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

$outputType = '';
$sql = "select product from scs_product order by sort";

$result = mysqli_query($conn_11, $sql);
$outputPdt .= '<option value = "000">&nbsp;</option>';
while ($row = mysqli_fetch_array($result)) {
  $outputPdt .= '<option value = "' . $row["product"] . '">' . $row["product"] . '</option>';
}

/**
 * PCBA 상태 : used
 */

$sql = "SELECT * FROM trad_part_pcba WHERE flag != 4 and status='used'";
if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$usedNum = mysqli_num_rows($result);

/**
 * PCBA정보 List
 */

$sql = "SELECT CEIL( COUNT(*) / $LIST_SIZE ) as page_count FROM trad_part_pcba WHERE flag != 4 ";

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

$sql  = "SELECT count(*) totalCnt FROM trad_part_pcba WHERE flag != 4 ";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$row  = mysqli_fetch_assoc($result);
$totalCnt = $row['totalCnt'];

$sql  = "SELECT * FROM trad_part_pcba WHERE flag != 4 ";
$sql .= "ORDER BY pcba_sn ";
$sql .= "LIMIT $offset, $LIST_SIZE ";
// echo($sql);

// $id                               1. id
// $pcba_sn                          2. pcba_sn
// $part_id                          3. 품목id
// $tradDate                         4. 입고일자
// $tradId                           5. 입고 번호
// $version                          6. version
// $type                             7. type
// $status                           8. 상태(used/not used)
// $sn                               9. sn
// $hostcnt                          10. 호스트커넥터
// $mcucnt                           11. MCU커넥터
// $modemcnt                         12. 모뎀커넥터
// $battcnt                          13. 배터리커넥터
// $ssorcnt                          14. 센서커넥터
// $ldo                              15. LDO
// $radio                            16. 라디오
// $buz                              17. 부저
// $adc                              18. ADC
// $memory                           19. 메모리
// $issue                            20. 이슈
// $comment                          21. Firmware Version
// $etc                              22. 기타
// $flag                             23. 구분 (0:초기저장, 2:수정, 4:삭제)
// $user                             24. user
// $inDate                           25. 입력일
// $reuser                           26. 수정자
// $reDate                           27. 수정일
// $img_radio                        28. 라디오 이미지
// $img_adc                          29. ADC 이미지


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
  $pcba_sn              = $row['pcba_sn'];
  $part_id              = $row['part_id'];
  $tradDate             = $row['tradDate'];
  $tradId               = $row['tradId'];
  $version              = $row['version'];
  $type                 = $row['type'];
  $status               = $row['status'];
  $validity             = $row['validity'];
  $sn                   = $row['sn'];
  $hostcnt              = $row['hostcnt'];
  $mcucnt               = $row['mcucnt'];
  $modemcnt             = $row['modemcnt'];
  $battcnt              = $row['battcnt'];
  $ssorcnt              = $row['ssorcnt'];
  $ldo                  = $row['ldo'];
  $radio                = $row['radio'];
  $buz                  = $row['buz'];
  $adc                  = $row['adc'];
  $memory               = $row['memory'];
  $issue                = $row['issue'];
  $comment              = $row['comment'];
  $etc                  = $row['etc'];
  $img_radio            = $row['img_radio'];
  // if($img_radio == 'radio.jpg') {
  //   $img_radio          = 'o';
  // } else {
  //   $img_radio          = '';
  // }
  $img_adc              = $row['img_adc'];
  // if($img_adc == 'adc.jpg') {
  //   $img_adc            = 'o';
  // } else {
  //   $img_adc            = '';
  // }
  $inDate                 = $row['inDate'] ?? "";
  $user                   = $row['user'] ?? "";
  $reDate                 = $row['reDate'] ?? "";
  $reuser                 = $row['reuser'] ?? "";
  if($reDate=='') {
    $reuser = $user;
    $reDate = $inDate;
  }

  if($validity=="N") {    
    $pcbaList .= "<tr class='tr_pcba tr_validity_N'>";
  } else if($status=="used") {    
    $pcbaList .= "<tr class='tr_pcba tr_status_used'>";
  } else {
    $pcbaList .= "<tr class='tr_pcba'>";
  }
  
  $pcbaList .= "
      <td class='d_pcba d_id' data-id='$id'>$i</td>      
      <td class='d_pcba d_pcba_sn' name='sn_asc'>$pcba_sn</td>
      <td class='d_pcba d_tradDate'>$tradDate</td>
      <td class='d_pcba d_tradId'>$tradId</td>
      <td class='d_pcba d_version'>$version</td>
      <td class='d_pcba d_type'>$type</td>
      <td class='d_pcba d_status'>$status</td>
      <td class='d_pcba d_validity'>$validity</td>
      <td class='d_pcba d_sn'>$sn</td>
      <td class='d_pcba d_hostcnt'>$hostcnt</td>
      <td class='d_pcba d_mcucnt'>$mcucnt</td>
      <td class='d_pcba d_modemcnt'>$modemcnt</td>
      <td class='d_pcba d_battcnt'>$battcnt</td>
      <td class='d_pcba d_ssorcnt'>$ssorcnt</td>
      <td class='d_pcba d_ldo'>$ldo</td>
      <td class='d_pcba d_radio'>$radio</td>
      <td class='d_pcba d_buz'>$buz</td>
      <td class='d_pcba d_adc' name='adc_asc'>$adc</td>
      <td class='d_pcba d_memory'>$memory</td>
      <td class='d_pcba d_issue' name='issue_asc'>$issue</td>
      <td class='d_pcba d_comment'>$comment</td>
      <td class='d_pcba d_etc'>$etc</td>
      <td class='d_pcba d_img_radio'>$img_radio</td>
      <td class='d_pcba d_img_adc'>$img_adc</td>
      <td class='d_pcba d_reDate'>$reDate</td>
      <td class='d_pcba d_reuser'>$reuser</td>
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

  <link rel="stylesheet" type="text/css" href="../../../semantic/semantic.min.css">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
  <script src="../../../semantic/semantic.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

  <link href='../../../bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
  <script src='../../../bootstrap/js/bootstrap.bundle.min.js' type='text/javascript'></script>

  <title>PCBA관리</title>
  <link rel="shortcut icon" href="../image/router.png">
  <script src="../js/pcba_search.js" defer></script>
  <link rel="stylesheet" href="../css/pcba.css">

</head>

<body>

  <!------------------ Modal ------------------>
  <div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">PCBA 세부 정보</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <button type='button' class='btn btn-outline-dark btn-sm pcba_mdy_save'>수정</button>
          <button type='button' class='btn btn-outline-dark btn-sm pcba_mdy_delete'>삭제</button>
          <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!------------------ Modal ------------------>

  <div class="container">
    <nav id="pcba_up" class="pcba_up">
      
      <div class="pcba_srh pcba_all_btn">
        <input type="button" class="pcba_btn pcba_clear" value="초기화">
        <input type="button" class="pcba_btn pcba_search" value="조회">
        <input type="button" class="pcba_btn pcba_excel" value="엑셀 다운로드">
      </div>

      <div class="pcba_space"></div>

      <div class="pcba_head">
        <div class="pcba_head_each">
          <label for='sn'>SN</label>
          <input type="text" class="pcba_input pcba_sn">
        </div>
        <div class="pcba_head_each">
          <label for='tradDate'>입고일자</label>
          <input type="date" class="pcba_input pcba_tradDateFrom" name="" id=""> ~
          <input type="date" class="pcba_input pcba_tradDateTo" name="" id="">
        </div>
        <div class="pcba_head_each">
          <label for='status'>상태</label>
          <select name="" id="" class="pcba_input pcba_status">
            <option value="0"></option>
            <option value="1">used</option>
            <option value="2">not used</option>
          </select>
        </div>
        <div class="pcba_head_each">
          <label for='validity'>정상여부</label>
          <select name="" id="" class="pcba_input pcba_validity">
            <option value="0"></option>
            <option value="1">Y</option>
            <option value="2">N</option>
          </select>
        </div>
        <div class="pcba_head_part_id">part_id : <?php echo $part_id ?></div>
        <div class="pcba_head_total"> <?php echo $total ?></div>
      </div>
    </nav>

    <div class="pcba_down">
      <table class='pcba'>
        <thead class='th_pcba'>
          <tr>
            <th class='h_pcba h_pcba_b h_id' rowspan="2">id</th>
            <th class='h_pcba h_pcba_b h_pcba_sn' rowspan="2">PCB_SN</th>
            <th class='h_pcba h_pcba_b h_tradDate' rowspan="2">입고일자</th>
            <th class='h_pcba h_pcba_b h_tradId' rowspan="2">입고번호</th>
            <th class='h_pcba h_pcba_b h_version' rowspan="2">VERSION</th>
            <th class='h_pcba h_pcba_b h_type' rowspan="2">TYPE</th>
            <th class='h_pcba h_pcba_b h_status' rowspan="2">상태</th>
            <th class='h_pcba h_pcba_b h_validity' rowspan="2">정상</th>
            <th class='h_pcba h_pcba_b h_sn' rowspan="2">SCSOL S/N</th>
            <th class='h_pcba h_pcba_b h_checklist' colspan="11">CHECK LIST</th>
            <th class='h_pcba h_pcba_b h_comment'>Firmware</th>
            <th class='h_pcba h_pcba_b h_etc' rowspan="2">기타</th>
            <th class='h_pcba h_pcba_b h_img_radio' colspan="2">이미지</th>
            <th class='h_pcba h_pcba_b h_reDate' rowspan="2">수정일</th>
            <th class='h_pcba h_pcba_b h_reuser' rowspan="2">담당자</th>
          </tr>
          <tr>
            <th class='h_pcba h_pcba_b h_hostcnt'>HOST</th>
            <th class='h_pcba h_pcba_b h_mcucnt'>MCU</th>
            <th class='h_pcba h_pcba_b h_modemcnt'>MODEM</th>
            <th class='h_pcba h_pcba_b h_battcnt'>BATTERY</th>
            <th class='h_pcba h_pcba_b h_ssorcnt'>SENSOR</th>
            <th class='h_pcba h_pcba_b h_ldo'>LDO</th>
            <th class='h_pcba h_pcba_b h_radio'>RADIO</th>
            <th class='h_pcba h_pcba_b h_buz'>BUZ</th>
            <th class='h_pcba h_pcba_b h_adc'>ADC</th>
            <th class='h_pcba h_pcba_b h_memory'>MEMORY</th>
            <th class='h_pcba h_pcba_b h_issue'>ISSUE</th>
            <th class='h_pcba h_pcba_b h_comment'>Version</th>
            <th class='h_pcba h_pcba_b h_img_radio'>RADIO</th>
            <th class='h_pcba h_pcba_b h_img_adc'>ADC</th>
          </tr>
        </thead>

        <tbody class='tb_pcba'>
          <?php echo $pcbaList ?>
        </tbody>

        <tfoot class='paging_area'>
          <tr><td colspan='24' style="height: 20px;"></td></tr>
          <tr>
            <td colspan='24' class='paging' style="text-align:center;"><?php echo $outputPage ?></td>
          </tr>
        </tfoot>

      <table>
    </div>
  </div>
</body>

</html>