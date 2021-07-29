<?php
/**
 * 구매처 supplier
 * table : prdt_supplier
 * $outputSupplier
 * default : 공백, value : 000
 * // 구매처 supplier field
 * include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_supplier.php");
 */
$outputSupplier = '';

$sql = "select supplier_cd, supplier from prdt_supplier order by sort";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$outputSupplier = '<option value = "000"></option>';

while ($row = mysqli_fetch_array($result)) {
  if ($row["supplier_cd"] == $supplier_cd) {
    $outputSupplier .= '<option value = "' . $row["supplier_cd"] . '" selected >' . $row["supplier"] . '</option>';
  } else {
    $outputSupplier .= '<option value = "' . $row["supplier_cd"] . '">' . $row["supplier"] . '</option>';
  }
}
?>