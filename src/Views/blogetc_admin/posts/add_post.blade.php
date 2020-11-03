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

    <script>
        SHOULD_AUTO_GEN_SLUG = false;

        /* Generate the slug field, if it was not touched by the user (or if it was an empty string) */
        function populate_slug_field() {

//        alert("A");
            var cat_slug = document.getElementById('blog_slug');

            if (cat_slug.value.length < 1) {
                // if the slug field is empty, make sure it auto generates
                SHOULD_AUTO_GEN_SLUG = true;
            }

            if (SHOULD_AUTO_GEN_SLUG) {
                // the slug hasn't been manually changed (or it was set above), so we should generate the slug
                // This is done in two stages - one to remove non words/spaces etc, the another to replace white space (and underscore) with a -
                cat_slug.value =document.getElementById("blog_title").value.toLowerCase()
                    .replace(/[^\w-_ ]+/g, '') // replace with nothing
                    .replace(/[_ ]+/g, '-') // replace _ and spaces with -
                    .substring(0,99); // limit str length

            }

        }

        if (document.getElementById("blog_slug").value.length < 1) {
            SHOULD_AUTO_GEN_SLUG = true;
        } else {
            SHOULD_AUTO_GEN_SLUG = false; // there is already a value in #category_slug, so lets pretend it was changed already.
        }

        //multi language
        var store_toggle_url = '{{route("blogetc.admin.store_post_toggle")}}';
        var preLang = $('#language_list').val();
        $('#language_list').change(function (){
            $('#add-post-form').attr('action', store_toggle_url);

            $('#selected_lang').val($('#language_list').val());
            $('#language_list').val(preLang);
            console.log($('#language_list').val())
            $('#add-post-form').trigger('submit');
        });
    </script>

    @if( config("blogetc.use_wysiwyg") && config("blogetc.echo_html"))
        {{--    <script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>--}}
        <script src="//cdn.ckeditor.com/4.15.0/full/ckeditor.js"></script>

        <script>
            if( typeof(CKEDITOR) !== "undefined" ) {
                CKEDITOR.replace('post_body');
            }
        </script>
    @endif

@endsection
