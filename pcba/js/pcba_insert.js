$(document).ready(function () {

  /**
   * 재고관리 Button
   */
  $('.pcba_trad').on('click', function () {
    $(location).attr('href', '/trad/src/trad_search.php');
  });

  /**
   * 초기화 Button
   * make all fields empty
   */
  $('.pcba_clear').on('click', function() {
    location.reload();
    
  });      

  /**
   * 엑셀 업로드 샘플 Button
   */
   $(".pcba_btn.pcba_uploadSample").on("click", function () {    
    location.href = "./pcba_uploadSample.php";
  });
  
  /**
   * 조회 Button
   * go to 조회 화면 
   */
  $('.pcba_search').on('click', function () {
    $(location).attr('href', './pcba_search.php');
    
  });

  /**
   * 엑셀 다운로드 Button
   */
  $('.pcba_excel').on('click', function () {
    alert('엑셀 다운로드');
    
  });
  
  /**
   * 엑셀 업로드 Button
   */

  $("#loadExcel").submit(function (e) {
    e.preventDefault();
    //uploadFile(); 

    $.ajax({
      type: "POST",
      url: "./pcba_upload.php",
      data: new FormData(this), //*** pcba_insert.php내에 value를 가짐
      contentType: false,
      cache:false,
      processData: false,
      dataType: "html",
    })
    .done(async function(data) {
      console.log('success');
      $(".tb_pcba").html(data);

    })
    .fail(function(data, textStatus, errorThrown){
      console.log('서버오류: '+ textStatus);
      console.log('서버오류: '+ errorThrown);
    });
  });  
  
});