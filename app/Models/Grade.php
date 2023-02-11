<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Grade extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "grades";

    public function getStudentGradeAttribute()
    {
        $id = session('user')->id; // User ID

        // Latest School Year
        $sy = SchoolYearTbl::latest('school_years')->where("is_active", '1')->first();

        $enrollment = EnrollmentTbl::whereRelation('student', 'user_id', $id)
            ->whereRelation('school_year', 'school_years', $sy->school_years)
            ->where('is_approved', 1)
            ->latest('date_submitted') // Latest Enrollment
            ->first(['id', 'student_id', 'school_year_id', 'student_department']);

        $passingGradeByDepartment = GradeSettings::where('status', 'Passed')
            ->where('level_department', $enrollment->student_department)->get();

        $failedGradeByDepartment = GradeSettings::where('status', 'Failed')
            ->where('level_department', $enrollment->student_department)->get();

        $grade = $this->grade;
        $isPassed = false;
        $pointEquivalent = 5.0;

        $text = 'Ongoing';

        if ($passingGradeByDepartment->count() != 0) {
            foreach ($passingGradeByDepartment as $i => $checkGrade) {
                $explode = explode('-', $checkGrade->grade_range);
                $min = (float)min($explode);
                $max = (float)max($explode);
                // If grade is greater than or equal to minimum passing grade
                if ($grade >= $min && $grade <= $max) {
                    $isPassed = true;
                    $text = 'Passed';
                }
                // $grade >= $min

                if ($grade >= $min && $grade <= $max) {
                    $pointEquivalent = $checkGrade->point_equivalent;
                }

            }
        }

        if ($failedGradeByDepartment->count() != 0) {
            foreach ($failedGradeByDepartment as $i => $checkGrade) {
                $explode = explode('-', $checkGrade->grade_range);
                $min = (float)min($explode);
                $max = (float)max($explode);
                if ($grade >= $min && $grade <= $max) {
                    $isPassed = false;
                    $text = 'Failed';
                }

                if ($grade >= $min && $grade <= $max) {
                    $pointEquivalent = $checkGrade->point_equivalent;
                }

            }
        }

        return [
            'point_equivalent' => $pointEquivalent,
            'is_passed' => $isPassed,
            'msg' => $text
        ];
    }

    public function students()
    {
        return $this->belongsTo(StudentsTbl::class, 'student_id');
    }

    public function enrollments()
    {
        return $this->belongsTo(EnrollmentTbl::class, 'enrollment_id');
    }

    public function subjects()
    {
        return $this->belongsTo(SubjectTbl::class, 'subject_id');
    }


}
