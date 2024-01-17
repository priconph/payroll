<?php
$con = mysqli_connect("localhost","root","r@p1d0nl1n3","db_payroll");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}


$sql = "SELECT * FROM tbl_tax_annual";
$result = mysqli_query($con, $sql);

$tax_w_fcast_1 = 350000;

$floated_tax_w_fcast_1 = number_format((float)$tax_w_fcast_1, 2, '.', '');


$tax_based = 0;
$tax_based_1 = 0;
while($row = mysqli_fetch_assoc($result)){
//    print_r($row);
    // if($tax_w_fcast_1)

    if($floated_tax_w_fcast_1 < 250000){
        $tax_based = 124.99;
        break;
    }
    else if($floated_tax_w_fcast_1 > $row['lower_limit'] && $floated_tax_w_fcast_1 <= $row['upper_limit']){
        $tax_based_1 = $floated_tax_w_fcast_1 - $row['lower_limit'];
        $tax_based = ($tax_based_1 * $row['addendum']) + $row['tax'];
        break;
    }
}
echo "tax_w_fcast_1: ".$tax_w_fcast_1."<br>";
echo "tax_based: ".$tax_based."<br>";


// if ( $tax_w_fcast_1 < 250000 ){
//     $tax_based = 124.99;  
// }else if ( $tax_w_fcast_1 > 250000 && $tax_w_fcast_1 <= 400000 ){
//     $tax_based_1 = $tax_w_fcast_1 - 250000; 
//     $tax_based = ($tax_based_1 * 0.15) + 0; 


//     //// 

// }else if ( $tax_w_fcast_1 > 400000 && $tax_w_fcast_1 <= 800000 ){
//     $tax_based_1 = $tax_w_fcast_1 - 400000; 
//     $tax_based = ($tax_based_1 * 0.20) + 22500; 
// }else if ( $tax_w_fcast_1 > 800000 && $tax_w_fcast_1 <= 2000000 ){
//     $tax_based_1 = $tax_w_fcast_1 - 800000; 
//     $tax_based = ($tax_based_1 * 0.25) + 102500; 
// }else if ( $tax_w_fcast_1 > 2000000 && $tax_w_fcast_1 <= 8000000 ){
//     $tax_based_1 = $tax_w_fcast_1 - 2000000; 
//     $tax_based = ($tax_based_1 * 0.30) + 402500; 
// }else if ( $tax_w_fcast_1 > 8000000 && $tax_w_fcast_1 <= 9999999 ){
//     $tax_based_1 = $tax_w_fcast_1 - 8000000; 
//     $tax_based = ($tax_based_1 * 0.35) + 2202500; 
// }

mysqli_close($con);
?>