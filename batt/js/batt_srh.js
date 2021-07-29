'use strict';
$(document).ready(function () {

  let _tr     = "";
  let reuser  = "";

  /**
   * 초기화 Button
   */
  $(".batt_btn.batt_clear").on("click", function () {
      location.reload();
  });


  /**
   * 조회 Button
   */
  $(".batt_btn.batt_search").on("click", function (e) {
    e.preventDefault();
      
    let filename              = "batt_srh_list.php";
    let batt_sn               = $('.batt_input.batt_sn').val();
    let batt_tradDateFrom     = $('.batt_input.batt_tradDateFrom').val();
    let batt_tradDateTo       = $('.batt_input.batt_tradDateTo').val();
    let batt_status           = $('.batt_input.batt_status').val();
    let batt_validity         = $('.batt_input.batt_validity').val();

    //alert(`sn: ${batt_sn}, tradDateFrom: ${batt_tradDateFrom} ~ ${batt_tradDateTo}, status: ${batt_status}`);

    $.ajax({
      type: "POST",
      url: filename,
      data: { batt_sn, batt_tradDateFrom, batt_tradDateTo, batt_status, batt_validity },  // new FormData(this),
      async: false,
      cache: false,
      dataType: "json",
    })
    .done(function (data) {
      console.log('success');

      $('.batt_head_total').html(data.total);
      $('.tb_batt').html(data.outputList);
      $('tfoot').remove();
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    })
  });


  /**
   * 엑셀 다운로드 Button
   */
   $(".batt_btn.batt_excel").on("click", function () {
       
    let batt_sn               = $('.batt_input.batt_sn').val();
    let batt_tradDateFrom     = $('.batt_input.batt_tradDateFrom').val();
    let batt_tradDateTo       = $('.batt_input.batt_tradDateTo').val();
    let batt_status           = $('.batt_input.batt_status').val();

    //alert(`sn: ${batt_sn}, tradDateFrom: ${batt_tradDateFrom} ~ ${batt_tradDateTo}, status: ${batt_status}`);
    location.href = "./batt_download.php?batt_sn=" + batt_sn + "&batt_tradDateFrom=" + batt_tradDateFrom + "&batt_tradDateTo=" + batt_tradDateTo + "&batt_status=" + batt_status;
  });

  /**
   * BATT_SN Click : BATTERY 세부정보 보여줌
   * batt_sn
   * batt_modify.php
   */
  $(document).on("click", ".d_batt.d_batt_sn", function () {
    let batt_sn = $(this).text();

    $.ajax({
      async: false,
      cache: false,
      type: "POST",
      url: "./batt_mod.php",
      data: { batt_sn },
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
   * 수정 Button
   */
  $('.batt_mdy_save').on('click', function () {

    let answer;
    answer = confirm("수정하시겠습니까?");
    if (answer == true) {

      let id        = $('.batt_l.batt_id').val();            // 1. batt_id
      let voltage   = $('.batt_l.batt_voltage').val();
      let comment   = $('.batt_l.batt_comment').val();
      let etc       = $('.batt_l.batt_etc').val();
      let validity  = $('input[name="batt_validity"]:checked').val();
      reuser        = $('.user_l.erp_user').val();

      if (reuser.length < 2) {
        alert("담당자명을 입력하세요.");
        $(".batt_l.batt_reuser").focus();
        return false;
      }
      
      //alert(`id : ${id}, voltage : ${voltage}, comment : ${comment}, etc : ${etc}, validity : ${validity}, reuser : ${reuser}`);

      $.ajax({
        type: "POST",
        url: "./batt_udt.php",
        data: { id, voltage, comment, etc, validity, reuser },
        dataType: "json",
      })
      .done(function (data) {
        console.log('return : ' + data);
        if (data == 0) {
          alert('수정되었습니다.');
        } else if (data == 1) {
          alert('수정할 BATTERY가 없습니다.');
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
  
  /**
   * 삭제 Button
   */
  $('.batt_mdy_delete').on('click', function () {
    
    let answer;
    answer = confirm("삭제하시겠습니까?");
    if (answer == true) {

      let id        = $('.batt_l.batt_id').val();           // 1. batt_id
      reuser        = $('.user_l.erp_user').val();          // 2. reuser

      if (reuser.length < 2) {
        alert("담당자명을 입력하세요.");
        $(".batt_l.batt_reuser").focus();
        return false;
      }
      
      $.ajax({
        type: "POST",
        url: "./batt_del.php",
        data: { id, reuser },
        dataType: "json",
      })
      .done(function (data) {
        console.log('return : ' + data);
        if (data == 0) {
          alert('삭제되었습니다.');
        } else if (data == 1) {
          alert('삭제할 BATTERY가 없습니다.');
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

  $(document).on('mouseover', '.d_batt.d_batt_sn', function () {    
    $(".tr_batt").css('border', '0px');
    _tr = $(this).closest('tr');
    _tr.css('border','1px solid red');
  });

});