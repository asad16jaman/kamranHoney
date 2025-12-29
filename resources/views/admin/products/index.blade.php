@extends('admin.layouts.master')

@section('title', 'All Products')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> >
                    All Products
                </span>
            </div>

            <!-- Product List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-box me-1"></i>Product List</div>
                    @if (auth()->user()->type == 'admin')
                        <a href="{{ route('products.create') }}" class="btn btn-addnew">
                            <i class="fa fa-plus"></i> Add New
                        </a>
                    @endif
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Images</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $product)
                                <tr class="text-center">
                                    <td class="align-middle">{{ $key + 1 }}</td>
                                    <td class="align-middle">{{ $product->product_code }}</td>
                                    <td class="align-middle">{{ $product->name }}</td>
                                    <td class="align-middle">{{ $product->category->name ?? 'N/A' }}</td>
                                    <td class="align-middle">{{ $product->client->name ?? 'N/A' }}</td>
                                    <td class="align-middle">{{ $product->price }}</td>
                                    <td class="align-middle">
                                        <img src="{{ $product->thumbnail_image ? asset($product->thumbnail_image) : asset('uploads/no_images/no-image.png') }}"
                                            alt="Product Image" width="40" height="40">
                                    </td>
                                    <td class="align-middle">
                                        @php
                                            $gallery = json_decode($product->gallery_images, true);
                                        @endphp
                                        @if ($gallery && is_array($gallery))
                                            @foreach ($gallery as $image)
                                                <img src="{{ asset($image) }}" alt="Gallery" width="40" height="40"
                                                    class="m-1 rounded">
                                            @endforeach
                                        @else
                                            <span class="text-muted">No Images</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('products.updateStatus', $product->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $product->status == 'a' ? 'd' : 'a' }}">
                                            <button type="submit"
                                                class="btn btn-sm {{ $product->status == 'a' ? 'btn-success' : 'btn-danger' }}"
                                                style="font-size: 12px;">
                                                @if ($product->status == 'a')
                                                    <i class="fas fa-check-circle me-1"></i> Active
                                                @else
                                                    <i class="fas fa-ban me-1"></i> Deactive
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-edit me-2"
                                                title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                class="delete-form m-0 p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-delete show-confirm" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
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
