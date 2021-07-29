<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * 기초항목 단위 DATA 처리
 * SAVE ($flag==1)
 * UPDATE ($flag==2)
 * DELETE ($flag==4)
 * return : $data: 1(저장), 2(수정), 3(중복), 4(삭제), 5(사용여부), 9(에러)
 */

$id       = trim($_POST["id"]) ?? "";              // 1. id
$unit     = trim($_POST["unit"]) ?? "";            // 2. unit
$user     = trim($_POST["user"]) ?? "";            // 3. 사용자
$flag     = trim($_POST["flag"]) ?? "";            // 4. flag

//echo("id : $id, unit : $unit, user : $user, flag : $flag<br>");

if ($flag == 1) {

  // SAVE
  /**
   * 단위 중복 확인
   * table : prdt_unit
   */

  $sql    = "SELECT id, unit FROM prdt_unit WHERE unit = '$unit' ";
  if (!($result = mysqli_query($conn_11, $sql))) {
    $data = 9;
    echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
  }
  $num    = mysqli_num_rows($result);
  
  if ($num>0) {  
    $data = 3;
    goto escape;

  } else {
  
   /**
   * 단위 Code, sort 생성
   * table : prdt_unit
   */

    $sql      = "SELECT CONCAT(LEFT(unit_cd,4), RIGHT(unit_cd,3)+1) unit_cd, sort+10 sort ";
    $sql     .= "FROM prdt_unit ORDER BY id DESC LIMIT 1";
    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
      goto escape;
    }
    $row      = mysqli_fetch_assoc($result);
    $unit_cd  = $row['unit_cd'];                    // 단위 Code
    $sort     = $row['sort'];                        // 정렬순서

    $sql      = "INSERT INTO prdt_unit (unit, unit_cd, sort, flag, user, inDate) ";
    $sql     .= "VALUES ('$unit','$unit_cd','$sort', '$flag', '$user', now()) ";
    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }
    $data = 1;
  }
} else if ($flag == 2) {

  // UPDATE
  // 동일한 단위가 있는지 확인
  $sql    = "SELECT id, unit FROM prdt_unit WHERE unit = '$unit' AND id !='$id' ";
  if (!($result = mysqli_query($conn_11, $sql))) {
    $data = 9;
    echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    goto escape;
  }
  $num    = mysqli_num_rows($result);
  
  if ($num>0) {    
    $data = 3;
    goto escape;

  } else {  
    $sql = "UPDATE prdt_unit SET unit='$unit', flag='$flag', reuser='$user', reDate=now()  WHERE id='$id'";
    //echo($sql);
    if(!($result =mysqli_query($conn_11,$sql))) {
      $data = 9;
      echo("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }    
    $data = 2;
  }

} else if ($flag == 4) {
  $sql = "SELECT id FROM prdt_part WHERE unit = '$unit'";
  if(!($result =mysqli_query($conn_11,$sql))) {
    $data = 9;
    echo("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
  }
  $num  = mysqli_num_rows($result);
  
  if ($num>0) {  
    $data = 5;
    goto escape;
  } else {

    // DELETE
    $sql = "UPDATE prdt_unit SET flag='$flag', reuser='$user', reDate=now()  WHERE id='$id'";
    //echo($sql);
    if(!($result =mysqli_query($conn_11,$sql))) {
      $data = 9;
      echo("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }
    $data = 4;
  }  
}
 
escape: 

echo json_encode($data);

?>