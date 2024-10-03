<div class="modal" id="multipleImage" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document" style="width: 450px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="title"></h5>
                <button type="button" class="close" id="modalDismiss" data-dismiss="modal" aria-label="Close" style="margin-top: -35px">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        {{-- <li data-target="#carousel-example-generic" data-slide-to="${ index }" class="${ index == 0 ? 'active' : '' }"></li> --}}
                    </ol>
                
                    
                    <div class="carousel-inner">
                        {{-- <div class="item ${ index == 0 ? 'active' : '' }">
                            <img src="{{ asset('${ item.image }') }}" alt="${ variation_name }" style="height: 300px !important; width: 100% !important;">
                        
                            <div class="carousel-caption">
                                <a href="javascript:void(0)" type="button" class="btn btn-xs mt-3" data-id="${ item.id }" onclick="deleteVariationImage(this)" style="background: red !important; color: #ffffff;"><i class="fa fa-trash"></i></a>
                            </div>
                        </div> --}}
                    </div>
                
                    
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>