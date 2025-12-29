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
                    <div class="table-head"><i class="fas fa-box-open me-1"></i>Product Info</div>
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
                                    <label for="product_code" class="col-sm-1 col-form-label">Code</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="product_code"
                                            name="product_code" value="{{ $nextProductCode ?? '' }}" readonly>
                                    </div>
                                </div>

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
                                </div>

                                <div class="form-group row mt-2">
                                    <!-- Short Description -->
                                    <label for="short_description" class="col-sm-1 col-form-label">S_
                                        Descrip</label>
                                    <div class="col-sm-5">
                                        <textarea name="short_description" id="short_description" class="form-control form-control-sm" rows="4">{{ old('short_description') }}</textarea>
                                        @error('short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <label for="description" class="col-sm-1 col-form-label">Description</label>
                                    <div class="col-sm-5">
                                        <textarea name="description" id="description" class="form-control form-control-sm" rows="4">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
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
