<h5>Post Categories</h5>
<ul class="nav">
    {{-- TODO replace with repo--}}
    @foreach(\WebDevEtc\BlogEtc\Models\Category::orderBy('category_name')->limit(200)->get() as $category)
        <li class="nav-item">
            <a class="nav-link" href="{{ $category->url() }}">{{ $category->category_name }}</a>
        </li>
    @endforeach
</ul>
