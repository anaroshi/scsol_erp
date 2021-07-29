
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$reuser = "";
include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_user.php");

/**
 * USER 정보 List
 */
$sql = "SELECT * FROM erp_user WHERE flag != 4 ";
$sql .= "order by user ";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
}

$i          = 0;
$info_user  = "";
while ($row = mysqli_fetch_array($result)) {
  $i++;
  $cid      = $row['cid'];
  $id       = $row['id'];  
  $pw       = $row['pw'];
  $name     = $row['name'];
  $phone    = $row['phone'];
  $addr      = $row['addr'];
  $email    = $row['email'];
  $startDate= $row['startDate'];
  $user     = $row['user'];
  $inDate   = $row['inDate'];
  $reuser   = $row['reuser'];
  $reDate   = $row['reDate'];
  if (is_null($reuser)) {
    $reuser = $user;
    $reDate = $inDate;
  }

  $info_user .= "
    <tr class='tr_user'>
      <td class='b_info b_user_id' data-id='$cid'>$i</td>
      <td class='b_info b_user_id'>$id</td>
      <td class='b_info b_user_pw' hidden>$pw</td>
      <td class='b_info b_user_name'>$name</td>
      <td class='b_info b_user_phone'>$phone</td>
      <td class='b_info b_user_addr' hidden>$addr</td>
      <td class='b_info b_user_email'>$email</td>
      <td class='b_info b_user_startDate'>$startDate</td>
      <td class='b_info b_user_reuser'>$reuser</td>
      <td class='b_info b_user_reDate'>$reDate</td>
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
  <title>PRDT_user</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="../../../semantic/semantic.min.css">
  <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
  <script src="../../../semantic/semantic.min.js"></script>

  <title>USER 기초 자료 등록</title>
  <link rel="shortcut icon" href="">
  <link rel="stylesheet" href="../css/prdt_user.css">
  <script src="../js/prdt_user.js" defer></script>
</head>
<body>
<div >
  <div class="ui grid">
    <div class="ui form colum1">      
      <div><h1>USER</h1></div>
      <div class='info_all_btn'>
        <input type='button' class='info_btn info_clear' value='초기화'/>
        <input type='button' class='info_btn info_save' value='저장'/>
        <input type='button' class='info_btn info_del' value='삭제'/>
      </div>
      <div hidden>
        <div class="ui label" for="cid" class="bl_info">CID</div>
        <div class="ui input"><input type="text" name="cid" class="user_cid"></div>
      </div>    
      <div>
        <div class="ui label" for="id" class="bl_info">ID</div>
        <div class="ui input"><input type="text" name="id" class="user_id"></div>
      </div>  
      <div>
        <div class="ui label" for="pwd" class="bl_info">PASSWORD</div>
        <div class="ui input"><input type="text" name="pwd" class="user_password"></div>
      </div>
      <div>
        <div class="ui label" for="name" class="bl_info">이름</div>
        <div class="ui input"><input type="text" name="name" class="user_name"></div>
      </div>
      <div>
        <div class="ui label" for="phone" class="bl_info">전화번호</div>
        <div class="ui input"><input type="text" name="phone" class="user_phone"></div>
      </div>    
      <div>
        <div class="ui label" for="addr" class="bl_info">주소</div>
        <div class="ui input"><input type="text" name="addr" class="user_addr"></div>
      </div>      
      <div>
        <div class="ui label" for="email" class="bl_info">이메일</div>
        <div class="ui input"><input type="text" name="email" class="user_email"></div>
      </div>
      <div>
        <div class="ui label" for="startDate" class="bl_info">입사일</div>
        <div class="ui input"><input type="date" name="startDate" class="user_startDate"></div>
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
        <thead class='th_user'>
          <tr>
            <td class='br_info li_user_cid' data-id='$cid'>NO</td>
            <td class='br_info li_user_id'>ID</td>
            <td class='br_info li_user_pw' hidden>PWD</td>
            <td class='br_info li_user_name'>이름</td>
            <td class='br_info li_user_phone'>전화번호</td>
            <td class='br_info li_user_addr' hidden>주소</td>
            <td class='br_info li_user_email'>이메일</td>
            <td class='br_info li_user_startDate'>입사일</td>
            <td class='br_info li_user_reuser'>담당자</td>
            <td class='br_info li_user_reDate'>입력일</td>
          </tr>
          </thead>
          <tbody class='tb_user'>          
            <?php echo $info_user ?>            
          </tbody>          
        </table>
      </div>
    </div>
  </div>
</div>  
</body>
</html>