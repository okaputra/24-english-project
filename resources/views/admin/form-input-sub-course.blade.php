@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Input Sub Course</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin-input-sub-course/{{$id_course}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Current Sub Course</label>
                                    <div class="col-sm-10">
                                        @foreach ($datasub as $ds)
                                            <input type="text" style="margin-bottom: 10px" class="form-control" name="pricing" value="{{$ds['sub_course']}}" readonly>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Sub Course</label>
                                    <div class="col-sm-10" id="disini">
                                        <button type="button" class="btn btn-primary" style="margin-bottom: 10px" id="add-form">+</button>
                                        <input type="text" class="form-control" name="components[]" style="margin-bottom: 10px;">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Add Sub Course</button>
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
    $(document).ready(function () {
        var dynamicForm = $('#disini');
        var addButton = $('#add-form');

        $(addButton).click(function () {
            // Validasi: Cek apakah form terakhir kosong
            var lastForm = dynamicForm.find('input:last');
            if (!lastForm.val()) {
                alert("Harap isi formulir sebelum menambahkan yang baru.");
                return;
            }

            // Tambahkan formulir input baru
            var newForm = '<input type="text" class="form-control" name="components[]" style="margin-bottom:10px;">';
            dynamicForm.append(newForm);
        });
    });
</script>


@endsection