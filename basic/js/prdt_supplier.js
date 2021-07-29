'use strict';
$(document).ready(function () {
  
  let _td           = "";
  let id            = "";
  let supplier      = "";
  let supplier_cd   = "";
  let site          = "";
  let address       = "";
  let phone         = "";
  let fax           = "";
  let mail          = "";
  let tax_no        = "";
  let owner         = "";
  let manager       = "";
  let managerPhone  = "";
  let etc           = "";
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
    id            = $('.supplier_id').val();
    supplier      = $('.supplier_supplier').val().toUpperCase();
    supplier_cd   = $('.supplier_supplierCd').val();
    site          = $('.supplier_site').val();
    address       = $('.supplier_address').val();
    phone         = $('.supplier_phone').val();
    fax           = $('.supplier_fax').val();
    mail          = $('.supplier_mail').val();
    tax_no        = $('.supplier_taxNo').val();
    owner         = $('.supplier_owner').val();
    manager       = $('.supplier_manager').val();
    managerPhone  = $('.supplier_managerPhone').val();
    etc           = $('.supplier_etc').val();
    user          = $('.erp_user').val();

    let form_data   = new FormData();
    form_data.append("id", id);
    form_data.append("supplier", supplier);
    form_data.append("supplier_cd", supplier_cd);
    form_data.append("site", site);
    form_data.append("address", address);
    form_data.append("phone", phone);
    form_data.append("fax", fax);
    form_data.append("mail", mail);
    form_data.append("tax_no", tax_no);
    form_data.append("owner", owner);
    form_data.append("manager", manager);
    form_data.append("managerPhone", managerPhone);
    form_data.append("etc", etc);
    form_data.append("user", user);

    if (supplier == "") {
      alert("구매처를 입력하세요.");
      $(".supplier_supplier").focus();
      return;
    }

    if (user == "") {
      alert("담당자를 선택하세요.");
      $(".erp_user").focus();
      return;
    }
    
    //alert(`id: ${id}, supplier: ${supplier}, user: ${user}`);

    if (id=="") {
      answer  = confirm("저장하시겠습니까?");
      flag    = 1;      
    } else {
      answer  = confirm("수정하시겠습니까?");
      flag    = 2;
    }
    
    form_data.append("flag", flag);
    
    if(answer) {
      alert("answer");
      $.ajax({
        type: "POST",
        url: "./prdt_supplier_db.php",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        dataType: "json",
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
          alert('중복된 구매처입니다.');
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
    id          = $('.supplier_id').val();
    supplier_cd = $(".supplier_supplierCd").val();
    user        = $('.erp_user').val();
    flag        = 4;

    if (id == "") {
      alert("삭제할 구매처를 선택하세요.");
      $(".supplier_supplier").focus();
      return;
    }

    if (user == "") {
      alert("담당자를 선택하세요.");
      $(".erp_user").focus();
      return;
    }
    
    //alert(`id: ${id}, supplier: ${supplier}, user: ${user}`);

    answer  = confirm("삭제하시겠습니까?");          
        
    if(answer) {
      $.ajax({
        url: "./prdt_supplier_db.php",
        method: 'POST', 
        data: { id, supplier, supplier_cd, user, flag },
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
  $("tr.tr_supplier").on('click', function () {
    _td           = $(this).children();
    id            = _td.eq(0).data('id');
    supplier      = _td.eq(1).text();
    supplier_cd   = _td.eq(2).text();
    site          = _td.eq(3).text();
    address       = _td.eq(4).text();
    phone         = _td.eq(5).text();
    fax           = _td.eq(6).text();
    mail          = _td.eq(7).text();
    tax_no        = _td.eq(8).text();
    owner         = _td.eq(9).text();
    manager       = _td.eq(10).text();
    managerPhone  = _td.eq(11).text();
    etc           = _td.eq(12).text();
    sort          = _td.eq(13).text();
    user          = _td.eq(14).text();
    
    //alert(`id: ${id}, supplier: ${supplier}, code: ${code}, sort: ${sort}, user: ${user}`);
    
    $(".supplier_id").val(id);
    $(".supplier_supplier").val(supplier);
    $(".supplier_supplierCd").val(supplier_cd);
    $(".supplier_site").val(site);
    $(".supplier_address").val(address);
    $(".supplier_phone").val(phone);
    $(".supplier_fax").val(fax);
    $(".supplier_mail").val(mail);
    $(".supplier_taxNo").val(tax_no);
    $(".supplier_owner").val(owner);
    $(".supplier_manager").val(manager);
    $(".supplier_managerPhone").val(managerPhone);
    $(".supplier_etc").val(etc);
    $(".supplier_sort").val(sort);
    $(".erp_user").val(user);

  });
  


});