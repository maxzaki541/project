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
        input:invalid + span::after {
        content: '✖';
        }

        input:valid+span::after {
        content: '✓';
        }
    </style>
    <style>
      input[type=date] {
    position: relative;
    width: 200px; height: 35px;
    color: white;
    border: 1px solid #ccc;
}

input:before {
    position: absolute;
    top: 0px; left: 3px;
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
                        เพิ่มข้อมูลแพทย์ผู้ให้บริการ
                    </div>
                </div>
                <?php include 'assets/php/log.php'?>
            </div>
            <?php 
                
                // $row = 1;
                // $id = "";
                // do{

                    
                //     $id = "DT";
                //     for($i=0;$i<4;$i++){
                //         $id .= rand(0,9);
                //     }
                //     $sql1 = "SELECT * FROM `medic` Where `medic_id`=$id";
                //     $load1 = $con->query($sql1);
                //     $row = mysqli_num_rows($load1);

                // }while($row != 0);
                // $sql1 = mysqli_result(mysqli_query($con,"SELECT Max(substr(`di_id`,-3))+1 as MaxID from `diagnosis`"),0,"MaxID");
                
                $code = "DT";
                $sql = "SELECT MAX(medic_id) AS last_id FROM medic";
                $qry = mysqli_query($con,$sql) or die(mysqli_error());
                $rs = mysqli_fetch_assoc($qry);
                $maxId = substr($rs['last_id'], -4);  //ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
                //$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
                $maxId = ($maxId + 1); 

                $maxId = substr("0000".$maxId, -4);
                $nextId = $code.$maxId;
            ?>
            
            <form action="assets/php/add_medic.php" method="post" enctype="multipart/form-data">
            
                <div class="row my-4" style="padding: 10px">
                   
                        <input type="hidden" name="id" value="<?php echo $nextId; ?>"  pattern="DT[0-9]{4}" required class="form-control">
                    
                    <!-- <div class="mb-3 col-lg-6">
                        <label for="stock_in" class="form-label">คำนำหน้า</label>
                        <input type="text" name="pre" placeholder="นาย" required class="form-control">
                    </div> -->
                    
                    
                    <div class="mb-3 col-lg-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="form-label">คำนำหน้า</label><font size="4" color="#FF0000" align='right'>*</font>
                            <select class="form-control" id="exampleFormControlSelect1" name="pre">
                            <option>---เลือกคำนำหน้า---</option>
                            <option value="นาย">นาย</option>
                            <option value="นาง">นาง</option>
                            <option value="นางสาว">นางสาว</option>
                            <option value="นายแพทย์">นายแพทย์</option>
                            <option value="แพทย์หญิง">แพทย์หญิง</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label for="p_detail" class="form-label">ชื่อ</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="name" placeholder="ชื่อ" required class="form-control">
                        
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label for="p_detail" class="form-label">นามสกุล</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="lastname" placeholder="นามสกุล" required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label for="p_detail" class="form-label">หมายเลขทะเบียนวิชาชีพ</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="registerno" placeholder="หมายเลขทะเบียนวิชาชีพ"  class="form-control">
                    </div>
                    <?php
                      $day=date('Y-m-d');
                      ?>
                    <!-- <div class="mb-3 col-lg-3">
                        <label for="p_detail" class="form-label">วันที่เริ่มปฏิบัติงาน</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="sdate" id="txtDate" data-date="" data-date-format="YYYY-MM-DD" value=<?php echo '"'.$day.'"';?>   >
                    </div> -->
                    <div class="mb-3 col-lg-3">
                        <label for="p_detail" class="form-label">วันที่เริ่มปฏิบัติงาน</label><font size="4" color="#FF0000" align='right'>*</font>
                        <input type="text" name="sdate" id="txtDate" placeholder="เลือกวัน"  class="form-control" >
                    </div>
                    <!-- <div class="mb-3 col-lg-3">
                        <label for="p_detail" class="form-label">วันที่สิ้นสุดปฏิบัติงาน</label>
                        <input type="date" name="odate" placeholder="วันที่สิ้นสุดปฏิบัติงาน" required class="form-control">
                    </div> -->

                   

                    <div class="mb-3 col-lg-11">
                        <button class="btn btn-primary" style="float:right">บันทึกข้อมูล</button>
                    </div>
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

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js" type="text/javascript"></script> -->

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
    // $(function () {
    //         $('#txtDate').datepicker({
    //             format: "dd-mm-yyyy"
    //         });
    //     });
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
