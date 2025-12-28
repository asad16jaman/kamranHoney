@extends('admin.layouts.master')

@section('title', 'Manage Sizes & Colors')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> >
                    Manage Size & Color
                </span>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <!-- Create Color -->
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <div class="table-head"><i class="fas fa-palette me-1"></i> Add New Color</div>
                        </div>
                        <div class="card-body">
                            <form method="POST"
                                action="{{ isset($editColor) ? route('colors.update', $editColor->id) : route('colors.store') }}">
                                @csrf
                                @if (isset($editColor))
                                    @method('PUT')
                                @endif

                                <div class="form-group mb-2">
                                    <label for="color_name">Color Name</label>
                                    <input type="text" class="form-control form-control-sm" id="color_name"
                                        name="name" value="{{ old('name', $editColor->name ?? '') }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($editColor) ? 'Update Color' : 'Add Color' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Color List -->
                    <div class="card">
                        <div class="card-header"><i class="fas fa-palette me-1"></i> Color List</div>
                        <div class="card-body table-card-body">
                            <table class="table table-striped table-sm">
                                <thead class="bg-light text-center">
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($colors as $key => $color)
                                        <tr class="text-center">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $color->name }}</td>
                                            <td class="align-middle">
                                                <form action="{{ route('colors.updateStatus', $color->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status"
                                                        value="{{ $color->status == 'a' ? 'd' : 'a' }}">
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $color->status == 'a' ? 'btn-success' : 'btn-danger' }}"
                                                        style="padding: 2px 10px; font-size: 12px; align-items: center; gap: 5px;">
                                                        @if ($color->status == 'a')
                                                            <i class="fas fa-check-circle"></i> Active
                                                        @elseif ($color->status == 'd')
                                                            <i class="fas fa-ban"></i> Deactive
                                                        @endif
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('sizes_colors.index', ['edit_color_id' => $color->id]) }}"
                                                    class="btn btn-edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <form action="{{ route('colors.destroy', $color->id) }}" method="POST"
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

                {{-- Right Column: Sizes --}}
                <div class="col-md-6">
                    <!-- Create Size -->
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <div class="table-head"><i class="fas fa-text-height me-1"></i> Add New Size</div>
                        </div>
                        <div class="card-body">
                            <form method="POST"
                                action="{{ isset($editSize) ? route('sizes.update', $editSize->id) : route('sizes.store') }}">
                                @csrf

                                @if (isset($editSize))
                                    @method('PUT')
                                @endif

                                <div class="form-group mb-2">
                                    <label for="size_name">Size Name</label>
                                    <input type="text" class="form-control form-control-sm" id="size_name" name="name"
                                        value="{{ old('name', $editSize->name ?? '') }}" required>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        {{ isset($editSize) ? 'Update Size' : 'Add Size' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Size List -->
                    <div class="card">
                        <div class="card-header"><i class="fas fa-text-height me-1"></i> Size List</div>
                        <div class="card-body table-card-body">
                            <table class="table table-striped table-sm">
                                <thead class="bg-light text-center">
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sizes as $key => $size)
                                        <tr class="text-center">
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $size->name }}</td>
                                            <td class="align-middle">
                                                <form action="{{ route('sizes.updateStatus', $size->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status"
                                                        value="{{ $size->status == 'a' ? 'd' : 'a' }}">
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $size->status == 'a' ? 'btn-success' : 'btn-danger' }}"
                                                        style="padding: 2px 10px; font-size: 12px; align-items: center; gap: 5px;">
                                                        @if ($size->status == 'a')
                                                            <i class="fas fa-check-circle"></i> Active
                                                        @elseif ($size->status == 'd')
                                                            <i class="fas fa-ban"></i> Deactive
                                                        @endif
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('sizes_colors.index', ['edit_size_id' => $size->id]) }}"
                                                    class="btn btn-edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <form action="{{ route('sizes.destroy', $size->id) }}" method="POST"
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
            </div>
        </div>
    </main>
@endsection
