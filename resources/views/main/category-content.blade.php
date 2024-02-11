@extends('layout.master-main')
@section('content')

<!-- Page Header Start -->
<div class="container-fluid page-header py-6 my-6 mt-0 wow">
    <div class="container text-center">
        <h1 class="display-4 text-white animated slideInDown mb-4">{{$quiz['nama_quiz']}}</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Category</a></li>
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
            <div class="col-lg-8 wow">
                <div class="position-relative">
                    <video width="100%" height="100%" controls poster="{{asset('/images/video-thumbnail/'. $quiz['video_thumbnail'] .'/'.$quiz['video_thumbnail'])}}">
                        <source src="{{ asset('videos/quiz-video/' . $quiz['video_path'] . '/' . $quiz['video_path'])}}" type="video/{{ pathinfo($quiz['video_path'], PATHINFO_EXTENSION) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>

            <div class="col-lg-8 wow">
                <h1 class="display-6 mb-4">{{$quiz['nama_quiz']}}</h1>
                <div class="accordion col-lg-10 wow" id="accordionPanelsStayOpenExample">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        Answer Question
                      </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                      <div class="accordion-body">
                          <div class="card">
                              <div class="card-body">
                                <p class="card-text">Question &emsp;&emsp;&emsp;&emsp;&nbsp;: <i class="bi bi-book"></i> {{$jumlah_soal}}</p>
                                <p class="card-text">Duration &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;: <i class="bi bi-clock"></i> {{$quiz['durasi']}} Minutes</p>
                                <a href="#" class="btn btn-primary"><i class="bi bi-pencil"></i> Attempt Quiz</a>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Courses End -->

@endsection
