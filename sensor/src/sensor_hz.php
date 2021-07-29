<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

/**
 * sensor hz 값 추출
 * 주파수 값 DB에 저장
 * table : sensor_hz
 * value : freq_value, freq_no
 */
$totoal_sn_num          = 0;
$readed_sn              = array();
$readed_sn_num          = 0;
$completed_sn           = array();
$completed_sn_num       = 0;
$readedfile_num         = 0;

$sql  = "SELECT sensor_sn FROM trad_part_sensor WHERE flag !=4 AND status='used' ";
//$sql .= "AND sensor_sn BETWEEN 'sensor-210205-0612' AND 'sensor-210205-0795'";

if(!($result = mysqli_query($conn_11,$sql))) {
    echo ("Error description: ".mysqli_error($conn_11)."query:".$sql);
}

$total_sn_num           = mysqli_num_rows($result);
if(is_null($result)) {
    echo "No Sensor";
    exit();
}    

while ($row             = mysqli_fetch_array($result)) {
    $sensor_sn          = $row['sensor_sn'];
    echo $sensor_sn."<br>";
    $readedfile_num     = $readedfile_num + process_bySensor_sn($sensor_sn, $conn_11, $readedfile_num);
}


// $sensor_sn  = "sensor-210205-0611";         // 센서 SN
// $readedfile_num =  $readedfile_num + process_bySensor_sn($sensor_sn, $conn_11, $readedfile_num);

echo "$sensor_sn 에 총 $readedfile_num 개의 파일이 변환되었습니다. ";

/**
 * process_bySensor_sn
 * 
 * @param {*} sensor_sn 
 * @param {*} conn_11
 */
function process_bySensor_sn ($sensor_sn, $conn_11, $readedfile_num) {   
    //echo "process_bySensor_sn (".$sensor_sn.")<br>";
    $hz400_num      = process_byHz ($sensor_sn, $conn_11, '400');
    $hz600_num      = process_byHz ($sensor_sn, $conn_11, '600');
    $hz800_num      = process_byHz ($sensor_sn, $conn_11, '800');
    $hz1000_num     = process_byHz ($sensor_sn, $conn_11, '1000');
    $hz1200_num     = process_byHz ($sensor_sn, $conn_11, '1200');

    $readedfile_num = $readedfile_num + $hz400_num + $hz600_num + $hz800_num + $hz1000_num + $hz1200_num;
    return $readedfile_num;

}


/**
 * process_byHz
 * sensor hz 값 추출
 * 주파수 값 DB에 저장
 * table : sensor_hz
 * value : freq_value, freq_no
 * @param {*} sensor_sn 
 * @param {*} hz 
 * @param {*} conn_11
 */

function process_byHz ($sensor_sn, $conn_11, $hz) {

    $sn_dir     = substr($sensor_sn,-4);
    $tradDate   = substr($sensor_sn,7,6);
    $l          = 0;                            // 읽어드린 파일 중 csv파일 갯수
    $m          = 0;                            // csv파일 중 DB에 올린 파일 갯수


    //echo "process_byHz ( sensor_sn:$sensor_sn, sn_dir:$sn_dir, tradDate:$tradDate, hz:$hz )<br>";

    /****** 디렉토리내에 변화시킬 file명 list를 읽어들임 ******/

    // 읽어들일 file들이 있는 경로 & 이동시킬 디렉토리
    // /home/scsol/public_html/scsol_erp/sensor/data/210205/0601/4/20210325_174449_372859780_1270562715_1c_04_Audio_bt.csv
    $path           = $_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/sensor/data/$tradDate";
    $pathSn         = $path."/".$sn_dir;
    $readpath       = $pathSn."/".$hz."/";
    $movepath       = $readpath."done/";

    chmod($readpath, 0777);
    if(!is_dir($movepath)) {
        mkdir($movepath);
        chmod($movepath, 0777);
    }


    // echo ("readpath:$readpath"."<br>");
    // echo ("movepath:$movepath"."<br>");
    if(is_dir($readpath)) {
        //echo "read";

        $files          = array();
        $successedfiles = array();

        if($handle = opendir($readpath)) {
            while (($file = readdir($handle)) !== false) {
                
                if ($file == "." || $file == ".." || substr($file, -4) != ".csv") {
                    continue;
                }
                
                // csv 파일인 경우만 목록에 추가
                if (is_file($readpath . $file)) {
                    $files[] = $file;
                    $l++;
                    //echo "filename: $file : filetype : ". filetype($readpath.$file)."<br>";
                }

            }

            //echo $l."개 files<br>";
            // 핸들 해제
            closedir($handle);

            if ($l == 0) {
                Console_log("$sensor_sn 에는 추출할 파일이 없습니다.");
                goto endRead;
                //exit();
            }

            // 정렬
            sort($files);

            $i = 0;
            // 파일명 출력
            foreach ($files as $f) {
                if($i>2 ) break;        // 3개 파일까지만 읽어드리게함.

                $readfile = $readpath . $f;
                $movefile = $movepath . $f;
                
                //echo "readfile: $readfile ";

                if (($handle = fopen($readfile, "r")) != FALSE) {

                    $n = 0; // 파일내에 row 갯수

                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $n++;
                        if ($n < 2) continue;    
                        
                        $sql = "insert into sensor_hz ( sensor_sn, tradDate, hz, filename, freq_value, freq_no, inDate ) ";
                        $sql .= "values('$sensor_sn','$tradDate','$hz','$f','$data[0]','$data[1]',now())";
                        if (!($result = mysqli_query($conn_11, $sql))) {
                            echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
                        }                   
                    }

                    $m++;
                    $successedfiles[] = $f;
                }
                //echo "==> row : $n <br>";
                fclose($handle);
                $i++;

                rename($readfile, $movefile); // 완료 폴더로 파일 이동
            }
            echo "process_byHz ( sensor_sn:$sensor_sn, sn_dir:$sn_dir, tradDate:$tradDate, hz:$hz )<br>";
           

            $sql  = "SELECT A.* FROM sensor_hz A ";
            $sql .= "INNER JOIN (SELECT max(freq_value) freq_value, filename ";
            $sql .= "FROM sensor_hz WHERE 1 AND sensor_sn='$sensor_sn' AND tradDate='$tradDate' AND hz='$hz' GROUP BY filename ORDER BY filename) B ";
            $sql .= "ON A.freq_value = B.freq_value AND A.filename = B.filename ";
            
            //echo $sql."<br>";

            if (!($result = mysqli_query($conn_11, $sql))) {
                echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
            }

            $filename   = array();
            $freq_value = array();
            $freq_no    = array();

            $j = 1;
            while ($row = mysqli_fetch_array($result)) {
                $sensor_sn      = $row['sensor_sn'];
                $tradDate       = substr($row['tradDate'],0,2)."-".substr($row['tradDate'],2,2)."-".substr($row['tradDate'],-2);
                $hz             = $row['hz'];
                $filename[$j]   = $row['filename'];
                $freq_value[$j] = sprintf('%0.1f', $row['freq_value']);
                $freq_no[$j]    = $row['freq_no'];
                $j++;
            }
            
            switch ( $hz ) {
                case '400':
                    $hz_fieldname = 'hz_fh';
                    break;
                case '600':
                    $hz_fieldname = 'hz_sh';
                    break;
                case '800':
                    $hz_fieldname = 'hz_eh';
                    break;
                case '1000':
                    $hz_fieldname = 'hz_tt';
                    break;
                case '1200':
                    $hz_fieldname = 'hz_tw';
                    break;
                default:
                    $hz_fieldname = 'no';
                    echo 'not availale!!';       
            }

            // echo ("hz : $hz <br>");
            // echo ("file number : $i <br>");

            if($hz_fieldname == 'no') goto endRead;

            if ($i == 3) {
                echo ("It has 3 files.");
                $hz_fieldname1          = $hz_fieldname.'1';
                $hz_fieldname2          = $hz_fieldname.'2';
                $hz_fieldname3          = $hz_fieldname.'3';
                $hzno_fieldname1        = $hz_fieldname.'1_no';
                $hzno_fieldname2        = $hz_fieldname.'2_no';
                $hzno_fieldname3        = $hz_fieldname.'3_no';
                $hzavg_fieldname        = $hz_fieldname.'Avg';
                $hzavg                  = sprintf('%0.1f', ($freq_value[1] + $freq_value[2] + $freq_value[3])/3);

                echo " $hz_fieldname : $freq_value[1] : $freq_value[2] : $freq_value[3] : $hzavg <br>";
                //echo " $sensor_sn : $tradDate : $hz <br>";
                
                $sql   = "UPDATE trad_part_sensor SET ";
                $sql  .= "$hzavg_fieldname = $hzavg, reDate = now() ";
                $sql  .= "WHERE sensor_sn='$sensor_sn' AND tradDate='$tradDate' ";
        
                $sql_hz   = "UPDATE trad_part_sensor_hzmix SET ";
                $sql_hz  .= "$hz_fieldname1 = $freq_value[1], $hzno_fieldname1 = $freq_no[1], ";
                $sql_hz  .= "$hz_fieldname2 = $freq_value[2], $hzno_fieldname2 = $freq_no[2], ";
                $sql_hz  .= "$hz_fieldname3 = $freq_value[3], $hzno_fieldname3 = $freq_no[3], ";
                $sql_hz  .= "$hzavg_fieldname = $hzavg, reDate = now() ";
                $sql_hz  .= "WHERE sensor_sn='$sensor_sn' ";

            }   elseif ($i == 2) {
                echo ("It has 2 files.");
                $hz_fieldname1          = $hz_fieldname.'1';
                $hz_fieldname2          = $hz_fieldname.'2';
                
                $hzno_fieldname1        = $hz_fieldname.'1_no';
                $hzno_fieldname2        = $hz_fieldname.'2_no';
                
                $hzavg_fieldname        = $hz_fieldname.'Avg';
                $hzavg                  = sprintf('%0.1f', ($freq_value[1] + $freq_value[2])/2);

                echo " $hz_fieldname : $freq_value[1] : $freq_value[2] : $hzavg <br>";
                //echo " $sensor_sn : $tradDate : $hz <br>";
                
                $sql   = "UPDATE trad_part_sensor SET ";
                $sql  .= "$hzavg_fieldname = $hzavg, reDate = now() ";
                $sql  .= "WHERE sensor_sn='$sensor_sn' AND tradDate='$tradDate' ";
        
                $sql_hz   = "UPDATE trad_part_sensor_hzmix SET ";
                $sql_hz  .= "$hz_fieldname1 = $freq_value[1], $hzno_fieldname1 = $freq_no[1], ";
                $sql_hz  .= "$hz_fieldname2 = $freq_value[2], $hzno_fieldname2 = $freq_no[2], ";
                $sql_hz  .= "$hzavg_fieldname = $hzavg, reDate = now() ";
                $sql_hz  .= "WHERE sensor_sn='$sensor_sn' ";

            }   elseif ($i == 1) {
                echo ("It has only 1 file.");
                $hz_fieldname1          = $hz_fieldname.'1';
                $hzno_fieldname1        = $hz_fieldname.'1_no';
                $hzavg_fieldname        = $hz_fieldname.'Avg';
                $hzavg                  = sprintf('%0.1f', $freq_value[1]);

                echo " $hz_fieldname : $freq_value[1] : $hzavg <br>";
                //echo " $sensor_sn : $tradDate : $hz <br>";
                
                $sql   = "UPDATE trad_part_sensor SET ";
                $sql  .= "$hzavg_fieldname = $hzavg, reDate = now() ";
                $sql  .= "WHERE sensor_sn='$sensor_sn' AND tradDate='$tradDate' ";
        
                $sql_hz   = "UPDATE trad_part_sensor_hzmix SET ";
                $sql_hz  .= "$hz_fieldname1 = $freq_value[1], $hzno_fieldname1 = $freq_no[1], ";
                $sql_hz  .= "$hzavg_fieldname = $hzavg, reDate = now() ";
                $sql_hz  .= "WHERE sensor_sn='$sensor_sn' ";

            } else {
                echo ('No Hz Data!');
                goto endRead;
                //exit();
            }

            // echo $sql."<br>";

            if (!($result = mysqli_query($conn_11, $sql))) {
                echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
            }

            if (!($result = mysqli_query($conn_11, $sql_hz))) {
                echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql_hz);
            }

            $sql = "DELETE FROM sensor_hz WHERE filename ='$filename[1]' OR filename ='$filename[2]' OR filename ='$filename[3]'";
            //echo $sql."<br>";
            if (!($result = mysqli_query($conn_11, $sql))) {
                echo ("Error description: " . mysqli_error($conn_11) . "query:" . $sql);
            }
            
        }

        //    var_dump(memory_get_usage(true));  // 메모리 사용량 얻기

        
    }

    Console_log("총 $l 개 파일 중 $m 개 파일이 변환되었습니다.");

    
    foreach ($successedfiles as $sf) {
        Console_log($sf);
    }

    endRead:
    echo "--------------------------- $sensor_sn -------------------------------------<br>";
    //return $completed_sn_num;
    return $i; // 파일수


}

function Console_log($logcontent)
{
    echo "<script>console.log('$logcontent');</script>" . PHP_EOL;
}

function alert_log($logcontent)
{
    echo "<script>alert('$logcontent');</script>";
}
