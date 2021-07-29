<?php
/**
 * SCSOL_SN, PHONE_NO, PCBA_SN, SENSOR_SN, BATTEREY_SN 추출
 * sorInfoByScsolSN.php
 */

$conn = new mysqli('192.168.0.91','scsol', 'scsol92595', 'scsolERP'); 
header('Content-type: application/json; charset=utf-8');

$sn				= trim($_GET['sn']) ?? "";

$data 		= array();
$allData 	= array();

$str  = "SELECT scsol_sn, phone_no, pcba_sn, sensor_sn, battery_sn FROM step_product WHERE 1 ";
if($sn) {
	$str .= "AND scsol_sn = '$sn' ";
}
$str .= "ORDER BY scsol_sn";

if (!($result = mysqli_query($conn, $str))) {
  echo ("Error description: " . mysqli_error($conn) . "query:" . $str);
}

if($result) {
	$num = mysqli_num_rows($result);

	if($num >0) {
		while($row = mysqli_fetch_array($result))	{
			$data['scsolSn']		= stripslashes($row['scsol_sn']); 
			$data['phoneNo']		= stripslashes($row['phone_no']);
			$data['pcbaSn']			= stripslashes($row['pcba_sn']); 
			$data['sensorSn']		= stripslashes($row['sensor_sn']);
			$data['batterySn']	= stripslashes($row['battery_sn']);
			$allData[]          = $data; 
		}
		echo json_encode($allData);
	} else {
		echo "NO Available DATA";
	}
}	
mysqli_close($conn);
?>