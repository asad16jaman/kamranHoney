@extends('admin.layouts.master')

@section('title', 'Create Gallery')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > Create Gallery</span>
            </div>

            <!-- Create Gallery Form -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-images me-1"></i> Add New Gallery Item</div>
                    <a href="{{ route('gallery.index') }}" class="btn btn-addnew">
                        <i class="fa fa-file-alt"></i> View Galleries
                    </a>
                </div>
                <div class="card-body table-card-body">
                    <div class="row">
                        <form method="POST" action="{{ route('gallery.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Type -->
                                <div class="form-group row mt-2">
                                    <label for="type" class="col-sm-1 col-form-label">Type</label>
                                    <div class="col-sm-3">
                                        <select name="type" id="type" class="form-select form-select-sm">
                                            <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Image
                                            </option>
                                            <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video
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
                                            <img id="imagePreview" src="{{ asset('uploads/no_images/no-image.png') }}"
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
                                            name="title_1" value="{{ old('title_1') }}">
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
                                            name="video_url" value="{{ old('video_url') }}">
                                        @error('video_url')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <label for="description" class="col-sm-1 col-form-label">Description</label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control form-control-sm" id="description" name="description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-2">
                            <div class="clearfix">
                                <div class="text-end m-auto">
                                    <button type="reset" class="btn btn-dark">Reset</button>
                                    <button type="submit" class="btn btn-primary">Add Gallery Item</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Gallery Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-list me-1"></i> Gallery List</div>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Gallery Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Video URL</th>
                                @if (auth()->user()->type == 'admin')
                                    <th>Status</th>
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($galleries as $key => $item)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ $item->image ? asset('uploads/gallery/' . $item->image) : asset('uploads/no_images/no-image.png') }}"
                                            alt="Gallery Image" width="40" height="40">
                                    </td>
                                    <td class="align-middle">{{ $item->title_1 ?? 'N/A' }}</td>
                                    <td class="align-middle">{{ Str::limit(strip_tags($item->description ?? 'N/A'), 50) }}
                                    </td>
                                    <td class="align-middle">
                                        @if ($item->video_url)
                                            <a href="{{ $item->video_url }}" target="_blank">View Video</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    @if (auth()->user()->type == 'admin')
                                        <td class="align-middle">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <form action="{{ route('gallery.updateStatus', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status"
                                                        value="{{ $item->status == 'a' ? 'd' : 'a' }}">
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $item->status == 'a' ? 'btn-success' : 'btn-danger' }} d-flex align-items-center justify-content-center"
                                                        style="padding: 4px 12px; font-size: 12px;">
                                                        @if ($item->status == 'a')
                                                            <i class="fas fa-check-circle me-1"></i> Active
                                                        @else
                                                            <i class="fas fa-ban me-1"></i> Deactive
                                                        @endif
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('gallery.edit', $item->id) }}" class="btn btn-edit me-1">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            {{-- <form action="{{ route('gallery.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-delete"
                                                    onclick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form> --}}
                                            <form action="{{ route('gallery.destroy', $item->id) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-delete show-confirm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
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
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 3000);
            }

            // Init toggle
            toggleFields();

            // Bind change event
            document.getElementById('type').addEventListener('change', toggleFields);
        });
    </script>
@endsection
