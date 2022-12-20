<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Log;

class ProductsController extends Controller


{
    //

    public function addproductForm(Request $request)
    {
        $user =  User::where('active_login', $request['access_token'])->first();
        $firstname = $user->firstname;
        $lastname = $user->lastname;
        $biz_id = $user->biz_id;
        $image = $user->image;
        $token = $user->active_login;
        return view(
            'admin/add-product-form',
            [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'firstname' => $firstname,
                'lastname' => $lastname,
                'biz_id' => $biz_id,
                'image' => $image,


            ]
        );
    }
    public function index()
    {
        $product = Products::select(
            'productid',
            'product_name',
            'price',
            'category',
            'quantity',
            'description',
            'image',
            'user_id',
            'rating',
            'feature_image',
            'created_at',
            'updated_at',
        )->get();
        return view('index', ['products' => $product]);
    }

    public  function getAllProducts(Request $request)
    {
        return Products::select(
            'productid',
            'product_name',
            'price',
            'category',
            'quantity',
            'description',
            'image',
            'user_id',
            'rating',
            'feature_image',
            'created_at',
            'updated_at',
        )->get();
    }


    public function getProductByBizIdNewArrivals(Request $request)
    {


        try {

            $prod =  Products::where('user_id', $request['biz_id'])
                ->where('category',  "New Arrivals")
                ->get();
            return response()->json([
                'Prod' => $prod,
            ], 200);
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json([
                'message' => 'Could not find Products with biz_id!!'
            ], 400);
        }
    }

    public function getProductByBizIdTrending(Request $request)
    {


        try {

            $prod =  Products::where('user_id', $request['biz_id'])
                ->where('category',  "Trending Items")
                ->get();
            return response()->json([
                'Prod' => $prod,
            ], 200);
        } catch (\Exception $e) {
            //Log::error($e->getMessage());
            return response()->json([
                'message' => 'Could not find Products with biz_id!!'
            ], 400);
        }
    }


    public function getProductByProductId(Request $request)
    {
        $shopping_token = $request->shoppingtoken;
        $shopping_tag = $request->shopping_token;

        try {
            $cart =  Products::where('productid', $request['productid'])->first();
            $tag =  Cart::where('shopping_token', $request['shopping_token'])->first();

            if (!$tag) {
                $shoppingToken = $shopping_token;
                if ($cart) {
                    Cart::create([
                        'productid'     => $cart->productid,
                        'product_name'     => $cart->product_name,
                        'price'            => $cart->price,
                        'quantity'         => 1,
                        'user_id'          => $cart->user_id,
                        'image'            => $cart->image,
                        'description'      => $cart->description,
                        'category'         => $cart->category,
                        'shopping_token'   => $shoppingToken,
                        'total_qty'        => 1,
                        'total_price'      => $cart->price,

                    ]);

                    return redirect()->action([CartController::class, 'index'], [

                        'productid'        => $request->productid,
                        'biz_id'           => $cart->user_id,
                        'shopping_token'   => $shoppingToken,

                    ]);
                }
            } else {
                $shoppingToken = $shopping_tag;
                if ($cart) {
                    Cart::create([
                        'productid'     => $cart->productid,
                        'product_name'     => $cart->product_name,
                        'price'            => $cart->price,
                        'quantity'         => 1,
                        'user_id'          => $cart->user_id,
                        'image'            => $cart->image,
                        'description'      => $cart->description,
                        'category'         => $cart->category,
                        'shopping_token'   => $shoppingToken,
                        'total_qty'        => 1,
                        'total_price'      => $cart->price,

                    ]);

                    return redirect()->action([CartController::class, 'index'], [

                        'productid'        => $request->productid,
                        'biz_id'           => $cart->user_id,
                        'shopping_token'   => $shoppingToken,

                    ]);
                }
            }




            // ->where('category',  $request['category'])->get();
            // return response()->json([
            //     'pro' => $po,
            // ], 200);
            // return view('cart', [

            //     'carts' => $carts,

            // ]);
            // return redirect()->action([CartController::class, 'index'], [

            //     'carts' => $carts,

            // ]);
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json([
                'message' => 'Could not find Product with that Productid!!', $e,
                $shopping_token
            ], 400);
        }
    }

    public function getProductByCategory(Request $request)
    {

        $total_qty =  DB::table('cart')->sum('total_qty');
        $edit_token = $request['accesstoken'];
        if ($edit_token) {
            $user =  User::where('active_login', $request['accesstoken'])->first();
            $firstname = $user->firstname;
            $lastname = $user->lastname;
            $biz_id = $user->biz_id;
            $token = $user->active_login;

            $products =  Products::where('user_id', $request['biz_id'])
                // ->where('category',  $request['category'])
                ->get();

            // return response()->json([
            //     'Pro' => $prod,
            // ], 200);
            return view('express', [
                'products'          => $products,
                'token'             => $token,
                'token_type'        => 'Bearer',
                'firstname'         => $firstname,
                'lastname'          => $lastname,
                'biz_id'            => $biz_id,
                'total_qty'         => $total_qty,
                'shopping_token'    => $request->shopping_token,
            ]);
        } else {


            try {
                $products =  Products::where('user_id', $request['biz_id'])
                    // ->where('category',  $request['category'])
                    ->get();

                // return response()->json([
                //     'Pro' => $prod,
                // ], 200);
                return view('express', [
                    'products'           => $products,
                    'biz_id'             => $request->biz_id,
                    'total_qty'          => $total_qty,
                    'shopping_token'     => $request->shopping_token,

                ]);
            } catch (\Exception $e) {
                // Log::error($e->getMessage());
                return response()->json([
                    'message' => 'Could not find Product with that Category!!'
                ], 400);
            }
        }
    }

    public function getProductByPrice(Request $request)
    {


        try {
            //->whereBetween('price', [$minprice, $maxprice])
            //->where('price', 'like', '%' . $reqprice . '%')
            $prod =  Products::where('user_id', $request['biz_id'])
                ->where('price', '<', $request['price'])
                ->get();

            return response()->json([
                'Pro' => $prod,
            ], 200);
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json([

                'message' => 'Could not find Product with that Price!!'
            ], 400);
        }
    }

    public function getSearchProducts(Request $request)
    {
        $searchQuery = $request['searchQuery'];

        try {
            $prod =  Products::where('product_name', 'like', '%' . $searchQuery . '%')
                ->orwhere('category', 'like', '%' . $searchQuery . '%')
                ->where('user_id', $request['biz_id'])
                ->get();

            return response()->json([
                'Pro' => $prod,
            ], 200);
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json([

                'message' => 'Could not find Product with that Price!!'
            ], 400);
        }
    }


    public function createProduct(Request $request)
    {

        $user =  User::where('active_login', $request['accesstoken'])->first();
        $firstname = $user->firstname;
        $lastname = $user->lastname;
        $biz_id = $user->biz_id;
        $image = $user->image;
        $token = $user->active_login;

        $category_options = $request['select__category'];
        if ($category_options == 'New Arrivals') {
            $category = 'New Arrivals';
        } else if ($category_options == 'Trending Items') {
            $category = 'Trending Items';
        } else if ($category_options == 'Featured Items') {
            $category = 'Featured Items';
        } else if ($category_options == 'Top Deals') {
            $category = 'Top Deals';
        }
        $img = $request['file'];
        $valid = Validator::make($request->all(), [
            'product_name'       => 'required|string',
            'price'              => 'required|string',
            'image'              => 'required|string',
            'category'           => 'required|string',
            'quantity'           => 'required|string',
            'user_id'            => 'required|string',
            'description'        => 'string|max:1000',
            'rating'             => 'string',
            'feature_image'      => 'string',


        ]);
        if (!$valid) {
            return response()->json([
                'errors' => $valid->errors()
            ], 422);
        }

        $action =  Products::where('product_name', $request['product_name'])->first();
        if ($action) {
            // return response()->json([
            //     'msg' => 'Entry Already Exist!!',

            // ], 422);
            return view(
                'admin/add-product-form',
                [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'biz_id' => $biz_id,
                    'image' => $image,
                    'msg' => 'Entry Already Exist!!',

                ]
            );
        } else {
            if ($img != null) {
                $imageName = Str::random() . '.' . $img->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('product/image', $img, $imageName);
            } else {
                $imageName = " ";
            }
            if ($request->feature_image != null) {
                $featureImageName = Str::random() . '.' . $request->feature_image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('product/image', $request->feature_image, $featureImageName);
            } else {
                $featureImageName = " ";
            }

            $prod = Products::create([
                'product_name'     => $request->product_name,
                'price'            => $request->price,
                'quantity'         => $request->quantity,
                'user_id'          => $request->user_id,
                'image'            => $imageName,
                'feature_image'    => $featureImageName,
                'description'      => $request->description,
                'category'         => $category,
                'rating'           => $request->rating,
            ]);



            // return response()->json([
            //     'prod' => $prod,
            //     'msg' => "Product Addedd Successfully!",
            // ], 200);


            return view(
                'admin/add-product-status',
                [
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'biz_id' => $biz_id,
                    'image' => $image,
                    'msg' => "Product Addedd Successfully!",

                ]
            );
        }
    }
    public function updateProduct(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'product_name'       => 'required|string',
            'price'              => 'required|string',
            'image'              => 'required|string',
            'category'           => 'required|string',
            'quantity'           => 'required|string',
            'user_id'            => 'required|string',
            'description'        => 'string|max:1000',
            'rating'             => 'string',
            'feature_image'      => 'string',

        ]);
        if (!$valid) {
            return response()->json([
                'errors' => $valid->errors()
            ], 422);
        }

        $product = Products::where('productid', $request['productid'])->first();
        if ($product->image != null) {
            $exists = Storage::disk('public')->exists("product/image/{$product->image}");
            if ($exists) {
                Storage::disk('public')->delete("product/image/{$product->image}");
            }
        }

        if ($product->feature_image != " ") {
            $exists = Storage::disk('public')->exists("product/image/{$product->feature_image}");
            if ($exists) {
                Storage::disk('public')->delete("product/image/{$product->feature_image}");
            }
        }

        if ($request->image != 'undefined') {
            $imageName = Str::random() . '.' . $request->image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('product/image', $request->image, $imageName);
        } else {
            $imageName = " ";
        }
        if ($request->feature_image != null) {
            $featureImageName = Str::random() . '.' . $request->feature_image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('product/image', $request->feature_image, $featureImageName);
        } else {
            $featureImageName = " ";
        }

        try {
            Products::where('productid', $request['productid'])->update([
                'product_name'     => $request->product_name,
                'price'            => $request->price,
                'quantity'         => $request->quantity,
                'user_id'          => $request->user_id,
                'image'            => $imageName,
                'feature_image'    => $featureImageName,
                'description'      => $request->description,
                'category'         => $request->category,
                'rating'           => $request->rating,
            ]);

            return response()->json([
                'msg' => 'Product Updated Successfully'
            ], 200);
        } catch (\Exception $e) {
            //Log::error($e->getMessage());
            return response()->json([
                'message' => 'Something went wrong while Updating Product!!'
            ], 500);
        }
    }

    public function destroyProduct(Request $request)
    {

        try {

            $product = Products::where('productid', $request['productid'])->first();

            if ($product->image) {
                $exists = Storage::disk('public')->exists("product/image/{$product->image}");
                if ($exists) {
                    Storage::disk('public')->delete("product/image/{$product->image}");
                }
            }

            if ($product->feature_image) {
                $exists = Storage::disk('public')->exists("product/image/{$product->feature_image}");
                if ($exists) {
                    Storage::disk('public')->delete("product/image/{$product->feature_image}");
                }
            }

            if ($product) {
                $product->delete();
            }

            return response()->json([
                'msg' => 'Product Deleted Successfully!!'
            ], 200);
        } catch (\Exception $e) {
            // Log::error($e->getMessage());
            return response()->json([
                'msg' => 'Something went wrong while deleting Product!!'
            ], 400);
        }
    }
}
