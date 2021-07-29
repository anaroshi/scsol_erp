<?php
/**
 * JSON DATA 추출
 * FROM : http://thingsware.co.kr:9080/mhttp/getsninform.php?phone=8212-2578-8304
 * GET : SN, SID, PROJECT
 */

// $url = "http://thingsware.co.kr:9080/mhttp/getsninform.php?phone=8212-2578-8304";
$url = "http://www.ithingsware.com:5080/scsol_erp/z_test/encodeSensorInfoByScsolSN.php?sn=SWFLB-20210225-0106-0246";
$data = file_get_contents($url);
$character = json_decode($data, true);
//echo '<pre>'.print_r($character).'</pre><br>';

// $result = $character['0']['RESULT'];
// echo 'result : '.$result.'<br>';
// if ($result == "-1") {
//   echo "no data";
//   exit;
// }

$scsolSn        = $character[0]['scsolSn'];
$phoneNo        = $character[0]['phoneNo'];
$pcbaSn         = $character[0]['pcbaSn'];
$sensorSn       = $character[0]['sensorSn'];
$batterySn      = $character[0]['batterySn'];

echo 'scsolSn : '.$scsolSn.'<br>';
echo 'phoneNo : '.$phoneNo.'<br>';
echo 'pcbaSn : '.$pcbaSn.'<br>';
echo 'sensorSn : '.$sensorSn.'<br>';
echo 'batterySn : '.$batterySn.'<br><br>'; 

?>