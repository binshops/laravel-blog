<div class=''>
        @foreach($categories as $category)
                <a class='btn btn-outline-secondary btn-sm m-1' href='{{$category->categoryTranslations[0]->url($locale)}}'>
                        {{$category->categoryTranslations[0]->category_name}}
                </a>
        @endforeach
</div>
