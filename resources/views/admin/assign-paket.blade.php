@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Centang pada daftar soal berikut untuk menambahkan soal pada paket ini.</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin-assign-paket/{{$paket['id']}}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Paket Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" style="background-color: blue; color:white;" name="nama_paket" value="{{$paket['nama_paket']}}" readonly>
                                    </div>
                                </div>
                                {{-- Datatable --}}
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Daftar Soal</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="example" class="display" style="min-width: 845px">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Pertanyaan</th>
                                                                <th>Select</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $no=1;
                                                            @endphp
                                                            @foreach ($soal as $s)
                                                            <tr>
                                                                <td style="color: black">{{$no++}}</td>
                                                                <td style="color: black">
                                                                    {!!$s['pertanyaan']!!}
                                                                    @if($s['audio_file'])
                                                                        <audio controls preload="none">
                                                                            <source src="{{ asset('audio-soal/' . $s['audio_file'] . '/' . $s['audio_file'])}}" type="audio/{{ pathinfo($s['audio_file'], PATHINFO_EXTENSION) }}">
                                                                            Your browser does not support the audio element.
                                                                        </audio>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span style="color: blue">
                                                                        <div class="input-group-prepend">
                                                                            <div class="input-group-text">
                                                                                <input type="checkbox" name="soal[]" value="{{$s['id']}}">
                                                                            </div>
                                                                        </div>
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Assign</button>
                                    </div>
                                </div>
                                {{-- End --}}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection