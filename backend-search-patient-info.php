<?php
 session_start();
 include 'assets/php/connect.php';
 if(!isset($_SESSION['staff_id'])) header("location:index.php");
 
if(isset($_REQUEST["term"])){
    
    $sql = "SELECT * FROM `patient_info` WHERE Info_name LIKE '%{$_REQUEST['term']}%' OR Info_surename LIKE '%{$_REQUEST['term']}%' OR info_id LIKE '%{$_REQUEST['term']}%' 
    Group by Info_name,Info_surename";
   
    $sum=0;
    $query = $con->query($sql);
    $tt = "
    <div class='mb-3 col-lg-12' id='demo'>
    <table class='table table-striped table-bordered table-hover table-responsive-sm' style='width:100%'>
        <thead align='center'>
            <tr class='table-primary'>
            <th><center>รหัสHn.</th>
                <th><center>คำนำหน้า</th>
                <th><center>ชื่อ</th>
                <th><center>นามสกุล</th>
                <th><center>อายุ</th>
                <th><center>เบอร์โทรศัพท์</th>
               
                <th><center>อาชีพ</th>
                
                
                <th><center>เกี่ยวข้องเป็น</th>
                <th><center>ชื่อผู้ปกครอง</th>
                <th><center>สถานะ</th>
                <th><center>การทำงาน</th>
            </tr>
        </thead>
        <tbody>
        <div class='float-right'>
        <a class='btn btn-success' href=add_patient_info.php><i class='fas fa-plus'></i>เพิ่มข้อมูล</a>
    </div><div> 
        <div class='container'>
          <div class='row hidden-md-up'>";
          $n=1;
        while ($result =$query->fetch_assoc()) { 
            $sum++;
            $tt .= "<tr><td>".$n;
            $tt .=  "</td><td>".$result['Info_pre'];
            $tt .= "</td><td>".$result['Info_name'];
            $tt .= "</td><td>".$result['Info_surename'];
            $tt .=  "</td><td>".$result['Info_age'];
            $tt .=  "</td><td>".$result['Info_cardnum'];
            
            //$tt .=  "</td><td>".$result['Info_sex'];
            $tt .=  "</td><td>".$result['Info_career'];
            // $tt .=  "</td><td>".$result['Info_birthday'];
            
            // $tt .=  "</td><td>".$result['Info_infoname'];
            $tt .=  "</td><td>".$result['Info_about'];
            $tt .=  "</td><td>".$result['Info_nameadult'];
            $tt .=  "</td><td>".$result['Info_status'];
            $tt .=  "</td> 
            <td><center>
            <a  class='btn btn-success' onClick=add('".$result['Info_id']."')><i class='fas fa-plus'> </i></a>
           
            <a  class='btn btn-info' onClick=\"watch('".$result['Info_name']."', '".$result['Info_surename']."')\"><i class='fas fa-eye'> </i></a>
            
            <a  class='btn btn-danger' onClick=remove('".$result['Info_id']."')><i class='fas fa-trash'> </i></a>
            <a  class='btn btn-success' onClick=addde('".$result['Info_id']."')><i class='fas fa-plus'> </i>เพิ่มประวัติการรักษา</a></td>
            </tr>";
            $n++;
         } ;

         $tt .= "</div>
         </div>
       </div>
       </tbody>

       <tfoot>
                            <tr align='center'>
                            <td colspan='10'>
                                รวม
                            </td>
                            <td >
                               $sum รายการ
                            </td>
                            </tr>
                            
                        </tfoot>
   </table>
  

   </div>";

   echo $tt;
}
 
// close connection
mysqli_close($link);
?>
 <!-- <script>
 function watch(params) {
  
    window.location.href = "detail_patient_info.php?t="+params 
   }
  </script> -->