@extends('layouts.master')

@section('title','Dashboard')

@section('page-header')
    <i class="fa fa-tachometer"></i> Dashboard
@stop

@section('css')
    <link rel="stylesheet" href="/assets/css/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="/assets/css/bootstrap-timepicker.min.css" />
    <link rel="stylesheet" href="/assets/css/daterangepicker.min.css" />
    <link rel="stylesheet" href="/assets/css/bootstrap-datetimepicker.min.css" />

    <!----------- DASHBOARD WIDGET CARD CSS START ----------->
    <style>
        .card-section .card-item .item-body .load-data {
            font-family: 'Fira Sans', sans-serif;
        }
        .font-fira-sans {
            font-family: 'Fira Sans', sans-serif;
            font-size: 26px;
        }
        .card-section .card-item .item-body .load-data,
        .card-section .card-item .dashboard-info strong,
        .card-section .card-item .dashboard-info h2,
        .card-section .card-item .dashboard-info i,
        .font-fira-sans {
            color: white !important;
        }
        .card-section .card-item .dashboard-info > h2 > i {
            font-size: 38px;
        }
        .card-section .card-item{
            margin-bottom: 4px !important;
            transition: 0.3s;
        }
        .card-section .card-item .item-body{
            border-radius: 2px;
            background-color: aliceblue !important;
            border: 0 !important;
            padding: 0px !important;
            /* box-shadow: 0px 1px 6px 1px rgb(0 0 0 / 60%); */
            box-shadow: 0px 0px 3px 0px rgb(0 0 0 / 10%);
            background: no-repeat 50% 50%;
            background-size: cover;
            height: 122px;
            transition: 0.3s;
        }
        .card-section .card-item .item-body:hover {
            -webkit-transform: translateY(calc(-2rem / 5));
            transform: translateY(calc(-2rem / 5));
            /* box-shadow: 0px 1px 6px 1px rgb(0 0 0 / 40%); */
            box-shadow: 0px 5px 10px 0px rgba(96, 9, 240, 0.3);
        }
        .card-section .card-item .item-body .load-data{
            margin-bottom: 0 !important;
            font-size: 26px;
        }
        .card-section .card-item .dashboard-info strong.text-center {
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 500;
        }
        .effect8
        {
            -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
            -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
            box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
        }
        .effect7
        {
            -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
            -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
            box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
        }
        .card-section .card-item .overlay{
            position: absolute;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 25px 15px !important;
        }

    </style>
    <!----------- /DASHBOARD WIDGET CARD CSS END ----------->

@stop

@section('content')


    <div class="row pt-1 card-section" style="padding-left: 5px !important;">

        <!----- INCLUDING ALERT MESSAGES ------>
        <div class="col-xs-12">
            @include('partials._alert_message')
        </div>


        <!------------ CUSTOMER ------------>
        <div class="col-md-3 card-item">
            <div class="well item-body effect8" style="position: relative;">
                <img src="{{ asset('assets/dashboard-widget-img/green.png') }}" alt="" width="100%" height="100%">
                <div class="overlay">
                    <div class="dashboard-info">
                        <h2><i class="far fa-users"></i></h2>
                        <strong class="text-center">Customer</strong>
                    </div>
                    <div class="dashboard-loader" style="position:absolute;right:13px;top:11px;">
                        <h2 class="font-fira-sans">{{ $customers }}</h2>
                    </div>
                </div>
            </div>
        </div>


        <!------------ TODAY'S ORDER ------------>
        <div class="col-md-3 card-item">
            <div class="well item-body effect8" style="position: relative;">
                <img src="{{ asset('assets/dashboard-widget-img/purple.png') }}" alt="" width="100%" height="100%">
                <div class="overlay">
                    <div class="dashboard-info">
                        <h2><i class="far fa-shopping-cart"></i></h2>
                        <strong class="text-center">Today Order</strong>
                    </div>
                    <div class="dashboard-loader" style="position:absolute;right:13px;top:11px;">
                        <h2 class="font-fira-sans">{{ $todayOrders }}</h2>
                    </div>
                </div>
            </div>
        </div>


        <!------------ YESTERDAY'S ORDER ------------>
        <div class="col-md-3 card-item">
            <div class="well item-body effect8" style="position: relative;">
                <img src="{{ asset('assets/dashboard-widget-img/red.png') }}" alt="" width="100%" height="100%">
                <div class="overlay">
                    <div class="dashboard-info">
                        <h2><i class="far fa-shopping-cart"></i></h2>
                        <strong class="text-center">Yesterday Order</strong>
                    </div>
                    <div class="dashboard-loader" style="position:absolute;right:13px;top:11px;">
                        <h2 class="font-fira-sans">{{ $yesterdayOrders }}</h2>
                    </div>
                </div>
            </div>
        </div>



        <!------------ TOTAL ORDER ------------>
        <div class="col-md-3 card-item">
            <div class="well item-body effect8" style="position: relative;">
                <img src="{{ asset('assets/dashboard-widget-img/yellow.png') }}" alt="" width="100%" height="100%">
                <div class="overlay">
                    <div class="dashboard-info">
                        <h2><i class="fas fa-chart-pie"></i></h2>
                        <strong class="text-center">Total Order</strong>
                    </div>
                    <div class="dashboard-loader" style="position:absolute;right:13px;top:11px;">
                        <h2 class="font-fira-sans">{{ $totalOrders }}</h2>
                    </div>
                </div>
            </div>
        </div>



        <!------------ PRODUCT ------------>
        <div class="col-md-3 card-item">
            <div class="well item-body effect8" style="position: relative;">
                <img src="{{ asset('assets/dashboard-widget-img/red.png') }}" alt="" width="100%" height="100%">
                <div class="overlay">
                    <div class="dashboard-info">
                        <h2><i class="fas fa-box-open"></i></h2>
                        <strong class="text-center">Product</strong>
                    </div>
                    <div class="dashboard-loader" style="position:absolute;right:13px;top:11px;">
                        <h2 class="font-fira-sans">{{ $products }}</h2>
                    </div>
                </div>
            </div>
        </div>



        <!------------ TODAY SELL ------------>
        <div class="col-md-3 card-item">
            <div class="well item-body effect8" style="position: relative;">
                <img src="{{ asset('assets/dashboard-widget-img/yellow.png') }}" alt="" width="100%" height="100%">
                <div class="overlay">
                    <div class="dashboard-info">
                        <h2><i class="fas fa-analytics"></i></h2>
                        <strong class="text-center">Today Sell</strong>
                    </div>
                    <div class="dashboard-loader" style="position:absolute;right:13px;top:11px;">
                        <h2 class="font-fira-sans">{{ $todaySells }}</h2>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <br>
    <br>

    <div id="chartContainer" style="height: 370px; width: 100%; margin: 0px auto;"></div>

@endsection

{{-- @section('js')

    <script type="text/javascript" src="{{ asset('assets/custom_js/canvasjs.js') }}"></script>

    <script src="{{ asset('assets/js/ace-elements.min.js') }}"></script>
    <script src="{{ asset('assets/js/ace.min.js') }}"></script>

    <script>
        // var dt = new Date();
        // var month = dt.getMonth();
        // var year = dt.getFullYear();

        var t = new Date();
        var date = ('0' + t.getDate()).slice(-2);
        var month = ('0' + (t.getMonth() + 1)).slice(-2);
        var year = t.getFullYear();

        var time = `${year}-${month}-${date}`;


        daysInMonth = new Date(year, month, 0).getDate();
        // console.log(time)
        // console.log(daysInMonth)



        window.onload = function() {

            var dataPoints = [];

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Daily Sales Data"
                },
                axisY: {
                    title: "Units",
                    titleFontSize: 24,
                    includeZero: true
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,### Units",
                    dataPoints: dataPoints
                }]
            });

            function addData(data, dateList) {

                $.map( dateList, function( val, i ) {
                    dataPoints.push({
                        x: data[i] != undefined && data[i].date == val ? data[i].date : val,
                        y: 'adfd'
                    });
                });

                chart.render();
            }



            var getDaysOfMonth = function(year, month) {
                var monthDate = moment(year+'-'+month, 'YYYY-MM');
                var daysInMonth = monthDate.daysInMonth();
                var arrDays = [];

                while(daysInMonth) {
                    var current = moment().date(daysInMonth);
                    arrDays.push(current.format('YYYY-MM-DD'));
                    daysInMonth--;
                }

                return arrDays;
            };

            var dateList = getDaysOfMonth(year, month);

            async function getCurrentMonthWiseDailySaleReport()
            {
                const route = `{{ route('get-current-month-wise-daily-sale-report') }}`;
                await axios.get(route)
                .then((response) => {
                    // console.log(response.data)

                    addData(response.data, dateList)
                })
            }

            getCurrentMonthWiseDailySaleReport()
        }






    </script>

@stop --}}
