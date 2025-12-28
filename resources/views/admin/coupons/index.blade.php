@extends('admin.layouts.master')

@section('title', 'Coupon List')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > Coupon List
                </span>
            </div>

            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head">
                        <i class="fas fa-ticket-alt me-1"></i> Coupon List
                    </div>
                    <a href="{{ route('coupons.create') }}" class="btn btn-addnew">
                        <i class="fa fa-plus"></i> Add New
                    </a>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $key => $c)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="align-middle">{{ $c->code }}</td>
                                    <td class="align-middle">{{ ucfirst($c->type) }}</td>
                                    <td class="align-middle">{{ $c->value }}</td>
                                    <td class="align-middle">
                                        {{ $c->start_date ? \Carbon\Carbon::parse($c->start_date)->format('d M, Y') : '-' }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $c->end_date ? \Carbon\Carbon::parse($c->end_date)->format('d M, Y') : '-' }}
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('coupons.updateStatus', $c->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $c->status == 'a' ? 'd' : 'a' }}">
                                            <button type="submit"
                                                class="btn btn-sm {{ $c->status == 'a' ? 'btn-success' : 'btn-danger' }}"
                                                style="font-size: 12px;">
                                                @if ($c->status == 'a')
                                                    <i class="fas fa-check-circle me-1"></i> Active
                                                @else
                                                    <i class="fas fa-ban me-1"></i> Deactive
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('coupons.edit', $c->id) }}" class="btn btn-edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('coupons.destroy', $c->id) }}" method="POST"
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
