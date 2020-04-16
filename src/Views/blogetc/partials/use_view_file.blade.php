@php
    /** @var \WebDevEtc\BlogEtc\Models\Post $post */
@endphp
{{--This is used if a blog post has a 'use_view_file' value.--}}{{--It will (attempt to) load the view from /resources/views/custom_blog_posts/$use_view_file.blade.php. If that file doesn't exist, it'll show an error. --}}
@if(View::exists($post->bladeViewFile()))
    {{--view file existed, so include it.--}}
    @include('custom_blog_posts.' . $post->use_view_file, ['post' =>$post])
@else
    {{--uh oh! the view file wasn't there. Show a detailed error if user is logged in and can manage the blog, otherwise show generic error.--}}

    @can('blog-etc-admin')
        {{--is logged in + canManageBlogEtcPosts() == true, so show a detailed error--}}
        <div class="alert alert-danger">
            Custom blog post blade view file (<code>{{ $post->bladeViewFile() }}</code>) not found.
            <a href="https://webdevetc.com/laravel/packages/help-documentation/laravel-blog-package-blogetc"
               target="_blank">See Laravel Blog Package help here</a>.
        </div>
    @else
        {{--is not logged in, or User::canManageBlogEtcPosts() for current user == false--}}
        {{--show basic error message--}}
        <div class="alert alert-danger">
            Sorry, but there is an error showing that blog post. Please come back later.
        </div>
    @endif
@endif
