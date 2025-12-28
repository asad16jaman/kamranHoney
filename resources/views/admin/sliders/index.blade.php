@extends('admin.layouts.master')

@section('title', 'User List')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> > Slider List
                </span>
            </div>

            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head">
                        <i class="fas fa-users me-1"></i> Slider List
                    </div>

                    <a href="{{ route('sliders.create') }}" class="btn btn-addnew">
                        <i class="fa fa-plus"></i> Add New
                    </a>

                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Slider Image</th>
                                <th>Title One</th>
                                <th>Title Two</th>
                                <th>Button Text</th>
                                {{-- <th>Button Text</th> --}}
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sliders as $key => $slider)
                                <tr class="text-center">
                                    <td>{{ $key + 1 }}</td>
                                    <td text-center align-middle><img
                                            src="{{ asset('uploads/sliders/' . $slider->slider_image) }}" alt="Slider Image"
                                            width="40" height="40">
                                    </td>
                                    <td>{{ $slider->slider_title_one }}</td>
                                    <td>{{ $slider->slider_title_two }}</td>
                                    <td>{{ $slider->button_text }}</td>
                                    {{-- <td>{{ Str::limit(strip_tags($slider->description), 50) }}</td> --}}
                                    <td class="text-center">
                                        <form action="{{ route('sliders.updateStatus', $slider->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $slider->status == 'a' ? 'd' : 'a' }}">

                                            <button type="submit"
                                                class="btn btn-sm {{ $slider->status == 'a' ? 'btn-success' : 'btn-danger' }}"
                                                style="padding: 2px 10px; font-size: 12px; display: flex; align-items: center; gap: 5px; margin-top: 7px;">

                                                @if ($slider->status == 'a')
                                                    <i class="fas fa-check-circle"></i> Active
                                                @elseif ($slider->status == 'd')
                                                    <i class="fas fa-ban"></i> Deactive
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-edit"
                                            style="margin-top: 10px;">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST"
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
