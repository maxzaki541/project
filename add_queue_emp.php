<?php
session_start();
include 'assets/php/connect.php';

if (!isset($_SESSION['staff_id'])) header("location:index.php");
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
        input[type=date] {
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
    </style>
</head>

<body>


    <div class="wrapper">
        <!-- Sidebar -->
        <!-- <?php include 'assets/object/sidebar2.php' ?> -->
        <!-- Page Content -->
        <div id="content">
            <?php include 'assets/object/navbar.php' ?>

            <div class="container my-4">
                <div class="row">
                    <div class="mb-3 col-lg-12">
                        <div class="header">
                            เพิ่มข้อมูลการจองคิว
                        </div>
                    </div>
                    <?php include 'assets/php/log.php' ?>
                </div>
                <?php



                $code = "Q";
                $sql = "SELECT MAX(eguest_id) AS last_id FROM queue_emp";
                $qry = mysqli_query($con, $sql);
                $rs = mysqli_fetch_assoc($qry);
                $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
                //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
                $maxId = ($maxId + 1);

                $maxId = substr("0000" . $maxId, -4);
                $nextId = $code . $maxId;

                ?>
                <form action="assets/php/add_queue_emp.php" method="post" enctype="multipart/form-data">
                    <div class="row my-2" style="padding: 10px">

                        <input type="hidden" name="id" value="<?php echo $nextId; ?>" pattern="Q[0-9]{4}" required class="form-control">
                        <?php
                        $day = "";
                        if (isset($_GET['d'])) {
                            $result = $_GET['d'];
                            $day = $result;
                            //echo "<script> alert('yes".$result."')</script>";
                        } else
                            $y = date("Y") + 543;
                        $day = date($y . '-m-d');
                        ?>

                        <!-- <div class="mb-3 col-lg-3">
                        <label for="p_detail" class="form-label">วันที่จอง</label><font size="4" color="#FF0000" align='right'>*</font><br>
                        <input type="date"  value=<?php echo '"' . $day . '"'; ?> data-date="" data-date-format="YYYY-MM-DD"  id="datepicker" name="dates" >
                    </div> -->
                        <div class="mb-3 col-lg-3">
                            <label for="p_detail" class="form-label">วันที่จอง</label>
                            <font size="4" color="#FF0000" align='right'>*</font><br>
                            <input type="text" id="txtDate" value=<?php echo '"' . $day . '"'; ?> name="dates" required class="form-control">
                        </div>

                        <?php

                        // echo "<script> alert('$day')</script>";
                        $time = ["09:00-10:30", "10:30-12:00", "13:00-14:30", "14:30-16:00", "17:00-18:30", "18:30-20:00"];
                        $num = [0, 0, 0, 0, 0, 0];
                        $i = 0;
                        foreach ($time as $t) {
                            $sql1 = "SELECT * FROM `queue_emp` where eguest_date='$day' and eguest_time='$t'";
                            $q2 =  mysqli_query($con, $sql1);
                            $rowcount = mysqli_num_rows($q2);
                            $num[$i] += $rowcount;
                            $i++;
                        }
                        $i = 0;
                        foreach ($time as $t) {
                            $date = explode("-", $day);
                            $dd = $date[2] . "-" . $date[1] . "-" . $date[0];
                            $sql2 = "SELECT * FROM `queue` where queue_date='$dd' and queue_time='$t'";
                            $q3 =  mysqli_query($con, $sql2);
                            $rowcount = mysqli_num_rows($q3);
                            $num[$i] += $rowcount;
                            $i++;
                        }
                        // print_r ($num);


                        ?>
                        <div class="mb-3 col-lg-2">
                            <div class="row my-2">

                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">เวลาที่จอง</label>
                                    <font size="4" color="#FF0000" align='right'>*</font>
                                    <select class="form-control" id="exampleFormControlSelect2" name="times">

                                        <?php
                                        $i = 0;
                                        $txt = 0;
                                        foreach ($num as $nn) {
                                            $txt += $nn;
                                            if ($nn < 3) {
                                                echo "<option value=" . $time[$i] . ">$time[$i]</option>";
                                            }
                                            $i++;
                                        }
                                        //echo "<script>alert('$txt')</script>";
                                        if ($txt == 18) {
                                            echo "<option value='คิวเต็มแล้ว'>คิวเต็มแล้ว</option>";
                                        }

                                        ?>
                                        <!-- <option value="09:00-10:30">09:00-10:30</option>
                            <option value="10:30-12:00">10:30-12:00</option>
                            <option value="13:00-14:30">13:00-14:30</option>
                            <option value="14:30-16:00">14:30-16:00</option>
                            <option value="17:00-18:30">17:00-18:30</option>
                            <option value="18:30-20:00">18:30-20:00</option> -->

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 col-lg-3">
                            <label for="p_detail" class="form-label">ชื่อ</label>
                            <font size="4" color="#FF0000" align='right'>*</font>
                            <input type="text" name="fname" placeholder="ชื่อผู้จอง" required class="form-control">
                        </div>
                        <div class="mb-3 col-lg-3">
                            <label for="p_detail" class="form-label">นามสกุล</label>
                            <font size="4" color="#FF0000" align='right'>*</font>
                            <input type="text" name="lname" placeholder="นามสกุลผู้จอง" required class="form-control">
                        </div>


                        <div class="mb-3 col-lg-3">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">ประเภทการรักษา</label>
                                <font size="4" color="#FF0000" align='right'>*</font>
                                <select class="form-control" id="exampleFormControlSelect2" name="type">
                                    <!--<option value="T001">ประคบร้อน</option>
                            <option value="T002">นวดแผนไทย</option>-->
                                    <option value="---เลือก---">---เลือก---</option>
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

                        <!--<div class="mb-3 col-lg-3">
                        <label for="stock_in" class="form-label">รหัสพนักงานที่จองคิว</label>
                        <input type="text" name="emp" placeholder="1" value=<?php echo $_SESSION['staff_id']; ?> required class="form-control">
                    </div>-->
                        <!--<div class="mb-3 col-lg-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">พนักงานที่จองคิว</label>
                            <select class="form-control" id="exampleFormControlSelect2" value=<?php echo $data['emp_id']; ?> name="emp">
                           
                            <?php
                            // $sql = "SELECT * FROM `employees`";
                            // $load = $con->query($sql);
                            // while($data = $load->fetch_assoc()):

                            // 
                            ?>
                                // <option value="<?php echo $data['emp_id']; ?>"><?php echo $data['emp_name']; ?></option>

                                // <?php
                                    // endwhile;
                                    // 
                                    ?>   
                            </select>
                        </div>
                    </div>-->
                        <div class="mb-3 col-lg-3">
                            <!--label for="stock_in" class="form-label">รหัสพนักงานที่จองคิว</label-->
                            <input type="hidden" name="emp" value="<?php echo $_SESSION['id']; ?>" placeholder="Q001" pattern="E[0-9]{4}" required class="form-control">
                        </div>

                        <div class="mb-3 col-lg-12">
                            <button class="btn btn-primary" style="float:right">บันทึกข้อมูล</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="container my-45">
                <div class="row ">


                    <div class="result">
                        <div id="demo">
                            <table id="example" class="table table-striped table-bordered table-hover table-responsive-sm" style="width:100%">
                                <thead>
                                    <th>รหัสการจองคิว</th>
                                    <th>ชื่อ</th>
                                    <th>นามสกุล</th>
                                    <th>วันที่จอง</th>
                                    <th>เวลาที่จอง</th>
                                    <th>ประเภทการรักษา</th>
                                    <th>ชื่อพนักงานที่จองคิว</th>

                                </thead>

                                <tbody>
                                    <!-- <div class="float-right">
                        <a class='btn btn-success' class="float-right" href=add_queue_emp.php>เพิ่ม</a>
                    </div> -->
                                    <br>
                                    <div>
                                        <div class="container">
                                            <div class="row hidden-md-up">


                                                <?php


                                                $sql = "SELECT queue_emp.eguest_id,queue_emp.namepub,queue_emp.lastnamepub,queue_emp.eguest_date,queue_emp.eguest_time,type_service.type_name,employees.emp_name,employees.emp_surname
                               FROM ((`queue_emp`
                              INNER JOIN type_service ON queue_emp.type_id = type_service.type_id)
                              INNER JOIN employees ON queue_emp.emp_id = employees.emp_id) ";


                                                $load = $con->query($sql);
                                                while ($data = $load->fetch_assoc()) :
                                                ?>
                                                    <tr>
                                                        <td><?php echo $data['eguest_id']; ?></td>
                                                        <td><?php echo $data['namepub']; ?></td>
                                                        <td><?php echo $data['lastnamepub']; ?></td>
                                                        <td><?php echo $data['eguest_date'];

                                                            //   $d = explode("-",$data['eguest_date']);

                                                            //   echo $d[2]."-".$d[1]."-".($d[0]+543);
                                                            ?></td>
                                                        <td><?php echo $data['eguest_time']; ?></td>
                                                        <td><?php echo $data['type_name']; ?></td>
                                                        <td><?php echo $data['emp_name'] . " " . $data['emp_surname']; ?></td>


                                                    </tr>
                                                <?php
                                                endwhile;
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>

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


            $("#datepicker").on("change", function() {


                var selected = $(this).val();
                //alert(selected);
                window.location.href = "add_queue_emp.php?d=" + selected;
                // var data = {
                //     d: selected

                // };

                // $.post("add_queue_emp.php", data);
            });

            function getISODate() {
                var d = new Date();

                return d.getFullYear() + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + ('0' + d.getDate()).slice(-2);
            }
            window.onload = function() {
                document.getElementById('datepicker').setAttribute('min', getISODate());

            }




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