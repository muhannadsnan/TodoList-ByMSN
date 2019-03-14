<!DOCTYPE html>
<html>
<head>
    @include('partials.head')
</head>
<body>

    <div id="app">

        @include('partials.nav')

        <main class="master">
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="container">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>

        @include('partials.footer') <!-- with scripts -->

    </div>

    @yield('scripts')

    <script src="{{ asset('js/app.js') }}" ></script>

</body>
</html>