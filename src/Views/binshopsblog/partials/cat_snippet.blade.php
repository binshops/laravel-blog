@forelse($category->siblings as $category2)
    <a href="{{$category2->url()}}">
        <h6 style="padding-left: 20px" class="cat2">{{$category2->category_name}}</h6>
    </a>
    @forelse($category2->siblings as $category3)
        <a href="{{$category3->url()}}">
            <h6 style="padding-left: 40px" class="cat3">{{$category3->category_name}}</h6>
        </a>
    @empty @endforelse
@empty @endforelse
