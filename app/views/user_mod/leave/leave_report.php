<?php
//
//


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",EMP_ID)','EMP_ID','','EMP_ID');

do_calander('#s_date');
do_calander('#e_date');


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



?>

<script type="text/javascript"> 



function DoNav(theUrl)

{

	window.open('detail_leave_report.php?PBI_ID='+theUrl);

}

</script>

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

<div class="oe_view_manager oe_view_manager_current">

        

    <?php /*?><? include('../../common/title_bar.php');?><?php */?>
	<h1>HRM >> LEAVE REPORT</h1>

        <div class="oe_view_manager_body">

            

                <div  class="oe_view_manager_view_list"></div>

            

                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">

        <div class="oe_form_buttons"></div>

        <div class="oe_form_sidebar"></div>

        <div class="oe_form_pager"></div>

        <div class="oe_form_container"><div class="oe_form">

          <div class="">

    <? //include('../../common/report_bar.php');?>

<div class="oe_form_sheetbg">

        <div class="oe_form_sheet oe_form_sheet_width">



          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">

		 

		 <table border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC" class="oe_form_group ">

		

                

              <tr class="oe_form_group_row">

				  
		            <td bgcolor="#CCCCCC" class="oe_form_group_cell" style="width:60px"><div align="left"><span class="oe_form_group_cell oe_form_group_cell_label">Date :    </div></td>                                   
                            
                            <td bgcolor="#CCCCCC" colspan="" style="width:60px" class="oe_form_group_cell">
							<div align="left">
                                <input type="text" name="s_date" id="s_date" placeholder="From" value="<?=$s_date?>" style="width:100px;" />
								 
						    <td bgcolor="#CCCCCC" colspan="" style="width:60px" class="oe_form_group_cell">
							<div align="left">
                              <input type="text" name="e_date" id="e_date" placeholder="To" value="<?=$e_date?>" style="width:100px;" />
                            </div></td>
                           

			
			<td bgcolor="#CCCCCC" class="oe_form_group_cell" style="width:60px"><div align="left"><span class="oe_form_group_cell oe_form_group_cell_label">Employee Name / Code : </div></td>
                <td bgcolor="#CCCCCC" colspan="" style="width:60px" class="oe_form_group_cell">
				<div align="left">
                  <input name="EMP_ID"  type="text" id="EMP_ID" value="<?=$emp_id?>" size="10" onblur="" tabindex="1" style="width:auto;" />
                </div></td>

				  

                

                    <td bgcolor="#CCCCCC" class="oe_form_group_cell" style="width:60px"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label">Department</span></div></td>

                  <td bgcolor="#CCCCCC" colspan="" style="width:60px" class="oe_form_group_cell">

				    <div align="center">
				      <select name="department" style="width:130px">
				        
				        <? foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['department'],' 1 order by DEPT_DESC');?>
				          </select>
				        </div></td>

				   <td bgcolor="#CCCCCC" class="oe_form_group_cell" style="width:60px"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label">Designation</span></div></td>

                  <td bgcolor="#CCCCCC" class="oe_form_group_cell" style="width:60px" >

				  

				    <div align="center">
				      <select name="designation" style="width:130px">
				        
				        <? foreign_relation('designation','DESG_ID','DESG_DESC',$_POST['designation'],' 1 order by DESG_DESC');?>
				          </select>
				        </div></td>
						
						</tr>
						
						<tr>
						
						<td bgcolor="#CCCCCC" class="oe_form_group_cell" style="width:60px"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label">Gender</span></div></td>

                  <td bgcolor="#CCCCCC" class="oe_form_group_cell" style="width:60px" >

				  

				    <div align="center">
				      <select name="PBI_SEX" id="PBI_SEX" style="width:130px">
				        
				  <option></option>      
				  <option value="Male" <?=($gender=="Male")?'selected':'';?>>Male</option>
				  <option value="Female" <?=($gender=="Female")?'selected':'';?>>Female</option>
                  </select>
				          
				        </div></td>
						
						
						
						<td bgcolor="#CCCCCC" class="oe_form_group_cell" style="width:60px"><div align="center"><span class="oe_form_group_cell oe_form_group_cell_label">Location</span></div></td>

                  <td bgcolor="#CCCCCC" class="oe_form_group_cell" style="width:60px" >

				  

				    <div align="center">
				      <select name="JOB_LOCATION" id="JOB_LOCATION" style="width:130px">
				        <option></option>
				 		<option value="Head Office" <?=($location=="Head Office")?'selected':'';?>>Head Office</option>

						<option value="Dhaka Airport" <?=($location=="Dhaka Airport")?'selected':'';?>>Dhaka Airport</option>

						<option value="Sector-1, Uttara" <?=($location=="Sector-1, Uttara")?'selected':'';?>>Sector-1, Uttara</option>

						<option value="Nasirabad, Chittagong" <?=($location=="Nasirabad, Chittagong")?'selected':'';?>>Nasirabad, Chittagong</option>
						
						<option value="Cox`s Bazar Airport" <?=($location=="Cox`s Bazar Airport")?'selected':'';?>>Cox`s Bazar Airport</option>

						<option value="Chittagong Airport" <?=($location=="Chittagong Airport")?'selected':'';?>>Chittagong Airport</option>

						<option value="OCC, Dhaka Airport" <?=($location=="OCC, Dhaka Airport")?'selected':'';?>>OCC, Dhaka Airport</option>
						
						<option value="Agrabad, Chittagong" <?=($location=="Agrabad, Chittagong")?'selected':'';?>>Agrabad, Chittagong</option>
						
						<option value="Gulshan/Motijheel/Airport" <?=($location=="Gulshan/Motijheel/Airport")?'selected':'';?>>Gulshan/Motijheel/Airport</option>
						
						<option value="Gulshan" <?=($location=="Gulshan")?'selected':'';?>>Gulshan</option>
						
						<option value="Agrabad Sales Counter (CGP)" <?=($location=="Agrabad Sales Counter (CGP)")?'selected':'';?>>Agrabad Sales Counter (CGP)</option>
						
						<option value="Zone-B, Dhaka Airport" <?=($location=="Zone-B, Dhaka Airport")?'selected':'';?>>Zone-B, Dhaka Airport</option>
						
						<option value="Kolkata, India Airport" <?=($location=="Kolkata, India Airport")?'selected':'';?>>Kolkata, India Airport</option>
						
						<option value="MD House" <?=($location=="MD House")?'selected':'';?>>MD House</option>
						
						<option value="Group Office, Chittagong" <?=($location=="Group Office, Chittagong")?'selected':'';?>>Group Office, Chittagong</option>
						
						<option value="Gulshan Sales Counter" <?=($location=="Gulshan Sales Counter")?'selected':'';?>>Gulshan Sales Counter</option>
						
						<option value="Bankok, Thailand Airport" <?=($location=="Bankok, Thailand Airport")?'selected':'';?>>Bankok, Thailand Airport</option>
						
						<option value="Kuala Lumpur, Malaysia Airport" <?=($location=="Kuala Lumpur, Malaysia Airport")?'selected':'';?>>Kuala Lumpur, Malaysia Airport</option>
						
						<option value="Kathmandu, Nepal Airport" <?=($location=="Kathmandu, Nepal Airport")?'selected':'';?>>Kathmandu, Nepal Airport</option>
						
						<option value="Motijheel" <?=($location=="Motijheel")?'selected':'';?>>Motijheel</option>
						
						<option value="Nasirabad Sales Counter (CGP)" <?=($location=="Nasirabad Sales Counter (CGP)")?'selected':'';?>>Nasirabad Sales Counter (CGP)</option>					
				          </select>
				        </div></td>

				  

				 <td bgcolor="#CCCCCC" class="oe_form_group_cell">

				     <div align="center">
				       <input type="submit" value="Show" id="submit" name="view" style="background:#3079ed;color:#fff; width:100px;"/>
				          </div></td>
                </tr>
          </table>

		  <hr/>
		  

		    

          

<? 

$res = "select a.PBI_ID,a.EMP_ID as ID,a.PBI_NAME as Staff_Name, a.PBI_SEX as Gender, a.JOB_LOCATION, c.DESG_DESC as Designation,d.DEPT_DESC as Department,

(select sum(total_days) from hrm_leave_info  where type='Casual Leave' and PBI_ID=o.PBI_ID) as Casual,
(select sum(total_days) from hrm_leave_info  where type='Sick Leave' and PBI_ID=o.PBI_ID) as Sick,
(select sum(total_days) from hrm_leave_info  where type='Annual' and PBI_ID=o.PBI_ID) as Annual,
(select sum(total_days) from hrm_leave_info  where type='Maternity Leave' and PBI_ID=o.PBI_ID) as Maternity,
(select sum(total_days) from hrm_leave_info  where type='Compensatory Off' and PBI_ID=o.PBI_ID) as Compensatory,
(select sum(total_days) from hrm_leave_info  where type='LWP (Leave Without Pay)' and PBI_ID=o.PBI_ID) as LWP,

 sum(o.total_days) total_days from personnel_basic_info a,designation c, department d,hrm_leave_info o where 1 and a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_ID=o.PBI_ID ";

if($designation!="")
$res.="and a.PBI_DESIGNATION='".$designation."' ";

if($department!="")
$res.="and a.PBI_DEPARTMENT='".$department."' ";

if($emp_id!="")
$res.="and a.EMP_ID='".$emp_id."' ";

if($gender!="")
$res.="and a.PBI_SEX='".$gender."' ";

if($location!="")
$res.="and a.JOB_LOCATION='".$location."' ";

if(($e_date!="")&&($s_date!=""))
$res.="and o.s_date<='".$e_date."' and o.e_date>='".$s_date."' ";

$res.="group by o.PBI_ID  order by o.id desc";
//echo $res;

echo $crud->link_report($res,$link);

$query=db_query($res);
$count=mysqli_num_rows($query);
?>
 
 
 
 


          <table width="50%" border="0" cellspacing="0" cellpadding="0">

            <tr>

              <td><div align="center" class="style1">

                <div align="left">Total Employee Found: 

                  <?=$count?>

                  </div>

              </div></td>

            </tr>

          </table>

          </div></div>

          </div>

    </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">

      <div class="oe_follower_list"></div>

    </div></div></div></div></div>

    </div></div>

            

        </div>

  </div>

</form> 

<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>