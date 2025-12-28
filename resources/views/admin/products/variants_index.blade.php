@extends('admin.layouts.master')

@section('title', 'All Variants')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> >
                    All Variants
                </span>
            </div>

            <!-- Variant List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-box me-1"></i>Variant List</div>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Stock</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($variants as $key => $variant)
                                <tr>
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="align-middle">
                                        @php
                                            $thumb = $variant->product->thumbnail_image ?? null;
                                        @endphp
                                        <img src="{{ $thumb ? asset($thumb) : asset('uploads/no_images/no-image.png') }}"
                                            alt="Product Image" width="40" height="40">
                                    </td>
                                    <td class="align-middle">{{ $variant->product->name ?? 'N/A' }}</td>
                                    <td class="align-middle">{{ $variant->size->name ?? '-' }}</td>
                                    <td class="align-middle">{{ $variant->color->name ?? '-' }}</td>
                                    <td class="align-middle">{{ $variant->stock }}</td>
                                    <td>
                                        <a href="#" class="btn btn-edit" data-bs-toggle="modal"
                                            data-bs-target="#editVariantModal{{ $variant->id }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </td>
                                </tr>

                                @include('admin.partials.variant_edit_modal', [
                                    'variant' => $variant,
                                    'sizes' => \App\Models\Size::all(),
                                    'colors' => \App\Models\Color::all(),
                                ])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
