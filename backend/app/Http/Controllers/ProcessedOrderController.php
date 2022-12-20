<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\Processed_order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
//use Illuminate\Support\Facades\Log;

class ProcessedOrderController extends Controller
{
    //
    public  function getAllProcessedOrder(Request $request)
    {
        return Processed_order::select(
            'p_orderid',
            'product_name',
            'fullname',
            'phoneno',
            'email',
            'address',
            'tracking_id',
            'product_id',
            'price',
            'orderid',
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

    public function getProcessedOrderByTrackingId(Request $request)
    {

        try {
            $prod =  Processed_order::where('tracking_id', $request['tracking_id'])->first();
            return response()->json([
                'Prod' => $prod,
            ], 200);
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json([
                'message' => 'Could not find Processed_order with Tracking_id!!'
            ], 400);
        }
    }


    public function createProcessedOrder(Request $request)
    {
        try {
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
                'orderid'            => 'required',



            ]);
            if (!$valid) {
                return response()->json([
                    'errors' => $valid->errors()
                ], 422);
            }

            $action =  Processed_order::where('tracking_id', $request['tracking_id'])->first();
            if ($action) {
                return response()->json([
                    'msg' => 'Order Already Sent!!',

                ], 422);
            } else {


                $prod = Processed_order::create([
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
                    'orderid'            => $request->orderid,

                ]);
                if ($prod) {
                    $processed = Checkout::where('checkoutid', $request['checkoutid'])->first();

                    $processed->delete();


                    $order = Orders::where('tracking_id', $request['tracking_id'])->first();
                    $order->delete();
                    $customer =  Customers::where('phoneno', $request['phoneno'])->first();
                    $customer->update(['tracking_id' => ' ']);
                }
            }
            return response()->json([
                'Prod' => $prod,
            ], 200);
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something went wrong!!',
                $e
            ], 400);
        }
    }


    public function deleteProcessedOrder(Request $request)
    {

        try {

            $com = Processed_order::where('tracking_id', $request['tracking_id'])->first();

            if ($com) {
                $com->delete();
            }

            return response()->json([
                'message' => 'Processed Order Deleted Successfully!!'
            ], 200);
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json([
                'msg' => 'Something went wrong while deleting Processed Order!!'
            ], 400);
        }
    }
}
