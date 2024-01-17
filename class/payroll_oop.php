<?php
class PAYROLL extends mysqli 
{
	private static $instance = null;
	
	public static function getInstance() {
		if(!self::$instance instanceof self) 
		{
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function __clone()
	{
		trigger_error('Clone is not allowed.',E_USER_ERROR);
	}
	
	public function __wakeup()
	{
		trigger_error('Deserializing is not allowed.',E_USER_ERROR);
	}
	
	private function __construct() {
		$path 		= '../';
		$db_config  = 'db_config/config_payroll.php';
		if(file_exists($path.$db_config)){
			include($path.$db_config);
		}else{
			$path = '../../';
			if(file_exists($path.$db_config)){
				include($path.$db_config);
			}else{
				$path = '../../../';
				if(file_exists($path.$db_config)){
					include($path.$db_config);
				}else{
					exit;
				}
				
			}
		}
		parent::__construct($server, $username, $password, $db_name);
		
		if(mysqli_connect_error())
		{
			exit('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}
		parent::set_charset('utf-8');
	}



	////////////////////////////////////UP TO HERE////////////////////////////////////////
	
	/*---------------PUBLIC FUNCTIONS STARTS HERE---------------- */

    /* Administrative */
    public function get_valid_ip($ip_address){
        $query = "SELECT `ip_address` FROM `tbl_valid_ip` WHERE `ip_address` = '$ip_address';";
        $result = $this->query($query);
        if($result->num_rows != 0){
            return true;
        }
        return false;
    }


    public function insert_imported_eom($data,$username,$date_today){
        $query = "INSERT INTO `tbl_eom`
        (id_number,
        emp_code,
        absences,
        undertime,
        night_diff,
        SL,
        VL,
        reg_ot,
        sun_special_hol_ot,
        sun_special_hol_ot_ex_8_hrs,
        sun_ot,
        sun_ot_ex_8_hrs,
        sun_legal_hol,
        sun_legal_hol_ex_8_hrs,
        special_non_work_hol,
        special_non_work_hol_ex_8_hrs,
        legal_hol,
        legal_hol_ex_8_hrs,
        adj_1,
        adj_2,
        created_by,
        created_at) 
        VALUES
        (
        '".ltrim($data[0],"0")."',
        '".$data[1]."',
        '".$data[2]."',
        '".$data[3]."',
        '".$data[4]."',
        '".$data[5]."',
        '".$data[6]."',
        '".$data[7]."',
        '".$data[8]."',
        '".$data[9]."',
        '".$data[10]."',
        '".$data[11]."',
        '".$data[12]."',
        '".$data[13]."',
        '".$data[14]."',
        '".$data[15]."',
        '".$data[16]."',
        '".$data[17]."',
        '".$data[18]."',
        '".$data[19]."',
        '".$username."',
        '".$date_today."'
        );";

		$this->query($query);
		return "New record has been saved";
    }

    public function delete_eom_record(){
        $this->query("DELETE FROM tbl_eom");
    }
    /* IMPORT TAXES */
    public function insert_taxes_import($data){
    $query = "INSERT INTO tbl_taxes (emp_no,salary_adjustments,other_earnings,advances_other_deductions,tax_adjustments) 
            VALUES (
                '".$data[0]."',
                '".$data[1]."',
                '".$data[2]."',
                '".$data[3]."',
                '".$data[4]."'
            );";
        /* if the field type is int/number, do not put a '' to the values */
		$this->query($query);
		return "New record has been saved";
    }

    /* IMPORT LEAVES */
    public function insert_leave_import($data){
        // return $data;
    $query = "INSERT INTO tbl_leaves (emp_no,leave_code,amount,cut_off) 
            VALUES (
                '".$data[0]."',
                '".$data[1]."',
                '".$data[2]."',
                '".$data[3]."'
            );";
        /* if the field type is int/number, do not put a '' to the values */
		$this->query($query);
		// return "New record has been saved";
    }

    public function insert_pagibig_loan_import($data){
    /* NOTE: this query accept logdel but not accept the id column because it sets as auto increment */
    $query = "INSERT INTO tbl_pagibig_loan (emp_no,loan_amount,calamity_loan_amount) 
            VALUES(
                '".$data[0]."',
                '".$data[1]."',
                '".$data[2]."'
            );";
        /* if the field type is int/number, do not put a '' to the values */
		$this->query($query);
		// return "New record has been saved";
    }
    public function delete_query($table){
        $this->query("DELETE FROM $table");
        return "Deleted Sucessfully";
    }
    public function delete_where_query($table, $pkid){
        $this->query("DELETE FROM $table WHERE fkid_pagibig_loan = $pkid");
        return "Deleted Sucessfully";
    }
    public function delete_query_script($table){
        // $this->query("DELETE FROM $table");
        return $query="DELETE FROM $table";
    }

    public function insert_hmo_record($dataTayo,$dateTayo){
        
        $insertHMOData = "INSERT INTO tbl_hmo (employee_no,hmo_amount) VALUES (
        '".$dataTayo[0]."',
        '".$dataTayo[1]."'
        );"; 
        // echo $insertHMOData;

        $this->query($insertHMOData);
		return "New record has been saved";
    }

    public function delete_hmo_record(){
        $this->query("DELETE FROM tbl_hmo");
    }

    public function insert_sss_loan_data($data){
        $insertSSSLoanData = "INSERT INTO tbl_sss_loans (emp_num,sss_no,charge_amount) VALUES (
        '".$data[0]."',
        '".$data[1]."',
        '".$data[2]."'
        );"; 
        // echo $insertSSSLoanData;

        $this->query($insertSSSLoanData);
		return "New record has been saved";
    }

    public function delete_sss_loan_data(){
        $this->query("DELETE FROM tbl_sss_loans");
    }

    public function insert_sss_premium_data($data,$username,$dateToday){
        $insertSSSPremiumData = "INSERT INTO tbl_sss_premium (emp_num,emp_name,charge_amount,emp_code,created_at,created_by) VALUES (
        '".$data[0]."',
        '".$data[1]."',
        '".$data[2]."',
        '".$data[3]."',
        '".$dateToday."',
        '".$username."'
        );"; 

        $this->query($insertSSSPremiumData);
		return "New record has been saved";
    }

    public function delete_sss_premium_data(){
        $this->query("DELETE FROM tbl_sss_premium");
    }

    public function insert_sss_calamity_loan_data($data){
        $insertSSSCalamityLoan = "INSERT INTO tbl_sss_calamity_loan (emp_num,sss_no,charge_amount) VALUES (
        '".$data[0]."',
        '".$data[1]."',
        '".$data[2]."'
        );"; 

        $this->query($insertSSSCalamityLoan);
		return "New record has been saved";
    }

    public function delete_sss_calamity_loan_data(){
        $this->query("DELETE FROM tbl_sss_calamity_loan");
    }

    public function insert_philhealth_import($data,$username,$dateToday){

        $query = "INSERT INTO `tbl_philhealth` (emp_no,emp_name,philhealth_amount,emp_code,created_by,created_at) VALUES
        (
            '".$data[0]."',
            '".$data[1]."',
            '".$data[2]."',
            '".$data[3]."',
            '".$username."',
            '".$dateToday."'
        );";

		$this->query($query);
		return "New record has been saved";
    }

    public function delete_philhealth_record(){
        $this->query("DELETE FROM tbl_philhealth");
    }

    public function insert_salary_report_record($salaryReportData){
        $insertSalaryReportData = "INSERT INTO tbl_salary_report (employee_no,basic_salary,ecola,ctpa,socio_eco_allow,allowance) VALUES (
        '".$salaryReportData[0]."',
        '".$salaryReportData[1]."',
        '".$salaryReportData[2]."',
        '".$salaryReportData[3]."',
        '".$salaryReportData[4]."',
        '".$salaryReportData[5]."'
        );"; 
        // echo $insertSalaryReportData;

        $this->query($insertSalaryReportData);
		return "New record has been saved";
    }

    public function delete_salary_report_record(){
        $this->query("DELETE FROM tbl_salary_report");
    }

    public function insert_query($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		$this->query($query);
		// $this->save_logs('1',$query);
		return $this->insert_id; // lastinsertid
	}

    public function insert_query_multiple($table,$array_fields,$array_values){
		$new_values = $this->add_quotations($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		$this->query($query);
		// $this->save_logs('1',$query);
		return "New record has been saved";
	}

    public function insert_query_script($table,$array_fields,$array_values){
        $new_values = $this->add_quotations($array_values); 
        $query      = "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
        // $this->query($query);
        return $query;
    }
    public function select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $this->query($query);
	}

    public function select_all_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "SELECT " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
        // return $query;
		return $this->query($query);
	}
    
    public function select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "<br>SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};<br>";
		return $query;
	}
    public function update_query($table,$array_fields,$array_values,$pkid){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE id='{$pkid}';";
		$this->query($query);
		// $this->save_logs('2',$query);
		return "Record has been updated";
	}
	
	public function update_query_script($table,$array_fields,$array_values,$pkid){
		$update_array =  $this->create_update_param($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE id='{$pkid}'; <br>";
		return $query;
	}
    public function add_quotations($array_values){
		$array_values_r = array();
		for($i=0;$i<count($array_values);$i++){
			if(isset($array_values[$i]) || $array_values[$i] != ''){
				$array_values[$i] = $this->real_escape_string($array_values[$i]);
				$array_values_r[$i] = "'".$array_values[$i]."'";
			}else{
				$array_values_r[$i] = '';
			}
		}
		return $array_values_r;
	}
    public function create_update_param($array_fields,$array_values){
		$array_update = array();
		for($i=0;$i<count($array_fields);$i++){
			$array_values[$i] = $this->real_escape_string($array_values[$i]);
			$array_update[$i] = "`".$array_fields[$i]."` = "."'".$array_values[$i]."' ";
		}
		return $array_update;
	}

}

class HRIS extends mysqli 
{
    private static $instance = null;
    
    public static function getInstance() {
        if(!self::$instance instanceof self) 
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __clone()
    {
        trigger_error('Clone is not allowed.',E_USER_ERROR);
    }
    
    public function __wakeup()
    {
        trigger_error('Deserializing is not allowed.',E_USER_ERROR);
    }
    
    private function __construct() {
        $path       = '../';
        $db_config  = 'db_config/config_systemone.php';
        if(file_exists($path.$db_config)){
            include($path.$db_config);
        }else{
            $path = '../../';
            if(file_exists($path.$db_config)){
                include($path.$db_config);
            }else{
                $path = '../../../';
                if(file_exists($path.$db_config)){
                    include($path.$db_config);
                }else{
                    exit;
                }
                
            }
        }
        parent::__construct($server, $username, $password, $db_name);
        
        if(mysqli_connect_error())
        {
            exit('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }



    ////////////////////////////////////UP TO HERE////////////////////////////////////////
    
    /*---------------PUBLIC FUNCTIONS STARTS HERE---------------- */

    public function delete_philhealth_record(){
        $this->query("DELETE FROM tbl_philhealth");
    }
    public function insert_query($table,$array_fields,$array_values){
        $new_values = $this->add_quotations($array_values); 
        $query      = "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
        $this->query($query);
        return "New record has been saved";
    }
    
    public function select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
        $query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
        return $this->query($query);
    }
    
    public function select_query_script($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
        $query = "<br>SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};<br>";
        return $query;
    }
    public function update_query($table,$array_fields,$array_values,$pkid){
        $update_array =  $this->create_update_param($array_fields,$array_values);
        $query        = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE id='{$pkid}';";
        $this->query($query);
        return "Record has been updated";
    }
    
    public function update_query_script($table,$array_fields,$array_values,$pkid){
        $update_array =  $this->create_update_param($array_fields,$array_values);
        $query        = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE id='{$pkid}'; <br>";
        return $query;
    }
    
    public function create_update_param($array_fields,$array_values){
        $array_update = array();
        for($i=0;$i<count($array_fields);$i++){
            $array_values[$i] = $this->real_escape_string($array_values[$i]);
            $array_update[$i] = "`".$array_fields[$i]."` = "."'".$array_values[$i]."' ";
        }
        return $array_update;
    }

}

?>