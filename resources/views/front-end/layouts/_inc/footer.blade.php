@php
    $companyInfos = \App\Models\Company::select('name', 'logo', 'facebook_link', 'youtube_link', 'twitter_link', 'instagram_link', 'whatsapp_link', 'telegram_link')
        ->whereId(1)
        ->first();
@endphp
<footer class="page-footer font-small mdb-color pt-3">
    <div class="container text-center" style="padding-bottom: 13px;">

        <div class="row text-center text-md-left mt-3 pb-3">

            <div class="col-md-3 col-lg-3 col-xl-3 mr-auto mt-3">
                <div class="text-nowrap mb-4">
                    <a class="d-inline-block align-middle mt-n1 mr-3" href="{{ route('index') }}">
                        <div style="!important; width: 250px">
                            <img src="{{ asset($companyInfos->logo) }}" alt="Logo">
                        </div>
                    </a>
                </div>
                <span class="social-media">
                    <a class="social-btn sb-light sb-facebook ml-1 mb-2" target="_blank" @if(!empty($companyInfos->facebook_link)) href="{{ $companyInfos->facebook_link }}" @else href="javascript:void(0)" @endif>
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                    </a>
                </span>
                <span class="social-media">
                     <a class="social-btn sb-light sb-youtube ml-2 mb-2" target="_blank" @if(!empty($companyInfos->youtube_link)) href="{{ $companyInfos->youtube_link }}" @else href="javascript:void(0)" @endif>
                         <i class="fa fa-youtube" aria-hidden="true"></i>
                     </a>
                </span>
                <span class="social-media">
                    <a class="social-btn sb-light sb-twitter ml-2 mb-2" target="_blank" @if(!empty($companyInfos->twitter_link)) href="{{ $companyInfos->twitter_link }}" @else href="javascript:void(0)" @endif>
                        <i class="fa fa-twitter" aria-hidden="true"></i>
                    </a>
                </span>
                <span class="social-media">
                    <a class="social-btn sb-light sb-instagram ml-2 mb-2" target="_blank" @if(!empty($companyInfos->instagram_link)) href="{{ $companyInfos->instagram_link }}" @else href="javascript:void(0)" @endif>
                        <i class="fa fa-instagram" aria-hidden="true"></i>
                    </a>
                </span>
                <span class="social-media">
                     <a class="social-btn sb-light sb-whatsapp ml-2 mb-2" target="_blank" @if(!empty($companyInfos->whatsapp_link)) href="{{ $companyInfos->whatsapp_link }}" @else href="javascript:void(0)" @endif>
                         <i class="fa fa-whatsapp" aria-hidden="true"></i>
                     </a>
                </span>
                <span class="social-media">
                    <a class="social-btn sb-light sb-telegram ml-2 mb-2" target="_blank" @if(!empty($companyInfos->telegram_link)) href="{{ $companyInfos->telegram_link }}" @else href="javascript:void(0)" @endif>
                        <i class="fa fa-telegram" aria-hidden="true"></i>
                    </a>
                </span>
            </div>

            <hr class="w-100 clearfix d-md-none">

            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h6 class="text-uppercase mb-4 font-weight-bold footer-heder">Special</h6>
                <ul class="widget-list">
                    <li class="widget-list-item"><a class="widget-list-link" href="{{ route('brands') }}">All Brand</a></li>
                    <li class="widget-list-item"><a class="widget-list-link" href="{{ route('categories') }}">All Category</a>
                    </li>
                </ul>
            </div>

            <hr class="w-100 clearfix d-md-none">

            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h6 class="text-uppercase mb-4 font-weight-bold footer-heder">ACCOUNT &amp; SHIPPING INFO</h6>
                <ul class="widget-list">
                    <li class="widget-list-item"><a class="widget-list-link"
                            @if(!empty(auth()->guard('customer')->user()->id))
                                href="{{ route('cus-auth.my-profile') }}"
                            @else
                                href="javascript:void(0)"
                                data-toggle="modal" data-type="login" onclick="changeModalType(this)" data-target="#authModal"
                            @endif
                        >My Profile</a>
                    </li>
                    <li class="widget-list-item"><a class="widget-list-link"
                            @if(!empty(auth()->guard('customer')->user()->id))
                                href="{{ route('cus-auth.my-orders') }}"
                            @else
                                href="javascript:void(0)"
                                data-toggle="modal" data-type="login" onclick="changeModalType(this)" data-target="#authModal"
                            @endif
                        >My Orders</a>
                    </li>
                </ul>
            </div>

            <hr class="w-100 clearfix d-md-none">

            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h6 class="text-uppercase mb-4 font-weight-bold footer-heder">About Us</h6>
                <ul class="widget-list">
                    <li class="widget-list-item"><a class="widget-list-link" href="{{ route('about-us') }}">About company</a>
                    </li>
                    <li class="widget-list-item"><a class="widget-list-link" href="{{ route('faq') }}">FAQ</a></li>
                    <li class="widget-list-item "><a class="widget-list-link" href="{{ route('terms-and-conditions') }}">Terms &amp; Conditions</a>
                    </li>
                    <li class="widget-list-item ">
                        <a class="widget-list-link" href="{{ route('privacy-policy') }}">
                            Privacy Policy
                        </a>
                    </li>
                    <li class="widget-list-item "><a class="widget-list-link" href="{{ route('contact-us') }}">Contact Us</a>
                    </li>
                </ul>
            </div>

        </div>

    </div>
    <hr>

    <div class="container text-center">
        <div class="row d-flex align-items-center footer-end">
            <div class="col-md-12 mt-3">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="text-center" style="font-size: 12px;">Copyright © {{ date('Y') }} <strong>{{ $companyInfos->name }}</strong></p>
                </div>
            </div>
        </div>
    </div>

</footer>
