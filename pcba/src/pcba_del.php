<?php
/**
 * PCBA 삭제
 * 
 */

$id           = trim($_POST["id"]);               // 1. PCBA id
$pcba_sn      = trim($_POST["pcba_sn"]);          // 2. pcba_sn
$reuser       = trim($_POST["reuser"]);           // 3. 담당자 
//echo("id : $id, pcba_sn : $pcba_sn, reuser : $reuser");

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * PCBA 삭제
 * table : trad_part_pcba
 * flag : 4
 * id와 pcba_sn를 조건으로 한다.
 */

$sql = "update trad_part_pcba set flag = 4, reDate=now(), reuser='$reuser' where id = '$id' and pcba_sn = '$pcba_sn'";
//echo("sql : $sql");
if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

// $num = mysqli_num_rows($result);
// Alert_log('num: '.$num);

if ($result) {  

  $logcontent = '삭제되없습니다.';
//  Alert_log($logcontent);
  $data = 0;

} else {

  $logcontent = '삭제할 PCBA이 없습니다.';
//  Alert_log($logcontent);
  $data = 1;

}

echo json_encode($data);

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