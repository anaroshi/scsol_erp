<?php
/**
 * 단가 currency
 * table : prdt_currency
 * $outputcurrency
 * default : KRW, value : cur_101
 * // 단가 currency field
 * include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_currency.php");
 */
$outputCurrency = '';

$sql = "select currency_cd, currency from prdt_currency order by sort";

if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$outputCurrency = '<option value = "000">&nbsp;</option>';

while ($row = mysqli_fetch_array($result)) {
  if ($row["currency"] == $currency) {
    $outputCurrency .= '<option value = "' . $row["currency"] . '"selected >' . $row["currency"] . '</option>';
  } else {
    $outputCurrency .= '<option value = "' . $row["currency"] . '">' . $row["currency"] . '</option>';
  }
}
?>