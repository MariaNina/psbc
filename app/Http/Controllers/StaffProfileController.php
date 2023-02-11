<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffProfile\AccountDetailsRequest;
use App\Http\Requests\StaffProfile\AddressDetailsRequest;
use App\Http\Requests\StaffProfile\BasicInfoRequest;
use App\Http\Requests\StaffProfile\OtherCardRequest;
use App\Models\UsersTbl;
use App\Utilities\AccessRoute;
use App\Utilities\Filepond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StaffProfileController extends Controller
{

    public function index()
    {
        $user = UsersTbl::with(['staff', 'role'])->findOrFail(session('user')->id);

        abort_if(!$user->staff()->exists(), 404);

        if (!$user->staff) {
            return redirect()->route('dashboard.index');
        }

        $permissions = AccessRoute::user_permissions(session('user')->id);

        return view('dashboard.staff_profile', compact('user', 'permissions'));
    }

    public function basicInfo(BasicInfoRequest $request)
    {
        $user = UsersTbl::findOrFail(session('user')->id);

        $user->staff()->update($request->validated());

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

    public function addressDetails(AddressDetailsRequest $request)
    {
        $user = UsersTbl::findOrFail(session('user')->id);

        $user->staff()->update($request->validated());

        return response()->json([
            'msg' => 'Address has been updated'
        ]);
    }

    public function otherCardDetails(OtherCardRequest $request)
    {
        $data = $request->is_masteral == "on" ? array_merge($request->validated(), ['is_masteral' => 1]) : array_merge($request->validated(), ['is_masteral' => 0]);

        $user = UsersTbl::findOrFail(session('user')->id);

        $user->staff()->update($data);

        return response()->json([
            'msg' => 'Address has been updated',
            'data' => $data
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

    public function changeAvatar(Request $request)
    {
        $request->validate([
            'image' => 'image'
        ]);

        $user = UsersTbl::with('staff')->findOrFail(session('user')->id);

        $path = null;
        if ($request->has('image')) {

            // If file does exist, remove file
            Filepond::deleteFileWhenFound($user->staff->image);

            $path = Filepond::saveFile($request, 'image', 'avatars_img');

        }

        $user->staff()->update(['image' => $path]);

        // Change UI
        session('user')->avatar = '/storage' . $path;

        return response()->json(['msg' => 'Avatar has been updated.', 'image' => '/storage' . $path]);

    }
}
