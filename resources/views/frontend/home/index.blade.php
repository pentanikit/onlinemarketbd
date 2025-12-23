@extends('frontend.layout')
@push('styles')
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #ffffff;
        }

        .top-border-line {
            border-top: 1px solid #f0f0f0;
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
@endpush
@section('pages')
    <!-- Header -->
<x-frontend.header />
<div class="text-center my-4">
    <h1 class="hero-title">Business Directory</h1>
    <p class="hero-text">
         Helping you find right product and service company<br>
             for your online business
    </p>
</div>


<!-- HERO SECTION -->
<section class="py-0">
    <div class="container" >
        <div class="hero-card">
            <div class="row align-items-center g-2">
                 <img class="mx-auto" src="{{ asset('WhatsApp Image 2025-12-21 at 6.33.46 PM.jpeg') }}"  alt="" srcset="">
            </div>
        </div>
    </div>
</section>


<!-- CATEGORY STRIP -->
<x-frontend.category />

<!-- MANAGE LISTING + ABOUT US SECTION -->
<section class="manage-listing-section">
    <div class="container ">
        <div class="row align-items-center text-center text-md-start mb-5 py-5">
            <!-- Left image circle -->
            <div class="col-md-7 d-flex justify-content-center mb-3 mb-md-0">
                <div class="listing-photo-wrapper">
                    <!-- replace this image with your own -->
                    <img src="{{ asset('listing.png') }}" width="640" height="440" alt="Manage Listing" class="listing-photo rounded-circle">
                </div>
            </div>

            <!-- Right content -->
            <div class="col-md-5">
                <h2 class="manage-title">
                    Manage your <span class="highlight-free">free</span> listing.
                </h2>
                <p class="manage-subtext mt-2 mb-1">
                    Update your business information in a few steps.<br>
                    Make it easy for your customers to find you on Yellowpages.
                     
                </p>
                <p class="manage-subtext">
                    <span class="new-label">New!</span> Post a job opening on your free listing.
                </p>
                <button class="btn btn-primary listing-btn">
                    Claim Your Listing
                </button>
                <div class="listing-call">
                    or call <span>1-866-794-0889</span>
                </div>
            </div>
        </div>

        <!-- About Us text -->
        <div class="py-5">
            <h3 class="about-title text-center">About Us</h3>
            <p class="about-text">
                Page layouts look better with something in each section. Web page designers, content writers,
                and layout artists use lorem ipsum, also known as placeholder copy, to distinguish which areas
                on a page will hold advertisements, editorials, and filler before the final written content and
                website designs receive client approval.
            </p>
            <p class="about-text">
                Page layouts look better with something in each section. Web page designers, content writers,
                and layout artists use lorem ipsum, also known as placeholder copy, to distinguish which areas
                on a page will hold advertisements, editorials, and filler before the final written content and
                website designs receive client approval.
            </p>
        </div>

         

    </div>
</section>


<!-- MISSION & VISION SECTION -->
<section class="mission-vision-section">
    <div class="container">

        <!-- Mission -->
        <div class="row align-items-center mv-block g-4 py-5">
            <div class="col-md-6">
                <h2 class="mv-title">Our Mission</h2>
                <p class="mv-text">
                    We’ve been around in one form or another for more than 125 years, always with one goal in
                    mind — helping small businesses compete and win.
                </p>
                <p class="mv-text">
                    We provide the technology, software and local business automation tools small business
                    owners need to better manage their time, communicate with clients, and get paid, so they
                    can take control of their business and be more successful.
                </p>
            </div>
            <div class="col-md-6 text-center">
                <div class="mv-image-wrapper">
                    <!-- replace with your mission image -->
                    <img src="{{ asset('mission.png') }}" alt="Mission Section Image">
                </div>
            </div>
        </div>

        <!-- Vision -->
        <div class="row align-items-center mv-block g-4 py-5">
            <!-- Image left on desktop -->
            <div class="col-md-6 order-2 order-md-1 text-center">
                <div class="mv-image-wrapper">
                    <!-- replace with your vision image -->
                    <img src="{{ asset('vission.png') }}" alt="Vision Section Image">
                </div>
            </div>
            <div class="col-md-6 order-1 order-md-2">
                <h2 class="mv-title">Our Vision</h2>
                <p class="mv-text">
                    We’ve been around in one form or another for more than 125 years, always with one goal in
                    mind — helping small businesses compete and win.
                </p>
                <p class="mv-text">
                    We provide the technology, software and local business automation tools small business
                    owners need to better manage their time, communicate with clients, and get paid, so they
                    can take control of their business and be more successful.
                </p>
            </div>
        </div>

    </div>
</section>

<!-- FAQ SECTION -->
<x-frontend.faq />

<!-- FOOTER -->
<x-frontend.footer />
@endsection