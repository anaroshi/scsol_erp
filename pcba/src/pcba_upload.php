<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");
include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");


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
        $pcbaNm = trim($sheetData[$i][1]);
        if ($pcbaNm == "" || $pcbaNm !="PCB") {
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
        $type           = trim($sheetData[$i][6]);
        $user           = trim($sheetData[$i][7]);
        if($user=="" || $user=="admin") {
          echo($user." 담당자를 입력하세요.");
          return;
        }
        $status         = "not used";
        
        $pcba_sn = "PCB-".$maker."-".$version."-".$tradData_sn."-".sprintf('%04d',$tradId);

//        echo ($pcba_sn."<br>");

        $sql = "SELECT * FROM trad_part_pcba WHERE pcba_sn = '$pcba_sn'";
        if (!($result = mysqli_query($conn_11, $sql))) {
          echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
        }
        $rowsDuplicated = mysqli_num_rows($result);
 
        if ($rowsDuplicated < 1) {
          $numSuccessed++;
          $sql  = "INSERT INTO trad_part_pcba( ";
          $sql .= "pcba_sn, part_id, tradDate, tradId, maker, version, type, status, ";
          $sql .= "hostcnt, mcucnt, modemcnt, battcnt, ssorcnt, ldo, radio, buz, adc, memory, issue, inDate, user) ";
          $sql .= "VALUES ('$pcba_sn', 'SC-P-E-0003-PCB', '$tradDate', '$tradId', '$maker', '$version', '$type', '$status', ";
          $sql .= "'P', 'P', 'P', 'P', 'P', 'P', 'P', 'P', 0, 'P', 0, ";
          $sql .= " now(), '$user')";          

          if (!($result = mysqli_query($conn_11, $sql))) {
            echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
          }

          $html .= "<tr>";
          $html .= "<td class='i0'>$k</td>";
          $html .= "<td class='i1'>$pcba_sn</td>";
          $html .= "<td class='i2'>$version</td>";
          $html .= "<td class='i3'>$tradDate</td>";
          $html .= "<td class='i4'>$tradId</td>";
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
          $htmlDuplicated .= "<td class='i2'>$version</td>";
          $htmlDuplicated .= "<td class='i3'>$tradDate</td>";
          $htmlDuplicated .= "<td class='i4'>$tradId</td>";
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

unlink($uploadfile);  // 파일삭제

$countAllData=$countAllData-3;// 제목줄 제외
$outUploadReport = "<tr><td colspan='15'>총 $countAllData 건 / 성공 $numSuccessed 건 / 중복 $numDuplicated 건<td></tr>";
$outUploadReport .= $htmlDuplicated;
$outUploadReport .= $html;
echo $outUploadReport;

?>