<?php

    $salary_type = $_GET['salary_type'];

	$aColumns = array( 
                'pkid',
                'EmpNo',
                'fullname'
				);
								
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* DB table to use */
    $sTable = "vw_EmployeeInfo";

	$database_config = '../../db_config/config_systemone.php';
	
	if(!file_exists($database_config)){
		echo "config file does not exist!";
		exit;
	} else {
		require_once($database_config);
	}
	
	/* Database connection information */
	$gaSql['user']       = $username;
	$gaSql['password']   = $password;
	$gaSql['db']         = $db_name;
	$gaSql['server']     = $server;
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * MySQL connection
	 */
	$gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
		die( 'Could not open connection to server' );
	
	mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
		die( 'Could not select database '. $gaSql['db'] );
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_GET['iDisplayLength'] );
	}
		
	/*
	 * Ordering
	 */
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	 
	 /* wag gagalawin yung sWhere default to para sa searchbox ng datatables check mo sa baba kung pano gagawin mo :) */
	$sWhere = "";
	if ( $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			// if( in_array($aColumns[$i],$array_search) ){
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
			// }
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
		
	if($sWhere == ""){
		$sWhere .= "WHERE  ";
	}else{
		$sWhere .= "AND ";
	}

    // $sWhere .= "EmpStatus=1 AND SalaryType <> 3 AND fkSection=406 AND SalaryType = '".$salary_type."'";
	$sWhere .= "EmpStatus=1 AND SalaryType <> 3 AND SalaryType = '".$salary_type."'";
	// $sWhere .= "EmpStatus=1 AND SalaryType <> 3 ";
	
	if($sOrder == ""){
		$sOrder = 'ORDER BY EmpNo ASC';
	}
	/*
	 * SQL queries
	 * Get data to display
	 */
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
	";
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	
	// echo "limit: ".$sLimit." : ".$sQuery."<hr>";
	$query_used = $sQuery;
	// echo $query_used."<br>";
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM   $sTable
	";
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);

    $tax_based = '';
    $emp_no = '';

	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		unset($row);
        
        $row[] = $aRow['EmpNo'];
        $row[] = $aRow['fullname'];
        
        $salary_temp_arr = get_salary( $aRow['EmpNo'] );
        if( $salary_temp_arr['ctr']>0 ){
            $aRow['basic_salary'] 		= $salary_temp_arr['basic_salary'][0]; 
            $aRow['ecola'] 				= $salary_temp_arr['ecola'][0]; 
            $aRow['ctpa'] 				= $salary_temp_arr['ctpa'][0]; 
            $aRow['socio_eco_allow'] 	= $salary_temp_arr['socio_eco_allow'][0]; 
            $aRow['allowance'] 			= $salary_temp_arr['allowance'][0]; 
        }
        
        $eom_temp_arr = get_eom( $aRow['EmpNo'] );
        if( $eom_temp_arr['ctr']>0 ){
            $aRow['id_number']                      = $eom_temp_arr['id_number'][0]; 
            $aRow['SL'] 							= $eom_temp_arr['SL'][0]; 
            $aRow['VL'] 							= $eom_temp_arr['VL'][0]; 
            $aRow['absences'] 						= $eom_temp_arr['absences'][0]; 
            $aRow['undertime'] 						= $eom_temp_arr['undertime'][0]; 
            $aRow['night_diff'] 					= $eom_temp_arr['night_diff'][0]; 
            $aRow['reg_ot'] 						= $eom_temp_arr['reg_ot'][0]; 
            $aRow['sun_special_hol_ot'] 			= $eom_temp_arr['sun_special_hol_ot'][0]; 
            $aRow['sun_special_hol_ot_ex_8_hrs'] 	= $eom_temp_arr['sun_special_hol_ot_ex_8_hrs'][0]; 
            $aRow['sun_ot'] 						= $eom_temp_arr['sun_ot'][0]; 
            $aRow['sun_ot_ex_8_hrs'] 				= $eom_temp_arr['sun_ot_ex_8_hrs'][0]; 
            $aRow['sun_legal_hol'] 					= $eom_temp_arr['sun_legal_hol'][0]; 
            $aRow['sun_legal_hol_ex_8_hrs'] 		= $eom_temp_arr['sun_legal_hol_ex_8_hrs'][0]; 
            $aRow['special_non_work_hol'] 			= $eom_temp_arr['special_non_work_hol'][0]; 
            $aRow['special_non_work_hol_ex_8_hrs'] 	= $eom_temp_arr['special_non_work_hol_ex_8_hrs'][0]; 
            $aRow['legal_hol'] 						= $eom_temp_arr['legal_hol'][0]; 
            $aRow['legal_hol_ex_8_hrs'] 			= $eom_temp_arr['legal_hol_ex_8_hrs'][0]; 
        }

        $adj_temp_arr = get_taxes( $aRow['EmpNo'] );
        if( $adj_temp_arr['ctr']>0 ){
            $aRow['salary_adjustments']       = $adj_temp_arr['salary_adjustments'][0]; 
            $aRow['other_earnings']           = $adj_temp_arr['other_earnings'][0]; 
            $aRow['advances_other_deductions']= $adj_temp_arr['advances_other_deductions'][0]; 
            $aRow['tax_adjustments']          = $adj_temp_arr['tax_adjustments'][0]; 
        }

        $sss_prem_temp_arr = get_sss_premiums( $aRow['EmpNo'] );
        if( $sss_prem_temp_arr['ctr']>0 ){
            $aRow['charge_amount']       = $sss_prem_temp_arr['charge_amount'][0]; 
        }

        $phil_prem_temp_arr = get_phil_premiums( $aRow['EmpNo'] );
        if( $phil_prem_temp_arr['ctr']>0 ){
            $aRow['philhealth_amount']       = $phil_prem_temp_arr['philhealth_amount'][0]; 
        }

        $sss_loans_temp_arr = get_sss_loans( $aRow['EmpNo'] );
        if( $sss_loans_temp_arr['ctr']>0 ){
            $aRow['charge_amount']       = $sss_loans_temp_arr['charge_amount'][0]; 
        }

        $sss_cal_loans_temp_arr = get_sss_cal_loans( $aRow['EmpNo'] );
        if( $sss_cal_loans_temp_arr['ctr']>0 ){
            $aRow['charge_amount']       = $sss_cal_loans_temp_arr['charge_amount'][0]; 
        }

        $hipar_temp_arr = get_hipar( $aRow['EmpNo'] );
        if( $hipar_temp_arr['ctr']>0 ){
            $aRow['hmo_amount']       = $hipar_temp_arr['hmo_amount'][0]; 
        }

        $annal_tax_temp_arr = get_annual_tax( $aRow['EmpNo'] );
        if( $annal_tax_temp_arr['ctr']>0 ){
            $aRow['gross_income_ytd']       = $annal_tax_temp_arr['gross_income_ytd'][0]; 
            $aRow['forecast_earnings']      = $annal_tax_temp_arr['forecast_earnings'][0]; 
            $aRow['less_ytd_tax_exempt']    = $annal_tax_temp_arr['less_ytd_tax_exempt'][0]; 
            $aRow['yt_tax_withheld']        = $annal_tax_temp_arr['yt_tax_withheld'][0]; 
        }

        // Regular pay
        $reg_pay = $aRow['basic_salary'] / 2; 
        $row[] = number_format($reg_pay); // Regular pay

        // 13th
        $paid_leave 	= $aRow['SL'] + $aRow['VL'];
        $unpaid_leave 	= $aRow['absences'];
        
        $monthly_pay 	= $aRow['basic_salary'];
        $daily_pay 		= $aRow['basic_salary'] / 26.17;

        $paid_amnt 		= $daily_pay * $paid_leave;
        $unpaid_amnt 	= $daily_pay * $unpaid_leave;

        $terth_1 = $reg_pay + $paid_amnt; 
        $terth_2 = $terth_1 - $unpaid_amnt; 
        $terth_3 = $terth_2 / 12; 
        $row[] = number_format($terth_3,2);  // 13th

        // OT1
        $row[] = $aRow['reg_ot'];  // OT1

        // OT1 amnt
        $ot1_1 = $daily_pay / 8;
        $ot1_2 = $ot1_1 * 1.25;
        $ot1_3 = $ot1_2 * $aRow['reg_ot'];
        $row[] = number_format($ot1_3,2);  // OT1 amnt

		// OT2
        $row[] = $aRow['sun_special_hol_ot'];  // OT2
		
		// OT2 amnt
        $ot2_1 = $daily_pay / 8;
        $ot2_2 = $ot2_1 * 1.5;
        $ot2_3 = $ot2_2 * $aRow['sun_special_hol_ot'];
        $row[] = number_format($ot2_3,2);  // OT2 amnt

		// OT2A
        $row[] = $aRow['sun_special_hol_ot_ex_8_hrs'];  // OT2A

        // OT2A amnt
		$ot2a_1 = $daily_pay / 8;
        $ot2a_2 = $ot2a_1 * 1.95;
        $ot2a_3 = $ot2a_2 * $aRow['sun_special_hol_ot_ex_8_hrs'];
        $row[] = number_format($ot2a_3,2);  // OT2A amnt

        // OT3
      	$row[] = $aRow['sun_ot'];  // OT3
        
        // OT3 amnt
		$ot3_1 = $daily_pay / 8;
        $ot3_2 = $ot3_1 * 1.30;
        $ot3_3 = $ot3_2 * $aRow['sun_ot'];
        $row[] = number_format($ot3_3,2);  // OT3 amnt
		
		// OT3A
        $row[] = $aRow['sun_ot_ex_8_hrs'];  // OT3A
        
        // OT3A amnt
		$ot3a_1 = $daily_pay / 8;
        $ot3a_2 = $ot3a_1 * 1.69;
        $ot3a_3 = $ot3a_2 * $aRow['sun_ot_ex_8_hrs'];
        $row[] = number_format($ot3a_3,2);  // OT3A amnt
	
		// OT4
        $row[] = $aRow['sun_legal_hol'];  // OT4 	
        
        // OT4 amnt
		$ot4_1 = $daily_pay / 8;
        $ot4_2 = $ot4_1 * 2.6;
        $ot4_3 = $ot4_2 * $aRow['sun_legal_hol'];
        $row[] = number_format($ot4_3,2);  // OT4 amnt

        // OT4A
        $row[] = $aRow['sun_legal_hol_ex_8_hrs'];  // OT4A
        
        // OT4A amnt
		$ot4a_1 = $daily_pay / 8;
        $ot4a_2 = $ot4a_1 * 3.38;
        $ot4a_3 = $ot4a_2 * $aRow['sun_legal_hol_ex_8_hrs'];
        $row[] = number_format($ot4a_3,2);  // OT4A amnt

        // OT5
        $row[] = $aRow['special_non_work_hol'];  // OT5
        
        // OT5 amnt
		$ot5_1 = $daily_pay / 8;
        $ot5_2 = $ot5_1 * 1.3;
        $ot5_3 = $ot5_2 * $aRow['special_non_work_hol'];
        $row[] = number_format($ot5_3,2);  // OT5 amnt

        // OT5A
        $row[] = $aRow['special_non_work_hol_ex_8_hrs'];  // OT5A
        
        // OT5A amnt
		$ot5a_1 = $daily_pay / 8;
        $ot5a_2 = $ot5a_1 * 1.69;
        $ot5a_3 = $ot5a_2 * $aRow['special_non_work_hol_ex_8_hrs'];
        $row[] = number_format($ot5a_3,2);  // OT5A amnt
	
		// OT6
        $row[] = $aRow['legal_hol'];  // OT6	
        
        // OT6 amnt
		$ot6_1 = $daily_pay / 8;
        $ot6_2 = $ot6_1 * 2;
        $ot6_3 = $ot6_2 * $aRow['legal_hol'];
        $row[] = number_format($ot6_3,2);  // OT6 amnt

        // OT6A
        $row[] = $aRow['legal_hol_ex_8_hrs'];  // OT6A

        // OT6A amnt
		$ot6a_1 = $daily_pay / 8;
        $ot6a_2 = $ot6a_1 * 2.6;
        $ot6a_3 = $ot6a_2 * $aRow['legal_hol_ex_8_hrs'];
        $row[] = number_format($ot6a_3,2);  // OT6A amnt

        // night diff
        $row[] = $aRow['night_diff']; // night diff

        // night diff amnt
        $nd_1 = $daily_pay * 0.10;
        $nd_2 = $nd_1 * $aRow['night_diff'];
        $nd_3 = $nd_2 / 8;
        $row[] = number_format($nd_3,2); // night diff amnt

        // SL
        $row[] = $aRow['SL']; // SL

        // SL amnt
        $sl_1 = $daily_pay * $aRow['SL']; 
        $row[] = number_format($sl_1,2); // SL amnt
        
        // VL
        $row[] = $aRow['VL']; // VL

        // VL amnt
        $vl_1 = $daily_pay * $aRow['VL']; 
        $row[] = number_format($vl_1,2); // VL amnt
        
        /* for checking ng value */
        // BL
        $row[] = 0; // BL

        // BL amnt
        $bl_1 = 0; 
        $row[] = number_format($bl_1,2); // BL amnt
        
        // BDL
        // $row[] = $aRow['VL']; // BDL
        $row[] = 0; // BDL

        // BDL amnt
        // $bdl_1 = $daily_pay * $aRow['VL']; 
        $bdl_1 = 0; 
        $row[] = number_format($bdl_1,2); // BDL amnt
        
        // SD
        // $row[] = $aRow['VL']; // SD
        $row[] = 0; // SD

        // SD amnt
        // $sd_1 = $daily_pay * $aRow['VL']; 
        $sd_1 = 0; 
        $row[] = number_format($sd_1,2); // SD amnt

        // ecola 
        if ($aRow['ecola'] > 0){
            $ecola_1 = 13 - $unpaid_leave; // working days = 13
            $ecola_2 = $ecola_1 * $aRow['ecola']; // working days = 13

	        $row[] = number_format($ecola_2,2); // ecola
        }else{
        	$ecola_2 = 0;
	        $row[] = number_format($ecola_2,2); // ecola
        }

	    // Salary adj
        $sal_adj_amnt = $aRow['salary_adjustments'];
        $row[] = number_format($sal_adj_amnt,2);

	    // Allowance
	    $allowance = $aRow['allowance'] / 2; // Allowance
	    $row[] = $allowance; // Allowance

	    // CTPA
	    $row[] = 0; // CTPA

	    // Socio Eco. allow
	    $row[] = 0; // Socio Eco. allow

	    // Other Earnings
	    $row[] = 0; // Other Earnings
        
        // absences
        // $abs = $aRow['absences']; 
        $row[] = $unpaid_leave; // absences

        // absences amnt
        $abs_amnt = $daily_pay * $unpaid_leave; 
        $row[] = number_format($abs_amnt,2); //absences amnt

        // undertime
        $undertime = $aRow['undertime']; 
        $row[] = $undertime; // undertime

        // undertime amnt
        $ut_1 = $daily_pay / 8; 
        $ut_2 = $ut_1 * $aRow['undertime']; 
        $row[] = number_format($ut_2,2); //undertime amnt

        // gross pay
        $ot_nd = $ot1_3 + $ot2_3 + $ot2a_3 + $ot3_3 + $ot3a_3 + $ot4_3 + $ot4a_3 + $ot5_3 + $ot5a_3 + $ot6_3 + $ot6a_3 + $nd_3;
        $leaves = $sl_1 + $vl_1 + $bl_1 + $bdl_1 + $sd_1;
        $absent_ut = $abs_amnt + $ut_2;

        $gross_pay_1 = $reg_pay + $ot_nd + $leaves + $ecola_2 + $allowance + $aRow['salary_adjustments'];
        $gross_pay_2 = $gross_pay_1 - $absent_ut;
        $row[] = number_format($gross_pay_2,2);// gross pay

        // sss premiums
        $sss_amnt = $aRow['charge_amount'];
        $row[] = number_format($sss_amnt,2);
        
        // phil premiums
        $phil_1_amnt = $monthly_pay * 0.04;     
        $phil_2_amnt = $phil_1_amnt / 2;
        $row[] = number_format($phil_2_amnt,2);

        // pagibig
        $pagibig_amnt = 0;
        $row[] = number_format($pagibig_amnt,2);

        // sss loan
        $sss_loan_amnt = $aRow['charge_amount'];
        $row[] = number_format($sss_loan_amnt,2);

        // sss cal loan
        $sss_cal_loan_amnt = $aRow['charge_amount'];
        $row[] = number_format($sss_cal_loan_amnt,2);

        // pagibig sal loan
        $pagibig_sal_loan_amnt = 0;
        $row[] = number_format($pagibig_sal_loan_amnt,2);

        // pagibig cal loan
        $pagibig_cal_loan_amnt = 0;
        $row[] = number_format($pagibig_cal_loan_amnt,2);

        // hipar
        $hipar_amnt = $aRow['hmo_amount'] / 2;
        $row[] = number_format($hipar_amnt,2);

        // advances other deductions
        $adv_deduc_amnt = $aRow['advances_other_deductions'];
        $row[] = number_format($adv_deduc_amnt,2);

        // Tax Adjustment
        $tax_adj_amnt = $aRow['tax_adjustments'];
        $row[] = number_format($tax_adj_amnt,2);

        // With tax
        $ytd_gross_income   = $aRow['gross_income_ytd'] + $gross_pay_2;
        $forecast_earnings  = $aRow['forecast_earnings'] - $reg_pay;
        $ytd_tax_exempt     = $aRow['less_ytd_tax_exempt'] + $sss_amnt + $phil_2_amnt;

        $tax_w_fcast_1      = ($ytd_gross_income + $forecast_earnings) - $ytd_tax_exempt;

        if ( $tax_w_fcast_1 < 250000 ){
            $tax_based = 124.99;  

        }else if ( $tax_w_fcast_1 > 250000 && $tax_w_fcast_1 <= 400000 ){
            $tax_based_1 = $tax_w_fcast_1 - 250000; 
            $tax_based = ($tax_based_1 * 0.15) + 0; 
        }else if ( $tax_w_fcast_1 > 400000 && $tax_w_fcast_1 <= 800000 ){
            $tax_based_1 = $tax_w_fcast_1 - 400000; 
            $tax_based = ($tax_based_1 * 0.20) + 22500; 
        }else if ( $tax_w_fcast_1 > 800000 && $tax_w_fcast_1 <= 2000000 ){
            $tax_based_1 = $tax_w_fcast_1 - 800000; 
            $tax_based = ($tax_based_1 * 0.25) + 102500; 
        }else if ( $tax_w_fcast_1 > 2000000 && $tax_w_fcast_1 <= 8000000 ){
            $tax_based_1 = $tax_w_fcast_1 - 2000000; 
            $tax_based = ($tax_based_1 * 0.30) + 402500; 
        }else if ( $tax_w_fcast_1 > 8000000 && $tax_w_fcast_1 <= 9999999 ){
            $tax_based_1 = $tax_w_fcast_1 - 8000000; 
            $tax_based = ($tax_based_1 * 0.35) + 2202500; 
        }

        $rate_annl_earnings = $ytd_gross_income / ($ytd_gross_income + $forecast_earnings);

        $with_tax1 = $tax_based * $rate_annl_earnings;
        $with_tax = $with_tax1 - ($aRow['yt_tax_withheld'] + 3358.89); // for checking pa

        $row[] = number_format($with_tax,2); // With tax

        // Net pay
        $all_deductions = $sss_amnt + $phil_2_amnt + $pagibig_amnt + $sss_loan_amnt + $sss_cal_loan_amnt + $pagibig_sal_loan_amnt + $pagibig_cal_loan_amnt + $hipar_amnt + $adv_deduc_amnt + $tax_adj_amnt + $with_tax;
        $net_pay = $gross_pay_2 - $all_deductions; 

        $row[] = number_format($net_pay,2); // Net pay

     
		array_push($output['aaData'],$row);

	}
	

	echo json_encode( $output );

	function get_salary($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_salary_report';
        $joins              = '';
        $sql_where          = 'WHERE employee_no="'.$EmpNo.'"';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['basic_salary'][$ctr]           = $row['basic_salary'];
            $return['ecola'][$ctr]                  = $row['ecola'];
            $return['ctpa'][$ctr]                   = $row['ctpa'];
            $return['socio_eco_allow'][$ctr]        = $row['socio_eco_allow'];
            $return['allowance'][$ctr]              = $row['allowance'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    function get_eom($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_eom';
        $joins              = '';
        $sql_where          = 'WHERE id_number="'.$EmpNo.'"';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['id_number'][$ctr]                      = $row['id_number'];
            $return['SL'][$ctr]           					= $row['SL'];
            $return['VL'][$ctr]           					= $row['VL'];
            $return['absences'][$ctr]           			= $row['absences'];
            $return['night_diff'][$ctr]           			= $row['night_diff'];
            $return['undertime'][$ctr]           			= $row['undertime'];
            $return['reg_ot'][$ctr]           				= $row['reg_ot'];
            $return['sun_special_hol_ot'][$ctr]             = $row['sun_special_hol_ot'];
            $return['sun_special_hol_ot_ex_8_hrs'][$ctr]    = $row['sun_special_hol_ot_ex_8_hrs'];
            $return['sun_ot'][$ctr]        					= $row['sun_ot'];
            $return['sun_ot_ex_8_hrs'][$ctr]             	= $row['sun_ot_ex_8_hrs'];
            $return['sun_legal_hol'][$ctr]             		= $row['sun_legal_hol'];
            $return['sun_legal_hol_ex_8_hrs'][$ctr]        	= $row['sun_legal_hol_ex_8_hrs'];
            $return['special_non_work_hol'][$ctr]           = $row['special_non_work_hol'];
            $return['special_non_work_hol_ex_8_hrs'][$ctr]  = $row['special_non_work_hol_ex_8_hrs'];
            $return['legal_hol'][$ctr]             			= $row['legal_hol'];
            $return['legal_hol_ex_8_hrs'][$ctr]            	= $row['legal_hol_ex_8_hrs'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    function get_taxes($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_taxes'; // adjustments
        $joins              = '';
        $sql_where          = 'WHERE emp_no="'.$EmpNo.'"';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['salary_adjustments'][$ctr]           = $row['salary_adjustments'];
            $return['other_earnings'][$ctr]               = $row['other_earnings'];
            $return['advances_other_deductions'][$ctr]    = $row['advances_other_deductions'];
            $return['tax_adjustments'][$ctr]              = $row['tax_adjustments'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    function get_sss_premiums($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_sss_premium';
        $joins              = '';
        $sql_where          = 'WHERE emp_num="'.$EmpNo.'"';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['charge_amount'][$ctr]           = $row['charge_amount'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    function get_phil_premiums($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_philhealth'; 
        $joins              = '';
        $sql_where          = 'WHERE emp_no="'.$EmpNo.'"';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['philhealth_amount'][$ctr]           = $row['philhealth_amount'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    function get_sss_loans($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_sss_loans'; 
        $joins              = '';
        $sql_where          = 'WHERE emp_num="'.$EmpNo.'"';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['charge_amount'][$ctr]           = $row['charge_amount'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    function get_sss_cal_loans($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_sss_calamity_loan'; 
        $joins              = '';
        $sql_where          = 'WHERE emp_num="'.$EmpNo.'"';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['charge_amount'][$ctr]           = $row['charge_amount'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    function get_hipar($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_hmo'; 
        $joins              = '';
        $sql_where          = 'WHERE employee_no="'.$EmpNo.'"';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['hmo_amount'][$ctr]           = $row['hmo_amount'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    function get_annual_tax($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_annual_tax'; 
        $joins              = '';
        $sql_where          = 'WHERE emp_no="'.$EmpNo.'"';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['gross_income_ytd'][$ctr]         = $row['gross_income_ytd'];
            $return['forecast_earnings'][$ctr]        = $row['forecast_earnings'];
            $return['less_ytd_tax_exempt'][$ctr]      = $row['less_ytd_tax_exempt'];
            $return['yt_tax_withheld'][$ctr]          = $row['yt_tax_withheld'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    // function get_tax_base(){
    //     require_once ('../../class/payroll_oop.php');
    //     $return             = $_POST;
    //     $result             = '';
    //     $array_fields       = array('*');
    //     $table              = 'tbl_tax_base'; 
    //     $joins              = '';
    //     $sql_where          = '';
    //     $sql_order          = '';
    //     $sql_limit          = '';
    //     $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
    //     $ctr = 0;
    //     while($row = mysqli_fetch_array($result)){
    //         $return['tax_base'][$ctr]        = $row['tax_base'];
    //         $return['tax_rate'][$ctr]        = $row['tax_rate'];
    //         $return['lower_limit'][$ctr]     = $row['lower_limit'];
    //         $return['upper_limit'][$ctr]     = $row['upper_limit'];
    //         $ctr++;
    //     }
    //     $return['ctr']  = $ctr;
    //     return $return;
    // }

    // function get_working_days(){
    //     require_once ('../../class/payroll_oop.php');
    //     $return             = $_POST;
    //     $result             = '';
    //     $array_fields       = array('*');
    //     $table              = 'tbl_working_days';
    //     $joins              = '';
    //     $sql_where          = '';
    //     $sql_order          = '';
    //     $sql_limit          = '';
    //     $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
    //     $ctr = 0;
    //     while($row = mysqli_fetch_array($result)){
    //         $return['working_days'][$ctr]           = $row['working_days'];
    //         $ctr++;
    //     }
    //     $return['ctr']  = $ctr;
    //     return $return;
    // }



?>