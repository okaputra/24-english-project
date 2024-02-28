@extends('layout.master-main')
@section('content')

<!-- Page Header Start -->
<div class="container-fluid page-header py-6 my-6 mt-0 wow">
    <div class="container text-center">
        <h1 class="display-4 text-white animated slideInDown mb-4">My Course</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="/my-courses">My Course</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Courses Start -->
<div class="container-xxl py-6" style="padding: 4px">
    <div class="container">
        <div class="row g-5">
            <!-- Sub Courses Start -->
              <div class="container">
                  <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                  </div>
                  <div class="row g-4 justify-content-center">
                      @foreach ($subCourses as $sc)
                          <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                              <div class="courses-item d-flex flex-column bg-light overflow-hidden h-100">
                                  <div class="text-center p-4 pt-0">
                                      <div class="d-inline-block bg-primary text-white fs-5 py-1 px-4 mb-4">Rp {{number_format($sc['pricing'])}}</div>
                                      <h5 class="mb-3">{{$sc['sub_course']}}</h5>
                                  </div>
                                  <div class="position-relative mt-auto">
                                      <img class="img-fluid" src="{{asset('/images/book.png')}}" alt="">
                                      <div class="courses-overlay">
                                          <a class="btn btn-outline-primary border-2" href="/detail-my-subcourse/{{$sc['id']}}">Get Started</a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      @endforeach
                  </div>
              </div>
            <!-- Sub Courses End -->
        </div>
    </div>
</div>
<!-- Courses End -->

@endsection
