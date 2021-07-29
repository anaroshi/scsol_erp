<?php
/**
 * 수량단위 unit
 * table : prdt_unit
 * $outputUnit
 * default : EA, value : 101
 * // 수량단위 unit field
 * include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_unit.php");
 */
$outputUnit = '';

$sql = "select unit_cd, unit from prdt_unit order by sort";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$outputUnit = '<option value = "000">&nbsp;</option>';

while ($row = mysqli_fetch_array($result)) {
  if ($row["unit"] == $unit) {
    $outputUnit .= '<option value = "' . $row["unit"] . '"selected >' . $row["unit"] . '</option>';
  } else {
    $outputUnit .= '<option value = "' . $row["unit"] . '">' . $row["unit"] . '</option>';
  }
}
?>