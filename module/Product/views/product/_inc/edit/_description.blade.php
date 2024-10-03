<div class="row">
    <div class="col-md-12">
        <div class="mb-3 mt-2">
            <label for="">Short Description/SEO Description</label>
            <div>
                <textarea class="form-control" name="short_description" id="short_description">{{ $product->short_description }}</textarea>
            </div>
        </div>




        @if (hasAnyPermission(['website-cms.meta-tag'], $slugs))
            <!-- META TITLE  -->
            <div class="mb-3 mt-2">
                <label for="">Meta Title</label>
                <div>
                    <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" placeholder="Meta Title">
                </div>
            </div>


            <!-- META DESCRIPTION -->
            <div class="mb-3 mt-2">
                <label for="">Meta Description</label>
                <div>
                    <textarea style="min-height: 80px" class="form-control" name="meta_description" placeholder="Type Meta Description" id="meta_description">{{ $product->meta_description }}</textarea>
                </div>
            </div>



            <!-- IMAGE ALT TAGE  -->
            <div class="mb-3 mt-2">
                <label for="">Alt Text</label>
                <div>
                    <input type="text" class="form-control" name="alt_text" value="{{ old('alt_text', $product->alt_text) }}" placeholder="Meta Alt Text">
                </div>
            </div>
        @endif 


        <div>
            <label for="">Description</label>
            <div>
                <textarea class="summernote form-control" name="description" id="description">{!! $product->description !!}</textarea>
            </div>
        </div>
    </div>
</div>
