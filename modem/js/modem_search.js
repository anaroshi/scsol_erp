'use strict';

$(document).ready(function () {

  let phone_orderby       = "";
  let phone_sort          = "";
  let sn_orderby          = "";
  let sn_sort             = "";
  let modem_sn            = "";
  let modem_tradDateFrom  = "";
  let modem_tradDateTo    = "";
  let modem_status        = "";
  let modem_product       = "";
  let modem_validity      = "";
  let reuser              = "";
  let filename            = "";
   
  /**
   * 초기화 Button
   * make all fields empty
   */
  $('.modem_clear').on('click', function () {
    location.reload();

  });


  /**
   * 조회 Button
   * showing modem list with options selected 
   */
  $('.modem_search').on('click', function (e) {
    e.preventDefault();

    filename = "modem_search_list.php";
    processModem(filename,"");

  });


  /**
   * PHONE HEAD
   * showing modem list with options selected  + order by PHONE desc / asc
   */
   $('th.h_modem.h_modem_b.h_phone').on('mouseover', function (e) {
    $(this).html("PHONE ▲/▼");
  });

  $('th.h_modem.h_modem_b.h_phone').on('mouseout', function (e) {
    $(this).html("PHONE"); 
  });

  $('th.h_modem.h_modem_b.h_phone').on('click', function (e) {
    e.preventDefault();
    filename = "modem_search_list.php";
    processModem(filename,"phone");

  });


  /**
   * SCSOL S/N HEAD
   * showing modem list with options selected  + order by SCSOL S/N desc / asc
   */
   $('th.h_modem.h_modem_b.h_sn').on('mouseover', function (e) {
    $(this).html("SCSOL S/N ▲/▼");
  });

  $('th.h_modem.h_modem_b.h_sn').on('mouseout', function (e) {
    $(this).html("SCSOL S/N"); 
  });

  $('th.h_modem.h_modem_b.h_sn').on('click', function (e) {
    e.preventDefault();
    filename = "modem_search_list.php";
    processModem(filename,"sn");

  });


  /**
   * 엑셀 다운로드 Button
   */
  $('.modem_excel').on('click', function (e) {
    e.preventDefault();

    modem_sn = $('.modem_sn').val();
    modem_tradDateFrom = $('.modem_tradDateFrom').val();
    modem_tradDateTo = $('.modem_tradDateTo').val();
    modem_status = $('.modem_status').val();
    modem_product = $('.modem_product').val();

    // alert(`sn: ${modem_sn}, tradDateFrom: ${modem_tradDateFrom} ~ ${modem_tradDateTo}, status: ${modem_status}`);

    location.href = "./modem_download.php?modem_sn=" + modem_sn + "&modem_tradDateFrom=" + modem_tradDateFrom + "&modem_tradDateTo=" + modem_tradDateTo + "&modem_status=" + modem_status + "&modem_product=" + modem_product;
  });


  /**
   * SCSOL S/N 가져오기 Button
   * geting the list of SCSOL S/N of modem form Leak server 
   */
  $('.modem_loadSn').on('click', function (e) {
    e.preventDefault();
    alert("sn from LeakServer")

    filename = "modem_snlist_leakserver.php";

    $.ajax({
      type: "POST",
      url: filename,
      data: {},
      cache: false,
      dataType: "json",
    })
    .done(async function (data) {
      hideLoadingBar();
      console.log('success');
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    });
  });

  
  /**
   * 모뎀 조회 처리
   * @param {*} filename 
   */
  function processModem(filename, mode) {
    showLoadingBar();
    modem_sn            = $('.modem_input.modem_sn').val();
    modem_tradDateFrom  = $('.modem_input.modem_tradDateFrom').val();
    modem_tradDateTo    = $('.modem_input.modem_tradDateTo').val();
    modem_status        = $('.modem_input.modem_status').val();
    modem_product       = $('.modem_input.modem_product').val();
    modem_validity      = $('.modem_input.modem_validity').val();

    if (mode=='phone') {
      phone_orderby         = $('.d_modem.d_phone_no').attr('name');
      phone_sort            = "on";
      sn_orderby            = "";
      sn_sort               = "";

    } else if (mode=='sn') {
      phone_orderby         = "";
      phone_sort            = "";
      sn_orderby            = $('.d_modem.d_sn').attr('name');
      sn_sort               = "on";
    } else {
      
      phone_orderby         = "";
      phone_sort            = "";
      sn_orderby            = "";
      sn_sort               = "";
    }

    // alert(`sn: ${modem_sn}, tradDateFrom: ${modem_tradDateFrom} ~ ${modem_tradDateTo}, status: ${modem_status}`);

    $.ajax({
      type: "POST",
      url: filename,
      data: { modem_sn, modem_tradDateFrom, modem_tradDateTo, modem_status, modem_product, modem_validity, phone_orderby, phone_sort, sn_orderby, sn_sort },  // new FormData(this),
      cache: false,
      dataType: "json",
    })
    .done(async function (data) {
      hideLoadingBar();

      console.log('success');

      $('.modem_head_total').html(data.total);
      $('.tb_modem').html(data.outputList);
      $('tfoot').remove();
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    });
  }


  /**
   * PHONE Click : 모뎀 세부정보 보여줌
   * 모뎀 id
   * modem_modify.php
   */
  $(document).on('click', '.d_modem.d_phone_no', function () {
    //$('.d_modem.d_phone_no').on('click', function () {    

    let _tr = $(this).closest('tr');
    let _td = _tr.find('td');
    let id = _td.eq(0).data('id');
    //alert(id);

    $.ajax({
      type: "POST",
      url: "./modem_modify.php",
      data: { id },
      dataType: "html",
    })
      .done(async function (response) {
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
   * 모뎀 수정 Button
   * 수정값 : id, phone_no, supplierSn, usim, rate, monthlyFee, tradDate,
   * 수정값 : tradId, status, product, version, comment, etc
   * modem_udt.php
   */
  $('.btn.modem_mdy_save').on('click', function () {

    let id          = $('.modem_l.modem_id').val();    
    let validity    = $('input[name="modem_validity"]:checked').val();
    let comment     = $('.modem_l.modem_comment').val();
    let etc         = $('.modem_l.modem_etc').val();
    reuser          = $('.user_l.erp_user').val();

    if (reuser.length < 2) {
      alert("담당자명을 입력하세요.");
      $(".reuser").focus();
      return false;
    }

    // alert(`id: ${id}, validity: ${validity}, comment: ${comment}, etc: ${etc}, reuser: ${reuser}`);

    $.ajax({
      type: "POST",
      url: "./modem_udt.php",
      data: { id, validity, comment, etc, reuser},
      dataType: "html",
    })
    .done(async function (data) {
      console.log('return : ' + data);
      if (data == 0) {
        alert('수정되었습니다.');
      } else if (data == 1) {
        alert('수정할 모뎀이 없습니다.');
      }
      self.close();
      location.reload();
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    })
  });


  /**
   * 모뎀 삭제 Button
   * 모뎀 id
   * modem_del.php
   */
  $('.btn.modem_mdy_delete').on('click', function () {
    let answer;
    answer = confirm("모뎀을 삭제하시겠습니까?");
    if (answer == true) {

      let id = $('.modem_l.modem_id').val();                // 1. 모뎀id
      let phone_no = $('.modem_l.modem_phone_no').val();    // 2. phone_no
      reuser        = $('.user_l.erp_user').val();          // 3. reuser

      if (reuser.length < 2) {
        alert("담당자명을 입력하세요.");
        $(".batt_l.batt_reuser").focus();
        return false;
      }

      $.ajax({
        type: "POST",
        url: "./modem_del.php",
        data: { id, phone_no, reuser },
        dataType: "json",
      })
        .done(async function (data) {
          console.log('return : ' + data);
          if (data == 0) {
            alert('삭제되었습니다.');
          } else if (data == 1) {
            alert('삭제할 모뎀이 없습니다.');
          }
          self.close();
          location.reload();

          // console.log(self);
          // console.log(window);
          // window.close();
          // console.log(window);
          // window.opener.document.location.close();
          // console.log(window.opener.document.location);
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
          console.log('서버오류: ' + textStatus);
          console.log('서버오류: ' + errorThrown);
        })
    }
  });

//  $('.d_modem.d_phone_no').on('mouseover', function () {
  $(document).on('mouseover', '.d_modem.d_phone_no', function () {
    $('.tr_modem').css('border','0px');
    let _tr = $(this).closest('tr');
    _tr.css('border','1px solid red');
  });

//  $('.d_modem.d_phone_no').on('mouseout', function () {
  // $(document).on('mouseout', '.d_modem.d_phone_no', function () {
  //   let _tr = $(this).closest('tr');
  //   _tr.css('border','0px');
  // });

});

/************* LoadingBar **************/
function showLoadingBar() {
  let maskHeight = $(document).height();
  let maskWidth = window.document.body.clientWidth;
  let mask = "<div id='mask' style='position:absolute; z-index:9000; background-color:#000000; display:none; left:0; top:0;'></div>";
  let loadingImg = "";
  loadingImg += "<div id='loadingImg' style='position:absolute; left:30%; top:40%; display:none; z-index:10000;'>";
  loadingImg += " <img src='../../image/spinner.gif'/>";
  loadingImg += "</div>";
  $('body').append(mask).append(loadingImg);
  $('#mask').css({ 'width': maskWidth, 'height': maskHeight, 'opacity': '0.1' });
  $('#mask').show();
  $('#loadingImg').show();
}

function hideLoadingBar() {
  $('#mask, #loadingImg').hide();
  $('#mask, #loadingImg').remove();
}
