<!-- Photo Gallery -->
<div class="brand-slide xs-padding-bottom-50px">
    <div class="biolife-title-box xs-padding-bottom-50px">
        <div class="g-img">
            <h3 class="main-title cmb-5">PHOTO GALLERY</h3>
        </div>
    </div>

    <div class="container">
        <div class="row">

            @if ($galleryImages->count())

                <!-- Left Large Image -->
                <div class="col-lg-4 d-lg-block d-none fade-up-on-scroll">
                    @php $firstImage = $galleryImages->first(); @endphp
                    <a href="{{ asset('uploads/gallery/' . $firstImage->image) }}"
                       data-fancybox="gallery"
                       data-caption="{{ $firstImage->title_1 ?? '' }}">
                        <div class="mb-4 overlay-container-left">
                            <div class="overlay"></div>
                            <img src="{{ asset('uploads/gallery/' . $firstImage->image) }}"
                                 alt="{{ $firstImage->title_1 }}"
                                 style="width:100%; height:100%; object-fit:cover;">
                        </div>
                    </a>
                </div>

                <!-- Right Grid Images -->
                <div class="col-lg-8">
                    <div class="row">
                        @foreach ($galleryImages->skip(1) as $image)
                            <div class="col-lg-4 col-md-6 fade-up-on-scroll">
                                <a href="{{ asset('uploads/gallery/' . $image->image) }}"
                                   data-fancybox="gallery"
                                   data-caption="{{ $image->title_1 ?? '' }}">
                                    <div class="mb-4 overlay-container">
                                        <div class="overlay"></div>
                                        <img src="{{ asset('uploads/gallery/' . $image->image) }}"
                                             alt="{{ $image->title_1 }}"
                                             style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

            @endif

        </div>
    </div>
</div>
