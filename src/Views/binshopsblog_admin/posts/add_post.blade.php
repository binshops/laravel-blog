@extends("binshopsblog_admin::layouts.admin_layout")
@section("content")


    <h5>Admin - Add post</h5>
    <p>Change language option to translate your post in different language</p>
    <form id="add-post-form" method='post' action='{{route("binshopsblog.admin.store_post")}}'  enctype="multipart/form-data" >

        @csrf
        @include("binshopsblog_admin::posts.form", [
    'post' => $post,
    'post_translation' => $post_translation
    ])
        <input id="post_id" name="post_id" type="number" value="{{$post_id}}" hidden>
        <input type='submit' name="submit_btn" class='btn btn-primary' value='Add new post' >

    </form>

    <script>
        //multi language
        var store_toggle_url = '{{route("binshopsblog.admin.store_post_toggle")}}';
        var preLang = $('#language_list').val();
        $('#language_list').change(function (){
            $('#add-post-form').attr('action', store_toggle_url);

            $('#selected_lang').val($('#language_list').val());
            $('#language_list').val(preLang);
            console.log($('#language_list').val())
            $('#add-post-form').trigger('submit');
        });
    </script>
@endsection
