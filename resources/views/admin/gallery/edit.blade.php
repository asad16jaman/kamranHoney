@extends('admin.layouts.master')

@section('title', 'Edit Gallery')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > Edit Gallery</span>
            </div>

            <!-- Edit Gallery Form -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-edit me-1"></i> Edit Gallery Item</div>
                    <a href="{{ route('gallery.index') }}" class="btn btn-addnew">
                        <i class="fa fa-file-alt"></i> View Galleries
                    </a>
                </div>
                <div class="card-body table-card-body">
                    <div class="row">
                        @if (session('success'))
                            <div class="alert alert-success" id="success-alert">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('gallery.update', $gallery->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <!-- Type -->
                                <div class="form-group row mt-2">
                                    <label for="type" class="col-sm-1 col-form-label">Type</label>
                                    <div class="col-sm-3">
                                        <select name="type" id="type" class="form-select form-select-sm">
                                            <option value="image" {{ $gallery->type == 'image' ? 'selected' : '' }}>Image
                                            </option>
                                            <option value="video" {{ $gallery->type == 'video' ? 'selected' : '' }}>Video
                                            </option>
                                        </select>
                                        @error('type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Image Fields -->
                                <div id="imageFields" class="form-group row mt-2">
                                    <label for="gallery_image" class="col-sm-1 col-form-label">Image</label>
                                    <div class="col-sm-3">
                                        <div class="d-flex align-items-center">
                                            <img id="imagePreview"
                                                src="{{ $gallery->image ? asset('uploads/gallery/' . $gallery->image) : asset('uploads/no_images/no-image.png') }}"
                                                alt="Preview" width="40" class="me-2">
                                            <input type="file" class="form-control form-control-sm" id="gallery_image"
                                                name="image" accept="image/*" onchange="previewImage(event)">
                                        </div>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted d-inline-block text-nowrap">
                                            <span style="color: red; position: relative;">
                                                JPG/JPEG/PNG • Max: 2MB • 500×400px
                                            </span>
                                        </small>
                                    </div>

                                    <label for="title_1" class="col-sm-1 col-form-label">Title</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="title_1"
                                            name="title_1" value="{{ old('title_1', $gallery->title_1) }}">
                                        @error('title_1')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Video Fields -->
                                <div id="videoFields" class="form-group row mt-2" style="display: none;">
                                    <label for="video_url" class="col-sm-1 col-form-label">Video URL</label>
                                    <div class="col-sm-3">
                                        <input type="url" class="form-control form-control-sm" id="video_url"
                                            name="video_url" value="{{ old('video_url', $gallery->video_url) }}">
                                        @error('video_url')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <label for="description" class="col-sm-1 col-form-label">Description</label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control form-control-sm" id="description" name="description">{{ old('description', $gallery->description) }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-2">
                            <div class="clearfix">
                                <div class="text-end m-auto">
                                    <a href="{{ route('gallery.index') }}" class="btn btn-dark">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update Gallery Item</button>
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
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const imgElement = document.getElementById('imagePreview');
                imgElement.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error('CKEditor Error:', error);
            });

        function toggleFields() {
            const type = document.getElementById('type').value;
            const imageFields = document.getElementById('imageFields');
            const videoFields = document.getElementById('videoFields');

            if (type === 'image') {
                imageFields.style.display = 'flex';
                videoFields.style.display = 'none';
            } else {
                imageFields.style.display = 'none';
                videoFields.style.display = 'flex';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleFields();
            document.getElementById('type').addEventListener('change', toggleFields);
        });
    </script>
@endsection
