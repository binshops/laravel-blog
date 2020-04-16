@php
    /** @var \WebDevEtc\BlogEtc\Models\Post $post */
@endphp
@can('blog-etc-admin')
    <a href="{{ $post->editUrl() }}" class="btn btn-outline-secondary btn-sm pull-right float-right">
        Edit Post
    </a>
@endcan

<h2 class="blog_title">
    {{ $post->title }}
</h2>

@if($post->subtitle)
    <h5 class="blog_subtitle">
        {{ $post->subtitle }}
    </h5>
@endif

{{ $post->imageTag('medium', false, 'd-block mx-auto') }}

<p class="blog_body_content">
    {!! $post->renderBody() !!}
</p>

<hr/>

Posted <strong>{{ $post->posted_at->diffForHumans() }}</strong>

@includeWhen($post->author, 'blogetc::partials.author', ['post'=>$post])
@includeWhen($post->categories, 'blogetc::partials.categories', ['post'=>$post])
