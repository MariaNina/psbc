<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsersTbl;
use App\Utilities\AuditTrail;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(['is_guest'])->except('logout');
    }

    public function index()
    {
        return view('authentication.login');
    }

    //
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = UsersTbl::select("*")
            ->where('email', $request->email)
            ->where('is_active', 1)
            ->with(['staff', 'student','branch'])
            ->first();

        // Invalid Email
        if (!$user) {
            return response()->json([
                'status' => 401
            ]);
        }

        // Invalid Password
        if (!password_verify(sha1($request->password, TRUE), $user->password)) {
            return response()->json([
                'status' => 401
            ]);
        }

        $avatar = null;

        // Check if student
        if ($user->student()->exists() && $user->role->role_name == "Student" && !is_null($user->student->image)) {
            $avatar = '/storage'.$user->student->image;
        } elseif ($user->staff()->exists() && $user->role->role_name != "Student" && !is_null($user->staff->image)) {
            $avatar = '/storage'.$user->staff->image;
        } else {
            $avatar = 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';
        }

        // Correct Email & Password
        if($user->student()->exists() && $user->role->role_name == "Student"){
            $userInfo = (object)[
                'id' => $user->id,
                'branch' => $user->branch->branch_name,
                'branch_id' => $user->branch->id,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'salt' => $user->salt,
                'student_id' =>$user->student->id,
                'user_name' => $user->user_name,
                'role' => $user->role->role_name,
                'avatar' => $avatar,
        ];  
        }else{
            $userInfo = (object)[
                'id' => $user->id,
                'branch' => $user->branch->branch_name,
                'branch_id' => $user->branch->id,
                'full_name' => $user->full_name,
                'email' => $user->email,
                'salt' => $user->salt,
                'staff_id' =>$user->staff->id,
                'user_name' => $user->user_name,
                'role' => $user->role->role_name,
                'avatar' => $avatar,
            ];
        }

        // Assign a session
        $request->session()->put('user', $userInfo);

        //log login to audit trail
        $action_taken = 'Logged In';
        $description = 'Logged In to PSBC with authentication';
        AuditTrail::logAuditTrail( $action_taken , $description );
        //end log

        return response()->json([
            'status' => 200,
            'role' => $user->role->role_name,
            'has_staff' => $user->staff()->exists()
        ]);

        /* Example: How to get user data */
        // session('user')->email
        // session('user')->full_name

    }

    public function logout(Request $request)
    {
         //log login to audit trail
         $action_taken = 'Logged Out';
         $description = 'Logged Out to PSBC';
         AuditTrail::logAuditTrail( $action_taken , $description );
         //end log

        session()->forget('user'); // Remove the session

        return redirect()->route('login');
    }
}
