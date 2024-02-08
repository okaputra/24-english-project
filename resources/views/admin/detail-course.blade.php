@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 col-xxl-6 col-lg-6 col-sm-6">
                <div class="card mb-3">
                    <img class="card-img-top img-fluid" src="{{asset('/images/course-thumbnail/'. $detail['thumbnail'] .'/'.$detail['thumbnail'])}}" alt="Card image cap">
                    <div class="card-header">
                        <h5 class="card-title">{{$detail['course_name']}}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text" style="color: black">{{$detail['components']}}</p>
                        <br>
                        <p class="card-text">{{$detail['description']}}</p>
                    </div>
                    <div class="card-footer">
                        <a href="/admin-edit-course/{{$detail['id']}}" class="card-link btn btn-outline-primary float-right">EDIT</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">SUB COURSE</h4>
                        <a href="/admin-input-sub-course/{{$detail['id']}}" class="btn btn-primary" style="margin-bottom:20px;">ADD SUB COURSE</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered verticle-middle table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th scope="col" style="color: black">No</th>
                                        <th scope="col" style="color: black">Sub Course Name</th>
                                        <th scope="col" style="color: black">Price</th>
                                        <th scope="col" style="color: black">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($sub_course as $sc)
                                        <tr>
                                            <td style="color: black">{{$no++}}</td>
                                            <td style="color: black">{{$sc['sub_course']}}</td>
                                            <td style="color: black">Rp {{number_format($sc['pricing'])}}</td>
                                            
                                            <td>
                                                <span style="color: black">
                                                    <a href="/admin-input-subcourse-content/{{$sc['id']}}" class="mr-4" data-toggle="tooltip" data-placement="top" title="Input"><i class="fa fa-file color-muted"></i> </a>
                                                    <a href="/admin-edit-subcourse/{{$sc['id']}}/{{$detail['id']}}" type="button" class="mr-4"><i class="fa fa-pencil color-danger"></i></a>
                                                    <a href="/admin-delete-subcourse/{{$sc['id']}}" type="button" class="mr-4 delSub"><i class="fa fa-close color-danger"></i></a>
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
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.delSub').on('click',function(e){
        e.preventDefault();
        const delButton = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "This Sub Course will be Deleted!",
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