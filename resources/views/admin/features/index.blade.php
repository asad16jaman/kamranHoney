@extends('admin.layouts.master')

@section('title', 'Feature List')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > Feature List
                </span>
            </div>

            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head">
                        <i class="fas fa-users me-1"></i> Feature List
                    </div>
                    <a href="{{ route('features.create') }}" class="btn btn-addnew">
                        <i class="fa fa-plus"></i> Add New
                    </a>
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
@endsection
