<section class="main">		
	<section class="tab-pane active fade in content">
		<div class="row">
			<div class="col">
				<div class="panel panel-primary">
					<div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> EOM Data</i>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col">
								<button class="btn btn-primary fa pull-left" id="btnImportData" data-toggle="modal" data-target="#EOMImportModal"><i class="fa fa-upload"></i> Import Data</button><br><br>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-condensed table-hover" id="dtOEM">
										<thead>
											<th>Employee No.</th>
											<th>Employee Name</th>
											<th>Employee Code</th>
											<th>Absences</th>
											<th>Undertime</th>
											<th>Night diff</th>
											<th>SL</th>
											<th>VL</th>
											<th>OT 1</th>
											<th>OT 2</th>
											<th>OT 2A</th>
											<th>OT 3</th>
											<th>OT 3A</th>
											<th>OT 4</th>
											<th>OT 4A</th>
											<th>OT 5</th>
											<th>OT 5A</th>
											<th>OT 6</th>
											<th>OT 6A</th>
											<th>ADJ 1</th>
											<th>ADJ 2</th>
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
<!-- Modal for system message -->
<div class="modal fade" tabindex="-1" role="dialog" id="EOMImportModal" data-backdrop="static">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-file-excel-o"></i> Import EOM</h4>
      </div>
	  	<form id="formImportEOM" method="" enctype="multipart/form-data">
		  <div class="modal-body">
			<!-- <label class="col-md-4 control-label">Choose CSV File</label>
			<input type="file" name="oem_file" id="fileOEM" accept=".csv"> -->
			<div class="form-group">
				<label for="file">Choose CSV File</label>
				<input type="file" name="file" class="form-control-file" id="file" accept=".csv" required>
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary" name="import" id="btnImport"><i class="fa fa-upload" id="importIcons"></i> Import</button>
			<button type="button" class="btn btn-default fa fa-close" data-dismiss="modal" id="btn_close"> Close</button>
		  </div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
	$(document).ready(function(){
		// let eom_handler = 'eom_handler.php';
		$('#formImportEOM').submit(function(e){
			e.preventDefault();
			let serialize_data = new FormData(this);
			serialize_data.append('action',"import_eom_data");

			$.ajax({
				url: './handler/handler.php',
				type:"post",
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
					$('#EOMImportModal').modal('hide');
					$('#btnImport').prop('disabled', false);
					$('#formImportEOM')[0].reset();
					notif_success('Import Successfully');
					datatableEOM.ajax.reload();
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

		datatableEOM = $('#dtOEM').DataTable({
			"aaSorting"	 : [],
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "./server_side_scripts/eom/dt_eom.php",
			"drawCallback": function( settings ) {
				$('#dtOEM').attr('style','width:100%;');
			}
		});

		

	});

</script>
<script src="" type="text/javascript"></script>
<script src="js/common_functions.js?1" type="text/javascript"></script>
