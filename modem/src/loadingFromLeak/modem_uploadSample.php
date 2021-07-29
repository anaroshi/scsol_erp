<?php
  include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");
  include($_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php");

  use PhpOffice\PhpSpreadsheet\IOFactory;
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  
  $spreadsheet  = new Spreadsheet();  
  $sheet        = $spreadsheet->getActiveSheet();
  
  // Set document properties
  $spreadsheet->getProperties()->setCreator('jhsung')
    ->setLastModifiedBy('jhsung')
    ->setTitle('Office XLSX Modem List')
    ->setSubject('Office XLSX Modem List')
    ->setDescription('Battery List document for Office XLSX, generated using PHP classes.')
    ->setKeywords('office openxml php')
    ->setCategory('Battery List File');

  $spreadsheet->getDefaultStyle()->getFont()->setSize(10);  // font size
  $spreadsheet->getActiveSheet()->setTitle('New Modem');
  $spreadsheet->getActiveSheet()->getTabColor()->setRGB('FF0000');

  // Merge cells
  $spreadsheet->getActiveSheet()->mergeCells('A1:N1')
  ->mergeCells('A2:N2');

  $spreadsheet->setActiveSheetIndex(0)
  ->setCellValue('A1','신규 모뎀 업로드용 샘플' )
  ->setCellValue('A2','*** 모뎀 입고 번호는 순번으로 처리 되어니 꼭 마지막 입고 번호 확인 후 업로드 바랍니다. ***')
  ->setCellValue('A3','ID')
  ->setCellValue('B3','PHONE')
  ->setCellValue('C3','SERIAL')
  ->setCellValue('D3','USIM')
  ->setCellValue('E3','요금제')
  ->setCellValue('F3','약정')
  ->setCellValue('G3','가입일자')
  ->setCellValue('H3','입고번호')
  ->setCellValue('I3','상태')
  ->setCellValue('J3','정상')
  ->setCellValue('K3','PRODUCT')
  ->setCellValue('L3','PRODUCT CODE')
  ->setCellValue('M3','VERSION')
  ->setCellValue('N3','담당자')
  ->setCellValue('A4','1')
  ->setCellValue('B4','8212-3268-8643')
  ->setCellValue('C4','334001')
  ->setCellValue('D4','2008600300009F')
  ->setCellValue('E4','LTE-M-10')
  ->setCellValue('F4','24개월')
  ->setCellValue('G4','2021-06-23')
  ->setCellValue('H4','1136')
  ->setCellValue('I4','not used')
  ->setCellValue('J4','N')
  ->setCellValue('K4','LeakMaster')
  ->setCellValue('L4','SWFLB')
  ->setCellValue('M4','106')
  ->setCellValue('N4','admin')
  ->setCellValue('A5','2')
  ->setCellValue('B5','8212-3268-8644')
  ->setCellValue('C5','334002')
  ->setCellValue('D5','2008600300017F')
  ->setCellValue('E5','LTE-M-10')
  ->setCellValue('F5','24개월')
  ->setCellValue('G5','2021-06-23')
  ->setCellValue('H5','1137')
  ->setCellValue('I5','not used')
  ->setCellValue('J5','N')
  ->setCellValue('K5','LeakMaster')
  ->setCellValue('L5','SWFLB')
  ->setCellValue('M5','106')
  ->setCellValue('N5','admin')
  ->setCellValue('A6','3')
  ->setCellValue('B6','8212-3268-8645')
  ->setCellValue('C6','334003')
  ->setCellValue('D6','2008600300025F')
  ->setCellValue('E6','LTE-M-10')
  ->setCellValue('F6','24개월')
  ->setCellValue('G6','2021-06-23')
  ->setCellValue('H6','1138')
  ->setCellValue('I6','not used')
  ->setCellValue('J6','N')
  ->setCellValue('K6','LeakMaster')
  ->setCellValue('L6','SWFLB')
  ->setCellValue('M6','106')
  ->setCellValue('N6','admin');

  $spreadsheet->getActiveSheet()->getColumnDimension('A:N')->setAutoSize(true);
  
  // bold text
  $spreadsheet->getActiveSheet()->getStyle('A1:N3')->getFont()->setBold(true);
  $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);

  // set the text in the middle
  $sheet->getStyle("A1:N6")->getAlignment()
    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

  // apply border outline around cells
  $sheet->getStyle("A3:N6")->getBorders()->getAllBorders()
    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

  // set a text color
  $spreadsheet->getActiveSheet()->getStyle('A1')
    ->getFont()->getColor()->setARGB('FF191970');
  $spreadsheet->getActiveSheet()->getStyle('A2')
    ->getFont()->getColor()->setARGB('FFFF0000');  

  // set a background color on a range of cells  
  $spreadsheet->getActiveSheet()->getStyle('A3:N3')->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFA0A0A0');  

  
  $fileName = 'modem_insertSample.xlsx';

  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="'.$fileName.'"');
  header('Cache-Control: max-age=0');

  $objWriter = new Xlsx($spreadsheet);
  $objWriter->save('php://output');

?>