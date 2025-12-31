@extends('frontend.layout')

@push('styles')
        <style>


        /* Wizard layout */
        .wizard-wrapper {
            max-width: 980px;
            margin: 30px auto 40px;
        }

        .wizard-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 35px rgba(15, 23, 42, 0.08);
            border: 1px solid #e5e9f0;
        }

        .wizard-header {
            padding: 18px 24px 12px;
            border-bottom: 1px solid #eef1f7;
        }

        .wizard-title {
            font-size: 20px;
            font-weight: 600;
        }

        .wizard-subtitle {
            font-size: 13px;
            color: #6b7280;
        }

        /* Stepper */
        .stepper {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 14px;
        }

        .stepper-step {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .stepper-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid #d1d5db;
            background: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            color: #6b7280;
            position: relative;
            z-index: 2;
        }

        .stepper-label {
            margin-top: 4px;
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .stepper-step::before {
            content: "";
            position: absolute;
            height: 2px;
            background: #e5e7eb;
            top: 15px;
            left: -50%;
            right: 50%;
            z-index: 1;
        }

        .stepper-step:first-child::before {
            content: none;
        }

        .stepper-step.active .stepper-circle {
            border-color: #2563eb;
            background: #2563eb;
            color: #ffffff;
        }

        .stepper-step.completed .stepper-circle {
            background: #16a34a;
            border-color: #16a34a;
            color: white;
        }

        .stepper-step.completed .stepper-circle i {
            font-size: 14px;
        }

        .stepper-step.active .stepper-label {
            color: #111827;
            font-weight: 600;
        }

        .stepper-step.completed .stepper-label {
            color: #16a34a;
        }

        /* Panels */
        .wizard-body {
            padding: 20px 24px 6px;
        }

        .step-panel {
            display: none;
        }

        .step-panel.active {
            display: block;
        }

        .form-section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-section-help {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 16px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 500;
        }

        .form-text {
            font-size: 11px;
        }

        .border-dashed {
            border-style: dashed !important;
        }

        .upload-hint {
            font-size: 12px;
            color: #6b7280;
        }

        .summary-box {
            background: #f9fafb;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 13px;
        }

        .summary-box dt {
            font-weight: 600;
            color: #374151;
        }

        .summary-box dd {
            margin-bottom: 6px;
            color: #4b5563;
        }

        .wizard-footer {
            padding: 14px 24px 18px;
            border-top: 1px solid #eef1f7;
            display: flex;
            justify-content: space-between;
            gap: 12px;
        }

        .btn-step-next {
            min-width: 120px;
        }

        .btn-soft {
            background: #eff6ff;
            border-color: #dbeafe;
            color: #1d4ed8;
        }

        .btn-soft:hover {
            background: #dbeafe;
            border-color: #bfdbfe;
            color: #1d4ed8;
        }

        /* Mobile tweaks */
        @media (max-width: 767.98px) {
            .wizard-wrapper {
                margin: 18px auto 26px;
                padding-inline: 8px;
            }
            .wizard-card {
                border-radius: 12px;
            }
            .wizard-header {
                padding-inline: 16px;
            }
            .wizard-body,
            .wizard-footer {
                padding-inline: 16px;
            }
            .stepper-label {
                font-size: 10px;
            }
            .stepper-circle {
                width: 26px;
                height: 26px;
                font-size: 12px;
            }
        }
    </style>
@endpush

@section('pages')

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
                        <a class="nav-link" href="#"><i class="fa-regular fa-circle-dot me-2"></i>Vision</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>
    <div class="wizard-wrapper">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger"><strong>Please fix the errors below:</strong></div>
    @endif

    <form id="onboardingForm"
          class="wizard-card"
          enctype="multipart/form-data"
          method="POST"
          action="{{ route('listings.store') }}">
        @csrf

        <div class="wizard-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="wizard-title">Add Your Business</div>
                    <div class="wizard-subtitle">Complete the steps below to submit your listing for approval.</div>
                </div>
                <div class="text-end d-none d-md-block">
                    <span class="badge bg-primary-subtle text-primary" id="stepLabel">Step 1 of 5</span>
                </div>
            </div>

            <div class="stepper mt-3">
                <div class="stepper-step active" data-step="0">
                    <div class="stepper-circle">1</div>
                    <div class="stepper-label">Business Info</div>
                </div>
                <div class="stepper-step" data-step="1">
                    <div class="stepper-circle">2</div>
                    <div class="stepper-label">Contact & Location</div>
                </div>
                <div class="stepper-step" data-step="2">
                    <div class="stepper-circle">3</div>
                    <div class="stepper-label">Details & Photos</div>
                </div>
                <div class="stepper-step" data-step="3">
                    <div class="stepper-circle">4</div>
                    <div class="stepper-label">Documents</div>
                </div>
                <div class="stepper-step" data-step="4">
                    <div class="stepper-circle">5</div>
                    <div class="stepper-label">Review & Submit</div>
                </div>
            </div>
        </div>

        <div class="wizard-body">

            {{-- STEP 1 --}}
            <div class="step-panel active" data-step="0">
                <h6 class="form-section-title">Basic Business Information</h6>
                <p class="form-section-help">Tell us who you are and what type of business you’re listing.</p>

                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label">Business Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               name="name" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- ✅ FIX #1: Business Type = categories with NO parent --}}
                    <div class="col-md-4">
                        <label class="form-label">Business Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('business_type_id') is-invalid @enderror"
                                name="type"
                                id="businessTypeSelect"
                                required>
                            <option value="">Select type</option>
                            @foreach($categories as $typeCat) {{-- parent_id NULL categories --}}
                                <option value="{{ $typeCat->id }}" {{ old('business_type_id') == $typeCat->id ? 'selected' : '' }}>
                                    {{ $typeCat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('business_type_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">This is your top-level category (no parent).</div>
                    </div>

                    {{-- ✅ FIX #2 + #3: Primary Category = sub-categories ONLY after selection --}}
                    <div class="col-md-6">
                        <label class="form-label">Primary Category <span class="text-danger"></span></label>
                        <select class="form-select @error('primary_category_id') is-invalid @enderror"
                                name="category_id"
                                id="primaryCategorySelect"
                                data-children-url="{{ route('listings.category') }}"
                                data-old="{{ old('primary_category_id') }}"
                                disabled
                                >
                            <option value="">Select business type first</option>
                        </select>
                        @error('primary_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">This will be loaded from selected Business Type’s sub-categories.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Short Tagline</label>
                        <input type="text" class="form-control" name="tagline" value="{{ old('tagline') }}"
                               placeholder="Example: Cozy Italian family restaurant">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Business Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  name="description" rows="4" required
                                  placeholder="Tell customers what makes your business special...">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">This appears on your public listing page. Keep it friendly and informative.</div>
                    </div>
                </div>
            </div>

            {{-- STEP 2 --}}
            <div class="step-panel" data-step="1">
                <h6 class="form-section-title">Contact & Location</h6>
                <p class="form-section-help">We use this to show your listing in the correct city and help customers contact you.</p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Official Business Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                               name="phone" value="{{ old('phone') }}" required placeholder="+8801xxxxxxxxx">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Country <span class="text-danger">*</span></label>
                        <select class="form-select @error('country') is-invalid @enderror" name="country" required>
                            <option value="">Select country</option>
                            <option value="BD" {{ old('country','BD') === 'BD' ? 'selected' : '' }}>Bangladesh</option>
                            <option value="US" {{ old('country') === 'US' ? 'selected' : '' }}>United States</option>
                            <option value="CA" {{ old('country') === 'CA' ? 'selected' : '' }}>Canada</option>
                        </select>
                        @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">City / District <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                               name="city" value="{{ old('city') }}" required placeholder="Dhaka, Chattogram, etc.">
                        @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Area / Thana</label>
                        <input type="text" class="form-control" name="area" value="{{ old('area') }}"
                               placeholder="Mirpur, Gulshan, etc.">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Street Address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('address_line1') is-invalid @enderror"
                               name="address_line1" value="{{ old('address_line1') }}" required>
                        @error('address_line1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Additional Address Info</label>
                        <input type="text" class="form-control"
                               name="address_line2" value="{{ old('address_line2') }}"
                               placeholder="Floor, landmark, suite #">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Postal Code</label>
                        <input type="text" class="form-control" name="postal_code" value="{{ old('postal_code') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Website</label>
                        <input type="text" class="form-control @error('website') is-invalid @enderror"
                               name="website" value="{{ old('website') }}" placeholder="https://example.com">
                        @error('website') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            {{-- STEP 3 --}}
            <div class="step-panel" data-step="2">
                <h6 class="form-section-title">Business Details & Photos</h6>
                <p class="form-section-help">Basic details to show “Open Now / Closed Now” and some photos of your place.</p>

                @php
                    // ✅ FIX #4: 12-hour display (BST / Asia-Dhaka), but value remains HH:MM for backend saving
                    $timeOptions = [];
                    for ($h = 0; $h < 24; $h++) {
                        foreach ([0, 30] as $m) {
                            $value = sprintf('%02d:%02d', $h, $m);
                            $label = \Carbon\Carbon::createFromTime($h, $m, 0, 'Asia/Dhaka')->format('g:i A');
                            $timeOptions[$value] = $label;
                        }
                    }
                @endphp

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Price Level</label>
                        <select class="form-select @error('price_level') is-invalid @enderror" name="price_level">
                            <option value="">Select</option>
                            @foreach(['Low' => 'Low Level', 'Mid' => 'Mid Level', 'High Level' => 'High Level', 'Luxury' => 'Luxury Level'] as $val => $label)
                                <option value="{{ $val }}" {{ old('price_level') == $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('price_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Services / Highlights</label>
                        <input type="text" class="form-control" name="highlights" value="{{ old('highlights') }}"
                               placeholder="Example: Home delivery, family friendly, rooftop seating">
                        <div class="form-text">Comma-separated; you can map these to amenities later.</div>
                    </div>

                    <div class="col-12 mt-2">
                        <label class="form-label d-block mb-1">Opening Hours (Typical Day)</label>
                        <div class="row g-2">
                            <div class="col-6 col-md-3">
                                <select class="form-select @error('opens_at') is-invalid @enderror" name="opens_at">
                                    <option value="">Opens at</option>
                                    @foreach($timeOptions as $val => $label)
                                        <option value="{{ $val }}" {{ old('opens_at') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('opens_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-6 col-md-3">
                                <select class="form-select @error('closes_at') is-invalid @enderror" name="closes_at">
                                    <option value="">Closes at</option>
                                    @foreach($timeOptions as $val => $label)
                                        <option value="{{ $val }}" {{ old('closes_at') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('closes_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <select class="form-select @error('open_days') is-invalid @enderror" name="open_days">
                                    <option value="">Select days</option>
                                    @foreach(['Everyday','Mon – Fri','Fri – Sat','Custom (we’ll contact you)'] as $days)
                                        <option value="{{ $days }}" {{ old('open_days') === $days ? 'selected' : '' }}>{{ $days }}</option>
                                    @endforeach
                                </select>
                                @error('open_days') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-text">
                            Times shown in <strong>Bangladesh Standard Time (Asia/Dhaka)</strong>. You can set exact per-day hours after approval.
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <label class="form-label">Listing Photos</label>
                        <div class="border rounded border-dashed p-3 bg-light">
                            <input type="file"
                                   class="form-control @error('photos.*') is-invalid @enderror"
                                   name="photos[]"
                                   id="photosInput"
                                   accept="image/*"
                                   multiple>
                            @error('photos.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="upload-hint mt-1">
                                Upload up to 6 clear photos of your business (front view, interior, products, etc.). JPG or PNG, max 3 MB each.
                            </div>
                            <div id="photosPreview" class="row g-2 mt-2 d-none"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 4 --}}
            <div class="step-panel" data-step="3">
                <h6 class="form-section-title">Verify Your Business</h6>
                <p class="form-section-help">To protect customers and prevent fake listings, we require a valid NID and at least one legal business document.</p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Owner’s Full Name (As per NID) <span class="text-danger">(Optional)</span></label>
                        <input type="text" class="form-control @error('owner_name') is-invalid @enderror"
                               name="owner_name" value="{{ old('owner_name') }}" >
                        @error('owner_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">NID Number (Optional) </label>
                        <input type="text" class="form-control @error('nid_number') is-invalid @enderror"
                               name="nid_number" value="{{ old('nid_number') }}" >
                        @error('nid_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Upload NID (Front)  <span class="text-danger">(Optional)</span></label>
                        <div class="border rounded border-dashed p-3 bg-light">
                            <input type="file" class="form-control @error('nid_front') is-invalid @enderror"
                                   name="nid_front" accept="image/*,application/pdf" >
                            @error('nid_front') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="upload-hint mt-1">JPG, PNG or PDF. Max 5 MB.</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Upload NID (Back) (Optional)</label>
                        <div class="border rounded border-dashed p-3 bg-light">
                            <input type="file" class="form-control @error('nid_back') is-invalid @enderror"
                                   name="nid_back" accept="image/*,application/pdf">
                            @error('nid_back') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="upload-hint mt-1">Optional but recommended for faster verification.</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Trade License / Business Registration (Optional) </label>
                        <div class="border rounded border-dashed p-3 bg-light">
                            <input type="file" class="form-control @error('trade_license') is-invalid @enderror"
                                   name="trade_license" accept="image/*,application/pdf" >
                            @error('trade_license') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="upload-hint mt-1">Scanned copy or clear photo. Max 5 MB.</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">TIN / VAT / Other Legal Document if any (Optional)</label>
                        <div class="border rounded border-dashed p-3 bg-light">
                            <input type="file" class="form-control @error('tax_document') is-invalid @enderror"
                                   name="tax_document" accept="image/*,application/pdf">
                            @error('tax_document') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="upload-hint mt-1">Optional extra proof (VAT certificate, TIN, etc.).</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check mt-2">
                            <input class="form-check-input @error('agreed_terms') is-invalid @enderror"
                                   type="checkbox" value="1" id="agreeTerms" name="agreed_terms"
                                   {{ old('agreed_terms') ? 'checked' : '' }} required>
                            <label class="form-check-label" for="agreeTerms">
                                I confirm that the information and documents provided are accurate and I am authorized to list this business.
                            </label>
                            @error('agreed_terms') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 5 --}}
            <div class="step-panel" data-step="4">
                <h6 class="form-section-title">Review & Submit</h6>
                <p class="form-section-help">Double-check the main information before you submit for approval.</p>

                <div class="summary-box mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt>Business</dt>
                                <dd id="summaryBusiness">–</dd>

                                <dt>Category & Type</dt>
                                <dd id="summaryCategory">–</dd>

                                <dt>Contact</dt>
                                <dd id="summaryContact">–</dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="mb-0">
                                <dt>Location</dt>
                                <dd id="summaryLocation">–</dd>

                                <dt>Hours & Price</dt>
                                <dd id="summaryHours">–</dd>

                                <dt>Owner / NID</dt>
                                <dd id="summaryOwner">–</dd>

                                <dt>Photos</dt>
                                <dd id="summaryPhotos">No photos uploaded yet</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info py-2">
                    <i class="fa-solid fa-shield-halved me-2"></i>
                    Our team usually reviews new listings within <strong>1–2 business days</strong>.
                </div>
            </div>

        </div>

        <div class="wizard-footer">
            <button type="button" class="btn btn-outline-secondary btn-sm" id="btnPrev" disabled>
                <i class="fa-solid fa-arrow-left-long me-1"></i> Previous
            </button>

            <div class="d-flex ms-auto gap-2">
                <button type="button" class="btn btn-soft btn-sm" id="btnSaveDraft">
                    <i class="fa-regular fa-floppy-disk me-1"></i> Save draft
                </button>
                <button type="button" class="btn btn-primary btn-step-next btn-sm" id="btnNext">
                    Next Step <i class="fa-solid fa-arrow-right-long ms-1"></i>
                </button>
                <button type="submit" class="btn btn-success btn-sm d-none" id="btnSubmit">
                    Submit for Approval <i class="fa-solid fa-check ms-1"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function () {
    const form          = document.getElementById('onboardingForm');
    const panels        = document.querySelectorAll('.step-panel');
    const steps         = document.querySelectorAll('.stepper-step');
    const stepLabel     = document.getElementById('stepLabel');
    const btnPrev       = document.getElementById('btnPrev');
    const btnNext       = document.getElementById('btnNext');
    const btnSubmit     = document.getElementById('btnSubmit');
    const btnSaveDraft  = document.getElementById('btnSaveDraft');
    const photosInput   = document.getElementById('photosInput');
    const photosPreview = document.getElementById('photosPreview');

    // ✅ Dependent dropdown refs
    const businessTypeSelect   = document.getElementById('businessTypeSelect');
    const primaryCategorySelect= document.getElementById('primaryCategorySelect');

    let currentStep = 0;
    const totalSteps = panels.length;

    function showStep(index) {
        currentStep = index;

        panels.forEach((p, i) => p.classList.toggle('active', i === currentStep));

        steps.forEach((step, i) => {
            step.classList.toggle('active', i === currentStep);
            step.classList.toggle('completed', i < currentStep);
            if (i < currentStep) {
                step.querySelector('.stepper-circle').innerHTML = '<i class="fa-solid fa-check"></i>';
            } else {
                step.querySelector('.stepper-circle').textContent = (i + 1).toString();
            }
        });

        btnPrev.disabled = currentStep === 0;
        btnNext.classList.toggle('d-none', currentStep === totalSteps - 1);
        btnSubmit.classList.toggle('d-none', currentStep !== totalSteps - 1);

        if (stepLabel) stepLabel.textContent = `Step ${currentStep + 1} of ${totalSteps}`;

        if (currentStep === totalSteps - 1) fillSummary();

        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    function validateStep(index) {
        const panel = panels[index];
        const inputs = panel.querySelectorAll('input, select, textarea');
        for (const input of inputs) {
            if (!input.checkValidity()) {
                input.reportValidity();
                return false;
            }
        }
        return true;
    }

    btnNext.addEventListener('click', function () {
        if (!validateStep(currentStep)) return;
        if (currentStep < totalSteps - 1) showStep(currentStep + 1);
    });

    btnPrev.addEventListener('click', function () {
        if (currentStep > 0) showStep(currentStep - 1);
    });

    btnSaveDraft.addEventListener('click', function () {
        alert('Draft saved in browser (demo only). Connect to backend to store real drafts.');
    });

    function v(name) {
        const el = form.elements[name];
        return el && el.value ? el.value : '—';
    }

    function vSelectLabel(name) {
        const el = form.elements[name];
        if (!el || el.tagName !== 'SELECT') return '—';
        const opt = el.options[el.selectedIndex];
        return opt ? opt.text : '—';
    }

    function fillSummary() {
        document.getElementById('summaryBusiness').textContent =
            v('name') + ' – ' + (v('tagline') !== '—' ? v('tagline') : 'No tagline added');

        // ✅ Show both levels nicely
        const typeLabel = vSelectLabel('business_type_id');
        const primaryLabel = vSelectLabel('primary_category_id');
        document.getElementById('summaryCategory').textContent =
            (typeLabel !== '—' ? typeLabel : '—') + ' → ' + (primaryLabel !== '—' ? primaryLabel : '—');

        document.getElementById('summaryContact').textContent =
            v('email') + ' | ' + v('phone');

        document.getElementById('summaryLocation').textContent =
            v('address_line1') + (v('address_line2') !== '—' ? (', ' + v('address_line2')) : '') +
            ' – ' + v('area') + ', ' + v('city') + ' ' + v('postal_code') + ' (' + v('country') + ')';

        // ✅ Use 12-hour label for hours (not raw HH:MM)
        document.getElementById('summaryHours').textContent =
            'Opens ' + vSelectLabel('opens_at') + ', closes ' + vSelectLabel('closes_at') +
            ' · Days: ' + v('open_days') +
            ' · Price: ' + (vSelectLabel('price_level') !== '—' ? vSelectLabel('price_level') : 'not set');

        document.getElementById('summaryOwner').textContent =
            v('owner_name') + ' · NID: ' + v('nid_number');

        const summaryPhotosEl = document.getElementById('summaryPhotos');
        const count = photosInput && photosInput.files ? photosInput.files.length : 0;
        summaryPhotosEl.textContent = count ? `${count} photo(s) selected` : 'No photos uploaded yet';
    }

    function updatePhotosPreview(files) {
        if (!photosPreview) return;

        photosPreview.innerHTML = '';
        if (!files || !files.length) {
            photosPreview.classList.add('d-none');
            return;
        }

        const max = Math.min(files.length, 6);
        for (let i = 0; i < max; i++) {
            const file = files[i];
            const col = document.createElement('div');
            col.className = 'col-4 col-md-2';

            const wrapper = document.createElement('div');
            wrapper.className = 'ratio ratio-1x1 rounded overflow-hidden border bg-white';

            const img = document.createElement('img');
            img.alt = file.name;
            img.style.objectFit = 'cover';
            img.src = URL.createObjectURL(file);

            wrapper.appendChild(img);
            col.appendChild(wrapper);
            photosPreview.appendChild(col);
        }

        photosPreview.classList.remove('d-none');
    }

    if (photosInput) {
        photosInput.addEventListener('change', function () {
            updatePhotosPreview(this.files);
        });
    }

    // ✅ Dependent dropdown logic
    function resetPrimarySelect() {
        if (!primaryCategorySelect) return;
        primaryCategorySelect.innerHTML = '<option value="">Select business type first</option>';
        primaryCategorySelect.value = '';
        primaryCategorySelect.disabled = true;
       
        
    }

    async function loadPrimaryCategories(parentId, preselectId = null) {
        if (!primaryCategorySelect) return;

        primaryCategorySelect.disabled = true;
        primaryCategorySelect.innerHTML = '<option value="">Loading...</option>';

        const baseUrl = primaryCategorySelect.dataset.childrenUrl;
        const url = `${baseUrl}?parent_id=${encodeURIComponent(parentId)}`;

        try {
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            if (!res.ok) throw new Error('Failed to load categories');
            const data = await res.json();

            const items = (data && data.data) ? data.data : data; // supports either {data: []} or []

            let html = '<option value="">Choose primary category</option>';
            for (const item of items) {
                const selected = (preselectId && String(preselectId) === String(item.id)) ? 'selected' : '';
                html += `<option value="${item.id}" ${selected}>${item.name}</option>`;
            }

            primaryCategorySelect.innerHTML = html;
            primaryCategorySelect.disabled = false;
        } catch (e) {
            primaryCategorySelect.innerHTML = '<option value="">Could not load categories</option>';
            primaryCategorySelect.disabled = true;
            console.error(e);
        }
    }

    if (businessTypeSelect) {
        businessTypeSelect.addEventListener('change', function () {
            const parentId = this.value;
            if (!parentId) {
                resetPrimarySelect();
                return;
            }
            loadPrimaryCategories(parentId, null);
        });

        // On page load (validation error case)
        const currentParent = businessTypeSelect.value;
        const oldPrimary = primaryCategorySelect ? primaryCategorySelect.dataset.old : '';
        if (currentParent) {
            loadPrimaryCategories(currentParent, oldPrimary);
        } else {
            resetPrimarySelect();
        }
    }

    showStep(0);

    form.addEventListener('submit', function (e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            validateStep(currentStep);
        }
    });
})();
</script>
@endsection