<script src="../js/sensor_modify.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>

<?php

/**
 * 선택된 센서 수정을 위한 화면
 * 
 */
$sensor_sn = trim($_POST["sensor_sn"]);
//echo("sensor_sn : $sensor_sn");

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * 선택된 센서 정보 가져오기
 * 
 */

$sql  = "SELECT * FROM trad_part_sensor WHERE flag != 4 and sensor_sn = '$sensor_sn' ";
//echo($sql);

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$num = mysqli_num_rows($result);
//echo("num : $num");

$result && $row = mysqli_fetch_assoc($result);

$id                     = $row['id'];
$sensor_sn              = $row['sensor_sn'];
$part_id                = $row['part_id'];
$tradDate               = $row['tradDate'];
$tradId                 = $row['tradId'];
$status                 = $row['status'];
$validity               = $row['validity'];
$sn                     = $row['sn'];
$hz_mix_fh1             = sprintf('%0.1f', $row['hz_mix_fh1']);
$hz_mix_fh1_no          = $row['hz_mix_fh1_no'];
$hz_mix_fh2             = sprintf('%0.1f', $row['hz_mix_fh2']);
$hz_mix_fh2_no          = $row['hz_mix_fh2_no'];
$hz_mix_fh3             = sprintf('%0.1f', $row['hz_mix_fh3']);
$hz_mix_fh3_no          = $row['hz_mix_fh3_no'];
$hz_mix_fhAvg           = sprintf('%0.1f', $row['hz_mix_fhAvg']);
$hz_mix_sh1             = sprintf('%0.1f', $row['hz_mix_sh1']);
$hz_mix_sh1_no          = $row['hz_mix_sh1_no'];
$hz_mix_sh2             = sprintf('%0.1f', $row['hz_mix_sh2']);
$hz_mix_sh2_no          = $row['hz_mix_sh2_no'];
$hz_mix_sh3             = sprintf('%0.1f', $row['hz_mix_sh3']);
$hz_mix_sh3_no          = $row['hz_mix_sh3_no'];
$hz_mix_shAvg           = sprintf('%0.1f', $row['hz_mix_shAvg']);
$hz_mix_eh1             = sprintf('%0.1f', $row['hz_mix_eh1']);
$hz_mix_eh1_no          = $row['hz_mix_eh1_no'];
$hz_mix_eh2             = sprintf('%0.1f', $row['hz_mix_eh2']);
$hz_mix_eh2_no          = $row['hz_mix_eh2_no'];
$hz_mix_eh3             = sprintf('%0.1f', $row['hz_mix_eh3']);
$hz_mix_eh3_no          = $row['hz_mix_eh3_no'];
$hz_mix_ehAvg           = sprintf('%0.1f', $row['hz_mix_ehAvg']);
$hz_mix_tt1             = sprintf('%0.1f', $row['hz_mix_tt1']);
$hz_mix_tt1_no          = $row['hz_mix_tt1_no'];
$hz_mix_tt2             = sprintf('%0.1f', $row['hz_mix_tt2']);
$hz_mix_tt2_no          = $row['hz_mix_tt2_no'];
$hz_mix_tt3             = sprintf('%0.1f', $row['hz_mix_tt3']);
$hz_mix_tt3_no          = $row['hz_mix_tt3_no'];
$hz_mix_ttAvg           = sprintf('%0.1f', $row['hz_mix_ttAvg']);
$hz_mix_tw1             = sprintf('%0.1f', $row['hz_mix_tw1']);
$hz_mix_tw1_no          = $row['hz_mix_tw1_no'];
$hz_mix_tw2             = sprintf('%0.1f', $row['hz_mix_tw2']);
$hz_mix_tw2_no          = $row['hz_mix_tw2_no'];
$hz_mix_tw3             = sprintf('%0.1f', $row['hz_mix_tw3']);
$hz_mix_tw3_no          = $row['hz_mix_tw3_no'];
$hz_mix_twAvg           = sprintf('%0.1f', $row['hz_mix_twAvg']);
$hz_fh1                 = sprintf('%0.1f', $row['hz_fh1']);
$hz_fh1_no              = $row['hz_fh1_no'];
$hz_fh2                 = sprintf('%0.1f', $row['hz_fh2']);
$hz_fh2_no              = $row['hz_fh2_no'];
$hz_fh3                 = sprintf('%0.1f', $row['hz_fh3']);
$hz_fh3_no              = $row['hz_fh3_no'];
$hz_fhAvg               = sprintf('%0.1f', $row['hz_fhAvg']);
$hz_sh1                 = sprintf('%0.1f', $row['hz_sh1']);
$hz_sh1_no              = $row['hz_sh1_no'];
$hz_sh2                 = sprintf('%0.1f', $row['hz_sh2']);
$hz_sh2_no              = $row['hz_sh2_no'];
$hz_sh3                 = sprintf('%0.1f', $row['hz_sh3']);
$hz_sh3_no              = $row['hz_sh3_no'];
$hz_shAvg               = sprintf('%0.1f', $row['hz_shAvg']);
$hz_eh1                 = sprintf('%0.1f', $row['hz_eh1']);
$hz_eh1_no              = $row['hz_eh1_no'];
$hz_eh2                 = sprintf('%0.1f', $row['hz_eh2']);
$hz_eh2_no              = $row['hz_eh2_no'];
$hz_eh3                 = sprintf('%0.1f', $row['hz_eh3']);
$hz_eh3_no              = $row['hz_eh3_no'];
$hz_ehAvg               = sprintf('%0.1f', $row['hz_ehAvg']);
$hz_tt1                 = sprintf('%0.1f', $row['hz_tt1']);
$hz_tt1_no              = $row['hz_tt1_no'];
$hz_tt2                 = sprintf('%0.1f', $row['hz_tt2']);
$hz_tt2_no              = $row['hz_tt2_no'];
$hz_tt3                 = sprintf('%0.1f', $row['hz_tt3']);
$hz_tt3_no              = $row['hz_tt3_no'];
$hz_ttAvg               = sprintf('%0.1f', $row['hz_ttAvg']);
$hz_tw1                 = sprintf('%0.1f', $row['hz_tw1']);
$hz_tw1_no              = $row['hz_tw1_no'];
$hz_tw2                 = sprintf('%0.1f', $row['hz_tw2']);
$hz_tw2_no              = $row['hz_tw2_no'];
$hz_tw3                 = sprintf('%0.1f', $row['hz_tw3']);
$hz_tw3_no              = $row['hz_tw3_no'];
$hz_twAvg               = sprintf('%0.1f', $row['hz_twAvg']);
$conclusion             = $row['conclusion'];
$issue                  = $row['issue'];
$comment                = $row['comment'];
$etc                    = $row['etc'];
$image_1                = $row['image_1'];
$image_2                = $row['image_2'];
$image_3                = $row['image_3'];
$user                   = $row['user'];
$reuser                 = $row['reuser'];
if(!$reuser) {
  $reuser = $user;
  $reDate = $inDate;
}

// echo("id : $id, sensor_sn : $sensor_sn, part_id : $part_id, tradDate : $tradDate,tradId : $tradId");
// echo("status : $status, sn : $sn, comment : $comment, etc : $etc, reuser : $reuser");

/**
 * 정상/불량
 * validity
 * Y/N : Default N (불량)
 */
if($validity=='Y') {
  $outputValidity .= "
    <input class='form-check-input' type='radio' name='sensor_validity' class='sensor_l sensor_validity' value='Y' checked>
    <label class='form-check-label' for='sensor_validity1' style='width:90px'>정상</label>
    <input class='form-check-input' type='radio' name='sensor_validity' class='sensor_l sensor_validity' value='N'>
    <label class='form-check-label' for='sensor_validity2'>불량</label>
  ";  
} else {
  $outputValidity .= "  
    <input class='form-check-input' type='radio' name='sensor_validity' class='sensor_l sensor_validity' value='Y'>
    <label class='form-check-label' for='sensor_validity1' style='width:90px'>정상</label>
    <input class='form-check-input' type='radio' name='sensor_validity' class='sensor_l sensor_validity' value='N' checked>
    <label class='form-check-label' for='sensor_validity2'>불량</label>
";
}

/**
 * 종합판정 checkbox
 */
$outputConclusion  = setCheckBox('sensor_conclusion',$conclusion); 

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

/**
 * 이미지 로드
 * image_1, image_2, image_3
 */
$path_image = substr($sensor_sn,14,6)."/".substr($sensor_sn,-4);

$outputImage_1 = setImageLoad($path_image,$image_1);
$outputImage_2 = setImageLoad($path_image,$image_2);
$outputImage_3 = setImageLoad($path_image,$image_3);

function setImageLoad($path_image,$imageNm) {
  $outputImage = "";
  if($imageNm != '') {
    $outputImage = "
      <img src='../data/$path_image/$imageNm'>
    ";
  }
  return $outputImage;
}

// 담당자 field
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_user.php");

$response = "
  <div class='modal_list'>  
    <div>
      <table class='sensor_mdy'>
        <tr hidden>
          <th><label class='sensor_h' for='id'>id</label></th>
          <td><input type='text' class='sensor_l sensor_id' value='$id' readonly/></td>
        </tr>
        <tr>
          <th><label class='sensor_h' for='sensor_sn'>SENSOR_SN</label></th>
          <td><input type='text' class='sensor_l sensor_sn' value='$sensor_sn' readonly></td>
          <th><label class='sensor_h sensor_r' for='sn'>SCSOL S/N</label></th>
          <td><input type='text' class='sensor_l sensor_scsolsn' value='$sn' readonly/></td>
        </tr>
        <tr>
          <th><label class='sensor_h' for='tradDate'>입고일자</label></th>
          <td><input type='date' class='sensor_l sensor_tradDate' value='$tradDate' readonly></td>
          <th><label class='sensor_h sensor_r' for='tradId'>입고번호</label></th>
          <td><input type='text' class='sensor_l sensor_tradId' value='$tradId' readonly></td>
        </tr>    
        <tr>
          <th><label class='sensor_h' for='status'>상태</label></th>
          <td><input type='text' class='sensor_l sensor_status' value = '$status' readonly/></td>          
          <th><label class='sensor_h sensor_r' for='validity'>정상</label></th>      
          <td>
            <div class='form-check'>
              $outputValidity
            </div>
          </td>
        </tr>    
        <tr>
          <th><label class='sensor_h' for='conclusion'>종합판정</label></th>
          <td>
            <div class='ui checkbox'>  
              $outputConclusion<label for='sensor_conclusion' class='sensor_conclusion'>PASS</label>
            </div>
          </td>
          <th><label class='sensor_h sensor_r' for='etc'>ETC</label></th>
          <td><input type='text' class='sensor_l sensor_etc' value='$etc'></td>          
        </tr>
        <tr>
          <th><label class='sensor_h' for='comment'>Comment</label></th>
          <td><input type='text' class='sensor_l sensor_comment' value='$comment'></td>
          <th><label class='sensor_h sensor_r' for='issue'>ISSUE</label></th>
          <td><input type='text' class='sensor_l sensor_issue' value='$issue'></td>
        </tr>
        <tr>$outputUser</tr>
      </table>
    </div>
    <div class='modal_list_sub'>
      <div>        
        <table class='sensor_mdy1'>
          <thead class='th_sensor'>
            <tr>
              <th class='mdy_h_sensor mdy_h_hz_mix' colspan='6'>MIX ( Hz )</th>
            </tr>
            <tr>  
              <th class='mdy_h_sensor mdy_h_no'>NO</th>
              <th class='mdy_h_sensor mdy_h_hz_mix_fh'>400</th>
              <th class='mdy_h_sensor mdy_h_hz_mix_sh'>600</th>
              <th class='mdy_h_sensor mdy_h_hz_mix_eh'>800</th>
              <th class='mdy_h_sensor mdy_h_hz_mix_tt'>1000</th>
              <th class='mdy_h_sensor mdy_h_hz_mix_tw'>1200</th>
            </tr>
          </thead>
          <tbody class='tb_sensor'>      
            <tr>  
              <td class='mdy_b_sensor b_no'>1</td>
              <td class='mdy_b_sensor b_hz_mix_fh1'><span>$hz_mix_fh1</span>/$hz_mix_fh1_no</td>
              <td class='mdy_b_sensor b_hz_mix_sh1'><span>$hz_mix_sh1</span>/$hz_mix_sh1_no</td>
              <td class='mdy_b_sensor b_hz_mix_eh1'><span>$hz_mix_eh1</span>/$hz_mix_eh1_no</td>
              <td class='mdy_b_sensor b_hz_mix_tt1'><span>$hz_mix_tt1</span>/$hz_mix_tt1_no</td>
              <td class='mdy_b_sensor b_hz_mix_tw1'><span>$hz_mix_tw1</span>/$hz_mix_tw1_no</td>
            </tr>
            <tr>  
              <td class='mdy_b_sensor b_no'>2</td>
              <td class='mdy_b_sensor b_hz_mix_fh2'><span>$hz_mix_fh2</span>/$hz_mix_fh2_no</td>
              <td class='mdy_b_sensor b_hz_mix_sh2'><span>$hz_mix_sh2</span>/$hz_mix_sh2_no</td>
              <td class='mdy_b_sensor b_hz_mix_eh2'><span>$hz_mix_eh2</span>/$hz_mix_eh2_no</td>
              <td class='mdy_b_sensor b_hz_mix_tt2'><span>$hz_mix_tt2</span>/$hz_mix_tt2_no</td>
              <td class='mdy_b_sensor b_hz_mix_tw2'><span>$hz_mix_tw2</span>/$hz_mix_tw2_no</td>
            </tr>
            <tr>  
              <td class='mdy_b_sensor b_no'>3</td>
              <td class='mdy_b_sensor b_hz_mix_fh3'><span>$hz_mix_fh3</span>/$hz_mix_fh3_no</td>
              <td class='mdy_b_sensor b_hz_mix_sh3'><span>$hz_mix_sh3</span>/$hz_mix_sh3_no</td>
              <td class='mdy_b_sensor b_hz_mix_eh3'><span>$hz_mix_eh3</span>/$hz_mix_eh3_no</td>
              <td class='mdy_b_sensor b_hz_mix_tt3'><span>$hz_mix_tt3</span>/$hz_mix_tt3_no</td>
              <td class='mdy_b_sensor b_hz_mix_tw3'><span>$hz_mix_tw3</span>/$hz_mix_tw3_no</td>
            </tr>
            <tr class='b_hz_mix_avg'>  
              <td class='mdy_b_sensor b_hz_mix_avg b_no'>AVG</td>
              <td class='mdy_b_sensor b_hz_mix_avg b_hz_mix_fhAvg'>$hz_mix_fhAvg</td>
              <td class='mdy_b_sensor b_hz_mix_avg b_hz_mix_shAvg'>$hz_mix_shAvg</td>
              <td class='mdy_b_sensor b_hz_mix_avg b_hz_mix_ehAvg'>$hz_mix_ehAvg</td>
              <td class='mdy_b_sensor b_hz_mix_avg b_hz_mix_ttAvg'>$hz_mix_ttAvg</td>
              <td class='mdy_b_sensor b_hz_mix_avg b_hz_mix_twAvg'>$hz_mix_twAvg</td>
            </tr>
          </tbody>    
        </table>
      </div>
      <div class='modal_list_sub_gap'>
      </div>
      <div>
        <table class='sensor_mdy2'>
          <thead class='th_sensor'>
            <tr>
              <th class='mdy_h_sensor mdy_h_hz_mix' colspan='6'>SINGLE ( Hz )</th>
            </tr>
            <tr>  
              <th class='mdy_h_sensor mdy_h_no'>NO</th>
              <th class='mdy_h_sensor mdy_h_hz_fh' OnClick='process(\"{$sensor_sn}\", \"400\")'>400</th>
              <th class='mdy_h_sensor mdy_h_hz_sh' OnClick='process(\"{$sensor_sn}\", \"600\")'>600</th>
              <th class='mdy_h_sensor mdy_h_hz_eh' OnClick='process(\"{$sensor_sn}\", \"800\")'>800</th>
              <th class='mdy_h_sensor mdy_h_hz_tt' OnClick='process(\"{$sensor_sn}\", \"1000\")'>1000</th>
              <th class='mdy_h_sensor mdy_h_hz_tw' OnClick='process(\"{$sensor_sn}\", \"1200\")'>1200</th>
            </tr>
          </thead>
          
          <tbody class='tb_sensor'>
            <tr>  
              <td class='mdy_b_sensor b_no'>1</td>
              <td class='mdy_b_sensor b_hz_fh1'><span>$hz_fh1</span>/$hz_fh1_no</td>
              <td class='mdy_b_sensor b_hz_sh1'><span>$hz_sh1</span>/$hz_sh1_no</td>
              <td class='mdy_b_sensor b_hz_eh1'><span>$hz_eh1</span>/$hz_eh1_no</td>
              <td class='mdy_b_sensor b_hz_tt1'><span>$hz_tt1</span>/$hz_tt1_no</td>
              <td class='mdy_b_sensor b_hz_tw1'><span>$hz_tw1</span>/$hz_tw1_no</td>
            </tr>
            <tr>  
              <td class='mdy_b_sensor b_no'>2</td>
              <td class='mdy_b_sensor b_hz_fh2'><span>$hz_fh2</span>/$hz_fh2_no</td>
              <td class='mdy_b_sensor b_hz_sh2'><span>$hz_sh2</span>/$hz_sh2_no</td>
              <td class='mdy_b_sensor b_hz_eh2'><span>$hz_eh2</span>/$hz_eh2_no</td>
              <td class='mdy_b_sensor b_hz_tt2'><span>$hz_tt2</span>/$hz_tt2_no</td>
              <td class='mdy_b_sensor b_hz_tw2'><span>$hz_tw2</span>/$hz_tw2_no</td>
            </tr>
            <tr>  
              <td class='mdy_b_sensor b_no'>3</td>
              <td class='mdy_b_sensor b_hz_fh3'><span>$hz_fh3</span>/$hz_fh3_no</td>
              <td class='mdy_b_sensor b_hz_sh3'><span>$hz_sh3</span>/$hz_sh3_no</td>
              <td class='mdy_b_sensor b_hz_eh3'><span>$hz_eh3</span>/$hz_eh3_no</td>
              <td class='mdy_b_sensor b_hz_tt3'><span>$hz_tt3</span>/$hz_tt3_no</td>
              <td class='mdy_b_sensor b_hz_tw3'><span>$hz_tw3</span>/$hz_tw3_no</td>
            </tr>
            <tr class='b_hz_avg'>  
              <td class='mdy_b_sensor b_hz_avg b_no'>AVG</td>
              <td class='mdy_b_sensor b_hz_avg b_hz_fhAvg'>$hz_fhAvg</td>
              <td class='mdy_b_sensor b_hz_avg b_hz_shAvg'>$hz_shAvg</td>
              <td class='mdy_b_sensor b_hz_avg b_hz_ehAvg'>$hz_ehAvg</td>
              <td class='mdy_b_sensor b_hz_avg b_hz_ttAvg'>$hz_ttAvg</td>
              <td class='mdy_b_sensor b_hz_avg b_hz_twAvg'>$hz_twAvg</td>
            </tr>
          </tbody>
        </table>    
      </div>
    </div>
    <div class='modal_list_img'>
      <div class='modal_list_img_align'>
        <div>
          <label class='sensor_h' for='sensor_sn'>400-mix 이미지</label>
          <input type='text' class='sensor_img sensor_image_1' id='sensor_image_1' value='$image_1' readonly />
          <input type='file' class='sensor_l sensor_image_1_file' id='image_1_file' name='image_1_file' accept='*.jpg' required/>
        </div>
        <div>
          <button type='button' class='btn btn-outline-dark btn-sm sensor_mdy_image_del image_del_1'>삭제</button>
        </div>
      </div>
      <div id='image_container_image_1'>
        $outputImage_1
      </div>    
      <div class='modal_list_img_align'>
        <div>
        <label class='sensor_h' for='sensor_sn'>600-800 이미지</label>
        <input type='text' class='sensor_img sensor_image_2' id='sensor_image_2' value='$image_2' readonly />
          <input type='file' class='sensor_l sensor_image_2_file' id='image_2_file' name='image_2_file' accept='*.jpg' required/>
        </div>
        <div>
          <button type='button' class='btn btn-outline-dark btn-sm sensor_mdy_image_del image_del_2'>삭제</button>
        </div>
      </div>
      <div id='image_container_image_2'>
        $outputImage_2
      </div>
      <div class='modal_list_img_align'>
        <div>
          <label class='sensor_h' for='sensor_sn'>1,000-1,200이미지</label>
          <input type='text' class='sensor_img sensor_image_3' id='sensor_image_3' value='$image_3' readonly />
          <input type='file' class='sensor_l sensor_image_3_file' id='image_3_file' name='image_3_file' accept='*.jpg' required/>
        </div>
        <div>
          <button type='button' class='btn btn-outline-dark btn-sm sensor_mdy_image_del image_del_3'>삭제</button>
        </div>
      </div>
      <div id='image_container_image_3'>
        $outputImage_3
      </div>
    </div>    
  </div>  
";

echo $response;
exit;

?>
