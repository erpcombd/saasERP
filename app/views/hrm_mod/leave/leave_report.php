<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','EMP_ID');















//do_calander('#s_date');
//do_calander('#e_date');























if(isset($_REQUEST['view']))







{







$s_date=$_REQUEST['s_date'];







$e_date=$_REQUEST['e_date'];















$emp_id=$_REQUEST["EMP_ID"];







$department=$_REQUEST["department"];







$designation=$_REQUEST["designation"];







$gender=$_REQUEST["PBI_SEX"];







$location=$_REQUEST["JOB_LOCATION"];







}



























do_datatable('grp');



// ::::: Edit This Section ::::: 







$title='Leave Report';			// Page Name and Page Title







$page="leave_report.php";		// PHP File Name















$root='leave';















$table='hrm_leave_info';		// Database Table Name Mainly related to this page







$unique='id';			// Primary Key of this Database table







$shown='type';				// For a New or Edit Data a must have data field















// ::::: End Edit Section :::::















$crud      =new crud($table);







$$unique = $_GET[$unique];


$date = new DateTime($_POST['e_date']);
$date_paramiter = $date->format('Y');




?>





<script type="text/javascript"> 


var date_variable = '<?php echo $date_paramiter?>';




function DoNav(theUrl)







{




window.open('detail_leave_report.php?PBI_ID=' + theUrl + '&date_var=' + date_variable);







}





</script>





	<script type="text/javascript">







$(document).ready(function(){















  $("#e_date").change(function (){







     var from_leave = $("#s_date").datepicker('getDate');







     var to_leave = $("#e_date").datepicker('getDate');







    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;















	if(days>0&&days<100){







	$("#total_days").val(days);}







  });







      $("#s_date").change(function (){







     var from_leave = $("#s_date").datepicker('getDate');







     var to_leave = $("#e_date").datepicker('getDate');







    var days   = ((to_leave - from_leave)/1000/60/60/24)+1;







	if(days>0&&days<100){







	$("#total_days").val(days);}







  });







    







  







});







 







</script>





	<style type="text/css">















<!--















.style1 {















	color: #0066CC;















	font-weight: bold;















}







-->







</style>





















    <form action="" method="post" name="search" enctype="multipart/form-data">









        <div class="d-flex justify-content-center">

            <div class="n-form1 fo-width pt-0">

                <h4 class="text-center bg-titel bold pt-2 pb-2"> Leave Report  </h4>

                <div class="container-fluid pt-3">

                    <div class="row m-0 p-0">

                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" >





                            <div class="form-group row m-0 mb-1 pl-3 pr-3">

                                <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date :</label>

                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                    <input type="date" name="s_date" id="s_date" placeholder="From" value="<?=$s_date?>" required  autocomplete="off"/ >

                                </div>

                            </div>





                            <div class="form-group row m-0 mb-1 pl-3 pr-3">

                                <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date:</label>

                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                               <input type="date" name="e_date" id="e_date" placeholder="To" value="<?=$e_date?>" required autocomplete="off"/  >

                                </div>

                            </div>





                            <div class="form-group row m-0 mb-1 pl-3 pr-3">

                                <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Employee Name:</label>

                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                    <input name="EMP_ID"  type="text" id="EMP_ID" value="<?=$emp_id?>"  onblur="" tabindex="1"/>

                                </div>

                            </div>





                        </div>









                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                            <div class="form-group row m-0 mb-1 pl-3 pr-3">

                                <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company :</label>

                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">



                                    <select name="user_group">



                                        <? foreign_relation('user_group','id','group_name',$_POST['user_group'],' 1 order by group_name asc');?>



                                    </select>

                                </div>

                            </div>







                            <div class="form-group row m-0 mb-1 pl-3 pr-3">

                                <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Department :</label>

                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">



                                    <select name="department">

                                        <option></option>

                                        <? foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['department'],' 1 order by DEPT_DESC');?>

                                    </select>

                                </div>

                            </div>





                            <div class="form-group row m-0 mb-1 pl-3 pr-3">

                                <label for="group_for" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Location :</label>

                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                    <select name="JOB_LOCATION" id="JOB_LOCATION">



                                        <option></option>



                                        <? foreign_relation('office_location','ID','LOCATION_NAME',$_POST['JOB_LOCATION'],' 1 order by LOCATION_NAME');?>

                                    </select>



                                </div>

                            </div>



                        </div>













                    </div>



                    <div class="n-form-btn-class">

                        <input type="submit" value="Show" id="submit" name="view"  class="btn1 btn1-bg-submit">

                    </div>



                </div>

            </div>

        </div>



        <div class="container-fluid pt-5">





            <?

            if(isset($_POST['view'])){









                $res = "select a.PBI_ID,a.PBI_CODE as ID,a.PBI_NAME as Staff_Name, a.PBI_SEX as Gender, c.DESG_DESC as Designation,d.DEPT_DESC as Department,

(select sum(total_days) from hrm_leave_info  where type='LWP (Leave Without Pay)' and s_date between '".$s_date."' and '".$e_date."' and PBI_ID=o.PBI_ID) as LWP,

(select sum(total_days) from hrm_leave_info  where type!='LWP (Leave Without Pay)' and s_date between '".$s_date."' and '".$e_date."' and PBI_ID=o.PBI_ID) as Total_Leave



from personnel_basic_info a,designation c, department d,hrm_leave_info o



where 1 and a.DESG_ID=c.DESG_ID and a.DEPT_ID=d.DEPT_ID and o.s_date between '".$s_date."' and '".$e_date."'



and a.PBI_ID=o.PBI_ID ";





                if($designation!="") $res.="and a.PBI_DESIGNATION='".$designation."' ";



                if($department!="") $res.="and a.DEPT_ID='".$department."' ";



                if($emp_id!="") $res.="and a.PBI_ID='".$emp_id."' ";



                if($_POST['user_group']!="") $res.="and a.PBI_ORG='".$_POST['user_group']."' ";



                if($location!="") $res.="and a.JOB_LOC_ID='".$location."' ";



                $res.="group by o.PBI_ID  order by o.id desc";





//echo $res;





                echo link_report1($res,$link);



                $query=db_query($res);



                $count=mysqli_num_rows($query);



            }



            ?>



            <h4 class="text-center bg-titel bold pt-2 pb-2">Total Employee Found: <?=$count?></h4>



        </div>



    </form>





<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>