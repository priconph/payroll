<?php
	/**
	 * Get my IP Address
	 */
	$userIp = isset($_SERVER['HTTP_CLIENT_IP']) 
		? $_SERVER['HTTP_CLIENT_IP'] 
		: (isset($_SERVER['HTTP_X_FORWARDED_FOR']) 
			? $_SERVER['HTTP_X_FORWARDED_FOR'] 
			: $_SERVER['REMOTE_ADDR']);

	/**
	 * Add IP Address as much as you want to 
	 * allow user to have an access on the page
	 */
	$allowedIp = array(
		'192.168.22.103', // Nessa
		'192.168.23.210', // Janella
		'192.168.23.183', // Lina
		'192.168.22.105', // Chris
		'192.168.23.252', // da
	);

	/**
	 * This will only run if the current IP Address($userIp) 
	 * is not listed on the Allowed IP Address($allowedIp)
	 */
	if(!in_array($userIp, $allowedIp)){
		echo "<script>alert('Warning! You're not allowed to view this page!');</script>";
		echo "<script>history.back()</script>";
	}

if( isset($_GET['page']) ){
	$page = $_GET['page'];
	/* changes here must also be applied in handler fn_get_page() */
	switch($page){
		case "dashboard" 		: $page_link = 'pages/dashboard/index.php'; break;
		case "eom" 				: $page_link = 'pages/eom/index.php'; break;
		case "hmo" 				: $page_link = 'pages/hmo/hmo_index.php'; break;
		case "sss" 				: $page_link = 'pages/sss/index.php'; break;
		case "philhealth" 		: $page_link = 'pages/philhealth/index.php'; break;
		case "payroll_info"		: $page_link = 'pages/payroll_info/index.php'; break;
		case "taxes"			: $page_link = 'pages/taxes/index.php'; break;
		case "payroll_reports"	: $page_link = 'pages/reports/index.php'; break;
		case "workingdays"		: $page_link = 'pages/workingdays/index.php'; break;
		case "leaves"			: $page_link = 'pages/leaves/index.php'; break;
		case "pagibig"			: $page_link = 'pages/pagibig/index.php'; break;
		case "configuration"	: $page_link = 'pages/configuration/index.php'; break;

		default 				: $page_link = 'pages/redirect_page/index.php';
	}

	$selected_menu = $page;
	include($page_link);
}else{
	$page_link 		= 'pages/dashboard/index.php';
	$selected_menu 	= 'dashboard';
	include($page_link);
}

?>
