<?php
/**
 * 모뎀 Save
 * 
 */

$id             = trim($_POST["id"]);                               // 1. 모뎀id
$validity       = trim($_POST["validity"]);                         // 2. 정상
$comment        = trim($_POST["comment"]);                          // 3. 비고
$etc            = trim($_POST["etc"]);                              // 4. 기타
$reuser         = trim($_POST["reuser"]);                           // 5. 담당자         

// echo("id : $id, validity : $validity, comment : $comment, etc : $etc");

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * 모뎀 수정
 * table : prdt_part
 */
$sql = "UPDATE trad_part_modem SET ";
$sql .= "validity='$validity', comment='$comment', etc='$etc', ";
$sql .= "flag=2, reuser='$reuser', reDate=now() WHERE id='$id'";

//Console_log($sql);

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

if ($result) {
  $logcontent = '수정되었습니다.';
//  Alert_log($logcontent);
  $data = 0;  
} else {  
  $logcontent = '수정할 모뎀이 없습니다.';
//  Alert_log($logcontent);
  $data = 1;  
}


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