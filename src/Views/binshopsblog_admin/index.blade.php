@extends("binshopsblog_admin::layouts.admin_layout")
@section("content")


    <h5>Admin - Manage Blog Posts</h5>
    <div class="container">
        <div class="row">
            @forelse($posts as $post)
                <div class="card col-lg-4 m-4" style="">
                    <div class="card-body">
                        <dt class="">Author</dt>
                        <dd class="">{{$post->author_string()}}</dd>
                        <dt class="">Posted at</dt>
                        <dd class="">{{$post->posted_at}}</dd>
                        <dt class="">Is published?</dt>
                        <dd class="">
                            {!!($post->is_published ? "Yes" : '<span class="border border-danger rounded p-1">No</span>')!!}
                        </dd>
                    </div>
                </div>

                <div class="card col-lg-6 m-4" style="">
                    <div class="card-body">
                        @foreach($languages as $lang)
                            @php $translation = $post->getTranslationById($lang->id) @endphp

                            <h5 class='card-title'>{{$lang->name}}</h5>
                            @if($translation == null)
                                <a href="{{route("binshopsblog.admin.create_post", ['post_id' => $post->id, 'locale' => $lang->locale])}}" class="card-link btn btn-primary btn-sm">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                    Create translation
                                </a>
                            @endif
                            @if($translation != null)
                                <h5 class='card-title'>{{$translation->title}}</a></h5>
                                <h5 class='card-subtitle mb-2 text-muted'>{{$translation->subtitle}}</h5>
                                <a href="{{$translation->edit_url()}}" class="card-link btn btn-outline-secondary btn-sm">
                                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                    Edit Post
                                </a>
                                <a href="{{$translation->url()}}" class="card-link btn btn-outline-secondary btn-sm">
                                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                    View Post
                                </a>
                                <form onsubmit="return confirm('Are you sure you want to delete this blog post?\n You cannot undo this action!');"
                                      method='post' action='{{route("binshopsblog.admin.destroy_post", $translation->post_id)}}' class='float-right'>
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE"/>
                                    <button type='submit' class='btn btn-danger btn-sm'>
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        Delete
                                    </button>
                                </form>
                                <br>
                                <hr width=”25%” align=”right”>
                            @endif
                        @endforeach
                    </div>
                </div>
            @empty
                <div class='alert alert-warning'>No posts to show you. Why don't you add one?</div>
            @endforelse
        </div>
    </div>
@endsection
