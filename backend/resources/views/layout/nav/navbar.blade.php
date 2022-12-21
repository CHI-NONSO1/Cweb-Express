<nav class="navbar">
  <div class="NavHeader">
    <div class="search_parent">
      <input class="search_input" spellCheck="false" placeholder="Search here" type="text" />
    </div>

    <div class="CartBag">
      <div class="ShoppingCart" id="cartIcon">
        <form method="GET" action="/cart/{{$biz_id}}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="shopping_token" value='{{$shopping_token}}' />
          <button class="return-to-shop">
            cart

          </button>
        </form>
      </div>
      <div class="CartCount">
        {{$total_qty}}
      </div>
    </div>
  </div>
  <div class="FilterProduct">
    <div class="filter">
      <div class="filter-result">productNumber</div>
      <div class="filter-sort">

        <select name="categoryfilter" value=''>
          <option value="">Filter By Category</option>
          <option value="New Arrivals">New Arrivals</option>
          <option value="Trending Items">Trending Items</option>
          <option value="Featured Items">Featured Items</option>
          <option value="Top Deals">Top Deals</option>
        </select>
      </div>
      <div class="filter-size">

        <select name="pricefilter" value=''>
          <option value="">Filter By Price</option>
          <option value="5000">0-5000</option>
          <option value="10000">5000-10000</option>
          <option value="20000">10000-20000</option>
          <option value="30000">20000-30000</option>
          <option value="40000">30000-40000</option>
          <option value="50000">40000-50000</option>
          <option value="60000">60000-70000</option>
          <option value="70000">70000-80000</option>
          <option value="80000">80000-90000</option>
          <option value="90000">90000-100000</option>
          <option value="100000">100k</option>
        </select>
      </div>
    </div>
  </div>
</nav>
