@php
    $notificationService = new App\Services\AppNotificationService();
    $systemSettings = App\Models\SystemSetting::whereIn('key', ['topbar_background_color', 'topbar_text_color'])->get();

    $bg_color = $systemSettings->where('key', 'topbar_background_color')->first()->value ?? '#dfe2cd' ;
    $text_color = ($systemSettings->where('key', 'topbar_text_color')->first()->value ?? '#478FCA') . ' !important';
    $totalNotification = $notificationService->totalNotificationCount;

    $companyInfos = \App\Models\Company::select('name', 'favicon_icon', 'website')->whereId(1)->first()->toArray();
@endphp

<style>

    .navbar {
        background: #efefef !important;
        border-bottom: 4px solid #2c6aa0;
    }
</style>
<div id="navbar" class="navbar navbar-default ace-save-state  navbar-fixed-top">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
            <a href="{{ url('home') }}" class="navbar-brand">
                <small class="text-primary font-weight-bold" style="font-weight: 600">
                    <span class="blue topbar-text-color">
                        <img src="{{ asset($companyInfos['favicon_icon']) }}" alt="" height="25">
                        {{ $companyInfos['name'] }}
                    </span>
                </small>
            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-10" title="Visit Website">
                    <a href="{{ $companyInfos['website'] != null ? $companyInfos['website'] : '' }}" target="_blank">
                        <i class="fa fa-2x fa-globe" style="margin-top: 10px; color: #FF4747"></i>
                    </a>
                </li>


                <li class="light-10 dropdown-modal" title="Recommend Notifications">

                </li>
                <!--  Leave Application Notification End  -->





                <li class="light-10 dropdown-modal">
                    <a data-toggle="dropdown" href="javascript:void(0)" class="dropdown-toggle dark">
                        {{--     <a data-toggle="dropdown" href="#" class="dropdown-toggle dark" style="margin-left: -1px; background-color: #efefef;"> --}}

                        {{-- @if (optional(auth()->user())->employee)
                            @if (auth()->user()->employee->image != 'default.png')
                                <img class="nav-user-photo" style="height:40px; width:40px" src="{{ asset(auth()->user()->employee->image) }}" alt="User Photo" />
                            @else
                                <img class="nav-user-photo" src="{{ asset('default-user.png') }}" alt="User Photo" />
                            @endif
                        @else --}}
                            <img class="nav-user-photo" src="{{ asset('default-user.png') }}" alt="User Photo" />
                        {{-- @endif --}}

                        <span class="user-info">
                            <small>Welcome,</small>
                            {{ optional(auth()->user())->name }}
                        </span>

                        <i class="ace-icon dark fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

{{--                        <li>--}}
{{--                            <a href="{{ route('user.password.edit') }}">--}}
{{--                                <i class="ace-icon fa fa-user"></i>--}}
{{--                                Change Password--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                        <li class="divider"></li>--}}

                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                                <i class="ace-icon fa fa-power-off"></i>
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</div>
