@foreach($category_tree as $category)
    @php $trans =  $category->categoryTranslations->where('lang_id',$lang_id)->first();@endphp
    @if($trans != null)
        <li class="category-item-wrapper">
         <span class="category-item" value='{{$category->category_id}}'>
        {{$trans->category_name}}

             @if( count($category->siblings) > 0)
                 <ul>
                 @include("hessamcms::partials._category_partial", ['category_tree' => $category->siblings])
                 </ul>
             @endif
    </span>
        </li>
    @endif
@endforeach
