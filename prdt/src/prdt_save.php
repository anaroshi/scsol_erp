<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

$all_query_ok = true;

$data = array();

/**
 * 생산 등록
 * table : step_product
 * field : scsol_sn, pcba_sn, sensor_sn, battery_sn, case_sn, fwVersion, user
 */

$scsol_sn       = trim($_POST["scsol_sn"]) ?? '';               // scsol_sn
$pcba_sn        = trim($_POST["pcba_sn"]) ?? '';                // pcba_sn
$sensor_sn      = trim($_POST["sensor_sn"]) ?? '';              // sensor_sn
$battery_sn     = trim($_POST["battery_sn"]) ?? '';             // battery_sn
//$case_sn        = trim($_POST["case_sn"]) ?? '';                // case_sn
$fwVersion      = trim($_POST["prdt_fwVersion"]) ?? '';             // firmware_version
$user           = trim($_POST["user"]) ?? '';                   // user

// echo 'scsol_sn: '.$scsol_sn."\n";
// echo 'pcba_sn: '.$pcba_sn."\n";
// echo 'sensor_sn: '.$sensor_sn."\n";
// echo 'battery_sn: '.$battery_sn."\n";
// echo 'case_sn: '.$case_sn."\n";

$sql = "Select * FROM step_product WHERE scsol_sn = '$scsol_sn' ";
if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . " query: " . $sql);
}
$rowsDuplicated = mysqli_num_rows($result);

if ($rowsDuplicated < 1) {
  $sql = "SELECT phone_no FROM trad_part_modem WHERE status='not used' AND flag != 4 AND validity='Y' AND sn = '$scsol_sn' ";
  
  if (!($result = mysqli_query($conn_11, $sql))) {
    echo ("Error description: " . mysqli_error($conn_11) . " query: " . $sql);
  }
 
  $row = mysqli_fetch_assoc($result);
  $phone_no = $row['phone_no'];

  if ($phone_no) {

    $all_query_ok = true;

    // 생산관리 : step_product
    $sql  = "INSERT INTO step_product( ";
    $sql .= "scsol_sn, phone_no, pcba_sn, sensor_sn, battery_sn, fw_version, flag, inDate, user) ";
    $sql .= "values('$scsol_sn', '$phone_no', '$pcba_sn', '$sensor_sn', '$battery_sn', '$fwVersion', 1, now(), $user)";
    $conn_11->query($sql)? null : $all_query_ok=false;
     
    // if (!($result = mysqli_query($conn_11, $sql))) {
    //   echo ("Error description: " . mysqli_error($conn_11) . " query: " . $sql);
    // }

    // 생산관리 history : step_product_history
    $sql  = "INSERT INTO step_product_history( ";
    $sql .= "scsol_sn, phone_no, pcba_sn, sensor_sn, battery_sn, fw_version, flag, inDate, user) ";
    $sql .= "values('$scsol_sn', '$phone_no', '$pcba_sn', '$sensor_sn', '$battery_sn', '$fwVersion', 1, now(), $user)";
    $conn_11->query($sql)? null : $all_query_ok=false;
    
    // if (!($result = mysqli_query($conn_11, $sql))) {
    //   echo ("Error description: " . mysqli_error($conn_11) . " query: " . $sql);
    // }


    // 모뎀관리 : trad_part_modem 
    $sql  = "UPDATE trad_part_modem ";
    $sql .= "SET status = 'used' ";
    $sql .= "WHERE sn = '$scsol_sn' ";
    
    $conn_11->query($sql)? null : $all_query_ok=false;
    // if (!($result = mysqli_query($conn_11, $sql))) {
    //   echo ("Error description: " . mysqli_error($conn_11) . " query: " . $sql);
    // }

    if($pcba_sn) {
      // PCBA 관리 : trad_part_pcba
      $sql   = "UPDATE trad_part_pcba ";
      $sql  .= "SET status = 'used', sn = '$scsol_sn' ";
      $sql  .= "WHERE pcba_sn = '$pcba_sn' ";
      
      $conn_11->query($sql)? null : $all_query_ok=false;
      // if (!($result = mysqli_query($conn_11, $sql))) {
      //   echo ("Error description: ". mysqli_error($conn_11) . " query: " . $sql);
      // }
    }

    if($sensor_sn) {
      // SENSOR 관리 : trad_part_sensor
      $sql   = "UPDATE trad_part_sensor ";
      $sql  .= "SET status = 'used', sn = '$scsol_sn' ";
      $sql  .= "WHERE sensor_sn = '$sensor_sn' ";
      
      $conn_11->query($sql)? null : $all_query_ok=false;
      // if (!($result = mysqli_query($conn_11, $sql))) {
      //   echo ("Error description: ". mysqli_error($conn_11) . " query: " . $sql);
      // }
    }

    if($battery_sn) {
      // BATTERY 관리 : trad_part_battery
      $sql   = "UPDATE trad_part_battery ";
      $sql  .= "SET status = 'used', sn = '$scsol_sn' ";
      $sql  .= "WHERE battery_sn = '$battery_sn' ";
      
      $conn_11->query($sql)? null : $all_query_ok=false;
      // if (!($result = mysqli_query($conn_11, $sql))) {
      //   echo ("Error description: ". mysqli_error($conn_11) . " query: " . $sql);
      // }
    }  

    if($case_sn) {
      // CASE 관리 : trad_part_case
      $sql   = "UPDATE trad_part_case ";
      $sql  .= "SET status = 'used', sn = '$scsol_sn' ";
      $sql  .= "WHERE case_sn = '$case_sn' ";
      
      $conn_11->query($sql)? null : $all_query_ok=false;
      // if (!($result = mysqli_query($conn_11, $sql))) {
      //   echo ("Error description: ". mysqli_error($conn_11) . " query: " . $sql);
      // }
    }  

    $all_query_ok ? $conn_11->autocommit() : $conn_11->rollback();
    $conn_11->close();

    $data = 0;
  }  

} else {
  $data = 1;
}

echo $data;