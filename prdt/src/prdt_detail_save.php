<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

$all_query_ok = true;
//$data = array();

/**
 * 생산 수정
 * table : step_product
 * 
 */

// scsol_sn, pcba_sn, sensor_sn, battery_sn, fwVesrion, 
// leaktest_t1_p4, leaktest_t1_p5, radiotest_t1, mold,
// leaktest_t2_p4, leaktest_t2_p5, radiotest_t2, 
// comment1, comment2, comment3, etc, flag, status, finalState

$scsol_sn             = trim($_POST["scsol_sn"]) ?? '';               // scsol_sn
$pcba_sn              = trim($_POST["pcba_sn"]) ?? '';                // pcba_sn
$sensor_sn	          = trim($_POST["sensor_sn"]) ?? '';              // sensor_sn
$battery_sn           = trim($_POST["battery_sn"]) ?? '';             // battery_sn
//$case_sn	            = trim($_POST["case_sn"]) ?? '';                // case_sn
$fwVesrion	          = trim($_POST["fwVesrion"]) ?? '';                // fwVesrion
$pcba_sn_ex           = trim($_POST["pcba_sn_ex"]) ?? '';             // pcba_sn_ex
$sensor_sn_ex	        = trim($_POST["sensor_sn_ex"]) ?? '';           // sensor_sn_ex
$battery_sn_ex        = trim($_POST["battery_sn_ex"]) ?? '';          // battery_sn_ex
//$case_sn_ex	          = trim($_POST["case_sn_ex"]) ?? '';             // case_sn_ex
$fwVesrion_ex	        = trim($_POST["fwVesrion_ex"]) ?? '';             // fwVesrion_ex
$leaktest_t1_p4       = trim($_POST["leaktest_t1_p4"]) ?? '';         // leaktest_t1_p4
$leaktest_t1_p4_img   = trim($_POST["leaktest_t1_p4_img"]) ?? '';     // leaktest_t1_p4_img (name)
$leaktest_t1_p5       = trim($_POST["leaktest_t1_p5"]) ?? '';         // leaktest_t1_p5
$leaktest_t1_p5_img   = trim($_POST["leaktest_t1_p5_img"]) ?? '';     // leaktest_t1_p5_img (name)
$radiotest_t1         = trim($_POST["radiotest_t1"]) ?? '';           // radiotest_t1
$radiotest_t1_img     = trim($_POST["radiotest_t1_img"]) ?? '';       // radiotest_t1_img (name)
$mold                 = trim($_POST["mold"]) ?? '';                   // mold
$mold_img1            = trim($_POST["mold_img1"]) ?? '';              // mold_img1
$mold_img2            = trim($_POST["mold_img2"]) ?? '';              // mold_img2
$leaktest_t2_p4       = trim($_POST["leaktest_t2_p4"]) ?? '';         // leaktest_t2_p4
$leaktest_t2_p4_img   = trim($_POST["leaktest_t2_p4_img"]) ?? '';     // leaktest_t2_p4_img (name)
$leaktest_t2_p5       = trim($_POST["leaktest_t2_p5"]) ?? '';         // leaktest_t2_p5
$leaktest_t2_p5_img   = trim($_POST["leaktest_t2_p5_img"]) ?? '';     // leaktest_t2_p5_img (name)
$radiotest_t2         = trim($_POST["radiotest_t2"]) ?? '';           // radiotest_t2
$radiotest_t2_img     = trim($_POST["radiotest_t2_img"]) ?? '';       // radiotest_t2_img (name)
$comment1	            = trim($_POST["comment1"]) ?? '';               // comment1
$comment2	            = trim($_POST["comment2"]) ?? '';               // comment2
$comment3	            = trim($_POST["comment3"]) ?? '';               // comment3
$etc                  = trim($_POST["etc"]) ?? '';                    // etc
$finalState           = trim($_POST["finalState"]) ?? '';             // finalState
$reuser	              = trim($_POST["reuser"]) ?? '';                 // reuser
$reuser_ex            = trim($_POST["reuser_ex"]) ?? '';              // reuser_ex


// echo ("scsol_sn          : ".$scsol_sn          ."\n");
// echo ("pcba_sn           : ".$pcba_sn           ."\n");
// echo ("sensor_sn	        : ".$sensor_sn	       ."\n");
// echo ("battery_sn        : ".$battery_sn        ."\n");
// echo ("fwVesrion	          : ".$fwVesrion	         ."\n");
// echo ("pcba_sn_ex        : ".$pcba_sn_ex         ."\n");
// echo ("sensor_sn_ex	    : ".$sensor_sn_ex	      ."\n");
// echo ("battery_sn_ex     : ".$battery_sn_ex      ."\n");
// echo ("fwVesrion_ex	      : ".$fwVesrion_ex	        ."\n");
// echo ("leaktest_t1_p4     : ".$leaktest_t1_p4    ."\n");
// echo ("leaktest_t1_p4_img : ".$leaktest_t1_p4_img."\n");
// echo ("leaktest_t1_p5     : ".$leaktest_t1_p5    ."\n");
// echo ("leaktest_t1_p5_img : ".$leaktest_t1_p5_img."\n");
// echo ("radiotest_t1       : ".$radiotest_t1      ."\n");
// echo ("radiotest_t1_img   : ".$radiotest_t1_img  ."\n");
// echo ("mold               : ".$mold              ."\n");
// echo ("mold_img1          : ".$mold_img1          ."\n");
// echo ("mold_img2          : ".$mold_img2          ."\n");
// echo ("leaktest_t2_p4     : ".$leaktest_t2_p4    ."\n");
// echo ("leaktest_t2_p4_img : ".$leaktest_t2_p4_img."\n");
// echo ("leaktest_t2_p5     : ".$leaktest_t2_p5    ."\n");
// echo ("leaktest_t2_p5_img : ".$leaktest_t2_p5_img."\n");
// echo ("radiotest_t2       : ".$radiotest_t2      ."\n");
// echo ("radiotest_t2_img   : ".$radiotest_t2_img  ."\n");
// echo ("comment1	         : ".$comment1	         ."\n");
// echo ("comment2	         : ".$comment2	         ."\n");
// echo ("comment3	         : ".$comment3	         ."\n");
// echo ("etc                : ".$etc               ."\n");
// echo ("finalState         : ".$finalState        ."\n");


// 생산관리 : step_product
$sql  = "UPDATE step_product SET ";
$sql .= "pcba_sn='$pcba_sn', sensor_sn='$sensor_sn', battery_sn='$battery_sn', 	fw_version='$fwVesrion', ";
$sql .= "leaktest_t1_p4_chk='$leaktest_t1_p4', leaktest_t1_p4_imgNM='$leaktest_t1_p4_img', ";
$sql .= "leaktest_t1_p5_chk='$leaktest_t1_p5', leaktest_t1_p5_imgNM='$leaktest_t1_p5_img', ";
$sql .= "radiotest_t1_chk='$radiotest_t1', radiotest_t1_imgNM='$radiotest_t1_img', ";
$sql .= "mold_chk='$mold', mold_imgNM1='$mold_img1', mold_imgNM2='$mold_img2', ";
$sql .= "leaktest_t2_p4_chk='$leaktest_t2_p4', leaktest_t2_p4_imgNM='$leaktest_t2_p4_img', ";
$sql .= "leaktest_t2_p5_chk='$leaktest_t2_p5', leaktest_t2_p5_imgNM='$leaktest_t2_p5_img', ";
$sql .= "radiotest_t2_chk='$radiotest_t2', radiotest_t2_imgNM='$radiotest_t2_img', ";
$sql .= "comment1='$comment1', comment2='$comment2', comment3='$comment3', etc='$etc', ";
$sql .= "finalState='$finalState', flag=2, reDate=now(), reuser='$reuser' ";
$sql .= "WHERE scsol_sn = '$scsol_sn' ";
$conn_11->query($sql)? null : $all_query_ok=false;

// 생산관리 history : step_product_history
$sql  = "INSERT INTO step_product_history( ";
$sql .= "scsol_sn, pcba_sn, sensor_sn, battery_sn, 	fw_version, ";
$sql .= "leaktest_t1_p4_chk, leaktest_t1_p4_imgNM, leaktest_t1_p5_chk, leaktest_t1_p5_imgNM, radiotest_t1_chk, radiotest_t1_imgNM, ";
$sql .= "mold_chk, mold_imgNM1, mold_imgNM2, ";
$sql .= "leaktest_t2_p4_chk, leaktest_t2_p4_imgNM, leaktest_t2_p5_chk, leaktest_t2_p5_imgNM, radiotest_t2_chk, radiotest_t2_imgNM, ";
$sql .= "comment1, comment2, comment3, etc, finalState, flag, inDate) ";
$sql .= "values('$scsol_sn', '$pcba_sn', '$sensor_sn', '$battery_sn', '$fwVesrion', ";
$sql .= "'$leaktest_t1_p4', '$leaktest_t1_p4_img', '$leaktest_t1_p5', '$leaktest_t1_p5_img', '$radiotest_t1', '$radiotest_t1_img', ";
$sql .= "'$mold', '$mold_img1', '$mold_img2', ";
$sql .= "'$leaktest_t2_p4', '$leaktest_t2_p4_img', '$leaktest_t2_p5', '$leaktest_t2_p5_img', '$radiotest_t2', '$radiotest_t2_img', ";
$sql .= "'$comment1', '$comment2', '$comment3', '$etc', '$finalState', 2, now(), reuser='$reuser' )";
$conn_11->query($sql)? null : $all_query_ok=false;


// PCBA 관리 : trad_part_pcba
if($pcba_sn_ex) {
  if ($pcba_sn_ex != $pcba_sn) {
    $sql   = "UPDATE trad_part_pcba ";
    $sql  .= "SET status = 'not used', sn = '' ";
    $sql  .= "WHERE pcba_sn = '$pcba_sn_ex' ";
    $conn_11->query($sql)? null : $all_query_ok=false;  

    $sql   = "UPDATE trad_part_pcba ";
    $sql  .= "SET status = 'used', sn = '$scsol_sn' ";
    $sql  .= "WHERE pcba_sn = '$pcba_sn' ";
    $conn_11->query($sql)? null : $all_query_ok=false;  
  }
} else {
  if ($pcba_sn) {
    $sql   = "UPDATE trad_part_pcba ";
    $sql  .= "SET status = 'used', sn = '$scsol_sn' ";
    $sql  .= "WHERE pcba_sn = '$pcba_sn' ";
    $conn_11->query($sql)? null : $all_query_ok=false;
  }    
} 

// SENSOR 관리 : trad_part_sensor
if($sensor_sn_ex) {
  if ($sensor_sn_ex != $sensor_sn) {
    $sql   = "UPDATE trad_part_sensor ";
    $sql  .= "SET status = 'not used', sn = '' ";
    $sql  .= "WHERE sensor_sn = '$sensor_sn_ex' ";
    $conn_11->query($sql)? null : $all_query_ok=false;

    $sql   = "UPDATE trad_part_sensor ";
    $sql  .= "SET status = 'used', sn = '$scsol_sn' ";
    $sql  .= "WHERE sensor_sn = '$sensor_sn' ";
    $conn_11->query($sql)? null : $all_query_ok=false;
  }
} else {
  if ($sensor_sn) {
    $sql   = "UPDATE trad_part_sensor ";
    $sql  .= "SET status = 'used', sn = '$scsol_sn' ";
    $sql  .= "WHERE sensor_sn = '$sensor_sn' ";
    $conn_11->query($sql)? null : $all_query_ok=false;
  }
}  

// BATTERY 관리 : trad_part_battery
if($battery_sn_ex) {
  if ($battery_sn_ex != $battery_sn) {
    $sql   = "UPDATE trad_part_battery ";
    $sql  .= "SET status = 'not used', sn = '' ";
    $sql  .= "WHERE battery_sn = '$battery_sn_ex' ";
    $conn_11->query($sql)? null : $all_query_ok=false;

    $sql   = "UPDATE trad_part_battery ";
    $sql  .= "SET status = 'used', sn = '$scsol_sn' ";
    $sql  .= "WHERE battery_sn = '$battery_sn' ";
    $conn_11->query($sql)? null : $all_query_ok=false;
  }
} else {
  if ($battery_sn) {
    $sql   = "UPDATE trad_part_battery ";
    $sql  .= "SET status = 'used', sn = '$scsol_sn' ";
    $sql  .= "WHERE battery_sn = '$battery_sn' ";
    $conn_11->query($sql)? null : $all_query_ok=false;
  }
}


// CASE 관리 : trad_part_case
// if($case_sn_ex) {
//   if ($case_sn_ex != $case_sn) {
//     $sql   = "UPDATE trad_part_case ";
//     $sql  .= "SET status = 'not used', sn = '' ";
//     $sql  .= "WHERE case_sn = '$case_sn_ex' ";
//     $conn_11->query($sql)? null : $all_query_ok=false;

//     $sql   = "UPDATE trad_part_case ";
//     $sql  .= "SET status = 'used', sn = '$scsol_sn' ";
//     $sql  .= "WHERE case_sn = '$case_sn' ";
//     $conn_11->query($sql)? null : $all_query_ok=false;
//   }
// } else {
//   if ($case_sn) {
//     $sql   = "UPDATE trad_part_case ";
//     $sql  .= "SET status = 'used', sn = '$scsol_sn' ";
//     $sql  .= "WHERE case_sn = '$case_sn' ";
//     $conn_11->query($sql)? null : $all_query_ok=false;
//   }
// }


$all_query_ok ? $conn_11->autocommit() : $conn_11->rollback();
$conn_11->close();

$data = 0;

echo $data;