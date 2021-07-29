<?php
include($_SERVER['DOCUMENT_ROOT'] . "/connect_db.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbConfig_scsolERP.php");
include($_SERVER['DOCUMENT_ROOT'] . "/scsol_erp/template/templ_noCash.php");

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

/**
 * sensor hz 값 추출
 * 주파수 값 DB에 저장
 * table : sensor_hz
 * value : freq_value, freq_no
 */

$total_sn_num           = 0;
$readed_sn              = array();
$readed_sn_num          = 0;
$completed_sn           = array();
$completed_sn_num       = 0;

$sql = "SELECT sensor_sn FROM trad_part_sensor WHERE flag != 4 and status='used'";
if(!($result=mysqli_query($conn_11,$sql))) {
    echo ("Error description: ".mysqli_error($conn_11)."query: ".$sql."<br>");
}

$total_sn_num           = mysqli_num_rows($result);

if(is_null($result)) {
    echo "No Sensor";
    exit();
}


while ($row = mysqli_fetch_array($result)) {

    $sensor_sn          = $row['sensor_sn'];            // 센서 SN
    $completed_sn_num   = process_bysensor_sn ($sensor_sn, $conn_11, $completed_sn_num);
}

Console_log("총 $total_sn_num 개 센서 중 $completed_sn_num 개 센서의 Data가 추출되었습니다.");


/**
 * process_bysensor_sn
 * 
 * @param {*} sensor_sn 
 * @param {*} conn_11 
 * @param {*} completed_sn_num
 */

function process_bysensor_sn ($sensor_sn, $conn_11, $completed_sn_num) {
    $sn_dir             = substr($sensor_sn,-4);
    $tradDate           = substr($sensor_sn,7,6);
    $hz                 = "mix";
    $l                  = 0;                            // 읽어드린 파일 중 csv파일 갯수
    $m                  = 0;                            // csv파일 중 DB에 올린 파일 갯수

    // $sensor_sn  = "sensor-210205-0001";              // 센서 SN
    // $sn_dir     = substr($sensor_sn,-4);
    // $tradDate   = substr($sensor_sn,7,6);
    // $hz         = "mix";

    echo "sensor_sn:$sensor_sn, sn_dir:$sn_dir, tradDate:$tradDate, hz:$hz <br>";
    /****** Directory내에 추출할 file명 list를 읽어들임 ******/


    // 읽어들일 file들이 있는 경로 & 이동시킬 디렉토리
    // /home/scsol/public_html/scsol_erp/sensor/data/210205/0601/4/20210325_174449_372859780_1270562715_1c_04_Audio_bt.csv
    $path               = "../data/$tradDate/$sn_dir";
    $readpath           = $path."/".$hz."/";
    $movepath           = $readpath."done/";
  
    @chmod($path,0777);

    // if(!is_dir($readpath)) {
    //     echo("${readpath} 있다구<br>");
    // }

    if(!is_dir($movepath)) {
        @mkdir($movepath,0777);
        if(is_dir($movepath)) {
            @chmod($movepath,0777);
            echo ("${movepath} 디렉토리 생성<br>");
        }else {
            echo ("${movepath} 디렉토리  생성 실패<br>");
        }
    }

//    echo ("readpath:$readpath"."<br>");
//    echo ("movepath:$movepath"."<br>");

    if(is_dir($readpath)) {
        
        //echo ("readpath:$readpath"."<br>");
        
        $files              = array();
        $successedfiles     = array();

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
                //$readed_sn_num++;
                $readed_sn[] = $sensor_sn;

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
                if($i>2 ) goto filemax;        // 3개 파일까지만 읽어드리게 함.
                $filename[$i]   = $f;

                $readfile = $readpath . $f;
                $movefile = $movepath . $f;
                
                //echo "filename: $filename[$i]<br>";
                echo "readfile: $readfile<br>";
                    
                if (($handle = fopen($readfile, "r")) != FALSE) {

                    $n = 0; // 파일내에 row 갯수
                 
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                        $n++;

                        if ($n < 2) continue;                        
                        
                        $sql = "insert into sensor_hz ( sensor_sn, tradDate, hz, filename, freq_value, freq_no, inDate ) ";
                        $sql .= "values('$sensor_sn','$tradDate','$hz','$f','$data[0]','$data[1]',now())";
                         
                        if (!($result = mysqli_query($conn_11, $sql))) {
                            echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql."<br>");
                        }
                    }
                    
                    $m++;
                    $successedfiles[$i] = $f;
                }
                echo "==> row : $n <br>";
                fclose($handle);
                
                $i++;

                rename($readfile, $movefile); // 완료 폴더로 파일 이동
            }

            filemax:

            process_exstractHz ($sensor_sn, $tradDate, '400', $conn_11, $i);
            process_exstractHz ($sensor_sn, $tradDate, '600', $conn_11, $i);
            process_exstractHz ($sensor_sn, $tradDate, '800', $conn_11, $i);
            process_exstractHz ($sensor_sn, $tradDate, '1000', $conn_11, $i);
            process_exstractHz ($sensor_sn, $tradDate, '1200', $conn_11, $i);

            $sql = "DELETE FROM sensor_hz WHERE filename ='$filename[0]' OR filename ='$filename[1]' OR filename ='$filename[2]'";
            //echo $sql."<br>";
            if (!($result = mysqli_query($conn_11, $sql))) {
                echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql."<br>");
            }

            $completed_sn[] = $sensor_sn;
          
        }

        Console_log("총 $l 개 파일 중 $m 개 파일이 변환되었습니다.");
        Console_log("$sensor_sn 는 추출이 완료되었습니다.");
        $completed_sn_num++;

        //    var_dump(memory_get_usage(true));  // 메모리 사용량 얻기
        
    } else {
            
        Console_log("$sensor_sn 에는 파일 경로가 없습니다.");
    }

    foreach ($successedfiles as $sf) {
        Console_log($sf);
    }

    endRead:
    
    echo "--------------------------- $sensor_sn -------------------------------------<br>";
    
    return $completed_sn_num;
   
}


/**
 * process_exstractHz
 * 
 * @param {*} sensor_sn 
 * @param {*} tradDate 
 * @param {*} hz 
 * @param {*} conn_11
 * @param {*} i 
 */
function process_exstractHz($sensor_sn, $tradDate, $hz, $conn_11, $i) {

    // echo("process_exstractHz : $sensor_sn, $tradDate, $hz, $i 개일 파일 <br>");
    $sql = "SELECT A.* FROM sensor_hz A ";
    $sql .= "INNER JOIN ( SELECT max(freq_value) freq_value, filename ";
    $sql .= "FROM sensor_hz WHERE 1 AND sensor_sn='$sensor_sn' AND tradDate='$tradDate' ";
    if ($hz == '400') {
        $sql .= "AND freq_no BETWEEN 390 AND 410 ";
    } elseif ($hz == '600') {
        $sql .= "AND freq_no BETWEEN 590 AND 610 ";
    } elseif ($hz == '800') {
        $sql .= "AND freq_no BETWEEN 790 AND 810 ";
    } elseif ($hz == '1000') {
        $sql .= "AND freq_no BETWEEN 990 AND 1010 ";
    } elseif ($hz == '1200') {
        $sql .= "AND freq_no BETWEEN 1190 AND 1210 ";
    }    
    $sql .= "GROUP BY filename ORDER BY filename ) B ";
    $sql .= "ON A.freq_value = B.freq_value AND A.filename = B.filename ";
    
    //echo $sql."<br>";

    if (!($result = mysqli_query($conn_11, $sql))) {
        echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql."<br>");
    }

    //$filename   = array();
    $freq_value = array();
    $freq_no    = array();

    $j = 1;
    while ($row = mysqli_fetch_array($result)) {
        $sensor_sn      = $row['sensor_sn'];
        $tradDate       = substr($row['tradDate'],0,2)."-".substr($row['tradDate'],2,2)."-".substr($row['tradDate'],-2);
        //$filename[$j]   = $row['filename'];
        $freq_value[$j] = sprintf('%0.1f', $row['freq_value']);
        $freq_no[$j]    = $row['freq_no'];
        $j++;
    }
    //echo $hz."==>";
    switch ( $hz ) {
        case '400':
            $hz_mix_fieldname = 'hz_mix_fh';
            break;
        case '600':
            $hz_mix_fieldname = 'hz_mix_sh';
            break;
        case '800':
            $hz_mix_fieldname = 'hz_mix_eh';
            break;
        case '1000':
            $hz_mix_fieldname = 'hz_mix_tt';
            break;
        case '1200':
            $hz_mix_fieldname = 'hz_mix_tw';
            break;
        default:
            $hz_mix_fieldname = 'no';
            echo 'not availale!!';       
    }

    // echo ("hz : $hz <br>");
    // echo ("file number : $i <br>");

    if($hz_mix_fieldname == 'no') {
        goto endRead;
        //exit();
    }    
    if ($i == 3) {
        echo ("It has 3 files. <br>");
        $hz_mix_fieldname1      = $hz_mix_fieldname.'1';
        $hz_mix_fieldname2      = $hz_mix_fieldname.'2';
        $hz_mix_fieldname3      = $hz_mix_fieldname.'3';
        $hzno_mix_fieldname1    = $hz_mix_fieldname.'1_no';
        $hzno_mix_fieldname2    = $hz_mix_fieldname.'2_no';
        $hzno_mix_fieldname3    = $hz_mix_fieldname.'3_no';
        $hzavg_fieldname        = $hz_mix_fieldname.'Avg';
        $hzavg                  = sprintf('%0.1f', ($freq_value[1] + $freq_value[2] + $freq_value[3])/3);

        echo " $hz_mix_fieldname : $freq_value[1] : $freq_value[2] : $freq_value[3] : $hzavg <br>";
        echo " $sensor_sn : $tradDate : $hz <br>";
        
        $sql   = "UPDATE trad_part_sensor SET ";
        $sql  .= "$hzavg_fieldname = $hzavg, reDate = now() ";
        $sql  .= "WHERE sensor_sn='$sensor_sn' AND tradDate='$tradDate' ";

        $sql_mix   = "UPDATE trad_part_sensor_hzmix SET ";
        $sql_mix  .= "$hz_mix_fieldname1 = $freq_value[1], $hzno_mix_fieldname1 = $freq_no[1], ";
        $sql_mix  .= "$hz_mix_fieldname2 = $freq_value[2], $hzno_mix_fieldname2 = $freq_no[2], ";
        $sql_mix  .= "$hz_mix_fieldname3 = $freq_value[3], $hzno_mix_fieldname3 = $freq_no[3], ";
        $sql_mix  .= "$hzavg_fieldname = $hzavg, reDate = now() ";
        $sql_mix  .= "WHERE sensor_sn='$sensor_sn' ";


    }   elseif ($i == 2) {
        echo ("It has 2 files.");
        $hz_mix_fieldname1      = $hz_mix_fieldname.'1';
        $hz_mix_fieldname2      = $hz_mix_fieldname.'2';
        
        $hzno_mix_fieldname1    = $hz_mix_fieldname.'1_no';
        $hzno_mix_fieldname2    = $hz_mix_fieldname.'2_no';
        
        $hzavg_fieldname        = $hz_mix_fieldname.'Avg';
        $hzavg                  = sprintf('%0.1f', ($freq_value[1] + $freq_value[2])/2);

        echo " $hz_mix_fieldname : $freq_value[1] : $freq_value[2] : $hzavg <br>";
        echo " $sensor_sn : $tradDate : $hz <br>";
        
        $sql   = "UPDATE trad_part_sensor SET ";
        $sql  .= "$hzavg_fieldname = $hzavg, reDate = now() ";
        $sql  .= "WHERE sensor_sn='$sensor_sn' AND tradDate='$tradDate' ";

        $sql_mix   = "UPDATE trad_part_sensor_hzmix SET ";
        $sql_mix  .= "$hz_mix_fieldname1 = $freq_value[1], $hzno_mix_fieldname1 = $freq_no[1], ";
        $sql_mix  .= "$hz_mix_fieldname2 = $freq_value[2], $hzno_mix_fieldname2 = $freq_no[2], ";
        $sql_mix  .= "$hzavg_fieldname = $hzavg, reDate = now() ";
        $sql_mix  .= "WHERE sensor_sn='$sensor_sn' ";

    }   elseif ($i == 1) {
        echo ("It has only 1 file.");
        $hz_mix_fieldname1          = $hz_mix_fieldname.'1';
        $hzno_mix_fieldname1        = $hz_mix_fieldname.'1_no';
        $hzavg_fieldname            = $hz_mix_fieldname.'Avg';
        $hzavg                      = sprintf('%0.1f', $freq_value[1]);

        echo " $hz_mix_fieldname : $freq_value[1] : $hzavg <br>";
        echo " $sensor_sn : $tradDate : $hz <br>";
        
        $sql   = "UPDATE trad_part_sensor SET ";
        $sql  .= "$hzavg_fieldname = $hzavg, reDate = now() ";
        $sql  .= "WHERE sensor_sn='$sensor_sn' AND tradDate='$tradDate' ";

        $sql_mix   = "UPDATE trad_part_sensor_hzmix SET ";
        $sql_mix  .= "$hz_mix_fieldname1 = $freq_value[1], $hzno_mix_fieldname1 = $freq_no[1], ";
        $sql_mix  .= "$hzavg_fieldname = $hzavg, reDate = now() ";
        $sql_mix  .= "WHERE sensor_sn='$sensor_sn' ";

    } else {
        echo ('No Hz Data! <br>');
        goto endRead;
        //exit();
    }

    //echo $sql."<br>";

    if (!($result = mysqli_query($conn_11, $sql))) {
        echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql."<br>");
    }
    
    if (!($result = mysqli_query($conn_11, $sql_mix))) {
        echo ("Error description: " . mysqli_error($conn_11) . "query: " . $sql_mix."<br>");
    }

    endRead:

}

function Console_log($logcontent)
{
    echo "<script>console.log('$logcontent');</script><br>";
}

function alert_log($logcontent)
{
    echo "<script>alert('$logcontent');</script>";
}
