<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OnlineMarketBD • Post New Ad</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sd-body {
            background: #f6f8fb;
            font-family: "Trebuchet MS", Arial, sans-serif;
        }

        .sd-navbar {
            background: #fff;
        }

        .sd-brand {
            letter-spacing: .2px;
        }

        .sd-user-pill {
            font-size: 13px;
            padding: 6px 10px;
            border-radius: 999px;
            background: #111;
            color: #fff;
        }

        .sd-title {
            font-size: 28px;
            font-weight: 800;
            color: #111;
            line-height: 1.1;
        }

        .sd-subtitle {
            color: #566;
            margin-top: 6px;
        }

        .sd-btn {
            border-radius: 12px;
        }

        .sd-section {
            background: #fff;
            border: 1px solid #e9eef6;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
        }

        .sd-section-title {
            font-size: 18px;
            font-weight: 900;
            color: #111;
        }

        .sd-section-sub {
            font-size: 13px;
            color: #667;
        }

        .sd-label {
            font-weight: 800;
            color: #111;
            font-size: 13px;
        }

        .sd-input {
            border-radius: 12px !important;
            border: 1px solid #e9eef6 !important;
            padding: .7rem .85rem;
        }

        .sd-help {
            font-size: 12px;
            color: #667;
            margin-top: 6px;
        }

        .sd-alert {
            border-radius: 14px;
        }

        .sd-tip {
            background: #111;
            color: #fff;
            border-radius: 16px;
            padding: 16px;
        }

        .sd-tip-title {
            font-weight: 900;
            font-size: 14px;
            letter-spacing: .2px;
        }

        .sd-tip-text {
            margin-top: 6px;
            color: rgba(255, 255, 255, .85);
            font-size: 13px;
        }

        .sp-drop {
            position: relative;
            border: 2px dashed #dbe3f2;
            border-radius: 16px;
            padding: 18px;
            cursor: pointer;
            text-align: center;
            background: #f9fbff;
            transition: all .15s ease;
        }

        .sp-drop-active {
            border-color: #111;
            transform: translateY(-1px);
        }

        .sp-drop-title {
            font-weight: 900;
            color: #111;
        }

        .sp-drop-sub {
            font-size: 13px;
            color: #667;
            margin-top: 2px;
        }

        .sp-preview {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .sp-thumb {
            border: 1px solid #eef2f8;
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
        }

        .sp-thumb img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            display: block;
        }

        .sp-thumb-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 10px;
            border-top: 1px solid #f0f3f9;
        }

        .sp-thumb-badge {
            font-size: 11px;
            font-weight: 900;
            padding: 4px 8px;
            border-radius: 999px;
            background: #eef2ff;
            color: #3730a3;
        }

        .sp-thumb-remove {
            font-size: 12px;
            font-weight: 900;
            border: 0;
            background: transparent;
            color: #991b1b;
            padding: 0;
        }

        .sp-thumb-remove:hover {
            text-decoration: underline;
        }

        @media (max-width:576px) {
            .sd-title {
                font-size: 22px;
            }

            .sp-preview {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .sp-thumb img {
                height: 90px;
            }
        }
    </style>
</head>

<body class="sd-body">

    <nav class="navbar navbar-expand-lg sd-navbar border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold sd-brand" href="{{ route('seller.dashboard') }}">
                OnlineMarketBD • Seller Panel
            </a>

            <div class="ms-auto d-flex align-items-center gap-2">
                <span class="sd-user-pill">
                    {{ auth('classified_ad')->user()->name ?? auth()->user()->name ?? 'My Account' }}
                </span>

                <a class="btn btn-sm btn-outline-dark" href="{{ url('/') }}">View Site</a>

                <form action="{{ route('seller.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-dark">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container py-4">

        <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3 mb-3">
            <div>
                <div class="sd-title">Post New Ad</div>
                <div class="sd-subtitle">Add clear title, price, category, contact info and quality photos to get more responses.</div>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a class="btn btn-outline-dark sd-btn" href="{{ url()->previous() }}">← Back</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success sd-alert">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger sd-alert">
                <div class="fw-bold mb-1">Fix these:</div>
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-12 col-lg-8">

                    <div class="sd-section mb-3">
                        <div class="sd-section-title">Basic Info</div>
                        <div class="sd-section-sub">Write the title and description buyers understand instantly.</div>

                        <div class="row g-3 mt-1">
                            <div class="col-12">
                                <label class="form-label sd-label">Ad Title *</label>
                                <input type="text" name="title" id="spTitle" value="{{ old('title') }}"
                                    class="form-control sd-input" placeholder="Ex: Used iPhone 13 Pro Max 256GB" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label sd-label">Slug (auto)</label>
                                <input type="text" name="slug" id="spSlug" value="{{ old('slug') }}"
                                    class="form-control sd-input" placeholder="used-iphone-13-pro-max-256gb">
                                <div class="sd-help">Used in URL. You can edit this manually.</div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label sd-label">Location</label>
                                <input type="text" name="location" value="{{ old('location') }}"
                                    class="form-control sd-input" placeholder="Ex: Mirpur, Dhaka">
                                <div class="sd-help">Mention city, area or pickup location.</div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label sd-label">Category (Parent) *</label>
                                <select name="parent_category_id" id="spParentCat" class="form-select sd-input">
                                    <option value="">Select category</option>
                                    @foreach(($parentCategories ?? []) as $pc)
                                        <option value="{{ $pc->id }}"
                                            {{ (string) old('parent_category_id') === (string) $pc->id ? 'selected' : '' }}>
                                            {{ $pc->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="sd-help">Choose a main category first.</div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label sd-label">Subcategory (Optional)</label>
                                <select name="seller_category_id" id="spChildCat" class="form-select sd-input" disabled>
                                    <option value="">Select subcategory</option>
                                </select>
                                <div class="sd-help">If available, choose the best matching subcategory.</div>
                            </div>

                            <div class="col-12">
                                <label class="form-label sd-label">Description</label>
                                <textarea name="description" class="form-control sd-input" rows="6"
                                    placeholder="Write full details: condition, features, accessories, warranty, reason for sale, delivery option...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="sd-section mb-3">
                        <div class="sd-section-title">Pricing</div>
                        <div class="sd-section-sub">Set clear pricing so buyers know what to expect.</div>

                        <div class="row g-3 mt-1">
                            <div class="col-12 col-md-4">
                                <label class="form-label sd-label">Price</label>
                                <input type="number" step="0.01" min="0" name="price"
                                    value="{{ old('price') }}" class="form-control sd-input"
                                    placeholder="Ex: 25000">
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label sd-label">Price Type</label>
                                <select name="price_type" class="form-select sd-input">
                                    <option value="fixed" {{ old('price_type', 'fixed') === 'fixed' ? 'selected' : '' }}>Fixed</option>
                                    <option value="negotiable" {{ old('price_type') === 'negotiable' ? 'selected' : '' }}>Negotiable</option>
                                    <option value="call" {{ old('price_type') === 'call' ? 'selected' : '' }}>Call for price</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label sd-label">Condition</label>
                                <select name="condition_type" class="form-select sd-input">
                                    <option value="">Select condition</option>
                                    <option value="new" {{ old('condition_type') === 'new' ? 'selected' : '' }}>New</option>
                                    <option value="used" {{ old('condition_type') === 'used' ? 'selected' : '' }}>Used</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="sd-section mb-3">
                        <div class="sd-section-title">Contact Information</div>
                        <div class="sd-section-sub">This info will help buyers contact the ad owner quickly.</div>

                        <div class="row g-3 mt-1">
                            <div class="col-12 col-md-4">
                                <label class="form-label sd-label">Contact Name *</label>
                                <input type="text" name="contact_name" value="{{ old('contact_name', auth('classified_ad')->user()->name ?? auth()->user()->name ?? '') }}"
                                    class="form-control sd-input" placeholder="Ex: Rahim" required>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label sd-label">Contact Email</label>
                                <input type="email" name="contact_email" value="{{ old('contact_email', auth('classified_ad')->user()->email ?? auth()->user()->email ?? '') }}"
                                    class="form-control sd-input" placeholder="Ex: name@email.com">
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label sd-label">Contact Phone *</label>
                                <input type="text" name="contact_phone" value="{{ old('contact_phone', auth('classified_ad')->user()->phone ?? '') }}"
                                    class="form-control sd-input" placeholder="Ex: 017XXXXXXXX" required>
                            </div>
                        </div>
                    </div>

                    <div class="sd-section">
                        <div class="sd-section-title">Publishing</div>
                        <div class="sd-section-sub">Choose whether to publish now or keep it pending.</div>

                        <div class="row g-3 mt-1">
                            <div class="col-12 col-md-6">
                                <label class="form-label sd-label">Status</label>
                                <select name="status" class="form-select sd-input">
                                    <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label sd-label">Expiry Date (optional)</label>
                                <input type="datetime-local" name="expires_at"
                                    value="{{ old('expires_at') }}" class="form-control sd-input">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-12 col-lg-4">

                    <div class="sd-section mb-3">
                        <div class="sd-section-title">Ad Images</div>
                        <div class="sd-section-sub">Upload up to 10 images. First image becomes primary.</div>

                        <div class="sp-drop mt-2" id="spDrop" role="button" tabindex="0">
                            <div class="sp-drop-title">Drag & drop images here</div>
                            <div class="sp-drop-sub">or click to choose files</div>
                        </div>

                        <input type="file" name="images[]" id="spImages" class="d-none" accept="image/*" multiple>

                        <div class="sp-preview mt-3" id="spPreview"></div>

                        <div class="sd-help mt-2">
                            Tip: Use real, bright and clear photos from multiple angles.
                        </div>
                    </div>

                    <div class="sd-section">
                        <div class="sd-section-title">Save</div>
                        <div class="sd-section-sub">Choose what happens after save.</div>

                        <div class="d-grid gap-2 mt-2">
                            <button type="submit" class="btn btn-dark sd-btn">Save Ad</button>
                            <button type="submit" name="save_next" value="1" class="btn btn-outline-dark sd-btn">
                                Save & Add Another
                            </button>
                        </div>

                        <div class="sd-tip mt-3">
                            <div class="sd-tip-title">Pro tip</div>
                            <div class="sd-tip-text">Use 5–7 real images and write honest condition details for better response.</div>
                        </div>
                    </div>

                </div>
            </div>

        </form>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function slugify(text) {
            return text.toString().toLowerCase()
                .trim()
                .replace(/[\s\_]+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-');
        }

        const titleEl = document.getElementById('spTitle');
        const slugEl = document.getElementById('spSlug');
        let slugTouched = false;

        if (slugEl) {
            slugEl.addEventListener('input', () => slugTouched = true);
        }

        if (titleEl) {
            titleEl.addEventListener('input', () => {
                if (!slugTouched && slugEl) slugEl.value = slugify(titleEl.value);
            });
        }

        const parentCat = document.getElementById('spParentCat');
        const childCat = document.getElementById('spChildCat');
        const childrenUrl = "{{ route('seller.categories.children') }}";
        const oldChildId = "{{ old('seller_category_id') }}";

        function setChildDisabled(state) {
            childCat.disabled = !!state;
            childCat.classList.toggle('opacity-75', !!state);
        }

        function resetChild(message) {
            childCat.innerHTML = `<option value="">${message || 'Select subcategory'}</option>`;
            setChildDisabled(true);
        }

        async function loadChildren(parentId, preselectId = '') {
            resetChild('Loading…');

            try {
                const res = await fetch(`${childrenUrl}?parent_id=${encodeURIComponent(parentId)}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const json = await res.json();
                const rows = (json && json.data) ? json.data : [];

                if (!rows.length) {
                    resetChild('No subcategory (optional)');
                    return;
                }

                childCat.innerHTML = `<option value="">Select subcategory</option>`;

                rows.forEach(r => {
                    const opt = document.createElement('option');
                    opt.value = r.id;
                    opt.textContent = r.name;

                    if (String(preselectId) && String(preselectId) === String(r.id)) {
                        opt.selected = true;
                    }

                    childCat.appendChild(opt);
                });

                setChildDisabled(false);
            } catch (e) {
                resetChild('Failed to load');
            }
        }

        parentCat?.addEventListener('change', () => {
            const pid = parentCat.value;
            if (!pid) {
                resetChild('Select subcategory');
                return;
            }
            loadChildren(pid, '');
        });

        (function initCategory() {
            const pid = parentCat?.value;
            if (pid) loadChildren(pid, oldChildId);
        })();

        const fileInput = document.getElementById('spImages');
        const preview = document.getElementById('spPreview');
        const drop = document.getElementById('spDrop');

        drop.addEventListener('click', (e) => {
            e.preventDefault();
            fileInput.click();
        });

        drop.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                fileInput.click();
            }
        });

        drop.addEventListener('dragover', (e) => {
            e.preventDefault();
            drop.classList.add('sp-drop-active');
        });

        drop.addEventListener('dragleave', () => drop.classList.remove('sp-drop-active'));

        drop.addEventListener('drop', (e) => {
            e.preventDefault();
            drop.classList.remove('sp-drop-active');

            if (e.dataTransfer.files && e.dataTransfer.files.length) {
                const dt = new DataTransfer();

                Array.from(fileInput.files).forEach(f => dt.items.add(f));
                Array.from(e.dataTransfer.files).forEach(f => dt.items.add(f));

                fileInput.files = dt.files;
                renderPreviews();
            }
        });

        fileInput.addEventListener('change', renderPreviews);

        function renderPreviews() {
            preview.innerHTML = '';
            const files = Array.from(fileInput.files || []);

            if (!files.length) return;

            files.slice(0, 10).forEach((file, idx) => {
                const url = URL.createObjectURL(file);

                const item = document.createElement('div');
                item.className = 'sp-thumb';

                item.innerHTML = `
                    <img src="${url}" alt="preview">
                    <div class="sp-thumb-bar">
                        <div class="sp-thumb-badge">${idx === 0 ? 'Primary' : 'Image'}</div>
                        <button type="button" class="sp-thumb-remove" data-index="${idx}">Remove</button>
                    </div>
                `;

                preview.appendChild(item);
            });

            preview.querySelectorAll('.sp-thumb-remove').forEach(btn => {
                btn.addEventListener('click', () => {
                    const removeIndex = parseInt(btn.getAttribute('data-index'));
                    const dt = new DataTransfer();

                    Array.from(fileInput.files).forEach((f, i) => {
                        if (i !== removeIndex) dt.items.add(f);
                    });

                    fileInput.files = dt.files;
                    renderPreviews();
                });
            });
        }
    </script>

</body>

</html>