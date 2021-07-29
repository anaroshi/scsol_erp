<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

$all_query_ok = true;
//$data = array();

/**
 * 생산 삭제
 * table : step_product
 * 
 */

// scsol_sn, pcba_sn, sensor_sn, battery_sn, fwVesrion, 
// leaktest_t1_p4, leaktest_t1_p5, radiotest_t1, mold,
// leaktest_t2_p4, leaktest_t2_p5, radiotest_t2, 
// comment1, comment2, comment3, etc, flag, status, finalState

$scsol_sn    = trim($_POST["scsol_sn"]) ?? '';        // scsol_sn
$pcba_sn     = trim($_POST["pcba_sn"]) ?? '';         // pcba_sn
$sensor_sn	 = trim($_POST["sensor_sn"]) ?? '';       // sensor_sn
$battery_sn  = trim($_POST["battery_sn"]) ?? '';      // battery_sn
//$case_sn	   = trim($_POST["case_sn"]) ?? '';         // case_sn
$fwVesrion	 = trim($_POST["fwVesrion"]) ?? '';         // fwVesrion
$reuser	     = trim($_POST["reuser"]) ?? '';          // reuser

// echo ("scsol_sn   : ".$scsol_sn      ."\n");
// echo ("pcba_sn    : ".$pcba_sn       ."\n");
// echo ("sensor_sn	 : ".$sensor_sn	    ."\n");
// echo ("battery_sn : ".$battery_sn    ."\n");
// echo ("fwVesrion	 : ".$fwVesrion	      ."\n");


// 생산관리 : step_product
$sql  = "DELETE FROM step_product ";
$sql .= "WHERE scsol_sn = '$scsol_sn' ";
$conn_11->query($sql)? null : $all_query_ok=false;

// 생산관리 history : step_product_history
$sql  = "INSERT INTO step_product_history( ";
$sql .= "scsol_sn, pcba_sn, sensor_sn, battery_sn, 	fw_version, flag, inDate, user) ";
$sql .= "values('$scsol_sn', '$pcba_sn', '$sensor_sn', '$battery_sn', '$fwVesrion', 4, now(), '$reuser')";
$conn_11->query($sql)? null : $all_query_ok=false;

// 모뎀관리 : trad_part_modem 
$sql  = "UPDATE trad_part_modem ";
$sql .= "SET status = 'not used', reDate= now(), reuser='$reuser' ";
$sql .= "WHERE sn = '$scsol_sn' ";
$conn_11->query($sql)? null : $all_query_ok=false;

// PCBA 관리 : trad_part_pcba
if ($pcba_sn) {
  $sql   = "UPDATE trad_part_pcba ";
  $sql  .= "SET status = 'not used', sn = '', reDate= now(), reuser='$reuser' ";
  $sql  .= "WHERE pcba_sn = '$pcba_sn' ";
  $conn_11->query($sql)? null : $all_query_ok=false;
}

// SENSOR 관리 : trad_part_sensor
if ($sensor_sn) {
  $sql   = "UPDATE trad_part_sensor ";
  $sql  .= "SET status = 'not used', sn = '', reDate= now(), reuser='$reuser' ";
  $sql  .= "WHERE sensor_sn = '$sensor_sn' ";
  $conn_11->query($sql)? null : $all_query_ok=false;
}

// BATTERY 관리 : trad_part_battery
if ($battery_sn) {
  $sql   = "UPDATE trad_part_battery ";
  $sql  .= "SET status = 'not used', sn = '', reDate= now(), reuser='$reuser' ";
  $sql  .= "WHERE battery_sn = '$battery_sn' ";
  $conn_11->query($sql)? null : $all_query_ok=false;
}

// CASE 관리 : trad_part_case
// if ($case_sn) {
//   $sql   = "UPDATE trad_part_case ";
//   $sql  .= "SET status = 'not used', sn = '', reDate= now(), reuser='$reuser' ";
//   $sql  .= "WHERE case_sn = '$case_sn' ";
//   $conn_11->query($sql)? null : $all_query_ok=false;
// }

$all_query_ok ? $conn_11->autocommit() : $conn_11->rollback();
$conn_11->close();

$data = 0;


echo $data;