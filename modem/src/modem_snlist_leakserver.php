<?php
include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");


/**
 * LEAK SERVER에서 SN 가져와 DB에 저장함
 */

// $sql = "SELECT phone_no FROM trad_part_modem WHERE flag != 4 ";
// if (!($result = mysqli_query($conn_11, $sql))) {
//   echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
// }
// $num = mysqli_num_rows($result);

// while ($row = mysqli_fetch_array($result)) {
//   $phone_no   = $row['phone_no'];
  
//   $url        = "http://thingsware.co.kr:9080/mhttp/getsninform.php?phone=".$phone_no;
//   $jsonData   = file_get_contents($url);
//   $snInfo     = json_decode($jsonData, true);
  
//   $tag        = $snInfo['0']['RESULT'];
  
//   if ($tag == "0") {
//     $sn       = $snInfo['0']['SN'];
//     $sid      = $snInfo['0']['SID'];
//     $project  = $snInfo['0']['PROJECT'];    
//   } else {
//     $sn       = "";
//     $sid      = "";
//     $project  = "";
//   }

//   $sql_sn = "UPDATE trad_part_modem SET sn='$sn', sid='$sid', project='$project' WHERE phone_no = '$phone_no' "; 
//   if (!($result_sn = mysqli_query($conn_11, $sql_sn))) {
//     echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql_sn);
//   } 
// }

?>