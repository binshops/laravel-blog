@extends('blogetc_admin::layouts.admin_layout')
@section('title','Blog Etc Admin - Upload Images')
@section('content')
    <h5>Admin - Upload Images</h5>

    <p>You can use this to upload images.</p>

    <form method="post" action="{{ route('blogetc.admin.images.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-4 p-2">
            <label for="image_title">
                Image title
            </label>
            <small id="image_title_help" class="form-text text-muted">
                Image Title
            </small>
            <input required class="form-control" type="text" name="image_title"
                   id="image_title" aria-describedby="image_title_help">
        </div>

        <div class="form-group mb-4 p-2">
            <label for="upload">
                Upload image
            </label>
            <small id="blog_upload_help" class="form-text text-muted">
                Upload image
            </small>
            <input required class="form-control" type="file" name="upload"
                   id="upload" aria-describedby="upload_help">
        </div>

        <div class="form-group mb-4 p-2">
            <label>Upload</label>
            <input type="submit" class="btn btn-primary" value="Upload">
        </div>
    </form>
@endsection
