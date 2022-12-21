@extends('layout.header.master')

@section('content')

<div class='container'>

  <div class="ShowCheckout">

    <div class="items-box">
      <a href="{{asset('express/'.$biz_id)}}" class="items-box-link">Return To Shop</a>
    </div>


    <div>
      @foreach($checkout as $order)
      <div>{{$order}}</div>
      @endforeach
    </div>
  </div>

  <div class="FooterMain">
    <div class="Footer"></div>
  </div>
</div>

@endsection