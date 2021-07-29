"use strict";

$(document).ready(function () {
  
  
  $('#upload').on('click', function(event) {
    event.preventDefault();
    
    $.ajax({
      url: "sensor_hz.php",
      cache: false,
      dataType: "html",
      success: function () {
        console.log("success loading file data");
       // $("#details").html();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("서버오류: " + textStatus);
        console.log("서버오류: " + errorThrown);
      }
    });
  });
});
