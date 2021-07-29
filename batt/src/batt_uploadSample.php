<?php

include($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

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
$spreadsheet->getActiveSheet()->setTitle('New BATTERY');
$spreadsheet->getActiveSheet()->getTabColor()->setRGB('FF0000');

// Merge cells
$spreadsheet->getActiveSheet()->mergeCells('A1:M1')
->mergeCells('A2:M2');

$spreadsheet->setActiveSheetIndex(0)
  ->setCellValue('A1','신규 BATTERY 업로드용 샘플' )
  ->setCellValue('A2','')

  ->setCellValue('A3','ID')
  ->setCellValue('B3','자재명')
  ->setCellValue('C3','Maker')
  ->setCellValue('D3','제품명/버전')
  ->setCellValue('E3','입고일자')
  ->setCellValue('F3','입고번호')
  ->setCellValue('G3','CELL TYPE')
  ->setCellValue('H3','CELL SIZE')
  ->setCellValue('I3','SIZE CAPACITY')
  ->setCellValue('J3','CELL 제조사')
  ->setCellValue('K3','제조사')
  ->setCellValue('L3','배터리 전압')
  ->setCellValue('M3','담당자')

  ->setCellValue('A4','1')
  ->setCellValue('B4','BAT')
  ->setCellValue('C4','SAM')
  ->setCellValue('D4','ION7A')  
  ->setCellValue('E4','2021-06-02')
  ->setCellValue('F4','1')
  ->setCellValue('G4','Li-ION')
  ->setCellValue('H4','18650')
  ->setCellValue('I4','7000')
  ->setCellValue('J4','삼성')
  ->setCellValue('K4','파워랜드')
  ->setCellValue('L4','0')
  ->setCellValue('M4','admin')

  ->setCellValue('A5','2')
  ->setCellValue('B5','BAT')
  ->setCellValue('C5','SAM')
  ->setCellValue('D5','ION7A')  
  ->setCellValue('E5','2021-06-02')
  ->setCellValue('F5','2')
  ->setCellValue('G5','Li-ION')
  ->setCellValue('H5','18650')
  ->setCellValue('I5','7000')
  ->setCellValue('J5','삼성')
  ->setCellValue('K5','파워랜드')
  ->setCellValue('L5','0')
  ->setCellValue('M5','admin')
  
  ->setCellValue('A6','3')
  ->setCellValue('B6','BAT')
  ->setCellValue('C6','SAM')
  ->setCellValue('D6','ION7A')  
  ->setCellValue('E6','2021-06-02')
  ->setCellValue('F6','3')
  ->setCellValue('G6','Li-ION')
  ->setCellValue('H6','18650')
  ->setCellValue('I6','7000')
  ->setCellValue('J6','삼성')
  ->setCellValue('K6','파워랜드')
  ->setCellValue('L6','0')
  ->setCellValue('M6','admin');


$sheet->getColumnDimension('A:M')->setAutoSize(true);

// text를 굵게
$spreadsheet->getActiveSheet()->getStyle('A1:M3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);


// 헤더 칼럼 가운데 정렬
$sheet->getStyle("A1:M6")->getAlignment()
  ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// 표 그리기
$sheet->getStyle("A3:M6")->getBorders()->getAllBorders()
  ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

// set a text color
$spreadsheet->getActiveSheet()->getStyle('A1')
  ->getFont()->getColor()->setARGB('FF191970');
$spreadsheet->getActiveSheet()->getStyle('A2')
  ->getFont()->getColor()->setARGB('FFFF0000');  

// set a background color on a range of cells  
$spreadsheet->getActiveSheet()->getStyle('A3:M3')->getFill()
  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
  ->getStartColor()->setARGB('FFA0A0A0');

$fileName = 'batt_insertSample.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$fileName.'"');
header('Cache-Control: max-age=0');

$objWriter= new Xlsx($spreadsheet);
$objWriter->save('php://output');


?>