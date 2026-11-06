<!-- CSS for sticky headers -->
<style>
    .table-wrapper {
        max-height: 550px; /* You can adjust this height */
        overflow-y: auto;
        position: relative;
    }

    /* Sticky table headers */
    #tbl_nav_code thead th {
        position: sticky;
        top: 0;
        z-index: 2;
		padding-top: 5px;
		padding-bottom: 5px;
		padding-right: 5px;
		padding-left: 5px;
		font-size: 16px;
		text-align: center;
		vertical-align: middle;
		padding: 5px 5px;
		margin: 3px 3px;
    }

	/* Columns with teal background */
	#tbl_nav_code thead th:nth-child(1),
	#tbl_nav_code thead th:nth-child(2),
	#tbl_nav_code thead th:nth-child(5),
	#tbl_nav_code thead th:nth-child(6) {
		background-color: teal;
	}

	/* Columns with cadetblue background */
	#tbl_nav_code thead th:nth-child(3),
	#tbl_nav_code thead th:nth-child(4),
	#tbl_nav_code thead th:nth-child(7),
	#tbl_nav_code thead th:nth-child(8) {
		background-color: cadetblue;
	}
</style>

<div class="panel panel-default" id="containerNavCodeCrud">
	<div class="panel-heading">
		<i class="fa fa-file fa-lg"></i> NAV Code CRUD
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<button class="btn btn-primary fa pull-right" id="btnImportSalaryReport" data-toggle="modal" data-target="#modalCreateUpdateNavCode"><i class="fa fa-plus"></i> Create NAV Code</button><br><br>
			</div>
		</div>
		<div class="table responsive">
			<div class="table-wrapper">
			<table class="table table-hover table-striped table-bordered" id="tbl_nav_code" style="width:100%;">
					<thead>
						<tr>
							<th>Action</th>
							<th>Status</th>
							<th>Nav Code <br> Department</th>
							<th>Department</th>
							<th>Nav Code <br> Section</th>
							<th>Section</th>
							<th>Nav Code <br> Division</th>
							<th>Division</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- CREATE / UPDATE NAV CODE -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalCreateUpdateNavCode" aria-labelledby="navModalLabel">
	<div class="modal-dialog modal-m" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title" id="navModalLabel" style="color: white;">
					<i class="fa fa-plus-circle"></i> Add or Update NAV Code
				</h5>
			</div>

			<form id="formCreateUpdateNavCode">
				<div class="modal-body">
					<input type="hidden" class="reset-value" id="navCodePkid" name="nav_code_pkid">
					<div class="container-fluid">

						<div class="form-row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nav_code_department" class="col-form-label">NAV Code - Department</label>
									<input type="text" class="form-control reset-value" id="navCodeDepartment" name="nav_code_department" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="department" class="col-form-label">Department</label>
									<input type="text" class="form-control reset-value" id="department" name="department" required>
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nav_code_section" class="col-form-label">NAV Code - Section</label>
									<input type="text" class="form-control reset-value" id="navCodeSection" name="nav_code_section" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="section" class="col-form-label">Section</label>
									<input type="text" class="form-control reset-value" id="section" name="section" required>
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nav_code_division" class="col-form-label">NAV Code - Division</label>
									<input type="text" class="form-control reset-value" id="navCodeDivision" name="nav_code_division" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="division" class="col-form-label">Division</label>
									<input type="text" class="form-control reset-value" id="division" name="division" required>
								</div>
							</div>
						</div>					
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">
						Close
					</button>
					<button type="submit" class="btn btn-success">
						<i class="fa fa-save"></i> Save
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- NAV CODE CHANGE STATUS -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalNavCodeChangeStatus" aria-labelledby="navModalLabel">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary">
				<h5 class="modal-title" id="navCodeChangeStatusTitle" style="color: white;">
					<i class="fa fa-cog"></i> NAV Code Change Status
				</h5>
			</div>

			<form id="formNavCodeChangeStatus">
				<div class="modal-body">
					<input type="hidden" class="reset-value" id="navCodeStatusPkid" name="nav_code_status_pkid">
					<input type="hidden" class="reset-value" id="navCodeStatus" name="nav_code_status">
					<div class="container-fluid" id="navCodeChangeStatusLabel">
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">
						Close
					</button>
					<button type="submit" class="btn btn-success">
						<i class="fa fa-save"></i> Save
					</button>
				</div>
			</form>
		</div>
	</div>
</div>



