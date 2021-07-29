<?php

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");
include($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set document properties
$spreadsheet->getProperties()->setCreator('jhsung')
  ->setLastModifiedBy('jhsung')
  ->setTitle('Office XLSX Battery List')
  ->setSubject('Office XLSX Battery List')
  ->setDescription('Battery List document for Office XLSX, generated using PHP classes.')
  ->setKeywords('office openxml php')
  ->setCategory('Battery List file');

$spreadsheet->getDefaultStyle()->getFont()->setSize(10); // font size

$spreadsheet->setActiveSheetIndex(0)
  ->setCellValue('A1','id')
  ->setCellValue('B1','BATTERY_SN')
  ->setCellValue('C1','입고일자')
  ->setCellValue('D1','입고번호')
  ->setCellValue('E1','CELL TYPE')
  ->setCellValue('F1','CELL SIZE')
  ->setCellValue('G1','SIZE CAPACITY')
  ->setCellValue('H1','CELL 제조사')
  ->setCellValue('I1','제조사')
  ->setCellValue('J1','상태')
  ->setCellValue('K1','정상')
  ->setCellValue('L1','SCSOL S/N')
  ->setCellValue('M1','배터리 전압')
  ->setCellValue('N1','비고')
  ->setCellValue('O1','기타')
  ->setCellValue('P1','수정일')
  ->setCellValue('Q1','담당자');


/**
 * 배터리 조회 처리
 * table : trad_part_battery
 * 조건 : battery_sn, batt_tradDateFrom, batt_tradDateTo, batt_status
 * $outputList
 */

$batt_sn        = trim($_GET["batt_sn"]) ?? '';               // 모뎀 SN
$tradDateFrom   = trim($_GET["batt_tradDateFrom"]) ?? '';     // 가입 일자 시작
$tradDateTo     = trim($_GET["batt_tradDateTo"]) ?? '';       // 가입 일자 까지
$status         = trim($_GET["batt_status"]) ?? '';           // 상태
$product        = trim($_GET["batt_product"]) ?? '';          // product

// echo 'sn: '.$batt_sn;
// echo 'tradDateFrom: '.$tradDateFrom;
// echo 'tradDateTo: '.$tradDateTo;
// echo 'status: '.$status;

$sql = "SELECT * FROM trad_part_battery ";
$sql .= "WHERE 1 ";
$sql .= " AND flag != 4 ";
if ($batt_sn != "") {
  $sql .= "AND battery_sn like '%$batt_sn%' ";
}
if ($tradDateFrom != "" || $tradDateTo != "" ) {
  $sql .= "and tradDate between '$tradDateFrom' and '$tradDateTo' ";
}
if ($status == 1) {
  $sql .= "and status = 'used' ";
} elseif ($status == 2) {
  $sql .= "and status = 'not used' ";
}
// if ($product != "000") {
//   $sql .= "and product = '$product' ";
// }
$sql .= "ORDER BY id ";

//echo("<br>".$sql);

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

mysqli_set_charset($conn_11,"utf8");

$outputList ="";
$no = 0;
$i = 1;
while ($row = mysqli_fetch_assoc($result)) {

  $no++;
  $i++;
  $id                   = $row['id'];
  $batt_sn              = $row['battery_sn'];
  $part_id              = $row['part_id'];
  $tradDate             = $row['tradDate'];
  $tradId               = $row['tradId'];
  $cellType             = $row['cellType'];
  $cellSize             = $row['cellSize'];
  $cellCap              = $row['cellCap'];
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
  if($reuser == "") {
    $reuser = $user;
    $reDate = $inDate;
  }
/*
  echo '<br>i: '.$i;
  echo '<br>id: '.$id;
  echo '<br>batt_sn: '.$batt_sn;
  echo '<br>part_id: '.$part_id;
  echo '<br>tradDate: '.$tradDate;
  echo '<br>tradId: '.$tradId;
  echo '<br>cellType: '.$cellType;
  echo '<br>cellSize: '.$cellSize;
  echo '<br>cellCap: '.$cellCap;
  echo '<br>cellFactory: '.$cellFactory;
  echo '<br>factory: '.$factory;
  echo '<br>status: '.$status;
  echo '<br>validity: '.$validity;
  echo '<br>sn: '.$sn;
  echo '<br>voltage: '.$voltage;
  echo '<br>comment: '.$comment;
  echo '<br>etc: '.$etc;
  echo '<br>flag: '.$flag;
  echo '<br>user: '.$user;
  echo '<br>inDate: '.$inDate;
  echo '<br>reuser: '.$reuser;
  echo '<br>reDate: '.$reDate;
  
*/
  /**
   * Excel file contents
   */
  $sheet->setCellValue("A$i", $no)
  ->setCellValue("B$i", $batt_sn)
  ->setCellValue("C$i", $tradDate)
  ->setCellValue("D$i", $tradId)
  ->setCellValue("E$i", $cellType)
  ->setCellValue("F$i", $cellSize)
  ->setCellValue("G$i", $cellCap)
  ->setCellValue("H$i", $cellFactory)
  ->setCellValue("I$i", $factory)
  ->setCellValue("J$i", $status)
  ->setCellValue("K$i", $validity)
  ->setCellValue("L$i", $sn)
  ->setCellValue("M$i", $voltage)
  ->setCellValue("N$i", $comment)
  ->setCellValue("O$i", $etc)
  ->setCellValue("P$i", $reDate)
  ->setCellValue("Q$i", $reuser);
 }

$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
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

// text를 굵게
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('P1')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);


// echo ("<br>no:".$no);
// 헤더 칼럼 가운데 정렬
$sheet->getStyle("A1:Q$no")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// 표 그리기
$sheet->getStyle("A1:Q$no")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$fileName = 'batt_list.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$fileName.'"');
header('Cache-Control: max-age=0');

$objWriter= new Xlsx($spreadsheet);
$objWriter->save('php://output');


?>