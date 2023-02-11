<?php

namespace App\Http\Controllers;

use App\Models\AssessmentsTbl;
use App\Models\Grade;
use App\Models\PaymentHistoryTbl;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    //
    public function printAssessmentForm(Request $request)
    {
        if(isset($_GET['i'])){

            $view_page = '';
            $assessment_id = base64_decode($_GET['i']);
            # code...
            $assessment = AssessmentsTbl::find($assessment_id);
            $enrollment_id = $assessment->enrollment_id;
            $student_department = $assessment->student_department;
            $section_id = $assessment->enrollment->section_id;
            // SELECT b.subject_name, b.lect_unit, b.lab_unit, d.days, d.start_time, d.end_time, e.first_name, e.last_name FROM grades a LEFT JOIN subject_tbls b ON (a.subject_id = b.id) LEFT JOIN enrollment_tbls c ON (a.enrollment_id = c.id) LEFT JOIN schedules_tbls d ON (b.id = d.subject_id) LEFT JOIN staffs_tbls e ON (d.staff_id = e.id);
            $subjects_with_schedule = Grade::select("subject_tbls.subject_name","subject_tbls.subject_code",
            "subject_tbls.lect_unit",
            "subject_tbls.lab_unit",
            "schedules_tbls.days",
            "schedules_tbls.start_time",
            "schedules_tbls.end_time",
            "staffs_tbls.first_name",
            "staffs_tbls.last_name",
            )
            ->leftJoin('subject_tbls', 'grades.subject_id', '=', 'subject_tbls.id')
            ->leftJoin('enrollment_tbls', 'grades.enrollment_id', '=', 'enrollment_tbls.id')
            ->leftJoin('schedules_tbls', function ($join) {
                    $join->on('subject_tbls.id', '=', 'schedules_tbls.subject_id')
                         ->on('enrollment_tbls.section_id', '=', 'schedules_tbls.section_id');
                })
            ->leftJoin('staffs_tbls', 'schedules_tbls.staff_id', '=', 'staffs_tbls.id')
            ->where('grades.enrollment_id',$enrollment_id)
            ->get();


            if($student_department == 'Elementary' || $student_department == 'JHS'){
                $view_page = 'print.elem_jhs.elemreg';
            }
            if($student_department == 'SHS'){
                $view_page = 'print.shs.shsreg';
            }
            if($student_department == 'College' || $student_department == 'Graduate Studies'){
                $view_page = 'print.college.collegereg';
            }
            $form_type_array = array('STUDENT\'S COPY','TREASURER\'S COPY','RECORD\'S COPY');

            $payments = PaymentHistoryTbl::where([['assessments_id',$assessment_id],['is_approved',1]])->get();
            return view($view_page, compact('assessment','subjects_with_schedule','form_type_array','payments'));
        }
    }
}
