<?php
  session_start();
  include 'assets/php/connect.php';
  if(!isset($_SESSION['staff_id'])) header("location:index.php");
  if(isset($_REQUEST['t']) ) {
    $i = $_REQUEST['t'];
}else{
    header("location:index_history_medical.php");
}

if(isset($_REQUEST['s']) ) {
    $s = $_REQUEST['s'];
}else{
    header("location:index_history_medical.php");
}


?>
<html>
<head><title>แบบฟอร์มบันทึกการรักษา</title>


<style type='text/css'>
body{
  color:#000000; background-color:#ffffff;
  font-family:arial, verdana, sans-serif; font-size:12pt;}

fieldset {
  font-size:18px;
  padding:10px;
  
  line-height:1.8;}

label:hover {cursor:hand;}
</style>
</head>
<body>

<br>
<br>
<br><br><br>
<?php

                //นำเข้าไฟล์ การเชื่อมต่อฐานข้อมูล
                

                $sql = "SELECT * FROM (((( `diagnosis` INNER JOIN `patient_info` ON diagnosis.Info_id = patient_info.Info_id) 
                INNER JOIN `defence` ON diagnosis.de_id = defence.de_id) JOIN type_service ON type_service.type_id = defence.type_id)
                INNER JOIN medic ON diagnosis.medic_id = medic.medic_id)JOIN nexttime ON nexttime.de_id = defence.de_id
                WHERE patient_info.Info_name='$i' and patient_info.Info_surename='$s'";
                $result = $con->query($sql);
                $n=1;

                

                // เเสดงข้อมูลจากฐานข้อมูล
                
                while ($item = mysqli_fetch_assoc($result)) { 
                ?>
<fieldset style="width:1000px " >
    <legend >แบบฟอร์มบันทึกการรักษา:</legend>
    <label for="fname">ชื่อ-นามสกุล (ผู้มารักษา): ....<?php echo $item["Info_name"]." ".$item["Info_surename"]; ?>..............</label>
    <br><br>
    <label for="lname">ประเภทการรักษา :</label>
    ประคบร้อน
    <input type="checkbox" id="lname" name="lname">
    นวดแพทย์แผนไทย
    <input type="checkbox" id="lname" name="lname">
    อื่นๆ
    <input type="checkbox" id="lname" name="lname">(กรุณาระบุ)<br><br>

    <label for="email">การรักษาอื่นๆ : .............................................................................</label>
    

    <label for="birthday">วินิจฉัยอาการ : .................................................................</label><br><br>
    
    <label for="birthday">ชื่อแพทย์ที่ทำการรักษา : ...................................................................................................</label><br><br>

    <label for="email">วัน/เดือน/ปี ที่นัดหมายถัดไป : ..........................................</label>
    <label for="email">เวลา ที่นัดหมายถัดไป : ..........................................</label>

    
  </fieldset>
  <?php
  }
  ?>
</body>

</html>
<script>

    window.print();
    
</script>