<?php
ini_set('max_execution_time', 123456);
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

$get_eomd   = get_eom_details();
$get_pd = get_payroll_details();
$get_love = get_pagibig_loan();



function get_eom_details(){
    require_once ('../class/payroll_oop.php');

    $salaryType = $_GET['salaryType'];

    $return             = $_POST;
    // $result             = '';
    // $array_fields       = array('id_number, emp_code');
    // $table              = 'tbl_eom';
    // $joins              = '';
    // $sql_where          = "WHERE emp_code = '".$salaryType."' ";
    // $sql_order          = '';
    // $sql_limit          = '';
    // $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
    // while($row = mysqli_fetch_array($result)){

        // $return ['id_number'][]       = $row ['id_number'];
        // $return ['emp_code'][]        = $row ['emp_code'];

        $resultx             = '';
        $array_fieldsx       = array('EmpNo, LastName, FirstName, MiddleName, DOBirth, SSN, TIN, SalaryType ');
        $tablex              = 'vw_EmployeeInfo';
        $joinsx              = '';
        // $sql_wherex          = 'WHERE EmpStatus = 1 AND EmpNo = "'.$row['id_number'].'" AND SalaryType= "'.$salaryType.'" ';
        $sql_wherex          = 'WHERE EmpStatus = 1 AND SalaryType= "'.$salaryType.'" ';
        $sql_orderx          = '';
        $sql_limitx          = '';
        $resultx             = HRIS::getInstance()->select_query($array_fieldsx,$tablex,$joinsx,$sql_wherex,$sql_orderx,$sql_limitx);
        while($rowx = mysqli_fetch_array($resultx)){
            $return ['EmpNo'][]       = $rowx ['EmpNo'];
            $return ['LastName'][]    = $rowx ['LastName'];
            $return ['FirstName'][]   = $rowx ['FirstName'];
            $return ['MiddleName'][]  = $rowx ['MiddleName'];
            $return ['DOBirth'][]     = $rowx ['DOBirth'];
            $return ['SSN'][]         = $rowx ['SSN'];
            $return ['TIN'][]         = $rowx ['TIN'];
        }

    // }
    return $return;
}

// echo json_encode($get_eomd);
// return;


function get_payroll_details(){
    require_once ('../class/payroll_oop.php');
    
    $selectMonth    = $_GET['selectMonth'];
    $selectCutoff   = $_GET['selectCutoff'];
    $salaryType     = $_GET['salaryType'];

    $return             = $_POST;
    $result             = '';
    $array_fields       = array('b.employee_no','b.pagibig_loan','b.pagibig_cal_loan', 'b.pagibig_safe_loan');
    $table              = 'tbl_payroll_info a';
    $joins              = 'INNER JOIN tbl_payroll_info_data b ON b.fkid_payroll_info = a.id
                            ';
    $sql_where          = 'WHERE a.description= '.$salaryType.' AND a.cut_off= '.$selectCutoff.' AND MONTH(a.date_cut_off)= '.$selectMonth.' 
                            AND YEAR(a.date_cut_off)= '.date('Y').'
                            ';
    // AND YEAR(a.date_cut_off)='.date('Y').'

    $sql_order          = '';
    $sql_limit          = '';
    $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
    $ctr = 0;
    $eeshare = 0;
    while($row = mysqli_fetch_array($result)){
        // $return ['description'][]       = $row ['description'];
        $return ['employee_no'][]           = $row ['employee_no'];
        $return ['pagibig_loan'][]          = $row ['pagibig_loan'];
        $return ['pagibig_cal_loan'][]      = $row ['pagibig_cal_loan'];
        $return ['pagibig_safe_loan'][]     = $row ['pagibig_safe_loan'];
        
        $ctr++;
    }
    return $return;
}

// echo json_encode($get_pd);
// exit();

function get_pagibig_loan(){
	require_once ('../class/payroll_oop.php');
	$return             = $_POST;
	$result             = '';
	$array_fields       = array('emp_no');
	$table              = 'tbl_pagibig_loan';
	$joins              = '';
	$sql_where          = '';
	$sql_order          = '';
	$sql_limit          = '';
	$result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// $result             = PAYROLL::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// return $result;
	$ctr = 0;
	while($row = mysqli_fetch_array($result)){
		$return ['emp_no'][] = $row ['emp_no'];
		// $return ['date_end'][] = $row ['date_end'];
		// $return ['employee_no'][] = $row ['employee_no'];
		
		$ctr++;
	}
	// $return['ctr']  = $ctr;
	return $return;
}

// echo json_encode($get_love);
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
$excel->title = 'Pag-ibig Loan';
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
// $excel->objPHPExcel->setCellValue('A1','Period');
$excel->objPHPExcel->setCellValue('A1','EmpNo');
$excel->objPHPExcel->setCellValue('B1','LastName');
$excel->objPHPExcel->setCellValue('C1','FirstName');
$excel->objPHPExcel->setCellValue('D1','MiddleName');
$excel->objPHPExcel->setCellValue('E1','Date of Birth');
$excel->objPHPExcel->setCellValue('F1','SSN');
$excel->objPHPExcel->setCellValue('G1','TIN');
$excel->objPHPExcel->setCellValue('H1','Loan Amount');
$excel->objPHPExcel->setCellValue('I1','Calamity Loan Amount');
$excel->objPHPExcel->setCellValue('J1','Safe Loan Amount');


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


$rowCounter = 2;
	
	// for ($u=0; $u <count($.['emp_no']); $u++) { 
		for ($i=0; $i <count($get_eomd['EmpNo']); $i++) { 
			// if($get_eomd['EmpNo'][$i] == $get_love['emp_no'][$u]){
				$excel->objPHPExcel->setCellValue('A'.$rowCounter,$get_eomd['EmpNo'][$i]);
				$excel->objPHPExcel->setCellValue('B'.$rowCounter,$get_eomd['LastName'][$i]);
				$excel->objPHPExcel->setCellValue('C'.$rowCounter,$get_eomd['FirstName'][$i]);
				$excel->objPHPExcel->setCellValue('D'.$rowCounter,$get_eomd['MiddleName'][$i]);
				$excel->objPHPExcel->setCellValue('E'.$rowCounter,$get_eomd['DOBirth'][$i]);
				$excel->objPHPExcel->setCellValue('F'.$rowCounter,$get_eomd['SSN'][$i]);
				$excel->objPHPExcel->setCellValue('G'.$rowCounter,$get_eomd['TIN'][$i]);
				for ($x=0; $x <count($get_pd['employee_no']) ; $x++) { 
					if($get_pd['employee_no'][$x] == $get_eomd['EmpNo'][$i]){
						$excel->objPHPExcel->setCellValue('H'.$rowCounter,$get_pd['pagibig_loan'][$x]);
						$excel->objPHPExcel->setCellValue('I'.$rowCounter,$get_pd['pagibig_cal_loan'][$x]);
						$excel->objPHPExcel->setCellValue('J'.$rowCounter,$get_pd['pagibig_safe_loan'][$x]);
					}
				}
				$rowCounter++;
			// }
		}
	// }
	
	$excel->objPHPExcel->getStyle('A1:J'.$rowCounter)->applyFromArray($arial_font_12);
	$excel->objPHPExcel->getStyle('A2:J'.$rowCounter)->applyFromArray($hl_center);
	$excel->objPHPExcel->getStyle('A1:J1')->applyFromArray($hv_center);


/* set file name */
$filename = "Pag-ibig Loan";
/* output excel - filename, excel version (2003,2007) */
$excel->output($filename);
?>
