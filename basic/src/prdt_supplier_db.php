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

$id           = trim($_POST["id"]) ?? "";               // id
$supplier     = trim($_POST["supplier"]) ?? "";         // supplier
$supplier_cd  = trim($_POST["supplier_cd"]) ?? "";      // supplier_cd
$user         = trim($_POST["user"]) ?? "";             // 사용자
$flag         = trim($_POST["flag"]) ?? "";             // flag
if ($flag == 4) { goto delFlow; }
$site         = trim($_POST["site"]) ?? "";             // site
$address      = trim($_POST["address"]) ?? "";          // address
$phone        = trim($_POST["phone"]) ?? "";            // phone
$fax          = trim($_POST["fax"]) ?? "";              // fax
$mail         = trim($_POST["mail"]) ?? "";             // mail
$tax_no       = trim($_POST["tax_no"]) ?? "";           // tax_no
$owner        = trim($_POST["owner"]) ?? "";            // owner
$manager      = trim($_POST["manager"]) ?? "";          // manager
$managerPhone = trim($_POST["managerPhone"]) ?? "";     // managerPhone
$etc          = trim($_POST["etc"]) ?? "";              //etc


//echo("id : $id, supplier : $supplier, user : $user, flag : $flag<br>");
delFlow:

if ($flag == 1) {

  // SAVE
  /**
   * 종류 중복 확인
   * table : prdt_supplier
   */

  $sql    = "SELECT id, supplier FROM prdt_supplier WHERE supplier = '$supplier' ";
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
   * table : prdt_supplier
   */

    $sql      = "SELECT CONCAT(LEFT(supplier_cd,4), RIGHT(supplier_cd,3)+1) supplier_cd, sort+10 sort ";
    $sql     .= "FROM prdt_supplier ORDER BY id DESC LIMIT 1";
    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
      goto escape;
    }
    $row          = mysqli_fetch_assoc($result);
    $supplier_cd  = $row['supplier_cd'];                  // 종류 Code
    $sort         = $row['sort'];                         // 정렬순서


    $sql      = "INSERT INTO prdt_supplier (supplier, supplier_cd, site, address, phone, fax, mail, ";
    $sql     .= "tax_no, owner, manager, manager_phone, etc, sort, flag, user, inDate) ";
    $sql     .= "VALUES ('$supplier','$supplier_cd','$site','$address','$phone','$fax','$mail', ";
    $sql     .= "'$tax_no','$owner','$manager','$manager_phone','$etc','$sort','$flag','$user',now()) ";

    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }
    $data = 1;
  }
} else if ($flag == 2) {

  // UPDATE
  // 동일한 종류가 있는지 확인
  $sql    = "SELECT id, supplier FROM prdt_supplier WHERE supplier = '$supplier' AND id !='$id' ";
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
    $sql  = "UPDATE prdt_supplier ";
    $sql .= "SET supplier='$supplier', site='$site', address='$address', phone='$phone', fax='$fax', ";
    $sql .= "mail='$mail', tax_no='$tax_no', owner='$owner', manager='$manager', manager_phone='$manager_phone', ";
    $sql .= "etc='$etc', flag='$flag', reuser='$user', reDate=now() ";
    $sql .= "WHERE id='$id' AND supplier_cd='$supplier_cd' ";
    //echo($sql);
    if(!($result =mysqli_query($conn_11,$sql))) {
      $data = 9;
      echo("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }    
    $data = 2;
  }

} else if ($flag == 4) {
  $sql = "SELECT id FROM prdt_part WHERE supplier_cd = '$supplier_cd'";
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
    $sql = "UPDATE prdt_supplier SET flag='$flag', reuser='$user', reDate=now()  WHERE id='$id'";
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