@extends('admin.layouts.master')

@section('title', 'Create Blog')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > Create Blog
                </span>
            </div>

            <!-- Create Blog Form -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-blog me-1"></i>Create Blog</div>
                    <a href="{{ route('blogs.index') }}" class="btn btn-addnew">
                        <i class="fa fa-file-alt"></i> View All
                    </a>
                </div>
                <div class="card-body table-card-body">
                    <form method="POST"
                        action="{{ isset($blog) ? route('blogs.update', $blog->id) : route('blogs.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        @if (isset($blog))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="form-group row">
                                <!-- Blog Image -->
                                <label for="image" class="col-sm-1 col-form-label">Image</label>
                                <div class="col-sm-3">
                                    <div class="d-flex align-items-center">
                                        <img id="imagePreview"
                                            src="{{ isset($blog) && $blog->image && $blog->image !== 'no-image.png'
                                                ? asset('uploads/blogs/' . $blog->image)
                                                : asset('uploads/no_images/no-image.png') }}"
                                            alt="Image Preview" width="50" class="me-2">
                                        <input type="file" class="form-control form-control-sm" id="image"
                                            name="image" accept="image/*" onchange="previewImage(event)">
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted d-inline-block text-nowrap">
                                        <span style="color: red; position: relative;">
                                            JPG/JPEG/PNG • Max: 2MB • 600×412px
                                        </span>
                                    </small>
                                </div>

                                <!-- Blog Title -->
                                <label for="blog_title" class="col-sm-1 col-form-label">Title</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" id="title" name="title"
                                        value="{{ old('title', $blog->title ?? '') }}">
                                    @error('blog_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Name -->
                                <label for="name" class="col-sm-1 col-form-label">Author Name</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control form-control-sm" id="name" name="name"
                                        value="{{ old('name', $blog->name ?? '') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <!-- Blog Description -->
                                <label for="description" class="col-sm-1 col-form-label">Description</label>
                                <div class="col-sm-11">
                                    <textarea class="form-control form-control-sm" id="blog_editor" name="description" rows="4">{{ old('description', $blog->description ?? '') }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-2">
                            <div class="text-end m-auto">
                                <button type="reset" class="btn btn-dark">Reset</button>
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($blog) ? 'Update Blog' : 'Create Blog' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Blog List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-list me-1"></i>Blog List</div>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allBlogs as $key => $blog)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="align-middle">
                                        <img src="{{ $blog->image && $blog->image !== 'no-image.png'
                                            ? asset('uploads/blogs/' . $blog->image)
                                            : asset('uploads/no_images/no-image.png') }}"
                                            alt="Blog Image"
                                            style="width: 40px; height: 40px; object-fit: cover; margin-left: 11px;">
                                    </td>
                                    <td class="align-middle">{{ $blog->title }}</td>
                                    <td class="align-middle">{{ $blog->name }}</td>
                                    <td class="align-middle">{{ Str::limit(strip_tags($blog->description), 50) }}</td>

                                    <td class="align-middle">
                                        <form action="{{ route('blogs.updateStatus', $blog->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $blog->status == 'a' ? 'd' : 'a' }}">
                                            <button type="submit"
                                                class="btn btn-sm {{ $blog->status == 'a' ? 'btn-success' : 'btn-danger' }}"
                                                style="padding: 2px 10px; font-size: 12px;">
                                                {{ $blog->status == 'a' ? 'Active' : 'Deactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST"
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
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        ClassicEditor
            .create(document.querySelector('#blog_editor'))
            .catch(error => {
                console.error('CKEditor Error:', error);
            });
    </script>
@endsection
