<?php
  include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");
  include($_SERVER['DOCUMENT_ROOT'] . "/vendor/autoload.php");
?>
<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="../../semantic/semantic.min.css">
  <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
  <script src="../../semantic/semantic.min.js"></script>

  <title>SCSOL ERP</title>

  <link rel="shortcut icon" href="../image/construction.png">
  <script src="../js/scsolerp.js" defer></script>
  <link rel="stylesheet" href="../css/scsolerp.css">

</head>

<body>
  <!--borderless-->
  <div class="ui visible inverted left vertical sidebar menu">
    <div class="ui accordion inverted">

      <a class="item title spt" name="spt"><i class="cogs icon"></i>자재관리</a>
      <div class="content spt" name="content_spt">
        <a class="item menu_list spt_int">등록</a>
        <a class="item menu_list spt_srh borderless">조회</a>
      </div>

      <a class="item title trad" name="trad"><i class="fas list alternate outline icon"></i>구매관리</a>
      <div class="content trad" name="content_trad">
        <a class="item menu_list trad_int">등록</a>
        <a class="item menu_list trad_srh borderless">조회</a>
      </div>

      <a class="item title prdtMgt" name="prdtMgt"><i class="tasks icon"></i>생산관리</a>
      <div class="menu prdtMgt" name="content_prdtMgt">
        <div class="accordion transition hidden">
          <a class="item title modem" name="modem">모뎀</a>
          <div class="content subItem modem" name="content_modem">
            <a class="item menu_list modem_int">등록</a>
            <a class="item menu_list modem_srh borderless">조회</a>
          </div>

          <a class="item title pcba" name="pcba">PCB</a>
          <div class="content subItem pcba" name="content_pcba">
            <a class="item menu_list pcba_int">등록</a>
            <a class="item menu_list pcba_srh borderless">조회</a>
          </div>

          <a class="item title sensor" name="sensor">SENSOR</a>
          <div class="content subItem sensor" name="content_sensor">
            <a class="item menu_list sensor_int">등록</a>
            <a class="item menu_list sensor_srh borderless">조회</a>
          </div>

          <a class="item title batt" name="batt">BATTERY</a>
          <div class="content subItem batt" name="content_batt">
            <a class="item menu_list batt_int">등록</a>
            <a class="item menu_list batt_srh borderless">조회</a>
          </div>

          <a class="item title prdt" name="prdt">제품생산</a>
          <div class="content subItem prdt" name="content_prdt">
            <a class="item menu_list prdt_int">등록</a>
            <a class="item menu_list prdt_srh borderless">조회</a>
          </div>
        </div>  
      </div>      

      <a class="item title info" name="info"><i class="search icon"></i>제품정보</a>
      <div class="content info" name="content_info">
        <a class="item menu_list info_leak">누수센서</a>
        <a class="item menu_list info_motor borderless">진동센서</a>
        <a class="item menu_list info_current borderless">전류센서</a>
      </div>

    </div>    
    <div class="item title madeby">&copy;2021 JH SUNG</div>
  </div>

  <div class="ui container">
    <p><img class="mainView" src='../image/SCSOLUTION GLOBAL.png'></p>    
  </div>

</body>

</html>