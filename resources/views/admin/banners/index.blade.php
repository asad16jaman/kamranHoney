@extends('admin.layouts.master')

@section('title', 'Banner List')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > Banner List
                </span>
            </div>

            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head">
                        <i class="fas fa-users me-1"></i> Banner List
                    </div>
                    <a href="{{ route('banners.create') }}" class="btn btn-addnew">
                        <i class="fa fa-plus"></i> Add New
                    </a>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Banner Image</th>
                                <th>Title One</th>
                                <th>Title Two</th>
                                <th>Button Text</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $key => $b)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="align-middle"><img src="{{ asset('uploads/banners/' . $b->banner_image) }}"
                                            alt="Banner" width="40" height="40"></td>
                                    <td class="align-middle">{{ $b->title_one }}</td>
                                    <td class="align-middle">{{ $b->title_two }}</td>
                                    <td class="align-middle">{{ $b->button_text }}</td>
                                    <td class="align-middle">
                                        <form action="{{ route('banners.updateStatus', $b->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $b->status == 'a' ? 'd' : 'a' }}">

                                            <button type="submit"
                                                class="btn btn-sm {{ $b->status == 'a' ? 'btn-success' : 'btn-danger' }}"
                                                style="padding: 2px 10px; font-size: 12px; display: flex; align-items: center; gap: 5px; margin-top: 7px;">

                                                @if ($b->status == 'a')
                                                    <i class="fas fa-check-circle"></i> Active
                                                @elseif ($b->status == 'd')
                                                    <i class="fas fa-ban"></i> Deactive
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('banners.edit', $b->id) }}" class="btn btn-edit"
                                            style="margin-top: 10px;">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('banners.destroy', $b->id) }}" method="POST"
                                            class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-delete show-confirm"
                                                style="margin-top: 10px;">
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
