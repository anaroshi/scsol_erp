<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * 생산 관리 입력 화면 - Data
 */

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * SCSOL SENSOR NUMBER
 * table      : prdt_part_modem
 * sn
 * $outputSnList
 * default    : 공백, value : 000
 * status = 'not used' : 사용하지 않는 SN만
 * flag != 4  : 삭제품목 제외
 * validity   : 불량
 */ 

$outputSnList ='';

$sql = "SELECT sn FROM trad_part_modem WHERE status='not used' AND flag != 4 AND validity='Y' ORDER BY sn ";


if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

while ($row = mysqli_fetch_array($result)) {
  $outputSnList .= '<div class="item prdt_modem" data-value= "' . $row["sn"] . '">' . $row["sn"] . '</div>';
}

$sql = "SELECT count(*) modemCnt FROM trad_part_modem WHERE status='not used' AND flag != 4 AND validity='Y' ORDER BY sn ";


if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$row = mysqli_fetch_assoc($result);
$modemCnt = $row["modemCnt"];


/**
 * pcba
 * table : prdt_part_pcba
 * pcba_sn
 * $outputPcbaList
 * default : 공백, value : 000
 * status = 'not used' : 사용하지 않는 pcba_sn
 * flag != 4 : 삭제품목 제외
 */ 

$outputPcbaList ='';

$sql = "SELECT pcba_sn FROM trad_part_pcba WHERE status='not used' AND flag !=4 AND validity='Y' ORDER BY pcba_sn ";


if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

while ($row = mysqli_fetch_array($result)) {
  $outputPcbaList .= '<div class="item part_pcba" data-value= "' . $row["pcba_sn"] . '">' . $row["pcba_sn"] . '</div>';
}

$sql = "SELECT count(*) pcbaCnt FROM trad_part_pcba WHERE status='not used' AND flag !=4 AND validity='Y' ORDER BY pcba_sn ";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$row = mysqli_fetch_assoc($result);
$pcbaCnt = $row["pcbaCnt"];

/**
 * sensor
 * table : prdt_part_sensor
 * sensor_sn
 * $outputSensorList
 * default : 공백, value : 000
 * status = 'not used' : 사용하지 않는 sensor_sn
 * flag != 4 : 삭제품목 제외
 */ 

$outputSensorList ='';

$sql = "SELECT sensor_sn FROM trad_part_sensor WHERE status='not used' AND flag !=4 AND validity='Y' ORDER BY sensor_sn ";


if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

while ($row = mysqli_fetch_array($result)) {
  $outputSensorList .= '<div class="item part_sensor" data-value= "' . $row["sensor_sn"] . '">' . $row["sensor_sn"] . '</div>';
}

$sql = "SELECT count(*) sensorCnt FROM trad_part_sensor WHERE status='not used' AND flag !=4 AND validity='Y' ORDER BY sensor_sn ";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$row = mysqli_fetch_assoc($result);
$sensorCnt = $row["sensorCnt"];

/**
 * battery
 * table : prdt_part_battery
 * battery_sn
 * $outputBatteryList
 * default : 공백, value : 000
 * status = 'not used' : 사용하지 않는 battery_sn
 * flag != 4 : 삭제품목 제외
 */ 

$outputBatteryList ='';

$sql = "SELECT battery_sn FROM trad_part_battery WHERE status='not used' AND flag !=4 AND validity='Y' ORDER BY battery_sn ";


if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

while ($row = mysqli_fetch_array($result)) {
  $outputBatteryList .= '<div class="item part_battery" data-value= "' . $row["battery_sn"] . '">' . $row["battery_sn"] . '</div>';
}

$sql = "SELECT count(*) batteryCnt FROM trad_part_battery WHERE status='not used' AND flag !=4 AND validity='Y' ORDER BY battery_sn ";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$row = mysqli_fetch_assoc($result);
$batteryCnt = $row["batteryCnt"];

/**
 * case
 * table : prdt_part_case
 * case_sn
 * $outputCaseList
 * default : 공백, value : 000
 * status = 'not used' : 사용하지 않는 case_sn만
 * flag != 4 : 삭제품목 제외
 */ 

$outputCaseList ='';

$sql = "SELECT case_sn FROM trad_part_case WHERE status='not used' AND flag !=4 AND validity='Y' ORDER BY case_sn ";


if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

while ($row = mysqli_fetch_array($result)) {
  $outputCaseList .= '<div class="item part_case" data-value= "' . $row["case_sn"] . '">' . $row["case_sn"] . '</div>';
}

$sql = "SELECT count(*) caseCnt FROM trad_part_case WHERE status='not used' AND flag !=4 AND validity='Y' ORDER BY case_sn ";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$row = mysqli_fetch_assoc($result);
$caseCnt = $row["caseCnt"];


/**
 * 담당자
 * table : erp_user
 * name
 * $outputUserList
 * default : 공백, value : 000 
 * flag != 4 : 삭제품목 제외
 */ 

$outputUserList ='';

$sql = "SELECT name FROM erp_user WHERE flag !=4 ORDER BY name ";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

while ($row = mysqli_fetch_array($result)) {
  $outputUserList .= '<div class="item part_user" data-value= "' . $row["name"] . '">' . $row["name"] . '</div>';
}

$sql = "SELECT count(*) userCnt FROM erp_user WHERE flag !=4";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$row = mysqli_fetch_assoc($result);
$userCnt = $row["userCnt"];

$conn_11->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="../../../semantic/semantic.min.css">
  <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
  <script src="../../../semantic/semantic.min.js"></script>

  <title>생산관리</title>
  <link rel="shortcut icon" href="../image/construction.png">
  <script src="../js/prdt_int.js" defer></script>
  <link rel="stylesheet" href="../css/prdt_int.css">
</head>

<body>
<div class="container">
  <nav id="prdt_up" class="prdt_up">    
    <div class="prdt_search prdt_all_btn">
      <input type="button" class="prdt_btn prdt_clear" value="초기화">
      <input type="button" class="prdt_btn prdt_int" value="저장">
    </div>
  </nav>

  <div class="ui form">
    <div class="seven fields">
      
      <div class="field">
        <label><div class='label_sn'><span>SCSOL SN</span><span><?php echo($modemCnt."개") ?></span></div></label>
        <div class="ui search selection dropdown">
          <input type="hidden" value="modem">
          <i class="dropdown icon"></i>
          <input type="text" class="search" tabindex="0">
          <div class="text">Select SCSOL SN</div>
          <div class="menu transition hidden" tabindex="-1">
          <?php echo $outputSnList ?>
          </div>
        </div>
      </div>

      <div class="field">
        <label><div class='label_sn'><span>PCBA</span><span><?php echo($pcbaCnt."개") ?></span></div></label>
        <div class="ui search selection dropdown">
          <input type="hidden" value="pcba">
          <i class="dropdown icon"></i>
          <input type="text" class="search" tabindex="0">
          <div class="text">Select PCBA</div>
          <div class="menu transition hidden" tabindex="-1">
          <?php echo $outputPcbaList ?>
          </div>
        </div>
      </div>
      
      <div class="field">
        <label><div class='label_sn'><span>SENSOR</span><span><?php echo($sensorCnt."개") ?></span></div></label>
        <div class="ui search selection dropdown">
          <input type="hidden" value="sensor">
          <i class="dropdown icon"></i>
          <input type="text" class="search" tabindex="0">
          <div class="text">Select SENSOR</div>
          <div class="menu transition hidden" tabindex="-1">
          <?php echo $outputSensorList ?>
          </div>
        </div>          
      </div>

      <div class="field">
        <label><div class='label_sn'><span>BATTERY</span><span><?php echo($batteryCnt."개") ?></span></div></label>
        <div class="ui search selection dropdown">
          <input type="hidden" value="battery">
          <i class="dropdown icon"></i>
          <input type="text" class="search" tabindex="0">
          <div class="text">Select BATTERY</div>
          <div class="menu transition hidden" tabindex="-1">
          <?php echo $outputBatteryList ?>
          </div>
        </div>          
      </div>

      <div class="field">
        <label><div class='label_fwVersion'>Firmware Version</div></label>
        <div class="ui input">   
          <input type="text" class="prdt_fwVersion" tabindex="0">         
        </div>          
      </div>      

      <div class="field">
        <label><div class='label_sn'><span>담당자</span></div></label>
        <div class="ui search selection dropdown">
          <input type="hidden" value="user">
          <i class="dropdown icon"></i>
          <input type="text" class="search" tabindex="0">
          <div class="text">Select NAME</div>
          <div class="menu transition hidden" tabindex="-1">
          <?php echo $outputUserList ?>
          </div>
        </div>
      </div>     

    </div>
  </div>
</div>  
</body>
</html>
