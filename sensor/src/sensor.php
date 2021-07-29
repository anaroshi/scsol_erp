<?php

/**
 * 선택된 센서 Hz정보 List
 */

$id = trim($_POST["id"]);
$id = 3;
//echo("id : $id");

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

$sql = "SELECT * FROM trad_part_sensor WHERE flag != 4 and id = '$id' ";
$sql .= "order by id";

// $id                               1. id
// $sensor_sn                        2. sensor_sn
// $part_id                          3. 품목id
// $tradDate                         4. 입고일자
// $tradId                           5. 입고 번호
// $status                           6. 상태(used/not used)
// $sn                               7. sn
// $hz_sh1		                        8. 600Hz - 1
// $hz_sh2		                        9. 600Hz - 2
// $hz_sh3		                        10. 600Hz - 3
// $hz_eh1		                        11. 800Hz - 1
// $hz_eh2		                        12. 800Hz - 2
// $hz_eh3		                        13. 800Hz - 3
// $hz_tt1		                        14. 1000Hz - 1
// $hz_tt2		                        15. 1000Hz - 2
// $hz_tt3		                        16. 1000Hz - 3
// $hz_tw1		                        17. 1200Hz - 1
// $hz_tw2		                        18. 1200Hz - 2
// $hz_tw3		                        19. 1200Hz - 3
// $hz_mx1		                        20. MIXHz - 1
// $hz_mx2		                        21. MIXHz - 2
// $hz_mx3		                        22. MIXHz - 3
// $hz_fh1		                        23. DUMPHz - 1
// $hz_fh2		                        24. DUMPHz - 2
// $hz_fh3		                        25. DUMPHz - 3
// $conclusion		                    26. 종합판정
// $issue		                          27. ISSUE
// $comment                          28. 비고
// $etc                              29. 기타
// $user                             30. user
// $inDate                           31. 입력일
// $reuser                           32. 수정자
// $reDate                           33. 수정일

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$result && $row = mysqli_fetch_assoc($result);
  
$id                     = $row['id'];
$sensor_sn              = $row['sensor_sn'];
$part_id                = $row['part_id'];
$tradDate               = $row['tradDate'];
$tradId                 = $row['tradId'];
$status                 = $row['status'];
$sn                     = $row['sn'];
$hz_mix_fh1             = $row['hz_mix_fh1'];
$hz_mix_fh2             = $row['hz_mix_fh2'];
$hz_mix_fh3             = $row['hz_mix_fh3'];
$hz_mix_fhAvg           = $row['hz_mix_fhAvg'];
$hz_mix_sh1             = $row['hz_mix_sh1'];
$hz_mix_sh2             = $row['hz_mix_sh2'];
$hz_mix_sh3             = $row['hz_mix_sh3'];
$hz_mix_shAvg           = $row['hz_mix_shAvg'];
$hz_mix_eh1             = $row['hz_mix_eh1'];
$hz_mix_eh2             = $row['hz_mix_eh2'];
$hz_mix_eh3             = $row['hz_mix_eh3'];
$hz_mix_ehAvg           = $row['hz_mix_ehAvg'];
$hz_mix_tt1             = $row['hz_mix_tt1'];
$hz_mix_tt2             = $row['hz_mix_tt2'];
$hz_mix_tt3             = $row['hz_mix_tt3'];
$hz_mix_ttAvg           = $row['hz_mix_ttAvg'];
$hz_mix_tw1             = $row['hz_mix_tw1'];
$hz_mix_tw2             = $row['hz_mix_tw2'];
$hz_mix_tw3             = $row['hz_mix_tw3'];
$hz_mix_twAvg           = $row['hz_mix_twAvg'];
$hz_fh1                 = $row['hz_fh1'];
$hz_fh2                 = $row['hz_fh2'];
$hz_fh3                 = $row['hz_fh3'];
$hz_fhAvg               = $row['hz_fhAvg'];
$hz_sh1                 = $row['hz_sh1'];
$hz_sh2                 = $row['hz_sh2'];
$hz_sh3                 = $row['hz_sh3'];
$hz_shAvg               = $row['hz_shAvg'];
$hz_eh1                 = $row['hz_eh1'];
$hz_eh2                 = $row['hz_eh2'];
$hz_eh3                 = $row['hz_eh3'];
$hz_ehAvg               = $row['hz_ehAvg'];
$hz_tt1                 = $row['hz_tt1'];
$hz_tt2                 = $row['hz_tt2'];
$hz_tt3                 = $row['hz_tt3'];
$hz_ttAvg               = $row['hz_ttAvg'];
$hz_tw1                 = $row['hz_tw1'];
$hz_tw2                 = $row['hz_tw2'];
$hz_tw3                 = $row['hz_tw3'];
$hz_twAvg               = $row['hz_twAvg'];
$conclusion             = $row['conclusion'];
$issue                  = $row['issue'];
$comment                = $row['comment'];
$etc                    = $row['etc'];
$flag                   = $row['flag'];
$reDate                 = $row['reDate'];

$checkList ="
    <tr>  
      <td class='h_sensor h_no'>1</td>
      <td class='h_sensor h_hz_mix_fh1'>$hz_mix_fh1</td>
      <td class='h_sensor h_hz_mix_sh1'>$hz_mix_sh1</td>
      <td class='h_sensor h_hz_mix_eh1'>$hz_mix_eh1</td>
      <td class='h_sensor h_hz_mix_tt1'>$hz_mix_tt1</td>
      <td class='h_sensor h_hz_mix_tw1'>$hz_mix_tw1</td>
    </tr>
    <tr>  
      <td class='h_sensor h_no'>2</td>
      <td class='h_sensor h_hz_mix_fh2'>$hz_mix_fh2</td>
      <td class='h_sensor h_hz_mix_sh2'>$hz_mix_sh2</td>
      <td class='h_sensor h_hz_mix_eh2'>$hz_mix_eh2</td>
      <td class='h_sensor h_hz_mix_tt2'>$hz_mix_tt2</td>
      <td class='h_sensor h_hz_mix_tw2'>$hz_mix_tw2</td>
    </tr>
    <tr>  
      <td class='h_sensor h_no'>3</td>
      <td class='h_sensor h_hz_mix_fh3'>$hz_mix_fh3</td>
      <td class='h_sensor h_hz_mix_sh3'>$hz_mix_sh3</td>
      <td class='h_sensor h_hz_mix_eh3'>$hz_mix_eh3</td>
      <td class='h_sensor h_hz_mix_tt3'>$hz_mix_tt3</td>
      <td class='h_sensor h_hz_mix_tw3'>$hz_mix_tw3</td>
    </tr>
    <tr>  
      <td class='h_sensor h_no'>AVG</td>
      <td class='h_sensor h_hz_mix_fhAvg'>$hz_mix_fhAvg</td>
      <td class='h_sensor h_hz_mix_shAvg'>$hz_mix_shAvg</td>
      <td class='h_sensor h_hz_mix_ehAvg'>$hz_mix_ehAvg</td>
      <td class='h_sensor h_hz_mix_ttAvg'>$hz_mix_ttAvg</td>
      <td class='h_sensor h_hz_mix_twAvg'>$hz_mix_twAvg</td>
    </tr>
";

?>

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

    <div class="sensor_down">

      <table class='sensor'>
        <thead class='th_sensor'>
          <tr>
            <th class='h_sensor h_hz_mix' colspan='6'>MIX</th>
          </tr>
          <tr>  
            <th class='h_sensor h_no'>NO</th>
            <th class='h_sensor h_hz_mix_fh'>400</th>
            <th class='h_sensor h_hz_mix_sh'>600</th>
            <th class='h_sensor h_hz_mix_eh'>800</th>
            <th class='h_sensor h_hz_mix_tt'>1000</th>
            <th class='h_sensor h_hz_mix_tw'>1200</th>
          </tr>
        </thead>
        <tbody class='tb_sensor'>
          <?php echo $checkList ?>
        </tbody>
      <table>

    </div> 

    </nav>  
  </div>
</body>
</html>