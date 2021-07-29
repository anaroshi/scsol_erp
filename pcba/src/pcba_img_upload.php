<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * PCBA에 속한 이미지 Upload
 * PATH : "/data/입고날짜(6자리)/sn(4자리)"
 * ex   : "/data/210222/0010/image" <= pcba-210222-0010 
 */

$id       = trim($_POST["id"]);               // 1. PCBA id
$pcba_sn  = trim($_POST["pcba_sn"]);          // 2. pcba_sn
$pcba_img = trim($_POST["pcba_img"]);         // 3. pcba_img
$classNm  = trim($_POST["classNm"]);          // 4. classNm

if ($pcba_sn) {

  /**
   * PCBA 이미지 경로 존재 확인
   * 
   */

  $path           = "../data/";
  $sub1_dir       = substr($pcba_sn, 5, 6);
  $path1          = $path . $sub1_dir . "/";
  $sub2_dir       = substr($pcba_sn, -4);
  $path2          = $path1 . $sub2_dir . "/";


  $uploadImgFile  = $path2 . $pcba_img;
  $allowed_ext    = array('jpg');
  //$allowed_ext = array('jpg','jpeg','png','gif');

  if (!is_dir($path)) {
    mkdir($path);
    chmod($path, 0777);
  }
  if (!is_dir($path1)) {
    mkdir($path1);
    chmod($path1, 0777);
  }
  if (!is_dir($path2)) {
    mkdir($path2);
    chmod($path2, 0777);
  }

  // 오류 확인
  if (!isset($_FILES[$classNm]['error'])) {
    echo json_encode(array(
      'status' => 'error',
      'message' => '파일이 첨부되지 않았습니다.'
    ));
    exit;
  }
  $error = $_FILES[$classNm]['error'];
  if ($error != UPLOAD_ERR_OK) {
    switch ($error) {
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        $message = "파일이 너무 큽니다. ($error)";
        break;
      case UPLOAD_ERR_NO_FILE:
        $message = "파일이 첨부되지 않았습니다. ($error)";
        break;
      default:
        $message = "파일이 제대로 업로드되지 않았습니다. ($error)";
    }
    echo json_encode(array(
      'status' => 'error',
      'message' => $message
    ));
    exit;
  }

  // 변수 정리
  $name = $_FILES[$classNm]['name'];
  $ext = array_pop(explode('.', $name));

  // 확장자 확인
  if (!in_array($ext, $allowed_ext)) {
    echo json_encode(array(
      'status' => 'error',
      'message' => '허용되지 않는 확장자입니다.'
    ));
    exit;
  }

  // 파일 이동
  move_uploaded_file($_FILES[$classNm]['tmp_name'], $uploadImgFile);

  // 파일 정보 출력
  echo json_encode(array(
    'status' => 'OK',
    'id' => $id,
    'pcba_sn' => $pcba_sn,
    'name' => $name,
    'ext' => $ext,
    'path' => $path2,
    'type' => $_FILES[$classNm]['type'],
    'size' => $_FILES[$classNm]['size']
  ));


  // $max_file_size = 5242880;
  // if($imageNm['size'] >= $max_file_size) {
  //   echo "업로드할 수 없는 크기입니다.";
  // }
  //move_uploaded_file( $_FILES[$classNm]['tmp_name'], $uploadImgFile);
  // if(move_uploaded_file($_FILES["img_radio_file"]["tmp_name"],"$path2/radio.jpg")) {
  //   $data ="P";
  // } else {
  //   $data ="F";
  // }

} else {
  // 저장할 이미지 무
  $data = "F";
}



/*
if(!is_dir($upload_dir)) {
  mkdir($upload_dir);
  $inputFileName = $_FILES["pcba_readfile"]["tmp_name"];
} else {
  $inputFileName = $_FILES["pcba_readfile"]["tmp_name"];
}

$sql = "select * from trad_part_pcba where id = '$id'";
//echo("sql : $sql");
if (!($result = mysqli_query($conn_11, $sql))) {
  echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
}

$result && $row = mysqli_fetch_assoc($result);
*/
//echo $data;
