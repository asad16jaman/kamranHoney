@extends('admin.layouts.master')

@section('title', 'Create User')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-home"></i> <a href="{{ route('dashboard') }}">Dashboard</a> >
                    Create User</span>
            </div>

            <!-- Create User Form -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-user-plus me-1"></i>Create New User</div>
                    <a href="{{ route('users.index') }}" class="btn btn-addnew"> <i class="fa fa-file-alt"></i> View All</a>
                </div>
                <div class="card-body table-card-body">
                    <div class="row">
                        {{-- @if (session('success'))
                        <div class="alert alert-success" id="success-alert">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif --}}
                        <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Name -->
                                <div class="form-group row">
                                    <label for="name" class="col-sm-1 col-form-label">Name</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="name"
                                            name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <label for="email" class="col-sm-1 col-form-label">Email</label>
                                    <div class="col-sm-3">
                                        <input type="email" class="form-control form-control-sm" id="email"
                                            name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Username -->
                                    <label for="username" class="col-sm-1 col-form-label">Username</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="username"
                                            name="username" value="{{ old('username') }}">
                                        @error('username')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <label for="address" class="col-sm-1 col-form-label">Address</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="address"
                                            name="address" value="{{ old('address') }}">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <label for="phone" class="col-sm-1 col-form-label">Phone</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control form-control-sm" id="phone"
                                            name="phone" value="{{ old('phone') }}">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- User Type -->
                                    <label for="type" class="col-sm-1 col-form-label">User Type</label>
                                    <div class="col-sm-3">
                                        <select name="type" class="form-control form-control-sm" id="type" required>
                                            <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="user" {{ old('type') == 'user' ? 'selected' : '' }}>User
                                            </option>
                                        </select>
                                        @error('type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Password -->
                                    <label for="password" class="col-sm-1 col-form-label">Password</label>
                                    <div class="col-sm-3">
                                        <input type="password" class="form-control form-control-sm" id="password"
                                            name="password" required>
                                        @error('password')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <label for="password_confirmation" class="col-sm-1 col-form-label">Confirm
                                        Password</label>
                                    <div class="col-sm-3">
                                        <input type="password" class="form-control form-control-sm"
                                            id="password_confirmation" name="password_confirmation" required>
                                        @error('password_confirmation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Profile Picture -->
                                    <label for="image" class="col-sm-1 col-form-label">Image</label>
                                    <div class="col-sm-3">
                                        <div class="d-flex align-items-center">
                                            <img id="imagePreview" src="{{ asset('uploads/no_images/no-image.png') }}"
                                                alt="Profile Picture Preview" width="50" class="me-2">
                                            <input type="file" class="form-control form-control-sm" id="image"
                                                name="image" onchange="previewImage(event)">
                                        </div>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted d-inline-block text-nowrap">
                                            <span style="color: red; position: relative; right: 43px;">Allowed formats:
                                                JPG, JPEG, PNG. Max size: 2MB</span>
                                        </small>
                                    </div>
                                </div>

                                <hr class="my-2">
                                <div class="clearfix">
                                    <div class="text-end m-auto">
                                        <button type="reset" class="btn btn-dark">Reset</button>
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- User List -->
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head">
                        <i class="fas fa-users me-1"></i> User List
                    </div>
                </div>
                <div class="card-body table-card-body">
                    <table id="datatablesSimple" class="table table-striped">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Sl</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>User Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if ($user->image)
                                            <img src="{{ asset($user->image) }}" alt="User Image"
                                                style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; margin-left: 11px;">
                                        @else
                                            <img src="{{ asset('uploads/no_images/no-image.png') }}" alt="User Image"
                                                style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; margin-left: 11px;">
                                        @endif
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td>{{ ucfirst($user->type) }}</td>
                                    {{-- <td>
                                        <form action="{{ route('users.updateStatus', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                <option value="a" {{ $user->status == 'a' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="p" {{ $user->status == 'p' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="d" {{ $user->status == 'd' ? 'selected' : '' }}>
                                                    Deactivated
                                                </option>
                                            </select>
                                        </form>
                                    </td> --}}
                                    <td class="text-center">
                                        <form action="{{ route('users.updateStatus', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status"
                                                value="{{ $user->status == 'a' ? 'p' : ($user->status == 'p' ? 'd' : 'a') }}">

                                            <button type="submit"
                                                class="btn btn-sm
                                                {{ $user->status == 'a' ? 'btn-success' : ($user->status == 'p' ? 'btn-warning' : 'btn-danger') }}"
                                                style="padding: 2px 10px; font-size: 12px; display: flex; align-items: center; gap: 5px; margin-top: 7px;">

                                                @if ($user->status == 'a')
                                                    <i class="fas fa-check-circle"></i> Active
                                                @elseif ($user->status == 'p')
                                                    <i class="fas fa-clock"></i> Pending
                                                @else
                                                    <i class="fas fa-ban"></i> Deactivated
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-edit"
                                                title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>

                                            @if ($user->type !== 'admin')
                                                <button type="button" class="btn btn-warning btn-sm access-btn"
                                                    style="font-size: 0.5rem;" data-bs-toggle="modal"
                                                    data-bs-target="#accessModal{{ $user->id }}"
                                                    title="Manage Access">
                                                    <i class="fas fa-user-edit fa-sm"></i>
                                                </button>
                                            @endif

                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="m-0 p-0 delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-delete show-confirm"
                                                    title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- User Access Modal -->
                                <div class="modal fade" id="accessModal{{ $user->id }}" tabindex="-1"
                                    aria-labelledby="accessModalLabel{{ $user->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div
                                                class="modal-header d-flex justify-content-between align-items-center py-2 px-3">
                                                <h4 class="modal-title font-weight-bold mb-0" style="font-size: 1.25rem;">
                                                    User Access</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>

                                            <form action="{{ route('user.access.update', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                                                    <div class="form-group">
                                                        <div class="row">
                                                            @php
                                                                $groupedAccesses = availableAccesses();
                                                                $userAccessData =
                                                                    json_decode(
                                                                        optional($user->userAccess)->access,
                                                                        true,
                                                                    ) ?? [];
                                                            @endphp

                                                            @foreach ($groupedAccesses as $group => $accesses)
                                                                <div class="col-md-4 mb-3">
                                                                    <label
                                                                        class="fw-bold mb-2 d-block">{{ $group }}</label>
                                                                    @foreach ($accesses as $key => $label)
                                                                        <div
                                                                            class="form-check d-flex align-items-center gap-2 mb-1">
                                                                            <input type="checkbox"
                                                                                class="form-check-input" name="access[]"
                                                                                id="access_{{ $key }}_{{ $user->id }}"
                                                                                value="{{ $key }}"
                                                                                {{ in_array($key, $userAccessData) ? 'checked' : '' }}>
                                                                            <label class="form-check-label mb-0"
                                                                                for="access_{{ $key }}_{{ $user->id }}"
                                                                                style="margin-left: 23px;">
                                                                                {{ $label }}
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit"
                                                        class="btn btn-primary bg-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const imgElement = document.getElementById('imagePreview');
                imgElement.src = reader.result;
                imgElement.classList.remove('d-none');
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 3000);
            }
        });
    </script>
@endsection
