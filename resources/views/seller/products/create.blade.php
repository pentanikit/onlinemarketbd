<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OnlineMarketBD • Add Product</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Reuse your Seller Dashboard base look */
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

        .sd-shop-pill {
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

        /* Dropzone */
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

        /* Preview grid */
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
                <span class="sd-shop-pill">
                    {{ $shop->shop_name ?? 'My Shop' }}
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

        <div
            class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3 mb-3">
            <div>
                <div class="sd-title">Add Product</div>
                <div class="sd-subtitle">Fast entry, clean photos, correct BDT price. Your catalog will look pro.</div>
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
                <!-- Left: main form -->
                <div class="col-12 col-lg-8">

                    <div class="sd-section mb-3">
                        <div class="sd-section-title">Basic Info</div>
                        <div class="sd-section-sub">Name + details customers understand instantly.</div>

                        <div class="row g-3 mt-1">
                            <div class="col-12">
                                <label class="form-label sd-label">Product Name *</label>
                                <input type="text" name="name" id="spName" value="{{ old('name') }}"
                                    class="form-control sd-input" placeholder="Ex: Premium Cotton T-Shirt" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label sd-label">Slug (auto)</label>
                                <input type="text" name="slug" id="spSlug" value="{{ old('slug') }}"
                                    class="form-control sd-input" placeholder="premium-cotton-t-shirt">
                                <div class="sd-help">Used in URL. You can edit if you want.</div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label sd-label">SKU (optional)</label>
                                <input type="text" name="sku" value="{{ old('sku') }}"
                                    class="form-control sd-input" placeholder="Ex: TS-RED-M-001">
                                <div class="sd-help">Helpful for inventory (unique per shop).</div>
                            </div>

                            <!-- ✅ NEW: Category + Subcategory -->
                            <div class="col-12 col-md-6">
                                <label class="form-label sd-label">Category (Parent) *</label>
                                <select name="parent_category_id" id="spParentCat" class="form-select sd-input">
                                    <option value="">Select category</option>
                                    @foreach(($parentCategories ?? []) as $pc)
                                        <option value="{{ $pc->id }}"
                                            {{ (string)old('parent_category_id') === (string)$pc->id ? 'selected' : '' }}>
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
                                <div class="sd-help">If the category has subcategories, pick one.</div>
                            </div>
                            <!-- ✅ END: Category + Subcategory -->

                            <div class="col-12">
                                <label class="form-label sd-label">Short Description (optional)</label>
                                <textarea name="short_description" class="form-control sd-input" rows="2" placeholder="One short selling line…">{{ old('short_description') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label sd-label">Full Description (optional)</label>
                                <textarea name="description" class="form-control sd-input" rows="6"
                                    placeholder="Write details: fabric, warranty, delivery, what’s included…">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="sd-section mb-3">
                        <div class="sd-section-title">Pricing (BDT)</div>
                        <div class="sd-section-sub">Use clear price. Compare price shows discount.</div>

                        <div class="row g-3 mt-1">
                            <div class="col-12 col-md-4">
                                <label class="form-label sd-label">Price *</label>
                                <input type="number" step="0.01" min="0" name="price"
                                    value="{{ old('price', 0) }}" class="form-control sd-input" required>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label sd-label">Compare Price (optional)</label>
                                <input type="number" step="0.01" min="0" name="compare_price"
                                    value="{{ old('compare_price') }}" class="form-control sd-input"
                                    placeholder="Ex: 1490">
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label sd-label">Cost Price (optional)</label>
                                <input type="number" step="0.01" min="0" name="cost_price"
                                    value="{{ old('cost_price') }}" class="form-control sd-input"
                                    placeholder="Your buying cost">
                            </div>
                        </div>
                    </div>

                    <div class="sd-section mb-3">
                        <div class="sd-section-title">Stock</div>
                        <div class="sd-section-sub">Simple inventory controls.</div>

                        <div class="row g-3 mt-1 align-items-end">
                            <div class="col-12 col-md-4">
                                <label class="form-label sd-label">Stock Qty</label>
                                <input type="number" min="0" name="stock_qty"
                                    value="{{ old('stock_qty', 0) }}" class="form-control sd-input">
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="form-check sd-check">
                                    <input class="form-check-input" type="checkbox" name="track_stock"
                                        value="1" id="spTrack" {{ old('track_stock', 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="spTrack">Track stock</label>
                                </div>
                                <div class="form-check sd-check mt-1">
                                    <input class="form-check-input" type="checkbox" name="allow_backorder"
                                        value="1" id="spBackorder"
                                        {{ old('allow_backorder') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="spBackorder">Allow backorder</label>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="form-label sd-label">Status</label>
                                <select name="status" class="form-select sd-input">
                                    <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>
                                        Draft</option>
                                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="sd-section mb-3">
                        <div class="sd-section-title">Advanced (Flexible)</div>
                        <div class="sd-section-sub">
                            Type attributes in comma separated format like:
                            <strong>Color: Black, green</strong> and <strong>Size: M, L, XL</strong>.
                            This will be saved as plain text (string).
                        </div>

                        <div class="row g-3 mt-1">
                            <!-- ✅ Attributes saved as string -->
                            <div class="col-12">
                                <label class="form-label sd-label">Attributes (comma format)</label>
                                <textarea name="attributes_text" id="spAttrText" class="form-control sd-input" rows="4"
                                    placeholder="Color: Black, green Size: M, L, XL Material: Cotton">{{ old('attributes_text') }}</textarea>

                                <div class="sd-help">
                                    One line per attribute. Use <strong>:</strong> between key and values. Values
                                    separated by comma.
                                    Example: <strong>Color: Black, Green</strong>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label sd-label">Variants JSON (optional)</label>
                                <textarea name="variants_json" class="form-control sd-input" rows="3"
                                    placeholder='option: Black / M, sku: TS-BLK-M, price: 990, stock: 10'>{{ old('variants_json') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label sd-label">Shipping JSON (optional)</label>
                                <textarea name="shipping_json" class="form-control sd-input" rows="3"
                                    placeholder='inside_dhaka: 80, outside_dhaka: 130, weight: 1.2, unit: kg'>{{ old('shipping_json') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="sd-section">
                        <div class="sd-section-title">SEO (Optional)</div>
                        <div class="sd-section-sub">Helps Google understand your product.</div>

                        <div class="row g-3 mt-1">
                            <div class="col-12">
                                <label class="form-label sd-label">SEO Title</label>
                                <input type="text" name="seo_title" value="{{ old('seo_title') }}"
                                    class="form-control sd-input"
                                    placeholder="Ex: Premium Cotton T-Shirt Price in BD">
                            </div>

                            <div class="col-12">
                                <label class="form-label sd-label">SEO Description</label>
                                <input type="text" name="seo_description" value="{{ old('seo_description') }}"
                                    class="form-control sd-input"
                                    placeholder="Short meta description (max ~155 chars)">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right: images + actions -->
                <div class="col-12 col-lg-4">

                    <div class="sd-section mb-3">
                        <div class="sd-section-title">Product Images</div>
                        <div class="sd-section-sub">Upload up to 10 images. First image becomes primary.</div>

                        <div class="sp-drop mt-2" id="spDrop" role="button" tabindex="0">
                            <div class="sp-drop-title">Drag & drop images here</div>
                            <div class="sp-drop-sub">or click to choose files</div>
                        </div>

                        <input type="file" name="images[]" id="spImages" class="d-none" accept="image/*" multiple>

                        <div class="sp-preview mt-3" id="spPreview"></div>

                        <div class="sd-help mt-2">
                            Tip: Use 1:1 square + bright background. Looks premium.
                        </div>
                    </div>

                    <div class="sd-section">
                        <div class="sd-section-title">Save</div>
                        <div class="sd-section-sub">Choose what happens after save.</div>

                        <div class="d-grid gap-2 mt-2">
                            <button type="submit" class="btn btn-dark sd-btn">Save Product</button>
                            <button type="submit" name="save_next" value="1"
                                class="btn btn-outline-dark sd-btn">
                                Save & Add Another
                            </button>
                        </div>

                        <div class="sd-tip mt-3">
                            <div class="sd-tip-title">Pro tip</div>
                            <div class="sd-tip-text">Use 5–7 photos. Real images = higher trust = more orders.</div>
                        </div>
                    </div>

                </div>
            </div>

        </form>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /* slug auto */
        function slugify(text) {
            return text.toString().toLowerCase()
                .trim()
                .replace(/[\s\_]+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-');
        }

        const nameEl = document.getElementById('spName');
        const slugEl = document.getElementById('spSlug');
        let slugTouched = false;

        slugEl.addEventListener('input', () => slugTouched = true);
        nameEl.addEventListener('input', () => {
            if (!slugTouched) slugEl.value = slugify(nameEl.value);
        });

        /* ✅ Category -> Subcategory loader */
        const parentCat = document.getElementById('spParentCat');
        const childCat  = document.getElementById('spChildCat');

        const childrenUrl = "{{ route('seller.categories.children') }}";
        const oldChildId  = "{{ old('seller_category_id') }}";

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
                    headers: { 'Accept': 'application/json' }
                });
                const json = await res.json();
                const rows = (json && json.data) ? json.data : [];

                if (!rows.length) {
                    // no subcategories -> keep disabled, parent will be saved
                    resetChild('No subcategory (optional)');
                    return;
                }

                childCat.innerHTML = `<option value="">Select subcategory</option>`;
                rows.forEach(r => {
                    const opt = document.createElement('option');
                    opt.value = r.id;
                    opt.textContent = r.name;
                    if (String(preselectId) && String(preselectId) === String(r.id)) opt.selected = true;
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

        // On page load (old input)
        (function initCategory() {
            const pid = parentCat?.value;
            if (pid) loadChildren(pid, oldChildId);
        })();

        /* image preview + remove (DataTransfer trick) */
        const fileInput = document.getElementById('spImages');
        const preview = document.getElementById('spPreview');
        const drop = document.getElementById('spDrop');

        // ✅ open picker ONLY from dropzone
        drop.addEventListener('click', (e) => {
            e.preventDefault();
            fileInput.click();
        });

        // optional: Enter/Space support for accessibility
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
                // merge existing + dropped
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

            // remove handlers
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
