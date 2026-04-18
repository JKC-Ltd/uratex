<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Uratex - Login</title>

    <!-- Fonts -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    {{-- <div class="row">
            <div class="col-lg-8 col-md-7 col-sm-12" style="padding: 0px;">
                <div class="login-bg"></div>
            </div>
            <div class="col-lg-4 col-md-5 col-sm-12 login-content">
                <div class="login-form">
                    <img src="{{ asset('assets/images/SmartPower-logo.png') }}" class="login-logo">
                    <p>Welcome! Please enter your credentials to access your account.</p>
                    {{ $slot }}
                </div>
            </div>
        </div> --}}
    {{-- OPTION 1 --}}
    {{-- <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 login-content">
            <div class="login-form">
                <img src="{{ asset('assets/images/SmartPower-logo.png') }}" class="login-logo">
                <h2 class="sp-tagline">Innovative, effective,
                    practical and cost-efficient
                    energy solutions</h2>
                <h1>SIGN IN</h1>
                <p>Please enter your credentials to access your account.</p>
                {{ $slot }}
            </div>
        </div>
    </div> --}}
    {{-- OPTION 2 --}}
    <div class="login-container">
        <div class="row ">
            <div class="col-lg-4 col-md-4 col-sm-12 login-left-content">
                <div class="login-content">
                    
                    <img src="{{ asset('assets/images/favicon.png') }}" class="login-logo">
                    <h1>Welcome to SmartPower</h1>
                    <h3 class="sp-tagline">Innovative, effective,
                        practical and cost-efficient
                        energy solutions</h3>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 login-right-content">
                <div class="login-form">
                    <h1>SIGN IN</h1>
                    <p>Please enter your credentials to access your account.</p>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
