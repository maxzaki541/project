<?php
session_start();
include 'assets/php/connect.php';

$sqlss="SELECT *FROM `queue_emp` where `eguest_status`='กำลังรักษา'";

$sqlss1 ="SELECT *FROM `queue` where `queue_status`='กำลังรักษา'";


$result1 = mysqli_query($con, $sqlss) or die(mysqli_error());
$num=mysqli_num_rows($result1);

$result2 = mysqli_query($con, $sqlss1) or die(mysqli_error());
$num2=mysqli_num_rows($result2);

if($num+$num2 < 3){


    $i = $_GET['t'];

    $sqlq_e="SELECT `eguest_room` from `queue_emp` where `eguest_status`='กำลังรักษา'";
    
    $sqlq="SELECT `queue_room` from `queue` where `queue_status`='กำลังรักษา'";

    $r[0]=false;
    $r[1]=false;
    $r[2]=false;

    if($load1=$con->query($sqlq_e)){
        while($data1 = $load1->fetch_assoc()){
            // echo $data1['eguest_room'];
            // $tt = $data1['eguest_room'] != '';
            // echo $tt;
            if($data1['eguest_room'] != ''){
                $r[($data1['eguest_room'])]=true;
            }
        }
    }
    if($load=$con->query($sqlq)){
        while($data2 = $load->fetch_assoc()){
            if($data2['queue_room'] != ''){
            $r[($data2['queue_room'])]=true;
            }
        }
    }

    $room=1;
    if($r[0]){
        $room=1;
    }elseif($r[1]){
        $room=2;
    }elseif($r[2]){
        $room=3;
    }
    
    
    $sql = "UPDATE `queue_emp` SET `eguest_status`='กำลังรักษา',`eguest_room`='$room' WHERE `eguest_id`='$i'";
    
    $sql2 ="UPDATE `queue` SET `queue_status`='กำลังรักษา',`queue_room`='$room' WHERE `queue_id`='$i'";

if($con->query($sql)){
    echo "<script type='text/javascript'>
    window.location.href='callq.php';</script>";

}
else{
    $_SESSION['error'] = "ไม่สำเร็จ " . $con->error;
    echo "<script type='text/javascript'>
    window.location.href='callq.php';</script>";
    
}


if($con->query($sql2)){
    echo "<script type='text/javascript'> 
    window.location.href='callq.php';</script>";
   
}

else{
    $_SESSION['error'] = "ไม่สำเร็จ " . $con->error;
    echo "<script type='text/javascript'>
    window.location.href='callq.php';</script>";
}

}else{
    echo "<script>alert('คิวการรักษาเต็มแล้ว')</script>";
    echo "<script type='text/javascript'>
    window.location.href='callq.php';</script>";
}




?>