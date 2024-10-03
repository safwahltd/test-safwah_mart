@php

    $dashboard = App\Models\SystemSetting::where('key', 'dashboard')
        ->where('value', 1)
        ->first();
    $group = App\Models\Group::first();
    $fav_icon = '/icon.png';

    if (file_exists($group->fav_icon)) {
        $fav_icon = asset($group->fav_icon);
    }

    $isAdminHeader = !request()->is('hrm/payroll/master-salary/*') && !request()->is('hrm/payroll/bank-salary/*') && !request()->is('hrm/payroll/cash-salary/*') && !request()->is('hrm/payroll/master-salary-without-payslip/*') && !request()->is('hrm/payroll/master-salary-with-payslip/*') && !request()->is('hrm/bonus/fixed/bonus/details/*') && request()->segment(1) != 'ems';

    $isAdminSidebar = !request()->is('hrm/payroll/master-salary/*') && !request()->is('hrm/payroll/bank-salary/*') && !request()->is('hrm/payroll/cash-salary/*') && !request()->is('hrm/payroll/master-salary-without-payslip/*') && !request()->is('hrm/payroll/master-salary-with-payslip/*') && !request()->is('hrm/bonus/fixed/bonus/details/*') && request()->segment(1) !== 'em';

    $isFooterVisible = !request()->is('hrm/payroll/master-salary/*') && !request()->is('hrm/payroll/bank-salary/*') && !request()->is('hrm/payroll/cash-salary/*') && !request()->is('hrm/payroll/master-salary-without-payslip/*') && !request()->is('hrm/payroll/master-salary-with-payslip/*');

    $companyInfos = \App\Models\Company::select('title', 'favicon_icon')
        ->where('id', 1)
        ->first();

@endphp

<!DOCTYPE html>


<html lang="en">


<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />


    <!-- TITLE -->
    <title>@yield('title') &mdash; {{ $companyInfos->title }}</title>


    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />


    <!-- FAB ICON -->
    <link rel="shortcut icon"
        href="{{ file_exists($companyInfos->favicon_icon) ? asset($companyInfos->favicon_icon) : asset('favicon.png') }}"
        type="image/x-icon">



    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-colorpicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome-iconpicker.min.css') }}" />


    <!-- font & font awesome -->
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/4.5.0/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.googleapis.com.css') }}?v=0.1" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />





    <!-- stack & yield  css -->
    @yield('css')

    @stack('style')




    <!-- ace styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/ace.min.css') }}" class="ace-main-stylesheet"
        id="main-ace-style" />
    <link rel="stylesheet" href="{{ asset('assets/css/ace-skins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/ace-rtl.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.css"
        integrity="sha512-m52YCZLrqQpQ+k+84rmWjrrkXAUrpl3HK0IO4/naRwp58pyr7rf5PO1DbI2/aFYwyeIH/8teS9HbLxVyGqDv/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />



    <!-- ace settings handler -->
    <script src="{{ asset('assets/js/ace-extra.min.js') }}"></script>



    <!-- sweat alert -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/sweetalert2.min.css') }}">



    <!-- Toastr -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toastr.min.css') }}">


    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" />
    <!-- custom css for master page -->
    <link rel="stylesheet" href="{{ asset('assets/custom_css/master.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/custom_css/color-size.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/custom_css/bootstrap4.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/custom_css/custom.css') }}" />

</head>



<body class="no-skin" style="font-family: monospace;" id="pageContent">

    <!-- header -->
    @include('partials/_header')

    <div class="main-container ace-save-state" id="main-container">

        <input type="hidden" class="sidebar-type" value="{{ request()->segment(1) }}">

        <!-- sidebar -->
        @include('partials/_sidebar')




        <div class="main-content">

            @if ($dashboard && (request()->is('/') || request()->is('home')))
                <div class="main-content-inner" style="background: #f2f2f2">

                    <div class="page-content" style="background: transparent; padding-bottom: 0;">
                    @else
                        <div class="main-content-inner">

                            <div class="page-content">
            @endif





            <!-- DYNAIC CONTENT FROM VIEWS -->
            @yield('content', 'Default Content')

        </div>
    </div>
    </div>




    <!-- FOOTER -->
    @if ($isFooterVisible)
        @include('partials._footer')
    @endif




    <!-- delete form -->
    <form action="" id="deleteItemForm" method="POST">
        @csrf @method('DELETE')
    </form>

    </div>


    <script src="{{ asset('assets/js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.query-object.js') }}"></script>


    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <!--[endif]-->
    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write(
            "<script src='{{ asset('assets/js/jquery.mobile.custom.min.js') }}'>" + "<" + "/script>");
    </script>


    <!-- ace scripts -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>

    <script type="text/javascript">
        function withDefault(value, default_value) {
            return value ? value : default_value
        }
    </script>

    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/custom_js/custom-datatable.js') }}"></script>
    <script src="{{ asset('assets/custom_js/confirm_delete_dialog.js') }}"></script>

    <script src="{{ asset('assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/export-excel-file.js') }}"></script>
    <script src="{{ asset('assets/js/export-pdf-file.js') }}"></script>

    <script src="{{ asset('assets/js/ace-elements.min.js') }}"></script>
    <script src="{{ asset('assets/js/ace.min.js') }}"></script>
    <script src="{{ asset('assets/js/fontawesome-iconpicker.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote.min.js"
        integrity="sha512-6rE6Bx6fCBpRXG/FWpQmvguMWDLWMQjPycXMr35Zx/HRD9nwySZswkkLksgyQcvrpYMx0FELLJVBvWFtubZhDQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.0.3/tinymce.min.js"
        integrity="sha512-DB4Mu+YChAdaLiuKCybPULuNSoFBZ2flD9vURt7PgU/7pUDnwgZEO+M89GjBLvK9v/NaixpswQtQRPSMRQwYIA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('assets/js/menu-auto-activation.js') }}"></script>


    <script>
        function onlyNumber(evnt) {
            let keyCode = evnt.charCode
            let str = evnt.target.value
            let n = str.includes(".")

            if (keyCode == 13) {
                evnt.preventDefault();
            }

            if (keyCode == 46 && n) {
                return false
            }

            if (str.length > 12) {
                showAlertMessage('Number length out of range', 3000)
                return false
            }
            return (keyCode >= 48 && keyCode <= 57) || keyCode == 13 || keyCode == 46
        }


        $(document).find('.only-number').keypress(function() {
            return onlyNumber(event)
        })

        // $(document).on('click','a', function(e){
        //     e.preventDefault();
        //     var pageURL=$(this).attr('href');

        //     history.pushState(null, '', pageURL);

        //     // let url = pageURL;
        //     // $.ajax({
        //     //     type: "GET",
        //     //     url: url,
        //     //     dataType: "html",
        //     //     success: function(data) {
        //     //         $('#pageContent').html(data);
        //     //     }
        //     // });
        // });
    </script>

    <!-- js yield -->
    @yield('js')
    @yield('script')

    <script>
        tinymce.init({
            selector: 'textarea.tiny-editor',
            plugins: [
                'a11ychecker', 'advlist', 'advcode', 'advtable', 'print', 'hr', 'autolink', 'pagebreak',
                'checklist', 'export',
                'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks',
                'powerpaste', 'fullscreen', 'formatpainter', 'image code', 'insertdatetime', 'media', 'code',
                'nonbreaking', 'table', 'help',
                'wordcount'
            ],

            toolbar: 'undo redo | styleselect | a11ycheck casechange blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist checklist outdent indent | image code | link image | print preview media fullscreen | ' +
                'forecolor backcolor emoticons | removeformat | code table help | help',
            menu: {
                favs: {
                    title: 'My Favorites',
                    items: 'code visualaid | searchreplace | emoticons'
                }
            },

            images_upload_url: 'postAcceptor.php',

            // images_upload_handler: function (blobInfo, success, failure) {
            //     setTimeout(function () {
            //     success('http://moxiecode.cachefly.net/tinymce/v9/images/logo.png');
            //     }, 2000);
            // },

            menubar: 'favs file edit view insert format tools table help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>


    <script type="text/javascript">
        $('[data-rel=popover]').popover({
            html: true,
            container: 'body'
        });
    </script>

    <script type="text/javascript">
        $('.success').fadeIn('slow').delay(10000).fadeOut('slow');
    </script>

    <script type="text/javascript">
        $('.select2').select2();
    </script>

    <script type="text/javascript">
        $('.date-picker').datepicker({
            autoclose: true,
            todayHighlight: true
        })


        $('#color-picker-component').colorpicker();
        $('#color-picker-component2').colorpicker();
        $('.colorpicker-element').colorpicker();
        // $('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
        // $( ".datepicker2" ).datepicker({
        //     changeMonth: true,
        //     changeYear: true,
        //     dateFormat: "d MM, yy"
        // });
    </script>

    <script type="text/javascript">
        function showAlertMessage(message, time = 1000, type = 'error') {
            swal.fire({
                title: type.toUpperCase(),
                html: "<b>" + message + "</b>",
                type: type,
                timer: time
            })
        }


        @if (session()->get('message'))
            swal.fire({
                title: "Success",
                html: "<b>{{ session()->get('message') }}</b>",
                type: "success",
                timer: 1000
            });
        @elseif (session()->get('arpMassage'))
            swal.fire({
                // title: "Success",
                html: "<h4><b>{!! session()->get('arpMassage') !!}</b></h4><br><b>Work Order Generated Successfully.</b>",
                type: "success",
                timer: 9000
            });
        @elseif (session()->get('yarn-transfer-success'))
            swal.fire({
                // title: "Success",
                html: "<h4><b>{!! session()->get('yarn-transfer-success') !!}</b></h4><br><b>Yarn Transfer Generated Successfully.</b>",
                type: "success",
                timer: 9000
            });
        @elseif (session()->get('message-number'))
            swal.fire({
                title: "Success",
                html: "<b>{!! session()->get('message-number') !!}</b>",
                // type: "success",
                timer: 30000
            });
        @elseif (session()->get('error'))
            swal.fire({
                title: "Error",
                html: "<b>{{ session()->get('error') }}</b>",
                type: "error",
                timer: 1000
            });
        @elseif (session()->get('payment-success'))
            swal.fire({
                title: "Payment Success",
                html: "<b>{{ session()->pull('payment-success') }}</b>",
                type: "success",
                timer: 10000
            });
        @elseif (session()->get('payment-fail'))
            swal.fire({
                title: "Payment Failed",
                html: "<b>{{ session()->pull('payment-fail') }}</b>",
                type: "Error",
                timer: 10000
            });
        @endif
    </script>

    <!-- Toastr -->
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>

    <!-- custom toster -->
    <script src="{{ asset('assets/custom_js/message-display.js') }}"></script>

    @include('js.toastr')



    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Write Here .....',
                height: 200
            });
        });
    </script>

    <script type="text/javascript">
        function delete_check(id) {
            Swal.fire({
                title: 'Are you sure ?',
                html: "<b>You want to delete permanently !</b>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                width: 400,
            }).then((result) => {
                if (result.value) {
                    $('#deleteCheck_' + id).submit();
                }
            })
        }
    </script>

    <script>
        (function($) {
            'use strict'
            $("#name").on('keyup', function() {
                let name = $(this).val();
                name = name.toLowerCase();
                let regExp = /([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g;
            name = name.replace(regExp, '-');
            $("#slug").val(name);
        });

        $("#name").on('keyup', function() {
            let name = $(this).val();
            name = name.toUpperCase();
            let regExp = /([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g;
                name = name.replace(regExp, '-');
                $("#coupon").val(name);
            });
        })(jQuery);
    </script>

    <script>
        (function($) {
            'use strict'
            $("#opening_balance").on('keyup', function() {
                let val = $(this).val();
                val = val.toLowerCase();
                let regExp = /([~!@#$%^&*()_+=`{}\[\]\|\\:;'<>,.\/? ])+/g;
                val = val.replace(regExp, '-');
                $("#current_balance").val(val);
            });
        })(jQuery);
    </script>

    <script>
        (function($) {
            'use strict'
            $(function() {
                $('[data-toggle="popover"]').popover()
            })
        })(jQuery);
    </script>


    <script>
        $(document).on("click", ".updateStatus", function() {

            let status = $(this).children("i").attr("status");
            let name = $(this).children("i").attr("name");
            let item_id = $(this).attr("item-id");
            let url = $(this).attr("item-url");
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    _token: '{!! csrf_token() !!}',
                    status: status,
                    item_id: item_id
                },
                success: function(resp) {
                    if (resp['status'] == 0) {
                        $("#id-" + name + "-" + item_id).html(
                            `<i class='fa fa-toggle-off text-danger status-icon' status='Inactive' name="${name}" style='font-size: 20px'></i>`
                        );
                        swal.fire({
                            icon: 'success',
                            title: "Status Inactive Successfully",
                            type: "success",
                            timer: 1500
                        });
                    } else if (resp['status'] == 1) {
                        $("#id-" + name + "-" + item_id).html(
                            `<i class='fa fa-toggle-on text-success status-icon' status='Active' name="${name}" style='font-size: 20px'></i>`
                        );
                        swal.fire({
                            icon: 'success',
                            title: "Status Active Successfully",
                            type: "success",
                            timer: 1500
                        });
                    }
                },
                error: function() {
                    alert("Error");
                }
            });
        });



        // jQuery(function($)
        // {
        //     $('#data-table').DataTable({
        //         "ordering": false,
        //         "bPaginate": true,
        //         "lengthChange": false,
        //         "info": false,
        //         "pageLength": 25
        //     });
        // })
    </script>


    <script>
        window.FontAwesomeConfig = {
            searchPseudoElements: true
        }

        $('.fontawesome').iconpicker();
    </script>
    <script>
        $('.date-picker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            viewMode: "days",
            minViewMode: "days",
        })
    </script>
</body>

</html>
