    
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if(is_ajax()) {
	if(isset($_POST["action"]) && !empty($_POST["action"])) {
		$action = $_POST["action"];
		switch($action) {
			/* Tax Info */
			case 'create_taxes'								: create_taxes(); 									break;
			case 'read_taxes_info'							: read_taxes_info(); 								break;
			case 'update_taxes'								: update_taxes(); 									break;
			case 'import_taxes_data'						: import_taxes_data(); 								break;
			case 'import_annual_tax_ytd'					: import_annual_tax_ytd(); 							break;
			/* Tax Base */
			case 'create_tax_base'							: create_tax_base(); 								break;
			case 'get_tax_base_data'						: get_tax_base_data(); 								break;
			case 'update_tax_base_data'						: update_tax_base_data(); 							break;
			/* Annual Tax  */
			case 'create_annual_tax'						: create_annual_tax(); 								break;
			case 'read_annual_tax_data'						: read_annual_tax_data(); 							break;
			case 'update_annual_tax'						: update_annual_tax(); 								break;
		}
	}
}

function is_ajax() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
/* Tax Info */
function create_taxes(){
	require_once('../class/payroll_oop.php');
	$request 	= $_POST;
	try{
		require_once('../class/payroll_oop.php'); 
		$request = $_POST;
		$table = "tbl_taxes";
		$array_fields = array("emp_no","salary_adjustments","other_earnings","advances_other_deductions","tax_adjustments");
		$array_values = array($request['txt_emp_no'],$request["txt_salary_adjustments"],$request["txt_other_earnings"],$request["txt_ad_deduc"],$request["txt_tax_adjustment"]);
		$result = PAYROLL::getInstance()->insert_query($table,$array_fields,$array_values);
		$return['result'] = 'success';
		echo json_encode($return);
	}catch(Exception $err){
		$error['error_message'] =  $err;
		$error['has_error'] =  'Exception Error';
		echo json_encode($error);
	}
}
function read_taxes_info(){
	try{
		require_once('../class/payroll_oop.php'); 
		$request 			= $_POST;
		$result 			= '';
		$pkid 				= $request['pkid'];
		$array_fields 		= array('*');
		$table 	   			= 'tbl_taxes';
		$joins				= '';
		$sql_where			= 'WHERE id = "'.$pkid.'"';
		$sql_order	 		= 'ORDER BY id DESC';
		$sql_limit 			= "";
		$result 			= PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr 				= 0;	
		// write_logs::getInstance()->save_logs('1',$query);
		while($row = mysqli_fetch_array($result)){			
			$return['Pkid'][$ctr] 						= $row['id'];
			$emp_no[] 									= $row['emp_no'];
			$return['salary_adjustments'][$ctr] 		= $row['salary_adjustments'];
			$return['other_earnings'][$ctr] 			= $row['other_earnings'];
			$return['advances_other_deductions'][$ctr]	= $row['advances_other_deductions'];
			$return['tax_adjustments'][$ctr] 			= $row['tax_adjustments'];
			$ctr++;
		}
		foreach ($emp_no as $key => $value) {
			$array_data_app 				= array();
			$array_data_app['id'] 			= $value;
			$array_data_app['text'] 		= $value;
			$return['emp_no'][]	= $array_data_app;
		}
		$return['ctr'] = $ctr;
		echo json_encode($return);
	}catch(Exception $err){
		$error['error_message'] =  $err;
		$error['has_error'] =  'Exception Error';
		echo json_encode($error);
	}
}
function update_taxes(){
	try{
		require_once('../class/payroll_oop.php'); 
		$request 	= $_POST;
		$pkid 		= $request['data_id'];
		$table = "tbl_taxes";
		$array_fields = array("emp_no","salary_adjustments","other_earnings"
								,"advances_other_deductions","tax_adjustments"
						);
		$array_values = array($request['txt_emp_no'],$request["txt_salary_adjustments"],$request["txt_other_earnings"],$request["txt_ad_deduc"]
								,$request["txt_tax_adjustment"]
						);
		$result = PAYROLL::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		
		$return['result'] = 'success';
		echo json_encode($return);
	}catch(Exception $err){
		$error['error_message'] =  $err;
		$error['has_error'] =  'Exception Error';
		echo json_encode($error);
	}
}

function import_taxes_data(){
	require_once('../class/payroll_oop.php'); 
	$input_file_name = $_FILES['file']['tmp_name'];
	$return = $_POST;
	$dateToday = date("m-d-Y h:i:s");
	$ctr = 0;
	$table = "tbl_taxes";
	if (($getfile = fopen($input_file_name, "r")) !== FALSE) { //OPEN FILE 
		$data = fgetcsv($getfile, 10000, ",");
		$delete = PAYROLL::getInstance()->delete_query($table);
		
		while (($data = fgetcsv($getfile, 10000, ",")) !== FALSE) {
			$result = PAYROLL::getInstance()->insert_taxes_import($data);
		}
	}
	echo json_encode($result);
}

/**
 * Import Annual Tax YTD
 * 04-18-2024
 */
function import_annual_tax_ytd(){
	require_once('../class/payroll_oop.php'); 
	$input_file_name = $_FILES['file']['tmp_name'];
	$return = $_POST;
	$dateToday = date("m-d-Y h:i:s");
	$ctr = 0;
	$table = "tbl_annual_tax";
	if (($getfile = fopen($input_file_name, "r")) !== FALSE) { //OPEN FILE 
		$data = fgetcsv($getfile, 10000, ",");
		$delete = PAYROLL::getInstance()->delete_query($table);
		
		while (($data = fgetcsv($getfile, 10000, ",")) !== FALSE) {
			$result = PAYROLL::getInstance()->insert_annual_tax_ytd($data);
		}
	}
	echo json_encode($result);
}

/* Tax Base */
function create_tax_base(){
	try{
		require_once('../class/payroll_oop.php'); 
		$request = $_POST;
		$table = "tbl_tax_base";
		$array_fields = array("tax_base","tax_rate","lower_limit","upper_limit","created_at",'created_by');
		$array_values = array($request["tax_base"],$request["tax_rate"],$request["lower_limit"],$request["upper_limit"],date('Y-m-d H:m:s'),$_SESSION['username'] );
		$result = PAYROLL::getInstance()->insert_query($table,$array_fields,$array_values);
		$return['result'] = 'success';
		echo json_encode($return);
	}catch(Exception $err){
		$error['error_message'] =  $err;
		$error['has_error'] =  'Exception Error';
		echo json_encode($error);
	}
}

function get_tax_base_data(){
	try{
		require_once('../class/payroll_oop.php'); 
		$request 			= $_POST;
		$result 			= '';
		$pkid 				= $request['pkid'];
		$array_fields 		= array('*');
		$table 	   			= 'tbl_tax_base';
		$joins				= '';
		$sql_where			= 'WHERE id = "'.$pkid.'" AND logdel = "0"';
		$sql_order	 		= 'ORDER BY id DESC';
		$sql_limit 			= "";
		$result 			= PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr 				= 0;		
		// write_logs::getInstance()->save_logs('1',$query);
		while($row = mysqli_fetch_array($result)){			
			
			$return['Id'][$ctr]				= $row['id'];
			$return['TaxBase'][$ctr]		= $row['tax_base'];
			$return['TaxRate'][$ctr] 		= $row['tax_rate'];
			$return['LowerLimit'][$ctr] 	= $row['lower_limit'];
			$return['UpperLimit'][$ctr] 	= $row['upper_limit'];
			$ctr++;
		}
		$return['ctr'] = $ctr;
		echo json_encode($return);
	}catch(Exception $err){
		$error['error_message'] =  $err;
		$error['has_error'] =  'Exception Error';
		echo json_encode($error);
	}
}
function update_tax_base_data(){
	try{
		require_once('../class/payroll_oop.php'); 
		$request 	= $_POST;
		$pkid 		= $request['data_id'];
		$table		= "tbl_tax_base";

		$array_fields = array("tax_base","tax_rate","lower_limit","upper_limit","created_at",'created_by');
		$array_values = array($request["tax_base"],$request["tax_rate"],$request["lower_limit"],$request["upper_limit"],date('Y-m-d H:m:s'),$_SESSION['username'] );
		// $result = PAYROLL::getInstance()->update_query($table,$array_fields,$array_values,$pkid,$idname);
		$result = PAYROLL::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		// echo json_encode($result);
		// return;
		$return['result'] = 'success';
		echo json_encode($return);
	}catch(Exception $err){
		$error['error_message'] =  $err;
		$error['has_error'] =  'Exception Error';
		echo json_encode($error);
	}
}
/* Annual Tax */
function create_annual_tax(){
	try{
		require_once('../class/payroll_oop.php'); 
		$request = $_POST;
		$table = "tbl_annual_tax";
		$array_fields = array("emp_no",
								"gross_income_ytd",
								"forecast_earnings",
								"less_ytd_tax_exempt",
								"yt_tax_withheld",
								"leaves_taxes");
		$array_values = array($request["txt_emp_no"],
								$request["txt_gross_income"],
								$request["txt_forecast_earnings"],
								$request["txt_tax_exempt"],
								$request["txt_tax_withheld"],
								$request["txt_annual_tax_others"]);
		$result = PAYROLL::getInstance()->insert_query($table,$array_fields,$array_values);
		$return['result'] = 'success';
		echo json_encode($return);
	}catch(Exception $err){
		$error['error_message'] =  $err;
		$error['has_error'] =  'Exception Error';
		echo json_encode($error);
	}
}
function read_annual_tax_data(){
	try{
		require_once('../class/payroll_oop.php'); 
		$request 			= $_POST;
		$result 			= '';
		$pkid 				= $request['pkid'];
		$array_fields 		= array('*');
		$table 	   			= 'tbl_annual_tax';
		$joins				= '';
		$sql_where			= 'WHERE id = "'.$pkid.'" AND logdel = "0"';
		$sql_order	 		= 'ORDER BY id DESC';
		$sql_limit 			= "";
		$result 			= PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		$ctr 				= 0;		
		while($row = mysqli_fetch_array($result)){			
			
			$return['id'][$ctr]						= $row['id'];
			$emp_no	[]								= $row['emp_no'];
			$return['gross_income_ytd'][$ctr] 		= $row['gross_income_ytd'];
			$return['forecast_earnings'][$ctr] 		= $row['forecast_earnings'];
			$return['less_ytd_tax_exempt'][$ctr] 	= $row['less_ytd_tax_exempt'];
			$return['yt_tax_withheld'][$ctr] 		= $row['yt_tax_withheld'];
			$return['leaves_taxes'][$ctr] 			= $row['leaves_taxes'];
			$ctr++;
		}
		foreach ($emp_no as $key => $value) {
			$array_data_app 				= array();
			$array_data_app['id'] 			= $value;
			$array_data_app['text'] 		= $value;
			$return['emp_no'][]	= $array_data_app;
		}

		$return['ctr'] = $ctr;
		echo json_encode($return);
	}catch(Exception $err){
		$error['error_message'] =  $err;
		$error['has_error'] =  'Exception Error';
		echo json_encode($error);
	}
}
function update_annual_tax(){
	// echo 'true';
	// return;
	try{
		require_once('../class/payroll_oop.php'); 
		$request 	= $_POST;
		$pkid 		= $request['data_id'];
		$table		= "tbl_annual_tax";
		$array_fields = array("emp_no",
								"gross_income_ytd",
								"forecast_earnings",
								"less_ytd_tax_exempt",
								"yt_tax_withheld",
								"leaves_taxes");
		$array_values = array(	$request["txt_emp_no"],
								$request["txt_gross_income"],
								$request["txt_forecast_earnings"],
								$request["txt_tax_exempt"],
								$request["txt_tax_withheld"],
								$request["txt_up_annual_tax_others"]);
		$result = PAYROLL::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
		$return['result'] = 'success';
		echo json_encode($return);
	}catch(Exception $err){
		$error['error_message'] =  $err;
		$error['has_error'] =  'Exception Error';
		echo json_encode($error);
	}
}