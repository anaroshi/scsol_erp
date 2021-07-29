<?php

$page = $_GET['page'] ? intval($_GET['page']) : 1;

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

$LIST_SIZE = 35;
$MORE_PAGE = 3;

/**
 * 센서 상태 : used
 */

$sql = "SELECT * FROM trad_part_sensor WHERE flag != 4 and status='used'";
if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql."<br>");
}

$usedNum = mysqli_num_rows($result);

/**
 * 센서 totalCnt
 */
$sql     = "SELECT count(*) totalCnt FROM trad_part_sensor ";
$sql    .= "WHERE flag !=4 ";
if(!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11). " query: ".$sql);
}
$row    = mysqli_fetch_assoc($result);
$totalCnt = $row['totalCnt'];


/**
 * 센서정보 List
 */

$sql  = "SELECT CEIL( COUNT(*) / $LIST_SIZE ) as page_count FROM trad_part_sensor WHERE flag != 4 ";
$sql .= "ORDER BY id";

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

$sql = "SELECT * FROM trad_part_sensor WHERE flag != 4 ";
$sql .= "ORDER BY id ";
$sql .= "LIMIT $offset, $LIST_SIZE ";

// $id                               1. id
// $sensor_sn                        2. sensor_sn
// $part_id                          3. 품목id
// $tradDate                         4. 입고일자
// $tradId                           5. 입고 번호
// $status                           6. 상태(used/not used)
// $sn                               7. sn
// $hz_sh1		                        8. 600Hz - 1
// $hz_sh2		                        9. 600Hz - 2
// $hz_sh3		                       10. 600Hz - 3
// $hz_eh1		                       11. 800Hz - 1
// $hz_eh2		                       12. 800Hz - 2
// $hz_eh3		                       13. 800Hz - 3
// $hz_tt1		                       14. 1000Hz - 1
// $hz_tt2		                       15. 1000Hz - 2
// $hz_tt3		                       16. 1000Hz - 3
// $hz_tw1		                       17. 1200Hz - 1
// $hz_tw2		                       18. 1200Hz - 2
// $hz_tw3		                       19. 1200Hz - 3
// $hz_mx1		                       20. MIXHz - 1
// $hz_mx2		                       21. MIXHz - 2
// $hz_mx3		                       22. MIXHz - 3
// $hz_fh1		                       23. DUMPHz - 1
// $hz_fh2		                       24. DUMPHz - 2
// $hz_fh3		                       25. DUMPHz - 3
// $conclusion		                   26. 종합판정
// $issue		                         27. ISSUE
// $comment                          28. 비고
// $etc                              29. 기타
// $user                             30. user
// $inDate                           31. 입력일
// $reuser                           32. 수정자
// $reDate                           33. 수정일

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql."<br>");
}

$num = mysqli_num_rows($result);
$total = "used ". number_format($usedNum)."대 / ".number_format($totalCnt)."대";

if ($page > 1) {
  $i = ($page-1) * $LIST_SIZE;
} else {
  $i = 0;
}
while ($row = mysqli_fetch_array($result)) {
  $i++;
  $id                     = $row['id'];
  $sensor_sn              = $row['sensor_sn'];
  $part_id                = $row['part_id'];
  $tradDate               = $row['tradDate'];
  $tradId                 = $row['tradId'];
  $status                 = $row['status'];
  $validity               = $row['validity'];
  $sn                     = $row['sn'];
  $hz_mix_fhAvg           = sprintf('%0.1f', $row['hz_mix_fhAvg']);
  $hz_mix_shAvg           = sprintf('%0.1f', $row['hz_mix_shAvg']);
  $hz_mix_ehAvg           = sprintf('%0.1f', $row['hz_mix_ehAvg']);
  $hz_mix_ttAvg           = sprintf('%0.1f', $row['hz_mix_ttAvg']);
  $hz_mix_twAvg           = sprintf('%0.1f', $row['hz_mix_twAvg']);
  $hz_fhAvg               = sprintf('%0.1f', $row['hz_fhAvg']);
  $hz_shAvg               = sprintf('%0.1f', $row['hz_shAvg']);
  $hz_ehAvg               = sprintf('%0.1f', $row['hz_ehAvg']);
  $hz_ttAvg               = sprintf('%0.1f', $row['hz_ttAvg']);
  $hz_twAvg               = sprintf('%0.1f', $row['hz_twAvg']);
  $conclusion             = $row['conclusion'];
  $issue                  = $row['issue'];
  $comment                = $row['comment'];
  $etc                    = $row['etc'];
  $image_1                = $row['image_1'];
  $image_2                = $row['image_2'];
  $image_3                = $row['image_3'];
  $inDate                 = $row['inDate'] ?? "";
  $user                   = $row['user'] ?? "";
  $reDate                 = $row['reDate'] ?? "";
  $reuser                 = $row['reuser'] ?? "";
  if($reDate=='') {
    $reuser = $user;
    $reDate = $inDate;
  }
  
  if($validity=="N") {    
    $sensorList .= "<tr class='tr_sensor tr_validity_N'>";
  } else if($status=="used") {    
    $sensorList .= "<tr class='tr_sensor tr_status_used'>";
  } else {
    $sensorList .= "<tr class='tr_sensor'>";
  }

  $sensorList .= "
      <td class='d_sensor d_id' data-id='$no'>$i</td>
      <td class='d_sensor d_id' data-id='$id' hidden>$id</td>
      <td class='d_sensor d_sensor_sn' name='d_sensor_sn'>$sensor_sn</td>
      <td class='d_sensor d_tradDate'>$tradDate</td>
      <td class='d_sensor d_tradId'>$tradId</td>
      <td class='d_sensor d_status'>$status</td>
      <td class='d_sensor d_validity'>$validity</td>
      <td class='d_sensor d_sn'>$sn</td>
      <td class='d_sensor d_hz_mix_fhAvg'>$hz_mix_fhAvg</td>
      <td class='d_sensor d_hz_mix_shAvg'>$hz_mix_shAvg</td>
      <td class='d_sensor d_hz_mix_ehAvg'>$hz_mix_ehAvg</td>
      <td class='d_sensor d_hz_mix_ttAvg'>$hz_mix_ttAvg</td>
      <td class='d_sensor d_hz_mix_twAvg'>$hz_mix_twAvg</td>
      <td class='d_sensor d_hz_fhAvg'>$hz_fhAvg</td>
      <td class='d_sensor d_hz_shAvg'>$hz_shAvg</td>
      <td class='d_sensor d_hz_ehAvg'>$hz_ehAvg</td>
      <td class='d_sensor d_hz_ttAvg'>$hz_ttAvg</td>
      <td class='d_sensor d_hz_twAvg'>$hz_twAvg</td>
      <td class='d_sensor d_conclusion'>$conclusion</td>
      <td class='d_sensor d_issue'>$issue</td>
      <td class='d_sensor d_comment'>$comment</td>
      <td class='d_sensor d_etc'>$etc</td>
      <td class='d_sensor d_image_1'>$image_1</td>
      <td class='d_sensor d_image_2'>$image_2</td>
      <td class='d_sensor d_image_3'>$image_3</td>
      <td class='d_sensor d_reDate'>$reDate</td>
      <td class='d_sensor d_reuser'>$reuser</td>
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
    <!-- <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


    <script src="../../../semantic/semantic.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

    <link href='../../../bootstrap/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
    <script src='../../../bootstrap/js/bootstrap.bundle.min.js' type='text/javascript'></script>
    <title>센서관리</title>
    <link rel="shortcut icon" href="../image/router.png">
    <script src="../js/sensor_search.js" defer></script>
    <link rel="stylesheet" href="../css/sensor.css">
  </head>
  <body>
    
  <!------------------ Modal ------------------>   
    <div class="modal fade" id="empModal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">센서 세부 정보</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">

          </div>
          <div class="modal-footer">
            <button type='button' class='btn btn-outline-dark btn-sm sensor_mdy_save'>수정</button>
            <button type='button' class='btn btn-outline-dark btn-sm sensor_mdy_delete'>삭제</button>
            <button type="button" class="btn btn-outline-dark btn-sm" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!------------------ Modal ------------------>
    
    <div class="container">
      <nav id="sensor_up" class="sensor_up">
        
        <div class="sensor_srh sensor_all_btn">
          <input type="button" class="sensor_btn sensor_clear" value="초기화">
          <input type="button" class="sensor_btn sensor_search" value="조회">
          <input type="button" class="sensor_btn sensor_excel" value="엑셀 다운로드">
          <input type="button" class="sensor_btn sensor_extract" value="데이터 추출">
        </div>

        <div class="sensor_space"></div>

        <div class="sensor_head">
          <div class="sensor_head_each">
            <label for='sn'>SN</label>
            <input type="text" class="sensor_input sensor_sn">
          </div>
          <div class="sensor_head_each">
            <label for='tradDate'>가입일자</label>
            <input type="date" class="sensor_input sensor_tradDateFrom" name="" id=""> ~  
            <input type="date" class="sensor_input sensor_tradDateTo" name="" id="">
          </div>
          <div class="sensor_head_each">
            <label for='status'>상태</label>
            <select name="" id="" class="sensor_input sensor_status">
              <option value="0"></option>
              <option value="1">used</option>
              <option value="2">not used</option>
            </select>
          </div>
          <div class="sensor_head_each">
            <label for='validity'>정상여부</label>
            <select name="" id="" class="sensor_input sensor_validity">
              <option value="0"></option>
              <option value="1">Y</option>
              <option value="2">N</option>
            </select>
          </div>
          <div class="sensor_head_part_id"> part_id : <?php echo $part_id ?></div>
          <div class="sensor_head_total"> <?php echo $total ?></div>
        </div>
      </nav>

      <div class="sensor_down">
        <table class='sensor'>
          <thead class='th_sensor'>            
            <tr class='th_sensor'>
              <th class='h_sensor h_sensor_b h_id' rowspan='3'>ID</th>

              <th class='h_sensor h_sensor_b h_sensor_sn' rowspan='3' name='sn_asc'>SENSOR_SN</th>
              <th class='h_sensor h_sensor_b h_tradDate' rowspan='3'>입고일자</th>
              <th class='h_sensor h_sensor_b h_tradId' rowspan='3'>입고번호</th>
              <th class='h_sensor h_sensor_b h_status' rowspan='3'>상태</th>
              <th class='h_sensor h_sensor_b h_validity' rowspan='3'>정상</th>
              <th class='h_sensor h_sensor_b h_sn' rowspan='3'>SCSOL S/N</th>
              <th class='h_sensor h_sensor_b h_checklist' colspan='12'>CHECK LIST</th>
              <th class='h_sensor h_sensor_b h_comment' rowspan='3'>비고</th>
              <th class='h_sensor h_sensor_b h_etc' rowspan='3'>기타</th>
              <th class='h_sensor h_sensor_b h_image' colspan='3'>이미지</th>
              <th class='h_sensor h_sensor_b h_reDate' rowspan='3'>수정일</th>
              <th class='h_sensor h_sensor_b h_reuser' rowspan='3'>담당자</th>
            </tr>
            <tr>              
              <th class='h_sensor h_sensor_b h_hz_mix' colspan='5'>MIX ( Hz )</th>
              <th class='h_sensor h_sensor_b h_hz_400' colspan='5'>SINGLE ( Hz )</th>
              <th class='h_sensor h_sensor_b h_conclusion'>종합판정</th>
              <th class='h_sensor h_sensor_b h_issue' rowspan='2'>ISSUE</th>
              <th class='h_sensor h_sensor_b h_image_1' rowspan='2'>400-mix</th>
              <th class='h_sensor h_sensor_b h_image_2' rowspan='2'>600-800</th>
              <th class='h_sensor h_sensor_b h_image_3' rowspan='2'>1,000-1,200</th>
            </tr>
            <tr>              
              <th class='h_sensor h_sensor_b h_hz_mix_fh'>400</th>
              <th class='h_sensor h_sensor_b h_hz_mix_sh'>600</th>
              <th class='h_sensor h_sensor_b h_hz_mix_eh'>800</th>
              <th class='h_sensor h_sensor_b h_hz_mix_tt'>1000</th>
              <th class='h_sensor h_sensor_b h_hz_mix_tw'>1200</th>
              <th class='h_sensor h_sensor_b h_hz_400'>400</th>
              <th class='h_sensor h_sensor_b h_hz_600'>600</th>
              <th class='h_sensor h_sensor_b h_hz_800'>800</th>
              <th class='h_sensor h_sensor_b h_hz_1000'>1000</th>
              <th class='h_sensor h_sensor_b h_hz_1200'>1200</th>
              <th class='h_sensor h_sensor_b h_conclusion_pf'>P/F</th>
            </tr>            
          </thead>

          <tbody class='tb_sensor'>
            <?php echo $sensorList ?>
          </tbody>
          
          <tfoot class='paging_area'>
            <tr><td colspan='24' style="height: 5px;"></td></tr>
            <tr>
              <td colspan='24' class='paging' style="text-align:center;"><?php echo $outputPage ?></td>
            </tr>
          </tfoot>

        <table>
      </div>  
    </div>
  </body>
</html>