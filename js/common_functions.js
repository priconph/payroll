/**
 * TODO: Toaster Notification
 */
function notif_success(data) {
	notif({
		type: "success",
		msg: "<b>Success:</b> " + data,
		type: "success",
		position: "right",
		timeout: 3000
	});
}
function notif_error(data) {
	notif({
		type: "error",
		msg: "<b>Error:</b> " + data,
		position: "right",
		timeout: 3000
	});
}
function notif_warning(data) {
    notif({
        type: "warning",
        msg: "<b>Warning:</b> " + data,
        position: "right",
        timeout: 3000
    });
}

function notif_info(data) {
    notif({
        type: "info",
        msg: "<b>Info:</b> " + data,
        position: "right",
        timeout: 3000
    });
}
function buttonDisabledClass($buttonId,$iconId){
	$buttonId.prop('disabled', true);
	$iconId.addClass('fa fa-spinner fa-pulse');
}
function buttonEnabledClass($buttonId,$iconId){
	$buttonId.prop('disabled', false);
	$iconId.removeClass('fa fa-spinner fa-pulse');
	$iconId.addClass('fa fa-save');
}

/*  */
function re_initialize_select2_server_side(combo_id,dropdown_parent,data_value,ajax_url){
	$(combo_id).select2({
		dropdownParent	: $(dropdown_parent),
		minimumInputLength: 2,
		triggerChange: true,
		allowClear: true,
		placeholder: {
			id: "",
			placeholder: "Leave blank to ..."
		},
		ajax: {
		url: ajax_url,
			dataType: 'json',
			delay: 100,
			data: function (params) {
				return {
					q: params.term, // search term
				};
			},
			processResults: function (data) {
				return {
					/* get the json encode data data[id => [], text => []] */
					results: data
				};
			},
			cache: true
		}
	});
}
function assign_value_select2(combo_id,data_value){
	/* get the data_value of EmpNo */
	var newOption = new Option(data_value.text, data_value.id, true, true); 
	$(combo_id).prepend(newOption).trigger('change');
}