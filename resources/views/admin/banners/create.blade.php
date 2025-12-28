@extends('admin.layouts.master')

@section('title', isset($banner) ? 'Edit Banner' : 'Create Banner')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > {{ isset($banner) ? 'Edit Banner' : 'Create Banner' }}
                </span>
            </div>

            <!-- Create Banner Form -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-image me-1"></i>Create New Banner</div>
                    <a href="{{ route('banners.index') }}" class="btn btn-addnew"> <i class="fa fa-file-alt"></i> View
                        All</a>
                </div>
                <div class="card-body table-card-body">
                    <div class="row">
                        <form method="POST"
                            action="{{ isset($banner) ? route('banners.update', $banner->id) : route('banners.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if (isset($banner))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <!-- Banner Image -->
                                <div class="form-group row">
                                    <label for="banner_image" class="col-sm-1 col-form-label">Banner Image</label>
                                    <div class="col-sm-3">
                                        <div class="d-flex align-items-center">
                                            <img id="imagePreview"
                                                src="{{ isset($banner) && $banner->banner_image ? asset('uploads/banners/' . $banner->banner_image) : asset('uploads/no_images/no-image.png') }}"
                                                alt="Banner Image Preview" width="50" class="me-2">
                                            <input type="file" class="form-control form-control-sm" id="banner_image"
                                                name="banner_image" accept="image/*" onchange="previewImage(event)">
                                        </div>
                                        @error('banner_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted d-inline-block text-nowrap">
                                            <span style="color: red; position: relative;">
                                                JPG/PNG • Max: 2MB
                                            </span>
                                        </small>
                                    </div>

                                    <!-- Title One -->
                                    <label for="title_one" class="col-sm-1 col-form-label">Title One</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="title_one"
                                            name="title_one" value="{{ old('title_one', $banner->title_one ?? '') }}">
                                        @error('title_one')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Title Two -->
                                    <label for="title_two" class="col-sm-1 col-form-label">Title Two</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="title_two"
                                            name="title_two" value="{{ old('title_two', $banner->title_two ?? '') }}">
                                        @error('title_two')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <!-- Start Date -->
                                    <label for="start_date" class="col-sm-1 col-form-label">Start Date</label>
                                    <div class="col-sm-3">
                                        <input type="datetime-local" class="form-control form-control-sm" id="start_date"
                                            name="start_date"
                                            value="{{ old('start_date', isset($banner) && $banner->start_date ? $banner->start_date->format('Y-m-d\TH:i') : '') }}">
                                        @error('start_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- End Date -->
                                    <label for="end_date" class="col-sm-1 col-form-label">End Date</label>
                                    <div class="col-sm-3">
                                        <input type="datetime-local" class="form-control form-control-sm" id="end_date"
                                            name="end_date"
                                            value="{{ old('end_date', isset($banner) && $banner->end_date ? $banner->end_date->format('Y-m-d\TH:i') : '') }}">
                                        @error('end_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Discount -->
                                    <label for="discount" class="col-sm-1 col-form-label">Discount (%)</label>
                                    <div class="col-sm-3">
                                        <input type="number" step="0.01" class="form-control form-control-sm"
                                            id="discount" name="discount"
                                            value="{{ old('discount', $banner->discount ?? '') }}">
                                        @error('discount')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <!-- Button Text -->
                                    <label for="button_text" class="col-sm-1 col-form-label">Button Text</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="button_text"
                                            name="button_text"
                                            value="{{ old('button_text', $banner->button_text ?? '') }}">
                                        @error('button_text')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <label class="col-sm-1 col-form-label">Products</label>
                                    <div class="col-sm-6">
                                        <select class="form-control select2" name="product_ids[]" id="product_select"
                                            multiple>
                                            @foreach (App\Models\Product::orderBy('name')->get() as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ (isset($banner) && $banner->products->contains($item->id)) || (is_array(old('product_ids')) && in_array($item->id, old('product_ids', []))) ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('product_ids')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="my-2">
                                <div class="clearfix">
                                    <div class="text-end m-auto">
                                        <button type="reset" class="btn btn-dark">Reset</button>
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($banner) ? 'Update Banner' : 'Create Banner' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Banner List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-list me-1"></i>Banner List</div>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Banner Image</th>
                                <th>Title One</th>
                                <th>Title Two</th>
                                <th>Button Text</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $key => $b)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="align-middle"><img
                                            src="{{ asset('uploads/banners/' . $b->banner_image) }}" alt="Banner"
                                            width="40" height="40"></td>
                                    <td class="align-middle">{{ $b->title_one }}</td>
                                    <td class="align-middle">{{ $b->title_two }}</td>
                                    <td class="align-middle">{{ $b->button_text }}</td>
                                    <td class="align-middle">
                                        <form action="{{ route('banners.updateStatus', $b->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $b->status == 'a' ? 'd' : 'a' }}">

                                            <button type="submit"
                                                class="btn btn-sm {{ $b->status == 'a' ? 'btn-success' : 'btn-danger' }}"
                                                style="padding: 2px 10px; font-size: 12px; display: flex; align-items: center; gap: 5px; margin-top: 7px;">

                                                @if ($b->status == 'a')
                                                    <i class="fas fa-check-circle"></i> Active
                                                @elseif ($b->status == 'd')
                                                    <i class="fas fa-ban"></i> Deactive
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('banners.edit', $b->id) }}" class="btn btn-edit"
                                            style="margin-top: 10px;">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('banners.destroy', $b->id) }}" method="POST"
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
            .create(document.querySelector('#banner_editor'))
            .catch(error => {
                console.error('CKEditor Error:', error);
            });
    </script>
@endsection
