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

    <style>
        .well {
            background-color: aliceblue !important;
            border: 2px solid #2c6aa0 !important;
            padding: 15px !important;
        }
    </style>
@stop


@section('content')


    <div class="row">
        <div class="col-xs-12">

        @include('partials._alert_message')

        <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->

        <br>

        <div class="col-md-3">
            <div class="well">
                <h2><i class="far fa-users"></i> &nbsp;{{ $customers }}</h2>
                <strong class="text-center">Total Customer</strong>
            </div>
        </div>

        <div class="col-md-3">
            <div class="well">
                <h2><i class="far fa-shopping-cart"></i> &nbsp;{{ $todayOrders }} </h2>
                <strong class="text-center">Today Order</strong>
            </div>
        </div>

        <div class="col-md-3">
            <div class="well">
                <h2><i class="far fa-shopping-cart"></i> &nbsp; {{ $yesterdayOrders }}</h2>
                <strong class="text-center">Yesterday Order</strong>
            </div>
        </div>

        <div class="col-md-3">
            <div class="well">
                <h2><i class="far fa-shopping-cart"></i> &nbsp; {{ $totalOrders }}</h2>
                <strong class="text-center">Total Order</strong>
            </div>
        </div>

        <div class="col-md-3">
            <div class="well">
                <h2><i class="far fa-cube"></i> &nbsp;{{ $products }} </h2>
                <strong class="text-center">Product</strong>
            </div>
        </div>

        <div class="col-md-3">
            <div class="well">
                <h2><i class="far fa-money"></i> &nbsp;{{ $todaySells }}</h2>
                <strong class="text-center">Today Sell</strong>
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
