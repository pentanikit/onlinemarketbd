<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Market BD – Business Directory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <!-- Font Awesome for icons -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />

    <style>
                /* Footer */
        .site-footer {
            background-color: #0b1728;
            color: #dfe6ef;
            padding-top: 40px;
            padding-bottom: 25px;
            margin-top: 0;
        }

        .footer-logo {
            font-weight: 700;
            font-size: 22px;
            color: #ffffff;
        }

        .footer-logo span {
            color: #ffb347;
        }

        .footer-heading {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .footer-link {
            font-size: 13px;
            color: #dfe6ef;
            text-decoration: none;
            display: block;
            margin-bottom: 6px;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        .footer-small {
            font-size: 12px;
            color: #9fb0c5;
        }

        .footer-input-group .form-control {
            font-size: 13px;
            border-radius: 999px 0 0 999px;
            border: none;
        }

        .footer-input-group .btn {
            border-radius: 0 999px 999px 0;
            font-size: 13px;
            padding-inline: 16px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            margin-top: 20px;
            padding-top: 10px;
            font-size: 12px;
        }

        .footer-social a {
            color: #dfe6ef;
            margin-right: 10px;
            font-size: 16px;
        }

        .footer-social a:hover {
            color: #ffffff;
        }

        @media(max-width: 767.98px){
            .site-footer {
                text-align: center;
            }

            .footer-input-group {
                justify-content: center;
            }
        }
    </style>

@stack('styles')
</head>
<body>

@yield('pages')

<x-frontend.footer />
<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- <script>
    // Simple demo JS so the page actually has JS behaviour
    document.getElementById('searchForm').addEventListener('submit', function (e) {
        e.preventDefault();
        alert('Search is demo only on this static layout.');
    });
</script> --}}

</body>
</html>
