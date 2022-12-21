@extends('admin.applayout.applayout')


@section('content')

<div class="product__wrap">
  <form method="POST" action="/admin/add-product" enctype="multipart/form-data">
    @csrf
    <div class="add__product-container">
      <div class="hdparent">
        <h2 class="product__header">Add Product</h2>
      </div>
      <div class="form-group ">

      </div>

      <div class="form-group-parent2">
        <div class="form-group "></div>

        <div class="input_parent">
          <input type="text" name="user_id" value={{$biz_id}} />
        </div>

        <div class="input_parent">
          <input type="text" name="accesstoken" value={{$access_token}} />

        </div>

        <div class="form-group-parent2">
          <div class="input_parent">
            <input type="text" id="product_name" name="product_name" placeholder="Product Name" class="product_name" value='' />
            <label for="product_name" class="lab-Text">
              Product Name
            </label>
          </div>
          <div class="help_parent">
            <span class="help-block"></span>
          </div>
        </div>

        <div class="form-group-parent2">
          <div class="form-group "></div>

          <div class="input_parent">
            <input min='1' type="number" id="price" name="price" placeholder="Product Price" class="form__control-num" value='' />
            <label for="price" class="labText-num">
              Product Price
            </label>
          </div>
          <div class="help_parent">
            <span class="help-block"></span>
          </div>
        </div>

        <div class="form-group-parent2">
          <div class="form-group "></div>

          <div class="input_parent">
            <input min='1' type="number" id="quantity" name="quantity" placeholder="Product Quantity" class="form__control-num" value='' />
            <label for="quantity" class="labText-num">
              Product Quantity
            </label>
          </div>
          <div class="help_parent">
            <span class="help-block"></span>
          </div>
        </div>

        <div class="form-group-parent2">
          <div class="input_parent">
            <select class="select__category" name="select__category">
              <option value="">Select Category</option>
              <option value="New Arrivals">New Arrivals</option>
              <option value="Trending Items">Trending Items</option>
              <option value="Featured Items">Featured Items</option>
              <option value="Top Deals">Top Deals</option>
            </select>
          </div>

          <div class="help_parent">
            <span class="help-block"></span>
          </div>
        </div>

        <div class="form-group-parent2">
          <div class="form-group "></div>
          <div class="description__parent">
            <textarea name="description" form="description" id="description" required placeholder="Product Description" value=''></textarea>
            <label for="description" class="form__label">
              Product Description
            </label>
          </div>
          <div class="help_parent">
            <span class="help-block"></span>
          </div>
        </div>

        <div class="form__group--parent--file">
          <div class="fileBtn__parent">
            <input type="file" name="file" value="" />
          </div>
          <div class="img__holder">
            <img class="img__cont" alt="avatarimg" src='' id="profileDisplay" />
          </div>
        </div>

        <div class="form-group-submit-parent">

          <input type="submit" class="btn__submit" value="Post" />

          <input type="reset" class="btn-reset" value="Reset" />
        </div>
      </div>
  </form>
</div>
@endsection