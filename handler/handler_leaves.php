<?php
// create_leaves
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if(is_ajax()) {
    if(isset($_POST["action"]) && !empty($_POST["action"])) {
        $action = $_POST["action"];
        switch($action) {
            /* do not edit below */
            case 'create_leaves'					: create_leaves(); 	        break;
            case 'read_leaves_info'					: read_leaves_info(); 		break;
            case 'update_leaves'					: update_leaves(); 	        break;
            case 'import_leaves'					: import_leaves(); 	        break;
        }
    }
}

function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}


function create_leaves(){

    try{
        require_once('../class/payroll_oop.php'); 
        $request = $_POST;
        $table = "tbl_leaves";
        $array_fields = array("emp_no","leave_code","amount","cut_off");
        $array_values = array($request["txt_emp_no"],$request["slct_leave_code"],$request["int_amount"],
                                $request["slct_cutoff"]
                        );
        $result = PAYROLL::getInstance()->insert_query($table,$array_fields,$array_values);
        $return['result'] = 'success';
        echo json_encode($return);
    }catch(Exception $err){
        $error['error_message'] =  $err;
        $error['has_error'] =  'Exception Error';
        echo json_encode($error);
    }
}
function read_leaves_info(){
    try{
        require_once('../class/payroll_oop.php'); 
        $request 			= $_POST;
        $result 			= '';
        $pkid 				= $request['pkid'];
        $array_fields 		= array('*');
        $table 	   			= 'tbl_leaves';
        $joins				= '';
        $sql_where			= 'WHERE id = "'.$pkid.'"';
        $sql_order	 		= 'ORDER BY id DESC';
        $sql_limit 			= "";
        $result 			= PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);

        $ctr 				= 0;		
        // write_logs::getInstance()->save_logs('1',$query);
        while($row = mysqli_fetch_array($result)){			
            $return['pkid'][$ctr] 			= $row['id'];
            $emp_no[] 		                = $row['emp_no'];
            $return['leave_code'][$ctr]     = $row['leave_code'];
            $return['amount'][$ctr]		    = $row['amount'];
            $return['cut_off'][$ctr] 		= $row['cut_off'];
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
function update_leaves(){
    try{
        require_once('../class/payroll_oop.php'); 
        $request 	= $_POST;
        $pkid 		= $request['data_id'];
        $table = "tbl_leaves";
        $array_fields = array('updated_by',"emp_no","leave_code","amount","cut_off","updated_at");
        $array_values = array($_SESSION['username'],$request["txt_emp_no"],$request["slct_leave_code"],$request["int_amount"],
                                $request["slct_cutoff"],date('Y-m-d H:m:s')
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


function import_leaves(){
	require_once('../class/payroll_oop.php'); 
	$input_file_name = $_FILES['file']['tmp_name'];
	$return = $_POST;
	$dateToday = date("m-d-Y h:i:s");
	$ctr = 0;
	$table = "tbl_leaves";

	if (($getfile = fopen($input_file_name, "r")) !== FALSE) { //OPEN FILE 
	 
		$data = fgetcsv($getfile, 10000, ",");
		$delete = PAYROLL::getInstance()->delete_query($table);
		
		while (($data = fgetcsv($getfile, 10000, ",")) !== FALSE) {
			$result = PAYROLL::getInstance()->insert_leave_import($data);
		}
	}
	$return['result'] = 'success';
    
	echo json_encode($return);
}
