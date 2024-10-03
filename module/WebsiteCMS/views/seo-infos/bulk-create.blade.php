@extends('layouts.master')

@section('title', 'Seo Management')


@section('content')
    <div class="row">
        <div class="col-md-12">


            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('website.seo-management.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-12">

                                <h3>
                                    <strong><i>Seo Management</i></strong>
                                </h3>

                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="18%">Title</th>
                                            <th width="20%">Alt Text</th>
                                            <th>Meta Title</th>
                                            <th>Meta Description</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $seoInfo = $seoInfos->where('page_title', 'Dashboard')->first();
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="text" readonly class="form-control" name="titles[]" value="Dashboard">
                                            </td>
                                            <td>
                                                <input type="text" name="alt_texts[]" class="form-control" value="{{ optional($seoInfo)->alt_text }}">
                                            </td>
                                            <td>
                                                <input type="text" name="meta_titles[]" class="form-control" value="{{ optional($seoInfo)->meta_title }}">
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="meta_descriptions[]">{{ optional($seoInfo)->meta_description }}</textarea>
                                            </td>
                                        </tr>


                                        @php
                                            $seoInfo = $seoInfos->where('page_title', 'Profile')->first();
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="text" readonly class="form-control" name="titles[]" value="Profile">
                                            </td>
                                            <td>
                                                <input type="text" name="alt_texts[]" class="form-control" value="{{ optional($seoInfo)->alt_text }}">
                                            </td>
                                            <td>
                                                <input type="text" name="meta_titles[]" class="form-control" value="{{ optional($seoInfo)->meta_title }}">
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="meta_descriptions[]">{{ optional($seoInfo)->meta_description }}</textarea>
                                            </td>
                                        </tr>


                                        @php
                                            $seoInfo = $seoInfos->where('page_title', 'My Order')->first();
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="text" readonly class="form-control" name="titles[]" value="My Order">
                                            </td>
                                            <td>
                                                <input type="text" name="alt_texts[]" class="form-control" value="{{ optional($seoInfo)->alt_text }}">
                                            </td>
                                            <td>
                                                <input type="text" name="meta_titles[]" class="form-control" value="{{ optional($seoInfo)->meta_title }}">
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="meta_descriptions[]">{{ optional($seoInfo)->meta_description }}</textarea>
                                            </td>
                                        </tr>


                                        @php
                                            $seoInfo = $seoInfos->where('page_title', 'Order Return')->first();
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="text" readonly class="form-control" name="titles[]" value="Order Return">
                                            </td>
                                            <td>
                                                <input type="text" name="alt_texts[]" class="form-control" value="{{ optional($seoInfo)->alt_text }}">
                                            </td>
                                            <td>
                                                <input type="text" name="meta_titles[]" class="form-control" value="{{ optional($seoInfo)->meta_title }}">
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="meta_descriptions[]">{{ optional($seoInfo)->meta_description }}</textarea>
                                            </td>
                                        </tr>


                                        @php
                                            $seoInfo = $seoInfos->where('page_title', 'Wishlist')->first();
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="text" readonly class="form-control" name="titles[]" value="Wishlist">
                                            </td>
                                            <td>
                                                <input type="text" name="alt_texts[]" class="form-control" value="{{ optional($seoInfo)->alt_text }}">
                                            </td>
                                            <td>
                                                <input type="text" name="meta_titles[]" class="form-control" value="{{ optional($seoInfo)->meta_title }}">
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="meta_descriptions[]">{{ optional($seoInfo)->meta_description }}</textarea>
                                            </td>
                                        </tr>


                                        @php
                                            $seoInfo = $seoInfos->where('page_title', 'Product Review')->first();
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="text" readonly class="form-control" name="titles[]" value="Product Review">
                                            </td>
                                            <td>
                                                <input type="text" name="alt_texts[]" class="form-control" value="{{ optional($seoInfo)->alt_text }}">
                                            </td>
                                            <td>
                                                <input type="text" name="meta_titles[]" class="form-control" value="{{ optional($seoInfo)->meta_title }}">
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="meta_descriptions[]">{{ optional($seoInfo)->meta_description }}</textarea>
                                            </td>
                                        </tr>


                                        @php
                                            $seoInfo = $seoInfos->where('page_title', 'Stock Request')->first();
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="text" readonly class="form-control" name="titles[]" value="Stock Request">
                                            </td>
                                            <td>
                                                <input type="text" name="alt_texts[]" class="form-control" value="{{ optional($seoInfo)->alt_text }}">
                                            </td>
                                            <td>
                                                <input type="text" name="meta_titles[]" class="form-control" value="{{ optional($seoInfo)->meta_title }}">
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="meta_descriptions[]">{{ optional($seoInfo)->meta_description }}</textarea>
                                            </td>
                                        </tr>


                                        @php
                                            $seoInfo = $seoInfos->where('page_title', 'Change Password')->first();
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="text" readonly class="form-control" name="titles[]" value="Change Password">
                                            </td>
                                            <td>
                                                <input type="text" name="alt_texts[]" class="form-control" value="{{ optional($seoInfo)->alt_text }}">
                                            </td>
                                            <td>
                                                <input type="text" name="meta_titles[]" class="form-control" value="{{ optional($seoInfo)->meta_title }}">
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="meta_descriptions[]">{{ optional($seoInfo)->meta_description }}</textarea>
                                            </td>
                                        </tr>


                                        @php
                                            $seoInfo = $seoInfos->where('page_title', 'Help')->first();
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="text" readonly class="form-control" name="titles[]" value="Help">
                                            </td>
                                            <td>
                                                <input type="text" name="alt_texts[]" class="form-control" value="{{ optional($seoInfo)->alt_text }}">
                                            </td>
                                            <td>
                                                <input type="text" name="meta_titles[]" class="form-control" value="{{ optional($seoInfo)->meta_title }}">
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="meta_descriptions[]">{{ optional($seoInfo)->meta_description }}</textarea>
                                            </td>
                                        </tr>


                                        @php
                                            $seoInfo = $seoInfos->where('page_title', 'Track Order')->first();
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="text" readonly class="form-control" name="titles[]" value="Track Order">
                                            </td>
                                            <td>
                                                <input type="text" name="alt_texts[]" class="form-control" value="{{ optional($seoInfo)->alt_text }}">
                                            </td>
                                            <td>
                                                <input type="text" name="meta_titles[]" class="form-control" value="{{ optional($seoInfo)->meta_title }}">
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="meta_descriptions[]">{{ optional($seoInfo)->meta_description }}</textarea>
                                            </td>
                                        </tr>


                                        @php
                                            $seoInfo = $seoInfos->where('page_title', 'Supplier Your Product')->first();
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="text" readonly class="form-control" name="titles[]" value="Supplier Your Product">
                                            </td>
                                            <td>
                                                <input type="text" name="alt_texts[]" class="form-control" value="{{ optional($seoInfo)->alt_text }}">
                                            </td>
                                            <td>
                                                <input type="text" name="meta_titles[]" class="form-control" value="{{ optional($seoInfo)->meta_title }}">
                                            </td>
                                            <td>
                                                <textarea class="form-control" name="meta_descriptions[]">{{ optional($seoInfo)->meta_description }}</textarea>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
