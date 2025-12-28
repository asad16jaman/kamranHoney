@extends('admin.layouts.master')

@section('title', 'General Settings')
@section('main-content')

    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading"><i class="fas fa-cogs"></i> <a href="{{ route('dashboard') }}">Dashboard</a> >
                    Settings</span>
            </div>
            <div class="card my-3">
                <div class="card-header d-flex justify-content-between">
                    <div class="table-head"><i class="fas fa-cog me-1"></i>General Settings</div>
                </div>
                <div class="card-body table-card-body">
                    <form method="POST" action="{{ route('setting.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Company Name -->
                            <label for="company_name" class="col-sm-1 col-form-label">Name</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="company_name"
                                    name="company_name" value="{{ old('company_name', $setting->company_name) }}">
                                @error('company_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Company Address -->
                            <label for="company_address" class="col-sm-1 col-form-label">Address</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="company_address"
                                    name="company_address" value="{{ old('company_address', $setting->company_address) }}">
                                @error('company_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Company Phone -->
                            <label for="company_phone" class="col-sm-1 col-form-label">Phone</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="company_phone"
                                    name="company_phone" value="{{ old('company_phone', $setting->company_phone) }}"
                                    required>
                                @error('company_phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Hotline -->
                            <label for="hotline" class="col-sm-1 col-form-label">Hotline</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="hotline" name="hotline"
                                    value="{{ old('hotline', $setting->hotline) }}">
                                @error('hotline')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Company Slogan -->
                            <label for="company_slogan" class="col-sm-1 col-form-label">Slogan</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="company_slogan"
                                    name="company_slogan" value="{{ old('company_slogan', $setting->company_slogan) }}">
                                @error('company_slogan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Company Email -->
                            <label for="company_email" class="col-sm-1 col-form-label">Email</label>
                            <div class="col-sm-3">
                                <input type="email" class="form-control form-control-sm" id="company_email"
                                    name="company_email" value="{{ old('company_email', $setting->company_email) }}"
                                    required>
                                @error('company_email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Facebook URL -->
                            <label for="facebook_url" class="col-sm-1 col-form-label">Facebook</label>
                            <div class="col-sm-3">
                                <input type="url" class="form-control form-control-sm" id="facebook_url"
                                    name="facebook_url" value="{{ old('facebook_url', $setting->facebook_url) }}">
                                @error('facebook_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Twitter URL -->
                            <label for="twitter_url" class="col-sm-1 col-form-label">Twitter</label>
                            <div class="col-sm-3">
                                <input type="url" class="form-control form-control-sm" id="twitter_url"
                                    name="twitter_url" value="{{ old('twitter_url', $setting->twitter_url) }}">
                                @error('twitter_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- LinkedIn URL -->
                            <label for="linkedin_url" class="col-sm-1 col-form-label">LinkedIn</label>
                            <div class="col-sm-3">
                                <input type="url" class="form-control form-control-sm" id="linkedin_url"
                                    name="linkedin_url" value="{{ old('linkedin_url', $setting->linkedin_url) }}">
                                @error('linkedin_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Instagram URL -->
                            <label for="instagram_url" class="col-sm-1 col-form-label">Instagram</label>
                            <div class="col-sm-3">
                                <input type="url" class="form-control form-control-sm" id="instagram_url"
                                    name="instagram_url" value="{{ old('instagram_url', $setting->instagram_url) }}">
                                @error('instagram_url')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Favicon Image -->
                            <label for="favicon_image" class="col-sm-1 col-form-label">Favicon</label>
                            <div class="col-sm-3">
                                <div class="d-flex align-items-center">
                                    <img id="faviconPreview"
                                        src="{{ $setting->favicon_image ? asset('uploads/logo_and_icon/' . $setting->favicon_image) : asset('uploads/no_images/no-image.png') }}"
                                        alt="Favicon Preview" width="50" class="me-2">
                                    <input type="file" class="form-control form-control-sm" id="favicon_image"
                                        name="favicon_image" onchange="previewImage(event, 'faviconPreview')">
                                </div>
                                @error('favicon_image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Company Logo -->
                            <label for="company_logo" class="col-sm-1 col-form-label">Logo</label>
                            <div class="col-sm-3">
                                <div class="d-flex align-items-center">
                                    <img id="logoPreview"
                                        src="{{ $setting->company_logo ? asset('uploads/logo_and_icon/' . $setting->company_logo) : asset('uploads/no_images/no-image.png') }}"
                                        alt="Company Logo Preview" width="50" class="me-2">
                                    <input type="file" class="form-control form-control-sm" id="company_logo"
                                        name="company_logo" onchange="previewImage(event, 'logoPreview')">
                                </div>
                                @error('company_logo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Footer Logo -->
                            <label for="footer_logo" class="col-sm-1 col-form-label">Footer Logo</label>
                            <div class="col-sm-3">
                                <div class="d-flex align-items-center">
                                    <img id="footerPreview"
                                        src="{{ $setting->footer_logo ? asset('uploads/logo_and_icon/' . $setting->footer_logo) : asset('uploads/no_images/no-image.png') }}"
                                        alt="Footer Logo Preview" width="50" class="me-2">
                                    <input type="file" class="form-control form-control-sm" id="footer_logo"
                                        name="footer_logo" onchange="previewImage(event, 'footerPreview')">
                                </div>
                                @error('footer_logo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Copyright -->
                            <label for="copyright" class="col-sm-1 col-form-label">Copyright</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="copyright"
                                    name="copyright" value="{{ old('copyright', $setting->copyright) }}" required>
                                @error('copyright')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Google Map -->
                            <label for="google_map" class="col-sm-1 col-form-label">Google Map</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control form-control-sm" id="google_map"
                                    name="google_map" value="{{ old('google_map', $setting->google_map) }}">
                                @error('google_map')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Video Upload -->
                            <label for="video_file" class="col-sm-1 col-form-label">Video</label>
                            <div class="col-sm-3">
                                <input type="file" class="form-control form-control-sm" id="video_file"
                                    name="video_file" accept="video/mp4,video/webm,video/ogg">

                                @if (!empty($setting->video_file))
                                    <small class="text-muted d-block mt-1">
                                        Current Video:
                                        <a href="{{ asset($setting->video_file) }}" target="_blank">View</a>
                                    </small>
                                @endif

                                @error('video_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Delivery Charge -->
                            <label for="inside" class="col-sm-1 col-form-label">Inside Dhaka</label>
                            <div class="col-sm-3">
                                <input type="number" step="0.01" min="0" class="form-control form-control-sm"
                                    id="inside" name="inside" value="{{ old('inside', $setting->inside) }}">
                                @error('inside')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="outside" class="col-sm-1 col-form-label">Outside Dhaka</label>
                            <div class="col-sm-3">
                                <input type="number" step="0.01" min="0" class="form-control form-control-sm"
                                    id="outside" name="outside" value="{{ old('outside', $setting->outside) }}">
                                @error('outside')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- About the Company -->
                            <label for="company_about" class="col-sm-1 col-form-label">About</label>
                            <div class="col-sm-12">
                                <textarea id="company_about_editor" class="form-control form-control-sm @error('company_about') is-invalid @enderror"
                                    name="company_about" placeholder="Enter About the Company" rows="5" required>{{ old('company_about', $setting->company_about) }}</textarea>
                                @error('company_about')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-2">
                        <div class="clearfix">
                            <div class="text-end m-auto">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save
                                    Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
    <script>
        function previewImage(event, previewId) {
            const reader = new FileReader();
            reader.onload = function() {
                const imgElement = document.getElementById(previewId);
                imgElement.src = reader.result;
                imgElement.classList.remove('d-none');
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        ClassicEditor
            .create(document.querySelector('#company_about_editor'))
            .catch(error => {
                console.error('CKEditor Error:', error);
            });

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
