@php
    /** @var \WebDevEtc\BlogEtc\Models\Post[]|\Illuminate\Support\Collection $posts */
@endphp
@extends('blogetc_admin::layouts.admin_layout')
@section('content')
    <h5>Admin - Manage Blog Posts</h5>

    @forelse($posts as $post)
        <div class="card m-4">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{ $post->url() }}">
                        {{ $post->title}}
                    </a>
                </h5>
                <h5 class="card-subtitle mb-2 text-muted">{{ $post->subtitle }}</h5>
                <p class="card-text">{{ $post->html }}</p>

                {{ $post->imageTag('thumbnail', false, 'float-right') }}

                <dl>
                    <dt>Author</dt>
                    <dd>{{ $post->authorString() }}</dd>

                    <dt>Posted at</dt>
                    <dd>{{ $post->posted_at }}</dd>

                    <dt>Is published?</dt>
                    <dd>
                        @if($post->is_published)
                            Yes
                        @else
                            <span class="border border-danger rounded p-1">
                                No
                            </span>
                        @endif
                    </dd>

                    <dt>
                        Categories
                    </dt>
                    <dd>
                        @if(count($post->categories))
                            @foreach($post->categories as $category)
                                <a class="btn btn-outline-secondary btn-sm m-1" href="{{ $category->editUrl() }}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>

                                    {{ $category->category_name }}
                                </a>
                            @endforeach
                        @else
                            No Categories
                        @endif
                    </dd>
                </dl>

                @if($post->use_view_file)
                    <h5>Uses Custom View file:</h5>
                    <div class="m-2 p-1">
                        <strong>View file:</strong><br>
                        <code>{{ $post->use_view_file }}</code>
                        <br>
                        <strong>
                            Full filename:
                        </strong>
                        <br>
                        <small>
                            <code>{{ $post->fullViewFilePath() }}</code>
                        </small>

                        @if(!file_exists($post->fullViewFilePath()))
                            <div class="alert alert-danger">
                                Warning! The custom view file does not exist. Create the
                                file for this post to display correctly.
                            </div>
                        @endif

                    </div>
                @endif

                <a href="{{ $post->url() }}" class="card-link btn btn-outline-secondary">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    View Post
                </a>
                <a href="{{ $post->editUrl() }}" class="card-link btn btn-primary">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    Edit Post
                </a>
                {{-- TODO--}}
                <form
                    onsubmit="return confirm('Are you sure you want to delete this blog post?\n You cannot undo this action!');"
                    method="post" action="{{ route('blogetc.admin.destroy_post', $post->id) }}" class="float-right">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE"/>
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="alert alert-warning">
            No posts to show you. Why don't you add one?
        </div>
    @endforelse

    <div class="text-center">
        {{ $posts->links()}}
    </div>
@endsection
