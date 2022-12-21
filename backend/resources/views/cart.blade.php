@extends('layout.header.master')

@section('content')

@include('layout.nav.navbar')


<div class='container'>


  <div class="ShowCart">

    <div class="items-box">
      <form method="GET" action="/express/{{$biz_id}}" enctype="multipart/form-data">
        @csrf
        <input type="text" class="shoppingTag" name="shopping_token" value='{{$shopping_token}}' />
        <button class="return-to-shop">
          Return To Shop

        </button>
      </form>
    </div>

    @foreach($carts as $cart)
    <div class="cart__flex">

      <div class="cart__img--wrap">
        <img class="cart__item--img" src="http://localhost:8000/storage/product/image/{{$cart->image}}" />
      </div>
      <div class="increase-decrease">
        <div class="incre">
          <form method="POST" action='/increase-cart/.$cart->user_id' enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="cartid" value='{{$cart->cartid}}' />
            <input type="hidden" name="biz_id" value='{{$cart->user_id}}' />
            <input type="hidden" name="cartqty" value='{{$cart->quantity}}' />
            <button class="btn-increase" id="{{$cart->cartid}}">
              +
            </button>
          </form>
        </div>
        <div>{{$cart->quantity}}</div>
        <div class="decre">
          <form method="POST" action='/decrease-cart/.$cart->user_id' enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="cartid" value='{{$cart->cartid}}' />
            <input type="hidden" name="cartqty" value='{{$cart->quantity}}' />
            <input type="hidden" name="biz_id" value='{{$cart->user_id}}' />
            <button class="btn-decrease" id="{{$cart->cartid}}">
              -
            </button>
          </form>
        </div>
      </div>

      <div class="cart__title">{{$cart->product_name}}</div>

      <div class="cart__price">
        <span class="naira">N</span>
        {{$cart->price}}
      </div>

      <div class="cart__category">{{$cart->category}}</div>

      <div class="cartbtn--wrap">
        <form method="POST" action='/delete-cart/.$cart->user_id' enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="cartid" value='{{$cart->cartid}}' />
          <input type="hidden" name="biz_id" value='{{$cart->user_id}}' />
          <button class="remove_item" id="{{$cart->cartid}}">
            Remove
          </button>
        </form>
      </div>


    </div>

    @endforeach
    <div class="total-price-qty">

      <div class="total-qty">
        {{$total_qty}}

      </div>
      <div class="total-price">
        <span class="naira">N</span>
        {{$total_price}}
      </div>

    </div>
    <div class="checkout">
      <form method="POST" action='/checkout-form' enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="biz_id" value='{{$biz_id}}' />
        @foreach($carts as $cart)
        <input type="hidden" name="cartid[]" value='{{$cart->cartid}}' />
        @endforeach
        <button class="check-out-btn">
          Checkout
        </button>
      </form>

    </div>
  </div>

  <div class="FooterMain">
    <div class="Footer"></div>
  </div>
</div>

@endsection