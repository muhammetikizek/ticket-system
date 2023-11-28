<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('styles')
</head>

<body>

    @include('admin.layouts.navigation')
    @hasSection('content')
        <div class="container" id="app">
            @hasSection('title')
                <div class="row align-items-center mb-4">
                    <div class="col-md border-2">
                        <h4 class="my-auto">@yield('title')</h4>
                    </div>
                    @hasSection('options')
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end">
                                <div>
                                    @yield('options')
                                </div>
                            </div>
                        </div>
                    @endif
                </div><!-- /.row -->
            @endif
            <div class="{{ request()->routeIs('admin.dashboard.index') ?: '' }}">
                @if ($success = session()->get('success'))
                    <div class="alert alert-success bg-success-subtle border-2 mb-4" role="alert">
                        {{ $success }}
                    </div>
                @elseif ($error = session()->get('error'))
                    <div class="alert alert-danger bg-danger-subtle border-2 mb-4" role="alert">
                        {{ $error }}
                    </div>
                @endif
                @yield('content')
            </div>
            @hasSection('pagination')
                @yield('pagination')
            @endif
        </div><!-- /.container -->
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    @stack('scripts')
</body>

</html>
