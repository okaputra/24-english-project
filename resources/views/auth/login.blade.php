<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('login/fonts/icomoon/style.css')}}">

    <link rel="stylesheet" href="{{asset('login/css/owl.carousel.min.css')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('login/css/bootstrap.min.css')}}">

    <!-- Style -->
    <link rel="stylesheet" href="{{asset('login/css/style.css')}}">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.2/dist/sweetalert2.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Login 24English Center</title>
  </head>
  <body>

    @include('layout.script')

  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('login/images/bg_1.jpg');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Login to <strong>24English Center</strong></h3>
            <p class="mb-4">Jaga kerahasian username dan password yang anda gunakan!</p>
            <form action="/login-user" method="POST">
                @csrf
              <div class="form-group first">
                <label for="username">Username</label>
                <input type="email" class="form-control" name="email" placeholder="your-email@gmail.com" id="email" required>
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Your Password" id="password" required>
              </div>

              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked"/>
                  <div class="control__indicator"></div>
                </label>
                <span class="ml-auto"><a href="/register-user" class="forgot-pass">Don't have any account? Sign up</a></span>
              </div>

              <button type="submit" class="btn btn-block btn-primary">LOGIN </button>

            </form>
          </div>
        </div>
      </div>
    </div>


  </div>

    <script src="{{asset('login/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('login/js/popper.min.js')}}"></script>
    <script src="{{asset('login/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('login/js/main.js')}}"></script>
  </body>
</html>
