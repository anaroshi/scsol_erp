<?php
/**
 * 장착 type
 * table : prdt_type
 * $outputType
 * default : 공백, value : 000
 * // 장착 Type field
 * include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_type.php");
 */

$outputType = '';
$sql = "select type_cd, type from prdt_type order by sort";

if (!($result = mysqli_query($conn_11, $sql))) {
    echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}
$outputType .= '<option value = "000">&nbsp;</option>';
while ($row = mysqli_fetch_array($result)) {
  if ($row["type_cd"] == $type_cd) {
    $outputType .= '<option value = "' . $row["type_cd"] . '" selected >' . $row["type"] . '</option>';
  } else {
    $outputType .= '<option value = "' . $row["type_cd"] . '">' . $row["type"] . '</option>';
  }
}
?>
