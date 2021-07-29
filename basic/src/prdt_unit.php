
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$reuser = "";
include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_user.php");

/**
 * 단위 정보 List
 */
$sql = "SELECT * FROM prdt_unit WHERE flag != 4 ";
$sql .= "order by sort ";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
}

$i          = 0;
$info_unit  = "";
while ($row = mysqli_fetch_array($result)) {
  $i++;
  $id       = $row['id'];
  $unit     = $row['unit'];
  $unit_cd  = $row['unit_cd'];
  $sort     = $row['sort'];
  $user     = $row['user'];
  $inDate   = $row['inDate'];
  $reuser   = $row['reuser'];
  $reDate   = $row['reDate'];
  if (is_null($reuser)) {
    $reuser = $user;
    $reDate = $inDate;
  }

  $info_unit .= "
    <tr class='tr_unit'>
      <td class='b_info b_unit_id' data-id='$id'>$i</td>
      <td class='b_info b_unit_unit'>$unit</td>
      <td class='b_info b_unit_unitCd'>$unit_cd</td>
      <td class='b_info b_unit_sort'>$sort</td>
      <td class='b_info b_unit_reuser'>$reuser</td>
      <td class='b_info b_unit_reDate'>$reDate</td>
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
  <title>PRDT_UNIT</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="../../../semantic/semantic.min.css">
  <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
  <script src="../../../semantic/semantic.min.js"></script>

  <title>단위 기초 자료 등록</title>
  <link rel="shortcut icon" href="">
  <link rel="stylesheet" href="../css/prdt_unit.css">
  <script src="../js/prdt_unit.js" defer></script>
</head>
<body>
<div >
  <div class="ui grid">
    <div class="ui form colum1">      
      <div><h1>단위</h1></div>
      <div class='info_all_btn'>
        <input type='button' class='info_btn info_clear' value='초기화'/>
        <input type='button' class='info_btn info_save' value='저장'/>
        <input type='button' class='info_btn info_del' value='삭제'/>
      </div>
      <div hidden>
        <div class="ui label" for="id" class="bl_info">ID</div>
        <div class="ui input"><input type="text" name="id" class="unit_id"></div>
      </div>    
      <div>
        <div class="ui label" for="unit" class="bl_info">단위</div>
        <div class="ui input"><input type="text" name="unit" class="unit_unit"></div>
      </div>  
      <div>
        <div class="ui label" for="code" class="bl_info">CODE</div>
        <div class="ui input"><input type="text" name="code" class="unit_unitCd" style="background-color: #bdbdbd;" readonly onfocus='this.blur();'></div>
      </div>
      <div>
        <div class="ui label" for="sort" class="bl_info">정렬순서</div>
        <div class="ui input"><input type="text" name="sort" class="unit_sort" style="background-color: #bdbdbd;" readonly onfocus='this.blur();'></div>
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
        <thead class='th_unit'>
          <tr>
            <td class='br_info li_unit_id' data-id='$id'>NO</td>
            <td class='br_info li_unit_unit'>단위</td>
            <td class='br_info li_unit_unitCd'>Code</td>
            <td class='br_info li_unit_sort'>정렬순서</td>
            <td class='br_info li_unit_reuser'>담당자</td>
            <td class='br_info li_unit_reDate'>입력일</td>
          </tr>
          </thead>
          <tbody class='tb_unit'>          
            <?php echo $info_unit ?>            
          </tbody>          
        </table>
      </div>
    </div>
  </div>
</div>  
</body>
</html>