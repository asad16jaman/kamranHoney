@extends('admin.layouts.master')

@section('title', 'Create Product')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading">
                    <i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > Create Product
                </span>
            </div>

            <!-- Create Product Form -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-box-open me-1"></i> Add New Product</div>
                    <a href="{{ route('products.index') }}" class="btn btn-addnew">
                        <i class="fa fa-file-alt"></i> View All
                    </a>
                </div>
                <div class="card-body table-card-body">
                    <div class="row">
                        <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group row mt-2">
                                    <!-- Product Name -->
                                    <label for="product_name" class="col-sm-1 col-form-label">Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="product_name"
                                            name="name" value="{{ old('name') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Category -->
                                    <label for="category_id" class="col-sm-1 col-form-label">Category</label>
                                    <div class="col-sm-3">
                                        <select class="form-select form-select-sm" name="category_id" id="category_id">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Subcategory -->
                                    <label for="sub_category_id" class="col-sm-1 col-form-label">S_Category</label>
                                    <div class="col-sm-3">
                                        <select class="form-select form-select-sm" name="sub_category_id"
                                            id="sub_category_id">
                                            <option value="">Select Subcategory</option>
                                            @foreach ($subCategories as $subCategory)
                                                <option value="{{ $subCategory->id }}"
                                                    {{ old('sub_category_id') == $subCategory->id ? 'selected' : (isset($product) && $product->sub_category_id == $subCategory->id ? 'selected' : '') }}>
                                                    {{ $subCategory->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('sub_category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mt-2">

                                    <!-- Brand -->
                                    <label for="client_id" class="col-sm-1 col-form-label">Brand</label>
                                    <div class="col-sm-3">
                                        <select class="form-select form-select-sm" name="client_id" id="client_id">
                                            <option value="">Select Brand</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}"
                                                    {{ old('category_id') == $client->id ? 'selected' : '' }}>
                                                    {{ $client->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Price -->
                                    <label for="price" class="col-sm-1 col-form-label">Price</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="0.01" class="form-control form-control-sm"
                                            id="price" name="price" value="{{ old('price') }}">
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Thumbnail -->
                                    <label for="thumbnail_image" class="col-sm-1 col-form-label">Image</label>
                                    <div class="col-sm-3">
                                        <div class="d-flex align-items-center">
                                            <img id="thumbPreview" src="{{ asset('uploads/no_images/no-image.png') }}"
                                                alt="Thumbnail Preview" width="40" class="me-2">
                                            <input type="file" class="form-control form-control-sm" id="thumbnail_image"
                                                name="thumbnail_image" accept="image/*" onchange="previewThumbnail(event)">
                                        </div>
                                        @error('thumbnail_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted d-inline-block text-nowrap">
                                            <span style="color: red; position: relative;">
                                                JPG/JPEG/PNG • Max: 2MB • 500×500px
                                            </span>
                                        </small>
                                    </div>
                                </div>


                                <div class="form-group row">

                                    <!-- Gallery -->
                                    <label for="gallery_images" class="col-sm-1 col-form-label">M. Image</label>
                                    <div class="col-sm-3">
                                        <input type="file" class="form-control form-control-sm" id="gallery_images"
                                            name="gallery_images[]" multiple accept="image/*">
                                        @error('gallery_images.*')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted d-inline-block text-nowrap">
                                            <span style="color: red; position: relative;">
                                                JPG/JPEG/PNG • Max: 2MB • 500×500px
                                            </span>
                                        </small>
                                    </div>

                                    <!-- Discount Price -->
                                    <label for="discount_price" class="col-sm-1 col-form-label">Discount Price</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="0.01" class="form-control form-control-sm"
                                            id="discount_price" name="discount_price"
                                            value="{{ old('discount_price') }}">
                                        @error('discount_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Product Code -->
                                    <label for="product_code" class="col-sm-1 col-form-label">Product Code</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="product_code"
                                            name="product_code" value="{{ old('product_code') }}">
                                        @error('product_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mt-2">

                                    <!-- Sizes -->
                                    {{-- <label for="sizes" class="col-sm-1 col-form-label">Sizes</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="sizes[]" class="form-control form-control-sm"
                                            placeholder="e.g. S,M,L,XL" value="{{ old('sizes.0') }}">
                                        @error('sizes.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}

                                    <!-- Colors -->
                                    {{-- <label for="colors" class="col-sm-1 col-form-label">Colors</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="colors[]" class="form-control form-control-sm"
                                            placeholder="e.g. Red,Blue,Green" value="{{ old('colors.0') }}">
                                        @error('colors.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}

                                    <!-- Short Description -->
                                    <label for="short_description" class="col-sm-1 col-form-label">S_
                                        Descrip</label>
                                    <div class="col-sm-3">
                                        <textarea name="short_description" id="short_description" class="form-control form-control-sm" rows="4">{{ old('description') }}</textarea>
                                        @error('short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <label for="description" class="col-sm-1 col-form-label">Description</label>
                                    <div class="col-sm-3">
                                        <textarea name="description" id="description" class="form-control form-control-sm" rows="4">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Feature Toggles -->
                                <div class="form-group row mt-4">
                                    <div class="col-12">
                                        <label class="form-label d-block text-center fw-bold mb-2">Product Tags</label>
                                        <div class="d-flex justify-content-center flex-wrap gap-3">
                                            @php
                                                $toggles = [
                                                    'is_featured' => 'Featured',
                                                    'is_top_selling' => 'Top Selling',
                                                    'is_popular' => 'Popular',
                                                    'is_special' => 'Special',
                                                    'is_best' => 'Best',
                                                    'is_new' => 'New',
                                                ];
                                            @endphp

                                            @foreach ($toggles as $key => $label)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="{{ $key }}" name="{{ $key }}"
                                                        value="Yes" {{ old($key) == 'Yes' ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="{{ $key }}">{{ $label }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <hr class="my-2">
                                <div class="clearfix">
                                    <div class="text-end m-auto">
                                        <button type="reset" class="btn btn-dark">Reset</button>
                                        <button type="submit" class="btn btn-primary">Add Product</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- All Products Table -->
            <div class="card my-4">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-box me-1"></i>All Products</div>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Images</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="align-middle">{{ $product->name }}</td>
                                    <td class="align-middle">{{ $product->category->name ?? 'N/A' }}</td>
                                    <td class="align-middle">{{ $product->client->name ?? 'N/A' }}</td>
                                    <td class="align-middle">{{ $product->price }}</td>
                                    <td class="align-middle">
                                        <img src="{{ $product->thumbnail_image ? asset($product->thumbnail_image) : asset('uploads/no_images/no-image.png') }}"
                                            alt="Product Image" width="40" height="40">
                                    </td>
                                    <td class="align-middle">
                                        @php
                                            $gallery = json_decode($product->gallery_images, true);
                                        @endphp
                                        @if ($gallery && is_array($gallery))
                                            @foreach ($gallery as $image)
                                                <img src="{{ asset($image) }}" alt="Gallery" width="40"
                                                    height="40" class="m-1 rounded">
                                            @endforeach
                                        @else
                                            <span class="text-muted">No Images</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        {{ Str::limit(strip_tags($product->description ?? 'N/A'), 20) }}</td>
                                    <td class="align-middle">
                                        <form action="{{ route('products.updateStatus', $product->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $product->status == 'a' ? 'd' : 'a' }}">
                                            <button type="submit"
                                                class="btn btn-sm {{ $product->status == 'a' ? 'btn-success' : 'btn-danger' }}"
                                                style="font-size: 12px;">
                                                @if ($product->status == 'a')
                                                    <i class="fas fa-check-circle me-1"></i> Active
                                                @else
                                                    <i class="fas fa-ban me-1"></i> Deactive
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="btn btn-edit me-2" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            <button type="button" class="btn btn-secondary btn-sm me-2"
                                                style="font-size: 0.5rem;" data-bs-toggle="modal"
                                                data-bs-target="#variantModal{{ $product->id }}"
                                                title="Manage Variants">
                                                <i class="fas fa-boxes fa-sm"></i>
                                            </button>

                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                class="delete-form m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-delete show-confirm"
                                                    title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                @include('admin.partials.variant_modal', [
                                    'product' => $product,
                                    'sizes' => $sizes,
                                    'colors' => $colors,
                                ])
                            @endforeach
                        </tbody>
                    </table>
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
    </script>
@endsection
