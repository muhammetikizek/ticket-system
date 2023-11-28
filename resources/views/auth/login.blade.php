<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(45deg, #00151e, #002639, #004b52, #005b6e, #007a8a);
            height: 100vh;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="d-flex justify-content-center mb-5">
                    <a href="{{ url('/') }}">
                        <img src="https://media.discordapp.net/attachments/1167388098599075840/1172461882758660146/logo-white.png?ex=65606738&amp;is=654df238&amp;hm=98c8c0406eb53ad7b89466cef793ec5ec9e311617cd20bc27d4451a364d622f6&amp;=" style="height:2.3rem;width:14rem;" alt="">
                    </a>
                </div>

                <div class="card p-5 border-0 shadow rounded-4">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="post" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="emailInput" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @else border-secondary @enderror" id="emailInput" value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="passwordInput" class="form-label">Şifre</label>
                            <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @else border-secondary @enderror" id="passwordInput">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember_me" class="form-check-input" id="remember-me-check">
                            <label class="form-check-label" for="remember-me-check">Oturum bilgilerini hatırla</label>
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary w-100">Oturum aç</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
