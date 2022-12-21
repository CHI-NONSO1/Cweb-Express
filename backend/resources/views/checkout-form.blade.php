@extends('layout.header.master')

@section('content')

<div class='container'>

  <div class="ShowCheckout">

    <div class="items-box">
      <a href="{{asset('express/'.$biz_id)}}" class="items-box-link">Return To Shop</a>
    </div>


    <div class="checkout__wrap--flex">

      <div class="h2parent">Enter Your details</div>
      <form method="POST" action='/checkout/.$biz_id' enctype="multipart/form-data">
        @csrf
        <div class="form-group-parent2">
          <div class="input_parent">
            <input type="text" id="firstname" name="fullname" placeholder="Full Name" class="form-control" value='' />
            <label htmlFor="firstname" class="labText">
              Full Name
            </label>
          </div>
          <div class="help_parent">
            <span class="help-block"></span>
          </div>
        </div>

        <div class="form-group-parent2">
          <div class="input_parent">
            <input type="phoneno" name="phoneno" id="phoneno" placeholder="Phone Number" class="form-control" value='' />
            <label htmlFor="phoneno" class="labText">
              Phone Number
            </label>
          </div>
          <div class="help_parent">
            <span class="help-block"></span>
          </div>
        </div>

        <div class="form-group-parent2">
          <div class="input_parent">
            <input type="email" name="email" id="email" placeholder="Email" class="form-control" value='' />
            <label htmlFor="email" class="labText">
              Email
            </label>
          </div>
          <div class="help_parent">
            <span class="help-block"></span>
          </div>
        </div>

        <div class="form-group-parent2">
          <div class="input_parent">
            <input type="address" name="address" id="address" placeholder="Your Address" class="form-control" value='' />
            <label htmlFor="address" class="labText">
              Your Address
            </label>
          </div>
          <div class="help_parent">
            <span class="help-block"></span>
          </div>
        </div>

        <input type="text" name="biz_id" value='{{$biz_id}}' />
        <input type="text" class="tracking_id" name="tracking_id" value='' />
        @foreach($cartItems as $cart)
        <input type="hidden" name="cartid[]" value='{{$cart}}' />

        @endforeach

        <div class="checkout__submit-parent">
          <input type="submit" class="checkout_submit" value="Order" />

          <input type="reset" class="checkout__btn--reset" value="Cance" />
        </div>
      </form>


    </div>
  </div>

  <div class="FooterMain">
    <div class="Footer"></div>
  </div>
</div>

@endsection