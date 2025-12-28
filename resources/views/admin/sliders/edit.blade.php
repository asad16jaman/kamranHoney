@extends('admin.layouts.master')

@section('title', 'Edit Slider')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i> <a href="{{ route('dashboard') }}">Dashboard</a> > Edit
                    Slider</span>
            </div>

            <!-- Edit Slider Form -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-image me-1"></i> Edit Slider</div>
                    <a href="{{ route('sliders.index') }}" class="btn btn-addnew"> <i class="fa fa-file-alt"></i> View
                        All</a>
                </div>
                <div class="card-body table-card-body">
                    <div class="row">
                        <form method="POST" action="{{ route('sliders.update', $slider->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <!-- Slider Image -->
                                <div class="form-group row">
                                    <label for="slider_image" class="col-sm-1 col-form-label">Slider Image</label>
                                    <div class="col-sm-3">
                                        <div class="d-flex align-items-center">
                                            <img id="imagePreview"
                                                src="{{ asset('uploads/sliders/' . $slider->slider_image) }}"
                                                alt="Slider Image Preview" width="50" class="me-2">
                                            <input type="file" class="form-control form-control-sm" id="slider_image"
                                                name="slider_image" accept="image/*" onchange="previewImage(event)">
                                        </div>
                                        @error('slider_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted d-inline-block text-nowrap">
                                            <span style="color: red; position: relative; left: 6px;">Allowed formats: JPG,
                                                JPEG, PNG. Max size: 2MB</span>
                                        </small>
                                    </div>

                                    <!-- Slider Title One -->
                                    <label for="slider_title_one" class="col-sm-1 col-form-label">Title One</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="slider_title_one"
                                            name="slider_title_one"
                                            value="{{ old('slider_title_one', $slider->slider_title_one) }}">
                                        @error('slider_title_one')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Slider Title Two -->
                                    <label for="slider_title_two" class="col-sm-1 col-form-label">Title Two</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="slider_title_two"
                                            name="slider_title_two"
                                            value="{{ old('slider_title_two', $slider->slider_title_two) }}">
                                        @error('slider_title_two')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <!-- Button Text -->
                                    {{-- <label for="button_text" class="col-sm-1 col-form-label">Button Text</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="button_text"
                                            name="button_text" value="{{ old('button_text', $slider->button_text) }}">
                                        @error('button_text')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}

                                    <!-- Slider Description -->
                                    {{-- <label for="description" class="col-sm-1 col-form-label">Description</label>
                                    <div class="col-sm-4">
                                        <textarea id="slider_editor" class="form-control form-control-sm @error('description') is-invalid @enderror"
                                            name="description" rows="5">{{ old('description', $slider->description) }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}
                                </div>

                                <hr class="my-2">
                                <div class="clearfix">
                                    <div class="text-end m-auto">
                                        <button type="reset" class="btn btn-dark">Reset</button>
                                        <button type="submit" class="btn btn-primary">Update Slider</button>
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
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const imgElement = document.getElementById('imagePreview');
                imgElement.src = reader.result;
                imgElement.classList.remove('d-none');
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        ClassicEditor
            .create(document.querySelector('#slider_editor'))
            .catch(error => {
                console.error('CKEditor Error:', error);
            });
    </script>
@endsection
