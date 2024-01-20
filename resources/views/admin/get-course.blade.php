@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <div class="container-fluid">
        <a href="/admin-input-course" class="btn btn-primary" style="margin-bottom:20px;">ADD COURSE</a>
        <div class="row">
            @foreach ($courses as $c)
            <div class="col-xl-4 col-xxl-6 col-lg-6 col-sm-6">
                <div class="card mb-3">
                    <img class="card-img-top img-fluid" src="{{asset('/images/course-thumbnail/'. $c['thumbnail'] .'/'.$c['thumbnail'])}}" alt="Card image cap">
                    <div class="card-header">
                        <h5 class="card-title">{{$c['course_name']}}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{Str::limit($c['description'], 120, '...')}}</p>
                    </div>
                    <div class="card-footer">
                        <a href="/admin-detail-course/{{$c['id']}}" class="card-link btn btn-outline-primary">Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection