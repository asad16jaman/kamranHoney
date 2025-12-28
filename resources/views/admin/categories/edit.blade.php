@extends('admin.layouts.master')

@section('title', 'Edit Category')
@section('main-content')
<main>
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading"><i class="fas fa-home"></i> 
                <a href="{{ route('dashboard') }}">Dashboard</a> > 
                Edit Category
            </span>
        </div>

        <!-- Edit Category Form -->
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-edit me-1"></i> Edit Category</div>
                <a href="{{ route('categories.index') }}" class="btn btn-addnew">
                    <i class="fa fa-file-alt"></i> View All
                </a>
            </div>
            <div class="card-body table-card-body">
                <div class="row">
                    <form method="POST" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Category Image -->
                            <div class="form-group row mt-2">
                                <label for="category_image" class="col-sm-1 col-form-label">Image</label>
                                <div class="col-sm-3">
                                    <div class="d-flex align-items-center">
                                        <img id="imagePreview" 
                                             src="{{ $category->image ? asset($category->image) : asset('uploads/no_images/no-image.png') }}"
                                             alt="Category Image Preview" width="40" class="me-2">
                                        <input type="file" class="form-control form-control-sm" id="category_image"
                                            name="image" accept="image/*" onchange="previewImage(event)">
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted d-inline-block text-nowrap">
                                        <span style="color: red; position: relative; left: 6px;">Allowed formats:
                                            JPG, JPEG, PNG. Max size: 2MB</span>
                                    </small>
                                </div>

                                <!-- Category Name -->
                                <label for="category_name" class="col-sm-1 col-form-label">Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" id="category_name"
                                        name="name" value="{{ old('name', $category->name) }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-2">
                            <div class="clearfix">
                                <div class="text-end m-auto">
                                    <button type="reset" class="btn btn-dark">Reset</button>
                                    <button type="submit" class="btn btn-primary">Update Category</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
