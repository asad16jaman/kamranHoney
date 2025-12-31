@php
    function youtubeEmbedUrl($url) {
        if (str_contains($url, 'embed')) {
            return $url;
        }

        preg_match(
            '/(youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/',
            $url,
            $matches
        );

        return isset($matches[2])
            ? 'https://www.youtube.com/embed/' . $matches[2]
            : '';
    }
@endphp


<!-- Video Gallery -->
<div class="brand-slide xs-padding-bottom-50px">
    <div class="biolife-title-box xs-padding-bottom-50px">
        <div class="g-img">
            <h3 class="main-title cmb-5">Video Gallery</h3>
        </div>
    </div>

    <div class="container">
        <div class="row">

            @if($videos->count())

                <div class="col-lg-6 col-12">
                    <div class="row">

                        @foreach($videos->take(4) as $video)
                            <div class="col-lg-6 col-md-6 col-12 fade-up-on-scroll">
                                <div class="">
                                    <iframe width="100%" height=""
                                        src="{{ youtubeEmbedUrl($video->video_url) }}"
                                        title="{{ $video->title_1 ?? 'YouTube video player' }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                @php $mainVideo = $videos->first(); @endphp

                <div class="col-lg-6 d-lg-block d-none fade-up-on-scroll">
                    <div class="">
                        <iframe width="560" height="315"
                            src="{{ youtubeEmbedUrl($mainVideo->video_url) }}"
                            title="{{ $mainVideo->title_1 ?? 'YouTube video player' }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>

            @endif

        </div>
    </div>
</div>

