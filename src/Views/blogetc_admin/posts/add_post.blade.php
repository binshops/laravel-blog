@extends('blogetc_admin::layouts.admin_layout')
@section('content')
    <h5>Admin - Add post</h5>

    <form method="POST" action="{{ route('blogetc.admin.store_post') }}" enctype="multipart/form-data">
        @csrf
        @include('blogetc_admin::posts.form', ['post' => $post])
        <input type="submit" class="btn btn-primary" value="Add new post">
    </form>
@endsection
