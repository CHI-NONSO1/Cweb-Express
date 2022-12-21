@extends('admin.applayout.applayout')


@section('content')


<div class="main-box">

  <div class="items-box">
    <a href="{{asset('admin/add-product-form/'.$accesstoken)}}" class="items-box-link">Add Product</a>
  </div>

  <div class="items-box">
    <a href="{{asset('express/'.$biz_id)}}" class="items-box-link">Visit Shop</a>
  </div>

  <div class="items-box">
    <form method="POST" action="admin/express" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="accesstoken" value={{$accesstoken}} />
      <input type="button" class="link__item" name="send" value="Visit Shop" />
  </div>
  </form>
</div>


@endsection