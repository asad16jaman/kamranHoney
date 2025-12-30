<!--Block 08: Blog Posts-->
<div class="blog-posts sm-padding-top-72px xs-padding-bottom-50px">
    <div class="container fade-up-on-scroll">
        <div class="biolife-title-box mb-30 mt-30">
            <div class="g-img">
                <h3 class="main-title cmb-5">From the Blog</h3>
            </div>
        </div>

        <ul class="biolife-carousel nav-center nav-none-on-mobile xs-margin-top-36px"
            data-slick='{"rows":1,"arrows":true,
                "dots":false,"infinite":true,"speed":400,
                "slidesMargin":30,"slidesToShow":3,
                "autoplay":true,
                "autoplaySpeed":3000,
                "responsive":[
                {"breakpoint":1200,"settings":{"slidesToShow":3}},
                {"breakpoint":992,"settings":{"slidesToShow":2}},
                {"breakpoint":768,"settings":{"slidesToShow":2}},
                {"breakpoint":600,"settings":{"slidesToShow":1}}
            ]}'>

            @foreach ($blogs as $blog)
                <li>
                    <div class="post-item effect-01 style-bottom-info layout-02">
                        <div class="thumbnail">
                            <a href="#" class="link-to-post">
                                <img src="{{ asset('uploads/blogs/' . $blog->image) }}"
                                    style="width:100%; height:175px; object-fit:cover" alt="{{ $blog->title }}">
                            </a>

                            <div class="post-date">
                                <span class="date">{{ $blog->created_at->format('d') }}</span>
                                <span class="month">{{ strtolower($blog->created_at->format('M')) }}</span>
                            </div>
                        </div>

                        <div class="post-content">
                            <h4 class="post-name">
                                <a href="#" class="linktopost">
                                    {{ Str::limit($blog->title, 60) }}
                                </a>
                            </h4>

                            @if (!empty($blog->name))
                                <p class="blog-author" style="color:#e17f55; margin-top: 5px; font-weight: bold;">
                                    <small>By {{ $blog->name }}</small>
                                </p>
                            @endif

                            <p class="excerpt">
                                {{ Str::limit($blog->description, 140) }}
                            </p>

                            <div class="group-buttons">
                                <a href="#" class="btn readmore">
                                    Continue Reading
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach

        </ul>
    </div>
</div>
