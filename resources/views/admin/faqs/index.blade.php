@extends('admin.layouts.master')

@section('title', 'All Faqs')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> >
                    All Faqs
                </span>
            </div>

            <!-- Category List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-list me-1"></i>Faq List</div>
                    <a href="{{ route('faqs.create') }}" class="btn btn-addnew">
                        <i class="fa fa-plus"></i> Add New
                    </a>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($faqs as $key => $faq)
                                <tr class="text-center">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $faq->question }}</td>
                                    <td>{{ Str::limit(strip_tags($faq->answer), 60) }}</td>
                                    <td>
                                        <form action="{{ route('faqs.updateStatus', $faq->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $faq->status == 'a' ? 'd' : 'a' }}">
                                            <button type="submit"
                                                class="btn btn-sm {{ $faq->status == 'a' ? 'btn-success' : 'btn-danger' }}">
                                                @if ($faq->status == 'a')
                                                    <i class="fas fa-check-circle me-1"></i> Active
                                                @else
                                                    <i class="fas fa-ban me-1"></i> Deactive
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('faqs.edit', $faq->id) }}" class="btn btn-edit">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST"
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
