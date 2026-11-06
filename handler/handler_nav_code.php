
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if(is_ajax()) {
    if(isset($_POST["action"]) && !empty($_POST["action"])) {
        $action = $_POST["action"];
        switch($action) {
            case 'create_update_nav_code'           : create_update_nav_code();             break;
            case 'get_nav_code_by_id'               : get_nav_code_by_id();                 break;
            case 'nav_code_change_status_by_id'     : nav_code_change_status_by_id();       break;
        }
    }
}

function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function create_update_nav_code(){
    try{
        require_once('../class/nav_code_oop.php'); 
        $request = $_POST;
        $pkid 		= $request['nav_code_pkid'];
        $table = "tbl_nav_code";

        $common_fields = array(
            'nav_code_dept',
            'department',
            'nav_code_sect',
            'section',
            'nav_code_div',
            'division'
        );
        
        $common_values = array(
            $request["nav_code_department"],
            $request["department"],
            $request["nav_code_section"],
            $request["section"],
            $request["nav_code_division"],
            $request["division"]
        );
        
        $timestamp = date('Y-m-d H:i:s');
        
        if (empty($request["nav_code_pkid"])) {
            // echo 'Insert';
            // return;
            $array_fields = array_merge($common_fields, array('created_at'));
            $array_values = array_merge($common_values, array($timestamp));
            
            $result = PAYROLL::getInstance()->insert_query($table, $array_fields, $array_values);
        } else {
            // echo 'Update';
            // return;
            $array_fields = array_merge($common_fields, array('updated_at'));
            $array_values = array_merge($common_values, array($timestamp));
            
            $result = PAYROLL::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
        }            

        $return['result'] = 'success';
        echo json_encode($return);
    }catch(Exception $err){
        $error['error_message'] =  $err;
        $error['has_error'] =  'Exception Error';
        echo json_encode($error);
    }
}

function get_nav_code_by_id(){
    try{
        require_once('../class/nav_code_oop.php'); 
        $request 			= $_POST;
        $result 			= '';

        $nav_code_pkid 		= $request['pkid'];
        $array_fields 		= array('*');
        $table 	   			= 'tbl_nav_code';
        $joins				= '';
        $sql_where			= 'WHERE logdel = "0" AND pkid  = "'.$nav_code_pkid.'"';
        $sql_order	 		= 'ORDER BY pkid ASC';
        $sql_limit 			= "";
        $result 			= PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr 				= 0;		
        while($row = mysqli_fetch_array($result)){			
            $return['nav_code_dept'][$ctr]  = $row['nav_code_dept'];
            $return['department'][$ctr]     = $row['department'];
            $return['nav_code_sect'][$ctr]  = $row['nav_code_sect'];
            $return['section'][$ctr] 	    = $row['section'];
            $return['nav_code_div'][$ctr]   = $row['nav_code_div'];
            $return['division'][$ctr] 	    = $row['division'];
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

function nav_code_change_status_by_id(){
    try{
        require_once('../class/nav_code_oop.php'); 
        $timestamp = date('Y-m-d H:i:s');
        $request = $_POST;
        $pkid 		= $request['nav_code_status_pkid'];
        $table = "tbl_nav_code";
        
        $array_fields = array(
            'status',
            'updated_at'
        );
        
        $array_values = array(
            $request["nav_code_status"],
            $timestamp
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
