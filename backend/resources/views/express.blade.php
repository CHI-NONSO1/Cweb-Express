@extends('layout.header.master')

@section('content')

@include('layout.nav.navbar')


<div class='container'>
  <div class="ProductDisplay">
    <div class="product__wrap">
      @if(count($products)>0)
      @foreach($products as $product)
      <div class="product_display_container">

        <div class="image__wrap">

          <img class="product_img" src="http://localhost:8000/storage/product/image/{{$product->image}}" />

        </div>
        <div class="product_discription">{{$product->title}}</div>
        <div class="items__price">
          <span class="currency__sign">N</span>
          {{$product->price}}
        </div>
        <div class="items__cate">{{$product->category}}</div>
        <div class="cartbtn-wrap">
          <form method="POST" action='/one-product' enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="productid" value='{{$product->productid}}' />
            <input type="hidden" name="biz_id" value='{{$product->user_id}}' />
            <input type="text" name="shopping_token" value='{{$shopping_token}}' />
            <button class="add__cart--btn" name="shoppingtoken" value="" id="{{$product->productid}}">
              Add to Cart
            </button>

          </form>

        </div>

        <div class="admin__log-area">

          <span class="btn_edit">
            Edit
          </span>
          <span>
            <button>
              Delete
            </button>
          </span>

        </div>


      </div>
      @endforeach

      @else
      <h3>No product</h3>
      @endif
    </div>
  </div>

  <div class="DetailsDescription">
    <div class="close__details">
      icon close
    </div>
    <div class="Details">DetailsDescription </div>
  </div>


  <div class="SearchWrap">
    <div class="CloseSearchBox">
      close search icon
    </div>
    <div class="Search"></div>
  </div>

  <div class="FooterMain">
    <div class="Footer"></div>
  </div>
</div>

@endsection