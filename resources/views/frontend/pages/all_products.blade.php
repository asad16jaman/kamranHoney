@extends('frontend.layouts.master')

@section('content')
    <!--Hero Section-->
    <div class="hero-section hero-background">
        <nav class="biolife-nav nav-86px">
            <ul>
                <li class="nav-item">
                    <a href="{{route('home')}}" class="permal-link">Home</a>
                </li>
                <li class="nav-item">
                    <span class="current-page">All Products</span>
                </li>
            </ul>
        </nav>
    </div>


@endsection
