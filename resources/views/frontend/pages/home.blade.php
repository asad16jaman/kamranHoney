@extends('frontend.layouts.master')

@section('content')

    @include('frontend.components.category')

    @include('frontend.components.product')

    @include('frontend.components.blog')

    @include('frontend.components.customerReview')

    @include('frontend.components.photoGallery')

    @include('frontend.components.videoGallery')

@endsection
