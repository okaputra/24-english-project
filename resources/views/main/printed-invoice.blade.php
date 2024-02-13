@extends('layout.master-main')
@section('content')

<!-- Page Header Start -->
<div class="container-fluid page-header py-6 my-6 mt-0 wow">
    <div class="container text-center">
        <h1 class="display-4 text-white animated slideInDown mb-4">DETAIL ORDER</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Sub Course</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Detail Order</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Courses Start -->
<div class="container-xxl py-6" style="padding: 4px">
    <div class="container">
        <div class="row g-5">
            <h1 class="display-6" style="margin-bottom: -19px">CONGRATS!</h1>
            <a href="/detail-subcourse/{{$sub['id']}}">Nikmati Course Anda!</a>
        </div>
    </div>
</div>
<!-- Courses End -->
@endsection
