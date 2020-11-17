@foreach($category_tree as $category)
    <li>
         <span value='{{$category->category_id}}'>
        {{$category->categoryTranslations->where('lang_id', $language_id)->first()->category_name}}
        </span>
        @if( count($category->siblings) > 0)
            <ul>
                @include("hessamcms_admin::categories._category_partial", ['category_tree' => $category->siblings])
            </ul>
        @endif
    </li>
@endforeach
