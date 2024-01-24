@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Tambah Soal</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin-create-soal" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Pertanyaan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="pertanyaan" value="{{ old('pertanyaan') }}">
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Opsi</label>
                                    <div class="col-sm-10" id="disini">
                                        <button type="button" class="btn btn-primary" style="margin-bottom: 10px" id="add-form">+ Tambah Opsi</button>
                                        <div id="opsi-container">
                                            <div class="input-group" style="margin-bottom: 10px;">
                                                <input type="text" class="form-control opsi-input" name="opsi[]" required>
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <input type="radio" name="jawaban_benar[]" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($dataSoal as $ds)
                                    <tr>
                                        <td style="color: black">{{$no++}}</td>
                                        <td style="color: black">{{$ds['pertanyaan']}}</td>
                                        <td>
                                            <span style="color: black">
                                                <a href="/admin-update-soal/{{$ds['id']}}" type="button" class="mr-4"><i class="fa fa-pencil color-danger"></i></a>
                                                <a href="/admin-delete-soal/{{$ds['id']}}" type="button" class="mr-4 delSub"><i class="fa fa-close color-danger"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                    </tr>
                                </tfoot> --}}
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
    $(document).ready(function () {
        var dynamicForm = $('#disini');
        var addButton = $('#add-form');
        var opsiContainer = $('#opsi-container');

        $(addButton).click(function () {
            var lastForm = opsiContainer.find('.opsi-input:last');
            if (!lastForm.val()) {
                alert("Harap isi form sebelum menambahkan yang baru.");
                return;
            }
            // Tambahkan formulir input baru beserta checkbox
            var newIndex = opsiContainer.find('.opsi-input').length;
            var newForm = '<div class="input-group" style="margin-bottom: 10px;">' +
                              '<input type="text" class="form-control opsi-input" name="opsi[]" required>' +
                              '<div class="input-group-prepend">' +
                                  '<div class="input-group-text">' +
                                      '<input type="radio" name="jawaban_benar[]" value="' + newIndex + '">' +
                                  '</div>' +
                              '</div>' +
                          '</div>';
            opsiContainer.append(newForm);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.delSub').on('click',function(e){
        e.preventDefault();
        const delButton = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "This Question will be Deleted!",
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