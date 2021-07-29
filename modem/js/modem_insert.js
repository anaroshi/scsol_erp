$(document).ready(function () {

  /**
   * 초기화 Button
   * make all fields empty
   */
  $('.modem_clear').on('click', function() {
    location.reload();    
  });      


  /**
   * 엑셀 업로드 샘플 Button
   */
  $(".modem_btn.modem_uploadSample").on("click", function () {    
    location.href = "./modem_uploadSample.php";
  });


  /**
   * 엑셀 업로드 Button
   */

  $("#loadExcel").submit(function (e) {
    e.preventDefault();
    //uploadFile(); 

    $.ajax({
      type: "POST",
      url: "./modem_upload.php",
      data: new FormData(this), //*** modem_insert.php내에 value를 가짐
      contentType: false,
      cache:false,
      processData: false,
      dataType: "html",
    })
    .done(async function(data) {
      console.log('success');
      $(".tb_modem").html(data);

    })
    .fail(function(data, textStatus, errorThrown){
      console.log('서버오류: '+ textStatus);
      console.log('서버오류: '+ errorThrown);
    });
  });  
  
});