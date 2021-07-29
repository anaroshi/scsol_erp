<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * 기초항목 PRODUCT DATA 처리
 * SAVE ($flag==1)
 * UPDATE ($flag==2)
 * DELETE ($flag==4)
 * return : $data: 1(저장), 2(수정), 3(중복), 4(삭제), 5(사용여부), 9(에러)
 */

$id       = trim($_POST["id"]) ?? "";               // 1. id
$product  = trim($_POST["product"]) ?? "";          // 2. product
$user     = trim($_POST["user"]) ?? "";             // 3. 사용자
$flag     = trim($_POST["flag"]) ?? "";             // 4. flag

//echo("id : $id, product : $product, user : $user, flag : $flag<br>");

if ($flag == 1) {

  // SAVE
  /**
   * PRODUCT 중복 확인
   * table : scs_product
   */

  $sql    = "SELECT id, product FROM scs_product WHERE product = '$product' ";
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
   * PRODUCT Code, sort 생성
   * table : scs_product
   */

    $sql      = "SELECT CONCAT(LEFT(product_cd,4), RIGHT(product_cd,3)+1) product_cd, sort+10 sort ";
    $sql     .= "FROM scs_product ORDER BY id DESC LIMIT 1";
    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
      goto escape;
    }
    $row      = mysqli_fetch_assoc($result);
    $product_cd  = $row['product_cd'];                // PRODUCT Code
    $sort     = $row['sort'];                         // 정렬순서

    $sql      = "INSERT INTO scs_product (product, product_cd, sort, flag, user, inDate) ";
    $sql     .= "VALUES ('$product','$product_cd','$sort', '$flag', '$user', now()) ";
    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }
    $data = 1;
  }
} else if ($flag == 2) {

  // UPDATE
  // 동일한 PRODUCT가 있는지 확인
  $sql    = "SELECT id, product FROM scs_product WHERE product = '$product' AND id !='$id' ";
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
    $sql = "UPDATE scs_product SET product='$product', flag='$flag', reuser='$user', reDate=now()  WHERE id='$id'";
    //echo($sql);
    if(!($result = mysqli_query($conn_11,$sql))) {
      $data = 9;
      echo("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }    
    $data = 2;
  }

} else if ($flag == 4) {

  // DELETE
  $sql = "UPDATE scs_product SET flag='$flag', reuser='$user', reDate=now()  WHERE id='$id'";
  //echo($sql);
  if(!($result = mysqli_query($conn_11,$sql))) {
    $data = 9;
    echo("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
  }
  $data = 4;  
}
 
escape: 

echo json_encode($data);

?>