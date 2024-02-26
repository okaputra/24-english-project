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
                            <button class="accordion-button" type="button" data-bs-toggle="collaps" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                Answer Question
                            </button>
                        </h2>
                        <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                            <div class="accordion-body">
                                <div class="card">
                                    <div class="card-body">
                                        <p class="card-text">Question &emsp;&emsp;&emsp;&emsp;&nbsp;: <i class="bi bi-book"></i> {{$jumlah_soal}}</p>
                                        <p class="card-text">Duration &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;: <i class="bi bi-clock"></i> {{$quiz['durasi']}} Minutes</p>
                                        {{-- <p class="card-text">TIMER &emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;: <i class="bi bi-clock"></i></p> --}}
                                        <h1 id="timer"></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="POST" action="/user-submit-quiz/{{$quiz['id']}}/{{$id_sub_course}}" id="formJ">
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
                                                <input type="hidden" class="form-control" id="exampleFormControlInput1" value="{{$index+1}}" name="id_soal[]">
                                                <input type="hidden" class="form-control" id="exampleFormControlInput1" value="{{$currentQuiz['id']}}" name="id_attempt_quiz">
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
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                </div>
                                                <textarea class="form-control" name="user_answers[{{$s['id']}}][{{$index+1}}]" aria-label="With textarea">{{$userAnswer}}</textarea>
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
        var csrfToken = '{{ csrf_token() }}';
        $('.select_ans').change(function() {
            var formData = $('#formJ').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route("save-answer") }}',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

<script>
    function startTimer(duration) {
      var timerDisplay = document.getElementById('timer');
    
      var startTime = localStorage.getItem('startTime');
      if (!startTime) {
        startTime = Date.now();
        localStorage.setItem('startTime', startTime);
      }
    
      var timer = Math.max(duration * 60 - Math.floor((Date.now() - startTime) / 1000), 0);
    
      var interval = setInterval(function () {
        var hours = Math.floor(timer / 3600);
        var minutes = Math.floor((timer % 3600) / 60);
        var seconds = timer % 60;
    
        timerDisplay.textContent = hours + "h : " + minutes + "m : " + seconds + "s ";
    
        if (--timer < 0) {
          clearInterval(interval);
          timerDisplay.textContent = "Time's up!";
          localStorage.removeItem('startTime');
          document.getElementById('formJ').submit(); // Submit the form
        }
      }, 1000);
    }
    
    // Change the value of minutes here
    var minutes = {{$quiz['durasi']}};
    startTimer(minutes);
    
</script>

@endsection
