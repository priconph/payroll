<html>
<head>
</head>
<body>	

<section class="main">		
	<section class="tab-pane active fade in content">
		<div class="row">
			<div class="col">
				<div class="panel panel-primary">
					<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Taxes Table</i>
					</div>
					<div class="panel-body">
					<div class="row">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tax_info" aria-controls="tax_info" role="tab" data-toggle="tab"> Tax Info</a></li>
                                <li role="presentation"><a href="#tax_base" aria-controls="tax_base" role="tab" data-toggle="tab"> Tax Base</a></li>
                                <li role="presentation"><a href="#annual_tax" aria-controls="annual_tax" role="tab" data-toggle="tab"> Annual Tax YTD</a></li>
                            </ul>
                            <!-- Tab panel Tax Info-->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="tax_info">
									<div class="row">
										<div class="col-sm-6">
											<button class="btn btn-primary fa pull-left" id="btnTaxes" data-toggle="modal" data-target="#mdlTaxes"><i class="fa fa-plus"></i> New</button>
											<button class="btn btn-success fa pull-left" id="btnImportTaxes" data-toggle="modal" data-target="#importTaxes"><i class="fa fa-upload"></i> Import Data</button><br><br>
										</div>
									</div>
									<br>	
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-condensed table-hover" id="t_taxes">
											<thead>
												<th  style="width: 15%;">Employee Number</th>
												<th  style="width: 15%;">Salary Adjustments</th>
												<th  style="width: 15%;">Other Earnings</th>
												<th  style="width: 15%;">Advances/Other Deductions</th>
												<th  style="width: 15%;">Tax Adjustments</th>
												<th  style="width: 10%;">Action</th>
											</thead>
										</table>
									</div>
								</div>
                                <!-- Tab panel Tax Base-->
                                <div role="tabpanel" class="tab-pane" id="tax_base">
									<div class="row">
										<div class="col-sm-6">
											<button class="btn btn-primary fa pull-left" id="btnNewTaxBase" data-toggle="modal" data-target="#mdlNewTaxBase"><i class="fa fa-plus"></i> New</button>
										</div>
									</div>
									<br>
                                    <div class="table-responsive">
										<table class="table table-striped table-bordered table-condensed table-hover" id="t_tax_base">
											<thead>
												<th style="width: 20%;">Tax Base</th>
												<th style="width: 20%;">Tax Rate</th>
												<th style="width: 20%;">Lower Limit</th>
												<th style="width: 20%;">Upper Limit</th>
												<th style="width: 10%;">Action</th>
											</thead>
										</table>
                                    </div>
                                </div>
                                <!-- Tab panel Annual Tax-->
                                <div role="tabpanel" class="tab-pane" id="annual_tax">
									<div class="row">
										<div class="col-sm-6">
											<button class="btn btn-primary fa pull-left" id="btnCreateAnnualTax" data-toggle="modal" data-target="#mdlCreateAnnualTax"><i class="fa fa-plus"></i> New</button>
											<button class="btn btn-success fa pull-left" id="btnImportAnnualTaxYTD" data-toggle="modal" data-target="#importAnnualTaxYTD"><i class="fa fa-upload"></i> Import Data</button><br><br>
										</div>
									</div>
									<br>	
                                    <div class="table-responsive">
										<table class="table table-striped table-bordered table-condensed table-hover" id="t_annual_taxes">
											<thead>
												<th>Employee Number</th>
												<th>Gross Income YTD</th>
												<th>Forecast Earnings</th>
												<th>Less Ytd Tax Exempt</th>
												<th>Yt Tax Withheld</th>
												<th>Other Taxes</th>
												<th>Action</th>
											</thead>
										</table>
                                    </div>
                                </div>
                                
							</div>

						<div class="row">
							<!-- Tab panes -->
							
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
<div class="modal fade" id="mdl_taxes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" style="margin-top:0%;">
		<div class="modal-content">
			<div class="modal-header" style="overflow-y:auto;">
				New Taxes Info
			</div>
			<form id="frm_taxes">
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
									<label for="dt_start_date" class="col-form-label">Salary Adjustments</label>
									<!-- <input type="number" class="form-control"  name="txt_salary_adjustments" step = "0.01" pattern="^\d*(\.\d{0,2})?$"> -->
									<input type="text" class="form-control"  name="txt_salary_adjustments">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Other Earnings</label>
									<!-- <input type="number" class="form-control"  name="txt_other_earnings" step = "0.01" pattern="^\d*(\.\d{0,2})?$"> -->
									<input type="text" class="form-control"  name="txt_other_earnings">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Advances/Other Deductions</label>
									<!-- <input type="number" class="form-control"  name="txt_ad_deduc" step = "0.01" pattern="^\d*(\.\d{0,2})?$"> -->
									<input type="text" class="form-control"  name="txt_ad_deduc">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Tax Adjustments</label>
									<!-- <input type="number" class="form-control"  name="txt_tax_adjustment" step = "0.01" pattern="^\d*(\.\d{0,2})?$"> -->
									<input type="text" class="form-control"  name="txt_tax_adjustment">
								</div>
							</div>
						</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!---------------------
Update Modal
---------------------->
<div class="modal fade" id="mdl_update_taxes" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" style="margin-top:0%;">
		<div class="modal-content">
			<div class="modal-header" style="overflow-y:auto;">
				Update Taxes Info
			</div>
			<form id="frm_update_taxes">
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
										<label for="dt_start_date" class="col-form-label">Employee Number</label>
										<select type="text" class="form-control"  name="txt_emp_no" id="txt_emp_no" style="width:100%;">
										</select>
									</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Salary Adjustments</label>
									<input type="number" class="form-control"  name="txt_salary_adjustments">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Other Earnings</label>
									<input type="number" class="form-control"  name="txt_other_earnings">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Advances/Other Deductions</label>
									<input type="number" class="form-control"  name="txt_ad_deduc">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Tax Adjustments</label>
									<input type="number" class="form-control"  name="txt_tax_adjustment">
								</div>
							</div>
						</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- Modal for system message -->
<div class="modal fade" tabindex="-1" role="dialog" id="importTaxes" data-backdrop="static">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-file-excel-o"></i> Import Taxessss</h4>
      </div>
	  	<form id="formImportTaxes" method="" enctype="multipart/form-data">
		  <div class="modal-body">
			<!-- <label class="col-md-4 control-label">Choose CSV File</label>
			<input type="file" name="oem_file" id="fileOEM" accept=".csv"> -->
			<div class="form-group">
				<label for="file">Choose CSV File</label>
				<input type="file" name="file" class="form-control-file" id="file" accept=".csv" required>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-success" name="import" id="btnImport"><i class="fa fa-upload" id="importIcons"></i> Import</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--
	Import Annual Tax YTD
	04-18-2024
-->
<div class="modal fade" tabindex="-1" role="dialog" id="importAnnualTaxYTD" data-backdrop="static">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-file-excel-o"></i> Import Annual Tax YTD</h4>
      </div>
	  	<form id="formImportAnnualTaxYTD" method="" enctype="multipart/form-data">
		  <div class="modal-body">
			<div class="form-group">
				<label for="file">Choose CSV File</label>
				<input type="file" name="file" class="form-control-file" id="file" accept=".csv" required>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-success" name="import" id="btnImport"><i class="fa fa-upload" id="importIcons"></i> Import</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- ################################ TAX BASE ################################# -->
<!--------------------- Create Modal (TAX BASE) ---------------------->
<div class="modal fade" id="mdl_NewTaxBase" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" style="margin-top:0%;">
		<div class="modal-content">
			<div class="modal-header" style="overflow-y:auto;">
				New Tax Base Data
			</div>
			<form id="frm_new_tax_base">
				<div class="modal-body" style="overflow-y:auto;">
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_tax_base" class="col-form-label">Tax Base</label>
									<input type="number" class="form-control" id="txt_tax_base" name="tax_base">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_tax_rate" class="col-form-label">Tax Rate</label>
									<input type="number" class="form-control" id="txt_tax_rate" name="tax_rate">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_lower_limit" class="col-form-label">Lower Limit</label>
									<input type="number" class="form-control" id="txt_lower_limit" name="lower_limit">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_upper_limit" class="col-form-label">Upper Limit</label>
									<input type="number" class="form-control" id="txt_upper_limit" name="upper_limit">
								</div>
							</div>
						</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!--------------------- Update Modal (TAX BASE) ---------------------->
<div class="modal fade" id="mdl_update_tax_base" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" style="margin-top:0%;">
		<div class="modal-content">
			<div class="modal-header" style="overflow-y:auto;">
				Update Tax Base Data
			</div>
			<form id="frm_update_tax_base">
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
									<label for="txt_tax_base" class="col-form-label">Tax Base</label>
									<input type="number" class="form-control" id="txt_tax_base" name="tax_base" step = "0.01" pattern="^\d*(\.\d{0,2})?$">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_tax_rate" class="col-form-label">Tax Rate</label>
									<input type="number" class="form-control" id="txt_tax_rate" name="tax_rate" step = "0.01" pattern="^\d*(\.\d{0,2})?$">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_lower_limit" class="col-form-label">Lower Limit</label>
									<input type="number" class="form-control" id="txt_lower_limit" name="lower_limit" step = "0.01" pattern="^\d*(\.\d{0,2})?$">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_upper_limit" class="col-form-label">Upper Limit</label>
									<input type="number" class="form-control" id="txt_upper_limit" name="upper_limit" step = "0.01" pattern="^\d*(\.\d{0,2})?$">
								</div>
							</div>
						</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- ################################ ANNUAL TAX ################################# -->
<!--------------------- Create Modal (ANNUAL TAX) ---------------------->
<div class="modal fade" id="mdlCreateAnnualTax" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" style="margin-top:0%;">
		<div class="modal-content">
			<div class="modal-header" style="overflow-y:auto;">
				New Annual Tax Info
			</div>
			<form id="frm_create_annual_tax">
				<div class="modal-body" style="overflow-y:auto;">
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_emp_no" class="col-form-label">Employee Number</label>
									<select type="text" class="form-control"  name="txt_emp_no" id="txt_emp_no" style="width:100%;">
									</select>
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_gross_income" class="col-form-label">Gross Income YTD</label>
									<input type="number" class="form-control" id="txt_gross_income" name="txt_gross_income" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_forecast_earnings" class="col-form-label">Forecast Earnings</label>
									<input type="number" class="form-control" id="txt_forecast_earnings" name="txt_forecast_earnings" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_tax_exempt" class="col-form-label">Less Ytd Tax Exempt</label>
									<input type="number" class="form-control" id="txt_tax_exempt" name="txt_tax_exempt" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_tax_withheld" class="col-form-label">Yt Tax Withheld</label>
									<input type="number" class="form-control" id="txt_tax_withheld" name="txt_tax_withheld" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_annual_tax_others" class="col-form-label">Other Taxes</label>
									<input type="number" class="form-control" id="txt_annual_tax_others" name="txt_annual_tax_others" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
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
</div>
<!--------------------- Update Modal (ANNUAL TAX) ---------------------->
<div class="modal fade" id="mdlUpdateAnnualTax" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" style="margin-top:0%;">
		<div class="modal-content">
			<div class="modal-header" style="overflow-y:auto;">
				Update Annual Tax Info
			</div>
			<form id="frm_update_annual_tax">
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
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_gross_income" class="col-form-label">Gross Income YTD</label>
									<input type="number" class="form-control" id="txt_gross_income" name="txt_gross_income" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_forecast_earnings" class="col-form-label">Forecast Earnings</label>
									<input type="number" class="form-control" id="txt_forecast_earnings" name="txt_forecast_earnings" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_tax_exempt" class="col-form-label">Less Ytd Tax Exempt</label>
									<input type="number" class="form-control" id="txt_tax_exempt" name="txt_tax_exempt" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_tax_withheld" class="col-form-label">Yt Tax Withheld</label>
									<input type="number" class="form-control" id="txt_tax_withheld" name="txt_tax_withheld" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group">
									<label for="txt_up_annual_tax_others" class="col-form-label">Other Taxes</label>
									<input type="number" class="form-control" id="txt_up_annual_tax_others" name="txt_up_annual_tax_others" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$">
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
</div>
<!-- <script src="./js/common_functions.js?09876"></script> -->
<script>
	$(document).ready(function () {
		handler_payroll_info = './handler/handler_payroll_info.php';
		handler_taxes = './handler/handler_taxes.php';

		/* ######################################## TAX INFO ###################################### */
		dt_taxes = $('#t_taxes').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "./server_side_scripts/taxes/dt_taxes.php",
			"drawCallback": function( settings ) {
				$('#t_taxes').attr('style','width:100%;');
			}
		});
		$('#t_taxes').on('click','.taxes-data-edit',function () {
			let pkid = $(this).attr('data-id');
			readTaxesInfo(pkid);
			$('#mdl_update_taxes').modal('show');
		});
		$('#frm_taxes').submit(function (e) { 
			e.preventDefault();
			let action = {
				'action' : 'create_taxes'
			};
			let data = $.param(action) +'&'+ $(this).serialize();
			$.ajax({
				type: "POST",
				url: handler_taxes,
				data: data,
				dataType: "json",
				success: function (response) {
					if(response['result']=="success"){
						notif_success("Created Successfully");
						$('#mdl_taxes').modal('hide');
						$('#frm_taxes')[0].reset();
						dt_taxes.draw();
					}else{
						alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
					}
				},error: function (response){
					console.log('error: '+response);
					alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
				}
			});
		});
		$('#frm_update_taxes').submit(function (e) { 
			e.preventDefault();
			let action = {
				'action' : 'update_taxes'
			};
			let data = $.param(action) +'&'+ $(this).serialize();
			$.ajax({
				type: "POST",
				url: handler_taxes,
				data: data,
				dataType: "json",
				success: function (response) {
					if(response['result']=="success"){
						notif_success("Updated Successfully");
						$('#mdl_update_taxes').modal('hide');
						dt_taxes.draw();
					}else{
						alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
					}
				},
				error:function(response){
					console.log('error: '+response);
					alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
				}
			});
		});
		/* ######################################## TAX BASE DATA ###################################### */
		dt_tax_base = $('#t_tax_base').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "./server_side_scripts/taxes/dt_tax_base.php",
			"drawCallback": function( settings ) {
				$('#t_tax_base').attr('style','width:100%;');
			}
		});
		/* Tax Base */
		$('#frm_new_tax_base').submit(function (e) { 
			e.preventDefault();
			let action = {
				'action' : 'create_tax_base'
			};
			let data = $.param(action) +'&'+ $(this).serialize();
			$.ajax({
				type: "POST",
				url: handler_taxes,
				data: data,
				dataType: "json",
				success: function (response) {
					if(response['result']=="success"){
						notif_success("Created Successfully");
						$('#mdl_NewTaxBase').modal('hide');
						$('#frm_new_tax_base')[0].reset();
						dt_tax_base.draw();
					}else{
						alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
					}
				},error: function (response){
					console.log('error: '+response);
					alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
				}
			});
		});
		$('#btnTaxes').click(function () { 
			$('#mdl_taxes').modal('show');
			re_initialize_select2_server_side('#mdl_taxes #txt_emp_no','#mdl_taxes #frm_taxes',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
		});
		$('#t_tax_base').on('click','.edit_tax_base_data',function () {
			let pkid = $(this).attr('data-id');
			getTaxBaseDataForEditting(pkid);
			$('#mdl_update_tax_base').modal('show');
		});
		$('#frm_update_tax_base').submit(function (e) { 
			e.preventDefault();
			let action = {
				'action' : 'update_tax_base_data'
			};
			let data = $.param(action) +'&'+ $(this).serialize();
			$.ajax({
				type: "POST",
				url: handler_taxes,
				data: data,
				dataType: "json",
				success: function (response) {
					if(response['result']=="success"){
						notif_success("Updated Successfully");
						$('#mdl_update_tax_base').modal('hide');
						dt_tax_base.draw();
					}else{
						alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
					}
				},
				error:function(response){
					console.log('error: '+response);
					alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
				}
			});
		});
		/* ######################################## ANNUAL TAX DATA ###################################### */
		dt_annual_taxes = $('#t_annual_taxes').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "./server_side_scripts/taxes/dt_annual_taxes.php",
			"drawCallback": function( settings ) {
				$('#t_annual_taxes').attr('style','width:100%;');
			}
		});
		/* Annual Tax */
		$('#btnCreateAnnualTax').click(function () { 
			re_initialize_select2_server_side('#mdlCreateAnnualTax #txt_emp_no','#mdlCreateAnnualTax #frm_create_annual_tax',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
		});
		$('#t_annual_taxes').on('click','.edit-annual-tax-data',function () {
			let pkid = $(this).attr('data-id');
			readAnnualTaxData(pkid);
			$('#mdlUpdateAnnualTax').modal('show');
		});
		$('#frm_create_annual_tax').submit(function (e) { 
			e.preventDefault();
			var $buttonId 	= $('#frm_create_annual_tax #btnSave');
			var $iconId		= $("#frm_create_annual_tax #iconsSave");
			let action = {
				'action' : 'create_annual_tax'
			};
			let data = $.param(action) +'&'+ $(this).serialize();
			console.log('data ', data);
			$.ajax({
				type: "POST",
				url: handler_taxes,
				data: data,
				dataType: "json",
				success: function (response) {
					if(response['result']=="success"){
						dt_annual_taxes.draw();
						notif_success("Created Successfully");
						buttonEnabledClass($buttonId,$iconId);
						$('#mdlCreateAnnualTax').modal('hide');
						$('#frm_create_annual_tax')[0].reset();
						
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
		$('#frm_update_annual_tax').submit(function (e) { 
			e.preventDefault();
			var $buttonId 	= $('#frm_update_annual_tax #btnSave');
			var $iconId		= $("#frm_update_annual_tax #iconsSave");
			let action = {
				'action' : 'update_annual_tax'
			};
			let data = $.param(action) +'&'+ $(this).serialize();
			$.ajax({
				type: "POST",
				url: handler_taxes,
				data: data,
				dataType: "json",
				beforeSend: function(){
					buttonDisabledClass($buttonId,$iconId);
				},
				success: function (response) {
					if(response['result']=="success"){
						dt_annual_taxes.draw();
						notif_success("Updated Successfully");
						buttonEnabledClass($buttonId,$iconId);
						$('#mdlUpdateAnnualTax').modal('hide');
					}else{
						alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
					}
				},
				error: function(error){
					console.log('error: '+error);
					buttonDisabledClass($buttonId,$iconId);
					alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
				}
			});
		});
		/**************
		 	IMPORTS 
		***************/
		$('#formImportTaxes').submit(function (e) { 
			e.preventDefault();
			// formImportTaxes
			let serialize_data = new FormData(this);
			serialize_data.append('action',"import_taxes_data");
			$.ajax({
				url: handler_taxes,
				type:"POST",
				data: serialize_data,
				dataType:'json',
                cache: false,
				contentType:false,
				processData:false,
				beforeSend: function(){
					$('#btnImport').prop('disabled', true);
					$("#importIcons").addClass('fa fa-spinner fa-pulse');
				},
				success:function(data)
				{
					$('#importTaxes').modal('hide');
					$('#formImportTaxes')[0].reset();
					notif_success('Import Successfully');
					dt_taxes.draw();
					$('#btnImport').prop('disabled', false);
					$("#importIcons").removeClass('fa fa-spinner fa-pulse');
					$("#importIcons").addClass('fa fa-upload');
				},
				error: function(data, xhr, status){
                    console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
					$('#btnImport').prop('disabled', false);
					notif_error('Import Failed. Please try again.');
					$("#importIcons").removeClass('fa fa-spinner fa-pulse');
					$("#importIcons").addClass('fa fa-upload');
                }
			});
		});
		
		/**
		 * Import Annual Tax YTD
		 * Added by JD on 04-18-2024
		 */
		$('#formImportAnnualTaxYTD').submit(function (e) { 
			e.preventDefault();
			// formImportAnnualTaxYTD
			let serialize_data = new FormData(this);
			serialize_data.append('action',"import_annual_tax_ytd");
			$.ajax({
				url: handler_taxes,
				type:"POST",
				data: serialize_data,
				dataType:'json',
                cache: false,
				contentType:false,
				processData:false,
				beforeSend: function(){
					// $('#btnImport').prop('disabled', true);
					// $("#importIcons").addClass('fa fa-spinner fa-pulse');
				},
				success:function(data)
				{
					$('#importAnnualTaxYTD').modal('hide');
					$('#formImportAnnualTaxYTD')[0].reset();
					notif_success('Import Successfully');
					dt_annual_taxes.draw();

					// $('#btnImport').prop('disabled', false);
					// $("#importIcons").removeClass('fa fa-spinner fa-pulse');
					// $("#importIcons").addClass('fa fa-upload');
				},
				error: function(data, xhr, status){
                    console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
					notif_error('Import Failed. Please try again.');
					// $('#btnImport').prop('disabled', false);
					// $("#importIcons").removeClass('fa fa-spinner fa-pulse');
					// $("#importIcons").addClass('fa fa-upload');
                }
			});
		});
		/****************
			FUNCTIONS 
		*****************/
		function readTaxesInfo(pkid){
			// console.log(pkid);
			// return;
			let array_data = {
				'action' : 'read_taxes_info',
				'pkid'	 : pkid
			};
			let data = $.param(array_data);
			$.ajax({
				type: "POST",
				url: handler_taxes,
				data: data,
				dataType:  "json",
				success: function (response) {
					for(var i=0;i<response['ctr'];i++){
						$('#frm_update_taxes input[name="data_id"]').val(response['Pkid'][i]);
						$('#frm_update_taxes input[name="txt_salary_adjustments"]').val(response['salary_adjustments'][i]);
						$('#frm_update_taxes input[name="txt_other_earnings"]').val(response['other_earnings'][i]);
						$('#frm_update_taxes input[name="txt_ad_deduc"]').val(response['advances_other_deductions'][i]);
						$('#frm_update_taxes input[name="txt_tax_adjustment"]').val(response['tax_adjustments'][i]);
						assign_value_select2('#frm_update_taxes #txt_emp_no',response['emp_no'][i]);
						re_initialize_select2_server_side('#mdl_update_taxes #txt_emp_no','#mdl_update_taxes #frm_update_taxes',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
					}
				}
			});
		}
		function readAnnualTaxData(pkid){
			let array_data = {
				'action' : 'read_annual_tax_data',
				'pkid'	 : pkid
			};
			let data = $.param(array_data);
			$.ajax({
				type: "POST",
				url: handler_taxes,
				data: data,
				dataType:  "json",
				success: function (response) {
					for(var i=0;i<response['ctr'];i++){
						$('#frm_update_annual_tax input[name="data_id"]').val(response['id'][i]);
						$('#frm_update_annual_tax input[name="txt_gross_income"]').val(response['gross_income_ytd'][i]);
						$('#frm_update_annual_tax input[name="txt_forecast_earnings"]').val(response['forecast_earnings'][i]);
						$('#frm_update_annual_tax input[name="txt_tax_exempt"]').val(response['less_ytd_tax_exempt'][i]);
						$('#frm_update_annual_tax input[name="txt_tax_withheld"]').val(response['yt_tax_withheld'][i]);
						$('#frm_update_annual_tax input[name="txt_up_annual_tax_others"]').val(response['leaves_taxes'][i]);
						assign_value_select2('#frm_update_annual_tax #txt_emp_no',response['emp_no'][i]);
						re_initialize_select2_server_side('#mdlUpdateAnnualTax #txt_emp_no','#mdlUpdateAnnualTax #frm_update_annual_tax',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
					}
				}
				
			});
		}
		function getTaxBaseDataForEditting(pkid){
			let array_data = {
				'action' : 'get_tax_base_data',
				'pkid'	 : pkid
			};
			let data = $.param(array_data);
			$.ajax({
				type: "POST",
				url: handler_taxes,
				data: data,
				dataType:  "json",
				success: function (response) {
					for(var i=0;i<response['ctr'];i++){
						$('#frm_update_tax_base input[name="data_id"]').val(response['Id'][i]);
						$('#frm_update_tax_base input[name="tax_base"]').val(response['TaxBase'][i]);
						$('#frm_update_tax_base input[name="tax_rate"]').val(response['TaxRate'][i]);
						$('#frm_update_tax_base input[name="lower_limit"]').val(response['LowerLimit'][i]);
						$('#frm_update_tax_base input[name="upper_limit"]').val(response['UpperLimit'][i]);
					}
				}
			});
		}

	}); //end
</script>
</body>
</html>
