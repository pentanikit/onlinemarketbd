@extends('frontend.layout')
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
                    <img src="./images/section left.PNG" alt="Manage Listing" class="listing-photo">
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
                    <img src="./images/section right.PNG" alt="Mission Section Image">
                </div>
            </div>
        </div>

        <!-- Vision -->
        <div class="row align-items-center mv-block g-4 py-5">
            <!-- Image left on desktop -->
            <div class="col-md-6 order-2 order-md-1 text-center">
                <div class="mv-image-wrapper">
                    <!-- replace with your vision image -->
                    <img src="./images/section right.PNG" alt="Vision Section Image">
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