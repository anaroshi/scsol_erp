<?php
$page = $_GET['page'] ? intval($_GET['page']) : 1;

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

$LIST_SIZE = 35;
$MORE_PAGE = 3;

/**
 * product
 * table : scs_product
 * $outputPdt
 * default : 공백, value : 000
 */

$outputPdt = '';
$sql = "select product from scs_product order by sort";

$result = mysqli_query($conn_11, $sql);
$outputPdt .= '<option value = "000">&nbsp;</option>';
while ($row = mysqli_fetch_array($result)) {
  $outputPdt .= '<option value = "' . $row["product"] . '">' . $row["product"] . '</option>';
}

/**
 * 모뎀 상태 : used
 */

$sql = "SELECT * FROM trad_part_modem WHERE flag != 4 and status='used'";
if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$usedNum = mysqli_num_rows($result);

/**
 * 모뎀정보 List
 */

$sql = "SELECT * FROM trad_part_modem WHERE flag != 4 ";
if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}
$num = mysqli_num_rows($result);


$sql = "SELECT CEIL( COUNT(*) / $LIST_SIZE ) as page_count FROM trad_part_modem WHERE flag != 4 ";
$sql .= "order by id";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$row = mysqli_fetch_row($result);
$page_count = $row[0];

//echo ("page_count : " . $page_count);

$start_page = max($page - $MORE_PAGE, 1);
$end_page   = min($page + $MORE_PAGE, $page_count);
$prev_page  = max($start_page - $MORE_PAGE - 1, 1);
$next_page  = min($end_page + $MORE_PAGE + 1, $page_count);

$offset     = ($page - 1) * $LIST_SIZE;


$sql = "SELECT * FROM trad_part_modem WHERE flag != 4 ";
$sql .= "order by id ";
$sql .= "LIMIT $offset, $LIST_SIZE ";


// $id                               1. id
// $part_id                          2. 모뎀코드
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


if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$total = "used ". number_format($usedNum)."대 / ".number_format($num)."대";

if ($page > 1) {
  $i = ($page-1) * $LIST_SIZE;
} else {
  $i = 0;
}

while ($row = mysqli_fetch_array($result)) {
  $i++;
  $id                   = $row['id'];
  $supplierSn           = $row['supplierSn'];
  $usim                 = $row['usim'];
  $phone_no             = $row['phone_no'];
  $rate                 = $row['rate'];
  $monthlyFee           = $row['monthlyFee'];
  $tradDate             = $row['tradDate'];
  $tradId               = $row['tradId'];
  $status               = $row['status'];
  $validity             = $row['validity'];
  $product              = $row['product'];
  $product_cd           = $row['product_cd'];
  $version              = $row['version'];
  $sn                   = $row['sn'];
  $comment              = $row['comment'];
  $etc                  = $row['etc'];
  $user                 = $row['user'];
  $inDate               = $row['inDate'];
  $reuser               = $row['reuser'];
  $reDate               = $row['reDate'];
  if($reDate=='') {
    $reuser = $user;
    $reDate = $inDate;
  }
 
  if($validity=="N") {    
    $modemList .= "<tr class='tr_modem tr_validity_N'>";
  } else if($status=="used") {    
    $modemList .= "<tr class='tr_modem tr_status_used'>";
  } else {
    $modemList .= "<tr class='tr_modem'>";
  }

  $modemList .= "
      <td class ='d_modem d_id' data-id='$id'>$i</td>
      <td class ='d_modem d_phone_no' name='phone_asc'>$phone_no</td>
      <td class ='d_modem d_supplierSn'>$supplierSn</td>
      <td class ='d_modem d_usim'>$usim </td>
      <td class ='d_modem d_rate'>$rate</td>
      <td class ='d_modem d_monthlyFee'>$monthlyFee</td>
      <td class ='d_modem d_tradDate'>$tradDate</td>
      <td class ='d_modem d_tradId'>$tradId</td>
      <td class ='d_modem d_status'>$status</td>
      <td class ='d_modem d_validity'>$validity</td>
      <td class ='d_modem d_product'>$product</td>
      <td class ='d_modem d_product_cd'>$product_cd</td>
      <td class ='d_modem d_version'>$version</td>
      <td class ='d_modem d_sn' name='sn_asc'>$sn</td>
      <td class ='d_modem d_comment'>$comment</td>
      <td class ='d_modem d_etc'>$etc</td>
      <td class ='d_modem d_reDate'>$reDate</td>
      <td class ='d_modem d_reuser'>$reuser</td>
    </tr>
    ";
}

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
    
    <title>모뎀관리</title>
    <link rel="shortcut icon" href="../image/router.png">
    <script src="../js/modem_search.js" defer></script>
    <link rel="stylesheet" href="../css/modem.css">
  </head>
  <body>
    
  <!------------------ Modal ------------------>   
    <div class="modal fade" id="empModal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">모뎀 세부 정보</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">

          </div>
          <div class="modal-footer">
            <button type='button' class='btn btn-outline-dark btn-sm modem_mdy_save'>수정</button>
            <button type='button' class='btn btn-outline-dark btn-sm modem_mdy_delete'>삭제</button>
            <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!------------------ Modal ------------------>    

    <div class="container">
      <nav id="modem_up" class="modem_up">
        
        <div class="modem_srh modem_all_btn">
          <input type="button" class="modem_btn modem_clear" value="초기화">
          <input type="button" class="modem_btn modem_search" value="조회">
          <input type="button" class="modem_btn modem_excel" value="엑셀 다운로드">
          <input type="button" class="modem_btn modem_loadSn" value="LEAK SERVER에서 SCSOL S/N 가져오기">
        </div>

        <div class="modem_space"></div>

        <div class="modem_head">
          <div class="modem_head_each">
            <label for='sn'>SN</label>
            <input type="text" class="modem_input modem_sn">
          </div>
          <div class="modem_head_each">
            <label for='tradDate'>가입일자</label>
            <input type="date" class="modem_input modem_tradDateFrom" name="" id=""> ~  
            <input type="date" class="modem_input modem_tradDateTo" name="" id="">
          </div>
          <div class="modem_head_each">
            <label for='status'>상태</label>
            <select name="" id="" class="modem_input modem_status">
              <option value="0"></option>
              <option value="1">used</option>
              <option value="2">not used</option>
            </select>
          </div>
          <div class="modem_head_each">
            <label for='validity'>정상여부</label>
            <select name="" id="" class="modem_input modem_validity">
              <option value="0"></option>
              <option value="1">Y</option>
              <option value="2">N</option>
            </select>
          </div>
          <div class="modem_head_each">
            <label for='product'>PRODUCT</label>
            <select name="" id="" class="modem_input modem_product">
              <?php echo $outputPdt ?>
            </select>
          </div>
          <div class="modem_head_total"> <?php echo $total ?></div>
        </div>
      </nav>

      <div class="modem_down">
        <table class='modem'>
          <thead class='th_modem'>
            <th class='h_modem h_modem_b h_id'>id</th>
            <th class='h_modem h_modem_b h_phone'>PHONE</th>
            <th class='h_modem h_modem_b h_supplierSn'>SERIAL</th>
            <th class='h_modem h_modem_b h_usim'>USIM</th>          
            <th class='h_modem h_modem_b h_rate'>요금제</th>
            <th class='h_modem h_modem_b h_monthlyFee'>약정</th>
            <th class='h_modem h_modem_b h_tradDate'>가입일자</th>
            <th class='h_modem h_modem_b h_tradId'>입고번호</th>
            <th class='h_modem h_modem_b h_status'>상태</th>
            <th class='h_modem h_modem_b h_validity'>정상</th>
            <th class='h_modem h_modem_b h_product'>PRODUCT</th>
            <th class='h_modem h_modem_b h_product_cd'>PRODUCT CODE</th>
            <th class='h_modem h_modem_b h_version'>VERSION</th>
            <th class='h_modem h_modem_b h_sn'>SCSOL S/N</th>
            <th class='h_modem h_modem_b h_comment'>비고</th>
            <th class='h_modem h_modem_b h_etc'>기타</th>
            <th class='h_modem h_modem_b h_reDate'>수정일</th>
            <th class='h_modem h_modem_b h_reuser'>담당자</th>
          </thead>
          <tbody class='tb_modem'>
            <?php echo $modemList ?>
          </tbody>

          <tfoot class='paging_area'>
            <tr><td colspan='24' style="height: 30px;"></td></tr>
            <tr>
              <td colspan='24' class='paging' style="text-align:center;"><?php echo $outputPage ?></td>
            </tr>
          </tfoot>

        <table>
      </div>  
    </div>
  </body>
</html>