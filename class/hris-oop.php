<?php
class HRIS extends mysqli
{
	private static $instance = null;
	
	//db connection config variables
	private $user = "root";
	private $pass = "newd3v";
	private $dbName = "db_hris";
	private $dbHost = "192.168.3.240";

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
		parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
		if(mysqli_connect_error())
		{
			exit('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		}
		parent::set_charset('utf-8');
	}

	////////////////////////////////////PUBLIC FUNCTIONS STARTS HERE//////////////////////////////////////////////
	public function fetch_hris_info($EmpNo){
		$query = "SELECT * FROM `vw_EmpInfo_Rapid` WHERE `EmpNo`  = '$EmpNo';";
		return $this->query($query);
	}
	
	public function fetch_hris_info_subcon($EmpNo){
		$query = "SELECT * FROM db_subcon.`vw_subcon_all_employees` WHERE `EmpNo`  = '$EmpNo';";
		return $this->query($query);
	}

	/**
	 * For SSS & Calamity Loan and Labor Allocation Report
	 */
    public function select_all_division($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $this->query($query);
	}

    public function select_all_active_employee(){
		$query = "SELECT * FROM `tbl_EmployeeInfo` WHERE `EmpStatus` = 1 OR `EmpStatus` = 3";
		// $query = "SELECT * FROM `tbl_EmployeeInfo`";
		return $this->query($query);
	}

    public function select_all_active_employee_test($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $this->query($query);
	}

	public function active_user($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $this->query($query);
	}

	public function fetch_all_hris_info(){
		// $query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_limit};";
		
		// $query = "SELECT * FROM `vw_EmployeeInfo` WHERE `EmpStatus` = 1 OR `EmpStatus` = 3";
		$query = "SELECT * FROM `vw_EmployeeInfo`";
		// $query = "SELECT `vw_EmployeeInfo.EmpNo`, `tbl_payroll_info_data.employee_no` FROM vw_EmployeeInfo INNER JOIN `tbl_payroll_info_data` ON `vw_EmployeeInfo.EmpNo` = `tbl_payroll_info_data.employee_no`";
		return $this->query($query);
	}
	
	public function select_employee_info($array_fields,$table,$sql_where,$sql_limit){
		$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$sql_where} {$sql_limit};";
		return $this->query($query);
	}
}

class RAPID extends mysqli 
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

	/**
	 * For SSS & Calamity Loan and Labor Allocation Report
	 */
    public function select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $this->query($query);
	}
}
?>