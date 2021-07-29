<?php
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");
// error_reporting(E_ALL);
// ini_set("display_errors", 1);
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

  <title>배터리 정보 등록</title>
  <link rel="shortcut icon" href="../image/router.png">
  <script src="../js/batt_int.js" defer></script>
  <link rel="stylesheet" href="../css/batt.css">

</head>

<body>
  <div class="container">    
    <nav id="batt_up" class="batt_up">      
      <div class="batt_int batt_all_btn">        
        <div>
          <form id="loadExcel">
              <input type="file" class="batt_file" name="batt_readfile" id="batt_readfile" accept=".xls,.xlsx" required/>
              <input type="submit" class="batt_btn batt_upload" value="엑셀 업로드" name="submit" id="submit">
              <input type="button" class="batt_btn batt_uploadSample" value="업로드용 샘플">
          </form>          
        </div>
        <div>
          <input type="button" class="batt_btn batt_clear" value="초기화">
        </div>     
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
            <th class='h_batt h_batt_b h_inDate' rowspan="2">입력일</th>
            <th class='h_batt h_batt_b h_user' rowspan="2">담당자</th>         
          </tr>
          <tr>
            <th class='h_batt h_batt_b h_cellCap'>(mA)</th>
            <th class='h_batt h_batt_b h_voltage'>(V)</th>
          </tr>
        </thead>

        <tbody class='tb_batt'>
        </tbody>
      <table>
    </div>
  </div>
</body>

</html>

