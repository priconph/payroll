<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $salary_type    = $_GET['salary_type'];
    $cutoff         = $_GET['cutoff'];
    $date_cutoff   = $_GET['date_cutoff'];

    $aColumns = array( 
                'id',
                'id_number',
                'emp_code',
                'absences',
                'undertime',
                'night_diff',
                'SL',
                'VL',
                'reg_ot',
                'sun_special_hol_ot',
                'sun_special_hol_ot_ex_8_hrs',
                'sun_ot',
                'sun_ot_ex_8_hrs',
                'sun_legal_hol',
                'sun_legal_hol_ex_8_hrs',
                'special_non_work_hol',
                'special_non_work_hol_ex_8_hrs',
                'legal_hol',
                'legal_hol_ex_8_hrs'
                );
                                
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "id";
    
    /* DB table to use */
    $sTable = "tbl_eom";

    $database_config = '../../db_config/config_payroll.php';
    
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
    $sOrder = '';
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

    // $sWhere .= "emp_code = '".$salary_type."' AND (id_number = 'K010') ";
    $sWhere .= "emp_code = '".$salary_type."' ";
    
    if($sOrder == ""){
        $sOrder = 'ORDER BY id_number ASC';
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
    
    $query_used = $sQuery;
    
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
        // "query" => $query_used,
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );

    $tax_based = '';
    $emp_no = '';
    // echo "encode ".json_encode(mysql_fetch_array( $rResult ));
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        $row = array();
        unset($row);
        
        $emp_info_temp_arr = get_employee_info( $aRow['id_number'] );
        if( $emp_info_temp_arr['ctr']>0 ){
            $aRow['EmpNo']       = $emp_info_temp_arr['EmpNo'][0]; 
            $aRow['LastName']    = $emp_info_temp_arr['LastName'][0]; 
            $aRow['FirstName']   = $emp_info_temp_arr['FirstName'][0]; 
            $aRow['MiddleName']  = $emp_info_temp_arr['MiddleName'][0]; 
            $aRow['Department']  = $emp_info_temp_arr['Department'][0]; 
            $aRow['Section']     = $emp_info_temp_arr['Section'][0]; 
        }else{
            $aRow['EmpNo']       ='';
            $aRow['LastName']    ='';
            $aRow['FirstName']   ='';
            $aRow['MiddleName']  ='';
            $aRow['Department']  ='';
            $aRow['Section']     ='';
        }

        $salary_temp_arr = get_salary( $aRow['id_number'] );
        if( $salary_temp_arr['ctr']>0 ){
            $aRow['basic_salary']       = $salary_temp_arr['basic_salary'][0]; 
            $aRow['ecola']              = $salary_temp_arr['ecola'][0]; 
            $aRow['ctpa']               = $salary_temp_arr['ctpa'][0]; 
            $aRow['socio_eco_allow']    = $salary_temp_arr['socio_eco_allow'][0]; 
            $aRow['allowance']          = $salary_temp_arr['allowance'][0]; 
        }else{
            $aRow['basic_salary']       = '';
            $aRow['ecola']              = '';
            $aRow['ctpa']               = '';
            $aRow['socio_eco_allow']    = '';
            $aRow['allowance']          = '';
        }

        $adj_temp_arr = get_taxes( $aRow['id_number'] );

         $aRow['b_other_earnings'] = 0;
         $aRow['t_other_earnings'] = 0;
         $aRow['bt_other_earnings'] = 0;
         $aRow['ph_other_earnings'] = 0; 

        if( $adj_temp_arr['ctr']>0 ){
            if ( $aRow['id_number'] == $adj_temp_arr['emp_no'][0]){ // check if tbl_eom(id_number) is equal to tbl_taxes(emp_no)

                $oe_adj = 0;
                for($i=0; $i< $adj_temp_arr['ctr']; $i++){
                    $oe_adj = $oe_adj + $adj_temp_arr['other_earnings'][$i];

                    if( $adj_temp_arr['type_of_earning'][$i] == 1){ // bonus adj
                        $aRow['b_other_earnings']           = $adj_temp_arr['other_earnings'][$i]; 
                    }else if ( $adj_temp_arr['type_of_earning'][$i] == 2){ // 13th adj
                        $aRow['t_other_earnings']           = $adj_temp_arr['other_earnings'][$i]; 
                    }else if ( $adj_temp_arr['type_of_earning'][$i] == 3){ // sss prem adj
                        $aRow['s_other_earnings']           = $adj_temp_arr['other_earnings'][$i]; 
                    }else if ( $adj_temp_arr['type_of_earning'][$i] == 4){ // ph prem adj
                        $aRow['ph_other_earnings']           = $adj_temp_arr['other_earnings'][$i]; 
                    }else{
                        $aRow['other_earnings']           = $adj_temp_arr['other_earnings'][$i]; 
                    }
                }
                $aRow['bt_other_earnings'] = $aRow['b_other_earnings'] + $aRow['t_other_earnings'];

                $aRow['emp_no']                   = $adj_temp_arr['emp_no'][0]; 
                $aRow['salary_adjustments']       = $adj_temp_arr['salary_adjustments'][0];
                $aRow['other_earnings']           = $oe_adj;  
                $aRow['advances_other_deductions']= $adj_temp_arr['advances_other_deductions'][0]; 
                $aRow['tax_adjustments']          = $adj_temp_arr['tax_adjustments'][0]; 
                $aRow['type_of_earning']          = $adj_temp_arr['type_of_earning']; 
            }
        }else{
                $aRow['emp_no']                   ='';
                $aRow['salary_adjustments']       ='';
                $aRow['b_other_earnings']         ='';
                $aRow['t_other_earnings']         ='';
                $aRow['s_other_earnings']         ='';
                $aRow['ph_other_earnings']        ='';
                $aRow['other_earnings']           ='';
                $aRow['advances_other_deductions']='';
                $aRow['tax_adjustments']          ='';
                $aRow['type_of_earning']          ='';
        }

        $sss_loans_temp_arr = get_sss_loans( $aRow['id_number'] );
        if( $sss_loans_temp_arr['ctr']>0 ){
            if ( $aRow['id_number'] == $sss_loans_temp_arr['emp_num']){ // check if tbl_eom(id_number) is equal to tbl_taxes(emp_no)
                $aRow['sssl_charge_amount']       = $sss_loans_temp_arr['charge_amount']; 
            }
        }else{
            $aRow['sssl_charge_amount'] = '';
        }

        $sss_cal_loans_temp_arr = get_sss_cal_loans( $aRow['id_number'] );
        if( $sss_cal_loans_temp_arr['ctr']>0 ){
            if ( $aRow['id_number'] == $sss_cal_loans_temp_arr['emp_num']){ // check if tbl_eom(id_number) is equal to tbl_taxes(emp_no)
                $aRow['ssscl_charge_amount']       = $sss_cal_loans_temp_arr['charge_amount']; 
            }
        }else{
            $aRow['ssscl_charge_amount'] = '';
        }

        //09162024 added by nessa
        $sss_condo_temp_arr = get_sss_condonation( $aRow['id_number'] );
        if( $sss_condo_temp_arr['ctr']>0 ){
            if ( $aRow['id_number'] == $sss_condo_temp_arr['emp_num']){ // check if tbl_eom(id_number) is equal to tbl_taxes(emp_no)
                $aRow['ssscon_charge_amount']       = $sss_condo_temp_arr['charge_amount']; 
            }
        }else{
            $aRow['ssscon_charge_amount'] = '';
        }

        $hipar_temp_arr = get_hipar( $aRow['id_number'] );
        if( $hipar_temp_arr['ctr']>0 ){
            if ( $aRow['id_number'] == $hipar_temp_arr['employee_no']){ // check if tbl_eom(id_number) is equal to tbl_taxes(emp_no)
                $aRow['hmo_amount']       = $hipar_temp_arr['hmo_amount']; 
            }
        }else{
            $aRow['hmo_amount'] = '';
        }

        // $adj_temp_arr = get_oleaves( $aRow['id_number'] );
        
        // if( $adj_temp_arr['ctr']>0 ){
        //     if ( $aRow['id_number'] == $adj_temp_arr['emp_no']){ // check if tbl_eom(id_number) is equal to tbl_taxes(emp_no)
        //         $aRow['emp_no']           = $adj_temp_arr['emp_no']; 
        //         $aRow['leave_code']       = $adj_temp_arr['leave_code'];
                

        //         if ($aRow['leave_code'] == 1 ){
        //             $aRow['bdl_amount']      = $adj_temp_arr['amount']; 
        //         }
        //  		if($aRow['leave_code'] == 2){
        //             $aRow['sd_amount']      = $adj_temp_arr['amount']; 
        //         }
        //         else{
        //             $aRow['bdl_amount']       = 0;
        //             $aRow['sd_amount']       = 0;
        //         }

        //         $aRow['cut_off']          = $adj_temp_arr['cut_off']; 
        //     }
        // }else{
        //     $aRow['leave_code '] = '';
        //     $aRow['amount'] = '';
        //     $aRow['cut_off'] = '';
        // }

        $adj_temp_arr = get_oleaves($aRow['id_number']); // Get leave data for employee

		if ($adj_temp_arr['ctr'] > 0) {
		    if ($aRow['id_number'] == $adj_temp_arr['emp_no'][0]) {  // Check emp_no match
		        $aRow['emp_no'] = $adj_temp_arr['emp_no'][0];

		        // Initialize amounts to 0 in case there are no matching leave codes
		        $aRow['bdl_amount'] = 0;
		        $aRow['sd_amount'] = 0;

		        // Loop through each leave record and assign amounts
		        for ($i = 0; $i < $adj_temp_arr['ctr']; $i++) {
		            if ($adj_temp_arr['leave_code'][$i] == 1) {
		                $aRow['bdl_amount'] += $adj_temp_arr['amount'][$i]; // Sum BDL amounts
		            }
		            if ($adj_temp_arr['leave_code'][$i] == 2) {
		                $aRow['sd_amount'] += $adj_temp_arr['amount'][$i]; // Sum SD amounts
		            }
		        }

		        // Example: Assign the first cut_off (or use the latest if needed)
		        $aRow['cut_off'] = $adj_temp_arr['cut_off'][0];
		    }
		} else {
		    // Reset values if no matching data is found
		    $aRow['leave_code'] = '';
		    $aRow['amount'] = '';
		    $aRow['cut_off'] = '';
		}

        $annal_tax_temp_arr = get_annual_tax( $aRow['id_number'] );
        if( $annal_tax_temp_arr['ctr']>0 ){
            $aRow['gross_income_ytd']       = $annal_tax_temp_arr['gross_income_ytd'][0]; 
            $aRow['forecast_earnings']      = $annal_tax_temp_arr['forecast_earnings'][0]; 
            $aRow['less_ytd_tax_exempt']    = $annal_tax_temp_arr['less_ytd_tax_exempt'][0]; 
            $aRow['yt_tax_withheld']        = $annal_tax_temp_arr['yt_tax_withheld'][0]; 
            $aRow['leaves_taxes']       	= $annal_tax_temp_arr['leaves_taxes'][0]; 
        }else{
            $aRow['gross_income_ytd']       ='';
            $aRow['forecast_earnings']      ='';
            $aRow['less_ytd_tax_exempt']    ='';
            $aRow['yt_tax_withheld']        ='';
            $aRow['leaves_taxes']        	='';
        }

        $pagibig_loan_temp_arr = get_pagibig( $aRow['id_number'] );
        if( $pagibig_loan_temp_arr['ctr']>0 ){
            if ( $aRow['id_number'] == $pagibig_loan_temp_arr['emp_no']){ // check if tbl_eom(id_number) is equal to tbl_taxes(emp_no)
                $aRow['loan_amount']            = $pagibig_loan_temp_arr['loan_amount']; 
                $aRow['calamity_loan_amount']   = $pagibig_loan_temp_arr['calamity_loan_amount']; 
                $aRow['safe_loan_amount']       = $pagibig_loan_temp_arr['safe_loan_amount']; 
            }
        }else{
                $aRow['loan_amount']            ='';
                $aRow['calamity_loan_amount']   ='';
                $aRow['safe_loan_amount']       ='';
        } 

        $payroll_info_loan_temp_arr = get_payroll_info_data( $aRow['id_number'] ); // Prev. gross pay LIVE
        if( $payroll_info_loan_temp_arr['ctr']>0 ){
            if ( $aRow['id_number'] == $payroll_info_loan_temp_arr['employee_no']){ // check if tbl_eom(id_number) is equal to tbl_taxes(emp_no)
                $aRow['prev_gross_pay']            = $payroll_info_loan_temp_arr['gross_pay']; 
            }else{
                $aRow['prev_gross_pay']            = 0; 
            }
        }else{
                $aRow['prev_gross_pay']            = 0; 
        } 

        /* Value */
        $row[] = $aRow['id_number']; // EmpNo

        // Emp Name
        $row[] = $aRow['LastName'].', '.$aRow['FirstName'].' ('.$aRow['MiddleName'].')'; // Emp Name

        // Regular pay
        $monthly_pay    = $aRow['basic_salary'];
        $dp             = $aRow['basic_salary'] / 26.17;
        $daily_pay      = sprintf('%0.4f', $dp);
        $wd             = get_working_days();
        
        if ( $cutoff == 1 ){ // First Cutoff formula
            if ($aRow['emp_code'] == 1){ //Daily

                // Regular pay
                $reg_pay = $aRow['basic_salary']; 
                if($reg_pay == ""){
                    $row[] = $reg_pay; // Regular pay
                }
                else{
                    $row[] = number_format($reg_pay,2); // Regular pay
                }

                // 13th
                $utm_1 = $reg_pay / 8; 
                $utm_2 = $utm_1 * $aRow['undertime']; 

                $sd_amnt = isset($aRow['sd_amount']) 
                ? floatval($aRow['sd_amount']) 
                : floatval("0.00");
                
                $bdl_amnts = isset($aRow['bdl_amount']) 
                ? floatval($aRow['bdl_amount']) 
                : floatval("0.00");

                $bdl_amnt     = $bdl_amnts * $reg_pay;
                $paid_leave     = $aRow['SL'] + $aRow['VL'];
                $unpaid_leave   = $aRow['absences'];
                $paid_amnt      = ($reg_pay * $paid_leave) + $sd_amnt + $bdl_amnt;
                $unpaid_amnt    = ($reg_pay * $unpaid_leave) + $utm_2;

                $terth_1 = ($reg_pay * $wd) + $paid_amnt; 
                $terth_2 = $terth_1 - $unpaid_amnt; 
                $terth_4 = $terth_2 / 12; 
                $row[] = number_format($terth_4,2);  // 13th

                /* // OT1
                $row[] = $aRow['reg_ot'];  // OT1

                // OT1 amnt
                $ot1_1x = $reg_pay / 8;
                $ot1_1 = number_format($ot1_1x,2);
                $ot1_2x = $ot1_1 * 1.25;
                $ot1_2 = sprintf('%0.4f', $ot1_2x);
                $ot1_3 = $ot1_2 * $aRow['reg_ot'];
                $row[] = number_format($ot1_3,2);  // OT1 amnt

                // OT2
                $row[] = $aRow['sun_special_hol_ot'];  // OT2

                // OT2 amnt
                $ot2_1x = $reg_pay / 8;
                $ot2_1 = sprintf('%0.2f', $ot2_1x);
                $ot2_2x = $ot2_1 * 1.5;
                $ot2_2 = sprintf('%0.4f', $ot2_2x);
                $ot2_3 = $ot2_2 * $aRow['sun_special_hol_ot'];
                $row[] = number_format($ot2_3,2);  // OT2 amnt

                // OT2A
                $row[] = $aRow['sun_special_hol_ot_ex_8_hrs'];  // OT2A

                // OT2A amnt
                $ot2a_1x = $reg_pay / 8;
                $ot2a_1 = sprintf('%0.2f', $ot2a_1x);
                $ot2a_2x = $ot2a_1 * 1.95;
                $ot2a_2 = sprintf('%0.4f', $ot2a_2x);
                $ot2a_3 = $ot2a_2 * $aRow['sun_special_hol_ot_ex_8_hrs'];
                $row[] = number_format($ot2a_3,2);  // OT2A amnt

                // OT3
                $row[] = $aRow['sun_ot'];  // OT3

                // OT3 amnt
                $ot3_1x = $reg_pay / 8;
                $ot3_1 = sprintf('%0.2f', $ot3_1x);
                $ot3_2x = $ot3_1 * 1.30;
                $ot3_2 = sprintf('%0.4f', $ot3_2x);
                $ot3_3 = $ot3_2 * $aRow['sun_ot'];
                $row[] = number_format($ot3_3,2);  // OT3 amnt

                // OT3A
                $row[] = $aRow['sun_ot_ex_8_hrs'];  // OT3A

                // OT3A amnt
                $ot3a_1x = $reg_pay / 8;
                $ot3a_1 = sprintf('%0.2f', $ot3a_1x);
                $ot3a_2x = $ot3a_1 * 1.69;
                $ot3a_2 = sprintf('%0.4f', $ot3a_2x);
                $ot3a_3 = $ot3a_2 * $aRow['sun_ot_ex_8_hrs'];
                $row[] = number_format($ot3a_3,2);  // OT3A amnt

                // OT4
                $row[] = $aRow['sun_legal_hol'];  // OT4    

                // OT4 amnt
                $ot4_1x = $reg_pay / 8;
                $ot4_1 = sprintf('%0.2f', $ot4_1x);
                $ot4_2x = $ot4_1 * 2.6;
                $ot4_2 = sprintf('%0.4f', $ot4_2x);
                $ot4_3 = $ot4_2 * $aRow['sun_legal_hol'];
                $row[] = number_format($ot4_3,2);  // OT4 amnt

                // OT4A
                $row[] = $aRow['sun_legal_hol_ex_8_hrs'];  // OT4A

                // OT4A amnt
                $ot4a_1x = $reg_pay / 8;
                $ot4a_1 = sprintf('%0.2f', $ot4a_1x);
                $ot4a_2x = $ot4a_1 * 3.38;
                $ot4a_2 = sprintf('%0.4f', $ot4a_2x);
                $ot4a_3 = $ot4a_2 * $aRow['sun_legal_hol_ex_8_hrs'];
                $row[] = number_format($ot4a_3,2);  // OT4A amnt

                // OT5
                $row[] = $aRow['special_non_work_hol'];  // OT5

                // OT5 amnt
                $ot5_1x = $reg_pay / 8;
                $ot5_1 = sprintf('%0.2f', $ot5_1x);
                $ot5_2x = $ot5_1 * 1.3; // 05162024 by Nessa
                $ot5_2 = sprintf('%0.4f', $ot5_2x);
                $ot5_3 = $ot5_2 * $aRow['special_non_work_hol'];
                $row[] = number_format($ot5_3,2);  // OT5 amnt

                // OT5A
                $row[] = $aRow['special_non_work_hol_ex_8_hrs'];  // OT5A

                // OT5A amnt
                $ot5a_1x = $reg_pay / 8;
                $ot5a_1 = sprintf('%0.2f', $ot5a_1x);
                $ot5a_2x = $ot5a_1 * 1.69;
                $ot5a_2 = sprintf('%0.4f', $ot5a_2x);
                $ot5a_3 = $ot5a_2 * $aRow['special_non_work_hol_ex_8_hrs'];
                $row[] = number_format($ot5a_3,2);  // OT5A amnt

                // OT6
                $row[] = $aRow['legal_hol'];  // OT6    

                // OT6 amnt
                $ot6_1x = $reg_pay / 8;
                $ot6_1 = sprintf('%0.2f', $ot6_1x);
                $ot6_2x = $ot6_1 * 1; // 05162024 by Nessa
                $ot6_2 = sprintf('%0.4f', $ot6_2x);
                $ot6_3 = $ot6_2 * $aRow['legal_hol'];
                $row[] = number_format($ot6_3,2);  // OT6 amnt

                // OT6A
                $row[] = $aRow['legal_hol_ex_8_hrs'];  // OT6A

                // OT6A amnt
                $ot6a_1x = $reg_pay / 8;
                $ot6a_1 = sprintf('%0.2f', $ot6a_1x);
                $ot6a_2x = $ot6a_1 * 2.6;
                $ot6a_2 = sprintf('%0.4f', $ot6a_2x);
                $ot6a_3 = $ot6a_2 * $aRow['legal_hol_ex_8_hrs'];
                $row[] = number_format($ot6a_3,2);  // OT6A amnt */

                // OT1
                $row[] = $aRow['reg_ot'];  // OT1

                // OT1 amnt
                $ot1_1 = $reg_pay / 8;
                $ot1_2 = $ot1_1 * 1.25;
                $ot1_3 = $ot1_2 * $aRow['reg_ot'];
                $row[] = number_format($ot1_3,2);  // OT1 amnt

                // OT2
                $row[] = $aRow['sun_special_hol_ot'];  // OT2

                // OT2 amnt
                $ot2_1 = $reg_pay / 8;
                $ot2_2 = $ot2_1 * 1.5;
                $ot2_3 = $ot2_2 * $aRow['sun_special_hol_ot'];
                $row[] = number_format($ot2_3,2);  // OT2 amnt

                // OT2A
                $row[] = $aRow['sun_special_hol_ot_ex_8_hrs'];  // OT2A

                // OT2A amnt
                $ot2a_1 = $reg_pay / 8;
                $ot2a_2 = $ot2a_1 * 1.95;
                $ot2a_3 = $ot2a_2 * $aRow['sun_special_hol_ot_ex_8_hrs'];
                $row[] = number_format($ot2a_3,2);  // OT2A amnt

                // OT3
                $row[] = $aRow['sun_ot'];  // OT3

                // OT3 amnt
                $ot3_1 = $reg_pay / 8;
                $ot3_2 = $ot3_1 * 1.30;
                $ot3_3 = $ot3_2 * $aRow['sun_ot'];
                $row[] = number_format($ot3_3,2);  // OT3 amnt

                // OT3A
                $row[] = $aRow['sun_ot_ex_8_hrs'];  // OT3A

                // OT3A amnt
                $ot3a_1 = $reg_pay / 8;
                $ot3a_2 = $ot3a_1 * 1.69;
                $ot3a_3 = $ot3a_2 * $aRow['sun_ot_ex_8_hrs'];
                $row[] = number_format($ot3a_3,2);  // OT3A amnt

                // OT4
                $row[] = $aRow['sun_legal_hol'];  // OT4    

                // OT4 amnt
                $ot4_1 = $reg_pay / 8;
                $ot4_2 = $ot4_1 * 2.6;
                $ot4_3 = $ot4_2 * $aRow['sun_legal_hol'];
                $row[] = number_format($ot4_3,2);  // OT4 amnt

                // OT4A
                $row[] = $aRow['sun_legal_hol_ex_8_hrs'];  // OT4A

                // OT4A amnt
                $ot4a_1 = $reg_pay / 8;
                $ot4a_2 = $ot4a_1 * 3.38;
                $ot4a_3 = $ot4a_2 * $aRow['sun_legal_hol_ex_8_hrs'];
                $row[] = number_format($ot4a_3,2);  // OT4A amnt

                // OT5
                $row[] = $aRow['special_non_work_hol'];  // OT5

                // OT5 amnt
                $ot5_1 = $reg_pay / 8;
                $ot5_2 = $ot5_1 * 1.3; // 05162024 by Nessa
                $ot5_3 = $ot5_2 * $aRow['special_non_work_hol'];
                $row[] = number_format($ot5_3,2);  // OT5 amnt

                // OT5A
                $row[] = $aRow['special_non_work_hol_ex_8_hrs'];  // OT5A

                // OT5A amnt
                $ot5a_1 = $reg_pay / 8;
                $ot5a_2 = $ot5a_1 * 1.69;
                $ot5a_3 = $ot5a_2 * $aRow['special_non_work_hol_ex_8_hrs'];
                $row[] = number_format($ot5a_3,2);  // OT5A amnt

                // OT6
                $row[] = $aRow['legal_hol'];  // OT6    

                // OT6 amnt
                $ot6_1 = $reg_pay / 8;
                $ot6_2 = $ot6_1 * 1; // 05022024
                $ot6_3 = $ot6_2 * $aRow['legal_hol'];
                $row[] = number_format($ot6_3,2);  // OT6 amnt

                // OT6A
                $row[] = $aRow['legal_hol_ex_8_hrs'];  // OT6A

                // OT6A amnt
                $ot6a_1 = $reg_pay / 8;
                $ot6a_2 = $ot6a_1 * 2.6;
                $ot6a_3 = $ot6a_2 * $aRow['legal_hol_ex_8_hrs'];
                $row[] = number_format($ot6a_3,2);  // OT6A amnt

                // night diff
                $row[] = $aRow['night_diff']; // night diff

                // night diff amnt
                $nd_1 = $reg_pay * 0.10;
                $nd_2 = $nd_1 * $aRow['night_diff'];
                $nd_3 = $nd_2 / 8;
                $row[] = number_format($nd_3,2); // night diff amnt

                // SL
                $row[] = $aRow['SL']; // SL

                // SL amnt
                $sl_1 = $reg_pay * $aRow['SL']; 
                $row[] = number_format($sl_1,2); // SL amnt

                // VL
                $row[] = $aRow['VL']; // VL

                // VL amnt
                $vl_1 = $reg_pay * $aRow['VL']; 
                $row[] = number_format($vl_1,2); // VL amnt

                /* for checking ng value */
                // BL
                $row[] = 0; // BL

                // BL amnt
                $bl_1 = 0; 
                $row[] = number_format($bl_1,2); // BL amnt

                // BDL
                $bdl = isset($aRow['bdl_amount']) 
                ? floatval($aRow['bdl_amount']) 
                : floatval("0.00"); // BDL
                $row[] = number_format($bdl,2);

                // BDL amnt
                $bdl_1 = isset($aRow['bdl_amount']) 
                ? floatval($aRow['bdl_amount']) 
                : floatval("0.00");
                $bdl_1 = $bdl_1 * $reg_pay;
                $row[] = number_format($bdl_1,2); // BDL amnt
                
                // SD
                $sd = isset($aRow['sd_amount']) 
                ? floatval($aRow['sd_amount']) 
                : floatval("0.00");
                $sd = $sd / 100;          
                $row[] = number_format($sd,2);

                // SD amnt
                $sd_amnt = isset($aRow['sd_amount']) 
                ? floatval($aRow['sd_amount']) 
                : floatval("0.00");
                $row[] = number_format($sd_amnt,2);

                // ecola 
                if ($aRow['ecola'] > 0){
                $ecola_1 = ($wd - $unpaid_leave) + $aRow['SL'] + $aRow['VL'] + $bdl + $sd; // working days = 13
                $ecola_2 = $ecola_1 * $aRow['ecola']; // working days = 13

                $row[] = number_format($ecola_2,2); // ecola
                }else{
                $ecola_2 = 0;
                $row[] = number_format($ecola_2,2); // ecola
                }

                // Salary adjustments
                $salary_adjustments = isset($aRow['salary_adjustments']) 
                ? floatval($aRow['salary_adjustments']) 
                : floatval("0.00");
                $row[] = number_format($salary_adjustments,2);

                // Allowance
                $allowance = $aRow['allowance'] / 2; // Allowance
                $row[] = $allowance; // Allowance

                // CTPA
                $row[] = 0; // CTPA

                // Socio Eco. allow
                $row[] = 0; // Socio Eco. allow

                // Other Earnings
                $other_earnings = isset($aRow['bt_other_earnings']) 
                ? floatval($aRow['bt_other_earnings']) 
                : floatval("0.00");
                $row[] = number_format($other_earnings,2);

                // absences
                $row[] = $unpaid_leave; // absences

                // absences amnt
                $abs_amnt = $reg_pay * $unpaid_leave; 
                $row[] = number_format($abs_amnt,2); //absences amnt

                // undertime
                $row[] = $aRow['undertime']; // undertime

                // undertime amnt
                $ut_1 = $reg_pay / 8; 
                $ut_2 = $ut_1 * $aRow['undertime']; 
                $row[] = number_format($ut_2,2); //undertime amnt            

                // gross pay
                $ot_nd = $ot1_3 + $ot2_3 + $ot2a_3 + $ot3_3 + $ot3a_3 + $ot4_3 + $ot4a_3 + $ot5_3 + $ot5a_3 + $ot6_3 + $ot6a_3 + $nd_3;
                $leaves = $sl_1 + $vl_1 + $bl_1 + $bdl_1 + $sd_amnt;
                $absent_ut = $abs_amnt + $ut_2;

                $gross_pay_1 = ($reg_pay * $wd) + $ot_nd + $leaves + $ecola_2 + $allowance + $salary_adjustments + $other_earnings; //working days 13
                $gross_pay_2 = $gross_pay_1 - $absent_ut;
                $row[] = number_format($gross_pay_2,2); // gross pay this cutoff

                $prev_gross = $aRow['prev_gross_pay'];

                $comp_gross_pay = $prev_gross + $gross_pay_2;
                $floated_comp_gross_pay =  number_format((float)$comp_gross_pay, 2, '.', '');

                // sss premiums
                $eeshare = isset($aRow['s_other_earnings']) 
                ? floatval($aRow['s_other_earnings']) 
                : floatval("0.00");
                $row[] = number_format($eeshare,2);

                // phil premiums
                $phil_2_amnt = isset($aRow['ph_other_earnings']) 
                ? floatval($aRow['ph_other_earnings']) 
                : floatval('0.00'); 
                $row[] = number_format($phil_2_amnt,2);

                // pagibig
                $pagibig_amnt = 200; 
                $row[] = number_format($pagibig_amnt,2);

                // sss loan
                $sss_loan_amnt = isset($aRow['sssl_charge_amount']) 
                ? floatval($aRow['sssl_charge_amount']) 
                : floatval("0.00");
                $row[] = number_format($sss_loan_amnt,2);

                // sss cal loan
                $sss_cal_loan_amnt = isset($aRow['ssscl_charge_amount']) 
                ? floatval($aRow['ssscl_charge_amount']) 
                : floatval("0.00");
                $row[] = number_format($sss_cal_loan_amnt,2);

                // sss condonation
                $sss_condo_loan_amnt = isset($aRow['ssscon_charge_amount']) 
                ? floatval($aRow['ssscon_charge_amount']) 
                : floatval("0.00");
                $row[] = number_format($sss_condo_loan_amnt,2);

                // pagibig sal loan
                $pagibig_sal_loan_amnt = isset($aRow['loan_amount']) 
                ? floatval($aRow['loan_amount']) 
                : floatval("0.00");
                $row[] = number_format($pagibig_sal_loan_amnt,2);

                // pagibig cal loan
                $pagibig_cal_loan_amnt = isset($aRow['calamity_loan_amount']) 
                ? floatval($aRow['calamity_loan_amount']) 
                : floatval("0.00");
                $row[] = number_format($pagibig_cal_loan_amnt,2);

                // pagibig safe loan
                $pagibig_safe_loan_amnt = isset($aRow['safe_loan_amount']) 
                ? floatval($aRow['safe_loan_amount']) 
                : floatval("0.00");
                $row[] = number_format($pagibig_safe_loan_amnt,2);

                // hipar or HMO
                $hipar_amnt = isset($aRow['hmo_amount']) 
                ? floatval($aRow['hmo_amount']) 
                : floatval("0.00");
                $row[] = number_format($hipar_amnt,2);

                // advances other deductions
                $adv_deduc_amnt = isset($aRow['advances_other_deductions']) 
                ? floatval($aRow['advances_other_deductions']) 
                : floatval("0.00");
                $row[] = number_format($adv_deduc_amnt,2);

                // Tax Adjustment
                $tax_adj_amnt = isset($aRow['tax_adjustments']) 
                ? floatval($aRow['tax_adjustments']) 
                : floatval("0.00");
                $row[] = number_format($tax_adj_amnt,2);

                // With tax
                $ytd_gross_income   = $aRow['gross_income_ytd'] + $gross_pay_2;
                $forecast_earnings  = $aRow['forecast_earnings'] - ($reg_pay * 13); //FIXED daw ito 13 working days for FORECAST ONLY 06182024 by Nessa
                $ytd_tax_exempt     = $aRow['less_ytd_tax_exempt'] + $pagibig_amnt + $phil_2_amnt + $eeshare; // Orig Code, added by JD as of 02-19-2024, due to adjustment of SSS & Philhealth. Noreen and Rara

                $tax_w_fcast_1      = ($ytd_gross_income + $forecast_earnings) - $ytd_tax_exempt;

                $floated_tax_w_fcast_1 = number_format((float)$tax_w_fcast_1, 2, '.', '');
                $tax_based = get_tax_annual($floated_tax_w_fcast_1);

                $rate_annl_earningsx = $ytd_gross_income / ($ytd_gross_income + $forecast_earnings);
                $rate_annl_earnings = number_format($rate_annl_earningsx,4);

                if ($tax_based == 124.99){
                    $with_tax = $tax_based;
                }else{
                    $with_tax1 = $tax_based * $rate_annl_earnings;
                    $with_tax2 = $with_tax1 - $aRow['yt_tax_withheld'];

                    if ($with_tax2 <= 124.99){
                        $with_tax = 124.99;
                    }       
                    /* 04042025 by Nessa */
                    else if ($with_tax2 <= 0){
                        $with_tax = 0;
                    }
                    else if ($with_tax2 > 124.99){
                        $with_tax = $with_tax1 - $aRow['yt_tax_withheld'];

                    }         
                    else{
                    $with_tax = $with_tax1 - $aRow['yt_tax_withheld'];
                    }


                }

                // $rem_cutoff = 24 - 14;
                $row[] = number_format($with_tax,2); // With tax

                // Net pay
                $all_deductions = $eeshare + $phil_2_amnt + $pagibig_amnt + $sss_loan_amnt + $sss_cal_loan_amnt + $sss_condo_loan_amnt + $pagibig_sal_loan_amnt + $pagibig_cal_loan_amnt + $pagibig_safe_loan_amnt + $hipar_amnt + $adv_deduc_amnt + $tax_adj_amnt + $with_tax;
                // $all_deductions = $eeshare + $phil_2_amnt + $pagibig_amnt + $sss_loan_amnt + $sss_cal_loan_amnt + $sss_condo_loan_amnt + $pagibig_sal_loan_amnt + $pagibig_cal_loan_amnt + $hipar_amnt + $adv_deduc_amnt + $tax_adj_amnt + $with_tax; // old
                // $all_deductions = $eeshare + $phil_2_amnt + $pagibig_amnt + $sss_loan_amnt + $sss_cal_loan_amnt + $pagibig_sal_loan_amnt + $pagibig_cal_loan_amnt + $hipar_amnt + $adv_deduc_amnt + $tax_adj_amnt + $aRow['yt_tax_withheld']; // Pang year-end lang
                $net_pay = $gross_pay_2 - $all_deductions; 
                $row[] = number_format($net_pay,2); // Net pay

            }else{ //Monthly & JSSS

                // Regular pay
                $reg_pay = $aRow['basic_salary'] / 2; 
                $row[] = number_format($reg_pay,2); // Regular pay

                // 13th
                $utm_1 = $daily_pay / 8; 
                $utm_2 = $utm_1 * $aRow['undertime']; 
                
                $sd_amnt = isset($aRow['sd_amount']) 
                ? floatval($aRow['sd_amount']) 
                : floatval("0.00");
                
                $bdl_amnts = isset($aRow['bdl_amount']) 
                ? floatval($aRow['bdl_amount']) 
                : floatval("0.00");

                $bdl_amnt     = $bdl_amnts * $daily_pay;
                $paid_leave     = $aRow['SL'] + $aRow['VL'];
                $unpaid_leave   = $aRow['absences'];
                $paid_amnt      = ($daily_pay * $paid_leave) + $sd_amnt + $bdl_amnt;
                $unpaid_amnt    = ($daily_pay * $unpaid_leave) + $utm_2;

                /**
                 * Commented on 01-17-2025
                 * With Rara
                 */
                // $terth_1 = $reg_pay + $paid_amnt; 
                // $terth_2 = $terth_1 - $unpaid_amnt; 
                // $terth_3 = $terth_2 - $utm_2; // Orig 1112024 with Noreen Rara
                // $terth_4 = $terth_3 / 12; // Orig 1112024 with Noreen Rara
                // $row[] = number_format($terth_4,2);  // 13th

                $terth_1 = $reg_pay + $paid_amnt; 
                $terth_2 = $terth_1 - $unpaid_amnt; 
                // $terth_3 = $terth_2 - $utm_2; // Orig 1112024 with Noreen Rara
                $terth_4 = $terth_2 / 12; // Orig 1112024 with Noreen Rara
                $row[] = number_format($terth_4,2);  // 13th

                // OT1
                $row[] = $aRow['reg_ot'];  // OT1

                // OT1 amnt
                $ot1_1x = $daily_pay / 8;
                $ot1_1 = number_format($ot1_1x,2);
                $ot1_2x = $ot1_1 * 1.25;
                $ot1_2 = sprintf('%0.4f', $ot1_2x);
                $ot1_3 = $ot1_2 * $aRow['reg_ot'];
                $row[] = number_format($ot1_3,2);  // OT1 amnt

                // OT2
                $row[] = $aRow['sun_special_hol_ot'];  // OT2

                // OT2 amnt
                $ot2_1x = $daily_pay / 8;
                $ot2_1 = sprintf('%0.2f', $ot2_1x);
                $ot2_2x = $ot2_1 * 1.5;
                $ot2_2 = sprintf('%0.4f', $ot2_2x);
                $ot2_3 = $ot2_2 * $aRow['sun_special_hol_ot'];
                $row[] = number_format($ot2_3,2);  // OT2 amnt

                // OT2A
                $row[] = $aRow['sun_special_hol_ot_ex_8_hrs'];  // OT2A

                // OT2A amnt
                $ot2a_1x = $daily_pay / 8;
                $ot2a_1 = sprintf('%0.4f', $ot2a_1x);
                $ot2a_2x = $ot2a_1 * 1.95;
                $ot2a_2 = sprintf('%0.4f', $ot2a_2x);
                $ot2a_3 = $ot2a_2 * $aRow['sun_special_hol_ot_ex_8_hrs'];
                $row[] = number_format($ot2a_3,2);  // OT2A amnt

                // OT3
                $row[] = $aRow['sun_ot'];  // OT3

                // OT3 amnt
                $ot3_1x = $daily_pay / 8;
                $ot3_1 = sprintf('%0.4f', $ot3_1x);
                $ot3_2x = $ot3_1 * 1.30;
                $ot3_2 = sprintf('%0.4f', $ot3_2x);
                $ot3_3 = $ot3_2 * $aRow['sun_ot'];
                $row[] = number_format($ot3_3,2);  // OT3 amnt

                // OT3A
                $row[] = $aRow['sun_ot_ex_8_hrs'];  // OT3A

                // OT3A amnt
                $ot3a_1x = $daily_pay / 8;
                $ot3a_1 = sprintf('%0.4f', $ot3a_1x);
                $ot3a_2x = $ot3a_1 * 1.69;
                $ot3a_2 = sprintf('%0.4f', $ot3a_2x);
                $ot3a_3 = $ot3a_2 * $aRow['sun_ot_ex_8_hrs'];
                $row[] = number_format($ot3a_3,2);  // OT3A amnt

                // OT4
                $row[] = $aRow['sun_legal_hol'];  // OT4    

                // OT4 amnt
                $ot4_1x = $daily_pay / 8;
                $ot4_1 = sprintf('%0.4f', $ot4_1x);
                $ot4_2x = $ot4_1 * 2.6;
                $ot4_2 = sprintf('%0.4f', $ot4_2x);
                $ot4_3 = $ot4_2 * $aRow['sun_legal_hol'];
                $row[] = number_format($ot4_3,2);  // OT4 amnt

                // OT4A
                $row[] = $aRow['sun_legal_hol_ex_8_hrs'];  // OT4A

                // OT4A amnt
                $ot4a_1x = $daily_pay / 8;
                $ot4a_1 = sprintf('%0.4f', $ot4a_1x);
                $ot4a_2x = $ot4a_1 * 3.38;
                $ot4a_2 = sprintf('%0.4f', $ot4a_2x);
                $ot4a_3 = $ot4a_2 * $aRow['sun_legal_hol_ex_8_hrs'];
                $row[] = number_format($ot4a_3,2);  // OT4A amnt

                // OT5
                $row[] = $aRow['special_non_work_hol'];  // OT5

                // OT5 amnt
                $ot5_1x = $daily_pay / 8;
                $ot5_1 = sprintf('%0.4f', $ot5_1x);
                $ot5_2x = $ot5_1 * 0.3; // Modified by JD as of 03-04-2024 with Rara
                $ot5_2 = sprintf('%0.4f', $ot5_2x);
                $ot5_3 = $ot5_2 * $aRow['special_non_work_hol'];
                $row[] = number_format($ot5_3,2);  // OT5 amnt

                // OT5A
                $row[] = $aRow['special_non_work_hol_ex_8_hrs'];  // OT5A

                // OT5A amnt
                $ot5a_1x = $daily_pay / 8;
                $ot5a_1 = sprintf('%0.4f', $ot5a_1x);
                $ot5a_2x = $ot5a_1 * 1.69;
                $ot5a_2 = sprintf('%0.4f', $ot5a_2x);
                $ot5a_3 = $ot5a_2 * $aRow['special_non_work_hol_ex_8_hrs'];
                $row[] = number_format($ot5a_3,2);  // OT5A amnt

                // OT6
                $row[] = $aRow['legal_hol'];  // OT6    

                // OT6 amnt
                $ot6_1x = $daily_pay / 8;
                $ot6_1 = sprintf('%0.4f', $ot6_1x);
                $ot6_2x = $ot6_1 * 1; // 0502024
                $ot6_2 = sprintf('%0.4f', $ot6_2x);
                $ot6_3 = $ot6_2 * $aRow['legal_hol'];
                $row[] = number_format($ot6_3,2);  // OT6 amnt

                // OT6A
                $row[] = $aRow['legal_hol_ex_8_hrs'];  // OT6A

                // OT6A amnt
                $ot6a_1x = $daily_pay / 8;
                $ot6a_1 = sprintf('%0.4f', $ot6a_1x);
                $ot6a_2x = $ot6a_1 * 2.6;
                $ot6a_2 = sprintf('%0.4f', $ot6a_2x);
                $ot6a_3 = $ot6a_2 * $aRow['legal_hol_ex_8_hrs'];
                $row[] = number_format($ot6a_3,2);  // OT6A amnt

                // night diff
                $row[] = $aRow['night_diff']; // night diff

                // night diff amnt
                $nd_1x = $daily_pay * 0.10;
                $nd_1 = sprintf('%0.4f', $nd_1x);
                $nd_2 = $nd_1 * $aRow['night_diff'];
                $nd_3x = $nd_2 / 8;
                $nd_3 = sprintf('%0.4f', $nd_3x);
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
                $bdl = isset($aRow['bdl_amount']) 
                ? floatval($aRow['bdl_amount']) 
                : floatval("0.00"); // BDL
                $row[] = number_format($bdl,2);

                // BDL amnt
                $bdl_1 = isset($aRow['bdl_amount']) 
                ? floatval($aRow['bdl_amount']) 
                : floatval("0.00");
                $bdl_1 = $bdl_1 * $daily_pay;
                $row[] = number_format($bdl_1,2); // BDL amnt

               // SD
                $sd = isset($aRow['sd_amount']) 
                ? floatval($aRow['sd_amount']) 
                : floatval("0.00");
                $sd = $sd / 100;          
                $row[] = number_format($sd,2);

                // SD amnt
                $sd_amnt = isset($aRow['sd_amount']) 
                ? floatval($aRow['sd_amount']) 
                : floatval("0.00");
                $row[] = number_format($sd_amnt,2);


                // ecola 
                if ($aRow['ecola'] > 0){
                    $ecola_1 = 13 - $unpaid_leave + $aRow['SL'] + $aRow['VL'] + $bdl + $sd; // working days = 13
                    $ecola_2 = $ecola_1 * $aRow['ecola']; // working days = 13

                    $row[] = number_format($ecola_2,2); // ecola
                }else{
                    $ecola_2 = 0;
                    $row[] = number_format($ecola_2,2); // ecola
                }

                // Salary adjustments
                $salary_adjustments = isset($aRow['salary_adjustments']) 
                ? floatval($aRow['salary_adjustments']) 
                : floatval("0.00");
                $row[] = number_format($salary_adjustments,2);

                // Allowance
                $allowance = $aRow['allowance'] / 2; // Allowance
                $row[] = $allowance; // Allowance

                // CTPA
                $row[] = 0; // CTPA

                // Socio Eco. allow
                $row[] = 0; // Socio Eco. allow

                // Other Earnings
                $other_earnings = isset($aRow['bt_other_earnings']) 
                ? floatval($aRow['bt_other_earnings']) 
                : floatval("0.00");
                $row[] = number_format($other_earnings,2);

                // absences
                $row[] = $unpaid_leave; // absences

                // absences amnt
                $abs_amntx = $daily_pay * $unpaid_leave; 
                $abs_amnt = sprintf('%0.4f', $abs_amntx);
                $row[] = number_format($abs_amnt,2); //absences amnt

                // undertime
                $row[] = $aRow['undertime']; // undertime

                // undertime amnt
                $ut_1x = $daily_pay / 8; 
                $ut_1 = sprintf('%0.4f', $ut_1x);
                $ut_2 = $ut_1 * $aRow['undertime']; 
                $row[] = number_format($ut_2,2); //undertime amnt            

                // gross pay
                $ot_nd = $ot1_3 + $ot2_3 + $ot2a_3 + $ot3_3 + $ot3a_3 + $ot4_3 + $ot4a_3 + $ot5_3 + $ot5a_3 + $ot6_3 + $ot6a_3 + $nd_3;
                $leaves = $sl_1 + $vl_1 + $bl_1 + $bdl_1 + $sd_amnt;
                $absent_ut = $abs_amnt + $ut_2;

                /* Original Code */
                $gross_pay_1 = $reg_pay + $ot_nd + $leaves + $ecola_2 + $allowance + $salary_adjustments + $other_earnings;
                $gross_pay_2 = $gross_pay_1 - $absent_ut;
                $row[] = number_format($gross_pay_2,2); // gross pay

                $prev_gross = $aRow['prev_gross_pay'];
                $comp_gross_pay = $prev_gross + $gross_pay_2;
                $floated_comp_gross_pay =  number_format((float)$comp_gross_pay, 2, '.', '');

                // sss premiums//
                $eeshare = isset($aRow['s_other_earnings']) 
                ? floatval($aRow['s_other_earnings']) 
                : floatval("0.00");
                $row[] = number_format($eeshare,2);

                // phil premiums
                $phil_2_amnt = isset($aRow['ph_other_earnings']) 
                ? floatval($aRow['ph_other_earnings']) 
                : floatval('0.00'); 
                $row[] = number_format($phil_2_amnt,2);

                // pagibig
                $pagibig_amnt = 200; 
                $row[] = number_format($pagibig_amnt,2);

                // sss loan
                $sss_loan_amnt = isset($aRow['sssl_charge_amount']) 
                ? floatval($aRow['sssl_charge_amount']) 
                : floatval("0.00");
                $row[] = number_format($sss_loan_amnt,2);

                // sss cal loan
                $sss_cal_loan_amnt = isset($aRow['ssscl_charge_amount']) 
                ? floatval($aRow['ssscl_charge_amount']) 
                : floatval("0.00");
                $row[] = number_format($sss_cal_loan_amnt,2);

                // sss condonation
                $sss_condo_loan_amnt = isset($aRow['ssscon_charge_amount']) 
                ? floatval($aRow['ssscon_charge_amount']) 
                : floatval("0.00");
                $row[] = number_format($sss_condo_loan_amnt,2);

                // pagibig sal loan
                $pagibig_sal_loan_amnt = isset($aRow['loan_amount']) 
                ? floatval($aRow['loan_amount']) 
                : floatval("0.00");
                $row[] = number_format($pagibig_sal_loan_amnt,2);

                // pagibig cal loan
                $pagibig_cal_loan_amnt = isset($aRow['calamity_loan_amount']) 
                ? floatval($aRow['calamity_loan_amount']) 
                : floatval("0.00");
                $row[] = number_format($pagibig_cal_loan_amnt,2);

                // pagibig safe loan
                $pagibig_safe_loan_amnt = isset($aRow['safe_loan_amount']) 
                ? floatval($aRow['safe_loan_amount']) 
                : floatval("0.00");
                $row[] = number_format($pagibig_safe_loan_amnt,2);

                // hipar or HMO
                $hipar_amnt = isset($aRow['hmo_amount']) 
                ? floatval($aRow['hmo_amount']) 
                : floatval("0.00");
                $row[] = number_format($hipar_amnt,2);

                // advances other deductions
                $adv_deduc_amnt = isset($aRow['advances_other_deductions']) 
                ? floatval($aRow['advances_other_deductions']) 
                : floatval("0.00");
                $row[] = number_format($adv_deduc_amnt,2);

                // Tax Adjustment
                $tax_adj_amnt = isset($aRow['tax_adjustments']) 
                ? floatval($aRow['tax_adjustments']) 
                : floatval("0.00");
                $row[] = number_format($tax_adj_amnt,2);

                // With tax
                $ytd_gross_income   = $aRow['gross_income_ytd'] + $gross_pay_2;
                $forecast_earnings  = $aRow['forecast_earnings'] - $reg_pay;
                $ytd_tax_exempt     = $aRow['less_ytd_tax_exempt'] + $pagibig_amnt + $phil_2_amnt + $eeshare; // Orig Code, added by JD as of 02-19-2024, due to adjustment of SSS & Philhealth. Noreen and Rara

                $tax_w_fcast_1      = ($ytd_gross_income + $forecast_earnings) - $ytd_tax_exempt;

                $floated_tax_w_fcast_1 = number_format((float)$tax_w_fcast_1, 2, '.', '');
                $tax_based = get_tax_annual($floated_tax_w_fcast_1);

                $rate_annl_earningsx = $ytd_gross_income / ($ytd_gross_income + $forecast_earnings);
                $rate_annl_earnings = number_format($rate_annl_earningsx,4);

                if ($tax_based == 124.99){
                    $with_tax = $tax_based;
                }else{
                    $with_tax1 = $tax_based * $rate_annl_earnings;
                    $with_tax2 = $with_tax1 - $aRow['yt_tax_withheld'];

                    if ($with_tax2 <= 124.99){
                        $with_tax = 124.99;
                    }else{
                        $with_tax = $with_tax1 - $aRow['yt_tax_withheld'];
                    }
                }

                $row[] = number_format($with_tax,2); // With tax

                // Net pay
                // $all_deductions = $eeshare + $phil_2_amnt + $pagibig_amnt + $sss_loan_amnt + $sss_cal_loan_amnt + $sss_condo_loan_amnt + $pagibig_sal_loan_amnt + $pagibig_cal_loan_amnt + $hipar_amnt + $adv_deduc_amnt + $tax_adj_amnt + $with_tax; // old
                $all_deductions = $eeshare + $phil_2_amnt + $pagibig_amnt + $sss_loan_amnt + $sss_cal_loan_amnt + $sss_condo_loan_amnt + $pagibig_sal_loan_amnt + $pagibig_cal_loan_amnt + $pagibig_safe_loan_amnt + $hipar_amnt + $adv_deduc_amnt + $tax_adj_amnt + $with_tax;
                $net_pay = $gross_pay_2 - $all_deductions; 
                $row[] = number_format($net_pay,2); // Net pay

            } //end if else

        }else{ // Last Cutoff formula

            if ($aRow['emp_code'] == 1){ //Daily

                // Regular pay
                $reg_pay = $aRow['basic_salary']; 
                $row[] = number_format($reg_pay,2); // Regular pay

                // 13th
                $utm_1 = $reg_pay / 8; 
                $utm_2 = $utm_1 * $aRow['undertime']; 

                $sd_amnt = isset($aRow['sd_amount']) 
                ? floatval($aRow['sd_amount']) 
                : floatval("0.00");
                
                $bdl_amnt = isset($aRow['bdl_amount']) 
                ? floatval($aRow['bdl_amount']) 
                : floatval("0.00");

                $paid_leave     = $aRow['SL'] + $aRow['VL'];
                $unpaid_leave   = $aRow['absences'];
                $bdl_amnts      = $bdl_amnt * $reg_pay;
                $paid_amnt      = ($reg_pay * $paid_leave) + $sd_amnt + $bdl_amnts;
                $unpaid_amnt    = ($reg_pay * $unpaid_leave) + $utm_2;

                $terth_1 = ($reg_pay * $wd) + $paid_amnt; 
                $terth_2 = $terth_1 - $unpaid_amnt; 
                $terth_4 = $terth_2 / 12; 
                $row[] = number_format($terth_4,2);  // 13th

                // OT1
                $row[] = $aRow['reg_ot'];  // OT1

                // OT1 amnt
                $ot1_1 = $reg_pay / 8;
                $ot1_2 = $ot1_1 * 1.25;
                $ot1_3 = $ot1_2 * $aRow['reg_ot'];
                $row[] = number_format($ot1_3,2);  // OT1 amnt

                // OT2
                $row[] = $aRow['sun_special_hol_ot'];  // OT2

                // OT2 amnt
                $ot2_1 = $reg_pay / 8;
                $ot2_2 = $ot2_1 * 1.5;
                $ot2_3 = $ot2_2 * $aRow['sun_special_hol_ot'];
                $row[] = number_format($ot2_3,2);  // OT2 amnt

                // OT2A
                $row[] = $aRow['sun_special_hol_ot_ex_8_hrs'];  // OT2A

                // OT2A amnt
                $ot2a_1 = $reg_pay / 8;
                $ot2a_2 = $ot2a_1 * 1.95;
                $ot2a_3 = $ot2a_2 * $aRow['sun_special_hol_ot_ex_8_hrs'];
                $row[] = number_format($ot2a_3,2);  // OT2A amnt

                // OT3
                $row[] = $aRow['sun_ot'];  // OT3

                // OT3 amnt
                $ot3_1 = $reg_pay / 8;
                $ot3_2 = $ot3_1 * 1.30;
                $ot3_3 = $ot3_2 * $aRow['sun_ot'];
                $row[] = number_format($ot3_3,2);  // OT3 amnt

                // OT3A
                $row[] = $aRow['sun_ot_ex_8_hrs'];  // OT3A

                // OT3A amnt
                $ot3a_1 = $reg_pay / 8;
                $ot3a_2 = $ot3a_1 * 1.69;
                $ot3a_3 = $ot3a_2 * $aRow['sun_ot_ex_8_hrs'];
                $row[] = number_format($ot3a_3,2);  // OT3A amnt

                // OT4
                $row[] = $aRow['sun_legal_hol'];  // OT4    

                // OT4 amnt
                $ot4_1 = $reg_pay / 8;
                $ot4_2 = $ot4_1 * 2.6;
                $ot4_3 = $ot4_2 * $aRow['sun_legal_hol'];
                $row[] = number_format($ot4_3,2);  // OT4 amnt

                // OT4A
                $row[] = $aRow['sun_legal_hol_ex_8_hrs'];  // OT4A

                // OT4A amnt
                $ot4a_1 = $reg_pay / 8;
                $ot4a_2 = $ot4a_1 * 3.38;
                $ot4a_3 = $ot4a_2 * $aRow['sun_legal_hol_ex_8_hrs'];
                $row[] = number_format($ot4a_3,2);  // OT4A amnt

                // OT5
                $row[] = $aRow['special_non_work_hol'];  // OT5

                // OT5 amnt
                $ot5_1 = $reg_pay / 8;
                $ot5_2 = $ot5_1 * 1.3; // 05162024 by Nessa
                $ot5_3 = $ot5_2 * $aRow['special_non_work_hol'];
                $row[] = number_format($ot5_3,2);  // OT5 amnt

                // OT5A
                $row[] = $aRow['special_non_work_hol_ex_8_hrs'];  // OT5A

                // OT5A amnt
                $ot5a_1 = $reg_pay / 8;
                $ot5a_2 = $ot5a_1 * 1.69;
                $ot5a_3 = $ot5a_2 * $aRow['special_non_work_hol_ex_8_hrs'];
                $row[] = number_format($ot5a_3,2);  // OT5A amnt

                // OT6
                $row[] = $aRow['legal_hol'];  // OT6    

                // OT6 amnt
                $ot6_1 = $reg_pay / 8;
                $ot6_2 = $ot6_1 * 1; // 05022024
                $ot6_3 = $ot6_2 * $aRow['legal_hol'];
                $row[] = number_format($ot6_3,2);  // OT6 amnt

                // OT6A
                $row[] = $aRow['legal_hol_ex_8_hrs'];  // OT6A

                // OT6A amnt
                $ot6a_1 = $reg_pay / 8;
                $ot6a_2 = $ot6a_1 * 2.6;
                $ot6a_3 = $ot6a_2 * $aRow['legal_hol_ex_8_hrs'];
                $row[] = number_format($ot6a_3,2);  // OT6A amnt

                // night diff
                $row[] = $aRow['night_diff']; // night diff

                // night diff amnt
                $nd_1 = $reg_pay * 0.10;
                $nd_2 = $nd_1 * $aRow['night_diff'];
                $nd_3 = $nd_2 / 8;
                $row[] = number_format($nd_3,2); // night diff amnt

                // SL
                $row[] = $aRow['SL']; // SL

                // SL amnt
                $sl_1 = $reg_pay * $aRow['SL']; 
                $row[] = number_format($sl_1,2); // SL amnt

                // VL
                $row[] = $aRow['VL']; // VL

                // VL amnt
                $vl_1 = $reg_pay * $aRow['VL']; 
                $row[] = number_format($vl_1,2); // VL amnt

                /* for checking ng value */
                // BL
                $row[] = 0; // BL

                // BL amnt
                $bl_1 = 0; 
                $row[] = number_format($bl_1,2); // BL amnt


                // BDL
                $bdl = isset($aRow['bdl_amount']) 
                ? floatval($aRow['bdl_amount']) 
                : floatval("0.00"); // BDL
                $row[] = number_format($bdl,2);

                // BDL amnt
                $bdl_1 = isset($aRow['bdl_amount']) 
                ? floatval($aRow['bdl_amount']) 
                : floatval("0.00");
                $bdl_1 = $bdl_1 * $reg_pay;
                $row[] = number_format($bdl_1,2); // BDL amnt

               // SD
                $sd = isset($aRow['sd_amount']) 
                ? floatval($aRow['sd_amount']) 
                : floatval("0.00");
                $sd = $sd / 100;          
                $row[] = number_format($sd,2);

                // SD amnt
                $sd_amnt = isset($aRow['sd_amount']) 
                ? floatval($aRow['sd_amount']) 
                : floatval("0.00");
                $row[] = number_format($sd_amnt,2);

                // ecola 
                if ($aRow['ecola'] > 0){
                    $ecola_1 = ($wd - $unpaid_leave) + $aRow['SL'] + $aRow['VL'] + $bdl + $sd; 
                    $ecola_2 = $ecola_1 * $aRow['ecola']; // working days = 13

                    $row[] = number_format($ecola_2,2); // ecola
                }else{
                    $ecola_2 = 0;
                    $row[] = number_format($ecola_2,2); // ecola
                }

                // Salary adjustments
                $salary_adjustments = isset($aRow['salary_adjustments']) 
                ? floatval($aRow['salary_adjustments']) 
                : floatval("0.00");
                $row[] = number_format($salary_adjustments,2);

                // Allowance
                $allowance = $aRow['allowance'] / 2; // Allowance
                $row[] = $allowance; // Allowance

                // CTPA
                $row[] = 0; // CTPA

                // Socio Eco. allow
                $row[] = 0; // Socio Eco. allow

                // Other Earnings
                $other_earnings = isset($aRow['other_earnings']) 
                ? floatval($aRow['other_earnings']) 
                : floatval("0.00");
                $row[] = number_format($other_earnings,2);

                // absences
                $row[] = $unpaid_leave; // absences

                // absences amnt
                $abs_amnt = $reg_pay * $unpaid_leave; 
                $row[] = number_format($abs_amnt,2); //absences amnt

                // undertime
                $row[] = $aRow['undertime']; // undertime

                // undertime amnt
                $ut_1 = $reg_pay / 8; 
                $ut_2 = $ut_1 * $aRow['undertime']; 
                $row[] = number_format($ut_2,2); //undertime amnt            

                // gross pay
                $ot_nd = $ot1_3 + $ot2_3 + $ot2a_3 + $ot3_3 + $ot3a_3 + $ot4_3 + $ot4a_3 + $ot5_3 + $ot5a_3 + $ot6_3 + $ot6a_3 + $nd_3;
                $leaves = $sl_1 + $vl_1 + $bl_1 + $bdl_1 + $sd_amnt;
                $absent_ut = $abs_amnt + $ut_2;

                $gross_pay_1 = ($reg_pay * $wd) + $ot_nd + $leaves + $ecola_2 + $allowance + $salary_adjustments + $other_earnings; //working days 13
                $gross_pay_2 = $gross_pay_1 - $absent_ut;
                $row[] = number_format($gross_pay_2,2); // gross pay

                $prev_gross = $aRow['prev_gross_pay']; // Orig code commented on 04-03-2024 by JD

                $comp_gross_pay = $prev_gross + $gross_pay_2;
                $floated_comp_gross_pay =  number_format((float)$comp_gross_pay, 2, '.', '');

                $eeshare = get_sss($floated_comp_gross_pay);
                $row[] = $eeshare;

                // phil premiums
                $phil_1_amnt = ($reg_pay * 26) * 0.05;     // 02132024 as requested
                $phil_2_amnt = $phil_1_amnt / 2;
                $row[] = number_format($phil_2_amnt,2);

                // pagibig
                $pagibig_amnt = 0;
                $row[] = number_format($pagibig_amnt,2);

                // sss loan
                $sss_loan_amnt = isset($aRow['sssl_charge_amount']) 
                ? floatval($aRow['sssl_charge_amount']) 
                : floatval("0.00");
                $row[] = number_format($sss_loan_amnt,2);


                // sss cal loan
                $sss_cal_loan_amnt = isset($aRow['ssscl_charge_amount']) 
                ? floatval($aRow['ssscl_charge_amount']) 
                : floatval("0.00");
                $row[] = number_format($sss_cal_loan_amnt,2);

                // sss condonation
                $sss_condo_loan_amnt = isset($aRow['ssscon_charge_amount']) 
                ? floatval($aRow['ssscon_charge_amount']) 
                : floatval("0.00");
                $row[] = number_format($sss_condo_loan_amnt,2);

                // pagibig sal loan
                $pagibig_sal_loan_amnt = isset($aRow['loan_amount']) 
                ? floatval($aRow['loan_amount']) 
                : floatval("0.00");
                $row[] = number_format($pagibig_sal_loan_amnt,2);

                // pagibig cal loan
                $pagibig_cal_loan_amnt = isset($aRow['calamity_loan_amount']) 
                ? floatval($aRow['calamity_loan_amount']) 
                : floatval("0.00");
                $row[] = number_format($pagibig_cal_loan_amnt,2);

                // pagibig safe loan
                $pagibig_safe_loan_amnt = isset($aRow['safe_loan_amount']) 
                ? floatval($aRow['safe_loan_amount']) 
                : floatval("0.00");
                $row[] = number_format($pagibig_safe_loan_amnt,2);


                // hipar
                $hipar_amnt = isset($aRow['hmo_amount']) 
                ? floatval($aRow['hmo_amount']) 
                : floatval("0.00");
                $row[] = number_format($hipar_amnt,2);


                // advances other deductions
                $adv_deduc_amnt = isset($aRow['advances_other_deductions']) 
                ? floatval($aRow['advances_other_deductions']) 
                : floatval("0.00");
                $row[] = number_format($adv_deduc_amnt,2);

                // Tax Adjustment
                $tax_adj_amnt = isset($aRow['tax_adjustments']) 
                ? floatval($aRow['tax_adjustments']) 
                : floatval("0.00");
                $row[] = number_format($tax_adj_amnt,2);

                // With tax
                $ytd_gross_income   = $aRow['gross_income_ytd'] + $gross_pay_2; //orig
                $forecast_earnings  = $aRow['forecast_earnings'] - ($reg_pay * 13); //FIXED 07032024 by Nessa as requested // orig
                // $forecast_earnings  = 0; // uncomment pag ANNUAL
                $ytd_tax_exempt     = $aRow['less_ytd_tax_exempt'] + $eeshare + $phil_2_amnt; // orig
                $tax_w_fcast_1      = ($ytd_gross_income + $forecast_earnings) - $ytd_tax_exempt;

                $floated_tax_w_fcast_1 = number_format((float)$tax_w_fcast_1, 2, '.', '');
                $tax_based = get_tax_annual($floated_tax_w_fcast_1);

                $rate_annl_earningsx = $ytd_gross_income / ($ytd_gross_income + $forecast_earnings);
                $rate_annl_earnings = number_format($rate_annl_earningsx,4);

                if ($tax_based == 124.99){
                    $with_tax = $tax_based;
                }                
                else{
                    $with_tax1 = $tax_based * $rate_annl_earnings; // NEED FOR ANNUAL
                    $with_tax2 = $with_tax1 - $aRow['yt_tax_withheld'];
                    
                    // orig
                    if ($with_tax2 <= 124.99){
                        $with_tax = 124.99;
                    }

                    /* 04042025 by Nessa */
                    else if ($with_tax2 <= 0){
                        $with_tax = 0;
                    }
                    else if ($with_tax2 > 124.99){
                        $with_tax = $with_tax1 - $aRow['yt_tax_withheld'];

                    }
                                      
                    else{
                        $with_tax = $with_tax1 - $aRow['yt_tax_withheld'];
                    }
                    
                    // $with_tax = ($with_tax1 - $aRow['yt_tax_withheld']) - $aRow['leaves_taxes']; // FOR ANNUAL
                    

                }

                $row[] = number_format($with_tax,2); // With tax old

                // Net pay
                // $all_deductions = $eeshare + $phil_2_amnt + $pagibig_amnt + $sss_loan_amnt + $sss_cal_loan_amnt + $sss_condo_loan_amnt + $pagibig_sal_loan_amnt + $pagibig_cal_loan_amnt + $hipar_amnt + $adv_deduc_amnt + $tax_adj_amnt + $with_tax;// old
                $all_deductions = $eeshare + $phil_2_amnt + $pagibig_amnt + $sss_loan_amnt + $sss_cal_loan_amnt + $sss_condo_loan_amnt + $pagibig_sal_loan_amnt + $pagibig_cal_loan_amnt + $pagibig_safe_loan_amnt + $hipar_amnt + $adv_deduc_amnt + $tax_adj_amnt + $with_tax; 
                $net_pay = $gross_pay_2 - $all_deductions; 
                $row[] = number_format($net_pay,2); // Net pay


            }else{ //Monthly & JSSS
                
                // Regular pay
                $reg_pay = $aRow['basic_salary'] / 2; 
                $row[] = number_format($reg_pay,2); // Regular pay
                
                // 13th
                // $utm_1 = $daily_pay / 8; 
                // $utm_2 = $utm_1 * $aRow['undertime']; 
                
                // $sd_amnt = isset($aRow['sd_amount']) 
                // ? floatval($aRow['sd_amount']) 
                // : floatval("0.00");
                
                // $bdl_amnt = isset($aRow['bdl_amount']) 
                // ? floatval($aRow['bdl_amount']) 
                // : floatval("0.00");


                // $paid_leave     = $aRow['SL'] + $aRow['VL'];
                // $unpaid_leave   = $aRow['absences'];
                // $sd_amnts       = $sd_amnt * $daily_pay;
                // $bdl_amnts      = $bdl_amnt * $daily_pay;
                // $paid_amnt      = ($daily_pay * $paid_leave) + $sd_amnts + $bdl_amnts;
                // $unpaid_amnt    = ($daily_pay * $unpaid_leave) + $utm_2;

                // $terth_1 = $reg_pay + $paid_amnt; 
                // $terth_2 = $terth_1 - $unpaid_amnt; 
                // $terth_4 = $terth_2 / 12; 
                // $row[] = number_format($terth_4,2);  // 13th

                // 13th
                $utm_1 = $daily_pay / 8; 
                $utm_2 = $utm_1 * $aRow['undertime']; 
                
                $sd_amnt = isset($aRow['sd_amount']) 
                ? floatval($aRow['sd_amount']) 
                : floatval("0.00");
                
                $bdl_amnts = isset($aRow['bdl_amount']) 
                ? floatval($aRow['bdl_amount']) 
                : floatval("0.00");

                $bdl_amnt     	= $bdl_amnts * $daily_pay;
                $paid_leave     = $aRow['SL'] + $aRow['VL'];
                $unpaid_leave   = $aRow['absences'];
                $paid_amnt      = ($daily_pay * $paid_leave) + $sd_amnt + $bdl_amnt;
                $unpaid_amnt    = ($daily_pay * $unpaid_leave) + $utm_2;

                /**
                 * Commented on 01-17-2025
                 * With Rara
                 */
                // $terth_1 = $reg_pay + $paid_amnt; 
                // $terth_2 = $terth_1 - $unpaid_amnt; 
                // $terth_3 = $terth_2 - $utm_2; // Orig 1112024 with Noreen Rara
                // $terth_4 = $terth_3 / 12; // Orig 1112024 with Noreen Rara
                // $row[] = number_format($terth_4,2);  // 13th

                $terth_1 = $reg_pay + $paid_amnt; 
                $terth_2 = $terth_1 - $unpaid_amnt; 
                // $terth_3 = $terth_2 - $utm_2; // Orig 1112024 with Noreen Rara
                $terth_4 = $terth_2 / 12; // Orig 1112024 with Noreen Rara
                $row[] = number_format($terth_4,2);  // 13th


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
                $ot5_2 = $ot5_1 * 0.30; // Added by JD as of 03-04-2024 with Rara
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
                $ot6_2 = $ot6_1 * 1; // 05022024
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
                $bdl = isset($aRow['bdl_amount']) 
                ? floatval($aRow['bdl_amount']) 
                : floatval("0.00"); // BDL
                $row[] = number_format($bdl,2);

                // BDL amnt
                $bdl_1 = isset($aRow['bdl_amount']) 
                ? floatval($aRow['bdl_amount']) 
                : floatval("0.00");
                $bdl_1 = $bdl_1 * $daily_pay;
                $row[] = number_format($bdl_1,2); // BDL amnt

                // SD
                $sd = isset($aRow['sd_amount']) 
                ? floatval($aRow['sd_amount']) 
                : floatval("0.00");
                $sd = $sd / 100;          
                $row[] = number_format($sd,2);

                // SD amnt
                $sd_amnt = isset($aRow['sd_amount']) 
                ? floatval($aRow['sd_amount']) 
                : floatval("0.00");
                $row[] = number_format($sd_amnt,2);

                // ecola 
                if ($aRow['ecola'] > 0){
                $ecola_1 = ($wd - $unpaid_leave); // working days = 13
                $ecola_2 = $ecola_1 * $aRow['ecola']; // working days = 13

                $row[] = number_format($ecola_2,2); // ecola
                }else{
                $ecola_2 = 0;
                $row[] = number_format($ecola_2,2); // ecola
                }

                // Salary adjustments
                $salary_adjustments = isset($aRow['salary_adjustments']) 
                ? floatval($aRow['salary_adjustments']) 
                : floatval("0.00");
                $row[] = number_format($salary_adjustments,2);

                // Allowance
                $allowance = $aRow['allowance'] / 2; // Allowance
                $row[] = $allowance; // Allowance

                // CTPA
                $row[] = 0; // CTPA

                // Socio Eco. allow
                $row[] = 0; // Socio Eco. allow

                // Other Earnings
                $other_earnings = isset($aRow['other_earnings']) 
                ? floatval($aRow['other_earnings']) 
                : floatval("0.00");
                $row[] = number_format($other_earnings,2);

                // absences
                $row[] = $unpaid_leave; // absences

                // absences amnt
                $abs_amnt = $daily_pay * $unpaid_leave; 
                $row[] = number_format($abs_amnt,2); //absences amnt

                // undertime
                $row[] = $aRow['undertime']; // undertime

                // undertime amnt
                $ut_1 = $daily_pay / 8; 
                $ut_2 = $ut_1 * $aRow['undertime']; 
                $row[] = number_format($ut_2,2); //undertime amnt            

                // gross pay
                $ot_nd = $ot1_3 + $ot2_3 + $ot2a_3 + $ot3_3 + $ot3a_3 + $ot4_3 + $ot4a_3 + $ot5_3 + $ot5a_3 + $ot6_3 + $ot6a_3 + $nd_3;
                $leaves = $sl_1 + $vl_1 + $bl_1 + $bdl_1 + $sd_amnt;
                $absent_ut = $abs_amnt + $ut_2;

                /* Original Code */
                $gross_pay_1 = $reg_pay + $ot_nd + $leaves + $ecola_2 + $allowance + $salary_adjustments + $other_earnings;
                $gross_pay_2 = $gross_pay_1 - $absent_ut;
                $row[] = number_format($gross_pay_2,2); // gross pay

                $prev_gross = $aRow['prev_gross_pay'];
                $comp_gross_pay = $prev_gross + $gross_pay_2;
                $floated_comp_gross_pay =  number_format((float)$comp_gross_pay, 2, '.', '');

                $eeshare = get_sss($floated_comp_gross_pay);
                $row[] = $eeshare;

                // phil premiums
                $phil_1_amnt = $monthly_pay * 0.05;   // 02132024 as requested  
                $phil_2_amnt = $phil_1_amnt / 2;
                $row[] = number_format($phil_2_amnt,2);

                // pagibig
                $pagibig_amnt = 0;
                $row[] = number_format($pagibig_amnt,2);

                // sss loan
                $sss_loan_amnt = isset($aRow['sssl_charge_amount']) 
                ? floatval($aRow['sssl_charge_amount']) 
                : floatval("0.00");
                $row[] = number_format($sss_loan_amnt,2);

                // sss cal loan
                $sss_cal_loan_amnt = isset($aRow['ssscl_charge_amount']) 
                ? floatval($aRow['ssscl_charge_amount']) 
                : floatval("0.00");
                $row[] = number_format($sss_cal_loan_amnt,2);

                // sss condonation
                $sss_condo_loan_amnt = isset($aRow['ssscon_charge_amount']) 
                ? floatval($aRow['ssscon_charge_amount']) 
                : floatval("0.00");
                $row[] = number_format($sss_condo_loan_amnt,2);

                // pagibig sal loan
                $pagibig_sal_loan_amnt = isset($aRow['loan_amount']) 
                ? floatval($aRow['loan_amount']) 
                : floatval("0.00");
                $row[] = number_format($pagibig_sal_loan_amnt,2);

                // pagibig cal loan
                $pagibig_cal_loan_amnt = isset($aRow['calamity_loan_amount']) 
                ? floatval($aRow['calamity_loan_amount']) 
                : floatval("0.00");
                $row[] = number_format($pagibig_cal_loan_amnt,2);

                // pagibig safe loan
                $pagibig_safe_loan_amnt = isset($aRow['safe_loan_amount']) 
                ? floatval($aRow['safe_loan_amount']) 
                : floatval("0.00");
                $row[] = number_format($pagibig_safe_loan_amnt,2);
                    
                // hipar
                $hipar_amnt = isset($aRow['hmo_amount']) 
                ? floatval($aRow['hmo_amount']) 
                : floatval("0.00");
                $row[] = number_format($hipar_amnt,2);

                // advances other deductions
                $adv_deduc_amnt = isset($aRow['advances_other_deductions']) 
                ? floatval($aRow['advances_other_deductions']) 
                : floatval("0.00");
                $row[] = number_format($adv_deduc_amnt,2);

                // Tax Adjustment
                $tax_adj_amnt = isset($aRow['tax_adjustments']) 
                ? floatval($aRow['tax_adjustments']) 
                : floatval("0.00");
                $row[] = number_format($tax_adj_amnt,2);

                // With tax
                $ytd_gross_income   = $aRow['gross_income_ytd'] + $gross_pay_2; // orig
                $forecast_earnings  = $aRow['forecast_earnings'] - $reg_pay; //orig
                // $forecast_earnings  = 0; // For Annual
                $ytd_tax_exempt     = $aRow['less_ytd_tax_exempt'] + $eeshare + $phil_2_amnt; //orig
                $tax_w_fcast_1      = ($ytd_gross_income + $forecast_earnings) - $ytd_tax_exempt; // orig
                
                $floated_tax_w_fcast_1 = number_format((float)$tax_w_fcast_1, 2, '.', '');
                $tax_based = get_tax_annual($floated_tax_w_fcast_1);


                $rate_annl_earningsx = $ytd_gross_income / ($ytd_gross_income + $forecast_earnings);
                $rate_annl_earnings = number_format($rate_annl_earningsx,4);

                if ($tax_based == 124.99){
                    $with_tax = $tax_based;
                }else{
                    $with_tax1 = $tax_based * $rate_annl_earnings; // Need For Annual
                    $with_tax2 = $with_tax1 - $aRow['yt_tax_withheld'];

                    // orig
                    if ($with_tax2 <= 124.99){
                        $with_tax = 124.99;
                    }else{
                        $with_tax = $with_tax1 - $aRow['yt_tax_withheld']; 
                    }

                    // $with_tax = ($with_tax1 - $aRow['yt_tax_withheld']) - $aRow['leaves_taxes']; // For Annual
                    
                }

                /* Original Code */
                $row[] = number_format($with_tax,2); // With tax ORIG 
                

                // Net pay
                $all_deductions = $eeshare + $phil_2_amnt + $pagibig_amnt + $sss_loan_amnt + $sss_cal_loan_amnt + $sss_condo_loan_amnt + $pagibig_sal_loan_amnt + $pagibig_cal_loan_amnt + $hipar_amnt + $adv_deduc_amnt + $tax_adj_amnt + $with_tax; // original 03052024
                
                // $all_deductions = $eeshare + $phil_2_amnt + $pagibig_amnt + $sss_loan_amnt + $sss_cal_loan_amnt + $pagibig_sal_loan_amnt + $pagibig_cal_loan_amnt + $hipar_amnt + $adv_deduc_amnt + $tax_adj_amnt + $aRow['yt_tax_withheld']; // Pang year-end lang; For checking
                
                $net_pay = $gross_pay_2 - $all_deductions; 
                $row[] = number_format($net_pay,2); // Net pay

                } //end if else
            
            }
        

        array_push($output['aaData'],$row);

    }
    
    echo json_encode( $output );


    function get_employee_info($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        // $table              = 'vw_EmployeeInfo';
        $table              = 'vw_employeeinfo'; //09112024 By nessa
        $joins              = '';
        $sql_where          = 'WHERE EmpNo="'.$EmpNo.'"';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = HRIS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['EmpNo'][$ctr]            = $row['EmpNo'];
            $return['LastName'][$ctr]         = $row['LastName'];
            $return['FirstName'][$ctr]        = $row['FirstName'];
            $return['MiddleName'][$ctr]       = $row['MiddleName'];
            $return['Department'][$ctr]       = $row['Department'];//09112024 By nessa
            $return['Section'][$ctr]          = $row['Section'];//09112024 By nessa
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

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
            $return['emp_no'][$ctr]                       = $row['emp_no'];
            $return['salary_adjustments'][$ctr]           = $row['salary_adjustments'];
            $return['other_earnings'][$ctr]               = $row['other_earnings'];
            $return['advances_other_deductions'][$ctr]    = $row['advances_other_deductions'];
            $return['tax_adjustments'][$ctr]              = $row['tax_adjustments'];
            $return['type_of_earning'][$ctr]              = $row['type_of_earning'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    function get_sss($floated_comp_gross_pay){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_sss';
        $joins              = '';
        $sql_where          = '';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        $eeshare = 0;
        while($row = mysqli_fetch_array($result)){
            if($floated_comp_gross_pay <= $row['lower_limit']){
                $eeshare = $row['eeshare'];
                break;
            }
            else if($floated_comp_gross_pay > $row['lower_limit'] && $floated_comp_gross_pay <= $row['upper_limit']){
                $eeshare = $row['eeshare'];
                break;
            }
        }
        return $eeshare;
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
            $return['emp_num']           = $row['emp_num'];
            $return['charge_amount']     = $row['charge_amount'];
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
            $return['emp_num']           = $row['emp_num'];
            $return['charge_amount']     = $row['charge_amount'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    //09182024 by Nessa
    function get_sss_condonation($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_sss_condonation'; 
        $joins              = '';
        $sql_where          = 'WHERE emp_num="'.$EmpNo.'"';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['emp_num']           = $row['emp_num'];
            $return['charge_amount']     = $row['charge_amount'];
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
            $return['employee_no']         = $row['employee_no'];
            $return['hmo_amount']          = $row['hmo_amount'];
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
            $return['leaves_taxes'][$ctr]          	  = $row['leaves_taxes']; //0102026 for Annual
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    function get_gross_pay($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_gross_pay'; 
        $joins              = '';
        $sql_where          = 'WHERE emp_no="'.$EmpNo.'"';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['emp_no']         = $row['emp_no'];
            $return['gross_pay']      = $row['gross_pay'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    function get_tax_annual($floated_tax_w_fcast_1){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_tax_annual'; 
        $joins              = '';
        $sql_where          = '';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        $tax_based = 0;
        $tax_based_1 = 0;
        while($row = mysqli_fetch_array($result)){
            if($floated_tax_w_fcast_1 < 250000){
                $tax_based = 124.99; // orig
                // $tax_based = 0; // for ANNUAL
                break;
            }
            else if($floated_tax_w_fcast_1 > $row['lower_limit'] && $floated_tax_w_fcast_1 <= $row['upper_limit']){
                $tax_based_1 = $floated_tax_w_fcast_1 - $row['lower_limit'];
                $tax_based = ($tax_based_1 * $row['addendum']) + $row['tax'];
                break;
            }
        }
        // $return['ctr']  = $ctr;
        return $tax_based;
    }

    function get_oleaves($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_leaves'; // adjustments
        $joins              = '';
        $sql_where          = 'WHERE emp_no="'.$EmpNo.'" and logdel =0';
        $sql_order          = '';
        $sql_limit          = '';                  
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['emp_no'][$ctr]       = $row['emp_no'];
            $return['leave_code'][$ctr]   = $row['leave_code'];
            $return['amount'][$ctr]       = $row['amount'];
            $return['cut_off'][$ctr]      = $row['cut_off'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    function get_pagibig($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_pagibig_loan'; 
        $joins              = '';
        $sql_where          = 'WHERE emp_no="'.$EmpNo.'"';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['emp_no']               = $row['emp_no'];
            $return['loan_amount']          = $row['loan_amount'];
            $return['calamity_loan_amount'] = $row['calamity_loan_amount'];
            $return['safe_loan_amount']     = $row['safe_loan_amount'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }

    // OLD 01022024
   /* function get_payroll_info_data($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('a.*, b.date_cut_off');
        $table              = 'tbl_payroll_info_data a'; 
        $joins              = 'inner join tbl_payroll_info b on b.id = a.fkid_payroll_info';
        // $sql_where          = "WHERE a.employee_no='".$EmpNo."' AND b.date_cut_off >='".date('01/01/2023')."' ";
        $sql_where          = "WHERE a.employee_no='".$EmpNo."' ";
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['employee_no']              = $row['employee_no'];
            $return['gross_pay']                = $row['gross_pay'];
            $ctr++;
        }
        $return['ctr']  = $ctr;
        return $return;
    }*/

    function get_payroll_info_data($EmpNo){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('a.*, b.date_cut_off');
        $table              = 'tbl_payroll_info_data a'; 
        $joins              = 'inner join tbl_payroll_info b on b.id = a.fkid_payroll_info';
        // $sql_where          = "WHERE a.employee_no='".$EmpNo."' AND b.date_cut_off >='".date('01/01/2023')."' ";
        $sql_where          = "WHERE a.employee_no='".$EmpNo."' and (description = 1 or description = 2 or description = 4) ";
        $sql_order          = 'ORDER BY b.id DESC';
        $sql_limit          = 'LIMIT 0,1';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        while($row = mysqli_fetch_array($result)){
            $return['employee_no']              = $row['employee_no'];
            $return['gross_pay']                = $row['gross_pay'];
            $ctr++;
        }
        $return['ctr']  = $ctr;

        return $return;
    }

    function get_working_days(){
        require_once ('../../class/payroll_oop.php');
        $return             = $_POST;
        $result             = '';
        $array_fields       = array('*');
        $table              = 'tbl_working_days';
        $joins              = '';
        $sql_where          = '';
        $sql_order          = '';
        $sql_limit          = '';
        $result             = PAYROLL::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
        $ctr = 0;
        $eeshare = 0;
        while($row = mysqli_fetch_array($result)){
            $working_days = $row['working_days'];        
        }
        // $return['ctr']  = $ctr;
        return $working_days;
    }

?>