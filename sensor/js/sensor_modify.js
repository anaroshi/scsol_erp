'use strict';

$(document).ready(function () {

  let img_filename  = "";
  let pos           = "";
  let ext           = "";
  let id            = "";
  let sensor_sn     = "";   
  let sensor_img    = "";  
  let classNm       = "";  
  
  /**
   * 파일선택 Button
   * sensor_image_1
   * 이미지명 표기
   * 서버에 사진 upload
   */
  $('.sensor_image_1_file').on('change',function(){

    if(window.FileReader) {
      img_filename = $(this)[0].files[0].name;
    } else {
      img_filename = $(this).val().split('/').pop().split('\\').pop();
    }
    $('.sensor_img.sensor_image_1').val(img_filename);


    /** 확장자 [.jpg] check ***************************************/

    pos = img_filename.indexOf(".");
    if(pos<0) {
      alert("확장자가 [.jpg]만 허용됩니다.")
      $('.sensor_img.sensor_image_1').val("");
      $('input.sensor_l.sensor_image_1_file').val("");
      $('.seneor_img.sensor_image_1').focus();
      return false;
    }

    ext = img_filename.slice(img_filename.indexOf(".")+1).toLowerCase();
    if(ext!='jpg') {
      alert("확장자가 [.jpg]만 허용됩니다.");
      $('.sensor_img.sensor_image_1').val("");
      $('input.sensor_l.sensor_image_1_file').val("");
      $('.seneor_img.sensor_image_1').focus();
      return false;
    } 

    /** 이미지 표시 ************************************************/
    let reader    = new FileReader();
    reader.onload = function(event) {
      let img     = document.createElement("img");
      img.setAttribute("src", event.target.result);
      let parentNode = document.querySelector("div#image_container_image_1");
      if (parentNode.hasChildNodes()) {
        $("div#image_container_image_1").empty();
      }
      parentNode.appendChild(img);
    };
    reader.readAsDataURL(event.target.files[0]);

    /***************************************************************/

    id          = $('.sensor_l.sensor_id').val();
    sensor_sn   = $('.sensor_l.sensor_sn').val();
    sensor_img  = "image_1.jpg";
    classNm     = "image_1_file";

    $("<form action='sensor_img_upload.php' enctype='multipart/form-data' method='post'/>")
    .ajaxForm({
      dataType: 'json',
      data: { id, sensor_sn, sensor_img, classNm },
      // beforeSend: function() {
      //   $('#result').append("beforeSend...\n");
      // },
      complete: function(data) {
        // $('#result')
        // .append("complete...\n")
        // .append( JSON.stringify(data.responseJSON) + "\n" );
      }
    })
    .append($(this))
    .submit();

  });


  /**
   * 파일선택 Button
   * sensor_image_2
   * 이미지명 표기
   * 서버에 사진 upload
   */  
  $('.sensor_image_2_file').on('change',function(){
    if(window.FileReader) {
      img_filename = $(this)[0].files[0].name;
    } else {
      img_filename = $(this).val().split('/').pop().split('\\').pop();
    }
    $('.sensor_img.sensor_image_2').val(img_filename);


    /** 확장자 [.jpg] check ***************************************/
    pos = img_filename.indexOf(".");
    if(pos<0) {
      alert("확장자가 [.jpg]만 허용됩니다.")
      $('.sensor_img.sensor_image_2').val("");
      $('input.sensor_l.sensor_image_2_file').val("");
      $('.seneor_img.sensor_image_2').focus();
      return false;
    }

    ext = img_filename.slice(img_filename.indexOf(".")+1).toLowerCase();
    if(ext!='jpg') {
      alert("확장자가 [.jpg]만 허용됩니다.");
      $('.sensor_img.sensor_image_2').val("");
      $('input.sensor_l.sensor_image_2_file').val("");
      $('.seneor_img.sensor_image_2').focus();
      return false;
    } 


    /** 이미지 표시 ************************************************/
    let reader = new FileReader();
    reader.onload = function(event) {
      let img = document.createElement("img");
      img.setAttribute("src", event.target.result);
      let parentNode = document.querySelector("div#image_container_image_2");
      if (parentNode.hasChildNodes()) {
        $("div#image_container_image_2").empty();
      }
      parentNode.appendChild(img);
    };
    reader.readAsDataURL(event.target.files[0]);

    /***************************************************************/

    id          = $('.sensor_l.sensor_id').val();
    sensor_sn   = $('.sensor_l.sensor_sn').val();
    sensor_img  = "image_2.jpg";
    classNm     = "image_2_file";

    $("<form action='sensor_img_upload.php' enctype='multipart/form-data' method='post'/>")
    .ajaxForm({
      dataType: 'json',
      data: { id, sensor_sn, sensor_img, classNm },
      // beforeSend: function() {
      //   $('#result').append("beforeSend...\n");
      // },
      complete: function(data) {
        // $('#result')
        // .append("complete...\n")
        // .append( JSON.stringify(data.responseJSON) + "\n" );
      }
    })
    .append($(this))
    .submit();

  });


  /**
   * 파일선택 Button
   * sensor_image_3
   * 이미지명 표기
   * 서버에 사진 upload
   */  
   $('.sensor_image_3_file').on('change',function(){
    
    if(window.FileReader) {
      img_filename = $(this)[0].files[0].name;
    } else {
      img_filename = $(this).val().split('/').pop().split('\\').pop();
    }
    $('.sensor_img.sensor_image_3').val(img_filename);


    /** 확장자 [.jpg] check ***************************************/
    pos = img_filename.indexOf(".");
    if(pos<0) {
      alert("확장자가 [.jpg]만 허용됩니다.")
      $('.sensor_img.sensor_image_3').val("");
      $('input.sensor_l.sensor_image_3_file').val("");
      $('.seneor_img.sensor_image_3').focus();
      return false;
    }

    ext = img_filename.slice(img_filename.indexOf(".")+1).toLowerCase();
    if(ext!='jpg') {
      alert("확장자가 [.jpg]만 허용됩니다.");
      $('.sensor_img.sensor_image_3').val("");
      $('input.sensor_l.sensor_image_3_file').val("");
      $('.seneor_img.sensor_image_3').focus();
      return false;
    } 


    /** 이미지 표시 ************************************************/
    let reader = new FileReader();
    reader.onload = function(event) {
      let img = document.createElement("img");
      img.setAttribute("src", event.target.result);
      let parentNode = document.querySelector("div#image_container_image_3");
      if (parentNode.hasChildNodes()) {
        $("div#image_container_image_3").empty();
      }
      parentNode.appendChild(img);
    };
    reader.readAsDataURL(event.target.files[0]);

    /***************************************************************/

    id          = $('.sensor_l.sensor_id').val();
    sensor_sn   = $('.sensor_l.sensor_sn').val();
    sensor_img  = "image_3.jpg";
    classNm     = "image_3_file";

    $("<form action='sensor_img_upload.php' enctype='multipart/form-data' method='post'/>")
    .ajaxForm({
      dataType: 'json',
      data: { id, sensor_sn, sensor_img, classNm },
      // beforeSend: function() {
      //   $('#result').append("beforeSend...\n");
      // },
      complete: function(data) {
        // $('#result')
        // .append("complete...\n")
        // .append( JSON.stringify(data.responseJSON) + "\n" );
      }
    })
    .append($(this))
    .submit();

  });


  /**
   * 삭제 Button
   * 이미지 삭제
   * DB 테이블에 이름만 지우는 것으로 2021-03-23
   * 서버에는 파일이 남아 있음.
   */
  $('.btn.image_del_1').on('click', function () {
    $('.sensor_img.sensor_image_1').val("");
    $('div#image_container_image_1').empty();
  });

  $('.btn.image_del_2').on('click', function () {
    $('.sensor_img.sensor_image_2').val("");
    $('div#image_container_image_2').empty();
  });

  $('.btn.image_del_3').on('click', function () {
    $('.sensor_img.sensor_image_3').val("");
    $('div#image_container_image_3').empty();
  });

});


function process (sensor_sn, hz) {
  
  $.ajax({
    async: false,
    cache: false,
    type: "POST",
    url: "./sensor_hz.php",
    data: {sensor_sn,hz},
    dataType: "html",
  })
  .done(function (data) {
    console.log('success');
  })
  .fail(function (jqXHR, textStatus, errorThrown) {
    console.log('서버오류: ' + textStatus);
    console.log('서버오류: ' + errorThrown);
  })

//  alert (`sensor_sn: ${sensor_sn}, hz: ${hz}`);
}

