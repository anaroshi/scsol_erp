<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <title>PCBA관리</title>
  <link rel="shortcut icon" href="../image/router.png">
  <script src="../js/pcba_insert.js"></script>
  <link rel="stylesheet" href="../css/pcba.css">
</head>
<body>
  <div class="container">
    <nav id="pcba_up" class="pcba_up">
      
      <div class="pcba_int pcba_all_btn">        
        <div>
          <form id="loadExcel">
              <input type="file" class="pcba_file" name="pcba_readfile" id="pcba_readfile" accept=".xls,.xlsx" required/>
              <input type="submit" class="pcba_btn pcba_upload" value="엑셀 업로드" name="submit" id="submit">
              <input type="button" class="pcba_btn pcba_uploadSample" value="업로드용 샘플">
          </form>
        </div>
        <div>
          <input type="button" class="pcba_btn pcba_clear" value="초기화">
        </div>     
      </div>

      <div class="pcba_space"></div>
    </nav>

    <div class="pcba_down">
      <table class='pcba'>
        <thead class='th_pcba'>
          <tr>
            <th class='h_pcba h_id' rowspan="2">id</th>
            <th class='h_pcba h_pcba_sn' rowspan="2">PCB_SN</th>
            <th class='h_pcba h_tradDate' rowspan="2">VERSION</th>
            <th class='h_pcba h_tradId' rowspan="2">입고일자</th>
            <th class='h_pcba h_version' rowspan="2">입고번호</th>
            <th class='h_pcba h_type' rowspan="2">TYPE</th>
            <th class='h_pcba h_status' rowspan="2">상태</th>
            <th class='h_pcba h_validity' rowspan="2">정상</th>
            <th class='h_pcba h_sn' rowspan="2">SCSOL S/N</th>
            <th class='h_pcba h_checklist' colspan="11">CHECK LIST</th>
            <th class='h_pcba h_comment' rowspan="2">비고</th>
            <th class='h_pcba h_etc' rowspan="2">기타</th>
            <th class='h_pcba h_img_radio'>RADIO</th>
            <th class='h_pcba h_img_adc'>ADC</th>
            <th class='h_pcba h_user' rowspan="2">담당자</th>
          </tr>
          <tr>              
            <th class='h_pcba h_hostcnt'>HOST</th>
            <th class='h_pcba h_mcucnt'>MCU</th>
            <th class='h_pcba h_modemcnt'>MODEM</th>
            <th class='h_pcba h_battcnt'>BATTERY</th>
            <th class='h_pcba h_ssorcnt'>SENSOR</th>
            <th class='h_pcba h_ldo'>LDO</th>
            <th class='h_pcba h_radio'>RADIO</th>
            <th class='h_pcba h_buz'>BUZ</th>
            <th class='h_pcba h_adc'>ADC</th>
            <th class='h_pcba h_memory'>MEMORY</th>
            <th class='h_pcba h_issue'>ISSUE</th>
            <th class='h_pcba h_img_radio'>이미지</th>
            <th class='h_pcba h_img_adc'>이미지</th>
          </tr>
        </thead>

        <tbody class='tb_pcba'>
        </tbody>
      <table>
    </div>  
  </div>
</body>
</html>