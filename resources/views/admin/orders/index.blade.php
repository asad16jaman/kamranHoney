@extends('admin.layouts.master')

@section('title', 'Order List')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading">
                    <i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > Order List
                </span>
            </div>

            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head">
                        <i class="fas fa-shopping-cart me-1"></i> All Orders
                    </div>
                    {{-- Optional: If admin needs a button like "Export Orders" --}}
                    {{-- @if (auth()->user()->type == 'admin')
                    <a href="#" class="btn btn-addnew">
                        <i class="fas fa-file-export"></i> Export Orders
                    </a>
                    @endif --}}
                </div>

                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Total</th>
                                <th>Payment</th>
                                @if (auth()->user()->type == 'admin')
                                    <th>Status</th>
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr class="text-center">
                                    <td class="align-middle">#{{ $order->order_number }}</td>
                                    <td class="align-middle">
                                        {{ $order->customer?->first_name }} {{ $order->customer?->last_name }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $order->customer?->email }}
                                    </td>
                                    <td class="align-middle">{{ $order->total }} ৳</td>
                                    <td class="align-middle">{{ ucfirst($order->payment_method) }}</td>
                                    @if (auth()->user()->type == 'admin')
                                        <td class="align-middle">
                                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" onchange="this.form.submit()"
                                                    class="form-select form-select-sm text-center"
                                                    style="font-size: 12px; padding: 7px 6px;"
                                                    {{ $order->status === 'c' ? 'disabled' : '' }}>
                                                    <option value="p" {{ $order->status == 'p' ? 'selected' : '' }}>
                                                        Pending</option>
                                                    <option value="a" {{ $order->status == 'a' ? 'selected' : '' }}>
                                                        Approved</option>
                                                    <option value="d" {{ $order->status == 'd' ? 'selected' : '' }}>
                                                        Declined</option>
                                                    <option value="c" {{ $order->status == 'c' ? 'selected' : '' }}>
                                                        Completed</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('orders.show', $order) }}" class="btn btn-edit me-2" title="View Order">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning btn-edit me-2" title="Edit Order">
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                <button type="button" class="btn btn-secondary btn-edit me-2" title="Update Tracking"
                                                    data-bs-toggle="modal" data-bs-target="#trackingModal{{ $order->id }}">
                                                    <i class="fas fa-truck"></i>
                                                </button>

                                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline delete-form m-0 p-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-delete show-confirm" title="Delete Order">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>

                                <!-- Tracking Modal for this Order -->
                                <div class="modal fade" id="trackingModal{{ $order->id }}" tabindex="-1"
                                    aria-labelledby="trackingModalLabel{{ $order->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('orders.updateTracking', $order->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="trackingModalLabel{{ $order->id }}">
                                                        Update
                                                        Tracking Info</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="form-group mb-3">
                                                        <label>Tracking Number</label>
                                                        <input type="text" name="tracking_number" class="form-control"
                                                            value="{{ $order->tracking_number }}">
                                                    </div>

                                                    <div class="form-group mb-3">
                                                        <label>Shipping Carrier</label>
                                                        <select name="shipping_carrier" class="form-control">
                                                            <option value="">Select Carrier</option>
                                                            <option value="Sundarban"
                                                                {{ $order->shipping_carrier == 'Sundarban' ? 'selected' : '' }}>
                                                                Sundarban</option>
                                                            <option value="SA Paribahan"
                                                                {{ $order->shipping_carrier == 'SA Paribahan' ? 'selected' : '' }}>
                                                                SA Paribahan</option>
                                                            <option value="Pathao"
                                                                {{ $order->shipping_carrier == 'Pathao' ? 'selected' : '' }}>
                                                                Pathao</option>
                                                            <option value="Other"
                                                                {{ $order->shipping_carrier == 'Other' ? 'selected' : '' }}>
                                                                Other</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
