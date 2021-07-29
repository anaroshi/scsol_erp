<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * 생산 관리 입력 화면 - Data
 */

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

$id = trim($_GET['id']);

/**
 * 생산정보 List
 */

$sql = "SELECT * FROM step_product WHERE id = " . $id;
if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}
$row = mysqli_fetch_assoc($result);
$id                   = $row['id'];
$scsol_sn             = $row['scsol_sn'];
$phone_no             = $row['phone_no'];
$pcba_sn              = $row['pcba_sn'];
$sensor_sn            = $row['sensor_sn'];
$battery_sn           = $row['battery_sn'];
$case_sn              = $row['case_sn'];
$fwVesrion            = $row['fw_version'];
$leaktest_t1_p4       = $row['leaktest_t1_p4_chk'];
$leaktest_t1_p4_imgNM = $row['leaktest_t1_p4_imgNM'];
$leaktest_t1_p5       = $row['leaktest_t1_p5_chk'];
$leaktest_t1_p5_imgNM = $row['leaktest_t1_p5_imgNM'];
$radiotest_t1         = $row['radiotest_t1_chk'];
$radiotest_t1_imgNM   = $row['radiotest_t1_imgNM'];
$mold                 = $row['mold_chk'];
$mold_imgNM1          = $row['mold_imgNM1'];
$mold_imgNM2          = $row['mold_imgNM2'];
$leaktest_t2_p4       = $row['leaktest_t2_p4_chk'];
$leaktest_t2_p4_imgNM = $row['leaktest_t2_p4_imgNM'];
$leaktest_t2_p5       = $row['leaktest_t2_p5_chk'];
$leaktest_t2_p5_imgNM = $row['leaktest_t2_p5_imgNM'];
$radiotest_t2         = $row['radiotest_t2_chk'];
$radiotest_t2_imgNM   = $row['radiotest_t2_imgNM'];
$comment1             = $row['comment1'];
$comment2             = $row['comment2'];
$comment3             = $row['comment3'];
$etc                  = $row['etc'];
$flag                 = $row['flag'];
$status               = $row['status'];
$finalState           = $row['finalState'];
$user                 = $row['user'];
$inDate               = $row['inDate'];
$reuser               = $row['reuser'];
$reDate               = $row['reDate'];

if($reDate=="") {
  $reuser = $user;
  $reDate = $inDate;
}

$pcba_sn_ex           = $pcba_sn;
$sensor_sn_ex         = $sensor_sn;
$battery_sn_ex        = $battery_sn;
$case_sn_ex           = $case_sn;
$fwVesrion_ex         = $fwVesrion;
$reuser_ex            = $reuser;

if ($pcba_sn) {
  $outputTextPcbaList = $pcba_sn;
} else {
  $outputTextPcbaList = "Select PCBA";
}

if ($sensor_sn) {
  $outputTextSensorList = $sensor_sn;
} else {
  $outputTextSensorList = "Select SENSOR";
}

if ($battery_sn) {
  $outputTextBatteryList = $battery_sn;
} else {
  $outputTextBatteryList = "Select BATTERY";
}

if ($case_sn) {
  $outputTextCaseList = $case_sn;
} else {
  $outputTextCaseList = "Select CASE";
}

if ($reuser) {
  $outputTextUserList = $reuser;
} else {
  $outputTextUserList = "Select NAME";
}


/**
 * pcba
 * table : prdt_part_pcba
 * pcba_sn
 * $outputPcbaList
 * default : 공백, value : 000
 * status = 'not used' : 사용하지 않는 pcba_sn
 * flag != 4 : 삭제품목 제외
 */

$outputPcbaList = '';

$sql = "SELECT pcba_sn FROM trad_part_pcba WHERE flag !=4  AND validity='Y' ORDER BY pcba_sn ";


if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

while ($row = mysqli_fetch_array($result)) {
  if ($pcba_sn ==$row["pcba_sn"] ) {
    $outputPcbaList .= '<div class="item part_pcba active selected" data-value= "' . $row["pcba_sn"] . '">' . $row["pcba_sn"] . '</div>';
  } else {
    $outputPcbaList .= '<div class="item part_pcba" data-value= "' . $row["pcba_sn"] . '">' . $row["pcba_sn"] . '</div>';
  }
}


/**
 * sensor
 * table : prdt_part_sensor
 * sensor_sn
 * $outputSensorList
 * default : 공백, value : 000
 * status = 'not used' : 사용하지 않는 sensor_sn
 * flag != 4 : 삭제품목 제외
 */

$outputSensorList = '';

$sql = "SELECT sensor_sn FROM trad_part_sensor WHERE flag !=4 AND validity='Y' ORDER BY sensor_sn ";


if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

while ($row = mysqli_fetch_array($result)) {
  if ($sensor_sn ==$row["sensor_sn"] ) {
    $outputSensorList .= '<div class="item sensor_sn active selected" data-value= "' . $row["sensor_sn"] . '">' . $row["sensor_sn"] . '</div>';
  } else {
    $outputSensorList .= '<div class="item sensor_sn" data-value= "' . $row["sensor_sn"] . '">' . $row["sensor_sn"] . '</div>';
  }
}


/**
 * battery
 * table : prdt_part_battery
 * battery_sn
 * $outputBatteryList
 * default : 공백, value : 000
 * status = 'not used' : 사용하지 않는 battery_sn
 * flag != 4 : 삭제품목 제외
 */

$outputBatteryList = '';

$sql = "SELECT battery_sn FROM trad_part_battery WHERE status='not used' AND flag !=4 AND validity='Y' ORDER BY battery_sn ";


if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

while ($row = mysqli_fetch_array($result)) {
  if ($battery_sn ==$row["battery_sn"] ) {
    $outputBatteryList .= '<div class="item battery_sn active selected" data-value= "' . $row["battery_sn"] . '">' . $row["battery_sn"] . '</div>';
  } else {
    $outputBatteryList .= '<div class="item battery_sn" data-value= "' . $row["battery_sn"] . '">' . $row["battery_sn"] . '</div>';
  }
}

/**
 * case
 * table : prdt_part_case
 * case_sn
 * $outputCaseList
 * default : 공백, value : 000
 * status = 'not used' : 사용하지 않는 case_sn만
 * flag != 4 : 삭제품목 제외
 */

$outputCaseList = '';

$sql = "SELECT case_sn FROM trad_part_case WHERE flag !=4 AND validity='Y' ORDER BY case_sn ";


if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

while ($row = mysqli_fetch_array($result)) {
  if ($case_sn ==$row["case_sn"] ) {
    $outputCaseList .= '<div class="item case_sn active selected" data-value= "' . $row["case_sn"] . '">' . $row["case_sn"] . '</div>';
  } else {
    $outputCaseList .= '<div class="item case_sn" data-value= "' . $row["case_sn"] . '">' . $row["case_sn"] . '</div>';
  }
}

/**
 * 담당자
 * table : erp_user
 * name
 * $outputUserList
 * default : 공백, value : 000 
 * flag != 4 : 삭제품목 제외
 */ 

$outputUserList = '';

$sql = "SELECT name FROM erp_user WHERE flag !=4 ORDER BY name ";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

while ($row = mysqli_fetch_array($result)) {
  if ($case_sn ==$row["name"] ) {
    $outputUserList .= '<div class="item reuser active selected" data-value= "' . $row["name"] . '">' . $row["name"] . '</div>';
  } else {
    $outputUserList .= '<div class="item reuser" data-value= "' . $row["name"] . '">' . $row["name"] . '</div>';
  }
}

$conn_11->close();

/**
 * CHECKBOX is checked by the value.
 */

 $chkLeaktest_t1_p4 = "";

function setCheckBox($id, $value)
{

  if ($value == 'P') {
    $outputCheckBox = "
      <input id='$id' type='checkbox' checked>
    ";
  } else {
    $outputCheckBox = "
      <input id='$id' type='checkbox'>
    ";
  }
  return $outputCheckBox;
}

$chkLeaktest_t1_p4  = setCheckBox('leaktest_t1_p4', $leaktest_t1_p4);
$chkLeaktest_t1_p5  = setCheckBox('leaktest_t1_p5', $leaktest_t1_p5);
$chkRadiotest_t1    = setCheckBox('radiotest_t1', $radiotest_t1);
$chkMold            = setCheckBox('mold', $mold);
$chkLeaktest_t2_p4  = setCheckBox('leaktest_t2_p4', $leaktest_t2_p4);
$chkLeaktest_t2_p5  = setCheckBox('leaktest_t2_p5', $leaktest_t2_p5);
$chkRadiotest_t2    = setCheckBox('radiotest_t2', $radiotest_t2);
$status             = setCheckBox('status', $status);
$finalState         = setCheckBox('finalState', $finalState);


/**
 * 이미지 로드
 * leaktest_t1_p4, leaktest_t1_p5, radiotest_t1, $outputMold1, $outputMold2,
 * leaktest_t2_p4, leaktest_t2_p5, radiotest_t2
 */
$outputLeaktest_t1_p4  = setImageLoad($scsol_sn,$leaktest_t1_p4_imgNM,"_leaktest_t1_p4.jpg");
$outputLeaktest_t1_p5  = setImageLoad($scsol_sn,$leaktest_t1_p5_imgNM,"_leaktest_t1_p5.jpg");
$outputRadiotest_t1    = setImageLoad($scsol_sn,$radiotest_t1_imgNM,"_radiotest_t1.jpg");
$outputMold1           = setImageLoad($scsol_sn,$mold_imgNM1,"_mold1.jpg");
$outputMold2           = setImageLoad($scsol_sn,$mold_imgNM2,"_mold2.jpg");
$outputLeaktest_t2_p4  = setImageLoad($scsol_sn,$leaktest_t2_p4_imgNM,"_leaktest_t2_p4.jpg");
$outputLeaktest_t2_p5  = setImageLoad($scsol_sn,$leaktest_t2_p5_imgNM,"_leaktest_t2_p5.jpg");
$outputRadiotest_t2    = setImageLoad($scsol_sn,$radiotest_t2_imgNM,"_radiotest_t2.jpg");

function setImageLoad($scsol_sn,$imageNm,$imgNm) {
  $outputImage = "";
  if($imageNm != '') {
    $outputImage = "
      <img src='../data/$scsol_sn/$scsol_sn$imgNm'>
    ";
  }
  return $outputImage;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" type="text/javascript"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="../../../semantic/semantic.min.css">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
  <script src="../../../semantic/semantic.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>

  <title>생산관리</title>
  <link rel="shortcut icon" href="../image/construction.png">
  <script src="../js/prdt_detail.js" defer></script>
  <link rel="stylesheet" href="../css/prdt_detail.css">
</head>

<body>
  <div class="container">

    <nav id="prdt_up" class="prdt_up">
      <div class="prdt_search prdt_all_btn">
        <input type="button" class="prdt_btn prdt_clear" value="초기화">
        <input type="button" class="prdt_btn prdt_int" value="저장">
        <input type="button" class="prdt_btn prdt_del" value="삭제">
      </div>
    </nav>

    <div class="ui form">
      <div class="seven fields">

        <div class="field">
          <label>SCSOL SN</label>
          <div class="ui input div_scsol_sn">
            <input type="text" class="scsol_sn" name="scsol_sn" value="<?php echo $scsol_sn ?>" style="background-color: #bdbdbd;" readonly />
          </div>
          <div class="ui input">
            <input type="text" class="phone_no" name="phone_no" value="<?php echo $phone_no ?>" readonly />
          </div>
        </div>

        <div class="field">
          <label>PCBA</label>
          <input type="text" class="pcba_sn" name="pcba_sn" value="<?php echo $pcba_sn ?>" style="background-color: #bdbdbd;" readonly />
          <input type="hidden" class="pcba_sn_ex" name="pcba_sn_ex" value="<?php echo $pcba_sn_ex ?>" />
          <div class="ui search selection dropdown">
            <input type="hidden" value="pcba">
            <i class="dropdown icon"></i>
            <input type="text" class="search" tabindex="0">
            <div class="text pcba_sn"><?php echo $outputTextPcbaList ?></div>
            <div class="menu pcba_sn transition hidden" tabindex="-1">
              <?php echo $outputPcbaList ?>
            </div>
          </div>
        </div>

        <div class="field">
          <label>SENSOR</label>
          <input type="text" class="sensor_sn" name="sensor_sn" value="<?php echo $sensor_sn ?>" style="background-color: #bdbdbd;" readonly />
          <input type="hidden" class="sensor_sn_ex" name="sensor_sn_ex" value="<?php echo $sensor_sn_ex ?>" />
          <div class="ui search selection dropdown">
            <input type="hidden" value="sensor">
            <i class="dropdown icon"></i>
            <input type="text" class="search" tabindex="0">
            <div class="text sensor_sn"><?php echo $outputTextSensorList ?></div>
            <div class="menu sensor_sn transition hidden" tabindex="-1">
              <?php echo $outputSensorList ?>
            </div>
          </div>
        </div>

        <div class="field">
          <label>BATTERY</label>
          <input type="text" class="battery_sn" name="battery_sn" value="<?php echo $battery_sn ?>" style="background-color: #bdbdbd;" readonly />
          <input type="hidden" class="battery_sn_ex" name="battery_sn_ex" value="<?php echo $battery_sn_ex ?>" />
          <div class="ui search selection dropdown">
            <input type="hidden" value="battery">
            <i class="dropdown icon"></i>
            <input type="text" class="search" tabindex="0">
            <div class="text battery_sn"><?php echo $outputTextBatteryList ?></div>
            <div class="menu battery_sn transition hidden" tabindex="-1">
              <?php echo $outputBatteryList ?>
            </div>
          </div>
        </div>

        <div class="field">
          <label>FIRMWARE VERSION</label>
          <input type="text" class="fwVesrion_ex" name="fwVesrion_ex" value="<?php echo $fwVesrion_ex ?>" style="background-color: #bdbdbd;" readonly />          
          <div class="ui">            
            <input type="text" class="fwVersion" name="fwVersion" value="<?php echo $fwVesrion ?>" />
          </div>
        </div>

        <div class="field">
          <label>담당자</label>
          <input type="text" class="reuser" name="reuser" value="<?php echo $reuser ?>" style="background-color: #bdbdbd;" readonly />
          <input type="hidden" class="reuser_ex" name="reuser_ex" value="<?php echo $reuser_ex ?>" />
          <div class="ui search selection dropdown">
            <input type="hidden" value="case">
            <i class="dropdown icon"></i>
            <input type="text" class="search" tabindex="0">
            <div class="text reuser"><?php echo $outputTextUserList ?></div>
            <div class="menu reuser transition hidden" tabindex="-1">
              <?php echo $outputUserList ?>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="ui grid leaktest_t1_p4 leaktest_low">      
      <div class="two wide column">
        <label><h4>leaktest_t1_p4</h4></label>
      </div>
      <div class="column">
        <div class='ui checkbox'>
          <?php echo $chkLeaktest_t1_p4 ?>
          <label for='leaktest_t1_p4'>PASS</label>
        </div>
      </div>
      <div class='ui input three wide column' style ='padding:7px 0 0' >
        <label class='prdt_h' for='prdt_leaktest_t1_p4'>이미지</label>
        <input type='text' class='prdt_img prdt_leaktest_t1_p4' id='prdt_leaktest_t1_p4' value='<?php echo $leaktest_t1_p4_imgNM ?>' readonly />
      </div>
      <div class='ui two wide column' style ='padding-right:0' >
        <input type='file' class='prdt_l prdt_leaktest_t1_p4_file' id='leaktest_t1_p4_file' name='leaktest_t1_p4_file' accept='*.jpg' required />
      </div>
      <div class='column'>
        <button type='button' class='btn btn-outline-dark btn-sm prdt_leaktest_t1_p4_del image_del_1'>삭제</button>
      </div>      
    </div>
  
    <div class="ui grid leaktest_t1_p5 leaktest_low">
      <div class="two wide column">
        <label><h4>leaktest_t1_p5</h4></label>
      </div>
      <div class="column">
        <div class='ui checkbox'>
          <?php echo $chkLeaktest_t1_p5 ?>
          <label for='leaktest_t1_p5'>PASS</label>
        </div>
      </div>
      <div class='ui input three wide column' style ='padding:7px 0 0' >
        <label class='prdt_h' for='prdt_leaktest_t1_p5'>이미지</label>
        <input type='text' class='prdt_img prdt_leaktest_t1_p5' id='prdt_leaktest_t1_p5' value='<?php echo $leaktest_t1_p5_imgNM ?>' readonly />
      </div>
      <div class='two wide column' style ='padding-right:0' > 
        <input type='file' class='prdt_l prdt_leaktest_t1_p5_file' id='leaktest_t1_p5_file' name='leaktest_t1_p5_file' accept='*.jpg' required />
      </div>
      <div class='column'> 
        <button type='button' class='btn btn-outline-dark btn-sm prdt_leaktest_t1_p5_del image_del_1'>삭제</button>
      </div>      
    </div>

    <div class="ui grid radiotest_t1 leaktest_low">
      <div class="two wide column">
        <label><h4>radiotest_t1</h4></label>
      </div>
      <div class="column">
        <div class='ui checkbox'>
          <?php echo $chkRadiotest_t1 ?>
          <label for='radiotest_t1'>PASS</label>
        </div>
      </div>
      <div class='ui input three wide column' style ='padding:7px 0 0' >
        <label class='prdt_h' for='prdt_radiotest_t1'>이미지</label>
        <input type='text' class='prdt_img prdt_radiotest_t1' id='prdt_radiotest_t1' value='<?php echo $radiotest_t1_imgNM ?>' readonly />
      </div>
      <div class='two wide column' style ='padding-right:0' >
        <input type='file' class='prdt_l prdt_radiotest_t1_file' id='radiotest_t1_file' name='radiotest_t1_file' accept='*.jpg' required />
      </div>
      <div class='column'> 
        <button type='button' class='btn btn-outline-dark btn-sm prdt_radiotest_t1_del image_del_1'>삭제</button>
      </div>      
    </div>

    <div class="ui grid img_t1 leaktest_low">
      <table>
        <tr>
          <td class="prdt_test_img">
            <div class="colum colum_img" id='image_container_leaktest_t1_p4'>
              <?php echo $outputLeaktest_t1_p4 ?>
            </div>
          </td>          
          <td class="prdt_test_img">
            <div class="colum colum_img" id='image_container_leaktest_t1_p5'>
              <?php echo $outputLeaktest_t1_p5 ?>
            </div>
          </td>          
          <td class="prdt_test_img">
            <div class="colum colum_img" id='image_container_radiotest_t1'>
              <?php echo $outputRadiotest_t1 ?>
            </div>
          </td>
        </tr>
      </table>
    </div>

    <div class="ui grid mold leaktest_low">
      <div class="two wide column">
        <label><h4>mold</h4></label>
      </div>
      <div class="column">
        <div class='ui checkbox'>
          <?php echo $chkMold ?>
          <label for='mold'>PASS</label>
        </div>
      </div>
      <div class='ui input three wide column' style ='padding:7px 0 0' >
        <label class='prdt_h' for='prdt_mold'>이미지1</label>
        <input type='text' class='prdt_img prdt_mold1' id='prdt_mold1' value='<?php echo $mold_imgNM1 ?>' readonly />
      </div>
      <div class='two wide column' style ='padding-right:0' > 
        <input type='file' class='prdt_l prdt_mold_file1' id='mold_file1' name='mold_file1' accept='*.jpg' required />
      </div>
      <div class='column'> 
        <button type='button' class='btn btn-outline-dark btn-sm prdt_mold_del1 image_del1'>삭제</button>
      </div>
      <div class='ui input three wide column' style ='padding:7px 0 0' >
        <label class='prdt_h' for='prdt_mold'>이미지2</label>
        <input type='text' class='prdt_img prdt_mold2' id='prdt_mold2' value='<?php echo $mold_imgNM2 ?>' readonly />
      </div>
      <div class='two wide column' style ='padding-right:0' > 
        <input type='file' class='prdt_l prdt_mold_file2' id='mold_file2' name='mold_file2' accept='*.jpg' required />
      </div>
      <div class='column'> 
        <button type='button' class='btn btn-outline-dark btn-sm prdt_mold_del2 image_del2'>삭제</button>
      </div>          
    </div>

    <div class="ui grid img_t2 leaktest_low">
      <table>
        <tr>
          <td class="prdt_test_img">
            <div class="colum colum_img1" id='image_container_mold1'>
              <?php echo $outputMold1?>
            </div>
          </td>          
          <td class="prdt_test_img">
            <div class="colum colum_img2" id='image_container_mold2'>
              <?php echo $outputMold2?>
            </div>
          </td>
        </tr>
      </table>
    </div>

    <div class="ui grid leaktest_t2_p4 leaktest_low">
      <div class="two wide column">
        <label><h4>leaktest_t2_p4</h4></label>
      </div>
      <div class="column">
        <div class='ui checkbox'>
          <?php echo $chkLeaktest_t2_p4 ?>
          <label for='leaktest_t2_p4'>PASS</label>
        </div>
      </div>
      <div class='ui input three wide column' style ='padding:7px 0 0' >
        <label class='prdt_h' for='prdt_leaktest_t2_p4'>이미지</label>
        <input type='text' class='prdt_img prdt_leaktest_t2_p4' id='prdt_leaktest_t2_p4' value='<?php echo $leaktest_t2_p4_imgNM ?>' readonly />
      </div>
      <div class='two wide column' style ='padding-right:0' >  
        <input type='file' class='prdt_l prdt_leaktest_t2_p4_file' id='leaktest_t2_p4_file' name='leaktest_t2_p4_file' accept='*.jpg' required />
      </div>
      <div class='column'>   
        <button type='button' class='btn btn-outline-dark btn-sm prdt_leaktest_t2_p4_del image_del_1'>삭제</button>
      </div>
    </div>

    <div class="ui grid leaktest_t2_p5 leaktest_low">
      <div class="two wide column">
        <label><h4>leaktest_t2_p5</h4></label>
      </div>
      <div class="column">
        <div class='ui checkbox'>
          <?php echo $chkLeaktest_t2_p5 ?>
          <label for='leaktest_t2_p5'>PASS</label>
        </div>
      </div>
      <div class='ui input three wide column' style ='padding:7px 0 0' >
        <label class='prdt_h' for='prdt_leaktest_t2_p5'>이미지</label>
        <input type='text' class='prdt_img prdt_leaktest_t2_p5' id='prdt_leaktest_t2_p5' value='<?php echo $leaktest_t2_p5_imgNM ?>' readonly />
      </div>
      <div class='two wide column' style ='padding-right:0' >  
        <input type='file' class='prdt_l prdt_leaktest_t2_p5_file' id='leaktest_t2_p5_file' name='leaktest_t2_p5_file' accept='*.jpg' required />
      </div>
      <div class='column'>  
        <button type='button' class='btn btn-outline-dark btn-sm prdt_leaktest_t2_p5_del image_del_1'>삭제</button>
      </div>      
    </div>

    <div class="ui grid radiotest_t2 leaktest_low">
      <div class="two wide column">
        <label><h4>radiotest_t2</h4></label>
      </div>
      <div class="column">
        <div class='ui checkbox'>
          <?php echo $chkRadiotest_t2 ?>
          <label for='radiotest_t2'>PASS</label>
        </div>
      </div>
      <div class='ui input three wide column' style ='padding:7px 0 0' >
        <label class='prdt_h' for='prdt_radiotest_t2'>이미지</label>
        <input type='text' class='prdt_img prdt_radiotest_t2' id='prdt_radiotest_t2' value='<?php echo $radiotest_t2_imgNM ?>' readonly />
      </div>
      <div class='two wide column' style ='padding-right:0' >
        <input type='file' class='prdt_l prdt_radiotest_t2_file' id='radiotest_t2_file' name='radiotest_t2_file' accept='*.jpg' required />
      </div>
      <div class='column'>  
        <button type='button' class='btn btn-outline-dark btn-sm prdt_radiotest_t2_del image_del_1'>삭제</button>
      </div>
    </div>   
    <div class="ui grid img_t3 leaktest_low">
      <table>
        <tr>
          <td class="prdt_test_img">
            <div class="colum colum_img" id='image_container_leaktest_t2_p4'>
              <?php echo $outputLeaktest_t2_p4 ?>
            </div>
          </td>          
          <td class="prdt_test_img">
            <div class="colum colum_img" id='image_container_leaktest_t2_p5'>
              <?php echo $outputLeaktest_t2_p5 ?>
            </div>
          </td>          
          <td class="prdt_test_img">
            <div class="colum colum_img" id='image_container_radiotest_t2'>
              <?php echo $outputRadiotest_t2 ?>
            </div>
          </td>
        </tr>
      </table>
    </div>

    <div class="ui form grid">
      <div class="column">
        <label><h4>comment1</h4></label>
      </div>
      <div class="five wide column">
        <input type="text" name="comment1" id="comment1" value='<?php echo $comment1 ?>'>
      </div>
      <div class="column">
        <label><h4>comment2</h4></label>
      </div>
      <div class="five wide column">
        <input type="text" name="comment2" id="comment2" value='<?php echo $comment2 ?>'>
      </div>
    </div>
    <div class="ui form grid">
      <div class="column">
        <label><h4>comment3</h4></label>
      </div>
      <div class="five wide column">
        <input type="text" name="comment3" id="comment3" value='<?php echo $comment3 ?>'>
      </div>
      <div class="column">
        <label><h4>etc</h4></label>
      </div>
      <div class="five wide column">
        <input type="text" name="etc" id="etc" value='<?php echo $etc ?>'>
      </div>
    </div>    
    
    <div class="ui mini form grid finalState">
      <div class="column">
        <label for='finalState'><h4>최종</h4></label>
      </div>
      <div class="column">
        <div class='ui checkbox'>
          <?php echo $finalState ?>
          <label for='finalState'>COMPLETED</label>
        </div>
      </div>      
    </div>
    
    <!-- <div class="ui grid indicating progress"id="progress">
      <div class="bar">
        <div class="progress"></div>
      </div>
      <div class="label">공정 진행</div>
    </div>    
    <div class="gap"></div> -->

  </div>
</body>

</html>

