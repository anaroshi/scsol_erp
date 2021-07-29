'use strict';
$(document).ready(function () {
  
  let _td       = "";  
  let answer    = "";
  let flag      = "";

  let cid       = "";
  let id        = "";
  let pwd       = "";
  let name      = "";
  let phone     = "";
  let addr      = "";
  let email     = "";
  let startDate = "";
  let user      = "";


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
    
    cid       = $('.user_cid').val();
    id        = $('.user_id').val();
    pwd       = $('.user_password').val();
    name      = $('.user_name').val();
    phone     = $('.user_phone').val();
    add1      = $('.user_add1').val();
    add2      = $('.user_add2').val();
    email     = $('.user_email').val();
    startDate = $('.user_startDate').val();
    user      = $('.erp_user').val();
    
    if (user == "") {
      alert("담당자를 선택하세요.");
      $(".erp_user").focus();
      return;
    }
    
    //alert(`cid: ${cid}, id: ${id}, pwd: ${pwd}, name: ${name}, phone: ${phone}`);
    //alert(`add1: ${add1}, add2: ${add2}, email: ${email}, startDate: ${startDate}, user: ${user}`);

    if (cid=="") {
      answer  = confirm("저장하시겠습니까?");
      flag    = 1;      
    } else {
      answer  = confirm("수정하시겠습니까?");
      flag    = 2;
    }
    
    if(answer) {
      $.ajax({
        url: "./prdt_user_db.php",
        method: 'POST', 
        data: { cid, id, pwd, name, phone, add1, add2, email, startDate, user, flag},
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
          alert('중복된 USER입니다.');
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
    cid       = $('.user_cid').val();
    user      = $('.erp_user').val();
    flag      = 4;

    if (cid == "") {
      alert("삭제할 USER를 선택하세요.");
      $(".user_user").focus();
      return;
    }

    if (user == "") {
      alert("담당자를 선택하세요.");
      $(".erp_user").focus();
      return;
    }
    
    //alert(`cid: ${cid}, user: ${user}`);

    answer  = confirm("삭제하시겠습니까?");          
        
    if(answer) {
      $.ajax({
        url: "./prdt_user_db.php",
        method: 'POST', 
        data: { cid, id, pwd, name, phone, add1, add2, email, startDate, user, flag },
        dataType: 'json',
      })
      .done(function (data) {
        console.log('return : ' + data);
        if (data == 4) {
          alert('삭제되었습니다.');
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

  // List에서 항목 선택  
  $("tr.tr_user").on('click', function () {
    _td   = $(this).children();
    cid       = _td.eq(0).text();
    id        = _td.eq(1).text();
    pwd       = _td.eq(2).text();
    name      = _td.eq(3).text();
    phone     = _td.eq(4).text();
    addr      = _td.eq(5).text();    
    email     = _td.eq(6).text();
    startDate = _td.eq(7).text();
    user      = _td.eq(8).text();
    
    //alert(`id: ${id}, user: ${user}, code: ${code}, sort: ${sort}, user: ${user}`);
    
    $(".user_cid").val(cid);
    $(".user_id").val(id);
    $(".user_password").val(pwd);
    $(".user_name").val(name);
    $(".user_phone").val(phone);
    $(".user_addr").val(addr);
    $(".user_email").val(email);
    $(".user_startDate").val(startDate);
    $(".erp_user").val(user);
    
    $(".user_id").css("background-color","#bdbdbd");
    $(".user_id").css("user-select","none");
    $(".user_id").prop('readonly', true);
    $(".user_id").prop("'onfocus='this.blur();'", true);
  });
});