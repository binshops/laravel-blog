<h5>Recent Posts</h5>
<ul class="nav">
    @foreach(\WebDevEtc\BlogEtc\Models\BlogEtcPost::where('is_published', '=', 1)->where('posted_at', '<', Carbon\Carbon::now()->format('Y-m-d H:i:s'))->orderBy("posted_at","desc")->limit(3)->get() as $post)
        <li class="nav-item">
            <a class='nav-link' href='{{$post->url()}}'>{{$post->title}}</a>
        </li>
    @endforeach
</ul>