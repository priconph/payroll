<?php
	/**
	 * Check if the OOP file is existed
	 * then include
	 */
	$oop = '../class/hris-oop.php';
	if(file_exists($oop)){
		require_once($oop);
	}else{
		echo 'oops not found!';
		exit;
	}

	$contribution 	= $_GET['contribution'];
	// echo json_encode($contribution).'<br>';
	// exit();

	/**
	 * Query
	 */
	$array_fields	= 	array('*');
	$table 			= 	'tbl_EmployeeInfo a';
	$joins 			= 	'
							INNER JOIN tbl_Department b 
								ON b.pkid = a.fkDepartment
							INNER JOIN tbl_Division c 
								ON c.pkid = a.fkDivision
							INNER JOIN tbl_Section d 
								ON d.pkid = a.fkSection
							INNER JOIN tbl_Position e 
								ON e.pkid = a.fkPosition
						';
	$sql_where 		= 	'WHERE a.EmpStatus = 1';
	$sql_order 		= 	'ORDER BY a.EmpNo ASC';
	$sql_limit 		= 	'';
	$result 		= 	HRIS::getInstance()->active_user($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	$dataArray		= 	array();

	if($contribution == 1){
		while($row = mysqli_fetch_array($result)){
			$dataArray['EmpNo'][]		= $row['EmpNo'];
			$dataArray['LastName'][]	= $row['LastName'];
			$dataArray['FirstName'][]	= $row['FirstName'];
			$dataArray['MiddleName'][]	= $row['MiddleName'];
			$dataArray['NickName'][]	= $row['NickName'];
			$dataArray['Department'][]	= $row['Department'];
			$dataArray['Division'][]	= $row['Division'];
			$dataArray['Section'][]		= $row['Section'];
			$dataArray['Position'][]	= $row['Position'];
			$dataArray['DateHired'][]	= $row['DateHired'];
			$dataArray['TelephoneNo'][]	= $row['TelephoneNo'];
			$dataArray['DOBirth'][]		= $row['DOBirth'];
			$dataArray['Gender'][]		= $row['Gender'];
			$dataArray['CivilStatus'][]	= $row['CivilStatus'];
			$dataArray['SSN'][]			= $row['SSN'];
			$dataArray['TIN'][]			= $row['TIN'];
			$dataArray['PhilHealth'][]	= $row['PhilHealth'];
			$dataArray['PagIbig'][]		= $row['PagIbig'];
			$dataArray['BloodType'][]	= $row['BloodType'];
		}
	}else{
		while($row = mysqli_fetch_array($result)){
			$dataArray['EmpNo'][]		= $row['EmpNo'];
			$dataArray['LastName'][]	= $row['LastName'];
			$dataArray['FirstName'][]	= $row['FirstName'];
			$dataArray['MiddleName'][]	= $row['MiddleName'];
			$dataArray['NickName'][]	= $row['NickName'];
			$dataArray['Department'][]	= $row['Department'];
			$dataArray['Division'][]	= $row['Division'];
			$dataArray['Section'][]		= $row['Section'];
			$dataArray['Position'][]	= $row['Position'];
		}
	}

	// echo json_encode($dataArray);
	// exit();


	/**
	 * Excel
	 */
	$excel_class = '../class/excel_new.php';
	if(file_exists($excel_class)){
		include($excel_class);
	}else{
		echo 'File '.$excel_class.' does not exist';
		exit;
	}

	/* Excel initialization */
	$excel = new EXCEL;

	/* Set Title */
	$excel->title = 'Labor Allocation';

	/* Add a new page */
	$excel->add_page();

	/* Set page orientation */
	$excel->set_page_orientation_a4_landscape();

	/* Use the default font style */
	$excel->set_default_font_style();

	/* Select an active page */
	$excel->set_active_sheet(0);

	/* Set margin */
	$excel->set_margin();

	/* Set print area */
	$excel->set_print_area();


	$width_allowance = .81;

	/* Set width */
	$excel->set_width('A',$width_allowance+10);
	$excel->set_width('B',$width_allowance+10);
	$excel->set_width('C',$width_allowance+10);
	$excel->set_width('D',$width_allowance+10);
	$excel->set_width('E',$width_allowance+10);
	$excel->set_width('F',$width_allowance+10);
	$excel->set_width('G',$width_allowance+10);
	$excel->set_width('H',$width_allowance+10);
	$excel->set_width('I',$width_allowance+10);


	/* Header Columns */
	$excel->place_value('A1','Employee No.','string');
	$excel->place_value('B1','Last Name','string');
	$excel->place_value('C1','First Name','string');
	$excel->place_value('D1','Middle Name','string');
	$excel->place_value('E1','Nickaname','string');
	$excel->place_value('F1','Department','string');
	$excel->place_value('G1','Division','string');
	$excel->place_value('H1','Section','string');
	$excel->place_value('I1','Position','string');

	if($contribution == 1){
		/* Set width */
		$excel->set_width('J',$width_allowance+10);
		$excel->set_width('K',$width_allowance+10);
		$excel->set_width('L',$width_allowance+10);
		$excel->set_width('M',$width_allowance+10);
		$excel->set_width('N',$width_allowance+10);
		$excel->set_width('O',$width_allowance+10);
		$excel->set_width('P',$width_allowance+10);
		$excel->set_width('Q',$width_allowance+10);
		$excel->set_width('R',$width_allowance+10);
		$excel->set_width('S',$width_allowance+10);

		/* Header Columns */
		$excel->place_value('J1','Date Hired','string');
		$excel->place_value('K1','Telephone No.','string');
		$excel->place_value('L1','DO Birth','string');
		$excel->place_value('M1','Gender','string');
		$excel->place_value('N1','Civil Status','string');
		$excel->place_value('O1','SSN','string');
		$excel->place_value('P1','TIN','string');
		$excel->place_value('Q1','Philhealth','string');
		$excel->place_value('R1','PagIbig','string');
		$excel->place_value('S1','Blood Type','string');
	}

	$array_format = array(
		"name" 			=> 'Arial',
		"size" 			=> 12,
		"wordwrap"		=> false,
		"h_alignment" 	=> 'center'
	);

	/**
	 * Font weight
	 */
	$styleArray = array(
		'font'  => array(
			'bold'   => true,
			'size'   => '14',
		)
	);

	if($contribution == 1){
		$excel->set_format('A1:S1',$array_format);
		$excel->objPHPExcel->getStyle('A1:S1')->applyFromArray($styleArray);
		$excel->set_borders('A1:S1',1,1,1,1,'thin');
	}else{
		$excel->set_format('A1:I1',$array_format);
		$excel->objPHPExcel->getStyle('A1:I1')->applyFromArray($styleArray);
		$excel->set_borders('A1:I1',1,1,1,1,'thin');
	}

	$rowCounter = 2;
	$totalRows = count($dataArray['EmpNo']);

	if ($contribution == 1) {
		for ($i = 0; $i < $totalRows; $i++) {
			if($dataArray['Gender'][$i] == 1){
				$gender = 'Male';
			}else{
				$gender = 'Female';
			}

			if($dataArray['CivilStatus'][$i] == 1){
				$civil_status = 'Single';
			}else if($dataArray['CivilStatus'][$i] == 2){
				$civil_status = 'Maried';
			}else{
				$civil_status = 'Widowed';
			}

			$excel->place_value('A'.$rowCounter, $dataArray['EmpNo'][$i], 'string');
			$excel->place_value('B'.$rowCounter, $dataArray['LastName'][$i], 'string');
			$excel->place_value('C'.$rowCounter, $dataArray['FirstName'][$i], 'string');
			$excel->place_value('D'.$rowCounter, $dataArray['MiddleName'][$i], 'string');
			$excel->place_value('E'.$rowCounter, $dataArray['NickName'][$i], 'string');
			$excel->place_value('F'.$rowCounter, $dataArray['Department'][$i], 'string');
			$excel->place_value('G'.$rowCounter, $dataArray['Division'][$i], 'string');
			$excel->place_value('H'.$rowCounter, $dataArray['Section'][$i], 'string');
			$excel->place_value('I'.$rowCounter, $dataArray['Position'][$i], 'string');
	
			$excel->place_value('J'.$rowCounter, $dataArray['DateHired'][$i], 'string');
			$excel->place_value('K'.$rowCounter, $dataArray['TelephoneNo'][$i], 'string');
			$excel->place_value('L'.$rowCounter, $dataArray['DOBirth'][$i], 'string');
			$excel->place_value('M'.$rowCounter, $gender, 'string');
			$excel->place_value('N'.$rowCounter, $civil_status, 'string');
			$excel->place_value('O'.$rowCounter, $dataArray['SSN'][$i], 'string');
			$excel->place_value('P'.$rowCounter, $dataArray['TIN'][$i], 'string');
			$excel->place_value('Q'.$rowCounter, $dataArray['PhilHealth'][$i], 'string');
			$excel->place_value('R'.$rowCounter, $dataArray['PagIbig'][$i], 'string');
			$excel->place_value('S'.$rowCounter, $dataArray['BloodType'][$i], 'string');
	
			$excel->set_borders('A'.$rowCounter.':S'.$rowCounter,1,1,1,1,'thin');
			$rowCounter++;
		}
	
	} else {
		for ($i = 0; $i < $totalRows; $i++) {
			$excel->place_value('A'.$rowCounter, $dataArray['EmpNo'][$i], 'string');
			$excel->place_value('B'.$rowCounter, $dataArray['LastName'][$i], 'string');
			$excel->place_value('C'.$rowCounter, $dataArray['FirstName'][$i], 'string');
			$excel->place_value('D'.$rowCounter, $dataArray['MiddleName'][$i], 'string');
			$excel->place_value('E'.$rowCounter, $dataArray['NickName'][$i], 'string');
			$excel->place_value('F'.$rowCounter, $dataArray['Department'][$i], 'string');
			$excel->place_value('G'.$rowCounter, $dataArray['Division'][$i], 'string');
			$excel->place_value('H'.$rowCounter, $dataArray['Section'][$i], 'string');
			$excel->place_value('I'.$rowCounter, $dataArray['Position'][$i], 'string');
	
			$excel->set_borders('A'.$rowCounter.':I'.$rowCounter,1,1,1,1,'thin');
			$rowCounter++;
		}
	}
	


	$excel->objPHPExcel->getColumnDimension('A')->setAutoSize(true);
	$excel->objPHPExcel->getColumnDimension('B')->setAutoSize(true);
	$excel->objPHPExcel->getColumnDimension('C')->setAutoSize(true);
	$excel->objPHPExcel->getColumnDimension('D')->setAutoSize(true);
	$excel->objPHPExcel->getColumnDimension('E')->setAutoSize(true);
	$excel->objPHPExcel->getColumnDimension('F')->setAutoSize(true);
	$excel->objPHPExcel->getColumnDimension('G')->setAutoSize(true);
	$excel->objPHPExcel->getColumnDimension('H')->setAutoSize(true);
	$excel->objPHPExcel->getColumnDimension('I')->setAutoSize(true);

	if($contribution == 1){
		$excel->objPHPExcel->getColumnDimension('J')->setAutoSize(true);
		$excel->objPHPExcel->getColumnDimension('K')->setAutoSize(true);
		$excel->objPHPExcel->getColumnDimension('L')->setAutoSize(true);
		$excel->objPHPExcel->getColumnDimension('M')->setAutoSize(true);
		$excel->objPHPExcel->getColumnDimension('N')->setAutoSize(true);
		$excel->objPHPExcel->getColumnDimension('O')->setAutoSize(true);
		$excel->objPHPExcel->getColumnDimension('P')->setAutoSize(true);
		$excel->objPHPExcel->getColumnDimension('Q')->setAutoSize(true);
		$excel->objPHPExcel->getColumnDimension('R')->setAutoSize(true);
		$excel->objPHPExcel->getColumnDimension('S')->setAutoSize(true);
	}

	/* set file name */
	$filename = "Labor Allocation";
	/* output excel - filename, excel version (2003,2007) */
	$excel->output($filename,'2007');
?>
