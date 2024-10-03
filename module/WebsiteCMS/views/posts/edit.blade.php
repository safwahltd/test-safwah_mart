@extends('layouts.master')

@section('title')
    Edit Post
@endsection

@section('page-header')
    <i class="fa fa-plus"></i> Edit Post
@endsection



@section('css')
    <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
@endsection

@section('content')
    <div class="page-content no-print">
        <div class="row">

            @include('partials._alert_message')

            <div class="widget-box">
                <div class="widget-header">
                    <h5 class="widget-title">
                        <i class="ace-icon fa fa-plus-circle"></i>Edit Post
                    </h5>
                    <span class="widget-toolbar">
                        <a href="{{ route('website.posts.index') }}">
                            <i class="fa fa-list-alt"></i> Post List
                        </a>
                    </span>

                </div>

                <form action="{{ route('website.posts.update', $post->id) }}" id="Form" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="widget-body">

                        <div class="row pt-2 pr-2">

                            <!-- Left side -->
                            <div class="col-sm-9">

                                <div class="row">
                                    <div class="col-sm-12 px-3">


                                        <!-- Title -->
                                        <div class="form-group">
                                            <label class="">Title <sup class="text-danger">*</sup></label>
                                            <input name="title" type="text" value="{{ old('title', $post->title) }}" placeholder="Title"
                                                class="form-control" autocomplete="off" required />
                                            <div class="space-10"></div>
                                        </div>

                                        <!-- Short Description -->
                                        <div class="form-group">
                                            <label class="">Short Description</label>
                                            <textarea name="short_desc"
                                                class="form-control input-sm">{{ old('short_desc',$post->short_desc) }}</textarea>
                                            <div class="space-10"></div>
                                        </div>


                                        <!-- Description/Article -->
                                        <div class="form-group">
                                            <label>Article/Content</label>

                                            <textarea name="content" id="summernote" cols="40" rows="15"
                                                class="form-control">{{ old('content',$post->content) }}</textarea>

                                            <div class="space-10"></div>
                                        </div>


                                        <!-- SEO  Title -->
                                        <div class="form-group">
                                            <label class="">SEO Title</label>
                                            <textarea name="seo_title"
                                                class="form-control input-sm">{{ old('seo_title', $post->seo_title) }}</textarea>
                                            <div class="space-10"></div>
                                        </div>


                                        <!-- SEO  Title -->
                                        <div class="form-group">
                                            <label class="">SEO Description</label>
                                            <textarea name="seo_description"
                                                class="form-control input-sm">{{ old('seo_description', $post->seo_description) }}</textarea>
                                            <div class="space-10"></div>
                                        </div>


                                    </div>
                                </div>
                            </div>



                            <!-- Right Side -->
                            <div class="col-xs-3">


                                <div class="row" style="margin:15px">



                                    <!-- Duration -->
                                    <div class="form-group">
                                        <label for="inputEmail4">Category</label>
                                        <select name="category_id[]" class="form-control select2"
                                            data-placeholder="--Category--" multiple>
                                            <option value=""></option>
                                            @foreach ($categories as $key => $item)
                                                <option value="{{ $key }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <!-- Feature Image -->
                                    <div class="form-group">
                                        <label>Feature Image</label>
                                        <input type="file" class="form-control ace-file-upload" name="feature_image">
                                    </div>




                                    <!-- Format -->
                                    <div class="form-group">
                                        <label for="format">Format</label>
                                        <select name="format_type" class="form-control chosen-selecst select2"
                                            data-placeholder="--Select Format--" data-selected="{{ $post->format_type }}">
                                            <option value=""></option>
                                            <option value="Post" selected>Post</option>
                                            <option value="Video">Video</option>

                                        </select>
                                    </div>



                                </div>
                            </div>




                            <div class="col-xs-12">

                                <!-- Edit Post -->
                                <h5 class="widget-title">
                                    <div class="row" style="margin-top: 10px;padding:5px">

                                        <div class="col-md-12 text-right pr-2">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block"
                                                style="max-width: 150px">
                                                <i class="fa fa-save"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                    <div class="space-10"></div>
                                </h5>
                            </div>

                        </div>
                    </div>
                </form>


            </div>

        </div>
    </div>
@endsection


@section('js')
    <script src="{{ asset('admin/assets/js/bootstrap-tag.min.js') }}"></script>


    <script src="{{ asset('admin/assets/custom_js/file_upload.js') }}"></script>


    <script>
        CKEDITOR.replace('summernote');
    </script>

    <script>
        var tag_input = $('#form-field-tags');
        try {
            tag_input.tag({
                placeholder: tag_input.attr('placeholder'),
                // source: ace.vars['US_STATES'],
                /**
                //or fetch data from database, fetch those that match "query"
                source: function(query, process) {
                  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
                  .done(function(result_items){
                	process(result_items);
                  });
                }
                */
            })

            var $tag_obj = $('#form-field-tags').data('tag');
            var index = $tag_obj.inValues('some tag');
            $tag_obj.remove(index);
        } catch (e) {
            tag_input.after('<textarea id="' + tag_input.attr('id') + '" name="' + tag_input.attr('name') + '" rows="3">' +
                tag_input.val() + '</textarea>').remove();
        }
    </script>
@endsection
