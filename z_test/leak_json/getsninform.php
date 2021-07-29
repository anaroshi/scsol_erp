<?php
$leak_con=mysqli_connect("thingsware.co.kr","scsol","scsol92595","mysql");
if(mysqli_connect_errno($leak_con))
{
   echo "Failed to connect to Leak MySQL: " . mysqli_connect_error();
   return;
}

$mecha_con=mysqli_connect("ithingsware.com","scsol","scsol92595","mysql", 3304);
if(mysqli_connect_errno($mecha_con))
{
   echo "Failed to connect to Mecha MySQL: " . mysqli_connect_error();
   return;
}


$PHONE = $_GET['phone'];
// $PHONE = "8212-2758-8304";

$leak_search = "SELECT * FROM `sensor_list_all` WHERE mphone = '$PHONE' and valid != '-1' ORDER BY cid DESC LIMIT 1";
$mecha_search = "SELECT * FROM `mecha_sensor_list_all` WHERE mphone = '$PHONE' and valid != '-1' ORDER BY cid DESC LIMIT 1";

$leak_result = mysqli_query($leak_con, $leak_search);
$mecha_result = mysqli_query($mecha_con, $mecha_search);

$leak_num = mysqli_num_rows($leak_result);
$mecha_num = mysqli_num_rows($mecha_result);

$d = array(); 
$a = array();


if($leak_num)
{
  	while($row = mysqli_fetch_assoc($leak_result))
        {
                $sn = $row['ssn'];
                $sid = $row['asid'];
                $project = $row['aproject'];


		$d['RESULT'] = 0;
		$d['SN'] = $sn;
		$d['SID'] = $sid; 
		$d['PROJECT'] = $project;

		$a[] = $d;
        }
}
else if($mecha_num)
{
	while($row = mysqli_fetch_assoc($mecha_result))
        {
                $sn = $row['ssn'];
                $sid = $row['asid'];
                $project = $row['aproject'];
		
		$d['RESULT'] = 0;
		$d['SN'] = $sn;
		$d['SID'] = $sid; 
		$d['PROJECT'] = $project; 

		$a[] = $d;
        }
}
else
{
	
	$d['RESULT'] = -1;
	$a[] = $d;
}
echo json_encode($a, JSON_FORCE_OBJECT);


?>
