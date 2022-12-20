<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\Processed_order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Symfony\Component\Console\Input\Input;

//use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    //
    public function getCheckoutForm(Request $request)
    {

        $cartid  = [...$request['cartid']];


        return view('checkout-form', [
            'biz_id'        => $request->biz_id,
            'cartItems'     => $cartid,

        ]);
    }


    public function getCheckoutStatus(Request $request)
    {
        $biz_id = $request['biz_id'];
        $checkout = [...$request['tracking_id']];
        $order =  Checkout::where('tracking_id', $checkout)->get();
        return view('checkout-status', [
            'biz_id'        => $biz_id,
            'checkout'      => $order,

        ]);
    }

    public  function getAllCheckouts(Request $request)
    {
        return response()->json(
            Checkout::select(
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
            )->get(),
            200
        );
    }

    public function getCheckoutByTrackingId(Request $request)
    {

        try {
            $prod =  Checkout::where('tracking_id', $request['tracking_id'])->first();
            return response()->json([
                'Prod' => $prod,
            ], 200);
        } catch (\Exception $e) {
            //Log::error($e->getMessage());
            return response()->json([
                'message' => 'Could not find Checkout with biz_id!!'
            ], 400);
        }
    }


    public function createCheckout(Request $request)
    {
        $cartid  = [...$request['cartid']];
        $biz_id  = $request['biz_id'];
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

        $action =  Checkout::where('tracking_id', $request['tracking_id'])->first();
        if ($action) {
            return response()->json([
                'msg' => 'Order Already Sent!!',

            ], 422);
        } else {
            $biz_id  = $request['biz_id'];

            // $checkout = Checkout::create([
            //     'fullname'           => $request->fullname,
            //     'phoneno'            => $request->phoneno,
            //     'email'              => $request->email,
            //     'address'            => $request->address,
            //     'tracking_id'        => $request->tracking_id,
            //     'product_id'         => $request->product_id,
            //     'product_name'       => $request->product_name,
            //     'price'              => $request->price,
            //     'image'              => $request->image,
            //     'category'           => $request->category,
            //     'quantity'           => $request->quantity,
            //     'total_price'        => $request->total_price,
            //     'total_qty'          => $request->total_qty,
            //     'description'        => $request->description,
            //     'biz_id'           => $request->biz_id,

            // ]);
            foreach ($cartid as $cart_id) {
                $cart =  Cart::where('cartid', $cart_id)->first();
                $product_id      =        $cart->productid;
                $product_name    =        $cart->product_name;
                $price           =        $cart->price;
                $image           =        $cart->image;
                $category        =        $cart->category;
                $quantity        =        $cart->quantity;
                $total_price     =        $cart->total_price;
                $total_qty       =        $cart->total_qty;
                $description     =        $cart->product_id;
                $biz_id          =        $cart->biz_id;

                $checkout = Checkout::create([
                    'fullname'           => $request->fullname,
                    'phoneno'            => $request->phoneno,
                    'email'              => $request->email,
                    'address'            => $request->address,
                    'tracking_id'        => $request->tracking_id,
                    'product_id'         => $product_id,
                    'product_name'       => $product_name,
                    'price'              => $price,
                    'image'              => $image,
                    'category'           => $category,
                    'quantity'           => $quantity,
                    'total_price'        => $total_price,
                    'total_qty'          => $total_qty,
                    'description'        => $description,
                    'biz_name'           => $biz_id,

                ]);


                if ($checkout) {
                    $seller =  User::where('biz_id', $request['biz_id'])->first();
                    //$seller =  User::where('biz_id', $request['biz_id'])->first();
                    if ($seller->balance == null) {
                        $oldbalance = 0;
                    } else {
                        $oldbalance = $seller->balance;
                    }
                    $newSellerBalance = $oldbalance + $total_price;
                    //$newSellerBalance = $oldbalance + $request->total_price;
                    $seller->update(['balance' => $newSellerBalance]);

                    // $order = Orders::create([
                    //     'fullname'           => $request->fullname,
                    //     'phoneno'            => $request->phoneno,
                    //     'email'              => $request->email,
                    //     'address'            => $request->address,
                    //     'tracking_id'        => $request->tracking_id,
                    //     'product_id'         => $request->product_id,
                    //     'product_name'       => $request->product_name,
                    //     'price'              => $request->price,
                    //     'image'              => $request->image,
                    //     'category'           => $request->category,
                    //     'quantity'           => $request->quantity,
                    //     'total_price'        => $request->total_price,
                    //     'total_qty'          => $request->total_qty,
                    //     'description'        => $request->description,
                    //     'biz_id'           => $request->biz_id,

                    // ]);

                    $order = Orders::create([
                        'fullname'           => $request->fullname,
                        'phoneno'            => $request->phoneno,
                        'email'              => $request->email,
                        'address'            => $request->address,
                        'tracking_id'        => $request->tracking_id,
                        'product_id'         => $product_id,
                        'product_name'       => $product_name,
                        'price'              => $price,
                        'image'              => $image,
                        'category'           => $category,
                        'quantity'           => $quantity,
                        'total_price'        => $total_price,
                        'total_qty'          => $total_qty,
                        'description'        => $description,
                        'biz_id'             => $biz_id,

                    ]);
                    $customer =  Customers::where('phoneno', $request['phoneno'])->first();

                    if (!$customer) {

                        // Customers::create([
                        //     'fullname'       => $request->fullname,
                        //     'email'          => $request->email,
                        //     'phoneno'        => $request->phoneno,
                        //     'city'           => $request->city,
                        //     'address'        => $request->address,
                        //     'tracking_id'    => $request->tracking_id,
                        //     'balance'        => $request->total_price,
                        // ]);

                        Customers::create([
                            'fullname'       => $request->fullname,
                            'email'          => $request->email,
                            'phoneno'        => $request->phoneno,
                            'city'           => $request->city,
                            'address'        => $request->address,
                            'tracking_id'    => $request->tracking_id,
                            'balance'        => $total_price,
                        ]);
                    } else {
                        // $newBalance = $customer->balance  + $request->total_price;
                        $newBalance = $customer->balance  + $total_price;
                        $customer->update([
                            'balance'         => $newBalance,
                            'tracking_id'     => $request->tracking_id,
                        ]);
                    }
                }
            }


            // return response()->json([
            //     'checkout' => $checkout,
            //     'order' => $order,

            // ], 200);

            return redirect()->action([CheckoutController::class, 'getCheckoutStatus'], [

                'biz_id'       => $request->biz_id,
                'tracking_id'  => array($request->tracking_id),

            ]);
        }
    }


    public function RemoveCheckout(Request $request)
    {

        try {

            $cancel = Checkout::where('tracking_id', $request['tracking_id'])->first();

            if ($cancel) {
                $orderCancel =  $cancel->delete();
                if ($orderCancel) {
                    $order = Orders::where('tracking_id', $request['tracking_id'])->first();
                    $order->delete();

                    $seller =  User::where('biz_name', $request['biz_name'])->first();
                    $newSellerBalance = $seller->balance - $request->total_price;
                    $seller->update(['balance' => $newSellerBalance]);
                }
            }


            return response()->json([
                'message' => 'Order Deleted Successfully!!'
            ], 200);
        } catch (\Exception $e) {
            //Log::error($e->getMessage());
            return response()->json([
                'msg' => 'Something went wrong while deleting Order!!'
            ], 400);
        }
    }
}
