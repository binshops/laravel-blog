@extends("layouts.app",['title'=>$post->gen_seo_title()])

@section('blog-custom-css')
    <link type="text/css" href="{{ asset('hessam-blog.css') }}" rel="stylesheet">
@endsection

@section("content")

    @if(config("blogetc.reading_progress_bar"))
        <div id="scrollbar">
            <div id="scrollbar-bg"></div>
        </div>
    @endif

    {{--https://webdevetc.com/laravel/packages/blogetc-blog-system-for-your-laravel-app/help-documentation/laravel-blog-package-blogetc#guide_to_views--}}

    <div class='container'>
    <div class='row'>
        <div class='col-sm-12 col-md-12 col-lg-12'>

            @include("blogetc::partials.show_errors")
            @include("blogetc::partials.full_post_details")


            @if(config("blogetc.comments.type_of_comments_to_show","built_in") !== 'disabled')
                <div class="" id='maincommentscontainer'>
                    <h2 class='text-center' id='blogetccomments'>Comments</h2>
                    @include("blogetc::partials.show_comments")
                </div>
            @else
                {{--Comments are disabled--}}
            @endif


        </div>
    </div>
    </div>

@endsection

@section('blog-custom-js')
    <script src="{{asset('hessam-blog.js')}}"></script>
@endsection