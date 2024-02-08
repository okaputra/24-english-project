@extends('layout.admin.master')
@section('content')
@include('layout.script')
<div class="content-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Form Input Course</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin-input-course" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Course Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="course_name" value="{{old('course_name')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" rows="6" name="description">{{old('description')}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Sub Course</label>
                                    <div class="col-sm-10" id="disini">
                                        <button type="button" class="btn btn-primary" style="margin-bottom: 10px" id="add-form">+ Sub Course</button>
                                        <input type="text" class="form-control" name="components[]" style="margin-bottom: 10px;">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Thumbnail</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="thumbnail" accept="image/png, image/gif, image/jpeg" type="file" id="formFile">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Add Course</button>
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