<?php

/**
 * 선택된 모뎀 수정을 위한 화면
 * 
 */
$id = trim($_POST["id"]);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * 선택된 모뎀 정보 가져오기
 * 
 */

$sql  = "SELECT * FROM trad_part_modem WHERE  flag != 4  and id = '$id' ";
//echo($sql);

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$num = mysqli_num_rows($result);
//echo("num : $num");

$result && $row = mysqli_fetch_assoc($result);

$id                   = $row['id'];
$supplierSn           = $row['supplierSn'];
$usim                 = $row['usim'];
$phone_no             = $row['phone_no'];
$rate                 = $row['rate'];
$monthlyFee           = $row['monthlyFee'];
$tradDate             = $row['tradDate'];
$tradId               = $row['tradId'];
$status               = $row['status'];
$product              = $row['product'];
$product_cd           = $row['product_cd'];
$version              = $row['version'];
$sn                   = $row['sn'];
$validity             = $row['validity'];
$comment              = $row['comment'];
$etc                  = $row['etc'];
$user                 = $row['user'];
$reuser               = $row['reuser'];
if(!$reuser) {
  $reuser = $user;
  $reDate = $inDate;
}

// echo("id : $id, phone_no : $phone_no, supplierSn : $supplierSn, usim : $usim");
// echo("rate : $rate, monthlyFee : $monthlyFee, tradDate : $tradDate");
// echo("tradId : $tradId, status : $status, product : $product, product_cd : $product_cd");
// echo("version : $version, sn : $sn, comment : $comment, etc : $etc");

/**
 * 정상/불량
 * validity
 * Y/N : Default N (불량)
 */
if($validity=='Y') {
  $outputValidity .= "
    <input class='form-check-input' type='radio' name='modem_validity' class='modem_l modem_validity' value='Y' checked>
    <label class='form-check-label' for='modem_validity1' style='width:90px'>정상</label>
    <input class='form-check-input' type='radio' name='modem_validity' class='modem_l modem_validity' value='N'>
    <label class='form-check-label' for='modem_validity2'>불량</label>
  ";  
} else {
  $outputValidity .= "  
    <input class='form-check-input' type='radio' name='modem_validity' class='modem_l modem_validity' value='Y'>
    <label class='form-check-label' for='modem_validity1' style='width:90px'>정상</label>
    <input class='form-check-input' type='radio' name='modem_validity' class='modem_l modem_validity' value='N' checked>
    <label class='form-check-label' for='modem_validity2'>불량</label>
";
}


// 담당자 field
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_user.php");

$response = "
  <table class='modem_mdy'>
    <tr hidden>
      <th><label class='modem_h' for='id'>id</label></th>
      <td><input type='text' class='modem_l modem_id' value = '$id' readonly/></td>
    </tr>
    <tr>
      <th><label class='modem_h' for='phone_no'>PHONE No</label></th>
      <td><input type='text' class='modem_l modem_phone_no' value = '$phone_no' readonly/></td>
    </tr>
    <tr>
      <th><label class='modem_h' for='supplierSn'>Serial No</label></th>
      <td><input type='text' class='modem_l modem_supplierSn' value = '$supplierSn' readonly/></td>
    </tr>
    <tr>
      <th><label class='modem_h' for='usim'>USIM No</label></th>
      <td><input type='text' class='modem_l modem_usim' value = '$usim' readonly/></td>
    </tr>
    <tr>
      <th><label class='modem_h' for='rate'>요금제</label></th>
      <td><input type='text' class='modem_l modem_rate' value = '$rate' readonly/></td>
    </tr>
    <tr>
      <th><label class='modem_h' for='monthlyFee'>약정</label></th>
      <td><input type='text' class='modem_l modem_monthlyFee' value = '$monthlyFee' readonly/></td>
    </tr>
    <tr>
      <th><label class='modem_h' for='tradDate'>가입/입고일자</label></th>
      <td><input type='date' class='modem_l modem_tradDate' value = '$tradDate' readonly/></td>
    </tr>
    <tr>
      <th><label class='modem_h' for='tradId'>입고번호</label></th>
      <td><input type='text' class='modem_l modem_tradId' value = '$tradId' readonly/></td>
    </tr>
    <tr>
      <th><label class='modem_h' for='status'>상태</label></th>
      <td><input type='text' class='modem_l modem_status' value = '$status' readonly/></td> 
    </tr>        
    <tr>
      <th><label class='modem_h' for='product'>Product</label></th>
      <td><input type='text' class='modem_l modem_product' value = '$product' readonly/></td>      
    </tr>
    <tr>
      <th><label class='modem_h' for='product_cd'>Product code</label></th>
      <td><input type='text' class='modem_l modem_product_cd' value = '$product_cd' readonly/></td>
    </tr>
    <tr>
      <th><label class='modem_h' for='version'>Version</label></th>
      <td><input type='text' class='modem_l modem_version' value = '$version' readonly/></td>
    </tr>
    <tr>
      <th><label class='modem_h' for='sn'>SCSOL S/N</label></th>
      <td><input type='text' class='modem_l modem_sn' value = '$sn' readonly/></td>
    </tr>
    <tr>
      <th><label class='modem_h' for='validity'>정상</label></th>      
      <td>
        <div class='form-check'>$outputValidity</div>
      </td>
    </tr>
    <tr>
      <th><label class='modem_h' for='comment'>Comment</label></th>
      <td><input type='text' class='modem_l modem_comment' value = '$comment'></td>
    </tr>
    <tr>
      <th><label class='modem_h' for='etc'>ETC</label></th>
      <td><input type='text' class='modem_l modem_etc' value = '$etc'></td>
    </tr>
    <tr>$outputUser</tr>
  </table>
";

echo $response;
exit;

?>
