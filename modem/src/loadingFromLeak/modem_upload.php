
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

$uploaddir = $_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/modem/temporary/";
$filename   = $_FILES["modem_readfile"]["name"];
//echo ("filename : $filename\n");

$arr_file = explode('.', $filename);
$extension = end($arr_file);

if ('xlsx' == $extension) {
  $reader = new PhpOffice\PhpSpreadsheet\Reader\Xlsx();
} else {
  $reader = new PhpOffice\PhpSpreadsheet\Reader\Xls();
}

$uploadfile = $uploaddir . $filename;

//echo ("uploadfile : $uploadfile\n");

$inputFileName = $_FILES["modem_readfile"]["tmp_name"];
//echo ("inputFileName : $inputFileName\n");

if (move_uploaded_file($inputFileName, $uploadfile)) {
  echo ("move_uploaded_fil : ok\n");

  if (file_exists($uploadfile)) {
    $spreadsheet = $reader->load($uploadfile);
    $sheetData = $spreadsheet->getActiveSheet()->toArray();
    $countAllData = count($sheetData);

    if (!empty($sheetData)) {
      $numSuccessed   = 0;
      $numDuplicated  = 0;
      $html           = "";
      $htmlDuplicated = "";
      $k=1;  
      for ($i = 3; $i < $countAllData; $i++) {
        $phone_no     = trim($sheetData[$i][1]);
        if ($phone_no == "") break;
        $supplierSn   = trim($sheetData[$i][2]);
        $usim         = trim($sheetData[$i][3]);
        $rate         = trim($sheetData[$i][4]);
        $monthlyFee   = trim($sheetData[$i][5]);
        $tradDate     = date('Y-m-d', strtotime($sheetData[$i][6]));
        $tradId       = trim($sheetData[$i][7]);
        $status       = 'not-used';
        $validity     = 'N'; 
        $product      = trim($sheetData[$i][10]);
        $product_cd   = trim($sheetData[$i][11]);
        $version      = trim($sheetData[$i][12]);
        $sn1          = "CAST(DATE_FORMAT('$tradDate','%Y%m%d') as char)";
        $sn2          = "LPAD('$version','4','0')";
        $sn3          = "LPAD('$tradId','4','0')";
        $erpSn        = "CONCAT('$product_cd','-',$sn1,'-',$sn2,'-',$sn3)";
        $user         = trim($sheetData[$i][13]);
        
        $sql = "SELECT * FROM trad_part_modem WHERE phone_no = '$phone_no'";
        if (!($result = mysqli_query($conn_11, $sql))) {
          echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
        }
        $rowsDuplicated = mysqli_num_rows($result);
        if ($rowsDuplicated < 1) {
          $numSuccessed++;
          $sql  = "INSERT INTO trad_part_modem( ";
          $sql .= "part_id, supplierSn, usim, phone_no, rate, monthlyFee, tradDate, tradId, status, product, product_cd, version, erpSn, validity, user, inDate) ";
          $sql .= "values('SC-P-E-0001-MOD', '$supplierSn', '$usim', '$phone_no', '$rate', '$monthlyFee', '$tradDate', '$tradId', '$status', '$product', ";
          $sql .= "'$product_cd', '$version', $erpSn, '$validity', '$user', now())";          

          // INSERT INTO trad_part_modem( part_id, supplierSn, usim, phone_no, rate, monthlyFee, tradDate, tradId, status, product, product_cd, version, sn, comment, etc, inDate) 
          // values('SC-P-E-0106-E', 'LM5', '320400', '1808304845444F', '012-3261-8794', 'LTE-M-10', '24개월', '210225', '435', 'used', 'LeakMaster', 
          //        if('LeakMaster'='LeakMaster','SWFLB',if('LeakMaster'='CurrentMaster','STFCB',if('LeakMaster'='MotorMaster','STFMB',if('LeakMaster'='VibrationMaster','STFVB','')))), 
          //        '106',CONCAT(if('LeakMaster'='LeakMaster','SWFLB',if('LeakMaster'='CurrentMaster','STFCB',if('LeakMaster'='MotorMaster','STFMB',if('LeakMaster'='VibrationMaster','STFVB','')))),'-',CAST(DATE_FORMAT('210225','%Y%m%d') as char),'-',LPAD('106','4','0'),'-',LPAD('435','4','0')), '', '', now())

          if (!($result = mysqli_query($conn_11, $sql))) {
            echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
          }

          $html .= "<tr>";
          $html .= "<td class='i0'>$k</td>";
          $html .= "<td class='i1'>$phone_no</td>";
          $html .= "<td class='i2'>$supplierSn</td>";
          $html .= "<td class='i3'>$usim</td>";
          $html .= "<td class='i4'>$rate</td>";
          $html .= "<td class='i5'>$monthlyFee</td>";
          $html .= "<td class='i6'>$tradDate</td>";
          $html .= "<td class='i7'>$tradId</td>";
          $html .= "<td class='i8'>$status</td>";
          $html .= "<td class='i9'>$validity</td>";
          $html .= "<td class='i10'>$product</td>";
          $html .= "<td class='i11'>$product_cd</td>";
          $html .= "<td class='i12'>$version</td>";
          $html .= "<td class='i13'></td>"; // 수식으로 표시되므로 화면표시 안함
          $html .= "<td class='i14'>$user</td>";
          $html .= "</tr>";
        } else {
          $numDuplicated++;
          $htmlDuplicated .= "<tr>";
          $htmlDuplicated .= "<td class='i0'>$k</td>";
          $htmlDuplicated .= "<td class='i1'>$phone_no</td>";
          $htmlDuplicated .= "<td class='i2'>$supplierSn</td>";
          $htmlDuplicated .= "<td class='i3'>$usim</td>";
          $htmlDuplicated .= "<td class='i4'>$rate</td>";
          $htmlDuplicated .= "<td class='i5'>$monthlyFee</td>";
          $htmlDuplicated .= "<td class='i6'>$tradDate</td>";
          $htmlDuplicated .= "<td class='i7'>$tradId</td>";
          $htmlDuplicated .= "<td class='i8'>$status</td>";
          $htmlDuplicated .= "<td class='i9'>$validity</td>";
          $htmlDuplicated .= "<td class='i10'>$product</td>";
          $htmlDuplicated .= "<td class='i11'>$product_cd</td>";
          $htmlDuplicated .= "<td class='i12'>$version</td>";
          $htmlDuplicated .= "<td class='i13'></td>"; // 수식으로 표시되므로 화면표시 안함
          $htmlDuplicated .= "<td class='i14'>$user</td>";
          $htmlDuplicated .= "</tr>";
        }
        $k++;
      }
    }
  }
}

unlink($uploadfile);  // 파일삭제

$countAllData=$countAllData-3;// 제목줄 제외
$outUploadReport = "<tr><td colspan='16'>총 $countAllData 건 / 성공 $numSuccessed 건 / 중복 $numDuplicated 건<td></tr>";
$outUploadReport .= $htmlDuplicated;
$outUploadReport .= $html;
echo $outUploadReport;

?>