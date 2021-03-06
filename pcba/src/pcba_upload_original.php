<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");
include_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/pcba/temporary/";

$filename   = $_FILES["pcba_readfile"]["name"];
// echo ("filename : $filename");

$arr_file = explode('.', $filename);
$extension = end($arr_file);

if ('xlsx' == $extension) {
  if (!class_exists('\PhpOffice\PhpSpreadsheet\Reader\Xlsx')) include_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Reader/Xlsx.php';
  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
} else {
  if (!class_exists('\PhpOffice\PhpSpreadsheet\Reader\Xls')) include_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Reader/Xls.php';
  $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
}

$uploadfile = $uploaddir . $filename;


$inputFileName = $_FILES["pcba_readfile"]["tmp_name"];

if (move_uploaded_file($inputFileName, $uploadfile)) {

  if (file_exists($uploadfile)) {

    $spreadsheet = $reader->load($uploadfile);
    $sheetData = $spreadsheet->getActiveSheet()->toArray();
    $countAllData = count($sheetData);

    if (!empty($sheetData)) {
      $numSuccessed     = 0;
      $numDuplicated    = 0;
      $html             = "";
      $htmlDuplicated   = "";
      $k=1;
      for ($i = 3; $i < $countAllData; $i++) {
        $pcba_sn        = trim($sheetData[$i][1]);
        if ($pcba_sn == "") break;
        $tradDate       = date('Y-m-d', strtotime($sheetData[$i][2]));
        $tradId         = trim($sheetData[$i][3]);
        $version        = trim($sheetData[$i][4]);
        $type           = trim($sheetData[$i][5]);
        $user           = trim($sheetData[$i][6]);
        $status         = "not used";
        
        $sql = "Select * FROM trad_part_pcba WHERE pcba_sn = '$pcba_sn'";
        if (!($result = mysqli_query($conn_11, $sql))) {
          echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
        }
        $rowsDuplicated = mysqli_num_rows($result);

        if ($rowsDuplicated < 1) {
          $numSuccessed++;
          $sql  = "INSERT INTO trad_part_pcba( ";
          $sql .= "pcba_sn, part_id, tradDate, tradId, version, type, status, ";
          $sql .= "hostcnt, mcucnt, modemcnt, battcnt, ssorcnt, ldo, radio, buz, adc, memory, issue, inDate, user) ";
          $sql .= "values('$pcba_sn', 'SC-P-E-0003-PCB', '$tradDate', '$tradId', '$version', '$type', '$status', ";
          $sql .= "'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 0, 'P', 0, ";
          $sql .= " now(), '$user')";          

          if (!($result = mysqli_query($conn_11, $sql))) {
            echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
          }

          $html .= "<tr>";
          $html .= "<td class='i0'>$k</td>";
          $html .= "<td class='i1'>$pcba_sn</td>";
          $html .= "<td class='i2'>$tradDate</td>";
          $html .= "<td class='i3'>$tradId</td>";
          $html .= "<td class='i4'>$version</td>";
          $html .= "<td class='i5'>$type</td>";
          $html .= "<td class='i6'>$status</td>";
          $html .= "<td class='i7'>N</td>";
          $html .= "<td class='i8'></td>";
          $html .= "<td class='i9'>P</td>";
          $html .= "<td class='i10'>P</td>";
          $html .= "<td class='i11'>P</td>";
          $html .= "<td class='i12'>P</td>";
          $html .= "<td class='i13'>P</td>";
          $html .= "<td class='i14'>P</td>";
          $html .= "<td class='i15'>P</td>";
          $html .= "<td class='i16'>P</td>";
          $html .= "<td class='i17'>&nbsp;</td>";
          $html .= "<td class='i18'>P</td>";
          $html .= "<td class='i19'>P</td>";
          $html .= "<td class='i20'>&nbsp;</td>";
          $html .= "<td class='i21'>&nbsp;</td>";
          $html .= "<td class='i22'>&nbsp;</td>";
          $html .= "<td class='i23'>&nbsp;</td>";
          $html .= "<td class='i24'>$user</td>";
          $html .= "</tr>";
        } else {

          $numDuplicated++;
          $htmlDuplicated .= "<tr>";
          $htmlDuplicated .= "<td class='i0'>$k</td>";
          $htmlDuplicated .= "<td class='i1'>$pcba_sn</td>";
          $htmlDuplicated .= "<td class='i2'>$tradDate</td>";
          $htmlDuplicated .= "<td class='i3'>$tradId</td>";
          $htmlDuplicated .= "<td class='i4'>$version</td>";
          $htmlDuplicated .= "<td class='i5'>$type</td>";
          $htmlDuplicated .= "<td class='i6'>$status</td>";
          $htmlDuplicated .= "<td class='i7'>N</td>";
          $htmlDuplicated .= "<td class='i8'>&nbsp;</td>";
          $htmlDuplicated .= "<td class='i9'>P</td>";
          $htmlDuplicated .= "<td class='i10'>P</td>";
          $htmlDuplicated .= "<td class='i11'>P</td>";
          $htmlDuplicated .= "<td class='i12'>P</td>";
          $htmlDuplicated .= "<td class='i13'>P</td>";
          $htmlDuplicated .= "<td class='i14'>P</td>";
          $htmlDuplicated .= "<td class='i15'>P</td>";
          $htmlDuplicated .= "<td class='i16'>P</td>";
          $htmlDuplicated .= "<td class='i17'></td>";
          $htmlDuplicated .= "<td class='i18'>P</td>";
          $htmlDuplicated .= "<td class='i19'>P</td>";
          $htmlDuplicated .= "<td class='i20'></td>";
          $htmlDuplicated .= "<td class='i21'></td>";
          $htmlDuplicated .= "<td class='i22'></td>";
          $htmlDuplicated .= "<td class='i23'></td>";
          $htmlDuplicated .= "<td class='i24'>$user</td>";
          $htmlDuplicated .= "</tr>";
        }
        $k++;
      }
    }
  }
}

unlink($uploadfile);  // ????????????

$countAllData=$countAllData-3;// ????????? ??????
$outUploadReport = "<tr><td colspan='15'>??? $countAllData ??? / ?????? $numSuccessed ??? / ?????? $numDuplicated ???<td></tr>";
$outUploadReport .= $htmlDuplicated;
$outUploadReport .= $html;
echo $outUploadReport;

?>