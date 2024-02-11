@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-two card-body">
                        <div class="stat-content">
                            <div class="stat-text">TOTAL USER</div>
                            <div class="stat-digit"> <i class="fa fa-user"></i>{{$countUser}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-two card-body">
                        <div class="stat-content">
                            <div class="stat-text">TOTAL COURSE</div>
                            <div class="stat-digit"> <i class="fa fa-book"></i>{{$countCourse}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-two card-body">
                        <div class="stat-content">
                            <div class="stat-text">COMPLETED USERS PAYMENT</div>
                            <div class="stat-digit"> <i class="fa fa-check"></i>{{$countUserPurchase}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       {{-- code here if you want to add something! --}}

       {{-- end --}}
    </div>
</div>
@endsection