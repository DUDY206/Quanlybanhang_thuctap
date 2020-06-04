<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Loding font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,700" rel="stylesheet">

    <!-- Custom Styles -->
    <link rel="stylesheet" type="text/css" href="/css/login.css">

    <title>Login</title>
  </head>
  <body>

    <!-- Backgrounds -->

    <div id="login-bg" class="container-fluid">

      <div class="bg-img"></div>
      <div class="bg-color"></div>
    </div>

    <!-- End Backgrounds -->
      @include('inc.messages')

    <div class="container" id="login">
        <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="login">

            <h1>Login</h1>

            <!-- Loging form -->
                  <form method="post" action="{{ url('/login/checkLogin') }}">
                    @csrf
                    <div class="form-group">
                      <input type="text" name="sdt" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Số điện thoại">

                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Mật khẩu" name="password">
                    </div>

                      <div class="form-check">

                      <label class="switch">
                      <input type="checkbox" id="RMB_login" name="remember" class="field login-checbox" value= "First Choice">
                      <span class="slider round"></span>
                    </label>
                      <label class="form-check-label" for="exampleCheck1">Nhớ mật khẩu</label>

                      <label class="forgot-password"><a href="#">Quên mật khẩu?<a></label>

                    </div>

                    <br>
                    <button type="submit" class="btn btn-lg btn-block btn-success">Đăng nhập</button>
                  </form>
             <!-- End Loging form -->

          </div>
        </div>
        </div>
    </div>
<script type="text/javascript">
  document.getElementById('RMB_login').defaultChecked = true
</script>
@if(isset(Auth::user()->ten))
  <script type="text/javascript">
    window.location = "/";
  </script>
@endif
  </body>
</html>
