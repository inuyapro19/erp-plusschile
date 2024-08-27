

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - PlussChile</title>

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <style>
        .form-form .form-form-wrap form .field-wrapper svg.feather-eye {
            top: 46px;
        }
        .form-image .l-image {
            background-image: url({{asset('images/fondo.jpg')}});
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            background-position-x: center;
            background-position-y: center;
        }
    </style>
</head>
<body id="kt_body" class="app-blank app-blank">
<!--begin::Theme mode setup on page load-->
<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-theme-mode")) { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }</script>
<!--end::Theme mode setup on page load-->

@yield('content')

<script src="{{asset('js/app.js')}}"></script>
<!--begin::Javascript-->
<script>var hostUrl = "assets/";</script>
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Custom Javascript(used for this page only)-->
<script src="{{asset('assets/js/custom/authentication/sign-in/general.js')}}"></script>
<!--end::Custom Javascript-->
<!--end::Javascript-->
@stack('scripts')

</body>
</html>
