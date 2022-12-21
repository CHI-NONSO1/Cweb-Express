<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Cweb Express</title>
  @vite([ 'resources/css/register.css','resources/js/app.js'])

</head>

<body>



  <div class="wrapper_flexB">
    <form method="POST" action="/admin/register" enctype="multipart/form-data">
      @csrf

      <div class="error"></div>
      <div class="form-group-parent2">
        <div class="form-group"></div>
        <div class="input_parent">
          <input type="text" id="firstname" name="firstname" placeholder="First Name" class="form-control" value='' />
          <label for="firstname" class="labText">First Name</label>
        </div>
        <div class="help_parent"><span class="help-block"></span></div>
      </div>

      <div class="form-group-parent2">
        <div class="input_parent">
          <input type="text" id="lastname" name="lastname" placeholder="Last Name" class="form-control" value='' />
          <label htmlFor="lastname" class="labText">Last Name</label>
        </div>
        <div class="help_parent"><span class="help-block"></span></div>
      </div>

      <div class="form-group-parent2">
        <div class="input_parent">
          <input type="password" id="password" name="password" autoComplete="none" placeholder="Password" class="form-control" value='' />
          <label htmlFor="password" class="labText">Password</label>
        </div>
        <div class="help_parent"> <span class="help-block"></span></div>
      </div>

      <div class="form-group-parent2">
        <div class="input_parent">
          <input type="phoneno" name="phoneno" id="phoneno" placeholder="Phone Number" class="form-control" value='' />
          <label htmlFor="phoneno" class="labText">Phone Number</label>
        </div>
        <div class="help_parent"><span class="help-block"></span></div>
      </div>

      <div class="form-group-parent2">
        <div class="input_parent">
          <input type="email" name="email" id="email" placeholder="Email" class="form-control" value='' />
          <label htmlFor="email" class="labText">Email</label>
        </div>
        <div class="help_parent"><span class="help-block"></span></div>
      </div>


      <div class="form-group-parent2">
        <div class="input_parent">
          <input type="text" name="biz_name" id="biz_name" placeholder="Bussiness Name" class="form-control" value='' />
          <label htmlFor="biz_name" class="labText">Bussiness Name</label>
        </div>
        <div class="help_parent"><span class="help-block"></span></div>
      </div>

      <div class="form__group--parent--file">
        <div class="fileBtn__parent">
          <input type="file" name='file' />

        </div>

        <div class="img__parent">
          <img class="img__content" alt='avatarimg' src={imageprev} id="profileDisplay" />

        </div>
      </div>

      <div class="form__group--submit-parent">

        <input type="submit" class="btn__submit" value="Register" />

        <input type="reset" class="btn-reset" value="Reset" />

      </div>

    </form>



  </div>



</body>

</html>