@extends("binshopsblog_admin::layouts.admin_layout")
@section("content")


    <h5>Admin - Upload Images</h5>

    <p>Upload was successful.</p>

    @forelse($images as $image)

        <div>

            <h4>{{$image['filename']}}</h4>
            <h6>
                <small>{{$image['w'] . "x" . $image['h']}}</small>
            </h6>

            <a href='{{asset(     config("binshopsblog.blog_upload_dir") . "/". $image['filename'])}}' target='_blank'>
                <img src='{{asset(     config("binshopsblog.blog_upload_dir") . "/". $image['filename'])}}'
                     style='max-width:400px; height: auto;'>
            </a>
            <input type='text' readonly='readonly' class='form-control' value='{{asset(     config("binshopsblog.blog_upload_dir") . "/". $image['filename'])}}'>
            <input type='text' readonly='readonly' class='form-control' value='{{"<img src='".asset(     config("binshopsblog.blog_upload_dir") . "/". $image['filename'])."' alt='' >"}}'>


        </div>

    @empty
        <div class='alert alert-danger'>No image was processed</div>
    @endforelse



@endsection