<?php
/**
 * ERP USER
 * table : erp_user
 * $outputUser
 * default : 공백, value : name
 * // 담당자 field
 * include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_user.php");
 */
$listUser = '';

$sql = "SELECT name FROM erp_user WHERE flag != 4 ORDER BY name";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$listUser .= '<option value = "">&nbsp;</option>';

while ($row = mysqli_fetch_array($result)) {
  $chkProduct = $row["name"];  
  if ($reuser == $chkProduct)
    $listUser .= '<option value = "' . $chkProduct . '" selected>' . $chkProduct . '</option>';
  else
    $listUser .= '<option value = "' . $chkProduct . '">' . $chkProduct . '</option>';
}

$outputUser = "
    <th><label class='user_h' for='user'>담당자</label></th>
    <td>
    <select class='user_l erp_user'>
        $listUser
    </select>
    </td>
";
?>
