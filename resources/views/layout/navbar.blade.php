<!-- Topbar Start -->
{{-- <div class="container-fluid bg-dark text-light p-0">
    <div class="row gx-0 d-none d-lg-flex">
        <div class="col-lg-7 px-5 text-start">
            <div class="h-100 d-inline-flex align-items-center me-4">
                <small class="fa fa-map-marker-alt text-primary me-2"></small>
                <small>123 Street, New York, USA</small>
            </div>
            <div class="h-100 d-inline-flex align-items-center">
                <small class="far fa-clock text-primary me-2"></small>
                <small>Mon - Fri : 09.00 AM - 09.00 PM</small>
            </div>
        </div>
        <div class="col-lg-5 px-5 text-end">
            <div class="h-100 d-inline-flex align-items-center me-4">
                <small class="fa fa-phone-alt text-primary me-2"></small>
                <small>+012 345 6789</small>
            </div>
            <div class="h-100 d-inline-flex align-items-center mx-n2">
                <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i class="fab fa-twitter"></i></a>
                <a class="btn btn-square btn-link rounded-0 border-0 border-end border-secondary" href=""><i class="fab fa-linkedin-in"></i></a>
                <a class="btn btn-square btn-link rounded-0" href=""><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</div> --}}
<!-- Topbar End -->


<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
    <a href="/" class="navbar-brand d-flex align-items-center border-end px-4 px-lg-5">
       <img class="img-fluid logo24" src="{{asset('logo/logo.png')}}" alt="">
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="/" class="nav-item nav-link">Home</a>
            <a href="/about" class="nav-item nav-link">About</a>
            <a href="/our-courses" class="nav-item nav-link">Courses</a>
            @if(Session::get("login"))
                <h5 style="margin-right: 20px; height: 40px; margin-top: 25px">Hi, {{ Session::get("first_name") }}</h5>
                <a href="/logout" class="btn btn-primary" style="margin-right: 20px; height: 40px; margin-top: 19px">Logout</a>
            @else
                <a href="/login-user" class="btn btn-primary" style="margin-right: 20px; height: 40px; margin-top: 19px">Login</a>
                <a href="/register-user" class="btn btn-outline-primary" style="margin-top: 19px; height: 38px; margin-right: 20px">Register</a>
            @endif
        </div>
        {{-- <a href="/login-user" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Get Started<i class="fa fa-arrow-right ms-3"></i></a> --}}
    </div>
</nav>
<!-- Navbar End -->
