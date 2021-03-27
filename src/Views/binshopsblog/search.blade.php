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
                            @if($post && is_a($post,\BinshopsBlog\Models\BinshopsBlogPost::class))
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
                    @forelse($categories as $category)
                        <a href="{{$category->url()}}">
                            <h6>{{$category->category_name}}</h6>
                        </a>
                    @empty
                        <a href="#">
                            <h6>No Categories</h6>
                        </a>
                    @endforelse
                </div>
            </div>

            @if (config('binshopsblog.search.search_enabled') )
                @include('binshopsblog::sitewide.search_form')
            @endif

        </div>
    </div>


@endsection