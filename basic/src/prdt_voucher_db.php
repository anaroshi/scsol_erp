<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * 기초항목 거래 구분 DATA 처리
 * SAVE ($flag==1)
 * UPDATE ($flag==2)
 * DELETE ($flag==4)
 * return : $data: 1(저장), 2(수정), 3(중복), 4(삭제), 5(사용여부), 9(에러)
 */

$id           = trim($_POST["id"]) ?? "";               // 1. id
$voucher      = trim($_POST["voucher"]) ?? "";          // 2. voucher
$voucher_cd   = trim($_POST["voucher_cd"]) ?? "";       // 3. voucher_cd
$user         = trim($_POST["user"]) ?? "";             // 4. 사용자
$flag         = trim($_POST["flag"]) ?? "";             // 5. flag

//echo("id : $id, voucher : $voucher, user : $user, flag : $flag<br>");

if ($flag == 1) {

  // SAVE
  /**
   * 거래 구분 중복 확인
   * table : trad_voucher
   */

  $sql    = "SELECT id, voucher FROM trad_voucher WHERE voucher = '$voucher' ";
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
   * 거래 구분 Code, sort 생성
   * table : trad_voucher
   */

    $sql      = "SELECT CONCAT(LEFT(voucher_cd,4), RIGHT(voucher_cd,3)+1) voucher_cd, sort+10 sort ";
    $sql     .= "FROM trad_voucher ORDER BY id DESC LIMIT 1";
    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
      goto escape;
    }
    $row      = mysqli_fetch_assoc($result);
    $voucher_cd  = $row['voucher_cd'];                // 거래 구분 Code
    $sort     = $row['sort'];                         // 정렬순서

    $sql      = "INSERT INTO trad_voucher (voucher, voucher_cd, sort, flag, user, inDate) ";
    $sql     .= "VALUES ('$voucher','$voucher_cd','$sort', '$flag', '$user', now()) ";
    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }
    $data = 1;
  }
} else if ($flag == 2) {

  // UPDATE
  // 동일한 거래 구분이 있는지 확인
  $sql    = "SELECT id, voucher FROM trad_voucher WHERE voucher = '$voucher' AND id !='$id' ";
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
    $sql = "UPDATE trad_voucher SET voucher='$voucher', flag='$flag', reuser='$user', reDate=now()  WHERE id='$id'";
    //echo($sql);
    if(!($result =mysqli_query($conn_11,$sql))) {
      $data = 9;
      echo("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }    
    $data = 2;
  }

} else if ($flag == 4) {
  $sql = "SELECT id FROM trad_list WHERE voucher_cd = '$voucher_cd'";
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
    $sql = "UPDATE trad_voucher SET flag='$flag', reuser='$user', reDate=now()  WHERE id='$id'";
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