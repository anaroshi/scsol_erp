<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * 기초항목 USER DATA 처리
 * SAVE ($flag==1)
 * UPDATE ($flag==2)
 * DELETE ($flag==4)
 * return : $data: 1(저장), 2(수정), 3(중복), 4(삭제), 5(사용여부), 9(에러)
 */

$cid        = trim($_POST["cid"]) ?? "";              // 1. cid
$id         = trim($_POST["id"]) ?? "";               // 2. id
$pw         = trim($_POST["pwd"]) ?? "";              // 3. pw
$name       = trim($_POST["name"]) ?? "";             // 4. name
$phone      = trim($_POST["phone"]) ?? "";            // 5. phone
$add1       = trim($_POST["add1"]) ?? "";             // 6. add1
$add2       = trim($_POST["add2"]) ?? "";             // 7. add2
$email      = trim($_POST["email"]) ?? "";            // 8. email
$startDate  = trim($_POST["startDate"]) ?? "";        // 9. user
$user       = trim($_POST["user"]) ?? "";             // 10. 사용자
$flag       = trim($_POST["flag"]) ?? "";             // 11. flag



// echo("cid : $cid, id: $id, pw : $pw, name : $name, phone : $phone, add1 : $add1, add2 : $add2<br>"); 
// echo("email : $email, startDate : $startDate, user : $user<br>");

if ($flag == 1) {

  // SAVE
  /**
   * ID 중복 확인
   * table : erp_user
   */

  $sql    = "SELECT * FROM erp_user WHERE id = '$id' ";
  if (!($result = mysqli_query($conn_11, $sql))) {
    $data = 9;
    echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
  }
  $num    = mysqli_num_rows($result);
  
  if ($num>0) {  
    $data = 3;
    goto escape;

  } else {
  
    $sql      = "INSERT INTO erp_user (id, pw, name, phone, add1, add2, email, startDate, flag, user, inDate) ";
    $sql     .= "VALUES ('$id', '$pw', '$name', '$phone', '$add1', '$add2', '$email', '$startDate', '$flag', '$user', now()) ";
    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }
    $data = 1;
  }
} else if ($flag == 2) {

  // UPDATE
  
  $sql  = "UPDATE erp_user SET pw='$pw', name='$name', phone='$phone', add1='$add1', add2='$add2', ";
  $sql .= "email='$email', startDate='$startDate', flag='$flag', reuser='$user', reDate=now()  WHERE id='$id'";
  //echo($sql);
  if(!($result =mysqli_query($conn_11,$sql))) {
    $data = 9;
    echo("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
  }    
  $data = 2;
  

} else if ($flag == 4) {

  // DELETE
  $sql = "UPDATE erp_user SET flag='$flag', reuser='$user', reDate=now()  WHERE cid='$cid'";
  //echo($sql);
  if(!($result =mysqli_query($conn_11,$sql))) {
    $data = 9;
    echo("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
  }
  $data = 4;  
}
 
escape: 

echo json_encode($data);

?>