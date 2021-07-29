<?php
/**
 * 용도 purpose
 * table : prdt_purpose
 * $outputPurpose
 * default : 공백, value : 000
 * // 용도 purpose field
 * include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_purpose.php");
 */
$outputPurpose = '';

$sql = "select purpose_cd, purpose from prdt_purpose order by sort";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$outputPurpose = '<option value = "000">&nbsp;</option>';

while ($row = mysqli_fetch_array($result)) {
  if ($row["purpose_cd"] == $purpose_cd) {
    $outputPurpose .= '<option value = "' . $row["purpose_cd"] . '" selected >' . $row["purpose"] . '</option>';
  } else {
    $outputPurpose .= '<option value = "' . $row["purpose_cd"] . '">' . $row["purpose"] . '</option>';
  }
}
?>