<?php
/**
 * 종류 item
 * table : prdt_item
 * $outputItem
 * default : 공백, value : 000
 * // 종류 item field
 * include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_item.php");
 */

$outputItem = '';
$sql = "select item_cd, item from prdt_item order by sort";

if (!($result = mysqli_query($conn_11, $sql))) {
    echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}
  
$outputItem .= '<option value = "000">&nbsp;</option>';

while ($row = mysqli_fetch_array($result)) {
  if ($row["item_cd"] == $item_cd) {
    $outputItem .= '<option value = "' . $row["item_cd"] . '" selected >' . $row["item"] . '</option>';
  } else {
    $outputItem .= '<option value = "' . $row["item_cd"] . '">' . $row["item"] . '</option>';
  }
}
?>
