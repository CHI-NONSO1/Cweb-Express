<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    //

    public  function profile(Request $request)
    {
        return $request->user();
    }
    public  function getProfileByPortfolioId(Request $request)
    {
        try {
            $user =  Customers::where('portfolioadminid', $request['portfolioadminid'])->first();
            if ($user) {
                return response()->json([
                    'user' =>  $user,
                ], 200);
            } else {
                return response()->json([
                    'user' => 'You are not Allowed',
                ], 201);
            }
        } catch (\Exception $e) {
            //Log::error($e->getMessage());
            return response()->json([
                'message' => 'Could not find Biodata with Portfolioid!!'
            ], 400);
        }
    }
    //this method adds new users
    public function createAccount(Request $request)
    {
        $attr = Validator::make($request->all(), [
            'fullname'          => 'required|string',
            'phoneno'           => 'required|string',
            'email'             => 'required|string',
            'address'           => 'required|string',
            'balance'           => 'required',
            'image'             => 'image',
            'city'              => 'city',
            'password'          =>  'password',

        ]);
        if (!$attr) {
            return response()->json([
                'errors' => $attr->errors()
            ], 422);
        }

        $action =  Customers::where('email', $request['email'])->first();
        if ($action) {
            return response()->json([
                'msg' => 'A Customers with the Email Address Already Exist!!',

            ], 422);
        } else {
            if ($request->image != null) {

                $imageName = Str::random() . '.' . $request->image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('product/image', $request->image, $imageName);
            } else {
                $imageName = " ";
            }
            $user = Customers::create([
                'firstname'  => $request->firstname,
                'lastname'   => $request->lastname,
                'email'      => $request->email,
                'image'      => $imageName,
                'password'   => Hash::make($request->password),
                'middlename' => $request->middlename,
                'phoneno'    => $request->phoneno,
                'city'       => $request->city,
                'address'    => $request->address,
                'position'   => $request->position,

            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 200);
        }
    }
    //use this method to signin users
    public function signin(Request $request)
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

        $user = Customers::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        if ($user) {
            Customers::where('email', $request['email'])->update(['login_token' => $token]);
        }
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 200);
    }


    public function update(Request $request)
    {
        $data = Validator::make($request->all(), [
            'fullname'          => 'required|string',
            'phoneno'           => 'required|string',
            'email'             => 'required|string',
            'address'           => 'required|string',
            'balance'           => 'required',
            'image'             => 'image',
            'city'              => 'city',
        ]);

        if ($data->fails()) {
            return response()->json([
                'errors' => $data->errors()
            ], 422);
        }
        // $user = Customers::where('email', $request['email'])->first();
        // if ($user->image) {
        //     $exists = Storage::disk('public')->exists("product/image/{$user->image}");
        //     if ($exists) {
        //         Storage::disk('public')->delete("product/image/{$user->image}");
        //     }
        // }

        // $imageName = Str::random() . '.' . $request->image->getClientOriginalExtension();
        // Storage::disk('public')->putFileAs('product/image', $request->image, $imageName);
        try {
            Customers::where('email', $request['email'])->update([
                // 'firstname'  => $request->firstname,
                // 'lastname'   => $request->lastname,
                // 'email'      => $request->email,
                // 'image'      => $imageName,
                // 'password'   => Hash::make($request->password),
                'middlename' => $request->middlename,
                'phoneno'    => $request->phoneno,
                'city'       => $request->city,
                'address'    => $request->address,
                'position'   => $request->position,

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
    public function signout(Request $request)
    {
        try {

            $user = Customers::where('email', $request['email'])->firstOrFail();

            if ($user) {
                Customers::where('email', $request['email'])->update(['login_token' => " "]);
            }
        } catch (\Exception $e) {
           // Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something went wrong!!'
            ], 400);
        }
    }

    public function destroy(Request $request)
    {
        $action =  Customers::where('email', $request['email'])->firstOrFail();


        try {

            if ($action->image) {
                $exists = Storage::disk('public')->exists("product/image/{$action->image}");
                if ($exists) {
                    Storage::disk('public')->delete("product/image/{$action->image}");
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
