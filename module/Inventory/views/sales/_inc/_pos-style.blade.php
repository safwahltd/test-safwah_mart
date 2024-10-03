<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Toastr -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toastr.min.css') }}">


<style>
    * {
        font-size: 14px;
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif !important;
        box-sizing: border-box;
    }

    .main {
        width: 100% !important;
        padding-top: 46px !important;
        height: 84vh !important;
        /* height: 70vh !important; */
        overflow: hidden !important;
    }

    .navbar {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }

    .row {
        --bs-gutter-x: 0 !important;
    }

    .product-row {
        overflow-y: auto; 
        height: 69vh; 
        padding-bottom: 100px !important
    }

    .width-30 {
        width: 30% !important;
    }


    .item-row {
        overflow-y: auto; 
        height: 38%;
    }

    .gutter-sizer {
        --bs-gutter-x: .5rem !important;
        width: 99.99% !important;
        margin: 0 auto !important;
    }

    .input-group>.input-group-text~.select2-container--bootstrap-5 .select2-selection:focus,
    .input-group>.btn~.select2-container--bootstrap-5 .select2-selection:focus,
    .input-group>.dropdown-menu~.select2-container--bootstrap-5 .select2-selection:focus {
        /* box-shadow: 0 0 0 1px #89c7ff !important; */
        border-radius: 0px !important;
    }

    .select2-container--bootstrap-5 .select2-dropdown .select2-search .select2-search__field:focus {
        /* box-shadow: 0 0 0 1px #89c7ff !important; */
        border-radius: 0px !important;
    }


    ::-webkit-scrollbar {
        width: 5px;
        height: 2em
    }

    ::-webkit-scrollbar-thumb {
        background: #ccc
    }

    a {
        text-decoration: none;
        color: #000000;
    }

    .card-info p {
        padding: 0;
        margin: 0;
        line-height: 15px;
        margin-bottom: 5px;
    }

    

    .form-control,
    .form-control:focus,
    .form-select:focus,
    .form-check-input:focus,
    .form-range:focus::-webkit-slider-thumb,
    .btn-check:focus+.btn,
    .btn:focus,
    .accordion-button:focus,
    .page-link:focus,
    .btn-close:focus,
    .bootstrap-timepicker-widget.dropdown-menu.open table tbody tr td input:focus,
    .select2-container--bootstrap-5 .select2-selection,
    .input-group-text {
        border-radius: 0px !important;
        outline: none !important;
    }

    .badge {
        line-height: 13px !important;
    }

    .navbar-brand {
        font-size: 2rem !important;
        font-weight: 700;
        padding: 0 !important;
        margin: 0 !important;
    }

    .product {
        position: relative;
        height: 102px;
    }

    .product img {
        height: 90px;
    }

    .product .card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 5px;
        background-color: #efefef;
        text-align: center;
        color: #000000;
        opacity: 0;
        -webkit-transition: all 800ms;
        -moz-transition: all 800ms;
        -ms-transition: all 800ms;
        -o-transition: all 800ms;
        transition: all 800ms;
    }

    .add-icon {
        font-size: 30px !important;
        top: 36%;
        left: 42%;
        color: #198754 !important
    }

    .add-icon-stock-out {
        font-size: 30px !important;
        top: 36%;
        left: 42%;
        color: #c20c0c !important
    }

    .card {
        background-color: aliceblue;
        /* border: 2px solid aliceblue; */
    }

    

    .product:hover .card-overlay {
        opacity: 0.8;
    }

    .card-overlay .package-info {
        padding: 45px 25px 40px;
        overflow: hidden;
    }

    .card-overlay .btn.btn-primary {
        background-color: #007bd4;
        border-color: #007bd4;
        margin-bottom: 10px;
    }

    .card-overlay .package-info,
    .card-overlay .package-info ul li,
    .card-overlay .package-info ul li i,
    .card-overlay .package-info .package-title a {
        color: #fff;
    }

    .table tr td .select2-container--bootstrap-5 .select2-selection--single {
        border: 0 !important;
    }

    .navbar .container {
        max-width: 100%;
    }


    .bg-success {
        background-color: #70e8b1 !important;
        color: #000000 !important;
    }

    .bg-danger {
        background-color: #ff99a2 !important;
        color: #000000 !important;
    }


    .badge-primary {
        background-color: #bfd9ff!important;
        color: #000000;
    }


    .badge-success {
        background-color: #7df0ba!important;
        color: #000000;
    }


    .badge-secondary {
        background-color: #d6d6d6!important;
        color: #000000;
    }


    .badge-warning {
        background-color: #ffda6a!important;
        color: #000000;
    }

    .card > .p-name {
        font-size: 16px;
        word-wrap: break-word !important;
    }

    .p-name {
        height: 65px !important;
    }

    .input-group {
        height: 33px !important;
    }

    


    .btn-success {
        background-color: #70e8b1 !important;
        border: 2px solid #70e8b1 !important;
        color: #000000 !important;
    }

    .btn-danger {
        background-color: #ff99a2 !important;
        border: 2px solid #ff99a2 !important;
        color: #000000 !important;
    }


    .increment {
        color: #000000 !important;
        font-size: 10px !important;
    }

    .decrement {
        color: #000000 !important;
        font-size: 10px !important;
    }

    .increment:hover {
        background-color: #70e8b1 !important;
        cursor: pointer;
    }

    .decrement:hover {
        background-color: #ff99a2 !important;
        cursor: pointer;
    }

    .search-input, .search-icon {
        background-color: aliceblue !important;
        border: none;
        color: #000000 !important;
        font-size: 16px !important;
    }

    .search-input {
        padding-left: 1px !important;
    }

    .search-input:focus {
        outline: 0px !important;
        box-shadow: none !important;
    }

    .fs-7 {
        font-size: 16px !important;
    }

    .page-item.active .page-link {
        color: #000000;
        background-color: #ffda6a !important;
        border-color: #ffda6a !important;
    }

    .item-table { 
        overflow: auto; 
        height: 100px; 
    }
    .item-table thead th { 
        position: sticky; 
        top: 0; 
        z-index: 1; 
        background-color: aliceblue; 
        border-bottom: 2px solid !important;
    }
</style>
