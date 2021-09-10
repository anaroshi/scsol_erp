<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

$data = array();

/**
 * 모뎀 조회 처리
 * table : trad_part_modem
 * 조건 : modem_sn, modem_tradDateFrom, modem_tradDateTo, modem_status
 * $outputList
 */

$sn             = trim($_POST["modem_sn"]);               // 모뎀 SN
$tradDateFrom   = trim($_POST["modem_tradDateFrom"]);     // 가입 일자 시작
$tradDateTo     = trim($_POST["modem_tradDateTo"]);       // 가입 일자 까지
$status         = trim($_POST["modem_status"]);           // 상태
$product        = trim($_POST["modem_product"]);          // product
$phone_orderby  = trim($_POST["phone_orderby"]);          // PHONE 정렬
$phone_sort     = trim($_POST["phone_sort"]);             // PHONE 정렬
$sn_orderby     = trim($_POST["sn_orderby"]);             // MODEM SN 정렬
$sn_sort        = trim($_POST["sn_sort"]);                // MODEM SN 정렬
$validity       = trim($_POST["modem_validity"]);         // MODEM 정상여부

// echo 'sn: '.$sn;
// echo 'tradDateFrom: '.$tradDateFrom;
// echo 'tradDateTo: '.$tradDateTo;
// echo 'status: '.$status;
// echo 'product: '.$product;

$sql = "SELECT * FROM trad_part_modem ";
$sql .= "WHERE 1 ";
$sql .= "AND flag != 4 ";
if ($sn != "") {
  $sql .= "AND sn LIKE '%$sn%' ";
}
if ($tradDateFrom != '' && $tradDateTo != '') {
  $sql .= "AND tradDate BETWEEN '$tradDateFrom' AND '$tradDateTo' ";
} else if ($tradDateFrom != '' && $tradDateTo == '') {
  $sql .= "AND tradDate >= '$tradDateFrom' ";
} else if ($tradDateFrom == '' && $tradDateTo != '') {
  $sql .= "AND tradDate <= '$tradDateTo' ";
}
if ($status == 1) {
  $sql .= "AND status = 'used'";
  $statuslabel = "used "; 
} elseif ($status == 2) {
  $sql .= "AND status = 'not used' ";
  $statuslabel = "not used ";
}
if ($validity == 1) {
  $sql .= "AND validity = 'Y' ";
} elseif ($validity == 2) {
  $sql .= "AND validity = 'N' ";
}

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$total = mysqli_num_rows($result);

$sql = "SELECT * FROM trad_part_modem ";
$sql .= "WHERE 1 ";
$sql .= "and flag != 4 ";
if ($sn != "") {
  $sql .= "and sn like '%$sn%' ";
}
if ($tradDateFrom != '' && $tradDateTo != '') {
  $sql .= "AND tradDate BETWEEN '$tradDateFrom' AND '$tradDateTo' ";
} else if ($tradDateFrom != '' && $tradDateTo == '') {
  $sql .= "AND tradDate >= '$tradDateFrom' ";
} else if ($tradDateFrom == '' && $tradDateTo != '') {
  $sql .= "AND tradDate <= '$tradDateTo' ";
}
if ($validity == 1) {
  $sql .= "AND validity = 'Y' ";
} elseif ($validity == 2) {
  $sql .= "AND validity = 'N' ";
}
$sql .= "and status = 'used' ";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$usedNum = mysqli_num_rows($result);
$statuslabel = "used ";

$sql = "SELECT * FROM trad_part_modem ";
$sql .= "WHERE 1 ";
$sql .= "and flag != 4 ";
if ($sn != "") {
  $sql .= "and sn like '%$sn%' ";
}

if ($tradDateFrom != '' && $tradDateTo != '') {
  $sql .= "AND tradDate BETWEEN '$tradDateFrom' AND '$tradDateTo' ";
} else if ($tradDateFrom != '' && $tradDateTo == '') {
  $sql .= "AND tradDate >= '$tradDateFrom' ";
} else if ($tradDateFrom == '' && $tradDateTo != '') {
  $sql .= "AND tradDate <= '$tradDateTo' ";
}

if ($status == 1) {
  $sql .= "and status = 'used' ";
  $statuslabel = "used "; 
} elseif ($status == 2) {
  $sql .= "and status = 'not used' ";
  $statuslabel = "not used ";
}

if ($validity == 1) {
  $sql .= "AND validity = 'Y' ";
} elseif ($validity == 2) {
  $sql .= "AND validity = 'N' ";
}

if ($product != "000") {
  $sql .= "and product = '$product' ";
}
if ($phone_orderby == 'phone_asc' && $phone_sort =='on') {
  $sql .= "ORDER BY phone_no DESC;";
  $phone_orderby  = 'phone_desc';
  $sn_orderby     = 'sn_asc';

} else if ($sn_orderby == 'sn_asc' && $sn_sort =='on') {
  $sql .= "ORDER BY sn DESC;";
  $sn_orderby     = 'sn_desc';
  $phone_orderby  = 'phone_asc';
  
} else {
  $sql .= "ORDER BY id ASC;";
  $sn_orderby     = 'sn_asc';
  $phone_orderby  = 'phone_asc';
} 

// echo($sql);

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$subTotal = mysqli_num_rows($result);
if ($status == 0 ) $subTotal = $usedNum;

$outputList ="";
$i = 0;
while ($row = mysqli_fetch_array($result)) {

  $i++;
  $id                   = $row['id'];
  $supplierSn           = $row['supplierSn'];
  $usim                 = $row['usim'];
  $phone_no             = $row['phone_no'];
  $rate                 = $row['rate'];
  $monthlyFee           = $row['monthlyFee'];
  $tradDate             = $row['tradDate'];
  $tradId               = $row['tradId'];
  $status               = $row['status'];
  $validity             = $row['validity'];
  $product              = $row['product'];
  $product_cd           = $row['product_cd'];
  $version              = $row['version'];
  $sn                   = $row['sn'];
  $comment              = $row['comment'];
  $etc                  = $row['etc'];
  $user                 = $row['user'];
  $inDate               = $row['inDate'];
  $reuser               = $row['reuser'];
  $reDate               = $row['reDate'];
  if($reDate=='') {
    $reuser = $user;
    $reDate = $inDate;
  }

  if($validity=="N") {
    $outputList .= "<tr class='tr_modem tr_validity_N'>";
  } else if($status=="used") {    
    $outputList .= "<tr class='tr_modem tr_status_used'>";
  } else {
    $outputList .= "<tr class='tr_modem'>";
  }

  $outputList .= "
      <td class ='d_modem d_id' data-id='$id'>$i</td>
      <td class ='d_modem d_phone_no' name='$phone_orderby'>$phone_no</td>
      <td class ='d_modem d_supplierSn'>$supplierSn</td>
      <td class ='d_modem d_usim'>$usim </td>      
      <td class ='d_modem d_rate'>$rate</td>
      <td class ='d_modem d_monthlyFee'>$monthlyFee</td>
      <td class ='d_modem d_tradDate'>$tradDate</td>
      <td class ='d_modem d_tradId'>$tradId</td>
      <td class ='d_modem d_status'>$status</td>      
      <td class ='d_modem d_validity'>$validity</td>
      <td class ='d_modem d_product'>$product</td>
      <td class ='d_modem d_product_cd'>$product_cd</td>
      <td class ='d_modem d_version'>$version</td>
      <td class ='d_modem d_sn' name='$sn_orderby'>$sn</td>
      <td class ='d_modem d_comment'>$comment</td>
      <td class ='d_modem d_etc'>$etc</td>
      <td class ='d_modem d_reDate'>$reDate</td>
      <td class ='d_modem d_reuser'>$reuser</td>
    </tr>
  ";
}

$outputList .= "<tr><td colspan='24' style='height: 60px;'></td></tr>";
$totalMessage = $statuslabel.number_format($subTotal)."대 / ".number_format($total)."대";
$data['total'] = $totalMessage;
$data['outputList'] = $outputList;
echo json_encode($data);

?>