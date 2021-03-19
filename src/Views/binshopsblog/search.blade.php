@extends("layouts.app",['title'=>$title])
@section("content")

    <div class='row'>
        <div class='col-sm-12'>
            <div class="row">
                <div class="col-md-9">
                    <h2>Search Results for {{$query}}</h2>

                    @php $search_count = 0;@endphp
                    @forelse($search_results as $result)
                        @if(isset($result->indexable))
                            @php $search_count += $search_count + 1; @endphp
                            <?php $post = $result->indexable; ?>
                            @if($post && is_a($post,\BinshopsBlog\Models\BinshopsPostTranslation::class))
                                <h2>Search result #{{$search_count}}</h2>
                                @include("binshopsblog::partials.index_loop")
                            @else

                                <div class='alert alert-danger'>Unable to show this search result - unknown type</div>
                            @endif
                        @endif
                    @empty
                        <div class='alert alert-danger'>Sorry, but there were no results!</div>
                    @endforelse
                </div>
                <div class="col-md-3">
                    <h6>Blog Categories</h6>
                    <ul class="binshops-cat-hierarchy">
                        @if($categories)
                            @include("binshopsblog::partials._category_partial", [
    'category_tree' => $categories,
    'name_chain' => $nameChain = ""
    ])
                        @else
                            <span>No Categories</span>
                        @endif
                    </ul>
                </div>
            </div>

            @if (config('binshopsblog.search.search_enabled') )
                @include('binshopsblog::sitewide.search_form')
            @endif

        </div>
    </div>


@endsection
