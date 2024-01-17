    
    <?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

    session_start();
    if(is_ajax()) {
		if(isset($_POST["action"]) && !empty($_POST["action"])) {
			$action = $_POST["action"];
			switch($action) {
				/* Payroll Info */
                case 'create_payroll_info'					: create_payroll_info(); 		break;
				case 'read_payroll_info'					: read_payroll_info(); 			break;
				case 'update_payroll_info'					: update_payroll_info(); 		break;
				case 'get_payroll_details'					: get_payroll_details(); 		break;
				/* Taxes */
				case 'create_taxes'							: create_taxes(); 				break;
				case 'read_taxes_info'						: read_taxes_info(); 			break;
				case 'update_taxes'							: update_taxes(); 				break;
				case 'import_taxes_data'					: import_taxes_data(); 			break;
				/* Working Days */
				case 'add_working_days'						: add_working_days(); 			break;
				case 'get_working_days_id'					: get_working_days_id(); 		break;
				case 'update_working_days'					: update_working_days(); 		break;
				/* Salary Report */
				case "import_salary_report_data"			: import_salary_report_data(); 	break;
				case "create_salary_report"					: create_salary_report(); 		break;
				case "read_salary_report"					: read_salary_report(); 		break;
				/* Payroll Details */
				case "save_payroll_details"					: save_payroll_details(); 		break;

			}
		}
	}

	function is_ajax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}

    function create_payroll_info(){
        // echo 'true';
        // return;
		try{
            require_once('../class/payroll_oop.php'); 
			$request = $_POST;
			$table = "tbl_payroll_info";
			$array_fields = array('created_by',"description","cut_off","date_start","date_end","date_cut_off","posted","created_at","updated_at");
			$array_values = array($_SESSION['username'],$request["slct_description"],$request["slct_cut_off"],$request["dt_start_date"],
									$request["dt_end_date"],$request["dt_cut_off_date"],$request["slct_posted"],date('Y-m-d H:m:s'),date('Y-m-d H:m:s')
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

    function read_payroll_info(){
		try{
            require_once('../class/payroll_oop.php'); 
			$request 			= $_POST;
			$result 			= '';
			$pkid 				= $request['pkid'];
			$array_fields 		= array('*');
			$table 	   			= 'tbl_payroll_info';
			$joins				= '';
			$sql_where			= 'WHERE id = "'.$pkid.'"';
			$sql_order	 		= 'ORDER BY id DESC';
			$sql_limit 			= "";
			$result 			= PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			$ctr 				= 0;		
			// write_logs::getInstance()->save_logs('1',$query);
			while($row = mysqli_fetch_array($result)){			
				$return['Pkid'][$ctr] 				= $row['id'];
				$return['Description'][$ctr] 		= $row['description'];
				$return['CutOff'][$ctr] 			= $row['cut_off'];
				$return['StartingDate'][$ctr]		= $row['date_start'];
				$return['EndingDate'][$ctr] 		= $row['date_end'];
				$return['CutOffDate'][$ctr] 		= $row['date_cut_off'];
				$return['Posted'][$ctr] 			= $row['posted'];
				$return['Lastupdate'][$ctr]			= date('M d, Y h:i:s A',strtotime($row['updated_at']));
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

	function update_payroll_info(){
		try{
            require_once('../class/payroll_oop.php'); 
			$request 	= $_POST;
			$pkid 		= $request['data_id'];
			$table = "tbl_payroll_info";

			$array_fields = array('created_by',"description","cut_off","date_start","date_end","date_cut_off","posted","updated_at",);
			$array_values = array($_SESSION['username'],$request["slct_description"],$request["slct_cut_off"],$request["dt_start_date"],
									$request["dt_end_date"],$request["dt_cut_off_date"],$request["slct_posted"],date('Y-m-d H:m:s'),
							);
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

 	function get_payroll_details(){
		try{
            require_once('../class/payroll_oop.php');
			$request 			= $_POST;
			$result 			= '';

			$salary_type 		= $request['salary_type'];
			$array_fields 		= array('*');
			$table 	   			= 'vw_EmployeeInfo';
			$joins				= '';
			$sql_where			= 'WHERE EmpStatus = "1" AND SalaryType  = "'.$salary_type.'"';
			$sql_order	 		= 'ORDER BY EmpNo ASC';
			$sql_limit 			= "";
			$result 			= HRIS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			$ctr 				= 0;		
			while($row = mysqli_fetch_array($result)){			
				$return['pkid'][$ctr] 				= $row['pkid'];
				$return['EmpNo'][$ctr] 				= $row['EmpNo'];
				$return['fullname'][$ctr] 			= $row['fullname'];
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

	/*function create_taxes(){
		require_once('../class/payroll_oop.php');
		$request 	= $_POST;
		try{
            require_once('../class/payroll_oop.php'); 
			$request = $_POST;
			$table = "tbl_taxes";
			$array_fields = array('updated_by',"emp_no","salary_adjustments","other_earnings","advances_other_deductions","tax_adjustments","created_at","updated_at");
			$array_values = array($_SESSION['username'],$request['txt_emp_no'],$request["txt_salary_adjustments"],$request["txt_other_earnings"],$request["txt_ad_deduc"],
									$request["txt_tax_adjustment"],date('Y-m-d H:m:s'),date('Y-m-d H:m:s'));
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
			$array_fields = array(	"updated_by","emp_no","salary_adjustments","other_earnings"
									,"advances_other_deductions","tax_adjustments","updated_at"
							);
			$array_values = array(	$_SESSION['username'],$request['txt_emp_no'],$request["txt_salary_adjustments"],$request["txt_other_earnings"],$request["txt_ad_deduc"]
									,$request["txt_tax_adjustment"],date('Y-m-d H:m:s')
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
				
				$result = PAYROLL::getInstance()->insert_taxes_import($data,$_SESSION['username'],$dateToday);
			}
		}
		echo json_encode($result);
	}*/

	function add_working_days(){
		require_once('../class/payroll_oop.php');
		$request 	= $_POST;
		try{
            require_once('../class/payroll_oop.php'); 
			$request = $_POST;
			$table = "tbl_working_days";

			$array_fields = array('working_days',"created_at","created_by");
			$array_values = array($request["number_of_working_days"],date('Y-m-d H:m:s'),$_SESSION['username']);
			$result = PAYROLL::getInstance()->insert_query($table,$array_fields,$array_values);

			$return['result'] = 'success';
			echo json_encode($return);
		}catch(Exception $err){
			$error['error_message'] =  $err;
			$error['has_error'] =  'Exception Error';
			echo json_encode($error);
		}
	}

	function get_working_days_id(){
		try{
            require_once('../class/payroll_oop.php'); 
			$request 			= $_POST;
			$result 			= '';
			$pkid 				= $request['pkid'];
			$array_fields 		= array('*');
			$table 	   			= 'tbl_working_days';
			$joins				= '';
			$sql_where			= 'WHERE id = "'.$pkid.'"';
			$sql_order	 		= 'ORDER BY id DESC';
			$sql_limit 			= "";
			$result 			= PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			$ctr 				= 0;	
			// write_logs::getInstance()->save_logs('1',$query);
			while($row = mysqli_fetch_array($result)){			
				$return['Pkid'][$ctr] 						= $row['id'];
				$return['working_days'][$ctr] 					= $row['working_days'];
				
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

	function update_working_days(){
		// echo json_encode('true');;
		// return;
		try{
            require_once('../class/payroll_oop.php'); 
			$request 	= $_POST;
			$pkid 		= $request['working_days_id'];
			$table = "tbl_working_days";
			$array_fields = array(	'working_days',"updated_at","updated_by");
			$array_values = array(	$request["edit_number_of_working_days"],date('Y-m-d H:m:s'),$_SESSION['username']);
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

	function import_salary_report_data(){
		date_default_timezone_set('Asia/Manila');
		// session_start();
		require_once('../class/payroll_oop.php'); 
		$input_file_name = $_FILES['file']['tmp_name'];
		$return = $_POST;
		$ctr = 0;
		// $dateTayo = date("m-d-Y h:i:s");
		if (($get_record = fopen($input_file_name, "r")) !== FALSE) { //OPEN FILE 
			$salaryReportData = fgetcsv($get_record, 10000, ",");
			PAYROLL::getInstance()->delete_salary_report_record();
			
			while (($salaryReportData = fgetcsv($get_record, 10000, ",")) !== FALSE) {
				// PAYROLL::getInstance()->insert_salary_report_record($dataTayo,$_SESSION['username'],$dateTayo);
				PAYROLL::getInstance()->insert_salary_report_record($salaryReportData);
			}
		}
		$return['result'] = 1;
		echo json_encode($return);
	}

	function save_payroll_details(){
		require_once('../class/payroll_oop.php');

		$return			= $_POST;
		$result			= '';
		$table			= 'tbl_payroll_info_data_test';
		$array_fields 	= array('fkid_payroll_info, 
								employee_no, 
								employee_name, 
								regular_pay, 
								thirteenth_month



								');
		$array_values 	= array($return['fkid_payroll_info'], 
								$return['employee_no'], 
								$return['employee_name'], 
								$return['regular_pay'],
								$return['thirteenth_month']




							);	

								// ot1, 
								// ot1_amount, 
								// ot2, 
								// ot2_amount, 
								// ot2a, 
								// ot2a_amount, 
								// ot3, 
								// ot3_amount, 
								// ot3a, 
								// ot3a_amount, 
								// ot4, 
								// ot4_amount, 
								// ot4a, 
								// ot4a_amount, 
								// ot5, 
								// ot5_amount,
								// ot5a,
								// ot5a_amount,
								// ot6,
								// ot6_amount,
								// ot6a,
								// ot6a_amount

								// $return['ot1'],
								// $return['ot1_amount'],
								// $return['ot2'],
								// $return['ot2_amount'],
								// $return['ot2a'],
								// $return['ot2a_amount'],
								// $return['ot3'],
								// $return['ot3_amount'],
								// $return['ot3a'],
								// $return['ot3a_amount'],
								// $return['ot4'],
								// $return['ot4_amount'],
								// $return['ot4a'],
								// $return['ot4a_amount'],
								// $return['ot5'],
								// $return['ot5_amount'],
								// $return['ot5a'],
								// $return['ot5a_amount'],
								// $return['ot6'],
								// $return['ot6_amount'],
								// $return['ot6a'],
								// $return['ot6a_amount']

	
		$result = PAYROLL::getInstance()->insert_query($table,$array_fields,$array_values);
							
		$return['result'] = json_encode($result);
		echo json_encode($return);
		
	}
	/*
	CRUD Salary Report
	*/
	function create_salary_report(){
		try{
			require_once('../class/payroll_oop.php'); 
			$request = $_POST;
			if($request['data_id'] == null){
				$table = "tbl_salary_report";
				$is_employee_no_existed = this_is_employee_num_existed($request['txt_emp_no']);
				if($is_employee_no_existed == 0){
					$array_fields = array('employee_no',"personal_exemption","basic_salary","ecola","ctpa","socio_eco_allow","allowance");
					$array_values = array(	$request['txt_emp_no'],$request['txt_personal_exempt'],$request["int_basic_sal"],
											$request['int_ecola'],$request["int_ctpa"],$request['int_socio_eco'],$request["int_allowance"]
									);
					$result = PAYROLL::getInstance()->insert_query($table,$array_fields,$array_values);
					$return['result'] = 'success';
				}else{
					$return['result'] = 'This employee number is already existed';
				}
				echo json_encode($return);
				return;
			}else{
				$pkid  = $request['data_id'];
				$table = "tbl_salary_report";
				$array_fields = array('employee_no',"personal_exemption","basic_salary","ecola","ctpa","socio_eco_allow","allowance");
				$array_values = array(	$request['txt_emp_no'],$request['txt_personal_exempt'],$request["int_basic_sal"],
											$request['int_ecola'],$request["int_ctpa"],$request['int_socio_eco'],$request["int_allowance"]
								);
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

	function this_is_employee_num_existed($emp_no){
		try{
			require_once('../class/payroll_oop.php'); 
			$result 			= '';
			$array_fields 		= array('*');
			$table 	   			= 'tbl_salary_report';
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
	
	function read_salary_report(){
		try {
			require_once('../class/payroll_oop.php'); 
			$request 			= $_POST;
			$result 			= '';
			$pkid 				= $request['pkid'];
			$array_fields 		= array('*');
			$table 	   			= 'tbl_salary_report';
			$joins				= '';
			$sql_where			= 'WHERE id = "'.$pkid.'" AND `logdel` = 0';
			$sql_order	 		= '';
			$sql_limit 			= "";
			$result 			= PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			// $result 			= PAYROLL::getInstance()->select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
			while($row = mysqli_fetch_array($result)){			
				$return['pkid'] 					= $row['id'];
				$emp_no[] 		            		= $row['employee_no'];
				$return['personal_exemption']		= $row['personal_exemption'];
				$return['basic_salary']				= $row['basic_salary'];
				$return['ecola']					= $row['ecola'];
				$return['ctpa']						= $row['ctpa'];
				$return['socio_eco_allow']			= $row['socio_eco_allow'];
				$return['allowance']				= $row['allowance'];
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