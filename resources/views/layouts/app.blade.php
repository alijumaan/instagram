<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/earlyaccess/droidarabickufi.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.css') }}">
    @yield('style')

</head>
<body class="bg-light">
    <div class="container-fluid">
        @include('partial.header')
        <main class="py-4">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    @include('partial.flash')
                </div>
            </div>
            @yield('content')
        </main>
        @include('partial.footer')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        $(function () {
            $('#alert-message').fadeTo(2000, 500).slideUp(500, function () {
                $('#alert-message').slideUp(500);
            })
        })
    </script>
    @yield('script')
</body>
</html>
