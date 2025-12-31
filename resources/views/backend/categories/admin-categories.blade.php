@extends('backend.layout')
@section('admin')
    <main class="main-content">
        <div class="container-fluid py-2">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h4 class="mb-1">Categories</h4>
                    <p class="mb-0 text-muted small">Manage listing categories and sub-categories.</p>
                </div>

                <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#categoryModal"
                    data-mode="create"
                    data-action="{{ route('categories.store') }}"
                >
                    <i class="bi bi-plus-lg me-1"></i> Add New
                </button>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Done!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Fix these:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-3 mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('categories.index') }}">
                        <div class="row g-2">
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                                    <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Search categories...">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <select class="form-select" name="type">
                                    <option value="all" {{ request('type', 'all') === 'all' ? 'selected' : '' }}>Type: All</option>
                                    <option value="primary" {{ request('type') === 'primary' ? 'selected' : '' }}>Primary</option>
                                    <option value="sub" {{ request('type') === 'sub' ? 'selected' : '' }}>Sub-category</option>
                                </select>
                            </div>
                            <div class="col-lg-3 d-grid">
                                <button class="btn btn-outline-primary" type="submit">Apply</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="min-width: 220px;">Name</th>
                                    <th>Slug</th>
                                    <th>Parent</th>
                                    <th>Listings</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $cat)
                                    <tr>
                                        <td class="fw-semibold">
                                            <div class="d-flex align-items-center gap-2">
                                                {{-- NOTE: you can update this later to show category image thumbnail --}}
                                                @if($cat->icon_class)
                                                    <span class="text-muted"><i class="{{ $cat->icon_class }}"></i></span>
                                                @else
                                                    <span class="text-muted"><i class="bi bi-tag"></i></span>
                                                @endif
                                                <div>
                                                    {{ $cat->name }}
                                                    @if($cat->parent_id)
                                                        <div class="small text-muted">Sub-category</div>
                                                    @else
                                                        <div class="small text-muted">Primary</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge text-bg-light">{{ $cat->slug }}</span>
                                        </td>
                                        <td>
                                            {{ $cat->parent?->name ?? '—' }}
                                        </td>
                                        <td>
                                            {{ $cat->listings_count ?? 0 }}
                                        </td>
                                        <td class="text-end">
                                            <button
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#categoryModal"
                                                data-mode="edit"
                                                data-action="{{ route('categories.update', $cat->id) }}"
                                                data-id="{{ $cat->id }}"
                                                data-name="{{ $cat->name }}"
                                                data-slug="{{ $cat->slug }}"
                                                data-parent_id="{{ $cat->parent_id }}"
                                                data-sort_order="{{ $cat->sort_order }}"
                                                data-image_url="{{ $cat->image ? asset('storage/'.$cat->image) : '' }}"
                                            >
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Delete this category? Child categories will also be deleted (cascade).');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" type="submit">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            No categories found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>


<div class="list-pagination-bar mt-3">
    <small class="text-muted">
        @if(method_exists($listings, 'firstItem') && $listings->total() > 0)
            Showing {{ $listings->firstItem() }}–{{ $listings->lastItem() }} of {{ $listings->total() }}
        @else
            Showing 0 of 0
        @endif
    </small>

    <div class="list-pagination-links">
        {{ $listings->appends(request()->query())->onEachSide(1)->links() }}
    </div>
</div>

                </div>
            </div>

            <div class="app-footer text-center">&copy; <span id="yearSpan"></span> Directory Admin</div>
        </div>
    </main>

    <!-- Add/Edit Category Modal -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="categoryForm" method="POST" action="{{ route('categories.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="categoryMethod" value="POST">

                    <div class="modal-header">
                        <h5 class="modal-title" id="categoryModalTitle">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label small">Name</label>
                            <input name="name" id="catName" class="form-control" placeholder="e.g. Restaurants" required>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Slug <span class="text-muted">(optional)</span></label>
                            <input name="slug" id="catSlug" class="form-control" placeholder="restaurants">
                            <div class="form-text">Leave blank to auto-generate from name.</div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Parent (optional)</label>
                            <select name="parent_id" id="catParent" class="form-select">
                                <option value="">— None —</option>
                                @foreach($parents as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Select a parent to make it a sub-category.</div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label small">Category image <span class="text-muted">(optional)</span></label>
                            <input
                                type="file"
                                name="image"
                                id="catImage"
                                class="form-control"
                                accept="image/png,image/jpeg,image/webp,image/svg+xml"
                            >
                            <div class="form-text">PNG/JPG/WEBP/SVG. Recommended: square (e.g. 256×256).</div>

                            {{-- Preview UI --}}
                            <div class="mt-2" id="catImagePreviewWrap" style="display:none;">
                                <div class="d-flex align-items-center gap-2">
                                    <img id="catImagePreview" alt="Preview"
                                         style="width:64px;height:64px;object-fit:cover;border-radius:10px;border:1px solid rgba(0,0,0,.12);">
                                    <div class="small">
                                        <div class="fw-semibold" id="catImagePreviewTitle">Preview</div>
                                        <div class="text-muted" id="catImageMeta"></div>
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-1" id="catImageRemoveBtn">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label small">Sort order</label>
                            <input name="sort_order" id="catSort" type="number" min="0" class="form-control" placeholder="0">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="categorySaveBtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const modal = document.getElementById('categoryModal');
            if (!modal) return;

            const form   = document.getElementById('categoryForm');
            const method = document.getElementById('categoryMethod');
            const title  = document.getElementById('categoryModalTitle');

            const nameEl   = document.getElementById('catName');
            const slugEl   = document.getElementById('catSlug');
            const parentEl = document.getElementById('catParent');
            const sortEl   = document.getElementById('catSort');
            const imgEl    = document.getElementById('catImage');

            // Preview elements
            const previewWrap  = document.getElementById('catImagePreviewWrap');
            const previewImg   = document.getElementById('catImagePreview');
            const previewMeta  = document.getElementById('catImageMeta');
            const previewTitle = document.getElementById('catImagePreviewTitle');
            const removeBtn    = document.getElementById('catImageRemoveBtn');

            let objectUrl = null;

            function hidePreview() {
                if (objectUrl) {
                    URL.revokeObjectURL(objectUrl);
                    objectUrl = null;
                }
                if (previewImg) previewImg.src = '';
                if (previewMeta) previewMeta.textContent = '';
                if (previewWrap) previewWrap.style.display = 'none';
                if (previewTitle) previewTitle.textContent = 'Preview';
            }

            function showPreviewFromFile(file) {
                if (!file) { hidePreview(); return; }
                if (!file.type || !file.type.startsWith('image/')) { hidePreview(); return; }

                if (objectUrl) URL.revokeObjectURL(objectUrl);
                objectUrl = URL.createObjectURL(file);

                previewImg.src = objectUrl;
                const sizeKB = Math.round(file.size / 1024);
                previewMeta.textContent = `${file.name} • ${sizeKB} KB`;
                previewWrap.style.display = 'block';
                previewTitle.textContent = 'Preview';
            }

            function showPreviewFromUrl(url) {
                if (!url) { hidePreview(); return; }
                hidePreview(); // ensure clean state
                previewImg.src = url;
                previewMeta.textContent = 'Current image';
                previewWrap.style.display = 'block';
                previewTitle.textContent = 'Current image';
            }

            if (imgEl) {
                imgEl.addEventListener('change', function () {
                    const file = this.files && this.files[0] ? this.files[0] : null;
                    showPreviewFromFile(file);
                });
            }

            if (removeBtn) {
                removeBtn.addEventListener('click', function () {
                    if (imgEl) imgEl.value = '';
                    hidePreview();
                });
            }

            modal.addEventListener('show.bs.modal', function (event) {
                const btn = event.relatedTarget;
                if (!btn) return;

                const mode = btn.getAttribute('data-mode') || 'create';
                const action = btn.getAttribute('data-action');

                // Reset
                form.reset();
                parentEl.value = "";
                if (imgEl) imgEl.value = "";
                hidePreview();

                if (mode === 'edit') {
                    title.textContent = 'Edit Category';
                    form.action = action;
                    method.value = 'PUT';

                    nameEl.value = btn.getAttribute('data-name') || '';
                    slugEl.value = btn.getAttribute('data-slug') || '';
                    sortEl.value = btn.getAttribute('data-sort_order') || 0;

                    const pid = btn.getAttribute('data-parent_id');
                    parentEl.value = (pid && pid !== 'null') ? pid : "";

                    // Show current image preview (if exists)
                    const imageUrl = btn.getAttribute('data-image_url') || '';
                    if (imageUrl) showPreviewFromUrl(imageUrl);

                } else {
                    title.textContent = 'Add Category';
                    form.action = action;
                    method.value = 'POST';
                }
            });

            modal.addEventListener('hidden.bs.modal', function () {
                hidePreview();
                if (imgEl) imgEl.value = '';
            });
        })();
    </script>
@endsection
