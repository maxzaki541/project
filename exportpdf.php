<?php
session_start();
include 'assets/php/connect.php';
if (!isset($_SESSION['staff_id'])) header("location:index.php");
if (isset($_REQUEST['t'])) {
    $i = $_REQUEST['t'];
} else {
    //header("location:index_history_medical.php");
}

if (isset($_REQUEST['s'])) {
    $s = $_REQUEST['s'];
} else {
    //header("location:index_history_medical.php");
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
    <title>รายงานการรักษา</title>
</head>

<body>





    <div class="wrapper">

        <!-- <?php include 'assets/object/sidebar2.php' ?> -->

        <div id="content">
            <?php include 'assets/object/navBar.php' ?>


            <div class="container my-4">
                <div class="row">
                    <div class="col-md-10">
                        <h4>
                            ข้อมูลการรักษา

                        </h4>
                    </div>
                    <?php

                    //นำเข้าไฟล์ การเชื่อมต่อฐานข้อมูล


                    $sql = "SELECT * FROM ((((( `diagnosis` INNER JOIN `defence` ON diagnosis.de_id = defence.de_id) 
                    INNER JOIN type_service ON type_service.type_id = defence.type_id) 
                    INNER JOIN medic ON diagnosis.medic_id = medic.medic_id) 
                    INNER JOIN patient_info ON patient_info.Info_id = defence.Info_id) 
                    INNER JOIN service2 ON diagnosis.di_date = service2.sdate) 
                    INNER JOIN nexttime ON nexttime.de_id = defence.de_id
                    
                    WHERE defence.de_id = '$i' and service2.Info_id ='$s'";
                    $result = $con->query($sql);




                    // เเสดงข้อมูลจากฐานข้อมูล

                    while ($item = mysqli_fetch_assoc($result)) {
                    ?>
                        <table style="width:100% " id="tblCustomers" class="table table-striped table-bordered table-hover table-responsive-sm">
                            <!-- Card -->
                            <div class="card card-cascade wider reverse" style="width:50%">

                                <!-- Card image -->
                                <div class="view view-cascade overlay">
                                    <!-- <img class="img-thumbnail" src="images/logo1.png" alt="Card image cap" height="100" width="250">
                
                                

                                 Card content -->


                                    <tr align="center">
                                        <th colspan="2">
                                            <h3>รายงานการรักษา </h3>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <h6>รหัส :
                                        </th>
                                        <td><?php echo $item["de_id"]; ?></h6>
                                        </td>
                                    </tr>
                                    <!-- Title -->
                                    <tr>
                                        <th>
                                            <h6>มาเมื่อวันที่-เวลา :
                                        </th>
                                        <td><?php echo $item["di_date"] . " เวลา : " . $item["di_time"]; ?></h6>
                                            </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <h6>ชื่อ :
                                        </th>
                                        <td><?php echo $item["Info_name"]; ?></h6>
                                        </td>
                                    </tr>
                                    <!-- Subtitle -->
                                    <tr>
                                        <th>
                                            <h6>นามสกุล :
                                        </th>
                                        <td><?php echo $item["Info_surename"]; ?></h6>
                                            </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <h6>ประเภทการรักษา :
                                        </th>
                                        <td><?php echo $item["type_name"]; ?></h6>
                                            </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <h6>การรักษาอื่นๆ :
                                        </th>
                                        <td><?php echo $item["other_de"]; ?></h6>
                                            </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <h6>วินิจฉัยอาการ :
                                        </th>
                                        <td><?php echo $item["di_NameSymptom"]; ?></h6>
                                            </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <h6>แพทย์ที่รักษา:
                                        </th>
                                        <td><?php echo $item["medic_name"] . " " . $item["medic_surname"]; ?></h6>
                                            </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <h6>วัน-เวลานัดถัดไป:
                                        </th>
                                        <td><?php echo $item["nt_date"] . " เวลา : " . $item["nt_time"]; ?></h6>
                                            </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <h6>ข้อมูลบริการ
                                        </th>
                                        <td><?php echo "สูง : " . $item["se2_height"] . "cm." . " น้ำหนัก : " . $item["se2_weight"] . "kg." . "ความดัน : " . $item["se2_pressure"] . "mmhg." . " รอบเอว : " . $item["se2_waist"] . "cm." . " อุณหภูมิ : " . $item["se2_temp"]; ?></h6>
                                        </td>
                                    </tr>
                                </div>
                            </div>

                        </table>

                </div>



            </div>
        <?php

                    }
        ?>
        </div>
    </div>



</body>

</html>
<script>
    window.print();
</script>





<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-alpha.6.min.js"></script>