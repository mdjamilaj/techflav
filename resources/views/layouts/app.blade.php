<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Techflav Admin</title>
    <!-- Favicon -->
    <link href="{{ asset('argon') }}/img/brand/favicon.ico" rel="icon" type="image/ico">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Extra details for Live View on GitHub Pages -->

    <!-- Icons -->
    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
</head>

<body class="{{ $class ?? '' }}" style="background: #e1e1e1fa;">
    @auth()
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        @include('layouts.navbars.sidebar')
    @endauth

    <div class="main-content">
        @include('layouts.navbars.navbar')
        @yield('content')
    </div>

    {{-- @guest()
            @include('layouts.footers.guest')
        @endguest --}}

    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

    @stack('js')

    <!-- Argon JS -->
    <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
    <script>
        document.querySelector('input[list]').addEventListener('input', function(e) {
            var input = e.target,
                list = input.getAttribute('list'),
                options = document.querySelectorAll('#' + list + ' option'),
                hiddenInput = document.getElementById(input.getAttribute('id') + '-hidden'),
                inputValue = input.value;

            hiddenInput.value = inputValue;

            for (var i = 0; i < options.length; i++) {
                var option = options[i];

                if (option.innerText === inputValue) {
                    hiddenInput.value = option.getAttribute('data-value');
                    break;
                }
            }
        });
    </script>
    <script>
        // Toggle Search Form
        $(document).ready(function() {

            var currnet = "{{ url()->current() }}";
            var matching = $('.nav-link').filter(function() {
                return $(this).attr('href') == currnet
            });
            matching.addClass('bg-primary-20');


            var isactive = $(".show-test").find('.nav-link').filter(function() {
                return $(this).attr('href') == currnet
            });

            isactive.closest(".show-test").addClass('show');
            var show = isactive.closest(".show-test").attr('id');
            $("[data-value=" + show + "]").attr('aria-expanded', 'true');

        });
    </script>
</body>

</html>
