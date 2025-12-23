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
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #ffffff;
        }

        .top-border-line {
            border-top: 1px solid #f0f0f0;
        }

        /* Header */
        .site-header {
            padding: 18px 0 10px;
        }

        .logo-text {
            font-weight: 700;
            font-size: 26px;
            color: #00306b;
        }

        .logo-text span {
            color: #ff7a1a;
            font-weight: 600;
        }

        .logo-icon {
            width: 34px;
            height: 40px;
            border: 3px solid #00306b;
            border-radius: 6px;
            border-top-width: 6px;
            margin-right: 6px;
            position: relative;
        }

        .logo-icon::before {
            content: "";
            position: absolute;
            width: 60%;
            height: 12px;
            border: 3px solid #00306b;
            border-radius: 10px;
            border-bottom: none;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
        }

          /* Orange border */
        .custom-hamburger{
            border: 2px solid #ff7921 !important;
            border-radius: 10px;   /* you can change */
            padding: 8px 10px;     /* you can change */
        }

        /* White hamburger lines (Bootstrap uses a background-image for the icon) */
        .custom-hamburger .navbar-toggler-icon{
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255,255,255,1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .top-links a {
            font-size: 13px;
            margin-left: 14px;
            color: #333;
            text-decoration: none;
        }

        .top-links a i {
            margin-right: 5px;
        }

        .top-links a:hover {
            text-decoration: underline;
        }

        /* Search bar */
        .search-section {
            padding: 18px 0 26px;
        }

        .search-wrapper {
            border: 1px solid #e5e5e5;
            border-radius: 30px;
            background-color: #ffffff;
            padding: 6px;
            box-shadow: 0 0 8px rgba(0,0,0,0.03);
        }

        .search-wrapper .form-control,
        .search-wrapper .form-select {
            border: none;
            box-shadow: none !important;
            font-size: 14px;
        }

        .search-wrapper .input-group-text {
            background: transparent;
            border: none;
            color: #777;
        }

        .search-wrapper .divider {
            width: 1px;
            background-color: #eeeeee;
            height: 32px;
        }

        .search-btn {
            border-radius: 25px;
            font-weight: 600;
            font-size: 13px;
            padding-inline: 28px;
        }

        /* Hero */
        .hero-card {
            background-color: #ffffff;
            border: 1px solid #e5e5e5;
            padding: 15px 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.04);
        }

        .hero-left-img {
            max-width: 100%;
            height: auto;
        }

        .hero-title {
            font-size: 46px;
            line-height: 1.1;
            font-weight: 500;
            color: #333;
        }

        .hero-text {
            margin-top: 14px;
            font-size: 17px;
            color: #555;
        }

        .hero-btn {
            margin-top: 28px;
            background-color: #5ca623;
            border-color: #5ca623;
            font-weight: 600;
            padding: 10px 35px;
            border-radius: 0;
            text-transform: uppercase;
            font-size: 14px;
        }

        .hero-btn i {
            margin-left: 6px;
        }

        /* Categories strip */
        .category-strip {
            margin-top: 18px;
            margin-bottom: 40px;
        }

        .category-card {
            background-color: #ffffff;
            border: 1px solid #dcdcdc;
            border-radius: 6px;
            padding-top: 10px;
            padding-bottom: 6px;
            text-align: center;
        }

        .category-icon-wrapper {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: #000;
            margin: 0 auto 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .category-icon-wrapper i {
            color: #fff;
            font-size: 18px;
        }

        .category-label {
            font-size: 11px;
            color: #333;
        }

        /* Manage Listing + About */


        /* Mission & Vision */
        .mission-vision-section {
            padding: 20px 0 70px;
        }

        .mv-block {
            margin-bottom: 60px;
        }

        .mv-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #111;
        }

        .mv-text {
            font-size: 15px;
            line-height: 1.8;
            color: #444;
            max-width: 520px;
        }

        .mv-image-wrapper img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        /* FAQ */
        .faq-section {
            padding: 50px 0 60px;
            background-color: #f7f9fc;
        }

        .faq-title {
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 24px;
        }

        .faq-intro {
            text-align: center;
            max-width: 620px;
            margin: 0 auto 30px;
            font-size: 14px;
            color: #555;
        }

        .accordion-button {
            font-size: 15px;
        }

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
            border-top: 1px solid rgba(255,255,255,0.08);
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

        @media (max-width: 767.98px) {
            .hero-card {
                padding: 18px 14px;
            }

            .hero-title {
                font-size: 32px;
                margin-top: 16px;
            }

            .search-wrapper {
                border-radius: 18px;
                padding: 4px 8px;
            }

            .search-btn {
                width: 100%;
                margin-top: 6px;
            }

            .search-wrapper .divider {
                display: none;
            }

            .manage-title {
                font-size: 24px;
                text-align: center;
            }

            .manage-subtext {
                text-align: center;
            }

            .listing-btn,
            .listing-call {
                text-align: center;
            }

            .mv-title {
                font-size: 24px;
                text-align: center;
            }

            .mv-text {
                text-align: center;
                margin-left: auto;
                margin-right: auto;
            }

            .site-footer {
                text-align: center;
            }

            .footer-input-group {
                justify-content: center;
            }
        }

        /* small helper for custom 1-5 width on large screens */
        @media (min-width: 992px) {
            .col-lg-1-5 {
                flex: 0 0 auto;
                width: 10%;
            }
        }
    </style>
</head>
<body>

@yield('pages')


<!-- Bootstrap JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Simple demo JS so the page actually has JS behaviour
    document.getElementById('searchForm').addEventListener('submit', function (e) {
        e.preventDefault();
        alert('Search is demo only on this static layout.');
    });
</script>

</body>
</html>
