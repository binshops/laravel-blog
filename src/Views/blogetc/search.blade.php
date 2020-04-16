@extends("layouts.app",['title'=>$title])
@section("content")

    {{--https://webdevetc.com/laravel/packages/blogetc-blog-system-for-your-laravel-app/help-documentation/laravel-blog-package-blogetc#guide_to_views--}}

    <div class='row'>
        <div class='col-sm-12'>
            <h2>Search Results for {{$query}}</h2>

            @forelse($search_results as $result)

                <?php $post = $result->indexable; ?>
                @if($post && is_a($post,\WebDevEtc\BlogEtc\Models\BlogEtcPost::class))
                    <h2>Search result #{{$loop->count}}</h2>
                    @include("blogetc::partials.index_loop")
                @else

                    <div class='alert alert-danger'>Unable to show this search result - unknown type</div>
                @endif
            @empty
                <div class='alert alert-danger'>Sorry, but there were no results!</div>
            @endforelse


            @include("blogetc::sitewide.search_form")

        </div>
    </div>


@endsection