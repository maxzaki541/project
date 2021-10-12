<?php
session_start();
include 'assets/php/connect.php';
if(!isset($_SESSION['staff_id'])) header("location:index.php");
if(isset($_REQUEST['t']) ) {
    $i = $_REQUEST['t'];
}else{
    header("location:index_queue_emp.php");
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/console.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <title>ยินดีต้อนรับ</title>

   
    <style>
      input[type="date"] {
    position: relative;
    width: 500px; height: 37px;
    color: white;
    border: 1px solid #ccc;
    border-radius: 2.5px;
}



input:before {
    position: absolute;
    top: 2px; left: 5px;
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
    <!-- <?php include 'assets/object/sidebar2.php'?> -->
    <!-- Page Content -->
    <div id="content">
        <?php include 'assets/object/navbar.php'?>

        <div class="container my-4">
            <div class="row">
                <div class="mb-3 col-lg-12">
                    <div class="header">
                        แก้ไขข้อมูลการจองคิวทั่วไป
                    </div>
                </div>
                <?php include 'assets/php/log.php'?>
            </div>
            <?php 
                $sql = "SELECT * FROM `queue_emp` WHERE `eguest_id`='$i' ";
                $load = $con->query($sql);
                $data = $load->fetch_assoc();
                
                
            ?>
            
            <form action="assets/php/update_queue_emp.php" method="post" enctype="multipart/form-data">
                <div class="row my-4" style="padding: 50px">
                <div class="mb-3 col-lg-2">
                        <label for="p_detail" class="form-label">รหัส</label>
                        <input type="text" name="id" disabled="disabled" value=<?php echo $data['eguest_id'];?> required class="form-control">
                    </div>
                    <div class="mb-3 col-lg-2">
                        <label for="p_detail" class="form-label">ชื่อ</label>
                        <input type="text" name="namep" placeholder="22/12/2020" value=<?php echo $data['namepub'];?> required class="form-control">
                    </div>
                    <div class="mb-3 col-lg-4">
                        <label for="p_detail" class="form-label">นามสกุล</label>
                        <input type="text" name="lastp" placeholder="10:00-11:00" value=<?php echo $data['lastnamepub'];?> required class="form-control">
                    </div>
                    <div class="mb-3 col-lg-6">
                        <label for="p_detail" class="form-label">วันที่จอง</label><br>
                        <input type="text" id="txtDate" name="dates" data-date="" data-date-format="YYYY-MM-DD" value=<?php echo $data['eguest_date'];?> required class="form-control" >
                    </div>
                    <!--<div class="mb-3 col-lg-4">
                        <label for="p_detail" class="form-label">เวลาที่จอง</label>
                        <input type="text" name="times" placeholder="10:00-11:00" value=<?php /*echo $data['eguest_time'];*/?> required class="form-control">
                    </div>-->
                    <div class="mb-3 col-lg-2">
                    <div class="row my-2" >
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">เวลาที่จอง</label>
                            <select class="form-control" id="exampleFormControlSelect2" value=<?php echo $data['eguest_time'];?> name="times">
                            <option value="09:00-10:30"
                            <?php 
                                if($data["eguest_time"]=='09:00-10:30')
                                {
                                    echo "selected";
                                }
                            ?>>09:00-10:30</option>
                            <option value="10:30-12:00"
                            <?php 
                                if($data["eguest_time"]=='10:30-12:00')
                                {
                                    echo "selected";
                                }
                            ?>>10:30-12:00</option>
                            <option value="13:00-14:30"
                            <?php 
                                if($data["eguest_time"]=='13:00-14:30')
                                {
                                    echo "selected";
                                }
                            ?>>13:00-14:30</option>
                            <option value="14:30-16:00"
                            <?php 
                                if($data["eguest_time"]=='14:30-16:00')
                                {
                                    echo "selected";
                                }
                            ?>>14:30-16:00</option>
                            <option value="17:00-18:30"
                            <?php 
                                if($data["eguest_time"]=='17:00-18:30')
                                {
                                    echo "selected";
                                }
                            ?>>17:00-18:30</option>
                            <option value="18:30-20:00"
                            <?php 
                                if($data["eguest_time"]=='18:30-20:00')
                                {
                                    echo "selected";
                                }
                            ?>
                            >18:30-20:00</option>
                            
                            </select>
                        </div>
                    </div>
                    </div>
                    <!--<div class="mb-3 col-lg-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">ประเภทการจอง</label>
                            <select class="form-control" id="exampleFormControlSelect2" name="type">
                            <option value="T001">ประคบร้อน</option>
                            <option value="T002">นวดแผนไทย</option>
                            </select>
                        </div>
                    </div>-->
                    <div class="mb-3 col-lg-3">
                    <div class="row my-2" >
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">ประเภทการรักษา</label>
                            <select class="form-control" id="exampleFormControlSelect2"  name="type">
                            <!--<option value="T001">ประคบร้อน</option>
                            <option value="T002">นวดแผนไทย</option>-->
                            <option value="---เลือก---" >---เลือก---</option> 
                            <?php
                                $strDefault=$data['type_id'];
                                $sql = "SELECT * FROM `type_service`";
                                $load = $con->query($sql);
                                while($data = $load->fetch_assoc()):
                                    if($strDefault == $data["type_id"])
                                    {
                                        $sel = "selected";
                                    }
                                    else
                                    {
                                        $sel = "";
                                    }
                                ?>
                                <option value="<?php echo $data['type_id'];?>"<?=$sel;?>><?php echo $data['type_name'];?></option>

                                <?php
                                endwhile;
                                ?>   
                            </select>
                        </div>
                    </div>
                    </div>

                    <input type="hidden" name="id" value=<?php echo $i;?> required class="form-control">
                    
                    <div class="mb-3 col-lg-11">
                        <button class="btn btn-primary" style="float:right">บันทึกข้อมูล</button>
                    </div>
                </div>
            </form>
            
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {

        $(function () {
            var year = (new Date).getFullYear()+543;
            $('#txtDate').datepicker({
                
                format: year+"-mm-dd"
            });
        });

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
