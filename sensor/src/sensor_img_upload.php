<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * sensor에 속한 이미지 Upload
 * PATH : "/data/입고날짜(6자리)/sn(4자리)"
 * ex   : "/data/210222/0010/image" <= sensor-210222-0010 
 */

$id              = trim($_POST["id"]);                 // 1. sensor id
$sensor_sn       = trim($_POST["sensor_sn"]);          // 2. sensor_sn
$sensor_img      = trim($_POST["sensor_img"]);         // 3. sensor_img
$classNm         = trim($_POST["classNm"]);            // 4. classNm

if ($sensor_sn) {

  /**
   * sensor 이미지 경로 존재 확인
   * 
   */
  $path           = "../data/";
  $sub1_dir       = substr($sensor_sn,-11,6);
  $path1          = $path.$sub1_dir."/";
  $sub2_dir       = substr($sensor_sn,-4);
  $path2          = $path1.$sub2_dir."/";

  if($classNm=='image_1_file') {
    $sensor_img     = $sub2_dir.'-4-x.jpg';
  } elseif($classNm=='image_2_file') {
    $sensor_img     = $sub2_dir.'-6-8.jpg';
  } elseif($classNm=='image_3_file') {
    $sensor_img     = $sub2_dir.'-10-12.jpg';
  }

  $uploadImgFile  = $path2 .$sensor_img;
  $allowed_ext    = array('jpg');
  //$allowed_ext = array('jpg','jpeg','png','gif');

  if(!is_dir($path)) {
    mkdir($path);
    chmod($path, 0777);
  }
  if(!is_dir($path1)) {
    mkdir($path1);
    chmod($path1, 0777);
  }
  if(!is_dir($path2)) {
    mkdir($path2);
    chmod($path2, 0777);
  }
  
  // 오류 확인
  if( !isset($_FILES[$classNm]['error']) ) {
    echo json_encode( array(
      'status' => 'error',
      'message' => '파일이 첨부되지 않았습니다.'
    ));
    exit;
  }
  $error = $_FILES[$classNm]['error'];
  if( $error != UPLOAD_ERR_OK ) {
    switch( $error ) {
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
    echo json_encode( array(
      'status' => 'error',
      'message' => $message 
    ));
    exit;
  }

  // 변수 정리
  $name = $_FILES[$classNm]['name'];
  $ext  = array_pop(explode('.', $name));

  // 확장자 확인
  if( !in_array($ext, $allowed_ext) ) {
    echo json_encode( array(
      'status' => 'error',
      'message' => '허용되지 않는 확장자입니다.'
    ));
    exit;
  }

  // 파일 이동
  move_uploaded_file( $_FILES[$classNm]['tmp_name'], $uploadImgFile );

  // 파일 정보 출력
  echo json_encode( array(
  'status' => 'OK',
  'id' => $id,
  'sensor_sn' => $sensor_sn,
  'name' => $name,
  'ext' => $ext,
  'path' => $path2,
  'type' => $_FILES[$classNm]['type'],
  'size' => $_FILES[$classNm]['size']
  ));

} else {
  // 저장할 이미지 무
  $data ="F";
}

echo $data;

?>