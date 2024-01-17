<?php
/**
 * Check if the OOP file is existed
 * then include
 */
$oop = '../class/hris-oop.php';
if(file_exists($oop)){
	require_once($oop);
}else{
	echo 'oops not found!';
	exit;
}

$salaryType = $_GET['salaryType'];
$selectCutoff   = $_GET['cutoff'];
$selectMonth   = $_GET['month'];
// echo json_encode($selectCutoff);
// exit();

/**
 * EOM
 */
$array_fields 	= 	array('*');
$table 	   		= 	'tbl_eom';
$joins 	   		=	'';
$sql_where 		= '
					WHERE emp_code = '.$salaryType.'
					AND logdel = 0 
				';
$sql_order 		= '';
$sql_limit 		= '';
$resultOfEOMBySalaryType 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$asanAngBeshyKo🤸‍♀️ 		= array();
while($row = mysqli_fetch_array($resultOfEOMBySalaryType)){
	$asanAngBeshyKo🤸‍♀️['id_number'][]			= $row['id_number'];
	$asanAngBeshyKo🤸‍♀️['emp_code'][] 			= $row['emp_code'];
}

/**
 * HRIS
 */
$resultHRISActiveEmployees 		= HRIS::getInstance()->select_all_active_employee();
$etoAngBeshyMo🤸‍♀️🤸‍♀️ 		= array();
while($row = mysqli_fetch_array($resultHRISActiveEmployees)){
	$etoAngBeshyMo🤸‍♀️🤸‍♀️['pkid'][]			= $row['pkid'];
	$etoAngBeshyMo🤸‍♀️🤸‍♀️['EmpNo'][]			= $row['EmpNo'];
	$etoAngBeshyMo🤸‍♀️🤸‍♀️['LastName'][]		= $row['LastName'];
	$etoAngBeshyMo🤸‍♀️🤸‍♀️['FirstName'][]		= $row['FirstName'];
	$etoAngBeshyMo🤸‍♀️🤸‍♀️['MiddleName'][]	= $row['MiddleName'];
	$etoAngBeshyMo🤸‍♀️🤸‍♀️['DateHired'][]		= $row['DateHired'];
	$etoAngBeshyMo🤸‍♀️🤸‍♀️['SSN'][]			= $row['SSN'];
}

/**
 * Payroll Info Data
 */
$array_fields 	= 	array('*');
$table 	   		= 	'tbl_payroll_info a';
$joins 	   		=	'INNER JOIN tbl_payroll_info_data b 
						ON b.fkid_payroll_info = a.id';
// $sql_where 		= 	'WHERE a.description ='.$salaryType.'
// 						AND a.cut_off ='.$selectCutoff.'';
$sql_where 		= 	'WHERE a.description ='.$salaryType.'
					AND a.cut_off ='.$selectCutoff.'
					AND MONTH(a.date_cut_off)= '.$selectMonth;
$sql_order 		= 	'';
$sql_limit 		= 	'';
$resultOfPayrollInfoData 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$malungkotAngBeshyKo🤸‍♀️🤸‍♀️🤸‍♀️ 		= array();
while($row = mysqli_fetch_array($resultOfPayrollInfoData)){
	$malungkotAngBeshyKo🤸‍♀️🤸‍♀️🤸‍♀️['id'][]					= $row['id'];
	$malungkotAngBeshyKo🤸‍♀️🤸‍♀️🤸‍♀️['employee_no'][]			= $row['employee_no'];
	$malungkotAngBeshyKo🤸‍♀️🤸‍♀️🤸‍♀️['sss_loan'][]			= $row['sss_loan'];
	$malungkotAngBeshyKo🤸‍♀️🤸‍♀️🤸‍♀️['sss_cal_loan'][]			= $row['sss_cal_loan'];
}

$dankMoBeshyKo🤾🏻‍♀️ = array();
$arrayAllEmployeesPayrollInfoData = array();
for ($i=0; $i < count($asanAngBeshyKo🤸‍♀️['id_number']); $i++) { 
	for ($j=0; $j < count($etoAngBeshyMo🤸‍♀️🤸‍♀️['pkid']); $j++) { 
		if($asanAngBeshyKo🤸‍♀️['id_number'][$i] == $etoAngBeshyMo🤸‍♀️🤸‍♀️['EmpNo'][$j]){
			$temporaryArray = array(
				'EmpNo' => $etoAngBeshyMo🤸‍♀️🤸‍♀️['EmpNo'][$j],
				'LastName' => $etoAngBeshyMo🤸‍♀️🤸‍♀️['LastName'][$j],
				'FirstName' => $etoAngBeshyMo🤸‍♀️🤸‍♀️['FirstName'][$j],
				'MiddleName' => $etoAngBeshyMo🤸‍♀️🤸‍♀️['MiddleName'][$j],
				'DateHired' => $etoAngBeshyMo🤸‍♀️🤸‍♀️['DateHired'][$j],
				'SSN' => $etoAngBeshyMo🤸‍♀️🤸‍♀️['SSN'][$j],
			);
			array_push($dankMoBeshyKo🤾🏻‍♀️, $temporaryArray);
		}
	}

	for ($k=0; $k < count($malungkotAngBeshyKo🤸‍♀️🤸‍♀️🤸‍♀️['id']); $k++) { 
		if($asanAngBeshyKo🤸‍♀️['id_number'][$i] == $malungkotAngBeshyKo🤸‍♀️🤸‍♀️🤸‍♀️['employee_no'][$k]){
			$temporaryArray = array(
				'id_number' => $asanAngBeshyKo🤸‍♀️['id_number'][$i],
				'employee_no' => $malungkotAngBeshyKo🤸‍♀️🤸‍♀️🤸‍♀️['employee_no'][$k],
				'sss_loan' => $malungkotAngBeshyKo🤸‍♀️🤸‍♀️🤸‍♀️['sss_loan'][$k],
				'sss_cal_loan' => $malungkotAngBeshyKo🤸‍♀️🤸‍♀️🤸‍♀️['sss_cal_loan'][$k],
			);
			array_push($arrayAllEmployeesPayrollInfoData, $temporaryArray);
		}
		
	}
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
$excel->title = 'SSS Loan';
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
$width_allowance = .81;

/* Set width */
$excel->set_width('A',$width_allowance+30);
$excel->set_width('B',$width_allowance+30);
$excel->set_width('C',$width_allowance+30);

/**
 * Header Columns
 */
$excel->place_value('A1','PRICON MICROELECTRONICS, INC.','string');
// $excel->objPHPExcel->getColumnDimension('A')->setAutoSize(true);
$arrayStyleCellA1 = array(
	'name'   		=> 'Abadi MT Condensed Light',
	'size'   		=> '16',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->setFormat('A1',$arrayStyleCellA1);


$excel->place_value('A2','SSS Salary & Calamity Loan Report','string');
$arrayStyleCellA2 = array(
	'name'   		=> 'Abadi MT Condensed Light',
	'size'   		=> '22',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->setFormat('A2',$arrayStyleCellA2);

$excel->place_value('A3','JS/SS Employees ( June 01 - 15, 2023 )','string');
$arrayStyleCellA3 = array(
	'name'   		=> 'Abadi MT Condensed Light',
	'size'   		=> '16',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->setFormat('A3',$arrayStyleCellA3);

$monthNow = date("F-Y");



$excel->place_value('A4','As of '.$monthNow,'string');
$arrayStyleCellA4 = array(
	'name'   		=> 'Abadi MT Condensed Light',
	'size'   		=> '16',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->setFormat('A4',$arrayStyleCellA4);

$excel->place_value('A6','EmpNo','string');
$excel->place_value('B6','LastName','string');
$excel->place_value('C6','FirstName','string');
$excel->place_value('D6','MiddleName','string');
$excel->place_value('E6','DateHired','string');
$excel->place_value('F6','SSN','string');
$excel->place_value('G6','Salary Loan','string');
$excel->place_value('H6','Calamity Loan','string');
$excel->place_value('I6','Total','string');
// $excel->objPHPExcel->getColumnDimension('A')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('B')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('C')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('D')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('E')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('F')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('G')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('H')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('I')->setAutoSize(true);
$arrayStyleCellA6 = array(
	'size'   		=> '16',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->set_borders('A6:I6',1,1,1,1,'thick');
$excel->setFormat('A6:I6',$arrayStyleCellA6);

$rowCounter = 7;
$rowStart = 7;
// echo json_encode(count($arrayAllEmployeesPayrollInfoData));
// exit();

$beshywapsSalaryLoan = 0;
$beshywapsCalamityLoan = 0;
$beshywapsTotalLoan = 0;

for ($i=0; $i < count($dankMoBeshyKo🤾🏻‍♀️); $i++) { 
	for($beshyMoPagodNa😨😨 = 0; $beshyMoPagodNa😨😨 < count($arrayAllEmployeesPayrollInfoData); $beshyMoPagodNa😨😨++){
		
		if($arrayAllEmployeesPayrollInfoData[$beshyMoPagodNa😨😨]['employee_no'] == $dankMoBeshyKo🤾🏻‍♀️[$i]['EmpNo']){
			// $excel->place_value('K'.$rowCounter,$arrayAllEmployeesPayrollInfoData[$beshyMoPagodNa😨😨]['employee_no'],'string');
			// $excel->place_value('L'.$rowCounter,$dankMoBeshyKo🤾🏻‍♀️[$i]['EmpNo'],'string');

			$excel->place_value('A'.$rowCounter,$dankMoBeshyKo🤾🏻‍♀️[$i]['EmpNo'],'string');
			$excel->place_value('B'.$rowCounter,$dankMoBeshyKo🤾🏻‍♀️[$i]['LastName'],'string');
			$excel->place_value('C'.$rowCounter,$dankMoBeshyKo🤾🏻‍♀️[$i]['FirstName'],'string');
			$excel->place_value('D'.$rowCounter,$dankMoBeshyKo🤾🏻‍♀️[$i]['MiddleName'],'string');
			$excel->place_value('E'.$rowCounter,$dankMoBeshyKo🤾🏻‍♀️[$i]['DateHired'],'string');
			$excel->place_value('F'.$rowCounter,$dankMoBeshyKo🤾🏻‍♀️[$i]['SSN'],'string');
			
			$excel->place_value('G'.$rowCounter,$arrayAllEmployeesPayrollInfoData[$beshyMoPagodNa😨😨]['sss_loan'],'number');
			$excel->place_value('H'.$rowCounter,$arrayAllEmployeesPayrollInfoData[$beshyMoPagodNa😨😨]['sss_cal_loan'],'number');
	
			$total = (double)$arrayAllEmployeesPayrollInfoData[$beshyMoPagodNa😨😨]['sss_loan'] + (double)$arrayAllEmployeesPayrollInfoData[$beshyMoPagodNa😨😨]['sss_cal_loan'];
			$excel->place_value('I'.$rowCounter,$total,'number_2_decimal');
			$arrayStyleStartFromCellA6 = array(
				'name'   		=> 'Arial',
				'size'   		=> '12',
				'horizontal'	=> 'left',
			);
			$excel->setFormat('A'.$rowStart.':E'.$rowCounter,$arrayStyleStartFromCellA6);
			// $excel->set_borders('A'.$rowStart.':I'.$rowCounter,1,1,1,1);
			$beshywapsSalaryLoan += $arrayAllEmployeesPayrollInfoData[$beshyMoPagodNa😨😨]['sss_loan'];
			$beshywapsCalamityLoan += $arrayAllEmployeesPayrollInfoData[$beshyMoPagodNa😨😨]['sss_cal_loan'];
			$beshywapsTotalLoan += $total;

			$rowCounter++;

		}
	}
		// $excel->place_value('A'.$rowCounter,$dankMoBeshyKo🤾🏻‍♀️[$i]['EmpNo'],'string');
		// $excel->place_value('B'.$rowCounter,$dankMoBeshyKo🤾🏻‍♀️[$i]['LastName'],'string');
		// $excel->place_value('C'.$rowCounter,$dankMoBeshyKo🤾🏻‍♀️[$i]['FirstName'],'string');
		// $excel->place_value('D'.$rowCounter,$dankMoBeshyKo🤾🏻‍♀️[$i]['MiddleName'],'string');
		// $excel->place_value('E'.$rowCounter,$dankMoBeshyKo🤾🏻‍♀️[$i]['DateHired'],'string');
		// $excel->place_value('F'.$rowCounter,$dankMoBeshyKo🤾🏻‍♀️[$i]['SSN'],'string');
		
		// $excel->place_value('G'.$rowCounter,$arrayAllEmployeesPayrollInfoData[$i]['sss_loan'],'number');
		// $excel->place_value('H'.$rowCounter,$arrayAllEmployeesPayrollInfoData[$i]['sss_cal_loan'],'number');

		// $total = (double)$arrayAllEmployeesPayrollInfoData[$i]['sss_loan'] + (double)$arrayAllEmployeesPayrollInfoData[$i]['sss_cal_loan'];
		// $excel->place_value('I'.$rowCounter,$total,'number_2_decimal');
		// $arrayStyleStartFromCellA6 = array(
		// 	'name'   		=> 'Arial',
		// 	'size'   		=> '12',
		// 	'horizontal'	=> 'left',
		// );
		// $excel->setFormat('A'.$rowStart.':E'.$rowCounter,$arrayStyleStartFromCellA6);
		// $excel->set_borders('A'.$rowStart.':I'.$rowCounter,1,1,1,1,'thin');
		// $rowCounter++;
		// $beshywapsSalaryLoan += $arrayAllEmployeesPayrollInfoData[$i]['sss_loan'];
		// $beshywapsCalamityLoan += $arrayAllEmployeesPayrollInfoData[$i]['sss_cal_loan'];
		// $beshywapsTotalLoan += $total;
	
}
$excel->place_value('G'.$rowCounter,$beshywapsSalaryLoan,'number');
$excel->place_value('H'.$rowCounter,$beshywapsCalamityLoan,'number');
$excel->place_value('I'.$rowCounter,$beshywapsTotalLoan,'number');

/* set file name */
$filename = "SSS Loan";
/* output excel - filename, excel version (2003,2007) */
$excel->output($filename,'2007');
?>