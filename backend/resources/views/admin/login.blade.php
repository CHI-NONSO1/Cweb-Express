<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cweb Express---Admin Login</title>
  @vite([ 'resources/css/admin/Login.css','resources/js/app.js'])

</head>

<body>

  <div class="wrapper_flex">
    <div class="h2parent">
      <h2 class="login_header">Login</h2>
    </div>
    <div class="paraparent">
      <p class="para_details"></p>
    </div>
    <form method="POST" action="/admin/sign-in" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <p class="has-text-centered">

        </p>
      </div>

      <div class="form-group-parent2">
        <div class="input1_parent">
          <input type="email" id="email" placeholder="Email" name="email" class="form-control" value='' />
          <label for="email" class="labText">Email</label>
        </div>
        <div class="help_parent"><span class="help-block"></span>
        </div>
      </div>

      <div class="form-group-parent2">
        <div class="form-group"></div>

        <div class="input_parent">
          <input type="password" id="password" placeholder="Password" autoComplete="none" name="password" class="form-control" value='' />
          <label for="password" class="labText"> Password</label>
        </div>
        <div class="help_parent"><span class="help-block"></span>
        </div>
      </div>

      <div class="form-group-submit-parent">
        <input type="submit" class="btn_submit" value="Login" />
      </div>


    </form>
  </div>

</body>

</html>