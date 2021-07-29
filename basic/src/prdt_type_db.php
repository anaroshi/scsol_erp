<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * 기초항목 Type DATA 처리
 * SAVE ($flag==1)
 * UPDATE ($flag==2)
 * DELETE ($flag==4)
 * return : $data: 1(저장), 2(수정), 3(중복), 4(삭제), 5(사용여부), 9(에러)
 */

$id       = trim($_POST["id"]) ?? "";               // 1. id
$type     = trim($_POST["type"]) ?? "";             // 2. Type
$type_cd  = trim($_POST["type_cd"]) ?? "";          // 3. type_cd
$user     = trim($_POST["user"]) ?? "";             // 4. 사용자
$flag     = trim($_POST["flag"]) ?? "";             // 5. flag

//echo("id : $id, type : $type, user : $user, flag : $flag<br>");

if ($flag == 1) {

  // SAVE
  /**
   * Type 중복 확인
   * table : prdt_type
   */

  $sql    = "SELECT id, type FROM prdt_type WHERE type = '$type' ";
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
   * Type Code, sort 생성
   * table : prdt_type
   */

   $sql      = "SELECT CONCAT(LEFT(type_cd,4), RIGHT(type_cd,3)+1) type_cd, sort+10 sort ";
    $sql     .= "FROM prdt_type ORDER BY id DESC LIMIT 1";
    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
      goto escape;
    }
    $row      = mysqli_fetch_assoc($result);
    $type_cd  = $row['type_cd'];                    // Type Code
    $sort     = $row['sort'];                        // 정렬순서

    $sql      = "INSERT INTO prdt_type (type, type_cd, sort, flag, user, inDate) ";
    $sql     .= "VALUES ('$type','$type_cd','$sort', '$flag', '$user', now()) ";
    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }
    $data = 1;
  }
} else if ($flag == 2) {

  // UPDATE
  // 동일한 Type이 있는지 확인
  $sql    = "SELECT id, type FROM prdt_type WHERE type = '$type' AND id !='$id' ";
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
    $sql = "UPDATE prdt_type SET type='$type', flag='$flag', reuser='$user', reDate=now()  WHERE id='$id'";
    //echo($sql);
    if(!($result =mysqli_query($conn_11,$sql))) {
      $data = 9;
      echo("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }    
    $data = 2;
  }

} else if ($flag == 4) {

  $sql = "SELECT id FROM prdt_part WHERE type_cd = '$type_cd'";
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
    $sql = "UPDATE prdt_type SET flag='$flag', reuser='$user', reDate=now()  WHERE id='$id'";
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