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

$selectMonth 		= $_GET['LaborAllocationSelectMonth'];
$selectSalaryType	= $_GET['LaborAllocsalaryType'];
$selectCutoff   	= $_GET['LaborAllocSelectCutoff'];
// echo json_encode($selectMonth).'<br>';
// echo json_encode($selectSalaryType).'<br>';
// echo json_encode($selectCutoff).'<br>';
// exit();

switch ($selectSalaryType) {
	case '1':
		$title_salary_type = 'Daily';
		break;
	
	case '2':
		$title_salary_type = 'Monthly';
		break;

	case '4':
		$title_salary_type = 'JS_SS';
		break;

	default:
		$title_salary_type = '';
		break;
}
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
		'working_days'		=> $row['working_days'],
		'undertime_amnt'	=> $row['undertime_amnt'],
	);
	array_push($payrollInfoDataArray, $tempEmployeeInfoArray);
	// exit();
}

// echo json_encode(count($payrollInfoDataArray));
// echo json_encode($payrollInfoDataArray);
// exit();

$array_fields 	= 	array('*');
$table 	   		= 	'tbl_nav_code';
$joins 	   		=	'';
$sql_where 		= 	'WHERE status = 0 AND logdel =0';
$sql_order 		= 	'';
$sql_limit 		= 	'';
$payrollNavCode 		= RAPID::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
$payrollNavCodeArray 		= array();
while($row = mysqli_fetch_array($payrollNavCode)){
	$tempPayrollNavCodeArray = array(
		'nav_code_dept'		=> $row['nav_code_dept'],
		'department'		=> $row['department'],
		'nav_code_sect'		=> $row['nav_code_sect'],
		'section'			=> $row['section'],
		'nav_code_div'		=> $row['nav_code_div'],
		'division'			=> $row['division'],
	);
	array_push($payrollNavCodeArray, $tempPayrollNavCodeArray);
	// exit();
}
// echo json_encode($payrollNavCodeArray[0]['nav_code_sect']);
// exit();

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
						'working_days'		=> $payrollInfoDataArray[$z]['working_days'],
						'undertime_amnt'	=> $payrollInfoDataArray[$z]['undertime_amnt'],

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
$excel->title = 'Labor Allocation - '.$title_salary_type.'';

/* Add a new page */
$excel->add_page();

/* Set page orientation */
$excel->set_page_orientation_a4_landscape();

/* Use the default font style */
$excel->set_default_font_style();

/* Select an active sheet */
$excel->set_active_sheet(0);

/* Set margin */
$excel->set_margin();

/* Set print area */
$excel->set_print_area();

$width_allowance = .81;

/* Set width */
foreach (range('A', 'Y') as $col) {
    $excel->set_width($col, $width_allowance + 10);
}

/* Header Columns */
$excel->place_value('A1',"Document\nType",'string');
$excel->place_value('B1',"Document\nNo.",'string');
$excel->place_value('C1',"Line\nNo.",'string');
$excel->place_value('D1',"Buy-from\nVendor\nNo.",'string');
$excel->place_value('E1',"Type",'string');
$excel->place_value('F1',"No.",'string');
$excel->place_value('G1',"Expected\nReceipt\nDate",'string');
$excel->place_value('H1',"Description",'string');
$excel->place_value('I1',"Quantity",'string');
$excel->place_value('J1',"Direct\nUnit\nCost",'string');
$excel->place_value('K1',"Unit\nCost\n(LCY)",'string');
$excel->place_value('L1',"Amount",'string');
$excel->place_value('M1',"Gen.\nBus.\nPosting\nGroup",'string');
$excel->place_value('N1',"Gen.\nProd.\nPosting\nGroup",'string');
$excel->place_value('O1',"VAT\nBus.\nPosting\nGroup",'string');
$excel->place_value('P1',"Currency\nCode",'string');
$excel->place_value('Q1',"Dimension\nSet\nID",'string');
$excel->place_value('R1',"WHT\nBusiness\nPosting\nGroup",'string');
$excel->place_value('S1',"WHT\nProduct\nPosting\nGroup",'string');
$excel->place_value('T1',"WHT\nAbsorb\nBase",'string');
$excel->place_value('U1',"Businessunit\nCode\n(Dimension)",'string');
$excel->place_value('V1',"Details\nCode\n(Dimension)",'string');
$excel->place_value('W1',"Expense\nsub\ngroup\nCode\n(Dimension)",'string');
$excel->place_value('X1',"Productline\nCode\n(Dimension)",'string');
$excel->place_value('Y1',"Realaccountsgroup\nCode\n(Dimension)",'string');

$array_format = array(
	"name" 			=> 'Arial',
	"size" 			=> 10,
	"wordwrap"		=> false,
	"h_alignment" 	=> 'center'
);
$excel->set_format('A1:Y1',$array_format);

/**
 * Font weight
 */
$styleArray = array(
	'font'  => array(
		'bold'   => true,
		'size'   => '10',
		'color'  => array('rgb' => 'FFFFFF')
	)
);
$excel->objPHPExcel->getStyle('A1:Y1')->applyFromArray($styleArray);
$excel->set_borders('A1:Y1',1,1,1,1,'thin');

$excel->objPHPExcel->getStyle('A1:Y1')->getAlignment()->setWrapText(true);

$excel->objPHPExcel->getStyle('A1:Y1')->applyFromArray(array(
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => '4863A0')
    )
));

foreach (range(1, $excel->objPHPExcel->getHighestRow()) as $row) {
    $excel->objPHPExcel->getRowDimension($row)->setRowHeight(-1);
}

$rowCounter = 2;
$rowStart 	= 2;

for ($i=0; $i < count($overAllDataResult); $i++) {
	$countEmployeePerDivDeptSect = 0;
	$divisionName		= $overAllDataResult[$i]['Division'];
	$departmentName 	= $overAllDataResult[$i]['Department'];
	$sectionName 		= $overAllDataResult[$i]['Section'];
	$labor 				= 0;

	if($sectionName != ''){
		$excel->set_borders('A'.$rowStart.':Y'.$rowCounter,1,1,1,1,'thin');

		for ($j=0; $j < count($overAllPayrollDataInfoArray) ; $j++) { 
			if($overAllDataResult[$i]['Section'] == $overAllPayrollDataInfoArray[$j]['Section'] 
				&& $overAllDataResult[$i]['Division'] == $overAllPayrollDataInfoArray[$j]['Division'] 
				&& $overAllDataResult[$i]['Department'] == $overAllPayrollDataInfoArray[$j]['Department']
			){
				if($selectSalaryType == 1){
					$computation = $overAllPayrollDataInfoArray[$j]['regular_pay'] * $overAllPayrollDataInfoArray[$j]['working_days']; //working days
					//DAILY
				}else{
					$computation = $overAllPayrollDataInfoArray[$j]['regular_pay'];
					//MONTHLY&JS/SS
				}

				$laborTotal 	= 	$computation+
									$overAllPayrollDataInfoArray[$j]['salary_adj']-
									$overAllPayrollDataInfoArray[$j]['abs_amnt']-
									$overAllPayrollDataInfoArray[$j]['undertime_amnt'];
				$labor 			+= 	$laborTotal;

				for ($nav=0; $nav < count($payrollNavCodeArray); $nav++) { 
					if($payrollNavCodeArray[$nav]['section'] == $sectionName){
						// $excel->place_value('F'.$rowCounter,$payrollNavCodeArray[$nav]['nav_code_div'],'string');
						$excel->place_value('U'.$rowCounter,$payrollNavCodeArray[$nav]['nav_code_dept'],'string');
						$excel->place_value('X'.$rowCounter,$payrollNavCodeArray[$nav]['nav_code_sect'],'string');
						$excel->place_value('Y'.$rowCounter,$payrollNavCodeArray[$nav]['nav_code_div'],'string');
					}
				}
				$excel->place_value('A'.$rowCounter,'','string');
				$excel->place_value('B'.$rowCounter,'','string');
				$excel->place_value('C'.$rowCounter,'','string');
				$excel->place_value('D'.$rowCounter,'','string');
				$excel->place_value('E'.$rowCounter,'G/L Account','string');
				$excel->place_value('G'.$rowCounter,'','string');
				$excel->place_value('H'.$rowCounter,'','string');
				$excel->place_value('I'.$rowCounter,'1','number_0_decimal');
				$excel->place_value('J'.$rowCounter,$labor,'numberFormat');
				$excel->place_value('K'.$rowCounter,'','string');
				$excel->place_value('L'.$rowCounter,$labor,'numberFormat');
				$excel->place_value('M'.$rowCounter,'','string');
				$excel->place_value('N'.$rowCounter,'','string');
				$excel->place_value('O'.$rowCounter,'VAT EXEMPT','string');
				$excel->place_value('P'.$rowCounter,'','string');
				$excel->place_value('Q'.$rowCounter,'','string');
				$excel->place_value('R'.$rowCounter,'NO WHT','string');
				$excel->place_value('S'.$rowCounter,'','string');
				$excel->place_value('T'.$rowCounter,'','string');
				$excel->place_value('V'.$rowCounter,'','string');
				$excel->place_value('W'.$rowCounter,'','string');

			}
		}
	}
	else{
		continue;
	}
	$rowCounter++;
}

foreach (range('A', 'Y') as $col2) {
	$excel->objPHPExcel->getColumnDimension($col)->setAutoSize(true);
}

/* set file name */
$filename = 'Labor Allocation - '.$title_salary_type.'';
/* output excel - filename, excel version (2003,2007) */
$excel->output($filename,'2007');
?>
