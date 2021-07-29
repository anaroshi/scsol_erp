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
  ->setTitle('Office XLSX PCBA List')
  ->setSubject('Office XLSX PCBA List')
  ->setDescription('PCBA List document for Office XLSX, generated using PHP classes.')
  ->setKeywords('office openxml php')
  ->setCategory('PCBA List file');

$spreadsheet->getDefaultStyle()->getFont()->setSize(10); // font size
$spreadsheet->getActiveSheet()->setTitle('New PCBA');
$spreadsheet->getActiveSheet()->getTabColor()->setRGB('FF0000');

// Merge cells
$spreadsheet->getActiveSheet()->mergeCells('A1:G1')
->mergeCells('A2:G2');

$spreadsheet->setActiveSheetIndex(0)
  ->setCellValue('A1','신규 PCBA 업로드용 샘플' )
  ->setCellValue('A2','')
  ->setCellValue('A3', 'id')
  ->setCellValue('B3', 'PBCA_SN')
  ->setCellValue('C3', '입고일자')
  ->setCellValue('D3', '입고번호')
  ->setCellValue('E3', 'VERSION')
  ->setCellValue('F3', 'TYPE')
  ->setCellValue('G3', '담당자')
  ->setCellValue('A4', '1')
  ->setCellValue('B4', 'pcba-210629-0001')
  ->setCellValue('C4', '2021-06-29')
  ->setCellValue('D4', '1')
  ->setCellValue('E4', '0106')
  ->setCellValue('F4', 'fix')
  ->setCellValue('G4', 'admin')
  ->setCellValue('A5', '2')
  ->setCellValue('B5', 'pcba-210629-0002')
  ->setCellValue('C5', '2021-06-29')
  ->setCellValue('D5', '2')
  ->setCellValue('E5', '0106')
  ->setCellValue('F5', 'fix')
  ->setCellValue('G5', 'admin')
  ->setCellValue('A6', '3')
  ->setCellValue('B6', 'pcba-210629-0003')
  ->setCellValue('C6', '2021-06-29')
  ->setCellValue('D6', '3')
  ->setCellValue('E6', '0106')
  ->setCellValue('F6', 'fix')
  ->setCellValue('G6', 'admin');

$sheet->getColumnDimension('A:G')->setAutoSize(true);

// text를 굵게
$spreadsheet->getActiveSheet()->getStyle('A1:G3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

// set the text in the middle
$sheet->getStyle("A1:G6")->getAlignment()
  ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// apply border outline around cells
$sheet->getStyle("A3:G6")->getBorders()->getAllBorders()
  ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

// set a text color
$spreadsheet->getActiveSheet()->getStyle('A1')
  ->getFont()->getColor()->setARGB('FF191970');
$spreadsheet->getActiveSheet()->getStyle('A2')
  ->getFont()->getColor()->setARGB('FFFF0000');  

// set a background color on a range of cells  
$spreadsheet->getActiveSheet()->getStyle('A3:G3')->getFill()
  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
  ->getStartColor()->setARGB('FFA0A0A0');  

$fileName = 'pcba_uploadSample.xlsx';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
header('Cache-Control: max-age=0');

$objWriter = new Xlsx($spreadsheet);
$objWriter->save('php://output');
