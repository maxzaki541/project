<?php
session_start();
include 'assets/php/connect.php';

if (!isset($_SESSION['staff_id'])) header("location:index.php");
if (isset($_REQUEST['t'])) {
    $i = $_REQUEST['t'];
} else {
    header("location:index_history_medical.php");
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
</head>
<style>
    input[type="time"] {
        position: relative;
        width: 200px;
        height: 37px;
        color: black;
        border: 1px solid #ccc;
        border-radius: 2.5px;
    }
</style>
<style>
    input[type="date"] {
        position: relative;
        width: 200px;
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

    .end div {
        background-color: white;
        display: inline-flex;
        border: 1px solid #ccc;
        color: #555;
        width: 460px;
    }

    input[type="number"] {
        border: none;
        color: #555;
        text-align: center;
        width: 160px;
    }
</style>

<body>


    <div class="wrapper">
        <!-- Sidebar -->
        <!-- <?php include 'assets/object/sidebar2.php' ?> -->
        <!-- Page Content -->
        <div id="content">
            <?php include 'assets/object/navbar.php' ?>
            <?php

            $sql = "SELECT * FROM (((( `diagnosis` INNER JOIN `defence` ON diagnosis.de_id = defence.de_id) 
            JOIN type_service ON type_service.type_id = defence.type_id) 
            INNER JOIN medic ON diagnosis.medic_id = medic.medic_id) 
            JOIN patient_info ON patient_info.Info_id = defence.Info_id)
            JOIN nexttime ON nexttime.de_id = defence.de_id
                where defence.`de_id`='$i' ";
            $load = $con->query($sql);
            $data = $load->fetch_assoc();


            // $sql1 = mysqli_result(mysqli_query($con,"SELECT Max(substr(`di_id`,-3))+1 as MaxID from `diagnosis`"),0,"MaxID");

            ?>
            <div class="container my-4">
                <div class="row">
                    <div class="mb-3 col-lg-12">
                        <div class="header">
                            เพิ่มข้อมูลการรักษาใหม่ของ <?php echo "คุณ" . $data['Info_name'] . " " . $data['Info_surename']; ?>
                        </div>
                    </div>
                    <?php include 'assets/php/log.php' ?>
                </div>
                <?php


                // $row = 1;
                // $id = "";
                // do{


                //     $id = "DE";
                //     for($i=0;$i<4;$i++){
                //         $id .= rand(0,9);
                //     }
                //     $sql1 = "SELECT * FROM `defence` Where `de_id`=$id";
                //     $load1 = $con->query($sql1);
                //     $row = mysqli_num_rows($load1);

                // }while($row != 0);
                //$sql1 = mysqli_result(mysqli_query($con,"SELECT MAX(substr(`di_id`,-3))+1 as MaxID from `diagnosis`"),0,"MaxID");
                $code = "DE";
                $sql = "SELECT MAX(de_id) AS last_id FROM defence";
                $qry = mysqli_query($con, $sql);
                $rs = mysqli_fetch_assoc($qry);
                $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
                //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
                $maxId = ($maxId + 1);

                $maxId = substr("0000" . $maxId, -4);
                $nextId = $code . $maxId;

                ?>

                <form action="assets/php/add_hiss.php" method="post" enctype="multipart/form-data">
                    <div class="row my-5" style="padding: 10px">

                        <!-- <div class="mb-3 col-lg-3">
                        <label for="p_detail" class="form-label">รหัสการรักษา</label>  -->
                        <input type="hidden" name="id" value=<?php echo $nextId; ?> required class="form-control">
                        <!-- </div> -->


                        <!--<div class="mb-3 col-lg-6">
                        <label for="p_detail" class="form-label">รหัสประเภทการรักษา</label>
                        <input type="text" name="type" placeholder="T001" pattern="T[0-9]{3}" required class="form-control">
                    </div>-->
                        <!-- <div class="mb-3 col-lg-4">
                        <label for="p_detail" class="form-label">ผู้เข้ารับการรักษา</label>
                        <input type="text" name="patient" placeholder="ชื่อ"  required class="form-control">
                    </div> -->

                        <input type="hidden" name="patient" placeholder="US01" pattern="US[0-9]{2}" value=<?php echo $data['Info_id']; ?> required class="form-control">

                        <!-- <div class="mb-3 col-lg-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">ผู้เข้ารับการรักษา</label>
                            <select class="form-control" id="exampleFormControlSelect2" name="patient">
                            <option disabled="disabled" selected="selected">---เลือก---</option> 
                            <?php
                            $sql = "SELECT * FROM `patient_info`";
                            $load = $con->query($sql);
                            while ($data = $load->fetch_assoc()) :

                            ?>
                                <option value="<?php echo $data['Info_id']; ?>"><?php echo $data['Info_pre'] . " " . $data['Info_name'] . " " . $data['Info_surename']; ?></option>

                                <?php
                            endwhile;
                                ?>   
                            </select>
                        </div>
                    </div>  -->


                        <div class="mb-3 col-lg-3">
                            <div class="row my-2">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">ประเภทการรักษา</label>
                                    <font size="4" color="#FF0000" align='right'>*</font>
                                    <select class="form-control" id="exampleFormControlSelect2" name="type">
                                        <option disabled="disabled" selected="selected">---เลือก---</option>
                                        <?php
                                        $sql = "SELECT * FROM `type_service`";
                                        $load = $con->query($sql);
                                        while ($data = $load->fetch_assoc()) :

                                        ?>
                                            <option value="<?php echo $data['type_id']; ?>"><?php echo $data['type_name']; ?></option>

                                        <?php
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 col-lg-4">
                            <label for="p_detail" class="form-label">การรักษาอื่นๆ</label>
                            <font size="4" color="#FF0000" align='right'>*</font>
                            <input type="text" name="other_de" placeholder="การรักษาอื่นๆ" required class="form-control">
                        </div>

                        <?php

                        // $row = 1;
                        // $id = "";
                        // do{


                        //     $id = "DI";
                        //     for($i=0;$i<4;$i++){
                        //         $id .= rand(0,9);
                        //     }
                        //     $sql2 = "SELECT * FROM `diagnosis` Where `di_id`=$id";
                        //     $load2 = $con->query($sql2);
                        //     $ro2 = mysqli_num_rows($load2);

                        // }while($row2 != 0);
                        //$sql1 = mysqli_result(mysqli_query($con,"SELECT MAX(substr(`di_id`,-3))+1 as MaxID from `diagnosis`"),0,"MaxID");

                        $code = "DI";
                        $sql = "SELECT MAX(di_id) AS last_id FROM diagnosis";
                        $qry = mysqli_query($con, $sql);
                        $rs = mysqli_fetch_assoc($qry);
                        $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
                        //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
                        $maxId = ($maxId + 1);

                        $maxId = substr("0000" . $maxId, -4);
                        $nextId = $code . $maxId;


                        ?>

                        <input type="hidden" name="diagid" value="<?php echo $nextId; ?>" pattern="DI[0-9]{4}" required class="form-control">
                        <?php
                        $y = date("Y") + 543;
                        $day = date($y . '-m-d');
                        ?>
                        <div class="mb-3 col-lg-3">
                            <label for="stock_in" class="form-label">วันที่รักษา</label>
                            <font size="4" color="#FF0000" align='right'>*</font>
                            <input type="text" value="<?php echo $day ?>" name="nowdate" placeholder="22/12/2020" required class="form-control">
                        </div>
                        <div class="mb-3 col-lg-3">
                            <label for="p_detail" class="form-label">เวลาที่รักษา</label>
                            <font size="4" color="#FF0000" align='right'>*</font>
                            <input type="text" value="<?php date_default_timezone_set("Asia/Bangkok");
                                                        echo date("H:i"); ?>" name="nowtime" placeholder="example" required class="form-control">
                        </div>
                        <div class="mb-3 col-lg-5">
                            <label for="p_detail" class="form-label">วินิจฉัยอาการ</label>
                            <font size="4" color="#FF0000" align='right'>*</font>
                            <input type="text" name="name" placeholder="วินิจฉัยอาการ" class="form-control">
                        </div>
                        <div class="mb-3 col-lg-3">
                            <div class="row my-2">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">แพทย์ที่ทำการรักษา</label>
                                    <font size="4" color="#FF0000" align='right'>*</font>
                                    <select class="form-control" id="exampleFormControlSelect2" name="namemed">
                                        <option disabled="disabled" selected="selected">---เลือก---</option>
                                        <?php
                                        $sql = "SELECT * FROM `medic`";
                                        $load = $con->query($sql);
                                        while ($data = $load->fetch_assoc()) :

                                        ?>
                                            <option value="<?php echo $data['medic_id']; ?>"><?php echo $data['medic_pre'] . " " . $data['medic_name'] . " " . $data['medic_surname']; ?></option>

                                        <?php
                                        endwhile;
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php

                        // $row = 1;
                        // $id = "";
                        // do{


                        //     $id = "NT";
                        //     for($i=0;$i<4;$i++){
                        //         $id .= rand(0,9);
                        //     }
                        //     $sql3 = "SELECT * FROM `nexttime` Where `nt_id`=$id";
                        //     $load3 = $con->query($sql3);
                        //     $row3 = mysqli_num_rows($load3);

                        // }while($row3 != 0);
                        //$sql1 = mysqli_result(mysqli_query($con,"SELECT MAX(substr(`di_id`,-3))+1 as MaxID from `diagnosis`"),0,"MaxID");  
                        $code = "NT";
                        $sql = "SELECT MAX(nt_id) AS last_id FROM nexttime";
                        $qry = mysqli_query($con, $sql);
                        $rs = mysqli_fetch_assoc($qry);
                        $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
                        //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
                        $maxId = ($maxId + 1);

                        $maxId = substr("0000" . $maxId, -4);
                        $nextId = $code . $maxId;
                        ?>
                        <input type="hidden" name="ntid" value="<?php echo $nextId; ?>" pattern="NT[0-9]{4}" required class="form-control">

                        <!-- <div class="mb-3 col-lg-3">
                        <label for="stock_in" class="form-label">วันที่นัดถัดไป</label><font size="4" color="#FF0000" align='right'>*</font><br>
                        <input type="text" id="txtDate" name="nextdate" data-date="" data-date-format="YYYY-MM-DD" value=<?php echo '"' . $day . '"'; ?>>
                    </div>  -->
                        <div class="mb-3 col-lg-3">
                            <label for="stock_in" class="form-label">วันที่นัดถัดไป</label>
                            <font size="4" color="#FF0000" align='right'>*</font><br>
                            <input type="text" id="txtDate" name="nextdate" placeholder="เลือกวัน" value=<?php echo '"' . $day . '"'; ?> required class="form-control">
                        </div>
                        <?php
                        //  date_default_timezone_set("Asia/Bangkok"); 
                        // $timea = date("H:i");
                        ?>
                        <!-- <div class="end"> -->
                        <!-- <div class="mb-3 col-lg-3"> -->
                        <!-- <div class="input-append" id="datetimepicker3">
                        <label for="input_starttime"  class="form-label">เวลาที่นัดถัดไป</label>
                        <input  type="text"  name="nexttime" placeholder="time" class="form-control">
                              
                    </div>
                    </div> -->
                        <div class="mb-3 col-lg-3">
                            <div class="input-append" id="datetimepicker3">
                                <label for="input_starttime" class="form-label">เวลาที่นัดถัดไป</label>
                                <select class="form-control" id="exampleFormControlSelect2" name="nexttime">
                                    <option value="-">-</option>
                                    <option value="09:00">09:00</option>
                                    <option value="10:30">10:30</option>
                                    <option value="13:00">13:00</option>
                                    <option value="14:30">14:30</option>
                                    <option value="17:00">17:00</option>
                                    <option value="18:30">18:30</option>

                                </select>
                            </div>
                        </div>


                        <input type="hidden" name="44" placeholder="de_id" required class="form-control">




                        <div class="mb-3 col-lg-11">
                            <button class="btn btn-primary" style="float:right">บันทึกข้อมูล</button>
                        </div>

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

    <!-- <script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/> -->

    <!-- <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css"> -->
    <!-- <script src="plugins/timepicker/bootstrap-timepicker.min.js"></script> -->


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js" type="text/javascript"></script>


    <script>
        $(document).ready(function() {
            $(function() {
                var year = (new Date).getFullYear() + 543;
                $('#txtDate').datepicker({

                    format: year + "-mm-dd"
                });
            });


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

        // var timepicker = new TimePicker('time', {
        //   lang: 'en',
        //   theme: 'dark'
        // });
        // timepicker.on('change', function(evt) {

        //   var value = (evt.hour || '00') + ':' + (evt.minute || '00');
        //   evt.element.value = value;

        // });
        $(function() {
            $('#datetimepicker3').datetimepicker({
                format: 'HH:mm'

            });
        });


        // $(".timepicker1").timepicker({
        //     showInputs: false
        // });

        // $('#input_starttime').pickatime({
        // // 12 or 24 hour
        // twelvehour: true,
        // });
        // document.querySelectorAll('input[type=number]')
        //   .forEach(e => e.oninput = () => {
        //     // Always 2 digits
        //     if (e.value.length >= 2) e.value = e.value.slice(0, 2);
        //     // 0 on the left (doesn't work on FF)
        //     if (e.value.length === 1) e.value = '0' + e.value;
        //     // Avoiding letters on FF
        //     if (!e.value) e.value = '00';
        //   });
    </script>
</body>

</html>