<!doctype html>
<html lang="en">

<head>
    @include('includes.head')
    @isset($importedLinks)
        {{ $importedLinks }}
    @endisset
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            {{-- <img class="" src="{{ asset('assets/images/siix-logo.png')}}" alt="Logo" width="200"> --}}
            <img src="{{ asset('assets/images/loader.gif')}}" alt="Loader" width="100">
        </div>
        @include('includes.navigation')
        @include('includes.aside')

        @isset($content)
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">{{ $pageTitle ?? '' }}</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    @if (!request()->routeIs('dashboard')) 
                                        <li class="breadcrumb-item "><a href="{{ route('dashboard') }}">Home</a></li>
                                        <li class="breadcrumb-item active">{{ $pageTitle ?? '' }}</li>
                                    @endif
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <section class="content">
                    <div class="container-fluid">
                        {{ $content }}
                    </div>
                </section>
            @endisset
        </div>
            @include('includes.footer')
            @include('includes.script')
            {{-- @isset($importedScripts)
                {{ $importedScripts }}
            @endisset --}}
            @yield('scripts')
        
</body>

</html>
