<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OnlineMarket BD • Create Your Shop</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}" />
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* OnlineMarket BD - Stepper styles */
        .om-body { background: #f6f8fb; }
        .om-brand { font-weight: 800; letter-spacing: .3px; }
        .om-card { border: 1px solid #e9eef6; border-radius: 14px; }
        .om-stepper { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; }
        .om-step { display: flex; flex-direction: column; align-items: center; text-align: center; user-select: none; cursor: pointer; }
        .om-step-dot { width: 36px; height: 36px; border-radius: 999px; display: grid; place-items: center; font-weight: 700; border: 2px solid #d8e2f2; background: #fff; color: #6b7280; }
        .om-step-label { margin-top: 6px; font-size: 12px; color: #6b7280; }
        .om-step.om-active .om-step-dot { border-color: #0d6efd; color: #0d6efd; }
        .om-step.om-done .om-step-dot { background: #198754; border-color: #198754; color: #fff; }
        .om-step.om-done .om-step-label { color: #198754; }
        .om-preview { border-radius: 12px; border: 1px dashed #d9e2f2; }
        .om-preview-placeholder { background: #f3f6fb; border: 1px solid #e6eefc; border-radius: 10px; padding: 16px; text-align: center; color: #6b7280; }
        .om-summary { border-radius: 14px; border: 1px solid #e9eef6; }
        .om-summary-title { font-weight: 700; margin-bottom: 8px; }
        .om-summary-item { font-size: 14px; color: #374151; margin-bottom: 6px; }
        .om-summary-item span { color: #6b7280; display: inline-block; min-width: 90px; }
        @media (max-width: 575.98px) {
            .om-stepper { grid-template-columns: 1fr; gap: 8px; }
            .om-step { flex-direction: row; gap: 10px; justify-content: flex-start; text-align: left; }
            .om-step-label { margin-top: 0; font-size: 13px; }
        }
    </style>
</head>

<body class="om-body">
    <div class="container py-4 py-md-5">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <div class="om-brand">OnlineMarket BD</div>
                        <h1 class="h4 mb-0">Create your shop</h1>
                        <div class="text-muted small">Finish onboarding in ~2 minutes.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="btnSaveDraft">
                            Save Draft
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" id="btnClearDraft">
                            Clear Draft
                        </button>
                    </div>
                </div>

                <div class="om-card card shadow-sm">
                    <div class="card-body p-3 p-md-4">

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="small text-muted">Progress</div>
                                <div class="small text-muted"><span id="progressText">Step 1</span> of 5</div>
                            </div>
                            <div class="progress" style="height:10px;">
                                <div class="progress-bar" id="progressBar" role="progressbar" style="width: 20%"></div>
                            </div>
                        </div>

                        <div class="om-stepper mb-4">
                            <div class="om-step om-active" data-step="0">
                                <div class="om-step-dot">1</div>
                                <div class="om-step-label">Account</div>
                            </div>
                            <div class="om-step" data-step="1">
                                <div class="om-step-dot">2</div>
                                <div class="om-step-label">Shop</div>
                            </div>
                            <div class="om-step" data-step="2">
                                <div class="om-step-dot">3</div>
                                <div class="om-step-label">Address</div>
                            </div>
                            <div class="om-step" data-step="3">
                                <div class="om-step-dot">4</div>
                                <div class="om-step-label">Payments</div>
                            </div>
                            <div class="om-step" data-step="4">
                                <div class="om-step-dot">5</div>
                                <div class="om-step-label">Finish</div>
                            </div>
                        </div>

                        <div class="alert alert-danger d-none" id="errorBox"></div>
                        <div class="alert alert-success d-none" id="successBox"></div>

                        <form id="onboardForm" novalidate>
                            <!-- STEP 1 -->
                            <section class="om-step-panel" data-step="0">
                                <div class="mb-3">
                                    <h2 class="h6 mb-1">Account details</h2>
                                    <div class="text-muted small">We’ll create your seller account.</div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" class="form-control" name="fullName"
                                            placeholder="e.g. Emdadul Haque" required>
                                        <div class="invalid-feedback">Name is required.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Mobile Number</label>
                                        <input type="tel" class="form-control" name="phone" placeholder="01XXXXXXXXX"
                                            required>
                                        <div class="invalid-feedback">Valid BD phone is required (11 digits).</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Email (optional)</label>
                                        <input type="email" class="form-control" name="email"
                                            placeholder="you@email.com">
                                        <div class="invalid-feedback">Please enter a valid email.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" minlength="6"
                                            required>
                                        <div class="invalid-feedback">Password must be at least 6 characters.</div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agreeTerms" name="agreeTerms"
                                        required>
                                    <label class="form-check-label" for="agreeTerms">
                                        I agree to OnlineMarket BD seller terms & policies
                                    </label>
                                    <div class="invalid-feedback">You must agree before continuing.</div>
                                </div>
                            </section>

                            <!-- STEP 2 -->
                            <section class="om-step-panel d-none" data-step="1">
                                <div class="mb-3">
                                    <h2 class="h6 mb-1">Shop information</h2>
                                    <div class="text-muted small">This is what customers will see.</div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-7">
                                        <label class="form-label">Shop Name</label>
                                        <input type="text" class="form-control" name="shopName"
                                            placeholder="e.g. Ponnobd Electronics" required>
                                        <div class="invalid-feedback">Shop name is required.</div>
                                    </div>

                                    <div class="col-md-5">
                                        <label class="form-label">Shop Category</label>
                                        <select class="form-select" name="category" required>
                                            <option value="" selected disabled>Select a category</option>
                                            <option>Electronics</option>
                                            <option>Fashion</option>
                                            <option>Groceries</option>
                                            <option>Beauty & Personal Care</option>
                                            <option>Home & Kitchen</option>
                                            <option>Books & Stationery</option>
                                            <option>Services</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a category.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Shop Username / Slug</label>
                                        <div class="input-group">
                                            <span class="input-group-text">onlinemarketbd.com/shop/</span>
                                            <input type="text" class="form-control" name="shopSlug"
                                                placeholder="ponnobd" required>
                                            <div class="invalid-feedback">Slug is required (letters/numbers/- only).</div>
                                        </div>
                                        <div class="form-text">Only lowercase letters, numbers, and hyphens.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Support Contact (optional)</label>
                                        <input type="tel" class="form-control" name="supportPhone"
                                            placeholder="01XXXXXXXXX">
                                        <div class="invalid-feedback">Support phone must be 11 digits.</div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Short Description</label>
                                        <textarea class="form-control" name="shopDesc" rows="3"
                                            placeholder="Tell customers what you sell..." required></textarea>
                                        <div class="invalid-feedback">Please write a short description.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Logo (optional)</label>
                                        <input class="form-control" type="file" name="logo" accept="image/*">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Shop Banner (optional)</label>
                                        <input class="form-control" type="file" name="banner" accept="image/*">
                                    </div>
                                </div>

                                <div class="row g-3 mt-2">
                                    <div class="col-md-6">
                                        <div class="om-preview card">
                                            <div class="card-body">
                                                <div class="small text-muted mb-2">Logo preview</div>
                                                <img id="logoPreview" class="img-fluid rounded d-none" alt="Logo preview">
                                                <div id="logoPlaceholder" class="om-preview-placeholder">No logo selected</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="om-preview card">
                                            <div class="card-body">
                                                <div class="small text-muted mb-2">Banner preview</div>
                                                <img id="bannerPreview" class="img-fluid rounded d-none" alt="Banner preview">
                                                <div id="bannerPlaceholder" class="om-preview-placeholder">No banner selected</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- STEP 3 -->
                            <section class="om-step-panel d-none" data-step="2">
                                <div class="mb-3">
                                    <h2 class="h6 mb-1">Pickup / business address</h2>
                                    <div class="text-muted small">Used for delivery pickups & verification.</div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Division</label>
                                        <select class="form-select" name="division" required>
                                            <option value="" selected disabled>Select division</option>
                                            <option>Dhaka</option>
                                            <option>Chattogram</option>
                                            <option>Khulna</option>
                                            <option>Rajshahi</option>
                                            <option>Barishal</option>
                                            <option>Sylhet</option>
                                            <option>Rangpur</option>
                                            <option>Mymensingh</option>
                                        </select>
                                        <div class="invalid-feedback">Division is required.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">City / District</label>
                                        <input type="text" class="form-control" name="district" placeholder="e.g. Mirpur, Dhaka" required>
                                        <div class="invalid-feedback">City/District is required.</div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Full Address</label>
                                        <textarea class="form-control" name="address" rows="3" placeholder="House, Road, Area..." required></textarea>
                                        <div class="invalid-feedback">Address is required.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Postal Code (optional)</label>
                                        <input type="text" class="form-control" name="postal" placeholder="e.g. 1216">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Pickup Instructions (optional)</label>
                                        <input type="text" class="form-control" name="pickupNotes" placeholder="Gate, floor, call before...">
                                    </div>
                                </div>
                            </section>

                            <!-- STEP 4 -->
                            <section class="om-step-panel d-none" data-step="3">
                                <div class="mb-3">
                                    <h2 class="h6 mb-1">Payout method</h2>
                                    <div class="text-muted small">Where we send your earnings.</div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Payout Method</label>
                                        <select class="form-select" name="payoutMethod" required>
                                            <option value="" selected disabled>Select method</option>
                                            <option value="bkash">bKash</option>
                                            <option value="nagad">Nagad</option>
                                            <option value="bank">Bank Transfer</option>
                                        </select>
                                        <div class="invalid-feedback">Choose a payout method.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Account Number</label>
                                        <input type="text" class="form-control" name="payoutNumber" placeholder="e.g. 01XXXXXXXXX / Bank A/C" required>
                                        <div class="invalid-feedback">Account number is required.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Account Holder Name</label>
                                        <input type="text" class="form-control" name="payoutName" placeholder="Name on account" required>
                                        <div class="invalid-feedback">Account holder name is required.</div>
                                    </div>

                                    <div class="col-md-6" id="bankFields" style="display:none;">
                                        <label class="form-label">Bank Name + Branch (for bank)</label>
                                        <input type="text" class="form-control" name="bankInfo" placeholder="e.g. DBBL • Mirpur-10">
                                    </div>

                                    <div class="col-12">
                                        <div class="alert alert-warning small mb-0">
                                            Demo note: This form does not send real payments; it just collects data.
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- STEP 5 -->
                            <section class="om-step-panel d-none" data-step="4">
                                <div class="mb-3">
                                    <h2 class="h6 mb-1">Review & create shop</h2>
                                    <div class="text-muted small">Check everything before finishing.</div>
                                </div>

                                <div class="om-summary card">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="om-summary-title">Account</div>
                                                <div class="om-summary-item"><span>Name:</span> <strong id="sumFullName">—</strong></div>
                                                <div class="om-summary-item"><span>Phone:</span> <strong id="sumPhone">—</strong></div>
                                                <div class="om-summary-item"><span>Email:</span> <strong id="sumEmail">—</strong></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="om-summary-title">Shop</div>
                                                <div class="om-summary-item"><span>Shop Name:</span> <strong id="sumShopName">—</strong></div>
                                                <div class="om-summary-item"><span>Category:</span> <strong id="sumCategory">—</strong></div>
                                                <div class="om-summary-item"><span>URL:</span> <strong id="sumUrl">—</strong></div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="om-summary-title">Address</div>
                                                <div class="om-summary-item"><span>Division:</span> <strong id="sumDivision">—</strong></div>
                                                <div class="om-summary-item"><span>District:</span> <strong id="sumDistrict">—</strong></div>
                                                <div class="om-summary-item"><span>Address:</span> <strong id="sumAddress">—</strong></div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="om-summary-title">Payout</div>
                                                <div class="om-summary-item"><span>Method:</span> <strong id="sumMethod">—</strong></div>
                                                <div class="om-summary-item"><span>Account:</span> <strong id="sumPayoutNumber">—</strong></div>
                                                <div class="om-summary-item"><span>Holder:</span> <strong id="sumPayoutName">—</strong></div>
                                            </div>
                                        </div>

                                        <hr class="my-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="confirmInfo" name="confirmInfo" required>
                                            <label class="form-check-label" for="confirmInfo">
                                                I confirm the above information is correct.
                                            </label>
                                            <div class="invalid-feedback">You must confirm before creating the shop.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info small mt-3 mb-0">
                                    After submit, you can redirect to a “Shop Dashboard” page or show a success screen.
                                </div>
                            </section>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button type="button" class="btn btn-light" id="btnBack" disabled>← Back</button>

                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-secondary" id="btnSkip">Skip</button>
                                    <button type="button" class="btn btn-primary" id="btnNext">Next →</button>
                                    <button type="submit" class="btn btn-success d-none" id="btnSubmit">Create Shop</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <div class="text-center text-muted small mt-3">
                    © <span id="year"></span> OnlineMarket BD • Seller Onboarding
                </div>

            </div>
        </div>
    </div>

    <script>
        (function() {
            const form = document.getElementById('onboardForm');

            const panels = Array.from(document.querySelectorAll('.om-step-panel'));
            const steps = Array.from(document.querySelectorAll('.om-step'));

            const btnBack = document.getElementById('btnBack');
            const btnNext = document.getElementById('btnNext');
            const btnSkip = document.getElementById('btnSkip');
            const btnSubmit = document.getElementById('btnSubmit');

            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');

            const errorBox = document.getElementById('errorBox');
            const successBox = document.getElementById('successBox');

            const year = document.getElementById('year');
            if (year) year.textContent = new Date().getFullYear();

            const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const DRAFT_KEY = "om_shop_onboarding_draft_v1";

            const ROUTES = {
                account: "{{ route('seller.onboarding.account') }}",
                shop: "{{ route('seller.onboarding.shop') }}",
                address: "{{ route('seller.onboarding.address') }}",
                payout: "{{ route('seller.onboarding.payout') }}",
                finish: "{{ route('seller.onboarding.finish') }}",
            };

            let currentStep = 0;
            let isSubmitting = false;

            function showError(msg) {
                errorBox.textContent = msg;
                errorBox.classList.remove('d-none');
                successBox.classList.add('d-none');
            }

            function showSuccess(msg) {
                successBox.textContent = msg;
                successBox.classList.remove('d-none');
                errorBox.classList.add('d-none');
            }

            function clearAlerts() {
                errorBox.classList.add('d-none');
                successBox.classList.add('d-none');
            }

            function setPanel(stepIdx) {
                currentStep = stepIdx;

                panels.forEach(p => p.classList.add('d-none'));
                const active = panels.find(p => Number(p.dataset.step) === stepIdx);
                if (active) active.classList.remove('d-none');

                steps.forEach((s, i) => {
                    s.classList.remove('om-active');
                    if (i < stepIdx) s.classList.add('om-done');
                    else s.classList.remove('om-done');
                    if (i === stepIdx) s.classList.add('om-active');
                });

                btnBack.disabled = stepIdx === 0;

                const last = stepIdx === panels.length - 1;
                btnNext.classList.toggle('d-none', last);
                btnSubmit.classList.toggle('d-none', !last);

                const skippable = (stepIdx === 1 || stepIdx === 2 || stepIdx === 3);
                btnSkip.classList.toggle('d-none', !skippable);

                const percent = Math.round(((stepIdx + 1) / panels.length) * 100);
                progressBar.style.width = percent + "%";
                progressText.textContent = `Step ${stepIdx + 1}`;

                clearAlerts();
                if (stepIdx === 4) fillSummary();
            }

            function isValidBDPhone(v) {
                const digits = (v || "").replace(/\D/g, "");
                return digits.length === 11 && digits.startsWith("01");
            }

            function isValidSlug(v) {
                return /^[a-z0-9-]+$/.test((v || "").trim());
            }

            function validateStep(stepIdx) {
                clearAlerts();

                const panel = panels.find(p => Number(p.dataset.step) === stepIdx);
                if (!panel) return true;

                panel.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                let ok = true;

                const requiredFields = panel.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (!field.checkValidity()) {
                        field.classList.add('is-invalid');
                        ok = false;
                    }
                });

                const phone = panel.querySelector('input[name="phone"]');
                if (phone && !isValidBDPhone(phone.value)) {
                    phone.classList.add('is-invalid');
                    ok = false;
                }

                const supportPhone = panel.querySelector('input[name="supportPhone"]');
                if (supportPhone && supportPhone.value.trim() !== "" && !isValidBDPhone(supportPhone.value)) {
                    supportPhone.classList.add('is-invalid');
                    ok = false;
                }

                const slug = panel.querySelector('input[name="shopSlug"]');
                if (slug) {
                    const v = slug.value.trim();
                    if (!v || !isValidSlug(v)) {
                        slug.classList.add('is-invalid');
                        ok = false;
                    }
                }

                if (stepIdx === 4) {
                    const confirm = document.getElementById('confirmInfo');
                    if (confirm && !confirm.checked) {
                        confirm.classList.add('is-invalid');
                        ok = false;
                    }
                }

                if (!ok) showError("Please fix the highlighted fields before continuing.");
                return ok;
            }

            function getFD() {
                return new FormData(form);
            }

            function saveDraft() {
                const fd = new FormData(form);
                const data = {};
                for (const [k, v] of fd.entries()) {
                    if (v instanceof File) continue; // don't store files in localStorage
                    data[k] = String(v);
                }
                data.agreeTerms = document.getElementById('agreeTerms')?.checked ? "yes" : "no";
                data.confirmInfo = document.getElementById('confirmInfo')?.checked ? "yes" : "no";
                data._step = currentStep;

                localStorage.setItem(DRAFT_KEY, JSON.stringify(data));
                showSuccess("Draft saved on this browser.");
            }

            function clearDraft() {
                localStorage.removeItem(DRAFT_KEY);
                showSuccess("Draft cleared.");
            }

            function restoreDraftIfAny() {
                const raw = localStorage.getItem(DRAFT_KEY);
                if (!raw) return;
                try {
                    const data = JSON.parse(raw);

                    Object.keys(data).forEach(key => {
                        if (key === "_step") return;
                        const el = form.querySelector(`[name="${CSS.escape(key)}"]`);
                        if (!el) return;
                        const type = (el.getAttribute('type') || '').toLowerCase();
                        if (type === 'file') return;
                        el.value = data[key];
                    });

                    const agree = document.getElementById('agreeTerms');
                    if (agree) agree.checked = data.agreeTerms === "yes";

                    const confirm = document.getElementById('confirmInfo');
                    if (confirm) confirm.checked = data.confirmInfo === "yes";

                    const stepTo = Number.isFinite(Number(data._step)) ? Number(data._step) : 0;
                    setPanel(Math.min(Math.max(stepTo, 0), panels.length - 1));
                    showSuccess("Draft restored.");
                } catch (e) {}
            }

            // ---- File previews ----
            const logoInput = form.querySelector('input[name="logo"]');
            const bannerInput = form.querySelector('input[name="banner"]');

            function handlePreview(input, imgEl, placeholderEl) {
                if (!input || !imgEl || !placeholderEl) return;
                input.addEventListener('change', () => {
                    const file = input.files && input.files[0];
                    if (!file) {
                        imgEl.classList.add('d-none');
                        placeholderEl.classList.remove('d-none');
                        placeholderEl.textContent = "No file selected";
                        return;
                    }
                    const url = URL.createObjectURL(file);
                    imgEl.src = url;
                    imgEl.classList.remove('d-none');
                    placeholderEl.classList.add('d-none');
                });
            }

            handlePreview(logoInput, document.getElementById('logoPreview'), document.getElementById('logoPlaceholder'));
            handlePreview(bannerInput, document.getElementById('bannerPreview'), document.getElementById('bannerPlaceholder'));

            // ---- Bank fields toggle ----
            const payoutMethod = form.querySelector('select[name="payoutMethod"]');
            const bankFields = document.getElementById('bankFields');
            if (payoutMethod) {
                payoutMethod.addEventListener('change', () => {
                    bankFields.style.display = payoutMethod.value === 'bank' ? 'block' : 'none';
                });
            }

            // ---- Summary fill ----
            function setText(id, value) {
                const el = document.getElementById(id);
                if (el) el.textContent = value || "—";
            }

            function fillSummary() {
                const fd = new FormData(form);
                const get = (k) => (fd.get(k) || "").toString();

                setText('sumFullName', get('fullName'));
                setText('sumPhone', get('phone'));
                setText('sumEmail', get('email'));

                setText('sumShopName', get('shopName'));
                setText('sumCategory', get('category'));
                const slug = (get('shopSlug') || "").trim();
                setText('sumUrl', slug ? `onlinemarketbd.com/shop/${slug}` : "—");

                setText('sumDivision', get('division'));
                setText('sumDistrict', get('district'));
                setText('sumAddress', get('address'));

                setText('sumMethod', get('payoutMethod'));
                setText('sumPayoutNumber', get('payoutNumber'));
                setText('sumPayoutName', get('payoutName'));
            }

            // ---- Fetch helper ----
            async function postForm(url, formData) {
                const res = await fetch(url, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": CSRF,
                        "Accept": "application/json"
                    },
                    body: formData
                });

                const data = await res.json().catch(() => ({}));
                if (!res.ok) {
                    // Laravel validation error
                    if (data?.message) throw new Error(data.message);
                    if (data?.errors) {
                        const firstKey = Object.keys(data.errors)[0];
                        const firstMsg = data.errors[firstKey]?.[0] || "Validation failed.";
                        throw new Error(firstMsg);
                    }
                    throw new Error("Request failed.");
                }
                return data;
            }

            // Build per-step payload (only the fields for that step)
            function buildStepFormData(stepIdx) {
                const fdAll = new FormData(form);
                const fd = new FormData();

                const pick = (keys) => {
                    keys.forEach(k => {
                        if (fdAll.has(k)) fd.append(k, fdAll.get(k));
                    });
                };

                if (stepIdx === 0) {
                    pick(['fullName', 'phone', 'email', 'password', 'agreeTerms']);
                    // ensure checkbox value exists
                    if (!document.getElementById('agreeTerms').checked) fd.delete('agreeTerms');
                    else fd.set('agreeTerms', 'yes');
                }

                if (stepIdx === 1) {
                    pick(['shopName', 'category', 'shopSlug', 'supportPhone', 'shopDesc', 'logo', 'banner']);
                    // note: logo/banner are files
                }

                if (stepIdx === 2) {
                    pick(['division', 'district', 'address', 'postal', 'pickupNotes']);
                }

                if (stepIdx === 3) {
                    pick(['payoutMethod', 'payoutNumber', 'payoutName', 'bankInfo']);
                }

                if (stepIdx === 4) {
                    // finish
                    if (document.getElementById('confirmInfo').checked) fd.set('confirmInfo', 'yes');
                }

                return fd;
            }

            async function saveCurrentStepToServer() {
                if (!validateStep(currentStep)) return false;

                // Prevent double submission
                if (isSubmitting) return false;
                isSubmitting = true;

                // Loading state
                const originalNext = btnNext.innerHTML;
                btnNext.disabled = true;
                btnSkip.disabled = true;

                try {
                    let url = null;
                    if (currentStep === 0) url = ROUTES.account;
                    if (currentStep === 1) url = ROUTES.shop;
                    if (currentStep === 2) url = ROUTES.address;
                    if (currentStep === 3) url = ROUTES.payout;

                    if (!url) return true; // step 4 is final submit

                    const fd = buildStepFormData(currentStep);
                    await postForm(url, fd);

                    showSuccess("Saved ✔");
                    saveDraft(); // local
                    return true;
                } catch (err) {
                    showError(err.message || "Something went wrong.");
                    return false;
                } finally {
                    btnNext.disabled = false;
                    btnSkip.disabled = false;
                    btnNext.innerHTML = originalNext;
                    isSubmitting = false;
                }
            }

            // ---- Navigation ----
            btnNext.addEventListener('click', async () => {
                const ok = await saveCurrentStepToServer();
                if (!ok) return;
                setPanel(Math.min(currentStep + 1, panels.length - 1));
            });

            btnBack.addEventListener('click', () => {
                setPanel(Math.max(currentStep - 1, 0));
            });

            btnSkip.addEventListener('click', async () => {
                // still validates current step; you can remove saveCurrentStepToServer() if you want skip without saving
                const ok = await saveCurrentStepToServer();
                if (!ok) return;
                setPanel(Math.min(currentStep + 1, panels.length - 1));
            });

            steps.forEach((s, idx) => {
                s.addEventListener('click', () => {
                    if (idx <= currentStep) setPanel(idx);
                });
            });

            document.getElementById('btnSaveDraft').addEventListener('click', saveDraft);
            document.getElementById('btnClearDraft').addEventListener('click', clearDraft);

            // Final submit -> POST finish route
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                if (!validateStep(4)) return;

                if (isSubmitting) return;
                isSubmitting = true;

                const original = btnSubmit.innerHTML;
                btnSubmit.disabled = true;
                btnSubmit.innerHTML = 'Creating...';

                try {
                    // Save step 4 confirm only
                    const fd = buildStepFormData(4);
                    const data = await postForm(ROUTES.finish, fd);

                    localStorage.removeItem(DRAFT_KEY);
                    showSuccess(data.message || "Shop created successfully!");

                    // redirect if provided by backend
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                } catch (err) {
                    showError(err.message || "Could not finish onboarding.");
                } finally {
                    btnSubmit.disabled = false;
                    btnSubmit.innerHTML = original;
                    isSubmitting = false;
                }
            });

            // Init
            setPanel(0);
            restoreDraftIfAny();
        })();
    </script>
</body>

</html>
