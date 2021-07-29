'use strict';

$(document).ready(function () {

  $('.ui.accordion').accordion({ exclusive: false});
 
  
  $('.item.spt_int').on('click', function () {
    
    $('.container').html('<iframe src="http://www.ithingsware.com:5080/scsol_erp/spt/src/spt_int.php"></iframe>');
    
  });

  $('.item.spt_srh').on('click', function () {
    
                                                                      
    $('.container').html('<iframe src="http://www.ithingsware.com:5080/scsol_erp/spt/src/spt_search.php"></iframe>');
    
  });

  $('.item.trad_int').on('click', function () {
    
    $('.container').html('<iframe src="http://www.ithingsware.com:5080/scsol_erp/trad/src/trad_insert.php"></iframe>');
    
  });

  $('.item.trad_srh').on('click', function () {
                                                                      
    $('.container').html('<iframe src="http://www.ithingsware.com:5080/scsol_erp/trad/src/trad_search.php"></iframe>');
    
  });

  $('.item.modem_int').on('click', function () {

    $('.container').html('<iframe src="http://www.ithingsware.com:5080/scsol_erp/modem/src/modem_insert.php"></iframe>');
    
  });

  $('.item.modem_srh').on('click', function () {

    $('.container').html('<iframe src="http://www.ithingsware.com:5080/scsol_erp/modem/src/modem_search.php"></iframe>');

  });

  $('.item.pcba_int').on('click', function () {

    $('.container').html('<iframe src="http://www.ithingsware.com:5080/scsol_erp/pcba/src/pcba_insert.php"></iframe>');
    
  });

  $('.item.pcba_srh').on('click', function () {

    $('.container').html('<iframe src="http://www.ithingsware.com:5080/scsol_erp/pcba/src/pcba_search.php"></iframe>');
    
  });

  $('.item.sensor_int').on('click', function () {

    $('.container').html('<iframe src="http://www.ithingsware.com:5080/scsol_erp/sensor/src/sensor_insert.php"></iframe>');
    
  });

  $('.item.sensor_srh').on('click', function () {

    $('.container').html('<iframe src="http://www.ithingsware.com:5080/scsol_erp/sensor/src/sensor_search.php"></iframe>');
    
  });

  $('.item.batt_int').on('click', function () {
    
    $('.container').html('<iframe src="http://www.ithingsware.com:5080/scsol_erp/batt/src/batt_int.php"></iframe>');
    
  });

  $('.item.batt_srh').on('click', function () {
    
    $('.container').html('<iframe src="http://www.ithingsware.com:5080/scsol_erp/batt/src/batt_srh.php"></iframe>');
    
  });

  $('.item.prdt_int').on('click', function () {

    $('.container').html('<iframe src="http://www.ithingsware.com:5080/scsol_erp/prdt/src/prdt_int.php"></iframe>');    
    
  });

  $('.item.prdt_srh').on('click', function () {

    $('.container').html('<iframe src="http://www.ithingsware.com:5080/scsol_erp/prdt/src/prdt_search.php"></iframe>');
    
  });
  

});