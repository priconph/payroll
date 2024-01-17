<section class="main">		
	<section class="tab-pane active fade in content">
		<div class="row">
			<div class="col">
				<div class="panel panel-primary">
                	<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> SSS Data</i>
					</div>
					<div class="panel-body">
                        <div class="row">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#sss_loan" aria-controls="sss_loan" role="tab" data-toggle="tab"> SSS Loan</a></li>
                                <li role="presentation"><a href="#sss_calamity_loan" aria-controls="sss_calamity_loan" role="tab" data-toggle="tab"> SSS Calamity Loan</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="sss_loan">
                                    <div class="col-sm-3">
                                        <button class="btn btn-primary fa pull-left" id="btnImportSSSLoan" data-toggle="modal" data-target="#SSSLoanImportModal"><i class="fa fa-upload"></i> Import Data</button>
                                    </div>
                                    <div class="col-sm-9">
                                        <button class="btn btn-success fa pull-right" id="btnCreateLoan"><i class="fa fa-plus"></i> New</button><br><br>
                                    </div>
                                        <br>
                                        <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-condensed table-hover" id="tblSSSLoanId">
                                            <thead>
                                                <th>Employee No.</th>
                                                <th>Employee Name</th>
                                                <th>SSS No.</th>
                                                <th>Amount</th>
                                                <th>Action</th>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="sss_calamity_loan">
									<div class="col-sm-3">
										<button class="btn btn-primary fa pull-left" id="btnImportSSSCalamityLoan" data-toggle="modal" data-target="#SSSCalamityLoanImportModal"><i class="fa fa-upload"></i> Import Data</button>
                                    </div>
                                    <div class="col-sm-9">
                                        <button class="btn btn-success fa pull-right" id="btnCreateCalamityLoan"><i class="fa fa-plus"></i> New</button><br><br>
                                    </div>
									<br>
                                        <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-condensed table-hover" id="tblSSSCalamityLoanId">
                                            <thead>
                                                <th>Employee No.</th>
                                                <th>Employee Name</th>
                                                <th>SSS No.</th>
                                                <th>Amount</th>
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
<!---------------------
	SSS Loan Modal
---------------------->
<div class="modal fade" id="mdl_save_loan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" style="margin-top:0%;margin-left: 45%;">
		<div class="modal-content" style="width:50%">
			<div class="modal-header" style="overflow-y:auto;">
				SSS Loan Info
			</div>
			<form id="frm_save_loan">
				<div class="modal-body" style="overflow-y:auto;">
					<div class="row" style="margin-top:-10px;">
						<div class="col-sm-12">
							<div class="form-group">
								<input type="" class="form-control"  name="data_id">
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
						<div class="col-sm-12">
							<div class="form-group">
								<label for="txt_sss_no" class="col-form-label">SSS No.</label>
								<input type="text" class="form-control"  name="txt_sss_no" required>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:-10px;">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="int_amount" class="col-form-label">Amount</label>
								<input type="number" class="form-control"  name="int_amount" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$" required>
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
	SSS Calamity Loan Modal
---------------------->
<div class="modal fade" id="mdl_save_sss_calamity_loan" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" style="margin-top:0%;margin-left: 45%;">
		<div class="modal-content" style="width:50%">
			<div class="modal-header" style="overflow-y:auto;">
				SSS Calamity Loan Info
			</div>
			<form id="frm_save_sss_calamity_loan">
				<div class="modal-body" style="overflow-y:auto;">
					<div class="row" style="margin-top:-10px;">
						<div class="col-sm-12">
							<div class="form-group">
								<input type="" class="form-control"  name="data_id">
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
						<div class="col-sm-12">
							<div class="form-group">
								<label for="txt_sss_no" class="col-form-label">SSS No.</label>
								<input type="text" class="form-control"  name="txt_sss_no" required>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:-10px;">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="int_amount" class="col-form-label">Amount</label>
								<input type="number" class="form-control"  name="int_amount" min="0" step="0.01" pattern="^\d*(\.\d{0,2})?$" required>
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
	IMPORT 
---------------------->
    <!-- Modal for system message -->
    <div class="modal fade" tabindex="-1" role="dialog" id="SSSLoanImportModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
            </div>
                <form id="formImportSSSLoan" method="" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- <label class="col-md-4 control-label">Choose CSV File</label>
                    <input type="file" name="oem_file" id="fileOEM" accept=".csv"> -->
                    <div class="form-group">
                        <label for="file">Choose CSV File</label>
                        <input type="file" name="file" class="form-control-file" id="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary fa fa-upload" name="import" id="btnImportSSSLoan"> Import</button>
                    <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal for system message -->
    <div class="modal fade" tabindex="-1" role="dialog" id="SSSCalamityLoanImportModal">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-question-circle-o"></i> System Confirmation</h4>
            </div>
                <form id="formImportSSSCalamityLoan" method="" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- <label class="col-md-4 control-label">Choose CSV File</label>
                    <input type="file" name="oem_file" id="fileOEM" accept=".csv"> -->
                    <div class="form-group">
                        <label for="file">Choose CSV File</label>
                        <input type="file" name="file" class="form-control-file" id="file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary fa fa-upload" name="import" id="btnImportSSSCalamityLoan"> Import</button>
                    <button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
                </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<script>
$(document).ready(function(){
		var sss_handler ="./handler/sss_handler.php";
        var $buttonId 	= $('#frm_save_loan #btnSave');
		var $iconId		= $("#frm_save_loan #iconsSave");
        var $buttonIdClmtyLoan 			= $('#frm_save_sss_calamity_loan #btnSave');
		var $iconIdClmtyLoan				= $("#frm_save_sss_calamity_loan #iconsSave");

		function readSssLoan(pkid){
			// console.log(pkid);
			// return;
			let array_data = {
				'action' : 'read_sss_loan',
				'pkid'	 : pkid
			};
			let data = $.param(array_data);
			$.ajax({
				type: "POST",
				url: sss_handler,
				data: data,
				dataType:  "json",
				success: function (response) {
					// console.log(response);
					$('#frm_save_loan input[name="data_id"]').val(response['pkid']);
					$('#frm_save_loan input[name="txt_sss_no"]').val(response['sss_no']);
					$('#frm_save_loan input[name="int_amount"]').val(response['charge_amount']);
					assign_value_select2('#frm_save_loan #txt_emp_no',response['emp_no'][0]);
					re_initialize_select2_server_side('#mdl_save_loan #txt_emp_no','#mdl_save_loan #frm_save_loan',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
	
				}
			});
		}

		function readSssCalamityLoan(pkid){
			// console.log(pkid);
			// return;
			let array_data = {
				'action' : 'read_sss_calamity_loan',
				'pkid'	 : pkid
			};
			let data = $.param(array_data);
			$.ajax({
				type: "POST",
				url: sss_handler,
				data: data,
				dataType:  "json",
				success: function (response) {
					// console.log(response);
					$('#frm_save_sss_calamity_loan input[name="data_id"]').val(response['pkid']);
					$('#frm_save_sss_calamity_loan input[name="txt_sss_no"]').val(response['sss_no']);
					$('#frm_save_sss_calamity_loan input[name="int_amount"]').val(response['charge_amount']);
					assign_value_select2('#frm_save_sss_calamity_loan #txt_emp_no',response['emp_no'][0]);
					re_initialize_select2_server_side('#mdl_save_sss_calamity_loan #txt_emp_no','#mdl_save_sss_calamity_loan #frm_save_sss_calamity_loan',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
				}
			});
		}

		var datatableSSSLoan = $('#tblSSSLoanId').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "./server_side_scripts/sss/dt_sss_loan.php",
			"drawCallback": function( settings ) {
				$('#tblSSSLoanId').attr('style','width:100%;');
			}
		});

        var datatableSSSCalamityLoan = $('#tblSSSCalamityLoanId').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "./server_side_scripts/sss/dt_sss_calamity_loan.php",
			"drawCallback": function( settings ) {
				$('#tblSSSCalamityLoanId').attr('style','width:100%;');
			}
		});
/*
	SSS Loan
*/	
        $('#btnCreateLoan').click(function () { 
			$('#mdl_save_loan').modal('show');
			// dd_hris_all_list
			$('#frm_save_loan')[0].reset();
			$('#frm_save_loan #txt_emp_no').val('');
			buttonEnabledClass($buttonId,$iconId);
			re_initialize_select2_server_side('#mdl_save_loan #txt_emp_no','#mdl_save_loan #frm_save_loan',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
		});

        $('#frm_save_loan').submit(function (e) { 
			e.preventDefault();
			let action = {
				'action' : 'save_sss_loan'
			};
			let data = $.param(action) +'&'+ $(this).serialize();
			$.ajax({
				type: "POST",
				url: sss_handler,
				data: data,
				dataType: "json",
				beforeSend: function(){
					buttonDisabledClass($buttonId,$iconId);
				},success: (response) => {
                    console.log(response);
					if(response['result']=="success"){
						notif_success("Updated Successfully");
						datatableSSSLoan.draw();
						$('#mdl_save_loan').modal('hide');
						buttonEnabledClass($buttonId,$iconId);
					}else{
                        notif_error('Error Found! This employee number is already exist');
                        buttonDisabledClass($buttonId,$iconId);
					}
				},error: (err) =>{
					notif_error('Error Found! '+err+' Please contact Local 205/208');
				}
			});
		});

        $('#tblSSSLoanId').on('click', '.btn_edit', function () {
			let pkid = $(this).attr('data-id');

			console.log(pkid);

			readSssLoan(pkid);

			$('#mdl_save_loan').modal('show');
		});
/*
	SSS Calamity Loan
*/		
		$('#btnCreateCalamityLoan').click(function () { 
			$('#mdl_save_sss_calamity_loan').modal('show');
			$('#frm_save_sss_calamity_loan')[0].reset();
			$('#frm_save_sss_calamity_loan #txt_emp_no').val('');
			buttonEnabledClass($buttonIdClmtyLoan,$iconIdClmtyLoan);
			re_initialize_select2_server_side('#mdl_save_sss_calamity_loan #txt_emp_no','#mdl_save_sss_calamity_loan #frm_save_sss_calamity_loan',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
		});
		
		$('#frm_save_sss_calamity_loan').submit(function (e) { 
			e.preventDefault();
			let action = {
				'action' : 'save_sss_calamity_loan'
			};
			let data = $.param(action) +'&'+ $(this).serialize();
			$.ajax({
				type: "POST",
				url: sss_handler,
				data: data,
				dataType: "json",
				beforeSend: function(){
					buttonDisabledClass($buttonIdClmtyLoan,$iconIdClmtyLoan);
				},success: (response) => {
					console.log(response);
					if(response['result']=="success"){
						notif_success("Updated Successfully");
						buttonEnabledClass($buttonIdClmtyLoan,$iconIdClmtyLoan);
						$('#mdl_save_sss_calamity_loan').modal('hide');
						datatableSSSCalamityLoan.draw();
					}else{
                        buttonDisabledClass($buttonIdClmtyLoan,$iconIdClmtyLoan);
						notif_error('Error Found! This employee number is already exist');
					}
				},error: (err) =>{
					notif_error('Error Found! '+err+' Please contact Local 205/208');
				}
			});
		});

		$('#tblSSSCalamityLoanId').on('click', '.btn_edit', function () {
			let pkid = $(this).attr('data-id');

			readSssCalamityLoan(pkid);
			buttonEnabledClass($buttonIdClmtyLoan,$iconIdClmtyLoan);
			$('#mdl_save_sss_calamity_loan').modal('show');
		});
/*
	SSS Import
*/		
		$('#formImportSSSLoan').submit(function(e){
			e.preventDefault();
			let serialize_data = new FormData(this);
			serialize_data.append('action',"import_sss_data");

			$.ajax({
				url: './handler/sss_handler.php',
				type:"post",
				data: serialize_data,
				dataType:'json',
                cache: false,
				contentType:false,
				processData:false,
				beforeSend: function(){
					$('#btnImportSSSLoan').prop('disabled', true);
				},
				success:function(data)
				{
					$('#SSSLoanImportModal').modal('hide');
					$('#btnImportSSSLoan').prop('disabled', false);
					$('#formImportSSSLoan')[0].reset();
					datatableSSSLoan.ajax.reload();

				},
				error: function(data, xhr, status){
                    console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                }
			});
		});
        
        $('#formImportSSSCalamityLoan').submit(function(e){
			e.preventDefault();
			let serialize_data = new FormData(this);
			serialize_data.append('action',"import_sss_calamity_loan");

			$.ajax({
				url: './handler/sss_handler.php',
				type:"post",
				data: serialize_data,
				dataType:'json',
                cache: false,
				contentType:false,
				processData:false,
				beforeSend: function(){
					$('#btnImportSSSCalamityLoan').prop('disabled', true);
				},
				success:function(data)
				{
					$('#SSSCalamityLoanImportModal').modal('hide');
					$('#btnImportSSSCalamityLoan').prop('disabled', false);
					$('#formImportSSSCalamityLoan')[0].reset();
					datatableSSSCalamityLoan.ajax.reload();

				},
				error: function(data, xhr, status){
                    console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                }
			});
		});


	});

</script>

