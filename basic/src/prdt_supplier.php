
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$reuser = "";
include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_user.php");

/**
 * 구매처 정보 List
 */
$sql = "SELECT * FROM prdt_supplier WHERE flag != 4 ";
$sql .= "order by sort ";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql);
}
$num = mysqli_num_rows($result);
echo ("num: ".$num);

$i          = 0;
$info_supplier  = "";
while ($row = mysqli_fetch_array($result)) {
  $i++;
  $id           = $row['id'];
  $supplier     = $row['supplier'];
  $supplier_cd  = $row['supplier_cd'];
  $site         = $row['site'];
  $address      = $row['address'];
  $phone        = $row['phone'];
  $fax          = $row['fax'];
  $mail         = $row['mail'];
  $tax_no       = $row['tax_no'];
  $owner        = $row['owner'];
  $manager      = $row['manager'];
  $managerPhone = $row['manager_phone'];
  $etc          = $row['etc'];
  $sort         = $row['sort'];
  $user         = $row['user'];
  $inDate       = $row['inDate'];
  $reuser       = $row['reuser'];
  $reDate       = $row['reDate'];
  if (is_null($reuser)) {
    $reuser = $user;
    $reDate = $inDate;
  }

  $info_supplier .= "
    <tr class='tr_supplier'>
      <td class='b_info b_supplier_id' data-id='$id'>$i</td>
      <td class='b_info b_supplier_supplier'>$supplier</td>
      <td class='b_info b_supplier_supplierCd'>$supplier_cd</td>
      <td class='b_info b_supplier_site' hidden>$site</td>
      <td class='b_info b_supplier_address' hidden>$address</td>
      <td class='b_info b_supplier_phone' hidden>$phone</td>
      <td class='b_info b_supplier_fax' hidden>$fax</td>
      <td class='b_info b_supplier_mail' hidden>$mail</td>
      <td class='b_info b_supplier_tax_no' hidden>$tax_no</td>
      <td class='b_info b_supplier_owner' hidden>$owner</td>
      <td class='b_info b_supplier_manager'>$manager</td>
      <td class='b_info b_supplier_managerPhone'>$managerPhone</td>
      <td class='b_info b_supplier_etc' hidden>$etc</td>
      <td class='b_info b_supplier_sort' hidden>$sort</td>
      <td class='b_info b_supplier_reuser'>$reuser</td>
      <td class='b_info b_supplier_reDate'>$reDate</td>
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
  <title>PRDT_supplier</title>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

  <link rel="stylesheet" type="text/css" href="../../../semantic/semantic.min.css">
  <script
  src="https://code.jquery.com/jquery-3.1.1.min.js"
  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  crossorigin="anonymous"></script>
  <script src="../../../semantic/semantic.min.js"></script>

  <title>구매처 기초 자료 등록</title>
  <link rel="shortcut icon" href="">
  <link rel="stylesheet" href="../css/prdt_supplier.css">
  <script src="../js/prdt_supplier.js" defer></script>
</head>
<body>
<div >
  <div class="ui grid">
    <div class="ui form colum1">      
      <div><h1>구매처</h1></div>
      <div class='info_all_btn'>
        <input type='button' class='info_btn info_clear' value='초기화'/>
        <input type='button' class='info_btn info_save' value='저장'/>
        <input type='button' class='info_btn info_del' value='삭제'/>
      </div>
      <div hidden>
        <div class="ui label" for="id" class="bl_info">ID</div>
        <div class="ui input"><input type="text" name="id" class="supplier_id"></div>
      </div>    
      <div>
        <div class="ui label" for="supplier" class="bl_info">구매처</div>
        <div class="ui input"><input type="text" name="supplier" class="supplier_supplier"></div>
      </div>  
      <div>
        <div class="ui label" for="code" class="bl_info">CODE</div>
        <div class="ui input"><input type="text" name="code" class="supplier_supplierCd" style="background-color: #bdbdbd;" readonly onfocus='this.blur();'></div>
      </div>
      <div>
        <div class="ui label" for="site" class="bl_info">SITE</div>
        <div class="ui input"><input type="text" name="site" class="supplier_site"></div>
      </div>
      <div>
        <div class="ui label" for="address" class="bl_info">주소</div>
        <div class="ui input"><input type="text" name="address" class="supplier_address"></div>
      </div>
      <div>
        <div class="ui label" for="phone" class="bl_info">전화번호</div>
        <div class="ui input"><input type="text" name="phone" class="supplier_phone"></div>
      </div>
      <div>
        <div class="ui label" for="fax" class="bl_info">FAX</div>
        <div class="ui input"><input type="text" name="fax" class="supplier_fax"></div>
      </div>
      <div>
        <div class="ui label" for="mail" class="bl_info">이메일</div>
        <div class="ui input"><input type="text" name="mail" class="supplier_mail"></div>
      </div>
      <div>
        <div class="ui label" for="taxNo" class="bl_info">사업자번호</div>
        <div class="ui input"><input type="text" name="taxNo" class="supplier_taxNo"></div>
      </div>
      <div>
        <div class="ui label" for="owner" class="bl_info">사업자명</div>
        <div class="ui input"><input type="text" name="owner" class="supplier_owner"></div>
      </div>
      <div>
        <div class="ui label" for="manager" class="bl_info">담당자</div>
        <div class="ui input"><input type="text" name="manager" class="supplier_manager"></div>
      </div>
      <div>
        <div class="ui label" for="managerPhone" class="bl_info">담당자 전화번호</div>
        <div class="ui input"><input type="text" name="managerPhone" class="supplier_managerPhone"></div>
      </div>
      <div>
        <div class="ui label" for="etc" class="bl_info">기타</div>
        <div class="ui input"><input type="text" name="etc" class="supplier_etc"></div>
      </div>
      <div>
        <div class="ui label" for="sort" class="bl_info">정렬순서</div>
        <div class="ui input"><input type="text" name="sort" class="supplier_sort" style="background-color: #bdbdbd;" readonly onfocus='this.blur();'></div>
      </div>
      <div>
        <div class="ui label" for="reuser" class="bl_info">입력인</div>
        <div class="ui input">
          <select class='user_l erp_user'>
            <?php echo $listUser; ?>
          </select></div>
      </div>      
    </div>
    <div class="ui colum2">
      <div>
      <table class="ui selectable striped table">      
        <thead class='th_supplier'>
          <tr>
            <td class='br_info li_supplier_id' data-id='$id'>NO</td>
            <td class='br_info li_supplier_supplier'>구매처</td>
            <td class='br_info li_supplier_supplierCd'>Code</td>            
            <td class='br_info li_supplier_manager'>담당자</td>
            <td class='br_info li_supplier_managerPhone'>전화번호</td>
            <td class='br_info li_supplier_reuser'>입력인</td>
            <td class='br_info li_supplier_reDate'>입력일</td>
          </tr>
          </thead>
          <tbody class='tb_supplier'>          
            <?php echo $info_supplier ?>            
          </tbody>          
        </table>
      </div>
    </div>
  </div>
</div>  
</body>
</html>