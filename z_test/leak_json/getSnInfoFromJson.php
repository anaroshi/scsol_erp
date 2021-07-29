<?php
/**
 * JSON DATA 추출
 * FROM : http://thingsware.co.kr:9080/mhttp/getsninform.php?phone=8212-2578-8304
 * GET : SN, SID, PROJECT
 */

// $url = "http://thingsware.co.kr:9080/mhttp/getsninform.php?phone=8212-3268-8830";

$phone_no = "8212-3268-8830";
$url = "http://thingsware.co.kr:9080/mhttp/getsninform.php?phone=".$phone_no;

//$url = "http://www.ithingsware.com:5080/scsol_erp/z_test/leak_json/getsninform.php?phone=".$phone_no;

//$url = "http://thingsware.co.kr:9080/mhttp/getsninform.php";

$data = file_get_contents($url);
$character = json_decode($data, true);
// echo '<pre>'.print_r($character).'</pre><br>';

$result = $character['0']['RESULT'];
echo 'result : '.$result.'<br>';
if ($result == "-1") {
  echo "no data";
  exit;
}

$sn       = $character['0']['SN'];
$sid      = $character['0']['SID'];
$project  = $character['0']['PROJECT'];

echo 'sn : '.$sn.'<br>';
echo 'sid : '.$sid.'<br>';
echo 'project : '.$project.'<br>';

?>