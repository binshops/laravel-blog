@extends("binshopsblog_admin::layouts.admin_layout")
@section("content")


    <h5>Admin - Manage Blog Posts</h5>

    @forelse($post_translations as $post)
        <div class="card m-4" style="">
            <div class="card-body">
                <h5 class='card-title'><a class="a-link-cart-color" href='{{$post->url(app('request')->get('locale'))}}'>{{$post->title}}</a></h5>
                <h5 class='card-subtitle mb-2 text-muted'>{{$post->subtitle}}</h5>
                <p class="card-text">{{$post->html}}</p>

                <?=$post->image_tag("thumbnail", false, "float-right");?>

                <dl class="">
                    <dt class="">Author</dt>
                    <dd class="">{{$post->post->author_string()}}</dd>
                    <dt class="">Posted at</dt>
                    <dd class="">{{$post->post->posted_at}}</dd>


                    <dt class="">Is published?</dt>
                    <dd class="">

                        {!!($post->post->is_published ? "Yes" : '<span class="border border-danger rounded p-1">No</span>')!!}

                    </dd>

                    <dt class="">Categories</dt>
                    <dd class="">
                        @if(count($post->post->categories))
                            @foreach($post->post->categories as $category)
                                <a class='btn btn-outline-secondary btn-sm m-1' href='{{$category->categoryTranslations->where('lang_id' , $language_id)->first()->edit_url()}}'>
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>

                                    {{$category->categoryTranslations->where('lang_id' , $language_id)->first()->category_name}}
                                </a>
                            @endforeach
                        @else No Categories
                        @endif

                    </dd>
                </dl>


                @if($post->use_view_file)
                    <h5>Uses Custom Viewfile:</h5>
                    <div class="m-2 p-1">
                        <strong>View file:</strong><br>
                        <code>{{$post->use_view_file}}</code>

                        <?php

                        $viewfile = resource_path("views/custom_blog_posts/" . $post->use_view_file . ".blade.php");


                        ?>
                        <br>
                        <strong>Full filename:</strong>
                        <br>
                        <small>
                            <code>{{$viewfile}}</code>
                        </small>

                        @if(!file_exists($viewfile))
                            <div class='alert alert-danger'>Warning! The custom view file does not exist. Create the
                                file for this post to display correctly.
                            </div>
                        @endif

                    </div>
                @endif


                <a href="{{$post->url(app('request')->get('locale'))}}" class="card-link btn btn-outline-secondary"><i class="fa fa-file-text-o"
                                                                                                                       aria-hidden="true"></i>
                    View Post</a>
                <a href="{{$post->edit_url()}}" class="card-link btn btn-primary">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    Edit Post</a>
                <form onsubmit="return confirm('Are you sure you want to delete this blog post?\n You cannot undo this action!');"
                      method='post' action='{{route("binshopsblog.admin.destroy_post", $post->post_id)}}' class='float-right'>
                    @csrf
                    <input name="_method" type="hidden" value="DELETE"/>
                    <button type='submit' class='btn btn-danger btn-sm'>
                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class='alert alert-warning'>No posts to show you. Why don't you add one?</div>
    @endforelse

    {{--    <div class='text-center'>--}}
    {{--        {{$posts->appends( [] )->links()}}--}}
    {{--    </div>--}}

@endsection
