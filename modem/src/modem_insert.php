<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <title>모뎀관리</title>
  <link rel="shortcut icon" href="../image/router.png">
  <script src="../js/modem_insert.js"></script>
  <link rel="stylesheet" href="../css/modem.css">
</head>

<body>
  <div class="container">
    <nav id="modem_up" class="modem_up">

      <div class="modem_int modem_all_btn">
        <div>
          <form id="loadExcel">
            <input type="file" class="modem_file" name="modem_readfile" id="modem_readfile" accept=".xls,.xlsx" required />
            <input type="submit" class="modem_btn modem_upload" value="엑셀 업로드" name="submit" id="submit">
            <input type="button" class="modem_btn modem_uploadSample" value="업로드용 샘플">            
          </form>
        </div>
        <div><span>*** 모뎀 입고 번호는 순번으로 처리 되어니 꼭 마지막 입고 번호 확인 후 업로드 바랍니다. ***</span></div>
        <div>
          <input type="button" class="modem_btn modem_clear" value="초기화">          
        </div>
      </div>

      <div class="modem_space"></div>
    </nav>

    <div class="modem_down">
      <table class='modem'>
        <thead class='th_modem'>
          <th class='h_modem h_id'>id</th>
          <th class='h_modem h_phone'>PHONE</th>
          <th class='h_modem h_supplierSn'>SERIAL</th>
          <th class='h_modem h_usim'>USIM</th>
          <th class='h_modem h_rate'>요금제</th>
          <th class='h_modem h_monthlyFee'>약정</th>
          <th class='h_modem h_tradDate'>가입일자</th>
          <th class='h_modem h_tradId'>입고번호</th>
          <th class='h_modem h_status'>상태</th>
          <th class='h_modem h_validity'>정상</th>
          <th class='h_modem h_product'>PRODUCT</th>
          <th class='h_modem h_product_cd'>PRODUCT CODE</th>
          <th class='h_modem h_version'>VERSION</th>
          <th class='h_modem h_lt'>SCSOL S/N</th>
          <th class='h_modem h_comment'>담당자</th>
        </thead>
        <tbody class='tb_modem'>
        </tbody>
        <table>
    </div>
  </div>
</body>

</html>