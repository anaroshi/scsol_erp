<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

$data = array();

$batt_sn            = $_POST['batt_sn'] ?? '';
$batt_tradDateFrom  = $_POST['batt_tradDateFrom'] ?? '';
$batt_tradDateTo    = $_POST['batt_tradDateTo'] ?? '';
$batt_status        = $_POST['batt_status'] ?? '';
$batt_validity      = $_POST['batt_validity'] ?? '';

//echo ($batt_sn.":".$batt_tradDateFrom.":". $batt_tradDateTo.":". $batt_status."<br>");

/**
 * 배터리 조회 처리
 * table : trad_part_battery
 * 조건 : batt_sn, batt_tradDateFrom, batt_tradDteTo, batt_status
 * $outputList
 */

$sql = "SELECT * FROM trad_part_battery ";
$sql .= "WHERE 1 ";
$sql .= "AND flag != 4 ";
if ($batt_sn) {
  $sql .= "AND battery_sn LIKE '%$batt_sn%' ";
}
if ($batt_tradDateFrom != '' && $batt_tradDateTo != '') {
  $sql .= "AND tradDate BETWEEN '$batt_tradDateFrom' AND '$batt_tradDateTo' ";
} else if ($batt_tradDateFrom != '' && $batt_tradDateTo == '') {
  $sql .= "AND tradDate >= '$batt_tradDateFrom' ";
} else if ($batt_tradDateFrom == '' && $batt_tradDateTo != '') {
  $sql .= "AND tradDate <= '$batt_tradDateTo' ";
}
if ($batt_validity == 1) {
  $sql .= "AND validity='Y' ";
} else if ($batt_status == 2 ){
  $sql .= "AND validity='N' ";  
}
$sql .= "AND status='used' ";

if(!($result = mysqli_query($conn_11,$sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
}
$subTotal = mysqli_num_rows($result);
$statuslabel = "used ";
 
$sql = "SELECT * FROM trad_part_battery ";
$sql .= "WHERE 1 ";
$sql .= "AND flag != 4 ";
if ($batt_sn) {
  $sql .= "AND battery_sn LIKE '%$batt_sn%' ";
}
if ($batt_tradDateFrom != '' && $batt_tradDateTo != '') {
  $sql .= "AND tradDate BETWEEN '$batt_tradDateFrom' AND '$batt_tradDateTo' ";
} else if ($batt_tradDateFrom != '' && $batt_tradDateTo == '') {
  $sql .= "AND tradDate >= '$batt_tradDateFrom' ";
} else if ($batt_tradDateFrom == '' && $batt_tradDateTo != '') {
  $sql .= "AND tradDate <= '$batt_tradDateTo' ";
}
if ($batt_status == 1) {
  $sql .= "AND status='used' ";  
} else if ($batt_status == 2 ){
  $sql .= "AND status='not used' ";  
}
if ($batt_validity == 1) {
  $sql .= "AND validity='Y' ";
} else if ($batt_status == 2 ){
  $sql .= "AND validity='N' ";  
}
//echo $sql."<br>";
if(!($result = mysqli_query($conn_11,$sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
}
$total = mysqli_num_rows($result);

$outputList = "";
$no = 0;
while ($row = mysqli_fetch_array($result)) {
  $no++;
  $id                   = $row['id'];
  $batt_sn              = $row['battery_sn'];
  $part_id              = $row['part_id'];
  $tradDate             = $row['tradDate'];
  $tradId               = $row['tradId'];
  $cellType             = $row['cellType'];
  $cellSize             = number_format($row['cellSize']);
  $cellCap              = number_format($row['cellCap']);
  $cellFactory          = $row['cellFactory'];
  $factory              = $row['factory'];
  $status               = $row['status'];
  $validity             = $row['validity'];
  $sn                   = $row['sn'];
  $voltage              = $row['voltage'];
  $comment              = $row['comment'];
  $etc                  = $row['etc'];
  $flag                 = $row['flag'];
  $user                 = $row['user'];
  $inDate               = $row['inDate'];
  $reuser               = $row['reuser'];
  $reDate               = $row['reDate'];
  if($reuser == "") {
    $reuser = $user;
    $reDate = $inDate;
  }

  if($validity=="N") {    
    $outputList .= "<tr class='tr_batt tr_validity_N'>";
  } else if($status=="used") {    
    $outputList .= "<tr class='tr_batt tr_status_used'>";
  } else {
    $outputList .= "<tr class='tr_batt'>";
  }
  
  $outputList .= "
    <td class='d_batt d_id' data-id='$id'>$no</td>      
    <td class='d_batt d_batt_sn'>$batt_sn</td>
    <td class='d_batt d_tradDate'>$tradDate</td>
    <td class='d_batt d_tradId'>$tradId</td>
    <td class='d_batt d_cellType'>$cellType</td>
    <td class='d_batt d_cellSize'>$cellSize</td>
    <td class='d_batt d_cellCap'>$cellCap</td>
    <td class='d_batt d_cellFactory'>$cellFactory</td>
    <td class='d_batt d_factory'>$factory</td>
    <td class='d_batt d_status'>$status</td>
    <td class='d_batt d_validity'>$validity</td>
    <td class='d_batt d_sn'>$sn</td>
    <td class='d_batt d_voltage'>$voltage</td>
    <td class='d_batt d_comment'>$comment</td>
    <td class='d_batt d_etc'>$etc</td>
    <td class='d_batt d_reDate'>$reDate</td>
    <td class='d_batt d_reuser'>$reuser</td>
  </tr>
  ";
}

$outputList .= "<tr><td colspan='24' style='height: 60px;'></td></tr>";
$totalMessage = $statuslabel.number_format($subTotal)."대 / ".number_format($total)."대";
$data['total'] = $totalMessage;
$data['outputList'] = $outputList;
echo json_encode($data);

?>