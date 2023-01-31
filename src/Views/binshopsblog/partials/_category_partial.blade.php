@foreach($category_tree as $category)
    @php $trans =  $category->categoryTranslations->where('lang_id',$lang_id)->first();@endphp
    @if($trans != null)
        <li class="category-item-wrapper">
            @php $nameChain = $nameChain .'/'. $trans->slug @endphp

            <a href="{{ $routeWithoutLocale ? route("binshopsblog.view_category",["", $nameChain]) : route("binshopsblog.view_category",[$locale, $nameChain])}}">
                 <span class="category-item" value='{{$category->category_id}}'>
        {{$trans->category_name}}

                     @if( count($category->siblings) > 0)
                         <ul>
                 @include("binshopsblog::partials._category_partial", [
    'category_tree' => $category->siblings,
    'name_chain' => $nameChain,
    'routeWithoutLocale' => $routeWithoutLocale
    ])
                 </ul>
                     @endif
                 </span>
            </a>
        </li>
    @endif
@endforeach
