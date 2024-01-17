<?php 
	/**
	 * Custom functions
	 */
	function setFormat($cell, $arrayStyleFormat){
		/**
		 * Font
		 */
		$arrayFont = array();
		/* Font Name */
		if(isset($arrayStyleFormat['name']) && $arrayStyleFormat['name'] != ''){
			$name = $arrayStyleFormat['name'];
		}else{
			$name = "Arial";
		}
		$arrayFont['name'] = $name;
		/* Font Size */
		if(isset($arrayStyleFormat['size']) && $arrayStyleFormat['size'] != ''){
			$size = $arrayStyleFormat['size'];
		}else{
			$size = 10;
		}
		$arrayFont['size'] = $size;
		/* Font Weight */
		if(isset($arrayStyleFormat['bold']) && $arrayStyleFormat['bold'] != '' && $arrayStyleFormat['bold'] != false){
			$bold = $arrayStyleFormat['bold'];
		}else{
			$bold = false;
		}
		$arrayFont['bold'] = $bold;
		/* Font Style */
		if(isset($arrayStyleFormat['italic']) && $arrayStyleFormat['italic'] != '' && $arrayStyleFormat['italic'] != false){
			$italic = $arrayStyleFormat['italic'];
		}else{
			$italic = false;
		}
		$arrayFont['italic'] = $italic;
		/* Font Color */
		if(isset($arrayStyleFormat['color']) && $arrayStyleFormat['color'] != ''){
			$color = $arrayStyleFormat['color'];
		}else{
			$color = '000000';
		}
		$arrayFont['color'] = array('rgb' => $color);

		/**
		 * Alignment
		 */
		$arrayAlignment = array();
		if(isset($arrayStyleFormat['horizontal']) && $arrayStyleFormat['horizontal'] != ''){
			switch($arrayStyleFormat['horizontal']){
				case "left" 	: $horizontal = PHPExcel_Style_Alignment::HORIZONTAL_LEFT; break;
				case "right"	: $horizontal = PHPExcel_Style_Alignment::HORIZONTAL_RIGHT; break;
				case "center"	: $horizontal = PHPExcel_Style_Alignment::HORIZONTAL_CENTER; break;
			}
		}else{
			$horizontal = '';
		}
		$arrayAlignment['horizontal'] 	= $horizontal;
		$arrayAlignment['vertical'] 	= PHPExcel_Style_Alignment::VERTICAL_CENTER;
		
		$arrayStyle = array(
			'font'  => $arrayFont,
			'alignment' => $arrayAlignment,
		);
		$this->objPHPExcel->getStyle($cell)->applyFromArray($arrayStyle);
	}
?>