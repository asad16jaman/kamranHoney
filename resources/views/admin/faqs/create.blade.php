@extends('admin.layouts.master')

@section('title', 'Create FAQ')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i> <a href="{{ route('dashboard') }}">Dashboard</a> >
                    Create FAQ</span>
            </div>

            <!-- Create FAQ Form -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-question-circle me-1"></i> Add New FAQ</div>
                    <a href="{{ route('faqs.index') }}" class="btn btn-addnew">
                        <i class="fa fa-file-alt"></i> View All
                    </a>
                </div>
                <div class="card-body table-card-body">
                    <div class="row">
                        <form method="POST"
                            action="{{ isset($faq) ? route('faqs.update', $faq->id) : route('faqs.store') }}">
                            @csrf
                            @if (isset($faq))
                                @method('PUT')
                            @endif

                            <div class="row">
                                <!-- Question -->
                                <div class="form-group row mt-2">
                                    <label for="faq_question" class="col-sm-1 col-form-label">Question</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control form-control-sm" id="faq_question"
                                            name="question" value="{{ old('question', $faq->question ?? '') }}">
                                        @error('question')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Answer -->
                                    <label for="faq_answer" class="col-sm-1 col-form-label">Answer</label>
                                    <div class="col-sm-5">
                                        <textarea class="form-control form-control-sm" id="faq_answer" name="answer" rows="3">{{ old('answer', $faq->answer ?? '') }}</textarea>
                                        @error('answer')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="my-2">
                                <div class="clearfix">
                                    <div class="text-end m-auto">
                                        <button type="reset" class="btn btn-dark">Reset</button>
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($faq) ? 'Update FAQ' : 'Add FAQ' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- FAQ List Table -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-list me-1"></i>FAQ List</div>
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
