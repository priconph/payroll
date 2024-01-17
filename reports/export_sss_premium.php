<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Check if the OOP file is existed
 * then include
 */


//  echo json_encode($SSSPremiumCutOff);
// exit();

$get_sss = get_sss_premium();
$get_hris_data = get_hris_info();
$get_eeshare_data = get_eeshare();
// echo count($get_eesharee_data['ctr']);
// for ($i=0; $i <count($get_sss) ; $i++) { 
// 	# code...
// 	$get_sss = $get_sss['EmpNo'];

	// echo json_encode($get_sss);
	// var_dump($get_eeshare_data);
// }

// exit();

function get_sss_premium(){
	$SSSPremiumCutOff   = $_GET['SSSPremiumCutOffType'];
    $selectMonth    = $_GET['SSSPremiumSelMonth'];


	require_once ('../class/payroll_oop.php');
	$return             = $_POST;
	$result             = '';
	$array_fields       = array('sss_premium','fkid_payroll_info','employee_no','b.date_end');
	$table              = 'tbl_payroll_info_data a';
	$joins              = 'INNER JOIN tbl_payroll_info b
							ON b.id = a.fkid_payroll_info
							';
	// $sql_where          = 'WHERE a.fkid_payroll_info = b.id
	// 						AND b.cut_off ='.$SSSPremiumCutOff.'';
	$sql_where          = 'WHERE a.fkid_payroll_info = b.id
							AND b.cut_off ='.$SSSPremiumCutOff.' AND MONTH(b.date_cut_off)= '.$selectMonth;
	$sql_order          = '';
	$sql_limit          = '';
	$result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// $result             = PAYROLL::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// return $result;
	$ctr = 0;
	$eeshare = 0;
	while($row = mysqli_fetch_array($result)){
		$return ['sss_premium'][] = $row ['sss_premium'];
		$return ['employee_no'][] = $row ['employee_no'];
		$return ['date_end'][] = $row ['date_end'];
		// $return ['employee_no'][] = $row ['employee_no'];
		
		$ctr++;
	}
	// $return['ctr']  = $ctr;
	return $return;
}

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

function get_eeshare(){
	require_once ('../class/payroll_oop.php');
	$return             = $_POST;
	$result             = '';
	$array_fields       = array('eeshare ','ershare','eccshare');
	$table              = 'tbl_sss';
	$joins              = '';
	$sql_where          = '';
	$sql_order          = '';
	$sql_limit          = '';
	$result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// $result             = PAYROLL::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	// return $result;
	$ctr = 0;
	$eeshare = 0;
	while($row = mysqli_fetch_array($result)){
		$return ['eeshare'][] = $row ['eeshare'];
		$return ['ershare'][] = $row ['ershare'];
		$return ['eccshare'][] = $row ['eccshare'];
		// $return ['date_end'][] = $row ['date_end'];
		// $return ['employee_no'][] = $row ['employee_no'];
		
		$ctr++;
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
$excel->title = 'SSS Premium';
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
$excel->objPHPExcel->setCellValue('F1','EEShare');
$excel->objPHPExcel->setCellValue('G1','EEShare');
$excel->objPHPExcel->setCellValue('H1','ECShare');
$excel->objPHPExcel->setCellValue('I1','SSS No.');
$excel->objPHPExcel->setCellValue('J1','Tin No.');
$excel->objPHPExcel->setCellValue('K1','Date Hired');
$excel->objPHPExcel->setCellValue('L1','PhilHealth');
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

$rowCounter = 2;
$rowStart = 2;
for ($u=0; $u <count($get_sss['employee_no']) ; $u++) { 
	
		for ($i=0; $i < count($get_hris_data['EmpNo']); $i++) { 
			if($get_sss['employee_no'][$u] == $get_hris_data['EmpNo'][$i]){
				$excel->objPHPExcel->setCellValue('A'.$rowCounter,$get_sss['date_end'][$u]);
				$excel->objPHPExcel->setCellValue('B'.$rowCounter,$get_hris_data['EmpNo'][$i]);
				$excel->objPHPExcel->setCellValue('C'.$rowCounter,$get_hris_data['LastName'][$i]);
				$excel->objPHPExcel->setCellValue('D'.$rowCounter,$get_hris_data['FirstName'][$i]);
				$excel->objPHPExcel->setCellValue('E'.$rowCounter,$get_hris_data['MiddleName'][$i]);
				$excel->objPHPExcel->setCellValue('F'.$rowCounter,$get_sss['sss_premium'][$u]);
				$excel->objPHPExcel->setCellValue('I'.$rowCounter,$get_hris_data['SSN'][$i]);
				$excel->objPHPExcel->setCellValue('J'.$rowCounter,$get_hris_data['TIN'][$i]);
				$excel->objPHPExcel->setCellValue('K'.$rowCounter,$get_hris_data['DateHired'][$i]);
				$excel->objPHPExcel->setCellValue('L'.$rowCounter,$get_hris_data['PhilHealth'][$i]);
			for ($q=0; $q <count($get_eeshare_data['eeshare']) ; $q++) { 
				if($get_eeshare_data['eeshare'][$q] == $get_sss['sss_premium'][$u]){
					$excel->objPHPExcel->setCellValue('G'.$rowCounter,$get_eeshare_data['ershare'][$q]);
					$excel->objPHPExcel->setCellValue('H'.$rowCounter,$get_eeshare_data['eccshare'][$q]);
				}
			}
		}

		
	}
	$rowCounter++;
	

}

	$excel->objPHPExcel->getStyle('A1:J'.$rowCounter)->applyFromArray($arial_font_12);
	$excel->objPHPExcel->getStyle('A2:J'.$rowCounter)->applyFromArray($hl_center);
	$excel->objPHPExcel->getStyle('A1:J1')->applyFromArray($hv_center);


/* set file name */
$filename = "SSS Premium";
/* output excel - filename, excel version (2003,2007) */
$excel->output($filename);
?>
