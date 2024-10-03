




<div class="row mt-3" id="productOpening">
    <div class="col-lg-6 col-md-offset-3">
        <!-- IMAGE -->
        <div class="input-group width-100">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="imageLabel">Thumbnail Image</span>
            </span>
        </div>
        <div style="display: flex; align-items: center; justify-content: start; margin-top: 5px">
            <div class="add-image upload-section">
                <label class="upload-image" for="thumbnail_mage">
                    <input type="file" id="thumbnail_mage" name="thumbnail_image"accept="image/*" onchange="loadPhoto(this, 'thumbnailImage')">
                    <img id="thumbnailImage" src="{{ file_exists($product->image) ? asset($product->image) : '' }}" class="img-responsive" style="{{ !file_exists($product->image) ? 'display: none' : '' }}">
                </label>

            </div>
            <small style="margin-left: 13px;"><b>Thumbnail Image size must be 515x515.</b></small>
        </div>




        <!-- MULTIPLE IMAGE -->
        <div class="input-group width-100 mt-1" id="addMultipleImage">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="multipleImageLabel">Multiple Image</span>
            </span>
            <input type="text" class="form-control width-80" disabled value="Image size must be 515x515.">
            <button type="button" class="form-control btn btn-next width-20" data-toggle="modal" data-target="#productMultipleImageModal">
                Browse ...
            </button>
        </div>





        <!-- ATTACHMENT -->
        <div class="input-group width-100 my-1 book-type-field" style="{{ $product->product_type_id != 4 ? 'display: none' : '' }}">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="attachmentLabel">Attachment</span>
            </span>
            <input type="file" class="form-control" name="attachment">
        </div>





        <!-- VIDEO -->
        <div class="input-group width-100 my-1">
            <span class="input-group-addon width-30" style="text-align: left">
                <span id="videoLinkLabel">Video Link</span>
            </span>
            <input type="url" class="form-control" name="video_link" value="{{ $product->video_link }}">
        </div>

        <div style="display: flex; align-items: center; justify-content: start; margin-top: 5px" id="loadVideoThumbnail">
            <div class="add-image upload-section">
                <label class="upload-image" for="video_thumbnail">
                    <input type="file" id="video_thumbnail" name="video_thumbnail" accept="image/*" onchange="loadPhoto(this, 'videoThumbnailImage')">
                    <img id="videoThumbnailImage" src="{{ file_exists($product->video_thumbnail) ? asset($product->video_thumbnail) : '' }}" class="img-responsive" style="{{ !file_exists($product->video_thumbnail) ? 'display: none' : '' }}">
                    <span class="remove" style="background-color: red !important; {{ !file_exists($product->video_thumbnail) ? 'display: none' : '' }}" onclick="removeVideoThumbnailImage({{ $product->id }})"><i class="fas fa-times" style="color: white !important;"></i></span>
                </label>
            </div>
            <small style="margin-left: 13px;"><b>Video Thumbnail Image</b></small>
        </div>

    </div>
</div>




<div class="modal fade" id="productMultipleImageModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="multipleImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" style="margin: 0px; padding: 0px">
                <h4 class="heading">Upload Image</h4>
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#browse">Browse</a></li>
                    <li><a data-toggle="tab" href="#gallery">Gallery</a></li>
                </ul>

                <div class="tab-content">
                    <div id="browse" class="tab-pane active">
                        <div class="row add-image mt-1">
                            <div class="col-sm-12">
                                <div class="upload-section">
                                    <label class="upload-image" for="image1">
                                        <input type="file" class="multiple-image" id="image1" name="multiple_image[]" accept="image/*" onchange="loadPhoto(this, 'loadImage1')">
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
                    <div id="gallery" class="tab-pane">
                        <div class="row add-image mt-1">
                            <div class="col-sm-12">
                                <div class="upload-section" id="loadProductMultipleImage">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-theme" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
