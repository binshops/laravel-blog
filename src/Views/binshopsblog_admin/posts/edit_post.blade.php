@extends("binshopsblog_admin::layouts.admin_layout")
@section("content")


    <h5>Admin - Editing post
        @if($post_translation->slug)
            <a target='_blank' href='{{$post_translation->url($selected_locale)}}' class='float-right btn btn-primary'>View post</a>
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

    <script>
        //multi language
        var edit_toggle_url = '{{route("binshopsblog.admin.edit_post_toggle",$post->id)}}';
        var preLang = $('#language_list').val();
        $('#language_list').change(function (){
            $("#edit-post-form").attr("method", "get");
            $('#edit-post-form').attr('action', edit_toggle_url);

            $('#selected_lang').val($('#language_list').val());
            $('#language_list').val(preLang);
            console.log($('#language_list').val())
            $('#edit-post-form').trigger('submit');
        });
    </script>

@endsection
