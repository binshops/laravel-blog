@extends("layouts.app",['title'=>$title])
@section("content")

    <div class='row'>
        <div class='col-sm-12 blogetc_container'>
            @if(\Auth::check() && \Auth::user()->canManageBlogEtcPosts())
                <div class="text-center">
                        <p class='mb-1'>You are logged in as a blog admin user.
                            <br>
                            <a href='{{route("blogetc.admin.index")}}'
                               class='btn border  btn-outline-primary btn-sm '>
                                <i class="fa fa-cogs" aria-hidden="true"></i>
                                Go To Blog Admin Panel</a>
                        </p>
                </div>
            @endif

                <div class="row">
                    <div class="col-md-9">

                        @if(isset($blogetc_category) && $blogetc_category)
                            <h2 class='text-center'> {{$blogetc_category->category_name}}</h2>

                            @if($blogetc_category->category_description)
                                <p class='text-center'>{{$blogetc_category->category_description}}</p>
                            @endif

                        @endif

                        <div class="container">
                            <div class="row">
                                @forelse($posts as $post)
                                    @include("blogetc::partials.index_loop")
                                @empty
                                    <div class='alert alert-danger'>No posts</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h6>Blog Categories</h6>
                        @forelse($categories as $category)
                            <a href="{{$category->url()}}">
                                <h6>{{$category->category_name}}</h6>
                            </a>
                        @empty
                            <a href="#">
                                <h6>No Categories</h6>
                            </a>
                        @endforelse
                    </div>
                </div>

            <div class='text-center  col-sm-4 mx-auto'>
                {{$posts->appends( [] )->links()}}
            </div>
                @include("blogetc::sitewide.search_form")
        </div>
    </div>
@endsection