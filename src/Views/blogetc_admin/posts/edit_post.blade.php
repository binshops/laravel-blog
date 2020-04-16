@php
    /** @var \WebDevEtc\BlogEtc\Models\Post $post */
@endphp
@extends('blogetc_admin::layouts.admin_layout')
@section('content')
    <h5>Admin - Editing post
        <a target="_blank" href="{{ $post->url() }}" class="float-right btn btn-primary">
            View post
        </a>
    </h5>

    <form method="post" action="{{ route('blogetc.admin.update_post', $post->id) }}" enctype="multipart/form-data">

        @csrf
        @method('patch')
        @include('blogetc_admin::posts.form', ['post' => $post])

        <input type="submit" class="btn btn-primary" value="Save Changes">

    </form>
@endsection
