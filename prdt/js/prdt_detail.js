'use strict';

$(document).ready(function () {
  let filename            = "";  
  let classNm             = "";
  let selector            = ""; 
  let sltImgNm            = ""; 
  let sltImgFile          = ""; 
  let sltImg              = "";

  let scsol_sn            = "";
  let pcba_sn             = "";
  let sensor_sn	          = "";
  let battery_sn          = "";
  let case_sn	            = "";
  let pcba_sn_ex          = "";
  let sensor_sn_ex        = "";
  let battery_sn_ex       = "";
  let case_sn_ex	        = "";
  let fwVersion_ex	      = "";
  let leaktest_t1_p4      = "";
  let leaktest_t1_p4_img  = "";
  let leaktest_t1_p5      = "";
  let leaktest_t1_p5_img  = "";
  let radiotest_t1        = "";
  let radiotest_t1_img    = "";
  let mold                = "";
  let mold_img1           = "";
  let mold_img2           = "";
  let leaktest_t2_p4      = "";
  let leaktest_t2_p4_img  = "";
  let leaktest_t2_p5      = "";
  let leaktest_t2_p5_img  = "";
  let radiotest_t2        = "";
  let radiotest_t2_img    = "";
  let comment1	          = "";
  let comment2	          = "";
  let comment3	          = "";
  let etc                 = "";
  let flag                = "";
  let status              = "";
  let finalState          = "";
  let reuser              = "";
  let reuser_ex           = "";

  let reader              = "";
  let img                 = "";
  let parentNode          = "";
  let answer              = "";
  
  const leaktest_t1_p4_selector   = '.prdt_leaktest_t1_p4_file';
  const leaktest_t1_p4_sltImgNm   = '.prdt_img.prdt_leaktest_t1_p4';
  const leaktest_t1_p4_sltImgFile = 'input.prdt_l.prdt_leaktest_t1_p4_file';
  const leaktest_t1_p4_sltImg     = 'div#image_container_leaktest_t1_p4'; 
  const leaktest_t1_p5_selector   = '.prdt_leaktest_t1_p5_file';
  const leaktest_t1_p5_sltImgNm   = '.prdt_img.prdt_leaktest_t1_p5';
  const leaktest_t1_p5_sltImgFile = 'input.prdt_l.prdt_leaktest_t1_p5_file';
  const leaktest_t1_p5_sltImg     = 'div#image_container_leaktest_t1_p5';  
  const radiotest_t1_selector     = '.prdt_radiotest_t1_file';
  const radiotest_t1_sltImgNm     = '.prdt_img.prdt_radiotest_t1';
  const radiotest_t1_sltImgFile   = 'input.prdt_l.prdt_radiotest_t1_file';
  const radiotest_t1_sltImg       = 'div#image_container_radiotest_t1';
  const mold_selector1            = '.prdt_mold_file1';
  const mold_sltImgNm1            = '.prdt_img.prdt_mold1';
  const mold_sltImgFile1          = 'input.prdt_l.prdt_mold_file1';
  const mold_sltImg1              = 'div#image_container_mold1';
  const mold_selector2            = '.prdt_mold_file2';
  const mold_sltImgNm2            = '.prdt_img.prdt_mold2';
  const mold_sltImgFile2          = 'input.prdt_l.prdt_mold_file2';
  const mold_sltImg2              = 'div#image_container_mold2';
  const leaktest_t2_p4_selector   = '.prdt_leaktest_t2_p4_file';
  const leaktest_t2_p4_sltImgNm   = '.prdt_img.prdt_leaktest_t2_p4';
  const leaktest_t2_p4_sltImgFile = 'input.prdt_l.prdt_leaktest_t2_p4_file';
  const leaktest_t2_p4_sltImg     = 'div#image_container_leaktest_t2_p4';
  const leaktest_t2_p5_selector   = '.prdt_leaktest_t2_p5_file';
  const leaktest_t2_p5_sltImgNm   = '.prdt_img.prdt_leaktest_t2_p5';
  const leaktest_t2_p5_sltImgFile = 'input.prdt_l.prdt_leaktest_t2_p5_file';
  const leaktest_t2_p5_sltImg     = 'div#image_container_leaktest_t2_p5';
  const radiotest_t2_selector     = '.prdt_radiotest_t2_file';
  const radiotest_t2_sltImgNm     = '.prdt_img.prdt_radiotest_t2';
  const radiotest_t2_sltImgFile   = 'input.prdt_l.prdt_radiotest_t2_file';
  const radiotest_t2_sltImg       = 'div#image_container_radiotest_t2';
  
  $('.ui.selection.dropdown')
  .dropdown({
    clearable: true,
    fullTextSearch: true
  });


  $('.test.checkbox').checkbox('attach events', '.toggle.button');

  /**************************************************************************************
   * 초기화 Button
   * make all fields empty
   **************************************************************************************/
  $('.prdt_clear').on('click', function() {
    location.reload();    
  });      

  /**************************************************************************************
   * 저장 Button
   * save all data into fields that selected and inserted
   **************************************************************************************/
   $('.prdt_btn.prdt_int').on('click', function() {
    
    scsol_sn            = $('.scsol_sn').val();
    pcba_sn             = $('.pcba_sn').val();
    sensor_sn	          = $('.sensor_sn').val();
    battery_sn          = $('.battery_sn').val();
    //case_sn	            = $('.case_sn').val();
    fwVesrion           = $('.fwVersion').val();
    pcba_sn_ex          = $('.pcba_sn_ex').val();
    sensor_sn_ex	      = $('.sensor_sn_ex').val();
    battery_sn_ex       = $('.battery_sn_ex').val();
    //case_sn_ex	        = $('.case_sn_ex').val();
    fwVersion_ex        = $('.fwVesrion_ex').val();
    leaktest_t1_p4      = chk('#leaktest_t1_p4');
    leaktest_t1_p4_img  = $(leaktest_t1_p4_sltImgNm).val();
    leaktest_t1_p5      = chk('#leaktest_t1_p5');
    leaktest_t1_p5_img  = $(leaktest_t1_p5_sltImgNm).val();
    radiotest_t1        = chk('#radiotest_t1');
    radiotest_t1_img    = $(radiotest_t1_sltImgNm).val();
    mold                = chk('#mold');
    mold_img1           = $(mold_sltImgNm1).val();
    mold_img2           = $(mold_sltImgNm2).val();
    leaktest_t2_p4      = chk('#leaktest_t2_p4');
    leaktest_t2_p4_img  = $(leaktest_t2_p4_sltImgNm).val();
    leaktest_t2_p5      = chk('#leaktest_t2_p5');
    leaktest_t2_p5_img  = $(leaktest_t2_p5_sltImgNm).val();
    radiotest_t2        = chk('#radiotest_t2');
    radiotest_t2_img    = $(radiotest_t2_sltImgNm).val();
    comment1	          = $('#comment1').val();
    comment2	          = $('#comment2').val();
    comment3	          = $('#comment3').val();
    etc                 = $('#etc').val();
    finalState          = chk('#finalState');
    reuser              = $('.reuser').val();
    reuser_ex           = $('.reuser_ex').val();

    if (reuser == "") {
      alert("담당자를 선택하세요.");
      return false;
    }

    // alert(`scsol_sn: ${scsol_sn}, pcba_sn: ${pcba_sn}, pcba_sn_ex: ${pcba_sn_ex}, sensor_sn: ${sensor_sn}, sensor_sn_ex: ${sensor_sn_ex}`);
    // alert(`battery_sn: ${battery_sn}, battery_sn_ex: ${battery_sn_ex}, fwVesrion: ${fwVesrion}, fwVesrion_ex: ${fwVesrion_ex}`);
    // alert(`leaktest_t1_p4: ${leaktest_t1_p4}:${leaktest_t1_p4_img}, leaktest_t1_p5: ${leaktest_t1_p5}:${leaktest_t1_p5_img}, radiotest_t1: ${radiotest_t1}:${radiotest_t1_img}`); 
    // alert(`mold: ${mold}:${mold_img1}:${mold_img2}`);
    // alert(`leaktest_t2_p4: ${leaktest_t2_p4}:${leaktest_t2_p4_img}, leaktest_t2_p5: ${leaktest_t2_p5}:${leaktest_t2_p5_img}, radiotest_t2: ${radiotest_t2}:${radiotest_t2_img}`);
    // alert(`comment1: ${comment1}, comment2: ${comment2}, comment3: ${comment3}`);
    // alert(`etc: ${etc}, finalState: ${finalState}`);

    $.ajax({
      type: "POST",
      url: "./prdt_detail_save.php",
      data: {
        scsol_sn, pcba_sn, sensor_sn, battery_sn, fwVesrion, pcba_sn_ex, sensor_sn_ex, battery_sn_ex, fwVesrion_ex, 
        leaktest_t1_p4, leaktest_t1_p4_img, leaktest_t1_p5, leaktest_t1_p5_img, radiotest_t1, radiotest_t1_img, mold, mold_img1, mold_img2,
        leaktest_t2_p4, leaktest_t2_p4_img, leaktest_t2_p5, leaktest_t2_p5_img, radiotest_t2, radiotest_t2_img,
        comment1, comment2, comment3, etc, finalState, reuser, reuser_ex
      },
      dataType: "html",
    })
    .done(function (data) {
      console.log('return : ' + data);
      if (data == 0) {
        alert('수정되었습니다.');
      } else if (data == 1) {
        alert('수정 실폐입니다.');
      }
      location.reload();
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    })

  });      


  /**************************************************************************************
   * 삭제 Button
   * save all data in fields that selected and inserted
   **************************************************************************************/  
  $('.prdt_btn.prdt_del').on('click', function() {
    
    scsol_sn            = $('.scsol_sn').val();
    pcba_sn             = $('.pcba_sn').val();
    sensor_sn	          = $('.sensor_sn').val();
    battery_sn          = $('.battery_sn').val();
    fwVesrion	          = $('.fwVesrion').val();
    reuser              = $('.reuser').val();
    if (reuser == "") {
      alert("담당자를 선택하세요.");
      return false;
    }
    
    answer = confirm("생산을 삭제하시겠습니까?");
    if (answer == true) {
      $.ajax({
        type: "POST",
        url: "./prdt_del.php",
        data: { scsol_sn, pcba_sn, sensor_sn, battery_sn, fwVesrion, reuser },
        dataType: "html",
      })
      .done(function (data) {
        console.log('return : ' + data);
        if (data == 0) {
          alert('삭제되었습니다.');
        } else if (data == 1) {
          alert('삭제 실폐입니다.');
        }
        location.reload()
        window.history.back();
        //window.history.go(-2);
        
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.log('서버오류: ' + textStatus);
        console.log('서버오류: ' + errorThrown);
      })
    }
  });  


  /**************************************************************************************
   * PCBA selection dropdown
   * get the PCBA SN selected
   **************************************************************************************/
   $('.menu.pcba_sn.transition.hidden').on('click', function() {
    let pcba_sn = $('.item.part_pcba.active.selected').text();
    $('input.pcba_sn').val(pcba_sn);
  });  


  /***************************************************************************************
   * SENSOR selection dropdown
   * get the SENSOR SN selected
   **************************************************************************************/
   $('.menu.sensor_sn.transition.hidden').on('click', function() {
    let sensor_sn = $('.item.sensor_sn.active.selected').text();
    $('input.sensor_sn').val(sensor_sn);
  });  


  /***************************************************************************************
   * BATTERY selection dropdown
   * get the BATTERY SN selected
   **************************************************************************************/
   $('.menu.battery_sn.transition.hidden').on('click', function() {
    let battery_sn = $('.item.battery_sn.active.selected').text();
    $('input.battery_sn').val(battery_sn);
  });  


  /***************************************************************************************
   * CASE selection dropdown
   * get the CASE SN selected
   **************************************************************************************/
   $('.menu.case_sn.transition.hidden').on('click', function() {
    let case_sn = $('.item.case_sn.active.selected').text();
    $('input.case_sn').val(case_sn);
  });  

  /***************************************************************************************
   * 담당자 selection dropdown
   * get the user selected
   **************************************************************************************/
    $('.menu.reuser.transition.hidden').on('click', function() {
    let reuser = $('.item.reuser.active.selected').text();
    $('input.reuser').val(reuser);
  });  

  /***************************************************************************************
   * Checkbox
   * 값얻기
   **************************************************************************************/
  function chk(selector) {
    let value = 'F';
    if ($(selector).is(":checked") == true) {
      value = 'P';
    }
    return value;
  }
  
  /***************************************************************************************
   * leaktest_t1_p4 : 파일선택 Button
   * leaktest_t1_p4 이미지
   * 이미지명 표기
   * 서버에 사진 upload
   **************************************************************************************/  
  $('.prdt_leaktest_t1_p4_file').on('change',function() {

    /** 파일 선택시 필드에 이미지명 입력 ****************************/
    filename = getFileName(leaktest_t1_p4_selector);
    $(leaktest_t1_p4_sltImgNm).val(filename);

    /** 확장자 [.jpg] check ***************************************/
    if (!chkFileExtension(filename)) {      
      cleanAboutImg(leaktest_t1_p4_sltImgNm, leaktest_t1_p4_sltImgFile, leaktest_t1_p4_sltImg);
      return;
    } else {
    /** 파일 로드 **************************************************/
      loadDisplayImage(leaktest_t1_p4_sltImg);
      
      classNm   = "leaktest_t1_p4_file";
      scsol_sn  = $('.scsol_sn').val();    
      $("<form action='prdt_img_upload.php' enctype='multipart/form-data' method='post'/>")
      .ajaxForm({
        dataType: 'json',
        data: { scsol_sn, classNm },
        success: function(data) {
        },
        fail:function (jqXHR, textStatus, errorThrown) {
          console.log('서버오류: ' + textStatus);
          console.log('서버오류: ' + errorThrown);
        }
      })
      .append($(this))
      .submit();
    }
  });
    
  /***************************************************************************************
   * leaktest_t1_p5 : 파일선택 Button
   * leaktest_t1_p5 이미지
   * 이미지명 표기
   * 서버에 사진 upload
   **************************************************************************************/
  $('.prdt_leaktest_t1_p5_file').on('change',function() {
   
    filename = getFileName(leaktest_t1_p5_selector);
    $(leaktest_t1_p5_sltImgNm).val(filename);

    if (!chkFileExtension(filename)) { 
      cleanAboutImg(leaktest_t1_p5_sltImgNm, leaktest_t1_p5_sltImgFile, leaktest_t1_p5_sltImg);
      return;
    } else {
    
      loadDisplayImage(leaktest_t1_p5_sltImg);
      
      classNm = "leaktest_t1_p5_file";
      scsol_sn  = $('.scsol_sn').val();    
      $("<form action='prdt_img_upload.php' enctype='multipart/form-data' method='post'/>")
      .ajaxForm({
        dataType: 'json',
        data: { scsol_sn, classNm },
        success: function(data) {
        },
        fail:function (jqXHR, textStatus, errorThrown) {
          console.log('서버오류: ' + textStatus);
          console.log('서버오류: ' + errorThrown);
        }
      })
      .append($(this))
      .submit();
    }  
  });

  /***************************************************************************************
   * radiotest_t1 : 파일선택 Button
   * radiotest_t1 이미지
   * 이미지명 표기
   * 서버에 사진 upload
   **************************************************************************************/
  $('.prdt_radiotest_t1_file').on('change',function() {
   
    filename = getFileName(radiotest_t1_selector);
    $(radiotest_t1_sltImgNm).val(filename);

    if (!chkFileExtension(filename)) {      
      cleanAboutImg(radiotest_t1_sltImgNm, radiotest_t1_sltImgFile, radiotest_t1_sltImg);
      return;
    } else {
      loadDisplayImage(radiotest_t1_sltImg);
      
      classNm = "radiotest_t1_file";
      scsol_sn  = $('.scsol_sn').val();    
      $("<form action='prdt_img_upload.php' enctype='multipart/form-data' method='post'/>")
      .ajaxForm({
        dataType: 'json',
        data: { scsol_sn, classNm },
        success: function(data) {
        },
        fail:function (jqXHR, textStatus, errorThrown) {
          console.log('서버오류: ' + textStatus);
          console.log('서버오류: ' + errorThrown);
        }
      })
      .append($(this))
      .submit();
    }  
  });
    

  /***************************************************************************************
   * mold1 : 파일선택 Button
   * mold1 이미지
   * 이미지명 표기
   * 서버에 사진 upload
   **************************************************************************************/
  $('.prdt_mold_file1').on('change',function() {
   
    filename = getFileName(mold_selector1);
    $(mold_sltImgNm1).val(filename);

    if (!chkFileExtension(filename)) {      
      cleanAboutImg(mold_sltImgNm1, mold_sltImgFile1, mold_sltImg1);
      return;
    } else {

      loadDisplayImage(mold_sltImg1);
      
      classNm = "mold_file1";
      scsol_sn  = $('.scsol_sn').val();    
      $("<form action='prdt_img_upload.php' enctype='multipart/form-data' method='post'/>")
      .ajaxForm({
        dataType: 'json',
        data: { scsol_sn, classNm },
        success: function(data) {
        },
        fail:function (jqXHR, textStatus, errorThrown) {
          console.log('서버오류: ' + textStatus);
          console.log('서버오류: ' + errorThrown);
        }
      })
      .append($(this))
      .submit();
    }  
  });


  /***************************************************************************************
   * mold : 파일선택 Button
   * mold 이미지
   * 이미지명 표기
   * 서버에 사진 upload
   **************************************************************************************/
   $('.prdt_mold_file2').on('change',function() {
   
    filename = getFileName(mold_selector2);
    $(mold_sltImgNm2).val(filename);

    if (!chkFileExtension(filename)) {      
      cleanAboutImg(mold_sltImgNm2, mold_sltImgFile2, mold_sltImg2);
      return;
    } else {

      loadDisplayImage(mold_sltImg2);
      
      classNm = "mold_file2";
      scsol_sn  = $('.scsol_sn').val();    
      $("<form action='prdt_img_upload.php' enctype='multipart/form-data' method='post'/>")
      .ajaxForm({
        dataType: 'json',
        data: { scsol_sn, classNm },
        success: function(data) {
        },
        fail:function (jqXHR, textStatus, errorThrown) {
          console.log('서버오류: ' + textStatus);
          console.log('서버오류: ' + errorThrown);
        }
      })
      .append($(this))
      .submit();
    }  
  });


  /***************************************************************************************
   * leaktest_t2_p4 : 파일선택 Button
   * leaktest_t2_p4 이미지
   * 이미지명 표기
   * 서버에 사진 upload
   **************************************************************************************/  
   $('.prdt_leaktest_t2_p4_file').on('change',function() {

    filename = getFileName(leaktest_t2_p4_selector);
    $(leaktest_t2_p4_sltImgNm).val(filename);

    if (!chkFileExtension(filename)) {      
      cleanAboutImg(leaktest_t2_p4_sltImgNm, leaktest_t2_p4_sltImgFile, leaktest_t2_p4_sltImg);
      return;
    } else {

      loadDisplayImage(leaktest_t2_p4_sltImg);

      classNm = "leaktest_t2_p4_file";
      scsol_sn  = $('.scsol_sn').val();    
      $("<form action='prdt_img_upload.php' enctype='multipart/form-data' method='post'/>")
      .ajaxForm({
        dataType: 'json',
        data: { scsol_sn, classNm },
        success: function(data) {
        },
        fail:function (jqXHR, textStatus, errorThrown) {
          console.log('서버오류: ' + textStatus);
          console.log('서버오류: ' + errorThrown);
        }
      })
      .append($(this))
      .submit();
    }  
  });

  /***************************************************************************************
   * leaktest_t2_p5 : 파일선택 Button
   * leaktest_t2_p5 이미지
   * 이미지명 표기
   * 서버에 사진 upload
   **************************************************************************************/
    $('.prdt_leaktest_t2_p5_file').on('change',function() {    
    
    filename = getFileName(leaktest_t2_p5_selector);
    $(leaktest_t2_p5_sltImgNm).val(filename);

    if (!chkFileExtension(filename)) {      
      cleanAboutImg(leaktest_t2_p5_sltImgNm, leaktest_t2_p5_sltImgFile, leaktest_t2_p5_sltImg);
      return;
    } else {

      loadDisplayImage(leaktest_t2_p5_sltImg);

      classNm = "leaktest_t2_p5_file";
      scsol_sn  = $('.scsol_sn').val();    
      $("<form action='prdt_img_upload.php' enctype='multipart/form-data' method='post'/>")
      .ajaxForm({
        dataType: 'json',
        data: { scsol_sn, classNm },
        success: function(data) {
        },
        fail:function (jqXHR, textStatus, errorThrown) {
          console.log('서버오류: ' + textStatus);
          console.log('서버오류: ' + errorThrown);
        }
      })
      .append($(this))
      .submit();
    }  
  });

  /***************************************************************************************
   * radiotest_t2 : 파일선택 Button
   * radiotest_t2 이미지
   * 이미지명 표기
   * 서버에 사진 upload
   **************************************************************************************/
  $('.prdt_radiotest_t2_file').on('change',function() {
    
    filename = getFileName(radiotest_t2_selector);
    $(radiotest_t2_sltImgNm).val(filename);

    if (!chkFileExtension(filename)) {
      cleanAboutImg(radiotest_t2_sltImgNm, radiotest_t2_sltImgFile, radiotest_t2_sltImg);
      return;
    } else {

      loadDisplayImage(radiotest_t2_sltImg);

      classNm = "radiotest_t2_file";
      scsol_sn  = $('.scsol_sn').val();    
      $("<form action='prdt_img_upload.php' enctype='multipart/form-data' method='post'/>")
      .ajaxForm({
        dataType: 'json',
        data: { scsol_sn, classNm },
        success: function(data) {
        },
        fail:function (jqXHR, textStatus, errorThrown) {
          console.log('서버오류: ' + textStatus);
          console.log('서버오류: ' + errorThrown);
        }
      })
      .append($(this))
      .submit();
    }

    // $('.ui.progress')
    // .progress({
    //   duration : 200,
    //   total    : 200,
    //   text     : {
    //     active: '{value} of {total} done'
    //   }
    // });
    // $('div.#progress').on('mouseover', function () {
    //   alert("progress");
    // });
    
    
    // $('#progress').progress({
    //   percent: 22
    // });


    
  });

  /***************************************************************************************
   * 이미지 삭제
   * DB 테이블에 이름만 지우는 것으로 서버에는 파일이 남아 있음.
   **************************************************************************************/
  $('.btn.prdt_leaktest_t1_p4_del').on('click', function () {
    cleanAboutImg(leaktest_t1_p4_sltImgNm, leaktest_t1_p4_sltImgFile, leaktest_t1_p4_sltImg);
  });

  $('.btn.prdt_leaktest_t1_p5_del').on('click', function () {
    cleanAboutImg(leaktest_t1_p5_sltImgNm, leaktest_t1_p5_sltImgFile, leaktest_t1_p5_sltImg);
  });

  $('.btn.prdt_radiotest_t1_del').on('click', function () {
    cleanAboutImg(radiotest_t1_sltImgNm, radiotest_t1_sltImgFile, radiotest_t1_sltImg);
  });

  $('.btn.prdt_mold_del').on('click', function () {
    cleanAboutImg(mold_sltImgNm, mold_sltImgFile, mold_sltImg);
  });

  $('.btn.prdt_leaktest_t2_p4_del').on('click', function () {
    cleanAboutImg(leaktest_t2_p4_sltImgNm, leaktest_t2_p4_sltImgFile, leaktest_t2_p4_sltImg);
  });

  $('.btn.prdt_leaktest_t2_p5_del').on('click', function () {
    cleanAboutImg(leaktest_t2_p5_sltImgNm, leaktest_t2_p5_sltImgFile, leaktest_t2_p5_sltImg);
  });

  $('.btn.prdt_radiotest_t2_del').on('click', function () {
    cleanAboutImg(radiotest_t2_sltImgNm, radiotest_t2_sltImgFile, radiotest_t2_sltImg);    
  });


  /** 1. getFileName ****************************/
  function getFileName(selector) {
    if(window.FileReader) {
      filename = $(selector)[0].files[0].name;
    } else {
      filename = $(selector).val().split('/').pop().split('\\').pop();
    }
    return filename;
  }

  /** 2. chkFileExtension ****************************/
  function chkFileExtension(filename) {
    let pos = filename.indexOf(".");
    let ext = filename.slice(filename.indexOf(".")+1).toLowerCase();
    if(pos<0 || ext!='jpg') {
      alert("확장자가 [.jpg]만 허용됩니다.");
      return false;
    }
    return true;
  }
    
  /** 3. loadDisplayImage ************************************************/
  function loadDisplayImage(sltImg) {
    reader = new FileReader();
    reader.onload = function(event) {
      img = document.createElement("img");
      img.setAttribute("src", event.target.result);
      parentNode = document.querySelector(sltImg);
      if (parentNode.hasChildNodes()) {
      //  alert('hasChildNode');
        $(sltImg).empty();
      }
      parentNode.appendChild(img);
    };
    reader.readAsDataURL(event.target.files[0]);
  }

  /** 4. cleanImageFields ************************************************/
  function cleanAboutImg(sltImgNm, sltImgFile, sltImg) {
    $(sltImgNm).val("");
    $(sltImgFile).val("");
    $(sltImg).empty();
  }
});