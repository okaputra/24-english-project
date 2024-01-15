@extends('layout.master-main')
@section('content')

<!-- Page Header Start -->
<div class="container-fluid page-header py-6 my-6 mt-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center">
        <h1 class="display-4 text-white animated slideInDown mb-4">Courses</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Courses Start -->
<div class="container-xxl py-6">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="display-6 mb-4">General English</h1>
                <p class="mb-5"><b>Disini kasih wording beberapa kalimat tentang pelajaran ini ya</b>, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus obcaecati velit praesentium officia atque suscipit, fugit fugiat exercitationem dignissimos nisi!</p>

                <h5 class="display-6 mb-2" style="font-size: x-large">What I will learn?</h5>
                <div class="row gy-3 gx-4">
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="d-flex align-items-center mb-1">
                            <div class="flex-shrink-0 me-3">
                                <i class="fa fa-check text-black"></i>
                            </div>
                            <p class="mb-0">Lorem Ipsum</p>
                        </div>
                    </div>
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="d-flex align-items-center mb-1">
                            <div class="flex-shrink-0 me-3">
                                <i class="fa fa-check text-black"></i>
                            </div>
                            <p class="mb-0">Lorem Ipsum</p>
                        </div>
                    </div>
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="d-flex align-items-center mb-1">
                            <div class="flex-shrink-0 me-3">
                                <i class="fa fa-check text-black"></i>
                            </div>
                            <p class="mb-0">Lorem Ipsum</p>
                        </div>
                    </div>
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="d-flex align-items-center mb-1">
                            <div class="flex-shrink-0 me-3">
                                <i class="fa fa-check text-black"></i>
                            </div>
                            <p class="mb-0">Lorem Ipsum</p>
                        </div>
                    </div>
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="d-flex align-items-center mb-1">
                            <div class="flex-shrink-0 me-3">
                                <i class="fa fa-check text-black"></i>
                            </div>
                            <p class="mb-0">Lorem Ipsum</p>
                        </div>
                    </div>
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="d-flex align-items-center mb-1">
                            <div class="flex-shrink-0 me-3">
                                <i class="fa fa-check text-black"></i>
                            </div>
                            <p class="mb-0">Lorem Ipsum</p>
                        </div>
                    </div>
                    <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="d-flex align-items-center mb-1">
                            <div class="flex-shrink-0 me-3">
                                <i class="fa fa-check text-black"></i>
                            </div>
                            <p class="mb-0">Lorem Ipsum</p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="position-relative overflow-hidden pe-5 pt-5 h-100" style="min-height: 400px;">
                    {{-- <img class="position-absolute w-100 h-100" src="img/about-1.jpg" alt="" style="object-fit: cover;">
                    <img class="position-absolute top-0 end-0 bg-white ps-3 pb-3" src="img/about-2.jpg" alt="" style="width: 200px; height: 200px"> --}}
                    <video width="550" height="470" poster="{{asset('main/img/courses-3.jpg')}}" controls>
                        <source src="{{asset('main/video/vid.mp4')}}" type="video/mp4">
                        <source src="{{asset('main/video/vid.ogg')}}" type="video/ogg">
                      Your browser does not support the video tag.
                      </video>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Courses End -->

@endsection
