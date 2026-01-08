<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Seller Login</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        .sa-body{
  background: #f6f8fb;
  font-family: "Trebuchet MS", Arial, sans-serif;
}

.sa-card{
  background: #fff;
  border: 1px solid #e9eef6;
  border-radius: 16px;
  padding: 22px;
  box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
}

.sa-brand{
  font-weight: 900;
  letter-spacing: .3px;
  color: #111;
}

.sa-title{
  font-size: 22px;
  font-weight: 900;
  color: #111;
  line-height: 1.1;
}

.sa-subtitle{
  color: #667;
  font-size: 13px;
}

.sa-label{
  font-size: 13px;
  font-weight: 700;
  color: #334;
}

.sa-input{
  border-radius: 12px;
  padding: 10px 12px;
  border: 1px solid #e6eaf2;
}

.sa-input:focus{
  box-shadow: none;
  border-color: #111;
}

.sa-btn{
  border-radius: 12px;
  padding: 10px 12px;
  font-weight: 800;
}

.sa-link{
  color: #111;
  text-decoration: none;
  font-weight: 700;
}

.sa-link:hover{
  text-decoration: underline;
}

.sa-foot{
  opacity: .9;
}

@media (max-width: 576px){
  .sa-card{ padding: 18px; }
  .sa-title{ font-size: 20px; }
}

    </style>
</head>
<body class="sa-body">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">

            <div class="sa-card">
                <div class="sa-brand mb-2">Seller Portal</div>
                <div class="sa-title">Login to your shop</div>
                <div class="sa-subtitle mb-4">Use your seller account email & password.</div>

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li class="small">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}" class="sa-form">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label sa-label">Email</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control sa-input"
                               placeholder="seller@email.com"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label sa-label">Password</label>
                        <input type="password"
                               name="password"
                               class="form-control sa-input"
                               placeholder="••••••••"
                               required>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label small" for="remember">Remember me</label>
                        </div>

                        <!-- If you have password reset, link it here -->
                        <a href="#" class="sa-link small">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 sa-btn">
                        Login
                    </button>

                    <div class="text-center mt-3">
                        <a class="sa-link small" href="{{ url('/') }}">← Back to website</a>
                    </div>
                </form>
            </div>

            <div class="text-center mt-3 sa-foot">
                <span class="small text-muted">Bangladesh-ready • Currency: BDT</span>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
