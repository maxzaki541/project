<?php
session_start();
include 'assets/php/connect.php';

if(!isset($_SESSION['staff_id'])) header("location:index.php");
?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/console.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    
  
    <title>ยินดีต้อนรับ</title>
    <style>
      input[type="date"] {
    position: relative;
    width: 250px; height: 37px;
    color: white;
    border: 1px solid #ccc;
    border-radius: 2.5px;
}

input:before {
    position: absolute;
    top: 4px; left: 7px;
    content: attr(data-date);
    display: inline-block;
    color: black;
}

/* input::-webkit-datetime-edit, input::-webkit-inner-spin-button, input::-webkit-clear-button {
    display: none;
} */

input::-webkit-calendar-picker-indicator {
    position: absolute;
    top: 4;
    right: 0;
    color: black;
    opacity: 1;
}
      </style>
</head>
<body>


<div class="wrapper">
    <!-- Sidebar -->
    <!-- <?php include 'assets/object/sidebar2.php'?> -->
    <!-- Page Content -->
    <div id="content">
        <?php include 'assets/object/navbar.php'?>

        <div class="container my-4">
            <div class="row">
                <div class="mb-3 col-lg-12">
                    <div class="header">
                        เพิ่มข้อมูลทะเบียนประวัติผู้เข้ารับบริการ
                    </div>
                </div>
                <?php include 'assets/php/log.php'?>
            </div>
            <?php 
                
                // $row = 1;
                // $id = "";
                // do{

                    
                //     $id = "US";
                //     for($i=0;$i<4;$i++){
                //         $id .= rand(0,9);
                //     }
                //     $sql1 = "SELECT * FROM `patient_info` Where `Info_id`=$id";
                //     $load1 = $con->query($sql1);
                //     $row = mysqli_num_rows($load1);

                // }while($row != 0);
                // $sql1 = mysqli_result(mysqli_query($con,"SELECT Max(substr(`di_id`,-3))+1 as MaxID from `diagnosis`"),0,"MaxID");

                $code = "US";
                $sql = "SELECT MAX(Info_id) AS last_id FROM patient_info";
                $qry = mysqli_query($con,$sql) or die(mysqli_error());
                $rs = mysqli_fetch_assoc($qry);
                $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
                //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
                $maxId = ($maxId + 1); 

                $maxId = substr("0000".$maxId, -4);
                $nextId = $code.$maxId;
                
            ?>

           
  
                <script language="javascript">
                    function calAge(o){
                        var tmp = o.value.split("-");
                        var current = new Date();
                        var current_year = current.getFullYear()+543;
                        document.getElementById("age").value = current_year - tmp[0];
                    }
                    </script>

                
            <form action="assets/php/add_patient_info1.php" method="post" enctype="multipart/form-data">
               
             
             <!-- <div class="shadow p-3  bg-primary text-white ">ข้อมูลทั่วไป</div> -->
             <!-- <div class="d-flex flex-column bd-highlight mb-3">ข้อมูลทั่วไป</div> -->
             <div class="w-100 p-3" style="background-color: #eee;">ข้อมูลทั่วไป</div>
                <div class="row my-4" >
                   
                        <input type="hidden" name="1" value="<?php echo $nextId ;?>" pattern="US[0-9]{6}" required class="form-control">
                    
                    <div class="mb-3 col-lg-4">
                        <label for="p_detail" class="form-label">เลขประจำตัวประชาชน</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="0" placeholder="เลขประจำตัวประชาชน" onkeyup="autoTab(this)"  required class="form-control">
                    </div>
                    <div class="mb-3 col-lg-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="form-label">คำนำหน้า</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="6">
                            <option  value="----เลือกคำนำหน้า----">----เลือกคำนำหน้า----</option>
                            <option value="เด็กชาย">เด็กชาย</option>
                            <option value="เด็กหญิง">เด็กหญิง</option>
                            <option value="นาย">นาย</option>
                            <option value="นาง">นาง</option>
                            <option value="นางสาว">นางสาว</option>

                            </select>
                        </div>
                    </div>
                    <div class="mb-3 col-lg-2">
                        <label for="p_detail" class="form-label">ชื่อ</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="2" placeholder="ชื่อ" required class="form-control">
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label for="p_detail" class="form-label">นามสกุล</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="3" placeholder="นามสกุล" required class="form-control">
                    </div>
                    <?php
                     $y=date("Y")+543;
                      $day=date($y.'-m-d');
                      ?>
                    <div class="mb-3 col-lg-3">
                        <label for="stock_in" class="form-label">วันเกิด</label><font size="4" color="#FF0000" align='right'>*</font><br>
                        <input type="date"   name="9" data-date="" data-date-format="YYYY-MM-DD" value=<?php echo '"'.$day.'"';?> id="date" onchange="calAge(this);"   >
                    </div>
                    <div class="mb-3 col-lg-2">
                        <label for="p_price" class="form-label">อายุ</label>
                        <input type="text"  min=1 max=99 name="4" id="age" placeholder="อายุ" readonly="readonly" required class="form-control">
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label for="stock_in" class="form-label">เบอร์โทรศัพท์</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="tel" name="5" placeholder="เบอร์โทรศัพท์" pattern="0[0-9]{9}" required class="form-control">
                    </div>
                    
                    <!--<div class="mb-3 col-lg-5">
                        <label for="stock_in" class="form-label">คำนำหน้า</label>
                        <input type="text" name="6" placeholder="นาย" required class="form-control">
                    </div>-->
                  

                    <div class="mb-3 col-lg-3">
                    <div class="row my-2" >
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">เพศ</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="7">
                            <option>------เลือกเพศ------</option>
                            <option value="ชาย">ชาย</option>
                            <option value="หญิง">หญิง</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <!-- <div class="mb-3 col-lg-2">
                    <label for="stock_in" class="form-label">เพศ</label><font size="4" color="#FF0000" align='right'>*</font>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="7" id="exampleRadios1" value="ชาย" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            ชาย
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="7" id="exampleRadios2" value="หญิง">
                        <label class="form-check-label" for="exampleRadios2">
                            หญิง
                        </label>
                    </div>
                    </div> -->
                    
                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">อาชีพ</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="8" placeholder="รับจ้าง" required class="form-control">
                    </div>

                    

                    <!--<div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">ศาสนา</label>
                        <input type="text" name="10" placeholder="พุทธ" required class="form-control">
                    </div>-->

                    <div class="mb-3 col-lg-3">
                    <div class="row my-2" >
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">ศาสนา</label><font size="4" color="#FF0000" align='right'>*</font>
                            <select class="form-control" id="exampleFormControlSelect1" name="10">
                            <option  value="------เลือกศาสนา------">------เลือกศาสนา------</option>
                            <option value="พุทธ">พุทธ</option>
                            <option value="คริสต์">คริสต์</option>
                            <option value="อิสลาม">อิสลาม</option>
                            <option value="ฮินดู">ฮินดู</option>
                            </select>
                        </div>
                    </div>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">เชื้อชาติ</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="11" placeholder="ไทย" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">สัญชาติ</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="12" placeholder="ไทย" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">ชื่อผู้เเจ้ง</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="13" placeholder="ชื่อผู้เเจ้ง" required class="form-control">
                    </div>

                    <!--<div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">เกี่ยวข้องเป็น</label>
                        <input type="text" name="14" placeholder="บิดา" required class="form-control">
                    </div>-->

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">ชื่อผู้ปกครอง</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="15" placeholder="ชื่อผู้ปกครอง" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">เกี่ยวข้องเป็น</label><font size="4" color="#FF0000" align='right'>*</font>
                            <select class="form-control" id="exampleFormControlSelect1" name="14">
                            <option value="------เลือก------">------เลือก------</option>
                            <option value="บิดา">บิดา</option>
                            <option value="มารดา">มารดา</option>
                            <option value="-">-</option>
                            
                            </select>
                        </div>
                    </div>

                    

                    <div class="mb-3 col-lg-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">สถานะ</label><font size="4" color="#FF0000" align='right'>*</font>
                            <select class="form-control" id="exampleFormControlSelect2" name="16">
                            <option value="------เลือกสถานะ------">------เลือกสถานะ------</option>

                            <option value="โสด">โสด</option>
                            <option value="สมรส">สมรส</option>
                            <option value="อย่าร้าง">อย่าร้าง</option>
                            <option value="หม้าย">หม้าย</option>
                            <option value="สมณะ">สมณะ</option>
                            </select>
                        </div>
                    </div>
                    </div>
                    <?php 
                
                            // $row = 1;
                            // $id = "";
                            // do{

                                
                            //     $id = "AD";
                            //     for($i=0;$i<4;$i++){
                            //         $id .= rand(0,9);
                            //     }
                            //     $sql2 = "SELECT * FROM `address_p` Where `ad_id`=$id";
                            //     $load2 = $con->query($sql2);
                            //     $row2 = mysqli_num_rows($load2);

                            // }while($row2 != 0);
                // $sql1 = mysqli_result(mysqli_query($con,"SELECT Max(substr(`di_id`,-3))+1 as MaxID from `diagnosis`"),0,"MaxID");

                            $code = "AD";
                            $sql = "SELECT MAX(ad_id) AS last_id FROM address_p";
                            $qry = mysqli_query($con,$sql) or die(mysqli_error());
                            $rs = mysqli_fetch_assoc($qry);
                            $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
                            //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
                            $maxId = ($maxId + 1); 

                            $maxId = substr("0000".$maxId, -4);
                            $nextId = $code.$maxId;
                
                     ?>
                     <!-- <h5><center>-----ข้อมูลที่อยู่-----</center></h5> -->
                     <div class="w-100 p-3" style="background-color: #eee;">ข้อมูลที่อยู่</div>
                <div class="row my-4" >
                
                        <input type="hidden" name="17" value="<?php echo $nextId ;?>" placeholder="idadd" pattern="AD[0-9]{4}" required class="form-control">
                    

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">เลขที่บ้าน</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="18" placeholder="เลขที่บ้าน" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">ซอย</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="19" placeholder="ซอย"  required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">ถนน</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="20" placeholder="ถนน"  required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-2">
                        <label for="stock_in" class="form-label">หมู่ที่</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="21" placeholder="หมู่ที่"  required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">ตำบล</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="22" placeholder="ตำบล" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">อำเภอ</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="23" placeholder="อำเภอ" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">จังหวัด</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="24" placeholder="จังหวัด" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">ที่เกิด</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="25" placeholder="ที่เกิด" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="stock_in"  >ที่อยู่สามารถติดต่อได้</label><font size="4" color="#FF0000" align='right'>*</font>
                        <textarea class="form-control" rows="4" cols="50" name="26" placeholder="ที่อยู่สามารถติดต่อได้" required class="form-control"></textarea>
                    </div>
                    
                        <input type="hidden"  name="27" placeholder="รหัสข้อมูลผู้รักษา" required class="form-control">
                        </div>


                        <?php 
                
                                // $row = 1;
                                // $id = "";
                                // do{

                                    
                                //     $id = "SE";
                                //     for($i=0;$i<4;$i++){
                                //         $id .= rand(0,9);
                                //     }
                                //     $sql3 = "SELECT * FROM `service` Where `se_id`=$id";
                                //     $load3 = $con->query($sql3);
                                //     $row3 = mysqli_num_rows($load3);

                                // }while($row2 != 0);
    // $sql1 = mysqli_result(mysqli_query($con,"SELECT Max(substr(`di_id`,-3))+1 as MaxID from `diagnosis`"),0,"MaxID");

                                $code = "SE";
                                $sql = "SELECT MAX(se_id) AS last_id FROM service";
                                $qry = mysqli_query($con,$sql) or die(mysqli_error());
                                $rs = mysqli_fetch_assoc($qry);
                                $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
                                //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
                                $maxId = ($maxId + 1); 

                                $maxId = substr("0000".$maxId, -4);
                                $nextId = $code.$maxId;
    
                         ?>
                         <!-- <h5><center>-----ข้อมูลบริการ-----</center></h5> -->
                         <div class="w-100 p-3" style="background-color: #eee;">ข้อมูลบริการ</div>
                    <div class="row my-4" >
                        <input type="hidden" name="28" value="<?php echo $nextId ;?>"placeholder="idser" pattern="SE[0-9]{4}"required class="form-control">
                    

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">เลขบัตรสิทธิ</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="29" placeholder="เลขบัตรสิทธิ" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">เลขทั่วไป</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="30" placeholder="เลขทั่วไป" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">เลขที่ภายใน</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="31" placeholder="เลขที่ภายใน" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">เลขที่บัตรครอบครัว</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="32" placeholder="เลขที่บัตรครอบครัว" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">เลขที่เอ็กซเรย์</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="33" placeholder="เลขที่เอ็กซเรย์" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">สิทธิการรักษา</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="34" placeholder="สิทธิการรักษา"  require class="form-control">
                    </div>
                    <?php 
                        // $sql3 = "SELECT * FROM `service` WHERE `Info_id`='$i' ";
                        // $load3 = $con->query($sql3);
                        // $data3 = $load3->fetch_assoc();

                        $code = "SE2";
                        $sql = "SELECT MAX(se2_id) AS last_id FROM service2";
                        $qry = mysqli_query($con,$sql) or die(mysqli_error());
                        $rs = mysqli_fetch_assoc($qry);
                        $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
                        //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
                        $maxId = ($maxId + 1); 

                        $maxId = substr("0000".$maxId, -4);
                        $nextId55 = $code.$maxId;
                       
                         //echo "dfdsgggsdgsdgdsgsdgsdgdsg".$sql2;
                
                    ?>
                      <input type="hidden" name="99" value="<?php echo $nextId55;?>" placeholder="idser" pattern="SE[0-9]{4}"required class="form-control">

                    <div class="mb-3 col-lg-2">
                        <label for="stock_in" class="form-label">ความดัน (mmhg)</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="number" name="35" placeholder="ความดัน" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-2">
                        <label for="stock_in" class="form-label">น้ำหนัก (kg.)</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="number" name="36" placeholder="น้ำหนัก" required class="form-control">
                    </div>
                    <div class="mb-3 col-lg-2">
                        <label for="stock_in" class="form-label">ส่วนสูง (cm.)</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="number" name="37" placeholder="ส่วนสูง" required class="form-control">
                    </div>
                    <div class="mb-3 col-lg-2">
                        <label for="stock_in" class="form-label">รอบเอว (cm.)</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="number" name="38" placeholder="รอบเอว" required class="form-control">
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label for="stock_in" class="form-label">อุณหภูมิ</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="number" name="39" placeholder="temp" required class="form-control">
                    </div>

                    
                    
                        <input type="hidden" name="40" value="<?php echo $_SESSION['id'];?>" placeholder="รหัสเจ้าหน้าที่" required class="form-control">
                    
                    
                        <input type="hidden" name="41" placeholder="รหัสข้อมูลผู้รักษา" required class="form-control">
                        </div>

                        <?php 
                
                                // $row = 1;
                                // $id = "";
                                // do{

                                    
                                //     $id = "HD";
                                //     for($i=0;$i<4;$i++){
                                //         $id .= rand(0,9);
                                //     }
                                //     $sql4 = "SELECT * FROM `history_drug` Where `hd_id`=$id";
                                //     $load4 = $con->query($sql4);
                                //     $row4 = mysqli_num_rows($load4);

                                // }while($row4 != 0);
                // $sql1 = mysqli_result(mysqli_query($con,"SELECT Max(substr(`di_id`,-3))+1 as MaxID from `diagnosis`"),0,"MaxID");
                                $code = "HD";
                                $sql = "SELECT MAX(hd_id) AS last_id FROM history_drug";
                                $qry = mysqli_query($con,$sql) or die(mysqli_error());
                                $rs = mysqli_fetch_assoc($qry);
                                $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
                                //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
                                $maxId = ($maxId + 1); 

                                $maxId = substr("0000".$maxId, -4);
                                $nextId = $code.$maxId;
                        ?>
                        <!-- <h5><center>-----ข้อมูลอื่นๆ-----</center></h5> -->
                        <div class="w-100 p-3" style="background-color: #eee;">ข้อมูลอื่นๆ</div>
                <div class="row my-4" >
                        <input type="hidden" name="42"  value="<?php echo $nextId ;?>" placeholder="id drug" required class="form-control">
                    
                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">ชื่อยาที่แพ้</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="43" placeholder="ชื่อยาที่แพ้" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label for="stock_in" class="form-label">โรคประจำตัวที่สำคัญ</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="45" placeholder="โรคประจำตัวที่สำคัญ" required class="form-control">
                    </div>
                    
                        <input type="hidden" name="44" placeholder="info_id" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-12">
                        <button class="btn btn-primary" style="float:right">บันทึกข้อมูล</button>
                    </div>
                    <br>
                </div>
            </form>
        </div>
        </div>

    </div>
</div>
<?php include 'assets/object/footer.php'?> 
<!-- script -->
<!-- jQuery CDN - Slim version (=without AJAX) -->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<!-- Popper.JS --><!-- Bootstrap JS -->
<!-- jQuery Custom Scroller CDN -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>

   <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>

<script>
    $(document).ready(function () {

        

        $('#sidebarCollapse').on('click', function () {
            // open or close navbar
            $('#sidebar').toggleClass('active');
            // close dropdowns
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });

    });
    $("input").on("change", function() {
    this.setAttribute(
        "data-date",
        moment(this.value, "YYYY-MM-DD")
        .format( this.getAttribute("data-date-format") )
    )
}).trigger("change")
</script>
</body>
</html>
