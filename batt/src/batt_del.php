<?php
  /**
   * 선택된 BATTERY 삭제 처리
   */
  error_reporting(E_ALL);
  ini_set("display_errors",1);

  include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
  include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
  include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

  $id           = $_POST['id'] ?? '';
  $reuser       = trim($_POST["reuser"]) ?? '';           // 2. 담당자 
  //echo($id);

  $sql = "UPDATE trad_part_battery SET flag=4, reuser='$reuser', reDate=now()  WHERE id='$id'";
  //echo($sql);
  if(!($result =mysqli_query($conn_11,$sql))) {
    echo("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
  }
  
  if ($result) {
    // 삭제 성공
    $data = 0;
  } else {
    // 삭제 실폐
    $data = 1;
  }
  echo json_encode($data);

?>