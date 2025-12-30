<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Submission Received</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Your custom CSS -->
    <style>
        /* Unique prefix: ls-ty-  */

        .ls-ty-body{
            background: #ededee;
            color: #050505;
            min-height: 100vh;
        }

        .ls-ty-card{
            border-radius: 18px;
            overflow: hidden;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.10);
            backdrop-filter: blur(10px);
        }

        .ls-ty-header{
            padding: 20px 18px;
            display: flex;
            gap: 14px;
            align-items: center;
            background: linear-gradient(135deg, rgba(255,255,255,0.12), rgba(255,255,255,0.04));
            border-bottom: 1px solid rgba(255,255,255,0.10);
        }

        .ls-ty-icon-wrap{
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.14);
        }

        .ls-ty-icon{
            width: 26px;
            height: 26px;
            color: #b7ffcf;
        }

        .ls-ty-title{
            font-weight: 800;
            letter-spacing: -0.2px;
            line-height: 1.15;
            font-size: 1.25rem;
        }

        .ls-ty-subtitle{
            opacity: 0.9;
            line-height: 1.35;
            font-size: 0.98rem;
        }

        .ls-ty-highlight{
            font-weight: 700;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .ls-ty-content{
            padding: 18px;
        }

        .ls-ty-info{
            border-radius: 14px;
            padding: 14px;
            background: rgba(0,0,0,0.18);
            border: 1px solid rgba(255,255,255,0.08);
        }

        .ls-ty-label{
            font-size: 0.85rem;
            opacity: 0.75;
        }

        .ls-ty-value{
            font-size: 1.05rem;
            font-weight: 800;
            margin-top: 4px;
        }

        .ls-ty-hint{
            font-size: 0.86rem;
            opacity: 0.75;
            margin-top: 6px;
        }

        .ls-ty-badge{
            display: inline-block;
            padding: 8px 10px;
            border-radius: 12px;
            background: rgba(255,255,255,0.08);
            border: 1px dashed rgba(255,255,255,0.22);
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            letter-spacing: 0.5px;
        }

        .ls-ty-divider{
            height: 1px;
            margin: 16px 0;
            background: rgba(255,255,255,0.10);
        }

        .ls-ty-section-title{
            font-size: 1.02rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .ls-ty-steps{
            padding: 2px 2px 0;
        }

        .ls-ty-step{
            display: flex;
            gap: 12px;
            padding: 10px 0;
        }

        .ls-ty-step-dot{
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-weight: 900;
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.14);
            flex: 0 0 auto;
        }

        .ls-ty-step-title{
            font-weight: 850;
            margin-bottom: 2px;
        }

        .ls-ty-step-desc{
            opacity: 0.85;
            line-height: 1.4;
            font-size: 0.95rem;
        }

        .ls-ty-actions .ls-ty-btn{
            border-radius: 14px;
            padding: 10px 14px;
            font-weight: 700;
        }

        .ls-ty-support{
            opacity: 0.9;
            font-size: 0.92rem;
        }

        .ls-ty-support-link{
            color: inherit;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .ls-ty-support-sep{
            opacity: 0.7;
            margin: 0 8px;
        }

        .ls-ty-footer-note{
            opacity: 0.75;
            font-size: 0.9rem;
        }

        /* Responsive tweaks */
        @media (min-width: 768px){
            .ls-ty-header{ padding: 22px; }
            .ls-ty-content{ padding: 22px; }
            .ls-ty-title{ font-size: 1.45rem; }
        }

    </style>
</head>
<body class="ls-ty-body">

@php
    // Safe fallbacks (so this page works even if you pass only some data)
    $trackingCode = $listing->tracking_id ?? request('tracking') ?? ('TRK-' . strtoupper(substr(md5((string) now()), 0, 10)));
    $listingName  = $listingName ?? ($listing->name ?? 'Your Listing');
    $submittedAt  = $submittedAt ?? (isset($listing->created_at) ? $listing->created_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A'));
    $reviewDays   = $reviewDays ?? 2; 
    $supportEmail = $supportEmail ?? 'support@yourdomain.com';
@endphp

<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9 col-xl-8">

            <div class="ls-ty-card shadow-sm">
                <!-- Header -->
                <div class="ls-ty-header">
                    <div class="ls-ty-icon-wrap">
                        <svg class="ls-ty-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M20 7L10 17L4 11" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div class="ls-ty-headings">
                        <h1 class="ls-ty-title mb-1">Thanks! Submission received ✅</h1>
                        <p class="ls-ty-subtitle mb-0">
                            We’ve got your listing request for <span class="ls-ty-highlight">{{ $listingName }}</span>.
                        </p>
                    </div>
                </div>

                <!-- Main -->
                <div class="ls-ty-content">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="ls-ty-info">
                                <div class="ls-ty-label">Tracking ID</div>
                                <div class="ls-ty-value">
                                    <span class="ls-ty-badge">{{ $trackingCode }}</span>
                                </div>
                                <div class="ls-ty-hint">Keep this ID for updates & support.</div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="ls-ty-info">
                                <div class="ls-ty-label">Submitted</div>
                                <div class="ls-ty-value">{{ $submittedAt }}</div>
                                <div class="ls-ty-hint">We’ll review and notify you.</div>
                            </div>
                        </div>
                    </div>

                    <div class="ls-ty-divider"></div>

                    <div class="ls-ty-steps">
                        <h2 class="ls-ty-section-title">What happens next?</h2>

                        <div class="ls-ty-step">
                            <div class="ls-ty-step-dot">1</div>
                            <div class="ls-ty-step-text">
                                <div class="ls-ty-step-title">Verification</div>
                                <div class="ls-ty-step-desc">
                                    We’ll verify your business details and uploaded documents (NID + legal files).
                                </div>
                            </div>
                        </div>

                        <div class="ls-ty-step">
                            <div class="ls-ty-step-dot">2</div>
                            <div class="ls-ty-step-text">
                                <div class="ls-ty-step-title">Quality check</div>
                                <div class="ls-ty-step-desc">
                                    We may contact you if something is missing or unclear.
                                </div>
                            </div>
                        </div>

                        <div class="ls-ty-step">
                            <div class="ls-ty-step-dot">3</div>
                            <div class="ls-ty-step-text">
                                <div class="ls-ty-step-title">Approval & publish</div>
                                <div class="ls-ty-step-desc">
                                    If approved, your listing goes live (usually within <strong>{{ $reviewDays }}</strong> business days).
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ls-ty-divider"></div>

                    <div class="ls-ty-actions d-flex flex-column flex-sm-row gap-2">
                        <a href="{{ url('/') }}" class="btn btn-dark ls-ty-btn">
                            Back to Home
                        </a>

                        {{-- Update these routes based on your project --}}
                        <a href="{{ route('listings.create') }}" class="btn btn-outline-dark ls-ty-btn">
                            Submit Another Listing
                        </a>

                        <button type="button" class="btn btn-outline-secondary ls-ty-btn" id="lsCopyBtn"
                                data-copy="{{ $trackingCode }}">
                            Copy Tracking ID
                        </button>
                    </div>

                    <div class="ls-ty-support mt-3">
                        Need help? Email:
                        <a class="ls-ty-support-link" href="mailto:{{ $supportEmail }}">{{ $supportEmail }}</a>
                        <span class="ls-ty-support-sep">•</span>
                        Mention your Tracking ID: <strong>{{ $trackingCode }}</strong>
                    </div>
                </div>
            </div>

            <div class="text-center mt-3 ls-ty-footer-note">
                Tip: Save a screenshot of this page for your records.
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function () {
    const btn = document.getElementById('lsCopyBtn');
    if (!btn) return;

    btn.addEventListener('click', async () => {
        const text = btn.getAttribute('data-copy') || '';
        try {
            await navigator.clipboard.writeText(text);
            btn.textContent = 'Copied ✅';
            setTimeout(() => btn.textContent = 'Copy Tracking ID', 1400);
        } catch (e) {
            // fallback (older browsers)
            const temp = document.createElement('input');
            temp.value = text;
            document.body.appendChild(temp);
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);

            btn.textContent = 'Copied ✅';
            setTimeout(() => btn.textContent = 'Copy Tracking ID', 1400);
        }
    });
})();
</script>

</body>
</html>
