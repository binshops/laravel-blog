@extends("blogetc_admin::layouts.admin_layout")
@section("content")


    <h5>Admin - Add post</h5>

    <form method='post' action='{{route("blogetc.admin.store_post")}}'  enctype="multipart/form-data" >

        @csrf
        @include("blogetc_admin::posts.form", ['post' => new \WebDevEtc\BlogEtc\Models\HessamPost()])

        <input type='submit' class='btn btn-primary' value='Add new post' >

    </form>

@endsection
