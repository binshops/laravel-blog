@extends("blogetc_admin::layouts.admin_layout")
@section("content")


    <h5>Admin - Add post</h5>
    <p>Change language option to translate your post in different language</p>
    <form id="add-post-form" method='post' action='{{route("blogetc.admin.store_post")}}'  enctype="multipart/form-data" >

        @csrf
        @include("blogetc_admin::posts.form", [
    'post' => $post,
    'post_translation' => $post_translation
    ])

        <input type='submit' name="submit_btn" class='btn btn-primary' value='Add new post' >

    </form>

@endsection
