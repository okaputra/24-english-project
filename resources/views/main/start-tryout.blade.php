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
                <h1 class="display-6 mb-4">TRYOUT</h1>
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
                                        <p class="card-text">Duration &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;: <i class="bi bi-clock"></i> {{$tryout['durasi']}} Minutes</p>
                                        <p class="card-text">Reattempt Allowed: {{$allowedReattempt}}X</p>
                                        {{-- <p class="card-text">TIMER &emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;: <i class="bi bi-clock"></i></p> --}}
                                        <h1 id="timer"></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="POST" action="/user-submit-tryout/{{$tryout['id']}}/{{$id_sub_course}}" id="formJT">
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
                                                <input type="hidden" class="form-control" id="exampleFormControlInput2" value="{{$currentTryout['id']}}" name="id_attempt_tryout">
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
                                                            <input class="form-check-input select_ans_tryout" type="radio" name="user_answers[{{$s['id']}}][{{$index+1}}]" id="exampleRadios{{$s['id']}}_{{$index+1}}" value="{{$op['id']}}" @if(in_array($op['id'], $user_answers)) checked @endif>
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
                                                <textarea rows="7" class="form-control answer_description_tryout" name="user_answers[{{$s['id']}}][{{$index+1}}]" aria-label="With textarea">{{$userAnswerDesc ? $userAnswerDesc['user_answer'] : ''}} </textarea>
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
                        <button type="submit" class="btn btn-primary submitTryout">Submit Tryout</button>
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
        $('.select_ans_tryout').change(function() {
            var formData = $('#formJT').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route("save-answer-tryout") }}',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    // console.log(response);
                },
                error: function(xhr, status, error) {
                    // console.error(xhr.responseText);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        var csrfToken = '{{ csrf_token() }}';
        $('.answer_description_tryout').keyup(function() {
            var formData = $('#formJT').serialize();
            $.ajax({
                type: 'POST',
                url: '{{ route("save-answer-tryout") }}',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    // console.log(response);
                },
                error: function(xhr, status, error) {
                    // console.error(xhr.responseText);
                }
            });
        });
    });
</script>

<script>
    function startTimer(duration) {
      var timerDisplay = document.getElementById('timer');
    
      var startTime = localStorage.getItem('startTimeTryout');
      if (!startTime) {
        startTime = Date.now();
        localStorage.setItem('startTimeTryout', startTime);
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
          localStorage.removeItem('startTimeTryout');
          document.getElementById('formJT').submit(); // Submit the form
        }
      }, 1000);
    }
    
    // Change the value of minutes here
    var minutes = {{$tryout['durasi']}};
    startTimer(minutes);
</script>

<script>
    $(document).ready(function() {
        $('.submitTryout').on('click',function(e){
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: "Your Answer Will Submit Immediately!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#09bf25',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!',
            width: '600px',
            height: '20px'
            }).then((result) => {
            if (result.value) {
                localStorage.removeItem('startTimeTryout');
                form.submit();
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
