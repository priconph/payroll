<section class="main">		
	<section class="tab-pane active fade in content">
		<div class="row">
			<div class="col">
				<div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-puzzle-piece fa-lg"> Reports</i>
					</div>
					<div class="panel-body">
                        <div class="row">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#payroll_reports" aria-controls="payroll_reports" role="tab" data-toggle="tab">Payroll Reports</a></li>
                                <li role="presentation"><a href="#labor_alloc" aria-controls="labor_alloc" role="tab" data-toggle="tab"> Labor Allocation </a></li>
                                <li role="presentation"><a href="#sss_reports" aria-controls="sss_reports" role="tab" data-toggle="tab"> SSS Reports </a></li>
                                <li role="presentation"><a href="#philhealth_reports" aria-controls="philhealth_reports" role="tab" data-toggle="tab"> Philhealth Reports</a></li>
                                <li role="presentation"><a href="#pagibig_reports" aria-controls="pagibig_reports" role="tab" data-toggle="tab"> Pag-ibig Reports</a></li>

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="payroll_reports">
								<button class="btn btn-primary fa pull-left" id="btnPayrollReport" title= "Payroll Report"><i class="fa fa-file-excel-o"></i> Export Payroll Report</button>
                                <button class="btn btn-primary fa pull-left" id="btnPayrollValidation" title= "Payroll Validation"><i class="fa fa-file-excel-o"></i> Export Payroll Validation</button>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="labor_alloc">
								<button class="btn btn-primary fa pull-left" id="btnLaborAllocationReport" title= "Labor Allocation Report"><i class="fa fa-file-excel-o"></i> Export Labor Allocation</button>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="sss_reports">
								<button class="btn btn-primary fa pull-left" id="btnSSSPremium" title= "SSS Premium Report"><i class="fa fa-file-excel-o"></i> Export SSS Premium</button>
                                <button class="btn btn-primary fa pull-left" id="btnSSSCalamityReport" title= "SSS & Calamity Report"><i class="fa fa-file-excel-o"></i> Export SSS & Calamity Loan</button>
                                <button class="btn btn-primary fa pull-left" id="btnSSSContributionReport" title= "SSS Contribution Report"><i class="fa fa-file-excel-o"></i> Export SSS Contribution</button>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="philhealth_reports">
                                <button class="btn btn-primary fa pull-left" id="btnPHContReport" title= "Philhealth Premium Report"><i class="fa fa-file-excel-o"></i> Export Philhealth Premium</button>
							    <button class="btn btn-primary fa pull-left" id="btnPhilhealthContributionReport" title= "Philhealth Contribution Report"><i class="fa fa-file-excel-o"></i> Export Philhealth Contribution</button>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="pagibig_reports">
                                    <button class="btn btn-primary fa pull-left" id="btnPagibigPremiums" title= "Pag-ibig Premiums"><i class="fa fa-file-excel-o"></i> Export Pag-ibig Premiums</button>
                                    <button class="btn btn-primary fa pull-left" id="btnPagibigLoans" title= "Pag-ibig Loans"><i class="fa fa-file-excel-o"></i> Export Pag-ibig Loans</button>
                                    <button class="btn btn-primary fa pull-left" id="btnPagibigContri" title= "Pag-ibig Contribution"><i class="fa fa-file-excel-o"></i> Export Pag-ibig Contribution</button>
                                </div>

                            </div>
                            
                        </div>
					</div>
				</div>
			</div>
		</div>
        <div class="modal fade" tabindex="-1" role="dialog" id="modalPayrollReportExport">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><strong>Export Payroll Report</strong></h4>
                    </div>
                    <form id="formPayrollReportExport">
                        <div class="modal-body">
                            <div class="form-group"> 
                                <label class="form-control-label">Month:</label> 
                                <select class="form-control" id="selectMonth" name="month">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>
                            <div class="form-group"> 
                                <label class="form-control-label">Cutoff:</label> 
                                <select class="form-control" id="selectCutoff" name="cutoff">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">First</option>
                                    <option value="2">Last</option>
                                </select>
                            </div>
                            <div class="form-group"> 
                                <label class="form-control-label">Salary Type:</label> 
                                <select class="form-control" id="selectSalaryType" name="salary_type">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Daily</option>
                                    <option value="2">Montly</option>
                                    <option value="4">JS/SS</option>
                                    <option value="5">Rice Sub.</option>
                                    <option value="6">VL Conversion</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Close</button>
                            <button type="submit" class="btn btn-success" id="btnPayrollReportExport">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalLaborAllocationExport">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><strong>Export Labor Allocation</strong></h4>
                    </div>
                    <form id="formLaborAllocationExport">
                        <div class="modal-body">
                        <div class="form-group"> 
                                <label class="form-control-label">Month:</label> 
                                <select class="form-control" id="selectLaborAllocationMonth" name="month">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>

                            <div class="form-group"> 
                                <label class="form-control-label">Cutoff:</label> 
                                <select class="form-control" id="selectLaborAllocationCutoff" name="cutoff">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">First</option>
                                    <option value="2">Last</option>
                                </select>
                            </div>

                            <div class="form-group"> 
                                <label class="form-control-label">Salary Type:</label> 
                                <select class="form-control" id="selectLaborAllocationSalaryType" name="salary_type">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Daily</option>
                                    <option value="2">Montly</option>
                                    <option value="4">JS/SS</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Close</button>
                            <button type="submit" class="btn btn-success" id="btnLaborAllocationExport">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalSSSCalamityLoanReport">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><strong>Export SSS & Calamity Loan Report</strong></h4>
                    </div>
                    <form id="formSSSCalamityLoanReport">
                        <div class="modal-body">
                            <div class="form-group"> 
                                <label class="form-control-label">Month:</label> 
                                <select class="form-control" id="selectMonth" name="month">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>
                            <div class="form-group"> 
                                <label class="form-control-label">Salary Type:</label> 
                                <select class="form-control" id="selectSalaryType" name="salary_type">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Daily</option>
                                    <option value="2">Montly</option>
                                    <option value="4">JS/SS</option>
                                </select>
                            </div>

                            <div class="form-group"> 
                                <label class="form-control-label">Cutoff:</label> 
                                <select class="form-control" id="selectCutoff" name="cutoff">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">First</option>
                                    <option value="2">Last</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Close</button>
                            <button type="submit" class="btn btn-success" id="btnPayrollReportExport">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" tabindex="-1" role="dialog" id="modalSSSContributionReport">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><strong>Export SSS Contribution Report</strong></h4>
                    </div>
                    <form id="formSSSContributionReport">
                        <div class="modal-body">
                            <div class="form-group"> 
                                <label class="form-control-label">Month:</label> 
                                <select class="form-control" id="selectMonth" name="month">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>
                            <div class="form-group"> 
                                <label class="form-control-label">Salary Type:</label> 
                                <select class="form-control" id="selectSalaryType" name="salary_type">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Daily</option>
                                    <option value="2">Montly</option>
                                    <option value="4">JS/SS</option>
                                </select>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Close</button>
                            <button type="submit" class="btn btn-success" id="btnPayrollReportExport">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalPhilhealthContributionReport">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><strong>Export Phil. Health Contribution Report</strong></h4>
                    </div>
                    <form id="formPhilhealthContributionReport">
                        <div class="modal-body">
                            <div class="form-group"> 
                                <label class="form-control-label">Salary Type:</label> 
                                <select class="form-control" id="selectSalaryType" name="salary_type">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Daily</option>
                                    <option value="2">Montly</option>
                                    <option value="4">JS/SS</option>
                                </select>
                            </div>
                            <div class="form-group"> 
                                <label class="form-control-label">Cutoff:</label> 
                                <select class="form-control" id="selectCutoff" name="cutoff">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">First</option>
                                    <option value="2">Last</option>
                                </select>
                            </div>
                            
                            <div class="form-group"> 
                                <label class="form-control-label">Month:</label> 
                                <select class="form-control" id="selectMonth" name="month">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Close</button>
                            <button type="submit" class="btn btn-success" id="btnExportPhilhealthReport">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalPagibigPremiumExport">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><strong>Export Pagibig Premiums</strong></h4>
                    </div>
                    <form id="formPagibigPremiumExport">
                        <div class="modal-body">
                            <div class="form-group"> 
                                <label class="form-control-label">Salary Type:</label> 
                                <select class="form-control" id="selectSalaryType" name="salary_type">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Daily</option>
                                    <option value="2">Montly</option>
                                    <option value="4">JS/SS</option>
                                </select>
                            </div>

                            <div class="form-group"> 
                                <label class="form-control-label">Cutoff:</label> 
                                <select class="form-control" id="selectCutoff" name="cutoff">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">First</option>
                                    <option value="2">Last</option>
                                </select>
                            </div>
                            
                            <div class="form-group"> 
                                <label class="form-control-label">Month:</label> 
                                <select class="form-control" id="selectMonth" name="month">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Close</button>
                            <button type="submit" class="btn btn-success" id="btnPagibigPremiumExport">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalPagibigContriExport">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><strong>Export Pagibig Contribution</strong></h4>
                    </div>
                    <form id="formPagibigContriExport">
                        <div class="modal-body">
                            <div class="form-group"> 
                                <label class="form-control-label">Salary Type:</label> 
                                <select class="form-control" id="selectSalaryType" name="salary_type">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Daily</option>
                                    <option value="2">Montly</option>
                                    <option value="4">JS/SS</option>
                                </select>
                            </div>
                            <div class="form-group"> 
                                <label class="form-control-label">Cutoff:</label> 
                                <select class="form-control" id="selectCutoff" name="cutoff">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">First</option>
                                    <option value="2">Last</option>
                                </select>
                            </div>
                            
                            <div class="form-group"> 
                                <label class="form-control-label">Month:</label> 
                                <select class="form-control" id="selectMonth" name="month">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Close</button>
                            <button type="submit" class="btn btn-success" id="btnPagibigContriExport">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade" tabindex="-1" role="dialog" id="modalPagibigLoans">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><strong>Export Pagibig Loans</strong></h4>
                    </div>
                    <form id="formPagibigLoansExport">
                        <div class="modal-body">
                            <div class="form-group"> 
                                <label class="form-control-label">Salary Type:</label> 
                                <select class="form-control" id="selectSalaryType" name="salary_type">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Daily</option>
                                    <option value="2">Monthly</option>
                                    <option value="4">JS/SS</option>
                                </select>
                            </div>
                            <div class="form-group"> 
                                <label class="form-control-label">Cutoff:</label> 
                                <select class="form-control" id="selectCutoff" name="cutoff">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">First</option>
                                    <option value="2">Last</option>
                                </select>
                            </div>
                            <div class="form-group"> 
                                <label class="form-control-label">Month:</label> 
                                <select class="form-control" id="selectMonth" name="month">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Close</button>
                            <button type="submit" class="btn btn-success" id="btnPagibigLoansExport">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalSSSPremium">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><strong>Export SSS Premium Report</strong></h4>
                    </div>
                    <form id="formSSSPremiumReport">
                        <div class="modal-body">
                            <div class="form-group"> 
                                <label class="form-control-label">Month:</label> 
                                <select class="form-control" id="selectMonth" name="month">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>
                            <div class="form-group"> 
                                <label class="form-control-label">Cutoff:</label> 
                                <select class="form-control" id="selectCutoff" name="cutoff">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">First</option>
                                    <option value="2">Last</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Close</button>
                            <button type="submit" class="btn btn-success" id="btnSSSPremiumReport">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalPhilHealthPremium">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><strong>Export Phil Health Premium Report</strong></h4>
                    </div>
                    <form id="formPhilHealthPremiumReport">
                        <div class="modal-body">

                            <div class="form-group"> 
                                <label class="form-control-label">Cutoff:</label> 
                                <select class="form-control" id="selectCutoff" name="cutoff">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">First</option>
                                    <option value="2">Last</option>
                                </select>
                            </div>

                            <div class="form-group"> 
                                <label class="form-control-label">Month:</label> 
                                <select class="form-control" id="selectMonth" name="month">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Close</button>
                            <button type="submit" class="btn btn-success" id="btnPhilHealthPremiumReport">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="modalPayrollValidation">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><strong>Export Payroll Validation Report</strong></h4>
                    </div>
                    <form id="formPayrollValidationReport">
                        <div class="modal-body">
                            <div class="form-group"> 
                                <label class="form-control-label">Month:</label> 
                                <select class="form-control" id="selectMonth" name="month">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Jan</option>
                                    <option value="2">Feb</option>
                                    <option value="3">Mar</option>
                                    <option value="4">Apr</option>
                                    <option value="5">May</option>
                                    <option value="6">Jun</option>
                                    <option value="7">Jul</option>
                                    <option value="8">Aug</option>
                                    <option value="9">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>
                            <div class="form-group"> 
                                <label class="form-control-label">Cutoff:</label> 
                                <select class="form-control" id="selectCutoff" name="cutoff">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">First</option>
                                    <option value="2">Last</option>
                                </select>
                            </div>

                            <div class="form-group"> 
                                <label class="form-control-label">Salary Type:</label> 
                                <select class="form-control" id="selectPayrollValidationSalaryType" name="salary_type">
                                    <option value="0" disabled selected>Select One</option>
                                    <option value="1">Daily</option>
                                    <option value="2">Montly</option>
                                    <option value="4">JS/SS</option>
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="float:left;">Close</button>
                            <button type="submit" class="btn btn-success" id="btnPayrollValidationReport">Export</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

	</section>
</section>

<script src="js/report.js?n=4" type="text/javascript">
    // function exportToExcelPayrollReport() {
    //     let payrollReport = $("#selectSalaryType").val();
                    
    //     if( payrollReport == '' ) {
    //         alert("Please select salary type.");
            
    //     } else {
	// 	    window.location.href = "./reports/export_payroll_report.php?";
    //     }
    // }
</script>

