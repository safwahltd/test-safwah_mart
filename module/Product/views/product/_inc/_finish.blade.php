
@php
    session()->put('productCreate', 'no');
@endphp

<div class="" style="display: flex; align-items:center; justify-content:center; padding-top: 50px; padding-bottom: 100px; ">
    
    <img src="{{ asset('success.gif') }}" class="my-3 mr-3" style="width: 200px;" alt="">
    <div style="margin-top: -20px">
        <h2 class="text-success" style="font-weight: 800;">Finished Successfully</h2>
        <div class="btn-group mt-2">
            <a class="btn btn-sm btn-theme mr-1" href="{{ url()->previous() }}"><i class="fa fa-long-arrow-left"></i> PREVIOUS</a>
            <a class="btn btn-sm btn-next" href="{{ route('pdt.products.index') }}">BACK TO LIST <i class="fa fa-long-arrow-right"></i></a>
        </div>
    </div>
</div>