@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Create Paket</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin-create-paket" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Paket Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_paket" value="{{old('nama_paket')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Datatable --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Paket</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Paket</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($paket as $p)
                                    <tr>
                                        <td style="color: black">{{$no++}}</td>
                                        <td style="color: black">{{$p['nama_paket']}}</td>
                                        <td>
                                            <span style="color: black">
                                                <a href="/admin-assign-paket/{{$p['id']}}" type="button" class="mr-4"><i class="fa fa-book color-info"></i></a>
                                                <a href="/admin-update-paket/{{$p['id']}}" type="button" class="mr-4"><i class="fa fa-pencil color-danger"></i></a>
                                                <a href="/admin-delete-paket/{{$p['id']}}" type="button" class="mr-4 delPaket"><i class="fa fa-close color-danger"></i></a>
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
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.delPaket').on('click',function(e){
        e.preventDefault();
        const delButton = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "This Paket will be Deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#09bf25',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete!',
            width: '600px',
            height: '20px'
            }).then((result) => {
            if (result.value) {
                document.location.href = delButton;
            }else{
                Swal.fire({
                title: 'Canceled!',
                icon: 'error',
                timer: 1300,
                showConfirmButton: false, 
            })
            }
        })
        });
    });
  </script>
@endsection