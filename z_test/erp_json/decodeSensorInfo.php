<?php
/**
 * JSON DATA 추출
 * FROM : http://thingsware.co.kr:9080/mhttp/getsninform.php?phone=8212-2578-8304
 * GET : SN, SID, PROJECT
 */

// $url = "http://thingsware.co.kr:9080/mhttp/getsninform.php?phone=8212-2578-8304";
$url = "http://www.ithingsware.com:5080/scsol_erp/z_test/encodeSensorInfoByScsolSN.php";
$data = file_get_contents($url);
$character = json_decode($data, true);
//echo '<pre>'.print_r($character).'</pre><br>';

// $result = $character['0']['RESULT'];
// echo 'result : '.$result.'<br>';
// if ($result == "-1") {
//   echo "no data";
//   exit;
// }


for($i = 0; $i < 100; $i++) {
  $no             = $i+1;
  $scsolSn        = $character[$i]['scsolSn'];
  $phoneNo        = $character[$i]['phoneNo'];
  $pcbaSn         = $character[$i]['pcbaSn'];
  $sensorSn       = $character[$i]['sensorSn'];
  $batterySn      = $character[$i]['batterySn'];
  
  echo 'no : '.$no.'<br>';
  echo 'scsolSn : '.$scsolSn.'<br>';
  echo 'phoneNo : '.$phoneNo.'<br>';
  echo 'pcbaSn : '.$pcbaSn.'<br>';
  echo 'sensorSn : '.$sensorSn.'<br>';
  echo 'batterySn : '.$batterySn.'<br><br>'; 
  
}

?>