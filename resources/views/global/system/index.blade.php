
@extends('layouts.master')
@section('title','System Setting')
@section('page-header')
    <i class="fa fa-empire"></i> System Setting
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css') }}" />
    <style>
        .bg-dark{
            background-color: #ededed;
        }
    </style>

@stop


@section('content')


    @include('partials._alert_message')


    <div class="row mt-5">
        <form class="form-horizontal" action="{{ route('system-setting.store') }}" method="post">
            @csrf

            <div class="col-sm-8 col-sm-offset-2">
                <table class="table table-bordered">
                    <tr>
                        <th class="bg-dark">Title</th>
                        <th class="bg-dark">Value</th>
                    </tr>

                    @foreach($systemSettings as $key => $systemSetting)

                        <tr>
                            <th>
                                {{ $systemSetting->key }}
                            
                            </th>
                            <td>

                               
                                   <label> <input @if($systemSetting->id == 5 || $systemSetting->id == 6) onclick="chooseInvoice(this, {{ $systemSetting->id }})" @endif type="radio" class="yes-{{ $systemSetting->id }}" name="key[{{ $systemSetting->key }}]" {{ $systemSetting->value == 1 ? "checked" : "" }} value="1"> Yes</label>
                                   <label> <input @if($systemSetting->id == 5 || $systemSetting->id == 6) onclick="chooseInvoice(this, {{ $systemSetting->id }})" @endif type="radio" class="no-{{ $systemSetting->id }}" name="key[{{ $systemSetting->key }}]" {{ $systemSetting->value == 0 ? "checked" : "" }} value="0"> No</label>

                                

                            </td>
                        </tr>

                    @endforeach
                    <tr>
                        <th class="bg-dark text-center" colspan="2">
                            <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> Save</button>
                        </th>
                    </tr>

                </table>
            </div>
        </form>
    </div>


@endsection




@section('script')
    <script>

        function chooseInvoice(obj, id)
        {
            if (id == 5) {
                id = 6;
            } else if (id == 6) {
                id = 5;
            }

            if($(obj).prop("checked") == true && $(obj).val() == 1){
				$('.yes-'+id).prop('checked', false);
                $('.no-'+id).prop('checked', true);
            }
            else if($(obj).prop("checked") == true && $(obj).val() == 0) {
				$('.yes-'+id).prop('checked', true);
                $('.no-'+id).prop('checked', false);
            }
        }
    </script>
@stop
