<?php
  /**
   * 선택된 BATTERY 수정 처리
   */
  error_reporting(E_ALL);
  ini_set("display_errors",1);

  include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
  include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
  include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");
  
  $id           = $_POST['id'] ?? '';
  $voltage      = $_POST['voltage'] ?? '';
  $comment      = $_POST['comment'] ?? '';
  $etc          = $_POST['etc'] ?? '';
  $validity     = $_POST['validity'] ?? '';
  $reuser       = trim($_POST["reuser"]) ?? '';           // 담당자 
  //echo($id);

  $sql = "UPDATE trad_part_battery SET flag=2, voltage='$voltage', comment='$comment', etc='$etc', validity='$validity', reuser='$reuser', reDate=now()  WHERE id='$id'";
  //echo($sql);
  if(!($result =mysqli_query($conn_11,$sql))) {
    echo("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
  }
  
  if ($result) {
    // 수정 성공
    $data = 0;
  } else {
    // 수정 실폐
    $data = 1;
  }
  echo json_encode($data);

?>