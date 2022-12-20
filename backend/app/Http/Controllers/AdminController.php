<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class AdminController extends Controller
{
    //
    public function index()

    {
        $admin = User::select(
            'firstname',
            'biz_name',
            'active_login',
            'lastname',
            'email',
            'image',
            'biz_id',
            'password',
            'dob',
            'city',
            'phoneno',
            'duty',
            'address',
            'country',
            'balance'
        )->get();

        return view('admin/dashboard', ['admin' => $admin]);
        // $posts = Post::orderBy('id','desc')->paginate(10);
        // return view('posts.index')->with('posts',$posts)->withTitle('Blog');   

    }

    public  function getAllUsers(Request $request)
    {
        return User::select(
            'firstname',
            'biz_name',
            'active_login',
            'lastname',
            'email',
            'image',
            'biz_id',
            'password',
            'dob',
            'city',
            'phoneno',
            'duty',
            'address',
            'country',
            'balance'
        )->get();
    }
    public  function getProfileByAdminId(Request $request)
    {
        try {
            $admin =  Admin::where('admin_id', $request['admin_id'])->first();
            if ($admin) {
                return response()->json([
                    'admin' =>  $admin,
                ], 200);
            } else {
                return response()->json([
                    'admin' => 'You are not Allowed',
                ], 201);
            }
        } catch (\Exception $e) {
            //Log::error($e->getMessage());
            return response()->json([
                'msg' => 'Could not find Admin with admin_id!!'
            ], 400);
        }
    }

    public function registerForm()
    {
        //
        $message = 'ddd';

        return view('admin/register', ['message' => $message]);
    }
    //this method adds new users
    public function createAdminAccount(Request $request)
    {
        $attr = Validator::make($request->all(), [
            'firstname'         => 'required|string|max:255',
            'lastname'          => 'required|string|max:255',
            'password'          => 'required|string|min:6|confirmed',
            'email'             => 'required|string|email|unique:users',
            'image'             => 'image',
            'phoneno'           => 'string|max:14',
            'city'              => 'string',
            'address'           => 'string',
            'duty'              => 'string',
            'dob'               => 'string',
            'country'           => 'string',

        ]);
        if (!$attr) {
            return response()->json([
                'errors' => $attr->errors()
            ], 422);
        }

        $action =  Admin::where('email', $request['email'])->first();
        if ($action) {
            return response()->json([
                'msg' => 'A Admin with the Email Address Already Exist!!',

            ], 422);
        } else {
            if ($request->image != null) {
                $imageName = Str::random() . '.' . $request->image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('admin/image', $request->image, $imageName);
            } else {
                $imageName = " ";
            }
            $admin = Admin::create([

                'firstname'  => $request->firstname,
                'lastname'   => $request->lastname,
                'email'      => $request->email,
                'image'      => $imageName,
                'password'   => Hash::make($request->password),
                'middlename' => $request->middlename,
                'phoneno'    => $request->phoneno,
                'city'       => $request->city,
                'address'    => $request->address,
                'duty'       => $request->duty,
                'dob'        => $request->dob,
                'country'    => $request->country,

            ]);

            $token = $admin->createToken('auth_token')->plainTextToken;

            // return response()->json([
            //     'access_token' => $token,
            //     'token_type' => 'Bearer',
            //     'admin' => $admin,
            // ], 200);
            return view('admin/login', ['access_token' => $token, 'token_type' => 'Bearer', 'admin' => $admin]);
        }
    }



    public function loginForm()
    {
        //
        $message = 'ddd';

        return view('admin/login', ['message' => $message]);
    }
    //use this method to signin users
    public function adminLogin(Request $request)
    {
        $data = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($data->fails()) {
            return response()->json([
                'errors' => $data->errors()
            ], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $admin = Admin::where('email', $request['email'])->firstOrFail();
        $token = $admin->createToken('auth_token')->plainTextToken;
        if ($admin) {
            Admin::where('email', $request['email'])->update(['active_login' => $token]);
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);

        return view('admin/dashboard', ['access_token' => $token, 'token_type' => 'Bearer']);
    }


    public function updateAdmin(Request $request)
    {
        $data = Validator::make($request->all(), [
            'firstname'         => 'required|string|max:255',
            'lastname'          => 'required|string|max:255',
            'password'          => 'required|string|min:6|confirmed',
            'email'             => 'required|string|email|unique:users',
            'image'             => 'image',
            'phoneno'           => 'string|max:14',
            'city'              => 'string',
            'address'           => 'string',
            'duty'              => 'string',
            'dob'               => 'string',
            'country'           => 'string',
        ]);

        if ($data->fails()) {
            return response()->json([
                'errors' => $data->errors()
            ], 422);
        }
        $admin = Admin::where('email', $request['email'])->first();
        if ($admin->image != null) {
            $exists = Storage::disk('public')->exists("admin/image/{$admin->image}");
            if ($exists) {
                Storage::disk('public')->delete("admin/image/{$admin->image}");
            }
        }
        if ($request->image != null) {
            $imageName = Str::random() . '.' . $request->image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('admin/image', $request->image, $imageName);
        } else {
            $imageName = " ";
        }
        try {
            Admin::where('email', $request['email'])->update([
                'firstname'  => $request->firstname,
                'lastname'   => $request->lastname,
                'email'      => $request->email,
                'image'      => $imageName,
                'password'   => Hash::make($request->password),
                'middlename' => $request->middlename,
                'phoneno'    => $request->phoneno,
                'city'       => $request->city,
                'address'    => $request->address,
                'duty'       => $request->duty,
                'dob'        => $request->dob,
                'country'    => $request->country,

            ]);

            return response()->json([
                'message' => 'Account Updated Successfully'
            ], 200);
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something goes wrong while Updating Account!!'
            ], 500);
        }
    }

    // this method signs out users by removing tokens
    public function adminLogout(Request $request)
    {
        try {

            $admin = Admin::where('email', $request['email'])->firstOrFail();

            if ($admin) {
                Admin::where('email', $request['email'])->update(['active_login' => " "]);
            }
        } catch (\Exception $e) {
            //Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something went wrong!!'
            ], 400);
        }
    }

    public function destroy(Request $request)
    {
        $action =  Admin::where('email', $request['email'])->firstOrFail();


        try {

            if ($action->image != null) {
                $exists = Storage::disk('public')->exists("admin/image/{$action->image}");
                if ($exists) {
                    Storage::disk('public')->delete("admin/image/{$action->image}");
                }
            }

            $action->delete();

            return response()->json([
                'message' => 'Account Deleted Successfully!!'
            ], 200);
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something went wrong while deleting Account!!'
            ], 400);
        }
    }
}
