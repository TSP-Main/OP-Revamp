@extends('web.layouts.default')
@section('title', 'Product Questions')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
        .styled-radio {
            cursor: pointer;
            width: 20px;
            height: 20px;
            margin-right: 10px;
            border: 2px solid #0dcaf0;
            border-radius: 50%;
            outline: none;
        }

        .styled-radio:hover {
            outline: auto;
        }

        .styled-radio:checked {
            background-color: #0dcaf0;
            border: 2px solid #0dcaf0;
            box-shadow: none;
            outline: none;
        }


        .btn-radio {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem;
            padding: 7px 20px !important;
            cursor: pointer;
            outline: none;
            background-color: #ced4da;
            font-weight: 400;
        }

        .btn-radio:checked {
            background-color: #0dcaf0 !important;
            border: 2px solid #0dcaf0;
            color: #fff;
        }

        .btn-radio:focus {
            box-shadow: none;
        }

        .btn-radio:hover {
            background-color: #d8e5e8;
        }

        .btn-radio::before {
            content: attr(data-label);
        }

        /* Hide the actual radio input */
        .btn-radio input[type="radio"] {
            display: none;
        }

        /* Custom checkbox styles */
        .custom-checkbox {
            position: relative;
            display: inline-block;
            width: 26px;
            height: 29px;
            background-color: #fff;
            border: 2px solid #6c757d;
            border-radius: 5px;
            cursor: pointer;
        }

        .custom-checkbox::after {
            background-color: #03c4a5 !important;
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 12px;
            height: 12px;
            border-bottom: 2px solid #000;
            /* Changed border color to black */
            border-right: 2px solid #000;
            /* Changed border color to black */
            transform-origin: bottom right;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        /* Checkbox checked state */
        .custom-checkbox input:checked+.custom-checkbox::after {
            opacity: 1;
        }

        /* Change background color to green when checked */
        .custom-checkbox input:checked+.custom-checkbox {
            background-color: #03c4a5 !important;
            /* Green background color */
        }

        /* Hide the default checkbox */
        .custom-checkbox input[type="checkbox"] {
            opacity: 0;
            width: 0;
            height: 0;
            background-color: #03c4a5 !important;
        }

        .bnt-checkout:hover {
            background-color: #03c4a5;
            border-radius: 10px !important;
        }

        .bnt-checkout {
            border-radius: 10px !important;
        }
    </style>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="firstconsultationstart">
                    <div class="text">
                        <h2 class="mb-4">Condition Specific Questions</h2>
                        <p></p>
                    </div>
                    <form id="product_consultation_from" action="{{ route('web.transactionStore') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="template" required value="{{ $template }}">
                        <input type="hidden" name="product_id" required value="{{ $product_id ?? '' }}">

                        @foreach ($questions ?? [] as $key => $question)
                            @if ($question['anwser_set'] == 'mt_choice')
                                <div class="form-group px-4 question">
                                    <div class="d-flex align-items-center">
                                        <p class="m-0 fw-bold">{{ $question['title'] ?? '' }}</p>
                                    </div>
                                    <p class=" ">{!! $question['desc'] ?? '' !!}</p>
                                    @if ($question['optA'])
                                        <div class="form-check">
                                            <input class="form-check-input styled-radio option" type="radio"
                                                name="quest_{{ $question['id'] }}" id="quest_{{ $question['id'] }}_option1"
                                                data-append_id="apped_quest_{{ $question['id'] }}"
                                                data-next_type="{{ $question['next_type']['optA'] ?? 'nothing' }}"
                                                data-selector="{{ isset($question['selector']['optA']) ? $question['selector']['optA'] : '' }}"
                                                data-selector="{{ isset($question['selector']['optA']) ? $question['selector']['optA'] : '' }}"
                                                value="{{ $question['optA'] }}" required>
                                            <label class="form-check-label"
                                                for="quest_{{ $question['id'] }}_option1">{{ $question['optA'] }}</label>
                                        </div>
                                    @endif
                                    @if ($question['optB'])
                                        <div class="form-check">
                                            <input class="form-check-input styled-radio option" type="radio"
                                                name="quest_{{ $question['id'] }}"
                                                id="quest_{{ $question['id'] }}_option2"
                                                data-append_id="apped_quest_{{ $question['id'] }}"
                                                data-next_type="{{ $question['next_type']['optB'] ?? 'nothing' }}"
                                                data-selector="{{ isset($question['selector']['optB']) ? $question['selector']['optB'] : '' }}"
                                                value="{{ $question['optB'] }}" required>
                                            <label class="form-check-label"
                                                for="quest_{{ $question['id'] }}_option2">{{ $question['optB'] }}</label>
                                        </div>
                                    @endif
                                    @if ($question['optC'])
                                        <div class="form-check">
                                            <input class="form-check-input styled-radio option" type="radio"
                                                name="quest_{{ $question['id'] }}"
                                                id="quest_{{ $question['id'] }}_option3"
                                                data-append_id="apped_quest_{{ $question['id'] }}"
                                                data-next_type="{{ $question['next_type']['optC'] ?? 'nothing' }}"
                                                data-selector="{{ isset($question['selector']['optC']) ? $question['selector']['optC'] : '' }}"
                                                value="{{ $question['optC'] }}" required>
                                            <label class="form-check-label"
                                                for="quest_{{ $question['id'] }}_option3">{{ $question['optC'] }}</label>
                                        </div>
                                    @endif
                                    @if ($question['optD'])
                                        <div class="form-check">
                                            <input class="form-check-input styled-radio option" type="radio"
                                                name="quest_{{ $question['id'] }}"
                                                id="quest_{{ $question['id'] }}_option3"
                                                data-append_id="apped_quest_{{ $question['id'] }}"
                                                data-next_type="{{ $question['next_type']['optD'] ?? 'nothing' }}"
                                                data-selector="{{ isset($question['selector']['optD']) ? $question['selector']['optD'] : '' }}"
                                                value="{{ $question['optD'] }}" required>
                                            <label class="form-check-label"
                                                for="quest_{{ $question['id'] }}_option3">{{ $question['optD'] }}</label>
                                        </div>
                                    @endif
                                </div>
                                <div id="apped_quest_{{ $question['id'] }}"></div>
                            @endif
                            @if ($question['anwser_set'] == 'yes_no')
                                <div class="form-group px-3 question">
                                    <div class="d-flex align-items-start justify-content-between">
                                        <div class="d-block">
                                            <p class="me-auto px-2 " style="font-weight: 400;">
                                                {{ $question['title'] ?? '' }}</p>
                                            <p class="me-auto ">{!! $question['desc'] ?? '' !!}</p>
                                        </div>
                                        <div class="d-flex">
                                            <label class="btn" style="padding: 0;">
                                                <input type="radio" name="quest_{{ $question['id'] }}"
                                                    class="btn-radio option"
                                                    data-append_id="apped_quest_{{ $question['id'] }}"
                                                    data-next_type="{{ $question['next_type']['yes_lable'] ?? 'nothing' }}"
                                                    data-selector="{{ isset($question['selector']['yes_lable']) ? $question['selector']['yes_lable'] : '' }}"
                                                    value="{{ $question['yes_lable'] }}"
                                                    data-label="{{ $question['yes_lable'] }}" required>
                                            </label>
                                            <label class="btn" style="padding: 0;">
                                                <input type="radio" name="quest_{{ $question['id'] }}"
                                                    class="btn-radio option"
                                                    data-append_id="apped_quest_{{ $question['id'] }}"
                                                    data-next_type="{{ $question['next_type']['no_lable'] ?? 'nothing' }}"
                                                    data-selector="{{ isset($question['selector']['no_lable']) ? $question['selector']['no_lable'] : '' }}"
                                                    value="{{ $question['no_lable'] }}"
                                                    data-label="{{ $question['no_lable'] }}" required>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div id="apped_quest_{{ $question['id'] }}"></div>
                            @endif
                            @if ($question['anwser_set'] == 'openbox')
                                <div class="form-group px-4 question">
                                    <div class="d-flex align-items-center">
                                        <p class="m-0 fw-bold">{{ $question['title'] ?? '' }}</p>
                                    </div>
                                    <div class="mt-3 mb-0">
                                        <label for="quest_{{ $question['id'] }}" class="form-label">
                                            <p class="mt-1">{!! $question['desc'] ?? '' !!}</p>
                                        </label>
                                        <textarea class="form-control option" data-append_id="apped_quest_{{ $question['id'] }}"
                                            data-next_type="{{ $question['next_type']['openbox'] ?? 'nothing' }}"
                                            data-selector="{{ isset($question['selector']['openbox']) ? $question['selector']['openbox'] : '' }}"
                                            name="quest_{{ $question['id'] }}" id="quest_{{ $question['id'] }}" rows="7"
                                            style="height: 135px; border-radius:15px; " placeholder="Please provide any additional details here"
                                            required=''></textarea>
                                    </div>
                                </div>
                                <div id="apped_quest_{{ $question['id'] }}"></div>
                            @endif
                            @if ($question['anwser_set'] == 'file')
                                <div class="form-group px-4 question">
                                    <div class="d-flex align-items-center">
                                        <p class="m-0 fw-bold">{{ $question['title'] ?? '' }}</p>
                                    </div>
                                    <div class="mt-3 mb-0">
                                        <label for="quest_{{ $question['id'] }}" class="form-label">
                                            <p class="mt-1">{!! $question['desc'] ?? '' !!}</p>
                                        </label>
                                        <input type="file" class="form-control option"
                                            data-append_id="apped_quest_{{ $question['id'] }}"
                                            data-next_type="{{ $question['next_type']['file'] ?? 'nothing' }}"
                                            data-selector="{{ isset($question['selector']['file']) ? $question['selector']['file'] : '' }}"
                                            name="qfid_{{ $question['id'] }}" id="quest_{{ $question['id'] }}"
                                            required=''>
                                    </div>
                                </div>
                                <div id="apped_quest_{{ $question['id'] }}"></div>
                            @endif
                        @endforeach

                        <div class="form-group question" style=" background: none; padding:none; margin:none;">
                            <div class="d-flex align-items-center m-3 mb-5  ">
                                <button type="submit" class="btn btn-outline-success bnt-checkout fw-bold rounded-1"
                                    style="border:#ced4da 2xp solid; ">Proceed to Checkout</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- second div  -->
            <div class="col-md-4 bg-info mb-5 rounded-3" style="border-radius: 25px !important;">
                <div class="trackcompleted mb-4 ">
                    <div class="text">
                        <h1>How it works</h1>
                        <hr class="my-3">
                    </div>
                    <div class="q1complete">
                        <div class="mt-4 d-flex gap-2">
                            <span
                                style="width: 29px; height: 29px; background: #00c4a3; color: #fff; text-align: center; border-radius: 50%; ">&#49;
                            </span> <span>Complete a consultation</span>
                        </div>

                        <p>You will need to begin by completing an ailment-based consultation. This will be a set of
                            questions related to your symptoms, medical history and any other information our
                            prescribers might need to be able to recommend a suitable treatment.</p>
                    </div>
                    <div class="q2complete">
                        <div class="mt-3 d-flex gap-2">
                            <span
                                style="width: 29px; height: 29px; background: #00c4a3; color: #fff; text-align: center; border-radius: 50%; ">&#50;
                            </span> <span>Browse treatments</span>
                        </div>

                        <p>Explore our wide range of medications, diagnostic tools and over the counter treatments
                            to learn more about how they work, what they are used for and how much they cost.</p>
                    </div>
                    <div class="q3complete">
                        <div class="mt-3 d-flex ">
                            <span
                                style="width: 29px; height: 29px; background: #00c4a3; color: #fff; text-align: center; border-radius: 50%; ">&#51;
                            </span> <span>Wait for a prescriber to review your request</span>
                        </div>

                        <p>You can either wait on our website or you can leave the page and wait for a notification
                            from us to let you know that a prescriber has finished reviewing your consultation.</p>
                    </div>
                    <div class="q4complete">
                        <div class="mt-3 d-flex gap-2">
                            <span
                                style="width: 29px; height: 29px; background: #00c4a3; color: #fff; text-align: center; border-radius: 50%; ">&#52;
                            </span> <span>Purchase treatment</span>
                        </div>
                        <p>From our selection of available prescription-only and over-the-counter products, the
                            prescriber will let you know which ones they have approved for your condition. From
                            here, you can select your chosen option and continue to payment to complete your order.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL AREA START (Add To Cart Modal) -->

    <div class="modal fade" id="attention_modal" tabindex="-1">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger py-2 px-2">
                    <h5 class="modal-title mx-5 my-3 text-white fw-bold "> Attention !</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="text-danger fw-bold">You can't proceed further.</p>
                            <p class="text-success fw-bold">Please review your selections.</p>
                            <p>You are unable to continue if you do not agree to the terms and conditions of our site.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL AREA END -->
@stop

@pushOnce('scripts')
    <script>
        $(document).ready(function() {
            var dependent_questions = @json($dependent_questions);
            var alerts = @json($alerts);
            $(document).on('click input change', '.option', function() {
                var next_type = $(this).data('next_type');
                var selector = $(this).data('selector');
                var append_id = $(this).data('append_id');
                if (next_type == 'question') {
                    if (selector) {
                        let question = dependent_questions[selector] ?? null;
                        if (question) {
                            var quest_html = '';
                            if (question.anwser_set == 'mt_choice') {
                                quest_html = `<div class="form-group px-4 question">
                                        <div class="d-flex align-items-center">
                                            <p class="m-0 fw-bold">${question.title || ''}</p>
                                            </div>
                                            <p class="">${question.desc || ''}</p>
                                        <div class="form-check">
                                            <input class="form-check-input styled-radio option" type="radio" name="quest_${question.id}" id="quest_${question.id}_option1" data-selector="${question.selector && question.selector.optA ? question.selector.optA : ''}" value="${question.optA}" required>
                                            <label class="form-check-label" for="quest_${question.id}_option1">${question.optA}</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input styled-radio option" type="radio" name="quest_${question.id}" id="quest_${question.id}_option2" data-selector="${question.selector && question.selector.optB ? question.selector.optB : ''}" value="${question.optB}" required>
                                            <label class="form-check-label" for="quest_${question.id}_option2">${question.optB}</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input styled-radio option" type="radio" name="quest_${question.id}" id="quest_${question.id}_option3" data-selector="${question.selector && question.selector.optC ? question.selector.optC : ''}" value="${question.optC}" required>
                                            <label class="form-check-label" for="quest_${question.id}_option3">${question.optC}</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input styled-radio option" type="radio" name="quest_${question.id}" id="quest_${question.id}_option4" data-selector="${question.selector && question.selector.optD ? question.selector.optD : ''}" value="${question.optD}" required>
                                            <label class="form-check-label" for="quest_${question.id}_option4">${question.optD}</label>
                                        </div>
                                    </div>
                                    <div id="apped_quest_${question.id}"></div>`;

                                $('#' + append_id).html(quest_html);
                            } else if (question.anwser_set == 'yes_no') {
                                var quest_html = `<div class="form-group px-3 question">
                                            <div class="d-flex align-items-start">
                                                    <p class="me-auto" style="font-weight: 400;">${question.title || ''}</p>
                                                    <label class="btn" style="padding: 0;">
                                                        <input type="radio" name="quest_${question.id}" class="btn-radio option" data-append_id="apped_quest_${question.id}" data-selector="${question.selector && question.selector.yes_lable ? question.selector.yes_lable : ''}" value="${question.yes_lable}" data-label="${question.yes_lable}" required>
                                                    </label>
                                                    <label class="btn" style="padding: 0;">
                                                        <input type="radio" name="quest_${question.id}" class="btn-radio option" data-append_id="apped_quest_${question.id}" data-selector="${question.selector && question.selector.no_lable ? question.selector.no_lable : ''}" value="${question.no_lable}" data-label="${question.no_lable}" required>
                                                    </label>
                                                </div>
                                        </div>
                                        <div id="apped_quest_${question.id}"></div>`;

                                $('#' + append_id).html(quest_html);
                            } else if (question.anwser_set == 'openbox') {
                                var quest_html = `<div class="form-group px-4 question">
                                            <div class="d-flex align-items-center">
                                                <p class="m-0 fw-bold">${question.title || ''}</p>
                                            </div>
                                            <div class="mt-3 mb-0">
                                                <label for="quest_${question.id}" class="form-label">
                                                    <p class="mt-1">${question.desc || ''}</p>
                                                </label>
                                                <textarea class="form-control option" data-append_id="apped_quest_${question.id}" data-selector="${question.selector && question.selector.openbox ? question.selector.openbox : ''}" name="quest_${question.id}" id="quest_${question.id}" rows="7" style="height: 135px; border-radius:15px;" placeholder="Please provide any additional details here" required></textarea>
                                            </div>
                                        </div>
                                        <div id="apped_quest_${question.id}"></div>`;

                                $('#' + append_id).html(quest_html);

                            } else if (question.anwser_set == 'file') {
                                var quest_html = `<div class="form-group px-4 question">
                                            <div class="d-flex align-items-center">
                                                <p class="m-0 fw-bold">${question.title || ''}</p>
                                            </div>
                                            <div class="mt-3 mb-0">
                                                <label for="quest_${question.id}" class="form-label">
                                                    <p class="mt-1">${question.desc || ''}</p>
                                                </label>
                                                <input type="file" class="form-control option" data-append_id="apped_quest_${question.id}" data-selector="${question.selector && question.selector.file ? question.selector.file : ''}" name="qfid_${question.id}" id="quest_${question.id}" required>
                                            </div>
                                        </div>
                                        <div id="apped_quest_${question.id}"></div>`;
                                $('#' + append_id).html(quest_html);
                            }
                        }
                    } else {
                        let append_id = $(this).data('append_id');
                        $('#' + append_id).html('');
                    }
                } else if (next_type == 'alert') {
                    if (selector) {
                        var alert_detail = alerts[selector] ?? null;
                        // console.log(alert_detail);
                        var alert_html = '';
                        if (alert_detail) {
                            var alert_html = `<div class="alert ${alert_detail.type} ">
                                            <p class="px-2 fw-semibold">${alert_detail.body}</p>
                                        </div>`;

                            $('#' + append_id).html(alert_html);
                        }

                    } else {
                        let append_id = $(this).data('append_id');
                        $('#' + append_id).html('');
                    }
                } else {
                    let append_id = $(this).data('append_id');
                    $('#' + append_id).html('');
                }
            });

            $('#product_consultation_from').submit(function() {
                if ($('.alert-danger').length > 0) {
                    $('#attention_modal').modal("show");
                    return false;
                }
                return true;
            });
        });
    </script>
@endPushOnce
