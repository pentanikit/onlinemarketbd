    <div style="background-color: #0b1728; color: white;">
        <!-- HEADER -->
        <div class="container ">
            <header class="site-header">
                <nav class="navbar navbar-expand-md container p-0">
                    <!-- Logo -->
                    <a class="navbar-brand d-flex align-items-center" href="#">
                        {{-- <div class="logo-icon"></div>
                        <div class="logo-text">
                            Online<span>marketbd</span>
                        </div> --}}
                        <img src="{{ asset('Online-Market-BD-Logo.png') }}" width="220" height="60" alt="" srcset="">
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
                <form id="searchForm">
                    <div class="search-wrapper d-flex flex-column flex-md-row align-items-stretch">
                        <!-- Business search -->
                        <div class="flex-grow-1 d-flex align-items-center mb-2 mb-md-0">
                            <span class="input-group-text ps-3">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Find The Business">
                        </div>
    
                        <div class="divider d-none d-md-block mx-2"></div>
    
                        <!-- Location -->
                        <div class="flex-grow-0 flex-md-grow-0 d-flex align-items-center mb-2 mb-md-0 mx-md-2">
                            <span class="input-group-text ps-3">
                                <i class="fa-solid fa-location-dot"></i>
                            </span>
                            <select class="form-control">
                                <option>Dhaka, BD</option>
                                <option>Chattogram, BD</option>
                                <option>Khulna, BD</option>
                                <option>Rajshahi, BD</option>
                            </select>
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