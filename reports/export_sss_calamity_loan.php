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
$resultEOMArray 		= array();
while($row = mysqli_fetch_array($resultOfEOMBySalaryType)){
	$resultEOMArray['id_number'][]			= $row['id_number'];
	$resultEOMArray['emp_code'][] 			= $row['emp_code'];
}

/**
 * HRIS
 */
$resultHRISActiveEmployees 		= HRIS::getInstance()->select_all_active_employee();
$resultHRISArray 		= array();
while($row = mysqli_fetch_array($resultHRISActiveEmployees)){
	$resultHRISArray['pkid'][]			= $row['pkid'];
	$resultHRISArray['EmpNo'][]			= $row['EmpNo'];
	$resultHRISArray['LastName'][]		= $row['LastName'];
	$resultHRISArray['FirstName'][]		= $row['FirstName'];
	$resultHRISArray['MiddleName'][]	= $row['MiddleName'];
	$resultHRISArray['DateHired'][]		= $row['DateHired'];
	$resultHRISArray['SSN'][]			= $row['SSN'];
}

/**
 * Payroll Info Data
 */

if($selectMonth == 12 && $selectCutoff == 2){
	$year = date('Y') - 1;
	$array_fields 	= 	array('*');
	$table 	   		= 	'tbl_payroll_info a';
	$joins 	   		=	'INNER JOIN tbl_payroll_info_data b 
							ON b.fkid_payroll_info = a.id';
	// $sql_where 		= 	'WHERE a.description ='.$salaryType.'
	// 						AND a.cut_off ='.$selectCutoff.'';
	$sql_where 		= 	'WHERE a.description ='.$salaryType.'
						AND a.cut_off ='.$selectCutoff.'
						AND MONTH(a.date_cut_off)= '.$selectMonth.'
						AND YEAR(a.date_cut_off)='.$year.'
						';
						// AND YEAR(a.date_cut_off)= 2024
						// added 7-8-2024  Darren
	$sql_order 		= 	'';
	$sql_limit 		= 	'';
	$resultOfPayrollInfoData 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$resultPayrollInfoDataArray 		= array();
	while($row = mysqli_fetch_array($resultOfPayrollInfoData)){
		$resultPayrollInfoDataArray['id'][]					= $row['id'];
		$resultPayrollInfoDataArray['employee_no'][]			= $row['employee_no'];
		$resultPayrollInfoDataArray['sss_loan'][]			= $row['sss_loan'];
		$resultPayrollInfoDataArray['sss_cal_loan'][]			= $row['sss_cal_loan'];
	}
}else{
	$array_fields 	= 	array('*');
	$table 	   		= 	'tbl_payroll_info a';
	$joins 	   		=	'INNER JOIN tbl_payroll_info_data b 
							ON b.fkid_payroll_info = a.id';
	// $sql_where 		= 	'WHERE a.description ='.$salaryType.'
	// 						AND a.cut_off ='.$selectCutoff.'';
	$sql_where 		= 	'WHERE a.description ='.$salaryType.'
						AND a.cut_off ='.$selectCutoff.'
						AND MONTH(a.date_cut_off)= '.$selectMonth.'
						AND YEAR(a.date_cut_off)='.date('Y').'
						';
						// AND YEAR(a.date_cut_off)= 2024
						// added 7-8-2024  Darren
	$sql_order 		= 	'';
	$sql_limit 		= 	'';
	$resultOfPayrollInfoData 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$resultPayrollInfoDataArray 		= array();
	while($row = mysqli_fetch_array($resultOfPayrollInfoData)){
		$resultPayrollInfoDataArray['id'][]					= $row['id'];
		$resultPayrollInfoDataArray['employee_no'][]			= $row['employee_no'];
		$resultPayrollInfoDataArray['sss_loan'][]			= $row['sss_loan'];
		$resultPayrollInfoDataArray['sss_cal_loan'][]			= $row['sss_cal_loan'];
	}
}



/**
 * Condonation
 * By Darren Super bobo kaba paulo
 */
$array_fields 	= 	array('*');
$table 	   		= 	'tbl_sss_condonation';
$joins 	   		=	'';
$sql_where 		= '
					WHERE logdel = 0
				';
$sql_order 		= '';
$sql_limit 		= '';
$resultOfEOMBySalaryType 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$rainRainGoAwaySiPauloAySuperGay 		= array();
while($row = mysqli_fetch_array($resultOfEOMBySalaryType)){
	$rainRainGoAwaySiPauloAySuperGay['id'][]            = $row['id'];
	$rainRainGoAwaySiPauloAySuperGay['emp_num'][]       = $row['emp_num'];
	$rainRainGoAwaySiPauloAySuperGay['sss_no'][]        = $row['sss_no'];
	$rainRainGoAwaySiPauloAySuperGay['charge_amount'][] = $row['charge_amount'];
}
// echo json_encode($rainRainGoAwaySiPauloAySuperGay);
// exit();


$hrisArray = array();
$arrayAllEmployeesPayrollInfoData = array();
$eatingSugarNoPapaSiPauloTarantado = array(); // Darren super balentong
for ($i=0; $i < count($resultEOMArray['id_number']); $i++) { 
	for ($j=0; $j < count($resultHRISArray['pkid']); $j++) { 
		if($resultEOMArray['id_number'][$i] == $resultHRISArray['EmpNo'][$j]){
			$temporaryArray = array(
				'EmpNo' => $resultHRISArray['EmpNo'][$j],
				'LastName' => $resultHRISArray['LastName'][$j],
				'FirstName' => $resultHRISArray['FirstName'][$j],
				'MiddleName' => $resultHRISArray['MiddleName'][$j],
				'DateHired' => $resultHRISArray['DateHired'][$j],
				'SSN' => $resultHRISArray['SSN'][$j],
			);
			array_push($hrisArray, $temporaryArray);
		}
	}

	for ($k=0; $k < count($resultPayrollInfoDataArray['id']); $k++) { 
		if($resultEOMArray['id_number'][$i] == $resultPayrollInfoDataArray['employee_no'][$k]){
			$temporaryArray = array(
				'id_number' => $resultEOMArray['id_number'][$i],
				'employee_no' => $resultPayrollInfoDataArray['employee_no'][$k],
				'sss_loan' => $resultPayrollInfoDataArray['sss_loan'][$k],
				'sss_cal_loan' => $resultPayrollInfoDataArray['sss_cal_loan'][$k],
			);
			array_push($arrayAllEmployeesPayrollInfoData, $temporaryArray);
		}
	}

	for ($l=0; $l < count($rainRainGoAwaySiPauloAySuperGay['id']); $l++) { 
		if($resultEOMArray['id_number'][$i] == $rainRainGoAwaySiPauloAySuperGay['emp_num'][$l]){
			$temporaryArray = array(
				'id_number' => $resultEOMArray['id_number'][$i],
				'sss_no' => $rainRainGoAwaySiPauloAySuperGay['sss_no'][$l],
				'charge_amount' => $rainRainGoAwaySiPauloAySuperGay['charge_amount'][$l],
			);
			array_push($eatingSugarNoPapaSiPauloTarantado, $temporaryArray);
		}
		
	}
}

// echo json_encode($eatingSugarNoPapaSiPauloTarantado);
// exit();

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
$excel->place_value('I6','Condonation','string');
$excel->place_value('J6','Total','string');
// $excel->objPHPExcel->getColumnDimension('A')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('B')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('C')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('D')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('E')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('F')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('G')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('H')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('I')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('J')->setAutoSize(true);
$arrayStyleCellA6 = array(
	'size'   		=> '16',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->set_borders('A6:J6',1,1,1,1,'thick');
$excel->setFormat('A6:J6',$arrayStyleCellA6);

$rowCounter = 7;
$rowStart = 7;
// echo json_encode($arrayAllEmployeesPayrollInfoData);
// exit();

$salaryLoan = 0;
$calamityLoan = 0;
$totalCondonation = 0;
$totalLoan = 0;
for ($i=0; $i < count($hrisArray); $i++) {
	$totalSSSAndCalamityWithCondonation = 0;
	for($j = 0; $j < count($arrayAllEmployeesPayrollInfoData); $j++){
		
		if($arrayAllEmployeesPayrollInfoData[$j]['employee_no'] == $hrisArray[$i]['EmpNo']){
			// $excel->place_value('K'.$rowCounter,$arrayAllEmployeesPayrollInfoData[$j]['employee_no'],'string');
			// $excel->place_value('L'.$rowCounter,$hrisArray[$i]['EmpNo'],'string');

			$excel->place_value('A'.$rowCounter,$hrisArray[$i]['EmpNo'],'string');
			$excel->place_value('B'.$rowCounter,$hrisArray[$i]['LastName'],'string');
			$excel->place_value('C'.$rowCounter,$hrisArray[$i]['FirstName'],'string');
			$excel->place_value('D'.$rowCounter,$hrisArray[$i]['MiddleName'],'string');
			$excel->place_value('E'.$rowCounter,$hrisArray[$i]['DateHired'],'string');
			$excel->place_value('F'.$rowCounter,$hrisArray[$i]['SSN'],'string');
			
			$excel->place_value('G'.$rowCounter,$arrayAllEmployeesPayrollInfoData[$j]['sss_loan'],'number');
			$excel->place_value('H'.$rowCounter,$arrayAllEmployeesPayrollInfoData[$j]['sss_cal_loan'],'number');
	
			$totalSSSAndCalamityWithCondonation += (double)$arrayAllEmployeesPayrollInfoData[$j]['sss_loan'] + (double)$arrayAllEmployeesPayrollInfoData[$j]['sss_cal_loan'];
			
			$arrayStyleStartFromCellA6 = array(
				'name'   		=> 'Arial',
				'size'   		=> '12',
				'horizontal'	=> 'left',
			);
			$excel->setFormat('A'.$rowStart.':E'.$rowCounter,$arrayStyleStartFromCellA6);
			// $excel->set_borders('A'.$rowStart.':I'.$rowCounter,1,1,1,1);
			$salaryLoan += $arrayAllEmployeesPayrollInfoData[$j]['sss_loan'];
			$calamityLoan += $arrayAllEmployeesPayrollInfoData[$j]['sss_cal_loan'];
			
			// $rowCounter++;
		}
	}

	/**
	 * For Condonation
	 */
	for($k = 0; $k < count($eatingSugarNoPapaSiPauloTarantado); $k++){
		if($eatingSugarNoPapaSiPauloTarantado[$k]['id_number'] == $hrisArray[$i]['EmpNo']){
			$excel->place_value('I'.$rowCounter,$eatingSugarNoPapaSiPauloTarantado[$k]['charge_amount'],'number');
			$totalSSSAndCalamityWithCondonation += $eatingSugarNoPapaSiPauloTarantado[$k]['charge_amount'];
			$totalCondonation += $eatingSugarNoPapaSiPauloTarantado[$k]['charge_amount'];
		}
	}
	$excel->place_value('J'.$rowCounter,$totalSSSAndCalamityWithCondonation,'number_2_decimal');
	$totalLoan += $totalSSSAndCalamityWithCondonation;
	$rowCounter++;
}
$excel->place_value('G'.$rowCounter,$salaryLoan,'number');
$excel->place_value('H'.$rowCounter,$calamityLoan,'number');
$excel->place_value('I'.$rowCounter,$totalCondonation,'number');
$excel->place_value('J'.$rowCounter,$totalLoan,'number');

/* set file name */
$filename = "SSS Loan";
/* output excel - filename, excel version (2003,2007) */
$excel->output($filename,'2007');
?>