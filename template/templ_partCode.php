<?php
/**
 * 품목 Code
 * table : prdt_part
 * $outputPartCd
 * default : 공백, value : 000
 * flag != 4 : 삭제품목 제외
 * // 품목 part field
 * include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_partCode.php");
 */
$outputPartCd = '';

$sql = "select part_id, part, standard, rate from prdt_part where flag != 4";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$outputPartCd = '<option value = "000"></option>';

while ($row = mysqli_fetch_array($result)) {
  if ($row["part_id"] == $part_id) {
    $outputPartCd .= '<option value = "' . $row["part_id"] . '" selected >' . $row["part_id"] . '</option>';
  } else {
    $outputPartCd .= '<option value = "' . $row["part_id"] . '">' . $row["part_id"] . '</option>';
  }
}
?>