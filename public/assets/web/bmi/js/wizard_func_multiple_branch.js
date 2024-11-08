	/*  Wizard */
	jQuery(function ($) {
		"use strict";
		
		$("#wizard_container").wizard({
			stepsWrapper: "#wrapped",
			submit: ".submit",
			beforeSelect: function (event, state) {
				if ($('input#website').val().length != 0) {
					return false;
				}
				if (!state.isMovingForward)
					return true;
				var inputs = $(this).wizard('state').step.find(':input');
				return !inputs.length || !!inputs.valid();
			}
		}).validate({
			errorPlacement: function (error, element) {
				if (element.is(':radio') || element.is(':checkbox')) {
					error.insertBefore(element.next());
				} else {
					error.insertAfter(element);
				}
			}
		});
	});

	$("#wizard_container").wizard({
		transitions: {
			branchtype: function ($step, action) {
				// var branch = $step.find(":checked").val();
				var branch ='';
				var alert_msg ='Please choose an other option. You can not procceed futher with that option.';
				// Check if the current step has a radio button selected
				var checkedRadio = $step.find(":checked");
				if (checkedRadio.length > 0) {
					branch = checkedRadio.attr('data-branch_id');
					alert_msg = checkedRadio.attr('data-alert');
				} else {
					// If no radio button is selected, assume it's a text area
					var textArea = $step.find("textarea");
					branch = textArea.attr('data-branch_id');
					alert_msg = textArea.attr('data-alert');

				}

				if (!branch) {
					 $("form").valid();
				}

				// var branch_name = branch.split(' ')[0];
				if(branch == 'no_branch'){
					$('#message_popup').text(alert_msg)
					$('#consult_msg_modal').modal('show');

					// alert(alert_msg);
				}
				
				return branch;
			}
		}
	});
	