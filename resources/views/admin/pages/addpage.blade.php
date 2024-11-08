@extends('admin.layouts.default')
@section('title', 'Add Page')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Add Page</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Home</a></li>
                        <li class="breadcrumb-item active">All Pages</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-9">
                            <!-- page Information -->
                            <div class="card ">
                                <div class="card-header">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h5 class="mb-0">Page Information</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="prin_title">Title</label>
                                                <input type="text" name="title" id="prin_title" class="form-control" placeholder="Enter Title" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Content:</label>
                                                <span id="error_desc" class="text-danger d-none text-smaller error-msg"> * please wirte description</span>
                                                <textarea name="desc" id="prin_desc" class="form-control summernote" rows="5" placeholder="Enter Description" required>
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Custom SEO -->
                            <div class="card mt-3">
                                <div class="card-header row">
                                    <div class="col-md-6">
                                        <h4 class="card-title">Custom SEO</h4>
                                    </div>
                                    <div class="col-md-6 text-right"><a href="javascript:void(0)" class="custom-seo"><i class="fa fa-edit"></i> Custom SEO </a></div>
                                </div>
                                <div class="card-body">
                                    <div class="box-custom-seo box-hidden">
                                        <div class="form-group">
                                            <label for="meta_title" class="form-label">Title</label>
                                            <input type="text" name="meta_title" id="meta_title" class="form-control" value="" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_description" class="form-label">Description</label>
                                            <textarea name="meta_description" id="meta_description" class="form-control" rows="4" autocomplete="off"></textarea>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="seo-review">
                                        <h5>Preview</h5>
                                        <div class="review-title"></div>
                                        <div class="review-url text-primary">
                                            <a href="http://127.0.0.1:8000/"> http://127.0.0.1:8000/</a>
                                            <span></span>
                                        </div>
                                        <div class="review-description"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <!-- pagee statuses  -->
                            <div class="card ">
                                <div class="card-header">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h5 class="mb-0">Status</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <select name="status" id="pages-status" class="form-control">
                                            <option value="publish">Publish</option>
                                            <option value="private">Private</option>
                                            <option value="draft">Draft</option>
                                            <option value="trash">Trash</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary bg-primary btn-block" value="Apply">
                                    </div>
                                </div>
                            </div>
                            <!-- choose templates  -->
                            <div class="card ">
                                <div class="card-header">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h5 class="mb-0">Choose Template</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <select name="status" id="page-template" class="form-control">
                                            <option value="publish">Home</option>
                                            <option value="private">Out Reach</option>
                                            <option value="private">Secotors</option>
                                            <option value="private">Membership</option>
                                            <option value="private">Opportuniies</option>
                                            <option value="draft">other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-primary bg-primary btn-block" value="Apply">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="akjzzw-slug">Slug</label>
                                <div class="input-group">
                                    <input type="text" name="slug" class="form-control " id="akjzzw-slug" value="" autocomplete="off" data-max-length="150" readonly="">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <a href="javascript:void(0)" class="slug-edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>

        </div>
    </div>
    <!-- /.content-wrapper -->
</div>
@stop

@pushOnce('scripts')
<script>

</script>
@endPushOnce