@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Update Soal</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin-update-soal/{{$soal['id']}}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Pertanyaan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="pertanyaan" value="{{$soal['pertanyaan']}}">
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Opsi</label>
                                    <div class="col-sm-10" id="disini">
                                        <button type="button" class="btn btn-primary" style="margin-bottom: 10px" id="add-form">+ Tambah Opsi</button>
                                        <div id="opsi-container">
                                        @foreach ($opsi as $key => $o)
                                            <div class="input-group" style="margin-bottom: 10px;">
                                                <input type="text" class="form-control opsi-input" name="opsi[]" value="{{$o['opsi']}}">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <input type="radio" name="jawaban_benar[]" value="{{ $key }}" {{ $o['is_jawaban_benar'] ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                                <a href="/admin-delete-opsi/{{$o['id']}}" type="button" class="btn btn-danger remove-opsi" style="margin-left:10px">X</a>
                                            </div>
                                        @endforeach
                                        </div>
                                    </div>
                                    <label class="col-sm-2 col-form-label" style="margin-top: 20px">Jawaban Benar</label>
                                    <div class="col-sm-10" id="disini" style="margin-top: 20px;">
                                        <div id="opsi-container">
                                            @foreach ($jawaban_benar as $opsi)
                                                <div class="input-group" style="margin-bottom: 10px;">
                                                    <input type="text" class="form-control opsi-input" style="background: dodgerblue; color:white;" name="" value="{{$opsi['opsi']}}" readonly>
                                                </div>
                                            @endforeach
                                        </div>
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
        $('.remove-opsi').on('click',function(e){
        e.preventDefault();
        const delButton = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "This Opsi will be Deleted!",
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