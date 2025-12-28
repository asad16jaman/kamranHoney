@extends('admin.layouts.master')

@section('title', 'Edit Client')
@section('main-content')
<main>
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading"><i class="fas fa-home"></i> 
                <a href="{{ route('dashboard') }}">Dashboard</a> > Edit Client
            </span>
        </div>

        <!-- Edit Client Form -->
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <div class="table-head"><i class="fas fa-user me-1"></i> Edit Client</div>
                <a href="{{ route('client.index') }}" class="btn btn-addnew"> <i class="fa fa-file-alt"></i> View All</a>
            </div>
            <div class="card-body table-card-body">
                <div class="row">
                    <form method="POST" action="{{ route('client.update', $client->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Client Image -->
                            <div class="form-group row mt-2">
                                <label for="client_image" class="col-sm-1 col-form-label">Client Logo</label>
                                <div class="col-sm-3">
                                    <div class="d-flex align-items-center">
                                        <img id="imagePreview" 
                                             src="{{ $client->image ? asset($client->image) : asset('uploads/no_images/no-image.png') }}" 
                                             alt="Client Logo Preview" 
                                             width="40" class="me-2">
                                        <input type="file" class="form-control form-control-sm" id="client_image"
                                            name="image" accept="image/*" onchange="previewImage(event)">
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted d-inline-block text-nowrap">
                                        <span style="color: red; position: relative; left: 6px;">Allowed formats:
                                            JPG, JPEG, PNG. Max size: 2MB</span>
                                    </small>
                                </div>

                                <!-- Client Name -->
                                <label for="client_name" class="col-sm-1 col-form-label">Client Name</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" id="client_name"
                                        name="name" value="{{ old('name', $client->name) }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-2">
                            <div class="clearfix">
                                <div class="text-end m-auto">
                                    <a href="{{ route('client.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Update Client</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Image Preview Script -->
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function () {
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
