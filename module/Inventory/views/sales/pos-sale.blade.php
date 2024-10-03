<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>POS SALE &mdash; {{ $company->title }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- FONTAWESOME 5 -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <!-- FAB ICON -->
    <link rel="shortcut icon" href="{{ file_exists($company->favicon_icon) ? asset($company->favicon_icon) : asset('favicon.png') }}" type="image/x-icon">


    <!-- POS STYLE -->
    @include('sales._inc._pos-style')

    <!----------------- PAYMENT ADD FORM MODAL CSS ----------------->
    <style>
        .sn-no {
            padding-left: 5px;
            line-height: 2.5;
        }
        .payment-add-modal .table tr td .select2-container--bootstrap-5 .select2-selection--single {
            border: 1px solid #ced4da !important;
            text-align: left !important;
        }
        .select2-container--bootstrap-5 .select2-dropdown {
            z-index: 99999 !important;
        }
        .payment-add-modal .payment-add-modal-body{
            max-height: 70vh;
            overflow-y: scroll;
            overflow-x: hidden;
        }
        .payment-add-modal .remove-button{
            background: #D15B47 !important;
            color: white !important;
            padding: 4px 10px;
            border: none !important;
        }
        .payment-add-modal .add-button{
            padding: 4px 9px !important;
            border: none !important;
        }
        .payment-add-modal .modal-content {
            height: 70vh !important;
            width: 90% !important;
            border: 5px solid #dee2e6;
        }

    </style>


    <!---------------- RECENT TRANSACTION MODAL CSS ---------------->
    <style>
        .recent-transaction-modal .modal-content {
            /* height: 65vh !important; */
            width: 80% !important;
            border: 5px solid #dee2e6;
        }
        .recent-transaction-modal .recent-transaction-modal-header{
            padding: 15px 15px 0 15px;
        }
        .recent-transaction-modal-body .nav-link{
            color: #00878E;
        }
        .recent-transaction-modal-body .nav-link:hover{
            border-color: #00878E;
            color: #00878E;
            border-bottom-color: white !important;
        }
        .recent-transaction-modal-body .nav-link.active{
            background-color: transparent;
            border-color: #00878E;
            color: #00878E;
            font-weight: bold;
            border-bottom-color: white !important;
        }
        .recent-transaction-modal .nav-tabs {
            border-bottom: 1px solid #00878E;
        }
        .recent-transaction-modal .content-body{
            width: 100%;
            display: flex;
            margin: 0px 0;
        }
        .recent-transaction-modal .content-body .serial{
            width: 10%;
            color: #3e4144;
            font-weight: 400;
            font-size: 15px;
            text-align: left;
            padding-left: 20px;
            font-family: 'Roboto Slab', serif !important;
        }
        .recent-transaction-modal .content-body .title{
            width: 54%;
            text-align: left;
            font-family: 'Roboto Slab', serif !important;
        }
        .recent-transaction-modal .content-body .title a{
            color: #3e4144;
            font-weight: 400;
            font-size: 15px;
            font-family: 'Roboto Slab', serif !important;
        }
        .recent-transaction-modal .content-body .amount{
            width: 20%;
            color: #3e4144;
            font-weight: 400;
            font-size: 15px;
            font-family: 'Roboto Slab', serif !important;
        }
        .recent-transaction-modal .content-body .action{
            width: 20%;
            color: #3e4144;
            font-weight: 400;
            font-size: 15px;
            font-family: 'Roboto Slab', serif !important;
        }
        .recent-transaction-modal .content-body .action .edit-icon{
            margin: 0 3px;
        }
        .recent-transaction-modal .content-body .action .trash-icon{
            color: rgb(226, 44, 44);
            margin: 0 3px;
        }
        .recent-transaction-modal .content-body .action .print-icon{
            color: #6c6565;
            margin: 0 3px;
        }
        .recent-transaction-modal .content-body .action .eye-icon{
            color: rgb(48, 48, 212);
            margin: 0 3px;
        }
        .recent-transaction-modal table{
            width: 100%;
        }
        .recent-transaction-modal table tbody{
            width: 100%;
        }
        .recent-transaction-modal table tbody tr{
            width: 100%;
        }
        .text-white{
            color: white !important;
        }
        .recent-transaction-modal .tab-pane.sale-pane {
            height: 42vh;
            overflow-x: hidden;
            /* background: lightskyblue; */
            overflow-y: auto;
            /* color: white !important; */
        }
    </style>


    <!----------------- POS CUSTOMER EDIT MODAL CSS ---------------->
    <style>
        .pos-customer-edit .btn-close {
            border: none;
            outline: none;
            font-weight: 600;
            margin-top: -25px;
            margin-right: -8px;
        }
        .pos-customer-edit .modal-title .fa-user-edit{
            font-size: 18px;
        }
        .pos-customer-edit .save-btn {
            float: right;
            border-radius: 0;
            margin-top: 7px;
            margin-right: 10px;
        }
        .pos-customer-edit .form-group{
            margin: 10px;
        }
        .pos-customer-edit .modal-dialog {
            max-width: 600px;
        }
        .can-toggle {
        position: relative;
        }
        .can-toggle *, .can-toggle *:before, .can-toggle *:after {
        box-sizing: border-box;
        }
        .can-toggle input[type=checkbox] {
        opacity: 0;
        position: absolute;
        top: 0;
        left: 0;
        }
        .can-toggle input[type=checkbox][disabled] ~ label {
        pointer-events: none;
        }
        .can-toggle input[type=checkbox][disabled] ~ label .can-toggle__switch {
        opacity: 0.4;
        }
        .can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch:before {
        content: attr(data-unchecked);
        left: 0;
        }
        .can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch:after {
        content: attr(data-checked);
        }
        .can-toggle label {
        user-select: none;
        position: relative;
        display: flex;
        align-items: center;
        }
        .can-toggle label .can-toggle__label-text {
        flex: 1;
        padding-left: 32px;
        }
        .can-toggle label .can-toggle__switch {
        position: relative;
        }
        .can-toggle label .can-toggle__switch:before {
        content: attr(data-checked);
        position: absolute;
        top: 2px;
        text-transform: uppercase;
        text-align: center;
        }
        .can-toggle label .can-toggle__switch:after {
        content: attr(data-unchecked);
        position: absolute;
        z-index: 5;
        text-transform: uppercase;
        text-align: center;
        background: white;
        transform: translate3d(0, 0, 0);
        }
        .can-toggle input[type=checkbox][disabled] ~ label {
        color: rgba(234, 0, 48, 0.5);
        }
        .can-toggle input[type=checkbox]:focus ~ label .can-toggle__switch, .can-toggle input[type=checkbox]:hover ~ label .can-toggle__switch {
        background-color: lightgray;
        }
        .can-toggle input[type=checkbox]:focus ~ label .can-toggle__switch:after, .can-toggle input[type=checkbox]:hover ~ label .can-toggle__switch:after {
        color: #b70026;
        }
        .can-toggle input[type=checkbox]:hover ~ label {
        color: #d1002b;
        }
        .can-toggle input[type=checkbox]:checked ~ label:hover {
        color: #55bc49;
        }
        .can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch {
        background-color: #70c767;
        }
        .can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch:after {
        color: #4fb743;
        }
        .can-toggle input[type=checkbox]:checked:focus ~ label .can-toggle__switch, .can-toggle input[type=checkbox]:checked:hover ~ label .can-toggle__switch {
        background-color: #5fc054;
        }
        .can-toggle input[type=checkbox]:checked:focus ~ label .can-toggle__switch:after, .can-toggle input[type=checkbox]:checked:hover ~ label .can-toggle__switch:after {
        color: #47a43d;
        }
        .can-toggle label .can-toggle__label-text {
        flex: 1;
        }
        .can-toggle label .can-toggle__switch {
        transition: background-color 0.3s cubic-bezier(0, 1, 0.5, 1);
        background: lightgray;
        }
        .can-toggle label .can-toggle__switch:before {
        color: rgba(255, 255, 255, 0.5);
        }
        .can-toggle label .can-toggle__switch:after {
        -webkit-transition: -webkit-transform 0.3s cubic-bezier(0, 1, 0.5, 1);
        transition: transform 0.3s cubic-bezier(0, 1, 0.5, 1);
        color: #ea0030;
        }
        .can-toggle input[type=checkbox]:focus ~ label .can-toggle__switch:after, .can-toggle input[type=checkbox]:hover ~ label .can-toggle__switch:after {
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
        }
        .can-toggle input[type=checkbox]:checked ~ label .can-toggle__switch:after {
        transform: translate3d(55px, 0, 0);
        }
        .can-toggle input[type=checkbox]:checked:focus ~ label .can-toggle__switch:after, .can-toggle input[type=checkbox]:checked:hover ~ label .can-toggle__switch:after {
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
        }
        .can-toggle label {
        font-size: 14px;
        }
        .can-toggle label .can-toggle__switch {
            height: 29px;
            flex: 0 0 110px;
            border-radius: 4px;
        }
        .can-toggle label .can-toggle__switch:before {
            left: 56px;
            font-size: 12px;
            line-height: 25px;
            width: 50px;
            padding: 0 5px;
        }
        .can-toggle label .can-toggle__switch:after {
            top: 2px;
            left: 2px;
            border-radius: 2px;
            width: 50px;
            line-height: 25px;
            font-size: 12px;
        }
        .can-toggle label .can-toggle__switch:hover:after {
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4);
        }
        .can-toggle.can-toggle--size-small input[type=checkbox]:focus ~ label .can-toggle__switch:after, .can-toggle.can-toggle--size-small input[type=checkbox]:hover ~ label .can-toggle__switch:after {
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
        }
        .can-toggle.can-toggle--size-small input[type=checkbox]:checked ~ label .can-toggle__switch:after {
        transform: translate3d(44px, 0, 0);
        }
        .can-toggle.can-toggle--size-small input[type=checkbox]:checked:focus ~ label .can-toggle__switch:after, .can-toggle.can-toggle--size-small input[type=checkbox]:checked:hover ~ label .can-toggle__switch:after {
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
        }
        .can-toggle.can-toggle--size-small label {
        font-size: 13px;
        }
        .can-toggle.can-toggle--size-small label .can-toggle__switch {
        height: 28px;
        flex: 0 0 90px;
        border-radius: 2px;
        }
        .can-toggle.can-toggle--size-small label .can-toggle__switch:before {
        left: 45px;
        font-size: 10px;
        line-height: 28px;
        width: 45px;
        padding: 0 12px;
        }
        .can-toggle.can-toggle--size-small label .can-toggle__switch:after {
        top: 1px;
        left: 1px;
        border-radius: 1px;
        width: 44px;
        line-height: 26px;
        font-size: 10px;
        }
        .can-toggle.can-toggle--size-small label .can-toggle__switch:hover:after {
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.4);
        }
    </style>


    <!----------------- SEARCH ANY PRODUCT LIST CSS ---------------->
    <style>
        /* .dropdown-content {
            display: none;
            background-color: #f6f6f6;
            overflow: auto;
            border: 1px solid #ddd;
            z-index: 1;
            max-height: 117px;
            width: 95%;
            margin: 0 auto;
        } */
        .dropdown-content {
            display: none;
            background-color: #f6f6f6;
            overflow: auto;
            border: 1px solid #ddd;
            z-index: 1;
            max-height: 244px;
            width: 79%;
            margin: 0 auto;
        }
        .dropdown-content ul{
            margin-left: 0
        }
        .dropdown-content.ace-scroll{
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        .dropdown-content a {
        color: black;
        text-decoration: none;
        display: flex;
        padding: 5px 8px !important;
            border-bottom: 1px solid lightgray !important;
            transition: 0.3s;
        }

        .search-dropdown-list {
            position: absolute;
            top: 50px;
            left: 7px;
        }
        .search-dropdown-list a{
            transition: 0.4s;
        }
        .search-dropdown-list .scroll-hover{
            opacity: 0 !important;

        }
        .search-dropdown-list a:hover{
            color: white !important;
            background-color: rgb(58, 170, 207) !important;
        }
        .table-responsive {
            overflow: visible !important;
        }

        .dropdown-content a:hover{
            background-color: lightskyblue !important;
            color: black !important;
        }
        .show {display: block;}


        .search-result{
            color: white !important;
            background-color: rgb(58, 170, 207) !important;
        }
        .search-pos-product{
            position: relative;
        }
        .search-pos-product .dropdown-content{
            position: absolute;
            left: 0;
            top: 40px;
            display: block;
            width: 100%;
            z-index: 99;
        }
        .search-pos-product .dropdown-content .search-product{
            padding-left: 0;
        }
        .pos-left-side .search-body{
            /* width: 100%; */
            flex-wrap: nowrap !important;
        }
        .pos-left-side .search-body .add-customer-btn{
            /* width: 12% !important; */
        }
        .pos-left-side .search-body .search-customer-select{
            /* width: 60% !important; */
        }
        .pos-left-side .search-body .edit-customer-btn{
            /* width: 12% !important; */
        }
        .pos-left-side .select2-container .select2-selection--single{
            height: 33px;
            border-radius: 0;
            line-height: 33px !important;
        }
    </style>

</head>

<body>

    <!-- POS NAV -->
    @include('sales/_inc/_pos-nav')
    @include('sales/_inc/_recent-transaction-modal')
    @include('sales/_inc/_measurement-modal')
    @include('sales/_inc/_variation-modal')
    @include('sales/_inc/_pos-customer-add-modal')
    @include('sales/_inc/_pos-customer-edit-modal')
    @include('script/_customer-add-edit-script')

    <form id="posSaleForm" class="form-horizontal" action="{{ route('inv.orders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('sales/_inc/_payment-add-form')

        <!-- MAIN -->
        <div class="row main">


            @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>ERROR: </strong> {{ session()->get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif



            <!-- POS LEFT SIDE -->
            @include('sales/_inc/_pos-left-side')

            <!-- POS RIGHT SIDE -->
            @include('sales/_inc/_pos-right-side')
        </div>

        @include('sales/_inc/_footer')
    </form>

    <!-- POS SCRIPT -->
    @include('sales/_inc/_pos-script')

    <!-- RECENT TRANSACTION SCRIPT -->
    @include('sales/_inc/_recent-transaction-script')


    <script>

    </script>


</body>
</html>
