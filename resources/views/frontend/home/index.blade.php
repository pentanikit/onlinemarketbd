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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.04);
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
           
        }

        .mv-block {
            
        }

        .mv-title {
            font-size: 32px;
            font-weight: 700;
            
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
        <div class="container">
            <div class="hero-card">
                <div class="row align-items-center g-2">
                    <img class="mx-auto" src="{{ asset('WhatsApp Image 2025-12-21 at 6.33.46 PM.jpeg') }}" alt=""
                        srcset="">
                </div>
            </div>
        </div>
    </section>


    <!-- CATEGORY STRIP -->
    <x-frontend.category />

    @php
        $content = \App\Models\SiteContent::where('key', 'home')->first();

    @endphp

    <!-- MANAGE LISTING + ABOUT US SECTION -->
    <section class="manage-listing-section mb-3">
        <div class="container ">
            <div class="row align-items-center text-center text-md-start">
                <!-- Left image circle -->
                <div class="col-md-7 d-flex justify-content-center  mb-md-0">
                    <div class="listing-photo-wrapper">
                        <!-- replace this image with your own -->
                      
                            <img src="{{ asset('storage/' . $content->manage_image) }}" width="350" height="340" alt="Manage Listing"
                                class="listing-img img-fluid" >
                       

                    </div>
                </div>

                <!-- Right content -->
                <div class="col-md-5">
                    <h2>Manage your <span>free</span> listing.</h2>
                    <h2 class="manage-title" style="font-size:32px; font-weight:700">
                        {{ $content->manage_title }}
                    </h2>
                    <p class="manage-subtext mt-2 mb-1">
                         {!! nl2br(e($content->manage_body)) !!}
                       

                    </p>
          
                    <a href="{{ $content->manage_cta_url }}" class="btn listing-btn" style="background-color: #ff7a1a; color:white; font-weight:700;">
                        {{ $content->manage_cta_text }}
                    </a>
                    <div class="listing-call my-2">
                        call {{ $content->manage_phone }}
                    </div>
                </div>
            </div>

            <!-- About Us text -->
            <div class="my-5">
                <h3 class="about-title text-center mv-title">{{ $content->about_title }}</h3>

                <p class="about-text">
                    {!! nl2br(e($content->about_body)) !!}
                    
                </p>
            </div>



        </div>
    </section>


    <!-- MISSION & VISION SECTION -->
    {{-- <section class="mission-vision-section">
        <div class="container">

            <!-- Mission -->
            <div class="row align-items-center mv-block ">
                <div class="col-md-6">
                    <h2 class="mv-title">{{ $content->mission_title }}</h2>

                    <p class="mv-text">
                        {{ $content->mission_body }}
                    </p>
                </div>
                <div class="col-md-6 text-center">
                    <div class="mv-image-wrapper">
                        <!-- replace with your mission image -->
                        <div class="mv-image-wrapper">
                            <img src="{{ asset('storage/' . $content->mission_image) }}" width="350" height="340" alt="Mission Section Image"
                                class="mv-img img-fluid">
                        </div>

                    </div>
                </div>
            </div>

            <!-- Vision -->
            <div class="row align-items-center mv-block ">
                <!-- Image left on desktop -->
                <div class="col-md-6 order-2 order-md-1 text-center">
                    <div class="mv-image-wrapper">
                        <!-- replace with your vision image -->
                        <img src="{{ asset('storage/' . $content->vision_image) }}" width="350" height="340" class="mv-img img-fluid" alt="Vision Section Image">
                    </div>
                </div>
                <div class="col-md-6 order-1 order-md-2">
                    <h2 class="mv-title">{{ $content->vision_title }}</h2>

                    <p class="mv-text">
                        {{ $content->vision_body }}
                    </p>
                </div>
            </div>

        </div>
    </section> --}}

    <!-- FAQ SECTION -->
    <x-frontend.faq />


@endsection
