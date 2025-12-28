@extends('admin.layouts.master')

@section('title', isset($coupon) ? 'Edit Coupon' : 'Create Coupon')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > {{ isset($coupon) ? 'Edit Coupon' : 'Create Coupon' }}
                </span>
            </div>

            <!-- Create Coupon Form -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-ticket-alt me-1"></i>{{ isset($coupon) ? 'Edit' : 'Create New' }}
                        Coupon</div>
                    <a href="{{ route('coupons.index') }}" class="btn btn-addnew"> <i class="fa fa-file-alt"></i> View
                        All</a>
                </div>
                <div class="card-body table-card-body">
                    <div class="row">
                        <form method="POST"
                            action="{{ isset($coupon) ? route('coupons.update', $coupon->id) : route('coupons.store') }}">
                            @csrf
                            @if (isset($coupon))
                                @method('PUT')
                            @endif

                            <div class="form-group row">
                                <!-- Code -->
                                <label for="code" class="col-sm-1 col-form-label">Code</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control form-control-sm" id="code" name="code"
                                        value="{{ old('code', $coupon->code ?? '') }}">
                                    @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Type -->
                                <label for="type" class="col-sm-1 col-form-label">Type</label>
                                <div class="col-sm-3">
                                    <select name="type" class="form-control form-control-sm" id="type">
                                        <option value="fixed"
                                            {{ old('type', $coupon->type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed
                                        </option>
                                        <option value="percent"
                                            {{ old('type', $coupon->type ?? '') == 'percent' ? 'selected' : '' }}>Percent
                                        </option>
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Value -->
                                <label for="value" class="col-sm-1 col-form-label">Value</label>
                                <div class="col-sm-3">
                                    <input type="number" step="0.01" class="form-control form-control-sm" id="value"
                                        name="value" value="{{ old('value', $coupon->value ?? '') }}">
                                    @error('value')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-2">
                                <!-- Usage Limit -->
                                <label for="usage_limit" class="col-sm-1 col-form-label">Coupon Use Limit</label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control form-control-sm" id="usage_limit"
                                        name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}">
                                    @error('usage_limit')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Usage Limit/User -->
                                <label for="usage_limit_per_user" class="col-sm-1 col-form-label">User Usage Limit</label>
                                <div class="col-sm-3">
                                    <input type="number" class="form-control form-control-sm" id="usage_limit_per_user"
                                        name="usage_limit_per_user"
                                        value="{{ old('usage_limit_per_user', $coupon->usage_limit_per_user ?? '') }}">
                                    @error('usage_limit_per_user')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Start Date -->
                                <label for="start_date" class="col-sm-1 col-form-label">Start Date</label>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control form-control-sm" id="start_date"
                                        name="start_date" value="{{ old('start_date', $coupon->start_date ?? '') }}">
                                    @error('start_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mt-2">
                                <!-- End Date -->
                                <label for="end_date" class="col-sm-1 col-form-label">End Date</label>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control form-control-sm" id="end_date"
                                        name="end_date" value="{{ old('end_date', $coupon->end_date ?? '') }}">
                                    @error('end_date')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-3">
                            <div class="clearfix">
                                <div class="text-end m-auto">
                                    <button type="reset" class="btn btn-dark">Reset</button>
                                    <button type="submit"
                                        class="btn btn-primary">{{ isset($coupon) ? 'Update Coupon' : 'Create Coupon' }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Coupon List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-list me-1"></i>Coupon List</div>
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
