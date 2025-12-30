<!-- Customer Reviews -->
<div class="brand-slide xs-padding-bottom-50px">
    <div class="biolife-title-box xs-padding-bottom-50px">
        <div class="g-img">
            <h3 class="main-title cmb-5">CUSTOMER REVIEWS</h3>
        </div>
    </div>

    <div class="container fade-up-on-scroll">
        <ul class="biolife-carousel nav-center-bold nav-none-on-mobile"
            data-slick='{"rows":1,"arrows":true,
                        "dots":false,"infinite":false,"speed":400,
                        "slidesMargin":30,"slidesToShow":2,
                        "autoplay":true,
                        "autoplaySpeed":3000,
                        "responsive":[
                            {"breakpoint":1200,"settings":{"slidesToShow":2}},
                            {"breakpoint":992,"settings":{"slidesToShow":2}},
                            {"breakpoint":768,"settings":{"slidesToShow":1,"slidesMargin":10}},
                            {"breakpoint":450,"settings":{"slidesToShow":1,"slidesMargin":10}}
                        ]}'>
            @foreach($reviews as $review)
                <li>
                    <div class="review-card">
                        <p class="review-text">
                            "{{ $review->review ?? 'No review content available.' }}"
                        </p>

                        <div class="review-footer">
                            <img src="{{ asset($review->image ?? 'uploads/no_images/no-image.png') }}" 
                                 class="img-circle" alt="{{ $review->name ?? 'Client' }}" />
                            <div class="review-info">
                                <h5>{{ $review->name ?? 'Anonymous' }}</h5>
                                <span>{{ $review->title ?? 'Happy Client' }}</span>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
