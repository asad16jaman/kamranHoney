@extends('admin.layouts.master')

@section('title', 'Blog List')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > Blog List
                </span>
            </div>

            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head">
                        <i class="fas fa-blog me-1"></i> Blog List
                    </div>
                    @if (auth()->user()->type == 'admin')
                        <a href="{{ route('blogs.create') }}" class="btn btn-addnew">
                            <i class="fa fa-plus"></i> Add New
                        </a>
                    @endif
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
                                @if (auth()->user()->type == 'admin')
                                    <th>Status</th>
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($blogs as $key => $blog)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="align-middle">
                                        @if ($blog->image && $blog->image !== 'no-image.png')
                                            <img src="{{ asset('uploads/blogs/' . $blog->image) }}" alt="Blog Image"
                                                style="width: 40px; height: 40px; object-fit: cover; margin-left: 11px;">
                                        @else
                                            <img src="{{ asset('uploads/no_images/no-image.png') }}" alt="No Image"
                                                style="width: 40px; height: 40px; object-fit: cover; margin-left: 11px;">
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ $blog->title }}</td>
                                    <td class="align-middle">{{ $blog->name }}</td>
                                    <td class="align-middle">{{ Str::limit(strip_tags($blog->description), 50) }}</td>
                                    @if (auth()->user()->type == 'admin')
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
                                            <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-edit"><i
                                                    class="fas fa-pencil-alt"></i></a>
                                            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-delete show-confirm"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
