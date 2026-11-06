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
// echo json_encode($salaryType);
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
					WHERE NOT employeeInfo.EmpStatus = 2
					AND section.isActive = 1 
					AND department.isActive = 1 
					AND division.logdel = 0 
				';
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

$PhilHealthContributionCutOffType = $_GET['PhilHealthContributionCutOffType'];
$selectMonth    = $_GET['selectMonth'];

if($PhilHealthContributionCutOffType == 2 && $selectMonth == 12){
	$year = date('Y') - 1;
	$array_fields 	= 	array('*');
	$table 	   		= 	'tbl_payroll_info_data a';
	$joins 	   		=	'INNER JOIN tbl_payroll_info b
						ON b.id = a.fkid_payroll_info
						';
	$sql_where 		= 	'WHERE a.fkid_payroll_info = b.id
							AND b.cut_off = '.$PhilHealthContributionCutOffType.'
							AND MONTH(b.date_cut_off)='.$selectMonth.'
							AND YEAR(b.date_cut_off)='.$year.' 
							';
							// AND YEAR(b.date_cut_off)= 2024
							// added 7-5-2024  Darren

	$sql_order 		= 	'';
	$sql_limit 		= 	'';
	$resultOfPayrollInfoPHPremium 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$returnOfPayrollInfoPHPremium 		= array();
	while($row = mysqli_fetch_array($resultOfPayrollInfoPHPremium)){
		$temporaryArray = array(
			'employee_no'		=> $row['employee_no'],
			'ph_premium'		=> $row['ph_premium'],
			'regular_pay'       => $row['regular_pay'],
			'date_start'       => $row['date_start'],
			'date_end'       => $row['date_end'],

		);
		array_push($returnOfPayrollInfoPHPremium, $temporaryArray);
	}
}else{
	$array_fields 	= 	array('*');
	$table 	   		= 	'tbl_payroll_info_data a';
	$joins 	   		=	'INNER JOIN tbl_payroll_info b
						ON b.id = a.fkid_payroll_info
						';
	$sql_where 		= 	'WHERE a.fkid_payroll_info = b.id
							AND b.cut_off = '.$PhilHealthContributionCutOffType.'
							AND MONTH(b.date_cut_off)='.$selectMonth.'
							AND YEAR(b.date_cut_off)='.date('Y').' 
							';
							// AND YEAR(b.date_cut_off)= 2024
							// added 7-5-2024  Darren

	$sql_order 		= 	'';
	$sql_limit 		= 	'';
	$resultOfPayrollInfoPHPremium 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$returnOfPayrollInfoPHPremium 		= array();
	while($row = mysqli_fetch_array($resultOfPayrollInfoPHPremium)){
		$temporaryArray = array(
			'employee_no'		=> $row['employee_no'],
			'ph_premium'		=> $row['ph_premium'],
			'regular_pay'       => $row['regular_pay'],
			'date_start'       => $row['date_start'],
			'date_end'       => $row['date_end'],

		);
		array_push($returnOfPayrollInfoPHPremium, $temporaryArray);
	}
}


// echo json_encode($returnOfPayrollInfoPHPremium);
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
			for ($k=0; $k < count($returnOfPayrollInfoPHPremium); $k++) { 
				// check id_number(column) in tbl_eom(table) if match to employee_no(column) in tbl_payroll_info_data(table)
				if($returnOfEOMBySalaryType[$i]['id_number'] == $returnOfPayrollInfoPHPremium[$k]['employee_no']){
					
                    $temporaryArray = array(
                        'EmpNo' => $returnHRISActiveEmployees[$j]['EmpNo'],
                        'Section' => $returnHRISActiveEmployees[$j]['Section'],
                        'Department' => $returnHRISActiveEmployees[$j]['Department'],
                        'Division' => $returnHRISActiveEmployees[$j]['Division'],
                        'regular_pay' => $returnOfPayrollInfoPHPremium[$k]['regular_pay'],
                    );
                    array_push($arrayEmployeeWithMatchedEmpNo, $temporaryArray);
				}
			}
		}
	}
}

// echo json_encode($arrayEmployeeWithMatchedEmpNo);
// exit();

$arrayComputedDataByProductline = array();
for ($i=0; $i < count($returnOfAllProductLine); $i++) {
	$arrayTemporaryComputedData = array(
		'Department_Name'				=> '',
		'Section_Name'				=> '',
		'Division_Name'				=> '',
        // 'Regular_pay'               => '',
        // 'Division_Share'            => '',

	);
	for ($j=0; $j < count($arrayEmployeeWithMatchedEmpNo); $j++) {
		if($arrayEmployeeWithMatchedEmpNo[$j]['Section'] != ''){
			if($returnOfAllProductLine[$i]['Division'] == $arrayEmployeeWithMatchedEmpNo[$j]['Division']
            &&  $returnOfAllProductLine[$i]['Department'] == $arrayEmployeeWithMatchedEmpNo[$j]['Department'] 
            && $returnOfAllProductLine[$i]['Section'] == $arrayEmployeeWithMatchedEmpNo[$j]['Section']){

				$arrayTemporaryComputedData['Division_Name']				= $returnOfAllProductLine[$i]['Division'];
                $arrayTemporaryComputedData['Section_Name']				= $returnOfAllProductLine[$i]['Section'];
				$arrayTemporaryComputedData['Department_Name']				= $returnOfAllProductLine[$i]['Department'];
                $arrayTemporaryComputedData['Regular_pay']				+= $arrayEmployeeWithMatchedEmpNo[$j]['regular_pay'];

			}
		}
		else{
			$arrayTemporaryComputedData['Section_Not_Included'][]  = $arrayEmployeeWithMatchedEmpNo[$j]['Section'];
		}
		
	}
	array_push($arrayComputedDataByProductline,($arrayTemporaryComputedData));
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
$excel->title = 'Philhealth Contribution Report';
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


$excel->place_value('A2','Monthly Phil. Health Contribution Report','string');
$arrayStyleCellA2 = array(
	'name'   		=> 'Abadi MT Condensed Light',
	'size'   		=> '12',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->setFormat('A2',$arrayStyleCellA2);

$sd = date("F d", strtotime($returnOfPayrollInfoPHPremium[0]['date_start']));
$ed = date("d, Y", strtotime($returnOfPayrollInfoPHPremium[0]['date_end']));


$excel->place_value('A3',''.$st.' Employees ('.$sd.' - '.$ed.')','string');

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
$excel->place_value('A6','Division','string');
$excel->place_value('B6','Department','string');
$excel->place_value('C6','Section','string');
$excel->place_value('D6','Employee Share','string');
$excel->place_value('E6','Employer Share','string');
$excel->place_value('F6','Total','string');
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
$excel->set_borders('A6:F6',1,1,1,1,'thick');
$excel->setFormat('A6:F6',$arrayStyleCellA6);

$rowCounter = 7;
$rowStart = 7;
    if($salaryType == 2 || $salaryType == 4){
        for ($i=0; $i < count($arrayComputedDataByProductline); $i++) {  
            if($arrayComputedDataByProductline[$i]['Section_Name'] != ""){
                $sectionEmployeeShare 	= doubleval((($arrayComputedDataByProductline[$i]['Regular_pay'] * 2) * 0.05) / 2);
                $sectionEmployerShare 	= doubleval((($arrayComputedDataByProductline[$i]['Regular_pay'] * 2) * 0.05) / 2);
                $sectionTotal 			= $sectionEmployeeShare + $sectionEmployerShare;
                // $divisionTotal  += $sectionTotal;
    
                $excel->place_value('A'.$rowCounter,$arrayComputedDataByProductline[$i]['Division_Name'],'string');
                $excel->place_value('B'.$rowCounter,$arrayComputedDataByProductline[$i]['Department_Name'],'string');
                $excel->place_value('C'.$rowCounter,$arrayComputedDataByProductline[$i]['Section_Name'],'string');
                $excel->objPHPExcel->setCellValue('D'.$rowCounter,$sectionEmployeeShare);
                $excel->objPHPExcel->setCellValue('E'.$rowCounter,$sectionEmployerShare);
                $excel->objPHPExcel->setCellValue('F'.$rowCounter,$sectionTotal);
                // $excel->objPHPExcel->setCellValue('G7',$divisionTotal);
                $rowCounter++;
            }
        }
    }
    else{
        for ($i=0; $i < count($arrayComputedDataByProductline); $i++) {  
            if($arrayComputedDataByProductline[$i]['Section_Name'] != ""){
                $sectionEmployerShare 	= doubleval((($arrayComputedDataByProductline[$i]['Regular_pay'] * 26) * 0.05) / 2);
                $sectionEmployeeShare 	= doubleval((($arrayComputedDataByProductline[$i]['Regular_pay'] * 26) * 0.05) / 2);
                $sectionTotal 			= $sectionEmployeeShare + $sectionEmployerShare;
    
                $excel->place_value('A'.$rowCounter,$arrayComputedDataByProductline[$i]['Division_Name'],'string');
                $excel->place_value('B'.$rowCounter,$arrayComputedDataByProductline[$i]['Department_Name'],'string');
                $excel->place_value('C'.$rowCounter,$arrayComputedDataByProductline[$i]['Section_Name'],'string');
                $excel->objPHPExcel->setCellValue('D'.$rowCounter,$sectionEmployeeShare);
                $excel->objPHPExcel->setCellValue('E'.$rowCounter,$sectionEmployerShare);
                $excel->objPHPExcel->setCellValue('F'.$rowCounter,$sectionTotal);
                $rowCounter++;
            }
        }
    }
    

    if($salaryType == 1){
        $title = 'Daily';
    }else if ($salaryType == 2){
        $title = 'Monthly';
    }else{
        $title = 'JS/SS';
    }

/* set file name */
$filename = "Monthly Philhealth Contribution Report ".$title;
/* output excel - filename, excel version (2003,2007) */
$excel->output($filename,'2007');
?>