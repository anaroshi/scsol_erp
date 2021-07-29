'use strict';
$(document).ready(function () {
  
  let _td         = "";
  let id          = "";
  let voucher     = "";
  let voucher_cd  = "";
  let sort        = "";
  let user        = "";
  let answer      = "";
  let flag        = "";


  $('.ui.selection.dropdown')
  .dropdown({
    clearable: true,
    fullTextSearch: true
  });

  // 초기화 Button
  $('.info_clear').on('click', function() {
    location.reload();
  });

  // 저장 Button
  $('.info_save').on('click', function() {
    id   = $('.voucher_id').val();
    voucher = $('.voucher_voucher').val().toUpperCase();
    user = $('.erp_user').val();

    if (voucher == "") {
      alert("구분을 입력하세요.");
      $(".voucher_voucher").focus();
      return;
    }

    if (user == "") {
      alert("담당자를 선택하세요.");
      $(".erp_user").focus();
      return;
    }
    
    //alert(`id: ${id}, voucher: ${voucher}, user: ${user}`);

    if (id=="") {
      answer  = confirm("저장하시겠습니까?");
      flag    = 1;      
    } else {
      answer  = confirm("수정하시겠습니까?");
      flag    = 2;
    }
    
    if(answer) {
      $.ajax({
        url: "./prdt_voucher_db.php",
        method: 'POST', 
        data: { id, voucher, voucher_cd, user, flag },
        dataType: 'json',
      })
      .done(function (data) {
        console.log('return : ' + data);
        if (data == 1) {
          alert('저장되었습니다.');
          location.reload();
        } else if (data == 2) {
          alert('수정되었습니다.');
          location.reload();
        } else if (data == 3) {
          alert('중복된 구분입니다.');
          location.reload();
        } else if (data == 9) {
          alert('ERROR OCCURED');
        }
      })
       .fail(function (jqXHR, textStatus, errorThrown) {
        console.log('서버오류: ' + textStatus);
        console.log('서버오류: ' + errorThrown);
      })
    }
  });

  // 삭제 Button
  $('.info_del').on('click', function() {
    id          = $('.voucher_id').val();
    voucher_cd  = $(".voucher_voucherCd").val();
    user        = $('.erp_user').val();
    flag        = 4;

    if (id == "") {
      alert("삭제할 구분을 선택하세요.");
      $(".voucher_voucher").focus();
      return;
    }

    if (user == "") {
      alert("담당자를 선택하세요.");
      $(".erp_user").focus();
      return;
    }
    
    //alert(`id: ${id}, voucher: ${voucher}, user: ${user}`);

    answer  = confirm("삭제하시겠습니까?");          
        
    if(answer) {
      $.ajax({
        url: "./prdt_voucher_db.php",
        method: 'POST', 
        data: { id, voucher, voucher_cd, user, flag },
        dataType: 'json',
      })
      .done(function (data) {
        console.log('return : ' + data);
        if (data == 4) {
          alert('삭제되었습니다.');
          location.reload();
        } else if (data == 5) {
          alert('사용 중인 타입은 삭제할 수 없습니다.');
        } else if (data == 9) {
          alert('ERROR OCCURED');
        }
      })
       .fail(function (jqXHR, textStatus, errorThrown) {
        console.log('서버오류: ' + textStatus);
        console.log('서버오류: ' + errorThrown);
      })
    }
  });

  // List에서 항목 선택  
  $("tr.tr_voucher").on('click', function () {
    _td   = $(this).children();
    id    = _td.eq(0).data('id');
    voucher  = _td.eq(1).text();
    voucher_cd  = _td.eq(2).text();
    sort  = _td.eq(3).text();
    user  = _td.eq(4).text();
    
    //alert(`id: ${id}, voucher: ${voucher}, voucher_cd: ${voucher_cd}, sort: ${sort}, user: ${user}`);
    
    $(".voucher_id").val(id);
    $(".voucher_voucher").val(voucher);
    $(".voucher_voucherCd").val(voucher_cd);
    $(".voucher_sort").val(sort);
    $(".erp_user").val(user);

  });
  


});