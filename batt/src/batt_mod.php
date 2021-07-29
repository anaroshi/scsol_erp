<?php

/**
 * 선택된 BATTERY 수정을 위한 화면
 * 
 */
error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

$batt_sn = $_POST['batt_sn'] ?? '';


/**
 * 선택된 BATTERY 정보 가져오기
 * 
 */

$sql  = "SELECT * FROM trad_part_battery WHERE flag != 4 AND battery_sn = '$batt_sn' ";
// echo($sql);

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$num = mysqli_num_rows($result);
// echo("num : $num");

$result && $row = mysqli_fetch_assoc($result);

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
if(!$reuser) {
  $reuser = $user;
  $reDate = $inDate;
}

// echo("id : $id, batt_sn : $batt_sn, part_id : $part_id, tradDate : $tradDate");
// echo("tradId : $tradId, cellType : $cellType, cellSize : $cellSize, cellCap : $cellCap, cellFactory : $cellFactory");
// echo("factory : $factory, status : $status, validity : $validity, sn : $sn, voltage : $voltage");
// echo("comment : $comment, etc : $etc, reuser : $reuser");

/**
 * 정상/불량
 * validity
 * Y/N : Default N (불량)
 */
if($validity=='Y') {
  $outputValidity = "
    <input class='form-check-input' type='radio' name='batt_validity' class='batt_l batt_validity' value='Y' checked>
    <label class='form-check-label' for='batt_validity1' style='width:40px'>정상</label>
    <input class='form-check-input' type='radio' name='batt_validity' class='batt_l batt_validity' value='N'>
    <label class='form-check-label' for='batt_validity2'>불량</label>
  ";  
} else {
  $outputValidity = "  
    <input class='form-check-input' type='radio' name='batt_validity' class='batt_l batt_validity' value='Y'>
    <label class='form-check-label' for='batt_validity1' style='width:40px'>정상</label>
    <input class='form-check-input' type='radio' name='batt_validity' class='batt_l batt_validity' value='N' checked>
    <label class='form-check-label' for='batt_validity2'>불량</label>
";
}

// 담당자 field
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_user.php");

$response = "
  <table class='batt_mdy'>
    <tr>
      <td class='batt_1'>
        <table>
          <tr hidden>
            <th><label class='batt_h' for='id'>id</label></th>
            <td><input type='text' class='batt_l batt_readonly batt_id' value='$id' readonly/></td>
          </tr>
          <tr>
            <th><label class='batt_h' for='batt_sn'>BATTERY_SN</label></th>
            <td><input type='text' class='batt_l batt_readonly batt_sn' value='$batt_sn' readonly></td>
          </tr>
          <tr>
            <th><label class='batt_h' for='tradDate'>입고일자</label></th>
            <td><input type='date' class='batt_l batt_readonly batt_tradDate' value='$tradDate' readonly></td>
          </tr>
          <tr>
            <th><label class='batt_h' for='tradId'>입고번호</label></th>
            <td><input type='text' class='batt_l batt_readonly batt_tradId' value='$tradId' readonly></td>
          </tr>
          <tr>
            <th><label class='batt_h' for='cellType'>Cell Type</label></th>
            <td><input type='text' class='batt_l batt_readonly batt_cellType' value='$cellType' readonly></td>
          </tr>
          <tr>
            <th><label class='batt_h' for='cellSize'>Cell Size</label></th>
            <td><input type='text' class='batt_l batt_readonly batt_cellSize' value='$cellSize' readonly></td>
          </tr>
          <tr>
            <th><label class='batt_h' for='cellCap'>Cell Capacity(mA)</label></th>
            <td><input type='text' class='batt_l batt_readonly cellCap' value='$cellCap' readonly></td>
          </tr>
          <tr>
            <th><label class='batt_h' for='cellFactory'>Cell 제조사</label></th>
            <td><input type='text' class='batt_l batt_readonly cellFactory' value='$cellFactory' readonly></td>
          </tr>
          <tr>
            <th><label class='batt_h' for='factory'>제조사</label></th>
            <td><input type='text' class='batt_l batt_readonly batt_factory' value='$factory' readonly></td>
          </tr>          
        </table>
      </td>
      <td style='width: 20px;'></td>
      <td>
        <table>
          <tr>
            <th><label class='batt_h' for='status'>상태</label></th>
            <td><input type='text' class='batt_l batt_readonly batt_status' value = '$status' readonly/></td>
          </tr>
          <tr>
            <th><label class='batt_h' for='sn'>SCSOL S/N</label></th>
            <td><input type='text' class='batt_l batt_readonly batt_scsolsn' value='$sn' readonly/></td>
          </tr>
          <tr>
            <th><label class='batt_h' for='voltage'>배터리 전압(V)</label></th>
            <td><input type='number' class='batt_l batt_voltage' value='$voltage'></td>
          </tr>
          <tr>
            <th><label class='batt_h' for='comment'>비고</label></th>
            <td><input type='text' class='batt_l batt_comment' value='$comment'></td>
          </tr>
          <tr>
            <th><label class='batt_h' for='etc'>기타</label></th>
            <td><input type='text' class='batt_l batt_etc' value='$etc'></td>
          </tr>
          <tr>
          <th><label class='batt_h' for='validity'>정상</label></th>      
            <td>
              <div class='form-check'>
                $outputValidity
              </div>
            </td>
          </tr>
          <tr>$outputUser</tr>     
        </table>
      </td>
    </tr>    
  </table>
";

echo $response;
exit;

?>
