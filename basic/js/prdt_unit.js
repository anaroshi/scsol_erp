'use strict';
$(document).ready(function () {
  
  let _td   = "";
  let id    = "";
  let unit  = "";
  let code  = "";
  let sort  = "";
  let user  = "";
  let answer = "";
  let flag  = "";


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
    id   = $('.unit_id').val();
    unit = $('.unit_unit').val().toUpperCase();
    user = $('.erp_user').val();

    if (unit == "") {
      alert("단위를 입력하세요.");
      $(".unit_unit").focus();
      return;
    }

    if (user == "") {
      alert("담당자를 선택하세요.");
      $(".erp_user").focus();
      return;
    }
    
    //alert(`id: ${id}, unit: ${unit}, user: ${user}`);

    if (id=="") {
      answer  = confirm("저장하시겠습니까?");
      flag    = 1;      
    } else {
      answer  = confirm("수정하시겠습니까?");
      flag    = 2;
    }
    
    if(answer) {
      $.ajax({
        url: "./prdt_unit_db.php",
        method: 'POST', 
        data: { id, unit, user, flag },
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
          alert('중복된 단위입니다.');
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
    id   = $('.unit_id').val();
    unit = $('.unit_unit').val();
    user = $('.erp_user').val();
    flag = 4;

    if (id == "") {
      alert("삭제할 단위를 선택하세요.");
      $(".unit_unit").focus();
      return;
    }

    if (user == "") {
      alert("담당자를 선택하세요.");
      $(".erp_user").focus();
      return;
    }
    
    //alert(`id: ${id}, unit: ${unit}, user: ${user}`);

    answer  = confirm("삭제하시겠습니까?");          
        
    if(answer) {
      $.ajax({
        url: "./prdt_unit_db.php",
        method: 'POST', 
        data: { id, unit, user, flag },
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
  $("tr.tr_unit").on('click', function () {
    _td   = $(this).children();
    id    = _td.eq(0).data('id');
    unit  = _td.eq(1).text();
    code  = _td.eq(2).text();
    sort  = _td.eq(3).text();
    user  = _td.eq(4).text();
    
    //alert(`id: ${id}, unit: ${unit}, code: ${code}, sort: ${sort}, user: ${user}`);
    
    $(".unit_id").val(id);
    $(".unit_unit").val(unit);
    $(".unit_unitCd").val(code);
    $(".unit_sort").val(sort);
    $(".erp_user").val(user);

  });
  


});