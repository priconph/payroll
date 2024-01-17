<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

switch($_POST['action']){
    case "import_hmo_data"		: import_hmo_data();            break;
    case "save_info"		    : save_info();                  break;
    case "read_info"		    : read_info();                  break;
}

function import_hmo_data(){
    session_start();
    date_default_timezone_set('Asia/Manila');
    require_once('../class/payroll_oop.php'); 
	$input_file_name = $_FILES['file']['tmp_name'];
	$return = $_POST;
    $ctr = 0;
    $dateTayo = date("m-d-Y h:i:s");

    if (($get_record = fopen($input_file_name, "r")) !== FALSE) { //OPEN FILE 
    	$dataTayo = fgetcsv($get_record, 10000, ",");
        
		PAYROLL::getInstance()->delete_hmo_record();
        
    	while (($dataTayo = fgetcsv($get_record, 10000, ",")) !== FALSE) {
            // echo json_encode($dataTayo);
            // return;
            PAYROLL::getInstance()->insert_hmo_record($dataTayo,$dateTayo);
        }
    }
	$return['result'] = 1;
	echo json_encode($return);
}

function save_info(){
    try{
        require_once('../class/payroll_oop.php'); 
        $request = $_POST;
        if($request['data_id'] == null){
            $table = "tbl_hmo";
            $is_employee_no_existed = this_is_employee_num_existed($request['txt_emp_no']);
            if($is_employee_no_existed == 0){
                $array_fields = array('employee_no',"hmo_amount");
                $array_values = array($request['txt_emp_no'],$request["int_amount"]);
                $result = PAYROLL::getInstance()->insert_query($table,$array_fields,$array_values);
                $return['result'] = 'success';
            }else{
                $return['result'] = 'This employee number is already existed';
            }
            echo json_encode($return);
            return;
        }else{
			$pkid  = $request['data_id'];
			$table = "tbl_hmo";
			$array_fields = array('employee_no',"hmo_amount");
            $array_values = array($request['txt_emp_no'],$request["int_amount"]);
			$result = PAYROLL::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
			$return['result'] = 'success';
			echo json_encode($return);
            return;
        }
    }catch(\Throwable $err){
        $error['error_message'] =  $err;
        $error['has_error'] =  'Exception Error';
        echo json_encode($error);
    }
}

function read_info(){
    try {
        require_once('../class/payroll_oop.php'); 
        $request 			= $_POST;
        $result 			= '';
        $pkid 				= $request['pkid'];
        $array_fields 		= array('*');
        $table 	   			= 'tbl_hmo';
        $joins				= '';
        $sql_where			= 'WHERE id = "'.$pkid.'" AND `logdel` = 0';
        $sql_order	 		= '';
        $sql_limit 			= "";
        $result 			= PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        // $result 			= PAYROLL::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        while($row = mysqli_fetch_array($result)){			
            $return['pkid'] 			= $row['id'];
            $emp_no[] 		            = $row['employee_no'];
            $return['hmo_amount']		 = $row['hmo_amount'];
        }
        foreach ($emp_no as $key => $value) {
            $array_data_app 				= array();
            $array_data_app['id'] 			= $value;
            $array_data_app['text'] 		= $value;
            $return['emp_no'][]	            = $array_data_app;
        }
        echo json_encode($return);
    } catch (\Throwable $err) {
        $error['error_message'] =  $err;
        $error['has_error'] =  'Exception Error';
        echo json_encode($error);
    }
}

function this_is_employee_num_existed($emp_no){
    try{
        require_once('../class/payroll_oop.php'); 
        $result 			= '';
        $array_fields 		= array('*');
        $table 	   			= 'tbl_hmo';
        $joins				= '';
        $sql_where			= "WHERE employee_no = '{$emp_no}' AND logdel = 0";
        $sql_order	 		= '';
        $sql_limit 			= 'LIMIT 1';
        $result 			= PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        return $row = mysqli_num_rows($result);
    }catch(\Throwable $err){
        $error['error_message'] =  $err;
        $error['has_error'] =  'Exception Error';
        echo json_encode($error);
    }
}

?>