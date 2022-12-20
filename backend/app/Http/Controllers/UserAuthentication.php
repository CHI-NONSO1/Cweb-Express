<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
//use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class UserAuthentication extends Controller
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


    public  function profile(Request $request)
    {
        return $request->user();
    }


    public  function getProfileByBizId(Request $request)
    {
        try {
            $user =  User::where('active_login', $request['access_token'])->first();
            $firstname = $user->firstname;
            $lastname = $user->lastname;
            $biz_id = $user->biz_id;
            $image = $user->image;
            // $pass = $user->password;
            // $password = decrypt($pass);
            $token = $user->active_login;
            if ($user) {
                // return response()->json([
                //     'user' =>  $user,
                // ], 200);
                return view('admin/dashboard', [
                    'accesstoken' => $token,
                    'token_type' => 'Bearer',
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'biz_id' => $biz_id,
                    'image' => $image,
                    // 'password' => $password,

                ]);
            } else {
                return response()->json([
                    'user' => 'You are not Allowed',
                ], 201);
            }
        } catch (\Exception $e) {
            //Log::error($e->getMessage());
            // return response()->json([
            //     'message' => 'Could not find User with Biz_id!!', $user
            // ], 400);

            return redirect()->action([UserAuthentication::class, 'loginForm'], ['error' => 'login']);
        }
    }

    public function registerForm()
    {
        //
        $message = 'ddd';

        return view('admin/register', ['message' => $message]);
    }
    //this method adds new users
    public function createAccount(Request $request)
    {
        $attr = Validator::make($request->all(), [
            'firstname'         => 'required|string|max:255',
            'lastname'          => 'required|string|max:255',
            'password'          => 'required|string|min:6|confirmed',
            'email'             => 'required|string|email|unique:users',
            'phoneno'           => 'required|string|max:14',
            'biz_name'          => 'required|string',
            'image'             => 'image',
            'dob'               => 'string',
            'city'              => 'string',
            'address'           => 'string',
            'duty'              => 'string',
            'country'           => 'string',
            'balance'           => 'integer',


        ]);
        if (!$attr) {
            return response()->json([
                'errors' => $attr->errors()
            ], 422);
        }

        $action =  User::where('email', $request['email'])->first();
        if ($action) {
            return response()->json([
                'msg' => 'A User with the Email Address Already Exist!!',

            ], 422);
        } else {
            if ($request->image != null) {
                $imageName = Str::random() . '.' . $request->image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('user/image', $request->image, $imageName);
            } else {
                $imageName = " ";
            }
            $user = User::create([
                'firstname'         => $request->firstname,
                'lastname'          => $request->lastname,
                'password'          => Hash::make($request->password),
                'email'             => $request->email,
                'phoneno'           => $request->phoneno,
                'biz_name'          => $request->biz_name,
                'image'             => $imageName,
                'dob'               => $request->dob,
                'city'              => $request->city,
                'address'           => $request->address,
                'duty'              => $request->duty,
                'country'           => $request->country,

            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            // return response()->json([
            //     'access_token' => $token,
            //     'token_type' => 'Bearer',
            //     'user' => $user,
            // ], 200);
            return view('admin/login', ['access_token' => $token, 'token_type' => 'Bearer', 'user' => $user]);
        }
    }

    public function loginForm()
    {
        //


        return view('admin/login');
    }
    //use this method to signin users
    public function UserLogin(Request $request)
    {
        $email =  $request['email'];
        $password =  $request['password'];

        $data = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($data->fails()) {
            // return response()->json([
            //     'errors' => $data->errors()
            // ], 422);
            $erro = $data->errors();
            return view('admin/login', [$erro]);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            // return response()->json([
            //     'message' => 'Invalid login details'
            // ], 401);

            return view('admin/login', ['error' => 'Invalid login details']);
        }

        $user = User::where('email', $email)->firstOrFail();


        $token = $user->createToken('auth_token')->plainTextToken;
        if ($user) {
            $access =  User::where('email', $request['email'])->update(['active_login' => $token]);
            if ($access) {
                return redirect()->action([UserAuthentication::class, 'getProfileByBizId'], ['access_token' => $token]);
            }
        }
        // return response()->json([
        //     'access_token' => $token,
        //     'token_type' => 'Bearer',
        // ], 200);

    }


    public function updateAcount(Request $request)
    {
        $data = Validator::make($request->all(), [
            'firstname'         => 'required|string|max:255',
            'lastname'          => 'required|string|max:255',
            'password'          => 'required|string|min:6|confirmed',
            'email'             => 'required|string|email|unique:users',
            'phoneno'           => 'required|string|max:14',
            'biz_name'          => 'required|string',
            'image'             => 'image',
            'dob'               => 'string',
            'city'              => 'string',
            'address'           => 'string',
            'duty'              => 'string',
            'country'           => 'string',

        ]);

        if ($data->fails()) {
            return response()->json([
                'errors' => $data->errors()
            ], 422);
        }
        $user = User::where('email', $request['email'])->first();
        if ($user->image != null) {
            $exists = Storage::disk('public')->exists("user/image/{$user->image}");
            if ($exists) {
                Storage::disk('public')->delete("user/image/{$user->image}");
            }
        }

        if ($request->image != null) {
            $imageName = Str::random() . '.' . $request->image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('user/image', $request->image, $imageName);
        } else {
            $imageName = " ";
        }
        try {
            User::where('email', $request['email'])->update([
                'firstname'         => $request->firstname,
                'lastname'          => $request->lastname,
                'password'          => Hash::make($request->password),
                'email'             => $request->email,
                'phoneno'           => $request->phoneno,
                'biz_name'          => $request->biz_name,
                'image'             => $imageName,
                'dob'               => $request->dob,
                'city'              => $request->city,
                'address'           => $request->address,
                'duty'              => $request->duty,
                'country'           => $request->country,

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
    public function userLogout(Request $request)
    {
        try {

            $user = User::where('active_login', $request['access_token'])->firstOrFail();
            $logout = $user->update(['active_login' => " "]);
            if ($logout) {
                return redirect()->action([UserAuthentication::class, 'loginForm'], ['login' => 'login']);
            }

            // if ($user) {
            //     User::where('email', $request['email'])->update(['active_login' => " "]);
            // }
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something went wrong!!'
            ], 400);
        }
    }

    public function destroyAcount(Request $request)
    {
        $action =  User::where('email', $request['email'])->first();


        try {

            if ($action->image != null) {
                $exists = Storage::disk('public')->exists("user/image/{$action->image}");
                if ($exists) {
                    Storage::disk('public')->delete("user/image/{$action->image}");
                }
            }

            $action->delete();

            return response()->json([
                'message' => 'Account Deleted Successfully!!'
            ], 200);
        } catch (\Exception $e) {
            //Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something went wrong while deleting Account!!'
            ], 400);
        }
    }
}
