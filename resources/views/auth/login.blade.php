<!DOCTYPE html>
<html lang="en">

<head>
    @include('inc.header')
    <!-- STYLES -->
    @include('inc.styles')
</head>

<body class="hold-transition login-page">

    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('dashboard') }}">
                <img src="dist/img/Logo.png" alt="Logo" class=" img-circle elevation-8">
                <p class="font-weight-bold text-lg text-blue "><b>Clearance Data Analytics<b></p>
            </a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg text-green">Sign in to start your session</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input id="password" type="password" placeholder="Password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mb-1">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">I forgot my password</a>
                    @endif
                </p>
                <p class="mb-0">
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
                    @endif
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->



    <!-- jQuery -->
    <script src="asset('plugins/jquery/jquery.min.js')"></script>
    <!-- Bootstrap 4 -->
    <script src="asset('plugins/bootstrap/js/bootstrap.bundle.min.js')"></script>
    <!-- AdminLTE App -->
    <script src="asset('dist/js/adminlte.min.js')"></script>

</body>

</html>