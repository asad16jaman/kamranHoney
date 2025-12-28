@extends('admin.layouts.master')

@section('title', 'Review List')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > Review List
                </span>
            </div>

            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-list me-1"></i>Review List</div>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Message</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $key => $review)
                                <tr class="text-center align-middle">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="align-middle">{{ $review->product->name ?? 'N/A' }}</td>
                                    <td class="align-middle">
                                        {{ optional($review->customer)->first_name . ' ' . optional($review->customer)->last_name ?? 'Guest' }}
                                    </td>
                                    <td class="align-middle">
                                        <a href="#" data-bs-toggle="modal"
                                            data-bs-target="#messageModal{{ $review->id }}">
                                            View Message
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="messageModal{{ $review->id }}" tabindex="-1"
                                            aria-labelledby="messageModalLabel{{ $review->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="messageModalLabel{{ $review->id }}">
                                                            Review Message</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        {{ $review->message }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-muted"></i>
                                            @endif
                                        @endfor
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('reviews.updateStatus', $review->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $review->status == 'a' ? 'd' : 'a' }}">
                                            <button type="submit"
                                                class="btn btn-sm {{ $review->status == 'a' ? 'btn-success' : 'btn-danger' }}"
                                                style="padding: 2px 10px; font-size: 12px; align-items: center; gap: 5px;">
                                                @if ($review->status == 'a')
                                                    <i class="fas fa-check-circle"></i> Active
                                                @else
                                                    <i class="fas fa-ban"></i> Deactive
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete show-confirm"
                                                title="Delete Review">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($reviews->isEmpty())
                        <p class="text-center my-3">No reviews found.</p>
                    @endif
                </div>
            </div>
        </div>
    </main>
@endsection
