@extends('admin.layouts.master')

@section('title', 'Edit Product')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading">
                    <i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > Edit Product
                </span>
            </div>

            <!-- Edit Product Form -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-edit me-1"></i> Edit Product</div>
                    <a href="{{ route('products.index') }}" class="btn btn-addnew">
                        <i class="fa fa-file-alt"></i> View All
                    </a>
                </div>
                <div class="card-body table-card-body">
                    <div class="row">
                        <form method="POST" action="{{ route('products.update', $product->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="form-group row mt-2">
                                    <!-- Product Code -->
                                    <label class="col-sm-1 col-form-label">Code</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm"
                                            value="{{ $product->product_code }}" readonly>
                                    </div>

                                    <!-- Product Name -->
                                    <label for="product_name" class="col-sm-1 col-form-label">Name <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="product_name"
                                            name="name" value="{{ old('name', $product->name) }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Category -->
                                    <label for="category_id" class="col-sm-1 col-form-label">Category <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-3">
                                        <select class="form-select form-select-sm" name="category_id" id="category_id"
                                            style="padding: 0.5rem 0.75rem;">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mt-2">
                                    <!-- Subcategory -->
                                    <label for="sub_category_id" class="col-sm-1 col-form-label">S_Cat <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-3">
                                        <select class="form-select form-select-sm" name="sub_category_id"
                                            id="sub_category_id" style="padding: 0.5rem 0.75rem;">
                                            <option value="">Select Subcategory</option>
                                            @foreach ($subCategories as $subCategory)
                                                <option value="{{ $subCategory->id }}"
                                                    {{ old('sub_category_id', $product->sub_category_id) == $subCategory->id ? 'selected' : '' }}>
                                                    {{ $subCategory->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sub_category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Brand -->
                                    <label for="client_id" class="col-sm-1 col-form-label">Brand <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-3">
                                        <select class="form-select form-select-sm" name="client_id" id="client_id"
                                            style="padding: 0.5rem 0.75rem;">
                                            <option value="">Select Brand</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}"
                                                    {{ old('client_id', $product->client_id) == $client->id ? 'selected' : '' }}>
                                                    {{ $client->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('client_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Product Thumbnail -->
                                    <label for="thumbnail_image" class="col-sm-1 col-form-label">Image</label>
                                    <div class="col-sm-3">
                                        <div class="d-flex align-items-center">
                                            <img id="thumbPreview"
                                                src="{{ $product->thumbnail_image ? asset($product->thumbnail_image) : asset('uploads/no_images/no-image.png') }}"
                                                alt="Thumbnail Preview" width="40" class="me-2">
                                            <input type="file" class="form-control form-control-sm" id="thumbnail_image"
                                                name="thumbnail_image" accept="image/*" onchange="previewThumbnail(event)">
                                        </div>
                                        @error('thumbnail_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mt-2">
                                    <!-- Gallery Images -->
                                    <label for="gallery_images" class="col-sm-1 col-form-label">M. Image</label>
                                    <div class="col-sm-3">
                                        <input type="file" class="form-control form-control-sm" id="gallery_images"
                                            name="gallery_images[]" multiple accept="image/*">
                                        @error('gallery_images.*')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror

                                        <!-- Existing Gallery -->
                                        <div class="mt-2">
                                            @php $gallery = json_decode($product->gallery_images, true); @endphp
                                            @if ($gallery && is_array($gallery))
                                                <div>
                                                    @foreach ($gallery as $index => $image)
                                                        <div class="d-inline-block position-relative">
                                                            <img src="{{ asset($image) }}" alt="Gallery" width="40"
                                                                height="40" class="m-1 rounded">

                                                            <!-- Delete button -->
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle p-1"
                                                                onclick="removeImage(this, {{ $index }})">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted">No Images</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Short Description -->
                                    <label for="short_description" class="col-sm-1 col-form-label">S_
                                        Descrip</label>
                                    <div class="col-sm-7">
                                        <textarea name="short_description" id="short_description" class="form-control form-control-sm" rows="4">{{ old('short_description', $product->short_description) }}</textarea>
                                        @error('short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mt-2">
                                    <!-- Description -->
                                    <label for="description" class="col-sm-1 col-form-label">Description</label>
                                    <div class="col-sm-11">
                                        <textarea name="description" id="description" class="form-control form-control-sm" rows="4">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-header mt-4">
                                    <div class="table-head">
                                        <i class="fas fa-money-bill-wave me-1"></i> Product Pricing
                                    </div>
                                </div>

                                <div id="inventory-wrapper">
                                    @if ($product->inventory->count())
                                        @foreach ($product->inventory as $index => $inv)
                                            <div class="inventory-row border rounded p-2 mt-2">
                                                <div class="row align-items-center g-2">

                                                    <div class="col-sm-3">
                                                        <label class="form-label mb-0">Unit <span
                                                                class="text-danger">*</span></label>
                                                        <select name="inventory[{{ $index }}][unit_id]"
                                                            class="form-select form-select-sm" style="padding: 0.5rem 0.75rem;" required>
                                                            <option value="">Select Unit</option>
                                                            @foreach ($units as $unit)
                                                                <option value="{{ $unit->id }}"
                                                                    {{ $inv->unit_id == $unit->id ? 'selected' : '' }}>
                                                                    {{ $unit->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <label class="form-label mb-0">Price <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" step="0.01"
                                                            name="inventory[{{ $index }}][price]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $inv->price }}" required>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <label class="form-label mb-0">Discount</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" step="0.01"
                                                                name="inventory[{{ $index }}][discount_percent]"
                                                                class="form-control discount-percent"
                                                                value="{{ $inv->discount_percent }}" placeholder="%">
                                                            <input type="number" step="0.01"
                                                                name="inventory[{{ $index }}][discount_price]"
                                                                class="form-control discount-price"
                                                                value="{{ $inv->discount_price }}" placeholder="Amount" style="width: 35%;">
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <label class="form-label mb-0">Initial Qty <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number"
                                                            name="inventory[{{ $index }}][initial_qty]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $inv->initial_qty }}" required>
                                                    </div>

                                                    <div class="col-sm-1 text-center mt-4">
                                                        @if ($index == 0)
                                                            <button type="button" class="btn btn-sm btn-success"
                                                                id="addInventoryRow">
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger removeRow">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="inventory-row border rounded p-2 mt-2">
                                            <div class="row align-items-center g-2">

                                                <div class="col-sm-3">
                                                    <label class="form-label mb-0">Unit <span
                                                            class="text-danger">*</span></label>
                                                    <select name="inventory[0][unit_id]"
                                                        class="form-select form-select-sm" style="padding: 0.5rem 0.75rem;" required>
                                                        <option value="">Select Unit</option>
                                                        @foreach ($units as $unit)
                                                            <option value="{{ $unit->id }}">{{ $unit->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label class="form-label mb-0">Price <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" step="0.01" name="inventory[0][price]"
                                                        class="form-control form-control-sm" required>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label class="form-label mb-0">Discount</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="number" step="0.01"
                                                            name="inventory[0][discount_percent]"
                                                            class="form-control discount-percent" placeholder="%">
                                                        <input type="number" step="0.01"
                                                            name="inventory[0][discount_price]"
                                                            class="form-control discount-price" placeholder="Amount" style="width: 35%;">
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <label class="form-label mb-0">Initial Qty <span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" name="inventory[0][initial_qty]"
                                                        class="form-control form-control-sm" required>
                                                </div>

                                                <div class="col-sm-1 text-center mt-4">
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        id="addInventoryRow">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Submit -->
                                <hr class="my-2">
                                <div class="clearfix">
                                    <div class="text-end m-auto">
                                        <button type="reset" class="btn btn-dark">Reset</button>
                                        <button type="submit" class="btn btn-primary">Update Product</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script>
        function previewThumbnail(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const imgElement = document.getElementById('thumbPreview');
                imgElement.src = reader.result;
                imgElement.classList.remove('d-none');
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error('CKEditor Error:', error);
            });

        ClassicEditor
            .create(document.querySelector('#short_description'))
            .catch(error => {
                console.error('CKEditor Error:', error);
            });

        function removeImage(btn, index) {
            // index to delete
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_gallery_images[]';
            input.value = index;
            btn.closest('form').appendChild(input);

            // Remove the thumbnail container from the DOM
            btn.closest('.position-relative').remove();
        }
    </script>

    <script>
        let inventoryIndex = {{ max(1, $product->inventory->count()) }};

        document.getElementById('addInventoryRow').addEventListener('click', function() {
            let wrapper = document.getElementById('inventory-wrapper');

            let html = `
        <div class="inventory-row border rounded p-2 mt-2">
            <div class="row align-items-center g-2">

                <div class="col-sm-3">
                    <label class="form-label mb-0">Unit</label>
                    <select name="inventory[${inventoryIndex}][unit_id]"
                        class="form-select form-select-sm" style="padding: 0.5rem 0.75rem;" required>
                        <option value="">Select Unit</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-3">
                    <label class="form-label mb-0">Price</label>
                    <input type="number" step="0.01"
                        name="inventory[${inventoryIndex}][price]"
                        class="form-control form-control-sm" required>
                </div>

                <div class="col-sm-3">
                    <label class="form-label mb-0">Discount</label>
                    <div class="input-group input-group-sm">
                        <input type="number" step="0.01"
                            name="inventory[${inventoryIndex}][discount_percent]"
                            class="form-control discount-percent" placeholder="%">
                        <input type="number" step="0.01"
                            name="inventory[${inventoryIndex}][discount_price]"
                            class="form-control discount-price" placeholder="Amount"
                            style="width: 35%;">
                    </div>
                </div>

                <div class="col-sm-2">
                    <label class="form-label mb-0">Init Qty</label>
                    <input type="number"
                        name="inventory[${inventoryIndex}][initial_qty]"
                        class="form-control form-control-sm" required>
                </div>

                <div class="col-sm-1 text-center mt-4">
                    <button type="button" class="btn btn-sm btn-danger removeRow">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>

            </div>
        </div>`;
            wrapper.insertAdjacentHTML('beforeend', html);
            inventoryIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.removeRow')) {
                e.target.closest('.inventory-row').remove();
            }
        });

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('discount-price') || e.target.classList.contains('discount-percent')) {
                const row = e.target.closest('.inventory-row');
                const price = parseFloat(row.querySelector('input[name*="[price]"]').value) || 0;

                const dp = row.querySelector('.discount-price');
                const dper = row.querySelector('.discount-percent');

                if (!price) return;

                if (e.target.classList.contains('discount-percent')) {
                    dp.value = (price - (dper.value / 100) * price).toFixed(2);
                }

                if (e.target.classList.contains('discount-price')) {
                    dper.value = ((1 - dp.value / price) * 100).toFixed(2);
                }
            }
        });
    </script>
@endsection
