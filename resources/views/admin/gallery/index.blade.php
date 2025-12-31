@extends('admin.layouts.master')

@section('title', 'Create Gallery')
@section('main-content')
    <main>
        <div class="container-fluid">

            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> >
                    Gallery
                </span>
            </div>
            <!-- Gallery Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-list me-1"></i> Gallery List</div>
                    @if (auth()->user()->type == 'admin')
                        <a href="{{ route('gallery.create') }}" class="btn btn-addnew">
                            <i class="fa fa-plus"></i> Add New
                        </a>
                    @endif
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Gallery Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Video URL</th>
                                @if (auth()->user()->type == 'admin')
                                    <th>Status</th>
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($galleries as $key => $item)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ $item->image ? asset('uploads/gallery/' . $item->image) : asset('uploads/no_images/no-image.png') }}"
                                            alt="Gallery Image" width="40" height="40">
                                    </td>
                                    <td class="align-middle">{{ $item->title_1 }}</td>
                                    <td class="align-middle">{{ Str::limit(strip_tags($item->description ?? 'N/A'), 50) }}
                                    </td>
                                    <td class="align-middle">
                                        @if ($item->video_url)
                                            <a href="{{ $item->video_url }}" target="_blank">View Video</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    @if (auth()->user()->type == 'admin')
                                        <td class="align-middle">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <form action="{{ route('gallery.updateStatus', $item->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status"
                                                        value="{{ $item->status == 'a' ? 'd' : 'a' }}">
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $item->status == 'a' ? 'btn-success' : 'btn-danger' }} d-flex align-items-center justify-content-center"
                                                        style="padding: 4px 12px; font-size: 12px;">
                                                        @if ($item->status == 'a')
                                                            <i class="fas fa-check-circle me-1"></i> Active
                                                        @else
                                                            <i class="fas fa-ban me-1"></i> Deactive
                                                        @endif
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('gallery.edit', $item->id) }}" class="btn btn-edit me-1">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            {{-- <form action="{{ route('gallery.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-delete"
                                                    onclick="return confirm('Are you sure you want to delete this item?');">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form> --}}
                                            <form action="{{ route('gallery.destroy', $item->id) }}" method="POST"
                                                class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-delete show-confirm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 3000);
            }

            // Init toggle
            toggleFields();

            // Bind change event
            document.getElementById('type').addEventListener('change', toggleFields);
        });
    </script>
@endsection
