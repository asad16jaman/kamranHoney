@extends('admin.layouts.master')

@section('title', 'Return Policy')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="card my-3">
                <div class="heading-title p-2 my-2">
                    <span class="my-3 heading"><i class="fas fa-home"></i>
                        <a href="{{ route('dashboard') }}">Dashboard</a> > Return Policy
                    </span>
                </div>
                <div class="card-body table-card-body">
                    @if ($return)
                        <form method="POST" action="{{ route('return.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Title -->
                                <label for="title" class="col-sm-1 col-form-label">Title</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" id="title" name="title"
                                        value="{{ old('title', $return->title) }}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <label for="description" class="col-sm-1 col-form-label">Description</label>
                                <div class="col-sm-7">
                                    <textarea id="description" class="form-control form-control-sm @error('description') is-invalid @enderror"
                                        name="description" placeholder="Enter Description" rows="5">{{ old('description', $return->description) }}</textarea>
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
                        <div class="alert alert-warning">No Return Policy content found. Please create a new entry.</div>
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
