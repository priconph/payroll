<html>
<head>
	<?php
  		/* Administrative */
		// require_once('./class/payroll_oop.php');

		// $user_ip = $_SERVER['REMOTE_ADDR'];
		// $valid_ip = PAYROLL::getInstance()->get_valid_ip($user_ip);

		// echo $valid_ip;
		// if(!$valid_ip){
		// 	echo "WARNING YOU ARE NOT ALLOWED TO VIEW THIS PAGE!";
		// 	exit;
		// }
	?>
</head>
<body>	

<section class="main">		
	<section class="tab-pane active fade in content">
		<div class="row">
			<div class="col">
				<div class="panel panel-primary">
					<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Leaves Table</i>
					</div>
					<div class="panel-body">
						<div class="row">
							<!-- Tab panes -->
							<div role="tabpanel" class="tab-pane active" id="taxes">
								<div class="row">
									<div class="col-sm-3">
											<button class="btn btn-primary fa" id="btnImportData" data-toggle="modal"><i class="fa fa-plus"></i> Import Data</button><br><br>
									</div>
									<div class="col-sm-9" style="display: flex; justify-content: flex-end;">
										<button class="btn btn-danger" style="margin-right: 5px" id="btnDelete"><i class="fa fa-minus"></i> Delete All</button>
										<button class="btn btn-primary" id="btnLeaves" data-toggle="modal" data-target="#mdlTaxes"><i class="fa fa-plus"></i> New</button>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-condensed table-hover" id="t_leaves">
										<thead>
											<th style="width: 20%;">Employee Number</th> 
											<th style="width: 20%;">Leave Code</th>
											<th style="width: 20%;">Amount</th>
											<th style="width: 20%;">Cut-off</th>
											<th style="width: 10%;">Action</th>
										</thead>
									</table>
								</div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>

<!---------------------
	Modals - Start 
---------------------->

<!---------------------
	Import Modal
---------------------->
<!-- Modal for system message -->
<div class="modal fade" tabindex="-1" role="dialog" id="mdlImportData" data-backdrop="static">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-file-excel-o"></i> Import Taxes</h4>
      </div>
	  	<form id="formImportData" method="" enctype="multipart/form-data">
		  <div class="modal-body">
			<!-- <label class="col-md-4 control-label">Choose CSV File</label>
			<input type="file" name="oem_file" id="fileOEM" accept=".csv"> -->
			<div class="form-group">
				<label for="file">Choose CSV File</label>
				<input type="file" name="file" class="form-control-file" id="file" accept=".csv" required>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-success" name="import" id="btnSave"><i class="fa fa-save" id="iconsSave"></i> Import</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!---------------------
	Create Modal
---------------------->
<div class="modal fade" id="mdl_leaves" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-sm" >
		<div class="modal-content">
			<div class="modal-header" style="overflow-y:auto;">
				New Leave Info
			</div>
			<form id="frm_leaves">
				<div class="modal-body" style="overflow-y:auto;">
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Employee Number</label>
									<select type="text" class="form-control"  name="txt_emp_no" id="txt_emp_no" style="width:100%;">
									</select>
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Leave Code</label>
									<select class="form-control"  name="slct_leave_code">
										<option value="" disabled selected>---</option>
										<option value="1">BDL</option>
										<option value="2">Shutdown</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Amount</label>
									<input type="number" class="form-control"  name="int_amount" min="0" step = "0.01" pattern="^\d*(\.\d{0,2})?$">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Cut off</label>
									<select class="form-control"  name="slct_cutoff">
										<option value="" disabled selected>---</option>
										<option value="1">First</option>
										<option value="2">Last</option>
									</select>
								</div>
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<!-- <button type="submit" class="btn btn-primary">Save</button> -->
					<button type="submit" class="btn btn-primary" id="btnSave"><i class="fa fa-save" id="iconsSave"></i> Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="mdl_update_leaves" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" style="margin-top:0%;margin-left: 45%;">
		<div class="modal-content" style="width:50%">
			<div class="modal-header" style="overflow-y:auto;">
				New Leave Info
			</div>
			<form id="frm_update_leaves">
				<div class="modal-body" style="overflow-y:auto;">
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<input type="text" class="form-control"  name="data_id">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Employee Number</label>
									<select type="text" class="form-control"  name="txt_emp_no" id="txt_emp_no" style="width:100%;">
									</select>
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Leave Code ( 1-BDL, 2-Shutdown)</label>
									<select class="form-control"  name="slct_leave_code">
										<option value="" disabled selected>---</option>
										<option value="1">BDL</option>
										<option value="2">Shutdown</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Amount</label>
									<input type="number" class="form-control"  name="int_amount" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Cut off</label>
									<select class="form-control"  name="slct_cutoff">
										<option value="" disabled selected>---</option>
										<option value="1">First</option>
										<option value="2">Last</option>
									</select>
								</div>
							</div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<!-- <button type="submit" class="btn btn-primary">Save</button> -->
					<button type="submit" class="btn btn-primary" id="btnSave"><i class="fa fa-save" id="iconsSave"></i> Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!---------------------
	Update Modal
---------------------->

<!-- <script src="./js/common_functions.js?12345"></script> -->
<script>
	$(document).ready(function () {
		handler_leaves = './handler/handler_leaves.php';

		dt_leaves_info = $('#t_leaves').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "./server_side_scripts/leaves/dt_leaves.php",
			"drawCallback": function( settings ) {
				$('#t_leaves').attr('style','width:100%;');
			}
		});
		$('#btnLeaves').click(function () { 
			$('#mdl_leaves').modal('show');
			// dd_hris_all_list
			re_initialize_select2_server_side('#mdl_leaves #txt_emp_no','#mdl_leaves #frm_leaves',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
		});
		$('#frm_leaves').submit(function (e) { 
			e.preventDefault();
			var $buttonId 	= $('#frm_update_leaves #btnSave');
			var $iconId		= $("#frm_update_leaves #iconsSave");
			let action = {
				'action' : 'create_leaves'
			};
			let data = $.param(action) +'&'+ $(this).serialize();
			console.log('data ', data);
			$.ajax({
				type: "POST",
				url: handler_leaves,
				data: data,
				dataType: "json",
				beforeSend: function(){
					buttonDisabledClass($buttonId,$iconId);
				},
				success: function (response) {
					if(response['result']=="success"){
						notif_success("Created Successfully");
						dt_leaves_info.draw();
						buttonEnabledClass($buttonId,$iconId);
						$('#mdl_leaves').modal('hide');
						$('#frm_leaves')[0].reset();
						
					}else{
						alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
					}
				},error: function (response){
					console.log('error: '+response);
					buttonDisabledClass($buttonId,$iconId);
					alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
				}
			});
		});
		$('#t_leaves').on('click','.leaves-data-edit',function () {
			let pkid = $(this).attr('data-id');
			// console.log(pkid);
			readLeavesInfo(pkid);

			$('#mdl_update_leaves').modal('show');
		});

		$('#btnDelete').click(function (e) { 
			e.preventDefault();
			if (confirm('Are you sure you want to delete?')) {
				let action = {
					'action' : 'delete_leaves'
				};
				let data = $.param(action);
				$.ajax({
					type: "POST",
					url: handler_leaves,
					data: data,
					dataType: "json",
					success: function (response) {
						if(response['result']=="success"){
							dt_leaves_info.draw();
							notif_success("Deleted Successfully!");
						}else{
							alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
						}
					},
					error:function(response){
						console.log('error: '+response);
						alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
					}
				});
				
			}
		});
		
		$('#frm_update_leaves').submit(function (e) { 
			e.preventDefault();
			var $buttonId 	= $('#frm_update_leaves #btnSave');
			var $iconId		= $("#frm_update_leaves #iconsSave");
			let action = {
				'action' : 'update_leaves'
			};
			let data = $.param(action) +'&'+ $(this).serialize();
			$.ajax({
				type: "POST",
				url: handler_leaves,
				data: data,
				dataType: "json",
				beforeSend: function(){
					buttonDisabledClass($buttonId,$iconId);
				},
				success: function (response) {
					if(response['result']=="success"){
						notif_success("Updated Successfully");
						dt_leaves_info.draw();
						buttonEnabledClass($buttonId,$iconId);
						$('#mdl_update_leaves').modal('hide');
					}else{
						alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
					}
				},
				error:function(response){
					console.log('error: '+response);
					buttonDisabledClass($buttonId,$iconId);
					alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
				}
			});
		});

		function readLeavesInfo(pkid){
			// console.log(pkid);
			// return;
			let array_data = {
				'action' : 'read_leaves_info',
				'pkid'	 : pkid
			};
			let data = $.param(array_data);
			$.ajax({
				type: "POST",
				url: handler_leaves,
				data: data,
				dataType:  "json",
				success: function (response) {
					for(var i=0;i<response['ctr'];i++){
						$('#frm_update_leaves input[name="data_id"]').val(response['pkid'][i]);
						$('#frm_update_leaves select[name="slct_leave_code"]').val(response['leave_code'][i]);
						$('#frm_update_leaves input[name="int_amount"]').val(response['amount'][i]);
						$('#frm_update_leaves select[name="slct_cutoff"]').val(response['cut_off'][i]);
						assign_value_select2('#frm_update_leaves #txt_emp_no',response['emp_no'][i]);
						re_initialize_select2_server_side('#mdl_update_leaves #txt_emp_no','#mdl_update_leaves #frm_update_leaves',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
					}
				}
			});
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

		$('#btnImportData').click(function () { 
			var $buttonId 	= $('#formImportData #btnSave');
			var $iconId		= $("#formImportData #iconsSave");
			buttonEnabledClass($buttonId,$iconId);
			$('#mdlImportData').modal('show');
			// dd_hris_all_list
			// re_initialize_select2_server_side('#mdl_pagibig_loan_create #txt_emp_no','#mdl_pagibig_loan_create #frm_pagibig_loan_create',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
		
		});



		$('#formImportData').submit(function (e) { 
			e.preventDefault();
			var $buttonId 	= $('#formImportData #btnSave');
			var $iconId		= $("#formImportData #iconsSave");

			let serialize_data = new FormData(this);
			serialize_data.append('action',"import_leaves");
			$.ajax({
				type: "POST",
				url: handler_leaves,
				data: serialize_data,
				dataType: "json",
				cache: false,
				contentType:false,
				processData:false,
				beforeSend: function(){
					buttonDisabledClass($buttonId,$iconId);
				},
				success: function (response) {
					if(response['result']=="success"){
						notif_success("Import Successfully!");
						dt_leaves_info.draw();
						buttonEnabledClass($buttonId,$iconId);
						$('#mdlImportData').modal('hide');
						$('#formImportData')[0].reset();
					}else{
						buttonDisabledClass($buttonId,$iconId);
						notif_error("Import Failed!");
						alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
					}
				},error: function (response){
					console.log('error: '+response);
					buttonDisabledClass($buttonId,$iconId);
					alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
				}
			});
		});
	}); //end
</script>
</body>
</html>
