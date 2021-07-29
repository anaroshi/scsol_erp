
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$reuser = "";
include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_user.php");

/**
 * 타입 정보 List
 */
$sql = "SELECT * FROM prdt_type WHERE flag != 4 ";
$sql .= "order by sort ";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
}

$i          = 0;
$info_type  = "";
while ($row = mysqli_fetch_array($result)) {
  $i++;
  $id       = $row['id'];
  $type     = $row['type'];
  $type_cd  = $row['type_cd'];
  $sort     = $row['sort'];
  $user     = $row['user'];
  $inDate   = $row['inDate'];
  $reuser   = $row['reuser'];
  $reDate   = $row['reDate'];
  if ($reuser == "") {
    $resuer = $user;
    $reDate = $inDate;
  }

  $info_type .= "
    <tr class='tr_type'>
      <td class='b_info b_type_id' data-id='$id'>$i</td>
      <td class='b_info b_type_type'>$type</td>
      <td class='b_info b_type_typeCd'>$type_cd</td>
      <td class='b_info b_type_sort'>$sort</td>
      <td class='b_info b_type_reuser'>$reuser</td>
      <td class='b_info b_type_reDate'>$reDate</td>
    </tr>
  ";
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PRDT_TYPE</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="../../../semantic/semantic.min.css">
  <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
  <script src="../../../semantic/semantic.min.js"></script>

  <title>타입 기초 자료 등록</title>
  <link rel="shortcut icon" href="">
  <link rel="stylesheet" href="../css/prdt_type.css">
  <script src="../js/prdt_type.js" defer></script>
</head>
<body>
<div >
  <div class="ui grid">
    <div class="ui form colum1">      
      <div><h1>타입</h1></div>
      <div class='info_all_btn'>
        <input type='button' class='info_btn info_clear' value='초기화'/>
        <input type='button' class='info_btn info_save' value='저장'/>
        <input type='button' class='info_btn info_del' value='삭제'/>
      </div>
      <div hidden>
        <div class="ui label" for="type" class="bl_info">ID</div>
        <div class="ui input"><input type="text" name="type" class="type_id"></div>
      </div>    
      <div>
        <div class="ui label" for="type" class="bl_info">타입</div>
        <div class="ui input"><input type="text" name="type" class="type_type"></div>
      </div>  
      <div>
        <div class="ui label" for="code" class="bl_info">CODE</div>
        <div class="ui input"><input type="text" name="code" class="type_typeCd" style="background-color: #bdbdbd;" readonly onfocus='this.blur();'></div>
      </div>
      <div>
        <div class="ui label" for="sort" class="bl_info">정렬순서</div>
        <div class="ui input"><input type="text" name="sort" class="type_sort" style="background-color: #bdbdbd;" readonly onfocus='this.blur();'></div>
      </div>
      <div>
        <div class="ui label" for="reuser" class="bl_info">담당자</div>
        <div class="ui input">
          <select class='user_l erp_user'>
            <?php echo $listUser; ?>
          </select></div>
      </div>      
    </div>
    <div class="ui colum2">
      <div>
      <table class="ui selectable striped table">
        <thead class='th_type'>
          <tr>
            <td class='br_info li_type_id' data-id='$id'>NO</td>
            <td class='br_info li_type_type'>타입</td>
            <td class='br_info li_type_typeCd'>Code</td>
            <td class='br_info li_type_sort'>정렬순서</td>
            <td class='br_info li_type_reuser'>담당자</td>
            <td class='br_info li_type_reDate'>입력일</td>
          </tr>
          </thead>
          <tbody class='tb_type'>
            <?php echo $info_type ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>  
</body>
</html>