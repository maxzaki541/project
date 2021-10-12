<?php
session_start();
include 'assets/php/connect.php';
if(!isset($_SESSION['staff_id'])) header("location:index.php");
if(isset($_REQUEST['t']) ) {
    $i = $_REQUEST['t'];
}else{
    header("location:index_medic.php");
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/console.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
  <!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css" integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous">
    <title>ยินดีต้อนรับ</title>
    <style>

.front  input[type=date] {
    position: relative;
    width: 235px; height: 37px;
    border: 1px solid #ccc;
    color: white;
}


input:before {
    position: absolute;
    top: 4px; left: 10px;
    content: attr(data-date);
    display: inline-block;
    color: black;
}

input::-webkit-datetime-edit, input::-webkit-inner-spin-button, input::-webkit-clear-button {
    display: none;
}

input::-webkit-calendar-picker-indicator {
    position: absolute;
    top: 4px;
    right: 0;
    color: white;
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
                        แก้ไขข้อมูลแพทย์ผู้ให้บริการ
                    </div>
                </div>
                <?php include 'assets/php/log.php'?>
            </div>
            <?php 
                $sql = "SELECT * FROM `medic` WHERE `medic_id`='$i' ";
                $load = $con->query($sql);
                $data = $load->fetch_assoc();
                
                
            ?>
            <form action="assets/php/update_medic.php" method="post" enctype="multipart/form-data">
                <div class="row my-4" style="padding: 50px">

                    <div class="mb-3 col-lg-2">
                        <label for="stock_in" class="form-label">รหัสแพทย์</label>
                        <input type="text" name="pre" disabled="disabled" value=<?php echo $data['medic_id'];?> required class="form-control">
                    </div>

                    <div class="mb-3 col-lg-2">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="form-label">คำนำหน้า</label>
                            <select class="form-control" id="exampleFormControlSelect1" name="pre" value=<?php echo $data['medic_pre'];?>>
                            <option>---เลือกคำนำหน้า---</option>
                            <option value="นาย"
                            <?php 
                                if($data["medic_pre"]=='นาย')
                                {
                                    echo "selected";
                                }
                            ?>>นาย</option>
                            <option value="นาง"
                            <?php 
                                if($data["medic_pre"]=='นาง')
                                {
                                    echo "selected";
                                }
                            ?>>นาง</option>
                            <option value="นางสาว"
                            <?php 
                                if($data["medic_pre"]=='นางสาว')
                                {
                                    echo "selected";
                                }
                            ?>>นางสาว</option>
                            <option value="นายแพทย์"
                            <?php 
                                if($data["medic_pre"]=='นายแพทย์')
                                {
                                    echo "selected";
                                }
                            ?>>นายแพทย์</option>
                            <option value="แพทย์หญิง"
                            <?php 
                                if($data["medic_pre"]=='แพทย์หญิง')
                                {
                                    echo "selected";
                                }
                            ?>>แพทย์หญิง</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label for="p_detail" class="form-label">ชื่อ</label>
                        <input type="text" name="name" placeholder="example" value=<?php echo $data['medic_name'];?> required class="form-control">
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label for="p_detail" class="form-label">นามสกุล</label>
                        <input type="text" name="lastname" placeholder="example" value=<?php echo $data['medic_surname'];?> required class="form-control">
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label for="p_detail" class="form-label">หมายเลขทะเบียนวิชาชีพ</label>
                        <input type="text" name="regis" placeholder="example" value=<?php echo $data['medic_regis'];?> required class="form-control">
                    </div>
                    <!-- <div class="mb-3 col-lg-3">
                    <div class="front"> 
                        <label for="p_detail" class="form-label">วันที่เริ่มปฏิบัติงาน</label><br>
                        <input type="date" name="sdate" data-date="" data-date-format="YYYY-MM-DD" value=<?php echo $data['startdate'];?> >
                    </div>
                    </div> -->
                    <!-- <div class="mb-3 col-lg-3">
                    <div class="end">
                        <label for="p_detail" class="form-label">วันที่สิ้นสุดปฏิบัติงาน</label>
                        <input type="date" name="odate" data-date="" data-date-format="YYYY-MM-DD" value=<?php echo date("Y-m-d");?> >
                    </div>
                    </div> -->
                    <div class="mb-3 col-lg-3">
                    
                    <label for="p_detail" class="form-label">วันที่เริ่มปฏิบัติงาน</label>
                    
                    <input type="text" id="txtDate" name="sdate"  value="<?php echo $data['startdate']; ?>" class="form-control">
                   
                </div>
                    <div class="mb-3 col-lg-3">
                    
                        <label for="p_detail" class="form-label">วันที่สิ้นสุดปฏิบัติงาน</label>
                        
                        <input type="text" id="txtDates" name="odate"  value="<?php echo $data['outdate']; ?>" class="form-control">
                       
                    </div>

                    
                   
                    <input type="hidden" name="id" value=<?php echo $data['medic_id'];?> required class="form-control">
                    
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

        

        $('#sidebarCollapse').on('click', function () {
            // open or close navbar
            $('#sidebar').toggleClass('active');
            // close dropdowns
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });

        $('#a').on('click', function () {
            window.location  = "index_member.php"
        })
        $('#b').on('click', function () {})
        $('#c').on('click', function () {})
        $('#d').on('click', function () {})
        $('#e').on('click', function () {})
        $('#f').on('click', function () {})

    });
    $("input").on("change", function() {
    this.setAttribute(
        "data-date",
        moment(this.value, "YYYY-MM-DD")
        .format( this.getAttribute("data-date-format") )
    )
}).trigger("change")

$(function () {
    var year = (new Date).getFullYear()+543;
            $('#txtDate').datepicker({
                
                format: year+"-mm-dd"
            });
        });
        $(function () {
    var year = (new Date).getFullYear()+543;
            $('#txtDates').datepicker({
                
                format: year+"-mm-dd"
            });
        });

</script>
</body>
</html>
