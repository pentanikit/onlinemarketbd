    <div style="background-color: #0b1728; color: white;">
        @php
            $content = \App\Models\SiteContent::where('key', 'home')->first();
        @endphp
        <!-- HEADER -->
        <div class="container ">
            <header class="site-header">
                <nav class="navbar navbar-expand-md container p-0">
                    <!-- Logo -->
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('clientHome') }}">
                        {{-- <div class="logo-icon"></div>
                        <div class="logo-text">
                            Online<span>marketbd</span>
                        </div> --}}
                        <img src="{{ asset('storage').'/'.$content->logo_image }}" width="220" height="60" alt="" srcset="">
                    </a>
    
                    <!-- Hamburger (mobile only) -->
                    <button class="navbar-toggler d-block d-md-none border-0  custom-hamburger" type="button" data-bs-toggle="offcanvas" style="color: #ff7921"
                        data-bs-target="#mainOffcanvas" aria-controls="mainOffcanvas" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
    
                    <!-- Desktop menu -->
                    <div class="ms-auto top-links d-none d-md-flex align-items-center" >
                        <a href="#" style="color: white;"><i class="fa-regular fa-user"></i>About Us</a>
                        <a href="#" style="color: white;"><i class="fa-solid fa-bullseye"></i>Mission</a>
                        <a href="#" style="color: white;"><i class="fa-regular fa-circle-dot"></i>Vission</a>
                    </div>
                </nav>
            </header>
        </div>
        <!-- OFFCANVAS MENU (MOBILE) -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="mainOffcanvas" aria-labelledby="mainOffcanvasLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="mainOffcanvasLabel">Menu</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav">
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#"><i class="fa-regular fa-user me-2"></i>About Us</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#"><i class="fa-solid fa-bullseye me-2"></i>Mission</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="#"><i class="fa-regular fa-circle-dot me-2"></i>Vission</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- SEARCH BAR -->
        <section class="search-section">
            <div class="container">
                <form id="searchForm" action="{{ route('frontend.search') }}" method="GET" >
                    @csrf
                    <div class="search-wrapper d-flex flex-column flex-md-row align-items-stretch">
                        <!-- Business search -->
                        <div class="flex-grow-1 d-flex align-items-center mb-2 mb-md-0">
                            <span class="input-group-text ps-3">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" class="form-control" name="q" value=""
                               placeholder="Find Now">
                        </div>
    
                        <div class="divider d-none d-md-block mx-2"></div>
    
                        <!-- Location -->
                        <div class="flex-grow-0 flex-md-grow-0 d-flex align-items-center mb-2 mb-md-0 mx-md-2">
                            <span class="input-group-text ps-3">
                                <i class="fa-solid fa-location-dot"></i>
                            </span>
                            <input type="text" name="where" class="form-control" value="" placeholder="Where?">
                        </div>
    
                        <div class="divider d-none d-md-block mx-2"></div>
    
                        <!-- Button -->
                        <div class="d-flex align-items-center justify-content-md-end justify-content-center ms-md-auto">
                            <button type="submit" class="btn btn-dark search-btn" style="background-color: #ff7921;">
                                FIND
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>


    <style>
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
    </style>