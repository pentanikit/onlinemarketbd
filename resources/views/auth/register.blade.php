<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register – Online Market BD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>

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
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="auth-card p-4">
                        <div class="mb-3">
                            <h4 class="auth-title mb-1">Create Account</h4>
                            <div class="auth-sub">Register to manage your listings and profile.</div>
                        </div>

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

                        <form method="POST" action="{{ route('register.post') }}">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text"
                                           name="name"
                                           class="form-control"
                                           value="{{ old('name') }}"
                                           required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone (optional)</label>
                                    <input type="text"
                                           name="phone"
                                           class="form-control"
                                           value="{{ old('phone') }}"
                                           placeholder="e.g. 01XXXXXXXXX">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Email</label>
                                    <input type="email"
                                           name="email"
                                           class="form-control"
                                           value="{{ old('email') }}"
                                           required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password"
                                           name="password"
                                           class="form-control"
                                           required>
                                    <div class="help-text mt-1">Minimum 8 characters recommended.</div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password"
                                           name="password_confirmation"
                                           class="form-control"
                                           required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-brand w-100 py-2 mt-3">
                                <i class="fa-regular fa-user me-1"></i> Create Account
                            </button>

                            <div class="text-center mt-3 help-text">
                                Already have an account?
                                <a href="{{ route('login') }}" class="auth-link">Login</a>
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
