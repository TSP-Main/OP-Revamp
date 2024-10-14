@extends('admin.layouts.default')
@section('title', 'Add P Med Question')
@section('content')
<style>
    .select2-selection__rendered {
        line-height: 35px !important;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    .select2-selection__arrow {
        height: 40px !important;
    }

    .btn_theme {
        background: #03bd8d;
        border: #03bd8d 1px solid;
    }

    .hide {
        display: none;
    }
</style>
<!-- main stated -->
<main id="main" class="main">

    <div class="pagetitle">
        <h1<a href="javascript:void(0);" onclick="window.history.back();" class="btn btn-primary-outline fw-bold "><i class="bi bi-arrow-left"></i> Back</a> | Add P Med Question</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Add P Med Question</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <!-- Multi Columns Form -->
                        <form class="row g-3 mt-3 needs-validation" method="post" action="{{ route('admin.storePMedQuestion') }}" novalidate>
                            @csrf
                            <input type="hidden" name="id" id="question_id" value="{{ $question['id'] ?? ''}}">

                            <div class="col-md-12">
                                <label for="name" class="form-label fw-bold">Title</label>
                                <input type="text" name="title" value="{{  $question['title'] ?? old('title') }}" class="form-control" id="title" required>
                                <div class="invalid-feedback">Please enter question title!</div>
                                @error('name')
                                <div class="alert-danger text-danger ">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="desc" class="form-label fw-bold">Description <small>(Optional)</small></label>
                                <textarea name="desc" class="form-control tinymce-editor" cols="10" rows="3" id="desc"> {!! $question['desc'] ?? old('desc') !!} </textarea>
                                @error("desc")
                                <div class="alert-danger text-danger ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="anwser_set" class="form-label fw-bold">Answer Set</label>
                                <select class="form-select" name="anwser_set" id="anwser_set" required>
                                    <option value="yes_no" {{ (($question['anwser_set'] ?? old('anwser_set')) == 'yes_no') ? 'selected' : '' }}>Yes or No</option>
                                    <option value="mt_choice" {{ ($question['anwser_set'] ?? old('anwser_set')) == 'mt_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                    <option value="openbox" {{ ($question['anwser_set'] ?? old('anwser_set')) == 'openbox' ? 'selected' : '' }}>Input Box</option>
                                    <option value="file" {{ ($question['anwser_set'] ?? old('anwser_set')) == 'file' ? 'selected' : '' }}>File</option>
                                </select>
                                <div class="invalid-feedback">Please select anser Set!</div>
                                @error('anwser_set')
                                <div class="alert-danger text-danger ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 ">
                                <label for="type" class="form-label fw-bold">Type</label>
                                <select class="form-select" name="type" id="type" required>
                                    <option value="non_dependent" {{ (($question['tyoe'] ?? old('non_dependent')) == 'non_dependent') ? 'selected' : '' }}>Non Dependent</option>
                                    <option value="dependent" {{ ($question['type'] ?? old('dependent')) == 'dependent' ? 'selected' : '' }}>Dependent</option>
                                </select>
                                <div class="invalid-feedback">Please select question type!</div>
                                @error('anwser_set')
                                <div class="alert-danger text-danger ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2 order {{ ($question['type'] ?? old('dependent')) == 'dependent' ? 'd-none' : '' }}">
                                <label for="order" class="form-label fw-bold">Order</label>
                                <input type="text" name="order" value="{{  $question['order'] ?? old('order') }}" class="form-control" id="order" {{ ($question['type'] ?? old('dependent')) != 'dependent' ? 'required' : '' }}>
                                <div class="invalid-feedback">Please enter question order!</div>
                                @error('order')
                                <div class="alert-danger text-danger ">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="ansewers row px-0 mx-0  mt-3"></div>

                            <div class="col-md-5">
                                <label for="is_assigned" class="form-label fw-bold">Assign Next Questions</label>
                                <select class="form-select" name="is_assigned" id="is_assigned" required>
                                    <option value="no" {{ ($question['is_assigned'] ?? old('is_assigned')) == 'no' ? 'selected' : '' }}>No</option>
                                    <option value="yes" {{ ($question['is_assigned'] ?? old('is_assigned')) == 'yes' ? 'selected' : '' }}>Yes</option>
                                </select>
                                <div class="invalid-feedback">Please select whether to assign next questions or not!</div>
                                @error('is_assigned')
                                <div class="alert-danger text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-3 next-questions hide py-3">
                                <div id="no_dp_question" class="empty hide">
                                    <div class="col-md-12 mx-auto text-center btn py-3 text-danger border border-danger mt-2 ">
                                        <label class="  py-2 fw-bold">No Depenedent Questions Avialable <small>(add first)</small></label>
                                    </div>
                                </div>
                                <div id="option_id" class="question">
                                    <div class="col-md-2">
                                        <label class=" text-center px-5 col-form-label fw-bold btn text-danger">
                                            Option...
                                    </div>
                                    <div class="col-md-10 mt-choice hide ">
                                        <div class="row mt-2">
                                            <div class="col-md-4 mb-2">
                                                <label for="next_quest_optA_next_type" class=" text-center px-5 col-form-label fw-bold btn btn-outline-secondary" onclick="focusDropdown('optionA')">
                                                    Option A
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-select select_option mb-2" name="next_quest[optA][next_type]" id="next_quest_optA_next_type">
                                                    <option value="nothing" {{ old('next_quest.optA.next_type') == 'nothing' ? 'selected' : '' }}>Nothing to Next</option>
                                                    <option value="question" {{ old('next_quest.optA.next_type') == 'question' ? 'selected' : '' }}>Nested Question</option>
                                                    <option value="alert" {{ old('next_quest.optA.next_type') == 'alert' ? 'selected' : '' }}>Show alert</option>
                                                </select>
                                                <!-- <div class="invalid-feedback">Please select a next display!</div>
                                                @error('next_quest.optA.next_type')
                                                <div class="alert-danger text-danger">{{ $message }}</div>
                                                @enderror -->

                                                <div class="display_option ps-5 mt-2">
                                                    <div class="row mb-2 pt-1 neseted_question hide">
                                                        <div class="col-md-12">
                                                            <select id="optionA" class="form-select optA" name="next_quest[optA][question]">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 pt-1 show_alert hide">
                                                        <div class="col-md-4 mb-2">
                                                            <select class="form-select  py-2" name="next_quest[optA][alert_type]" id="alert_type">
                                                                <option value="alert-success">Success</option>
                                                                <option value="alert-warning">Warning</option>
                                                                <option value="alert-danger">Danger</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control" name="next_quest[optA][alert_msg]" placeholder="alert message"> </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4 mb-2">
                                                <label for="next_quest_optB_next_type" class=" text-center px-5 col-form-label fw-bold btn btn-outline-secondary" onclick="focusDropdown('optionB')">
                                                    Option B
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-select  select_option mb-2" name="next_quest[optB][next_type]" id="next_quest_optB_next_type">
                                                    <option value="nothing">Nothing to Next</option>
                                                    <option value="question">Nested Question</option>
                                                    <option value="alert">Show alert</option>
                                                </select>
                                                <div class="display_option ps-5 mt-2">
                                                    <div class="row mb-2 pt-1 neseted_question hide">
                                                        <div class="col-md-12">
                                                            <select id="optionB" class="form-select optB" name="next_quest[optB][question]">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 pt-1 show_alert hide">
                                                        <div class="col-md-4 mb-2">
                                                            <select class="form-select py-2" name="next_quest[optB][alert_type]" id="alert_type">

                                                                <option value="alert-success">Success</option>
                                                                <option value="alert-warning">Warning</option>
                                                                <option value="alert-danger">Danger</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control" name="next_quest[optB][alert_msg]" placeholder="alert message"> </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4 mb-2">
                                                <label for="optionC" class=" text-center px-5 col-form-label fw-bold btn btn-outline-secondary" onclick="focusDropdown('optionC')">
                                                    Option C
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-select  select_option mb-2" name="next_quest[optC][next_type]" id="next_quest[optC][next_type]">
                                                    <option value="nothing">Nothing to Next</option>
                                                    <option value="question">Nested Question</option>
                                                    <option value="alert">Show alert</option>
                                                </select>
                                                <div class="display_option ps-5 mt-2">
                                                    <div class="row mb-2 pt-1 neseted_question hide">
                                                        <div class="col-md-12">
                                                            <select id="optionC" class="form-select optC" name="next_quest[optC][question]"></select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 pt-1 show_alert hide">
                                                        <div class="col-md-4 mb-2">
                                                            <select class="form-select py-2" name="next_quest[optC][alert_type]" id="alert_type">
                                                                <option value="alert-success">Success</option>
                                                                <option value="alert-warning">Warning</option>
                                                                <option value="alert-danger">Danger</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control" name="next_quest[optC][alert_msg]" placeholder="alert message"> </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4 mb-2">
                                                <label for="optionD" class=" text-center px-5 col-form-label fw-bold btn btn-outline-secondary" onclick="focusDropdown('optionD')">
                                                    Option D
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-select  select_option mb-2" name="next_quest[optD][next_type]" id="next_quest[optD][next_type]">
                                                    <option value="nothing">Nothing to Next</option>
                                                    <option value="question">Nested Question</option>
                                                    <option value="alert">Show alert</option>
                                                </select>
                                                <div class="display_option ps-5 mt-2">
                                                    <div class="row mb-2 pt-1 neseted_question hide">
                                                        <div class="col-md-12">
                                                            <select id="optionD" class="form-select optD" name="next_quest[optD][question]"></select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 pt-1 show_alert hide">
                                                        <div class="col-md-4 mb-2">
                                                            <select class="form-select py-2" name="next_quest[optD][alert_type]" id="alert_type">
                                                                <option value="alert-success">Success</option>
                                                                <option value="alert-warning">Warning</option>
                                                                <option value="alert-danger">Danger</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control" name="next_quest[optD][alert_msg]" placeholder="alert message"> </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- yes no --}}
                                    <div class="col-md-10 yes-no hide">
                                        <div class="row mt-2">
                                            <div class="col-md-4 mb-2">
                                                <label for="next_quest_optY_next_type" class=" text-center px-5 col-form-label fw-bold btn btn-outline-secondary" onclick="focusDropdown('optionYes')">
                                                    YES
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <select id="select_optionYes" class="form-select  select_option mb-2" name="next_quest[optY][next_type]" id="next_quest_optY_next_type">
                                                    <option value="nothing">Nothing to Next</option>
                                                    <option value="question">Nested Question</option>
                                                    <option value="alert">Show alert</option>
                                                </select>
                                                <div class="display_option ps-5 mt-2">
                                                    <div class="row mb-2 pt-1 neseted_question hide">
                                                        <div class="col-md-12">
                                                            <select id="optionYes" class="form-select optY" name="next_quest[optY][question]"></select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 pt-1 show_alert hide">
                                                        <div class="col-md-4 mb-2">
                                                            <select class="form-select  py-2" name="next_quest[optY][alert_type]" id="next_quest[optY][alert_type]">
                                                                <option value="alert-success">Success</option>
                                                                <option value="alert-warning">Warning</option>
                                                                <option value="alert-danger">Danger</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control" name="next_quest[optY][alert_msg]" placeholder="alert message"> </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-4 mb-2">
                                                <label for="next_quest_optN_next_type" id="option_no" class=" text-center px-5 col-form-label fw-bold btn btn-outline-secondary" onclick="focusDropdown('optionNo')">
                                                    NO
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-select mb-2 select_option " name="next_quest[optN][next_type]" id="next_quest_optN_next_type">
                                                    <option value="nothing">Nothing to Next</option>
                                                    <option value="alert">Show alert</option>
                                                    <option value="question">Nested Question</option>
                                                </select>
                                                <div class="display_option mt-2 ps-5">
                                                    <div class="row mb-2  pt-1 neseted_question  hide">
                                                        <div class="col-md-12">
                                                            <select id="optionNo" class="form-select optN" name="next_quest[optN][question]">
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2  pt-1 show_alert hide">
                                                        <div class="col-md-4 mb-2">
                                                            <select class="form-select py-2 " name="next_quest[optN][alert_type]" id="next_quest_optN_alert_type">
                                                                <option value="alert-success">Success</option>
                                                                <option value="alert-warning">Warning</option>
                                                                <option value="alert-danger">Danger</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control" name="next_quest[optN][alert_msg]" placeholder="alert message"> </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- openbox --}}
                                    <div class="col-md-10 open-box hide">
                                        <div class="row mt-2">
                                            <div class="col-md-4 mb-2">
                                                <label for="openBox" class=" text-center px-5 col-form-label fw-bold btn btn-outline-secondary" onclick="focusDropdown('openBox')">
                                                    Next Question
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-select  select_option mb-2" name="next_quest[openBox][next_type]" id="next_quest[openBox][next_type]">
                                                    <option value="nothing">Nothing to Next</option>
                                                    <option value="question">Nested Question</option>
                                                    <option value="alert">Show alert</option>
                                                </select>
                                                <div class="display_option ps-5 mt-2">
                                                    <div class="row mb-2 pt-1 neseted_question hide">
                                                        <div class="col-md-12">
                                                            <select id="openBox" class="form-select openBox" name="next_quest[openBox][question]"></select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 pt-1 show_alert hide">
                                                        <div class="col-md-4 mb-2">
                                                            <select class="form-select py-2" name="next_quest[openBox][alert_type]" id="next_quest[openBox][alert_type]">

                                                                <option value="alert-success">Success</option>
                                                                <option value="alert-warning">Warning</option>
                                                                <option value="alert-danger">Danger</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control" name="next_quest[openBox][alert_msg]" placeholder="alert message"> </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- file --}}
                                    <div class="col-md-10 file hide">
                                        <div class="row mt-2">
                                            <div class="col-md-4 mb-2">
                                                <label for="file" class=" text-center px-5 col-form-label fw-bold btn btn-outline-secondary" onclick="focusDropdown('file')">
                                                    Next Question
                                                </label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-select  select_option mb-2" name="next_quest[file][next_type]" id="next_quest[file][next_type]">
                                                    <option value="nothing">Nothing to Next</option>
                                                    <option value="question">Nested Question</option>
                                                    <option value="alert">Show alert</option>
                                                </select>
                                                <div class="display_option ps-5 mt-2">
                                                    <div class="row mb-2 pt-1 neseted_question hide">
                                                        <div class="col-md-12">
                                                            <select id="file" class="form-select file" name="next_quest[file][question]"></select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2 pt-1 show_alert hide">
                                                        <div class="col-md-4 mb-2">
                                                            <select class="form-select py-2" name="next_quest[file][alert_type]" id="next_quest[file][alert_type]">

                                                                <option value="alert-success">Success</option>
                                                                <option value="alert-warning">Warning</option>
                                                                <option value="alert-danger">Danger</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control" name="next_quest[file][alert_msg]" placeholder="alert message"> </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="text-center mt-4 mb-3 d-flex justify-content-center ">
                                <button type="reset" class="btn btn-secondary px-5 py-2 mx-2 fw-bold">Reset</button>
                                <button type="submit" class="btn btn-success px-5 py-2 btn_theme fw-bold">Submit</button>
                            </div>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main>
<!-- End #main -->

@stop

@pushOnce('scripts')
<script>
    $(document).ready(function() {
        var anserset = $('#anwser_set').val();
        var questionId = $('#question_id').val();
        if (questionId) {
            let assigned = $('#is_assigned').val();
            if (assigned === 'yes') {
                let cate_Id = $('#category_id').val();
                get_question_detail(questionId, cate_Id);
            }
        }
        getoptions(anserset);

        $('.select_option').change(function() {
            var selectedValue = $(this).val();
            var parentDiv = $(this).closest('.col-md-8').find('.display_option');
            console.log(parentDiv);
            if (selectedValue === 'question') {
                parentDiv.find('.neseted_question').removeClass('hide');
                parentDiv.find('.show_alert').addClass('hide');
            } else if (selectedValue === 'alert') {
                parentDiv.find('.show_alert').removeClass('hide');
                parentDiv.find('.neseted_question').addClass('hide');
            } else if (selectedValue === 'nothing') {
                parentDiv.find('.neseted_question').addClass('hide');
                parentDiv.find('.show_alert').addClass('hide');
            }
        });

        $('#type').on('change', function() {
            let type = $(this).val();
            if (type === 'dependent') {
                $('.order').addClass('d-none');
                $('#order').removeAttr('required').val('');
            } else {
                $('.order').removeClass('d-none');
                $('#order').prop('required', true).val('');
            }
        });

        $('#anwser_set').on('change', function() {
            let anwser_set = $(this).val();
            let assigned = $('#is_assigned').val();
            if (assigned === 'yes') {
                let cate_id = $('#category_id').val();
                if (cate_id) {
                    $('.next-questions').slideDown('slow', function() {
                        $(this).removeClass('hide');
                    });

                    get_dp_question(cate_id, anwser_set);
                } else {
                    alert('please Select answer select');
                }
            }
            getoptions(anwser_set);

        });

        function getoptions(anserset = 'mt_choice') {
            let optAValue = "{{ $question['optA'] ?? old('optA') }}";
            let optBValue = "{{ $question['optB'] ?? old('optB') }}";
            let optCValue = "{{ $question['optC'] ?? old('optC') }}";
            let optDValue = "{{ $question['optD'] ?? old('optD') }}";
            let yesLableValue = "{{ (isset($question['yes_lable'])) ? $question['yes_lable'] : old('yes_lable') ?? 'Yes' }}";
            let noLableValue = "{{ (isset($question['no_lable'])) ? $question['no_lable'] : old('no_lable') ?? 'No' }}";
            if (anserset == 'mt_choice') {
                $('.ansewers').html('<div class="col-md-6 mb-3">' +
                    '<label for="optA" class="form-label fw-semibold ">Option A</label>' +
                    '<input type="text" name="optA" value="' + optAValue + '" class="form-control" id="optA" required>' +
                    '<div class="invalid-feedback">Please enter option A title!</div>' +
                    '@error("optA")' +
                    '<div class="alert-danger text-danger ">{{ $message }}</div>' +
                    '@enderror' +
                    '</div>' +

                    '<div class="col-md-6 mb-3">' +
                    '<label for="optB" class="form-label fw-semibold">Option B</label>' +
                    '<input type="text" name="optB" value="' + optBValue + '" class="form-control" id="optB" required>' +
                    '<div class="invalid-feedback">Please enter option B!</div>' +
                    '@error("optB")' +
                    '<div class="alert-danger text-danger ">{{ $message }}</div>' +
                    '@enderror' +
                    '</div>' +

                    '<div class="col-md-6 mb-3">' +
                    '<label for="optC" class="form-label fw-semibold">Option C</label>' +
                    '<input type="text" name="optC" value="' + optCValue + '" class="form-control" id="optC" required>' +
                    '<div class="invalid-feedback">Please enter option C!</div>' +
                    '@error("optC")' +
                    '<div class="alert-danger text-danger ">{{ $message }}</div>' +
                    '@enderror' +
                    '</div>' +

                    '<div class="col-md-6 mb-3">' +
                    '<label for="optD" class="form-label fw-semibold">Option D</label>' +
                    '<input type="text" name="optD" value="' + optDValue + '" class="form-control" id="optD" required>' +
                    '<div class="invalid-feedback">Please enter option D!</div>' +
                    '@error("optD")' +
                    '<div class="alert-danger text-danger ">{{ $message }}</div>' +
                    '@enderror' +
                    '</div>');
            } else if (anserset == 'yes_no') {
                $('.ansewers').html('<div class="col-md-6 mb-3">' +
                    '<label for="yes_lable" class="form-label fw-semibold">Yes Answer Label</label>' +
                    '<input type="text" name="yes_lable" value="' + yesLableValue + '" class="form-control" id="yes_lable" required>' +
                    '<div class="invalid-feedback">Please write Yes label!</div>' +
                    '@error("yes_lable")' +
                    '<div class="alert-danger text-danger ">{{ $message }}</div>' +
                    '@enderror' +
                    '</div>' +

                    '<div class="col-md-6 mb-3">' +
                    '<label for="no_lable" class="form-label fw-semibold">No Answer Label</label>' +
                    '<input type="text" name="no_lable" value="' + noLableValue + '" class="form-control" id="no_lable" required>' +
                    '<div class="invalid-feedback">Please write No label!</div>' +
                    '@error("no_lable")' +
                    '<div class="alert-danger text-danger ">{{ $message }}</div>' +
                    '@enderror' +
                    '</div>');
            } else if (anserset == 'openbox') {
                $('.ansewers').html('');
            } else if (anserset == 'file') {
                $('.ansewers').html('');
            } else {
                alert('Select the correct answer set');
            }
        }

        $('#is_assigned, #category_id', ).on('change', function() {
            $('#message').text('');
            let assigned = $('#is_assigned').val();
            if (assigned === 'yes') {
                let cate_id = $('#category_id').val();

                    let anwser_set = $('#anwser_set').val();
                    if (anwser_set) {
                        $('.next-questions').slideDown('slow', function() {
                            $(this).removeClass('hide');
                        });

                        get_dp_question(cate_id, anwser_set);
                    } else {
                        alert('please Select answer select');
                    }

            } else {
                $('.next-questions').slideUp('slow');
                $('.next-questions').addClass('hide');
            }
        });

        function get_dp_question(categoryId, rp_option) {
            var reply_option = rp_option;
            // Make AJAX request

                if (reply_option) {
                    $.ajax({
                        url: '{{ route("admin.getPMedDp_questions") }}',
                        type: 'GET',
                        data: {
                            cat_id: categoryId
                        },
                        success: function(response) {
                            let dp_qeusionts = response.result.dp_qstn;

                            console.log(dp_qeusionts);
                            $('#optionA').empty();
                            $('#optionB').empty();
                            $('#optionC').empty();
                            $('#optionD').empty();
                            $('#optionYes').empty();
                            $('#optionNo').empty();
                            $('#openBox').empty();
                            $('#file').empty();
                            $('#no_dp_question').addClass('hide');
                            $('#option_id').removeClass('hide');

                            if (response.status == 'success') {
                                if (reply_option == 'mt_choice') {
                                    $('.mt-choice').removeClass('hide');
                                    $('.yes-no').addClass('hide');
                                    $('.open-box').addClass('hide');
                                    $('.file').addClass('hide');
                                    $.each(response.result.dp_qstn, function(key, value) {
                                        $('#optionA').append($('<option>', {
                                            value: key,
                                            text: value
                                        }));
                                        $('#optionB').append($('<option>', {
                                            value: key,
                                            text: value
                                        }));
                                        $('#optionC').append($('<option>', {
                                            value: key,
                                            text: value
                                        }));
                                        $('#optionD').append($('<option>', {
                                            value: key,
                                            text: value
                                        }));
                                    });
                                } else if (reply_option == 'yes_no') {
                                    $('.mt-choice').addClass('hide');
                                    $('.open-box').addClass('hide');
                                    $('.yes-no').removeClass('hide');
                                    $('.file').addClass('hide');
                                    $.each(response.result.dp_qstn, function(key, value) {
                                        $('#optionYes').append($('<option>', {
                                            value: key,
                                            text: value
                                        }));
                                        $('#optionNo').append($('<option>', {
                                            value: key,
                                            text: value
                                        }));
                                    });
                                } else if (reply_option == 'openbox') {
                                    $('.mt-choice').addClass('hide');
                                    $('.yes-no').addClass('hide');
                                    $('.open-box').removeClass('hide');
                                    $('.file').addClass('hide');

                                    $.each(response.result.dp_qstn, function(key, value) {
                                        $('#openBox').append($('<option>', {
                                            value: key,
                                            text: value
                                        }));

                                    });
                                } else if (reply_option == 'file') {
                                    $('.mt-choice').addClass('hide');
                                    $('.yes-no').addClass('hide');
                                    $('.open-box').addClass('hide');
                                    $('.file').removeClass('hide');

                                    $.each(response.result.dp_qstn, function(key, value) {
                                        $('#file').append($('<option>', {
                                            value: key,
                                            text: value
                                        }));

                                    });
                                }
                                $('#optionA, #optionB, #optionC, #optionD, #optionYes, #optionNo, #openBox, #file').prepend($('<option>', {
                                    value: '',
                                    text: 'Select next Question',
                                    selected: true,
                                }));

                                $.each(response.result.dependant_question, function(key, value) {
                                    // for checking next assign question
                                    var className = value.answer;
                                    var selectedItem = value.next_question;
                                    $('.' + className).val(selectedItem);
                                });
                            } else {
                                $('#no_dp_question').removeClass('hide');
                                $('#option_id').addClass('hide');
                            }

                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                } else {
                    alert('please select answer Set first');
                }


        }

        function get_question_detail(questionId, category_Id) {
            // Make AJAX request
            $.ajax({
                url: '{{ route("admin.qustionDetail") }}',
                type: 'GET',
                data: {
                    id: questionId,
                    categoryId: category_Id
                },
                success: function(response) {
                    var reply_option = response.result.detail.anwser_set;
                    question_yes = response.result.detail.yes_lable ?? 'Yes';
                    question_no = response.result.detail.no_lable ?? 'No';
                    $('#optionA').empty();
                    $('#optionB').empty();
                    $('#optionC').empty();
                    $('#optionD').empty();
                    $('#optionYes').empty();
                    $('#optionNo').empty();
                    $('#openBox').empty();
                    $('#file').empty();
                    $('#option_no').text(question_no)
                    $('#option_yes').text(question_yes)
                    $('#no_dp_question').addClass('hide');
                    $('#option_id').removeClass('hide');

                    if (response.status == 'success') {
                        if (reply_option == 'mt_choice') {
                            $('.mt-choice').removeClass('hide');
                            $('.yes-no').addClass('hide');
                            $('.open-box').addClass('hide');
                            $('.file').addClass('hide');
                            $.each(response.result.other_qstn, function(key, value) {
                                $('#optionA').append($('<option>', {
                                    value: key,
                                    text: value
                                }));
                                $('#optionB').append($('<option>', {
                                    value: key,
                                    text: value
                                }));
                                $('#optionC').append($('<option>', {
                                    value: key,
                                    text: value
                                }));
                                $('#optionD').append($('<option>', {
                                    value: key,
                                    text: value
                                }));
                            });
                        } else if (reply_option == 'yes_no') {
                            $('.mt-choice').addClass('hide');
                            $('.open-box').addClass('hide');
                            $('.yes-no').removeClass('hide');
                            $('.file').addClass('hide');
                            $.each(response.result.other_qstn, function(key, value) {
                                $('#optionYes').append($('<option>', {
                                    value: key,
                                    text: value
                                }));
                                $('#optionNo').append($('<option>', {
                                    value: key,
                                    text: value
                                }));
                            });
                        } else if (reply_option == 'openbox') {
                            $('.mt-choice').addClass('hide');
                            $('.yes-no').addClass('hide');
                            $('.open-box').removeClass('hide');
                            $('.file').addClass('hide');

                            $.each(response.result.other_qstn, function(key, value) {
                                $('#openBox').append($('<option>', {
                                    value: key,
                                    text: value
                                }));

                            });
                        } else if (reply_option == 'file') {
                            $('.mt-choice').addClass('hide');
                            $('.yes-no').addClass('hide');
                            $('.open-box').addClass('hide');
                            $('.file').removeClass('hide');

                            $.each(response.result.other_qstn, function(key, value) {
                                $('#file').append($('<option>', {
                                    value: key,
                                    text: value
                                }));

                            });
                        }
                        $('#optionA, #optionB, #optionC, #optionD, #optionYes, #optionNo, #openBox, #file').prepend($('<option>', {
                            value: '',
                            text: 'Select  next Question',
                            selected: true,
                        }));
                        $.each(response.result.dependant_question, function(key, value) {
                            // for checking next assign question
                            var className = value.answer;
                            var selectedItem = value.next_question;
                            $('.' + className).val(selectedItem);
                        });
                        $('.next-questions').removeClass('hide');
                    } else {
                        $('.next-questions').addClass('hide');
                        $('#no_dp_question').removeClass('hide');
                        $('#option_id').addClass('hide');
                    }

                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        function focusDropdown(id) {
            var element = document.getElementById(id);
            $(element).trigger('open');
        }

    });
</script>
@endPushOnce
