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
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.consultationFormEdit', ['odd_id' => base64_encode($order_detail_id)]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="odd_id" value="{{ base64_encode($order_detail_id) }}">

                            <div class="form-section">
                                <div class="section-header">
                                    <h4>Generic Consultation</h4>
                                </div>

                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Question ID</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Answer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($generic_consultation as $val)
                                        <tr>
                                            <td style="text-align: center;">#{{$val['id']}}</td>
                                            <td>{{ $val['title'] }}</td>
                                            <td>{{ $val['desc'] }}</td>
                                            <td>
                                                @if(is_array($val['answer']))
                                                    <!-- Handle array answers (like weight questions) -->
                                                    @foreach($val['answer'] as $key => $answer)
                                                        @if($answer !== null)
                                                            <div>
                                                                <label for="answers[generic][{{$val['id']}}][{{$key}}]">{{ ucfirst($key) }}</label>
                                                                <input type="text" name="answers[generic][{{$val['id']}}][{{$key}}]" class="form-control" value="{{ $answer }}">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <!-- For non-array answers, use a single textarea -->
                                                    <textarea name="answers[generic][{{$val['id']}}]" class="form-control">{{ $val['answer'] }}</textarea>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-section">
                                <div class="section-header">
                                    <h4>Product Consultation</h4>
                                </div>

                                @if($product_consultation && count($product_consultation) > 0)
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Question ID</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Answer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($product_consultation as $value)
                                        <tr>
                                            <td style="text-align: center;">#{{$value['id']}}</td>
                                            <td>{{$value['title']}}</td>
                                            <td>{{$value['desc']}}</td>
                                            <td>
                                                <textarea name="answers[product][{{$value['id']}}]" class="form-control">{{ $value['answer'] }}</textarea>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                            </div>

                            <!-- New Product Questions (highlighted) -->
                            @foreach($new_product_questions as $new_question)
                                {{-- <div class="form-section new-question" style="background-color: #fff3f3; border-left: 5px solid #ff1744;">
                                    <h4><i class="bi bi-exclamation-triangle-fill" style="color: #ff1744;"></i> New Required Question</h4>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Question ID</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Answer</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="text-align: center;">#{{$new_question->id}}</td>
                                                <td><strong style="color: #d32f2f;">{{ $new_question->title }}</strong></td>
                                                <td>{{ $new_question->desc }}</td>
                                                <td>
                                                    <textarea name="answers[product][{{$new_question->id}}]" class="form-control" required style="border: 2px solid #f44336; background-color: #fff0f0;"></textarea>
                                                    <div class="mandatory-message" style="color: #f44336; font-weight: bold;">*This question is mandatory</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div> --}}

                                <!-- Image Upload for Question #800 -->
                                @if($new_question->id == 800)  
                                <div class="form-group" style="border: 2px solid #f44336; background-color: #fff0f0; padding: 10px; margin-bottom:1rem">
                                    <label for="image_800" class="required" style="color: #f44336;">Please Upload A Picture Of Your Torso To Verify Your Full Body Shot</label>
                                    <input type="file" name="image_800" class="form-control" accept="image/*" required>
                                </div>
                                @endif
                            @endforeach

                         <!-- Image Upload for Question #607 and #800 -->
                    @if($requires_image_upload_607 || $requires_image_upload_800)
                    <div class="form-section" style="background-color: #fff3f3;">
                        <div class="section-header">
                            <h4><i class="bi bi-image-fill" style="color: #ff1744;"></i> Image Upload</h4>
                        </div>

                        @if($requires_image_upload_607)
                        <div class="form-group" style="border: 2px solid #f44336; background-color: #fff0f0; padding: 10px; display: flex; justify-content: space-between;">
                            <label for="image_607" class="required" style="color: #f44336; width: 70%;">Please Upload The Picture (clearly Displaying The Weight On The Scales)</label>
                            <div style="width: 25%; display: flex; align-items: center; justify-content: center; padding-left: 10px;">
                                <input type="file" name="image_607" class="form-control image-upload" accept="image/*" required>
                                <div id="preview_607" style="max-width: 100px; margin-top: 10px;"></div>
                            </div>
                        </div>
                        @endif

                        @if($requires_image_upload_800)
                        <div class="form-group" style="border: 2px solid #f44336; background-color: #fff0f0; padding: 10px; margin-bottom: 1rem; display: flex; justify-content: space-between;">
                            <label for="image_800" class="required" style="color: #f44336; width: 70%;">Please Upload A Picture Of Your Torso To Verify Your Full Body Shot</label>
                            <div style="width: 25%; display: flex; align-items: center; justify-content: center; padding-left: 10px;">
                                <input type="file" name="image_800" class="form-control image-upload" accept="image/*" required>
                                <div id="preview_800" style="max-width: 100px; margin-top: 10px;"></div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif


                            <!-- Submit Button -->
                            <div class="form-section" style="padding: 10px 20px; background-color:#eff7ee; border-radius: 5px; font-weight: bold; font-size: 16px; cursor: pointer;">
                                <button type="submit" class="btn btn-primary" style="padding: 10px 20px; background-color:#198754; border-radius: 5px; font-weight: bold; font-size: 16px; cursor: pointer;">Update Consultation</button>
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
    @pushOnce('scripts')
<script>
    $(document).ready(function() {
        // Image upload preview handler
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.src = e.target.result;
                    preview.innerHTML = '';  // Clear previous preview
                    preview.appendChild(img);
                    img.style.maxWidth = '100%';  // Ensure the image fits the container
                    img.style.border = '1px solid #ddd'; // Optional styling for preview
                    img.style.marginTop = '10px'; // Add some margin
                }
                reader.readAsDataURL(file);
            }
        }

        // Attach event listeners to file inputs for image preview
        $('input[type="file"].image-upload').on('change', function() {
            const inputId = $(this).attr('name');
            if (inputId === 'image_607') {
                previewImage(this, 'preview_607');
            } else if (inputId === 'image_800') {
                previewImage(this, 'preview_800');
            }
        });
    });
</script>
@endpushOnce

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
