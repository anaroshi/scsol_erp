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
$item     = trim($_POST["item"]) ?? "";            // 2. Item
$item_cd  = trim($_POST["item_cd"]) ?? "";         // 3. Item_cd
$user     = trim($_POST["user"]) ?? "";            // 4. 사용자
$flag     = trim($_POST["flag"]) ?? "";            // 5. flag

//echo("id : $id, item : $item, user : $user, flag : $flag<br>");

if ($flag == 1) {

  // SAVE
  /**
   * 종류 중복 확인
   * table : prdt_item
   */

  $sql    = "SELECT id, item FROM prdt_item WHERE item = '$item' ";
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
   * table : prdt_item
   */

    $sql      = "SELECT CONCAT(LEFT(item_cd,4), RIGHT(item_cd,3)+1) item_cd, sort+10 sort ";
    $sql     .= "FROM prdt_item ORDER BY id DESC LIMIT 1";
    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
      goto escape;
    }
    $row      = mysqli_fetch_assoc($result);
    $item_cd  = $row['item_cd'];                    // 종류 Code
    $sort     = $row['sort'];                        // 정렬순서

    $sql      = "INSERT INTO prdt_item (item, item_cd, sort, flag, user, inDate) ";
    $sql     .= "VALUES ('$item','$item_cd','$sort', '$flag', '$user', now()) ";
    if (!($result = mysqli_query($conn_11, $sql))) {
      $data = 9;
      echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }
    $data = 1;
  }
} else if ($flag == 2) {

  // UPDATE
  // 동일한 종류가 있는지 확인
  $sql    = "SELECT id, item FROM prdt_item WHERE item = '$item' AND id !='$id' ";
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
    $sql = "UPDATE prdt_item SET item='$item', flag='$flag', reuser='$user', reDate=now()  WHERE id='$id'";
    //echo($sql);
    if(!($result =mysqli_query($conn_11,$sql))) {
      $data = 9;
      echo("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
    }    
    $data = 2;
  }

} else if ($flag == 4) {
  $sql = "SELECT id FROM prdt_part WHERE item_cd = '$item_cd'";
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
    $sql = "UPDATE prdt_item SET flag='$flag', reuser='$user', reDate=now()  WHERE id='$id'";
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