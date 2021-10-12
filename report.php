<?php
session_start();
include 'assets/php/connect.php';
if (!isset($_SESSION['staff_id'])) header("location:index.php");
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=windows-874">
    <link rel="stylesheet" href="assets/css/console.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <title>ยินดีต้อนรับ</title>
</head>

<body>





    <div class="wrapper">
        <!-- Sidebar -->
        <!-- <?php include 'assets/object/sidebar2.php' ?> -->
        <!-- Page Content -->

        <div id="content">
            <?php include 'assets/object/navbar.php' ?>


            <tr>
                <td>
                    <div align="center">
                        <h3>รายงานการรักษาแต่ละประเภทประจำเดือน </h3>
                        <?php
                        date_default_timezone_set('Asia/Bangkok');
                        $thai_n = array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
                        $w = $thai_w[date("w")];
                        $d = date("d");
                        $n = $thai_n[date("n") - 1];
                        $y = date("Y") + 543;
                        //$yy=date("Y");
                        $t = date("เวลา G: i : s");
                        // echo "เดือน $n ปี  $y"; 
                        ?>

                    </div>
                </td>
            </tr>


            </table>
            <form method="post" action="report.php">
                <div align="center">
                    <table width="627" border="0">

                        <tr>
                            <td width="621">
                                <div align="center">เลือกเดือน/ปี :


                                    <?php

                                    echo "<select name='month'>";
                                    echo "<option disabled='disabled' selected='selected' >------เลือกเดือน----";
                                    echo "<option value='01'>มกราคม";
                                    echo "<option value='02'>กุมภาพันธ์";
                                    echo "<option value='03'>มีนาคม";
                                    echo "<option value='04'>เมษายน";
                                    echo "<option value='05'>พฤษภาคม";
                                    echo "<option value='06'>มิถุนายน";
                                    echo "<option value='07'>กรกฎาคม";
                                    echo "<option value='08'>สิงหาคม";
                                    echo "<option value='09'>กันยายน";
                                    echo "<option value='10'>ตุลาคม";
                                    echo "<option value='11'>พฤศจิกายน";
                                    echo "<option value='12'>ธันวาคม";
                                    echo "</select>";
                                    ?>

                                    <!-- <select name="txt_year">
                                <option value="">--------------</option> -->
                                    <?php

                                    // $txtYear = (isset($_POST['txt_year']) && $_POST['txt_year'] != '') ? $_POST['txt_year'] : date('Y');
                                    // $yearStart = date('Y');
                                    // $year = date('Y')+543;
                                    // $yearEnd = $txtYear-5;
                                    // for($year=$yearStart;$year > $yearEnd;$year--){
                                    // $selected = '';
                                    // if($txtYear == $year) $selected = 'selected="selected"';
                                    // echo '<option value="'.($year).'" '.$selected.'>'. ($year+543) .'</option>'."\n";
                                    // }
                                    echo '<select name="year_q">';
                                    $var_y = date("Y") + 543;
                                    $ys = $var_y - 1;

                                    for ($i = $ys; $i <= $var_y; $i++) {
                                        if ($i == date("Y") + 543) {
                                            $selected = "selected";
                                        } else {
                                            $selected = "";
                                        }
                                        echo "<option value='{$i}' $selected>{$i}</option>";
                                    }
                                    echo "<input type='submit' name ='submit'  value='ค้นหา'>";
                                    echo '</select>';
                                    ?>
                                    <!-- <?php echo "<input type='submit' name ='submit'  value='ค้นหา'>"; ?> -->
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </form>

            <?php
            if (isset($_POST['submit'])) {

                $month =  $_POST['month'];
                $year =  $_POST['year_q'];

                // $month = date("n");

                // echo "เดือน".$month;
                //echo "ปี".$year;

                $sql3 = "SELECT * FROM `type_service`";
                $type = [];
                $load3 = $con->query($sql3);
                while ($data3 = $load3->fetch_assoc()) :
                    array_push($data3, 0);
                    $type[] = $data3;

                endwhile;
                // echo print_r($type);
                $sql = "SELECT * FROM `queue` WHERE queue.queue_date LIKE '$year-$month-__'";
                $load = $con->query($sql);
                while ($data = $load->fetch_assoc()) :

                    foreach ($type as $key => $value) {

                        if ($data['type_id'] == $value['type_id']) {
                            $type[$key]['0']++;
                        }
                    }

                endwhile;

                $sql1 = "SELECT * FROM `queue_emp` WHERE queue_emp.eguest_date LIKE '$year-$month-__'";
                $load = $con->query($sql1);
                while ($data4 = $load->fetch_assoc()) :

                    foreach ($type as $key => $value) {

                        if ($data4['type_id'] == $value['type_id']) {
                            $type[$key]['0']++;
                        }
                    }
                endwhile;


                $yy = ($year + 543);
                switch ($month) {
                    case '01':
                        $mm = "มกราคม";
                        break;
                    case '02':
                        $mm = "กุมภาพันธ์";
                        break;
                    case '03':
                        $mm = "มีนาคม";
                        break;
                    case '04':
                        $mm = "เมษายน";
                        break;
                    case '05':
                        $mm = "พฤษภาคม";
                        break;
                    case '06':
                        $mm = "มิถุนายน";
                        break;
                    case '07':
                        $mm = "กรกฎาคม";
                        break;
                    case '08':
                        $mm = "สิงหาคม";
                        break;
                    case '09':
                        $mm = "กันยายน";
                        break;
                    case '10':
                        $mm = "ตุลาคม";
                        break;
                    case '11':
                        $mm = "พฤศจิกายน";
                        break;
                    case '12':
                        $mm = "ธันวาคม";
                        break;
                }


                //$date= date("Y-m-d");
                // $d=mktime(11, 14, 54, 8, 12, 2014);
                $y = date("Y");
                $date = date($y . "-m-d h:s:i");

                // echo print_r($type);
                echo "<div class='col-md-10 text-right'><a href='#' class='btn btn-primary' id='download_link' onClick='ExcelReport();''>Export to Excel 
                    <i class='fas fa-file-excel' style='font-size:20px;color:white' ></i></a>";

                echo "</div>";
                // echo "<br>";
                echo "<table  id='myTable' align='center' style='width:68%' class='table table-striped table-bordered table-hover table-responsive-sm'> ";

                echo "<th align='center' colspan='1' class='table-success'>เดือน: $mm ปี: $year  ";
                echo "<th align='left' class='table-success'><font size='1' > $date";
                echo "<tr align='center'><th   class='table-success'>ประเภท";
                echo "<th align='center'  class='table-success'>จำนวน</th></th>";
                // echo "<td align='center' >";
                foreach ($type as $key => $value) {
                    echo "
                        <tr align='left' >
                        <td><font size='3'>" . " " . $value['type_name'] . "</td>";
                    echo "<td height='10' align='left'><font size='3' >" . "จำนวน : "  . $value['0'] . " ครั้ง" . " <br> ";
                    echo   " </td>  ";
                    echo "</tr>";

                    // echo $key." ".$value['type_name']." ".$value['type_id'] ." จำนวน".$value['0']."<br>";
                }

                echo "</tr>";
                //   echo "</td>";

                echo "</th>";
                echo "</table>";
            }

            ?>



            <?php
            $medic = [];
            //$sqldi = "SELECT medic_id from `diagnosis`";
            $sqldi = "SELECT * from `diagnosis` inner join medic on `diagnosis`.medic_id = medic.medic_id";
            $name2 = [];
            $pre = [];

            $result = $con->query($sqldi);
            while ($data10 = $result->fetch_assoc()) :
                array_push($medic, $data10['medic_id']);
                array_push($name2, $data10['medic_pre'] . " " . $data10['medic_name'] . " " . $data10['medic_surname']);
            endwhile;
            $name2 = array_unique($name2);
            // print_r ($name2);


            $m = $medic;

            $medic = array_unique($medic);
            //$name = array_unique($name);
            $mm = [];
            $medic2 = [];
            foreach ($medic as $key0 => $value0) {
                array_push($medic2, $value0);
            }
            $medic = $medic2;
            foreach ($medic as $key1 => $value1) {
                $temp = 0;

                //print $key1.' = '.$value1.'<br>';
                foreach ($m as $key2 => $value2) {
                    if ($value1 == $value2) {
                        $temp++;
                    }
                }
                array_push($mm, $temp);
            }
            // print_r ($mm);
            // print_r ($name);
            // $sum=[];
            // for($i=0;$i<count($medic);$i++){
            //     array_push($sum,[$name[$i][0],$name[$i][1],$name[$i][2],$mm[$i]]);
            // }
            //echo count($medic);
            $name3 = [];
            foreach ($name2 as $key00 => $value00) {
                array_push($name3, $value00);
            }
            $name2 = $name3;
            //print_r ($name2);   

            echo "<tr><td><div align='center'><h3>รายงานการให้บริการของแพทย์</h3></div></td></tr>";
            echo "<div class='col-md-10 text-right'><a href='#' class='btn btn-primary' id='download_link' onClick='ExcelReport2();''>Export to Excel 
                           <i class='fas fa-file-excel' style='font-size:20px;color:white' ></i></a>";
            echo "</div>";
            echo "<table id='myTable2' align='center' style='width:68%' class='table table-striped table-bordered table-hover table-responsive-sm'> ";

            echo "<th align='center' colspan='1' class='table-success'>การให้บริการของแพทย์";
            echo "<th align='left' class='table-success'><font size='1' > $date";
            echo "<tr align='center'><th   class='table-success'>ชื่อ-นามสกุล";
            echo "<th align='center'  class='table-success'>จำนวน</th></tr>";
            // print_r ($mm);
            for ($a = 0; $a < count($medic); $a++) {
                echo "<tr align='center' >
                                 <td align='left' >  " . $name2[$a] . "
                                 <td align='left' >จำนวน : " . $mm[$a] . " ครั้ง
                                 </tr>
                                 </th>";
            }

            echo "</th>";
            echo "</table>";


            ?>
        </div>
    </div>
    <?php include 'assets/object/footer.php' ?>
    <!-- เรียกใช้ javascript สำหรับ export ไฟล์ excel  -->
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saver@1.3.3/FileSaver.js"></script>

    <script>
        function ExcelReport() //function สำหรับสร้าง ไฟล์ excel จากตาราง
        {
            var sheet_name = "excel_sheet"; /* กำหหนดชื่อ sheet ให้กับ excel โดยต้องไม่เกิน 31 ตัวอักษร */
            var elt = document.getElementById('myTable'); /*กำหนดสร้างไฟล์ excel จาก table element ที่มี id ชื่อว่า myTable*/

            /*------สร้างไฟล์ excel------*/
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: sheet_name
            });

            XLSX.writeFile(wb, 'สรุปการรักษาแต่ละประเภท.xlsx'); //Download ไฟล์ excel จากตาราง html โดยใช้ชื่อว่า report.xlsx
        }

        function ExcelReport2() //function สำหรับสร้าง ไฟล์ excel จากตาราง
        {
            var sheet_name = "excel_sheet2"; /* กำหหนดชื่อ sheet ให้กับ excel โดยต้องไม่เกิน 31 ตัวอักษร */
            /*กำหนดสร้างไฟล์ excel จาก table element ที่มี id ชื่อว่า myTable*/
            var elt2 = document.getElementById('myTable2');
            /*------สร้างไฟล์ excel------*/

            var wb = XLSX.utils.table_to_book(elt2, {
                sheet: sheet_name
            });
            XLSX.writeFile(wb, 'สรุปการให้บริการของแพทย์.xlsx'); //Download ไฟล์ excel จากตาราง html โดยใช้ชื่อว่า report.xlsx
        }
    </script>
    <style type="text/css">
        table {
            border-collapse: collapse;
            width: 40%;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>











    </div>
    </div>










    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/js/bootstrap.min.js" integrity="sha384-5h4UG+6GOuV9qXh6HqOLwZMY4mnLPraeTrjT5v07o347pj6IkfuoASuGBhfDsp3d" crossorigin="anonymous"></script>



    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>


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
    </script>
</body>

</html>






<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://pingendo.com/assets/bootstrap/bootstrap-4.0.0-alpha.6.min.js"></script>