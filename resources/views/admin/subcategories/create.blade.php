@extends('admin.layouts.master')

@section('title', isset($subCategory) ? 'Edit Subcategory' : 'Create Subcategory')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i> <a href="{{ route('dashboard') }}">Dashboard</a> >
                    {{ isset($subCategory) ? 'Edit Subcategory' : 'Create Subcategory' }}</span>
            </div>

            <!-- Create/Edit Subcategory Form -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-layer-group me-1"></i>
                        {{ isset($subCategory) ? 'Edit Subcategory' : 'Add New Subcategory' }}</div>
                    <a href="{{ route('subcategories.index') }}" class="btn btn-addnew">
                        <i class="fa fa-file-alt"></i> View All
                    </a>
                </div>
                <div class="card-body table-card-body">
                    <form method="POST"
                        action="{{ isset($subCategory) ? route('subcategories.update', $subCategory->id) : route('subcategories.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($subCategory))
                            @method('PUT')
                        @endif

                        <div class="row justify-content-center">

                            <!-- Category -->
                            <div class="form-group row mt-2 align-items-center justify-content-center">
                                <label for="category_id" class="col-sm-1 col-form-label">Category</label>
                                <div class="col-sm-3">
                                    <select name="category_id" id="category_id" class="form-control form-control-sm">
                                        <option value="">-- Select Category --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $subCategory->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Subcategory Name -->
                            <div class="form-group row mt-2 align-items-center justify-content-center">
                                <label for="subcategory_name" class="col-sm-1 col-form-label">Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" id="subcategory_name"
                                        name="name" value="{{ old('name', $subCategory->name ?? '') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="form-group row mt-2 align-items-center justify-content-center">
                                <label for="subcategory_image" class="col-sm-1 col-form-label">Image</label>
                                <div class="col-sm-3">
                                    <div class="d-flex align-items-center">
                                        <img id="imagePreview"
                                            src="{{ isset($subCategory) && $subCategory->image ? asset($subCategory->image) : asset('uploads/no_images/no-image.png') }}"
                                            alt="Subcategory Image Preview" width="40" class="me-2">
                                        <input type="file" class="form-control form-control-sm" id="subcategory_image"
                                            name="image" accept="image/*" onchange="previewImage(event)">
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted d-inline-block text-nowrap">
                                        <span style="color: red;">
                                            JPG/JPEG/PNG • Max: 2MB • 700×600px
                                        </span>
                                    </small>
                                </div>
                            </div>

                            <hr class="my-2">

                            <div class="clearfix text-center">
                                <button type="reset" class="btn btn-dark">Reset</button>
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($subCategory) ? 'Update Subcategory' : 'Add Subcategory' }}
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            <!-- Subcategory List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-list me-1"></i> Subcategory List</div>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Subcategory Image</th>
                                <th>Category Name</th>
                                <th>Subcategory Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subCategories as $key => $subCategory)
                                <tr class="text-center">
                                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ $subCategory->image ? asset($subCategory->image) : asset('uploads/no_images/no-image.png') }}"
                                            alt="Subcategory Image" width="40" height="40">
                                    </td>
                                    <td class="text-center align-middle">{{ $subCategory->category->name ?? 'N/A' }}</td>
                                    <td class="text-center align-middle">{{ $subCategory->name }}</td>
                                    <td class="text-center align-middle" style="vertical-align: middle;">
                                        <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                            <form action="{{ route('subcategories.updateStatus', $subCategory->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status"
                                                    value="{{ $subCategory->status == 'a' ? 'd' : 'a' }}">
                                                <button type="submit"
                                                    class="btn btn-sm {{ $subCategory->status == 'a' ? 'btn-success' : 'btn-danger' }} d-flex align-items-center justify-content-center"
                                                    style="padding: 4px 12px; font-size: 12px;">
                                                    @if ($subCategory->status == 'a')
                                                        <i class="fas fa-check-circle me-1"></i> Active
                                                    @else
                                                        <i class="fas fa-ban me-1"></i> Deactive
                                                    @endif
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                    <td class="text-center align-middle">
                                        <a href="{{ route('subcategories.edit', $subCategory->id) }}" class="btn btn-edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('subcategories.destroy', $subCategory->id) }}"
                                            method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete show-confirm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const imgElement = document.getElementById('imagePreview');
                imgElement.src = reader.result;
                imgElement.classList.remove('d-none');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
