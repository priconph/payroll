<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Check if the OOP file is existed
 * then include
 */


/**
 * Query
 */

$get_payroll_data = get_payroll_data();
// echo count($get_payroll_data['ctr']);
// echo json_encode($get_payroll_data);

// echo json_encode($get_payroll_data);
// var_dump($get_payroll_data['regular_pay']);


// return;

function get_payroll_data(){
	require_once ('../class/payroll_oop.php');
	$PayrollValidationMonth   = $_GET['PayrollValidationSelectMonth'];
	$PayrollValidationCutOff   = $_GET['PayrollValidationCutOffType'];
	$PayrollValidationSalaryType = $_GET['PayrollValidationSelectSalaryType'];
	// echo json_encode($PayrollValidationMonth).'<br>';
	// echo json_encode($PayrollValidationSalaryType).'<br>';
	// echo json_encode($PayrollValidationSalaryType).'<br><br>';
	// exit();
	$return             = $_POST;
	$result             = '';
	$array_fields       = array(
								'employee_no',
								'employee_name',
								'regular_pay',
								'thirteenth_month',
								'ot1',
								'ot1_amount',
								'ot2',
								'ot2_amount',
								'ot2a',
								'ot2a_amount',
								'ot3',
								'ot3_amount',
								'ot3a',
								'ot3a_amount',
								'ot4',
								'ot4_amount',
								'ot4a',
								'ot4a_amount',
								'ot5',
								'ot5_amount',
								'ot5a',
								'ot5a_amount',
								'ot6',
								'ot6_amount',
								'ot6a',
								'ot6a_amount',
								'nightdiff',
								'nightdiff_amount',
								'sl',
								'sl_amount',
								'vl',
								'vl_amount',
								'bl',
								'bl_amount',
								'bdl',
								'bdl_amount',
								'shutdown',
								'shutdown_amount',
								'ecola',
								'salary_adj',
								'allowance',
								'ctpa_prod_allow',
								'socio_eco_allow',
								'other_earnings',
								'abs_days',
								'abs_amnt',
								'undertime',
								'undertime_amnt',
								'gross_pay',
								'sss_premium',
								'ph_premium',
								'pagibig',
								'sss_loan',
								'sss_cal_loan',
								'pagibig_loan',
								'pagibig_cal_loan',
								'hipar',
								'adv_other_deduc',
								'tax_adj',
								'with_tax',
								'net_pay'
							);
	$table              = 'tbl_payroll_info_data a';
	$joins              = 'INNER JOIN tbl_payroll_info b
							ON b.id = a.fkid_payroll_info
							';
	$sql_where          = 'WHERE a.fkid_payroll_info = b.id
							AND b.cut_off ='.$PayrollValidationCutOff.'
							AND b.description ='.$PayrollValidationSalaryType.'
							AND MONTH(b.date_cut_off)='.$PayrollValidationMonth.'';


	$sql_order          = '';
	$sql_limit          = '';
	$result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// $result             = PAYROLL::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// return $result;
	$ctr = 0;
	// $eeshare = 0;
	while($row = mysqli_fetch_array($result)){
		$return ['employee_no'][] = $row ['employee_no'];
		$return ['employee_name'][] = $row ['employee_name'];
		$return ['regular_pay'][] = $row ['regular_pay'];
		$return ['thirteenth_month'][] = $row ['thirteenth_month'];
		$return ['ot1'][] = $row ['ot1'];
		$return ['ot1_amount'][] = $row ['ot1_amount'];
		$return ['ot2'][] = $row ['ot2'];
		$return ['ot2_amount'][] = $row ['ot2_amount'];
		$return ['ot2a'][] = $row ['ot2a'];
		$return ['ot2a_amount'][] = $row ['ot2a_amount'];
		$return ['ot3'][] = $row ['ot3'];
		$return ['ot3_amount'][] = $row ['ot3_amount'];
		$return ['ot3a'][] = $row ['ot3a'];
		$return ['ot3a_amount'][] = $row ['ot3a_amount'];
		$return ['ot4'][] = $row ['ot4'];
		$return ['ot4_amount'][] = $row ['ot4_amount'];
		$return ['ot4a'][] = $row ['ot4a'];
		$return ['ot4a_amount'][] = $row ['ot4a_amount'];
		$return ['ot5'][] = $row ['ot5'];
		$return ['ot5_amount'][] = $row ['ot5_amount'];
		$return ['ot5a'][] = $row ['ot5a'];
		$return ['ot5a_amount'][] = $row ['ot5a_amount'];
		$return ['ot6'][] = $row ['ot6'];
		$return ['ot6_amount'][] = $row ['ot6_amount'];
		$return ['ot6a'][] = $row ['ot6a'];
		$return ['ot6a_amount'][] = $row ['ot6a_amount'];
		$return ['nightdiff'][] = $row ['nightdiff'];
		$return ['nightdiff_amount'][] = $row ['nightdiff_amount'];
		$return ['sl'][] = $row ['sl'];
		$return ['sl_amount'][] = $row ['sl_amount'];
		$return ['vl'][] = $row ['vl'];
		$return ['vl_amount'][] = $row ['vl_amount'];
		$return ['bl'][] = $row ['bl'];
		$return ['bl_amount'][] = $row ['bl_amount'];
		$return ['bdl'][] = $row ['bdl'];
		$return ['bdl_amount'][] = $row ['bdl_amount'];
		$return ['shutdown'][] = $row ['shutdown'];
		$return ['shutdown_amount'][] = $row ['shutdown_amount'];
		$return ['ecola'][] = $row ['ecola'];
		$return ['salary_adj'][] = $row ['salary_adj'];
		$return ['allowance'][] = $row ['allowance'];
		$return ['ctpa_prod_allow'][] = $row ['ctpa_prod_allow'];
		$return ['socio_eco_allow'][] = $row ['socio_eco_allow'];
		$return ['other_earnings'][] = $row ['other_earnings'];
		$return ['abs_days'][] = $row ['abs_days'];
		$return ['abs_amnt'][] = $row ['abs_amnt'];
		$return ['undertime'][] = $row ['undertime'];
		$return ['undertime_amnt'][] = $row ['undertime_amnt'];
		$return ['gross_pay'][] = $row ['gross_pay'];
		$return ['sss_premium'][] = $row ['sss_premium'];
		$return ['ph_premium'][] = $row ['ph_premium'];
		$return ['pagibig'][] = $row ['pagibig'];
		$return ['sss_loan'][] = $row ['sss_loan'];
		$return ['sss_cal_loan'][] = $row ['sss_cal_loan'];
		$return ['pagibig_loan'][] = $row ['pagibig_loan'];
		$return ['pagibig_cal_loan'][] = $row ['pagibig_cal_loan'];
		$return ['hipar'][] = $row ['hipar'];
		$return ['adv_other_deduc'][] = $row ['adv_other_deduc'];
		$return ['tax_adj'][] = $row ['tax_adj'];
		$return ['with_tax'][] = $row ['with_tax'];
		$return ['net_pay'][] = $row ['net_pay'];
		// $return ['employee_no'][] = $row ['employee_no'];
		
		$ctr++;
	}
	// $return['ctr']  = $ctr;
	return $return;
}





/**
 * Excel
 */
$excel_class = '../class/excel_new.php';
if(file_exists($excel_class)){
	include($excel_class);
}else{
	echo 'File '.$excel_class.' does not exist';
	exit;
}

/* Excel initialization */
$excel = new EXCEL;
/* Set Title */
$excel->title = 'Payroll Validation';
/* Add a new page */
$excel->add_page();
/* Set page orientation */
$excel->set_page_orientation_a4_landscape();
/* Use the default font style */
$excel->set_default_font_style();
/* Select an active page */
$excel->set_active_sheet(0);
/* Set margin */
$excel->set_margin();
/* Set print area */
$excel->set_print_area();

// $width_allowance = .81;

// /* Set width */
// $excel->set_width('A',$width_allowance+10);
// $excel->set_width('B',$width_allowance+10);
// $excel->set_width('C',$width_allowance+10);

$excel->objPHPExcel->getColumnDimension('A')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('B')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('C')->setAutoSize(true);

/**
 * Font weight
 */

$arial_font_12 = array(
		'font'  => array(
			'name'   => 'Arial',
			'size'   => '12',
		),
	);

$arial_font_12_bold = array(
		'font'  => array(
			'name'   => 'Arial',
			'size'   => '12',
			'bold'	=> 'true',
		),
	);

$hv_center = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);

$hl_center = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
);



/* Header Columns */
$excel->objPHPExcel->setCellValue('A1','Employee No.');
$excel->objPHPExcel->setCellValue('B1','Employee Name');
$excel->objPHPExcel->setCellValue('C1','Regular Pay');
$excel->objPHPExcel->setCellValue('D1','Thirteenth Month');
$excel->objPHPExcel->setCellValue('E1','OT + Night Diff');
$excel->objPHPExcel->setCellValue('F1','SL');
$excel->objPHPExcel->setCellValue('G1','SL Amount');
$excel->objPHPExcel->setCellValue('H1','VL');
$excel->objPHPExcel->setCellValue('I1','VL Amount');
$excel->objPHPExcel->setCellValue('J1','BL');
$excel->objPHPExcel->setCellValue('K1','BL Amount');
$excel->objPHPExcel->setCellValue('L1','BDL');
$excel->objPHPExcel->setCellValue('M1','BDL Amount');
$excel->objPHPExcel->setCellValue('N1','Shutdown');
$excel->objPHPExcel->setCellValue('O1','Shutdown Amount');
$excel->objPHPExcel->setCellValue('P1','ECOLA');
$excel->objPHPExcel->setCellValue('Q1','Salary Adjustment');
$excel->objPHPExcel->setCellValue('R1','Allowance');
$excel->objPHPExcel->setCellValue('S1','CTPA Prod Allowance');
$excel->objPHPExcel->setCellValue('T1','Socio Eco Allowance');
$excel->objPHPExcel->setCellValue('U1','Other Earnings');
$excel->objPHPExcel->setCellValue('V1','Absent Days');
$excel->objPHPExcel->setCellValue('W1','Absent Amount');
$excel->objPHPExcel->setCellValue('X1','Undertime');
$excel->objPHPExcel->setCellValue('Y1','Undertime Amount');
$excel->objPHPExcel->setCellValue('Z1','Gross Pay');
$excel->objPHPExcel->setCellValue('AA1','SSS Premium');
$excel->objPHPExcel->setCellValue('AB1','Philhealth Premium');
$excel->objPHPExcel->setCellValue('AC1','Pagibig');
$excel->objPHPExcel->setCellValue('AD1','SSS Loan');
$excel->objPHPExcel->setCellValue('AE1','SSS Calamity Loan');
$excel->objPHPExcel->setCellValue('AF1','Pagibig Loan');
$excel->objPHPExcel->setCellValue('AG1','Pagibig Calamity Loan');
$excel->objPHPExcel->setCellValue('AH1','HIPAR');
$excel->objPHPExcel->setCellValue('AI1','Advance Other Deduction');
$excel->objPHPExcel->setCellValue('AJ1','Tax Adjustment');
$excel->objPHPExcel->setCellValue('AK1','With Tax');
$excel->objPHPExcel->setCellValue('AL1','Net Pay');

// $excel->objPHPExcel->setCellValue('E1','OT1');
// $excel->objPHPExcel->setCellValue('F1','OT1 Amount');
// $excel->objPHPExcel->setCellValue('G1','OT2');
// $excel->objPHPExcel->setCellValue('H1','OT2 Amount');
// $excel->objPHPExcel->setCellValue('I1','OT2A');
// $excel->objPHPExcel->setCellValue('J1','OT2A Amount');
// $excel->objPHPExcel->setCellValue('K1','OT3');
// $excel->objPHPExcel->setCellValue('L1','OT3 Amount');
// $excel->objPHPExcel->setCellValue('M1','OT3A');
// $excel->objPHPExcel->setCellValue('N1','OT3A Amount');
// $excel->objPHPExcel->setCellValue('O1','OT4');
// $excel->objPHPExcel->setCellValue('P1','OT4 Amount');
// $excel->objPHPExcel->setCellValue('Q1','OT4a');
// $excel->objPHPExcel->setCellValue('R1','OT4A Amount');
// $excel->objPHPExcel->setCellValue('S1','OT5');
// $excel->objPHPExcel->setCellValue('T1','OT5 Amount');
// $excel->objPHPExcel->setCellValue('U1','OT5A');
// $excel->objPHPExcel->setCellValue('V1','OT5A Amount');
// $excel->objPHPExcel->setCellValue('W1','OT6');
// $excel->objPHPExcel->setCellValue('X1','OT6 Amount');
// $excel->objPHPExcel->setCellValue('Y1','OT6A');
// $excel->objPHPExcel->setCellValue('Z1','OT6A Amount');
// $excel->objPHPExcel->setCellValue('AA1','Night Diff');
// $excel->objPHPExcel->setCellValue('AB1','Night Diff Amount');
// $excel->objPHPExcel->setCellValue('AC1','SL');
// $excel->objPHPExcel->setCellValue('AD1','SL Amount');
// $excel->objPHPExcel->setCellValue('AE1','VL');
// $excel->objPHPExcel->setCellValue('AF1','VL Amount');
// $excel->objPHPExcel->setCellValue('AG1','BL');
// $excel->objPHPExcel->setCellValue('AH1','BL Amount');
// $excel->objPHPExcel->setCellValue('AI1','BDL');
// $excel->objPHPExcel->setCellValue('AJ1','BDL Amount');
// $excel->objPHPExcel->setCellValue('AK1','Shutdown');
// $excel->objPHPExcel->setCellValue('AL1','Shutdown Amount');
// $excel->objPHPExcel->setCellValue('AM1','ECOLA');
// $excel->objPHPExcel->setCellValue('AN1','Salary Adjustment');
// $excel->objPHPExcel->setCellValue('AO1','Allowance');
// $excel->objPHPExcel->setCellValue('AP1','CTPA Prod Allowance');
// $excel->objPHPExcel->setCellValue('AQ1','Socio Eco Allowance');
// $excel->objPHPExcel->setCellValue('AR1','Other Earnings');
// $excel->objPHPExcel->setCellValue('AS1','Absent Days');
// $excel->objPHPExcel->setCellValue('AT1','Absent Amount');
// $excel->objPHPExcel->setCellValue('AU1','Undertime');
// $excel->objPHPExcel->setCellValue('AV1','Undertime Amount');
// $excel->objPHPExcel->setCellValue('AW1','Gross Pay');
// $excel->objPHPExcel->setCellValue('AX1','SSS Premium');
// $excel->objPHPExcel->setCellValue('AY1','Philhealth Premium');
// $excel->objPHPExcel->setCellValue('AZ1','Pagibig');
// $excel->objPHPExcel->setCellValue('BA1','SSS Loan');
// $excel->objPHPExcel->setCellValue('BB1','SSS Calamity Loan');
// $excel->objPHPExcel->setCellValue('BC1','Pagibig Loan');
// $excel->objPHPExcel->setCellValue('BD1','Pagibig Calamity Loan');
// $excel->objPHPExcel->setCellValue('BE1','HIPAR');
// $excel->objPHPExcel->setCellValue('BF1','Advance Other Deduction');
// $excel->objPHPExcel->setCellValue('BG1','Tax Adjustment');
// $excel->objPHPExcel->setCellValue('BH1','With Tax');
// $excel->objPHPExcel->setCellValue('BI1','OT + Night Diff');
// $excel->objPHPExcel->setCellValue('BJ1','Net Pay');

$excel->objPHPExcel->getColumnDimension('A')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('B')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('C')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('D')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('E')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('F')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('G')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('H')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('I')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('J')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('K')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('L')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('M')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('N')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('O')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('P')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('Q')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('R')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('S')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('T')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('U')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('V')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('W')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('X')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('Y')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('Z')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('AA')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('AB')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('AC')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('AD')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('AE')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('AF')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('AG')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('AH')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('AI')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('AJ')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('AK')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('AL')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('AM')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('AN')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('AO')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('AP')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('AQ')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('AR')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('AS')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('AT')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('AU')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('AV')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('AW')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('AX')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('AY')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('AZ')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('BA')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('BB')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('BC')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('BD')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('BE')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('BF')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('BG')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('BH')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('BI')->setAutoSize(true);
// $excel->objPHPExcel->getColumnDimension('BJ')->setAutoSize(true);

$excel->objPHPExcel->getStyle('A1:BJ1')->applyFromArray($hv_center);
$excel->objPHPExcel->getStyle('A1:BJ1')->applyFromArray($arial_font_12_bold);


$rowCounter = 2;
$rowStart = 2;
for ($u=0; $u <count($get_payroll_data['employee_no']) ; $u++) { 
	$employee_name = str_replace("(","",$get_payroll_data['employee_name'][$u]);
	$emp_name = str_replace(")","",$employee_name);
	$excel->objPHPExcel->setCellValue('A'.$rowCounter,$get_payroll_data['employee_no'][$u]);
	$excel->objPHPExcel->setCellValue('B'.$rowCounter,$emp_name);
	$excel->objPHPExcel->setCellValue('C'.$rowCounter,$get_payroll_data['regular_pay'][$u]);
	$excel->objPHPExcel->setCellValue('D'.$rowCounter,$get_payroll_data['thirteenth_month'][$u]);
	$total = (double)$get_payroll_data['ot1_amount'][$u] + (double)$get_payroll_data['ot2_amount'][$u]+ (double)$get_payroll_data['ot2a_amount'][$u]
	+ (double)$get_payroll_data['ot3_amount'][$u]+ (double)$get_payroll_data['ot3a_amount'][$u] + (double)$get_payroll_data['ot4_amount'][$u]
	+ (double)$get_payroll_data['ot4a_amount'][$u] + (double)$get_payroll_data['ot5_amount'][$u] + (double)$get_payroll_data['ot5a_amount'][$u]
	+ (double)$get_payroll_data['ot6_amount'][$u] + (double)$get_payroll_data['ot6a_amount'][$u] + (double)$get_payroll_data['nightdiff_amount'][$u];
	$excel->objPHPExcel->setCellValue('E'.$rowCounter,$total,'number_2_decimal');
	$excel->objPHPExcel->setCellValue('F'.$rowCounter,$get_payroll_data['sl'][$u]);
	$excel->objPHPExcel->setCellValue('G'.$rowCounter,$get_payroll_data['sl_amount'][$u]);
	$excel->objPHPExcel->setCellValue('H'.$rowCounter,$get_payroll_data['vl'][$u]);
	$excel->objPHPExcel->setCellValue('I'.$rowCounter,$get_payroll_data['vl_amount'][$u]);
	$excel->objPHPExcel->setCellValue('J'.$rowCounter,$get_payroll_data['bl'][$u]);
	$excel->objPHPExcel->setCellValue('K'.$rowCounter,$get_payroll_data['bl_amount'][$u]);
	$excel->objPHPExcel->setCellValue('L'.$rowCounter,$get_payroll_data['bdl'][$u]);
	$excel->objPHPExcel->setCellValue('M'.$rowCounter,$get_payroll_data['bdl_amount'][$u]);
	$excel->objPHPExcel->setCellValue('N'.$rowCounter,$get_payroll_data['shutdown'][$u]);
	$excel->objPHPExcel->setCellValue('O'.$rowCounter,$get_payroll_data['shutdown_amount'][$u]);
	$excel->objPHPExcel->setCellValue('P'.$rowCounter,$get_payroll_data['ecola'][$u]);
	$excel->objPHPExcel->setCellValue('Q'.$rowCounter,$get_payroll_data['salary_adj'][$u]);
	$excel->objPHPExcel->setCellValue('R'.$rowCounter,$get_payroll_data['allowance'][$u]);
	$excel->objPHPExcel->setCellValue('S'.$rowCounter,$get_payroll_data['ctpa_prod_allow'][$u]);
	$excel->objPHPExcel->setCellValue('T'.$rowCounter,$get_payroll_data['socio_eco_allow'][$u]);
	$excel->objPHPExcel->setCellValue('U'.$rowCounter,$get_payroll_data['other_earnings'][$u]);
	$excel->objPHPExcel->setCellValue('V'.$rowCounter,$get_payroll_data['abs_days'][$u]);
	$excel->objPHPExcel->setCellValue('W'.$rowCounter,$get_payroll_data['abs_amnt'][$u]);
	$excel->objPHPExcel->setCellValue('X'.$rowCounter,$get_payroll_data['undertime'][$u]);
	$excel->objPHPExcel->setCellValue('Y'.$rowCounter,$get_payroll_data['undertime_amnt'][$u]);
	$excel->objPHPExcel->setCellValue('Z'.$rowCounter,$get_payroll_data['gross_pay'][$u]);
	$excel->objPHPExcel->setCellValue('AA'.$rowCounter,$get_payroll_data['sss_premium'][$u]);
	$excel->objPHPExcel->setCellValue('AB'.$rowCounter,$get_payroll_data['ph_premium'][$u]);
	$excel->objPHPExcel->setCellValue('AC'.$rowCounter,$get_payroll_data['pagibig'][$u]);
	$excel->objPHPExcel->setCellValue('AD'.$rowCounter,$get_payroll_data['sss_loan'][$u]);
	$excel->objPHPExcel->setCellValue('AE'.$rowCounter,$get_payroll_data['sss_cal_loan'][$u]);
	$excel->objPHPExcel->setCellValue('AF'.$rowCounter,$get_payroll_data['pagibig_loan'][$u]);
	$excel->objPHPExcel->setCellValue('AG'.$rowCounter,$get_payroll_data['pagibig_cal_loan'][$u]);
	$excel->objPHPExcel->setCellValue('AH'.$rowCounter,$get_payroll_data['hipar'][$u]);
	$excel->objPHPExcel->setCellValue('AI'.$rowCounter,$get_payroll_data['adv_other_deduc'][$u]);
	$excel->objPHPExcel->setCellValue('AJ'.$rowCounter,$get_payroll_data['tax_adj'][$u]);
	$excel->objPHPExcel->setCellValue('AK'.$rowCounter,$get_payroll_data['with_tax'][$u]);
	$excel->objPHPExcel->setCellValue('AL'.$rowCounter,$get_payroll_data['net_pay'][$u]);
	// $excel->objPHPExcel->setCellValue('BJ'.$rowCounter,$get_payroll_data['regular_pay'][$u]);

	// $excel->objPHPExcel->setCellValue('E'.$rowCounter,$get_payroll_data['ot1'][$u]);
	// $excel->objPHPExcel->setCellValue('F'.$rowCounter,$get_payroll_data['ot1_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('G'.$rowCounter,$get_payroll_data['ot2'][$u]);
	// $excel->objPHPExcel->setCellValue('H'.$rowCounter,$get_payroll_data['ot2_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('I'.$rowCounter,$get_payroll_data['ot2a'][$u]);
	// $excel->objPHPExcel->setCellValue('J'.$rowCounter,$get_payroll_data['ot2a_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('K'.$rowCounter,$get_payroll_data['ot3'][$u]);
	// $excel->objPHPExcel->setCellValue('L'.$rowCounter,$get_payroll_data['ot3_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('M'.$rowCounter,$get_payroll_data['ot3a'][$u]);
	// $excel->objPHPExcel->setCellValue('N'.$rowCounter,$get_payroll_data['ot3a_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('O'.$rowCounter,$get_payroll_data['ot4'][$u]);
	// $excel->objPHPExcel->setCellValue('P'.$rowCounter,$get_payroll_data['ot4_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('Q'.$rowCounter,$get_payroll_data['ot4a'][$u]);
	// $excel->objPHPExcel->setCellValue('R'.$rowCounter,$get_payroll_data['ot4a_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('S'.$rowCounter,$get_payroll_data['ot5'][$u]);
	// $excel->objPHPExcel->setCellValue('T'.$rowCounter,$get_payroll_data['ot5_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('U'.$rowCounter,$get_payroll_data['ot5a'][$u]);
	// $excel->objPHPExcel->setCellValue('V'.$rowCounter,$get_payroll_data['ot5a_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('W'.$rowCounter,$get_payroll_data['ot6'][$u]);
	// $excel->objPHPExcel->setCellValue('X'.$rowCounter,$get_payroll_data['ot6_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('Y'.$rowCounter,$get_payroll_data['ot6a'][$u]);
	// $excel->objPHPExcel->setCellValue('Z'.$rowCounter,$get_payroll_data['ot6a_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('AA'.$rowCounter,$get_payroll_data['nightdiff'][$u]);
	// $excel->objPHPExcel->setCellValue('AB'.$rowCounter,$get_payroll_data['nightdiff_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('AC'.$rowCounter,$get_payroll_data['sl'][$u]);
	// $excel->objPHPExcel->setCellValue('AD'.$rowCounter,$get_payroll_data['sl_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('AE'.$rowCounter,$get_payroll_data['vl'][$u]);
	// $excel->objPHPExcel->setCellValue('AF'.$rowCounter,$get_payroll_data['vl_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('AG'.$rowCounter,$get_payroll_data['bl'][$u]);
	// $excel->objPHPExcel->setCellValue('AH'.$rowCounter,$get_payroll_data['bl_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('AI'.$rowCounter,$get_payroll_data['bdl'][$u]);
	// $excel->objPHPExcel->setCellValue('AJ'.$rowCounter,$get_payroll_data['bdl_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('AK'.$rowCounter,$get_payroll_data['shutdown'][$u]);
	// $excel->objPHPExcel->setCellValue('AL'.$rowCounter,$get_payroll_data['shutdown_amount'][$u]);
	// $excel->objPHPExcel->setCellValue('AM'.$rowCounter,$get_payroll_data['ecola'][$u]);
	// $excel->objPHPExcel->setCellValue('AN'.$rowCounter,$get_payroll_data['salary_adj'][$u]);
	// $excel->objPHPExcel->setCellValue('AO'.$rowCounter,$get_payroll_data['allowance'][$u]);
	// $excel->objPHPExcel->setCellValue('AP'.$rowCounter,$get_payroll_data['ctpa_prod_allow'][$u]);
	// $excel->objPHPExcel->setCellValue('AQ'.$rowCounter,$get_payroll_data['socio_eco_allow'][$u]);
	// $excel->objPHPExcel->setCellValue('AR'.$rowCounter,$get_payroll_data['other_earnings'][$u]);
	// $excel->objPHPExcel->setCellValue('AS'.$rowCounter,$get_payroll_data['abs_days'][$u]);
	// $excel->objPHPExcel->setCellValue('AT'.$rowCounter,$get_payroll_data['abs_amnt'][$u]);
	// $excel->objPHPExcel->setCellValue('AU'.$rowCounter,$get_payroll_data['undertime'][$u]);
	// $excel->objPHPExcel->setCellValue('AV'.$rowCounter,$get_payroll_data['undertime_amnt'][$u]);
	// $excel->objPHPExcel->setCellValue('AW'.$rowCounter,$get_payroll_data['gross_pay'][$u]);
	// $excel->objPHPExcel->setCellValue('AX'.$rowCounter,$get_payroll_data['sss_premium'][$u]);
	// $excel->objPHPExcel->setCellValue('AY'.$rowCounter,$get_payroll_data['ph_premium'][$u]);
	// $excel->objPHPExcel->setCellValue('AZ'.$rowCounter,$get_payroll_data['pagibig'][$u]);
	// $excel->objPHPExcel->setCellValue('BA'.$rowCounter,$get_payroll_data['sss_loan'][$u]);
	// $excel->objPHPExcel->setCellValue('BB'.$rowCounter,$get_payroll_data['sss_cal_loan'][$u]);
	// $excel->objPHPExcel->setCellValue('BC'.$rowCounter,$get_payroll_data['pagibig_loan'][$u]);
	// $excel->objPHPExcel->setCellValue('BD'.$rowCounter,$get_payroll_data['pagibig_cal_loan'][$u]);
	// $excel->objPHPExcel->setCellValue('BE'.$rowCounter,$get_payroll_data['hipar'][$u]);
	// $excel->objPHPExcel->setCellValue('BF'.$rowCounter,$get_payroll_data['adv_other_deduc'][$u]);
	// $excel->objPHPExcel->setCellValue('BG'.$rowCounter,$get_payroll_data['tax_adj'][$u]);
	// $excel->objPHPExcel->setCellValue('BH'.$rowCounter,$get_payroll_data['with_tax'][$u]);
	// $excel->objPHPExcel->setCellValue('BJ'.$rowCounter,$get_payroll_data['net_pay'][$u]);
			
    $rowCounter++;
}
	
	$excel->objPHPExcel->getStyle('A1:BJ'.$rowCounter)->applyFromArray($arial_font_12);
	$excel->objPHPExcel->getStyle('A2:BJ'.$rowCounter)->applyFromArray($hl_center);
	$excel->objPHPExcel->setCellValue('E'.$rowCounter,  '=SUM(E2:E'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('F'.$rowCounter,  '=SUM(F2:F'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('G'.$rowCounter,  '=SUM(G2:G'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('H'.$rowCounter,  '=SUM(H2:H'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('I'.$rowCounter,  '=SUM(I2:I'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('J'.$rowCounter,  '=SUM(J2:J'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('K'.$rowCounter,  '=SUM(K2:K'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('L'.$rowCounter,  '=SUM(L2:L'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('M'.$rowCounter,  '=SUM(M2:M'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('N'.$rowCounter,  '=SUM(N2:N'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('O'.$rowCounter,  '=SUM(O2:O'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('P'.$rowCounter,  '=SUM(P2:P'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('Q'.$rowCounter,  '=SUM(Q2:Q'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('R'.$rowCounter,  '=SUM(R2:R'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('S'.$rowCounter,  '=SUM(S2:S'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('T'.$rowCounter,  '=SUM(T2:T'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('U'.$rowCounter,  '=SUM(U2:U'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('V'.$rowCounter,  '=SUM(V2:V'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('W'.$rowCounter,  '=SUM(W2:W'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('X'.$rowCounter,  '=SUM(X2:X'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('Y'.$rowCounter,  '=SUM(Y2:Y'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('Z'.$rowCounter,  '=SUM(Z2:Z'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('AA'.$rowCounter,  '=SUM(AA2:AA'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('AB'.$rowCounter,  '=SUM(AB2:AB'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('AC'.$rowCounter,  '=SUM(AC2:AC'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('AD'.$rowCounter,  '=SUM(AD2:AD'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('AE'.$rowCounter,  '=SUM(AE2:AE'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('AF'.$rowCounter,  '=SUM(AF2:AF'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('AG'.$rowCounter,  '=SUM(AG2:AG'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('AH'.$rowCounter,  '=SUM(AH2:AH'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('AI'.$rowCounter,  '=SUM(AI2:AI'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('AJ'.$rowCounter,  '=SUM(AJ2:AJ'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('AK'.$rowCounter,  '=SUM(AK2:AK'.($rowCounter -1).')');
	$excel->objPHPExcel->setCellValue('AL'.$rowCounter,  '=SUM(AL2:AL'.($rowCounter -1).')');

/* set file name */
$filename = "Payroll Validation";
/* output excel - filename, excel version (2003,2007) */
$excel->output($filename);
?>
