@extends('layout.master-main')
@section('content')

<style>
  .rating {
  display: inline-block;
  position: relative;
  height: 50px;
  line-height: 50px;
  font-size: 50px;
}

.rating label {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  cursor: pointer;
}

.rating label:last-child {
  position: static;
}

.rating label:nth-child(1) {
  z-index: 5;
}

.rating label:nth-child(2) {
  z-index: 4;
}

.rating label:nth-child(3) {
  z-index: 3;
}

.rating label:nth-child(4) {
  z-index: 2;
}

.rating label:nth-child(5) {
  z-index: 1;
}

.rating label input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
}

.rating label .icon {
  float: left;
  color: transparent;
}

.rating label:last-child .icon {
  color: grey;
}

.rating:not(:hover) label input:checked ~ .icon,
.rating:hover label:hover input ~ .icon {
  color: yellow;
}

.rating label input:focus:not(:checked) ~ .icon:last-child {
  color: grey;
  text-shadow: 0 0 5px yellow;
}
</style>

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
                                <p class="card-text">Last Update &emsp;&nbsp;: <i class="bi bi-calendar-check"></i> {{$subCourse['updated_at']->diffForHumans()}}</p>
                                <p class="card-text">Rating &emsp;&emsp;&emsp;&emsp;&nbsp;: <i class="bi bi-star"></i> 7/10</p>
                                <p class="card-text">Certificate &emsp;&emsp;&nbsp;: <i class="bi bi-patch-check"></i></p>
                                @if(!$userPurchase)
                                  <a href="#" class="btn btn-primary">Buy Course</a>
                                @endif
                                <a href="#" class="btn btn-primary"><i class="bi bi-patch-check"></i> Get Certificate</a>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
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
            <p class="card-text" style="margin-bottom: -32px"><i class="bi bi-star"></i> 100 Reviews</p>
            <form class="rating" style="padding-left: calc(var(--bs-gutter-x) / 2)">
              <label>
                <input type="radio" name="stars" value="1" />
                <span class="icon">★</span>
              </label>
              <label>
                <input type="radio" name="stars" value="2" />
                <span class="icon">★</span>
                <span class="icon">★</span>
              </label>
              <label>
                <input type="radio" name="stars" value="3" />
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>   
              </label>
              <label>
                <input type="radio" name="stars" value="4" />
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
              </label>
              <label>
                <input type="radio" name="stars" value="5" />
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
              </label>
            </form>
        </div>
    </div>
</div>
<!-- Courses End -->

<script>
  $(':radio').change(function() {
    console.log('New star rating: ' + this.value);
  });
</script>

@endsection
