@extends('admin.layouts.default')
@section('title', 'Order Consultations')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>
            <a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold">
                <i class="bi bi-arrow-left"></i> Back
            </a> | Order Consultations
        </h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.consultationFormEdit', ['odd_id' => base64_encode($order_detail_id)]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="odd_id" value="{{ base64_encode($order_detail_id) }}">
                        
                            <table id="tbl_data" class="table table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th style="vertical-align: middle; text-align: center;">Question ID</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Answer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Generic Consultation -->
                                    <tr>
                                        <td></td>
                                        <td class="fw-bold text-center" style="background-color:aquamarine !important;">Generic Consultation</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach($generic_consultation as $val)
                                    <tr>
                                        <td style="vertical-align: middle; text-align: center;">#{{$val['id']}}</td>
                                        <td>{{$val['title']}}</td>
                                        <td>{{$val['desc']}}</td>
                                        <td>
                                            <textarea name="answers[generic][{{$val['id']}}]" class="form-control">{{ $val['answer'] }}</textarea>
                                        </td>
                                    </tr>
                                    @endforeach
                        
                                    <!-- Product Consultation -->
                                    @if($product_consultation && count($product_consultation) > 0)
                                    <tr>
                                        <td></td>
                                        <td class="fw-bold text-center" style="background-color:aquamarine !important;">Product Consultation</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach($product_consultation as $value)
                                    <tr>
                                        <td style="vertical-align: middle; text-align: center;">#{{$value['id']}}</td>
                                        <td>{{$value['title']}}</td>
                                        <td>{{$value['desc']}}</td>
                                        <td>
                                            <textarea name="answers[product][{{$value['id']}}]" class="form-control">{{ $value['answer'] }}</textarea>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        
                            <!-- Image Upload -->
                            @if($requires_image_upload) <!-- Show this input if image upload is required -->
                            <div class="form-group">
                                <label for="image" style="color: red; font-size: 16px; font-weight: bold;">Please Upload The Picture (clearly Displaying The Weight On The Scales)</label>
                                <input type="file" name="image" class="form-control" accept="image/*" required>
                            </div>
                            @endif
                        
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary" style="color: blue">Update Consultation</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@stop

@pushOnce('scripts')
<script>
    $(document).ready(function() {
        $('.read-more-btn').click(function() {
            var $descriptionPreview = $(this).siblings('.description-preview');
            var $descriptionFull = $(this).siblings('.description-full');

            if ($descriptionPreview.is(':visible')) {
                $descriptionPreview.hide();
                $descriptionFull.show();
                $(this).removeClass('btn-primary').addClass('read-less-btn').text('Read Less');
            } else {
                $descriptionPreview.show();
                $descriptionFull.hide();
                $(this).removeClass('read-less-btn').addClass('btn-primary').text('Read More');
            }
        });
    });
</script>
@endPushOnce
