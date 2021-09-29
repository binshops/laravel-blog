@extends("binshopsblog_admin::layouts.admin_layout")
@section("content")


    <h5>Admin - Editing post
        @if($post_translation->slug)
            <a target='_blank' href='{{$post_translation->url()}}' class='float-right btn btn-primary'>View post</a>
        @endif
    </h5>

    <form id="edit-post-form" method='post' action='{{route("binshopsblog.admin.update_post",$post->id)}}'  enctype="multipart/form-data" >

        <p>
            To apply changes, click save changes for each language.
        </p>

        @csrf
        @method("patch")
        @include("binshopsblog_admin::posts.form", [
          'post' => $post,
          'post_translation' => $post_translation
        ])

        <input type='submit' name="submit_btn" class='btn btn-primary' value='Save Changes' >

    </form>
@endsection
