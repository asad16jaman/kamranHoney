@php $setting = \App\Helpers\SettingsHelper::getSetting(); @endphp

@extends('admin.layouts.master')
@section('title', 'Home')
@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{ route('dashboard') }}">
                        Dashboard</span>
            </div>
            <div class="row mt-3">
                {{-- <div class="dashboard-logo text-center pt-3 pb-4">
                <img class="border p-2" style="height: 100px;" src="{{ asset('images/dashboard.png') }}" alt="">
            </div> --}}
                <div class="dashboard-logo text-center pt-3 pb-4">
                    <img class="border p-2" style="height: 80px; position: relative; top: -30px;"
                        src="{{ asset('uploads/logo_and_icon/' . ($setting->company_logo ?? 'no-images/no-image.png')) }}"
                        alt="Company Logo">
                    <h1 class="company-name"
                        style="
                        font-size: 26px;
                        font-weight: bold;
                        font-family: 'Prata', serif;
                        letter-spacing: 1.5px;
                        text-transform: uppercase;
                        color: #003C43;
                        margin-bottom: -40px;
                        text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
                        position: relative;
                        top: -25px;">
                        {{ $setting->company_name }}
                    </h1>
                </div>

                @if (checkAccess('orders.index'))
                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('orders.index') }}" style="text-decoration: none;">
                            <div class="card mb-3 dashboard-card"
                                style="height: 100px; width: 100%; margin-top: 5px; border-radius: 5px; background-color: rgb(255, 243, 224); border: 1px solid #ccc;">
                                <div class="card-body mx-auto">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="fas fa-shopping-cart fa-2x"></i>
                                    </div>
                                    <p class="dashboard-card-text">Orders ({{ $orderCount }})</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                @if (checkAccess('categories.index'))
                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('categories.index') }}" style="text-decoration: none;">
                            <div class="card mb-3 dashboard-card"
                                style="height: 100px; width: 100%; margin-top: 5px; border-radius: 5px; background-color: rgb(220, 245, 234); border: 1px solid #ccc;">
                                <div class="card-body mx-auto">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="fas fa-folder-open fa-2x"></i>
                                    </div>
                                    <p class="dashboard-card-text">Category</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                @if (checkAccess('products.index'))
                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('products.index') }}" style="text-decoration: none;">
                            <div class="card mb-3 dashboard-card"
                                style="height: 100px; width: 100%; margin-top: 5px; border-radius: 5px; background-color: rgb(236, 255, 217); border: 1px solid #ccc;">
                                <div class="card-body mx-auto">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="fas fa-box fa-2x"></i>
                                    </div>
                                    <p class="dashboard-card-text">Product</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                @if (checkAccess('sliders.index'))
                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('sliders.index') }}" style="text-decoration: none;">
                            <div class="card mb-3 dashboard-card"
                                style="height: 100px; width: 100%; margin-top: 5px; border-radius: 5px; background-color:rgb(220, 245, 234); border: 1px solid #ccc;">
                                <div class="card-body mx-auto">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="fas fa-sliders-h fa-2x"></i>
                                    </div>
                                    <p class="dashboard-card-text">Slider</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                <div class="col-xl-3 col-md-6">
                    <div class="card mb-3 dashboard-card"
                        style="height: 100px; width: 100%; margin-top: 5px; border-radius: 5px; background-color: rgb(255, 227, 215); border: 1px solid #ccc;">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" style="all: unset; cursor: pointer; display: block; width: 100%;">
                                <div class="card-body mx-auto text-center">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <i class="fa fa-sign-out-alt fa-2x"></i>
                                    </div>
                                    <p class="dashboard-card-text">Sign Out</p>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
