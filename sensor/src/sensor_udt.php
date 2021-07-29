<?php

/**
 * 센서 Save
 * 
 */

$id             = trim($_POST["id"]);                               // 1. 센서id
$sensor_sn      = trim($_POST["sensor_sn"]);                        // 2. sensor_sn
$tradDate       = trim($_POST["tradDate"]);                         // 3. 가입(입고)일자
$tradId         = trim($_POST["tradId"]);                           // 4. 입고 번호
$validity       = trim($_POST["validity"]);                         // 5. 정상
$conclusion     = trim($_POST["conclusion"]);                       // 7. 종합판정
$issue          = trim($_POST["issue"]);                            // 8. ISSUE
$comment        = trim($_POST["comment"]);                          // 9. 비고
$etc            = trim($_POST["etc"]);                              // 10. 기타
$reuser         = trim($_POST["reuser"]);                           // 11. 담당자 
$image_1        = trim($_POST["image_1"]);                          // 41. image_1
$image_2        = trim($_POST["image_2"]);                          // 42. image_2
$image_3        = trim($_POST["image_3"]);                          // 43. image_3

$ss_no          = substr($sensor_sn,-4);                            // 44. ss_no
$fixed_img_1    = $ss_no.'-4-x.jpg';                                // 45. fixed_img_1
$fixed_img_2    = $ss_no.'-6-8.jpg';                                // 46. fixed_img_2
$fixed_img_3    = $ss_no.'-10-12.jpg';                              // 47. fixed_img_3



// echo("id : $id, sensor_sn : $sensor_sn, tradDate : $tradDate, tradId : $tradId ");
// echo("status : $status, comment : $comment, etc : $etc");
// echo("id : $id --");
// echo("sensor_sn : $sensor_sn --");
// echo("tradDate : $tradDate --");
// echo("tradId : $tradId --");
// echo("status : $status --");
// echo("sn : $sn --");
// echo("conclusion : $conclusion --");
// echo("issue : $issue --");
// echo("comment : $comment --");
// echo("etc : $etc --");
// echo("reuser : $reuser --");

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * 센서 수정
 * table : trad_part_sensor
 */
$sql = "UPDATE trad_part_sensor SET ";
$sql .= "validity='$validity', conclusion='$conclusion', issue='$issue', ";
$sql .= "comment='$comment', etc='$etc', ";
if($image_1) {
  $sql .= "image_1='$fixed_img_1', ";
} else {
  $sql .= "image_1='', ";
}
if($image_2) {
  $sql .= "image_2='$fixed_img_2', ";
} else {
  $sql .= "image_2='', ";
}
if($image_3) {
  $sql .= "image_3='$fixed_img_3', ";
} else {
  $sql .= "image_3='', ";
}
$sql .= "flag=2, reDate=now(), reuser='$reuser'  WHERE sensor_sn='$sensor_sn' ";

//echo($sql);

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

if ($result) {
  $logcontent = '수정되었습니다.';
//  Alert_log($logcontent);
  $status = 'ok';
} else {  
  $logcontent = '수정할 센서이 없습니다.';
//  Alert_log($logcontent);
  $status = 'err';
}

echo ($status);
die;
?>