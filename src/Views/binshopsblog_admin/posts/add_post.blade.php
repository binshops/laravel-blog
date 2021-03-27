@extends("BinshopsBlog_admin::layouts.admin_layout")
@section("content")


    <h5>Admin - Add post</h5>

    <form method='post' action='{{route("binshopsblog.admin.store_post")}}'  enctype="multipart/form-data" >

        @csrf
        @include("BinshopsBlog_admin::posts.form", ['post' => new \BinshopsBlog\Models\BinshopsBlogPost()])

        <input type='submit' class='btn btn-primary' value='Add new post' >

    </form>

@endsection
