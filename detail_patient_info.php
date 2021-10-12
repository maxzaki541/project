<?php
session_start();
include 'assets/php/connect.php';
if (!isset($_SESSION['staff_id'])) header("location:index.php");
if (isset($_REQUEST['t'])) {
    $i = $_REQUEST['t'];
} else {
    header("location:index_patient_info.php");
}
if (isset($_REQUEST['s'])) {
    $s = $_REQUEST['s'];
} else {
    header("location:index_patient_info.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>ยินดีต้อนรับ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/console.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">



    <style>
        .collapsible {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
        }

        /* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
        .active,
        .collapsible:hover {
            background-color: #ccc;
        }

        /* Style the collapsible content. Note: hidden by default */
        .content {
            padding: 0 18px;
            display: none;
            overflow: hidden;
            background-color: #f1f1f1;
        }

        .collapsible:after {
            content: '\02795';
            /* Unicode character for "plus" sign (+) */
            font-size: 13px;
            color: white;
            float: right;
            margin-left: 5px;
        }

        .active:after {
            content: "\2796";
            /* Unicode character for "minus" sign (-) */
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <!-- การนำเข้า Navbar -->
        <div id="content">
            <?php include 'assets/object/navbar.php' ?>

            <div class="container my-5">
                <div class="col-md-10">
                    <h4>
                        ข้อมูลทะเบียน

                    </h4>
                </div>
                <?php

                //นำเข้าไฟล์ การเชื่อมต่อฐานข้อมูล
                // $y=date('Y')+543;
                // $date = date($y.'-m-d');

                $sql = "SELECT * FROM ((`patient_info` INNER JOIN `address_p` ON `address_p`.Info_id =`patient_info`.Info_id ) INNER JOIN `service` ON `patient_info`.Info_id = `service`.Info_id) INNER JOIN `history_drug` ON `patient_info`.Info_id=`history_drug`.Info_id 
                INNER JOIN `service2` ON `patient_info`.Info_id = `service2`.Info_id WHERE patient_info.Info_name='$i' and patient_info.Info_surename='$s' 
                group BY service2.sdate ";
                //print $sql;
                $result = mysqli_query($con, $sql);

                $n = 1;
                // เเสดงข้อมูลจากฐานข้อมูล

                while ($item = mysqli_fetch_assoc($result)) {  //print_r ($item); */  ;
                ?>

                    <button type="button" class="collapsible">บันทึกข้อมูลครั้งที่ <?php echo $n; ?><?php echo " " . $item["sdate"]; ?> </button>
                    <div class="content">

                        <!-- เเสดงข้อมูลจากฐานข้อมูล -->

                        <?php if ($n == 1) {
                        ?>
                            <div class="col-md-10">
                                <!-- <h3>
                        ข้อมูล <?php echo $item["Info_pre"] . "" . $item["Info_name"] . " " . $item["Info_surename"]; ?>
                        
                    </h3> -->
                            </div>
                        <?php } ?>
                        <!-- Card -->

                        <table style="width:100% " id="tblCustomers" class="table table-striped table-bordered table-hover table-responsive-sm">
                            <div class="card " style="width: 80rem;">

                                <!-- Card image -->
                                <?php if ($n == 1) { ?>
                                    <div class="view view-cascade overlay">
                                        <img class="img-thumbnail" src="images/person.png" alt="Card image cap" height="60" width="200">

                                    </div>

                                    <div class="card-header">
                                        ข้อมูลทั่วไป
                                    </div>
                                    <!-- Card content -->
                                    <div class="card-body card-body-cascade text-left">
                                        <h6 class="card-title">รหัส : <?php echo $item["Info_id"]; ?></h6>
                                        <!-- Title -->
                                        <h6 class="card-title">เลขประชาชน : <?php echo $item["se_idcard"]; ?></h6>

                                        <h6 class="card-title">คำนำหน้าชื่อ : <?php echo $item["Info_pre"]; ?></h6>
                                        <h6 class="card-title">ชื่อ : <?php echo $item["Info_name"] . " " . $item["Info_surename"]; ?></h4>
                                            <!-- Subtitle -->
                                            <!-- <h6 class="card-title">นามสกุล : <?php echo $item["Info_surename"]; ?></h6> -->
                                            <h6 class="card-title">วันเกิด(ปี-เดือน-วัน) : <?php echo $item["Info_birthday"];
                                                                                            //  $d = explode("-",$item['Info_birthday']);

                                                                                            // echo $d[2]."-".$d[1]."-".($d[0]+543);
                                                                                            ?></h6>
                                            <h6 class="card-title">อายุ : <?php echo $item["Info_age"]; ?>ปี</h6>
                                            <h6 class="card-title">ศาสนา : <?php echo $item["Info_religion"]; ?></h6>
                                            <h6 class="card-title">เชื้อชาติ : <?php echo $item["Info_race"]; ?></h6>
                                            <h6 class="card-title">สัญชาติ : <?php echo $item["Info_national"]; ?></h6>
                                            <h6 class="card-title">เบอร์โทรศัพท์ : <?php echo $item["Info_cardnum"]; ?></h6>
                                            <h6 class="card-title">อาชีพ : <?php echo $item["Info_career"]; ?></h6>
                                            <h6 class="card-title">ชื่อผู้แจ้ง : <?php echo $item["Info_infoname"]; ?></h6>

                                            <h6 class="card-title">ชื่อผู้ปกครอง : <?php echo $item["Info_nameadult"]; ?></h6>
                                            <h6 class="card-title">เกี่ยวข้องเป็น : <?php echo $item["Info_about"]; ?></h6>
                                            <h6 class="card-title">สถานะ : <?php echo $item["Info_status"]; ?></h6>
                                    </div>
                            </div>

                            <div class="card card-cascade wider reverse" style="width: 80rem;">
                                <div class="card-header">
                                    ข้อมูลที่อยู่
                                </div>
                                <div class="card-body card-body-cascade text-left">
                                    <h6 class="card-title">บ้านเลขที่ : <?php echo $item["ad_idhome"]; ?></h6>
                                    <h6 class="card-title">ซอย : <?php echo $item["ad_alley"]; ?></h6>
                                    <h6 class="card-title">ถนน : <?php echo $item["ad_road"]; ?></h6>
                                    <h6 class="card-title">หมู่ที่ : <?php echo $item["ad_moo"]; ?></h6>
                                    <h6 class="card-title">ตำบล : <?php echo $item["ad_tumbol"]; ?></h6>
                                    <h6 class="card-title">อำเภอ : <?php echo $item["ad_amper"]; ?></h6>
                                    <h6 class="card-title">จังหวัด : <?php echo $item["ad_province"]; ?></h6>
                                    <h6 class="card-title">ที่เกิด : <?php echo $item["ad_atbirth"]; ?></h6>
                                    <h6 class="card-title">ที่อยู่ที่ติดต่อได้ : <?php echo $item["ad_contact"]; ?></h6>
                                </div>
                            </div>

                        <?php  }
                        ?>

                        <div class="card card-cascade wider reverse" style="width:80rem;">
                            <div class="card-header">
                                ข้อมูลบริการ
                            </div>
                            <div class="card-body card-body-cascade text-left">

                                <?php if ($n == 1) {
                                ?>
                                    <h6 class="card-title">เลขบัตรสิทธิ : <?php echo $item["se_idlicense"]; ?></h6>
                                    <h6 class="card-title">เลขทั่วไป : <?php echo $item["se_idpublic"]; ?></h6>
                                    <h6 class="card-title">เลขที่ภายใน : <?php echo $item["se_idhn"]; ?></h6>
                                    <h6 class="card-title">เลขที่บัตรครอบครัว : <?php echo $item["se_idfamily"]; ?></h6>
                                    <h6 class="card-title">เลขที่เอ็กซเรย์ : <?php echo $item["se_idXray"]; ?></h6>
                                    <h6 class="card-title">สิทธิการรักษา : <?php echo $item["se_roft"]; ?></h6>
                                <?php }
                                ?>

                                <h6 class="card-title">ความดัน : <?php echo $item["se2_pressure"]; ?>(mmhg.) </h6>
                                <h6 class="card-title">น้ำหนัก : <?php echo $item["se2_weight"]; ?>(kg.)</h6>
                                <h6 class="card-title">ส่วนสูง : <?php echo $item["se2_height"]; ?>(cm.)</h6>
                                <h6 class="card-title">รอบเอว : <?php echo $item["se2_waist"]; ?> (cm.)</h6>
                                <h6 class="card-title">temp : <?php echo $item["se2_temp"]; ?></h6>

                                <?php if ($n == 1) {
                                ?>

                                    <h6 class="card-title">ชื่อยาที่แพ้ : <?php echo $item["hd_namedrug"]; ?></h6>
                                    <h6 class="card-title">โรคประจำตัวที่สำคัญ : <?php echo $item["hd_condis"]; ?></h6>

                                <?php }
                                ?>
                            </div>
                        </div>
                        <th><a class='btn btn-warning' onClick=update(<?php echo "'" . $item['Info_id'] . "'"; ?>,<?php echo "'" . $item['se2_id'] . "'"; ?>)>
                                <i class="fas fa-edit"> </i>แก้ไข</a>
                            <a class='btn btn-danger' onClick=remove(<?php echo "'" . $item['Info_id'] . "'"; ?>,<?php echo "'" . $item['sdate'] . "'"; ?>)>
                                <i class="fas fa-trash"> </i>ลบ</a>
                        </th>
                        <!-- Text -->



                    </div>

            </div>
        </div>
        <!-- Card -->
        </table>

    </div>

<?php


                    $n++;
                }
                //mysqli_free_result($item);
?>

</div>
</div>
</div>
</div>

<?php include 'assets/object/footer.php' ?>
<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        });
    }

    function update(params, params2) {
        alert(params2);
        window.location.href = "update_patient_info_input.php?t=" + params + "&s=" + params2
    }

    function remove(params, params2) {
        alert(params);
        var conf = confirm("ยืนยันการลบข้อมูลทะเบียนหรือไม่");
        if (conf == true) {
            $.post("detail_patient_info.php", {
                t: params,
                t2: params2
            }).done(function(data) {
                location.reload()
            })
        }

    }
</script>

<?php

if (isset($_REQUEST['t']) && isset($_REQUEST['t2'])) {

    $i = $_REQUEST['t'];
    $t = $_REQUEST['t2'];

    $de = "select * from defence";
    $q = $con->query($de);
    $a = [];
    while ($data = $q->fetch_assoc()) {

        array_push($a, $data['de_id']);
    }

    //echo print_r($a);
    $boolean = true;
    //$sql = "DELETE FROM  `patient_info`WHERE Info_id  = '$i'";
    $sql2 = "DELETE FROM `address_p` WHERE Info_id = '$i' and sdate ='$t'";
    $sql3 = "DELETE FROM `history_drug` WHERE Info_id = '$i' and sdate ='$t'";
    $sql4 = "DELETE FROM `service` WHERE Info_id = '$i' and sdate ='$t'";
    $sql9 = "DELETE FROM `service2` WHERE Info_id = '$i' and sdate ='$t'";
    //   dd($sql);
    //   echo $sql9;
    //   if($con->query($sql)){

    //   }else{
    //       $boolean = false;
    //   }
    if ($con->query($sql2)) {
    } else {
        $boolean = false;
    }
    if ($con->query($sql3)) {
    } else {
        $boolean = false;
    }
    if ($con->query($sql4)) {
    } else {
        $boolean = false;
    }
    if ($con->query($sql9)) {
    } else {
        $boolean = false;
    }
    foreach ($a as $value) {
        $sql5 = "DELETE  FROM `nexttime`WHERE de_id ='$a'";
        if ($con->query($sql5)) {
        } else {
            $boolean = false;
        }
    }

    $sql6 = "DELETE FROM `defence` WHERE Info_id = '$i'";
    $sql7 = "DELETE FROM `diagnosis` WHERE Info_id = '$i'";


    if ($con->query($sql6)) {
    } else {
        $boolean = false;
    }
    if ($con->query($sql7)) {
    } else {
        $boolean = false;
    }
    if ($boolean) {
        //   echo "<script>alert('Delete Successful')</script>";
    }
    /*if($con->query($sql)){
              echo "<script>alert('Delete Successful')</script>";
          }*/
}
?>

</body>


</html>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-alpha.6.min.js"></script>