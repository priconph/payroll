<html>
<head>
</head>
<body>	

<section class="main">		
	<section class="tab-pane active fade in content">
		<div class="row">
			<div class="col">
				<div class="panel panel-primary">
					<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Payroll Info.</i>
					</div>
					<div class="panel-body">
						<div class="row">
							<ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#payroll_compute" aria-controls="payroll_compute" role="tab" data-toggle="tab">Payroll Compute</a></li>
                                <li role="presentation"><a href="#payroll_data" aria-controls="payroll_data" role="tab" data-toggle="tab">Payroll Data</a></li>
                                <li role="presentation"><a href="#salary_report" aria-controls="salary_report" role="tab" data-toggle="tab"> Salary Report</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                            	<div role="tabpanel" class="tab-pane" id="payroll_data">
									<!-- <button class="btn btn-primary fa pull-left" id="create_payroll_info" data-toggle="modal"><i class="fa fa-plus"></i> New</button><br><br> -->
	                                    <div class="table-responsive">
	                                        <table class="table table-striped table-bordered table-condensed table-hover" id="t_payroll_data" >
												<thead>
													<th>Action</th>
													<th>Description</th>
													<th>Cut-off</th>
													<th>Starting Date</th>
													<th>Ending Date</th>
													<th>Cut-off Date</th>
													<th>Last Modified</th>
													<th>Posted</th>
												</thead>
												<tbody>
												</tbody>
											</table>
	                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane active" id="payroll_compute">
									<button class="btn btn-primary fa pull-left" id="create_payroll_info" data-toggle="modal"><i class="fa fa-plus"></i> New</button><br><br>
	                                    <div class="table-responsive">
	                                        <table class="table table-striped table-bordered table-condensed table-hover" id="t_payroll_compute" >
												<thead>
													<th>Action</th>
													<th>Description</th>
													<th>Cut-off</th>
													<th>Starting Date</th>
													<th>Ending Date</th>
													<th>Cut-off Date</th>
													<th>Last Modified</th>
													<th>Posted</th>
													<th>Working Days</th>
												</thead>
												<tbody>
												</tbody>
											</table>
	                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="salary_report">
									<div class="row">
										<div class="col-sm-3">
											<button class="btn btn-primary fa pull-left" id="btnImportSalaryReport" data-toggle="modal" data-target="#SalaryReportImportModal"><i class="fa fa-upload"></i> Import Data</button><br><br>
										</div>
										<div class="col-sm-9">
											<button class="btn btn-success fa pull-right" id="btnCreateSalReport"><i class="fa fa-plus"></i> New</button><br><br>
										</div>
									</div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-condensed table-hover" id="t_salary_report">
                                            <thead>
                                                <th>Employee No.</th>
                                                <th>Employee Name</th>
                                                <th>Personal Exemption</th>
                                                <th>Basic Salary</th>
                                                <th>Ecola</th>
                                                <th>CTPA</th>
                                                <th>Socio Eco. Allow </th>
                                                <th>Allowance</th>
                                                <th>Account Number</th>
                                                <th>Action</th>
                                            </thead>
                                        </table>
                                    </div>
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
	<div class="modal fade" id="mdl_create_payroll_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog" style="margin-top:0%;">
			<div class="modal-content">
			<div class="modal-header" style="overflow-y:auto;">
				New Payroll Info
			</div>
				<div class="modal-body" style="overflow-y:auto;">
			        <form id="frm_create_payroll_info">
			      		<div class="row" style="margin-top:-10px;">
			      			<div class="col-sm-6">
								<div class="form-group">
									<label class="col-form-label">Description</label>
									<!-- <input type="select" class="form-control" name="cec_name"> -->
									<select class="form-control" name="slct_description" required>
										<option selected disabled>Select One</option>
										<option value="1">Daily</option>
										<option value="2">Monthly</option>
										<option value="4">JS/SS</option>
										<option value="5">Rice Sub.</option>
										<option value="6">VL Conversion</option>
										<option value="7">13th Month</option>
										<option value="8">SL Conversion</option>
										<option value="9">Bonus</option>
										<option value="10">Gratuity Pay</option>
									</select>
								</div>
			      			</div>
			      			<div class="col-sm-6">
								<div class="form-group">
									<label class="col-form-label">Cut-off</label>
									<!-- <input type="select" class="form-control" name="cec_position"> -->
									<select class="form-control" name="slct_cut_off" required>
										<option selected disabled>Select One</option>
										<option value="1">First</option>
										<option value="2">Last</option>
									</select>
								</div>
			      			</div>
			      		</div>
			      		<div class="row" style="margin-top:-10px;">
			      			<div class="col-sm-6">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Starting Date</label>
									<input type="date" class="form-control"  name="dt_start_date" required>
								</div>
			      			</div>
			      			<div class="col-sm-6">
								<div class="form-group">
									<label for="dt_end_date" class="col-form-label">Ending Date</label>
									<input type="date" class="form-control" name="dt_end_date" required>
								</div>
			      			</div>
			      		</div>
			      		<div class="row" style="margin-top:-10px;">
						  	<div class="col-sm-6">
								<div class="form-group">
									<label for="dt_cut_off_date" class="col-form-label">Cut-off Date</label>
									<input type="date" class="form-control" name="dt_cut_off_date" required>
								</div>
			      			</div>
			      			<div class="col-sm-6">
								<div class="form-group">
									<label for="slct_posted" class="col-form-label">Posted</label>
									<select class="form-control"  name="slct_posted" required>
										<option selected disabled>Select One</option>
										<option value="Y">Yes</option>
										<option value="N">No</option>
									</select>
								</div>
			      			</div>
			      		</div>
						<div class="row">
							<div class="col-sm-6">
							<label for="dt_cut_off_date" class="col-form-label">Working Days</label>
							<select class="form-control" name="working_days" id="working_days" required>
								<option selected disabled>Select One</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
							</select>
							</div>
						</div>
			        </form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" form="frm_create_payroll_info" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Payroll data -->
	<div class="modal fade" id="mdl_update_payroll_data" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog" style="margin-top:0%;">
			<div class="modal-content">
			<div class="modal-header" style="overflow-y:auto;">
				Edit Payroll Data
			</div>
				<div class="modal-body" style="overflow-y:auto;">
			        <form id="frm_update_payroll_data">
			        	<input name="data_id" type="hidden">
			      		<div class="row" style="margin-top:-10px;">
			      			<div class="col-sm-6">
								<div class="form-group">
									<label class="col-form-label">Description</label>
									<!-- <input type="select" class="form-control" name="cec_name"> -->
									<select class="form-control" name="slct_description" required>
										<option selected disabled>---</option>
										<option value="1">Daily</option>
										<option value="2">Monthly</option>
										<option value="4">JS/SS</option>
										<option value="5">Rice Sub.</option>
										<option value="6">VL Conversion</option>
										<option value="7">13th Month</option>
										<option value="8">SL Conversion</option>
										<option value="9">Bonus</option>
										<option value="10">Gratuity Pay</option>
									</select>
								</div>
			      			</div>
			      			<div class="col-sm-6">
								<div class="form-group">
									<label class="col-form-label">Cut-off</label>
									<!-- <input type="select" class="form-control" name="cec_position"> -->
									<select class="form-control" name="slct_cut_off" required>
										<option selected disabled>---</option>
										<option value="1">1st</option>
										<option value="2">2nd</option>
									</select>
								</div>
			      			</div>
			      		</div>
			      		<div class="row" style="margin-top:-10px;">
			      			<div class="col-sm-6">
								<div class="form-group">
									<label for="dt_start_date" class="col-form-label">Starting Date</label>
									<input type="date" class="form-control"  name="dt_start_date" id="dt_start_date" required>
								</div>
			      			</div>
			      			<div class="col-sm-6">
								<div class="form-group">
									<label for="dt_end_date" class="col-form-label">Ending Date</label>
									<input type="date" class="form-control" name="dt_end_date" required>
								</div>
			      			</div>
			      		</div>
			      		<div class="row" style="margin-top:-10px;">
						  	<div class="col-sm-6">
								<div class="form-group">
									<label for="dt_cut_off_date" class="col-form-label">Cut-off Date</label>
									<input type="date" class="form-control" name="dt_cut_off_date" required>
								</div>
			      			</div>
			      			<div class="col-sm-6">
								<div class="form-group">
									<label for="slct_posted" class="col-form-label">Posted</label>
									<select class="form-control"  name="slct_posted" required>
										<option selected disabled>---</option>
										<option value="Y">Yes</option>
										<option value="N">No</option>
									</select>
								</div>
			      			</div>
			      		</div>

						  <div class="row">
							<div class="col-sm-6">
							<label for="dt_cut_off_date" class="col-form-label">Working Days</label>
							<select class="form-control" name="working_days" required>
								<option selected disabled>Select One</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
							</select>
							</div>
						</div>
			        </form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" form="frm_update_payroll_data" class="btn btn-primary">Save</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Payroll Detials -->
	<div class="modal fade" id="mdl_payroll_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog" style="margin-top:0%; width:90%;">
			<div class="modal-content">
			<div class="modal-header" style="overflow-y:auto;">
				Payroll Details
			</div>
				<div class="modal-body" style="overflow-y:auto;">
			        <form id="frm_payroll_details">
			        	<input name="data_id" type="hidden">
			      		
			      		<div class="panel-body">
						<div class="row">
							<div class="col-sm-12">
								<table id="t_payroll_details" class="table table-striped table-bordered nowrap" style="width:100%;">
									<thead>
								 	<tr style="text-align:center;font-size:70%;">
		                              <th rowspan="3">Employye No. </th>
		                              <th rowspan="3">Employee Name </th>
		                              <th rowspan="3">Regular Pay </th>
		                              <th rowspan="3">13th month(monthly based) </th>
		                              <th colspan="22">Overtime </th>
		                              <th colspan="2"> </th>
		                              <th colspan="10">Leave </th>
		                              <th rowspan="3">Ecola </th>
		                              <th rowspan="3">Salary Adjustments </th>
		                              <th rowspan="3">Allowance </th>
		                              <th rowspan="3">CTPA/Prod Allow </th>
		                              <th rowspan="3">Socio Eco. Allow </th>
		                              <th rowspan="3">Other Earnings </th>
		                              <th colspan="2"> </th>
		                              <th colspan="2"> </th>
		                              <th rowspan="3">Gross Pay </th>
		                              <th rowspan="3">SSS Premiums</th>
		                              <th rowspan="3">Philhealth </th>
		                              <th rowspan="3">Pag-ibig </th>
		                              <!-- <th colspan="2">SSS Loans </th> -->
		                              <th colspan="3">SSS Loans </th>
		                              <th colspan="2">Pag-ibig Loans </th>
		                              <th rowspan="3">HIPAR </th>
		                              <th rowspan="3">Advances/Other Deductions </th>
		                              <th rowspan="3">Tax Adjustments </th>
		                              <th rowspan="3">With Tax </th>
		                              <th rowspan="3">NET PAY  </th>
		                            </tr>

		                            <tr style="text-align:center;font-size:70%;">
		                              <th colspan="2">Regular OT <br> (OT 1) </th>
		                              <th colspan="2">Sunday/ Special Hol. OT <br> (OT 2) </th>
		                              <th colspan="2">Sunday/ Special Hol. OT (excess of 8 hrs.) <br> (OT 2A) </th>
		                              <th colspan="2">Sunday OT <br> (OT 3) </th>
		                              <th colspan="2">Sunday OT (excess of 8 hrs.) <br> (OT 3A) </th>
		                              <th colspan="2">Sunday/ Legal Holiday (OT 4) </th>
		                              <th colspan="2">Sunday/ Legal Holiday (excess of 8 hrs.) <br> (OT 4A) </th>
		                              <th colspan="2">Special Non-working Holiday <br> (OT 5) </th>
		                              <th colspan="2">Special Non-working Holiday ( excess of 8 hrs.) <br> (OT 5A) </th>
		                              <th colspan="2">Legal Holiday <br> (OT 6) </th>
		                              <th colspan="2">Legal Holiday (excess of 8 hrs.) <br> (OT 6A) </th>
		                              <th colspan="2">Night Diff </th>	                             
		                              <th colspan="2">Sick Leave </th>
		                              <th colspan="2">Vacation Leave </th>
		                              <th colspan="2">Bereavement Leave </th>
		                              <th colspan="2">Birthday Leave </th>
		                              <th colspan="2">Shutdown </th>
		                              <th colspan="2">Absences </th>
		                              <th colspan="2">Undertime </th>
		                              <th rowspan="2">SSS Salary Loan </th>
		                              <th rowspan="2">SSS Calamity Loan </th>
		                              <th rowspan="2">SSS Condonation </th>
		                              <th rowspan="2">Pag-ibig Salary Loan </th>
		                              <th rowspan="2">Pag-ibig Calamity Loan </th>
		                            </tr>

		                            <tr style="text-align:center;font-size:70%;">
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Days </th>
		                              <th>Amount </th>
		                              <th>Days </th>
		                              <th>Amount </th>
		                              <th>Days </th>
		                              <th>Amount </th>
		                              <th>Days </th>
		                              <th>Amount </th>
		                              <th>Days </th>
		                              <th>Amount </th>
		                              <th>Days </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                            </tr>

									</thead>
									<tbody style="font-size:70%;">
									</tbody>
								</table>
							</div>
						</div>

						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" id="btn_close_pd">Close</button>
							<!-- <button type="submit" form="frm_payroll_details" class="btn btn-primary">Save</button> -->
						</div>

			        </form>
				</div>
			</div>
		</div>
	</div>

	<!-- Payroll Compute Details -->
	<div class="modal fade" id="mdl_payroll_compute_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog" style="margin-top:0%; width:90%;">
			<div class="modal-content">
			<div class="modal-header" style="overflow-y:auto;">
				Payroll Details
			</div>
				<div class="modal-body" style="overflow-y:auto;">
			        <form id="frm_payroll_compute_details">
			        	<input name="data_id" type="hidden">
			      		
			      		<div class="panel-body">
						<div class="row">
							<input type="hidden" class="form-control" id="payroll_data_id" name="payroll_data_id"> 
							<input type="hidden" class="form-control" id="cutoff_id" name="cutoff_id"> 
							<div class="col-sm-12">
								<table id="t_payroll_compute_details" class="table table-striped table-bordered nowrap" style="width:100%;">
									<thead>
								 	<tr style="text-align:center;font-size:70%;">
		                              <th rowspan="3">Employye No. </th>
		                              <th rowspan="3">Employee Name </th>
		                              <th rowspan="3">Regular Pay </th>
		                              <th rowspan="3">13th month(monthly based) </th>
		                              <th colspan="22">Overtime </th>
		                              <th colspan="2"> </th>
		                              <th colspan="10">Leave </th>
		                              <th rowspan="3">Ecola </th>
		                              <th rowspan="3">Salary Adjustments </th>
		                              <th rowspan="3">Allowance </th>
		                              <th rowspan="3">CTPA/Prod Allow </th>
		                              <th rowspan="3">Socio Eco. Allow </th>
		                              <th rowspan="3">Other Earnings </th>
		                              <th colspan="2"> </th>
		                              <th colspan="2"> </th>
		                              <th rowspan="3">Gross Pay </th>
		                              <th rowspan="3">SSS Premiums</th>
		                              <th rowspan="3">Philhealth </th>
		                              <th rowspan="3">Pag-ibig </th>
		                              <th colspan="3">SSS Loans </th>
		                              <th colspan="3">Pag-ibig Loans </th>
		                              <th rowspan="3">HIPAR </th>
		                              <th rowspan="3">Advances/Other Deductions </th>
		                              <th rowspan="3">Tax Adjustments </th>
		                              <th rowspan="3">With Tax </th>
		                              <th rowspan="3">NET PAY  </th>
		                            </tr>

		                            <tr style="text-align:center;font-size:70%;">
		                              <th colspan="2">Regular OT <br> (OT 1) </th>
		                              <th colspan="2">Sunday/ Special Hol. OT <br> (OT 2) </th>
		                              <th colspan="2">Sunday/ Special Hol. OT (excess of 8 hrs.) <br> (OT 2A) </th>
		                              <th colspan="2">Sunday OT <br> (OT 3) </th>
		                              <th colspan="2">Sunday OT (excess of 8 hrs.) <br> (OT 3A) </th>
		                              <th colspan="2">Sunday/ Legal Holiday (OT 4) </th>
		                              <th colspan="2">Sunday/ Legal Holiday (excess of 8 hrs.) <br> (OT 4A) </th>
		                              <th colspan="2">Special Non-working Holiday <br> (OT 5) </th>
		                              <th colspan="2">Special Non-working Holiday ( excess of 8 hrs.) <br> (OT 5A) </th>
		                              <th colspan="2">Legal Holiday <br> (OT 6) </th>
		                              <th colspan="2">Legal Holiday (excess of 8 hrs.) <br> (OT 6A) </th>
		                              <th colspan="2">Night Diff </th>	                             
		                              <th colspan="2">Sick Leave </th>
		                              <th colspan="2">Vacation Leave </th>
		                              <th colspan="2">Bereavement Leave </th>
		                              <th colspan="2">Birthday Leave </th>
		                              <th colspan="2">Shutdown </th>
		                              <th colspan="2">Absences </th>
		                              <th colspan="2">Undertime </th>
		                              <th rowspan="2">SSS Salary Loan </th>
		                              <th rowspan="2">SSS Calamity Loan </th>
		                              <th rowspan="2">SSS Condonation </th>
		                              <th rowspan="2">Pag-ibig Salary Loan </th>
		                              <th rowspan="2">Pag-ibig Calamity Loan </th>
		                              <th rowspan="2">Pag-ibig Safe Loan </th>
		                            </tr>

		                            <tr style="text-align:center;font-size:70%;">
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                              <th>Days </th>
		                              <th>Amount </th>
		                              <th>Days </th>
		                              <th>Amount </th>
		                              <th>Days </th>
		                              <th>Amount </th>
		                              <th>Days </th>
		                              <th>Amount </th>
		                              <th>Days </th>
		                              <th>Amount </th>
		                              <th>Days </th>
		                              <th>Amount </th>
		                              <th>Hours </th>
		                              <th>Amount </th>
		                            </tr>

									</thead>
									<tbody style="font-size:70%;">
									</tbody>
								</table>
							</div>
						</div>

						</div>

						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" id="btn_close_pcd">Close</button>
						</div>

			        </form>
				</div>
			</div>
		</div>
	</div>

	<!---------------------
		Modals - Start Salary Report
	---------------------->
	<div class="modal fade" id="modalCreateSalReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="overflow-y:auto;">
					HMO Info
				</div>
				<!-- 
					<th>Employee No.</th>
					<th>Employee Name</th>
					<th>Personal Exemption</th>
					<th>Basic Salary</th>
					<th>Ecola</th>
					<th>CTPA</th>
					<th>Socio Eco. Allow </th>
					<th>Allowance</th>
				 -->
				<form id="frmCreateSalReport">
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
									<label for="txt_emp_no" class="col-form-label">Employee Number</label>
									<select type="text" class="form-control"  name="txt_emp_no" id="txt_emp_no" style="width:100%;" required>
									</select>
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="txt_emp_no" class="col-form-label">Personal Exemption</label>
									<input type="text" class="form-control"  name="txt_personal_exempt" id="txt_personal_exempt" style="width:100%;" required>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="int_amount" class="col-form-label">Basic Salary</label>
									<input type="number" class="form-control"  name="int_basic_sal" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$" required>
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="int_amount" class="col-form-label">Ecola</label>
									<input type="number" class="form-control"  name="int_ecola" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$" required>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="int_amount" class="col-form-label">CTPA</label>
									<input type="number" class="form-control"  name="int_ctpa" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$" required>
								</div>
							</div>
						</div>
						<div class="row" style="margin-top:-10px;">
							<div class="col-sm-6">
								<div class="form-group">
									<label for="int_amount" class="col-form-label">Socio Eco. Allow</label>
									<input type="number" class="form-control"  name="int_socio_eco" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$" required>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="int_amount" class="col-form-label">Allowance</label>
									<input type="number" class="form-control"  name="int_allowance" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$" required>
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
	<!-- Modal for system message -->
	<div class="modal fade" tabindex="-1" role="dialog" id="SalaryReportImportModal">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><i class="fa fa-file-excel-o"></i> Import Salary Report</h4>
				</div>
				<form id="formImportSalaryReport" method="" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="form-group">
						<label for="file">Choose CSV File</label>
						<input type="file" name="file" class="form-control-file" accept=".csv" id="file">
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary fa fa-upload" name="import" id="btnImport"> Import</button>
					<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
				</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


<script>
	$(document).ready(function () {
		var handler_payroll_info = './handler/handler_payroll_info.php';
		var $buttonId = $('#frmCreateSalReport #btnSave');
		var $iconId = $('#frmCreateSalReport #iconsSave');

		/* Salary Report */
		dt_salary_report = $('#t_salary_report').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "./server_side_scripts/payroll_info/dt_salary_report.php",
			"drawCallback": function( settings ) {
				$('#t_salary_report').attr('style','width:100%;');
			}
		});

		/* Payroll Data */
		dt_payroll_info = $('#t_payroll_data').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "./server_side_scripts/payroll_info/dt_payroll_info.php",
			"drawCallback": function( settings ) {
				$('#t_payroll_data').attr('style','width:100%;');
			}
		});

		/* Payroll Compute */
		dt_payroll_info = $('#t_payroll_compute').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "./server_side_scripts/payroll_info/dt_payroll_compute_info.php",
			"drawCallback": function( settings ) {
				$('#t_payroll_compute').attr('style','width:100%;');
			}
		});

		$('#btn_close_pd').click(function () {
			location.reload();
		});

		$('#btn_close_pcd').click(function () {
			location.reload();
		});

		$('#frm_create_payroll_info').submit(function (e) {
			e.preventDefault();
			let action = {
				"action" : "create_payroll_info" 
			}
			let data = $.param(action) + "&" + $(this).serialize();
			$.ajax({
				type: "POST",
				url: handler_payroll_info,
				data: data,
				dataType: "json",
				success: function (data) {
					if(data['result']=="success"){
						notif_success("Created Successfully");
						$('#mdl_create_payroll_data').modal('hide');
						$('#frm_create_payroll_info')[0].reset();

						dt_payroll_info.draw();
					}else{
						alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
					}
				},error: function (data){
					console.log('error: '+data);
					alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
				}
			});
		});

		// $('#t_payroll_data tbody').on('click','.payroll-data-edit', function () { // 07172023
		$('#t_payroll_compute tbody').on('click','.payroll-data-edit', function () {
			let pkid = $(this).attr('data-id');

			readPayrollInfo(pkid);

			$('#mdl_update_payroll_data').modal('show');
		});

		$('#frm_update_payroll_data').submit(function (e) {
			e.preventDefault();
			let action = {
				"action" : "update_payroll_info" 
			}
			let data = $.param(action) + "&" + $(this).serialize();
			$.ajax({
				type: "POST",
				url: handler_payroll_info,
				data: data,
				dataType: "json",
				success: function (data) {
					if(data['result']=="success"){
						notif_success("Updated Successfully");
						$('#mdl_update_payroll_data').modal('hide');
						dt_payroll_info.draw();
					}else{
						alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
					}
				},
				error:function(data){
					console.log('error: '+data);
					alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
				}
			});
		});

		function readPayrollInfo(pkid){
			var data = {
				"action" : "read_payroll_info",
				"pkid" 	 : pkid 
			}
			var data = $.param(data)
			$.ajax({
				type: "POST",
				url: handler_payroll_info,
				data: data,
				dataType: "json",
				success: function (data) {
					for(var i=0;i<data['ctr'];i++){
						$('#frm_update_payroll_data input[name="data_id"]').val(data['Pkid'][i]);
						$('#frm_update_payroll_data select[name="slct_description"]').val(data['Description'][i]);
						$('#frm_update_payroll_data select[name="slct_cut_off"]').val(data['CutOff'][i]);
						$('#frm_update_payroll_data input[name="dt_start_date"]').val(data['StartingDate'][i]);
						$('#frm_update_payroll_data input[name="dt_end_date"]').val(data['EndingDate'][i]);
						$('#frm_update_payroll_data input[name="dt_cut_off_date"]').val(data['CutOffDate'][i]);
						$('#frm_update_payroll_data select[name="slct_posted"]').val(data['Posted'][i]);
						$('#frm_update_payroll_data select[name="working_days"]').val(data['WorkingDays'][i]);
					}
				},
				error:function (data){
					console.log('error: '+data);
					alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
				}
			});
		}	

		/* Payroll Details*/
		$('#t_payroll_data tbody').on('click','.payroll-details', function () { //07172023
			let payroll_data_id = $(this).attr('data-id');
			let salary_type = $(this).attr('data-desc');
			let cutoff = $(this).attr('data-cutoff');
			// alert(payroll_data_id)
			// alert(salary_type)
			// alert(cutoff)

			$('#payroll_data_id').val(payroll_data_id);
			$('#cutoff_id').val(cutoff);

			dt_payroll_details = $('#t_payroll_details').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"lengthChange": true,
			"bServerSide": true,
			"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			// "sAjaxSource": "./server_side_scripts/payroll_info/dt_payroll_details.php?salary_type="+salary_type, // 07172023
			"sAjaxSource": "./server_side_scripts/payroll_info/dt_payroll_details.php?salary_type="+salary_type+"&cutoff="+cutoff+"&payroll_data_id="+payroll_data_id,
			"drawCallback": function( settings ) {
				$('#t_payroll_details').attr('style','width:100%;');
			},
			});

			$('#mdl_payroll_details').modal({backdrop: 'static',keyboard: false},'show');
		});

		/* Payroll Compute*/
		$('#t_payroll_compute tbody').on('click','.payroll-details-compute', function () { 
			let payroll_data_id = $(this).attr('data-id');
			let salary_type = $(this).attr('data-desc');
			let cutoff = $(this).attr('data-cutoff');
			let date_cutoff = $(this).attr('data-date-cutoff');

			// alert(salary_type)
			$('#payroll_data_id').val(payroll_data_id);
			$('#cutoff_id').val(cutoff);

			dt_payroll_compute_details = $('#t_payroll_compute_details').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"lengthChange": true,
			"bServerSide": true,
			"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			"sAjaxSource": "./server_side_scripts/payroll_info/dt_payroll_compute.php?salary_type="+salary_type+"&cutoff="+cutoff+"&date_cutoff="+date_cutoff,
			"drawCallback": function( settings ) {
				$('#t_payroll_compute_details').attr('style','width:100%;');
			},
			});

			$('#mdl_payroll_compute_details').modal({backdrop: 'static',keyboard: false},'show');
		});

		$('#create_payroll_info').click(function () {
			$('#mdl_create_payroll_data').modal('show');
		});

		$('#formImportSalaryReport').submit(function(e){
			e.preventDefault();
			let serialize_data = new FormData(this);
			serialize_data.append('action',"import_salary_report_data");

			$.ajax({
				url: './handler/handler_payroll_info.php',
				type:"post",
				data: serialize_data,
				dataType:'json',
                cache: false,
				contentType:false,
				processData:false,
				beforeSend: function(){
					$('#btnImport').prop('disabled', true);
				},
				success:function(data)
				{
					$('#SalaryReportImportModal').modal('hide');
					$('#btnImport').prop('disabled', false);
					$('#formImportSalaryReport')[0].reset();
					notif_success('Import Successfully');
					dt_salary_report.ajax.reload();
				},
				error: function(data, xhr, status){
                    console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
					$('#btnImport').prop('disabled', false);
					notif_error('Import Failed. Please try again.');

                }
			});

		});

		$('#frm_payroll_details').submit(function(e){
			e.preventDefault();
			var serialData = $(this).serialize();
			// alert(serialData)

			var tableId 	= document.getElementById('t_payroll_details');
			var tBody 		= tableId.getElementsByTagName('tbody')[0];
			var tableRow 	= tBody.getElementsByTagName('tr');

			for (var t = 0; t < tableRow.length; t++){
			    console.log(tableRow[t].innerHTML)
			}


			// save_payroll_details(serialData);
			
		}); 

		function save_payroll_details(serialData){

			// alert(payroll_data_id)
		
			$('#t_payroll_details tbody tr').each(function(){
				
				var data = {
					"action"			: "save_payroll_details",
					"fkid_payroll_info"	: payroll_data_id,
					"employee_no"		: $(this).find('td:eq(0)').text(),
					"employee_name"		: $(this).find('td:eq(1)').text(),
					"regular_pay"		: $(this).find('td:eq(2)').text(),
					"thirteenth_month"	: $(this).find('td:eq(3)').text()
					// "ot1"				: $(this).find('td:eq(4)').text(),
					// "ot1_amount"		: $(this).find('td:eq(5)').text(),
					// "ot2"				: $(this).find('td:eq(6)').text(),
					// "ot2_amount"		: $(this).find('td:eq(7)').text(),
					// "ot2a"				: $(this).find('td:eq(8)').text(),
					// "ot2a_amount"		: $(this).find('td:eq(9)').text(),
					// "ot3"				: $(this).find('td:eq(10)').text(),
					// "ot3_amount"		: $(this).find('td:eq(11)').text(),
					// "ot3a"				: $(this).find('td:eq(12)').text(),
					// "ot3a_amount"		: $(this).find('td:eq(13)').text(),
					// "ot4"				: $(this).find('td:eq(14)').text(),
					// "ot4_amount"		: $(this).find('td:eq(15)').text(),
					// "ot4a"				: $(this).find('td:eq(16)').text(),
					// "ot4a_amount"		: $(this).find('td:eq(17)').text(),
					// "ot5"				: $(this).find('td:eq(18)').text(),
					// "ot5_amount"		: $(this).find('td:eq(19)').text(),
					// "ot5a"				: $(this).find('td:eq(20)').text(),
					// "ot6"				: $(this).find('td:eq(21)').text(),
					// "ot6a_amount"		: $(this).find('td:eq(22)').text()

					// "nightdiff"			: $(this).find('td:eq(23)').text(),
					// "nightdiff_amount"	: $(this).find('td:eq(24)').text(),
					// "sl"				: $(this).find('td:eq(26)').text(),
					// "sl_amount"			: $(this).find('td:eq(27)').text(),
					// "vl"				: $(this).find('td:eq(28)').text(),
					// "vl_amount"			: $(this).find('td:eq(29)').text(),
					// "bl"				: $(this).find('td:eq(30)').text(),
					// "bl_amount"			: $(this).find('td:eq(31)').text(),
					// "bdl"				: $(this).find('td:eq(32)').text(),
					// "bdl_amount"		: $(this).find('td:eq(33)').text(),
					// "shutdown"			: $(this).find('td:eq(34)').text(),
					// "shutdown_amount"	: $(this).find('td:eq(35)').text(),
					// "ecola"				: $(this).find('td:eq(36)').text(),
					// "salary_adj"		: $(this).find('td:eq(37)').text(),
					// "allowance"			: $(this).find('td:eq(38)').text(),
					// "ctpa_prod_allow"	: $(this).find('td:eq(39)').text(),
					// "socio_eco_allow"	: $(this).find('td:eq(40)').text(),
					// "other_earnings"	: $(this).find('td:eq(41)').text(),
					// "abs_days"			: $(this).find('td:eq(42)').text(),
					// "abs_amnt"			: $(this).find('td:eq(43)').text(),
					// "undertime"			: $(this).find('td:eq(44)').text(),
					// "undertime_amnt"	: $(this).find('td:eq(45)').text(),
					// "gross_pay"			: $(this).find('td:eq(46)').text(),
					// "sss_premium"		: $(this).find('td:eq(47)').text(),
					// "ph_premium"		: $(this).find('td:eq(48)').text(),
					// "pagibig"			: $(this).find('td:eq(49)').text(),
					// "sss_loan"			: $(this).find('td:eq(50)').text(),
					// "sss_cal_loan"		: $(this).find('td:eq(51)').text(),
					// "pagibig_loan"		: $(this).find('td:eq(52)').text(),
					// "pagibig_cal_loan"	: $(this).find('td:eq(53)').text(),
					// "hipar"				: $(this).find('td:eq(54)').text(),
					// "adv_other_deduc"	: $(this).find('td:eq(55)').text(),
					// "tax_adj"			: $(this).find('td:eq(56)').text(),
					// "with_tax"			: $(this).find('td:eq(57)').text(),
					// "net_pay"			: $(this).find('td:eq(58)').text()
				}
				
				data = $.param(data) + "&" + serialData;
				// alert(data);
				$.ajax({
					type: "POST",
					url: handler_payroll_info,
					data: data,
					dataType: "json",
					success	: function(data){
						console.log( data );
						alert('May sahod na!!!!!!')
						
					}, 
					error : function(data){
						console.log(data);
					}
					
				});

			});			
		}

		/*
			CRUD Salary Report
		 */
		$('#btnCreateSalReport').click(function () { 
			$('#modalCreateSalReport').modal('show');
			// dd_hris_all_list
			$('#frmCreateSalReport')[0].reset();
			buttonEnabledClass($buttonId,$iconId);
			re_initialize_select2_server_side('#modalCreateSalReport #txt_emp_no','#modalCreateSalReport #frmCreateSalReport',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
		});

		$('#frmCreateSalReport').submit(function (e) { 
			e.preventDefault();
			
			let action = {
				'action' : 'create_salary_report'
			};
			let data = $.param(action) +'&'+ $(this).serialize();
			console.log(data);
			$.ajax({
				type: "POST",
				url: handler_payroll_info,
				data: data,
				dataType: "json",
				beforeSend: function(){
					buttonDisabledClass($buttonId,$iconId);
				},
				success: (response) => {
					if(response['result']=="success"){
						notif_success("Saved Successfully");
						dt_salary_report.draw();
						buttonEnabledClass($buttonId,$iconId);
						$('#modalCreateSalReport').modal('hide');
					}else{
						buttonDisabledClass($buttonId,$iconId);
						notif_error('This employee number is already existed');
					}
				},error: (err) =>{
					notif_error(err +' Please contact Local 205/208');
				}
			});
		});

		$('#t_salary_report').on('click', '.fa-edit', function () {
			let pkid = $(this).attr('data-id');

			readSalReport(pkid);

			$('#modalCreateSalReport').modal('show');
		});

		function readSalReport(pkid){
			// console.log(pkid);
			// return;
			let array_data = {
				'action' : 'read_salary_report',
				'pkid'	 : pkid
			};
			let data = $.param(array_data);
			$.ajax({
				type: "POST",
				url: handler_payroll_info,
				data: data,
				dataType:  "json",
				success: function (response) {
					$('#frmCreateSalReport input[name="data_id"]').val(response['pkid']);
					assign_value_select2('#frmCreateSalReport #txt_emp_no',response['emp_no'][0]);
					re_initialize_select2_server_side('#modalCreateSalReport #txt_emp_no','#modalCreateSalReport #frmCreateSalReport',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
					$('#frmCreateSalReport input[name="txt_personal_exempt"]').val(response['personal_exemption']);
					$('#frmCreateSalReport input[name="int_basic_sal"]').val(response['basic_salary']);
					$('#frmCreateSalReport input[name="int_ecola"]').val(response['ecola']);
					$('#frmCreateSalReport input[name="int_ctpa"]').val(response['ctpa']);
					$('#frmCreateSalReport input[name="int_socio_eco"]').val(response['socio_eco_allow']);
					$('#frmCreateSalReport input[name="int_allowance"]').val(response['allowance']);
				}
			});
		}

		/**
		 * added on 01-02-2025
		 */
		function getWorkingDays(element){
			let result = '<option value="0" disabled selected>Select One</option>';
			var data = {
				"action" : "get_working_days",
			}
			var data = $.param(data)
			$.ajax({
				type: "POST",
				url: handler_payroll_info,
				data: data,
				dataType: "json",
				success: function (data) {
					console.log('data ',data);
					for(var i=0;i<data['ctr'];i++){
						result += `<option value="${data['working_days'][i]}">
										${data['working_days'][i]}
									</option>`;
					}
					element.html(result);
				},
				error:function (data){
					console.log('error: '+JSON.stringify(data));
					alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
				}
			});
		}
		getWorkingDays($('#working_days'))

	}); //end
</script>
</body>
</html>

