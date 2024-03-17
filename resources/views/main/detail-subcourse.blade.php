@extends('layout.master-main')
@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-6 my-6 mt-0 wow">
    <div class="container text-center">
        <h1 class="display-4 text-white animated slideInDown mb-4">{{$subCourse['sub_course']}}</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Sub Course</a></li>
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
                <div class="position-relative">
                    <img class="img-fluid" src="{{asset('/images/book.png')}}" alt="">
                </div>
            </div>

            <div class="col-lg-6 wow">
                <h1 class="display-6 mb-4">{{$subCourse['sub_course']}}</h1>
                <div class="accordion col-lg-10 wow" id="accordionPanelsStayOpenExample">
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
                                <h5 class="card-title">Rp {{number_format($subCourse['pricing'])}}</h5>
                                <p class="card-text">Enrolled &emsp;&emsp;&emsp;&nbsp;: <i class="bi bi-person"></i> {{$userPaidThisSubCourse}}</p>
                                <p class="card-text">Rating &emsp;&emsp;&emsp;&emsp;&nbsp;: <i class="bi bi-star"></i> {{ number_format( $subCourse->averageRating, 1) }}</p>
                                <p class="card-text">Review &emsp;&emsp;&emsp;&emsp;: <i class="bi bi-people"></i> {{$subCourse['number_of_review']}} Reviews</p>
                                <p class="card-text">Certificate &emsp;&emsp;&nbsp;: <i class="bi bi-patch-check"></i></p>
                                @if(!$userPurchase)
                                  <a href="/user-buy-subcourse/{{$subCourse['id']}}" class="btn btn-primary"><i class="bi bi-cart"></i> Buy Course</a>
                                @endif
                                <a href="#" class="btn btn-primary"><i class="bi bi-patch-check"></i> Get Certificate</a>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

            @if(count($quizFree) > 0)
              <h3 class="display-6" style="margin-bottom: -19px">FREE MATERIAL</h3>
            @endif
            <div class="accordion col-lg-6 wow" id="accordionPanelsStayOpenExample">
                @foreach($quizFree as $q)
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-heading{{$q['id']}}">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{$q['id']}}" aria-expanded="false" aria-controls="panelsStayOpen-collapse{{$q['id']}}">
                        {{$q['nama_quiz']}}
                      </button>
                    </h2>
                    <div id="panelsStayOpen-collapse{{$q['id']}}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading{{$q['id']}}">
                      <div class="accordion-body">
                        <strong><a href="/user-get-free-subcourse-material/{{$q['id']}}/{{$subCourse['id']}}">Get {{$q['nama_quiz']}} Material</a></strong>
                      </div>
                    </div>
                  </div>
                @endforeach
            </div>
            

            <h1 class="display-6" style="margin-bottom: -19px">MATERIAL</h1>

            <div class="accordion col-lg-6 wow" id="accordionPanelsStayOpenExample">
                @forelse($quiz as $q)
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-heading{{$q['id']}}">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{$q['id']}}" aria-expanded="false" aria-controls="panelsStayOpen-collapse{{$q['id']}}">
                        {{$q['nama_quiz']}}
                      </button>
                    </h2>
                    <div id="panelsStayOpen-collapse{{$q['id']}}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading{{$q['id']}}">
                      <div class="accordion-body">
                        <strong><a href="/user-get-subcourse-material/{{$q['id']}}/{{$subCourse['id']}}">Get {{$q['nama_quiz']}} Material</a>@if(!$userPurchase) <i class="bi bi-lock"></i> @endif</strong>
                      </div>
                    </div>
                  </div>
                @empty
                  <p class="card-text">No Material Published Yet!</p>
                @endforelse
            </div>

            <h1 class="display-6" style="margin-bottom: -19px; color:brown;">TRYOUT</h1>
            <div class="accordion col-lg-6 wow" id="accordionPanelsStayOpenExample">
                @php
                    $no=1;
                @endphp
                @forelse($tryout as $t)
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headings{{$t['id']}}">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collaps{{$t['id']}}" aria-expanded="false" aria-controls="panelsStayOpen-collapse{{$t['id']}}">
                        TRYOUT {{$no++}}
                      </button>
                    </h2>
                    <div id="panelsStayOpen-collaps{{$t['id']}}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading{{$t['id']}}">
                      <div class="accordion-body">
                        <strong><a href="/user-get-tryout/{{$t['id']}}/{{$subCourse['id']}}">Get Tryout</a></strong>
                      </div>
                    </div>
                  </div>
                @empty
                  <p class="card-text">No Tryout Published Yet!</p>
                @endforelse
            </div>
            <p class="card-text" style="margin-bottom: -32px"><i class="bi bi-star"></i>  {{ number_format( $subCourse->averageRating, 1) }}</p>
            <form class="rating" method="POST" action="/user-rate-subcourse-material/{{$subCourse['id']}}" >
              @csrf
              <input type="text" name="rate" class="kv-fa rating-loading" value="{{$subCourse->averageRating}}" data-size="sm">
              <br>
              <button type="submit" style="border-radius: 20px" class="btn btn-primary">Review</button>
            </form>
        </div>
    </div>
</div>
<!-- Courses End -->

<script type="text/javascript">
  $('.kv-fa').rating({
      filledStar: '<i class="fa fa-star"></i>',
      emptyStar: '<i class="fa fa-star-o"></i>'
  });
</script>

@endsection
