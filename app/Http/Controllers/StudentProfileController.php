<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentProfile\AccountDetailsRequest;
use App\Http\Requests\StudentProfile\AddressDetailsRequest;
use App\Http\Requests\StudentProfile\BasicInfoRequest;
use App\Http\Requests\StudentProfile\GuardianDetailsRequest;
use App\Models\DocumentsTbl;
use App\Models\DocumentTypeTbl;
use App\Models\EnrollmentTbl;
use App\Models\StudentsTbl;
use App\Models\UsersTbl;
use App\Utilities\AccessRoute;
use App\Utilities\Filepond;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class StudentProfileController extends Controller
{
    public function index()
    {
        // Filter Enrollment Relationship By Latest Enrollment Submitted
        // Upcoming relationships of enrollment will be filtered also
//        $user = UsersTbl::with(['student.guardian',
//            'student.enrollments' => function ($query) {
//                $query->orderBy('date_submitted', 'desc'); // Get the latest submitted enrollment
//            },
//            'student.enrollments.section', // Get section of filtered 'student.enrollments' relationship
//            'student.enrollments.level',
//            'role'
//        ])->findOrFail(session('user')->id);

        $user = UsersTbl::with(['student.guardian',
            'student.latestEnrollment' => function ($query) {
                $query->where('is_approved', 1);
            },
            'student.latestEnrollment.section', // Get section of filtered 'student.latestEnrollment' relationship
            'student.latestEnrollment.level',
            'role'
        ])->findOrFail(session('user')->id);

        abort_if(!$user->student()->exists(), 404);

        // Permissions
        $permissions = AccessRoute::user_permissions(session('user')->id);
        $user_student = UsersTbl::findOrFail(session('user')->id);
        $has_documents = DocumentsTbl::where('student_id', $user_student->student->id)->count();
        $documents = '';
        
        if(!empty($user->student->oldestEnrollment->student_type) && $user->student->oldestEnrollment->student_type == "Old" && $has_documents == 0 ){
            $documents = DocumentTypeTbl::where([['student_type', '=', $user->student->oldestEnrollment->student_type],['student_dept', '=', $user->student->oldestEnrollment->student_department]])->get();
        }

        return view('dashboard.student_profile', compact('user', 'permissions','documents','has_documents'));
    }

    public function basicInfo(BasicInfoRequest $request)
    {
        $user = UsersTbl::findOrFail(session('user')->id);

        $user->student()->update($request->validated());

        return response()->json([
            'msg' => 'Basic Info has been updated'
        ]);

    }

    public function accountDetails(AccountDetailsRequest $request)
    {
        $user = UsersTbl::findOrFail(session('user')->id);

        $user->update($request->validated());

        return response()->json([
            'msg' => 'Account details has been updated'
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required'
        ]);

        $user = UsersTbl::findOrFail(session('user')->id);

        // Check if password is correct
        if (!password_verify(sha1($request->password, TRUE), $user->password)) {
            return response()->json([
                'status' => 400,
                'is_password_wrong' => true,
                'msg' => 'Wrong password'
            ]);
        }

        // Check if password is match
        if ($request->new_password !== $request->confirm_password) {
            return response()->json([
                'status' => 400,
                'is_password_wrong' => false,
                'msg' => 'New password does not match'
            ]);
        }

        // Hash the password before storing
        $characters = sha1(md5($user->full_name . "123456"));
        $characterLength = strlen($characters);
        $randomStr = '';
        for ($i = 0; $i < 12; $i++) {
            $randomStr = $characters[rand(0, $characterLength - 1)];
        }
        $salt = md5($randomStr);
        $password = sha1($request->new_password, TRUE);
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, [$salt]);

        // Store Hashed Password
        $user->update(['password' => $hashed_password, 'salt' => $salt]);

        return response()->json([
            'status' => 200,
            'msg' => 'Your password has been updated'
        ]);
    }

    public function addressDetails(AddressDetailsRequest $request)
    {
        $user = UsersTbl::findOrFail(session('user')->id);

        $user->student()->update($request->validated());

        return response()->json([
            'msg' => 'Address has been updated'
        ]);
    }

    public function guardianDetails(GuardianDetailsRequest $request)
    {
        $student = StudentsTbl::where('user_id', session('user')->id)->firstOrFail();

        $student->guardian()->update($request->validated());

        return response()->json([
            'msg' => 'Guardian details has been updated'
        ]);
    }

    public function changeAvatar(Request $request)
    {
        $request->validate([
            'image' => 'image'
        ]);

        $user = UsersTbl::with('student')->findOrFail(session('user')->id);

        $path = null;
        if ($request->has('image')) {

            // If file does exist, remove file
            Filepond::deleteFileWhenFound($user->student->image);

            $path = Filepond::saveFile($request, 'image', 'avatars_img');

        }

        $user->student()->update(['image' => $path]);

        // Change UI
        session('user')->avatar = '/storage' . $path;

        return response()->json(['msg' => 'Avatar has been updated.', 'image' => '/storage' . $path]);

    }

    public function document_details(Request $request)
    {
        $user = UsersTbl::findOrFail(session('user')->id);
        $student_id = $user->student->id;
        $has_documents = DocumentsTbl::where('student_id', $student_id)->count();

        $documents = DocumentTypeTbl::where(array('student_dept' => $user->student->oldestEnrollment->student_department, 'student_type' => $user->student->oldestEnrollment->student_type))->get();

        if($has_documents == 0){
           
                foreach($documents as $docs){
                

                    if ($request->hasFile('document_'.$docs->id)) { //check if it has file 
                        $stud_docs = new DocumentsTbl();
                        $stud_docs->student_id = $student_id;
                        $image = $request->file('document_'.$docs->id); //get file
                        $image_name = $user->student->oldestEnrollment->application_no.'_'.$docs->document_name.'.'.$image->getClientOriginalExtension(); //create a unique file name
                        $destinationPath = storage_path('app/public/student_docs'); //path to save image 'url/public/uploads/...'
                        $image->move($destinationPath, $image_name); //move and save file to folder
                        $stud_docs->document_type_id = $docs->id;
                        $stud_docs->document_file = $image_name; //declare to save in database
                        $stud_docs->save();
                    }else{
                        $stud_docs = new DocumentsTbl();
                        $stud_docs->student_id = $student_id;
                        $stud_docs->document_type_id = $docs->id;
                        $stud_docs->document_file = NULL;
                        $stud_docs->save();
                    }
                

                }
        }else{
            foreach($documents as $docs){
 
                if ($request->hasFile('document_'.$docs->id)) { //check if it has file 
                    $stud_docs = DocumentsTbl::where([['document_type_id','=',$docs->id],['student_id','=',$student_id]]);
                    $image = $request->file('document_'.$docs->id); //get file
                    $image_name = $user->student->oldestEnrollment->application_no.'_'.$docs->document_name.'.'.$image->getClientOriginalExtension(); //create a unique file name
                    $destinationPath = storage_path('app/public/student_docs'); //path to save image 'url/public/uploads/...'
                    $image->move($destinationPath, $image_name); //move and save file to folder
                    $data['document_file'] = $image_name; //declare to save in database
                    $stud_docs->update($data);
                }
            

            }
        }
    }
}
