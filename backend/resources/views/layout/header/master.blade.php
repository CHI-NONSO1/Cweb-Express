<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cweb Express</title>

  @vite([ 'resources/css/shop/Shop.css','resources/js/shop/shop.js'])

  @vite([ 'resources/css/cart/cart.css'])

  @vite([ 'resources/css/checkout/checkout-form.css','resources/js/checkout/checkout.js'])
</head>

<body>

  @yield('content')

</body>

</html>
