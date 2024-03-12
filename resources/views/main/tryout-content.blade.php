@extends('layout.master-main')
@section('content')

<!-- Page Header Start -->
<div class="container-fluid page-header py-6 my-6 mt-0 wow">
    <div class="container text-center">
        <h1 class="display-4 text-white animated slideInDown mb-4">TRYOUT</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Category</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Courses Start -->
<div class="container-xxl py-6" style="padding: 4px">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8 wow">
                <div class="accordion col-lg-10 wow" id="accordionPanelsStayOpenExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collaps" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        TRYOUT
                    </button>
                    </h2>
                    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                    <div class="accordion-body">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-text">Question &emsp;&emsp;&emsp;&emsp;&nbsp;: <i class="bi bi-book"></i> {{$jumlah_soal_tryout}}</p>
                                <p class="card-text">Duration &emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;: <i class="bi bi-clock"></i> {{$tryout['durasi']}} Minutes</p>
                                @if($isUserAttemptTryout)
                                    <a href="/user-reattempt-tryout/{{$tryout['id']}}/{{$tryout['id_sub_course']}}" class="btn btn-primary attempt"><i class="bi bi-pencil"></i> Re-Attempt Tryout</a>
                                    <a href="/user-get-result-tryout/{{$tryout['id']}}/{{$tryout['id_sub_course']}}" class="btn btn-primary">RESULT</a>
                                @else
                                    <a href="/user-attempt-tryout/{{$tryout['id']}}/{{$tryout['id_sub_course']}}" class="btn btn-primary attempt"><i class="bi bi-pencil"></i> Attempt Tryout</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
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
            title: 'Tryout Segera Dimulai!',
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
                title: 'Tryout Dibatalkan!',
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
