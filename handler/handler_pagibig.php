    
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if(is_ajax()) {
	if(isset($_POST["action"]) && !empty($_POST["action"])) {
		$action = $_POST["action"];
		switch($action) {
			/* Pagibig Loan */
			case 'create_pagibig_loan'						: create_pagibig_loan(); 							break;
			case 'read_pagibig_loan'						: read_pagibig_loan(); 								break;
			case 'set_paid'						            : set_paid(); 								        break;
			case 'read_pagibig_loan_details'                : read_pagibig_loan_details(); 						break;
			case 'update_pagibig_loan'						: update_pagibig_loan(); 							break;
			case 'import_pagibig_loan_data'					: import_pagibig_loan_data(); 						break;
		}
	}
}

function is_ajax() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}
/* Pagibig Loan */
function create_pagibig_loan(){
    try{
        require_once('../class/payroll_oop.php'); 
        $request = $_POST;
        $table = "tbl_pagibig_loan";
        $pkid 		= $request['data_id'];
        // print_r($request['scheduleOfPaymentArray']);
        // exit();

        // Insert
        if($pkid == ''){
            /**
             * Pagibig Loan
             */
            $array_fields = array(
                'emp_no',
                "loan_amount",
                "calamity_loan_amount",
                "loan_code",
                "principal_amount",
                "interest_rate",
                "months_to_pay",
                "frequency",
                "start_date"
            );
            $array_values = array(
                $request["txt_emp_no"],
                $request["int_loan_amount"],
                $request["int_calamity_loan_amount"],
                $request["loan_code"],
                $request["principal_amount"],
                $request["interest_rate"],
                $request["months_to_pay"],
                $request["frequency"],
                $request["start_date"],
            );
            $result = PAYROLL::getInstance()->insert_query($table,$array_fields,$array_values);
            $lastInsertedId = $result;
            
            /**
             * Pagibig Loan Details
             */
            $tablePagibigLoanDetails = "tbl_pagibig_loan_details";
            $columnPagibigLoanDetails = array(
                'fkid_pagibig_loan',
                "date_paid",
                "schedule_of_payment",
                "principal",
                "interest",
                "balance",
                "hold_payment",
            );

            for ($i=0; $i < count($request['scheduleOfPaymentArray']); $i++) {
                $valuesPagibigLoanDetails = array(
                    $lastInsertedId,
                    $request['scheduleOfPaymentArray'][$i]['date_paid'],
                    $request['scheduleOfPaymentArray'][$i]['schedule_of_payment'],
                    $request['scheduleOfPaymentArray'][$i]['principal'],
                    $request['scheduleOfPaymentArray'][$i]['interest'],
                    $request['scheduleOfPaymentArray'][$i]['balance'],
                    $request['scheduleOfPaymentArray'][$i]['hold_payment'],
                );
                $resultPagibigLoanDetails = PAYROLL::getInstance()->insert_query($tablePagibigLoanDetails,$columnPagibigLoanDetails,$valuesPagibigLoanDetails);
            }
            
            $return['result'] = 'success';
            echo json_encode($return);
        }else{ // Update
            $array_fields = array(
                'emp_no',
                "loan_amount",
                "calamity_loan_amount",
                "loan_code",
                "principal_amount",
                "interest_rate",
                "months_to_pay",
                "frequency",
                "start_date"
            );
            $array_values = array(
                $request["txt_emp_no"],
                $request["int_loan_amount"],
                $request["int_calamity_loan_amount"],
                $request["loan_code"],
                $request["principal_amount"],
                $request["interest_rate"],
                $request["months_to_pay"],
                $request["frequency"],
                $request["start_date"],
            );
            $result = PAYROLL::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
            
            /**
             * Pagibig Loan Details
             */
            $tablePagibigLoanDetails = "tbl_pagibig_loan_details";
            $delete = PAYROLL::getInstance()->delete_where_query($tablePagibigLoanDetails, $pkid); // Delete before inserting new one
            $columnPagibigLoanDetails = array(
                'fkid_pagibig_loan',
                "date_paid",
                "schedule_of_payment",
                "principal",
                "interest",
                "balance",
                "hold_payment",
            );

            for ($i=0; $i < count($request['scheduleOfPaymentArray']); $i++) {
                $valuesPagibigLoanDetails = array(
                    $pkid,
                    $request['scheduleOfPaymentArray'][$i]['date_paid'],
                    $request['scheduleOfPaymentArray'][$i]['schedule_of_payment'],
                    $request['scheduleOfPaymentArray'][$i]['principal'],
                    $request['scheduleOfPaymentArray'][$i]['interest'],
                    $request['scheduleOfPaymentArray'][$i]['balance'],
                    $request['scheduleOfPaymentArray'][$i]['hold_payment'],
                );
                $resultPagibigLoanDetails = PAYROLL::getInstance()->insert_query($tablePagibigLoanDetails,$columnPagibigLoanDetails,$valuesPagibigLoanDetails);
            }
            $return['result'] = 'updated';
            echo json_encode($return);
        }
        
    }catch(Exception $err){
        $error['error_message'] =  $err;
        $error['has_error'] =  'Exception Error';
        echo json_encode($error);
    }
}

function read_pagibig_loan(){
    // echo 'true';
    try{
        require_once('../class/payroll_oop.php'); 
        $request 			= $_POST;
        $result 			= '';
        $pkid 				= $request['pkid'];
        $array_fields 		= array('*');
        $table 	   			= 'tbl_pagibig_loan';
        $joins				= '';
        $sql_where			= 'WHERE id = "'.$pkid.'"';
        $sql_order	 		= 'ORDER BY id DESC';
        $sql_limit 			= "";
        $result 			= PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        // echo $result 			= PAYROLL::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        // return;
        $ctr 				= 0;	
        while($row = mysqli_fetch_array($result)){			
            $return['id'][$ctr] 				        = $row['id'];
            $emp_no[] 		                            = $row['emp_no'];
            $return['loan_amount'][$ctr] 		        = $row['loan_amount'];
            $return['calamity_loan_amount'][$ctr]		= $row['calamity_loan_amount'];
            $return['loan_code'][$ctr]		            = $row['loan_code'];
            $return['principal_amount'][$ctr]		    = $row['principal_amount'];
            $return['interest_rate'][$ctr]		        = $row['interest_rate'];
            $return['months_to_pay'][$ctr]		        = $row['months_to_pay'];
            $return['frequency'][$ctr]		            = $row['frequency'];
            $return['start_date'][$ctr]		            = $row['start_date'];
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

        /**
         * Pagibig Loan Details
         * no need because after fetching Pagibig Loan
         * the data is automatically generated for Pagibig Loan Details
         */
        // $tablePagibigLoanDetails    = 'tbl_pagibig_loan_details';
        // $columnPagibigLoanDetails   = array('*');
        // $joinsPagibigLoanDetails    = '';
        // $wherePagibigLoanDetails    = 'WHERE fkid_pagibig_loan = "'.$pkid.'"';
        // $orderPagibigLoanDetails    = '';
        // $limitPagibigLoanDetails    = "";
        // $resultPagibigLoanDetails   = PAYROLL::getInstance()->select_all_query($columnPagibigLoanDetails,$tablePagibigLoanDetails,$joinsPagibigLoanDetails,$wherePagibigLoanDetails,$orderPagibigLoanDetails,$limitPagibigLoanDetails);

        // $scheduleOfPaymentArray = array();
        // while($rowPagibigLoanDetails = mysqli_fetch_array($resultPagibigLoanDetails)){
        //     $tempoArray = array(
        //         'date_paid'             => $rowPagibigLoanDetails['date_paid'],
        //         'schedule_of_payment'   => $rowPagibigLoanDetails['schedule_of_payment'],
        //         'principal'             => $rowPagibigLoanDetails['principal'],
        //         'interest'              => $rowPagibigLoanDetails['interest'],
        //         'balance'               => $rowPagibigLoanDetails['balance'],
        //         'hold_payment'          => $rowPagibigLoanDetails['hold_payment'],
        //     );
        //     array_push($scheduleOfPaymentArray, $tempoArray);
        // }
        // $return['scheduleOfPaymentArray'] = $scheduleOfPaymentArray;
    }catch(Exception $err){
        $error['error_message'] =  $err;
        $error['has_error'] =  'Exception Error';
        echo json_encode($error);
    }
}
function set_paid(){
    // echo 'true';
    try{
        require_once('../class/payroll_oop.php'); 
        $request 			= $_POST;
        $result 			= '';
        $pkid 				= $request['pkid'];
        $array_fields 		= array('is_payment_completed');
        $array_values = array(
            1,
        );
        $table 	   			= 'tbl_pagibig_loan';
        $joins				= '';
        $sql_where			= 'WHERE id = "'.$pkid.'"';
        $sql_order	 		= '';
        $sql_limit 			= "";
        $result 			= PAYROLL::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
        $return['result']   = 'updated';
        echo json_encode($return);
    }catch(Exception $err){
        $error['error_message'] =  $err;
        $error['has_error'] =  'Exception Error';
        echo json_encode($error);
    }
}
function read_pagibig_loan_details(){
    // echo 'true';
    try{
        require_once('../class/payroll_oop.php'); 
        $request 			= $_POST;
        $result 			= '';
        $pkid 				= $request['pkid'];
        /**
         * Pagibig Loan Details
         * no need because after fetching Pagibig Loan
         * the data is automatically generated for Pagibig Loan Details
         */
        $tablePagibigLoanDetails    = 'tbl_pagibig_loan_details';
        $columnPagibigLoanDetails   = array('*');
        $joinsPagibigLoanDetails    = '';
        $wherePagibigLoanDetails    = 'WHERE fkid_pagibig_loan = "'.$pkid.'"';
        $orderPagibigLoanDetails    = '';
        $limitPagibigLoanDetails    = "";
        $resultPagibigLoanDetails   = PAYROLL::getInstance()->select_all_query($columnPagibigLoanDetails,$tablePagibigLoanDetails,$joinsPagibigLoanDetails,$wherePagibigLoanDetails,$orderPagibigLoanDetails,$limitPagibigLoanDetails);

        $scheduleOfPaymentArray = array();
        while($rowPagibigLoanDetails = mysqli_fetch_array($resultPagibigLoanDetails)){
            $tempoArray = array(
                'date_paid'             => $rowPagibigLoanDetails['date_paid'],
                'schedule_of_payment'   => $rowPagibigLoanDetails['schedule_of_payment'],
                'principal'             => $rowPagibigLoanDetails['principal'],
                'interest'              => $rowPagibigLoanDetails['interest'],
                'balance'               => $rowPagibigLoanDetails['balance'],
                'hold_payment'          => $rowPagibigLoanDetails['hold_payment'],
            );
            array_push($scheduleOfPaymentArray, $tempoArray);
        }
        $return['scheduleOfPaymentArray'] = $scheduleOfPaymentArray;
        echo json_encode($return);
    }catch(Exception $err){
        $error['error_message'] =  $err;
        $error['has_error'] =  'Exception Error';
        echo json_encode($error);
    }
}
function update_pagibig_loan(){
    // echo 'true';
    // return;
    try{
        require_once('../class/payroll_oop.php'); 
        $request 	= $_POST;
        $pkid 		= $request['data_id'];
        $table = "tbl_pagibig_loan";

        $array_fields = array(
            'emp_no',
            "loan_amount",
            "calamity_loan_amount",
            "loan_code",
            "principal_amount",
            "interest_rate",
            "months_to_pay",
            "frequency",
            "start_date"
        );
        $array_values = array(
            $request["txt_emp_no"],
            $request["int_loan_amount"],
            $request["int_calamity_loan_amount"],
            $request["loan_code"],
            $request["principal_amount"],
            $request["interest_rate"],
            $request["months_to_pay"],
            $request["frequency"],
            $request["start_date"],
        );
        $result = PAYROLL::getInstance()->update_query($table,$array_fields,$array_values,$pkid);
        // $result = PAYROLL::getInstance()->update_query_script($table,$array_fields,$array_values,$pkid);
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
function import_pagibig_loan_data(){
    try{
        require_once('../class/payroll_oop.php'); 
        $input_file_name = $_FILES['file']['tmp_name'];
        $return = $_POST;
        $dateToday = date("m-d-Y h:i:s");
        $ctr = 0;
        $table = "tbl_pagibig_loan";
        if (($getfile = fopen($input_file_name, "r")) !== FALSE) { //OPEN FILE 
            $data = fgetcsv($getfile, 10000, ",");
            if(count($data) == 3){
                /* delete first before add new info */
                $delete = PAYROLL::getInstance()->delete_query($table);
                while (($data = fgetcsv($getfile, 10000, ",")) !== FALSE) {
        
                    /* NOTE: this query accept logdel but not accept the id column because it sets as auto increment */
                    $result = PAYROLL::getInstance()->insert_pagibig_loan_import($data);
                }
                $return['result'] = 'success';
            }else{
                $return['result'] = "error";
                $return['error_msg'] = "The column is not aligned with the database";
                /* the tbl_pagibig_loan has a required 3 columns only */
            }
        }
        echo json_encode($return);
    }catch(Exception $err){
        $error['error_message'] =  $err;
        $error['has_error'] =  'Exception Error';
        echo json_encode($error);
    }
}

// function import_pagibig_loan_data(){
//     require_once('../class/payroll_oop.php'); 
// 	$input_file_name = $_FILES['file']['tmp_name'];
// 	$return = $_POST;
// 	$dateToday = date("m-d-Y h:i:s");
// 	$ctr = 0;
// 	$table = "tbl_pagibig_loan";

// 	if (($fp = fopen($input_file_name, "r")) !== FALSE) { 
//         $delete = PAYROLL::getInstance()->delete_query($table);
//         while (($record = fgetcsv($fp)) !== FALSE) {
//             $ctr++;
// 			$result = PAYROLL::getInstance()->insert_pagibig_loan_import($data);
//         }
//         echo json_encode($ctr);
//       }
// }