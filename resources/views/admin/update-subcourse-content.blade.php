@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Update Course</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin-update-subcourse-content/{{$quiz['id']}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Quiz/Category Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_quiz" value="{{$quiz['nama_quiz']}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Current Paket</label>
                                    <div class="col-sm-10" id="disini">
                                        <input type="text" class="form-control" name="pkt" value="{{$paket_terpilih['nama_paket']}}" disabled style="background-color: blue; color:white;">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Choose Another Paket</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="id_paket" id="sel1">
                                            @foreach ($paket as $p)
                                                <option value="{{$p['id']}}">{{$p['nama_paket']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Durasi (in minutes)</label>
                                    <div class="col-sm-10" id="disini">
                                        <input type="text" class="form-control" name="durasi" value="{{$quiz['durasi']}}">
                                    </div>
                                </div>
                                <fieldset class="form-group">
                                    <div class="row">
                                        <label class="col-form-label col-sm-2 pt-0">Paid</label>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_berbayar" value="1" @if($quiz['is_berbayar'] == 1) checked @endif>
                                                <label class="form-check-label">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_berbayar" value="0" @if($quiz['is_berbayar'] == 0) checked @endif>
                                                <label class="form-check-label">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Old Video</label>
                                    <video width="320" height="240" controls>
                                        <source src="{{ asset('videos/quiz-video/' . $quiz['video_path'] . '/' . $quiz['video_path'])}}" type="video/{{ pathinfo($quiz['video_path'], PATHINFO_EXTENSION) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Old Video Thumbnail</label>
                                    <div class="col-sm-10">
                                        <img class="img-fluid" style="width: 320px" src="{{asset('/images/video-thumbnail/'. $quiz['video_thumbnail'] .'/'.$quiz['video_thumbnail'])}}" alt="Card image cap">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Learning Video</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="video" accept="video/mp4" type="file" id="formFile">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Video Thumbnail</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="video_thumbnail" accept="image/png, image/gif, image/jpeg" type="file" id="formFile">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection