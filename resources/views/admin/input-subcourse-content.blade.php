@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <div class="container-fluid">
        <a href="/admin-input-evaluasi/{{$id_sub_course}}" type="button" class="btn btn-warning" style="margin-bottom:20px;">TAMBAH EVALUASI</a>
        <br>
        <div class="row">
            <div class="col-xl-10 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Create Quiz / Category</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin-input-subcourse-content/{{$id_sub_course}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Category Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_quiz" value="{{old('nama_quiz')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Choose Paket</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="id_paket" id="sel1">
                                                <option value="" selected>NO QUIZ</option>
                                            @foreach ($paket as $p)
                                                <option value="{{$p['id']}}">{{$p['nama_paket']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Durasi (in minutes)</label>
                                    <div class="col-sm-10" id="disini">
                                        <input type="text" class="form-control" name="durasi" value="{{old('durasi')}}">
                                    </div>
                                </div>
                                <fieldset class="form-group">
                                    <div class="row">
                                        <label class="col-form-label col-sm-2 pt-0">Paid</label>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_berbayar" value="1">
                                                <label class="form-check-label">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_berbayar" value="0">
                                                <label class="form-check-label">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Learning Video</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="video" accept="video/mp4" type="file" id="formFile">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Video Thumbnail</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="video_thumbnail" accept="image/png, image/gif, image/jpeg" type="file" id="formFile">
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
                        <h4 class="card-title">Daftar Category/Quiz Pada Sub Course Ini</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Category Name</th>
                                        <th>Duration</th>
                                        <th>Video</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($quiz as $q)
                                    <tr>
                                        <td style="color: black">{{$no++}}</td>
                                        <td style="color: black">{{$q['nama_quiz']}}</td>
                                        <td style="color: black">{{$q['durasi']}} Minutes</td>
                                        <td style="color: black">
                                            <video width="320" height="240" controls poster="{{asset('/images/video-thumbnail/'. $q['video_thumbnail'] .'/'.$q['video_thumbnail'])}}">
                                                <source src="{{ asset('videos/quiz-video/' . $q['video_path'] . '/' . $q['video_path'])}}" type="video/{{ pathinfo($q['video_path'], PATHINFO_EXTENSION) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </td>
                                        <td>
                                            <span style="color: black">
                                                <a href="/admin-update-subcourse-content/{{$q['id']}}" type="button" class="mr-4"><i class="fa fa-pencil color-danger"></i></a>
                                                <a href="/admin-delete-subcourse-content/{{$q['id']}}" type="button" class="mr-4 delContentSub"><i class="fa fa-close color-danger"></i></a>
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
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
    $(document).ready(function() {
        $('.delContentSub').on('click',function(e){
        e.preventDefault();
        const delButton = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "This Quiz/Category will be Deleted!",
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