@props(['title'])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/dist/assets/css/components.css') }}">
</head>
<body>
    <div id="app">
        <main class="section">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                        <div class="login-brand">
                            <img src="{{ asset('stisla/dist/assets/img/stisla-fill.svg') }}" alt=""
                                width="100" height="100" class="shadow-light rounded-circle">
                            <p class="h5 mt-3 mb-0">{{ config('app.name') }}</p>
                        </div>

                        {{ $slot }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
