<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

$data = array();

/**
 * 센서 조회 처리
 * table : trad_part_sensor
 * 조건 : sensor_sn, sensor_tradDateFrom, sensor_tradDateTo, sensor_status
 * $outputList
 */


$sensor_sn      = trim($_POST["sensor_sn"]);                // 센서 SN
$tradDateFrom   = trim($_POST["sensor_tradDateFrom"]);      // 가입 일자 시작
$tradDateTo     = trim($_POST["sensor_tradDateTo"]);        // 가입 일자 까지
$status         = trim($_POST["sensor_status"]);            // 상태
$sn_orderby     = trim($_POST["sn_orderby"]);               // 센서 SN 정렬
$sn_sort        = trim($_POST["sn_sort"]);                  // 센서 SN 정렬
$validity       = trim($_POST["sensor_validity"]);          // 정상여부

// echo 'sn: '.$sn;
// echo 'tradDateFrom: '.$tradDateFrom;
// echo 'tradDateTo: '.$tradDateTo;
// echo 'status: '.$status;
// echo 'sn_sort: '.$sn_sort;

$sql = "SELECT * FROM trad_part_sensor ";
$sql .= "WHERE 1 ";
$sql .= "AND flag != 4 ";
if ($sensor_sn != "") {
  $sql .= "AND sensor_sn like '%$sensor_sn%' ";
}
if ($tradDateFrom != "" || $tradDateTo != "") {
  $sql .= "AND tradDate BETWEEN '$tradDateFrom' AND '$tradDateTo' ";
}
if ($status == 1) {
  $sql .= "AND status = 'used' ";
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

$sql = "SELECT * FROM trad_part_sensor ";
$sql .= "WHERE 1 ";
$sql .= "AND flag != 4 ";
if ($sensor_sn != "") {
  $sql .= "AND sensor_sn like '%$sensor_sn%' ";
}
if ($tradDateFrom != "" || $tradDateTo != "") {
  $sql .= "AND tradDate BETWEEN '$tradDateFrom' AND '$tradDateTo' ";
}
if ($validity == 1) {
  $sql .= "AND validity = 'Y' ";
} elseif ($validity == 2) {
  $sql .= "AND validity = 'N' ";
}
$sql .= "AND status = 'used' ";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$usedNum = mysqli_num_rows($result);
$statuslabel = "used ";

$sql = "SELECT * FROM trad_part_sensor ";
$sql .= "WHERE 1 ";
$sql .= "AND flag != 4 ";
if ($sensor_sn != "") {
  $sql .= "AND sensor_sn like '%$sensor_sn%' ";
}
if ($tradDateFrom != "" || $tradDateTo != "") {
  $sql .= "AND tradDate BETWEEN '$tradDateFrom' AND '$tradDateTo' ";
}
if ($status == 1) {
  $sql .= "AND status = 'used' ";
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
if ($sn_orderby == 'sn_asc' && $sn_sort =='on') {
  $sql .= "ORDER BY sensor_sn DESC;";
  $sn_orderby = 'sn_desc';

} else {
  $sql .= "ORDER BY id ASC;";
  $sn_orderby = 'sn_asc';
} 

//echo ($sql);

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$subTotal = mysqli_num_rows($result);
if ($status == 0) $subTotal = $usedNum;

$outputList = "";
$no = 0;
while ($row = mysqli_fetch_array($result)) {

  $no++;
  $id                     = $row['id'];
  $sensor_sn              = $row['sensor_sn'];
  $part_id                = $row['part_id'];
  $tradDate               = $row['tradDate'];
  $tradId                 = $row['tradId'];
  $status                 = $row['status'];
  $validity               = $row['validity'];
  $sn                     = $row['sn'];
  $hz_mix_fhAvg           = $row['hz_mix_fhAvg'];
  $hz_mix_shAvg           = $row['hz_mix_shAvg'];
  $hz_mix_ehAvg           = $row['hz_mix_ehAvg'];
  $hz_mix_ttAvg           = $row['hz_mix_ttAvg'];
  $hz_mix_twAvg           = $row['hz_mix_twAvg'];
  $hz_fhAvg               = $row['hz_fhAvg'];
  $hz_shAvg               = $row['hz_shAvg'];
  $hz_ehAvg               = $row['hz_ehAvg'];
  $hz_ttAvg               = $row['hz_ttAvg'];
  $hz_twAvg               = $row['hz_twAvg'];
  $conclusion             = $row['conclusion'];
  $issue                  = $row['issue'];
  $comment                = $row['comment'];
  $etc                    = $row['etc'];
  $image_1                = $row['image_1'];
  $image_2                = $row['image_2'];
  $image_3                = $row['image_3'];
  $inDate                 = $row['inDate'] ?? "";
  $user                   = $row['user'] ?? "";
  $reDate                 = $row['reDate'] ?? "";
  $reuser                 = $row['reuser'] ?? "";
  if($reDate=='') {
    $reuser = $user;
    $reDate = $inDate;
  }

  if($validity=="N") {
    $outputList .= "<tr class='tr_sensor tr_validity_N'>";
  } else if($status=="used") {    
    $outputList .= "<tr class='tr_sensor tr_status_used'>";
  } else {
    $outputList .= "<tr class='tr_sensor'>";
  }

  $outputList .= "
      <td class='d_sensor d_id' data-id='$id'>$no</td>
      <td class='d_sensor d_sensor_sn' name='$sn_orderby'>$sensor_sn</td>
      <td class='d_sensor d_tradDate'>$tradDate</td>
      <td class='d_sensor d_tradId'>$tradId</td>
      <td class='d_sensor d_status'>$status</td>
      <td class='d_sensor d_validity'>$validity</td>
      <td class='d_sensor d_sn'>$sn</td>
      <td class='d_sensor d_hz_mix_fhAvg'>$hz_mix_fhAvg</td>
      <td class='d_sensor d_hz_mix_shAvg'>$hz_mix_shAvg</td>
      <td class='d_sensor d_hz_mix_ehAvg'>$hz_mix_ehAvg</td>
      <td class='d_sensor d_hz_mix_ttAvg'>$hz_mix_ttAvg</td>
      <td class='d_sensor d_hz_mix_twAvg'>$hz_mix_twAvg</td>
      <td class='d_sensor d_hz_fhAvg'>$hz_fhAvg</td>
      <td class='d_sensor d_hz_shAvg'>$hz_shAvg</td>
      <td class='d_sensor d_hz_ehAvg'>$hz_ehAvg</td>
      <td class='d_sensor d_hz_ttAvg'>$hz_ttAvg</td>
      <td class='d_sensor d_hz_twAvg'>$hz_twAvg</td>
      <td class='d_sensor d_conclusion'>$conclusion</td>
      <td class='d_sensor d_issue'>$issue</td>
      <td class='d_sensor d_comment'>$comment</td>
      <td class='d_sensor d_etc'>$etc</td>
      <td class='d_sensor d_image_1'>$image_1</td>
      <td class='d_sensor d_image_2'>$image_2</td>
      <td class='d_sensor d_image_3'>$image_3</td>
      <td class='d_sensor d_reDate'>$reDate</td>
      <td class='d_sensor d_reuser'>$reuser</td>
    </tr>
  ";
}

$outputList .= "<tr><td colspan='24' style='height: 60px;'></td></tr>";
$totalMessage = $statuslabel . number_format($subTotal) . "대 / " . number_format($total) . "대";
$data['total'] = $totalMessage;
$data['outputList'] = $outputList;
echo json_encode($data);
