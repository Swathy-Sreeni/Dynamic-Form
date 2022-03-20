@extends('layouts.app')
@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Add Form</h1>
    @include('layouts.show-message')
    @if(isset($isEdit) && $isEdit)
    <form class="user" id="dynamic_form" method="POST" action="{{url('admin/forms/create')}}" id="js-site-notice-form"
        enctype="multipart/form-data">
        <input type="hidden" name="form_id" value="{{ $form_id }}">
        @else
        <form class="user" id="dynamic_form" method="POST" action="{{url('admin/forms/create')}}">
            @endif
            @csrf
            <div class="mb-3">
                <label class="form-label" for="form_name">Form Name</label>
                <input class="form-control" id="form_name" type="text" placeholder="Form Name" name="form_name"
                    required="required" value="{{ isset($formData['form_name'])?$formData['form_name']:''}}">
            </div>

            <div class="row btn-group d-md-flex justify-content-md-end">
                <div class="col-md-4">
                    <a href="{{url('admin/forms')}}" class="btn btn-danger btn-block me-md-2" id="btn-back"
                        type="button">Back</a>

                </div>
                @if(isset($isEdit) && $isEdit)
                <div class="col-md-4">
                    <button class="btn btn-success btn-block me-md-2" id="btn-update" type="button">Update</button>

                </div>

                @endif

                <div class="col-md-4">
                    <button class="btn btn-primary btn-block me-md-2" id="btn-add-input" type="button">Add Form
                        Inputs</button>

                </div>
            </div>


            </br>
            @if(isset($isEdit) && $isEdit && isset($formData) && isset($formData['form_controls']))
            <h4 class="form-label" for="option">Input Fields</h4>
            @foreach ($formData['form_controls'] as $key => $form_controls)
            <div class="row question-individual">
                <div class="col-md-6">
                    <h6 class="question-label-ctrl">{{ $form_controls['label'] }}</h6>

                </div>
                <div class="col-md-6">
                    <div class="label-options">
                        <!-- <a href="#" data-id="{{ $form_controls['id'] }}" data-type_id="{{ $form_controls['type'] }}" ><i class="fa fa-pencil"></i></a> -->
                        <a href="#"><button class="btn btn-info label-edit" type="button" style="margin:5px;"
                                data-id="{{ $form_controls['id'] }}"
                                data-type_id="{{ $form_controls['type'] }}">Edit</button></a>
                        <a href="#"><button class="btn btn-info label-delete" type="button" style="margin:5px;"
                                data-id="{{ $form_controls['id'] }}"
                                data-type_id="{{ $form_controls['type'] }}">Delete</button></a>
                    </div>
                </div>
            </div>

            @endforeach
            @endif

            <div class="row d-none" id="div_inputs">
                @if(isset($isEdit) && $isEdit)
                <input type="hidden" name="form_control_id" value="" id="form_control_id">
                @endif
                <div class="col-md-6">
                    <label class="form-label" for="label">Label Text</label>
                    <input class="form-control" id="label" type="text" placeholder="Label Text" name="label" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="type">Html Type</label>
                    <select class="form-select form-select-lg mb-3 form-control" aria-label=".form-select-lg example"
                        name="type" id="type">
                        <option selected disabled>Select Html Type</option>
                        <option value="1">Text</option>
                        <option value="2">Number</option>
                        <option value="3">Select</option>
                    </select>
                </div>

            </div>
            <div class="row d-none" id="div_options">
                <div class="col-md-6">
                    <label class="form-label" for="option">Options</label>
                    <div class="option_block_div">
                        <div class="row option_block" id="option_block_1" style="margin-top: 15px;">
                            <div class="col-md-6">
                                <input type="text" value="" name="options[]" class="form-control"
                                    placeholder="Enter Label" id="options_1">
                            </div>
                            <div class="col-md-6">
                                <button for="options_1" class="js-close-btn options_dlt">&times;</button>
                            </div>

                        </div>

                    </div>


                    <a class="small" id="btn_add_option" href="#">Add Option</a>
                </div>

            </div>
            <div class="row btn-group d-md-flex justify-content-md-end">
                <div class="col-md-4">
                    <button class="btn btn-danger btn-block me-md-2 d-none" id="btn-cancel-input"
                        type="reset">Cancel</button>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary btn-block me-md-2 d-none" id="btn-save-input" type="submit">Save
                        Input</button>
                </div>

            </div>

            <!-- <div class="d-grid gap-2 d-md-flex justify-content-md-end btn-group">
                <button class="btn btn-primary btn-block me-md-2 d-none" id="btn-save-input" type="submit" style="width:20%">Save Input</button>
                 <button class="btn btn-primary btn-block me-md-2" id="btn-cancel-input" type="button" style="width:20%">Cancel</button>
            </div> -->
        </form>

</div>
<!-- /.container-fluid -->


@endsection
@section('script')
<script>
$(document).ready(function() {
    var optioncount = $('.option_block').length;
    var isEdit = "{!!isset($isEdit) !!}"
    if (typeof isEdit != undefined && isEdit != null && isEdit != '' && isEdit) {
        var formData = '{!!isset($formData) ? json_encode($formData) : null!!}';
        var form_details = JSON.parse(formData);
    }


    $('#btn-add-input').click(function() {
        if ($('#form_name').val() != '' && $('#form_name').val() != null) {
            $('#div_inputs').removeClass('d-none');
            $('#btn-save-input').removeClass('d-none');
            $('#btn-cancel-input').removeClass('d-none');

        } else
            return false


    })
    $('#type').change(function() {
        var type = $(this).val()
        if (type == 3)
            $('#div_options').removeClass('d-none');
        else
            $('#div_options').addClass('d-none');
    })
    $('#btn_add_option').click(function() {
        var clone = $('.option_block:last').clone(true, true).get(0);
        ++optioncount;
        clone.id = 'option_block_' + optioncount;
        $(clone).find("*").each(function(index, element) { // And all inner elements.
            if (element.id) {
                var matches = element.id.match(/(.+)_\d+/);
                if (matches && matches.length >= 2) // Captures start at [1].
                    element.id = matches[1] + "_" + optioncount;

            }
            var attr = $(element).attr('for');
            if (typeof attr !== typeof undefined && attr !== false) {
                var matches = attr.match(/(.+)_\d+/);
                if (matches && matches.length >= 2) // Captures start at [1].
                    $(element).attr('for', matches[1] + "_" + optioncount);
            }
        })
        $(clone).find("input:text").val("");

        //  $(clone).appendTo('.input_option:last');
        $(clone).insertAfter($('.option_block:last')).val("");

    })
    $('.options_dlt').click(function() {
        var id = $(this).attr('for');
        var item = id.split('_')[1];
        $('#option_block_' + item).remove();
    })
    $('.label-edit').click(function() {
        $('#div_inputs').removeClass('d-none');
        $('#btn-save-input').removeClass('d-none');
        $('#btn-cancel-input').removeClass('d-none');
        var id = $(this).attr('data-id');
        var type = $(this).attr('data-type_id');
        if (type == 3) {
            $('#div_options').removeClass('d-none');
        }
        var control_array = (form_details.form_controls);
        $.each(control_array, function(key, value) {
            if (value.id == id) {
                $('#label').val(value.label);
                $('#form_control_id').val(value.id);
                $('#type').val(value.type);
            }
            if (value.type == 3) {
                var option_array = (value.options);
                var edit_option_count = 1
                $.each(option_array, function(key_option, value_option) {
                    console.log(edit_option_count)
                    if (key_option == 0) {
                        $('#options_' + edit_option_count).val(value_option.option);
                    } else {
                        var clone = $('.option_block:last').clone(true, true).get(0);

                        clone.id = 'option_block_' + edit_option_count;
                        $(clone).find("*").each(function(index,
                        element) { // And all inner elements.
                            if (element.id) {
                                var matches = element.id.match(/(.+)_\d+/);
                                if (matches && matches.length >=
                                    2) // Captures start at [1].
                                    element.id = matches[1] + "_" +
                                    edit_option_count;

                            }
                            var attr = $(element).attr('for');
                            if (typeof attr !== typeof undefined && attr !==
                                false) {
                                var matches = attr.match(/(.+)_\d+/);
                                if (matches && matches.length >=
                                    2) // Captures start at [1].
                                    $(element).attr('for', matches[1] + "_" +
                                        edit_option_count);
                            }
                        })
                        $(clone).find("input:text").val(value_option.option);
                        //  $(clone).appendTo('.input_option:last');
                        $(clone).insertAfter($('.option_block:last'));
                    }
                    ++edit_option_count;
                    console.log(value_option.option)
                    console.log(edit_option_count)
                })
            }
        });

    })
    $('.label-delete').click(function() {
        var id = $(this).attr('data-id');
        if (deleteItem()) {
            $.ajax({
                url: "{{url('admin/forms/controls/delete/')}}/" + id,
                type: 'DELETE',
                data: {
                    _token: "{{csrf_token()}}",
                },

                success: function(res) {
                    if (res.status) {
                        showMessage(res.message, 'success');
                        window.location.reload();

                    } else {
                        showMessage(res.message, 'error');

                    }
                }

            })
        }

    })
    $('#btn-update').click(function() {
        var form_id = "{{isset($isEdit) ? $form_id : null }}"
        $.ajax({
            url: "{{url('admin/forms/create')}}",
            type: 'POST',
            data: {
                form_id: form_id,
                form_name: $('#form_name').val(),
                _token: "{{csrf_token()}}",
            },

            success: function(res) {
                if (res.status) {
                    showMessage(res.message, 'success');
                    window.location.reload();

                } else {
                    showMessage(res.message, 'error');

                }
            }

        })

    })
    $('#btn-cancel-input').click(function() {
        $('#div_inputs').addClass('d-none');
        $('#btn-save-input').addClass('d-none');
        $('#btn-cancel-input').addClass('d-none');
        $('#div_options').addClass('d-none');
        window.location.reload();

    })
})

function deleteItem() {
    if (confirm("Are you sure you want to delete?")) {
        return true;
    }
    return false;
}
</script>
@endsection