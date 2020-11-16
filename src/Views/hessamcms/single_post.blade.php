@extends("layouts.app",['title'=>$post->gen_seo_title()])

@section('blog-custom-css')
    <link type="text/css" href="{{ asset('hessam-blog.css') }}" rel="stylesheet">
@endsection

@section("content")

    @if(config("hessamcms.reading_progress_bar"))
        <div id="scrollbar">
            <div id="scrollbar-bg"></div>
        </div>
    @endif

    {{--https://hessam.binshops.com/laravel/packages/hessamcms-blog-system-for-your-laravel-app/help-documentation/laravel-blog-package-hessamcms#guide_to_views--}}

    <div class='container'>
    <div class='row'>
        <div class='col-sm-12 col-md-12 col-lg-12'>

            @include("hessamcms::partials.show_errors")
            @include("hessamcms::partials.full_post_details")


            @if(config("hessamcms.comments.type_of_comments_to_show","built_in") !== 'disabled')
                <div class="" id='maincommentscontainer'>
                    <h2 class='text-center' id='hessamcmscomments'>Comments</h2>
                    @include("hessamcms::partials.show_comments")
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