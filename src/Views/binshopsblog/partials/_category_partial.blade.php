@foreach($category_tree as $category)
    @if($category->categoryTranslation != null)
        <li class="category-item-wrapper">
            @php $nameChain = $nameChain .'/'. $category->categoryTranslation->slug @endphp
            <a href="{{route("binshopsblog.view_category", [$nameChain])}}">
                <span class="category-item" value='{{$category->category_id}}'>
                    {{$category->categoryTranslation->category_name}}
                     @if( count($category->siblings) > 0)
                         <ul>
                            @include("binshopsblog::partials._category_partial", [
                                'category_tree' => $category->siblings,
                                'name_chain' => $nameChain
                            ])
                        </ul>
                     @endif
                </span>
            </a>
        </li>
    @endif
@endforeach
