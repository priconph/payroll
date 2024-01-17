<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Check if the OOP file is existed
 * then include
 */


$get_philhealth_premium = get_philhealth_premium();
$get_hris_data = get_hris_info();
// echo count($get_philhealth_premium['ctr']);
// for ($i=0; $i <count($get_philhealth_premium) ; $i++) { 
// 	# code...
// 	$get_philhealth_premium = $get_philhealth_premium['EmpNo'];

	// var_dump($get_philhealth_premium['ph_premium']);
// }

// return;

function get_philhealth_premium(){
	require_once ('../class/payroll_oop.php');
	$PhilHealthCutOff   = $_GET['PhilHealthCutOffType'];
	$selectMonth    = $_GET['selectMonth'];
	
	$return             = $_POST;
	$result             = '';
	$array_fields       = array('ph_premium','fkid_payroll_info','employee_no','b.date_end');
	$table              = 'tbl_payroll_info_data a';
	$joins              = 'INNER JOIN tbl_payroll_info b
							ON b.id = a.fkid_payroll_info
							';
	// $sql_where          = 'WHERE a.fkid_payroll_info = b.id
	// 						AND MONTH(b.date_cut_off)='.$selectMonth.'AND b.cut_off='.$PhilHealthCutOff.'';
	$sql_where          = 'WHERE b.cut_off= '.$PhilHealthCutOff.' AND MONTH(b.date_cut_off)= '.$selectMonth.' ';
	$sql_order          = '';
	$sql_limit          = '';
	$result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// $result             = PAYROLL::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// return $result;
	$ctr = 0;
	$eeshare = 0;
	while($row = mysqli_fetch_array($result)){
		$return ['ph_premium'][] = $row ['ph_premium'];
		$return ['employee_no'][] = $row ['employee_no'];
		$return ['date_end'][] = $row ['date_end'];
		// $return ['employee_no'][] = $row ['employee_no'];
		
		$ctr++;
	}
	// $return['ctr']  = $ctr;
	return $return;
}

// echo json_encode($get_philhealth_premium);
// exit();


function get_hris_info(){
	require_once ('../class/hris_data.php');
	$return             = $_POST;
	$result             = '';
	$array_fields       = array('*');
	$table              = 'vw_EmployeeInfo';
	$joins              = '';
	$sql_where          = '';
	$sql_order          = '';
	$sql_limit          = '';
	$result             = HRIS_details::getInstance()->fetch_all_hris_info();
	// $result             = PAYROLL::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// return $result;
	$ctr = 0;
	$eeshare = 0;
	while($row = mysqli_fetch_array($result)){
		$return['EmpNo'][] 				= $row['EmpNo'];
		$return['LastName'][] 				= $row['LastName'];
		$return['FirstName'][] 				= $row['FirstName'];
		$return['MiddleName'][] 				= $row['MiddleName'];
		$return['SSN'][] 				= $row['SSN'];
		$return['TIN'][] 				= $row['TIN'];
		$return['DateHired'][] 				= $row['DateHired'];
		$return['PhilHealth'][] 				= $row['PhilHealth'];
		
		// $ctr++;
	}
	// $return['ctr']  = $ctr;
	return $return;
}




/**
 * Query
 */



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
$excel->title = 'PhilHealth Premium';
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
$excel->objPHPExcel->setCellValue('A1','Period');
$excel->objPHPExcel->setCellValue('B1','EmpNo');
$excel->objPHPExcel->setCellValue('C1','LastName');
$excel->objPHPExcel->setCellValue('D1','FirstName');
$excel->objPHPExcel->setCellValue('E1','MiddleName');
$excel->objPHPExcel->setCellValue('F1','EESHare');
$excel->objPHPExcel->setCellValue('G1','ERSHare');
$excel->objPHPExcel->setCellValue('H1','SSS No.');
$excel->objPHPExcel->setCellValue('I1','Tin No.');
$excel->objPHPExcel->setCellValue('J1','Date Hired');
$excel->objPHPExcel->setCellValue('K1','PhilHealth');
// $excel->objPHPExcel->setCellValue('K1','Status');

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

$rowCounter = 2;
$rowStart = 2;
for ($u=0; $u <count($get_philhealth_premium['employee_no']) ; $u++) { 
	
		for ($i=0; $i < count($get_hris_data['EmpNo']); $i++) { 
			if($get_philhealth_premium['employee_no'][$u] == $get_hris_data['EmpNo'][$i]){
				$excel->objPHPExcel->setCellValue('A'.$rowCounter,$get_philhealth_premium['date_end'][$u]);
				$excel->objPHPExcel->setCellValue('B'.$rowCounter,$get_hris_data['EmpNo'][$i]);
				$excel->objPHPExcel->setCellValue('C'.$rowCounter,$get_hris_data['LastName'][$i]);
				$excel->objPHPExcel->setCellValue('D'.$rowCounter,$get_hris_data['FirstName'][$i]);
				$excel->objPHPExcel->setCellValue('E'.$rowCounter,$get_hris_data['MiddleName'][$i]);
				$excel->objPHPExcel->setCellValue('F'.$rowCounter,$get_philhealth_premium['ph_premium'][$u]);
				$excel->objPHPExcel->setCellValue('G'.$rowCounter,$get_philhealth_premium['ph_premium'][$u]);
				$excel->objPHPExcel->setCellValue('H'.$rowCounter,$get_hris_data['SSN'][$i]);
				$excel->objPHPExcel->setCellValue('I'.$rowCounter,$get_hris_data['TIN'][$i]);
				$excel->objPHPExcel->setCellValue('J'.$rowCounter,$get_hris_data['DateHired'][$i]);
				$excel->objPHPExcel->setCellValue('K'.$rowCounter,$get_hris_data['PhilHealth'][$i]);
					# code...
		}
		
	}
	$rowCounter++;
	

}

	$excel->objPHPExcel->getStyle('A1:J'.$rowCounter)->applyFromArray($arial_font_12);
	$excel->objPHPExcel->getStyle('A2:J'.$rowCounter)->applyFromArray($hl_center);
	$excel->objPHPExcel->getStyle('A1:J1')->applyFromArray($hv_center);


/* set file name */
$filename = "PhilHealth Premium";
/* output excel - filename, excel version (2003,2007) */
$excel->output($filename);
?>
