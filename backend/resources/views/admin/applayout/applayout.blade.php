<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cweb Express</title>
  @vite([ 'resources/css/admin/dashboard.css','resources/js/app.js'])
  @vite([ 'resources/css/admin/Product.css','resources/js/app.js'])
  @vite([ 'resources/css/admin/add-product-status.css','resources/js/app.js'])
</head>

<header class="header">
  <div class="site_logo">
    <a class="logo_link">
      <img src="credit-card.png" class="logo__img" />
      Cweb-Express
    </a>
  </div>

  <div class="greeting">
    <div>welcome: {{$firstname}} {{$lastname}}</div>
  </div>

  <div class="register_login">
    <div class="logout">
      <form method="POST" action="/admin/logout" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="access_token" class="form-control" value='{{$accesstoken}}' />
        <input type="submit" class="link__item" value="Logout" />
      </form>
    </div>
  </div>

  <div class="site-img-wrap">
    <img class="user__img" src="http://localhost:8000/storage/user/image/{{$image}}" />
  </div>
</header>
<main class="container">
  <div class="greeting-small">
    <div>welcome: {{$firstname}} {{$lastname}}</div>
  </div>

  @yield('content')

</main>


<footer class="footer">
  <div class="contact__us">
    <a class="whatsappme" href="https://wa.me/message/Q5U5MFFUW6NVO1">
      Contact
    </a>
  </div>
  <div class="policy">
    <p class="site_policy">
      Site policy is work in progress
    </p>
  </div>
</footer>

</html>
