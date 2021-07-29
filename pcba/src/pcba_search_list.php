<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

$data = array();

/**
 * PCBA 조회 처리
 * table : trad_part_pcba
 * 조건 : pcba_sn, pcba_tradDateFrom, pcba_tradDateTo, pcba_status
 * $outputList
 */

$pcba_sn        = trim($_POST["pcba_sn"]) ?? "";                // PCBA SN
$tradDateFrom   = trim($_POST["pcba_tradDateFrom"]) ?? "";      // 가입 일자 시작
$tradDateTo     = trim($_POST["pcba_tradDateTo"]) ?? "";        // 가입 일자 까지
$status         = trim($_POST["pcba_status"]) ?? "";            // 상태
$validity       = trim($_POST["pcba_validity"]) ?? "";          // 상태
$sn_orderby     = trim($_POST["sn_orderby"]) ?? "";             // 센서 SN 정렬
$sn_sort        = trim($_POST["sn_sort"]) ?? "";                // 센서 SN 정렬
$adc_orderby    = trim($_POST["adc_orderby"]) ?? "";            // 센서 ADC 정렬
$adc_sort       = trim($_POST["adc_sort"]) ?? "";               // 센서 ADC 정렬
$issue_orderby  = trim($_POST["issue_orderby"]) ?? "";          // 센서 ISSUE 정렬
$issue_sort     = trim($_POST["issue_sort"]) ?? "";             // 센서 ISSUE 정렬

// echo 'pcba_sn: '.$pcba_sn;
// echo 'tradDateFrom: '.$tradDateFrom;
// echo 'tradDateTo: '.$tradDateTo;
// echo 'status: '.$status;
// echo 'validity: '.$validity;

$sql = "SELECT * FROM trad_part_pcba ";
$sql .= "WHERE 1 ";
$sql .= "AND flag != 4 ";
if ($pcba_sn != "") {
  $sql .= "AND pcba_sn LIKE '%$pcba_sn%' ";
}
if ($tradDateFrom != "" || $tradDateTo != "") {
  $sql .= "AND tradDate BETWEEN '$tradDateFrom' AND '$tradDateTo' ";
}
if ($status == 1) {
  $sql .= "AND status = 'used' ";
} elseif ($status == 2) {
  $sql .= "AND status = 'not used' ";
}
if($validity == 1) {
  $sql .= "AND validity = 'Y' ";
} elseif ($validity == 2) {
  $sql .= "AND validity = 'N' ";
}
//echo('total:'.$sql.'\n');
if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$total = mysqli_num_rows($result);

$sql = "SELECT * FROM trad_part_pcba ";
$sql .= "WHERE 1 ";
$sql .= "AND flag != 4 ";
if ($pcba_sn != "") {
  $sql .= "AND pcba_sn LIKE '%$pcba_sn%' ";
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
//echo('used:'.$sql.'\n');
if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$usedNum = mysqli_num_rows($result);
$statuslabel = "used ";

$sql = "SELECT * FROM trad_part_pcba ";
$sql .= "WHERE 1 ";
$sql .= "AND flag != 4 ";
if ($pcba_sn != "") {
  $sql .= "AND pcba_sn LIKE '%$pcba_sn%' ";
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
  $sql .= "ORDER BY pcba_sn DESC;";
  $sn_orderby     = 'sn_desc';
  $adc_orderby    = 'adc_asc';
  $issue_orderby  = 'issue_asc';

} else if ($sn_orderby == 'sn_desc' && $sn_sort =='on') {
  $sql .= "ORDER BY pcba_sn ASC;";
  $sn_orderby     = 'sn_asc';
  $adc_orderby    = 'adc_asc';
  $issue_orderby  = 'issue_asc';

} else if ($adc_orderby == 'adc_asc' && $adc_sort =='on') {
  $sql .= "ORDER BY adc DESC;";
  $adc_orderby    = 'adc_desc';
  $sn_orderby     = 'sn_asc';
  $issue_orderby  = 'issue_asc';

} else if ($adc_orderby == 'adc_desc' && $adc_sort =='on') {
  $sql .= "ORDER BY adc ASC;";
  $adc_orderby    = 'adc_asc';
  $sn_orderby     = 'sn_asc';
  $issue_orderby  = 'issue_asc';

} else if ($issue_orderby == 'issue_asc' && $issue_sort =='on') {
  $sql .= "ORDER BY issue DESC;";
  $issue_orderby  = 'issue_desc';
  $sn_orderby     = 'sn_asc';
  $adc_orderby    = 'adc_asc';

} else if ($issue_orderby == 'issue_desc' && $issue_sort =='on') {
  $sql .= "ORDER BY issue ASC;";
  $issue_orderby  = 'issue_asc';
  $sn_orderby     = 'sn_asc';
  $adc_orderby    = 'adc_asc';

} else {
  $sql .= "ORDER BY id ASC;";
  $issue_orderby  = 'issue_asc';
  $sn_orderby     = 'sn_asc';
  $adc_orderby    = 'adc_asc';
} 
//echo('list:'.$sql.'\n');

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$subTotal = mysqli_num_rows($result);
if ($status == 0) $subTotal = $usedNum;

$outputList = "";
$i = 0;
while ($row = mysqli_fetch_array($result)) {  
  $i++;
  $id                     = $row['id'];
  $pcba_sn                = $row['pcba_sn'];
  $part_id                = $row['part_id'];
  $tradDate               = $row['tradDate'];
  $tradId                 = $row['tradId'];
  $version                = $row['version'];
  $type                   = $row['type'];
  $status                 = $row['status'];
  $validity               = $row['validity'];
  $sn                     = $row['sn'];
  $hostcnt                = $row['hostcnt'];
  $mcucnt                 = $row['mcucnt'];
  $modemcnt               = $row['modemcnt'];
  $battcnt                = $row['battcnt'];
  $ssorcnt                = $row['ssorcnt'];
  $ldo                    = $row['ldo'];
  $radio                  = $row['radio'];
  $buz                    = $row['buz'];
  $adc                    = $row['adc'];
  $memory                 = $row['memory'];
  $issue                  = $row['issue'];
  $comment                = $row['comment'];
  $etc                    = $row['etc'];
  $img_radio              = $row['img_radio'];
  $img_adc                = $row['img_adc'];
  $inDate                 = $row['inDate'] ?? "";
  $user                   = $row['user'] ?? "";
  $reDate                 = $row['reDate'] ?? "";
  $reuser                 = $row['reuser'] ?? "";
  if($reDate=='') {
    $reuser = $user;
    $reDate = $inDate;
  }

  if($validity=="N") {
    $outputList .= "<tr class='tr_pcba tr_validity_N'>";
  } else if($status=="used") {    
    $outputList .= "<tr class='tr_pcba tr_status_used'>";
  } else {
    $outputList .= "<tr class='tr_pcba'>";
  }

  $outputList .= "
      <td class='d_pcba d_id' data-id='$id'>$i</td>      
      <td class='d_pcba d_pcba_sn' name='$sn_orderby'>$pcba_sn</td>
      <td class='d_pcba d_tradDate'>$tradDate</td>
      <td class='d_pcba d_tradId'>$tradId</td>
      <td class='d_pcba d_version'>$version</td>
      <td class='d_pcba d_type'>$type</td>
      <td class='d_pcba d_status'>$status</td>
      <td class='d_pcba d_validity'>$validity</td>
      <td class='d_pcba d_sn'>$sn</td>
      <td class='d_pcba d_hostcnt'>$hostcnt</td>
      <td class='d_pcba d_mcucnt'>$mcucnt</td>
      <td class='d_pcba d_modemcnt'>$modemcnt</td>
      <td class='d_pcba d_battcnt'>$battcnt</td>
      <td class='d_pcba d_ssorcnt'>$ssorcnt</td>
      <td class='d_pcba d_ldo'>$ldo</td>
      <td class='d_pcba d_radio'>$radio</td>
      <td class='d_pcba d_buz'>$buz</td>
      <td class='d_pcba d_adc' name='$adc_orderby'>$adc</td>
      <td class='d_pcba d_memory'>$memory</td>
      <td class='d_pcba d_issue' name='$issue_orderby'>$issue</td>
      <td class='d_pcba d_comment'>$comment</td>
      <td class='d_pcba d_etc'>$etc</td>
      <td class='d_pcba d_img_radio'>$img_radio</td>
      <td class='d_pcba d_img_adc'>$img_adc</td>
      <td class='d_pcba d_reDate'>$reDate</td>
      <td class='d_pcba d_reuser'>$reuser</td>
    </tr>
  ";
}

$outputList .= "<tr><td colspan='24' style='height: 60px;'></td></tr>";
$totalMessage = $statuslabel . number_format($subTotal) . "대 / " . number_format($total) . "대";
$data['total'] = $totalMessage;
$data['outputList'] = $outputList;
echo json_encode($data);
