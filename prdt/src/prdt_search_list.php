<?php
  error_reporting(E_ALL);
  ini_set("display_errors",1);

  include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
  include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
  include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

  $data = array();

  $prdt_sn = $_POST['prdt_sn'] ?? ''; 
  $prdt_tradDateFrom  = $_POST['prdt_tradDateFrom'] ?? '';
  $prdt_tradDateTo    = $_POST['prdt_tradDateTo'] ?? '';
  $prdt_status        = $_POST['prdt_status'] ?? '';
  $prdt_product       = $_POST['prdt_product'] ?? '';
  $prdt_finalState    = $_POST['prdt_finalState'] ?? '';
  
  // echo ("prdt_sn           : ".$prdt_sn."<br>");
  // echo ("prdt_tradDateFrom : ".$prdt_tradDateFrom."<br>");
  // echo ("prdt_tradDateTo   : ".$prdt_tradDateTo."<br>");
  // echo ("prdt_status       : ".$prdt_status."<br>");
  // echo ("prdt_product      : ".$prdt_product."<br>");
  // echo ("prdt_finalState   : ".$prdt_finalState."<br>");

  /**
   * 생산 상태 : used
   */
  $sql = "SELECT * FROM step_product WHERE finalState ='P' ";
  if($prdt_sn) {
    $sql .= "AND scsol_sn like '%$prdt_sn%' ";
  }
  if($prdt_tradDateFrom != '' && $prdt_tradDateTo != '') {
    $sql .= "";
  } else if ($prdt_tradDateFrom != '') {
    $sql .= "";
  } else if ($prdt_tradDateTo != '') {
    $sql .= "";
  }
  if($prdt_product == 'LeakMaster') {
    $sql .= "AND LEFT(scsol_sn,5) = 'SWFLB' ";
  }
  if($prdt_product == 'MotorMaster') {
    $sql .= "AND LEFT(scsol_sn,5) = 'STFMB' ";
  }
  if($prdt_product == 'CurrentMaster') {
    $sql .= "AND LEFT(scsol_sn,5) = 'STFCB' ";
  }

  if (!($result = mysqli_query($conn_11, $sql))) {
    echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
  }

  $finalNum = mysqli_num_rows($result);

  /**
   * 생산정보 List
   */

  $sql = "SELECT * FROM step_product WHERE 1 ";
  if($prdt_sn) {
    $sql .= "AND scsol_sn like '%$prdt_sn%' ";
  }
  if($prdt_tradDateFrom != '' && $prdt_tradDateTo != '') {
    $sql .= "";
  } else if ($prdt_tradDateFrom != '') {
    $sql .= "";
  } else if ($prdt_tradDateTo != '') {
    $sql .= "";
  }
  if($prdt_product == 'LeakMaster') {
    $sql .= "AND LEFT(scsol_sn,5) = 'SWFLB' ";
  }
  if($prdt_product == 'MotorMaster') {
    $sql .= "AND LEFT(scsol_sn,5) = 'STFMB' ";
  }
  if($prdt_product == 'CurrentMaster') {
    $sql .= "AND LEFT(scsol_sn,5) = 'STFCB' ";
  }
  if($prdt_finalState == 'F') {
    $sql .= "AND finalState ='F' ";
  }
  if($prdt_finalState == 'P') {
    $sql .= "AND finalState ='P' ";
  }
  $sql .= "order by id";

  if(!($result = mysqli_query($conn_11, $sql))) {
    echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
  }
  
  $num = mysqli_num_rows($result);
  $totalMsg = "완품". number_format($finalNum)."대 / ".number_format($num)."대";

    $i = 0;
  $outputList = "";
  while ($row = mysqli_fetch_array($result)) {
  
  $i++;
  $id                   = $row['id'];                    
  $scsol_sn             = $row['scsol_sn'];                    
  $phone_no             = $row['phone_no'];                    
  $pcba_sn              = $row['pcba_sn'];      
  $sensor_sn            = $row['sensor_sn'];        
  $battery_sn           = $row['battery_sn'];        
  $case_sn              = $row['case_sn'];      
  $fwVesrion            = $row['fw_version'];      
  $flag                 = $row['flag'];  
  $status               = $row['status'];  
  $finalState           = $row['finalState'];  
  $user                 = $row['user'];  
  $inDate               = $row['inDate'];    
  $reuser               = $row['reuser'];    
  $reDate               = $row['reDate'];
  if($reDate == "") {
    $reuser = $user;
    $reDate = $inDate;
  }
  
  $outputList .= "
    <tr class='tr_prdt'>
      <td class ='d_prdt d_id' data-id='$id'>$i</td>
      <td class ='d_prdt d_scsol_sn'>$scsol_sn</td>
      <td class ='d_prdt d_prdt_sn d_phone_no'>$phone_no</td>
      <td class ='d_prdt d_prdt_sn d_usim'>$pcba_sn </td>
      <td class ='d_prdt d_prdt_sn d_rate'>$sensor_sn</td>
      <td class ='d_prdt d_prdt_sn d_monthlyFee'>$battery_sn</td>
      <td class ='d_prdt d_fwVersion'>$fwVesrion</td>
      <td class ='d_prdt d_inDate'>$inDate</td>
      <td class ='d_prdt d_status'>$status</td>
      <td class ='d_prdt d_finalState'>$finalState</td>
      <td class ='d_prdt d_reDate'>$reDate</td>
      <td class ='d_prdt d_reuser'>$reuser</td>
    </tr>
  ";
}
$conn_11->close();
$outputList .= "<tr><td colspan='24' style='height: 60px;'></td></tr>";
$data['total'] = $totalMsg;
$data['outputList'] = $outputList;
echo json_encode($data);
  
?>