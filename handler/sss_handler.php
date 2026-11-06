<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    switch($_POST['action']){
        case "import_sss_data"		        : import_sss_data();                break;
        case "import_sss_premium"		    : import_sss_premium();             break;
        case "import_sss_calamity_loan"		: import_sss_calamity_loan();       break;
        
        case "save_sss_loan"		        : save_sss_loan();                  break;
        case "read_sss_loan"		        : read_sss_loan();                  break;
        
        case "save_sss_calamity_loan"		: save_sss_calamity_loan();         break;
        case "read_sss_calamity_loan"	    : read_sss_calamity_loan();         break;
        
        case "save_sss_condonation"		: save_sss_condonation();         break;
        case "read_sss_condonation"	    : read_sss_condonation();         break;
        case "import_sss_condonation"		        : import_sss_condonation();                break;

    }

    function save_sss_loan(){
        try{
            require_once('../class/payroll_oop.php'); 
            $request = $_POST;
            if($request['data_id'] == null){
                $table = "tbl_sss_loans";
                $is_employee_no_existed = this_is_employee_num_existed($request['txt_emp_no'],$table);
                if($is_employee_no_existed == 0){
                    $array_fields = array('emp_num',"sss_no","charge_amount");
                    $array_values = array($request['txt_emp_no'],$request["txt_sss_no"],$request["int_amount"]);
                    $result = PAYROLL::getInstance()->insert_query($table,$array_fields,$array_values);
                    $return['result'] = 'success';
                }else{
                    $return['result'] = 'This employee number is already existed';
                }
                echo json_encode($return);
                return;
            }else{
                $pkid  = $request['data_id'];
                $table = "tbl_sss_loans";
                $array_fields = array('employee_no',"hmo_amount","lastupdate");
                $array_fields = array('emp_num',"sss_no","charge_amount");
                $array_values = array($request['txt_emp_no'],$request["txt_sss_no"],$request["int_amount"]);
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

    function read_sss_loan(){
        try {
            require_once('../class/payroll_oop.php'); 
            $request 			= $_POST;
            $result 			= '';
            $pkid 				= $request['pkid'];
            $array_fields 		= array('*');
            $table 	   			= 'tbl_sss_loans';
            $joins				= '';
            $sql_where			= 'WHERE id = "'.$pkid.'"';
            $sql_order	 		= '';
            $sql_limit 			= "";
            $result 			= PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
            // $result 			= PAYROLL::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
            // echo json_encode($result);
            // return;
            while($row = mysqli_fetch_array($result)){			
                $return['pkid'] 			= $row['id'];
                $emp_no[] 		            = $row['emp_num'];
                $return['sss_no']		 = $row['sss_no'];
                $return['charge_amount']		 = $row['charge_amount'];
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

    function import_sss_data(){
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
            // print_r ($getfile);

            PAYROLL::getInstance()->delete_sss_loan_data();    

            while (($data = fgetcsv($getfile, 10000, ",")) !== FALSE) {
                PAYROLL::getInstance()->insert_sss_loan_data($data);
                // print_r( $data);
            }
        }
        // return;
        $return['result'] = 1;
        echo json_encode($return);
    }

    function import_sss_premium(){
        session_start();
        date_default_timezone_set('Asia/Manila');
        require_once('../class/payroll_oop.php'); 
        $input_file_name = $_FILES['file']['tmp_name'];
        $return = $_POST;
        $ctr = 0;
        $dateToday = date("m-d-Y h:i:s");
        if (($getfile = fopen($input_file_name, "r")) !== FALSE) { //OPEN FILE 
            $data = fgetcsv($getfile, 10000, ",");

            PAYROLL::getInstance()->delete_sss_premium_data();
            
            while (($data = fgetcsv($getfile, 10000, ",")) !== FALSE) {
                PAYROLL::getInstance()->insert_sss_premium_data($data,$_SESSION['username'],$dateToday);
            }
        }
        $return['result'] = 1;
        echo json_encode($return);
    }

    function import_sss_calamity_loan(){
        session_start();
        date_default_timezone_set('Asia/Manila');
        require_once('../class/payroll_oop.php'); 
        $input_file_name = $_FILES['file']['tmp_name'];
        $return = $_POST;
        $ctr = 0;
        $dateToday = date("m-d-Y h:i:s");
        if (($getfile = fopen($input_file_name, "r")) !== FALSE) { //OPEN FILE 
            $data = fgetcsv($getfile, 10000, ",");

            PAYROLL::getInstance()->delete_sss_calamity_loan_data();
            
            while (($data = fgetcsv($getfile, 10000, ",")) !== FALSE) {
                PAYROLL::getInstance()->insert_sss_calamity_loan_data($data);
            }
        }
        $return['result'] = 1;
        echo json_encode($return);
    }

    function this_is_employee_num_existed($emp_no,$table_name){
        try{
            require_once('../class/payroll_oop.php'); 
            $result 			= '';
            $array_fields 		= array('*');
            $table 	   			= "{$table_name}";
            $joins				= '';
            $sql_where			= "WHERE emp_num = '{$emp_no}' AND logdel = 0";
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
    
    function save_sss_calamity_loan(){
        try{
            require_once('../class/payroll_oop.php'); 
            $request = $_POST;
            if($request['data_id'] == null){
                $table = "tbl_sss_calamity_loan";
                $is_employee_no_existed = this_is_employee_num_existed($request['txt_emp_no'],$table);
                if($is_employee_no_existed == 0){
                    $array_fields = array('emp_num',"sss_no","charge_amount");
                    $array_values = array($request['txt_emp_no'],$request["txt_sss_no"],$request["int_amount"]);
                    $result = PAYROLL::getInstance()->insert_query($table,$array_fields,$array_values);
                    // $result = PAYROLL::getInstance()->insert_query_script($table,$array_fields,$array_values);
                    // echo json_encode($result);
                    // return;
                    $return['result'] = 'success';
                }else{
                    $return['result'] = 'This employee number is already existed';
                }
                echo json_encode($return);
                return;
            }else{
                // echo json_encode('return');
                // return;
                $pkid  = $request['data_id'];
                $table = "tbl_sss_calamity_loan";
                $array_fields = array('employee_no',"hmo_amount","lastupdate");
                $array_fields = array('emp_num',"sss_no","charge_amount");
                $array_values = array($request['txt_emp_no'],$request["txt_sss_no"],$request["int_amount"]);
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

    function read_sss_calamity_loan(){
        try {
            require_once('../class/payroll_oop.php'); 
            $request 			= $_POST;
            $result 			= '';
            $pkid 				= $request['pkid'];
            $array_fields 		= array('*');
            $table 	   			= 'tbl_sss_calamity_loan';
            $joins				= '';
            $sql_where			= 'WHERE id = "'.$pkid.'"';
            $sql_order	 		= '';
            $sql_limit 			= "";
            $result 			= PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
            // $result 			= PAYROLL::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
            // echo json_encode($result);
            // return;
            while($row = mysqli_fetch_array($result)){			
                $return['pkid'] 			= $row['id'];
                $emp_no[] 		            = $row['emp_num'];
                $return['sss_no']		 = $row['sss_no'];
                $return['charge_amount']		 = $row['charge_amount'];
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

    /**
     * added by whyRainbowDoesntHaveBlack
     */
    function save_sss_condonation(){
        try{
            require_once('../class/payroll_oop.php'); 
            $request = $_POST;
            if($request['data_id'] == null){
                $table = "tbl_sss_condonation";
                $is_employee_no_existed = this_is_employee_num_existed($request['txt_emp_no'],$table);
                if($is_employee_no_existed == 0){
                    $array_fields = array('emp_num',"sss_no","charge_amount");
                    $array_values = array($request['txt_emp_no'],$request["txt_sss_no"],$request["int_amount"]);
                    $result = PAYROLL::getInstance()->insert_query($table,$array_fields,$array_values);
                    // $result = PAYROLL::getInstance()->insert_query_script($table,$array_fields,$array_values);
                    // echo json_encode($result);
                    // return;
                    $return['result'] = 'success';
                }else{
                    $return['result'] = 'This employee number is already existed';
                }
                echo json_encode($return);
                return;
            }else{
                // echo json_encode('return');
                // return;
                $pkid  = $request['data_id'];
                $table = "tbl_sss_condonation";
                $array_fields = array('employee_no',"hmo_amount","lastupdate");
                $array_fields = array('emp_num',"sss_no","charge_amount");
                $array_values = array($request['txt_emp_no'],$request["txt_sss_no"],$request["int_amount"]);
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

    /**
     * added by whyRainbowDoesntHaveBlack
     */
    function read_sss_condonation(){
        try {
            require_once('../class/payroll_oop.php'); 
            $request 			= $_POST;
            $result 			= '';
            $pkid 				= $request['pkid'];
            $array_fields 		= array('*');
            $table 	   			= 'tbl_sss_condonation';
            $joins				= '';
            $sql_where			= 'WHERE id = "'.$pkid.'"';
            $sql_order	 		= '';
            $sql_limit 			= "";
            $result 			= PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
            // $result 			= PAYROLL::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
            // echo json_encode($result);
            // return;
            while($row = mysqli_fetch_array($result)){			
                $return['pkid'] 			= $row['id'];
                $emp_no[] 		            = $row['emp_num'];
                $return['sss_no']		 = $row['sss_no'];
                $return['charge_amount']		 = $row['charge_amount'];
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

    /**
     * added by whyRainbowDoesntHaveBlack
     */
    function import_sss_condonation(){
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
            // print_r ($getfile);

            PAYROLL::getInstance()->delete_sss_condonation_data();    

            while (($data = fgetcsv($getfile, 10000, ",")) !== FALSE) {
                PAYROLL::getInstance()->insert_sss_condonation_data($data);
                // print_r( $data);
            }
        }
        // return;
        $return['result'] = 1;
        echo json_encode($return);
    }
?>