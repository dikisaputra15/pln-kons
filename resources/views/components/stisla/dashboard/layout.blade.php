@props(['title'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/css/components.css') }}">
</head>
<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <x-stisla.dashboard.navbar />
            <x-stisla.dashboard.sidebar />

            <main class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>{{ $title }}</h1>
                    </div>

                    <div class="section-body">
                        {{ $slot }}
                    </div>
                </section>
            </main>

            <footer class="main-footer">
                <div class="footer-left">{{ config('app.name') }}</div>
                <div class="footer-right">Template Stisla · Muhamad Nauval Azhar</div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('stisla/dist/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/popper.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/js/stisla.js') }}"></script>
    <script src="{{ asset('stisla/dist/assets/js/scripts.js') }}"></script>
</body>
</html>
