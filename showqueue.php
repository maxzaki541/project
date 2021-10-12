<?php
// session_start();
// $inRoom = [];
// if(!isset($_SESSION["inRoom"])){
//     echo "<script>alert('gfhgggggg')</script>"; 
//     $inRoom[0] = [];
//     $inRoom[1] = [];
//     $inRoom[2] = [];

//     $_SESSION["inRoom"] = $inRoom;

// }
// else{
//     $inR = $_SESSION["inRoom"];
//     echo "<script>console.log('gfhgggggg2222  $inR')</script>"; 
//     if(count( $inR[0] ) == 0)
//         $inRoom[0] = [];
//     else 
//         $inRoom[0] = $inR[0];
//         print_r($inRoom);
//         echo "<script>console.log('gfhgggggg2222  ".$inRoom[0][0]."')</script>";


// if(count($inR[1]) == 0)
//     $inRoom[1] = [];
// else {
//     $inRoom[1] = $inR[1]
// }

// if(count($inR[2]) == 0)
//     $inRoom[2] = [];
// else {
//     $inRoom[2] = $inR[2]
// }

// }

// echo "<script>alert($inRoom)</script>";
// return;

?>

<head>
    <script language="JavaScript" type="text/javascript">
        var i = 0;

        function sivamtime() {
            now = new Date();
            //const months = ["มกราคม", "กุมภาพันธ์", "มีนาคม ","เมษายน", "พฤษภาคม ", "มิถุนายน ", "กรกฎาคม ", "สิงหาคม ", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
            //const day = ["จันทร์", "อังคาร", "พุธ ","พฤหัสบดี", "ศุกร์ ", "เสาร์ ", "อาทิตย์ "];

            hour = now.getHours();
            min = now.getMinutes();
            sec = now.getSeconds();
            today = now.getDate();
            //m = months[now.getMonth()];
            y = now.getFullYear() + 543;
            mm = now.getMonth() + 1;



            time = hour + ":" + min + ":" + sec;
            day = today + "/" + mm + "/" + y;
            if (document.getElementById) {
                theTime.innerHTML = "วัน : " + day + "<br>" + "ขณะนี้เวลา " + time + " น.";
            } else if (document.layers) {
                document.layers.theTime.document.write(time);
                document.layers.theTime.document.close();
            }
            setTimeout("sivamtime()", 1000);
            if (i == 10) {
                location.reload()
            }


            i++;
        }
        window.onload = sivamtime;
    </script>
    <title>แสดงคิว</title>
</head>

<body>

    <div align="left">
        <!-- แก้ไขตำแหน่งของนาฬิกาที่ left และ top ครับ -->
        <span id="theTime" font-family: Tahoma; color:#FF0000></span>
    </div>
</body>

<?php
include 'assets/php/connect.php';



$y = date("Y") + 543;
$sql = "SELECT * FROM `queue_emp` a JOIN `type_service` b ON a.type_id = b.type_id where eguest_date='" . date($y . '-m-d') . "' ";


$info = array();
$q =  mysqli_query($con, $sql);
while ($data = $q->fetch_assoc()) {

    $i = substr($data['eguest_time'], 6);

    $time = explode("-", $data['eguest_time']);
    $time2 = explode(":", $time[1]);
    $tt = $time2[0] + ($time2[1] / 100);
    //echo $i;

    if (time() <= strtotime($i)) {
        $temp = array();
        array_push($temp, $data['eguest_id'], $data['eguest_date'], $data['eguest_time'], $data['type_name'], $data['namepub'], $data['lastnamepub'], $tt, $data['eguest_status'], $data['eguest_room']);
        array_push($info, $temp);
    }
}

$sql_m = "SELECT * FROM `queue` a JOIN `type_service` b ON a.type_id = b.type_id where queue_date='" . date($y . '-m-d') . "'   ";
$q2 =  mysqli_query($con, $sql_m);
while ($data2 = $q2->fetch_assoc()) {

    $i2 = substr($data2['queue_time'], 6);
    $time = explode("-", $data2['queue_time']);
    $time2 = explode(":", $time[1]);
    $tt = $time2[0] + ($time2[1] / 100);
    //echo $i2;

    if (time() <= strtotime($i2)) {
        $temp2 = array();
        $sq1 = "SELECT `member`.f_name,`member`.l_name FROM `member` where `mem_id` = $data2[mem_id]";
        $q3 =  mysqli_query($con, $sq1);
        //echo $sq1;
        while ($data3 = $q3->fetch_assoc()) {

            //$ymd = DateTime::createFromFormat('d-m-Y', $data2['queue_date'])->format('Y-m-d');
            array_push($temp2, $data2['queue_id'], $data2['queue_date'], $data2['queue_time'], $data2['type_name'], $data3['f_name'], $data3['l_name'], $tt, $data2['queue_status'], $data2['queue_room']);
            array_push($info, $temp2);
        }
    }
}

function array_sort_by_column(&$arr, $col, $dir = SORT_ASC)
{
    $sort_col = array();
    foreach ($arr as $key => $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}

array_sort_by_column($info, 8, "SORT_DESC");


echo "<br>";
echo "<table border='1' align='center' width='1500'>";
echo "
                <tr align='center' bgcolor='#66CCFF'>
                    <td><font size='25'>ห้องที่ 1</td>
                    <td><font size='25'>ห้องที่ 2</td>
                    <td><font size='25'>ห้องที่ 3</td> 
                </tr>";
echo "<tr>";
$ii = 0;

//print_r($info);

for ($i = 1; $i <= 3; $i++) {
    $foundRoom = true;
    foreach ($info as $value) {
        if ($ii < 3 and $value[7] == "กำลังรักษา" && $value[8] == $i) {
            $foundRoom = false;
            echo "<td height='500' align='center'><font size='10' >" . "รหัสคิว :"  . $value[0] .  " <br> ";
            echo "คุณ :" . $value[4] . " " . $value[5] .  "</br> ";
            echo "ประเภท :" . $value[3] .  "</br> ";
            $ii++;
        }
    }
    if ($foundRoom)
        echo "<td></td>";
}


echo "</tr>";
echo "</table>";
// sleep(10);
echo "
               
               <script>
               // location.reload();
               //window.reload = sivamtime;
               </script>";
$info2 = array();


$sql5 = "SELECT * FROM `queue_emp` where eguest_date='" . date($y . '-m-d') . "' and eguest_status = '' ";
$q5 =  mysqli_query($con, $sql5);
//echo $sq1;
while ($data5 = $q5->fetch_assoc()) {
    $i = substr($data5['eguest_time'], 6);

    $time = explode("-", $data5['eguest_time']);
    $time2 = explode(":", $time[1]);
    $tt = $time2[0] + ($time2[1] / 100);
    //echo $i;

    if (time() <= strtotime($i)) {
        $temp = array();
        array_push($temp, $data5['eguest_id'], $data5['eguest_date'], $data5['eguest_time'], $data5['type_id'], $data5['namepub'], $data5['lastnamepub'], $tt, $data5['eguest_status']);
        array_push($info2, $temp);
    }
}

$sql_m2 = "SELECT * FROM `queue` where queue_date='" . date($y . '-m-d') . "' and queue_status = ''  order by queue_id ASC ";
$qq2 =  mysqli_query($con, $sql_m2);
while ($data6 = $qq2->fetch_assoc()) {

    $i2 = substr($data6['queue_time'], 6);
    $time = explode("-", $data6['queue_time']);
    $time2 = explode(":", $time[1]);
    $tt = $time2[0] + ($time2[1] / 100) + 0.1;
    //echo $i2;

    if (time() <= strtotime($i2)) {
        $temp2 = array();
        $sq2 = "SELECT `member`.f_name,`member`.l_name FROM `member` where `mem_id` = $data6[mem_id]";
        $qq3 =  mysqli_query($con, $sq2);
        //echo $sq1;
        while ($data7 = $qq3->fetch_assoc()) {

            //$ymd = DateTime::createFromFormat('d-m-Y', $data6['queue_date'])->format('Y-m-d');
            array_push($temp2, $data6['queue_id'], $data6['queue_date'], $data6['queue_time'], $data6['type_id'], $data7['f_name'], $data7['l_name'], $tt, $data6['queue_status']);
            array_push($info2, $temp2);
        }
    }
}

array_sort_by_column($info2, 6);

//    print_r ($info2);

echo "<br>";
echo "<table border='1' align='left' width='700'>";


$ii = 0;


foreach ($info2 as $value) {
    //print_r($value);
    if ($ii < 1) {
        echo "
                    <tr align='center' bgcolor='#66CCFF'>
                    <td><font size='5'>คิวถัดไป </td>";
        echo "<td height='10' align='center'><font size='5' >" . "รหัสคิว :"  . $value[0] .  " <br> ";
        echo "ชื่อ-นามสกุล :" . $value[4] . " " . $value[5] .   " </td>  ";


        echo "</tr>";
        $ii++;
    }
    //echo "รหัสคิว ".$value[0]."</br>";  

}
echo "</tr>";
echo "</table>";

//} //end while
mysqli_close($conn);
/*echo
    "}
    </script>";*/

?>