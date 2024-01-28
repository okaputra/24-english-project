@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Create Quiz / Category</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin-input-subcourse-content/{{$id_sub_course}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Category Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_quiz" value="{{old('nama_quiz')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Choose Paket</label>
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
                                        <input type="text" class="form-control" name="durasi" value="{{old('durasi')}}">
                                    </div>
                                </div>
                                <fieldset class="form-group">
                                    <div class="row">
                                        <label class="col-form-label col-sm-2 pt-0">Paid</label>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_berbayar" value="1">
                                                <label class="form-check-label">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_berbayar" value="0">
                                                <label class="form-check-label">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Video</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="video" accept="video/mp4" type="file" id="formFile">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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