<?php

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
  $spreadsheet->getActiveSheet()->setTitle('New SENSOR');
  $spreadsheet->getActiveSheet()->getTabColor()->setRGB('FF0000');

  // Merge cells
  $spreadsheet->getActiveSheet()->mergeCells('A1:G1')
  ->mergeCells('A2:G2');

  $spreadsheet->setActiveSheetIndex(0)
  ->setCellValue('A1','신규 SENSOR 업로드용 샘플' )
  ->setCellValue('A2','')

  ->setCellValue('A3','ID')
  ->setCellValue('B3','자재명')
  ->setCellValue('C3','Maker')
  ->setCellValue('D3','제품명/버전')
  ->setCellValue('E3','입고일자')
  ->setCellValue('F3','입고번호')
  ->setCellValue('G3','담당자')

  ->setCellValue('A4','1')
  ->setCellValue('B4','SEN')
  ->setCellValue('C4','MUR')
  ->setCellValue('D4','7BB27')
  ->setCellValue('E4','2021-02-05')
  ->setCellValue('F4','1')
  ->setCellValue('G4','admin')

  ->setCellValue('A5','2')
  ->setCellValue('B5','SEN')
  ->setCellValue('C5','MUR')
  ->setCellValue('D5','7BB27')
  ->setCellValue('E5','2021-02-05')
  ->setCellValue('F5','2')
  ->setCellValue('G5','admin')
  
  ->setCellValue('A6','3')
  ->setCellValue('B6','SEN')
  ->setCellValue('C6','MUR')
  ->setCellValue('D6','7BB27')
  ->setCellValue('E6','2021-02-05')
  ->setCellValue('F6','3')
  ->setCellValue('G6','admin');


  $sheet->getColumnDimension('A:G')->setAutoSize(true);

  // text를 굵게
  $spreadsheet->getActiveSheet()->getStyle('A1:G3')->getFont()->setBold(true);
  $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);


  // 헤더 칼럼 가운데 정렬
  $sheet->getStyle("A1:G6")->getAlignment()
  ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

  // 표 그리기
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

  $fileName = 'sensor_insertSample.xlsx';

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$fileName.'"');
  header('Cache-Control: max-age=0');

  $objWriter= new Xlsx($spreadsheet);
  $objWriter->save('php://output');

?>