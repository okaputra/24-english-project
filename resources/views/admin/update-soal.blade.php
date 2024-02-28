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
                            <form action="/admin-update-soal/{{$soal['id']}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" style="color: black">Tipe soal ini</label>
                                    <div class="col-sm-10">
                                        <h5>{{$soal['tipe']}}</h5>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" style="color: black">Pertanyaan</label>
                                    <div class="col-sm-10">
                                        <textarea name="pertanyaan" class="summernote" id="" cols="30" rows="10">{!!$soal['pertanyaan']!!}</textarea>
                                        @if($soal['audio_file'])
                                            <audio controls preload="none">
                                                <source src="{{ asset('audio-soal/' . $soal['audio_file'] . '/' . $soal['audio_file'])}}" type="audio/{{ pathinfo($soal['audio_file'], PATHINFO_EXTENSION) }}">
                                                Your browser does not support the audio element.
                                            </audio>
                                            <a href="/admin-delete-audio-soal/{{$soal['id']}}" type="button" class="btn btn-danger remove-audio-soal" style="margin-left:10px; margin-top:-46px;">X</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" style="color: black">Clue</label>
                                    <div class="col-sm-10">
                                        <textarea name="clue" class="form-control" id="" cols="30" rows="10">{{$soal['clue']}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" style="color: black">Audio (opsional)</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="audio_soal" accept="audio/*" class="">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {{-- <label class="col-sm-2 col-form-label">Tipe Soal</label> --}}
                                    <div class="col-sm-10">
                                        <input type="hidden" name="tipe" class="form-control" value="{{$soal['tipe']}}" readonly>
                                    </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tipe Soal</label>
                                    <div class="col-sm-10">
                                        <select name="tipe" id="tipeSoal" class="form-control" style="width: 300px;">
                                            <option value="deskripsi" {{ $soal['tipe'] === 'deskripsi' ? 'selected' : '' }}>Deskripsi</option>
                                            <option value="opsi" {{ $soal['tipe'] === 'opsi' ? 'selected' : '' }}>Opsi</option>
                                        </select>
                                    </div>
                                </div> --}}
                                
                                <div class="form-group row" id="opsiSection" style="{{ $soal['tipe'] === 'deskripsi' ? 'display: none;' : '' }}">
                                    <label class="col-sm-2 col-form-label" style="color: black">Opsi</label>
                                    <div class="col-sm-10" id="disini">
                                        <button type="button" class="btn btn-primary" style="margin-bottom: 10px" id="add-form">+ Tambah Opsi</button>
                                        <div id="opsi-container">
                                            @if($soal['tipe'] === 'opsi')
                                                @foreach ($opsi as $key => $o)
                                                    <div class="input-group" style="margin-bottom: 10px;">
                                                        <textarea name="opsi[]" class="summernote opsi-input" id="" cols="30" rows="10">{!! $o['opsi'] !!}</textarea>
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">
                                                                <input type="radio" name="jawaban_benar[]" value="{{ $key }}" {{ $o['is_jawaban_benar'] ? 'checked' : '' }}>
                                                            </div>
                                                        </div>
                                                        <a href="/admin-delete-opsi/{{$o['id']}}" type="button" class="btn btn-danger remove-opsi" style="margin-left:10px">X</a>
                                                        @if($o['audio_file'])
                                                            <audio controls preload="none" data-opsi-id="{{ $key }}" data-audio-opsi-id="{{ $o['id'] }}">
                                                                <source src="{{ asset('audio-opsi/' . $o['audio_file'] . '/' . $o['audio_file'])}}" type="audio/{{ pathinfo($o['audio_file'], PATHINFO_EXTENSION) }}">
                                                                Your browser does not support the audio element.
                                                            </audio>
                                                            <a href="/admin-delete-audio-opsi/{{$o['id']}}" type="button" class="btn btn-danger remove-audio-opsi" style="margin-left:10px; margin-top:20px;">X</a>
                                                        @endif
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-2 col-form-label" style="color: black">Audio (opsional)</label>
                                                        <div class="col-sm-10">
                                                            <input type="file" name="audio_opsi[]" accept="audio/*" class="" data-audio-opsi-id="{{ $o['id'] }}">
                                                            <input type="hidden" name="audio_opsi_id[{{ $key }}]" value="{{ $key }}">
                                                        </div>
                                                    </div>
                                                    <br>
                                                @endforeach
                                            @endif
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
    const tipeSoalSelect = document.getElementById('tipeSoal');
    const opsiSection = document.getElementById('opsiSection');
    const opsiContainer = document.getElementById('opsi-container');
    const addButton = document.getElementById('add-form');

    // Tambahkan event listener untuk memantau perubahan pada select
    tipeSoalSelect.addEventListener('change', function () {
        if (this.value === 'deskripsi') {
            opsiSection.style.display = 'none';
        } else {
            opsiSection.style.display = 'flex';

            // Hapus event listener sebelumnya dari tombol tambah
            addButton.removeEventListener('click', tambahFormInputOpsi);

            // Tambahkan event listener baru untuk tombol tambah
            addButton.addEventListener('click', tambahFormInputOpsi);

            // Jika soal awalnya adalah "deskripsi", tambahkan satu form input opsi kosong
            if ({{ $soal['tipe'] === 'deskripsi' ? 'true' : 'false' }}) {
                tambahFormInputOpsi();
            }
        }
    });

    if (tipeSoalSelect.value === 'deskripsi') {
        opsiSection.style.display = 'none';
    }

    function tambahFormInputOpsi() {
        const divInputGroup = document.createElement('div');
        divInputGroup.className = 'input-group';
        divInputGroup.style.marginBottom = '10px';

        const textareaOpsi = document.createElement('textarea');
        textareaOpsi.name = 'opsi[]';
        textareaOpsi.className = 'summernote opsi-input';
        textareaOpsi.cols = '30';
        textareaOpsi.rows = '10';

        const divInputGroupPrepend = document.createElement('div');
        divInputGroupPrepend.className = 'input-group-prepend';

        const divInputGroupText = document.createElement('div');
        divInputGroupText.className = 'input-group-text';

        const inputRadio = document.createElement('input');
        inputRadio.type = 'radio';
        inputRadio.name = 'jawaban_benar[]';
        inputRadio.value = '0';

        divInputGroupText.appendChild(inputRadio);
        divInputGroupPrepend.appendChild(divInputGroupText);
        divInputGroup.appendChild(textareaOpsi);
        divInputGroup.appendChild(divInputGroupPrepend);

        // Tambahkan input file audio
        const audioFormGroup = document.createElement('div');
        audioFormGroup.className = 'form-group row';

        const labelAudio = document.createElement('label');
        labelAudio.className = 'col-sm-2 col-form-label';
        labelAudio.textContent = 'Audio (opsional)';

        const divAudioCol = document.createElement('div');
        divAudioCol.className = 'col-sm-10';

        const inputAudio = document.createElement('input');
        inputAudio.type = 'file';
        inputAudio.name = 'audio_opsi[]';
        inputAudio.accept = 'audio/*';
        inputAudio.className = '';

        divAudioCol.appendChild(inputAudio);
        audioFormGroup.appendChild(labelAudio);
        audioFormGroup.appendChild(divAudioCol);

        // Tambahkan ke kontainer
        opsiContainer.appendChild(divInputGroup);
        opsiContainer.appendChild(audioFormGroup);

        // Inisialisasi Summernote pada elemen terakhir
        $('.summernote').summernote({
            height: 150,
            codeviewFilter: true,
            codeviewIframeFilter: true,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['height', ['height']]
            ],
        });

        // Hapus event listener dari tombol tambah untuk menghindari penambahan berulang
        addButton.removeEventListener('click', tambahFormInputOpsi);
    }
</script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 150,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
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
                                    '<input type="file" name="audio_opsi['+ newIndex +']" accept="audio/*" class="">'+
                                    '<input type="hidden" name="audio_opsi_id[]">'+
                                '</div>'+
                            '</div>';
            opsiContainer.append(newForm);
              // Inisialisasi Summernote pada elemen terakhir
              opsiContainer.find('.opsi-input:last').summernote({
                height: 150,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
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

<script>
    $(document).ready(function() {
        $('.remove-audio-soal').on('click',function(e){
        e.preventDefault();
        const delButton = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "This Audio will be Deleted!",
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

<script>
    $(document).ready(function() {
        $('.remove-audio-opsi').on('click',function(e){
        e.preventDefault();
        const delButton = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "This Audio Opsi will be Deleted!",
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