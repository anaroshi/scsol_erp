<?php
/**
 * PCBA Save
 * 
 */

$id             = trim($_POST["id"]);                               // 1. PCBAid
$pcba_sn        = trim($_POST["pcba_sn"]);                          // 2. pcba_sn
$hostcnt        = trim($_POST["hostcnt"]);                          // 8. 호스트커넥터
$mcucnt         = trim($_POST["mcucnt"]);                           // 9. MCU커넥터
$modemcnt       = trim($_POST["modemcnt"]);                         // 10. 모뎀커넥터
$battcnt        = trim($_POST["battcnt"]);                          // 11. 배터리커넥터
$ssorcnt        = trim($_POST["ssorcnt"]);                          // 12. 센서커넥터
$ldo            = trim($_POST["ldo"]);                              // 13. LDO
$radio          = trim($_POST["radio"]);                            // 14. 라디오
$buz            = trim($_POST["buz"]);                              // 15. 부저
$adc            = trim($_POST["adc"]);                              // 16. ADC
$memory         = trim($_POST["memory"]);                           // 17. 메모리
$issue          = trim($_POST["issue"]);                            // 18. 이슈
$comment        = trim($_POST["comment"]);                          // 19. 비고
$validity       = trim($_POST["validity"]);                         // 20. 정상
$etc            = trim($_POST["etc"]);                              // 21. 기타
$img_radio      = trim($_POST["img_radio"]);                        // 22. radio 이미지
$img_adc        = trim($_POST["img_adc"]);                          // 23. adc 이미지
$reuser         = trim($_POST["reuser"]);                           // 24. 담당자 
// echo("id : $id, pcba_sn : $pcba_sn, ");
// echo("validity : $validity, comment : $comment, etc : $etc, reuser : $reuser");

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * PCBA 수정
 * table : trad_part_pcba
 */
$sql = "UPDATE trad_part_pcba SET ";
$sql .= "hostcnt = '$hostcnt', mcucnt = '$mcucnt', modemcnt = '$modemcnt', battcnt = '$battcnt', ";
$sql .= "ssorcnt = '$ssorcnt', ldo = '$ldo', radio = '$radio', buz = '$buz', adc = '$adc', memory = '$memory', ";
$sql .= "issue = '$issue', comment='$comment', validity='$validity', etc='$etc', img_radio='$img_radio', img_adc='$img_adc', ";
if($img_radio) {
  $sql .= "img_radio_nm='$img_radio', img_radio='radio.jpg', ";
} else {
  $sql .= "img_radio_nm='', img_radio='', ";
}
if($img_adc) {
  $sql .= "img_adc_nm='$img_adc', img_adc='adc.jpg', ";
} else {
  $sql .= "img_adc_nm='', img_adc='', ";
}
$sql .= "flag='2', reDate=now(), reuser='$reuser' WHERE pcba_sn='$pcba_sn' ";

//Console_log($sql);

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

if ($result) {
  $logcontent = '수정되었습니다.';
//  Alert_log($logcontent);
  $data = 0;  
} else {  
  $logcontent = '수정할 PCBA가 없습니다.';
//  Alert_log($logcontent);
  $data = 1;  
}

return $data;

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