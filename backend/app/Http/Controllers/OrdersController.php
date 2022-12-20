<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
//use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    //
    public  function getAllOrders(Request $request)
    {
        return Orders::select(
            'checkoutid',
            'product_name',
            'fullname',
            'phoneno',
            'email',
            'address',
            'tracking_id',
            'product_id',
            'price',
            'category',
            'quantity',
            'description',
            'image',
            'total_price',
            'total_qty',
            'biz_name',
            'created_at',
        )->get();
    }

    public function getOrderByTrackingId(Request $request)
    {

        try {
            $prod =  Orders::where('tracking_id', $request['tracking_id'])->first();
            return response()->json([
                'order' => $prod,
            ], 200);
        } catch (\Exception $e) {
            //Log::error($e->getMessage());
            return response()->json([
                'message' => 'Could not find Orders with biz_id!!',
                $e
            ], 400);
        }
    }


    public function createOrder(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'fullname'           => 'required|string',
            'phoneno'            => 'required|string',
            'email'              => 'required|string',
            'address'            => 'required|string',
            'tracking_id'        => 'required|string',
            'product_id'         => 'required|string',
            'product_name'       => 'required|string',
            'price'              => 'required|string',
            'image'              => 'required|string',
            'category'           => 'required|string',
            'quantity'           => 'required|string',
            'total_price'        => 'required|string',
            'total_qty'          => 'required|string',
            'description'        => 'string|max:1000',
            'biz_name'           => 'required|string',



        ]);
        if (!$valid) {
            return response()->json([
                'errors' => $valid->errors()
            ], 422);
        }

        $action =  Orders::where('tracking_id', $request['tracking_id'])->first();
        if ($action) {
            return response()->json([
                'msg' => 'Order Already Sent!!',

            ], 422);
        } else {


            $prod = Orders::create([
                'fullname'           => $request->fullname,
                'phoneno'            => $request->phoneno,
                'email'              => $request->email,
                'address'            => $request->address,
                'tracking_id'        => $request->tracking_id,
                'product_id'         => $request->product_id,
                'product_name'       => $request->product_name,
                'price'              => $request->price,
                'image'              => $request->image,
                'category'           => $request->category,
                'quantity'           => $request->quantity,
                'total_price'        => $request->total_price,
                'total_qty'          => $request->total_qty,
                'description'        => $request->description,
                'biz_name'           => $request->biz_name,

            ]);



            return response()->json([
                'prod' => $prod,
            ], 200);
        }
    }

    public function getLocation(Request $request)
    {
        try {
            $queryString = http_build_query([
                'access_key' => '',
                'query' => $request->searchQ,
                'region' => 'Nigeria',
                'output' => 'json',
                'limit' => 1,
            ]);

            $ch = curl_init(sprintf('%s?%s', 'https://api.positionstack.com/v1/forword', $queryString));

            curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);

            $json = curl_exec($ch);

            $apiResult = json_decode($json, true);

            return response()->json([
                $apiResult
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'Something went wrong while deleting Order!!',
                $e
            ], 404);
        }
    }

    public function CancelOrder(Request $request)
    {

        try {

            $com = Orders::where('tracking_id', $request['tracking_id'])->first();

            if ($com) {
                $processed = Checkout::where('tracking_id', $request['tracking_id'])->first();

                $processed->delete();

                $seller =  User::where('biz_id', $request['biz_id'])->first();
                $newSellerBalance = $seller->balance - $com->total_price;
                $seller->update(['balance' => $newSellerBalance]);

                $customer =  Customers::where('phoneno', $request['phoneno'])->first();
                $customer->update(['tracking_id' => ' ']);
                $com->delete();
            }

            return response()->json([
                'message' => 'Order Deleted Successfully!!'
            ], 200);
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json([
                'msg' => 'Something went wrong while deleting Order!!',
                $e
            ], 400);
        }
    }
}
