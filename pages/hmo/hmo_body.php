<section class="main">		
	<section class="tab-pane active fade in content">
		<div class="row">
			<div class="col">
				<div class="panel panel-primary">
					<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> HMO Data</i>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-3">
								<button class="btn btn-primary fa" id="btnImportData" data-toggle="modal" data-target="#HMOImportModal"><i class="fa fa-upload"></i> Import Data</button><br><br>
							</div>
							<div class="col-sm-9">
								<button class="btn btn-success fa pull-right" id="btnCreate" data-toggle="modal" data-target="#mdlCreate"><i class="fa fa-plus"></i> New</button><br><br>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="table responsive">
									<table class="table table-striped table-bordered table-condensed table-hover" id="dtHMO">
										<thead>
											<th>Employee No.</th>
											<th>Employee Name</th>
											<th>Amount (Half)</th>
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
	</section>
</section>
<!---------------------
	Create Modal
---------------------->
<div class="modal fade" id="mdl_save_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog" style="margin-top:0%;margin-left: 45%;">
		<div class="modal-content" style="width:50%">
			<div class="modal-header" style="overflow-y:auto;">
				HMO Info
			</div>
			<form id="frm_save_info">
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
								<select type="text" class="form-control"  name="txt_emp_no" id="txt_emp_no" style="width:100%;" required>
								</select>
							</div>
						</div>
					</div>
					<div class="row" style="margin-top:-10px;">
						<div class="col-sm-12">
							<div class="form-group">
								<label for="int_amount" class="col-form-label">Amount (Half)</label>
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
<!-- Modal for system message -->
<div class="modal fade" tabindex="-1" role="dialog" id="HMOImportModal">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><i class="fa fa-file-excel-o"></i> Import HMO</h4>
			</div>
			<form id="formImportHMO" method="" enctype="multipart/form-data">
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
	$(document).ready(function(){
		var hmo_handler ="./handler/hmo_handler.php";
		var $buttonId 	= $('#frm_save_info #btnSave');
		var $iconId		= $("#frm_save_info #iconsSave");

		var datatableHMO = $('#dtHMO').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "./server_side_scripts/hmo/dt_hmo.php",
			"drawCallback": function( settings ) {
				$('#dtHMO').attr('style','width:100%;');
			}
		});

		$('#btnCreate').click(function () { 
			$('#mdl_save_info').modal('show');
			// dd_hris_all_list
			$('#frm_save_info')[0].reset();
			buttonEnabledClass($buttonId,$iconId);
			re_initialize_select2_server_side('#mdl_save_info #txt_emp_no','#mdl_save_info #frm_save_info',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
		});

		$('#frm_save_info').submit(function (e) { 
			e.preventDefault();
			
			let action = {
				'action' : 'save_info'
			};
			let data = $.param(action) +'&'+ $(this).serialize();
			$.ajax({
				type: "POST",
				url: hmo_handler,
				data: data,
				dataType: "json",
				beforeSend: function(){
					buttonDisabledClass($buttonId,$iconId);
				},
				success: (response) => {
					if(response['result']=="success"){
						notif_success("Updated Successfully");
						datatableHMO.draw();
						buttonEnabledClass($buttonId,$iconId);
						$('#mdl_save_info').modal('hide');
					}else{
						buttonDisabledClass($buttonId,$iconId);
						notif_error('Error Found! Please contact Local 205/208');
					}
				},error: (err) =>{
					notif_error('Error Found! '+err+' Please contact Local 205/208');
				}
			});
		});

		$('#dtHMO').on('click', '.fa-edit', function () {
			let pkid = $(this).attr('data-id');

			console.log(pkid);

			readInfo(pkid);

			$('#mdl_save_info').modal('show');
		});
		
		$('#formImportHMO').submit(function(e){
			e.preventDefault();
			let serialize_data = new FormData(this);
			serialize_data.append('action',"import_hmo_data");

			$.ajax({
				url: './handler/hmo_handler.php',
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
					$('#HMOImportModal').modal('hide');
					$('#btnImport').prop('disabled', false);
					$('#formImportHMO')[0].reset();
					notif_success('Import Successfully');
					datatableHMO.ajax.reload();

				},
				error: function(data, xhr, status){
                    console.log('Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
					$('#btnImport').prop('disabled', false);
					notif_error('Import Failed. Please try again.');

                }
			});

		});

		function readInfo(pkid){
			// console.log(pkid);
			// return;
			let array_data = {
				'action' : 'read_info',
				'pkid'	 : pkid
			};
			let data = $.param(array_data);
			$.ajax({
				type: "POST",
				url: hmo_handler,
				data: data,
				dataType:  "json",
				success: function (response) {
					$('#frm_save_info input[name="data_id"]').val(response['pkid']);
					assign_value_select2('#frm_save_info #txt_emp_no',response['emp_no'][0]);
					$('#frm_save_info input[name="int_amount"]').val(response['hmo_amount']);
					re_initialize_select2_server_side('#mdl_save_info #txt_emp_no','#mdl_save_info #frm_save_info',[],"server_side_scripts/dropdown/common/dd_hris_all_list.php");
				}
			});
		}
	});

</script>
<script src="" type="text/javascript"></script>
<!-- <script src="js/common_functions.js?n=1" type="text/javascript"></script> -->
