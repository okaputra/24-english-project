@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Update Paket</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin-update-paket/{{$paket['id']}}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Paket Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_paket" value="{{$paket['nama_paket']}}">
                                    </div>
                                </div>
                                {{-- Datatable --}}
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Daftar Soal Terpilih Pada Paket ini.</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="example" class="display" style="min-width: 845px">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Soal</th>
                                                                <th>Select</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            @foreach ($soal as $s)
                                                                <tr>
                                                                    <td style="color: black">{{ $no++ }}</td>
                                                                    <td style="color: black">{!! $s['pertanyaan'] !!}</td>
                                                                    <td>
                                                                        <span style="color: blue">
                                                                            <div class="input-group-prepend">
                                                                                <div class="input-group-text">
                                                                                    <input type="checkbox" name="soal[]" value="{{ $s['id'] }}" {{ in_array($s['id'], $soal_terpilih_ids) ? 'checked' : '' }}>
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
                                {{-- End --}}
                                {{-- Datatable --}}
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Centang soal baru yang ingin ditambahkan.</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="example" class="display" style="min-width: 845px">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Soal</th>
                                                                <th>Select</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $no = 1;
                                                            @endphp
                                                            @foreach ($soal_all as $s)
                                                                <tr>
                                                                    <td style="color: black">{{ $no++ }}</td>
                                                                    <td style="color: black">{!! $s['pertanyaan'] !!}</td>
                                                                    <td>
                                                                        <span style="color: blue">
                                                                            <div class="input-group-prepend">
                                                                                <div class="input-group-text">
                                                                                    <input type="checkbox" name="soal[]" value="{{ $s['id'] }}">
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
                                {{-- End --}}
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