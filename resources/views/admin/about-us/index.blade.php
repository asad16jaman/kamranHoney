@extends('admin.layouts.master')

@section('title', 'About Us')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="card my-3">
                <div class="heading-title p-2 my-2">
                    <span class="my-3 heading"><i class="fas fa-home"></i>
                        <a href="{{ route('dashboard') }}">Dashboard</a> > About Us
                    </span>
                </div>
                <div class="card-body table-card-body">
                    @if ($aboutUs)
                        <form method="POST" action="{{ route('about-us.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Title -->
                                <label for="title" class="col-sm-1 col-form-label">Title</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" id="title" name="title"
                                        value="{{ old('title', $aboutUs->title) }}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Button Text -->
                                <label for="button_text" class="col-sm-1 col-form-label">Button Text</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" id="button_text"
                                        name="button_text" value="{{ old('button_text', $aboutUs->button_text) }}">
                                    @error('button_text')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Image -->
                                <label for="image_path" class="col-sm-1 col-form-label">Image</label>
                                <div class="col-sm-3">
                                    <div class="d-flex align-items-center">
                                        <img id="imagePreview"
                                            src="{{ $aboutUs->image_path ? asset('uploads/about/' . $aboutUs->image_path) : asset('uploads/no_images/no-image.png') }}"
                                            alt="Image Preview" width="50" class="me-2">
                                        <input type="file" class="form-control form-control-sm" id="image_path"
                                            name="image_path" onchange="previewImage(event, 'imagePreview')">
                                    </div>
                                    @error('image_path')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted d-inline-block text-nowrap">
                                        <span style="color: red; position: relative;">
                                            JPG/JPEG/PNG • Max: 2MB • 500×250px
                                        </span>
                                    </small>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Description -->
                                <label for="description" class="col-sm-1 col-form-label">Description</label>
                                <div class="col-sm-12">
                                    <textarea id="description" class="form-control form-control-sm @error('description') is-invalid @enderror"
                                        name="description" placeholder="Enter Description" rows="5">{{ old('description', $aboutUs->description) }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-2">
                            <div class="clearfix">
                                <div class="text-end m-auto">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save
                                        Changes</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning">No About Us content found. Please create a new entry.</div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script>
        function previewImage(event, previewId) {
            const reader = new FileReader();
            reader.onload = function() {
                const imgElement = document.getElementById(previewId);
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
    </script>
@endsection
