<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");
include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/sensor/temporary/";

$filename   = $_FILES["sensor_readfile"]["name"];
//echo ("filename : $filename");

$arr_file = explode('.', $filename);
$extension = end($arr_file);


if ('xlsx' == $extension) {
  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
} else {
  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
}

$uploadfile = $uploaddir . $filename;
//echo ("uploadfile : $uploadfile");

$inputFileName = $_FILES["sensor_readfile"]["tmp_name"];

if (move_uploaded_file($inputFileName, $uploadfile)) {

  if (file_exists($uploadfile)) {

    $spreadsheet = $reader->load($uploadfile);
    $sheetData = $spreadsheet->getActiveSheet()->toArray();
    $countAllData = count($sheetData);
    $no = 0;
    if (!empty($sheetData)) {
      $numSuccessed   = 0;
      $numDuplicated  = 0;
      $html           = "";
      $htmlDuplicated = "";

      for ($i = 3; $i < $countAllData; $i++) {
        $sensorNm = trim($sheetData[$i][1]);
        if ($sensorNm == "" || $sensorNm !="SEN") {
          echo("샘플 양식을 참고하여 업로드 해주세요.");
          return;
        }
        $maker = trim($sheetData[$i][2]);
        if ($maker == "" ) {
          echo("MAKER를 입력해주세요");
          return;
        }
        $version = trim($sheetData[$i][3]);
        if ($version == "" ) {
          echo("VERSION을 입력해주세요");
          return;
        }
        if ($sheetData[$i][4] == "" ) {
          echo("입고일자를 입력해주세요");
          return;
        }
        $tradDate       = date('Y-m-d', strtotime($sheetData[$i][4]));
        $tradData_sn    = date('ymd', strtotime($sheetData[$i][4]));        
        $tradId         = trim($sheetData[$i][5]);
        if ($tradId == "" ) {
          echo("입고번호를 입력해주세요");
          return;
        }
        $user           = trim($sheetData[$i][6]);
        if($user=="" || $user=="admin") {
          echo($user." 담당자를 입력하세요.");
          return;
        }
        $status         = "not used";
        $validity       ="N";
        $sensor_sn = "SEN-".$maker."-".$version."-".$tradData_sn."-".sprintf('%04d',$tradId);
        $no++;

      /*  $sn                     = trim($sheetData[$i][5]);
        $hz_mix_fh1             = trim($sheetData[$i][6]);
        $hz_mix_fh2             = trim($sheetData[$i][7]);
        $hz_mix_fh3             = trim($sheetData[$i][8]);
        $hz_mix_fhAvg           = ($hz_mix_fh1 + $hz_mix_fh2 + $hz_mix_fh3) / 3;
        $hz_mix_sh1             = trim($sheetData[$i][9]);
        $hz_mix_sh2             = trim($sheetData[$i][10]);
        $hz_mix_sh3             = trim($sheetData[$i][11]);
        $hz_mix_shAvg           = ($hz_mix_sh1 + $hz_mix_sh2 + $hz_mix_sh3) / 3;
        $hz_mix_eh1             = trim($sheetData[$i][12]);
        $hz_mix_eh2             = trim($sheetData[$i][13]);
        $hz_mix_eh3             = trim($sheetData[$i][14]);
        $hz_mix_ehAvg           = ($hz_mix_eh1 + $hz_mix_eh2 + $hz_mix_eh3) / 3;
        $hz_mix_tt1             = trim($sheetData[$i][15]);
        $hz_mix_tt2             = trim($sheetData[$i][16]);
        $hz_mix_tt3             = trim($sheetData[$i][17]);
        $hz_mix_ttAvg           = ($hz_mix_tt1 + $hz_mix_tt2 + $hz_mix_tt3) / 3;
        $hz_mix_tw1             = trim($sheetData[$i][18]);
        $hz_mix_tw2             = trim($sheetData[$i][19]);
        $hz_mix_tw3             = trim($sheetData[$i][20]);
        $hz_mix_twAvg           = ($hz_mix_tw1 + $hz_mix_tw2 + $hz_mix_tw3) / 3;
        $hz_fh1                 = trim($sheetData[$i][21]);
        $hz_fh2                 = trim($sheetData[$i][22]);
        $hz_fh3                 = trim($sheetData[$i][23]);
        $hz_fhAvg               = ($hz_fh1 + $hz_fh2 + $hz_fh3) / 3;
        $hz_sh1                 = trim($sheetData[$i][24]);
        $hz_sh2                 = trim($sheetData[$i][25]);
        $hz_sh3                 = trim($sheetData[$i][26]);
        $hz_shAvg               = ($hz_sh1 + $hz_sh2 + $hz_sh3) / 3;
        $hz_eh1                 = trim($sheetData[$i][27]);
        $hz_eh2                 = trim($sheetData[$i][28]);
        $hz_eh3                 = trim($sheetData[$i][29]);
        $hz_ehAvg               = ($hz_eh1 + $hz_eh2 + $hz_eh3) / 3;
        $hz_tt1                 = trim($sheetData[$i][30]);
        $hz_tt2                 = trim($sheetData[$i][31]);
        $hz_tt3                 = trim($sheetData[$i][32]);
        $hz_ttAvg               = ($hz_tt1 + $hz_tt2 + $hz_tt3) / 3;
        $hz_tw1                 = trim($sheetData[$i][33]);
        $hz_tw2                 = trim($sheetData[$i][34]);
        $hz_tw3                 = trim($sheetData[$i][35]);
        $hz_twAvg               = ($hz_tw1 + $hz_tw2 + $hz_tw3) / 3;
        $conclusion             = trim($sheetData[$i][36]);
        $issue                  = trim($sheetData[$i][37]);        
      */
        

        $sql = "Select * FROM trad_part_sensor WHERE sensor_sn = '$sensor_sn'";
        if (!($result = mysqli_query($conn_11, $sql))) {
          echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
        }
        $rowsDuplicated = mysqli_num_rows($result);


        if ($rowsDuplicated < 1) {
          $numSuccessed++;
          $sql  = "INSERT INTO trad_part_sensor( ";
          $sql .= "sensor_sn, part_id, tradDate, tradId, status, validity, version, ";
          $sql .= "maker, user, inDate) ";
          $sql .= "values('$sensor_sn', 'SC-P-E-0001-SEN', '$tradDate', '$tradId', '$status', '$validity', '$version', ";
          $sql .= "'$maker', '$user',now())";

          if (!($result = mysqli_query($conn_11, $sql))) {
            echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
          }

          // $sql  = "INSERT INTO trad_part_sensor_hzmix( ";
          // $sql .= "sensor_sn, ";
          // $sql .= "hz_mix_fh1, hz_mix_fh2, hz_mix_fh3, hz_mix_fhAvg, hz_mix_sh1, hz_mix_sh2, hz_mix_sh3, hz_mix_shAvg, ";
          // $sql .= "hz_mix_eh1, hz_mix_eh2, hz_mix_eh3, hz_mix_ehAvg, hz_mix_tt1, hz_mix_tt2, hz_mix_tt3, hz_mix_ttAvg, ";
          // $sql .= "hz_mix_tw1, hz_mix_tw2, hz_mix_tw3, hz_mix_twAvg, inDate) ";

          // $sql .= "values('$sensor_sn', ";
          // $sql .= "'$hz_mix_fh1', '$hz_mix_fh2', '$hz_mix_fh3', '$hz_mix_fhAvg', '$hz_mix_sh1', '$hz_mix_sh2', '$hz_mix_sh3', '$hz_mix_shAvg', ";
          // $sql .= "'$hz_mix_eh1', '$hz_mix_eh2', '$hz_mix_eh3', '$hz_mix_ehAvg', '$hz_mix_tt1', '$hz_mix_tt2', '$hz_mix_tt3', '$hz_mix_ttAvg', ";
          // $sql .= "'$hz_mix_tw1', '$hz_mix_tw2', '$hz_mix_tw3', '$hz_mix_twAvg', now())";

          // if (!($result = mysqli_query($conn_11, $sql))) {
          //   echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
          // }

          // $sql  = "INSERT INTO trad_part_sensor_hz( ";
          // $sql .= "sensor_sn, hz_fh1, hz_fh2, hz_fh3, hz_fhAvg, ";
          // $sql .= "hz_sh1, hz_sh2, hz_sh3, hz_shAvg, hz_eh1, hz_eh2, hz_eh3, hz_ehAvg, hz_tt1, hz_tt2, hz_tt3, hz_ttAvg, ";
          // $sql .= "hz_tw1, hz_tw2, hz_tw3, hz_twAvg, inDate) ";

          // $sql .= "values('$sensor_sn', '$hz_fh1', '$hz_fh2', '$hz_fh3', '$hz_fhAvg', ";
          // $sql .= "'$hz_sh1', '$hz_sh2', '$hz_sh3', '$hz_shAvg', '$hz_eh1', '$hz_eh2', '$hz_eh3', '$hz_ehAvg', ";
          // $sql .= "'$hz_tt1', '$hz_tt2', '$hz_tt3', '$hz_ttAvg', ";
          // $sql .= "'$hz_tw1', '$hz_tw2', '$hz_tw3', '$hz_twAvg', now())";

          
          
          $html .= "<tr>";
          $html .= "<td class='i0'>$no</td>";
          $html .= "<td class='i1'>$sensor_sn</td>";
          $html .= "<td class='i2'>$tradDate</td>";
          $html .= "<td class='i3'>$tradId</td>";
          $html .= "<td class='i4'>$status</td>";
          $html .= "<td class='i5'>$validity</td>";          
          $html .= "<td class='i6'>&nbsp</td>";
          $html .= "<td class='i7'>&nbsp</td>";
          $html .= "<td class='i8'>&nbsp</td>";
          $html .= "<td class='i9'>&nbsp</td>";
          $html .= "<td class='i10'>&nbsp</td>";
          $html .= "<td class='i11'>&nbsp</td>";
          $html .= "<td class='i12'>&nbsp</td>";
          $html .= "<td class='i13'>&nbsp</td>";
          $html .= "<td class='i14'>&nbsp</td>";
          $html .= "<td class='i15'>&nbsp</td>";
          $html .= "<td class='i16'>&nbsp</td>";
          $html .= "<td class='i17'>&nbsp</td>";
          $html .= "<td class='i18'>&nbsp</td>";
          $html .= "<td class='i19'>&nbsp</td>";
          $html .= "<td class='i20'>&nbsp</td>";
          $html .= "<td class='i21'>&nbsp</td>";
          $html .= "<td class='i22'>&nbsp</td>";
          $html .= "<td class='i23'>&nbsp</td>";
          $html .= "<td class='i24'>&nbsp</td>";
          $html .= "<td class='i25'>&nbsp</td>";
          $html .= "<td class='i26'>&nbsp</td>";
          $html .= "<td class='i27'>&nbsp</td>";
          $html .= "<td class='i28'>&nbsp</td>";
          $html .= "<td class='i29'>&nbsp</td>";
          $html .= "<td class='i30'>&nbsp</td>";
          $html .= "<td class='i31'>&nbsp</td>";
          $html .= "<td class='i32'>&nbsp</td>";
          $html .= "<td class='i33'>&nbsp</td>";
          $html .= "<td class='i34'>&nbsp</td>";
          $html .= "<td class='i35'>&nbsp</td>";
          $html .= "<td class='i36'>&nbsp</td>";
          $html .= "<td class='i37'>&nbsp</td>";
          $html .= "<td class='i38'>&nbsp</td>";
          $html .= "<td class='i39'>&nbsp</td>";
          $html .= "<td class='i40'>&nbsp</td>";
          $html .= "<td class='i41'>$user</td>";
          $html .= "</tr>";
        } else {

          $numDuplicated++;
          $htmlDuplicated .= "<tr>";
          $htmlDuplicated .= "<td class='i0'>$no</td>";
          $htmlDuplicated .= "<td class='i1'>$sensor_sn</td>";
          $htmlDuplicated .= "<td class='i2'>$tradDate</td>";
          $htmlDuplicated .= "<td class='i3'>$tradId</td>";
          $htmlDuplicated .= "<td class='i4'>$status</td>";
          $htmlDuplicated .= "<td class='i5'>$validity</td>";         
          $htmlDuplicated .= "<td class='i6'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i7'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i8'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i9'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i10'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i11'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i12'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i13'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i14'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i15'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i16'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i17'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i18'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i19'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i20'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i21'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i22'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i23'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i24'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i25'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i26'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i27'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i28'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i29'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i30'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i31'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i32'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i33'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i34'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i35'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i36'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i37'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i38'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i39'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i40'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i41'>$user</td>";
          $htmlDuplicated .= "</tr>";
        }
      }
    }
  }
}

unlink($uploadfile);  // 파일삭제

$countAllData=$countAllData-3;// 제목줄 제외
$outUploadReport = "<tr><td colspan='15'>총 $countAllData 건 / 성공 $numSuccessed 건 / 중복 $numDuplicated 건<td></tr>";
$outUploadReport .= $htmlDuplicated;
$outUploadReport .= $html;
echo $outUploadReport;
