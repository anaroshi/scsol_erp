'use strict';

$(document).ready(function () {

  let id                  = "";
  let _tr                 = "";
  let _td                 = "";
  let reuser              = "";

  let isLength = function(string) {
    return string.length <2
  }
  
  let chk = function(selector) {
    let value = 'F';
    if ($(selector).is(":checked") == true) {
      value = 'P';
    }
    return value;
  }


  /**
   * PCBA관리 Button
   */
  $('.pcba_trad').on('click', function () {
    $(location).attr('href', '/trad/src/trad_search.php');
  });

  /**
   * 초기화 Button
   * make all fields empty
   */
  $('.pcba_clear').on('click', function () {
    location.reload();

  });


  /**
   * 조회 Button
   * showing pcba list with options selected 
   */
  //$('.pcba_search').on('click', function (e) {
  $(document).on('click', 'input.pcba_btn.pcba_search', function (e) {
    e.preventDefault();

    //processpcba(filename);

    let filename              = "pcba_search_list.php";
    let pcba_sn               = $('.pcba_input.pcba_sn').val();
    let pcba_tradDateFrom     = $('.pcba_input.pcba_tradDateFrom').val();
    let pcba_tradDateTo       = $('.pcba_input.pcba_tradDateTo').val();
    let pcba_status           = $('.pcba_input.pcba_status').val();
    let pcba_validity         = $('.pcba_input.pcba_validity').val();

    //alert(`sn: ${pcba_sn}, tradDateFrom: ${pcba_tradDateFrom} ~ ${pcba_tradDateTo}, status: ${pcba_status}`);

    $.ajax({
      type: "POST",
      url: filename,
      data: { pcba_sn, pcba_tradDateFrom, pcba_tradDateTo, pcba_status, pcba_validity },  // new FormData(this),
      async: false,
      cache: false,
      dataType: "json",
    })
    .done(function (data) {
      console.log('success');

      $('.pcba_head_total').html(data.total);
      $('.tb_pcba').html(data.outputList);
      $('tfoot').remove();
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    })
  });

  
  /**
   * PBCA_SN Head Click
   * showing pcba list with options selected  + order by pcba_sn desc / asc
   */

  $('th.h_pcba.h_pcba_b.h_pcba_sn').on('mouseover', function (e) {
    $(this).html("PBCA_SN ▲/▼"); 
  });

  $('th.h_pcba.h_pcba_b.h_pcba_sn').on('mouseout', function (e) {
    $(this).html("PBCA_SN"); 
  });


  $('th.h_pcba.h_pcba_b.h_pcba_sn').on('click', function (e) {
    e.preventDefault();

    //alert("You clicked PBCA_SN");

    let filename              = "pcba_search_list.php";
    let sn_orderby            = $('.d_pcba.d_pcba_sn').attr('name');
    let sn_sort               = "on";
    let pcba_sn               = $('.pcba_input.pcba_sn').val();
    let pcba_tradDateFrom     = $('.pcba_input.pcba_tradDateFrom').val();
    let pcba_tradDateTo       = $('.pcba_input.pcba_tradDateTo').val();
    let pcba_status           = $('.pcba_input.pcba_status').val();


//    alert(`sn: ${pcba_sn}, sn_orderby: ${sn_orderby}, sn_sort: ${sn_sort}, tradDateFrom: ${pcba_tradDateFrom} ~ ${pcba_tradDateTo}, status: ${pcba_status}`);

    $.ajax({
      type: "POST",
      url: filename,
      data: { pcba_sn, pcba_tradDateFrom, pcba_tradDateTo, pcba_status, sn_orderby, sn_sort },  // new FormData(this),
      async: false,
      cache: false,
      dataType: "json",
    })
    .done(function (data) {
      console.log('success');

      $('.pcba_head_total').html(data.total);
      $('.tb_pcba').html(data.outputList);

    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    })

  });


  /**
   * ADC Head Click
   * showing pcba list with options selected  + order by ADC desc / asc
   */

  $('th.h_pcba.h_pcba_b.h_adc').on('mouseover', function (e) {
    $(this).html("▲/▼");
  });

  $('th.h_pcba.h_pcba_b.h_adc').on('mouseout', function (e) {
    $(this).html("ADC"); 
  });


  $('th.h_pcba.h_pcba_b.h_adc').on('click', function (e) {
    e.preventDefault();

    //alert("You clicked ADC");

    let filename              = "pcba_search_list.php";
    let adc_orderby            = $('.d_pcba.d_adc').attr('name');
    let adc_sort               = "on";
    let pcba_sn               = $('.pcba_input.pcba_sn').val();
    let pcba_tradDateFrom     = $('.pcba_input.pcba_tradDateFrom').val();
    let pcba_tradDateTo       = $('.pcba_input.pcba_tradDateTo').val();
    let pcba_status           = $('.pcba_input.pcba_status').val();

    //alert(`sn: ${pcba_sn}, tradDateFrom: ${pcba_tradDateFrom} ~ ${pcba_tradDateTo}, status: ${pcba_status}`);

    $.ajax({
      type: "POST",
      url: filename,
      data: { pcba_sn, pcba_tradDateFrom, pcba_tradDateTo, pcba_status, adc_orderby, adc_sort },  // new FormData(this),
      async: false,
      cache: false,
      dataType: "json",
    })
    .done(function (data) {
      console.log('success');

      $('.pcba_head_total').html(data.total);
      $('.tb_pcba').html(data.outputList);

    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    })

  });


  /**
   * ISSUE Head Click
   * showing pcba list with options selected  + order by ISSUE desc / asc
   */

  $('th.h_pcba.h_pcba_b.h_issue').on('mouseover', function (e) {
    $(this).html("▲/▼"); 
  });

  $('th.h_pcba.h_pcba_b.h_issue').on('mouseout', function (e) {
    $(this).html("ISSUE"); 
  });


  $('th.h_pcba.h_pcba_b.h_issue').on('click', function (e) {
    e.preventDefault();

    //alert("You clicked ISSUE");

    let filename              = "pcba_search_list.php";
    let issue_orderby         = $('.d_pcba.d_issue').attr('name');
    let issue_sort            = "on";
    let pcba_sn               = $('.pcba_input.pcba_sn').val();
    let pcba_tradDateFrom     = $('.pcba_input.pcba_tradDateFrom').val();
    let pcba_tradDateTo       = $('.pcba_input.pcba_tradDateTo').val();
    let pcba_status           = $('.pcba_input.pcba_status').val();


    //alert(`sn: ${pcba_sn}, tradDateFrom: ${pcba_tradDateFrom} ~ ${pcba_tradDateTo}, status: ${pcba_status}`);

    $.ajax({
      type: "POST",
      url: filename,
      data: { pcba_sn, pcba_tradDateFrom, pcba_tradDateTo, pcba_status, issue_orderby, issue_sort },  // new FormData(this),
      async: false,
      cache: false,
      dataType: "json",
    })
    .done(function (data) {
      console.log('success');

      $('.pcba_head_total').html(data.total);
      $('.tb_pcba').html(data.outputList);

    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    })
  });


  /**
   * 엑셀 다운로드 Button
   */
  $('.pcba_excel').on('click', function (e) {
    e.preventDefault();

    let pcba_sn = $('.pcba_sn').val();
    let pcba_tradDateFrom = $('.pcba_tradDateFrom').val();
    let pcba_tradDateTo = $('.pcba_tradDateTo').val();
    let pcba_status = $('.pcba_status').val();

    // alert(`sn: ${pcba_sn}, tradDateFrom: ${pcba_tradDateFrom} ~ ${pcba_tradDateTo}, status: ${pcba_status}`);

    location.href = "./pcba_download.php?pcba_sn=" + pcba_sn + "&pcba_tradDateFrom=" + pcba_tradDateFrom + "&pcba_tradDateTo=" + pcba_tradDateTo + "&pcba_status=" + pcba_status;
  });


  /**
   * 엑셀 업로드 / 등록 Button
   * go to 엑셀 업로드 / 등록 화면
   */
  $('.pcba_insert').on('click', function () {
    $(location).attr('href', './pcba_insert.php');
  });

  
  /**
   * PCBA_SN Click : PCBA 세부정보 보여줌
   * pcba_sn
   * pcba_modify.php
   */

  //$('.d_pcba.d_pcba_sn').on('click', function () {    
  $(document).on("click", ".d_pcba.d_pcba_sn", function () {
    let pcba_sn = $(this).text();

    $.ajax({
      async: false,
      cache: false,
      type: "POST",
      url: "./pcba_modify.php",
      data: { pcba_sn },
      dataType: "html",
    })
    .done(function (response) {
      // Add response in Modal body
      $('.modal-body').html(response);

      // Display Modal
      $('#empModal').modal('show');

    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    })
  });


  /**
   * PCBA 수정 Button
   * 수정값 : id, pcba_sn, tradDate, tradId, version, type, status,
   * 수정값 : sn, comment, etc
   * pcba_udt.php
   */
  $('.btn.pcba_mdy_save').on('click', function () {

    id            = $('.pcba_l.pcba_id').val();
    let pcba_sn   = $('.pcba_l.pcba_sn').val();    
    
    let hostcnt   = chk('#pcba_hostcnt');
    let mcucnt    = chk('#pcba_mcucnt');
    let modemcnt  = chk('#pcba_modemcnt');
    let battcnt   = chk('#pcba_battcnt');
    let ssorcnt   = chk('#pcba_ssorcnt');
    let ldo       = chk('#pcba_ldo');
    let radio     = chk('#pcba_radio');
    let buz       = chk('#pcba_buz');
    let adc       = $('.pcba_l.pcba_adc').val();
    let memory    = chk('#pcba_memory');
    let issue     = $('.pcba_l.pcba_issue').val();
    let comment   = $('.pcba_l.pcba_comment').val();
    let validity  = $('input[name="pcba_validity"]:checked').val();
    let etc       = $('.pcba_l.pcba_etc').val();
    let img_radio = $('.pcba_l.pcba_img_radio').val();
    let img_adc   = $('.pcba_l.pcba_img_adc').val();
    reuser        = $('.user_l.erp_user').val();
    
    //alert(`hostcnt: ${hostcnt}, mcucnt: ${mcucnt}, modemcnt: ${modemcnt}`);
    
    let answer;
    answer = confirm("수정하시겠습니까?");
    if (answer == true) {

      if(img_radio) {
        let pos = img_radio.indexOf(".");
        if(pos<0) {
          alert("확장자가 [.jpg]만 허용됩니다.");
          $('.pcba_l.pcba_img_radio').focus();
          return false;       
        }

        let ext = img_radio.slice(img_radio.indexOf(".")+1).toLowerCase();
        if(ext!='jpg') {
          alert("확장자가 [.jpg]만 허용됩니다.")
          $('.pcba_l.pcba_img_adc').focus();
          return false;
        }
      }

      if(img_adc) {
        let pos = img_adc.indexOf(".");
        if(pos<0) {
          alert("확장자가 [.jpg]만 허용됩니다.");
          $('.pcba_l.pcba_img_adc').focus();
          return false;       
        }

        let ext = img_adc.slice(img_adc.indexOf(".")+1).toLowerCase();
        if(ext!='jpg') {
          alert("확장자가 [.jpg]만 허용됩니다.")
          $('.pcba_l.pcba_img_adc').focus();
          return false;
        }
      }

      if (isLength(reuser)) {
        alert("담당자명을 입력하세요.");
        $(".reuser").focus();
        return false;
      }

      $.ajax({
        type: "POST",
        url: "./pcba_udt.php",
        data: {
          id, pcba_sn, hostcnt, mcucnt, modemcnt, battcnt, ssorcnt,
          ldo, radio, buz, adc, memory, issue, comment, validity, 
          etc, img_radio, img_adc, reuser
        },
        dataType: "html",
      })
      .done(function (data) {
        console.log('return : ' + data);
        if (data == 0) {
          alert('수정되었습니다.');
        } else if (data == 1) {
          alert('수정할 PCBA이 없습니다.');
        }
        self.close();
        location.reload();
      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.log('서버오류: ' + textStatus);
        console.log('서버오류: ' + errorThrown);
      });
    }
  });


  /**
   * PCBA 삭제 Button
   * PCBA id
   * pcba_del.php
   */
  $('.btn.pcba_mdy_delete').on('click', function () {
    let answer;
    answer = confirm("삭제하시겠습니까?");
    if (answer == true) {

      id          = $('.pcba_l.pcba_id').val();         // 1. PCBAid
      let pcba_sn = $('.pcba_l.pcba_sn').val();         // 2. phone_no
      reuser      = $('.user_l.erp_user').val();

      if (isLength(reuser)) {
        alert("담당자명을 입력하세요.");
        $(".reuser").focus();
        return false;
      }

      $.ajax({
        type: "POST",
        url: "./pcba_del.php",
        data: { id, pcba_sn, reuser },
        dataType: "json",
      })
      .done(function (data) {
        console.log('return : ' + data);
        if (data == 0) {
          alert('삭제되었습니다.');
        } else if (data == 1) {
          alert('삭제할 PCBA이 없습니다.');
        }
        self.close();
        location.reload();

      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.log('서버오류: ' + textStatus);
        console.log('서버오류: ' + errorThrown);
      })
    }
  });

  //$('.d_pcba.d_pcba_sn').on('mouseover', function () {
  $(document).on('mouseover', '.d_pcba.d_pcba_sn', function () {
    $(".tr_pcba").css('border','0px');
    _tr = $(this).closest('tr');
    _tr.css('border','1px solid red');
  });

  //$('.d_pcba.d_pcba_sn').on('mouseout', function () {
  //   $(document).on('mouseout', '.d_pcba.d_pcba_sn', function () {  
  //   _tr = $(this).closest('tr');
  //   _tr.css('border','0px');
  // });

});
