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
                                        <textarea name="pertanyaan" class="summernote" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Audio (opsional)</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="audio-soal" accept="audio/*" class="">
                                    </div>
                                </div>
                            
                                <div class="form-group row" >
                                    <label class="col-sm-2 col-form-label">Tipe Soal</label>
                                    <div class="col-sm-10">
                                        <select name="tipe" id="tipeSoal" class="form-control" style="width: 300px;">
                                            <option value="deskripsi">Deskripsi</option>
                                            <option value="opsi">Opsi</option>
                                        </select>
                                    </div>
                                </div>
                            
                                <div class="form-group row" id="opsiSection">
                                    <label class="col-sm-2 col-form-label">Opsi</label>
                                    <div class="col-sm-10" id="disini">
                                        <button type="button" class="btn btn-primary" style="margin-bottom: 10px" id="add-form">+ Tambah Opsi</button>
                                        <div id="opsi-container">
                                            <div class="input-group" style="margin-bottom: 10px;">
                                                <textarea name="opsi[]" class="summernote opsi-input" id="" cols="30" rows="10"></textarea>
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <input type="radio" name="jawaban_benar[]" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Audio (opsional)</label>
                                                <div class="col-sm-10">
                                                    <input type="file" name="audio-opsi" accept="audio/*" class="">
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

                            {{-- <form action="/admin-create-soal" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Pertanyaan</label>
                                    <div class="col-sm-10">
                                        <textarea name="pertanyaan" class="summernote" id="" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                            
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Opsi</label>
                                    <div class="col-sm-10" id="disini">
                                        <button type="button" class="btn btn-primary" style="margin-bottom: 10px" id="add-form">+ Tambah Opsi</button>
                                        <div id="opsi-container">
                                            <div class="input-group" style="margin-bottom: 10px;">
                                                <textarea name="opsi[]" class="summernote opsi-input" id="" cols="30" rows="10"></textarea>
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
                            </form> --}}
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
                                        <td style="color: black">{!!$ds['pertanyaan']!!}</td>
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
    // Ambil elemen-elemen yang dibutuhkan
    const tipeSoalSelect = document.getElementById('tipeSoal');
    const opsiSection = document.getElementById('opsiSection');

    // Tambahkan event listener untuk memantau perubahan pada select
    tipeSoalSelect.addEventListener('change', function () {
        // Jika tipe soal adalah "deskripsi", sembunyikan opsiSection
        if (this.value === 'deskripsi') {
            opsiSection.style.display = 'none';
        } else {
            // Jika tipe soal adalah "opsi", tampilkan opsiSection
            opsiSection.style.display = 'flex';
        }
    });

    // Sembunyikan opsiSection saat halaman dimuat jika tipe soal awalnya adalah "deskripsi"
    if (tipeSoalSelect.value === 'deskripsi') {
        opsiSection.style.display = 'none';
    }
</script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 150,
            codeviewFilter: true,
            codeviewIframeFilter: true,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'audio']],
                ['height', ['height']]
            ],
        });
    });
</script>

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
                              '<textarea name="opsi[]" class="summernote opsi-input" id="" cols="30" rows="10"></textarea>' +
                              '<div class="input-group-prepend">' +
                                  '<div class="input-group-text">' +
                                      '<input type="radio" name="jawaban_benar[]" value="' + newIndex + '">' +
                                  '</div>' +
                              '</div>' +
                          '</div>'+
                          '<div class="form-group row">'+
                                '<label class="col-sm-2 col-form-label">Audio(opsional)</label>'+
                                '<div class="col-sm-10">'+
                                    '<input type="file" name="audio-opsi" accept="audio/*" class="">'+
                                '</div>'+
                            '</div>';
            opsiContainer.append(newForm);
            // Inisialisasi Summernote pada elemen terakhir
            opsiContainer.find('.opsi-input:last').summernote({
                height: 150,
                codeviewFilter: true,
                codeviewIframeFilter: true,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'audio']],
                    ['height', ['height']]
                ],
                callbacks: {
                    onChange: function (contents, $editable) {
                        console.log('onChange:', contents, $editable);
                    }
                }
            });
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