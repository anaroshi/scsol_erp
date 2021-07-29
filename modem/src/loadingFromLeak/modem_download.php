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
  ->setTitle('Office XLSX Modem List')
  ->setSubject('Office XLSX Modem List')
  ->setDescription('Modem List document for Office XLSX, generated using PHP classes.')
  ->setKeywords('office openxml php')
  ->setCategory('Modem List file');

$spreadsheet->getDefaultStyle()->getFont()->setSize(10); // font size

$spreadsheet->setActiveSheetIndex(0)
  ->setCellValue('A1','id')
  ->setCellValue('B1','PHONE')
  ->setCellValue('C1','SERIAL')
  ->setCellValue('D1','USIM')
  ->setCellValue('E1','요금제')
  ->setCellValue('F1','약정')
  ->setCellValue('G1','가입일자')
  ->setCellValue('H1','입고번호')
  ->setCellValue('I1','상태')
  ->setCellValue('J1','정상')
  ->setCellValue('K1','PRODUCT')
  ->setCellValue('L1','PRODUCT CODE')
  ->setCellValue('M1','VERSION')
  ->setCellValue('N1','SCSOL S/N')
  ->setCellValue('O1','비고')
  ->setCellValue('P1','기타');



/**
 * 모뎀 조회 처리
 * table : trad_part_modem
 * 조건 : modem_sn, modem_tradDateFrom, modem_tradDateTo, modem_status
 * $outputList
 */

$sn             = trim($_GET["modem_sn"]);               // 모뎀 SN
$tradDateFrom   = trim($_GET["modem_tradDateFrom"]);     // 가입 일자 시작
$tradDateTo     = trim($_GET["modem_tradDateTo"]);       // 가입 일자 까지
$status         = trim($_GET["modem_status"]);           // 상태
$product        = trim($_GET["modem_product"]);          // product

// echo 'sn: '.$sn;
// echo 'tradDateFrom: '.$tradDateFrom;
// echo 'tradDateTo: '.$tradDateTo;
// echo 'status: '.$status;

$sql = "select * FROM trad_part_modem ";
$sql .= "WHERE 1 ";
$sql .= " and flag != 4 ";
if ($sn != "") {
  $sql .= "and sn like '%$modem_sn%' ";
}
if ($tradDateFrom != "" || $tradDateTo != "" ) {
  $sql .= "and tradDate between '$tradDateFrom' and '$tradDateTo' ";
}
if ($status == 1) {
  $sql .= "and status = 'used' ";
} elseif ($status == 2) {
  $sql .= "and status = 'not used' ";
}
if ($product != "000") {
  $sql .= "and product = '$product' ";
}
$sql .= "ORDER BY id ";

// echo($sql);

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
  $id = $row['id'];
  $phone_no = $row['phone_no'];
  $supplierSn = $row['supplierSn'];
  $usim = $row['usim'];  
  $rate = $row['rate'];
  $monthlyFee = $row['monthlyFee'];
  $tradDate = $row['tradDate'];
  $tradId = $row['tradId'];
  $status = $row['status'];
  $validity = $row['validity'];
  $product = $row['product'];
  $product_cd = $row['product_cd'];
  $version = $row['version'];
  $sn = $row['sn'];
  $comment = $row['comment'];
  $etc = $row['etc'];


  /**
   * Excel file contents
   */
  $sheet->setCellValue("A$i", $no)
  ->setCellValue("B$i", $row['phone_no'])
  ->setCellValue("C$i", $row['supplierSn'])
  ->setCellValue("D$i", $row['usim'])
  ->setCellValue("E$i", $row['rate'])
  ->setCellValue("F$i", $row['monthlyFee'])
  ->setCellValue("G$i", $row['tradDate'])
  ->setCellValue("H$i", $row['tradId'])
  ->setCellValue("I$i", $row['status'])
  ->setCellValue("J$i", $row['validity'])
  ->setCellValue("K$i", $row['product'])
  ->setCellValue("L$i", $row['product_cd'])
  ->setCellValue("M$i", $row['version'])
  ->setCellValue("N$i", $row['sn'])
  ->setCellValue("O$i", $row['comment'])
  ->setCellValue("P$i", $row['etc']);
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

$no++;
// 헤더 칼럼 가운데 정렬
$sheet->getStyle("A1:P$no")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// 표 그리기
$sheet->getStyle("A1:P$no")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

$fileName = 'modem_list.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$fileName.'"');
header('Cache-Control: max-age=0');

$objWriter= new Xlsx($spreadsheet);
$objWriter->save('php://output');


?>