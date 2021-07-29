<?php
  include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

// error_reporting(E_ALL);
// ini_set("display_errors", 1);
$data = array();

/**
 * PRODUCT에 속한 이미지 Upload
 * PATH : "/data/scsol_sn/"
 * ex   : "/data/SWFLB-20200625-0105-0001/"
 */

$scsol_sn   = trim($_POST["scsol_sn"]);         // 1. scsol_sn
$classNm    = trim($_POST["classNm"]);          // 2. classNm

if ($scsol_sn) {

  /**
   * prdt 이미지 경로 존재 확인
   * 
   */
  $path           = "../data/" . $scsol_sn . "/";

  if ($classNm == "leaktest_t1_p4_file") {
    $prdt_img = $scsol_sn . "_leaktest_t1_p4.jpg";
  } elseif ($classNm == "leaktest_t1_p5_file") {
    $prdt_img = $scsol_sn . "_leaktest_t1_p5.jpg";
  } elseif ($classNm == "radiotest_t1_file") {
    $prdt_img = $scsol_sn . "_radiotest_t1.jpg";
  } elseif ($classNm == "mold_file1") {
    $prdt_img = $scsol_sn . "_mold1.jpg";
  } elseif ($classNm == "mold_file2") {
    $prdt_img = $scsol_sn . "_mold2.jpg";
  } elseif ($classNm == "leaktest_t2_p4_file") {
    $prdt_img = $scsol_sn . "_leaktest_t2_p4.jpg";
  } elseif ($classNm == "leaktest_t2_p5_file") {
    $prdt_img = $scsol_sn . "_leaktest_t2_p5.jpg";
  } elseif ($classNm == "radiotest_t2_file") {
    $prdt_img = $scsol_sn . "_radiotest_t2.jpg";
  } else {
    exit;
  }

  $uploadImgFile  = $path . $prdt_img;
  $allowed_ext    = array("jpg");
  //$allowed_ext = array("jpg","jpeg","png","gif");

  if (!is_dir($path)) {
    mkdir($path);
    chmod($path, 0777);
  }

  // 오류 확인
  if (!isset($_FILES[$classNm]["error"])) {
    echo json_encode(array(
      "status" => "error",
      "message" => "파일이 첨부되지 않았습니다."
    ));
    exit;
  }

  $error = $_FILES[$classNm]["error"];
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
      "status" => "error",
      "message" => $message
    ));
    exit;
  }

  // 변수 정리
  $name = $_FILES[$classNm]["name"];
  $ext  = array_pop(explode(".", $name));

  // 확장자 확인
  if (!in_array($ext, $allowed_ext)) {
    echo json_encode(array(
      "status" => "error",
      "message" => "허용되지 않는 확장자입니다."
    ));
    exit;
  }

  // 파일 이동
  move_uploaded_file($_FILES[$classNm]["tmp_name"], $uploadImgFile);
  $data['check'] = "이미지를 서버에 저장하였습니다.";

  //파일 정보 출력
  // echo json_encode(array(
  //   "status"    => "OK",
  //   "scsol_sn" => $scsol_sn,
  //   "name"      => $name,
  //   "ext"       => $ext,
  //   "path"      => $path,
  //   "type"      => $_FILES[$classNm]["type"],
  //   "size"      => $_FILES[$classNm]["size"]
  // ));

} else {
  // 저장할 이미지 무
  $data['check'] = "서버에 저장할 이미지가 없습니다.";
}

echo json_encode($data);
