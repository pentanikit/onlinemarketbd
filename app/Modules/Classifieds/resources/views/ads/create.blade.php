@extends('classifieds::layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold">Post Ad</h1>
           
        </div>

<form id="classifiedAdForm" action="{{ route('classifieds.ads.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-6">
    @csrf

    <div>
        <h2 class="text-lg font-semibold mb-3">Your Info</h2>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border border-gray-300 px-4 py-3" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Phone *</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-lg border border-gray-300 px-4 py-3" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border border-gray-300 px-4 py-3">
            </div>
        </div>
    </div>

    <div>
        <h2 class="text-lg font-semibold mb-3">Ad Details</h2>
        <div class="grid md:grid-cols-2 gap-4">

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Ad Category *</label>
                <select name="category_id" class="w-full rounded-lg border border-gray-300 px-4 py-3" required>
                    <option value="">Select a category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full rounded-lg border border-gray-300 px-4 py-3" placeholder="e.g. iPhone 13 128GB Excellent Condition" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Price</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full rounded-lg border border-gray-300 px-4 py-3">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Price Type</label>
                <select name="price_type" class="w-full rounded-lg border border-gray-300 px-4 py-3">
                    <option value="fixed" {{ old('price_type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                    <option value="negotiable" {{ old('price_type') == 'negotiable' ? 'selected' : '' }}>Negotiable</option>
                    <option value="call" {{ old('price_type') == 'call' ? 'selected' : '' }}>Call for price</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Condition</label>
                <select name="condition_type" class="w-full rounded-lg border border-gray-300 px-4 py-3">
                    <option value="">Select</option>
                    <option value="new" {{ old('condition_type') == 'new' ? 'selected' : '' }}>New</option>
                    <option value="used" {{ old('condition_type') == 'used' ? 'selected' : '' }}>Used</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Location</label>
                <input type="text" name="location" value="{{ old('location') }}" class="w-full rounded-lg border border-gray-300 px-4 py-3" placeholder="Dhaka">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" rows="5" class="w-full rounded-lg border border-gray-300 px-4 py-3" placeholder="Write a short description">{{ old('description') }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-2">Images</label>

                <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-5">
                    <input
                        type="file"
                        id="imageInput"
                        name="images[]"
                        multiple
                        accept="image/*"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3"
                    >
                    <p class="text-xs text-gray-500 mt-2">
                        Up to {{ config('classifieds.max_images', 5) }} images. JPG, PNG, WEBP supported.
                    </p>

                    <div id="previewWrapper" class="mt-4 hidden">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Selected Images</h3>
                        <div id="imagePreviewGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit" id="submitBtn" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-xl inline-flex items-center gap-2 transition disabled:opacity-70 disabled:cursor-not-allowed">
            <span id="buttonText">Submit Ad</span>
            <span id="loadingSpinner" class="hidden">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        </button>
    </div>
</form>


    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('classifiedAdForm');
        const submitBtn = document.getElementById('submitBtn');
        const buttonText = document.getElementById('buttonText');
        const loadingSpinner = document.getElementById('loadingSpinner');

        form.addEventListener('submit', function (e) {
            if (!form.checkValidity()) {
                return;
            }

            submitBtn.disabled = true;
            buttonText.textContent = 'Submitting...';
            loadingSpinner.classList.remove('hidden');
        });
    });
</script>
    <script>
        (function () {
            const input = document.getElementById('imageInput');
            const previewWrapper = document.getElementById('previewWrapper');
            const previewGrid = document.getElementById('imagePreviewGrid');
            const maxImages = {{ (int) config('classifieds.max_images', 5) }};

            let selectedFiles = [];

            function bytesToSize(bytes) {
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                if (bytes === 0) return '0 Byte';
                const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)), 10);
                return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
            }

            function syncInputFiles() {
                const dataTransfer = new DataTransfer();

                selectedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });

                input.files = dataTransfer.files;
            }

            function renderPreviews() {
                previewGrid.innerHTML = '';

                if (selectedFiles.length === 0) {
                    previewWrapper.classList.add('hidden');
                    return;
                }

                previewWrapper.classList.remove('hidden');

                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const item = document.createElement('div');
                        item.className = 'relative rounded-2xl overflow-hidden border border-gray-200 bg-white shadow-sm';

                        item.innerHTML = `
                            <div class="aspect-square bg-gray-100">
                                <img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">
                            </div>
                            <div class="p-2">
                                <p class="text-xs font-medium text-gray-700 truncate" title="${file.name}">${file.name}</p>
                                <p class="text-[11px] text-gray-500 mt-1">${bytesToSize(file.size)}</p>
                            </div>
                            <button
                                type="button"
                                class="absolute top-2 right-2 bg-black/70 hover:bg-black text-white text-xs px-2 py-1 rounded-lg"
                                data-index="${index}"
                            >
                                Remove
                            </button>
                        `;

                        previewGrid.appendChild(item);
                    };

                    reader.readAsDataURL(file);
                });
            }

            input.addEventListener('change', function (event) {
                const files = Array.from(event.target.files);

                if (!files.length) return;

                let merged = [...selectedFiles, ...files];

                const uniqueMap = new Map();
                merged.forEach(file => {
                    const key = `${file.name}_${file.size}_${file.lastModified}`;
                    if (!uniqueMap.has(key)) {
                        uniqueMap.set(key, file);
                    }
                });

                merged = Array.from(uniqueMap.values()).slice(0, maxImages);
                selectedFiles = merged;

                syncInputFiles();
                renderPreviews();
            });

            previewGrid.addEventListener('click', function (event) {
                const button = event.target.closest('button[data-index]');
                if (!button) return;

                const index = parseInt(button.getAttribute('data-index'), 10);
                selectedFiles.splice(index, 1);

                syncInputFiles();
                renderPreviews();
            });
        })();
    </script>
@endsection