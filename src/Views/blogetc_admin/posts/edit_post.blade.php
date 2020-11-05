@extends("blogetc_admin::layouts.admin_layout")
@section("content")


    <h5>Admin - Editing post
        <a target='_blank' href='{{$post_translation->url()}}' class='float-right btn btn-primary'>View post</a>
    </h5>

    <form method='post' action='{{route("blogetc.admin.update_post",$post->id)}}'  enctype="multipart/form-data" >

        @csrf
        @method("patch")
        @include("blogetc_admin::posts.form", [
          'post' => $post,
          'post_translation' => $post_translation
        ])

        <input type='submit' name="submit_btn" class='btn btn-primary' value='Save Changes' >

    </form>

@endsection
