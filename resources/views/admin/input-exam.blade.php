@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Create Exam</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin-assign-exam/{{$id_sub_course}}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Choose Paket</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="id_paket" id="sel1">
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
                        <h4 class="card-title">Exam Pada Category Ini</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Duration</th>
                                        <th>Paket</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($exam as $q)
                                    <tr>
                                        <td style="color: black">{{$no++}}</td>
                                        <td style="color: black">{{$q['durasi']}} Minutes</td>
                                        <td style="color: black">
                                            @php
                                                $paket = App\Models\tb_paket::find($q['id_paket']);
                                                if ($paket) {
                                                    echo $paket['nama_paket'];
                                                } else {
                                                    echo "Paket not found";
                                                }
                                            @endphp
                                        </td>
                                        <td>
                                            <span style="color: black">
                                                <a href="/admin-update-exam/{{$q['id']}}" type="button" class="mr-4"><i class="fa fa-pencil color-danger"></i></a>
                                                <a href="/admin-delete-exam/{{$q['id']}}" type="button" class="mr-4 delExam"><i class="fa fa-close color-danger"></i></a>
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
        $('.delExam').on('click',function(e){
        e.preventDefault();
        const delButton = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "This Exam will be Deleted!",
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