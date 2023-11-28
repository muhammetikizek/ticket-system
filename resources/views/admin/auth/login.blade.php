<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body class="bg-dark-subtle vh-100 d-flex align-items-center justify-content-center">

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-3 col-md-7">
                <div class="card p-5 border-0 rounded-4 shadow">
                    <h2 class="mb-5">{{ __('Müze, Admin Panel') }}</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="mb-3">
                          <label for="emailInput" class="form-label">Email</label>
                          <input type="email" name="email" class="form-control @error('email') is-invalid @else border-secondary @enderror" id="emailInput" value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                          <label for="passwordInput" class="form-label">Şifre</label>
                          <input type="password" name="password" class="form-control @error('password') is-invalid @else border-secondary @enderror" id="passwordInput">
                        </div>
                        <div class="mb-3 form-check">
                          <input type="checkbox" class="form-check-input" id="exampleCheck1">
                          <label class="form-check-label" for="exampleCheck1">Oturum bilgilerini hatırla</label>
                        </div>
                        <button type="submit" class="btn btn-lg btn-dark text-warning w-100">Oturum aç</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
