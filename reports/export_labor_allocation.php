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

$selectMonth 	= $_GET['LaborAllocationSelectMonth'];
$selectSalaryType 	= $_GET['LaborAllocsalaryType'];
$selectCutoff   = $_GET['LaborAllocSelectCutoff'];
// echo json_encode($selectMonth).'<br>';
// echo json_encode($selectSalaryType).'<br>';
// echo json_encode($selectCutoff).'<br>';
// exit();

/**
 * Query
 */
$array_fields 	= 	array('*');
$table 	   		= 	'tbl_Section a';
$joins 	   		=	'
					INNER JOIN tbl_Department b 
						ON b.pkid = a.fkDepartment 
					INNER JOIN tbl_Division c 
						ON c.pkid = b.fkDivision 
					';
$sql_where 		= 	'
						WHERE a.isActive = 1 
						AND NOT a.Section = "BOD"
						AND NOT b.Department = "Board of Directors"
						AND b.isActive = 1 
						AND c.logdel = 0 
					';
$sql_order 		= 	'ORDER BY b.Department ASC, c.Division ASC, a.Section ASC';
$sql_limit 		= 	'';
$result 		= 	HRIS::getInstance()->select_all_division($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$productLine 	= 	array();
while($row = mysqli_fetch_array($result)){
	$productLineArray = array(
		'pkid'			=> $row['pkid'], //division pkid
		'Department'	=> $row['Department'],
		'Division'		=> $row['Division'],
		'Section'		=> $row['Section']
	);
	array_push($productLine, $productLineArray);
}
// echo json_encode($productLine);
// exit();

$array_fields 	= 	array('*');
$table 	   		= 	'tbl_EmployeeInfo a';
$joins 	   		=	'INNER JOIN tbl_Department b
						ON b.pkid = a.fkDepartment
					INNER JOIN tbl_Division c
						ON c.pkid = a.fkDivision
					INNER JOIN tbl_Section d
						ON d.pkid = a.fkSection
					';
// $sql_where 		= 	'WHERE NOT a.EmpStatus = 2
$sql_where 		= 	'WHERE a.SalaryType = '.$selectSalaryType.'
						AND b.isActive = 1
						AND c.logdel = 0
						AND d.isActive = 1
					';
$sql_order 		= 	'ORDER BY b.Department ASC, c.Division, d.Section';
$sql_limit 		= 	'';
$resultEmployeeInfo 		= HRIS::getInstance()->select_all_active_employee_test($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$returnEmployeeInfo 		= array();
while($row = mysqli_fetch_array($resultEmployeeInfo)){
	$EmployeeInfoArray = array(
		'EmpNo'			=> $row['EmpNo'],
		'FirstName'		=> $row['FirstName'],
		'LastName'		=> $row['LastName'],
		'Department'	=> $row['Department'],
		'Division'		=> $row['Division'],
		'Section'		=> $row['Section'],
	);
	array_push($returnEmployeeInfo, $EmployeeInfoArray);
}

// echo json_encode($returnEmployeeInfo);
// exit();

// CHAN - JAN-06-2026
$yearToday = date('Y');
if ($selectMonth == '12' && $selectCutoff == '2') {
    $year = $yearToday - 1;
}else{
	$year = $yearToday;
}

$array_fields 	= 	array('*');
$table 	   		= 	'tbl_payroll_info a';
$joins 	   		=	'INNER JOIN tbl_payroll_info_data b 
						ON b.fkid_payroll_info = a.id
					INNER JOIN tbl_working_days';
					
$sql_where 		= 	'WHERE a.description ='.$selectSalaryType.'
						AND a.cut_off ='.$selectCutoff.'	
						AND MONTH(a.date_cut_off)='.$selectMonth.'
						AND YEAR(a.date_cut_off)='.$year.'
						GROUP BY b.employee_no
						';
$sql_order 		= 	'';
$sql_limit 		= 	'';
$payrollInfoData 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$payrollInfoDataArray 		= array();
while($row = mysqli_fetch_array($payrollInfoData)){
	$tempEmployeeInfoArray = array(
		'employee_no'		=> $row['employee_no'],
		'employee_name'		=> $row['employee_name'],
		'regular_pay'		=> $row['regular_pay'],
		'salary_adj'		=> $row['salary_adj'],
		'abs_amnt'			=> $row['abs_amnt'],
		'undertime_amnt'	=> $row['undertime_amnt'],
		'ecola'				=> $row['ecola'],
		'ot1_amount'		=> $row['ot1_amount'],
		'ot2_amount'		=> $row['ot2_amount'],
		'ot2a_amount'		=> $row['ot2a_amount'],
		'ot3_amount'		=> $row['ot3_amount'],
		'ot3a_amount'		=> $row['ot3a_amount'],
		'ot4_amount'		=> $row['ot4_amount'],
		'ot4a_amount'		=> $row['ot4a_amount'],
		'ot5_amount'		=> $row['ot5_amount'],
		'ot5a_amount'		=> $row['ot5a_amount'],
		'ot6_amount'		=> $row['ot6_amount'],
		'ot6a_amount'		=> $row['ot6a_amount'],
		'nightdiff_amount'	=> $row['nightdiff_amount'],
		'sl_amount'			=> $row['sl_amount'],
		'vl_amount'			=> $row['vl_amount'],
		'bl_amount'			=> $row['bl_amount'],
		'bdl_amount'		=> $row['bdl_amount'],
		'shutdown_amount'	=> $row['shutdown_amount'],
		'allowance'			=> $row['allowance'],
		'working_days'		=> $row['working_days'],
	);
	array_push($payrollInfoDataArray, $tempEmployeeInfoArray);
	// exit();
}

// echo json_encode(count($payrollInfoDataArray));
// exit();

// for ($i=0; $i <count($payrollInfoDataArray); $i++) { 
// 	# code...
// }


$overAllProductLineArray = array();
$overAllPayrollDataInfoArray = array();
for($y=0; $y < count($productLine) ; $y++) {
	for ($x=0; $x < count($returnEmployeeInfo); $x++) {
		if($returnEmployeeInfo[$x]['Section'] == $productLine[$y]['Section'] && 
			$returnEmployeeInfo[$x]['Department'] == $productLine[$y]['Department'] && 
			$returnEmployeeInfo[$x]['Division'] == $productLine[$y]['Division']
		){
			$temporaryArray = array(
				'EmpNo' => $returnEmployeeInfo[$x]['EmpNo'],
				'Division' => $returnEmployeeInfo[$x]['Division'],
				'Department' => $returnEmployeeInfo[$x]['Department'],
				'Section' => $returnEmployeeInfo[$x]['Section'],
			);
			array_push($overAllProductLineArray, $temporaryArray);

			for ($z=0; $z < count($payrollInfoDataArray); $z++){
				if($returnEmployeeInfo[$x]['EmpNo'] == $payrollInfoDataArray[$z]['employee_no']){
					$tempoData = array(
						'employee_no' 		=> $payrollInfoDataArray[$z]['employee_no'],
						'employee_name' 	=> $payrollInfoDataArray[$z]['employee_name'],
						'regular_pay' 		=> $payrollInfoDataArray[$z]['regular_pay'],
						'salary_adj' 		=> $payrollInfoDataArray[$z]['salary_adj'],
						'abs_amnt' 			=> $payrollInfoDataArray[$z]['abs_amnt'],
						'undertime_amnt'	=> $payrollInfoDataArray[$z]['undertime_amnt'],
						'ecola'				=> $payrollInfoDataArray[$z]['ecola'],
						'ot1_amount'		=> $payrollInfoDataArray[$z]['ot1_amount'],
						'ot2_amount'		=> $payrollInfoDataArray[$z]['ot2_amount'],
						'ot2a_amount'		=> $payrollInfoDataArray[$z]['ot2a_amount'],
						'ot3_amount'		=> $payrollInfoDataArray[$z]['ot3_amount'],
						'ot3a_amount'		=> $payrollInfoDataArray[$z]['ot3a_amount'],
						'ot4_amount'		=> $payrollInfoDataArray[$z]['ot4_amount'],
						'ot4a_amount'		=> $payrollInfoDataArray[$z]['ot4a_amount'],
						'ot5_amount'		=> $payrollInfoDataArray[$z]['ot5_amount'],
						'ot5a_amount'		=> $payrollInfoDataArray[$z]['ot5a_amount'],
						'ot6_amount'		=> $payrollInfoDataArray[$z]['ot6_amount'],
						'ot6a_amount'		=> $payrollInfoDataArray[$z]['ot6a_amount'],
						'nightdiff_amount'	=> $payrollInfoDataArray[$z]['nightdiff_amount'],
						'vl_amount'			=> $payrollInfoDataArray[$z]['vl_amount'],
						'bl_amount'			=> $payrollInfoDataArray[$z]['bl_amount'],
						'sl_amount'			=> $payrollInfoDataArray[$z]['sl_amount'],
						'bdl_amount'		=> $payrollInfoDataArray[$z]['bdl_amount'],
						'shutdown_amount'	=> $payrollInfoDataArray[$z]['shutdown_amount'],
						'allowance'			=> $payrollInfoDataArray[$z]['allowance'],
						'working_days'		=> $payrollInfoDataArray[$z]['working_days'],

						'Division' 			=> $returnEmployeeInfo[$x]['Division'],
						'Department' 		=> $returnEmployeeInfo[$x]['Department'],
						'Section' 			=> $returnEmployeeInfo[$x]['Section'],
					);
					array_push($overAllPayrollDataInfoArray, $tempoData);
				}
			}
		}
		else{
			continue;
		}
	}
}

$overAllDataResult = array();
for ($i=0; $i < count($productLine); $i++) {
	$arrayTemporaryComputedData = array(
		'Department'			=> '',
		'Section'				=> '',
		'Division'				=> '',
	);
	for ($j=0; $j < count($payrollInfoDataArray); $j++){
		if($returnEmployeeInfo[$x]['EmpNo'] == $payrollInfoDataArray[$j]['employee_no']){
			$tempoData = array(
				'employee_no' 		=> $payrollInfoDataArray[$j]['employee_no'],
				'employee_name' 	=> $payrollInfoDataArray[$j]['employee_name'],
				'regular_pay' 		=> $payrollInfoDataArray[$j]['regular_pay'],
				'salary_adj' 		=> $payrollInfoDataArray[$j]['salary_adj'],
				'abs_amnt' 			=> $payrollInfoDataArray[$j]['abs_amnt'],
				'undertime_amnt'	=> $payrollInfoDataArray[$j]['undertime_amnt'],
				'ecola'				=> $payrollInfoDataArray[$j]['ecola'],
				'ot1_amount'		=> $payrollInfoDataArray[$j]['ot1_amount'],
				'ot2_amount'		=> $payrollInfoDataArray[$j]['ot2_amount'],
				'ot2a_amount'		=> $payrollInfoDataArray[$j]['ot2a_amount'],
				'ot3_amount'		=> $payrollInfoDataArray[$j]['ot3_amount'],
				'ot3a_amount'		=> $payrollInfoDataArray[$j]['ot3a_amount'],
				'ot4_amount'		=> $payrollInfoDataArray[$j]['ot4_amount'],
				'ot4a_amount'		=> $payrollInfoDataArray[$j]['ot4a_amount'],
				'ot5_amount'		=> $payrollInfoDataArray[$j]['ot5_amount'],
				'ot5a_amount'		=> $payrollInfoDataArray[$j]['ot5a_amount'],
				'ot6_amount'		=> $payrollInfoDataArray[$j]['ot6_amount'],
				'ot6a_amount'		=> $payrollInfoDataArray[$j]['ot6a_amount'],
				'nightdiff_amount'	=> $payrollInfoDataArray[$j]['nightdiff_amount'],
				'vl_amount'			=> $payrollInfoDataArray[$j]['vl_amount'],
				'bl_amount'			=> $payrollInfoDataArray[$j]['bl_amount'],
				'sl_amount'			=> $payrollInfoDataArray[$j]['sl_amount'],
				'bdl_amount'		=> $payrollInfoDataArray[$j]['bdl_amount'],
				'shutdown_amount'	=> $payrollInfoDataArray[$j]['shutdown_amount'],
				'allowance'			=> $payrollInfoDataArray[$j]['allowance'],
				'working_days'		=> $payrollInfoDataArray[$j]['working_days'],

				'Division' 			=> $returnEmployeeInfo[$x]['Division'],
				'Department' 		=> $returnEmployeeInfo[$x]['Department'],
				'Section' 			=> $returnEmployeeInfo[$x]['Section'],
			);
			array_push($overAllPayrollDataInfoArray, $tempoData);
		}
	}
		
	for ($k=0; $k < count($overAllPayrollDataInfoArray); $k++) { 
		if($productLine[$i]['Section'] == $overAllPayrollDataInfoArray[$k]['Section']
			&& $productLine[$i]['Division'] == $overAllPayrollDataInfoArray[$k]['Division']
			&& $productLine[$i]['Department'] == $overAllPayrollDataInfoArray[$k]['Department']
		){
			if($productLine[$i]['Division'] == $overAllPayrollDataInfoArray[$k]['Division']){
				$arrayTemporaryComputedData['Division']	= $productLine[$i]['Division'];

				if($productLine[$i]['Department'] == $overAllPayrollDataInfoArray[$k]['Department']){
					$arrayTemporaryComputedData['Department'] = $productLine[$i]['Department'];
				}
				if($overAllPayrollDataInfoArray[$k]['Section'] != ''){
					if($productLine[$i]['Section'] == $overAllPayrollDataInfoArray[$k]['Section']){
						$arrayTemporaryComputedData['Section'] = $productLine[$i]['Section'];
					}
				}
			}
		}
	}
	array_push($overAllDataResult,$arrayTemporaryComputedData);
}

// echo json_encode (($overAllPayrollDataInfoArray));
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
$excel->title = 'Labor Allocation';

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
$excel->set_width('A',$width_allowance+10);
$excel->set_width('B',$width_allowance+10);
$excel->set_width('C',$width_allowance+10);
$excel->set_width('D',$width_allowance+10);
$excel->set_width('E',$width_allowance+10);
$excel->set_width('F',$width_allowance+10);
$excel->set_width('G',$width_allowance+10);
$excel->set_width('H',$width_allowance+10);
$excel->set_width('I',$width_allowance+10);
$excel->set_width('J',$width_allowance+10);
$excel->set_width('K',$width_allowance+10);
$excel->set_width('L',$width_allowance+10);
$excel->set_width('M',$width_allowance+10);
$excel->set_width('N',$width_allowance+10);
$excel->set_width('O',$width_allowance+10);

/* Header Columns */
$excel->place_value('A1','','string');
$excel->place_value('B1','Department','string');
$excel->place_value('C1','Division','string');
$excel->place_value('D1','Section','string');
$excel->place_value('E1','','string');
$excel->place_value('F1','Labor','string');
$excel->place_value('G1','ECOLA','string');
$excel->place_value('H1','CTPA','string');
$excel->place_value('I1','SOCIO','string');
$excel->place_value('J1','Overtime','string');
$excel->place_value('K1','Sick','string');
$excel->place_value('L1','Vacation','string');
$excel->place_value('M1','BDL','string');
$excel->place_value('N1','Shutdown','string');
$excel->place_value('O1','Tech Allow','string');

$array_format = array(
	"name" 			=> 'Arial',
	"size" 			=> 12,
	"wordwrap"		=> false,
	"h_alignment" 	=> 'center'
);
$excel->set_format('A1:N1',$array_format);

/**
 * Font weight
 */
$styleArray = array(
	'font'  => array(
		'bold'   => true,
		'size'   => '16',
	)
);
$excel->objPHPExcel->getStyle('A1:O1')->applyFromArray($styleArray);
$excel->set_borders('A1:O1',1,1,1,1,'thin');
$rowCounter = 2;
$rowStart 	= 2;

for ($i=0; $i < count($overAllDataResult); $i++) {
	$countEmployeePerDivDeptSect = 0;
	$divisionName		= $overAllDataResult[$i]['Division'];
	$departmentName 	= $overAllDataResult[$i]['Department'];
	$sectionName 		= $overAllDataResult[$i]['Section'];
	$labor 				= 0;
	$ecola 				= 0;
	$overtime 			= 0;
	$sickLeave 			= 0;
	$vbLeave 			= 0;
	$bdLeave 			= 0;
	$shutDown 			= 0;
	$techAllowance 		= 0;
	if($sectionName != ''){
		$excel->set_borders('A'.$rowStart.':O'.$rowCounter,1,1,1,1,'thin');
		$excel->place_value('B'.$rowCounter,$departmentName,'string');
		$excel->place_value('C'.$rowCounter,$divisionName,'string');
		$excel->place_value('D'.$rowCounter,$sectionName,'string');

		for ($j=0; $j <count($overAllPayrollDataInfoArray) ; $j++) { 
			if($overAllDataResult[$i]['Section'] == $overAllPayrollDataInfoArray[$j]['Section'] 
				&& $overAllDataResult[$i]['Division'] == $overAllPayrollDataInfoArray[$j]['Division'] 
				&& $overAllDataResult[$i]['Department'] == $overAllPayrollDataInfoArray[$j]['Department']
			){
				$countEmployeePerDivDeptSect += count($j);
				if($selectSalaryType == 1){
					$computation = $overAllPayrollDataInfoArray[$j]['regular_pay'] * $overAllPayrollDataInfoArray[$j]['working_days']; //working days
					//DAILY
				}else{
					$computation = $overAllPayrollDataInfoArray[$j]['regular_pay'];
					//MONTHLY&JS/SS
				}
				// $laborTotal = $overAllPayrollDataInfoArray[$j]['regular_pay']+
				$laborTotal 	= 	$computation+
									$overAllPayrollDataInfoArray[$j]['salary_adj']-
									$overAllPayrollDataInfoArray[$j]['abs_amnt']-
									$overAllPayrollDataInfoArray[$j]['undertime_amnt'];

				$labor 			+= 	$laborTotal;

				$overTimeTotal 	=	$overAllPayrollDataInfoArray[$j]['ot1_amount']+
									$overAllPayrollDataInfoArray[$j]['ot2_amount']+
									$overAllPayrollDataInfoArray[$j]['ot2a_amount']+
									$overAllPayrollDataInfoArray[$j]['ot3_amount']+
									$overAllPayrollDataInfoArray[$j]['ot3a_amount']+
									$overAllPayrollDataInfoArray[$j]['ot4_amount']+
									$overAllPayrollDataInfoArray[$j]['ot4a_amount']+
									$overAllPayrollDataInfoArray[$j]['ot5_amount']+
									$overAllPayrollDataInfoArray[$j]['ot5a_amount']+
									$overAllPayrollDataInfoArray[$j]['ot6_amount']+
									$overAllPayrollDataInfoArray[$j]['ot6a_amount']+
									$overAllPayrollDataInfoArray[$j]['nightdiff_amount'];

				$overtime		+= 	$overTimeTotal;

				$ecola			+= 	$overAllPayrollDataInfoArray[$j]['ecola'];

				$sickLeave		+= 	$overAllPayrollDataInfoArray[$j]['sl_amount'];
				
				$vbLeaveTotal 	=	$overAllPayrollDataInfoArray[$j]['vl_amount']+
									$overAllPayrollDataInfoArray[$j]['bl_amount'];

				$vbLeave		+= 	$vbLeaveTotal;

				$bdLeave		+= 	$overAllPayrollDataInfoArray[$j]['bdl_amount'];

				$shutDown		+= 	$overAllPayrollDataInfoArray[$j]['shutdown_amount'];

				$techAllowance	+= 	$overAllPayrollDataInfoArray[$j]['allowance'];

				$excel->place_value('A'.$rowCounter,$countEmployeePerDivDeptSect,'number_0_decimal');
				$excel->place_value('F'.$rowCounter,$labor,'numberFormat');
				$excel->place_value('G'.$rowCounter,$ecola,'numberFormat');
				$excel->place_value('H'.$rowCounter,0,'numberFormat');
				$excel->place_value('I'.$rowCounter,0,'numberFormat');
				$excel->place_value('J'.$rowCounter,$overtime,'numberFormat');
				$excel->place_value('K'.$rowCounter,$sickLeave,'numberFormat');
				$excel->place_value('L'.$rowCounter,$vbLeave,'numberFormat');
				$excel->place_value('M'.$rowCounter,$bdLeave,'numberFormat');
				$excel->place_value('N'.$rowCounter,$shutDown,'numberFormat');
				$excel->place_value('O'.$rowCounter,$techAllowance,'numberFormat');

				// $excel->place_value('F62',"=SUM(F2:F60)",'numberFormat');
				// $excel->place_value('G62',"=SUM(G2:G60)",'numberFormat');
				// $excel->place_value('H62',"=SUM(H2:H60)",'numberFormat');
				// $excel->place_value('I62',"=SUM(I2:I60)",'numberFormat');
				// $excel->place_value('J62',"=SUM(J2:J60)",'numberFormat');
				// $excel->place_value('K62',"=SUM(K2:K60)",'numberFormat');
				// $excel->place_value('L62',"=SUM(L2:L60)",'numberFormat');
				// $excel->place_value('M62',"=SUM(M2:M60)",'numberFormat');
				// $excel->place_value('N62',"=SUM(N2:N60)",'numberFormat');
				// $excel->place_value('O62',"=SUM(O2:O60)",'numberFormat');

			}
		}
	}
	else{
		continue;
	}
	$rowCounter++;
}

	// $excel->objPHPExcel->getStyle('A1'.$rowStart.':N1'.$rowCounter)->applyFromArray($styleArray);
	// $excel->objPHPExcel->getStyle('A1:N1')->applyFromArray($styleArray);
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

/* set file name */
$filename = "Labor Allocation";
/* output excel - filename, excel version (2003,2007) */
$excel->output($filename,'2007');
?>
