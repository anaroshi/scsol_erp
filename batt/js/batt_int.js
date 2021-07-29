'use strict';
$(document).ready(function () {

    /**
     * 초기화 Button
     */
    $(".batt_btn.batt_clear").on("click", function () {
        location.reload();
    });

    /**
     * 엑셀 업로드 샘플 Button
     */
    $(".batt_btn.batt_uploadSample").on("click", function () {
        
        location.href = "./batt_uploadSample.php";
    });


  /**
   * 엑셀 업로드 Button
   */

    $("#loadExcel").submit(function (e) {
        e.preventDefault();

        $.ajax({
        type: "POST",
        url: "./batt_upload.php",
        data: new FormData(this), //*** batt_int.php내에 value를 가짐
        contentType: false,
        cache:false,
        processData: false,
        dataType: "html",
        })
        .done(async function(data) {
        console.log('success');
        $(".tb_batt").html(data);

        })
        .fail(function(data, textStatus, errorThrown){
        console.log('서버오류: '+ textStatus);
        console.log('서버오류: '+ errorThrown);
        });
    });

});