<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shopping_token = $request['shopping_token'];
        $biz_id = $request['biz_id'];
        // $total_price =  DB::table('cart', $shopping_token)->sum('total_price');
        // $total_qty =  DB::table('cart', $shopping_token)->sum('total_qty');

        $carts =  Cart::where('shopping_token', $request['shopping_token'])->get();
        $total_price =  $carts->sum('total_price');
        $total_qty =  $carts->sum('total_qty');
        try {

            $carts =  Cart::where('shopping_token', $request['shopping_token'])->get();

            return view('cart', [
                'carts'            => $carts,
                'biz_id'           => $biz_id,
                'total_price'      => $total_price,
                'total_qty'        => $total_qty,
                'shopping_token'   => $shopping_token,
            ]);
        } catch (Exception $e) {
            //throw $th;
            $e;
        }
        //

    }
    //php artisan make:migration add_shopping_token_to_cart --table="cart"
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function increaseCart(Request $request, $id)
    {
        //
        $qty = $request['cartqty'];
        $cart_qty = $qty + 1;
        $cart = Cart::where('cartid', $request['cartid'])->first();
        $cart_total_price = $cart->price * $cart_qty;
        $cart_total_qty = $cart->quantity + 1;
        $cart->update([
            'quantity'         =>  $cart_qty,
            'total_price'      =>  $cart_total_price,
            'total_qty'        =>  $cart_total_qty,

        ]);

        return redirect()->action([CartController::class, 'index'], [

            'biz_id'           => $cart->user_id,
            'shopping_token'   => $cart->shopping_token,


        ]);
    }

    public function decreaseCart(Request $request, $id)
    {
        //
        $cart = Cart::where('cartid', $request['cartid'])->first();
        $qty = $request['cartqty'];
        if ($qty == 1) {
            return redirect()->action([CartController::class, 'index'], [

                'biz_id'           => $cart->user_id,
                'shopping_token'   => $cart->shopping_token,


            ]);
        } else {
            $cart_qty = $qty - 1;

            $cart_total_price = $cart->price * $cart_qty;
            $cart_total_qty = $cart->quantity - 1;
            $cart->update([
                'quantity'         =>  $cart_qty,
                'total_price'      =>  $cart_total_price,
                'total_qty'        =>  $cart_total_qty,

            ]);

            return redirect()->action([CartController::class, 'index'], [

                'biz_id'           => $cart->user_id,
                'shopping_token'   => $cart->shopping_token,


            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        try {
            $cart = Cart::where('cartid', $request['cartid'])->first();
            if ($cart) {
                $cart->delete();
                return redirect()->action([CartController::class, 'index'], [

                    'biz_id'           => $cart->user_id,
                    'shopping_token'   => $cart->shopping_token,


                ]);
            }
        } catch (\Exception $e) {
            //throw $th;
            $e;
        }
    }
}
