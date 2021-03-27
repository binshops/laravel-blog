@extends("layouts.app",['title'=>"Saved comment"])
@section("content")

    <div class='text-center'>
        <h3>Thanks! Your comment has been saved!</h3>

        @if(!config("binshopsblog.comments.auto_approve_comments",false) )
            <p>After an admin user approves the comment, it'll appear on the site!</p>
        @endif

        <a href='{{$blog_post->url()}}' class='btn btn-primary'>Back to blog post</a>
    </div>

@endsection