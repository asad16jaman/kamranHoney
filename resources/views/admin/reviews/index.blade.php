@extends('admin.layouts.master')

@section('title', 'All Reviews')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> >
                    All Reviews
                </span>
            </div>

            <!-- Review List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-star me-1"></i>Review List</div>
                    @if (auth()->user()->type == 'admin')
                        <a href="{{ route('review.create') }}" class="btn btn-addnew">
                            <i class="fa fa-plus"></i> Add New
                        </a>
                    @endif
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Reviewer Image</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Review</th>
                                @if (auth()->user()->type == 'admin')
                                    <th>Status</th>
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $key => $review)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ $review->image ? asset($review->image) : asset('uploads/no_images/no-image.png') }}"
                                            alt="Reviewer Image" width="40" height="40">
                                    </td>
                                    <td class="align-middle">{{ $review->name }}</td>
                                    <td class="align-middle">{{ $review->title }}</td>
                                    <td class="align-middle">{{ Str::limit($review->review, 40) }}</td>
                                    @if (auth()->user()->type == 'admin')
                                        <td class="align-middle">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <form action="{{ route('review.updateStatus', $review->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status"
                                                        value="{{ $review->status == 'a' ? 'd' : 'a' }}">
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $review->status == 'a' ? 'btn-success' : 'btn-danger' }}"
                                                        style="padding: 4px 12px; font-size: 12px;">
                                                        @if ($review->status == 'a')
                                                            <i class="fas fa-check-circle me-1"></i> Active
                                                        @else
                                                            <i class="fas fa-ban me-1"></i> Deactive
                                                        @endif
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                        <td class="align-middle">
                                            <a href="{{ route('review.edit', $review->id) }}" class="btn btn-edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('review.destroy', $review->id) }}" method="POST"
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
@endsection
