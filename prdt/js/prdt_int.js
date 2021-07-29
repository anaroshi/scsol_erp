'use strict';

$(document).ready(function () {
  
  $('.ui.selection.dropdown')
  .dropdown({
    clearable: true,
    fullTextSearch: true
  });


  $('.test.checkbox').checkbox('attach events', '.toggle.button');

  /**
   * 초기화 Button
   * make all fields empty
   */
  $('.prdt_clear').on('click', function() {
    location.reload();    
  });      

  /**
   * 저장 Button
   * save all data in fields that selected and inserted
   */
   $('.prdt_int').on('click', function() {

    let scsol_sn    = $('.item.prdt_modem.active.selected').text();
    let pcba_sn     = $('.item.part_pcba.active.selected').text();
    let sensor_sn	  = $('.item.part_sensor.active.selected').text();
    let battery_sn  = $('.item.prdt_battery.active.selected').text();
    let case_sn	    = $('.item.prdt_case.active.selected').text();
    let user	      = $('.item.part_user.active.selected').text();

    if (user == "") {
      alert("담당자를 선택하세요.");
      return false;
    }

    //alert(`scsol_sn: ${scsol_sn}, pcba_sn: ${pcba_sn}, sensor_sn: ${sensor_sn}, battery_sn: ${battery_sn}, case_sn: ${case_sn}`);

    $.ajax({
      type: "POST",
      url: "./prdt_save.php",
      data: {
        scsol_sn, pcba_sn, sensor_sn, battery_sn, case_sn, user
      },
      dataType: "html",
    })
    .done(function (data) {
      console.log('return : ' + data);
      if (data == 0) {
        alert('입력되었습니다.');
      } else if (data == 1) {
        alert('중복된 SN 입니다.');
      }
      location.reload();
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log('서버오류: ' + textStatus);
      console.log('서버오류: ' + errorThrown);
    })

  });      

});