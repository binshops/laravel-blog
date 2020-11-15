{{--This is only included for backwards compatibility. It will be removed at a future stage.--}}
@if (config('hessamcms.search.search_enabled') )
    @include('hessamcms::sitewide.search_form')
@endif