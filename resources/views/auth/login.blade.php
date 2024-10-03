@php
    $logo = \App\Models\Company::select('logo')->whereId(1)->first()->toArray();
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>{{request()->routeIs('password-reset.verify-token') ? 'Reset Password' : 'Login Page'}} - {{ config('app.name') }}</title>

        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/font-awesome/4.5.0/css/font-awesome.min.css') }}" />

        <!-- text fonts -->
        <link rel="stylesheet" href="{{ asset('assets/css/fonts.googleapis.com.css') }}" />

        <!-- ace styles -->
        <link rel="stylesheet" href="{{ asset('assets/css/ace.min.css') }}" />


        <link rel="stylesheet" href="{{ asset('assets/css/ace-rtl.min.css') }}" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css"/>


    </head>


    @php
        $intended_string = 'url-' . session()->get('url.intended');
        $employee_base   = 'url-' . url('/em');
        $settings = App\Models\SystemSetting::where('key', 'employee_login_option')->first();
    @endphp

    <body class="login-layout light-login">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="center" style="margin-top: 50px;">

                                <img src="{{ asset("company.png") }}" alt="Logo" width="200px">
                                <br>
                                <br>
                            </div>

                            <div class="space-6"></div>

                            <div class="position-relative">

                                @if(request()->routeIs('password-reset.verify-token'))
                                    <div id="signup-box" class="signup-box widget-box no-border visible">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <h4 class="header green lighter bigger">
                                                    <i class="ace-icon fa fa-users blue"></i>
                                                    Reset Your Password
                                                </h4>

                                                <div class="space-6"></div>
                                                <p> Enter your password: </p>

                                                <form action="{{route('password-reset.update-password')}}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="email" value="{{request('email')}}">
                                                    <input type="hidden" name="token" value="{{request('token')}}">
                                                    <fieldset>
                                                        <label class="block clearfix">
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="password" class="form-control" placeholder="Password" name="password" />
                                                                <i class="ace-icon fa fa-lock"></i>

                                                                @error('password')
                                                                <span class="text-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </span>
                                                        </label>

                                                        <label class="block clearfix">
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="password" class="form-control" placeholder="Repeat password" name="password_confirmation" />
                                                                <i class="ace-icon fa fa-retweet"></i>

                                                                @error('password_confirmation')
                                                                <span class="text-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </span>
                                                        </label>

                                                        <div class="space-10"></div>

                                                        <div class="clearfix">
                                                            <button type="reset" class="width-30 pull-left btn btn-sm">
                                                                <i class="ace-icon fa fa-refresh"></i>
                                                                <span class="bigger-110">Reset</span>
                                                            </button>

                                                            <button type="submit" class="width-65 pull-right btn btn-sm btn-success">
                                                                <span class="bigger-110">Submit</span>

                                                                <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                            </div>

                                        </div>
                                    </div>

                                @else
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header blue lighter bigger text-center">
                                                <i class="ace-icon fa fa-sign-in green"></i>
                                                Login Information
                                            </h4>

                                            <div class="space-6"></div>

                                            <form action="" method="post">

                                                @if (session()->get('error'))
                                                    <div class="alert alert-danger">
                                                        <button type="button" class="close" data-dismiss="alert">
                                                            <i class="ace-icon fa fa-times"></i>
                                                        </button>
                                                        {{ session()->get('error') }}
                                                    </div>
                                                @endif


                                                @csrf

                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">

                                                            @if(session()->get('massage'))

                                                                <div class="alert alert-{{ session()->get('type') }}">
                                                                    <button type="button" class="close" data-dismiss="alert">
                                                                        <i class="ace-icon fa fa-times"></i>
                                                                    </button>

                                                                    <strong>
                                                                        @if(session()->get('type') == 'danger')
                                                                            <i class="ace-icon fa fa-times"></i>
                                                                            Error !
                                                                        @else
                                                                            <i class="ace-icon fa fa-check-circle-o"></i>
                                                                            Success !
                                                                        @endif
                                                                    </strong>

                                                                    {{ session()->get('massage') }}
                                                                    <br />
                                                                </div>

                                                            @endif

                                                        </span>
                                                    </label>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="hidden" name="employee_full_id" class="employee_full_id" value="{{ old('employee_full_id') }}">
                                                            <input id="email" type="text" class="form-control input-email @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" placeholder="Email" autofocus>
                                                            <i class="ace-icon fa fa-envelope"></i>
                                                            @error('email')
                                                                <span class="text-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </span>
                                                    </label>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  placeholder="Password" autocomplete="current-password">
                                                            <i class="ace-icon fa fa-lock"></i>
                                                            @error('password')
                                                                <span class="text-danger" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror

                                                        </span>
                                                    </label>

                                                    <div class="space"></div>

                                                    @if(optional($settings)->value == 1)
                                                        <div class="clearfix">
                                                            <div class="control-group">
                                                                <div class="radio">
                                                                    <label>
                                                                        <input name="form-field-radio" onclick="goToEmployeeLogin()" {{ (strpos($intended_string, $employee_base ) !== false) ? 'checked' : '' }} type="radio" class="ace">
                                                                        <span class="lbl"> Employee Login</span>
                                                                    </label>

                                                                    <label>
                                                                        <input name="form-field-radio" onclick="gotoHrLogin()"{{ (strpos($intended_string, $employee_base ) !== false) ? '' : 'checked' }} type="radio" class="ace">
                                                                        <span class="lbl"> Admin Login</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="clearfix">
                                                        <label class="inline">
                                                            <input type="checkbox" class="ace" />
                                                            <span class="lbl"> Remember Me</span>
                                                        </label>

                                                        <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                                            <i class="ace-icon fa fa-key"></i>
                                                            <span class="bigger-110">Login</span>
                                                        </button>
                                                    </div>
                                                    <div class="space-4"></div>
                                                    <!-- <div class="social-or-login center">
                                                        <span class="bigger-110">
                                                            &copy; Developed By
                                                        </span>
                                                    </div>

                                                    <div class="text-center" style="margin-top: 10px;">
                                                        <strong class="grey"> Smart Software Ltd</strong>
                                                    </div> -->


                                                </fieldset>

                                            </form>

                                            <br>

                                            <div class="space-6"></div>


                                        </div>


                                        <div class="toolbar clearfix">
                                            <div style="width: 100%">
                                                <a href="#" data-target="#forgot-box" class="forgot-password-link">
                                                    <i class="ace-icon fa fa-arrow-left"></i>
                                                    &nbsp;I forgot my password
                                                </a>
                                            </div>
                                        </div>



                                    </div>
                                </div>

                                <div id="forgot-box" class="forgot-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header red lighter bigger">
                                                <i class="ace-icon fa fa-key"></i>
                                                Retrieve Password
                                            </h4>

                                            <div class="space-6"></div>
                                            <p>
                                                Enter your email address to receive instructions
                                            </p>

                                            <form action="{{route('password-reset.send-email')}}" method="post">
                                                @csrf
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="email" class="form-control" placeholder="Email" name="email"/>
                                                            <i class="ace-icon fa fa-envelope"></i>
                                                        </span>
                                                    </label>

                                                    <div class="clearfix">
                                                        <button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
                                                            <i class="ace-icon fa fa-lightbulb-o"></i>
                                                            <span class="bigger-110">Send Me!</span>
                                                        </button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>

                                        <div class="toolbar center">
                                            <a href="#" data-target="#login-box" class="back-to-login-link">
                                                Back to login
                                                <i class="ace-icon fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div id="signup-box" class="signup-box widget-box no-border">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <h4 class="header green lighter bigger">
                                                    <i class="ace-icon fa fa-users blue"></i>
                                                    New User Registration
                                                </h4>

                                                <div class="space-6"></div>
                                                <p> Enter your details to begin: </p>

                                                <form>
                                                    <fieldset>
                                                        <label class="block clearfix">
                                                                <span class="block input-icon input-icon-right">
                                                                    <input type="email" class="form-control" placeholder="Email" />
                                                                    <i class="ace-icon fa fa-envelope"></i>
                                                                </span>
                                                        </label>

                                                        <label class="block clearfix">
                                                                <span class="block input-icon input-icon-right">
                                                                    <input type="text" class="form-control" placeholder="Username" />
                                                                    <i class="ace-icon fa fa-user"></i>
                                                                </span>
                                                        </label>

                                                        <label class="block clearfix">
                                                                <span class="block input-icon input-icon-right">
                                                                    <input type="password" class="form-control" placeholder="Password" />
                                                                    <i class="ace-icon fa fa-lock"></i>
                                                                </span>
                                                        </label>

                                                        <label class="block clearfix">
                                                                <span class="block input-icon input-icon-right">
                                                                    <input type="password" class="form-control" placeholder="Repeat password" />
                                                                    <i class="ace-icon fa fa-retweet"></i>
                                                                </span>
                                                        </label>

                                                        <label class="block">
                                                            <input type="checkbox" class="ace" />
                                                            <span class="lbl">
                                                                    I accept the
                                                                    <a href="#">User Agreement</a>
                                                                </span>
                                                        </label>

                                                        <div class="space-24"></div>

                                                        <div class="clearfix">
                                                            <button type="reset" class="width-30 pull-left btn btn-sm">
                                                                <i class="ace-icon fa fa-refresh"></i>
                                                                <span class="bigger-110">Reset</span>
                                                            </button>

                                                            <button type="button" class="width-65 pull-right btn btn-sm btn-success">
                                                                <span class="bigger-110">Register</span>

                                                                <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                            </div>

                                        </div>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--[if !IE]> -->
        <script src="{{ asset('assets/js/jquery-2.1.4.min.js') }}"></script>

        <script type="text/javascript">
            if('ontouchstart' in document.documentElement) document.write("<script src='{{ asset('assets/js/jquery.mobile.custom.min.js') }}'>"+"<"+"/script>");
        </script>

        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js" integrity="sha512-lOrm9FgT1LKOJRUXF3tp6QaMorJftUjowOWiDcG5GFZ/q7ukof19V0HKx/GWzXCdt9zYju3/KhBNdCLzK8b90Q==" crossorigin="anonymous"></script>
        <!-- inline scripts related to this page -->
        <script type="text/javascript">
            jQuery(function($) {
                $(document).on('click', '.toolbar a[data-target]', function(e) {
                    e.preventDefault();
                    var target = $(this).data('target');
                    $('.widget-box.visible').removeClass('visible');//hide others
                    $(target).addClass('visible');//show target
                });
            });



            $(document).ready(function(){
                $('.employee_full_id').val($('.input-email').val())
            })

            $('.input-email').keyup(function(){
                $('.employee_full_id').val($('.input-email').val())
            })


            function goToEmployeeLogin()
            {
                window.location = '/em'
            }

            function gotoHrLogin()
            {
                window.location = '/home'
            }

            //you don't need this, just used for changing background
            jQuery(function($) {
                $('#btn-login-dark').on('click', function(e) {
                    $('body').attr('class', 'login-layout');
                    $('#id-text2').attr('class', 'white');
                    $('#id-company-text').attr('class', 'blue');

                    e.preventDefault();
                });
                $('#btn-login-light').on('click', function(e) {
                    $('body').attr('class', 'login-layout light-login');
                    $('#id-text2').attr('class', 'grey');
                    $('#id-company-text').attr('class', 'blue');

                    e.preventDefault();
                });
                $('#btn-login-blur').on('click', function(e) {
                    $('body').attr('class', 'login-layout blur-login');
                    $('#id-text2').attr('class', 'white');
                    $('#id-company-text').attr('class', 'light-blue');

                    e.preventDefault();
                });

                @if(session()->get('message'))
                new Noty({
                    theme: 'metroui',
                    type: 'success',
                    text: '{{ session()->get('message') }}'
                }).show();
                @elseif(session()->get('error'))
                new Noty({
                    theme: 'metroui',
                    type: 'error',
                    text: '{{ session()->get('error') }}'
                }).show();
                @endif
            });
        </script>
    </body>
</html>
