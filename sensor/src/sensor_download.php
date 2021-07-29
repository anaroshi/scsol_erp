<?php

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet  = new Spreadsheet();
$sheet        = $spreadsheet->getActiveSheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('jhsung')
  ->setLastModifiedBy('jhsung')
  ->setTitle('Office XLSX Sensor List')
  ->setSubject('Office XLSX Sensor List')
  ->setDescription('Sensor List document for Office XLSX, generated using PHP classes.')
  ->setKeywords('office openxml php')
  ->setCategory('Sensor List file');

$spreadsheet->getDefaultStyle()->getFont()->setSize(10); // font size

// 셀 합치기

$sheet->mergeCells('A1:A4');
$sheet->mergeCells('B1:B4');
$sheet->mergeCells('C1:C4');
$sheet->mergeCells('D1:D4');
$sheet->mergeCells('E1:E4');
$sheet->mergeCells('F1:F4');
$sheet->mergeCells('G1:AL1');
$sheet->mergeCells('G2:U2');
$sheet->mergeCells('V2:AJ2');
$sheet->mergeCells('G3:I3');
$sheet->mergeCells('J3:L3');
$sheet->mergeCells('M3:O3');
$sheet->mergeCells('P3:R3');
$sheet->mergeCells('S3:U3');
$sheet->mergeCells('V3:X3');
$sheet->mergeCells('Y3:AA3');
$sheet->mergeCells('AB3:AD3');
$sheet->mergeCells('AE3:AG3');
$sheet->mergeCells('AH3:AJ3');
$sheet->mergeCells('AK2:AK4');
$sheet->mergeCells('AL2:AL4');
$sheet->mergeCells('AM1:AM4');
$sheet->mergeCells('AN1:AN4');


$spreadsheet->setActiveSheetIndex(0)
->setCellValue('A1','id')
->setCellValue('B1','SENSOR_SN')
->setCellValue('C1','입고일자')
->setCellValue('D1','입고번호')
->setCellValue('E1','상태')
->setCellValue('F1','SCSOL SN')
->setCellValue('G1','CHECK LIST')
->setCellValue('AM1','비고')
->setCellValue('AN1','기타')

->setCellValue('G2','MIX')
->setCellValue('V2','SINGLE')
->setCellValue('AK2','종합판정')
->setCellValue('AL2','ISSUE')

->setCellValue('G3','400')
->setCellValue('J3','600')
->setCellValue('M3','800')
->setCellValue('P3','1000')
->setCellValue('S3','1200')
->setCellValue('V3','400')
->setCellValue('Y3','600')
->setCellValue('AB3','800')
->setCellValue('AE3','1000')
->setCellValue('AH3','1200')

->setCellValue('G4','1')
->setCellValue('H4','2')
->setCellValue('I4','3')
->setCellValue('J4','1')
->setCellValue('K4','2')
->setCellValue('L4','3')
->setCellValue('M4','1')
->setCellValue('N4','2')
->setCellValue('O4','3')
->setCellValue('P4','1')
->setCellValue('Q4','2')
->setCellValue('R4','3')
->setCellValue('S4','1')
->setCellValue('T4','2')
->setCellValue('U4','3')
->setCellValue('V4','1')
->setCellValue('W4','2')
->setCellValue('X4','3')  
->setCellValue('Y4','1')
->setCellValue('Z4','2')
->setCellValue('AA4','3')
->setCellValue('AB4','1')
->setCellValue('AC4','2')
->setCellValue('AD4','3')
->setCellValue('AE4','1')
->setCellValue('AF4','2')
->setCellValue('AG4','3')
->setCellValue('AH4','1')
->setCellValue('AI4','2')
->setCellValue('AJ4','3');


/**
 * 센서 조회 처리
 * table : trad_part_sensor
 * 조건 : sensor_sn, sensor_tradDateFrom, sensor_tradDateTo, sensor_status
 * $outputList
 */

$sn             = trim($_GET["sensor_sn"]);               // 센서 SN
$tradDateFrom   = trim($_GET["sensor_tradDateFrom"]);     // 가입 일자 시작
$tradDateTo     = trim($_GET["sensor_tradDateTo"]);       // 가입 일자 까지
$status         = trim($_GET["sensor_status"]);           // 상태

// echo 'sn: '.$sn;
// echo 'tradDateFrom: '.$tradDateFrom;
// echo 'tradDateTo: '.$tradDateTo;
// echo 'status: '.$status;

$sql = "select * FROM trad_part_sensor ";
$sql .= "WHERE 1 ";
$sql .= " and flag != 4 ";
if ($sn != "") {
  $sql .= "and sn like '%$sensor_sn%' ";
}
if ($tradDateFrom != "" || $tradDateTo != "" ) {
  $sql .= "and tradDate between '$tradDateFrom' and '$tradDateTo' ";
}
if ($status == 1) {
  $sql .= "and status = 'used' ";
} elseif ($status == 2) {
  $sql .= "and status = 'not used' ";
}
$sql .= "ORDER BY id ";

// echo($sql);

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

mysqli_set_charset($conn_11,"utf8");

$outputList ="";
$no = 0;
$i = 4;
while ($row = mysqli_fetch_assoc($result)) {

  $no++;
  $i++;
  $id                     = $row['id'];
  $sensor_sn              = $row['sensor_sn'];
  $tradDate               = $row['tradDate'];
  $tradId                 = $row['tradId'];
  $status                 = $row['status'];
  $sn                     = $row['sn'];
  $hz_mix_fh1             = $row['hz_mix_fh1'];
  $hz_mix_fh2             = $row['hz_mix_fh2'];
  $hz_mix_fh3             = $row['hz_mix_fh3'];
  $hz_mix_sh1             = $row['hz_mix_sh1'];
  $hz_mix_sh2             = $row['hz_mix_sh2'];
  $hz_mix_sh3             = $row['hz_mix_sh3'];
  $hz_mix_eh1             = $row['hz_mix_eh1'];
  $hz_mix_eh2             = $row['hz_mix_eh2'];
  $hz_mix_eh3             = $row['hz_mix_eh3'];
  $hz_mix_tt1             = $row['hz_mix_tt1'];
  $hz_mix_tt2             = $row['hz_mix_tt2'];
  $hz_mix_tt3             = $row['hz_mix_tt3'];
  $hz_mix_tw1             = $row['hz_mix_tw1'];
  $hz_mix_tw2             = $row['hz_mix_tw2'];
  $hz_mix_tw3             = $row['hz_mix_tw3'];
  $hz_fh1                 = $row['hz_fh1'];
  $hz_fh2                 = $row['hz_fh2'];
  $hz_fh3                 = $row['hz_fh3'];
  $hz_sh1                 = $row['hz_sh1'];
  $hz_sh2                 = $row['hz_sh2'];
  $hz_sh3                 = $row['hz_sh3'];
  $hz_eh1                 = $row['hz_eh1'];
  $hz_eh2                 = $row['hz_eh2'];
  $hz_eh3                 = $row['hz_eh3'];
  $hz_tt1                 = $row['hz_tt1'];
  $hz_tt2                 = $row['hz_tt2'];
  $hz_tt3                 = $row['hz_tt3'];
  $hz_tw1                 = $row['hz_tw1'];
  $hz_tw2                 = $row['hz_tw2'];
  $hz_tw3                 = $row['hz_tw3'];
  $conclusion             = $row['conclusion'];
  $issue                  = $row['issue'];
  $comment                = $row['comment'];
  $etc                    = $row['etc'];

  /**
   * Excel file contents
   */
  $sheet->setCellValue("A$i", $no)
  ->setCellValue("B$i",  $sensor_sn)
  ->setCellValue("C$i",  $tradDate)
  ->setCellValue("D$i",  $tradId)
  ->setCellValue("E$i",  $status)
  ->setCellValue("F$i",  $sn)
  ->setCellValue("G$i",  $hz_mix_fh1)
  ->setCellValue("H$i",  $hz_mix_fh2)
  ->setCellValue("I$i",  $hz_mix_fh3)
  ->setCellValue("J$i",  $hz_mix_sh1)
  ->setCellValue("K$i",  $hz_mix_sh2)
  ->setCellValue("L$i",  $hz_mix_sh3)
  ->setCellValue("M$i",  $hz_mix_eh1)
  ->setCellValue("N$i",  $hz_mix_eh2)
  ->setCellValue("O$i",  $hz_mix_eh3)
  ->setCellValue("P$i",  $hz_mix_tt1)
  ->setCellValue("Q$i",  $hz_mix_tt2)
  ->setCellValue("R$i",  $hz_mix_tt3)
  ->setCellValue("S$i",  $hz_mix_tw1)
  ->setCellValue("T$i",  $hz_mix_tw2)
  ->setCellValue("U$i",  $hz_mix_tw3)
  ->setCellValue("V$i",  $hz_fh1)
  ->setCellValue("W$i",  $hz_fh2)
  ->setCellValue("X$i",  $hz_fh3)
  ->setCellValue("Y$i",  $hz_sh1)
  ->setCellValue("Z$i",  $hz_sh2)
  ->setCellValue("AA$i", $hz_sh3)
  ->setCellValue("AB$i", $hz_eh1)
  ->setCellValue("AC$i", $hz_eh2)
  ->setCellValue("AD$i", $hz_eh3)
  ->setCellValue("AE$i", $hz_tt1)
  ->setCellValue("AF$i", $hz_tt2)
  ->setCellValue("AG$i", $hz_tt3)
  ->setCellValue("AH$i", $hz_tw1)
  ->setCellValue("AI$i", $hz_tw2)
  ->setCellValue("AJ$i", $hz_tw3)
  ->setCellValue("AK$i", $conclusion)
  ->setCellValue("AL$i", $issue)
  ->setCellValue("AM$i", $comment)
  ->setCellValue("AN$i", $etc);

}

$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
//$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);
$sheet->getColumnDimension('H')->setAutoSize(true);
$sheet->getColumnDimension('I')->setAutoSize(true);
$sheet->getColumnDimension('J')->setAutoSize(true);
$sheet->getColumnDimension('K')->setAutoSize(true);
$sheet->getColumnDimension('L')->setAutoSize(true);
$sheet->getColumnDimension('M')->setAutoSize(true);
$sheet->getColumnDimension('N')->setAutoSize(true);
$sheet->getColumnDimension('O')->setAutoSize(true);
$sheet->getColumnDimension('P')->setAutoSize(true);
$sheet->getColumnDimension('Q')->setAutoSize(true);
$sheet->getColumnDimension('R')->setAutoSize(true);
$sheet->getColumnDimension('S')->setAutoSize(true);
$sheet->getColumnDimension('T')->setAutoSize(true);
$sheet->getColumnDimension('U')->setAutoSize(true);
$sheet->getColumnDimension('V')->setAutoSize(true);
$sheet->getColumnDimension('W')->setAutoSize(true);
$sheet->getColumnDimension('X')->setAutoSize(true);
$sheet->getColumnDimension('Y')->setAutoSize(true);
$sheet->getColumnDimension('Z')->setAutoSize(true);
$sheet->getColumnDimension('AA')->setAutoSize(true);
$sheet->getColumnDimension('AB')->setAutoSize(true);
$sheet->getColumnDimension('AC')->setAutoSize(true);
$sheet->getColumnDimension('AD')->setAutoSize(true);
$sheet->getColumnDimension('AE')->setAutoSize(true);
$sheet->getColumnDimension('AF')->setAutoSize(true);
$sheet->getColumnDimension('AG')->setAutoSize(true);
$sheet->getColumnDimension('AH')->setAutoSize(true);
$sheet->getColumnDimension('AI')->setAutoSize(true);
$sheet->getColumnDimension('AJ')->setAutoSize(true);
$sheet->getColumnDimension('AK')->setAutoSize(true);
$sheet->getColumnDimension('AL')->setAutoSize(true);
$sheet->getColumnDimension('AM')->setAutoSize(true);
$sheet->getColumnDimension('AN')->setAutoSize(true);


// text를 굵게
$spreadsheet->getActiveSheet()->getStyle("A1:AM4")->getFont()->setBold(true);

$no=$no+4;

// 헤더 칼럼 가운데 정렬
$sheet->getStyle("A1:AN$no")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);


// 표 그리기
$sheet->getStyle("A1:AN$no")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$fileName = 'sensor_list.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$fileName.'"');
header('Cache-Control: max-age=0');

$objWriter= new Xlsx($spreadsheet);
$objWriter->save('php://output');


?>