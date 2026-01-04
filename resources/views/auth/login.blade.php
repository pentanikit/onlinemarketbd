<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login – Online Market BD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}" />
    <style>
        body{font-family: Arial, Helvetica, sans-serif; background:#ffffff;}
        .top-border-line{border-top:1px solid #f0f0f0;}
        .site-header{padding:12px 0 8px;}
        .logo-text{font-weight:700;font-size:24px;color:#00306b;}
        .logo-text span{color:#ff7a1a;font-weight:600;}
        .logo-icon{width:30px;height:36px;border:3px solid #00306b;border-radius:6px;border-top-width:6px;margin-right:6px;position:relative;}
        .logo-icon::before{content:"";position:absolute;width:60%;height:10px;border:3px solid #00306b;border-radius:10px;border-bottom:none;top:-11px;left:50%;transform:translateX(-50%);}
        .auth-wrap{min-height:calc(100vh - 80px); display:flex; align-items:center;}
        .auth-card{border:1px solid #e1e4ea;border-radius:6px;background:#fff;}
        .auth-title{font-weight:800;color:#111;}
        .auth-sub{font-size:13px;color:#777;}
        .btn-brand{background:#ff7a1a;border-color:#ff7a1a;color:#fff;font-weight:700;}
        .btn-brand:hover{filter:brightness(.98);color:#fff;}
        .auth-link{color:#0073bb;text-decoration:none;}
        .auth-link:hover{text-decoration:underline;}
        .form-label{font-size:13px;font-weight:700;color:#333;}
        .form-control{font-size:14px;}
        .help-text{font-size:12px;color:#777;}
    </style>
</head>

<body>
    <!-- HEADER -->
    <div class="container top-border-line">
        <header class="site-header">
            <nav class="navbar container p-0">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <div class="logo-icon"></div>
                    <div class="logo-text">Online<span>marketbd</span></div>
                </a>
            </nav>
        </header>
    </div>

    <main class="auth-wrap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-7 col-lg-5 col-xl-4">
                    <div class="auth-card p-4">
                        <div class="mb-3">
                            <h4 class="auth-title mb-1">Login</h4>
                            <div class="auth-sub">Access your dashboard and manage listings.</div>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success py-2">{{ session('success') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger py-2 mb-3">
                                <div class="fw-bold mb-1">Please fix the errors:</div>
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li class="small">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email"
                                       name="email"
                                       class="form-control"
                                       value="{{ old('email') }}"
                                       required
                                       autofocus>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Password</label>
                                <input type="password"
                                       name="password"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="d-flex justify-content-between align-items-center my-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label help-text" for="remember">Remember me</label>
                                </div>

                                {{-- If you later add a forgot route --}}
                                {{-- <a href="#" class="auth-link help-text">Forgot password?</a> --}}
                            </div>

                            <button type="submit" class="btn btn-brand w-100 py-2">
                                <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                            </button>

                            <div class="text-center mt-3 help-text">
                                Don’t have an account?
                                <a href="{{ route('register') }}" class="auth-link">Create one</a>
                            </div>
                        </form>
                    </div>

                    <div class="text-center mt-3 help-text">
                        <a href="{{ url('/') }}" class="auth-link"><i class="fa-solid fa-arrow-left me-1"></i>Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
