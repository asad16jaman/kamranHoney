<!-- FOOTER -->
@php
    $setting = \App\Helpers\SettingsHelper::getSetting();
@endphp

<footer id="footer" class="footer layout-03">
    <div class="footer-content background-footer-03">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 md-margin-top-5px sm-margin-top-50px xs-margin-top-40px">
                    <section class="footer-item">
                        <h3 class="section-title">{{ $setting->company_name }}</h3>
                        <div class="row">
                            <div class="col-12">
                                <div class="wrap-custom-menu vertical-menu-2" style="color: #fff; text-align: justify">
                                    {{ $setting->company_about }}
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-6 md-margin-top-5px sm-margin-top-50px xs-margin-top-40px">
                    <section class="footer-item" style="margin-left: 33px;">
                        <h3 class="section-title">Contact Us</h3>
                        <div class="contact-info-block footer-layout xs-padding-top-10px">
                            <ul class="contact-lines">
                                <li>
                                    <p class="info-item">
                                        <i class="biolife-icon icon-location"></i>
                                        <b class="desc">{{ $setting->company_address }}</b>
                                    </p>
                                </li>
                                <li>
                                    <p class="info-item">
                                        <i class="biolife-icon icon-phone"></i>
                                        <b class="desc">{{ $setting->company_phone }}</b>
                                    </p>
                                </li>
                                <li>
                                    <p class="info-item">
                                        <i class="biolife-icon icon-letter"></i>
                                        <b class="desc">Email: {{ $setting->company_email }}</b>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </section>
                </div>

                <div class="col-lg-2 col-md-4 col-sm-6 md-margin-top-5px sm-margin-top-50px xs-margin-top-40px">
                    <section class="footer-item">
                        <h3 class="section-title">Useful Links</h3>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="wrap-custom-menu vertical-menu-2">
                                    <ul class="menu">
                                        <li><a href="{{route('home')}}">Home</a></li>
                                        <li><a href="{{ route('about.view') }}">About Us</a></li>
                                        <li><a href="{{ route('all.products') }}">Product</a></li>
                                        <li><a href="{{ route('contact.create') }}">Contact</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 md-margin-top-5px sm-margin-top-50px xs-margin-top-40px">
                    <section class="footer-item">
                        <h3 class="section-title">
                            Social Links
                        </h3>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="wrap-custom-menu vertical-menu-2">
                                    <ul class="socials">
                                        <li style="background-color: #3b5998">
                                            <a href="{{ $setting->facebook_url }}" title="facebook" class="socail-btn"><i
                                                    class="fa fa-facebook" aria-hidden="true"></i>
                                                FACEBOOK</a>
                                        </li>
                                        <li style="background: linear-gradient(45deg,#d720c1,red,#e4eb0c);">
                                            <a href="{{ $setting->instagram_url }}" title="pinterest" class="socail-btn"><i
                                                    class="fa fa-instagram" aria-hidden="true"></i>
                                                INSTAGRAM</a>
                                        </li>
                                        <li style="background: red">
                                            <a href="#" title="youtube" class="socail-btn"><i
                                                    class="fa fa-youtube" aria-hidden="true"></i>
                                                YOUTUBE</a>
                                        </li>
                                        <li style="background-color: #0a0a0a">
                                            <a href="{{ $setting->twitter_url }}" title="twitter" class="socail-btn"><i
                                                    class="fa fa-twitter" aria-hidden="true"></i>
                                                TWITTER</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-sm-12 col-xs-12 d-flex justify-content-end">
                    <div class="copy-right-text">
                        <p style="color: #fff; text-align: right">
                            Designed And Developed by
                            <a href="https://linktechbd.com/">Linkup Technology</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
