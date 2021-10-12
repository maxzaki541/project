<?php
session_start();
include 'assets/php/connect.php';

$i = $_GET['t'];

$sql = "UPDATE `queue_emp` SET `eguest_status`='รักษาเสร็จแล้ว',`eguest_room`='' WHERE `eguest_id`='$i'";
    
$sql2 ="UPDATE `queue` SET `queue_status`='รักษาเสร็จแล้ว',`queue_room`='' WHERE `queue_id`='$i'";

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





?>