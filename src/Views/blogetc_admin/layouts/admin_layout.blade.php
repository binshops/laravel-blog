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
    @if(file_exists(public_path("blogetc_admin_css.css")))
        <link href="{{ asset('blogetc_admin_css.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        {{--Edited your css/app.css file? Uncomment these lines to use plain bootstrap:--}}
        {{--<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}
        {{--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">--}}
    @endif


</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }} WebDevEtc Blog Admin
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


                    <li class='nav-item px-2'><a class='nav-link' href='{{route("blogetc.index")}}'>Blog home</a></li>


                    <li class="nav-item ">
                        <a id="" class="nav-link " href="#" role="button"
                           aria-haspopup="true" aria-expanded="false" >
                            Logged in as {{ Auth::user()->name }}
                        </a>

                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">

        <div class='container'>
            <div class='row'>
                <div class='col-md-3'>
                    @include("blogetc_admin::layouts.sidebar")
                </div>
                <div class='col-md-9 '>


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

                    @if(\WebDevEtc\BlogEtc\Helpers::has_flashed_message())
                        <div class='alert alert-info'>
                            <h3>{{\WebDevEtc\BlogEtc\Helpers::pull_flashed_message() }}</h3>
                        </div>
                    @endif



                    @yield('content')
                </div>
            </div>
        </div>
    </main>
</div>

<div class='text-center mt-5 pt-5 mb-3 text-muted'>
    <small><a href='https://webdevetc.com/'>Laravel Blog Package provided by Webdevetc</a></small>
</div>


@if( config("blogetc.use_wysiwyg") && config("blogetc.echo_html") && (in_array( \Request::route()->getName() ,[ 'blogetc.admin.create_post' , 'blogetc.admin.edit_post'  ])))
    <script src="https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js"
            integrity="sha384-BpuqJd0Xizmp9PSp/NTwb/RSBCHK+rVdGWTrwcepj1ADQjNYPWT2GDfnfAr6/5dn"
            crossorigin="anonymous"></script>
    <script>
        if( typeof(CKEDITOR) !== "undefined" ) {
            CKEDITOR.replace('post_body');
        }
    </script>
@endif


</body>
</html>
