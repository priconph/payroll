<section class="main">		
	<section class="tab-pane active fade in content">
		<div class="row">
			<div class="col">
				<div class="panel panel-primary">
                	<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Working Days</i>
					</div>
					<div class="panel-body">
                        <div class="row">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#sss_loan" aria-controls="sss_loan" role="tab" data-toggle="tab"> Working Days</a></li>
                                <!-- <li role="presentation"><a href="#sss_premium" aria-controls="sss_premium" role="tab" data-toggle="tab"> SSS Premium</a></li> -->
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="sss_loan">
                                    <button class="btn btn-primary fa pull-left" id="btnImportSSSLoan" data-toggle="modal" data-target="#mdl_working_days"><i class="fa fa-upload"></i> Add Working Days</button>
                                        <br>
                                        <br>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-condensed table-hover" id="tblWorkingDaysId">
                                            <thead>
                                                <!-- <th style="width: 500px;">Id</th> -->
                                                <th style="width: 500px;">Working Days</th>
                                                <th style="width: 100px;">Action</th>
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
    <div class="modal fade" id="mdl_working_days" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog" style="margin-top:0%;">
			<div class="modal-content">
				<div class="modal-header" style="overflow-y:auto;">
					Add Working Days
				</div>
				<form id="frm_working_days">
					<div class="modal-body" style="overflow-y:auto;">
							
							<div class="row" style="margin-top:-10px;">
								<div class="col-sm-12">
									<div class="form-group">
										<label for="dt_start_date" class="col-form-label">Number of Working Days</label>
										<input type="number" class="form-control"  name="number_of_working_days">
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
    
    <div class="modal fade" id="mdl_update_working_days" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog" style="margin-top:0%;">
			<div class="modal-content">
				<div class="modal-header" style="overflow-y:auto;">
					New Taxes Info
				</div>
				<form id="frm_update_working_days">
					<div class="modal-body" style="overflow-y:auto;">
							<div class="row" style="margin-top:-10px;">
								<div class="col-sm-12">
									<div class="form-group">
										<input type="hidden" class="form-control"  name="working_days_id">
									</div>
								</div>
							</div>

							<div class="row" style="margin-top:-10px;">
								<div class="col-sm-12">
									<div class="form-group">
										<label for="dt_start_date" class="col-form-label">Number of Working Days</label>
										<input type="number" class="form-control"  name="edit_number_of_working_days">
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

<script>
	$(document).ready(function(){
        handler_payroll_info = './handler/handler_payroll_info.php';

		$('#frm_working_days').submit(function (e) { 
			e.preventDefault();
			let action = {
				'action' : 'add_working_days'
			};
			let data = $.param(action) +'&'+ $(this).serialize();
			$.ajax({
				type: "POST",
				url: handler_payroll_info,
				data: data,
				dataType: "json",
				success: function (response) {
					if(response['result']=="success"){
						alert("Created Successfully");
						$('#mdl_working_days').modal('hide');
						$('#frm_working_days')[0].reset();
						datatableWorkingDays.draw();
					}else{
						alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!');
					}
				},error: function (response){
					console.log('error: '+response);
					alert('Something is wrong, please reload the page. If error persists, kindly contact ISS at local 205. Thank you!'); 
				}
			});
		});

        datatableWorkingDays = $('#tblWorkingDaysId').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "./server_side_scripts/workingdays/dt_working_days.php",
			"drawCallback": function( settings ) {
				$('#tblWorkingDaysId').attr('style','width:100%;');
			}
		});

        // 

        $('#tblWorkingDaysId').on('click','.workingdays-data-edit',function () {
			let pkid = $(this).attr('data-id');

            console.log(pkid);

            // return
			getWorkingDaysId(pkid);
			
			$('#mdl_update_working_days').modal('show');
		});

        function getWorkingDaysId(pkid){
			// console.log(pkid);
			// return;
			let array_data = {
				'action' : 'get_working_days_id',
				'pkid'	 : pkid
			};
			let data = $.param(array_data);
			$.ajax({
				type: "POST",
				url: handler_payroll_info,
				data: data,
				dataType:  "json",
				success: function (response) {
					console.log(response['ctr']);
					for(var i=0;i<response['ctr'];i++){
						$('#frm_update_working_days input[name="working_days_id"]').val(response['Pkid'][i]);
						$('#frm_update_working_days input[name="edit_number_of_working_days"]').val(response['working_days'][i]);
					}
				}
			});
		}

        $('#frm_update_working_days').submit(function (e) { 
			e.preventDefault();
			let action = {
				'action' : 'update_working_days'
			};
			let data = $.param(action) +'&'+ $(this).serialize();
			$.ajax({
				type: "POST",
				url: handler_payroll_info,
				data: data,
				dataType: "json",
				success: function (response) {
					if(response['result']=="success"){
						alert("Updated Successfully");
						$('#mdl_update_working_days').modal('hide');
						datatableWorkingDays.draw();
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

        // 


	});

</script>

