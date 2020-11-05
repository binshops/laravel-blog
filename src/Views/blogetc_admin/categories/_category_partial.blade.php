@foreach($category_tree as $category)
    <li class="category-item-wrapper">
         <span class="category-item" value='{{$category->category_id}}'>
        {{$category->categoryTranslations->where('lang_id',1)->first()->category_name}}

             @if( count($category->siblings) > 0)
                 <ul>
                 @include("blogetc_admin::categories._category_partial", ['category_tree' => $category->siblings])
                 </ul>
             @endif
    </span>
    </li>
@endforeach
