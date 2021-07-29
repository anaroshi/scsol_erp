
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$uploaddir  = $_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/batt/temporary/";
$filename   = $_FILES["batt_readfile"]["name"];
//echo ("filename : $filename\n");

$arr_file   = explode('.', $filename);
$extension  = end($arr_file);

if ('xlsx' == $extension) {
  $reader   = new PhpOffice\PhpSpreadsheet\Reader\Xlsx();
} else {
  $reader   = new PhpOffice\PhpSpreadsheet\Reader\Xls();
}

$uploadfile = $uploaddir . $filename;

//echo ("uploadfile : $uploadfile\n");

$inputFileName = $_FILES["batt_readfile"]["tmp_name"];
//echo ("inputFileName : $inputFileName\n");

if (move_uploaded_file($inputFileName, $uploadfile)) { 

  if (file_exists($uploadfile)) {
    $spreadsheet        = $reader->load($uploadfile);
    $sheetData          = $spreadsheet->getActiveSheet()->toArray();
    $countAllData       = count($sheetData);

    if (!empty($sheetData)) {
      $numSuccessed     = 0;
      $numDuplicated    = 0;
      $html             = "";
      $htmlDuplicated   = "";
      $no = 0;
      for ($i = 3; $i < $countAllData; $i++) {
        $no++;
        $batteryNm     = trim($sheetData[$i][1]);
        if ($batteryNm == "" || $batteryNm !="BAT") {
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
        $cellType       = trim($sheetData[$i][6]);
        $cellSize       = trim($sheetData[$i][7]);
        $cellCap        = trim($sheetData[$i][8]);
        $cellFactory    = trim($sheetData[$i][9]);
        $factory        = trim($sheetData[$i][10]);
        $status         = 'not-used';
        $validity       = 'N';    
        $voltage        = trim($sheetData[$i][11]); 
        $user           = trim($sheetData[$i][12]);
        if($user=="" || $user=="admin") {
          echo($user." 담당자를 입력하세요.");
          return;
        }

        $battery_sn     = "BAT-".$maker."-".$version."-".$tradData_sn."-".sprintf('%04d',$tradId);
        
        $sql = "SELECT * FROM trad_part_battery WHERE battery_sn = '$battery_sn'";
        if (!($result = mysqli_query($conn_11, $sql))) {
          echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
        }
        $rowsDuplicated = mysqli_num_rows($result);
        if ($rowsDuplicated < 1) {
          $numSuccessed++;
          $sql  = "INSERT INTO trad_part_battery( ";
          $sql .= "battery_sn, part_id, version, maker, tradDate, tradId, cellType, cellSize, cellCap, cellFactory, factory, status, validity, voltage, user, inDate) ";
          $sql .= "values('$battery_sn', 'SC-P-E-0001-BAT', '$version', '$maker', '$tradDate', '$tradId', '$cellType', '$cellSize', '$cellCap', '$cellFactory', '$factory', ";
          $sql .= "'$status', '$validity', $voltage, '$user', now())";

          if (!($result = mysqli_query($conn_11, $sql))) {
            echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
          }

          $html .= "<tr>";
          $html .= "<td class='i0'>$no</td>";
          $html .= "<td class='i1'>$battery_sn</td>";
          $html .= "<td class='i2'>$tradDate</td>";
          $html .= "<td class='i3'>$tradId</td>";
          $html .= "<td class='i4'>$cellType</td>";
          $html .= "<td class='i5'>$cellSize</td>";
          $html .= "<td class='i6'>$cellCap</td>";
          $html .= "<td class='i7'>$cellFactory</td>";
          $html .= "<td class='i8'>$factory</td>";
          $html .= "<td class='i9'>$status</td>";
          $html .= "<td class='i10'>$validity</td>";
          $html .= "<td class='i11'>&nbsp</td>";
          $html .= "<td class='i12'>$voltage</td>";
          $html .= "<td class='i13'>&nbsp</td>";
          $html .= "<td class='i14'>&nbsp</td>";
          $html .= "<td class='i15'></td>";
          $html .= "<td class='i16'>$user</td>";
          $html .= "</tr>";
        } else {
          $numDuplicated++;
          $htmlDuplicated .= "<tr>";
          $htmlDuplicated .= "<td class='i0'>$no</td>";
          $htmlDuplicated .= "<td class='i1'>$battery_sn</td>";
          $htmlDuplicated .= "<td class='i2'>$tradDate</td>";
          $htmlDuplicated .= "<td class='i3'>$tradId</td>";
          $htmlDuplicated .= "<td class='i4'>$cellType</td>";
          $htmlDuplicated .= "<td class='i5'>$cellSize</td>";
          $htmlDuplicated .= "<td class='i6'>$cellCap</td>";
          $htmlDuplicated .= "<td class='i7'>$cellFactory</td>";
          $htmlDuplicated .= "<td class='i8'>$factory</td>";
          $htmlDuplicated .= "<td class='i9'>$status</td>";
          $htmlDuplicated .= "<td class='i10'>$validity</td>";
          $htmlDuplicated .= "<td class='i11'></td>";
          $htmlDuplicated .= "<td class='i12'>$voltage</td>";
          $htmlDuplicated .= "<td class='i13'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i14'>&nbsp</td>";
          $htmlDuplicated .= "<td class='i15'></td>";
          $htmlDuplicated .= "<td class='i16'>$user</td>";
          $htmlDuplicated .= "</tr>";
        }
      }
    }
  }
}

unlink($uploadfile);  // 파일삭제
$html .= "<tr><td colspan='24' style='height: 60px;'></td></tr>";
$countAllData--;      // 제목줄 제외
$outUploadReport = "<tr><td colspan='16'>총 $countAllData 건 / 성공 $numSuccessed 건 / 중복 $numDuplicated 건<td></tr>";
$outUploadReport .= $htmlDuplicated;
$outUploadReport .= $html;
echo $outUploadReport;

?>