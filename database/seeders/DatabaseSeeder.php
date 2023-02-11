<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\BranchCollegesProgramsMajorsTbl;
use App\Models\PageTbl;
use App\Models\RoleTbl;
use App\Models\TermsTbl;
use App\Models\UsersTbl;
use App\Models\BranchTbl;
use App\Models\LevelsTbl;
use App\Models\MajorsTbl;
use App\Models\ProgramsTbl;
use App\Models\CampusPhotos;
use App\Models\CollegesTbl;
use App\Models\CurriculumTbl;
use App\Models\DocumentTypeTbl;
use App\Models\FeesTbl;
use App\Models\ProgramPhotos;
use App\Models\SchoolYearTbl;
use DateTimeZone;
use Illuminate\Database\Seeder;
use App\Models\ProgramMajorsTbl;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\StaffsTbl;
use App\Models\SubjectTbl;
use App\Models\RoomTbl;
use App\Models\SectionsTbl;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Seed
        ProgramPhotos::create([
            'name' => 'College of Business Administration',
            'file' => '/programs_img/1634808469.png',
            'description' => 'No Description'
        ]);

        // 2. Seed
        ProgramPhotos::create([
            'name' => 'College of Education',
            'file' => '/programs_img/1634808617.png',
            'description' => 'No Description'
        ]);

        ProgramPhotos::create([
            'name' => 'College of Hospitality Management and Tourism',
            'file' => '/programs_img/1634808672.png',
            'description' => 'No Description'
        ]);

        ProgramPhotos::create([
            'name' => 'Senior High School',
            'file' => '/programs_img/1634808727.png',
            'description' => 'No Description'
        ]);

        ProgramPhotos::create([
            'name' => 'Pre-Elementary',
            'file' => '/programs_img/1634811514.png',
            'description' => 'No Description'
        ]);

        CampusPhotos::create([
            'file' => '/campus_img/image1_1634961170.jpg'
        ]);

        CampusPhotos::create([
            'file' => '/campus_img/image2_1634961217.jpg'
        ]);

        CampusPhotos::create([
            'file' => '/campus_img/pexels-max-fischer-5212345_1638012285.jpg'
        ]);

        BranchTbl::create([
            'branch_name' => 'Paete',
            'branch_address' => 'J.P. Rizal Street Paete Laguna',
            'description' => 'Main Branch',
            'email' => 'psbc.family.school@gmail.com',
            'telephone_no' => '111111111',
            'mobile_no' => '0999999999'
        ]);

        BranchTbl::create([
            'branch_name' => 'Pagsanjan',
            'branch_address' => 'Rizal Street, Pagsanjan, Laguna',
            'description' => 'Annex Branch',
            'email' => 'psbc.family02.school@gmail.com',
            'telephone_no' => '111111111',
            'mobile_no' => '0999999999'
        ]);

        //Room
        RoomTbl::create([
            "room_no" => 111,
            "room_description" => "Elementary Room",
            "branch_id" => 1,
            "is_active" => 1,
        ]);

        RoomTbl::create([
            "room_no" => 112,
            "room_description" => "Elementary Room",
            "branch_id" => 1,
            "is_active" => 1,
        ]);

        RoomTbl::create([
            "room_no" => 113,
            "room_description" => "Elementary Room",
            "branch_id" => 1,
            "is_active" => 1,
        ]);

        //1
        RoleTbl::create([
            'role_name' => 'Super Admin',
            'is_active' => 1
        ]);

        //2
        RoleTbl::create([
            'role_name' => 'Teacher',
            'is_active' => 1
        ]);

        //3
        RoleTbl::create([
            'role_name' => 'Student',
            'is_active' => 1
        ]);

        RoleTbl::create([
            'role_name' => 'Staff',
            'is_active' => 1
        ]);

        SchoolYearTbl::create([
            'school_years' => '2021-2022',
            'is_active' => 1
        ]);

        //level 1
        LevelsTbl::create([
            'level_code' => 'K',
            'level_name' => 'Kinder',
            'student_dept' => 'Elementary',
            'is_active' => 1
        ]);

        //level 2
        LevelsTbl::create([
            'level_code' => 'G1',
            'level_name' => 'Grade 1',
            'student_dept' => 'Elementary',
            'is_active' => 1
        ]);

        //level 3
        LevelsTbl::create([
            'level_code' => 'G2',
            'level_name' => 'Grade 2',
            'student_dept' => 'Elementary',
            'is_active' => 1
        ]);

        //level 4
        LevelsTbl::create([
            'level_code' => 'G3',
            'level_name' => 'Grade 3',
            'student_dept' => 'Elementary',
            'is_active' => 1
        ]);

        //level 5
        LevelsTbl::create([
            'level_code' => 'G4',
            'level_name' => 'Grade 4',
            'student_dept' => 'Elementary',
            'is_active' => 1
        ]);

        //level 6
        LevelsTbl::create([
            'level_code' => 'G5',
            'level_name' => 'Grade 5',
            'student_dept' => 'Elementary',
            'is_active' => 1
        ]);

        //level 7
        LevelsTbl::create([
            'level_code' => 'G6',
            'level_name' => 'Grade 6',
            'student_dept' => 'Elementary',
            'is_active' => 1
        ]);

        //level 8
        LevelsTbl::create([
            'level_code' => 'G7',
            'level_name' => 'Grade 7',
            'student_dept' => 'JHS',
            'is_active' => 1
        ]);

        //level 9
        LevelsTbl::create([
            'level_code' => 'G8',
            'level_name' => 'Grade 8',
            'student_dept' => 'JHS',
            'is_active' => 1
        ]);

        //level 10
        LevelsTbl::create([
            'level_code' => 'G9',
            'level_name' => 'Grade 9',
            'student_dept' => 'JHS',
            'is_active' => 1
        ]);

        //level 11
        LevelsTbl::create([
            'level_code' => 'G10',
            'level_name' => 'Grade 10',
            'student_dept' => 'JHS',
            'is_active' => 1
        ]);

        //level 12
        LevelsTbl::create([
            'level_code' => 'G11',
            'level_name' => 'Grade 11',
            'student_dept' => 'SHS',
            'is_active' => 1
        ]);

        //level 13
        LevelsTbl::create([
            'level_code' => 'G12',
            'level_name' => 'Grade 12',
            'student_dept' => 'SHS',
            'is_active' => 1
        ]);


        //level 14
        LevelsTbl::create([
            'level_code' => 'C1',
            'level_name' => '1st Year College',
            'student_dept' => 'College',
            'is_active' => 1
        ]);
        //level 15
        LevelsTbl::create([
            'level_code' => 'C2',
            'level_name' => '2nd Year College',
            'student_dept' => 'College',
            'is_active' => 1
        ]);

        //level 16
        LevelsTbl::create([
            'level_code' => 'C3',
            'level_name' => '3rd Year College',
            'student_dept' => 'College',
            'is_active' => 1
        ]);

        //level 17
        LevelsTbl::create([
            'level_code' => 'C4',
            'level_name' => '4th Year College',
            'student_dept' => 'College',
            'is_active' => 1
        ]);

        //level 18
        LevelsTbl::create([
            'level_code' => 'Masters',
            'level_name' => 'Masteral',
            'student_dept' => 'Graduate Studies',
            'is_active' => 1
        ]);

        // Default Admin Acccount
        UsersTbl::create([
            'branch_id' => 1,
            'full_name' => 'Super Admin',
            'user_name' => 'superAdmin',
            'password' => '$2y$10$l0EnMsrceoaV4rTL/lFEBeOnctegpmffIcepjraKg/LIcppGR/Ht.',
            'salt' => 'cfcd208495d565ef66e7dff9f98764da',
            'email' => 'psbc.family.school@gmail.com',
            'role_id' => 1,
            'is_active' => 1
        ]);

        //Staff
        StaffsTbl::create([
            "user_id" => 1,
            "csc_id" => null,
            "first_name" => "Joze",
            "middle_name" => "Protacio",
            "last_name" => "Rizal",
            "extension_name" => "",
            "staff_type" => "Academic",
            "position" => "Teacher",
            "Department" => "JHS",
        ]);

        //Subjects
        SubjectTbl::create([
            "subject_name" => "English 1",
            "subject_code" => "Eng1",
            "lab_unit" => 1,
            "subject_description" => "English 1",
            "subject_type" => "Acad",
            "subject_image" => null,
            "is_offered" => 1,
            "is_for_college" => 0,
            "lect_unit" => 1,
        ]);
        SubjectTbl::create([
            "subject_name" => "Mathematics 1",
            "subject_code" => "Math1",
            "lab_unit" => 1,
            "subject_description" => "Mathematics 1",
            "subject_type" => "Acad",
            "subject_image" => null,
            "is_offered" => 1,
            "is_for_college" => 0,
            "lect_unit" => 1,
        ]);
        SubjectTbl::create([
            "subject_name" => "Science 1",
            "subject_code" => "Scie1",
            "lab_unit" => 1,
            "subject_description" => "Science 1",
            "subject_type" => "Acad",
            "subject_image" => null,
            "is_offered" => 1,
            "is_for_college" => 0,
            "lect_unit" => 1,
        ]);

        SubjectTbl::create([
            "subject_name" => "Filipino 1",
            "subject_code" => "Fili1",
            "lab_unit" => 1,
            "subject_description" => "Filipino 1",
            "subject_type" => "Acad",
            "subject_image" => null,
            "is_offered" => 1,
            "is_for_college" => 0,
            "lect_unit" => 1,
        ]);

        SubjectTbl::create([
            "subject_name" => "Music,Art, P.E., Health 1",
            "subject_code" => "MAPEH1",
            "lab_unit" => 1,
            "subject_description" => "Music,Art, P.E., Health 1",
            "subject_type" => "Acad",
            "subject_image" => null,
            "is_offered" => 1,
            "is_for_college" => 0,
            "lect_unit" => 1,
        ]);
        // 1
        ProgramsTbl::create([
            'program_code' => 'BSBA',
            'program_name' => 'BS in Business Administration',
            'program_description' => 'BS in Business Administration',
            'is_active' => 1
        ]);
        //2
        ProgramsTbl::create([
            'program_code' => 'BEE',
            'program_name' => 'Bachelor in Elementary Education',
            'program_description' => 'Bachelor in Elementary Education',
            'is_active' => 1
        ]);
        //3
        ProgramsTbl::create([
            'program_code' => 'BSE',
            'program_name' => 'Bachelor in Secondary Education',
            'program_description' => 'Bachelor in Secondary Education',
            'is_active' => 1
        ]);
        //4
        ProgramsTbl::create([
            'program_code' => 'BSHM',
            'program_name' => 'BS in Hospitality Management',
            'program_description' => 'BS in Hospitality Management',
            'is_active' => 1
        ]);
        //5
        ProgramsTbl::create([
            'program_code' => 'PTC',
            'program_name' => 'Professional Teaching Certification',
            'program_description' => 'Professional Teaching Certification',
            'is_active' => 1
        ]);
        //6
        ProgramsTbl::create([
            'program_code' => 'MAED',
            'program_name' => 'Master of Arts in Education',
            'program_description' => 'Master of Arts in Education',
            'is_active' => 1
        ]);

        //7
        ProgramsTbl::create([
            'program_code' => 'ABM',
            'program_name' => 'Accountancy, Business, and Management',
            'program_description' => 'Accountancy, Business, and Management',
            'is_active' => 1
        ]);

        //8
        ProgramsTbl::create([
            'program_code' => 'HUMSS',
            'program_name' => 'Humanities and Social Sciences',
            'program_description' => 'Humanities and Social Sciences',
            'is_active' => 1
        ]);

        //9
        ProgramsTbl::create([
            'program_code' => 'STEM',
            'program_name' => 'Science, Technology, Engineering, and Mathematics',
            'program_description' => 'Science, Technology, Engineering, and Mathematics',
            'is_active' => 1
        ]);

        //10
        ProgramsTbl::create([
            'program_code' => 'TVL',
            'program_name' => 'Technical Vocational Livelihood Track (Home Economics)',
            'program_description' => 'Technical Vocational Livelihood Track (Home Economics)',
            'is_active' => 1
        ]);

        //11
        ProgramsTbl::create([
            'program_code' => 'ELEM',
            'program_name' => 'Elementary',
            'program_description' => 'Elementary',
            'is_active' => 1
        ]);

        //12
        ProgramsTbl::create([
            'program_code' => 'JHS',
            'program_name' => 'Junior High School',
            'program_description' => 'Junior High School',
            'is_active' => 1
        ]);

        //1
        MajorsTbl::create([
            'major_code' => 'N/A',
            'major_name' => 'N/A',
            'major_description' => 'For No Majors',
            'is_active' => '1'
        ]);
        //2
        MajorsTbl::create([
            'major_code' => 'FM',
            'major_name' => 'Financial Management',
            'major_description' => 'Financial Management',
            'is_active' => '1'
        ]);
        //3
        MajorsTbl::create([
            'major_code' => 'MM',
            'major_name' => 'Marketing Management',
            'major_description' => 'Marketing Management',
            'is_active' => '1'
        ]);
        //4
        MajorsTbl::create([
            'major_code' => 'CC',
            'major_name' => 'Course Content',
            'major_description' => 'Course Content',
            'is_active' => '1'
        ]);
        //5
        MajorsTbl::create([
            'major_code' => 'ENG',
            'major_name' => 'English',
            'major_description' => 'English',
            'is_active' => '1'
        ]);
        //6
        MajorsTbl::create([
            'major_code' => 'FIL',
            'major_name' => 'Filipino',
            'major_description' => 'Filipino',
            'is_active' => '1'
        ]);
        //7
        MajorsTbl::create([
            'major_code' => 'MATH',
            'major_name' => 'Mathematics',
            'major_description' => 'Mathematics',
            'is_active' => '1'
        ]);
        //8
        MajorsTbl::create([
            'major_code' => 'EM',
            'major_name' => 'Educational Management',
            'major_description' => 'Educational Management',
            'is_active' => '1'
        ]);

        //9
        MajorsTbl::create([
            'major_code' => 'FBS',
            'major_name' => 'Food And Beverage Services',
            'major_description' => 'Food And Beverage Services',
            'is_active' => '1'
        ]);

        //10
        MajorsTbl::create([
            'major_code' => 'BAPP',
            'major_name' => 'Bread And Pastry Production',
            'major_description' => 'Bread And Pastry Production',
            'is_active' => '1'
        ]);

        //11
        MajorsTbl::create([
            'major_code' => 'HKS',
            'major_name' => 'House Keeping Services',
            'major_description' => 'House Keeping Services',
            'is_active' => '1'
        ]);

        //12
        MajorsTbl::create([
            'major_code' => 'LGS',
            'major_name' => 'Local Guiding Services',
            'major_description' => 'Local Guiding Services',
            'is_active' => '1'
        ]);

        //program major 1
        ProgramMajorsTbl::create([
            'program_id' => '1',
            'major_id' => '2',
            'description' => 'BS in Business Administration - Financial Management',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        //program major 2
        ProgramMajorsTbl::create([
            'program_id' => '1',
            'major_id' => '3',
            'description' => 'BS in Business Administration - Marketing Management',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        //program major 3
        ProgramMajorsTbl::create([
            'program_id' => '2',
            'major_id' => '4',
            'description' => 'Bachelor in Elementary Education - Course Content',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        //program major 4
        ProgramMajorsTbl::create([
            'program_id' => '3',
            'major_id' => '5',
            'description' => 'Bachelor in Secondary Education - English',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        //program major 5
        ProgramMajorsTbl::create([
            'program_id' => '3',
            'major_id' => '6',
            'description' => 'Bachelor in Secondary Education - Filipino',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        //program major 6
        ProgramMajorsTbl::create([
            'program_id' => '3',
            'major_id' => '7',
            'description' => 'Bachelor in Secondary Education - Math',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        //program major 7
        ProgramMajorsTbl::create([
            'program_id' => '4',
            'major_id' => '1',
            'description' => 'BS in Hospitality Management',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        //program major 8
        ProgramMajorsTbl::create([
            'program_id' => '5',
            'major_id' => '1',
            'description' => 'Professional Teaching Certification - 18 units',
            'student_department' => 'Graduate Studies',
            'is_active' => 1
        ]);

        //program major 9
        ProgramMajorsTbl::create([
            'program_id' => '6',
            'major_id' => '8',
            'description' => 'Master of Arts in Education - Educational Management',
            'student_department' => 'Graduate Studies',
            'is_active' => 1
        ]);

        //program major 10
        ProgramMajorsTbl::create([
            'program_id' => '7',
            'major_id' => '1',
            'description' => 'ABM',
            'student_department' => 'SHS',
            'is_active' => 1
        ]);

        //program major 11
        ProgramMajorsTbl::create([
            'program_id' => '8',
            'major_id' => '1',
            'description' => 'HUMSS',
            'student_department' => 'SHS',
            'is_active' => 1
        ]);

        //program major 12
        ProgramMajorsTbl::create([
            'program_id' => '9',
            'major_id' => '1',
            'description' => 'STEM',
            'student_department' => 'SHS',
            'is_active' => 1
        ]);

        //program major 13
        ProgramMajorsTbl::create([
            'program_id' => '10',
            'major_id' => '9',
            'description' => 'TVL - FBS',
            'student_department' => 'SHS',
            'is_active' => 1
        ]);

        //program major 14
        ProgramMajorsTbl::create([
            'program_id' => '10',
            'major_id' => '10',
            'description' => 'TVL - BAPP',
            'student_department' => 'SHS',
            'is_active' => 1
        ]);

        //program major 15
        ProgramMajorsTbl::create([
            'program_id' => '10',
            'major_id' => '11',
            'description' => 'TVL - HKS',
            'student_department' => 'SHS',
            'is_active' => 1
        ]);

        //program major 16
        ProgramMajorsTbl::create([
            'program_id' => '10',
            'major_id' => '12',
            'description' => 'TVL - LGS',
            'student_department' => 'SHS',
            'is_active' => 1
        ]);

        //program major 17
        ProgramMajorsTbl::create([
            'program_id' => '11',
            'major_id' => '1',
            'description' => 'Elementary',
            'student_department' => 'Elementary',
            'is_active' => 1
        ]);

        //program major 18
        ProgramMajorsTbl::create([
            'program_id' => '12',
            'major_id' => '1',
            'description' => 'JHS',
            'student_department' => 'JHS',
            'is_active' => 1
        ]);

        //College Curriculum in BS in Business Administration Major in Financial Management
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in BS in Business Administration Major in Financial Management',
            'level_id' => 14,
            'program_major_id' => 1,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in BS in Business Administration Major in Financial Management',
            'level_id' => 15,
            'program_major_id' => 1,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in BS in Business Administration Major in Financial Management',
            'level_id' => 16,
            'program_major_id' => 1,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in BS in Business Administration Major in Financial Management',
            'level_id' => 17,
            'program_major_id' => 1,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        //College Curriculum in BS in Business Administration - Marketing Management
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in BS in Business Administration - Marketing Management',
            'level_id' => 14,
            'program_major_id' => 2,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in BS in Business Administration - Marketing Management',
            'level_id' => 15,
            'program_major_id' => 2,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in BS in Business Administration - Marketing Management',
            'level_id' => 16,
            'program_major_id' => 2,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in BS in Business Administration - Marketing Management',
            'level_id' => 17,
            'program_major_id' => 2,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        //College Curriculum in Bachelor in Elementary Education - Course Content
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Elementary Education - Course Content',
            'level_id' => 14,
            'program_major_id' => 3,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Elementary Education - Course Content',
            'level_id' => 15,
            'program_major_id' => 3,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Elementary Education - Course Content',
            'level_id' => 16,
            'program_major_id' => 3,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Elementary Education - Course Content',
            'level_id' => 17,
            'program_major_id' => 3,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        //College Curriculum in Bachelor in Secondary Education - English
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Secondary Education - English',
            'level_id' => 14,
            'program_major_id' => 4,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Secondary Education - English',
            'level_id' => 15,
            'program_major_id' => 4,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Secondary Education - English',
            'level_id' => 16,
            'program_major_id' => 4,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Secondary Education - English',
            'level_id' => 17,
            'program_major_id' => 4,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        //College Curriculum in Bachelor in Secondary Education - Filipino
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Secondary Education - Filipino',
            'level_id' => 14,
            'program_major_id' => 5,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Secondary Education - Filipino',
            'level_id' => 15,
            'program_major_id' => 5,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Secondary Education - Filipino',
            'level_id' => 16,
            'program_major_id' => 5,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Secondary Education - Filipino',
            'level_id' => 17,
            'program_major_id' => 5,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        //College Curriculum in Bachelor in Secondary Education - Math
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Secondary Education - Math',
            'level_id' => 14,
            'program_major_id' => 6,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Secondary Education - Math',
            'level_id' => 15,
            'program_major_id' => 6,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Secondary Education - Math',
            'level_id' => 16,
            'program_major_id' => 6,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in Bachelor in Secondary Education - Math',
            'level_id' => 17,
            'program_major_id' => 6,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        //College Curriculum in BS in Hospitality Management
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in BS in Hospitality Management',
            'level_id' => 14,
            'program_major_id' => 7,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in BS in Hospitality Management',
            'level_id' => 15,
            'program_major_id' => 7,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in BS in Hospitality Management',
            'level_id' => 16,
            'program_major_id' => 7,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in BS in Hospitality Management',
            'level_id' => 17,
            'program_major_id' => 7,
            'student_department' => 'College',
            'school_year_id' => 1,
            'is_active' => 1
        ]);


        //SHS Curriculum in ABM
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in ABM',
            'level_id' => 12,
            'program_major_id' => 10,
            'student_department' => 'SHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in ABM',
            'level_id' => 13,
            'program_major_id' => 10,
            'student_department' => 'SHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        //SHS Curriculum in HUMSS
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in HUMSS',
            'level_id' => 12,
            'program_major_id' => 11,
            'student_department' => 'SHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in HUMSS',
            'level_id' => 13,
            'program_major_id' => 11,
            'student_department' => 'SHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        //SHS Curriculum in STEM
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in STEM',
            'level_id' => 12,
            'program_major_id' => 12,
            'student_department' => 'SHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in STEM',
            'level_id' => 13,
            'program_major_id' => 12,
            'student_department' => 'SHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        //SHS Curriculum in TVL - FBS
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in TVL - FBS',
            'level_id' => 12,
            'program_major_id' => 13,
            'student_department' => 'SHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in TVL - FBS',
            'level_id' => 13,
            'program_major_id' => 13,
            'student_department' => 'SHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        //SHS Curriculum in TVL - BAPP
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in TVL - BAPP',
            'level_id' => 12,
            'program_major_id' => 14,
            'student_department' => 'SHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in TVL - BAPP',
            'level_id' => 13,
            'program_major_id' => 14,
            'student_department' => 'SHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        //SHS Curriculum in TVL - HKS
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in TVL - HKS',
            'level_id' => 12,
            'program_major_id' => 15,
            'student_department' => 'SHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in TVL - HKS',
            'level_id' => 13,
            'program_major_id' => 15,
            'student_department' => 'SHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        //SHS Curriculum in TVL - LGS
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in TVL - LGS',
            'level_id' => 12,
            'program_major_id' => 16,
            'student_department' => 'SHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum in TVL - LGS',
            'level_id' => 13,
            'program_major_id' => 16,
            'student_department' => 'SHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        //ELementary Curriculum
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum for Kinder',
            'level_id' => 1,
            'program_major_id' => 17,
            'student_department' => 'Elementary',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum for Grade 1',
            'level_id' => 2,
            'program_major_id' => 17,
            'student_department' => 'Elementary',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum for Grade 2',
            'level_id' => 3,
            'program_major_id' => 17,
            'student_department' => 'Elementary',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum for Grade 3',
            'level_id' => 4,
            'program_major_id' => 17,
            'student_department' => 'Elementary',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum for Grade 4',
            'level_id' => 5,
            'program_major_id' => 17,
            'student_department' => 'Elementary',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum for Grade 5',
            'level_id' => 6,
            'program_major_id' => 17,
            'student_department' => 'Elementary',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum for Grade 6',
            'level_id' => 7,
            'program_major_id' => 17,
            'student_department' => 'Elementary',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        //JHS Curriculum
        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum for Grade 7',
            'level_id' => 8,
            'program_major_id' => 18,
            'student_department' => 'JHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum for Grade 8',
            'level_id' => 9,
            'program_major_id' => 18,
            'student_department' => 'JHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum for Grade 9',
            'level_id' => 10,
            'program_major_id' => 18,
            'student_department' => 'JHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);

        CurriculumTbl::create([
            'curriculum_year' => '2021-2023',
            'curriculum_description' => 'Curriculum for Grade 10',
            'level_id' => 11,
            'program_major_id' => 18,
            'student_department' => 'JHS',
            'school_year_id' => 1,
            'is_active' => 1
        ]);


        //1
        CollegesTbl::create([
            'college_code' => 'NA',
            'college_name' => 'Not Applicable',
            'college_description' => 'Not Applicable',
            'is_active' => 1
        ]);

        //2
        CollegesTbl::create([
            'college_code' => 'ELEM',
            'college_name' => 'Elementary',
            'college_description' => 'Elementary',
            'is_active' => 1
        ]);

        //3
        CollegesTbl::create([
            'college_code' => 'JHS',
            'college_name' => 'Junior High School',
            'college_description' => 'Junior High School',
            'is_active' => 1
        ]);

        //4
        CollegesTbl::create([
            'college_code' => 'SHS',
            'college_name' => 'Senior High School',
            'college_description' => 'Senior High School',
            'is_active' => 1
        ]);

        //5
        CollegesTbl::create([
            'college_code' => 'CBA',
            'college_name' => 'College of Business Administration',
            'college_description' => 'College of Business Administration',
            'is_active' => 1
        ]);

        //6
        CollegesTbl::create([
            'college_code' => 'CTE',
            'college_name' => 'College of Teachers Education',
            'college_description' => 'College of Teachers Education',
            'is_active' => 1
        ]);

        //7
        CollegesTbl::create([
            'college_code' => 'CHRM',
            'college_name' => 'College of Hotel Restaurant Management',
            'college_description' => 'College of Hotel Restaurant Management',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '3',
            'program_major_id' => '18',
            'student_department' => 'JHS',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '2',
            'college_id' => '3',
            'program_major_id' => '18',
            'student_department' => 'JHS',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '4',
            'program_major_id' => '10',
            'student_department' => 'SHS',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '4',
            'program_major_id' => '11',
            'student_department' => 'SHS',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '4',
            'program_major_id' => '12',
            'student_department' => 'SHS',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '4',
            'program_major_id' => '13',
            'student_department' => 'SHS',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '4',
            'program_major_id' => '14',
            'student_department' => 'SHS',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '4',
            'program_major_id' => '15',
            'student_department' => 'SHS',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '4',
            'program_major_id' => '16',
            'student_department' => 'SHS',
            'is_active' => 1
        ]);
        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '2',
            'program_major_id' => '17',
            'student_department' => 'Elementary',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '2',
            'college_id' => '2',
            'program_major_id' => '17',
            'student_department' => 'Elementary',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '5',
            'program_major_id' => '1',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '5',
            'program_major_id' => '2',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '6',
            'program_major_id' => '3',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '6',
            'program_major_id' => '4',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '6',
            'program_major_id' => '5',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '6',
            'program_major_id' => '6',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        BranchCollegesProgramsMajorsTbl::create([
            'branch_id' => '1',
            'college_id' => '6',
            'program_major_id' => '8',
            'student_department' => 'Graduate Studies',
            'is_active' => 1
        ]);

        DocumentTypeTbl::create([
            'document_name' => 'PSA',
            'is_required' => '1',
            'student_type' => 'New',
            'student_dept' => 'Elementary'
        ]);

        DocumentTypeTbl::create([
            'document_name' => 'Elementary Diploma',
            'is_required' => '1',
            'student_type' => 'New',
            'student_dept' => 'JHS'
        ]);
        DocumentTypeTbl::create([
            'document_name' => 'Form 138 / Card',
            'is_required' => '1',
            'student_type' => 'New',
            'student_dept' => 'JHS'
        ]);
        DocumentTypeTbl::create([
            'document_name' => 'Certificate of Good Moral Character',
            'is_required' => '1',
            'student_type' => 'New',
            'student_dept' => 'JHS'
        ]);
        DocumentTypeTbl::create([
            'document_name' => 'PSA',
            'is_required' => '1',
            'student_type' => 'New',
            'student_dept' => 'JHS'
        ]);

        DocumentTypeTbl::create([
            'document_name' => 'PSA',
            'is_required' => '1',
            'student_type' => 'New',
            'student_dept' => 'SHS'
        ]);

        DocumentTypeTbl::create([
            'document_name' => 'PSA',
            'is_required' => '1',
            'student_type' => 'New',
            'student_dept' => 'College'
        ]);

        DocumentTypeTbl::create([
            'document_name' => 'Certificate of Good Moral Character',
            'is_required' => '1',
            'student_type' => 'New',
            'student_dept' => 'JHS'
        ]);

        DocumentTypeTbl::create([
            'document_name' => 'High School Diploma',
            'is_required' => '1',
            'student_type' => 'New',
            'student_dept' => 'College'
        ]);
        DocumentTypeTbl::create([
            'document_name' => 'PSA',
            'is_required' => '1',
            'student_type' => 'New',
            'student_dept' => 'Graduate Studies'
        ]);

        SectionsTbl::create([
            'section_label' => 'Galatians',
            'hasSchedule' => 0,
            'adviser_id' => 1,
            'school_year_id' => 1,
            'level_id' => 1,
            'branch_id' => 1,
            'is_active' => 1
        ]);

        SectionsTbl::create([
            'section_label' => 'Colossians',
            'hasSchedule' => 0,
            'adviser_id' => 1,
            'school_year_id' => 1,
            'level_id' => 1,
            'branch_id' => 1,
            'is_active' => 1
        ]);

        SectionsTbl::create([
            'section_label' => 'Hebrews',
            'hasSchedule' => 0,
            'adviser_id' => 1,
            'school_year_id' => 1,
            'level_id' => 1,
            'branch_id' => 1,
            'is_active' => 1
        ]);

        SectionsTbl::create([
            'section_label' => 'Romans',
            'hasSchedule' => 0,
            'adviser_id' => 1,
            'school_year_id' => 1,
            'level_id' => 1,
            'branch_id' => 1,
            'is_active' => 1
        ]);

        SectionsTbl::create([
            'section_label' => 'Chronicles',
            'hasSchedule' => 0,
            'adviser_id' => 1,
            'school_year_id' => 1,
            'level_id' => 1,
            'branch_id' => 1,
            'is_active' => 1
        ]);

        SectionsTbl::create([
            'section_label' => 'Malachi',
            'hasSchedule' => 0,
            'adviser_id' => 1,
            'school_year_id' => 1,
            'level_id' => 1,
            'branch_id' => 1,
            'is_active' => 1
        ]);


        $pages = [
            'settings',
            'branches',
            'school_years',
            'curriculums',
            'colleges',
            'subjects',
            'programs',
            'majors',
            'levels',
            'programmajors',
            'terms',
            'rooms',
            'branch_college_program_majors',
            'sections',
            'employees',
            'users',
            'roles',
            'pages',
            'schedule',
            'document_settings',
            'students',
            'curriculum_subjects',
            'fees',
            'grade_settings',
            'college_grade',
            'deped_grade',
            'discounts',
            'employees',
            'assessments',
        ];

        foreach ($pages as $key => $page) {
            PageTbl::create([
                'page_name' => $page,
                'is_active' => 1
            ]);
        }

        $nowInManila = Carbon::now(new DateTimeZone('Asia/Manila'));

        foreach ($pages as $key => $page) {

            DB::table('permissions')->insert([
                'user_id' => 1,
                'page_id' => ($key + 1),
                'created_at' => $nowInManila,
                'updated_at' => $nowInManila
            ]);
        }

        // Add test user

        UsersTbl::create([
            'branch_id' => 1,
            'full_name' => 'Jose Rizal',
            'user_name' => 'joserizal',
            'password' => '$2y$10$l0EnMsrceoaV4rTL/lFEBeOnctegpmffIcepjraKg/LIcppGR/Ht.',
            'salt' => 'cfcd208495d565ef66e7dff9f98764da',
            'email' => 'joserizal@gmail.com',
            'role_id' => 2,
            'is_active' => 1
        ]);

        TermsTbl::create([
            'term_name' => '1st',
            'is_active' => 1
        ]);

        TermsTbl::create([
            'term_name' => '2nd',
            'is_active' => 0
        ]);

        TermsTbl::create([
            'term_name' => 'N/A',
            'is_active' => 1
        ]);

        FeesTbl::create([
            'fee_name' => 'College Lec Unit',
            'fee_description' => 1,
            'fee_amount' => 300,
            'fee_type' => 'Lec Unit',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        FeesTbl::create([
            'fee_name' => 'College Lab Unit',
            'fee_description' => 1,
            'fee_amount' => 300,
            'fee_type' => 'Lab Unit',
            'student_department' => 'College',
            'is_active' => 1
        ]);

        FeesTbl::create([
            'fee_name' => 'Grad Stud Lec Unit',
            'fee_description' => 1,
            'fee_amount' => 300,
            'fee_type' => 'Lec Unit',
            'student_department' => 'Graduate Studies',
            'is_active' => 1
        ]);

        FeesTbl::create([
            'fee_name' => 'Grad Stud Lab Unit',
            'fee_description' => 1,
            'fee_amount' => 300,
            'fee_type' => 'Lab Unit',
            'student_department' => 'Graduate Studies',
            'is_active' => 1
        ]);

        $this->call([
            HomeSettingsSeeder::class,
            AboutSettingsSeeder::class,
            EventSeeder::class,
            AnnouncementSeeder::class,
            ShowGradesSeeder::class
        ]);
    }
}
