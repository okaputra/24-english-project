@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Update Exam</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin-update-exam/{{$exam['id']}}" method="POST">
                                @csrf
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
                                        <input type="text" class="form-control" name="durasi" value="{{$exam['durasi']}}">
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