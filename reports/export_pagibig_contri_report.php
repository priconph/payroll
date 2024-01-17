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

// echo $salaryType;
// exit;

if ($salaryType == 1){
	$st = 'Daily';
}else if ($salaryType == 2){
	$st = 'Monthly';
}else if ($salaryType == 4){
	$st = 'JS/SS';
}

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
		'id_number'		=> $row['id_number'],
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

$cutOff = $_GET['cutOff'];
$selectMonth    = $_GET['selectMonth'];
// echo "salaryType ".$salaryType ."<br>";
// echo "cutOff ".$cutOff ."<br>";
// echo "selectMonth ".$selectMonth ."<br>";

$array_fields 	= 	array('*');
$table 	   		= 	'tbl_payroll_info_data a';
$joins 	   		=	'INNER JOIN tbl_payroll_info b
					ON b.id = a.fkid_payroll_info
					';
$sql_where 		= 	"WHERE a.fkid_payroll_info = b.id AND MONTH(b.date_cut_off)='$selectMonth' 
					AND b.description= '$salaryType' AND b.cut_off= '$cutOff'";
$sql_order 		= 	'';
$sql_limit 		= 	'';
$resultPagibigLoan 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$returnPagibigData 		= array();
while($row = mysqli_fetch_array($resultPagibigLoan)){
	$temporaryArray = array(
		'employee_no'		=> $row['employee_no'],
        'pagibig'       	=> $row['pagibig'],
        'date_start'       	=> $row['date_start'],
        'date_end'       	=> $row['date_end']

	);
	array_push($returnPagibigData, $temporaryArray);
}
// echo json_encode($returnPagibigData);
// exit();
// echo $cutOff;
// exit;

$array_fields 	= 	array('*');
$table 	   		= 	'tbl_payroll_info';
$joins 	   		=	'';
$sql_where 		= 	'WHERE description= '.$salaryType.' AND cut_off= '.$cutOff.' AND MONTH(date_cut_off)= '.$selectMonth.' ';
$sql_order 		= 	'';
$sql_limit 		= 	'';
$resultOfPayrollInfoPagibigContri 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$returnOfPayrollInfoPagibigContri 		= array();
while($row = mysqli_fetch_array($resultOfPayrollInfoPagibigContri)){
	$temporaryArray = array(
		'date_start'		=> $row['date_start'],
		'date_end'			=> $row['date_end'],

	);
	array_push($returnOfPayrollInfoPagibigContri, $temporaryArray);
}
// echo json_encode($returnOfPayrollInfoPagibigContri);
// exit();


$arrayEmployeeWithMatchedEmpNo = array();
$arrayComputed = array(
	'Section'		=> array('Name'=>'','Total'=>0),
	'Department'	=> array('Name'=>'','Total'=>0),
	'Division'		=> 0,
);
// echo count($returnPagibigData);
// exit();
// for ($i=0; $i < count($returnOfEOMBySalaryType); $i++) { 
	for ($j=0; $j < count($returnPagibigData); $j++) { 
		// if($returnOfEOMBySalaryType[$i]['id_number'] == $returnHRISActiveEmployees[$j]['EmpNo']){
				for ($k=0; $k < count($returnHRISActiveEmployees); $k++) { 
				// check id_number(column) in tbl_eom(table) if match to employee_no(column) in tbl_payroll_info_data(table)
					if($returnPagibigData[$j]['employee_no'] == $returnHRISActiveEmployees[$k]['EmpNo']){
						$temporaryArray = array(
							'EmpNo' => $returnHRISActiveEmployees[$k]['EmpNo'],
							'Section' => $returnHRISActiveEmployees[$k]['Section'],
							'Department' => $returnHRISActiveEmployees[$k]['Department'],
							'Division' => $returnHRISActiveEmployees[$k]['Division'],
							'pagibig' => $returnPagibigData[$j]['pagibig'],
						);
            			array_push($arrayEmployeeWithMatchedEmpNo, $temporaryArray);
					}
				}
       
		// }
	}
// }
// echo json_encode($arrayEmployeeWithMatchedEmpNo);
// exit();

$arrayComputedDataByProductline = array();
for ($i=0; $i < count($returnOfAllProductLine); $i++) {
	$arrayTemporaryComputedData = array(
		'Department_Name'			=> '',
		'Section_Name'				=> '',
		'Division_Name'				=> '',

	);
	for ($j=0; $j < count($arrayEmployeeWithMatchedEmpNo); $j++) {
		if($arrayEmployeeWithMatchedEmpNo[$j]['Section'] != ''){
			if($returnOfAllProductLine[$i]['Division'] == $arrayEmployeeWithMatchedEmpNo[$j]['Division']
            &&  $returnOfAllProductLine[$i]['Department'] == $arrayEmployeeWithMatchedEmpNo[$j]['Department'] 
            && $returnOfAllProductLine[$i]['Section'] == $arrayEmployeeWithMatchedEmpNo[$j]['Section']){

				$arrayTemporaryComputedData['Division_Name']			= $returnOfAllProductLine[$i]['Division'];
                $arrayTemporaryComputedData['Section_Name']				= $returnOfAllProductLine[$i]['Section'];
				$arrayTemporaryComputedData['Department_Name']			= $returnOfAllProductLine[$i]['Department'];
				$arrayTemporaryComputedData['Pagibig']					+= $arrayEmployeeWithMatchedEmpNo[$j]['pagibig'];
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
$excel->title = 'Pagibig Contribution Report';
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


$excel->place_value('A2','Monthly Pagibig Contribution Report','string');
$arrayStyleCellA2 = array(
	'name'   		=> 'Abadi MT Condensed Light',
	'size'   		=> '12',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->setFormat('A2',$arrayStyleCellA2);

$sd = date("F d", strtotime($returnPagibigData[0]['date_start']));
$ed = date("d, Y", strtotime($returnPagibigData[0]['date_end']));
$excel->place_value('A3',''.$st.' Employees ('.$sd.' - '.$ed.')','string');
$arrayStyleCellA3 = array(
	'name'   		=> 'Abadi MT Condensed Light',
	'size'   		=> '12',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->setFormat('A3',$arrayStyleCellA3);

$monthNow = date("F - Y");
$excel->place_value('A4','As of '.$monthNow,'string');
$arrayStyleCellA4 = array(
	'name'   		=> 'Abadi MT Condensed Light',
	'size'   		=> '12',
	'bold'			=> 'true',
	'horizontal'	=> 'left',
);
$excel->setFormat('A4',$arrayStyleCellA4);

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
		
		// $sectionCount = 1;
		
		// for ($i=0; $i < count($arrayEmployeeWithMatchedEmpNo); $i++) {  
		// 	$excel->place_value('A'.$rowCounter,$arrayEmployeeWithMatchedEmpNo[$i]['EmpNo'],'string');
		// 	$excel->place_value('C'.$rowCounter,$arrayEmployeeWithMatchedEmpNo[$i]['Section'],'string');

		// 	for ($u=0; $u <count($arrayComputedDataByProductline[$u]['Section_Name']); $u++) { 
		// 		if($arrayEmployeeWithMatchedEmpNo[$i]['Section'] == $arrayComputedDataByProductline[$u]['Section_Name']){
		// 		$excel->place_value('G'.$rowCounter,$sectionCount,'string');

		// 		$sectionCount++;
		// 	}
		// 	}

			
		// 	// for ($u=0; $u < count($arrayComputedDataByProductline); $u++){
		// 	// 	$sectionCount = count($arrayEmployeeWithMatchedEmpNo[$i]['Section']); 
		// 	// 	if($arrayEmployeeWithMatchedEmpNo[$i]['Section'] == $arrayComputedDataByProductline[$u]['Section_Name']){
		// 	// 		$excel->place_value('A'.$rowCounter,$arrayEmployeeWithMatchedEmpNo[$i]['EmpNo'],'string');
		// 	// 		$excel->place_value('C'.$rowCounter,$arrayEmployeeWithMatchedEmpNo[$i]['Section'],'string');

		// 	// 	}
		// 	// }

		// 	$rowCounter++;
		// }
			


    for ($i=0; $i < count($arrayComputedDataByProductline); $i++) {  
        if($arrayComputedDataByProductline[$i]['Section_Name'] != ""){
            $sectionEmployeeShare 	= doubleval($arrayComputedDataByProductline[$i]['Pagibig']);
            $sectionEmployerShare 	= doubleval($arrayComputedDataByProductline[$i]['Pagibig']);
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

/* set file name */
$filename = "Monthly Pagibig Contribution Report ".$st;
/* output excel - filename, excel version (2003,2007) */
$excel->output($filename,'2007');
?>