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
                <h1 class="display-6 mb-4">RESULT: {{$quiz['nama_quiz']}}</h1>
                <div class="accordion col-lg-10 wow" id="accordionPanelsStayOpenExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collaps" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                RESULT
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-text">Question &emsp;&emsp;&emsp;&emsp;&nbsp;: <i class="bi bi-book"></i> {{$jumlah_soal}}</p>
                                        <p class="card-text">Duration &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;: <i class="bi bi-clock"></i> {{$quiz['durasi']}} Minutes</p>
                                        <p class="card-text" style="color: green">CORRECT &emsp;&emsp;&emsp;&emsp; : <i class="bi bi-check"></i> {{$correctAnswer}}</p>
                                        <p class="card-text" style="color: red">WRONG &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;: <i class="bi bi-exclamation-circle"></i> {{$wrongAnswer}}</p>
                                        <a href="/user-reattempt-quiz/{{$quiz['id']}}/{{$quiz['id_sub_course']}}" class="btn btn-primary attempt"><i class="bi bi-pencil"></i> Re-Attempt Quiz</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="POST" action="#" id="formJ">
                    @csrf
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
                                                            <input class="form-check-input select_ans" type="radio" name="user_answers[{{$s['id']}}][{{$index+1}}]" id="exampleRadios{{$s['id']}}_{{$index+1}}" value="{{$op['id']}}" @if(in_array($op['id'], $user_answers)) checked @endif>
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
                                            @php
                                                // Find the user answer for this question
                                                $userAnswerDesc = $user_answers_desc->where('id_question', $s['id'])->first();
                                            @endphp
                                            <div class="input-group">
                                                <textarea rows="7" class="form-control answer_description" name="user_answers[{{$s['id']}}][{{$index+1}}]" aria-label="With textarea">{{$userAnswerDesc ? $userAnswerDesc['user_answer'] : ''}} </textarea>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
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
        $('.attempt').on('click',function(e){
        e.preventDefault();
        const attemptButton = $(this).attr('href');
        Swal.fire({
            title: 'Quiz Segera Dimulai!',
            text: "Jangan Tutup Halaman Browser Anda",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#09bf25',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Mulai!',
            width: '600px',
            height: '20px'
            }).then((result) => {
            if (result.value) {
                document.location.href = attemptButton;
            }else{
                Swal.fire({
                title: 'Quiz Dibatalkan!',
                icon: 'warning',
                timer: 1300,
                showConfirmButton: false, 
            })
            }
        })
        });
    });
</script>
@endsection
