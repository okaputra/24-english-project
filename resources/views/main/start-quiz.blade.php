@extends('layout.master-main')
@section('content')

<style>
    .justify-between{
        margin-bottom: 20px;
    }
</style>

<!-- Courses Start -->
<div class="container-xxl py-6" style="padding: 4px">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8 wow">
                <h1 class="display-6 mb-4">{{$quiz['nama_quiz']}}</h1>
                <div class="accordion col-lg-10 wow" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                Answer Question
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-text">Question &emsp;&emsp;&emsp;&emsp;&nbsp;: <i class="bi bi-book"></i> {{$jumlah_soal}}</p>
                                        <p class="card-text">Duration &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;: <i class="bi bi-clock"></i> {{$quiz['durasi']}} Minutes</p>
                                        <p class="card-text">TIMER &emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;: <i class="bi bi-clock"></i> 01-10-40</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="POST" action="#">
                    @php
                        $no=($soal->currentpage()-1)* $soal->perpage()+1;
                    @endphp
                    @foreach ($soal as $index => $s)
                    <br>
                    <div class="form-group">
                      <div class="accordion-item">
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                          <li class="breadcrumb-item active" aria-current="page">{{$no++}}</li>
                                        </ol>
                                    </nav>
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="card-text"> 
                                                {!! $s['pertanyaan'] !!}
                                                <input type="hidden" class="form-control" id="exampleFormControlInput1" value="{{$s['id']}}" name="id_soal[]">
                                                @if($s['audio_file'])
                                                    <audio controls preload="none">
                                                        <source src="{{ asset('audio-soal/' . $s['audio_file'] . '/' . $s['audio_file'])}}" type="audio/{{ pathinfo($s['audio_file'], PATHINFO_EXTENSION) }}">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                @endif
                                            </p>
                                            @if($s['tipe'] === 'opsi')
                                                @foreach ($s->opsi as $op)
                                                    <p class="card-text">
                                                        <div class="form-check">
                                                            <input class="form-check-input select_ans" type="radio" name="user_answers[{{$index+1}}]" id="exampleRadios{{$index+1}}" value="{{$op['id']}}" @if(Session::get('user_answers') && Session::get('user_answers')[$index+1] == $op['id']) checked @endif>
                                                            <label class="form-check-label" for="exampleRadios{{$index+1}}">
                                                                {!! $op['opsi'] !!}
                                                                @if($op['audio_file'])
                                                                    <audio controls preload="none">
                                                                        <source src="{{ asset('audio-opsi/' . $op['audio_file'] . '/' . $op['audio_file'])}}" type="audio/{{ pathinfo($op['audio_file'], PATHINFO_EXTENSION) }}">
                                                                        Your browser does not support the audio element.
                                                                    </audio>
                                                                @endif
                                                            </label>
                                                        </div>
                                                    </p>
                                                @endforeach
                                            @else
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                </div>
                                                <textarea class="form-control" name="deskripsi_user_answer[]" aria-label="With textarea">@if(Session::get('deskripsi_user_answer')){{ Session::get('deskripsi_user_answer')[$index] }}@endif</textarea>
                                              </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <br>
                    @if($soal->onLastPage())
                        <button type="submit" class="btn btn-primary">Submit Answer</button>
                    @endif
                </form>
                <br>
                {{ $soal->links() }}
            </div>
        </div>
    </div>
</div>
<!-- Courses End -->

<script>
    $(document).ready(function() {

    // Ketika pengguna memilih opsi
    $(".select_ans").change(function() {
        // Ambil nilai opsi yang dipilih
        var selectedOption = $(this).val();
        // Ambil nomor indeks pertanyaan
        var questionIndex = $(this).attr('name').replace('user_answers[', '').replace(']', '');

        // Kirim data jawaban ke server dengan menyertakan token CSRF
        $.ajax({
            url: '/api/save-answer', // Ubah URL dengan URL Anda sendiri
            method: 'POST',
            data: {
                questionIndex: questionIndex,
                selectedOption: selectedOption
            },
            success: function(response) {
                console.log(response); // Tampilkan respons dari server (opsional)
                // Ubah radio button yang dipilih sesuai dengan data yang tersimpan
                var selectedOptionId = response.selectedOption; // ID opsi yang dipilih dari respons server
                $(".select_ans[name='user_answers[" + (questionIndex+1) + "]']").each(function() {
                    if ($(this).val() == selectedOptionId) {
                        $(this).prop('checked', true); // Check radio button yang sesuai dengan jawaban yang disimpan
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error(error); // Tampilkan pesan kesalahan (opsional)
            }
        });
    });
});
</script>

@endsection
