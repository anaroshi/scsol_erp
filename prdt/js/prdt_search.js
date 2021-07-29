'use strict';

$(document).ready(function () {

  let id                  = "";
  let _tr                 = "";
  let _td                 = "";

  /**
   * 초기화 Button
   * refresh the view
   */
    $('.prdt_clear').on('click', function () {
    location.reload();

  });


  /**
   * 조회 Button
   * 
   */
   $('.prdt_search').on('click', function (e) {
    e.preventDefault();

    let filename              = "prdt_search_list.php";
    let prdt_sn               = $('.prdt_input.prdt_sn').val();
    let prdt_tradDateFrom     = $('.prdt_input.prdt_tradDateFrom').val();
    let prdt_tradDateTo       = $('.prdt_input.prdt_tradDateTo').val();
    let prdt_status           = $('.prdt_input.prdt_status').val();
    let prdt_product          = $('.prdt_input.prdt_product').val();
    let prdt_finalState       = $('.prdt_input.prdt_finalState').val();

    //alert(`sn: ${prdt_sn}, tradDateFrom: ${prdt_tradDateFrom} ~ ${prdt_tradDateTo}, status: ${prdt_status}, product: ${prdt_product}, prdt_finalState: ${prdt_finalState} `);

    $.ajax({
      type: "POST",
      url: filename,
      data: { prdt_sn, prdt_tradDateFrom, prdt_tradDateTo, prdt_status, prdt_product, prdt_finalState },  // new FormData(this),
      async: false,
      cache: false,
      dataType: "json",
    })
    .done(function (data) {
      console.log('success');
      $('.prdt_head_total').html(data.total);
      $('.tb_prdt').html(data.outputList);
      $('tfoot').remove();
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    })

  });

  /**
   * 엑셀 다운로드 Button
   * 
   */
   $('.prdt_excel').on('click', function () {
    alert("download a file");
    let prdt_sn               = $('.prdt_input.prdt_sn').val();
    let prdt_tradDateFrom     = $('.prdt_input.prdt_tradDateFrom').val();
    let prdt_tradDateTo       = $('.prdt_input.prdt_tradDateTo').val();
    let prdt_status           = $('.prdt_input.prdt_status').val();
    let prdt_product          = $('.prdt_input.prdt_product').val();
    let prdt_finalState       = $('.prdt_input.prdt_finalState').val();

    // alert(`sn: ${prdt_sn}, tradDateFrom: ${prdt_tradDateFrom} ~ ${prdt_tradDateTo}, status: ${prdt_status}`);
    // alert(`prdt_product: ${prdt_product}, prdt_finalState: ${prdt_finalState}`);

    //location.href = "./prdt_download.php?prdt_sn=" + prdt_sn + "&prdt_tradDateFrom=" + prdt_tradDateFrom + "&prdt_tradDateTo=" + prdt_tradDateTo + "&prdt_status=" + prdt_status + "&prdt_product=" + prdt_product + "&prdt_finalState=" + prdt_finalState;

  });  
    
  /**
   * scsol_sn Click
   * 생산 세부 화면으로 이동
   * prdt_detail.php
   */
  $(document).on('click', '.d_prdt.d_scsol_sn', function () {
    _tr   = $(this).closest('tr');
    _td   = _tr.find('td');
    id    = _td.eq(0).data('id');
    location.href = "./prdt_detail.php?id=" + id;
  });


  $(document).on('mouseover', '.d_prdt.d_scsol_sn', function () {
    $('.tr_prdt').css('border','0px');
    _tr = $(this).closest('tr');
    _tr.css('border','1px solid red');
  });

  // $(document).on('mouseout', '.d_prdt.d_scsol_sn', function () {  
  //   _tr = $(this).closest('tr');
  //   _tr.css('border','0px');
  // });

  
});
