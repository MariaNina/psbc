<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\BranchTbl;
use App\Models\EnrollmentTbl;
use App\Models\Event;
use App\Models\ProgramsTbl;
use App\Models\SchoolYearTbl;
use App\Models\StudentsTbl;
use App\Models\SubjectTbl;
use App\Models\TermsTbl;
use App\Models\UsersTbl;
use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    private $sy;
    private $term;

    public function __construct()
    {
        $this->sy = SchoolYearTbl::latest('school_years')->first();
        $this->term = TermsTbl::oldest('term_name')->first();
    }

    public function index(Request $request)
    {
        // Check if staff role
        $user = UsersTbl::with(['staff', 'role'])->findOrFail(session('user')->id);

        // Check if user has staff info or relationship existing
        if ($user->staff()->exists()) {

            // Check if staff has completed his profile or changed his password
            $defaultPassword = "PSBCNumber1";
            if (password_verify(sha1($defaultPassword, TRUE), $user->password)) {
                return redirect()->route('staff_profile')->with('warning', 'Please update your password or profile');
            }

        }

        if ($user->role->role_name == "Student") {
            return redirect('/profile');
        }

        $permissions = AccessRoute::user_permissions(session('user')->id);

        $sy = empty($_GET['school_year_select']) ? $this->sy->school_years : strip_tags($_GET['school_year_select']);
        $selectedTerm = empty($_GET['term_select']) ? $this->term->term_name : strip_tags($_GET['term_select']);

        $schoolYear = SchoolYearTbl::all();
        $terms = TermsTbl::where('term_name', '!=', 'N/A')->get();

        $validSy = false;
        $validTerm = false;

        // Check if school year on url exist
        foreach ($schoolYear as $year) {
            if ($year->school_years == $sy) {
                $validSy = true;
                break;
            }
        }

        // Check if term on url exist
        foreach ($terms as $term) {
            if ($term->term_name == $selectedTerm) {
                $validTerm = true;
                break;
            }
        }

        if (!$validSy || !$validTerm) {
            return redirect('/dashboard?school_year_select=' . $this->sy->school_years . '&term_select=' . $this->term->term_name);
        }

        // Get Students by school year, branch
        $users = UsersTbl::whereRelation('role', 'role_name', 'Student')
            ->whereRelation('student.enrollment.school_year', 'school_years', $sy)
            ->whereRelation('student.enrollment.branch', 'branch_id', session('user')->branch_id)
            ->has('student.enrollment')
            ->with('role', 'student.enrollment.program_majors')
            ->latest('joined_at')
            ->take(50)
            ->get()
            ->makeHidden(['branch_id', 'user_name', 'password', 'salt', 'email', 'full_name']);

        // count of active enrollees by branch, school year & term
        $countEnrolees = EnrollmentTbl::whereRelation('student.enrollment.school_year', 'school_years', $sy)
            ->whereRelation('student.enrollment.branch', 'id', session('user')->branch_id)
            ->whereRelation('term', 'term_name', $selectedTerm)
            ->where('is_approved', 1)
            ->count();

        // Get Year
        $onlyYear = explode('-', $sy);

        // Get Recent Employees, by branch, and school year
        $employees = UsersTbl::has('staff')->
        whereHas('role', function ($q) {
            $q->where('role_name', '!=', 'Student');
        })
            ->whereRelation('branch', 'id', session('user')->branch_id)
            ->where(function ($query) use ($onlyYear) {
                $query->whereYear('joined_at', $onlyYear[0])
                    ->orWhereYear('joined_at', $onlyYear[1]);
            })
            ->with('staff', 'role')
            ->limit(25)->latest('joined_at')->get();

        // Count of users account by branch and year
        $userCount = UsersTbl::whereRelation('branch', 'id', session('user')->branch_id)
            ->where('is_active', 1)
            ->whereYear('joined_at', $onlyYear[0])
            ->orWhereYear('joined_at', $onlyYear[1])
            ->count();

        // Subject Count
        $subjectCount = SubjectTbl::count();
        // Programs Count
        $programCount = ProgramsTbl::count();

        // Get Latest Announcement
        $announcement = Announcement::latest('created_at')->first();
        // Get latest events
        $events = Event::limit(2)->latest()->get();

        // For Pie Chart
        // Get new students
        $newStudentsCount = $this->newStudentsCount($sy, $selectedTerm);

        // Get old students
        $oldStudentsCount = $this->oldStudentsCount($sy, $selectedTerm);

        // Get transferee's students
        $transfereeStudentsCount = $this->transfereeStudentsCount($sy, $selectedTerm);

        // For Bar Chart
        // Get enrollees of every school year by department, by branch, and approved enrollees
        if ($selectedTerm == 'Summer') {
            $enrolleesPerDepartment = base64_encode($enrolleesPerDepartment = SchoolYearTbl::withCount([
                'enrollment as elementary_count' => function ($query) {
                    $query->where('student_department', 'Elementary')
                        ->where('branch_id', session('user')->branch_id)
                        ->whereHas('term', function ($query) {
                            $query->where('term_name', 'Summer');
                        })
                        ->where('is_approved', 1);
                },
                'enrollment as jhs_count' => function ($query) {
                    $query->where('student_department', 'JHS')
                        ->where('branch_id', session('user')->branch_id)
                        ->whereHas('term', function ($query) {
                            $query->where('term_name', 'Summer');
                        })
                        ->where('is_approved', 1);
                },
                'enrollment as shs_count' => function ($query) use ($selectedTerm) {
                    $query->where('student_department', 'SHS')
                        ->where('term_id', '=', function ($query) use ($selectedTerm) {
                            $query->selectRaw('id')->from('terms_tbls')
                                ->where('terms_tbls.term_name', $selectedTerm);
                        })
                        ->where('branch_id', session('user')->branch_id)
                        ->whereHas('term', function ($query) {
                            $query->where('term_name', 'Summer');
                        })
                        ->where('is_approved', 1);
                },
                'enrollment as college_count' => function ($query) use ($selectedTerm) {
                    $query->where('student_department', 'College')
                        // Sub query select/get id from terms_tbls where term name is 1st Sem/2nd
                        ->where('term_id', '=', function ($query) use ($selectedTerm) {
                            $query->selectRaw('id')->from('terms_tbls')
                                ->where('terms_tbls.term_name', $selectedTerm);
                        })
                        ->where('branch_id', session('user')->branch_id)
                        ->whereHas('term', function ($query) {
                            $query->where('term_name', 'Summer');
                        })
                        ->where('is_approved', 1);
                },
                'enrollment as graduate_studies_count' => function ($query) use ($selectedTerm) {
                    $query->where('student_department', 'Graduate Studies')
                        ->where('term_id', '=', function ($query) use ($selectedTerm) {
                            $query->selectRaw('id')->from('terms_tbls')
                                ->where('terms_tbls.term_name', $selectedTerm);
                        })
                        ->where('branch_id', session('user')->branch_id)
                        ->whereHas('term', function ($query) {
                            $query->where('term_name', 'Summer');
                        })
                        ->where('is_approved', 1);
                },
            ])->latest('school_years')->limit(5)->get()->toJson());
        } else {
            $enrolleesPerDepartment = base64_encode($enrolleesPerDepartment = SchoolYearTbl::withCount([
                'enrollment as elementary_count' => function ($query) {
                    $query->where('student_department', 'Elementary')
                        ->where('branch_id', session('user')->branch_id)
                        ->whereHas('term', function ($query) {
                            $query->where('term_name', '!=', 'Summer');
                        })
                        ->where('is_approved', 1);
                },
                'enrollment as jhs_count' => function ($query) {
                    $query->where('student_department', 'JHS')
                        ->where('branch_id', session('user')->branch_id)
                        ->whereHas('term', function ($query) {
                            $query->where('term_name', '!=', 'Summer');
                        })
                        ->where('is_approved', 1);
                },
                'enrollment as shs_count' => function ($query) use ($selectedTerm) {
                    $query->where('student_department', 'SHS')
                        ->where('term_id', '=', function ($query) use ($selectedTerm) {
                            $query->selectRaw('id')->from('terms_tbls')
                                ->where('terms_tbls.term_name', $selectedTerm);
                        })
                        ->where('branch_id', session('user')->branch_id)
                        ->whereHas('term', function ($query) use ($selectedTerm) {
                            $query->where('term_name', $selectedTerm);
                        })
                        ->where('is_approved', 1);
                },
                'enrollment as college_count' => function ($query) use ($selectedTerm) {
                    $query->where('student_department', 'College')
                        // Sub query select/get id from terms_tbls where term name is 1st Sem/2nd
                        ->where('term_id', '=', function ($query) use ($selectedTerm) {
                            $query->selectRaw('id')->from('terms_tbls')
                                ->where('terms_tbls.term_name', $selectedTerm);
                        })
                        ->where('branch_id', session('user')->branch_id)
                        ->whereHas('term', function ($query) use ($selectedTerm) {
                            $query->where('term_name', $selectedTerm);
                        })
                        ->where('is_approved', 1);
                },
                'enrollment as graduate_studies_count' => function ($query) use ($selectedTerm) {
                    $query->where('student_department', 'Graduate Studies')
                        ->where('term_id', '=', function ($query) use ($selectedTerm) {
                            $query->selectRaw('id')->from('terms_tbls')
                                ->where('terms_tbls.term_name', $selectedTerm);
                        })
                        ->where('branch_id', session('user')->branch_id)
                        ->whereHas('term', function ($query) use ($selectedTerm) {
                            $query->where('term_name', $selectedTerm);
                        })
                        ->where('is_approved', 1);
                },
            ])->latest('school_years')->limit(5)->get()->toJson());
        }


        return view('dashboard.dashboard', compact('permissions', 'users', 'employees', 'userCount', 'subjectCount', 'programCount', 'announcement', 'events', 'newStudentsCount', 'oldStudentsCount', 'transfereeStudentsCount', 'schoolYear', 'terms', 'countEnrolees', 'enrolleesPerDepartment'));
    }

    public function newStudentsCount($sy, $term)
    {
        if ($term == 'Summer') {
            $newKto10StudentsCount = EnrollmentTbl::whereRelation('school_year', 'school_years', $sy)
                ->whereHas('term', function ($query) {
                    $query->where('term_name', 'Summer');
                })
                ->where('branch_id', session('user')->branch_id)
                ->where(function ($query) {
                    $query->where('is_approved', 1)
                        ->where('student_type', 'New');
                })
                ->where(function ($query) {
                    $query->where('student_department', 'Elementary')
                        ->orWhere('student_department', 'JHS');
                })
                ->count();

            $newNOTKto10StudentsCount = EnrollmentTbl::whereRelation('school_year', 'school_years', $sy)
                ->whereHas('term', function ($query) {
                    $query->where('term_name', 'Summer');
                })
                ->where('branch_id', session('user')->branch_id)
                ->where(function ($query) {
                    $query->where('student_department', '!=', 'Elementary')
                        ->where('student_department', '!=', 'JHS');
                })
                ->where(function ($query) {
                    $query->where('is_approved', 1)
                        ->where('student_type', 'New');
                })
                ->count();
        } else {
            $newKto10StudentsCount = EnrollmentTbl::whereRelation('school_year', 'school_years', $sy)
                ->whereHas('term', function ($query) {
                    $query->where('term_name', '!=', 'Summer');
                })
                ->where('branch_id', session('user')->branch_id)
                ->where(function ($query) {
                    $query->where('is_approved', 1)
                        ->where('student_type', 'New');
                })
                ->where(function ($query) {
                    $query->where('student_department', 'Elementary')
                        ->orWhere('student_department', 'JHS');
                })
                ->count();

            $newNOTKto10StudentsCount = EnrollmentTbl::whereRelation('school_year', 'school_years', $sy)
                ->whereRelation('term', 'term_name', $term)
                ->where('branch_id', session('user')->branch_id)
                ->where(function ($query) {
                    $query->where('student_department', '!=', 'Elementary')
                        ->where('student_department', '!=', 'JHS');
                })
                ->where(function ($query) {
                    $query->where('is_approved', 1)
                        ->where('student_type', 'New');
                })
                ->count();
        }

        return ($newKto10StudentsCount + $newNOTKto10StudentsCount);
    }

    public function oldStudentsCount($sy, $term)
    {
        if ($term == 'Summer') {
            $oldKto10StudentsCount = EnrollmentTbl::whereRelation('school_year', 'school_years', $sy)
                ->where('branch_id', session('user')->branch_id)
                ->whereHas('term', function ($query) {
                    $query->where('term_name', 'Summer');
                })
                ->where(function ($query) {
                    $query->where('is_approved', 1)
                        ->where('student_type', 'Old');
                })
                ->where(function ($query) {
                    $query->where('student_department', 'Elementary')
                        ->orWhere('student_department', 'JHS');
                })
                ->count();

            $oldNOTKto10StudentsCount = EnrollmentTbl::whereRelation('school_year', 'school_years', $sy)
                ->whereHas('term', function ($query) {
                    $query->where('term_name', 'Summer');
                })
                ->where('branch_id', session('user')->branch_id)
                ->where(function ($query) {
                    $query->where('student_department', '!=', 'Elementary')
                        ->where('student_department', '!=', 'JHS');
                })
                ->where(function ($query) {
                    $query->where('is_approved', 1)
                        ->where('student_type', 'Old');
                })
                ->count();
        } else {
            $oldKto10StudentsCount = EnrollmentTbl::whereRelation('school_year', 'school_years', $sy)
                ->where('branch_id', session('user')->branch_id)
                ->whereHas('term', function ($query) {
                    $query->where('term_name', '!=', 'Summer');
                })
                ->where(function ($query) {
                    $query->where('is_approved', 1)
                        ->where('student_type', 'Old');
                })
                ->where(function ($query) {
                    $query->where('student_department', 'Elementary')
                        ->orWhere('student_department', 'JHS');
                })
                ->count();

            $oldNOTKto10StudentsCount = EnrollmentTbl::whereRelation('school_year', 'school_years', $sy)
                ->whereRelation('term', 'term_name', $term)
                ->where('branch_id', session('user')->branch_id)
                ->where(function ($query) {
                    $query->where('student_department', '!=', 'Elementary')
                        ->where('student_department', '!=', 'JHS');
                })
                ->where(function ($query) {
                    $query->where('is_approved', 1)
                        ->where('student_type', 'Old');
                })
                ->count();

        }

        $count = $oldKto10StudentsCount + $oldNOTKto10StudentsCount;

        return $count;
    }

    public function transfereeStudentsCount($sy, $term)
    {
        if ($term == 'Summer') {
            $transfereeKto10StudentsCount = EnrollmentTbl::whereRelation('school_year', 'school_years', $sy)
                ->where('branch_id', session('user')->branch_id)
                ->whereHas('term', function ($query) {
                    $query->where('term_name', 'Summer');
                })
                ->where(function ($query) {
                    $query->where('is_approved', 1)
                        ->where('student_type', 'Transferee');
                })
                ->where(function ($query) {
                    $query->where('student_department', 'Elementary')
                        ->orWhere('student_department', 'JHS');
                })
                ->count();

            $transfereeNOTKto10StudentsCount = EnrollmentTbl::whereRelation('school_year', 'school_years', $sy)
                ->whereHas('term', function ($query) {
                    $query->where('term_name', 'Summer');
                })
                ->where('branch_id', session('user')->branch_id)
                ->where(function ($query) {
                    $query->where('student_department', '!=', 'Elementary')
                        ->where('student_department', '!=', 'JHS');
                })
                ->where(function ($query) {
                    $query->where('is_approved', 1)
                        ->where('student_type', 'Transferee');
                })
                ->count();
        } else {
            $transfereeKto10StudentsCount = EnrollmentTbl::whereRelation('school_year', 'school_years', $sy)
                ->where('branch_id', session('user')->branch_id)
                ->whereHas('term', function ($query) {
                    $query->where('term_name', '!=', 'Summer');
                })
                ->where(function ($query) {
                    $query->where('is_approved', 1)
                        ->where('student_type', 'Transferee');
                })
                ->where(function ($query) {
                    $query->where('student_department', 'Elementary')
                        ->orWhere('student_department', 'JHS');
                })
                ->count();

            $transfereeNOTKto10StudentsCount = EnrollmentTbl::whereRelation('school_year', 'school_years', $sy)
                ->whereRelation('term', 'term_name', $term)
                ->where('branch_id', session('user')->branch_id)
                ->where(function ($query) {
                    $query->where('student_department', '!=', 'Elementary')
                        ->where('student_department', '!=', 'JHS');
                })
                ->where(function ($query) {
                    $query->where('is_approved', 1)
                        ->where('student_type', 'Transferee');
                })
                ->count();
        }

        $count = $transfereeKto10StudentsCount + $transfereeNOTKto10StudentsCount;

        return $count;
    }

    public function sections()
    {
        return view('dashboard.section');

    }

}
