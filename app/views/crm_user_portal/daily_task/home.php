<?php



//



//



require "../../config/inc.all.php";



$title=' Wellcome To User Module ';







?>



<style type="text/css">



.oe_app .oe_app_icon{



display:block;



float: left;



height: 48px;



position: relative;



width: 48px;



}







.oe_app .oe_app_icon img{



display:block;



height: 100%;



width: 100%;



}







.oe_app .oe_app_descr{



font-family:"Open Sans";



margin-left: 64px;



font-weight: 300;



font-size: 17px;



text-decoration:none;



color:#959494;



}







.oe_app_descr{







font-family:"Open Sans";



}











.oe_app .oe_app_name {



    font-size: 18px;



    /*font-weight: 400;*/



	/*text-align:center;*/



    margin-left: 64px;



    margin-top: -4px;



	/*font-family:"Open Sans";*/



	color:#646464;



	



}



.home_table td {



    padding: 2px;



}



.home_table_title {



    color: #617a03;



    font-weight: bold;



}



.home_box1 {



    background: url("../images/h_box_01.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);



    height: 212px;



    width: 249px;



}



.home_box2 {



    background: url("../images/h_box_02.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);



    height: 212px;



    width: 266px;



}



.home_box3 {



    background: url("../images/h_box_03.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);



    height: 212px;



    width: 241px;



}



.home_box4 {



    background: url("../images/h_box_04.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);



    height: 212px;



    width: 249px;



}



.home_box5 {



    background: url("../images/h_box_05.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);



    height: 212px;



    width: 266px;



}



.home_box6 {



    background: url("../images/h_box_06.jpg") no-repeat scroll 0 0 rgba(0, 0, 0, 0);



    height: 212px;



    width: 241px;



}



.left_report {



    overflow: auto;



}



.oe_app {



    background: none repeat scroll 0 0 whitesmoke;



    border: 1px solid transparent;



    border-radius: 2px;



    box-shadow: 0 0 white;



    box-sizing: border-box;



    color: inherit !important;



    cursor: pointer;



    display: block;



    float: left;



    height: 76px;



    margin: 16px;



    overflow: hidden;



    padding: 16px;



    position: relative;



    text-align: left;



    top: 0;



    transition: all 150ms linear 0s;



    width: 276px;



}



.oe_app:hover {



    border: 1px solid rgba(0, 0, 0, 0.1);



    box-shadow: 0 4px #dddddd, 0 4px 4px rgba(0, 0, 0, 0.1);



    top: -4px;



}



.style1 {font-size: 24px; color:#fff; font-weight:bold; margin-top:5px;}
</style>



<div class="oe_view_manager oe_view_manager_current">



        <table width="96%" border="0" align="center" cellpadding="10" cellspacing="0" style="margin:20px;">



  <tr>



    <td><?



////



//require "../../classes/check.php";



//require "../../config/db_connect.php";



//require "../../classes/all_functions.php";



//require "../../classes/scb.php";



//require "../../classes/my.php";



$leave_id = $_SESSION['user']['id'];

$welcome = find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$leave_id);





if($leave_id>0)



{







$g_s_date=date('Y-01-01');



$g_e_date=date('Y-12-31');







$hrm_leave_info=find_all_field('hrm_leave_info','','PBI_ID='.$leave_id);







$leave_days_casual=find_a_field('hrm_leave_info','sum(total_days)','type=1  and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);







$leave_days_sick=find_a_field('hrm_leave_info','sum(total_days)','type=2 and  and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);



$leave_balance=(30-($leave_days_casual+$leave_days_sick));



$leave_days_annual=find_a_field('hrm_leave_info','sum(total_days)','type=3 and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);



$leave_days_marrige=find_a_field('hrm_leave_info','sum(total_days)','type=4 and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);



$leave_days_maternity=find_a_field('hrm_leave_info','sum(total_days)','type=5 and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);



$leave_days_paternity=find_a_field('hrm_leave_info','sum(total_days)','type=6 and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);



$leave_days_Hajj=find_a_field('hrm_leave_info','sum(total_days)','type=7 and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);



$leave_days_half=find_a_field('hrm_leave_info','sum(total_days)','type="Half Leave" and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);



$leave_days_EOL=find_a_field('hrm_leave_info','sum(total_days)','type=8 and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);







$leave_days_compensatory=find_a_field('hrm_leave_info','sum(total_days)','type="Compensatory Off" and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);







$leave_days_lwp=find_a_field('hrm_leave_info','sum(total_days)','type=9 and leave_status="Granted" and s_date>="'.$g_s_date.'" and e_date<="'.$g_e_date.'"   and PBI_ID='.$hrm_leave_info->PBI_ID);







$personnel_basic_info=find_all_field('personnel_basic_info','','PBI_ID='.$leave_id);







$designation=find_all_field('designation','DESG_DESC','DESG_ID='.$personnel_basic_info->PBI_DESIGNATION);







$department=find_all_field('department','DEPT_DESC','DEPT_ID='.$personnel_basic_info->PBI_DEPARTMENT);







$hrm_leave_rull_manage=find_all_field('hrm_leave_rull_manage','','id='.$personnel_basic_info->LEAVE_RULE_ID);



}







?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>Details Staff Report</title>







<style type="text/css">



body { font-family:Tahoma, Geneva, sans-serif;



font-size:12px; }



table{ border:solid; border:#99C; padding:5px; margin-bottom:5px;}



td{



text-align:center;



}



.style4 {font-size: 14px}



.style9 {color: #FFFFFF}



.style10 {font-size: 14px; color: #000; margin-top:10px }



.style14 {font-size: 16px; font-weight: bold; }



.style16 {font-size: 12}



</style>



</head>







<body>



<form action="" method="post" enctype="multipart/form-data">







<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" eight="790" >



  <tr style="background:#2299C3">



    <td height="40" colspan="5">



	  <div align="center" class="style1">Employee Basic Information </div></td>



  </tr>



</table>







<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" eight="790" style="border-color:#CCCCCC">



  <tr>



    <td width="100" height="30" align="center" valign="middle" bordercolor="#F0F0F0" bgcolor="#FFFFFF"><div align="center" class="style14">ID</div></td>



    <td width="100" height="30" align="center" valign="middle" bordercolor="#F0F0F0" bgcolor="#FFFFFF" style="font-size:15px"><div align="center" class="style14">Name</div></td>



    <td width="100" height="30" align="center" valign="middle" bordercolor="#F0F0F0" bgcolor="#FFFFFF" style="font-size:15px"><div align="center" class="style14">



      Designation     </div></td>



    <td width="100" height="30" align="center" valign="middle" bordercolor="#F0F0F0" bgcolor="#FFFFFF"><div align="center" class="style14">Gender</div></td>



    <td width="100" height="30" align="center" valign="middle" bordercolor="#F0F0F0" bgcolor="#FFFFFF"><div align="center" class="style14">



      Department</div></td>



  </tr>



  <tr align="center" valign="middle" bgcolor="#FFFFFF">



    <td width="100" height="30"><div align="center" class="style4">



      <?=$personnel_basic_info->PBI_ID?>



    </div></td>



    <td width="100" height="30"><div align="center" class="style4"><?=$personnel_basic_info->PBI_NAME?></div></td>



    <td width="100" height="30"><div align="center" class="style4"><?php echo $designation->DESG_DESC?></div></td>



    <td width="100" height="30"><div align="center" class="style4">



      <?=$personnel_basic_info->PBI_SEX?>



    </div></td>



    <td width="100" height="30"><div align="center" class="style4"><?php echo $department->DEPT_DESC?></div></td>



  </tr>



  <tr align="center" valign="middle" bgcolor="#FFFFFF">



    <td width="100" height="30"><div align="center" class="style14">Date  of Joining</div></td>



    <td width="100" height="30"><div align="center" class="style14">Date of Confirmation</div></td>



    <td width="100" height="30">&nbsp;</td>



    <td width="100" height="30"><div align="center" class="style14">Job Location</div></td>



    <td width="100" height="30"><div align="center" class="style14">



      Total Sevice Length</div></td>



  </tr>



  



  



  



  <tr align="center" valign="middle" bgcolor="#FFFFFF">



    <td width="100" height="30"><div align="center" class="style4"><?=$personnel_basic_info->PBI_DOJ?>



    </div></td>



    <td width="100" height="30"><div align="center" class="style4">



      <?=$personnel_basic_info->PBI_DOC?>



</div></td>



    <td width="100" height="30">&nbsp;</td>



    <td width="100" height="30"><div align="center" class="style4">

      <?=find_a_field('project','PROJECT_NAME','PROJECT_ID='.$personnel_basic_info->JOB_LOCATION)?>

    </div></td>



    <td width="100" height="30"><div align="center" class="style4">



     

	  <?php

										  

		  $interval = date_diff(date_create(date('Y-m-d')), date_create($personnel_basic_info->PBI_DOJ));

		echo $interval->format("%Y Year, %M Months, %d Days");

		  ?>



    </div></td>



  </tr>



</table>

<p>&nbsp;</p>
<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#ccc">

    <tr>

      <td colspan="12"  bgcolor="#FFFFFF" style="background:#ffc107; color:#1d1c1c"><h2 align="center">Individual Task Status <?php echo date('d-m-Y')?></h2></td>
    </tr>

	<tr style="background:#f1f1f0" height="60">



      <td width="118" align="center" valign="middle"><strong><span class="style10">

      <div align="center" style="margin-top:15px">Type</div></span></strong></td>



      <td width="101" align="center" valign="middle"><strong><span style="margin-top:15px">Qty </span></strong></td>
      <td width="101" align="center" valign="middle"><strong><span class="style10">

      <div align="center" style="margin-top:15px">Action </div>

      </span></strong></td>
    <tr align="center">



      <td width="118" height="10" align="center"  bgcolor="red"><div align="center" style="margin-top:8px;"><strong>Pending Task </strong></div></td>



      <td width="101" align="center" valign="middle"  bgcolor="red" ><?=find_a_field('daily_give_task_details d,daily_give_task_master m','count(d.id)','d.status like "PENDING" and d.task_id=m.task_id and m.given_to='.$_SESSION['user']['id']);?></td>
      <td width="101" height="25" align="center" valign="middle"  bgcolor="red" ><div align="center" style="margin-top:8px;">View</div></td>
    </tr>



    <tr>



      <td width="118" height="25" align="center" valign="middle"  bgcolor="yellow"><div align="center" style="margin-top:5px;"><strong>Ongoing Task  </strong></div></td>



      <td width="101" align="center" valign="middle"  bgcolor="yellow"><?=find_a_field('daily_give_task_details d,daily_give_task_master m','count(d.id)','d.status like "ONGOING" and d.task_id=m.task_id and m.given_to='.$_SESSION['user']['id']); echo $_SESSION['user']['id'];?></td>
      <td width="101" height="25" align="center" valign="middle"  bgcolor="yellow"><div align="center" style="margin-top:8px;">View</div></td>

       
    <tr style="font-weight:bold;">



      <td width="118" height="25" align="center" valign="middle"  bgcolor="green"><div align="center" style="margin-top:8px;">Completed Task </div></td>


      <td width="101" align="center" valign="middle"  bgcolor="green"><?=find_a_field('daily_give_task_details d,daily_give_task_master m','count(d.id)','d.status like "COMPLETED" and d.task_id=m.task_id and m.given_to='.$_SESSION['user']['id']);?></td>
      <td width="101" height="25" align="center" valign="middle"  bgcolor="green"><div align="center" style="margin-top:8px;">View</div></td>

    </tr>


</table>
  <p>&nbsp;</p>

  <!----------------test ---------->

  <table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#ccc">

    <tr>

      <td colspan="11"  bgcolor="#FFFFFF" style="background:#2299C3; color:#FFFFFF"><h2 align="center">Individual Leave Status <?php echo date('Y')?></h2></td>
    </tr>

	<tr style="background:#f1f1f0" height="60">



      <td width="118" align="center" valign="middle"><strong><span class="style10">

      <div align="center" style="margin-top:15px">Type</div></span></strong></td>



      <td width="101" align="center" valign="middle"><strong><span class="style10">

      <div align="center" style="margin-top:15px">Leave </div>

      </span></strong></td>
    <tr align="center">



      <td width="118" height="10" align="center"  bgcolor="#FFFFFF"><div align="center" style="margin-top:8px;"><span class="style4"><strong>Sick Leave </strong></span></div></td>



      <td width="101" height="25" align="center" valign="middle"  bgcolor="#FFFFFF" ><div align="center" style="margin-top:8px;">
	  
	  
	   <?=number_format($leave_days_sick,0);?>
	  </div></td>
    </tr>



    <tr>



      <td width="118" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:5px;"><strong>Casual Leave </strong></div></td>



      <td width="101" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:8px;"><span class="style4">
        <?=$leave_days_casual?>
      </span></div></td>

        <?=number_format($leave_days_sick,0)?>

        <?=$leave_days_annual?>

        

      <?

	      if($personnel_basic_info->PBI_SEX=="Female"){

	      ?>

      

     <? }else{ ?>

      

	  <? } ?>
    <tr style="font-weight:bold;">



      <td width="118" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:8px;"><span class="style4"><strong>Balance</strong></span></div></td>



      <td width="101" height="25" align="center" valign="middle"  bgcolor="#FFFFFF"><div align="center" style="margin-top:8px;"><span class="style4">
        <?=$leave_balance;?>
      </span></div></td>



 

        <?=-$leave_days_sick?>



     





  <?

	      if($personnel_basic_info->PBI_SEX=="Female"){

	      ?>

      

   <? }else{ ?>

    

	  <? } ?>
    </tr>



	



	



   



  



  



  <? 



$res = "select o.*, a.EMP_ID, a.PBI_NAME from personnel_basic_info a, hrm_leave_info o where  a.PBI_ID=o.PBI_ID and leave_status='GRANTED' and o.s_date>='".$g_s_date."' and o.e_date<='".$g_e_date."'   and o.PBI_ID=".$hrm_leave_info->PBI_ID;







$sqll=db_query($res);







while ($data=mysqli_fetch_object($sqll)){?>

















<? } ?>
</table>



  



  



</form>



  



  



  



</body>



</html></td>



  </tr>



</table>







</div>



<?



//



//



require_once SERVER_CORE."routing/layout.bottom.php";



?>