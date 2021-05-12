@extends("binshopsblog_admin::layouts.admin_layout")
@section("content")

    @forelse ($comments as $comment)

        <div class="card m-4" >
            <div class="card-body">

                <h5 class='card-title'>


                    {{$comment->author()}} commented on:

                    @if($comment->post)
                    <a class="a-link-cart-color" href='{{$comment->post->url()}}'>{{$comment->post->title}}</a>
                        @else
                        Unknown blog post

                        @endif

                    on {{$comment->created_at}} </h5>


                <p class='m-3 p-2'>{{$comment->comment}}</p>




                @if($comment->post)

                    {{--VIEW + EDIT POST LINKS--}}
                    <a href="{{$comment->post->url()}}" class="card-link btn btn-outline-secondary"><i class="fa fa-file-text-o"
                                                                                              aria-hidden="true"></i>
                        View Post</a>
                    <a href="{{$comment->post->edit_url()}}" class="card-link btn btn-primary">
                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        Edit Post</a>


                @endif



                @if(!$comment->approved)
                    {{--APPROVE BUTTON--}}
                    <form method='post' action='{{route("binshopsblog.admin.comments.approve", $comment->id)}}' class='float-right'>
                        @csrf
                        @method("PATCH")
                        <input type='submit' class='btn btn-success btn-sm' value='Approve'/>
                    </form>
                @endif

                {{--DELETE BUTTON--}}
                <form
                        onsubmit="return confirm('Are you sure you want to delete this blog post comment?\n You cannot undo this action!');"
                        method='post' action='{{route("binshopsblog.admin.comments.delete", $comment->id)}}' class='float-right'>
                    @csrf
                    @method("DELETE")
                    <input type='submit' class='btn btn-danger btn-sm' value='Delete'/>
                </form>
            </div>
        </div>


    @empty
        <div class='alert alert-danger'>None found</div>
    @endforelse


    <div class='text-center'>
        {{$comments->appends( [] )->links()}}
    </div>

@endsection