<script src="../js/pcba_modify.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>

<?php

/**
 * 선택된 PCBA 수정을 위한 화면
 * 
 */
$pcba_sn = trim($_POST["pcba_sn"]);
//echo("pcba_sn : $pcba_sn");

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * 선택된 PCBA 정보 가져오기
 * 
 */

$sql  = "SELECT * FROM trad_part_pcba WHERE flag != 4 AND pcba_sn = '$pcba_sn' ";
// echo($sql);

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$num = mysqli_num_rows($result);
// echo("num : $num");

$result && $row = mysqli_fetch_assoc($result);

$id                   = $row['id'];
$pcba_sn              = $row['pcba_sn'];
$part_id              = $row['part_id'];
$tradDate             = $row['tradDate'];
$tradId               = $row['tradId'];
$version              = $row['version'];
$type                 = $row['type'];
$status               = $row['status'];
$validity             = $row['validity'];
$sn                   = $row['sn'];
$hostcnt              = $row['hostcnt'];
$mcucnt               = $row['mcucnt'];
$modemcnt             = $row['modemcnt'];
$battcnt              = $row['battcnt'];
$ssorcnt              = $row['ssorcnt'];
$ldo                  = $row['ldo'];
$radio                = $row['radio'];
$buz                  = $row['buz'];
$adc                  = $row['adc'];
$memory               = $row['memory'];
$issue                = $row['issue'];
$comment              = $row['comment'];
$etc                  = $row['etc'];
$img_radio            = $row['img_radio'];
$img_adc              = $row['img_adc'];
$img_radio_nm         = $row['img_radio_nm'];
$img_adc_nm           = $row['img_adc_nm'];
$user                 = $row['user'];
$reuser               = $row['reuser'];
if(!$reuser) {
  $reuser = $user;
  $reDate = $inDate;
}
// echo("id : $id, pcba_sn : $pcba_sn, part_id : $part_id, tradDate : $tradDate");
// echo("tradId : $tradId, version : $version, type : $type");
// echo("status : $status, sn : $sn, comment : $comment, etc : $etc");

/**
 * 
 * checkbox is checked with value.
 */
 
function setCheckBox($id,$value) {

  if($value=='P') {
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

$outputHostcnt  = setCheckBox('pcba_hostcnt',$hostcnt);
$outputMcucnt   = setCheckBox('pcba_mcucnt',$mcucnt);
$outputModem    = setCheckBox('pcba_modemcnt',$modemcnt);
$outputBattcnt  = setCheckBox('pcba_battcnt',$battcnt);
$outputSsorcnt  = setCheckBox('pcba_ssorcnt',$ssorcnt);
$outputLdo      = setCheckBox('pcba_ldo',$ldo);
$outputRadio    = setCheckBox('pcba_radio',$radio);
$outputBuz      = setCheckBox('pcba_buz',$buz);
$outputMemory   = setCheckBox('pcba_memory',$memory);

/**
 * 정상/불량
 * validity
 * Y/N : Default N (불량)
 */
if($validity=='Y') {
  $outputValidity = "
    <input class='form-check-input' type='radio' name='pcba_validity' class='pcba_l pcba_validity' value='Y' checked>
    <label class='form-check-label' for='pcba_validity1' style='width:40px'>정상</label>
    <input class='form-check-input' type='radio' name='pcba_validity' class='pcba_l pcba_validity' value='N'>
    <label class='form-check-label' for='pcba_validity2'>불량</label>
  ";  
} else {
  $outputValidity = "  
    <input class='form-check-input' type='radio' name='pcba_validity' class='pcba_l pcba_validity' value='Y'>
    <label class='form-check-label' for='pcba_validity1' style='width:40px'>정상</label>
    <input class='form-check-input' type='radio' name='pcba_validity' class='pcba_l pcba_validity' value='N' checked>
    <label class='form-check-label' for='pcba_validity2'>불량</label>
";
}

/**
 * 이미지 로드
 * img_radio
 */
$path_image       = substr($pcba_sn,-11,6)."/".substr($pcba_sn,-4);

$outputImg_radio  = setImageLoad($path_image,$img_radio);
$outputImg_adc    = setImageLoad($path_image,$img_adc);

function setImageLoad($path_image,$imageNm) {
  $outputImage = "";
  if($imageNm != '') {
    $outputImage  = "
      <img src='../data/$path_image/$imageNm'>
    ";
  }
  return $outputImage;
}

// 담당자 field
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_user.php");

$response = "
  <table class='pcba_mdy'>
    <tr>
      <td>
        <table>
          <tr hidden>
            <th><label class='pcba_h' for='id'>id</label></th>
            <td><input type='text' class='pcba_l pcba_id' value='$id' readonly/></td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='pcba_sn'>PBCA_SN</label></th>
            <td><input type='text' class='pcba_l pcba_sn' value='$pcba_sn' readonly></td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='tradDate'>입고일자</label></th>
            <td><input type='date' class='pcba_l pcba_tradDate' value='$tradDate' readonly></td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='tradId'>입고번호</label></th>
            <td><input type='text' class='pcba_l pcba_tradId' value='$tradId' readonly></td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='version'>Version</label></th>
            <td><input type='text' class='pcba_l pcba_version' value='$version' readonly></td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='type'>TYPE</label></th>
            <td><input type='text' class='pcba_l pcba_type' value='$type' readonly></td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='status'>상태</label></th>
            <td><input type='text' class='pcba_l pcba_status' value = '$status' readonly/></td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='sn'>SCSOL S/N</label></th>
            <td><input type='text' class='pcba_l pcba_scsolsn' value='$sn' readonly/></td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='adc'>ADC</label></th>
            <td><input type='number' class='pcba_l pcba_adc' value='$adc'></td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='issue'>ISSUE</label></th>
            <td><input type='text' class='pcba_l pcba_issue' value='$issue'></td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='comment'>Firmware Version</label></th>
            <td><input type='text' class='pcba_l pcba_comment' value='$comment'></td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='etc'>ETC</label></th>
            <td><input type='text' class='pcba_l pcba_etc' value='$etc'></td>
          </tr>
        </table>
      </td>
      <td style='width: 20px;'></td>
      <td>
        <table>
          <tr>
            <th><label class='pcba_h' for='hostcnt'>호스트 커넥터</label></th>
            <td>
              <div class='ui checkbox'>
                $outputHostcnt<label for='pcba_hostcnt' class='pcba_hostcnt'>PASS</label>
              </div>
            </td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='hostcnt'>MCU 커넥터</label></th>
            <td>
              <div class='ui checkbox'>
                $outputMcucnt<label for='pcba_mcucnt'>PASS</label>
              </div>
            </td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='hostcnt'>모뎀 커넥터</label></th>
            <td>
              <div class='ui checkbox'>
                $outputModem<label for='pcba_modemcnt'>PASS</label>
              </div>
            </td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='battcnt'>배터리 커넥터</label></th>
            <td>
              <div class='ui checkbox'>
                $outputBattcnt<label for='pcba_battcnt'>PASS</label>
              </div>
            </td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='ssorcnt'>센서 커넥터</label></th>
            <td>
              <div class='ui checkbox'>
                $outputSsorcnt<label for='pcba_ssorcnt'>PASS</label>
              </div>
            </td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='ldo'>LDO</label></th>
            <td>
              <div class='ui checkbox'>
                $outputLdo<label for='pcba_ldo'>PASS</label>
              </div>
            </td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='radio'>라디오</label></th>
            <td>
              <div class='ui checkbox'>
                $outputRadio<label for='pcba_radio'>PASS</label>
              </div>
            </td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='buz'>부저</label></th>
            <td>
              <div class='ui checkbox'>$outputBuz<label for='pcba_buz'>PASS</label>
              </div>
            </td>
          </tr>
          <tr>
            <th><label class='pcba_h' for='memory'>메모리</label></th>
            <td>
              <div class='ui checkbox'>$outputMemory<label for='pcba_memory'>PASS</label>
              </div>
            </td>
          </tr>
          <tr>
          <th><label class='pcba_h' for='validity'>정상</label></th>      
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
  <div>        
    <label class='pcba_h' for='pcba_sn'>RADIO 이미지</label>        
    <input type='text' class='pcba_l pcba_img_radio' id='pcba_img_radio' value='$img_radio_nm' readonly/>
  </div>
  <div class='modal_list_img'>    
    <div class='modal_list_img_align'>
      <div>        
        <label class='pcba_h' for='pcba_sn'></label>        
        <input type='file' class='pcba_l pcba_img_radio_file' id='img_radio_file' name='img_radio_file' accept='*.jpg' required/>     
      </div>
      <div>
        <button type='button' class='btn btn-outline-dark btn-sm pcba_img_radio_del'>삭제</button>
      </div>      
    </div>    
    <div id='image_container_radio'>      
      $outputImg_radio
    </div>
  </div>
  <div>     
    <label class='pcba_h' for='pcba_sn'>ADC 이미지</label>        
    <input type='text' class='pcba_l pcba_img_adc' id='pcba_img_adc' value='$img_adc_nm' readonly/>
  </div>
  <div class='modal_list_img'>  
    <div class='modal_list_img_align'>
      <div>     
        <label class='pcba_h' for='pcba_sn'></label>        
        <input type='file' class='pcba_l pcba_img_adc_file' id='img_adc_file' name='img_adc_file' accept='*.jpg' required/>     
      </div>
      <div>        
        <button type='button' class='btn btn-outline-dark btn-sm pcba_img_adc_del'>삭제</button>
      </div>
    </div>    
    <div id='image_container_adc'>      
      $outputImg_adc
    </div>    
  </div>  
";

echo $response;
exit;

?>
