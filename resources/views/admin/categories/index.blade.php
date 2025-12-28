@extends('admin.layouts.master')

@section('title', 'All Categories')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> >
                    All Categories
                </span>
            </div>

            <!-- Category List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-list me-1"></i>Category List</div>
                    <a href="{{ route('categories.create') }}" class="btn btn-addnew">
                        <i class="fa fa-plus"></i> Add New
                    </a>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Category Image</th>
                                <th>Category Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key => $category)
                                <tr class="text-center">
                                    <td class="text-center align-middle">{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ $category->image ? asset($category->image) : asset('uploads/no_images/no-image.png') }}"
                                            alt="Category Image" width="40" height="40">
                                    </td>
                                    <td class="text-center align-middle">{{ $category->name }}</td>
                                    <td class="text-center align-middle" style="vertical-align: middle;">
                                        <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                            <form action="{{ route('categories.updateStatus', $category->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status"
                                                    value="{{ $category->status == 'a' ? 'd' : 'a' }}">
                                                <button type="submit"
                                                    class="btn btn-sm {{ $category->status == 'a' ? 'btn-success' : 'btn-danger' }} d-flex align-items-center justify-content-center"
                                                    style="padding: 4px 12px; font-size: 12px;">
                                                    @if ($category->status == 'a')
                                                        <i class="fas fa-check-circle me-1"></i> Active
                                                    @else
                                                        <i class="fas fa-ban me-1"></i> Deactive
                                                    @endif
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                    <td class="text-center align-middle">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        {{-- <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-delete"
                                                    onclick="return confirm('Are you sure you want to delete this category?');">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form> --}}
                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
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
@endsection
