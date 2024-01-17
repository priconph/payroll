<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$st = $_GET['salaryType'];

if ($st == 1){
    $st = 'Daily';
}else if ($st == 2){
    $st = 'Monthly';
}else if ($st == 4){
    $st = 'JSSS';
}else if ($st == 5){
    $st = 'Rice Sub.';
}else if ($st == 6){
    $st = 'VL Conversion';
}

$get_pd = get_payroll_details();
// echo json_encode($get_pd);
// exit();

function get_payroll_details(){
    require_once ('../class/payroll_oop.php');
    
    $selectMonth    = $_GET['selectMonth'];
    $selectCutoff   = $_GET['selectCutoff'];
    $salaryType     = $_GET['salaryType'];

    $return             = $_POST;
    $result             = '';
    $array_fields       = array('a.description','a.cut_off','a.date_cut_off','b.employee_no','b.employee_name','b.net_pay','c.account_no');
    $table              = 'tbl_payroll_info a';
    $joins              = 'INNER JOIN tbl_payroll_info_data b ON b.fkid_payroll_info = a.id
                            INNER JOIN tbl_account_no c ON c.emp_no = b.employee_no
                            ';
    $sql_where          = "WHERE a.description= '$salaryType' AND a.cut_off= '$selectCutoff' AND MONTH(a.date_cut_off)= '$selectMonth' ";
    $sql_order          = '';
    $sql_limit          = '';
    $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
    $ctr = 0;
    $eeshare = 0;
    while($row = mysqli_fetch_array($result)){
        $return ['description'][]       = $row ['description'];
        $return ['employee_no'][]       = $row ['employee_no'];
        $return ['employee_name'][]     = $row ['employee_name'];
        $return ['net_pay'][]           = $row ['net_pay'];
        $return ['account_no'][]        = $row ['account_no'];
        
        $ctr++;
    }
    return $return;
}

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
$excel->title = $st;
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


// /* Set width */
$excel->objPHPExcel->getColumnDimension('A')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('B')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('C')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('D')->setAutoSize(true);

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
$excel->objPHPExcel->setCellValue('A1','Account No.');
$excel->objPHPExcel->setCellValue('B1','Amount');
$excel->objPHPExcel->setCellValue('C1','Employee No.');
$excel->objPHPExcel->setCellValue('D1','Employee Name');
$excel->set_borders('A1:D1',1,1,1,1,'thin');

$excel->objPHPExcel->getColumnDimension('A')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('B')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('C')->setAutoSize(true);
$excel->objPHPExcel->getColumnDimension('D')->setAutoSize(true);

$rowCounter = 2;
$rowStart = 2;
for ($i=0; $i <count($get_pd['employee_no']) ; $i++) { 
    $excel->set_borders('A'.$rowStart.':D'.$rowCounter,1,1,1,1,'thin');

    $excel->objPHPExcel->setCellValue('A'.$rowCounter,$get_pd['account_no'][$i]);
    $excel->objPHPExcel->setCellValue('B'.$rowCounter,$get_pd['net_pay'][$i]);
    $excel->objPHPExcel->getStyle('B'.$rowCounter)->getNumberFormat()->setFormatCode('#,##0.00');
    $excel->objPHPExcel->setCellValue('C'.$rowCounter,$get_pd['employee_no'][$i]);
    $excel->objPHPExcel->setCellValue('D'.$rowCounter,$get_pd['employee_name'][$i]);
    $rowCounter++;
    
}
    $excel->objPHPExcel->getStyle('A1:D1')->getFont()->setBold(true);
    $excel->objPHPExcel->getStyle('A1:D'.$rowCounter)->applyFromArray($arial_font_12);
    $excel->objPHPExcel->getStyle('A2:D'.$rowCounter)->applyFromArray($hl_center);


$filename = $st." Payroll Report";
$excel->output($filename);
?>
