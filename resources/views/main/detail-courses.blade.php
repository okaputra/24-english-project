@extends('layout.master-main')
@section('content')

<!-- Page Header Start -->
<div class="container-fluid page-header py-6 my-6 mt-0 wow">
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
<div class="container-xxl py-6" style="padding: 4px">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow">
                <div class="position-relative overflow-hidden pe-5 pt-5 h-100" style="min-height: 400px;">
                    {{-- <img class="position-absolute w-100 h-100" src="img/about-1.jpg" alt="" style="object-fit: cover;">
                    <img class="position-absolute top-0 end-0 bg-white ps-3 pb-3" src="img/about-2.jpg" alt="" style="width: 200px; height: 200px"> --}}
                    <video width="700" height="500" style="margin-top: -90px" poster="{{asset('main/img/courses-3.jpg')}}" controls>
                        <source src="{{asset('main/video/vid.mp4')}}" type="video/mp4">
                        <source src="{{asset('main/video/vid.ogg')}}" type="video/ogg">
                      Your browser does not support the video tag.
                      </video>
                </div>
            </div>

            <div class="col-lg-6 wow">
                <h1 class="display-6 mb-4">General English</h1>
                <p class="mb-5"><b>Disini kasih wording beberapa kalimat tentang pelajaran ini ya</b>, Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus obcaecati velit praesentium officia atque suscipit, fugit fugiat exercitationem dignissimos nisi!</p>

                <h5 class="display-6 mb-2" style="font-size: x-large">What I will learn?</h5>
                <div class="row gy-3 gx-4">
                    <div class="col-sm-6 wow">
                        <div class="d-flex align-items-center mb-1">
                            <div class="flex-shrink-0 me-3">
                                <i class="fa fa-check text-black"></i>
                            </div>
                            <p class="mb-0">Lorem Ipsum</p>
                        </div>
                    </div>
                    <div class="col-sm-6 wow">
                        <div class="d-flex align-items-center mb-1">
                            <div class="flex-shrink-0 me-3">
                                <i class="fa fa-check text-black"></i>
                            </div>
                            <p class="mb-0">Lorem Ipsum</p>
                        </div>
                    </div>
                    <div class="col-sm-6 wow">
                        <div class="d-flex align-items-center mb-1">
                            <div class="flex-shrink-0 me-3">
                                <i class="fa fa-check text-black"></i>
                            </div>
                            <p class="mb-0">Lorem Ipsum</p>
                        </div>
                    </div>
                    <div class="col-sm-6 wow">
                        <div class="d-flex align-items-center mb-1">
                            <div class="flex-shrink-0 me-3">
                                <i class="fa fa-check text-black"></i>
                            </div>
                            <p class="mb-0">Lorem Ipsum</p>
                        </div>
                    </div>
                    <div class="col-sm-6 wow">
                        <div class="d-flex align-items-center mb-1">
                            <div class="flex-shrink-0 me-3">
                                <i class="fa fa-check text-black"></i>
                            </div>
                            <p class="mb-0">Lorem Ipsum</p>
                        </div>
                    </div>
                    <div class="col-sm-6 wow">
                        <div class="d-flex align-items-center mb-1">
                            <div class="flex-shrink-0 me-3">
                                <i class="fa fa-check text-black"></i>
                            </div>
                            <p class="mb-0">Lorem Ipsum</p>
                        </div>
                    </div>
                    <div class="col-sm-6 wow">
                        <div class="d-flex align-items-center mb-1">
                            <div class="flex-shrink-0 me-3">
                                <i class="fa fa-check text-black"></i>
                            </div>
                            <p class="mb-0">Lorem Ipsum</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion col-lg-6 wow" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                      Price
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                    <div class="accordion-body">
                        <div class="card">
                            <div class="card-body">
                              <h5 class="card-title">Rp 100.000</h5>
                              <p class="card-text">Level</p> 
                              <p class="card-text">Enrolled</p>
                              <p class="card-text">Last Update</p>
                              <p class="card-text">Certificate</p>
                              <a href="#" class="btn btn-primary">Get Course</a>
                            </div>
                          </div>
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                      Introduction
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
                    <div class="accordion-body">
                      <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                      Introduction
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
                    <div class="accordion-body">
                      <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsStayOpen-headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFour" aria-expanded="false" aria-controls="panelsStayOpen-collapseFour">
                      Introduction
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseFour" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFour">
                    <div class="accordion-body">
                      <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsStayOpen-headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseFive" aria-expanded="false" aria-controls="panelsStayOpen-collapseFive">
                      Introduction
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseFive" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingFive">
                    <div class="accordion-body">
                      <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsStayOpen-headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSix" aria-expanded="false" aria-controls="panelsStayOpen-collapseSix">
                      Introduction
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseSix" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSix">
                    <div class="accordion-body">
                      <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsStayOpen-headingSeven">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseSeven" aria-expanded="false" aria-controls="panelsStayOpen-collapseSeven">
                      Introduction
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseSeven" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingSeven">
                    <div class="accordion-body">
                      <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsStayOpen-headingEight">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseEight" aria-expanded="false" aria-controls="panelsStayOpen-collapseEight">
                      Introduction
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseEight" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingEight">
                    <div class="accordion-body">
                      <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsStayOpen-headingNine">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseNine" aria-expanded="false" aria-controls="panelsStayOpen-collapseNine">
                      Introduction
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseNine" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingNine">
                    <div class="accordion-body">
                      <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="panelsStayOpen-headingTen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTen" aria-expanded="false" aria-controls="panelsStayOpen-collapseTen">
                      Introduction
                    </button>
                  </h2>
                  <div id="panelsStayOpen-collapseTen" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTen">
                    <div class="accordion-body">
                      <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                  </div>
                </div>
                
              </div>
        </div>
    </div>
</div>
<!-- Courses End -->

@endsection
