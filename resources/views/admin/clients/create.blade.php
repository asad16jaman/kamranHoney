@extends('admin.layouts.master')

@section('title', 'Create Brand')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i> <a href="{{ route('dashboard') }}">Dashboard</a> >
                    Create Brand</span>
            </div>

            <!-- Create Client Form -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-user me-1"></i> Add New Brand</div>
                    <a href="{{ route('client.index') }}" class="btn btn-addnew"> <i class="fa fa-file-alt"></i> View All</a>
                </div>
                <div class="card-body table-card-body">
                    <div class="row">
                        <form method="POST"
                            action="{{ isset($client) ? route('client.update', $client->id) : route('client.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if (isset($client))
                                @method('PUT')
                            @endif

                            <div class="row justify-content-center">

                                <!-- Brand Name -->
                                <div class="form-group row mt-2 align-items-center justify-content-center">
                                    <label for="client_name" class="col-sm-1 col-form-label">Brand Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="client_name"
                                            name="name" value="{{ old('name', $client->name ?? '') }}">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Brand Logo -->
                                <div class="form-group row mt-2 align-items-center justify-content-center">
                                    <label for="client_image" class="col-sm-1 col-form-label">Brand Logo</label>
                                    <div class="col-sm-3">
                                        <div class="d-flex align-items-center">
                                            <img id="clientImagePreview"
                                                src="{{ isset($client) && $client->image ? asset($client->image) : asset('uploads/no_images/no-image.png') }}"
                                                width="40" class="me-2">
                                            <input type="file" class="form-control form-control-sm" id="client_image"
                                                name="image" accept="image/*" onchange="previewClientImage(event)">
                                        </div>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted d-inline-block text-nowrap">
                                            <span style="color:red;">
                                                JPG/JPEG/PNG • Max: 2MB • 410×410px
                                            </span>
                                        </small>
                                    </div>
                                </div>

                                <hr class="my-2">

                                <div class="clearfix text-center">
                                    <button type="reset" class="btn btn-dark">Reset</button>
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($client) ? 'Update Brand' : 'Add Brand' }}
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Client List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-list me-1"></i>Brand List</div>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Brand Logo</th>
                                <th>Brand Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $key => $client)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="align-middle">
                                        <img src="{{ $client->image ? asset($client->image) : asset('uploads/no_images/no-image.png') }}"
                                            alt="Client Logo" width="50">
                                    </td>
                                    <td class="align-middle">{{ $client->name }}</td>
                                    <td class="align-middle">
                                        <form action="{{ route('client.updateStatus', $client->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $client->status == 'a' ? 'd' : 'a' }}">
                                            <button type="submit"
                                                class="btn btn-sm {{ $client->status == 'a' ? 'btn-success' : 'btn-danger' }}"
                                                style="padding: 2px 10px; font-size: 12px; align-items: center; gap: 5px;">
                                                @if ($client->status == 'a')
                                                    <i class="fas fa-check-circle"></i> Active
                                                @elseif ($client->status == 'd')
                                                    <i class="fas fa-ban"></i> Deactive
                                                @endif
                                            </button>
                                        </form>
                                    </td>

                                    <td class="align-middle">
                                        <a href="{{ route('client.edit', $client->id) }}" class="btn btn-edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('client.destroy', $client->id) }}" method="POST"
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
    </script>
@endsection
