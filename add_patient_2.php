<?php
session_start();
include 'assets/php/connect.php';

if (!isset($_SESSION['staff_id'])) header("location:index.php");
if (isset($_REQUEST['t'])) {
    $i = $_REQUEST['t'];
} else {
    header("location:index_patient_info.php");
}
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
        .birth input[type="date"] {
            position: relative;
            width: 250px;
            height: 37px;
            color: white;
            border: 1px solid #ccc;
            border-radius: 2.5px;
        }



        input:before {
            position: absolute;
            top: 2px;
            left: 5px;
            content: attr(data-date);
            display: inline-block;
            color: black;
        }

        /* input::-webkit-datetime-edit, input::-webkit-inner-spin-button, input::-webkit-clear-button {
    display: none;
} */

        input::-webkit-calendar-picker-indicator {
            position: absolute;
            top: 3px;
            right: 0;
            color: black;
            opacity: 1;
        }

        .my-select {
            visibility: hidden;
        }
    </style>
</head>

<body>


    <div class="wrapper">
        <!-- Sidebar -->
        <!-- <?php include 'assets/object/sidebar2.php' ?> -->
        <!-- Page Content -->
        <div id="content">
            <?php include 'assets/object/navBar.php' ?>
            <?php

            $sql = "SELECT * FROM ((`patient_info` INNER JOIN `address_p` ON `address_p`.Info_id =`patient_info`.Info_id ) INNER JOIN `service` ON `patient_info`.Info_id = `service`.Info_id) 
                INNER JOIN `history_drug` ON `patient_info`.Info_id=`history_drug`.Info_id
                where patient_info.`Info_id`='$i' ";
            $load = $con->query($sql);
            $data = $load->fetch_assoc();


            // $sql1 = mysqli_result(mysqli_query($con,"SELECT Max(substr(`di_id`,-3))+1 as MaxID from `diagnosis`"),0,"MaxID");

            ?>
            <script language="javascript">
                function calAge(o) {
                    var tmp = o.value.split("-");
                    var current = new Date();
                    var current_year = current.getFullYear() + 543;
                    document.getElementById("age").value = current_year - tmp[0];
                }
            </script>
            <div class="container my-4">
                <div class="row">
                    <div class="mb-3 col-lg-12">
                        <div class="header">
                            เพิ่มข้อมูลทะเบียนประวัติผู้เข้ารับบริการ <?php echo $data['Info_pre'] . "" . $data['Info_name'] . " " . $data['Info_surename']; ?>
                        </div>
                    </div>
                    <?php include 'assets/php/log.php' ?>
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
                $qry = mysqli_query($con, $sql);
                $rs = mysqli_fetch_assoc($qry);
                $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
                //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
                $maxId = ($maxId + 1);

                $maxId = substr("0000" . $maxId, -4);
                $nextId = $code . $maxId;

                ?>


                <form action="assets/php/up_service2.php" method="post" enctype="multipart/form-data">


                    <!-- <div class="w-100 p-3" style="background-color: #eee;">ข้อมูลทั่วไป</div>
                <div class="row my-4" > -->

                    <input type="hidden" name="1" value=<?php echo $nextId; ?> required class="form-control">

                    <!-- <div class="mb-3 col-lg-3"> -->
                    <!-- <label for="p_detail" class="form-label">เลขประจำตัวประชาชน</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="0" placeholder="เลขประจำตัวประชาชน" readonly="readonly" value=<?php echo $data['se_idcard']; ?> required class="form-control">
                    <!-- </div> -->
                    <!-- <div class="mb-3 col-lg-2"> -->
                    <!-- <div class="form-group"> -->
                    <!-- <label for="exampleFormControlSelect1" class="form-label">คำนำหน้า</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <select class="my-select" id="exampleFormControlSelect1" readonly="readonly" value=<?php echo $data['Info_pre']; ?> name="6">
                        <option value="----เลือกคำนำหน้า----">----เลือกคำนำหน้า----</option>
                        <option value="เด็กชาย" <?php
                                                if ($data["Info_pre"] == 'เด็กชาย') {
                                                    echo "selected";
                                                }
                                                ?>>เด็กชาย</option>
                        <option value="เด็กหญิง" <?php
                                                    if ($data["Info_pre"] == 'เด็กหญิง') {
                                                        echo "selected";
                                                    }
                                                    ?>>เด็กหญิง</option>
                        <option value="นาย" <?php
                                            if ($data["Info_pre"] == 'นาย') {
                                                echo "selected";
                                            }
                                            ?>>นาย</option>
                        <option value="นาง" <?php
                                            if ($data["Info_pre"] == 'นาง') {
                                                echo "selected";
                                            }
                                            ?>>นาง</option>
                        <option value="นางสาว" <?php
                                                if ($data["Info_pre"] == 'นางสาว') {
                                                    echo "selected";
                                                }
                                                ?>>นางสาว</option>

                    </select>
                    <!-- </div> -->
                    <!-- </div> -->
                    <!-- <div class="mb-3 col-lg-2"> -->
                    <!-- <label for="p_detail" class="form-label">ชื่อ</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="2" placeholder="example" readonly="readonly" value=<?php echo $data['Info_name']; ?> required class="form-control">
                    <!-- </div> -->
                    <!-- <div class="mb-3 col-lg-3"> -->
                    <!-- <label for="p_detail" class="form-label">นามสกุล</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="3" placeholder="example" readonly="readonly" value=<?php echo $data['Info_surename']; ?> required class="form-control">
                    <!-- </div> -->
                    <!-- <div class="mb-3 col-lg-3"> -->
                    <!-- <div class="birth"> -->
                    <!-- <label for="stock_in" class="form-label">วันเกิด</label><font size="4" color="#FF0000" align='right'>*</font><br> -->
                    <input type="hidden" name="9" data-date="" data-date-format="YYYY-MM-DD" value=<?php echo $data['Info_birthday']; ?> id="date" onchange="calAge(this);">
                    <!-- </div> -->
                    <!-- </div> -->
                    <!-- <div class="mb-3 col-lg-2"> -->
                    <!-- <label for="p_price" class="form-label">อายุ</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" min=1 max=99 name="4" value=<?php echo $data['Info_age']; ?> id="age" placeholder="30" readonly="readonly" required class="form-control">
                    <!-- </div> -->
                    <!-- <div class="mb-3 col-lg-3"> -->
                    <!-- <label for="stock_in" class="form-label">เบอร์โทรศัพท์</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="5" placeholder="0888888888" readonly="readonly" value=<?php echo $data['Info_cardnum']; ?> pattern="0[0-9]{9}" required class="form-control">
                    <!-- </div> -->





                    <!-- <div class="mb-3 col-lg-3"> -->
                    <!-- <div class="row my-2" > -->
                    <!-- <div class="form-group"> -->
                    <!-- <label for="exampleFormControlSelect1">เพศ</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <select class="my-select" id="exampleFormControlSelect1" readonly="readonly" value=<?php echo $data['Info_sex']; ?> name="7">
                        <option value="ชาย" <?php
                                            if ($data["Info_sex"] == 'ชาย') {
                                                echo "selected";
                                            }
                                            ?>>ชาย</option>
                        <option value="คริสต์" <?php
                                                if ($data["Info_sex"] == 'หญิง') {
                                                    echo "selected";
                                                }
                                                ?>>หญิง</option>
                    </select>
                    <!-- </div> -->
                    <!-- </div> -->
                    <!-- </div> -->


                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">อาชีพ</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="8" placeholder="รับจ้าง" readonly="readonly" value=<?php echo $data['Info_career']; ?> required class="form-control">
                    <!-- </div> -->





                    <!-- <div class="mb-3 col-lg-3"> -->
                    <!-- <div class="row my-2" > -->
                    <!-- <div class="form-group"> -->
                    <!-- <label for="exampleFormControlSelect1">ศาสนา</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <select class="my-select" id="exampleFormControlSelect1" readonly="readonly" value=<?php echo $data['Info_religion']; ?> name="10">
                        <option value="------เลือกศาสนา------">------เลือกศาสนา------</option>
                        <option value="พุทธ" <?php
                                                if ($data["Info_religion"] == 'พุทธ') {
                                                    echo "selected";
                                                }
                                                ?>>พุทธ</option>
                        <option value="คริสต์" <?php
                                                if ($data["Info_religion"] == 'คริสต์') {
                                                    echo "selected";
                                                }
                                                ?>>คริสต์</option>
                        <option value="อิสลาม" <?php
                                                if ($data["Info_religion"] == 'อิสลาม') {
                                                    echo "selected";
                                                }
                                                ?>>อิสลาม</option>
                        <option value="ฮินดู" <?php
                                                if ($data["Info_religion"] == 'ฮินดู') {
                                                    echo "selected";
                                                }
                                                ?>>ฮินดู</option>
                    </select>
                    <!-- </div> -->
                    <!-- </div> -->
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">เชื้อชาติ</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="11" placeholder="ไทย" readonly="readonly" value=<?php echo $data['Info_race']; ?> required class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">สัญชาติ</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="12" placeholder="ไทย" readonly="readonly" value=<?php echo $data['Info_national']; ?> required class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">ชื่อผู้เเจ้ง</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="13" placeholder="ตัวอย่าง" value=<?php echo $data['Info_infoname']; ?> required class="form-control">
                    <!-- </div> -->



                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">ชื่อผู้ปกครอง</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="15" placeholder="นายมะเขือ" value=<?php echo $data['Info_nameadult']; ?> required class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-3"> -->
                    <!-- <div class="form-group"> -->
                    <!-- <label for="exampleFormControlSelect1">เกี่ยวข้องเป็น</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <select class="my-select" id="exampleFormControlSelect1" value=<?php echo $data['Info_about']; ?> name="14">
                        <option value="บิดา">บิดา</option>
                        <option value="มารดา">มารดา</option>
                    </select>
                    <!-- </div> -->
                    <!-- </div> -->


                    <!-- <div class="mb-3 col-lg-3"> -->
                    <!-- <div class="form-group"> -->
                    <!-- <label for="exampleFormControlSelect1">สถานะ</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <select class="my-select" id="exampleFormControlSelect2" value=<?php echo $data['Info_status']; ?> name="16">
                        <option value="------เลือกสถานะ------">------เลือกสถานะ------</option>
                        <option value="โสด" <?php
                                            if ($data["Info_status"] == 'โสด') {
                                                echo "selected";
                                            }
                                            ?>>โสด</option>
                        <option value="สมรส" <?php
                                                if ($data["Info_status"] == 'สมรส') {
                                                    echo "selected";
                                                }
                                                ?>>สมรส</option>
                        <option value="หย่าร้าง" <?php
                                                    if ($data["Info_status"] == 'หย่าร้าง') {
                                                        echo "selected";
                                                    }
                                                    ?>>หย่าร้าง</option>
                        <option value="หม้าย" <?php
                                                if ($data["Info_status"] == 'หม้าย') {
                                                    echo "selected";
                                                }
                                                ?>>หม้าย</option>
                        <option value="สมณะ" <?php
                                                if ($data["Info_status"] == 'สมณะ') {
                                                    echo "selected";
                                                }
                                                ?>>สมณะ</option>
                    </select>
                    <!-- </div> -->
                    <!-- </div> -->
                    <!-- </div> -->
                    <?php
                    $sql2 = "SELECT * FROM `address_p` WHERE `Info_id`='$i' ";
                    $load2 = $con->query($sql2);
                    $data2 = $load2->fetch_assoc();


                    $code = "AD";
                    $sql = "SELECT MAX(ad_id) AS last_id FROM address_p";
                    $qry = mysqli_query($con, $sql);
                    $rs = mysqli_fetch_assoc($qry);
                    $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
                    //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
                    $maxId = ($maxId + 1);

                    $maxId = substr("0000" . $maxId, -4);
                    $nextId2 = $code . $maxId;



                    //echo "dfdsgggsdgsdgdsgsdgsdgdsg".$sql2;

                    ?>

                    <!-- <div class="w-100 p-3" style="background-color: #eee;">ข้อมูลที่อยู่</div>
                <div class="row my-4" > -->
                    <input type="hidden" name="17" value=<?php echo $nextId2; ?> placeholder="ตัวอย่าง" required class="form-control">


                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">เลขที่บ้าน</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="18" placeholder="เลขที่บ้าน" value=<?php echo $data['ad_idhome']; ?> required class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">ซอย</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="19" value=<?php echo $data['ad_alley']; ?> required class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">ถนน</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="20" value=<?php echo $data['ad_road']; ?> placeholder="ถนน" required class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-2"> -->
                    <!-- <label for="stock_in" class="form-label">หมู่ที่</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="21" value=<?php echo $data['ad_moo']; ?> placeholder="หมู่ที่" required class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">ตำบล</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="22" value=<?php echo $data['ad_tumbol']; ?> placeholder="ตำบล" required class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">อำเภอ</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="23" value=<?php echo $data['ad_amper']; ?> placeholder="อำเภอ" required class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">จังหวัด</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="24" value=<?php echo $data['ad_province']; ?> placeholder="จังหวัด" required class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">ที่เกิด</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="25" value=<?php echo $data['ad_atbirth']; ?> placeholder="ที่เกิด" required class="form-control">
                    <!-- </div> -->

                    <!-- <div class="form-group"> -->
                    <!-- <label for="stock_in"  >ที่อยู่สามารถติดต่อได้</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <textarea class="form-control" style="display:none;" rows="6" cols="40" name="26" placeholder="ที่อยู่สามารถติดต่อได้" require class="form-control"><?php echo ($data2['ad_contact']); ?></textarea>
                    <!-- </div> -->

                    <input type="hidden" name="27" value=<?php echo $data['Info_id']; ?> placeholder="รหัสข้อมูลผู้รักษา" class="form-control">
            </div>


            <?php
            // $sql3 = "SELECT * FROM `service` WHERE `Info_id`='$i' ";
            // $load3 = $con->query($sql3);
            // $data3 = $load3->fetch_assoc();

            $code = "SE";
            $sql = "SELECT MAX(se_id) AS last_id FROM service";
            $qry = mysqli_query($con, $sql);
            $rs = mysqli_fetch_assoc($qry);
            $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
            //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
            $maxId = ($maxId + 1);

            $maxId = substr("0000" . $maxId, -4);
            $nextId3 = $code . $maxId;

            //echo "dfdsgggsdgsdgdsgsdgsdgdsg".$sql2;

            ?>
            <div class="container my-4">
                <div class="w-100 p-3" style="background-color: #eee;">ข้อมูลบริการ</div>
                <div class="row my-4">
                    <input type="hidden" name="28" value="<?php echo $nextId3; ?>" placeholder="idser" pattern="SE[0-9]{4}" required class="form-control">


                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">เลขบัตรสิทธิ</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="29" placeholder="เลขบัตรสิทธิ" value=<?php echo $data['se_idlicense']; ?> require class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">เลขทั่วไป</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="30" placeholder="เลขทั่วไป" value=<?php echo $data['se_idpublic']; ?> require class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">เลขที่ภายใน</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="31" placeholder="เลขที่ภายใน" value=<?php echo $data['se_idhn']; ?> require class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">เลขที่บัตรครอบครัว</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="32" placeholder="เลขที่บัตรครอบครัว" value=<?php echo $data['se_idfamily']; ?> require class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">เลขที่เอ็กซเรย์</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="33" placeholder="เลขที่เอ็กซเรย์" value=<?php echo $data['se_idXray']; ?> require class="form-control">
                    <!-- </div> -->

                    <!-- <div class="mb-3 col-lg-4"> -->
                    <!-- <label for="stock_in" class="form-label">สิทธิการรักษา</label><font size="4" color="#FF0000" align='right'>*</font> -->
                    <input type="hidden" name="34" placeholder="สิทธิการรักษา" value=<?php echo $data['se_roft']; ?> require class="form-control">
                    <!-- </div> -->
                    <?php
                    // $sql3 = "SELECT * FROM `service` WHERE `Info_id`='$i' ";
                    // $load3 = $con->query($sql3);
                    // $data3 = $load3->fetch_assoc();

                    $code = "SE2";
                    $sql = "SELECT MAX(se2_id) AS last_id FROM service2";
                    $qry = mysqli_query($con, $sql);
                    $rs = mysqli_fetch_assoc($qry);
                    $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
                    //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
                    $maxId = ($maxId + 1);

                    $maxId = substr("0000" . $maxId, -4);
                    $nextId55 = $code . $maxId;

                    //echo "dfdsgggsdgsdgdsgsdgsdgdsg".$sql2;

                    ?>
                    <input type="hidden" name="99" value="<?php echo $nextId55; ?>" placeholder="idser" pattern="SE[0-9]{4}" required class="form-control">

                    <div class="mb-3 col-lg-2">
                        <label for="stock_in" class="form-label">ความดัน (mmhg)</label>
                        <font size="4" color="#FF0000" align='right'>*</font>
                        <input type="number" name="35" placeholder="ความดัน" class="form-control">
                    </div>

                    <div class="mb-3 col-lg-2">
                        <label for="stock_in" class="form-label">น้ำหนัก (kg.)</label>
                        <font size="4" color="#FF0000" align='right'>*</font>
                        <input type="number" name="36" placeholder="น้ำหนัก" require class="form-control">
                    </div>
                    <div class="mb-3 col-lg-2">
                        <label for="stock_in" class="form-label">ส่วนสูง (cm.)</label>
                        <font size="4" color="#FF0000" align='right'>*</font>
                        <input type="number" name="37" placeholder="ส่วนสูง" require class="form-control">
                    </div>
                    <div class="mb-3 col-lg-2">
                        <label for="stock_in" class="form-label">รอบเอว (cm.)</label>
                        <font size="4" color="#FF0000" align='right'>*</font>
                        <input type="number" name="38" placeholder="รอบเอว" require class="form-control">
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label for="stock_in" class="form-label">อุณหภูมิ</label>
                        <font size="4" color="#FF0000" align='right'>*</font>
                        <input type="number" name="39" placeholder="temp" require class="form-control">
                    </div>
                </div>
                <?php
                // $sql4 = "SELECT * FROM `history_drug` WHERE `Info_id`='$i' ";
                // $load4 = $con->query($sql4);
                // $data4 = $load4->fetch_assoc();

                $code = "HD";
                $sql = "SELECT MAX(hd_id) AS last_id FROM history_drug";
                $qry = mysqli_query($con, $sql);
                $rs = mysqli_fetch_assoc($qry);
                $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
                //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
                $maxId = ($maxId + 1);

                $maxId = substr("0000" . $maxId, -4);
                $nextId4 = $code . $maxId;

                //echo "dfdsgggsdgsdgdsgsdgsdgdsg".$sql2;

                ?>
                <!-- <div class="w-100 p-3" style="background-color: #eee;">ข้อมูลอื่นๆ</div>
                <div class="row my-4" > -->
                <input type="hidden" name="42" value=<?php echo $nextId4; ?> placeholder="id drug" required class="form-control">
                <!-- <div class="mb-3 col-lg-4"> -->
                <!-- <label for="stock_in" class="form-label">ชื่อยาที่แพ้</label><font size="4" color="#FF0000" align='right'>*</font> -->
                <input type="hidden" name="43" placeholder="ชื่อยาที่แพ้" value=<?php echo $data['hd_namedrug']; ?> require class="form-control">
                <!-- </div> -->
                <!-- <div class="mb-3 col-lg-4"> -->
                <!-- <label for="stock_in" class="form-label">โรคประจำตัวที่สำคัญ</label><font size="4" color="#FF0000" align='right'>*</font> -->
                <input type="hidden" name="45" placeholder="โรคประจำตัวที่สำคัญ" value=<?php echo $data['hd_condis']; ?> require class="form-control">
                <!-- </div> -->
                <!-- </div> -->
                <input type="hidden" name="40" value="<?php echo $_SESSION['id']; ?>" placeholder="รหัสเจ้าหน้าที่" required class="form-control">


                <input type="hidden" name="41" placeholder="รหัสข้อมูลผู้รักษา" required class="form-control">

                <input type="hidden" name="id" value=<?php echo $i; ?> required class="form-control">

                <div class="mb-3 col-lg-12">
                    <button class="btn btn-primary" style="float:right">บันทึกข้อมูล</button>
                </div>
                <br>
            </div>
            </form>
        </div>


    </div>
    </div>
    <?php include 'assets/object/footer.php' ?>
    <!-- script -->
    <!-- jQuery CDN - Slim version (=without AJAX) -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <!-- Bootstrap JS -->
    <!-- jQuery Custom Scroller CDN -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
    <script>
        $(document).ready(function() {



            $('#sidebarCollapse').on('click', function() {
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
                .format(this.getAttribute("data-date-format"))
            )
        }).trigger("change")
    </script>
</body>

</html>