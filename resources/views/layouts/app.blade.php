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
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-rtl.css') }}">
    @yield('style')

</head>
<body class="bg-dark">
    @include('partial.header')
    <div class="container">
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
    <script src="{{ asset('assets/js/alert-message.js') }}"></script>

    <!-- Import typeahead.js -->
    <script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>

    <script>
        $(document).ready(function() {
            let bloodhound = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '{{url("search")}}?searchName=%QUERY%',//'/user/find?q=%QUERY%',
                    wildcard: '%QUERY%'
                },
            });

            $('#search').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            }, {
                name: 'users',
                source: bloodhound,
                limit: 10,
                display: function(data) {
                    return data.name  //Input value to be set when you select a suggestion.
                },
                templates: {
                    empty: [
                        '<div class="list-group search-results-dropdown"><div class="list-group-item" style="direction: rtl; text-align: right; ">لا يوجد نتائج بحث مطابقة</div></div>'
                    ],
                    header: [
                        '<div class="list-group search-results-dropdown">'
                    ],
                    suggestion: function(data) {
                        return '<div style="font-weight:normal;direction: rtl; text-align: right; width:100%" class="list-group-item"> <a href="{{url('user_info')}}/'+data.id+'"> <img src="{{asset('images/users')}}/'+data.avatar+'" style=" margin-left: 2%; " width="35px" height="35px"/>' + data.first_name+' '+data.last_name + '</a></div></div>'
                    }
                }
            });
        });
    </script>

    @yield('script')
</body>
</html>
