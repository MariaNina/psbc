<?php

namespace App\Traits;

use App\Models\CurriculumTbl;
use App\Models\LevelsTbl;
use Illuminate\Http\Request;

trait checker {
    public function getLevelsByStudDept(Request $request)
    {
        $stud_dept = $request->stud_dept;
        $data['levels'] = LevelsTbl::where(array('student_dept' => $stud_dept, 'is_active' => 1))->get();
        return $data;
    }

    public function getCurriculumByStudDeptAndLevel(Request $request)
    {
        $stud_dept = $request->stud_dept;
        $stud_level = $request->stud_level;
        $school_year = 1;//place here selected school year
        $data['levels'] = LevelsTbl::where(array('student_dept' => $stud_dept, 'is_active' => 1))->get();
        $data['curriculums'] = CurriculumTbl::select(
            "curriculum_tbls.id as id",
            "programs_tbls.program_name as pname",
            "majors_tbls.major_name as mname")
            ->leftJoin('program_majors_tbls', 'curriculum_tbls.program_major_id', '=', 'program_majors_tbls.id')
            ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
            ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
            ->where('curriculum_tbls.school_year_id',$school_year)
            ->where('curriculum_tbls.level_id',$stud_level)
            ->where('curriculum_tbls.student_department', $stud_dept)
            ->where('curriculum_tbls.is_active',1)->get();
        return $data;
    }
}