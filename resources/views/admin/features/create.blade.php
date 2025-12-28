@extends('admin.layouts.master')

@section('title', 'Create Feature')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i> <a href="{{ route('dashboard') }}">Dashboard</a> >
                    Create Feature</span>
            </div>

            <!-- Create Feature Form -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-cogs me-1"></i>Create New Feature</div>
                    <a href="{{ route('features.index') }}" class="btn btn-addnew">
                        <i class="fa fa-file-alt"></i> View All
                    </a>
                </div>
                <div class="card-body table-card-body">
                    <div class="row">
                        <form method="POST"
                            action="{{ isset($feature) ? route('features.update', $feature->id) : route('features.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            @if (isset($feature))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <!-- Feature Image -->
                                <div class="form-group row">
                                    <label for="image" class="col-sm-1 col-form-label">Image</label>
                                    <div class="col-sm-3">
                                        <div class="d-flex align-items-center">
                                            <img id="imagePreview"
                                                src="{{ isset($feature) && $feature->image && $feature->image !== 'no-image.png'
                                                    ? asset('uploads/features/' . $feature->image)
                                                    : asset('uploads/no_images/no-image.png') }}"
                                                alt="Image Preview" width="50" class="me-2">
                                            <input type="file" class="form-control form-control-sm" id="image"
                                                name="image" accept="image/*" onchange="previewImage(event)">
                                        </div>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Feature Title -->
                                    <label for="features_title" class="col-sm-1 col-form-label">Title</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm mt-2" id="features_title"
                                            name="features_title"
                                            value="{{ old('features_title', $feature->features_title ?? '') }}">
                                        @error('features_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="my-2">
                                <div class="text-end m-auto">
                                    <button type="reset" class="btn btn-dark">Reset</button>
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($features) ? 'Update Feature' : 'Create Feature' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Feature List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-list me-1"></i>Feature List</div>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($features as $key => $features)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="align-middle">
                                        @if ($features->image && $features->image !== 'no-image.png')
                                            <img src="{{ asset('uploads/features/' . $features->image) }}"
                                                alt="Feature Image"
                                                style="width: 40px; height: 40px; object-fit: cover; margin-left: 11px;">
                                        @else
                                            <img src="{{ asset('uploads/no_images/no-image.png') }}" alt="No Image"
                                                style="width: 40px; height: 40px; object-fit: cover; margin-left: 11px;">
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ $features->features_title }}</td>
                                    <td class="align-middle">
                                        <form action="{{ route('features.updateStatus', $features->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $features->status == 'a' ? 'd' : 'a' }}">
                                            <button type="submit"
                                                class="btn btn-sm {{ $features->status == 'a' ? 'btn-success' : 'btn-danger' }}"
                                                style="padding: 2px 10px; font-size: 12px;">
                                                {{ $features->status == 'a' ? 'Active' : 'Deactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('features.edit', $features->id) }}" class="btn btn-edit"><i
                                                class="fas fa-pencil-alt"></i></a>
                                        <form action="{{ route('features.destroy', $features->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete show-confirm"><i
                                                    class="fa fa-trash"></i></button>
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
            .create(document.querySelector('#features_editor'))
            .catch(error => {
                console.error('CKEditor Error:', error);
            });
    </script>
@endsection
