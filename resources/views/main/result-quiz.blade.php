@extends('layout.master-main')
@section('content')

<style>
    /* Ballon */
    #balloon-container {
    height: 1vh;
    padding: 1em;
    box-sizing: border-box;
    display: flex;
    flex-wrap: wrap;
    /* overflow: hidden; */
    z-index: -9;
    transition: opacity 500ms;
    }

    .balloon {
    height: 125px;
    width: 105px;
    border-radius: 75% 75% 70% 70%;
    position: relative;
    }

    .balloon:before {
    content: "";
    height: 75px;
    width: 1px;
    padding: 1px;
    background-color: #FDFD96;
    display: block;
    position: absolute;
    top: 125px;
    left: 0;
    right: 0;
    margin: auto;
    }

    .balloon:after {
        content: "▲";
        text-align: center;
        display: block;
        position: absolute;
        color: inherit;
        top: 120px;
        left: 0;
        right: 0;
        margin: auto;
    }

    @keyframes float {
    from {transform: translateY(100vh);
    opacity: 1;}
    to {transform: translateY(-300vh);
    opacity: 0;}
    }
</style>

<!-- Courses Start -->
<div class="container-xxl py-6" style="padding: 4px">
    @if($showCongratsEffect)
        <div id="balloon-container"></div>
    @endif
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8 wow">
                @if($showCongratsEffect)
                    <h1 class="display-6 mb-4">CONGRATULATIONS!!</h1>
                @else
                    <h1 class="display-6 mb-4">RESULT: {{$quiz['nama_quiz']}}</h1>
                @endif
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
                                        <p class="card-text" style="color: red">INCORRECT &emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;: <i class="bi bi-exclamation-circle"></i> {{$wrongAnswer}}</p>
                                        <p class="card-text" style="color: red">BLANK &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <i class="bi bi-circle"></i> {{$blankAnswerCount}}</p>
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
                                            @if ($isShowClue[$s['id']])
                                                <li class="breadcrumb-item active" aria-current="page" style="color: red; font-size:2em"><b>{{$no++}}</b></li>
                                            @else
                                                <li class="breadcrumb-item active" aria-current="page" style="font-size:2em;"><b>{{$no++}}</b></li>
                                            @endif
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
                                                            <input class="form-check-input select_ans" type="radio" name="user_answers[{{$s['id']}}][{{$index+1}}]" id="exampleRadios{{$s['id']}}_{{$index+1}}" value="{{$op['id']}}" @if(in_array($op['id'], $user_answers)) checked @endif disabled>
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
                                                <textarea rows="7" class="form-control answer_description" name="user_answers[{{$s['id']}}][{{$index+1}}]" aria-label="With textarea" disabled>{{$userAnswerDesc ? $userAnswerDesc['user_answer'] : ''}} </textarea>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($isShowClue[$s['id']])
                                        <br>
                                        <div class="alert alert-warning" role="alert">
                                            <b>Clue: {{$s['clue']}}</b>
                                        </div>
                                    @endif
                                    @if ($blankAnswer[$s['id']])
                                        <br>
                                        <div class="alert alert-danger" role="alert">
                                            <b>Not Answered!</b>
                                        </div>
                                    @endif
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

<script>
    const balloonContainer = document.getElementById("balloon-container");

    function random(num) {
        return Math.floor(Math.random() * num);
    }

    function getRandomStyles() {
    var r = random(255);
    var g = random(255);
    var b = random(255);
    var mt = random(200);
    var ml = random(50);
    var dur = random(5) + 5;
    return `
    background-color: rgba(${r},${g},${b},0.7);
    color: rgba(${r},${g},${b},0.7); 
    box-shadow: inset -7px -3px 10px rgba(${r - 10},${g - 10},${b - 10},0.7);
    margin: ${mt}px 0 0 ${ml}px;
    animation: float ${dur}s ease-in infinite
    `;
    }

    function createBalloons(num) {
    for (var i = num; i > 0; i--) {
        var balloon = document.createElement("div");
        balloon.className = "balloon";
        balloon.style.cssText = getRandomStyles();
        balloonContainer.append(balloon);
    }
    }

    function removeBalloons() {
    balloonContainer.style.opacity = 0;
    setTimeout(() => {
        balloonContainer.remove()
    }, 500)
    }

    window.addEventListener("load", () => {
    createBalloons(120)
    });

</script>
@endsection
