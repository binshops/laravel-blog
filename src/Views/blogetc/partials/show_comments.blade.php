@switch(config('blogetc.comments.type_of_comments_to_show'))
    @case(\WebDevEtc\BlogEtc\Services\CommentsService::COMMENT_TYPE_BUILT_IN)
    {{-- default - show our own comments--}}
    @include('blogetc::partials.built_in_comments')
    @include('blogetc::partials.add_comment_form')
    @break

    @case(\WebDevEtc\BlogEtc\Services\CommentsService::COMMENT_TYPE_DISQUS)
    {{--use disqus--}}
    @include('blogetc::partials.disqus_comments')
    @break


    @case(\WebDevEtc\BlogEtc\Services\CommentsService::COMMENT_TYPE_CUSTOM)
    {{--use custom - you should create the custom_comments in your vendor view dir and customise it--}}
    @include('blogetc::partials.custom_comments')
    @break

    @case(\WebDevEtc\BlogEtc\Services\CommentsService::COMMENT_TYPE_DISABLED)
    {{--comments are disabled--}}
    @break

    @default
    {{--uh oh! we have an error!--}}
    <div class="alert alert-danger">
        Invalid comment <code>type_of_comments_to_show</code> config option
    </div>
@endswitch


