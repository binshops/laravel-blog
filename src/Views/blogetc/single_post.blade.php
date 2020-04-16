@php
/** @var \WebDevEtc\BlogEtc\Models\Post $post */
@endphp
@extends('layouts.app',['title' => $post->genSeoTitle() ])
@section('content')
    {{--https://webdevetc.com/laravel/packages/blogetc-blog-system-for-your-laravel-app/help-documentation/laravel-blog-package-blogetc#guide_to_views--}}

    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                @include('blogetc::partials.show_errors')
                @include('blogetc::partials.full_post_details')

                @if(config('blogetc.comments.type_of_comments_to_show') !== \WebDevEtc\BlogEtc\Services\CommentsService::COMMENT_TYPE_DISABLED)
                    <div id="maincommentscontainer">
                        <h2 class="text-center">
                            Comments
                        </h2>
                        @include('blogetc::partials.show_comments')
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
