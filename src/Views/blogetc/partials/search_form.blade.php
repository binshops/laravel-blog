{{--This is only included for backwards compatibility. It will be removed at a future stage.--}}
@if (config('blogetc.search.search_enabled') )
    @include('blogetc::sitewide.search_form')
@endif