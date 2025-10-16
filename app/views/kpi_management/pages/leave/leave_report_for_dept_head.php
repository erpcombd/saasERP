<?php
session_start();
ob_start();

require_once "../../config/inc.all.php";
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

$PBI = find_all_field('personnel_basic_info','','PBI_ID='.$_SESSION['employee_selected']);
$department=find_a_field('department','DEPT_DESC','DEPT_ID='.$PBI->PBI_DEPARTMENT);

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

$g_s_date=date('Y-01-01');
$g_e_date=date('Y-12-31');

?>

<script type="text/javascript"> 



function DoNav(theUrl)

{

	window.open('detail_leave_report.php?id='+theUrl);

}

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
	<h1>HRM >> LEAVE REPORT >> DEPT: <?=$department?> for Year <?=date('Y')?></h1>

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
            <hr/>
		  

		    

          

<? 

$res = "select a.PBI_ID,a.EMP_ID as ID,a.PBI_NAME as Staff_Name, a.PBI_SEX as Gender, a.JOB_LOCATION as job_loaction, c.DESG_DESC as Designation,d.DEPT_DESC as Department,

(select sum(total_days) from hrm_leave_info  where type='Casual Leave' and PBI_ID=o.PBI_ID) as Casual,
(select sum(total_days) from hrm_leave_info  where type='Sick Leave' and PBI_ID=o.PBI_ID) as Sick,
(select sum(total_days) from hrm_leave_info  where type='Annual' and PBI_ID=o.PBI_ID) as Annual,
(select sum(total_days) from hrm_leave_info  where type='Maternity Leave' and PBI_ID=o.PBI_ID) as Maternity,
(select sum(total_days) from hrm_leave_info  where type='Compensatory Off' and PBI_ID=o.PBI_ID) as Compensatory,
(select sum(total_days) from hrm_leave_info  where type='LWP (Leave Without Pay)' and PBI_ID=o.PBI_ID) as LWP,

 sum(o.total_days) total_days from personnel_basic_info a,designation c, department d,hrm_leave_info o where 1 and a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_ID=o.PBI_ID and o.s_date>='".$g_s_date."' and o.e_date<='".$g_e_date."' and a.PBI_DEPARTMENT=".$PBI->PBI_DEPARTMENT;

if($designation!="")
$res.=" and a.PBI_DESIGNATION='".$designation."' ";

//if($department!="")
//$res.=" and a.PBI_DEPARTMENT='".$department."' ";

if($emp_id!="")
$res.=" and a.EMP_ID='".$emp_id."' ";

if($gender!="")
$res.=" and a.PBI_SEX='".$gender."' ";

if($location!="")
$res.=" and a.JOB_LOCATION='".$location."' ";

if(($e_date!="")&&($s_date!=""))
$res.=" and o.s_date<='".$e_date."' and o.e_date>='".$s_date."' ";

$res.=" group by o.PBI_ID  order by a.PBI_ID";
//echo $res;

echo $crud->link_report($res,$link);

$query=mysql_query($res);
$count=mysql_num_rows($query);
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

$main_content=ob_get_contents();

ob_end_clean();

include ("../../template/main_layout.php");

?>