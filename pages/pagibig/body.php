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
					<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> PAG-IBIG Table</i>
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
										<button class="btn btn-success fa pull-right" id="btnLeaves" data-toggle="modal" data-target="#mdlTaxes"><i class="fa fa-plus"></i> New</button><br><br>
									</div>
								</div>
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-condensed table-hover" id="dt_pagibig_loan">
										<thead>
											<th style="width: 20%;">Employee Number</th> 
											<th style="width: 20%;">Salary Loan Amount</th>
											<th style="width: 20%;">Calamity Loan Amount</th>
											<th style="width: 20%;">Safe Loan Amount</th>
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
	Create Modal
---------------------->
<div class="modal fade" id="mdl_leaves" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" style="margin-top:0%;margin-left: 45%;">
		<div class="modal-content" style="width:50%">
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
<!---------------------
	Update Modal
---------------------->
<!-- <div class="modal fade" id="mdl_pagibig_loan_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" style="width: 25% !important; min-width: 25% !important;">
		<div class="modal-content">
			<div class="modal-header" style="overflow-y:auto;">
				Edit Leave Info
			</div>
			<form id="frm_pagibig_loan_create">
				<div class="modal-body" style="overflow-y:auto;">
					<div class="row" style="margin-top:-10px;">
						<div class="col-sm-12">
							<div class="form-group">
								<input type="hidden" class="form-control"  name="data_id">
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:-10px;">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="txt_emp_no" class="col-form-label">Employee Number</label>
								<select type="text" class="form-control"  name="txt_emp_no" id="txt_emp_no" style="width:100%;">
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-4" style="padding-right: 0 !important">
							<div class="form-group">
								<label for="loan_code" class="col-form-label">Loan Code</label>
								<select type="text" class="form-control"  name="loan_code" id="loan_code" style="width:100%;">
									<option value="0" disabled selected>Select One</option>
									<option value="1">BDO</option>
									<option value="2">SSSAL</option>
									<option value="3">CAMLO</option>
									<option value="4">PBGSL</option>
									<option value="5">PBGCL</option>
									<option value="6">HSBC</option>
								</select>
							</div>
						</div>
						<div class="col-sm-8" style="padding-left: 0 !important">
							<div class="form-group">
								<label for="loan_description" class="col-form-label">Loan Description</label>
								<select class="form-control" name="loan_description" id="loan_description" disabled tabindex="-1" style="width:100%;">
									<option value="0" disabled selected>Select One</option>
									<option value="1">BDO Salary Loan</option>
									<option value="2">SSS Salary Loan</option>
									<option value="3">SSS Calamity Loan</option>
									<option value="4">PagIBIG Salary Loan</option>
									<option value="5">PagIBIG Calamity Loan</option>
									<option value="6">HSBC Salary Loan</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="principal_amount" class="col-form-label">Principal Amount</label>
								<input type="number" class="form-control principal_amount" id="principal_amount" name="principal_amount" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="interest_rate" class="col-form-label">Interest Rate (%)</label>
								<input type="number" class="form-control" id="interest_rate" name="interest_rate">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="months_to_pay" class="col-form-label">Months to Pay</label>
								<input type="number" class="form-control months_to_pay" name="months_to_pay" id="months_to_pay">
							</div>
						</div>
					</div>
					<div class="row" id="div_loan_amount">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="int_loan_amount" class="col-form-label">Salary Loan Amount</label>
								<input type="number" class="form-control" id="int_loan_amount" name="int_loan_amount" readonly min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
							</div>
						</div>
					</div>
					<div class="row hidden" id="div_calamity_loan_amount">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="int_calamity_loan_amount" class="col-form-label">Calamity Loan Amount</label>
								<input type="number" class="form-control" id="int_calamity_loan_amount" name="int_calamity_loan_amount" readonly min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="frequency" class="col-form-label">Frequency</label>
								<select type="text" class="form-control"  name="frequency" id="frequency" style="width:100%;">
									<option value="0" disabled selected>Select One</option>
									<option value="1">[1A] First Half of the Month</option>
									<option value="2">[1B] Second Half of the Month</option>
									<option value="3">[1C] First Week of the Month</option>
									<option value="4">[1D] Third Half of the Month</option>
									<option value="5">[2] First and Second Half of the Month</option>
									<option value="6">[4] Every Week</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="start_date" class="col-form-label">Start Date</label>
								<input type="date" class="form-control" id="start_date" name="start_date">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btnSave"><i class="fa fa-save" id="iconsSave"></i> Save</button>
				</div>
			</form>
		</div>
	</div>
</div> -->
<!---------------------
	Create Modal
---------------------->
<div class="modal fade" id="mdl_pagibig_loan_create" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" style="overflow-y:auto;">
	<div class="modal-dialog" style="width: 25% !important; min-width: 25% !important;">
		<div class="modal-content">
			<div class="modal-header" style="overflow-y:auto;">
				Loan Info
			</div>
			<form id="frm_pagibig_loan_create">
				<div class="modal-body" style="overflow-y:auto;">
					<div class="row" style="margin-top:-10px;">
						<div class="col-sm-12">
							<div class="form-group">
								<input type="hidden" class="form-control" id="data_id" name="data_id">
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:-10px;">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="txt_emp_no" class="col-form-label">Employee Number</label>
								<select type="text" class="form-control" name="txt_emp_no" id="txt_emp_no" required style="width:100%;">
								</select>
							</div>
						</div>
					</div>
					<!--
						Old Code
					-->
					<!-- <div class="row" style="margin-top:-10px;">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="int_loan_amount" class="col-form-label">Salary Loan Amount</label>
								<input type="number" class="form-control"  name="int_loan_amount" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:-10px;">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="int_calamity_loan_amount" class="col-form-label">Calamity Loan Amount</label>
								<input type="number" class="form-control"  name="int_calamity_loan_amount" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
							</div>
						</div>
					</div> -->

					<!--
						Newly added
						-JD
					-->
					<div class="row">
						<div class="col-sm-4" style="padding-right: 0 !important">
							<div class="form-group">
								<label for="loan_code" class="col-form-label">Loan Code</label>
								<select type="text" class="form-control" name="loan_code" id="loan_code" required style="width:100%;">
									<option value="0" disabled selected>Select One</option>
									<option value="1">BDO</option>
									<option value="2">SSSAL</option>
									<option value="3">CAMLO</option>
									<option value="4">PBGSL</option>
									<option value="5">PBGCL</option>
									<option value="6">HSBC</option>
								</select>
							</div>
						</div>
						<div class="col-sm-8" style="padding-left: 0 !important">
							<div class="form-group">
								<label for="loan_description" class="col-form-label">Loan Description</label>
								<select class="form-control" name="loan_description" id="loan_description" disabled tabindex="-1" style="width:100%;">
									<option value="0" disabled selected>Select One</option>
									<option value="1">BDO Salary Loan</option>
									<option value="2">SSS Salary Loan</option>
									<option value="3">SSS Calamity Loan</option>
									<option value="4">PagIBIG Salary Loan</option>
									<option value="5">PagIBIG Calamity Loan</option>
									<option value="6">HSBC Salary Loan</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="principal_amount" class="col-form-label">Principal Amount</label>
								<input type="number" class="form-control principal_amount" id="principal_amount" required name="principal_amount" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="interest_rate" class="col-form-label">Interest Rate (%)</label>
								<input type="number" class="form-control" id="interest_rate" name="interest_rate" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="months_to_pay" class="col-form-label">Months to Pay <span class="text-danger text-lg" title="This will trigger the computation of Loan Amount">*</span></label>
								<input type="number" class="form-control months_to_pay" name="months_to_pay" id="months_to_pay" required>
							</div>
						</div>
					</div>
					<div class="row" id="div_loan_amount">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="int_loan_amount" class="col-form-label">Salary Loan Amount</label>
								<input type="number" class="form-control" id="int_loan_amount" name="int_loan_amount" readonly min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
							</div>
						</div>
					</div>
					<div class="row hidden" id="div_calamity_loan_amount">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="int_calamity_loan_amount" class="col-form-label">Calamity Loan Amount</label>
								<input type="number" class="form-control" id="int_calamity_loan_amount" name="int_calamity_loan_amount" readonly min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="frequency" class="col-form-label">Frequency</label>
								<select type="text" class="form-control"  name="frequency" id="frequency" required style="width:100%;">
									<option value="0" disabled selected>Select One</option>
									<option value="1" class="text-success">[1A] First Half of the Month</option>
									<option value="2">[1B] Second Half of the Month</option>
									<option value="3">[1C] First Week of the Month</option>
									<option value="4">[1D] Third Half of the Month</option>
									<option value="5" class="text-success">[2] First and Second Half of the Month</option>
									<option value="6">[4] Every Week</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="start_date" class="col-form-label">Start Date</label>
								<input type="date" class="form-control" id="start_date" required name="start_date">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<!-- <button type="submit" class="btn btn-primary" id="btnSave"><i class="fa fa-save" id="iconsSave"></i> Save</button> -->
					<button type="button" class="btn btn-primary" id="btnSave"><i class="fa fa-save" id="iconsSave"></i> Add</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="mdl_pagibig_loan_schedule_of_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" style="overflow-y:auto;">
	<div class="modal-dialog" style="width: 45% !important; min-width: 45% !important;">
		<div class="modal-content">
			<div class="modal-header" style="overflow-y:auto;">
				Pagibig Loan - Schedule of Payment
			</div>
			<form id="form_pagibig_loan_schedule_of_payment">
				<div class="modal-body" style="overflow-y:auto;">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-condensed table-hover" id="dt_pagibig_loan_schedule_of_payment" style="min-width: 100%">
							<thead>
								<th style="width: 15%">Date Paid</th> 
								<th style="width: 15%">Schedule of Payment</th>
								<th style="width: 15%">Principal</th>
								<th style="width: 15%">Interest</th>
								<th style="width: 15%">Balance</th>
								<th style="width: 15%">Hold Payment</th>
							</thead>
						</table>
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

<!-- <script src="./js/common_functions.js?1234567"></script> -->
<script>
	$(document).ready(function () {
		handler_pagibig = './handler/handler_pagibig.php';

		dt_pagibig_loan = $('#dt_pagibig_loan').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "./server_side_scripts/pagibig/dt_pagibig_loan.php",
			"drawCallback": function( settings ) {
				$('#t_leaves').attr('style','width:100%;');
			}
		});
		$('#btnLeaves').click(function () { 
			$('#mdl_pagibig_loan_create').modal('show');
			// dd_hris_all_list
			re_initialize_select2_server_side('#mdl_pagibig_loan_create #txt_emp_no','#mdl_pagibig_loan_create #frm_pagibig_loan_create',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
		});
		$('#btnImportData').click(function () { 
			var $buttonId 	= $('#formImportData #btnSave');
			var $iconId		= $("#formImportData #iconsSave");
			buttonEnabledClass($buttonId,$iconId);
			$('#mdlImportData').modal('show');
			// dd_hris_all_list
			re_initialize_select2_server_side('#mdl_pagibig_loan_create #txt_emp_no','#mdl_pagibig_loan_create #frm_pagibig_loan_create',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
		
		});

		$('#formImportData').submit(function (e) { 
			e.preventDefault();
			var $buttonId 	= $('#formImportData #btnSave');
			var $iconId		= $("#formImportData #iconsSave");

			let serialize_data = new FormData(this);
			serialize_data.append('action',"import_pagibig_loan_data");
			$.ajax({
				type: "POST",
				url: handler_pagibig,
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
						dt_pagibig_loan.draw();
						buttonEnabledClass($buttonId,$iconId);
						$('#mdlImportData').modal('hide');
						$('#formImportData')[0].reset();
					}
					else{
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


		// dt_pagibig_loan = $('#dt_pagibig_loan_schedule_of_payment').DataTable({
		// 	"aaSorting"	 : [],
		// 	"bProcessing": true,
		// 	"bServerSide": true,
		// 	"sAjaxSource": "./server_side_scripts/pagibig/dt_pagibig_loan_schedule_of_payment.php",
		// });
		$('#frm_pagibig_loan_create').submit(function (e) { 
			e.preventDefault();
			console.log('trigger frm_pagibig_loan_create');
			var $buttonId 	= $('#frm_update_leaves #btnSave');
			var $iconId		= $("#frm_update_leaves #iconsSave");
			let action = {
				'action'				: 'create_pagibig_loan',
				'scheduleOfPaymentArray': scheduleOfPaymentArray
			};
			let data = $.param(action) +'&'+ $(this).serialize() +'&'+$.param(scheduleOfPaymentArray);
			console.log('data ', data);

			$.ajax({
				type: "POST",
				url: handler_pagibig,
				data: data,
				dataType: "json",
				beforeSend: function(){
					buttonDisabledClass($buttonId,$iconId);
				},
				success: function (response) {
					if(response['result']=="success"){
						notif_success("Created Successfully");
						dt_pagibig_loan.draw();
						buttonEnabledClass($buttonId,$iconId);
						$('#mdl_pagibig_loan_create').modal('hide');
						$('#frm_pagibig_loan_create')[0].reset();
					}else if(response['result']=="updated"){
						notif_success("Updated Successfully");
						dt_pagibig_loan.draw();
						buttonEnabledClass($buttonId,$iconId);
						$('#mdl_pagibig_loan_create').modal('hide');
						$('#frm_pagibig_loan_create')[0].reset();
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
		
		$('#dt_pagibig_loan').on('click','.data-edit',function () {
			let pkid = $(this).attr('data-id');
			console.log(pkid);
			readPagibigInfo(pkid);
			$('#mdl_pagibig_loan_create').modal('show');
		});
		$('#dt_pagibig_loan').on('click','.data-view',function () {
			let pkid = $(this).attr('data-id');
			console.log(pkid);
			readPagibigLoanDetails(pkid);
			$('#btnSave', $('#form_pagibig_loan_schedule_of_payment')).addClass('hidden'); // Add class hidden to remove Submit button when in View mode
			$('#mdl_pagibig_loan_schedule_of_payment').modal('show');
		});

		$('#dt_pagibig_loan').on('click','.data-set-paid',function () {
			let answer = window.confirm("Set as paid?");
			if (answer) {
				let pkid = $(this).attr('data-id');
				let array_data = {
					'action' : 'set_paid',
					'pkid'	 : pkid
				};
				let data = $.param(array_data);
				console.log('data ', data);
				$.ajax({
					type: "POST",
					url: handler_pagibig,
					data: data,
					dataType:  "json",
					success: function (response) {
						console.log('response ', response['result']);
						if(response['result']=="updated"){
							notif_success("Updated Successfully");
						}
					}
				});
			}
			else {
				console.log(`Not Paid`);
			}
		});
		
		/**
		 * Update Pagibig Loan
		 * Change logic for adding/updating
		 * -JD
		 */
		// $('#frm_pagibig_loan_create').submit(function (e) { 
		// 	e.preventDefault();
		// 	var $buttonId 	= $('#frm_pagibig_loan_create #btnSave');
		// 	var $iconId		= $("#frm_pagibig_loan_create #iconsSave");
		// 	let action = {
		// 		'action' : 'update_pagibig_loan'
		// 	};
		// 	let data = $.param(action) +'&'+ $(this).serialize();
		// 	$.ajax({
		// 		type: "POST",
		// 		url: handler_pagibig,
		// 		data: data,
		// 		dataType: "json",
		// 		beforeSend: function(){
		// 			buttonDisabledClass($buttonId,$iconId);
		// 		},
		// 		success: function (response) {
		// 			if(response['result']=="success"){
		// 				notif_success("Updated Successfully");
		// 				dt_pagibig_loan.draw();
		// 				buttonEnabledClass($buttonId,$iconId);
		// 				$('#mdl_pagibig_loan_create').modal('hide');
		// 			}else{
		// 				alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
		// 			}
		// 		},
		// 		error:function(response){
		// 			console.log('error: '+response);
		// 			buttonDisabledClass($buttonId,$iconId);
		// 			alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
		// 		}
		// 	});
		// });

		function readPagibigInfo(pkid){
			let array_data = {
				'action' : 'read_pagibig_loan',
				'pkid'	 : pkid
			};
			let data = $.param(array_data);
			$.ajax({
				type: "POST",
				url: handler_pagibig,
				data: data,
				dataType:  "json",
				success: function (response) {
					console.log('response ',response);
					$('#frm_pagibig_loan_create input[name="data_id"]').val(response['id'][0]);
					$('#frm_pagibig_loan_create select[name="loan_code"]').val(response['loan_code'][0]).trigger('change');
					$('#frm_pagibig_loan_create input[name="int_loan_amount"]').val(response['loan_amount'][0]);
					$('#frm_pagibig_loan_create input[name="int_calamity_loan_amount"]').val(response['calamity_loan_amount'][0]);
					$('#frm_pagibig_loan_create input[name="principal_amount"]').val(response['principal_amount'][0]);
					$('#frm_pagibig_loan_create input[name="interest_rate"]').val(response['interest_rate'][0]);
					$('#frm_pagibig_loan_create input[name="months_to_pay"]').val(response['months_to_pay'][0]);
					$('#frm_pagibig_loan_create select[name="frequency"]').val(response['frequency'][0]).trigger('change');
					$('#frm_pagibig_loan_create input[name="start_date"]').val(response['start_date'][0]);
					
					assign_value_select2('#frm_pagibig_loan_create #txt_emp_no',response['emp_no'][0]);
					re_initialize_select2_server_side('#mdl_pagibig_loan_create #txt_emp_no','#mdl_pagibig_loan_create #frm_pagibig_loan_create',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
				}
			});
		}
		/**
		 * Pagibig Loan Details
		 */
		function readPagibigLoanDetails(pkid){
			let array_data = {
				'action' : 'read_pagibig_loan_details',
				'pkid'	 : pkid
			};
			let data = $.param(array_data);
			$.ajax({
				type: "POST",
				url: handler_pagibig,
				data: data,
				dataType:  "json",
				success: function (response) {
					let scheduleOfPaymentArray = response['scheduleOfPaymentArray'];
					console.log('scheduleOfPaymentArray ', scheduleOfPaymentArray);
					dt_pagibig_loan_schedule_of_payment.rows.add(
						scheduleOfPaymentArray
					).draw();
				}
			});
		}
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

		/**
		 * The scripts below is newly added for new process of adding in Pagibig Loan
		 * as of January 2024
		 * -JD
		 */
		
		/* Clear form values */
		$("#mdl_pagibig_loan_create").on('hidden.bs.modal', function () {
			console.log('mdl_pagibig_loan_create is closed');
			$('#frm_pagibig_loan_create')[0].reset();
			$('#txt_emp_no', '#frm_pagibig_loan_create').val(null).trigger('change');
			$('#data_id', '#frm_pagibig_loan_create').val(null);
		});
		
		$("#mdl_pagibig_loan_schedule_of_payment").on('hidden.bs.modal', function () {
			console.log('mdl_pagibig_loan_schedule_of_payment is closed');
			dt_pagibig_loan_schedule_of_payment.clear();
		});

		$('#loan_code').on('change', function(event) {
			$(`#loan_description`).find(`option`).prop("selected", false);
			$(`#loan_description`).find(`option[value=${$(this).val()}]`).prop("selected", true);

			/* Clear inputted amount when loan_code change */
			$('#int_loan_amount').val('');
			$('#int_calamity_loan_amount').val('');
			$('#months_to_pay').val('');

			// Showing/Hiding of Salary/Calamity Loan inputs based on selected loan_code
			let loanDescription = $(`#loan_description`).find(`option[value=${$(this).val()}]`).text();
			if(loanDescription.includes('Salary')){
				$('#div_calamity_loan_amount').addClass('hidden');
				$('#div_loan_amount').removeClass('hidden');
			}

			if(loanDescription.includes('Calamity')){
				$('#div_loan_amount').addClass('hidden');
				$('#div_calamity_loan_amount').removeClass('hidden');
			}
		});
		
		$('#months_to_pay').keydown(function(event) {
			if (event.which != 8 && event.which != 0 && event.which < 48 || event.which > 57){
				event.preventDefault();
			}
		});

		function delay(fn, ms) {
			let timer = 0
			return function(...args) {
				clearTimeout(timer)
				timer = setTimeout(fn.bind(this, ...args), ms || 0)
			}
		}
		$('#months_to_pay').keyup(delay(function(event) {
			let monthsToPay = $(this).val();
			console.log('monthsToPay ', monthsToPay);
			let principalAmount = $(`.principal_amount`).val();
			console.log('principalAmount ', principalAmount);
			let amortization = principalAmount / monthsToPay;
			console.log('amortization ', amortization);

			let loanDescription = $(`#loan_description`).find(":selected").text();
			// console.log('loan_description ', loanDescription);
			
			if(loanDescription.includes('Salary')){
				$('#int_loan_amount').val(amortization.toFixed(2));
			}
			if(loanDescription.includes('Calamity')){
				$('#int_calamity_loan_amount').val(amortization.toFixed(2));
			}
			generateScheduleOfPayment();
		}, 500));

		/**
		 * DataTables for Pagibig Loan Schedule of Payment
		 */
		let scheduleOfPaymentArray = [];
		let dt_pagibig_loan_schedule_of_payment = $('#dt_pagibig_loan_schedule_of_payment').DataTable({
			"ordering": false,
			"columns": [
				{ "data": "date_paid" },
				{ "data": "schedule_of_payment" },
				{ "data": "principal" },
				{ "data": "interest" },
				{ "data": "balance" },
				{ "data" : "hold_payment" }
			],
		});

		function checkIfEven(number){
			if (number % 2 === 0) {
				return true;
			} else {
				return false;
			}
		}
		function addMonths(date, addMonth, frequency) {
			let fullDate;
			if(frequency == 1){
				fullDate = moment(date).add(addMonth, 'months').format('DD-MMM-YY');
			}else if(frequency == 5){
				const isEven = checkIfEven(addMonth);
				console.log(`${addMonth} isEven: ${isEven}`);
				
				let momentYear = moment(date).year();
				let momentMonth = moment(date).month();
				let momentDate = moment(date).date();
				let parseDate = [momentYear, momentMonth, momentDate];
				let momentSetDate;
				console.log(`parseDate ${momentYear}-${momentMonth}-${momentDate}`);
				if(isEven){
					momentSetDate = 15;
				}else{
					momentSetDate = 30;
				}
				fullDate = moment(parseDate).date(momentSetDate).add(addMonth / 2, 'months').format('DD-MMM-YY');
				console.log(`fullDate ${fullDate}`);
			}
			return fullDate;
		}
		function deductBalanceByPrincipal(principalAmount, amortizationLoanAmount, multiplier) {
			return (parseFloat(principalAmount) - (parseFloat(amortizationLoanAmount) * multiplier)).toFixed(2);
		}
		// function checkIfScheduleOfPaymentPosted(schedule_of_payment){
		// 	let array_data = {
		// 		'action' : 'is_schedule_of_payment_posted',
		// 		'schedule_of_payment': schedule_of_payment
		// 	};
		// 	let data = $.param(array_data);
		// 	console.log('data ', data);
		// 	$.ajax({
		// 		type: "POST",
		// 		url: handler_pagibig,
		// 		data: data,
		// 		dataType: "json",
		// 		success: function (response) {
		// 			console.log('response payrollInfo', response['payrollInfo']);
		// 		}
		// 	});
		// }

		function generateScheduleOfPayment(){
			let startDate = $('#start_date').val(); // 2024-01-30
			let monthsToPay = $('#months_to_pay').val();
			let interestRate = $('#interest_rate').val();
			let principalAmount = $('#principal_amount').val();
			let amortizationLoanAmount;
			let monthsToPayByFrequency;
			if(startDate != '' && monthsToPay != ''){
				/* Computation for First Half of the Month */
				let frequency = $('#frequency').val();
				if(frequency == 1){
					let loanDescription = $(`#loan_description`).find(":selected").text();
					if(loanDescription.includes('Salary')){
						amortizationLoanAmount = $('#int_loan_amount').val();
					}
					if(loanDescription.includes('Calamity')){
						amortizationLoanAmount = $('#int_calamity_loan_amount').val();
					}
					monthsToPayByFrequency = monthsToPay;
				}
				/* Computation for First and Second Half of the Month */
				else if(frequency == 5){
					monthsToPayByFrequency = monthsToPay * 2;
					amortizationLoanAmount = principalAmount / (monthsToPayByFrequency);
				}
				
				/**
				 * This will compute and generate Schedule of Payment to append in table format
				 */
				scheduleOfPaymentArray = []; // this will clear scheduleOfPaymentArray values to avoid duplicate values before appending the new data
				for(let i = 0; i < monthsToPayByFrequency; i++){
					// let scheduleOfPayment = addMonths(moment(startDate), i, frequency, monthsToPayByFrequency);
					let scheduleOfPayment = addMonths(moment(startDate), i, frequency);
					let balance = deductBalanceByPrincipal(principalAmount, amortizationLoanAmount, i+1)
					// let isScheduleOfPaymentPosted = checkIfScheduleOfPaymentPosted(moment(scheduleOfPayment).format('YYYY-MM-DD'));
					scheduleOfPaymentArray.push(
						{
							"date_paid":			'',
							"schedule_of_payment":	scheduleOfPayment,
							"principal":			parseFloat(amortizationLoanAmount).toFixed(2),
							"interest":				`${parseFloat(interestRate).toFixed(2)}%`,
							"balance":				balance,
							"hold_payment":			"0"
						}
					);
				}
				console.log(`${JSON.stringify(scheduleOfPaymentArray)}`);
			}
		}
		$('#frequency, #start_date').each(function(){
			$(this).on('change', function(event) {
				generateScheduleOfPayment();
			});
		});

		$('#btnSave', $('#frm_pagibig_loan_create')).on('click',function (e) {
			console.log('frm_pagibig_loan_create');
			$('#btnSave', $('#form_pagibig_loan_schedule_of_payment')).removeClass('hidden'); // Remove class hidden to show Submit button when in Edit mode

			let loanCode = $('#loan_code').val();
			let principalAmount = $('#principal_amount', $('#frm_pagibig_loan_create')).val();
			let interestRate = $('#interest_rate', $('#frm_pagibig_loan_create')).val();
			let monthsToPay = $('#months_to_pay', $('#frm_pagibig_loan_create')).val();
			let frequency = $('#frequency', $('#frm_pagibig_loan_create')).val();
			let startDate = $('#start_date', $('#frm_pagibig_loan_create')).val();
			if(loanCode != '' && principalAmount != '' && interestRate != '' && monthsToPay != '' && frequency != '' && startDate != ''){
				generateScheduleOfPayment();
				dt_pagibig_loan_schedule_of_payment.rows.add(
					scheduleOfPaymentArray
				).draw();
				$('#mdl_pagibig_loan_schedule_of_payment').modal('show');
			}else{
				notif_error("Please fill required fields");
			}
		});

		$('#btnSave', $('#form_pagibig_loan_schedule_of_payment')).on('click',function (e) {
			e.preventDefault();
			$('#frm_pagibig_loan_create').trigger('submit');
			$('#mdl_pagibig_loan_schedule_of_payment').modal('hide');
		});

		/**
		 * Added on 10-29-24
		 * Basta paulo
		 */
		$('#btnDelete').click(function (e) {  
			e.preventDefault();
			if (confirm('Are you sure you want to delete?')) {
				let action = {
					'action' : 'delete_pagibig_loan'
				};
				let data = $.param(action);
				$.ajax({
					type: "POST",
					url: handler_pagibig,
					data: data,
					dataType: "json",
					success: function (response) {
						if(response['result']=="success"){
							dt_pagibig_loan.draw();
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
	}); //end
</script>
</body>
</html>
