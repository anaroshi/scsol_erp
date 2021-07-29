<?php
/**
 * 분류 kind
 * table : prdt_kind
 * $outputKind
 * default : 공백, value : 000
 * // 분류 kind field
 * include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_kind.php");
 */

$outputKind = '';
$sql = "select kind_cd, kind from prdt_kind order by sort";

if (!($result = mysqli_query($conn_11, $sql))) {
    echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$outputKind .= '<option value = "000">&nbsp;</option>';

while ($row = mysqli_fetch_array($result)) {
  if ($row["kind_cd"] == $kind_cd) {
    $outputKind .= '<option value = "' . $row["kind_cd"] . '" selected >' . $row["kind"] . '</option>';
  } else {
    $outputKind .= '<option value = "' . $row["kind_cd"] . '">' . $row["kind"] . '</option>';
  }
}
?>
