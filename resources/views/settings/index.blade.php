@extends('layouts.master')

@section('title', 'Settings')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fad fa-cogs"></i> @yield('title')</h4>
    </div>

    <div class="row">
        <div class="col-12">



            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-md-12">
                            @include('partials._alert_message')

                            <div class="tabbable tabs-left">
                                <ul class="nav nav-tabs mr-2" id="">
                                    @if (hasPermission("settings.company", $slugs))
                                        <li class="active">
                                            <a data-toggle="tab" href="#company-setting" aria-expanded="false">
                                                <i class="ace-icon far fa-cog bigger-110"></i>
                                                Company Setting
                                            </a>
                                        </li>
                                    @endif

                                    @if (hasPermission("settings.order", $slugs))
                                        <li class="">
                                            <a data-toggle="tab" href="#order-setting" aria-expanded="true">
                                                <i class="ace-icon far fa-cog bigger-110"></i>
                                                Order Setting
                                            </a>
                                        </li>
                                    @endif

                                    @if (hasPermission("settings.email", $slugs))

                                        <li class="">
                                            <a data-toggle="tab" href="#email-setting" aria-expanded="true">
                                                <i class="ace-icon far fa-cog bigger-110"></i>
                                                Email Setting
                                            </a>
                                        </li>
                                    @endif

                                    {{-- <li class="">
                                        <a data-toggle="tab" href="#sms-api-setting" aria-expanded="true">
                                            <i class="ace-icon fa fa-cog bigger-110"></i>
                                            SMS API Setting
                                        </a>
                                    </li> --}}
                                    @if (hasPermission("settings.cms", $slugs))
                                        <li class="">
                                            <a data-toggle="tab" href="#ecom-setting" aria-expanded="true">
                                                <i class="ace-icon far fa-cog bigger-110"></i>
                                                CMS Setting
                                            </a>
                                        </li>
                                    @endif

                                    <li class="">
                                        <a data-toggle="tab" href="#point-setting" aria-expanded="true">
                                            <i class="ace-icon far fa-cog bigger-110"></i>
                                            Point Setting
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">

                                    <x-settings.company-setting />

                                    <x-settings.order-setting />

                                    <x-settings.email-setting />

                                    {{-- <x-settings.sms-api-setting /> --}}

                                    <x-settings.ecom-setting />

                                    <x-settings.point-setting />

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


