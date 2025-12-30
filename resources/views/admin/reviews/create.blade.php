@extends('admin.layouts.master')

@section('title', isset($review) ? 'Edit Review' : 'Create Review')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> >
                    {{ isset($review) ? 'Edit Review' : 'Create Review' }}
                </span>
            </div>

            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-comment-dots me-1"></i>
                        {{ isset($review) ? 'Edit Review' : 'Add New Review' }}</div>
                    <a href="{{ route('review.index') }}" class="btn btn-addnew">
                        <i class="fa fa-file-alt"></i> View All
                    </a>
                </div>
                <div class="card-body table-card-body">
                    <div class="row">
                        <form method="POST"
                            action="{{ isset($review) ? route('review.update', $review->id) : route('review.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if (isset($review))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <!-- Review Image -->
                                <div class="form-group row mt-2">
                                    <label for="review_image" class="col-sm-1 col-form-label">Image</label>
                                    <div class="col-sm-3">
                                        <div class="d-flex align-items-center">
                                            <img id="imagePreview"
                                                src="{{ isset($review) && $review->image ? asset($review->image) : asset('uploads/no_images/no-image.png') }}"
                                                alt="Review Image Preview" width="40" class="me-2">
                                            <input type="file" class="form-control form-control-sm" id="review_image"
                                                name="image" accept="image/*" onchange="previewImage(event)">
                                        </div>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <span style="color: red; position: relative; left: 6px; white-space: nowrap;">
                                            JPG/JPEG/PNG • Max: 2MB • 600x600px
                                        </span>
                                    </div>

                                    <!-- Review Name -->
                                    <label for="review_name" class="col-sm-1 col-form-label">Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="review_name"
                                            name="name" value="{{ old('name', $review->name ?? '') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <label for="review_title" class="col-sm-1 col-form-label">Title</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="review_title"
                                            name="title" value="{{ old('title', $review->title ?? '') }}">
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <label for="review_text" class="col-sm-1 col-form-label">Review</label>
                                    <div class="col-sm-11">
                                        <textarea class="form-control form-control-sm" id="review_text" name="review" rows="3">{{ old('review', $review->review ?? '') }}</textarea>
                                        @error('review')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="my-2">
                                <div class="clearfix">
                                    <div class="text-end m-auto">
                                        <button type="reset" class="btn btn-dark">Reset</button>
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($review) ? 'Update Review' : 'Add Review' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Review List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-list me-1"></i>Review List</div>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Review</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $key => $item)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ $item->image ? asset($item->image) : asset('uploads/no_images/no-image.png') }}"
                                            alt="Review Image" width="40" height="40">
                                    </td>
                                    <td class="align-middle">{{ $item->name }}</td>
                                    <td class="align-middle">{{ $item->title }}</td>
                                    <td class="align-middle">{{ Str::limit($item->review, 60) }}</td>
                                    <td class="text-center align-middle">
                                        <a href="{{ route('review.edit', $item->id) }}" class="btn btn-edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('review.destroy', $item->id) }}" method="POST"
                                            class="d-inline delete-form">
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
            .create(document.querySelector('#review_text'))
            .catch(error => {
                console.error('CKEditor Error:', error);
            });
    </script>
@endsection
