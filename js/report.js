$(document).ready(function () {
	
	/**
	 * Start
	 * JD
	 */
	const alerts = (zxc, yyy)=>{
		window.location.href = "./reports/export_sss_contribution_report.php?salaryType="+zxc+"&month="+yyy;
	}
	/* SSS Salary & Calamity Loan */
	$('#btnSSSCalamityReport').click(function (e) {
		e.preventDefault();
		console.log('btnSSSCalamityReport');
		$('#modalSSSCalamityLoanReport').modal('show');
	});

	$("#formSSSCalamityLoanReport").submit(function(event){
		event.preventDefault();
		let salaryType = $("#selectSalaryType", $('#formSSSCalamityLoanReport')).val();
		let cutOff = $("#selectCutoff", $('#formSSSCalamityLoanReport')).val();
		let selMonth = $("#selectMonth", $('#formSSSCalamityLoanReport')).val();
		console.log('Salary Type ', salaryType)
		console.log('cutOff ', cutOff)
		console.log('selected month ', selMonth)
        if( salaryType == null ){
            alert("Please select salary type.");
        }
		// if(selMonth == null){
        //     alert("Please select month.");
		// }
		else{
			// window.location.href = "./reports/export_sss_calamity_loan.php?salaryType="+salaryType+"&cutoff="+cutOff;
			window.location.href = "./reports/export_sss_calamity_loan.php?salaryType="+salaryType+"&cutoff="+cutOff+"&month="+selMonth;
        }
	});

	$('#modalSSSCalamityLoanReport').on('hide.bs.modal', function() {
		$('#selectSalaryType', $('#formSSSCalamityLoanReport')).val(0).trigger('change');
		console.log('Reset Value')
	});

	/* SSS Contribution */
	$('#btnSSSContributionReport').click(function (e) {
		e.preventDefault();
		console.log('btnSSSContributionReport');
		$('#modalSSSContributionReport').modal('show');
	});

	$("#formSSSContributionReport").submit(function(event){
		event.preventDefault();
		let qwe = $("#selectSalaryType", $('#formSSSContributionReport')).val();
		let selMonth = $("#selectMonth", $('#formSSSContributionReport')).val();
		
		console.log('Salary Type:', qwe)
		console.log('Selected Month:', selMonth)
        if( qwe == null ){
            alert("Please select salary type.");
        }
		if( selMonth == null ){
            alert("Please select Month.");
        }
		else{
			alerts(qwe,selMonth);
        }
	});
	$('#modalSSSCalamityLoanReport').on('hide.bs.modal', function() {
		$('#selectSalaryType', $('#formSSSContributionReport')).val(0).trigger('change');
		console.log('Reset Value')
	});
	/**
	 * End
	 * JD
	 */

	// ================ CHAN IS WAVING ================
	/** START PAYROLL REPORT EXPORT **/
	$('#btnPayrollReport').click(function (e) {
		e.preventDefault();
		console.log('btnPayrollReport');
		$('#modalPayrollReportExport').modal('show');
	});

	$("#formPayrollReportExport").submit(function(event){
		event.preventDefault();
		let selectMonth 	= $("#selectMonth", $('#formPayrollReportExport')).val();
		let selectCutoff 	= $("#selectCutoff", $('#formPayrollReportExport')).val();
		let salaryType 		= $("#selectSalaryType", $('#formPayrollReportExport')).val();

		console.log(selectMonth + + selectCutoff + + salaryType)
        if( selectMonth == null || selectCutoff == null || salaryType == null ){
            alert("Please select details to export.");
            
        }else{
			window.location.href = "./reports/export_payroll_report.php?selectMonth="+selectMonth+"&selectCutoff="+selectCutoff+"&salaryType="+salaryType;
        }
	});

	$('#modalPayrollReportExport').on('hide.bs.modal', function() {
		$('#selectSalaryType').val(0).trigger('change');
		console.log('Reset Value')
	});
	/** END PAYROLL REPORT EXPORT **/

	/** START LABOR ALLOCATION REPORT EXPORT **/
	$('#btnLaborAllocationReport').click(function (e) {
		e.preventDefault();
		console.log('btnLaborAllocationExport');
		$('#modalLaborAllocationExport').modal('show');
	});

	$('#btnLaborAllocationReportv2').click(function (e) {
		e.preventDefault();
		console.log('btnLaborAllocationExport v2');
		$('#modalLaborAllocationExport').modal('show');
	});

	// $("#formLaborAllocationExport").submit(function(event){
	// 	event.preventDefault();
	// 	let LaborAllocationMonth = $("#selectLaborAllocationMonth").val();
	// 	let LaborAllocationCutOff = $("#selectLaborAllocationCutoff").val();
	// 	let LaborAllocationSalaryType = $("#selectLaborAllocationSalaryType").val();
	// 	console.log('Labor Allocation Month:', LaborAllocationMonth)
	// 	console.log('Labor Allocation Salary CutOff:', LaborAllocationCutOff)
	// 	console.log('Labor Allocation Salary Type:', LaborAllocationSalaryType)
    //     if( LaborAllocationSalaryType == null){
    //         alert("Please select salary type.");
    //     }
	// 	else if(LaborAllocationCutOff == null){
	// 		alert("Please select cutoff.");
	// 	}
	// 	else{
	// 		window.location.href = "./reports/export_labor_allocation.php?LaborAllocationSelectMonth="+LaborAllocationMonth+"&LaborAllocSelectCutoff="+LaborAllocationCutOff+"&LaborAllocsalaryType="+LaborAllocationSalaryType;
	// 		// window.location.href = "./reports/export_labor_allocation.php?LaborAllocsalaryType=1&LaborAllocSelectCutoff=2";
    //     }
	// });

	function getLaborAllocationParams() {
		const LaborAllocationMonth = $("#selectLaborAllocationMonth").val();
		const LaborAllocationCutOff = $("#selectLaborAllocationCutoff").val();
		const LaborAllocationSalaryType = $("#selectLaborAllocationSalaryType").val();
	
		console.log('Labor Allocation Month:', LaborAllocationMonth);
		console.log('Labor Allocation Salary CutOff:', LaborAllocationCutOff);
		console.log('Labor Allocation Salary Type:', LaborAllocationSalaryType);
	
		if (!LaborAllocationSalaryType) {
			alert("Please select salary type.");
			return null;
		}
	
		if (!LaborAllocationCutOff) {
			alert("Please select cutoff.");
			return null;
		}
	
		return {
			month: LaborAllocationMonth,
			cutoff: LaborAllocationCutOff,
			type: LaborAllocationSalaryType
		};
	}
	
	$('#btnLaborAllocationExport').click(function (e) {
		e.preventDefault();
		const params = getLaborAllocationParams();
		if (params) {
			window.location.href = `./reports/export_labor_allocation.php?LaborAllocationSelectMonth=${params.month}&LaborAllocSelectCutoff=${params.cutoff}&LaborAllocsalaryType=${params.type}`;
		}
	});
	
	$('#btnLaborAllocationExportv2').click(function (e) {
		e.preventDefault();
		const params = getLaborAllocationParams();
		if (params) {
			window.location.href = `./reports/export_labor_allocation_v2.php?LaborAllocationSelectMonth=${params.month}&LaborAllocSelectCutoff=${params.cutoff}&LaborAllocsalaryType=${params.type}`;
		}
	});
	

	$('#modalLaborAllocationExport').on('hide.bs.modal', function() {
		$('#selectLaborAllocationSalaryType').val(0).trigger('change');
		$('#selectLaborAllocationCutoff').val(0).trigger('change');
		console.log('Reset Value')
	});
	/** END PAYROLL ALLOCATION EXPORT **/
	// ================ CHAN IS WAVING AGAIN ================

	/** START SSS AND PHILHEALTH PREMIUM  EXPORT **/
	$('#btnSSSPremium').click(function (e) {
		e.preventDefault();
		console.log('btnSSSPremium');
		// window.location.href = "./reports/export_sss_premium.php?";
		$('#modalSSSPremium').modal('show');
	});

	$("#formSSSPremiumReport").submit(function(event){
		event.preventDefault();

		let SSSPremiumCutOff = $("#selectCutoff", $('#formSSSPremiumReport')).val();
		let SSSPremiumSelMonth = $("#selectMonth", $('#formSSSPremiumReport')).val();

		console.log('SSS Premium Salary CutOff:', SSSPremiumCutOff)
		console.log('SSS Premium Salary Month:', SSSPremiumSelMonth)
		
		window.location.href = "./reports/export_sss_premium.php?SSSPremiumCutOffType="+SSSPremiumCutOff+"&SSSPremiumSelMonth="+SSSPremiumSelMonth;

	});

	$('#btnPHContReport').click(function (e) {
		e.preventDefault();
		console.log('btnPHContReport');
		// window.location.href = "./reports/export_sss_premium.php?";
		$('#modalPhilHealthPremium').modal('show');
	});

	$("#formPhilHealthPremiumReport").submit(function(event){
		event.preventDefault();

		let PhilHealthCutOff = $("#selectCutoff", $('#formPhilHealthPremiumReport')).val();
		let selectMonth 	= $("#selectMonth", $('#formPhilHealthPremiumReport')).val();

		console.log('Philhealth Premium CutOff:', PhilHealthCutOff)
		console.log('Month', selectMonth)
		
		window.location.href = "./reports/export_philhealth_premium.php?PhilHealthCutOffType="+PhilHealthCutOff+"&selectMonth="+selectMonth;

	});

	/** END SSS AND PHILHEALTH PREMIUM EXPORT **/


	/** START PAYROLL VALIDATION REPORT EXPORT **/

	// $('#btnPayrollValidation').click(function (e) {
	// 	e.preventDefault();
	// 	console.log('btnPayrollValidation');
	// 	window.location.href = "./reports/export_payroll_validation.php?";
	// });

	$('#btnPayrollValidation').click(function (e) {
		e.preventDefault();
		console.log('btnPayrollValidation');
		// window.location.href = "./reports/export_sss_premium.php?";
		$('#modalPayrollValidation').modal('show');
	});

	$("#formPayrollValidationReport").submit(function(event){
		event.preventDefault();

		let PayrollValidationMonth = $("#selectMonth", $('#formPayrollValidationReport')).val();
		let PayrollValidationCutOff = $("#selectCutoff", $('#formPayrollValidationReport')).val();
		let PayrollValidationSalaryType = $("#selectPayrollValidationSalaryType", $('#formPayrollValidationReport')).val();

		console.log('Payroll Validation CutOff:', PayrollValidationCutOff)
		
		window.location.href = "./reports/export_payroll_validation.php?PayrollValidationCutOffType="+PayrollValidationCutOff+"&PayrollValidationSelectSalaryType="+PayrollValidationSalaryType+"&PayrollValidationSelectMonth="+PayrollValidationMonth;
	});

	/** END PAYROLL VALIDATION REPORT EXPORT **/

	// 

	/** START PHILHEALTH CONTRIBUTION EXPORT **/
	$('#btnPhilhealthContributionReport').click(function (e) {
		e.preventDefault();
		console.log('btnPhilhealthContributionReport');
		$('#modalPhilhealthContributionReport').modal('show');
	});
	$("#formPhilhealthContributionReport").submit(function(event){
		event.preventDefault();
		let salaryType = $("#selectSalaryType", $('#formPhilhealthContributionReport')).val();
		let PhilHealthContributionCutOff = $("#selectCutoff", $('#formPhilhealthContributionReport')).val();
		let selectMonth= $("#selectMonth", $('#formPhilhealthContributionReport')).val();

		console.log('Philhealth Contribution CutOff:', PhilHealthContributionCutOff)
		console.log('Salary Type:', salaryType)
		console.log('Month:', selectMonth)
		
        if( salaryType == null ){
            alert("Please select salary type.");
        }else{
			// window.location.href = "./reports/export_philhealth_contribution_report.php?salaryType="+salaryType;
			window.location.href = "./reports/export_philhealth_contribution_report.php?salaryType="+salaryType+"&PhilHealthContributionCutOffType="+PhilHealthContributionCutOff+"&selectMonth="+selectMonth;

        }
	});
	$('#modalPhilhealthContributionReport').on('hide.bs.modal', function() {
		$('#selectSalaryType', $('#formPhilhealthContributionReport')).val(0).trigger('change');
		console.log('Reset Value')
	});

	/** PAGIBIG PREMIUM EXPORT **/
	$('#btnPagibigPremiums').click(function (e) {
		e.preventDefault();
		console.log('btnPagibigPremiums');
		$('#modalPagibigPremiumExport').modal('show');
	});
	$("#formPagibigPremiumExport").submit(function(event){
		event.preventDefault();
		let salaryType = $("#selectSalaryType", $('#formPagibigPremiumExport')).val();
		let selectCutoff = $("#selectCutoff", $('#formPagibigPremiumExport')).val();
		let selectMonth 	= $("#selectMonth", $('#formPagibigPremiumExport')).val();

		console.log('Salary Type:', salaryType)
		console.log('CutOff:', selectCutoff)
		console.log('Month:', selectMonth)
        if( salaryType == null ){
            alert("Please select salary type.");
        }else{
			window.location.href = "./reports/export_pagibig_premium_report.php?salaryType="+salaryType+"&selectCutoff="+selectCutoff+"&selectMonth="+selectMonth;
        }
	});

	$('#modalPagibigPremiumExport').on('hide.bs.modal', function() {
		$('#selectSalaryType', $('#formPagibigPremiumExport')).val(0).trigger('change');
		console.log('Reset Value')
	});

	/* Contribution */
	$('#btnPagibigContri').click(function (e) {
		e.preventDefault();
		console.log('btnPagibigContri');
		$('#modalPagibigContriExport').modal('show');
	});
	$("#formPagibigContriExport").submit(function(event){
		event.preventDefault();
		let salaryType = $("#selectSalaryType", $('#formPagibigContriExport')).val();
		let cutOff = $("#selectCutoff", $('#formPagibigContriExport')).val();
		let selectMonth 	= $("#selectMonth", $('#formPagibigContriExport')).val();

		console.log('Salary Type:', salaryType)
		console.log('Cutoff:', cutOff)
		console.log('Month:', selectMonth)

        if(salaryType == null || cutOff == null ){
            alert("Please select salary type.");
        }else{
			window.location.href = "./reports/export_pagibig_contri_report.php?salaryType="+salaryType+"&cutOff="+cutOff+"&selectMonth="+selectMonth;
        }
	});

	$('#modalPagibigContriExport').on('hide.bs.modal', function() {
		$('#selectSalaryType', $('#formPagibigContriExport')).val(0).trigger('change');
		console.log('Reset Value')
	});

	/* Loans */
	$('#btnPagibigLoans').click(function (e) {
		e.preventDefault();
		console.log('btnPagibigLoans');
		$('#modalPagibigLoans').modal('show');
	});

	$("#formPagibigLoansExport").submit(function(event){
		event.preventDefault();
		let selectMonth 	= $("#selectMonth", $('#formPagibigLoansExport')).val();
		let selectCutoff 	= $("#selectCutoff", $('#formPagibigLoansExport')).val();
		let salaryType 		= $("#selectSalaryType", $('#formPagibigLoansExport')).val();
		// let pagibigLoanCutOff = $("#selectCutoff", $('#formPagibigLoansExport')).val();

		console.log('Salary Type:', salaryType)
		console.log('Cut Off:', selectCutoff)
		console.log('Month:', selectMonth)
		// console.log('Cut Off:', pagibigLoanCutOff)

        if( salaryType == null ){
            alert("Please select salary type.");
        }else{
			window.location.href = "./reports/export_pagibig_loans_report.php?salaryType="+salaryType+"&selectCutoff="+selectCutoff+"&selectMonth="+selectMonth;
        }
	});
	
	$('#modalPagibigLoans').on('hide.bs.modal', function() {
		$('#selectSalaryType', $('#formPagibigLoansExport')).val(0).trigger('change');
		console.log('Reset Value')
	});

	/** START HRIS USER EXPORT **/
	$('#btnHrisActiveUser').click(function (e) {
		e.preventDefault();
		console.log('btnHrisActiveUser');
		$('#modalHrisActiveUserExport').modal('show');
	});

	$("#formHrisActiveUserExport").submit(function(event){
		event.preventDefault();
		let contribution = $("#selectContribution").val();
		console.log('Contribution:', contribution)

		window.location.href = "./reports/export_hris_active_user.php?contribution="+contribution;
	});
});