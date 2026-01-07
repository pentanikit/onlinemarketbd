<style>
    :root {
        --bk-green: #ff7a1a;
        --bk-green-dark: #ff7a1a;
        --bk-yellow: #ffcc00;
        --bk-text: #ffffff;
        --bk-muted: rgba(255, 255, 255, .85);
        --bk-shadow: 0 10px 30px rgba(0, 0, 0, .12);
        --bk-radius: 999px;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        background: #fff;
    }

    /* Banner background */
    .bk-banner {
        background: var(--bk-green);
        color: var(--bk-text);
        padding: 16px 18px 26px;
    }

    /* Top bar */
    .bk-topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .bk-left,
    .bk-right {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    /* Brand */
    .bk-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: var(--bk-text);
        font-weight: 700;
        letter-spacing: .2px;
    }

    .bk-brand-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: rgba(255, 255, 255, .14);
        font-size: 14px;
    }

    .bk-brand-text {
        font-size: 22px;
    }

    /* links + language */
    .bk-link {
        color: var(--bk-muted);
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }

    .bk-link:hover {
        color: #fff;
    }

    .bk-lang {
        border: 1px solid rgba(255, 255, 255, .35);
        background: rgba(0, 0, 0, .06);
        color: #fff;
        padding: 7px 12px;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
    }

    .bk-lang:hover {
        background: rgba(0, 0, 0, .12);
    }

    /* Right icons */
    .bk-icon-link {
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: var(--bk-muted);
        font-weight: 700;
        font-size: 14px;
    }

    .bk-icon-link:hover {
        color: #fff;
    }

    .bk-ico {
        width: 18px;
        height: 18px;
        color: #fff;
        opacity: .95;
    }

    .bk-icon-text {
        display: inline-block;
    }

    /* CTA button */
    .bk-post-btn {
        background: var(--bk-yellow);
        color: #2b2b2b;
        text-decoration: none;
        font-weight: 800;
        padding: 10px 14px;
        border-radius: 10px;
        box-shadow: 0 8px 18px rgba(0, 0, 0, .15);
        white-space: nowrap;
    }

    .bk-post-btn:hover {
        filter: brightness(0.98);
    }

    /* Hero center */
    .bk-hero {
        max-width: 1100px;
        margin: 22px auto 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 14px;
    }

    /* Location pill + dropdown */
    .bk-location-wrap {
        position: relative;
    }

    .bk-location {
        display: flex;
        align-items: center;
        gap: 10px;
        border: 0;
        padding: 9px 14px;
        border-radius: var(--bk-radius);
        background: rgba(0, 0, 0, .14);
        color: #fff;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(0, 0, 0, .10);
    }

    .bk-location:hover {
        background: rgba(0, 0, 0, .18);
    }

    .bk-pin {
        width: 16px;
        height: 16px;
        color: #fff;
        opacity: .95;
    }

    .bk-caret {
        width: 18px;
        height: 18px;
        color: #fff;
        opacity: .9;
    }

    .bk-location-menu {
        position: absolute;
        top: calc(100% + 10px);
        left: 0;
        min-width: 220px;
        background: #fff;
        color: #222;
        border-radius: 14px;
        box-shadow: var(--bk-shadow);
        overflow: hidden;
        display: none;
        z-index: 20;
    }

    .bk-location-menu.is-open {
        display: block;
    }

    .bk-loc-item {
        width: 100%;
        text-align: left;
        border: 0;
        background: #fff;
        padding: 11px 12px;
        cursor: pointer;
        font-weight: 700;
    }

    .bk-loc-item:hover {
        background: #f3f6f5;
    }

    /* Search bar */
    .bk-search {
        width: min(980px, 95vw);
        position: relative;
    }

    .bk-search-input {
        width: 100%;
        height: 56px;
        border: 0;
        outline: none;
        border-radius: var(--bk-radius);
        padding: 0 70px 0 22px;
        font-size: 18px;
        background: #fff;
        color: #222;
        box-shadow: var(--bk-shadow);
    }

    .bk-search-input::placeholder {
        color: #9aa2a6;
        font-weight: 600;
    }

    .bk-search-btn {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: 0;
        background: var(--bk-yellow);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 18px rgba(0, 0, 0, .12);
    }

    .bk-search-btn:hover {
        filter: brightness(0.98);
    }

    .bk-search-ico {
        width: 20px;
        height: 20px;
        color: #2b2b2b;
    }

    /* helper line (optional) */
    .bk-helper {
        width: min(980px, 95vw);
        font-size: 13px;
        color: rgba(255, 255, 255, .9);
        min-height: 18px;
    }

    /* Responsive */
    @media (max-width: 820px) {
        .bk-topbar {
            align-items: flex-start;
            flex-direction: column;
        }

        .bk-right {
            width: 100%;
            justify-content: flex-start;
        }

        .bk-icon-text {
            display: none;
        }

        /* keep icons only for compact look */
    }

    @media (max-width: 480px) {
        .bk-brand-text {
            font-size: 20px;
        }

        .bk-search-input {
            font-size: 16px;
            height: 54px;
        }
    }
</style>
        @php
            $content = \App\Models\SiteContent::where('key', 'home')->first();
        @endphp
<header class="bk-banner">
    <!-- Top navbar -->
    <div class="bk-topbar">
        <div class="bk-left">
            <a class="bk-brand" href="#">
<h4>Manage your shop</h4>
            </a>

 


        </div>

        <div class="bk-right">
            <a class="bk-icon-link" href="#" title="Chat" aria-label="Chat">
                <!-- chat icon -->
                <svg viewBox="0 0 24 24" class="bk-ico" aria-hidden="true">
                    <path d="M4 4h16v11H7l-3 3V4z" fill="currentColor"></path>
                </svg>
                <span class="bk-icon-text">Support</span>
            </a>

            <a class="bk-icon-link" href="#" title="Login" aria-label="Login">
                <!-- user icon -->
                <svg viewBox="0 0 24 24" class="bk-ico" aria-hidden="true">
                    <path d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4zm0 2c-4.4 0-8 2.2-8 5v1h16v-1c0-2.8-3.6-5-8-5z"
                        fill="currentColor"></path>
                </svg>
                <span class="bk-icon-text">Seller login</span>
            </a>

            <a class="bk-post-btn" href="{{ route('seller.onboarding') }}">Post a free Ad</a>
        </div>
    </div>


</header>

<script>
    (() => {
        const locationBtn = document.getElementById("locationBtn");
        const locationMenu = document.getElementById("locationMenu");
        const locationText = document.getElementById("locationText");
        const searchForm = document.getElementById("searchForm");
        const qInput = document.getElementById("q");
        const helperText = document.getElementById("helperText");
        const langBtn = document.getElementById("langBtn");

        // Location dropdown toggle
        function closeLocationMenu() {
            locationMenu.classList.remove("is-open");
            locationBtn.setAttribute("aria-expanded", "false");
        }

        function openLocationMenu() {
            locationMenu.classList.add("is-open");
            locationBtn.setAttribute("aria-expanded", "true");
        }

        locationBtn?.addEventListener("click", (e) => {
            e.stopPropagation();
            const open = locationMenu.classList.contains("is-open");
            open ? closeLocationMenu() : openLocationMenu();
        });

        // Select location
        locationMenu?.addEventListener("click", (e) => {
            const btn = e.target.closest(".bk-loc-item");
            if (!btn) return;
            const loc = btn.getAttribute("data-loc") || btn.textContent.trim();
            locationText.textContent = loc;
            helperText.textContent = `Location set to: ${loc}`;
            closeLocationMenu();
        });

        // Close dropdown on outside click / ESC
        document.addEventListener("click", () => closeLocationMenu());
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") closeLocationMenu();
        });

        // Search submit
        searchForm?.addEventListener("submit", (e) => {
            e.preventDefault();
            const q = (qInput.value || "").trim();
            const loc = (locationText.textContent || "").trim();

            if (!q) {
                helperText.textContent = "অনুগ্রহ করে কিছু লিখে সার্চ করুন।";
                qInput.focus();
                return;
            }

            // Example redirect (change URL to your real route)
            const url = `/search?q=${encodeURIComponent(q)}&location=${encodeURIComponent(loc)}`;
            helperText.textContent = `Searching: "${q}" in ${loc} ...`;
            window.location.href = url;
        });

        // Tiny language button demo toggle
        langBtn?.addEventListener("click", () => {
            const current = langBtn.textContent.trim();
            langBtn.textContent = current === "English" ? "বাংলা" : "English";
        });
    })();
</script>
