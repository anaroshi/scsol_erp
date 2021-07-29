<?php
$page = $_GET['page'] ? intval($_GET['page']) : 1;

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_product.php");

$LIST_SIZE = 32;
$MORE_PAGE = 3;
if($page>1) {
  $i = ($page-1) * $LIST_SIZE;
} else {
  $i = 0;
}
$prdtList = "";


/**
 * 생산 상태 : used
 */

$sql = "SELECT * FROM step_product WHERE finalState ='P'";
if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}
$finalNum = mysqli_num_rows($result);

$sql = "SELECT * FROM step_product";
if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}
$num = mysqli_num_rows($result);

$sql = "SELECT CEIL( COUNT(*) / $LIST_SIZE ) as page_count FROM step_product ";
if(!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}
$row = mysqli_fetch_assoc($result);
$page_count = $row['page_count'];


$start_page = max($page - $MORE_PAGE, 1);
$end_page   = min($page + $MORE_PAGE, $page_count);
$prev_page  = max($start_page - $MORE_PAGE - 1, 1);
$next_page  = min($end_page + $MORE_PAGE + 1, $page_count);

$offset     = ($page - 1) * $LIST_SIZE;

/**
 * 생산정보 List
 */
$sql = "SELECT * FROM step_product ";
$sql .= "order by id ";
$sql .= "LIMIT $offset, $LIST_SIZE ";

// $id                               1. id
// $part_id                          2. 생산코드
// $supplierSn                       3. Serial No
// $usim                             4. USIM No
// $phone_no                         5. PHONE No
// $rate                             6. 요금제
// $monthlyFee                       7. 약정
// $tradDate                         8. 가입(입고)일자
// $tradId                           9. 입고 번호    
// $status                           10. 상태
// $product                          11. product
// $product_cd                       12. product code
// $version                          13. version
// $sn                               14. sn
// $comment                          15. 비고
// $etc                              16. 기타
// $user                             17. user
// $inDate                           18. 입력일
// $reuser                           29. 수정자
// $reDate                           30. 수정일


/*
scsol_sn
phone_no
pcba_sn
sensor_sn
battery_sn
case_sn
flag
user
inDate
reuser
reDate

*/


if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$total = "완품". number_format($finalNum)."대 / ".number_format($num)."대";

while ($row = mysqli_fetch_array($result)) {
  
  $i++;
  $id                   = $row['id'];                    
  $scsol_sn             = $row['scsol_sn'];                    
  $phone_no             = $row['phone_no'];                    
  $pcba_sn              = $row['pcba_sn'];      
  $sensor_sn            = $row['sensor_sn'];        
  $battery_sn           = $row['battery_sn'];        
  $case_sn              = $row['case_sn'];
  $fwVersion            = $row['fw_version'];
  $flag                 = $row['flag'];  
  $status               = $row['status'];  
  $finalState           = $row['finalState'];  
  $user                 = $row['user'];  
  $inDate               = $row['inDate'];    
  $reuser               = $row['reuser'];    
  $reDate               = $row['reDate'];
  if($reDate == "") {
    $reuser = $user;
    $reDate = $inDate;
  }

  if($status=="not used") {    
    $prdtList .= "<tr class='tr_prdt tr_notUsed'>";
  } else {
    $prdtList .= "<tr class='tr_prdt'>";
  }

  $prdtList .= "
      <td class ='d_prdt d_id' data-id='$id'>$i</td>
      <td class ='d_prdt d_scsol_sn'>$scsol_sn</td>
      <td class ='d_prdt d_prdt_sn d_phone_no'>$phone_no</td>
      <td class ='d_prdt d_prdt_sn d_usim'>$pcba_sn </td>
      <td class ='d_prdt d_prdt_sn d_rate'>$sensor_sn</td>
      <td class ='d_prdt d_prdt_sn d_monthlyFee'>$battery_sn</td>
      <td class ='d_prdt d_fwVersion'>$fwVersion</td>
      <td class ='d_prdt d_inDate'>$inDate</td>
      <td class ='d_prdt d_status'>$status</td>
      <td class ='d_prdt d_finalState'>$finalState</td>
      <td class ='d_prdt d_reDate'>$reDate</td>
      <td class ='d_prdt d_reuser'>$reuser</td>
    </tr>
    ";
}
$prdtList .= "<tr><td colspan='24' style='height: 20px;'></td></tr>";
$conn_11->close();

$outputPage = "";
// Paging
if ($start_page > 1) {
  $outputPage .= "
    <a href='$PHP_SELP?page=$prev_page' class='move_btn'>◀ 이전 </a>
    <a href='$PHP_SELP?page=1' class='pagenum'>1</a> ...
  ";
} else {
  $outputPage .= "<span class='move_btn disabled'>◀ 이전 </span>";
}

for ($p = $start_page; $p <= $end_page; $p++) {
  // $outputPage .= "<a href='$PHP_SELP?page=$p' class='pagenum ";
  // ($p == $page) ? $outputPage .= "current'><span style='color:red;'> $p </span></a>" : $outputPage .= "'> $p </a>";
 
  ($p == $page) ? 
  $outputPage .= "<span style='color:black;'> $p </span></a>" : 
  $outputPage .= "<a href='$PHP_SELP?page=$p' class='pagenum '> $p </a>";
}

if ($end_page < $page_count) {
  $outputPage .= " 
    ... <a href='$PHP_SELP?page=$page_count' class='pagemun'>$page_count</a>
    <a href='$PHP_SELP?page=$next_page' class='move_btn'> 다음 ▶</a>
  ";
} else {
  $outputPage .= "<span class='move_btn disabled'> 다음 ▶</span>";
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

    <link href='../../../bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
    <script src='../../../bootstrap/js/bootstrap.bundle.min.js' type='text/javascript'></script>
    <title>생산관리</title>
    <link rel="shortcut icon" href="../image/router.png">
    <script src="../js/prdt_search.js" defer></script>
    <link rel="stylesheet" href="../css/prdt.css">
  </head>
  <body>
    
  <!------------------ Modal ------------------>   
    <div class="modal fade" id="empModal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">생산 세부 정보</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">

          </div>
          <div class="modal-footer">
            <button type='button' class='btn btn-outline-dark btn-sm prdt_mdy_save'>수정</button>
            <button type='button' class='btn btn-outline-dark btn-sm prdt_mdy_delete'>삭제</button>
            <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!------------------ Modal ------------------>    

    <div class="container">
      <nav id="prdt_up" class="prdt_up">
        
        <div class="prdt_all_btn">
          <input type="button" class="prdt_btn prdt_clear" value="초기화">
          <input type="button" class="prdt_btn prdt_search" value="조회">
          <input type="button" class="prdt_btn prdt_excel" value="엑셀 다운로드">
        </div>

        <div class="prdt_space"></div>

        <div class="prdt_head">
          <div class="prdt_head_each">
            <label for='sn'>SN</label>
            <input type="text" class="prdt_input prdt_sn">
          </div>
          <div class="prdt_head_each">
            <label for='tradDate'>생산일자</label>
            <input type="date" class="prdt_input prdt_tradDateFrom" name="" id=""> ~  
            <input type="date" class="prdt_input prdt_tradDateTo" name="" id="">
          </div>
          <div class="prdt_head_each">
            <label for='status'>상태</label>
            <select name="" id="" class="prdt_input prdt_status">
              <option value="0"></option>
              <option value="1">used</option>
              <option value="2">not used</option>
            </select>
          </div>
          <div class="prdt_head_each">
            <label for='product'>PRODUCT</label>
            <select name="" id="" class="prdt_input prdt_product">
              <?php echo $outputPdt ?>
            </select>
          </div>
          <div class="prdt_head_each">
            <label for='finalState'>FINAL</label>
            <select name="" id="" class="prdt_input prdt_finalState">
              <option value="0"></option>
              <option value="P">P</option>
              <option value="F">F</option>
            </select>
          </div>
          <div class="prdt_head_total"> <?php echo $total ?></div>
        </div>
      </nav>

      <div class="prdt_down">
        <table class='prdt'>
          <thead class='th_prdt'>
            <th class='h_prdt h_prdt_b h_id'>id</th>
            <th class='h_prdt h_prdt_b h_sn h_scsol_sn'>scsol_sn</th>
            <th class='h_prdt h_prdt_b h_sn h_phone_no'>phone_no</th>
            <th class='h_prdt h_prdt_b h_sn h_pcba_sn'>pcba_sn</th>          
            <th class='h_prdt h_prdt_b h_sn h_sensor_sn'>sensor_sn</th>
            <th class='h_prdt h_prdt_b h_sn h_battery_sn'>battery_sn</th>
            <th class='h_prdt h_prdt_b h_sn h_fwVersion'>FirmwareVersion</th>
            <th class='h_prdt h_prdt_b h_inDate'>productionDate</th>
            <th class='h_prdt h_prdt_b h_status'>status</th>
            <th class='h_prdt h_prdt_b h_finalState'>finalState</th>
            <th class='h_prdt h_prdt_b h_reDate'>수정일</th>
            <th class='h_prdt h_prdt_b h_reuser'>담당자</th>
          </thead>
          <tbody class='tb_prdt'>
            <?php echo $prdtList ?>
          </tbody>

          <tfoot class='paging_area'>            
            <tr>
              <td colspan='24' class='paging' style="text-align:center;"><?php echo $outputPage ?></td>
            </tr>            
          </tfoot>

        <table>
      </div>  
    </div>
  </body>
</html>
