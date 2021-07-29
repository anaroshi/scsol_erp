<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

$page = $_GET['page'] ? intval($_GET['page']) : 1;

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

$LIST_SIZE = 35;
$MORE_PAGE = 3;

/**
 * batt 상태 : used
 */
$battList = "";
$sql = "SELECT * FROM trad_part_battery WHERE flag != 4 and status='used'";
if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$usedNum = mysqli_num_rows($result);

/**
 * batt정보 List
 */
$sql = "SELECT CEIL( COUNT(*) / $LIST_SIZE ) as page_count FROM trad_part_battery WHERE flag != 4 ";

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

$sql  = "SELECT count(*) totalCnt FROM trad_part_battery WHERE flag != 4 ";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$row        = mysqli_fetch_assoc($result);
$totalCnt   = $row['totalCnt'];

$sql  = "SELECT * FROM trad_part_battery WHERE flag != 4 ";
$sql .= "ORDER BY id ";
$sql .= "LIMIT $offset, $LIST_SIZE ";

// $id                                1. id
// $batt_sn                           2. batt_sn
// $part_id                           3. 품목id
// $tradDate                          4. 입고일자
// $tradId                            5. 입고 번호
// $cellType                          6. cellType
// $cellSize                          7. cellSize
// $cellCap                           8  cellCap
// $cellFactory                       9. cellFactory
// $factory                           10. factory
// $status                            11. 상태(used/not used)
// $validity                          12. 정상여부
// $sn                                13. sn
// $voltage                           14. 배터리 전압
// $comment                           15. 비고
// $etc                               16. 기타
// $flag                              17. 구분 (0:초기저장, 2:수정, 4:삭제)
// $user                              18. 입력자
// $inDate                            19. 입력일
// $reuser                            20. 수정자
// $reDate                            21. 수정일

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$total = "used " . number_format($usedNum) . "대 / " . number_format($totalCnt) . "대";

  
if ($page > 1) {
  $i = ($page-1) * $LIST_SIZE;
} else {
  $i = 0;
}

while ($row = mysqli_fetch_array($result)) {
  $i++;
  $id                   = $row['id'];
  $batt_sn              = $row['battery_sn'];
  $part_id              = $row['part_id'];
  $tradDate             = $row['tradDate'];
  $tradId               = $row['tradId'];
  $cellType             = $row['cellType'];
  $cellSize             = number_format($row['cellSize']);
  $cellCap              = number_format($row['cellCap']);
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
  if($reDate == "") {
    $reuser = $user;
    $reDate = $inDate;
  }
 
  if($validity=="N") {    
    $battList .= "<tr class='tr_batt tr_validity_N'>";
  } else if($status=="used") {    
    $battList .= "<tr class='tr_batt tr_status_used'>";
  } else {
    $battList .= "<tr class='tr_batt'>";
  }

  $battList .= "
    <td class='d_batt d_id' data-id='$id'>$i</td>      
    <td class='d_batt d_batt_sn'>$batt_sn</td>
    <td class='d_batt d_tradDate'>$tradDate</td>
    <td class='d_batt d_tradId'>$tradId</td>
    <td class='d_batt d_cellType'>$cellType</td>
    <td class='d_batt d_cellSize'>$cellSize</td>
    <td class='d_batt d_cellCap'>$cellCap</td>
    <td class='d_batt d_cellFactory'>$cellFactory</td>
    <td class='d_batt d_factory'>$factory</td>
    <td class='d_batt d_status'>$status</td>
    <td class='d_batt d_validity'>$validity</td>
    <td class='d_batt d_sn'>$sn</td>
    <td class='d_batt d_voltage'>$voltage</td>
    <td class='d_batt d_comment'>$comment</td>
    <td class='d_batt d_etc'>$etc</td>
    <td class='d_batt d_reDate'>$reDate</td>
    <td class='d_batt d_reuser'>$reuser</td>
  </tr>
  ";
}

// Paging
$outputPage ="";
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
//INSERT INTO `trad_part_battery` (`id`, `battery_sn`, `part_id`, `tradDate`, `tradId`, `cellType`, `cellSize`, `cellCap`, `cellFactory`, `factory`, `status`, `validity`, `sn`, `voltage`, `comment`, `etc`, `flag`, `user`, `inDate`, `reuser`, `reDate`) VALUES (NULL, 'pcba-210222-0001', '', '2021-06-02', '500', 'Li-ION', '18650', '7000', '삼성', '파워랜드', 'not used', 'N', NULL, '0.0', NULL, NULL, '', 'admin', 'now()', NULL, NULL);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" type="text/css" href="../../../semantic/semantic.min.css">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
  <script src="../../../semantic/semantic.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

  <link href='../../../bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
  <script src='../../../bootstrap/js/bootstrap.bundle.min.js' type='text/javascript'></script>

  <title>batt관리</title>
  <link rel="shortcut icon" href="../image/router.png">
  <script src="../js/batt_srh.js" defer></script>
  <link rel="stylesheet" href="../css/batt.css">

</head>

<body>

  <!------------------ Modal ------------------>
  <div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">배터리 세부 정보</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type='button' class='btn btn-outline-dark btn-sm batt_mdy_save'>수정</button>
          <button type='button' class='btn btn-outline-dark btn-sm batt_mdy_delete'>삭제</button>
          <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!------------------ Modal ------------------>

  <div class="container">
    <nav id="batt_up" class="batt_up">
      
      <div class="batt_srh batt_all_btn">
        <input type="button" class="batt_btn batt_clear" value="초기화">
        <input type="button" class="batt_btn batt_search" value="조회">
        <input type="button" class="batt_btn batt_excel" value="엑셀 다운로드">
      </div>

      <div class="batt_space"></div>

      <div class="batt_head">
        <div class="batt_head_each">
          <label for='sn'>SN</label>
          <input type="text" class="batt_input batt_sn">
        </div>
        <div class="batt_head_each">
          <label for='tradDate'>입고일자</label>
          <input type="date" class="batt_input batt_tradDateFrom" name="" id=""> ~
          <input type="date" class="batt_input batt_tradDateTo" name="" id="">
        </div>
        <div class="batt_head_each">
          <label for='status'>상태</label>
          <select name="" id="" class="batt_input batt_status">
            <option value="0"></option>
            <option value="1">used</option>
            <option value="2">not used</option>
          </select>
        </div>
        <div class="batt_head_each">
          <label for='status'>정상여부</label>
          <select name="" id="" class="batt_input batt_validity">
            <option value="0"></option>
            <option value="1">Y</option>
            <option value="2">N</option>
          </select>
        </div>
        <div class="batt_head_part_id">part_id : <?php echo $part_id ?></div>
        <div class="batt_head_total"> <?php echo $total ?></div>
      </div>
    </nav>

    <div class="batt_down">
      <table class='batt'>
        <thead class='th_batt'>
          <tr>
            <th class='h_batt h_batt_b h_id' rowspan="2">id</th>
            <th class='h_batt h_batt_b h_batt_sn' rowspan="2">BATTERY_SN</th>
            <th class='h_batt h_batt_b h_tradDate' rowspan="2">입고일자</th>
            <th class='h_batt h_batt_b h_tradId' rowspan="2">입고번호</th>
            <th class='h_batt h_batt_b h_cellType' rowspan="2">CELL TYPE</th>
            <th class='h_batt h_batt_b h_cellSize' rowspan="2">CELL SIZE</th>
            <th class='h_batt h_batt_b h_cellCap'>CELL CAPACITY</th>
            <th class='h_batt h_batt_b h_cellFactory' rowspan="2">CELL 제조사</th>
            <th class='h_batt h_batt_b h_factory' rowspan="2">제조사</th>
            <th class='h_batt h_batt_b h_status' rowspan="2">상태</th>
            <th class='h_batt h_batt_b h_validity' rowspan="2">정상</th>
            <th class='h_batt h_batt_b h_sn' rowspan="2">SCSOL S/N</th>
            <th class='h_batt h_batt_b h_voltage'>배터리 전압</th>
            <th class='h_batt h_batt_b h_comment' rowspan="2">비고</th>
            <th class='h_batt h_batt_b h_etc' rowspan="2">기타</th>            
            <th class='h_batt h_batt_b h_reDate' rowspan="2">수정일</th>
            <th class='h_batt h_batt_b h_reuser' rowspan="2">담당자</th>
          </tr>
          <tr>
            <th class='h_batt h_batt_b h_cellCap'>(mA)</th>
            <th class='h_batt h_batt_b h_voltage'>(V)</th>
          </tr>
        </thead>

        <tbody class='tb_batt'>
          <?php echo $battList ?>
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

