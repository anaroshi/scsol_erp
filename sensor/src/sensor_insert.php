<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <title>센서관리</title>
  <link rel="shortcut icon" href="../image/router.png">
  <script src="../js/sensor_insert.js"></script>
  <link rel="stylesheet" href="../css/sensor.css">
</head>
<body>
  <div class="container">
    <nav id="sensor_up" class="sensor_up">
      
      <div class="sensor_int sensor_all_btn">        
        <div>
          <form id="loadExcel">
              <input type="file" class="sensor_file" name="sensor_readfile" id="sensor_readfile" accept=".xls,.xlsx" required/>
              <input type="submit" class="sensor_btn sensor_upload"  value="엑셀 업로드" name="submit" id="submit">
              <input type="button" class="sensor_btn sensor_uploadSample" value="업로드용 샘플">
          </form>
        </div>
        <div>
          <input type="button" class="sensor_btn sensor_clear" value="초기화">
        </div>     
      </div>
      <div class="sensor_space"></div>
    </nav>

    <div class="sensor_down">
      <table class='sensor'>
        <thead class='th_sensor'>
        <tr>
            <th class='h_sensor h_sensor h_id' rowspan='4'>ID</th>
            <th class='h_sensor h_sensor h_sensor_sn' rowspan='4'>SENSOR_SN</th>
            <th class='h_sensor h_sensor h_tradDate' rowspan='4'>입고일자</th>
            <th class='h_sensor h_sensor h_tradId' rowspan='4'>입고번호</th>
            <th class='h_sensor h_sensor h_status' rowspan='4'>상태</th>
            <th class='h_sensor h_sensor h_validity' rowspan='4'>정상</th>
            <th class='h_sensor h_sensor h_sn' rowspan='4'>SCSOL S/N</th>
            <th class='h_sensor h_sensor h_checklist' colspan='32'>CHECK LIST</th>
            <th class='h_sensor h_sensor h_comment' rowspan='4'>비고</th>
            <th class='h_sensor h_sensor h_etc' rowspan='4'>기타</th>
            <th class='h_sensor h_sensor h_user' rowspan='4'>담당자</th>
          </tr>
          <tr>              
            <th class='h_sensor h_sensor h_hz_mix' colspan='15'>MIX ( Hz )</th>
            <th class='h_sensor h_sensor h_hz_400' colspan='15'>SINGLE ( Hz )</th>
            <th class='h_sensor h_sensor h_conclusion' rowspan='2'>종합판정</th>
            <th class='h_sensor h_sensor h_issue' rowspan='3'>ISSUE</th>
          </tr>
          <tr>              
            <th class='h_sensor h_sensor h_hz_mix_fh' colspan='3'>400</th>
            <th class='h_sensor h_sensor h_hz_mix_sh' colspan='3'>600</th>
            <th class='h_sensor h_sensor h_hz_mix_eh' colspan='3'>800</th>
            <th class='h_sensor h_sensor h_hz_mix_tt' colspan='3'>1000</th>
            <th class='h_sensor h_sensor h_hz_mix_tw' colspan='3'>1200</th>
            <th class='h_sensor h_sensor h_hz_400' colspan='3'>400</th>
            <th class='h_sensor h_sensor h_hz_600' colspan='3'>600</th>
            <th class='h_sensor h_sensor h_hz_800' colspan='3'>800</th>
            <th class='h_sensor h_sensor h_hz_1000' colspan='3'>1000</th>
            <th class='h_sensor h_sensor h_hz_1200' colspan='3'>1200</th>            
          </tr>
          <tr>              
            <th class='h_sensor h_sensor h_hz_mix_fh1'>1</th>
            <th class='h_sensor h_sensor h_hz_mix_fh2'>2</th>
            <th class='h_sensor h_sensor h_hz_mix_fh3'>3</th>
            <th class='h_sensor h_sensor h_hz_mix_sh1'>1</th>
            <th class='h_sensor h_sensor h_hz_mix_sh2'>2</th>
            <th class='h_sensor h_sensor h_hz_mix_sh3'>3</th>
            <th class='h_sensor h_sensor h_hz_mix_eh1'>1</th>
            <th class='h_sensor h_sensor h_hz_mix_eh2'>2</th>
            <th class='h_sensor h_sensor h_hz_mix_eh3'>3</th>
            <th class='h_sensor h_sensor h_hz_mix_tt1'>1</th>
            <th class='h_sensor h_sensor h_hz_mix_tt2'>2</th>
            <th class='h_sensor h_sensor h_hz_mix_tt3'>3</th>
            <th class='h_sensor h_sensor h_hz_mix_tw1'>1</th>
            <th class='h_sensor h_sensor h_hz_mix_tw2'>2</th>
            <th class='h_sensor h_sensor h_hz_mix_tw3'>3</th>
            <th class='h_sensor h_sensor h_hz_400-1'>1</th>
            <th class='h_sensor h_sensor h_hz_400-2'>2</th>
            <th class='h_sensor h_sensor h_hz_400-3'>3</th>
            <th class='h_sensor h_sensor h_hz_600-1'>1</th>
            <th class='h_sensor h_sensor h_hz_600-2'>2</th>
            <th class='h_sensor h_sensor h_hz_600-3'>3</th>
            <th class='h_sensor h_sensor h_hz_800-1'>1</th>
            <th class='h_sensor h_sensor h_hz_800-2'>2</th>
            <th class='h_sensor h_sensor h_hz_800-3'>3</th>
            <th class='h_sensor h_sensor h_hz_100-1'>1</th>
            <th class='h_sensor h_sensor h_hz_100-2'>2</th>
            <th class='h_sensor h_sensor h_hz_100-3'>3</th>
            <th class='h_sensor h_sensor h_hz_120-1'>1</th>
            <th class='h_sensor h_sensor h_hz_120-2'>2</th>
            <th class='h_sensor h_sensor h_hz_120-3'>3</th>
            <th class='h_sensor h_sensor h_conclusion_pf'>P/F</th>
          </tr>            
        </thead>
        <tbody class='tb_sensor'>
        </tbody>
      <table>
    </div>  
  </div>
</body>
</html>