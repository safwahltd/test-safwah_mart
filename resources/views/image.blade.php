
@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/custom_css/image-plugin.css') }}">
@endsection

@section('content')
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
    </button>
    
    
    <div class="modal fade" id="exampleModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="margin: 0px; padding: 0px">
                    <h4 class="heading">Upload Image</h4>
                    
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#browse">Browse</a></li>
                        <li><a data-toggle="tab" href="#select">Select</a></li>
                    </ul>
                
                    <div class="tab-content">
                        <div id="browse" class="tab-pane active">
                            <div class="row add-image mt-1">
                                <div class="col-sm-12">
                                    <div class="upload-section">
                                        <label class="upload-image" for="image1">
                                            <input type="file" class="multiple-image" id="image1" name="multiple_image[]" onchange="loadPhoto(this, 'loadImage1')">
                                            <img id="loadImage1" class="img-responsive" style="display: none">
                                            <span class="remove" onclick="removeImage(this)"><i class="fas fa-times"></i></span>
                                        </label>
                                        <span id="more__img">
                            
                                        </span>
                                        <label class="add-more" onclick="addMore()"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="select" class="tab-pane">
                            <div class="row add-image mt-1">
                                <div class="col-sm-12">
                                    <div class="upload-section">
                                        <label class="check-image" for="checkedImage1">
                                            <input type="checkbox" class="multiple-image image-checked" id="checkedImage1" name="multiple_image[]">
                                            <img class="img-responsive" src="{{ asset('1654511140-1918583.png') }}">
                                            <span class="remove" onclick="removeImage(this)" style="display: none"><i class="fas fa-times"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-theme" data-dismiss="modal">CLOSE</button>
                    <button type="button" class="btn btn-sm btn-next">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>
@endsection
    


@section('script')
    <script src="{{ asset('assets/custom_js/image-plugin.js') }}"></script>
@endsection
