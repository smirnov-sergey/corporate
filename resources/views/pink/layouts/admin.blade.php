<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" class="ie" dir="ltr" lang="en-US">
<![endif]-->
<!--[if IE 7]>
<html id="ie7" class="ie" dir="ltr" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html id="ie8" class="ie" dir="ltr" lang="en-US">
<![endif]-->
<!--[if IE 9]>
<html id="ie9" class="ie" dir="ltr" lang="en-US">
<![endif]-->
<!--[if gt IE 9]>
<html class="ie" dir="ltr" lang="en-US">
<![endif]-->
<!--[if !IE]>
<html dir="ltr" lang="en-US">
<![endif]-->

<head>

    <meta charset="UTF-8"/>

    <title>{{ $title }}</title>

    <!-- [favicon] begin -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(config('settings.theme')) }}/images/favicon.ico"/>

    <!-- CSSs -->
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/css/buttons.css">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/css/cache-custom.css">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/css/custom.css">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/css/max-width-320.css">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/css/max-width-480.css">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/css/max-width-768.css">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/css/max-width-1024.css">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/css/reset.css">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/css/style-minifield.css">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/css/thickbox.css">
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/css/jquery-ui.css">

    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/css/reset.css"/>
    <!-- RESET STYLESHEET -->
    <link rel="stylesheet" type="text/css" media="all" href="{{ asset(config('settings.theme')) }}/style.css"/>
    <!-- MAIN THEME STYLESHEET -->
    <link rel="stylesheet" id="max-width-1024-css" href="{{ asset(config('settings.theme')) }}/css/max-width-1024.css"
          type="text/css" media="screen and (max-width: 1240px)"/>
    <link rel="stylesheet" id="max-width-768-css" href="{{ asset(config('settings.theme')) }}/css/max-width-768.css" type="text/css"
          media="screen and (max-width: 987px)"/>
    <link rel="stylesheet" id="max-width-480-css" href="{{ asset(config('settings.theme')) }}/css/max-width-480.css" type="text/css"
          media="screen and (max-width: 480px)"/>
    <link rel="stylesheet" id="max-width-320-css" href="{{ asset(config('settings.theme')) }}/css/max-width-320.css" type="text/css"
          media="screen and (max-width: 320px)"/>

    <!-- CSSs Plugin -->
    <link rel="stylesheet" id="thickbox-css" href="{{ asset(config('settings.theme')) }}/css/thickbox.css" type="text/css"
          media="all"/>
    <link rel="stylesheet" id="styles-minified-css" href="{{ asset(config('settings.theme')) }}/css/style-minifield.css"
          type="text/css" media="all"/>
    <link rel="stylesheet" id="buttons" href="{{ asset(config('settings.theme')) }}/css/buttons.css" type="text/css" media="all"/>
    <link rel="stylesheet" id="cache-custom-css" href="{{ asset(config('settings.theme')) }}/css/cache-custom.css" type="text/css"
          media="all"/>
    <link rel="stylesheet" id="custom-css" href="{{ asset(config('settings.theme')) }}/css/custom.css" type="text/css" media="all"/>

    <!-- FONTs -->
    <link rel="stylesheet" id="google-fonts-css"
          href="http://fonts.googleapis.com/css?family=Oswald%7CDroid+Sans%7CPlayfair+Display%7COpen+Sans+Condensed%3A300%7CRokkitt%7CShadows+Into+Light%7CAbel%7CDamion%7CMontez&amp;ver=3.4.2"
          type="text/css" media="all"/>
    <link rel='stylesheet' href='{{ asset(config('settings.theme')) }}/css/font-awesome.css' type='text/css' media='all'/>

    <!-- JAVASCRIPTs -->
    <script type="text/javascript" src="{{ asset(config('settings.theme')) }}/js/jquery.js"></script>
    <script type="text/javascript" src="{{ asset(config('settings.theme')) }}/js/jquery-ui.js"></script>
    <script type="text/javascript" src="{{ asset(config('settings.theme')) }}/js/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="{{ asset(config('settings.theme')) }}/js/bootstrap-filestyle.min.js"></script>
</head>
<!-- END HEAD -->

<!-- START BODY -->
<body class="no_js responsive stretched
            {{ (Route::currentRouteName()  == 'home')
                || (Route::currentRouteName()  == 'portfolios.index')
                || (Route::currentRouteName()  == 'portfolios.show')
                    ? 'page-template-home-php'
                    : ''
            }}
        ">

<!-- START BG SHADOW -->
<div class="bg-shadow">

    <!-- START WRAPPER -->
    <div id="wrapper" class="group">

        <!-- START HEADER -->
        <div id="header" class="group">

            <div class="group inner">

                <!-- START LOGO -->
                <div id="logo" class="group">
                    <a href="index.html" title="Pink Rio">
                        <img src="{{ asset(config('settings.theme')) }}/images/logo.png"
                             title="Pink Rio"
                             alt="Pink Rio"
                        />
                    </a>
                </div>
                <!-- END LOGO -->

                <div id="sidebar-header" class="group">
                    <div class="widget-first widget yit_text_quote">
                        <blockquote class="text-quote-quote">&#8220;The caterpillar does all the work but the butterfly
                            gets all the publicity.&#8221;
                        </blockquote>
                        <cite class="text-quote-author">George Carlin</cite>
                    </div>
                </div>
                <div class="clearer"></div>

                <hr/>

                <!-- START MAIN NAVIGATION -->
            @yield('navigation')
            <!-- END MAIN NAVIGATION -->
                <div id="menu-shadow"></div>
            </div>
        </div>
        <!-- END HEADER -->
        <!-- START PRIMARY -->
        @if(count($errors) > 0)
            <div class="box error-box">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if(session('status'))
            <div class="box success-box">
                {{ session('status') }}
            </div>
        @endif

        @if(session('error'))
            <div class="box error-box">
                {{ session('error') }}
            </div>
        @endif
        <div id="primary" class="sidebar-{{ isset($bar) ? $bar : 'no' }}">
            <div class="inner group">
                <!-- START CONTENT -->
            @yield('content')
            <!-- END CONTENT -->
                <!-- START SIDEBAR -->
            @yield('bar')
            <!-- END SIDEBAR -->
                <!-- START EXTRA CONTENT -->
                <!-- END EXTRA CONTENT -->
            </div>
        </div>
        <!-- END PRIMARY -->

        <!-- START COPYRIGHT -->
    @yield('footer')
    <!-- END COPYRIGHT -->
    </div>
    <!-- END WRAPPER -->
</div>
<!-- END BG SHADOW -->

</body>
<!-- END BODY -->
</html>