<?php
/**
 * 모뎀 삭제
 * 
 */

$id           = trim($_POST["id"]);               // 1. 모뎀id
$phone_no     = trim($_POST["phone_no"]);         // 2. phone_no
$reuser       = trim($_POST["reuser"]);           // 3. 담당자

//echo("id : $id, phone_no : $phone_no");

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * 모뎀 삭제
 * table : trad_part_modem
 * flag : 4
 * id와 phone_no을 조건으로 한다.
 */

$sql = "update trad_part_modem set flag = 4, reDate=now(), reuser='$reuser' where id = '$id' and phone_no = '$phone_no'";
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

  $logcontent = '삭제할 모뎀이 없습니다.';
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