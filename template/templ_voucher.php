<?php
/**
 * 거래유형(전표구분)
 * table : trad_voucher
 * $outputVoucher
 * default : 공백, value : 000
 * // 거래유형(전표구분) field
 * include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_voucher.php");
 */
$outputVoucher = '';

$sql = "select voucher_cd, voucher from trad_voucher order by sort";

if (!($result = mysqli_query($conn_11, $sql))) {
    echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$outputVoucher .= '<option value = "000">&nbsp;</option>';

while ($row = mysqli_fetch_array($result)) {
  if ($row["voucher_cd"] == $voucher_cd) {
    $outputVoucher .= '<option value = "' . $row["voucher_cd"] . '" selected >' . $row["voucher"] . '</option>';
  } else {
    $outputVoucher .= '<option value = "' . $row["voucher_cd"] . '">' . $row["voucher"] . '</option>';
  }
}
?>
