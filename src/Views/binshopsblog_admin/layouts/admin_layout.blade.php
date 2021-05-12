<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Blog Admin - {{ config('app.name', 'Laravel') }}</title>


    <!-- jQuery is only used for hide(), show() and slideDown(). All other features use vanilla JS -->
    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito" crossorigin="anonymous">

    <!-- Styles -->
        <link href="{{ asset('binshopsblog_admin.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand binshops-blog-title" href="{{ route('binshopsblog.admin.index') }}">
                {{ config('app.name', 'Laravel') }} Blog Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->


                    <li class='nav-item px-2'><a class='nav-link' href='{{route("binshopsblog.index")}}'>Blog home</a></li>


                    <li class="nav-item ">
                        <a id="" class="nav-link " href="#" role="button"
                           aria-haspopup="true" aria-expanded="false" >
                            Logged in as {{ Auth::user()->name }}
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <div class='row full-width-div nav-bar-full'>
                <div class='list-group-color'>
                    @include("binshopsblog_admin::layouts.sidebar")
                    <div class=' list-group-color text-center mt-5 mb-3 text-muted binshops-version'>
                        <small><a href='https://github.com/vbinshops/laravel-blogger'>Binshops Blog</a></small>

                        <small>
                            Version 8.1.x
                        </small>
                    </div>
                </div>
                <div class='col-md-9 main-content'>

                    @if (isset($errors) && count($errors))
                        <div class="alert alert-danger">
                            <b>Sorry, but there was an error:</b>
                            <ul class='m-0'>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    {{--REPLACING THIS FILE WITH YOUR OWN LAYOUT FILE? Don't forget to include the following section!--}}

                    @if(\BinshopsBlog\Helpers::has_flashed_message())
                        <div class='alert alert-info'>
                            <h3>{{\BinshopsBlog\Helpers::pull_flashed_message() }}</h3>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </main>
</div>


@if( config("binshopsblog.use_wysiwyg") && config("binshopsblog.echo_html") && (in_array( \Request::route()->getName() ,[ 'binshopsblog.admin.create_post' , 'binshopsblog.admin.edit_post'  ])))
    <script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
    <script>
        if( typeof(CKEDITOR) !== "undefined" ) {
            CKEDITOR.replace('post_body');
        }
    </script>
@endif


</body>
</html>
