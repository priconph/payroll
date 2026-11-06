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
    public function insert_query($table,$array_fields,$array_values){
		$new_values = $this->insert_data($array_values); 
		$query 		= "INSERT INTO {$table} (". implode(", ", $array_fields).") VALUES (". implode(",", $new_values) .");";
		$this->query($query);
		// $this->save_logs('1',$query);
		return $this->insert_id;
	}

    public function update_query($table,$array_fields,$array_values,$pkid){
		$update_array =  $this->update_data($array_fields,$array_values);
		$query 		  = "UPDATE {$table} SET ". implode(",", $update_array) ."WHERE pkid='{$pkid}';";
		$this->query($query);
		return "Record has been updated";
	}

    public function insert_data($array_values){
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

    public function update_data($array_fields,$array_values){
		$array_update = array();
		for($i=0;$i<count($array_fields);$i++){
			$array_values[$i] = $this->real_escape_string($array_values[$i]);
			$array_update[$i] = "`".$array_fields[$i]."` = "."'".$array_values[$i]."' ";
		}
		return $array_update;
	}

    public function select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit){
		$query = "SELECT SQL_CALC_FOUND_ROWS " . implode(", ", $array_fields) . " FROM {$table} {$joins} {$sql_where} {$sql_order} {$sql_limit};";
		return $this->query($query);
	}
}
?>