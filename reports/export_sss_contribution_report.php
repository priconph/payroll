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

/**
 * Get All Division/Department/Section
 */
$array_fields 	= 	array('*');
$table 	   		= 	'tbl_Section a';
$joins 	   		=	'
					INNER JOIN tbl_Department b 
						ON b.pkid = a.fkDepartment 
					INNER JOIN tbl_Division c 
						ON c.pkid = b.fkDivision 
					';
$sql_where 		= '
					WHERE a.isActive = 1 
					AND b.isActive = 1 
					AND c.logdel = 0 
				';
$sql_order 		= 'ORDER BY b.Department ASC, c.Division ASC';
$sql_limit 		= '';
$resultOfAllProductLine 		= HRIS::getInstance()->select_all_division($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$returnOfAllProductLine 		= array();
while($row = mysqli_fetch_array($resultOfAllProductLine)){
	$temporaryArray = array(
		'Department'	=> $row['Department'],
		'Division'		=> $row['Division'],
		'Section'		=> $row['Section'],
	);
	array_push($returnOfAllProductLine, $temporaryArray);
}
// echo json_encode($returnOfAllProductLine);
// exit();

/**
 * Get data in tbl_eom
 */
$salaryType = $_GET['salaryType'];
$select_month = $_GET['month'];

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
$returnOfEOMBySalaryType 		= array();
while($row = mysqli_fetch_array($resultOfEOMBySalaryType)){
	$temporaryArray = array(
		'id_number'			=> $row['id_number'],
		'emp_code'		=> $row['emp_code'],
	);
	array_push($returnOfEOMBySalaryType, $temporaryArray);
}
// echo json_encode($returnOfEOMBySalaryType);
// exit();

/**
 * Get HRIS data
 */
$array_fields 	= 	array('employeeInfo.EmpNo','section.Section','department.Department','division.Division');
$table 	   		= 	'tbl_EmployeeInfo employeeInfo';
$joins 	   		=	'
					INNER JOIN tbl_Section section 
						ON section.pkid = employeeInfo.fkSection 
					INNER JOIN tbl_Department department 
						ON department.pkid = section.fkDepartment 
					INNER JOIN tbl_Division division 
						ON division.pkid = department.fkDivision 
					';
$sql_where 		= '
					WHERE (employeeInfo.EmpStatus = 1 OR employeeInfo.EmpStatus = 2)
					AND section.isActive = 1 
					AND department.isActive = 1 
					AND division.logdel = 0 
				';

				// WHERE NOT employeeInfo.EmpStatus = 2
$sql_order 		= 'ORDER BY department.Department ASC, division.Division ASC';
$sql_limit 		= '';
$resultHRISActiveEmployees 		= HRIS::getInstance()->select_all_division($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$returnHRISActiveEmployees 		= array();
while($row = mysqli_fetch_array($resultHRISActiveEmployees)){
	$temporaryArray = array(
		'EmpNo'			=> $row['EmpNo'],
		'Section'		=> $row['Section'],
		'Department'	=> $row['Department'],
		'Division'		=> $row['Division'],
	);
	array_push($returnHRISActiveEmployees, $temporaryArray);
}
// echo json_encode($returnHRISActiveEmployees);
// exit();

/**
 * Get data in tbl_sss
 */
if($select_month == 12 ){
	$year = date('Y') - 1;
	$array_fields 	= 	array('*');
	$table 	   		= 	'tbl_payroll_info_data a';
	// $joins 	   		=	'';
	$joins              = 'INNER JOIN tbl_payroll_info b
						ON b.id = a.fkid_payroll_info
						';
	// $sql_where 		= 	'';
	// $sql_where          = 'WHERE a.fkid_payroll_info = b.id
	// 						AND b.description ='.$salaryType.' 
	// 						AND MONTH(b.date_cut_off)= '.$select_month
	// 						; commented 07-05-2024 - darren

	// 07-05-2024 - darren
	$sql_where 			= 'WHERE a.fkid_payroll_info = b.id
							AND b.description ='.$salaryType.'
							AND MONTH(b.date_cut_off)='.$select_month.'
							AND YEAR(b.date_cut_off)='.$year.'
							';
							// AND YEAR(b.date_cut_off)= 2024
							// added 7-5-2024  Darren

	$sql_order 		= 	'';
	$sql_limit 		= 	'';
	$resultOfPayrollInfoSSSPremium 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$returnOfPayrollInfoSSSPremium 		= array();
	while($row = mysqli_fetch_array($resultOfPayrollInfoSSSPremium)){
		$temporaryArray = array(
			'employee_no'		=> $row['employee_no'],
			'sss_premium'		=> $row['sss_premium'],
		);
		array_push($returnOfPayrollInfoSSSPremium, $temporaryArray);
	}
}else{
	$array_fields 	= 	array('*');
	$table 	   		= 	'tbl_payroll_info_data a';
	// $joins 	   		=	'';
	$joins              = 'INNER JOIN tbl_payroll_info b
						ON b.id = a.fkid_payroll_info
						';
	// $sql_where 		= 	'';
	// $sql_where          = 'WHERE a.fkid_payroll_info = b.id
	// 						AND b.description ='.$salaryType.' 
	// 						AND MONTH(b.date_cut_off)= '.$select_month
	// 						; commented 07-05-2024 - darren

	// 07-05-2024 - darren
	$sql_where 			= 'WHERE a.fkid_payroll_info = b.id
							AND b.description ='.$salaryType.'
							AND MONTH(b.date_cut_off)='.$select_month.'
							AND YEAR(b.date_cut_off)='.date('Y').'
							';
							// AND YEAR(b.date_cut_off)= 2024
							// added 7-5-2024  Darren

	$sql_order 		= 	'';
	$sql_limit 		= 	'';
	$resultOfPayrollInfoSSSPremium 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$returnOfPayrollInfoSSSPremium 		= array();
	while($row = mysqli_fetch_array($resultOfPayrollInfoSSSPremium)){
		$temporaryArray = array(
			'employee_no'		=> $row['employee_no'],
			'sss_premium'		=> $row['sss_premium'],
		);
		array_push($returnOfPayrollInfoSSSPremium, $temporaryArray);
	}
}

// echo json_encode($returnOfPayrollInfoSSSPremium);
// exit();

/**
 * Get data in tbl_sss
 */
$array_fields 	= 	array('*');
$table 	   		= 	'tbl_sss';
$joins 	   		=	'';
$sql_where 		= '';
$sql_order 		= '';
$sql_limit 		= '';
$resultOfSSS 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$returnOfSSS 		= array();
while($row = mysqli_fetch_array($resultOfSSS)){
	$temporaryArray = array(
		'eeshare'		=> $row['eeshare'],
		'ershare'		=> $row['ershare'],
		'eccshare'		=> $row['eccshare'],
	);
	array_push($returnOfSSS, $temporaryArray);
}
// echo json_encode($returnOfSSS);
// exit();

$arrayEmployeeWithMatchedEmpNo = array();
$arrayComputed = array(
	'Section'		=> array('Name'=>'','Total'=>0),
	'Department'	=> array('Name'=>'','Total'=>0),
	'Division'		=> 0,
);
for ($i=0; $i < count($returnOfEOMBySalaryType); $i++) { 
	for ($j=0; $j < count($returnHRISActiveEmployees); $j++) { 
		// check id_number(column) in tbl_eom(table) if match to EmpNo(column) in tbl_EmployeeInfo(table)
		if($returnOfEOMBySalaryType[$i]['id_number'] == $returnHRISActiveEmployees[$j]['EmpNo']){
			for ($k=0; $k < count($returnOfPayrollInfoSSSPremium); $k++) { 
				// check id_number(column) in tbl_eom(table) if match to employee_no(column) in tbl_payroll_info_data(table)
				if($returnOfEOMBySalaryType[$i]['id_number'] == $returnOfPayrollInfoSSSPremium[$k]['employee_no']){
					for ($l=0; $l < count($returnOfSSS); $l++) { 
						// check sss_premium(column) in tbl_payroll_info_data(table) if match to eeshare(column) in tbl_sss(table)
						if($returnOfPayrollInfoSSSPremium[$k]['sss_premium'] == $returnOfSSS[$l]['eeshare']){
							$temporaryArray = array(
								'EmpNo' => $returnHRISActiveEmployees[$j]['EmpNo'],
								'Section' => $returnHRISActiveEmployees[$j]['Section'],
								'Department' => $returnHRISActiveEmployees[$j]['Department'],
								'Division' => $returnHRISActiveEmployees[$j]['Division'],
								'eeshare' => $returnOfSSS[$l]['eeshare'],
								'ershare' => $returnOfSSS[$l]['ershare'],
								'eccshare' => $returnOfSSS[$l]['eccshare'],
							);
							array_push($arrayEmployeeWithMatchedEmpNo, $temporaryArray);
						}
					}
				}
			}
		}
	}
}
// echo json_encode($arrayEmployeeWithMatchedEmpNo);
// exit();	

/**
 * Overall Computation for Excel
 */
$arrayComputedDataByProductline = array();
for ($i=0; $i < count($returnOfAllProductLine); $i++) {
	$arrayTemporaryComputedData = array(
		'Department_Name'				=> '',
		'Department_Employee_Share'		=> 0,
		'Department_Employer_Share'		=> 0,
		'Department_ECC'				=> 0,
		
		'Section_Name'				=> '',
		'Section_Employee_Share'	=> 0,
		'Section_Employer_Share'	=> 0,
		'Section_ECC'				=> 0,
		
		'Division_Name'				=> '',
		'Division_Employee_Share'	=> 0,
		'Division_Employer_Share'	=> 0,
		'Division_ECC'				=> 0,
	);
	for ($j=0; $j < count($arrayEmployeeWithMatchedEmpNo); $j++) {
		// echo $returnOfAllProductLine[$i]['Section'] . "<br>";
		// echo $arrayEmployeeWithMatchedEmpNo[$j]['Section'] . "<br>";
		// echo "<br>";
		// debug_backtrace();
		if($returnOfAllProductLine[$i]['Section'] == $arrayEmployeeWithMatchedEmpNo[$j]['Section']
			&& $returnOfAllProductLine[$i]['Division'] == $arrayEmployeeWithMatchedEmpNo[$j]['Division']
			&& $returnOfAllProductLine[$i]['Department'] == $arrayEmployeeWithMatchedEmpNo[$j]['Department']
		){
			
			if($returnOfAllProductLine[$i]['Division'] == $arrayEmployeeWithMatchedEmpNo[$j]['Division']){
				$arrayTemporaryComputedData['Division_Name']				= $returnOfAllProductLine[$i]['Division'];
				$arrayTemporaryComputedData['Division_Employee_Share'] 	+= $arrayEmployeeWithMatchedEmpNo[$j]['eeshare'];
				$arrayTemporaryComputedData['Division_Employer_Share'] 	+= $arrayEmployeeWithMatchedEmpNo[$j]['ershare'];
				$arrayTemporaryComputedData['Division_ECC'] 				+= $arrayEmployeeWithMatchedEmpNo[$j]['eccshare'];
	
				if($returnOfAllProductLine[$i]['Department'] == $arrayEmployeeWithMatchedEmpNo[$j]['Department']){
					$arrayTemporaryComputedData['Department_Name']				= $returnOfAllProductLine[$i]['Department'];
					$arrayTemporaryComputedData['Department_Employee_Share'] 	+= $arrayEmployeeWithMatchedEmpNo[$j]['eeshare'];
					$arrayTemporaryComputedData['Department_Employer_Share'] 	+= $arrayEmployeeWithMatchedEmpNo[$j]['ershare'];
					$arrayTemporaryComputedData['Department_ECC'] 				+= $arrayEmployeeWithMatchedEmpNo[$j]['eccshare'];
				}
				if($arrayEmployeeWithMatchedEmpNo[$j]['Section'] != ''){
					if($returnOfAllProductLine[$i]['Section'] == $arrayEmployeeWithMatchedEmpNo[$j]['Section']){
						$arrayTemporaryComputedData['Section_Name']				= $returnOfAllProductLine[$i]['Section'];
						$arrayTemporaryComputedData['Section_Employee_Share'] 	+= $arrayEmployeeWithMatchedEmpNo[$j]['eeshare'];
						$arrayTemporaryComputedData['Section_Employer_Share'] 	+= $arrayEmployeeWithMatchedEmpNo[$j]['ershare'];
						$arrayTemporaryComputedData['Section_ECC'] 				+= $arrayEmployeeWithMatchedEmpNo[$j]['eccshare'];
					}
				}
			}
			// array_push($arrayComputedDataByProductline, $arrayTemporaryComputedData);
		}
	}
	array_push($arrayComputedDataByProductline, $arrayTemporaryComputedData);
}
// echo json_encode($arrayComputedDataByProductline);
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
$excel->title = 'SSS Contri';
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
	'size'   		=> '12',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->setFormat('A1',$arrayStyleCellA1);


$excel->place_value('A2',' SSS Contribution Report','string');
$arrayStyleCellA2 = array(
	'name'   		=> 'Abadi MT Condensed Light',
	'size'   		=> '12',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->setFormat('A2',$arrayStyleCellA2);

$monthNum  = $select_month;
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('M'); // March


$excel->place_value('A3','JS/SS Employees ( '.$monthName.' 16 - 30, 2023 )','string');


$arrayStyleCellA3 = array(
	'name'   		=> 'Abadi MT Condensed Light',
	'size'   		=> '12',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->setFormat('A3',$arrayStyleCellA3);

$monthNow = date("F-Y");
$excel->place_value('A4','As of '.$monthNow,'string');
$arrayStyleCellA4 = array(
	'name'   		=> 'Abadi MT Condensed Light',
	'size'   		=> '12',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->setFormat('A4',$arrayStyleCellA4);

// $excel->place_value('A6','Department/Section/Division','string');
$excel->place_value('A6','Section','string');
$excel->place_value('B6','Employee Share','string');
$excel->place_value('C6','Employer Share','string');
$excel->place_value('D6','ECC','string');
$excel->place_value('E6','Total','string');
$excel->objPHPExcel->getColumnDimension('A')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('B')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('C')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('D')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('E')->setAutoSize(true);
$arrayStyleCellA6 = array(
	'size'   		=> '16',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->set_borders('A6:E6',1,1,1,1,'thick');
$excel->setFormat('A6:E6',$arrayStyleCellA6);

// echo json_encode($arrayComputedDataByProductline);
// exit();
$rowCounter = 7;
$rowStart = 7;
for ($i=0; $i < count($arrayComputedDataByProductline); $i++) {
	$divisionName 				= $arrayComputedDataByProductline[$i]['Division_Name'];
	$departmentName 			= $arrayComputedDataByProductline[$i]['Department_Name'];
	$sectionName 				= $arrayComputedDataByProductline[$i]['Section_Name'];
	$sectionEmployeeShare 		= $arrayComputedDataByProductline[$i]['Section_Employee_Share'];
	$sectionEmployerShare 		= $arrayComputedDataByProductline[$i]['Section_Employer_Share'];
	$sectionECC 				= $arrayComputedDataByProductline[$i]['Section_ECC'];
	$sectionTotal 				= $sectionEmployeeShare + $sectionEmployerShare + $sectionECC;
	if($sectionName != ''){
		if($departmentName == '' || $departmentName == '-'){
			$sectionName = $divisionName . ' - ' .$arrayComputedDataByProductline[$i]['Section_Name'];
		}else{
		}
		$sectionName = $divisionName . ' - ' . $arrayComputedDataByProductline[$i]['Department_Name'] . ' - ' .$arrayComputedDataByProductline[$i]['Section_Name'];
		$excel->place_value('A'.$rowCounter,$sectionName,'string');
		$excel->place_value('B'.$rowCounter,$sectionEmployeeShare,'number_2_decimal');
		$excel->place_value('C'.$rowCounter,$sectionEmployerShare,'number_2_decimal');
		$excel->place_value('D'.$rowCounter,$sectionECC,'number_2_decimal');
		$excel->place_value('E'.$rowCounter,$sectionTotal,'number_2_decimal');
	}else{
		continue;
	}
	$rowCounter++;
	
	// if($arrayComputedDataByProductline[$i]['Section_Name'] != ""){
	// 	$sectionEmployeeShare 	= $arrayComputedDataByProductline[$i]['Section_Employee_Share'];
	// 	$sectionEmployerShare 	= $arrayComputedDataByProductline[$i]['Section_Employer_Share'];
	// 	$sectionECC 			= $arrayComputedDataByProductline[$i]['Section_ECC'];
	// 	$sectionTotal 			= $sectionEmployeeShare + $sectionEmployerShare + $sectionECC;
	
	// 	$concatenatedDivisionSection = $arrayComputedDataByProductline[$i]['Section_Name'];
	// 	if($arrayComputedDataByProductline[$i]['Division_Name'] != ""){
	// 		$concatenatedDivisionSection = $arrayComputedDataByProductline[$i]['Division_Name'] . ' - '. $arrayComputedDataByProductline[$i]['Section_Name'];
	// 	}
	// 	if($arrayComputedDataByProductline[$i]['Division_Name'] != "" && $arrayComputedDataByProductline[$i]['Department_Name'] != ""){
	// 		$concatenatedDivisionSection = $arrayComputedDataByProductline[$i]['Division_Name'] . ' - '. $arrayComputedDataByProductline[$i]['Division_Name'] . ' - '. $arrayComputedDataByProductline[$i]['Section_Name'];
	// 	}
	// 	$excel->place_value('A'.$rowCounter,$concatenatedDivisionSection,'string');
	// 	$excel->place_value('B'.$rowCounter,$sectionEmployeeShare,'string');
	// 	$excel->place_value('C'.$rowCounter,$sectionEmployerShare,'string');
	// 	$excel->place_value('D'.$rowCounter,$sectionECC,'string');
	// 	$excel->place_value('E'.$rowCounter,$sectionTotal,'string');
	// }
}

/* set file name */
$filename = "SSS Contribution Report";
/* output excel - filename, excel version (2003,2007) */
$excel->output($filename,'2007');
?>