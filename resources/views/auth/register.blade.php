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

    <title>Register 24English Center</title>
  </head>
  <body>

    @include('layout.script')
  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('login/images/bg_1.jpg');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Create your<strong> New Account</strong></h3>
            <form action="/register-user" method="POST">
                @csrf
              <div class="form-group first">
                <label for="first-name">First Name</label>
                <input type="text" name="first_name" class="form-control" placeholder="First Name" id="first-name">
              </div>
              <div class="form-group first">
                <label for="last-name">Last Name</label>
                <input type="text" name="last_name" class="form-control" placeholder="Last Name" id="last-name">
              </div>
              <div class="form-group first">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" placeholder="your-email@gmail.com" id="email">
              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Your Password" id="password">
              </div>
              <div class="form-group last mb-3">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Your Confirm Password" id="confirm-password">
              </div>

              <input type="submit" value="Sign Up" class="btn btn-block btn-primary">

            </form>
          </div>
        </div>
      </div>
    </div>

  </div>

  @include('sweetalert::alert')
    <script src="{{asset('login/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('login/js/popper.min.js')}}"></script>
    <script src="{{asset('login/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('login/js/main.js')}}"></script>
  </body>
</html>
