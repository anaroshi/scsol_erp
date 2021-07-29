'use strict';

$(document).ready(function () {

  let filename            = "";
  let id                  = "";
  let sensor_sn           = "";
  let sn_orderby          = "";
  let sn_sort             = "";
  let tradDate            = "";
  let tradId              = "";
  let status              = "";
  let validity            = "";
  let sn                  = "";
  let conclusion          = "";
  let issue               = "";
  let comment             = "";
  let etc                 = "";
  let image_1             = "";
  let image_2             = "";
  let image_3             = "";  
  let sensor_tradDateFrom = "";
  let sensor_tradDateTo   = "";
  let sensor_status       = "";
  let sensor_validity     = "";
  let _tr                 = "";
  let _td                 = "";
  let chk_value           = "";
  let answer              = "";
  let reuser              = "";

  /**
   * 초기화 Button
   * make all fields empty
   */
  $('.sensor_btn.sensor_clear').on('click', function () {
    location.reload();

  });


  /**
   * 조회 Button
   * showing sensor list with options selected 
   */
  $('.sensor_btn.sensor_search').on('click', function (e) {
    e.preventDefault();

    filename            = "sensor_search_list.php";
    sn_orderby          = "off";
    sensor_sn           = $('.sensor_input.sensor_sn').val();
    sensor_tradDateFrom = $('.sensor_input.sensor_tradDateFrom').val();
    sensor_tradDateTo   = $('.sensor_input.sensor_tradDateTo').val();
    sensor_status       = $('.sensor_input.sensor_status').val();
    sensor_validity     = $('.sensor_input.sensor_validity').val();    

    //alert(`sn: ${sensor_sn}, tradDateFrom: ${sensor_tradDateFrom} ~ ${sensor_tradDateTo}, status: ${sensor_status}`);

    $.ajax({
      async: false,
      cache: false,
      type: "POST",
      url: filename,
      data: { sensor_sn, sensor_tradDateFrom, sensor_tradDateTo, sensor_status, sn_orderby, sensor_validity},  // new FormData(this),
      dataType: "json",
    })
//    .done(async function (data) {
    .done(function (data) {
      console.log('success');

      $('.sensor_head_total').html(data.total);
      $('.tb_sensor').html(data.outputList);
      $('tfoot').remove();
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    });

  });


  /**
   * SENSOR_SN HEAD
   * showing sensor list with options selected + order by sensor_sn desc / asc
   */
  
  $('.h_sensor.h_sensor_b.h_sensor_sn').on('mouseover', function (e) {
    $(this).html("SENSOR_SN ▲/▼"); 
  });

  $('.h_sensor.h_sensor_b.h_sensor_sn').on('mouseout', function (e) {
    $(this).html("SENSOR_SN"); 
  });

  $('.h_sensor.h_sensor_b.h_sensor_sn').on('click', function (e) {
     
    //alert("You clicked SENSOR_SN");
    //e.preventDefault();
    
    filename            = "sensor_search_list.php";
    sn_orderby          = $('.d_sensor.d_sensor_sn').attr('name');
    sn_sort             = "on";
    sensor_sn           = $('.sensor_input.sensor_sn').val();
    sensor_tradDateFrom = $('.sensor_input.sensor_tradDateFrom').val();
    sensor_tradDateTo   = $('.sensor_input.sensor_tradDateTo').val();
    sensor_status       = $('.sensor_input.sensor_status').val();


    //alert(`sn: ${sensor_sn}, orderby: ${sn_orderby} - ${sn_sort}, tradDateFrom: ${sensor_tradDateFrom} ~ ${sensor_tradDateTo}, status: ${sensor_status}`);

    $.ajax({
      async: false,
      cache: false,
      type: "POST",
      url: filename,
      data: { sensor_sn, sensor_tradDateFrom, sensor_tradDateTo, sensor_status, sn_orderby, sn_sort},  // new FormData(this),
      dataType: "json",
    })
//    .done(async function (data) {
    .done(function (data) {
      console.log('success');

      $('.sensor_head_total').html(data.total);
      $('.tb_sensor').html(data.outputList);
      $('.tb_sensor').html(data.outputList);

    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    });

  });


  /**
   * 엑셀 다운로드 Button
   */
  $('.sensor_btn.sensor_excel').on('click', function (e) {
    e.preventDefault();
    
    sensor_sn           = $('.sensor_sn').val();
    sensor_tradDateFrom = $('.sensor_tradDateFrom').val();
    sensor_tradDateTo   = $('.sensor_tradDateTo').val();
    sensor_status       = $('.sensor_status').val();

    // alert(`sn: ${sensor_sn}, tradDateFrom: ${sensor_tradDateFrom} ~ ${sensor_tradDateTo}, status: ${sensor_status}`);

    location.href = "./sensor_download.php?sensor_sn=" + sensor_sn + "&sensor_tradDateFrom=" + sensor_tradDateFrom + "&sensor_tradDateTo=" + sensor_tradDateTo + "&sensor_status=" + sensor_status;
  });


  /**
   * Hz Data 추출
   */
   $('.sensor_btn.sensor_extract').on('click', function (e) {
    e.preventDefault();
    
    //alert("Hz Data 추출");

    showLoadingBar();

    $.ajax({
      async: true,
      cache: false,
      url: "./sensor_mix_hz.php",
      type: "POST",
      data: {}
    })
    .done(function(response){
      console.log("hz exstraction!!");      
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    });

    $.ajax({
      async: true,
      cache: false,      
      url: "./sensor_hz.php",
      type: "POST",
      data: {}
    })
    .done(function(response){
      console.log("hz exstraction!!");
      location.reload();
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    });
    
  });


  /**
   * SENSOR_SN Click : 센서 세부정보 보여줌
   * 센서 id
   * sensor_modify.php
   */
  //$('.d_sensor.d_sensor_sn').on('click', function () {
  $(document).on('click', '.d_sensor.d_sensor_sn', function () {
    
    sensor_sn   = $(this).text();    
    
    $.ajax({
      async: false,
      cache: false,
      type: "POST",
      url: "./sensor_modify.php",
      data: { sensor_sn },
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
    });
  });

  /**
   * 센서 수정 Button
   * 수정값 : id, phone_no, supplierSn, usim, rate, monthlyFee, tradDate,
   * 수정값 : tradId, status, comment, etc
   * sensor_udt.php
   */
  $('.btn.sensor_mdy_save').on('click', function () {

    id            = $('.sensor_l.sensor_id').val();
    sensor_sn     = $('.sensor_l.sensor_sn').val();

    tradDate      = $('.sensor_l.sensor_tradDate').val();
    tradId        = $('.sensor_l.sensor_tradId').val();    

    validity      = $('input[name="sensor_validity"]:checked').val();
    conclusion    = chk('#sensor_conclusion');
    issue         = $('.sensor_l.sensor_issue').val();
    comment       = $('.sensor_l.sensor_comment').val();
    etc           = $('.sensor_l.sensor_etc').val();
    reuser        = $('.user_l.erp_user').val();
    image_1       = $('.sensor_img.sensor_image_1').val();
    image_2       = $('.sensor_img.sensor_image_2').val();
    image_3       = $('.sensor_img.sensor_image_3').val();
    
    
    // alert(`id: ${id}, sensor_sn: ${sensor_sn}, tradDate: ${tradDate}, tradId: ${tradId}, validity: ${validity}, `);
    // alert(`conclusion: ${conclusion}, issue: ${issue}, comment: ${comment}, etc: ${etc}, reuser: ${reuser}`);
  
    if (reuser.length < 2) {
      alert("담당자명을 입력하세요.");
      $(".reuser").focus();
      return false;
    }
    
    $.ajax({
      async: false,
      cache: false,
      type: "POST",      
      url: "./sensor_udt.php",
      data: {
        id, sensor_sn, tradDate, tradId, validity, conclusion, issue, comment, etc,
        reuser, image_1, image_2, image_3
      },
      dataType: "html",
    })
    .done(async function (data) {
    
      console.log('return : ' + data);
      if (data == 'ok') {
        alert('수정되었습니다.');
        self.close();
        location.reload();
      } else {
        alert('수정할 센서가 없습니다.');
      }
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    });

  });

  function chk(selector) {
    chk_value = 'F';
    if ($(selector).is(":checked") == true) {
      chk_value = 'P';
    }
    return chk_value;
  }

  /**
   * 센서 삭제 Button
   * 센서 id
   * sensor_del.php
   */
  $('.btn.sensor_mdy_delete').on('click', function () {
    
    answer = confirm("센서를 삭제하시겠습니까?");
    if (answer == true) {

      id        = $('.sensor_l.sensor_id').val();         // 1. 센서id
      sensor_sn = $('.sensor_l.sensor_sn').val();         // 2. sensor_sn
      $.ajax({
        type: "POST",
        url: "./sensor_del.php",
        data: { id, sensor_sn },
        dataType: "html",
      })
      .done(async function (data) {
        console.log('return : ' + data);
        if (data == 'ok') {
          alert('삭제되었습니다.');
          self.close();
          location.reload();

        } else {
          alert('삭제할 센서가 없습니다.');
        }

      })
      .fail(function (jqXHR, textStatus, errorThrown) {
        console.log('서버오류: ' + textStatus);
        console.log('서버오류: ' + errorThrown);
      });
    }
  });

//  $('.d_sensor.d_sensor_sn').on('mouseover', function () {
  $(document).on('mouseover', '.d_sensor.d_sensor_sn', function () {
    $('.tr_sensor').css('border','0px');
    let _tr = $(this).closest('tr');
    _tr.css('border','1px solid red');
  });

//  $('.d_sensor.d_sensor_sn').on('mouseout', function () {
  // $(document).on('mouseout', '.d_sensor.d_sensor_sn', function () {   
  //   let _tr = $(this).closest('tr');
  //   _tr.css('border','0px');
  // });


});


/**
 * LoadingBar
 */
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