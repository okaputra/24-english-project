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
                            <div class="stat-text">TRYOUT</div><br>
                            <div class="stat-digit"> <a href="/admin-assign-tryout/{{$id_sub_course}}" class="btn btn-primary" style="margin-bottom:20px;">ADD TRYOUT</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-two card-body">
                        <div class="stat-content">
                            <div class="stat-text">FINAL EXAM</div><br>
                            <div class="stat-digit"> <a href="/admin-assign-exam/{{$id_sub_course}}" class="btn btn-primary" style="margin-bottom:20px;">ADD FINAL EXAM</a></div>
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