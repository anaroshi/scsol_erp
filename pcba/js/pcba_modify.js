'use strict';

$(document).ready(function () {

  let filename  = "";
  let id        = ""; 
  let pcba_sn   = "";
  let pcba_img  = "";  
  let pos       = "";
  let ext       = "";
  let classNm   = "";

  $('#myfile').bind('change', function() {
    id        = $('.pcba_l.pcba_id').val();
    pcba_sn   = $('.pcba_l.pcba_sn').val();
    pcba_img  = "radio.jpg";

		$("<form action='upload_ok.php' enctype='multipart/form-data' method='post'/>")
			.ajaxForm({
				dataType: 'json',
        data: { id, pcba_sn, pcba_img },
				beforeSend: function() {
					$('#result').append( "beforeSend...\n" );
				},
				complete: function(data) {
					$('#result')
						.append( "complete...\n" )
						.append( JSON.stringify( data.responseJSON ) + "\n" );
				}
			})
			.append( $(this) )
			.submit();
	});


  /**
   * 파일선택 Button
   * 라디오 이미지
   * 이미지명 표기
   * 서버에 사진 upload
   */
  $('.pcba_img_radio_file').on('change',function(){
    
    if(window.FileReader) {
      filename = $(this)[0].files[0].name;
    } else {
      filename = $(this).val().split('/').pop().split('\\').pop();
    }
    $('.pcba_l.pcba_img_radio').val(filename);

    /** 확장자 [.jpg] check ***************************************/

    pos = filename.indexOf(".");
    if(pos<0) {
      alert("확장자가 [.jpg]만 허용됩니다.");
      $('.pcba_l.pcba_img_radio').val("");
      $('input.pcba_l.pcba_img_radio_file').val("");
      $('.pcba_l.pcba_img_radio').focus();
      return false;       
    }

    ext = filename.slice(filename.indexOf(".")+1).toLowerCase();
    if(ext!='jpg') {
      alert("확장자가 [.jpg]만 허용됩니다.");
      $('.pcba_l.pcba_img_radio').val("");
      $('input.pcba_l.pcba_img_radio_file').val("");
      $('.pcba_l.pcba_img_radio').focus();
      return false;
    }
    
    /** 이미지 표시 ************************************************/
    let reader = new FileReader();
    reader.onload = function(event) {
      let img = document.createElement("img");
      img.setAttribute("src", event.target.result);
      let parentNode = document.querySelector("div#image_container_radio");
      if (parentNode.hasChildNodes()) {
      //  alert('hasChildNode');
        $("div#image_container_radio").empty();
      }
      parentNode.appendChild(img);
    };
    reader.readAsDataURL(event.target.files[0]);
    /***************************************************************/

    id        = $('.pcba_l.pcba_id').val();
    pcba_sn   = $('.pcba_l.pcba_sn').val();
    pcba_img  = "radio.jpg";
    classNm   = "img_radio_file";

    $("<form action='pcba_img_upload.php' enctype='multipart/form-data' method='post'/>")
    .ajaxForm({
      dataType: 'json',
      data: { id, pcba_sn, pcba_img, classNm },
      beforeSend: function() {
        //$('#result').append( "beforeSend...\n" );
      },
      complete: function(data) {
        // $('#result')
        //   .append( "complete...\n" )
        //   .append( JSON.stringify( data.responseJSON ) + "\n" );
      }
    })
    .append( $(this) )
    .submit();

  });

  /**
   * 파일선택 Button
   * ADC 이미지
   * 이미지명 표기
   * 서버에 사진 upload
   */
  $('.pcba_img_adc_file').on('change',function(){
    
    if(window.FileReader) {
      filename = $(this)[0].files[0].name;
    } else {
      filename = $(this).val().split('/').pop().split('\\').pop();
    }
    $('.pcba_l.pcba_img_adc').val(filename);

    /***************************************************/

    pos = filename.indexOf(".");
    if(pos<0) {
      alert("확장자가 [.jpg]만 허용됩니다.");
      $('.pcba_l.pcba_img_adc').val("");
      $('input.pcba_l.pcba_img_adc_file').val("");
      $('.pcba_l.pcba_img_adc').focus();
      return false;       
    }

    ext = filename.slice(filename.indexOf(".")+1).toLowerCase();
    if(ext!='jpg') {
      alert("확장자가 [.jpg]만 허용됩니다.");
      $('.pcba_l.pcba_img_adc').val("");
      $('input.pcba_l.pcba_img_adc_file').val("");
      $('.pcba_l.pcba_img_adc').focus();
      return false;
    }

    /** 이미지 표시 ************************************************/
    let reader = new FileReader();
    reader.onload = function(event) {
      let img = document.createElement("img");
      img.setAttribute("src", event.target.result);
      let parentNode = document.querySelector("div#image_container_adc");
      if (parentNode.hasChildNodes()) {
      //  alert('hasChildNode');
        $("div#image_container_adc").empty();
      }
      parentNode.appendChild(img);
    };
    reader.readAsDataURL(event.target.files[0]);
    /***************************************************************/
    
    id        = $('.pcba_l.pcba_id').val();
    pcba_sn   = $('.pcba_l.pcba_sn').val();
    pcba_img  = "adc.jpg";
    classNm   = "img_adc_file";

    $("<form action='pcba_img_upload.php' enctype='multipart/form-data' method='post'/>")
    .ajaxForm({
      dataType: 'json',
      data: { id, pcba_sn, pcba_img, classNm },
      beforeSend: function() {
       // $('#result').append( "beforeSend...\n" );
      },
      complete: function(data) {
        // $('#result')
        //   .append( "complete...\n" )
        //   .append( JSON.stringify( data.responseJSON ) + "\n" );
      }
    })
    .append( $(this) )
    .submit();

  });


  /**
   * 이미지 삭제
   * DB 테이블에 이름만 지우는 것으로 2021-03-23
   * 서버에는 파일이 남아 있음.
   */
  $('.btn.pcba_img_radio_del').on('click', function () {
    $('#pcba_img_radio').val("");
    $('div#image_container_radio').empty();
  });

  $('.btn.pcba_img_adc_del').on('click', function () {
    $('#pcba_img_adc').val("");
    $('div#image_container_adc').empty();
  });

});