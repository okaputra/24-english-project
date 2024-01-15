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
                <li class="breadcrumb-item text-primary active" aria-current="page">Courses</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->


<!-- Courses Start -->
<div class="container-xxl py-6">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
            <h6 class="text-primary text-uppercase mb-2">Tranding Courses</h6>
            <h1 class="display-6 mb-4">Our Courses Upskill Your English</h1>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="courses-item d-flex flex-column bg-light overflow-hidden h-100">
                    <div class="text-center p-4 pt-0">
                        <div class="d-inline-block bg-primary text-white fs-5 py-1 px-4 mb-4">$99</div>
                        <h5 class="mb-3">General English</h5>
                        <p>Tempor erat elitr rebum at clita dolor diam ipsum sit diam amet diam et eos</p>
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item small">Basic English</li>
                            <li class="breadcrumb-item small">Intermediate English</li>
                            <li class="breadcrumb-item small">Advance English</li>
                        </ol>
                    </div>
                    <div class="position-relative mt-auto">
                        <img class="img-fluid" src="{{asset('main/img/courses-1.jpg')}}" alt="">
                        <div class="courses-overlay">
                            <a class="btn btn-outline-primary border-2" href="/detail-courses">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="courses-item d-flex flex-column bg-light overflow-hidden h-100">
                    <div class="text-center p-4 pt-0">
                        <div class="d-inline-block bg-primary text-white fs-5 py-1 px-4 mb-4">$99</div>
                        <h5 class="mb-3">TOEFL</h5>
                        <p>Tempor erat elitr rebum at clita dolor diam ipsum sit diam amet diam et eos</p>
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item small">Reading</li>
                            <li class="breadcrumb-item small">Writing</li>
                            <li class="breadcrumb-item small">Listening</li>
                            <li class="breadcrumb-item small">Speaking</li>
                        </ol>
                    </div>
                    <div class="position-relative mt-auto">
                        <img class="img-fluid" src="{{asset('main/img/courses-2.jpg')}}" alt="">
                        <div class="courses-overlay">
                            <a class="btn btn-outline-primary border-2" href="">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="courses-item d-flex flex-column bg-light overflow-hidden h-100">
                    <div class="text-center p-4 pt-0">
                        <div class="d-inline-block bg-primary text-white fs-5 py-1 px-4 mb-4">$99</div>
                        <h5 class="mb-3">IELTS</h5>
                        <p>Tempor erat elitr rebum at clita dolor diam ipsum sit diam amet diam et eos</p>
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item small">Reading</li>
                            <li class="breadcrumb-item small">Writing</li>
                            <li class="breadcrumb-item small">Listening</li>
                            <li class="breadcrumb-item small">Speaking</li>
                        </ol>
                    </div>
                    <div class="position-relative mt-auto">
                        <img class="img-fluid" src="{{asset('main/img/courses-3.jpg')}}" alt="">
                        <div class="courses-overlay">
                            <a class="btn btn-outline-primary border-2" href="">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="courses-item d-flex flex-column bg-light overflow-hidden h-100">
                    <div class="text-center p-4 pt-0">
                        <div class="d-inline-block bg-primary text-white fs-5 py-1 px-4 mb-4">$99</div>
                        <h5 class="mb-3">IELTS</h5>
                        <p>Tempor erat elitr rebum at clita dolor diam ipsum sit diam amet diam et eos</p>
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item small">Reading</li>
                            <li class="breadcrumb-item small">Writing</li>
                            <li class="breadcrumb-item small">Listening</li>
                            <li class="breadcrumb-item small">Speaking</li>
                        </ol>
                    </div>
                    <div class="position-relative mt-auto">
                        <img class="img-fluid" src="{{asset('main/img/courses-3.jpg')}}" alt="">
                        <div class="courses-overlay">
                            <a class="btn btn-outline-primary border-2" href="">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="courses-item d-flex flex-column bg-light overflow-hidden h-100">
                    <div class="text-center p-4 pt-0">
                        <div class="d-inline-block bg-primary text-white fs-5 py-1 px-4 mb-4">$99</div>
                        <h5 class="mb-3">IELTS</h5>
                        <p>Tempor erat elitr rebum at clita dolor diam ipsum sit diam amet diam et eos</p>
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item small">Reading</li>
                            <li class="breadcrumb-item small">Writing</li>
                            <li class="breadcrumb-item small">Listening</li>
                            <li class="breadcrumb-item small">Speaking</li>
                        </ol>
                    </div>
                    <div class="position-relative mt-auto">
                        <img class="img-fluid" src="{{asset('main/img/courses-3.jpg')}}" alt="">
                        <div class="courses-overlay">
                            <a class="btn btn-outline-primary border-2" href="">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="courses-item d-flex flex-column bg-light overflow-hidden h-100">
                    <div class="text-center p-4 pt-0">
                        <div class="d-inline-block bg-primary text-white fs-5 py-1 px-4 mb-4">$99</div>
                        <h5 class="mb-3">IELTS</h5>
                        <p>Tempor erat elitr rebum at clita dolor diam ipsum sit diam amet diam et eos</p>
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item small">Reading</li>
                            <li class="breadcrumb-item small">Writing</li>
                            <li class="breadcrumb-item small">Listening</li>
                            <li class="breadcrumb-item small">Speaking</li>
                        </ol>
                    </div>
                    <div class="position-relative mt-auto">
                        <img class="img-fluid" src="{{asset('main/img/courses-3.jpg')}}" alt="">
                        <div class="courses-overlay">
                            <a class="btn btn-outline-primary border-2" href="">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Courses End -->

@endsection
