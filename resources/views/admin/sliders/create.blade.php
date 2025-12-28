@extends('admin.layouts.master')

@section('title', 'Create Slider')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i> <a href="{{ route('dashboard') }}">Dashboard</a> >
                    Create Slider</span>
            </div>

            <!-- Create Slider Form -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-image me-1"></i>Create New Slider</div>
                    <a href="{{ route('sliders.index') }}" class="btn btn-addnew"> <i class="fa fa-file-alt"></i> View
                        All</a>
                </div>
                <div class="card-body table-card-body">
                    <div class="row">
                        <form method="POST"
                            action="{{ isset($slider) ? route('sliders.update', $slider->id) : route('sliders.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if (isset($slider))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <!-- Slider Image -->
                                <div class="form-group row">
                                    <label for="slider_image" class="col-sm-1 col-form-label">Slider Image</label>
                                    <div class="col-sm-3">
                                        <div class="d-flex align-items-center">
                                            <img id="imagePreview"
                                                src="{{ isset($slider) && $slider->slider_image ? asset('uploads/sliders/' . $slider->slider_image) : asset('uploads/no_images/no-image.png') }}"
                                                alt="Slider Image Preview" width="50" class="me-2">
                                            <input type="file" class="form-control form-control-sm" id="slider_image"
                                                name="slider_image" accept="image/*" onchange="previewImage(event)">
                                        </div>
                                        @error('slider_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted d-inline-block text-nowrap">
                                            <span style="color: red; position: relative;">
                                                JPG/JPEG/PNG • Max: 2MB • 640×360px
                                            </span>
                                        </small>
                                    </div>

                                    <!-- Slider Title One -->
                                    <label for="slider_title_one" class="col-sm-1 col-form-label">Title One</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="slider_title_one"
                                            name="slider_title_one"
                                            value="{{ old('slider_title_one', $slider->slider_title_one ?? '') }}">
                                        @error('slider_title_one')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Slider Title Two -->
                                    <label for="slider_title_two" class="col-sm-1 col-form-label">Title Two</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="slider_title_two"
                                            name="slider_title_two"
                                            value="{{ old('slider_title_two', $slider->slider_title_two ?? '') }}">
                                        @error('slider_title_two')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <!-- Slider Description -->
                                    {{-- <label for="description" class="col-sm-1 col-form-label">Short Description</label>
                                    <div class="col-sm-3">
                                        <textarea class="form-control form-control-sm" id="slider_editor" name="description" rows="3">{{ old('description', $slider->description ?? '') }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div> --}}

                                    <!-- Button Text -->
                                    <label for="button_text" class="col-sm-1 col-form-label">Button</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="button_text"
                                            name="button_text" value="{{ old('button_text', $slider->button_text ?? '') }}">
                                        @error('button_text')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="my-2">
                                <div class="clearfix">
                                    <div class="text-end m-auto">
                                        <button type="reset" class="btn btn-dark">Reset</button>
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($slider) ? 'Update Slider' : 'Create Slider' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Slider List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-list me-1"></i>Slider List</div>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Slider Image</th>
                                <th>Title One</th>
                                <th>Title Two</th>
                                <th>Button Text</th>
                                {{-- <th>Button Text</th> --}}
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sliders as $key => $slider)
                                <tr class="text-center">
                                    <td>{{ $key + 1 }}</td>
                                    <td text-center align-middle><img
                                            src="{{ asset('uploads/sliders/' . $slider->slider_image) }}"
                                            alt="Slider Image" width="40" height="40">
                                    </td>
                                    <td>{{ $slider->slider_title_one }}</td>
                                    <td>{{ $slider->slider_title_two }}</td>
                                    <td>{{ $slider->button_text }}</td>
                                    {{-- <td>{{ Str::limit(strip_tags($slider->description), 50) }}</td> --}}
                                    <td class="text-center">
                                        <form action="{{ route('sliders.updateStatus', $slider->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $slider->status == 'a' ? 'd' : 'a' }}">

                                            <button type="submit"
                                                class="btn btn-sm {{ $slider->status == 'a' ? 'btn-success' : 'btn-danger' }}"
                                                style="padding: 2px 10px; font-size: 12px; display: flex; align-items: center; gap: 5px; margin-top: 7px;">

                                                @if ($slider->status == 'a')
                                                    <i class="fas fa-check-circle"></i> Active
                                                @elseif ($slider->status == 'd')
                                                    <i class="fas fa-ban"></i> Deactive
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-edit"
                                            style="margin-top: 10px;">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete show-confirm"
                                                style="margin-top: 10px;">
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
