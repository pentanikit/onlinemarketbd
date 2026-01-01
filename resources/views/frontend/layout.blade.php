<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Online Market BD – Business Directory</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}" />
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

        @media(max-width: 767.98px) {
            .site-footer {
                text-align: center;
            }

            .footer-input-group {
                justify-content: center;
            }
        }


                /* Pagination bar wrapper */
        .list-pagination-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            /* ✅ prevents breaking on small screens */
        }

        /* Keep Laravel pagination neat */
        .list-pagination-links nav {
            margin: 0;
            /* remove default spacing */
        }

        .list-pagination-links .pagination {
            margin: 0;
            display: flex;
            gap: 6px;
            /* nicer spacing */
            flex-wrap: wrap;
            /* ✅ wrap instead of overflow */
            justify-content: flex-end;
        }

        .list-pagination-links .page-item {
            margin: 0;
        }

        .list-pagination-links .page-link {
            border-radius: 10px;
            padding: .45rem .7rem;
            line-height: 1;
        }

        /* On small screens: stack + center the pagination */
        @media (max-width: 575.98px) {
            .list-pagination-bar {
                justify-content: center;
                text-align: center;
            }

            .list-pagination-links .pagination {
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
    @stack('scripts')

</body>

</html>
