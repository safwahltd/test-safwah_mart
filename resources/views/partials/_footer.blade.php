@php
    $companyName = \App\Models\Company::select('name')->whereId(1)->first()->toArray();
@endphp
<div class="footer hidden-print">
    <div class="footer-inner">
        <div class="footer-content">
            <span class="bigger-120" style="float: left; padding-left: 12%;">
                Copyright &copy;{{ date('Y') }} <span class="blue bolder">{{ $companyName['name'] }}</span>
            </span>
        </div>
    </div>
</div>

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
</a>
