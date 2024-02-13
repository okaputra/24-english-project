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

            <h1 class="display-6" style="margin-bottom: -19px">DETAIL ORDER</h1>

            <form method="POST" action="/user-confirm-subcourse/{{$detailSub['id']}}">
                @csrf
                <div class="mb-3">
                  <label for="exampleInputSubCourseName" class="form-label">Sub Course Name</label>
                  <input type="text" class="form-control" name="sub_course" value="{{$detailSub['sub_course']}}" id="exampleInputSubCourseName" aria-describedby="emailHelp" readonly>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPrice" class="form-label">Price</label>
                  <input type="text" class="form-control" name="pricing" value="{{number_format($detailSub['pricing'])}}" id="exampleInputPrice" readonly>
                </div>
                <input type="hidden" class="form-control" name="id_user" value="{{$dataUser['id']}}" id="exampleInputEmail" readonly>
                <div class="mb-3">
                  <label for="exampleInputFirstName" class="form-label">First Name</label>
                  <input type="text" class="form-control" name="first_name" value="{{$dataUser['first_name']}}" id="exampleInputFirstName" readonly>
                </div>
                <div class="mb-3">
                  <label for="exampleInputLastName" class="form-label">Last Name</label>
                  <input type="text" class="form-control" name="last_name" value="{{$dataUser['last_name']}}" id="exampleInputLastName" readonly>
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail" class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" value="{{$dataUser['email']}}" id="exampleInputEmail" readonly>
                </div>

                <button type="submit" class="btn btn-primary">Confirm</button>
              </form>
        </div>
    </div>
</div>
<!-- Courses End -->


@endsection
