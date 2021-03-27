
<div class="col-md-6">
    <div class="blog-item">

        <div class='text-center blog-image'>
            <?=$post->image_tag("medium", true, ''); ?>
        </div>
        <div class="blog-inner-item">
            <h3 class=''><a href='{{$post->url()}}'>{{$post->title}}</a></h3>
            <h5 class=''>{{$post->subtitle}}</h5>

            @if (config('binshopsblog.show_full_text_at_list'))
                <p>{!! $post->post_body_output() !!}</p>
            @else
                <p>{!! mb_strimwidth($post->post_body_output(), 0, 400, "...") !!}</p>
            @endif

            <div class="post-details-bottom">
                <span class="light-text">Authored by: </span> {{$post->author->name}} <span class="light-text">Posted at: </span> {{date('d M Y ', strtotime($post->posted_at))}}
            </div>
            <div class='text-center'>
                <a href="{{$post->url()}}" class="btn btn-primary">View Post</a>
            </div>
        </div>
    </div>

</div>