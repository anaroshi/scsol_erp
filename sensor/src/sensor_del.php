<?php
/**
 * 센서 삭제
 * 
 */

$id           = trim($_POST["id"]);             // 1. 센서id
$sensor_sn    = trim($_POST["sensor_sn"]);      // 2. sensor_sn
$reuser       = trim($_POST["reuser"]);         // 3. 담당자 

//echo("id : $id, sensor_sn : $sensor_sn");

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * 센서 삭제
 * table : trad_part_sensor
 * flag : 4
 * id와 sensor_sn을 조건으로 한다.
 */

$sql = "update trad_part_sensor set flag = 4 reDate=now(), reuser='$reuser' where id = '$id' and sensor_sn = '$sensor_sn'";
//echo("sql : $sql");
if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

// $num = mysqli_num_rows($result);
// Alert_log('num: '.$num);

if ($result) {  

  $logcontent = '삭제되없습니다.';
//  Alert_log($logcontent);
  $status = 'ok';

} else {

  $logcontent = '삭제할 센서가 없습니다.';
//  Alert_log($logcontent);
  $status = 'err';

}

echo $status;
die;

function Console_log($logcontent)
{
  echo "<script>
  console.log('$logcontent');
  </script>";
}

function Alert_log($logcontent)
{
  echo "<script>
  alert('$logcontent');
  </script>";
}

?>