<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

switch($_POST['action']){
    case "import_philhealth_data"		: import_philhealth_data(); break;
}

function import_philhealth_data(){
    session_start();
    date_default_timezone_set('Asia/Manila');
    require_once('../class/payroll_oop.php'); 
	$input_file_name = $_FILES['file']['tmp_name'];
	$return = $_POST;
    $ctr = 0;
    $dateToday = date("m-d-Y h:i:s");
    // print_r($input_file_name);
    // return;

    if (($getfile = fopen($input_file_name, "r")) !== FALSE) { //OPEN FILE 
    	$data = fgetcsv($getfile, 10000, ",");

		PAYROLL::getInstance()->delete_philhealth_record();
        
    	while (($data = fgetcsv($getfile, 10000, ",")) !== FALSE) {
            $result =    PAYROLL::getInstance()->insert_philhealth_import($data,$_SESSION['username'],$dateToday);
	        // echo json_encode($result);
        }
    }
	$return['result'] = 1;
	echo json_encode($return);
}
?>