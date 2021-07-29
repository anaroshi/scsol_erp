<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * 기초항목 종류 DATA 처리
 * SAVE ($flag==1)
 * UPDATE ($flag==2)
 * DELETE ($flag==4)
 * return : $data: 1(저장), 2(수정), 3(중복), 4(삭제), 5(사용여부), 9(에러)
 */

$id       = trim($_POST["id"]) ?? "";              // 1. id
$currency     = trim($_POST["currency"]) ?? "";            // 2. currency
$user     = trim($_POST["user"]) ?? "";            // 3. 사용자
$flag     = trim($_POST["flag"]) ?? "";            // 4. flag

//echo("id : $id, currency : $currency, user : $user, flag : $flag<br>");

if ($flag == 1) {

  // SAVE
  /**
   * 종류 중복 확인
   * table : prdt_currency
   */

  $sql    = "SELECT id, currency FROM prdt_currency WHERE currency = '$currency' ";
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
   * 종류 Code, sort 생성
   * table : prdt_currency
   */

    $sql      = "SELECT CONCAT(LEFT(currency_cd,4), RIGHT(currency_cd,3)+1) currency_cd, sort+10 sort ";
    $sql     .= "FROM prdt_currency ORDER BY id DESC LIMIT 1";
    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
      goto escape;
    }
    $row      = mysqli_fetch_assoc($result);
    $currency_cd  = $row['currency_cd'];                    // 종류 Code
    $sort     = $row['sort'];                        // 정렬순서

    $sql      = "INSERT INTO prdt_currency (currency, currency_cd, sort, flag, user, inDate) ";
    $sql     .= "VALUES ('$currency','$currency_cd','$sort', '$flag', '$user', now()) ";
    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }
    $data = 1;
  }
} else if ($flag == 2) {

  // UPDATE
  // 동일한 종류가 있는지 확인
  $sql    = "SELECT id, currency FROM prdt_currency WHERE currency = '$currency' AND id !='$id' ";
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
    $sql = "UPDATE prdt_currency SET currency='$currency', flag='$flag', reuser='$user', reDate=now()  WHERE id='$id'";
    //echo($sql);
    if(!($result =mysqli_query($conn_11,$sql))) {
      $data = 9;
      echo("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }    
    $data = 2;
  }

} else if ($flag == 4) {

  // DELETE
  $sql = "UPDATE prdt_currency SET flag='$flag', reuser='$user', reDate=now()  WHERE id='$id'";
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