<?php
/**
 * product
 * table : scs_product
 * $outputPdt
 * default : 공백, value : 000
 * // Product field
 * include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_product.php");
 */

$outputPdt = '';
$sql = "select product from scs_product order by sort";

$result = mysqli_query($conn_11, $sql);
$outputPdt .= '<option value = "000">&nbsp;</option>';
while ($row = mysqli_fetch_array($result)) {
  $chkProduct = $row["product"];  
  if ($product == $chkProduct)
    $outputPdt .= '<option value = "' . $row["product"] . '" selected>' . $row["product"] . '</option>';
  else
    $outputPdt .= '<option value = "' . $row["product"] . '">' . $row["product"] . '</option>';
}

?>