



<?php

session_start();

//


require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";







do_calander('#s_date');



do_calander('#e_date');



$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';



auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_CODE)','PBI_ID','','PBI_ID');

do_datatable('grp');

// ::::: Edit This Section ::::: 



$title='Short Leave (SHL)';			// Page Name and Page Title



$page="leave_entry.php";		// PHP File Name



$input_page="leave_entry_input.php";



$root='leave';







$table='hrm_leave_info';



$unique='id';



$shown='s_date';







// ::::: End Edit Section :::::







$crud      =new crud($table);



if(prevent_multi_submit()){



if(isset($_POST[$shown]))



{



$$unique = $_POST[$unique];



$_POST['entry_at']=date('Y-m-d H:i:s');
$_POST['leave_status']='GRANTED';
$s_date= strtotime($_REQUEST['s_date']);
$_POST['e_date']= $_POST['s_date'];  //strtotime($_REQUEST['e_date']);

$_POST['month']=date("n",strtotime($_REQUEST['s_date']));
$_POST['year']=date("Y",strtotime($_REQUEST['s_date']));

$_POST['half_or_full']='Half';
$_REQUEST['leave_slot'] = $_POST['leave_slot'];

$_POST['leave_apply_date'] = $_POST['s_date'];


if($_POST['leave_slot']=="Early Half"){

$_POST['sort_leave_start_time'] = '8:30';

$_POST['sort_leave_end_time']   = '12:45';

}else{

$_POST['sort_leave_start_time']= '12:45';

$_POST['sort_leave_end_time']   = '5:00';

}



// $old_leave = find_a_field('hrm_att_summary','leave_id',' att_date between "'.$_REQUEST['s_date'].'" and  "'.$_REQUEST['e_date'].'" and  emp_id="'.$_POST['PBI_ID'].'" and leave_id>0');







//if($old_leave == 0)



//{







$crud->insert();



$_GET['leave_id'] =  mysqli_insert_id();



$full_leave = find_all_field('hrm_leave_info','','id='.$_GET['leave_id']);















for($i=$s_date; $i<=$s_date; $i+=86400){



//if($full_leave->half_or_full=="half")



$leave_duration = '0.5';



//else



//$leave_duration = '1.0';





if($full_leave->leave_slot=="Early Half"){

$sort_leave_start_time = '8:30';

$sort_leave_end_time   = '12:45';

}else{

$sort_leave_start_time = '12:45';

$sort_leave_end_time   = '17:00';

}





 $att_date=date('Y-m-d',$i);



$sql="select id from hrm_att_summary where emp_id='".$_POST['PBI_ID']."' and att_date='".$att_date."'";



$query=db_query($sql);



$num_rows=mysqli_num_rows($query);



$data=mysqli_fetch_object($query);



	if($num_rows>0){



	$up_query="update hrm_att_summary set leave_id='".$full_leave->id."', leave_type='".$full_leave->leave_slot."',leave_category='".$full_leave->type."', leave_entry_at='".date('Y-m-d H:i:s')."',leave_start_time='".$sort_leave_start_time."',leave_end_time='".$sort_leave_end_time."',

leave_entry_by='".$_SESSION['user']['id']."',leave_duration='0.5' where id=".$data->id;



	db_query($up_query);



	}else{



	$ins_query="INSERT INTO hrm_att_summary( att_date, emp_id, leave_id, leave_type,leave_entry_at,leave_entry_by,leave_start_time,leave_end_time,leave_category,leave_duration) 

	VALUES ('".$att_date."','".$full_leave->PBI_ID."', '".$full_leave->id."', '".$full_leave->leave_slot."','".date('Y-m-d H:i:s')."', '".$_SESSION['user']['id']."' ,'".$sort_leave_start_time."','".$sort_leave_end_time."','".$full_leave->type."','0.5')";



	db_query($ins_query);



	}



}



//}



//else echo $msggg= "<h2 style='color:#FF0000'>You Can't Add Duplicate Leave</h2>";;



}



}























?>



<?php /*?><script type="text/javascript"> function DoNav(lk){



return GB_show('ggg', '../pages/<?=$root?>/<?=$input_page?>?<?=$unique?>='+lk,600,940)



}</script> <?php */?>



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







<!--<style type="text/css">







.style1 {font-size: 24px}



.style2 {



	color: #FFFFFF;



	font-size: 24px;



	font-weight: bold;



}





</style>-->

 <? include('../common/title_bar.php');?>

<form action="" method="post" enctype="multipart/form-data">

<table align="center" class="table table-bordered table-sm">
                          <tbody><tr>
                            <td colspan="5" bgcolor="#00FF00"><div align="center" style="font-size:24px">Half Day Leave Information Entry  </div></td>
                          </tr>
                          <tr>
                            <td colspan="5"><div align="center"></div></td>
                          </tr>
						  
                          <tr>
                            <td width="20%"><div align="right">Employee Code : </div></td>
                            <td width="26%"><input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1"  required /> </td>
							
                            <td align="right"><div align="right"> Type : </div></td>
                            <td width="26%">
							    <select name="type" id="type">
                                    <option selected="selected">Short Leave (SHL)</option>
                                </select>
							 </td>
							 
							 <td width="20%"></td>
							 
                          </tr>
                          <tr>
                            <td align="right"><div align="right"> Leave Slot:</div></td>
                            <td> 
							     <select name="leave_slot" id="leave_slot" required="required">
                                    <option></option>
                                    <option <?=($half_or_full=='Early Half')?'Selected':'';?> >Early Half</option>
                                    <option <?=($half_or_full=='Last Half')?'Selected':'';?> >Last Half</option>
                                </select>
							</td>
							
                            <td align="right"><div align="right"> Date :</div></td>
                            <td>
							    <input type="hidden" name="total_days" id="total_days"   value="0.5" autocomplete="off"/>
                                <input type="text" name="s_date" id="s_date" autocomplete="off" />
							</td>
							<td width="20%"></td>
                          </tr>
                          <tr>
                            <td><div align="right">Paid Status : </div></td>
                            <td> 
							    <select name="paid_status" id="paid_status">

                                    <option>Paid</option>

                                    <option>Unpaid</option>

                                </select>
							
							</td>
							
                            <td><div align="right">Reason :</div></td>
                            <td><input name="reason" type="text" id="reason"  class="form-control" autocomplete="off"/> </td>
							<td width="20%"></td>
                          </tr>
                          <tr>
                            <td colspan="5"><div align="center">
								<input name="search" class="btn1 btn1-submit-input" type="submit" id="search" value="add" />
								
                      
                              </div></td>
                          </tr>
                        </tbody>
						
						</table>


    

    <div class="container-fluid pt-5">




        <? if($_POST['PBI_ID']>0)



            $res = "select o.id,a.PBI_ID,a.EMP_ID,a.PBI_NAME,c.DESG_DESC,d.DEPT_DESC,o.s_date as start_date, o.e_date as end_date,o.total_days from personnel_basic_info a,designation c, department d,hrm_leave_info o
where a.DESG_ID=c.DESG_ID and a.DEPT_ID=d.DEPT_ID  and o.half_or_full='Half' and a.PBI_ID=o.PBI_ID and  a.PBI_ID='".$_POST['PBI_ID']."' order by o.id desc";



        else



            $res = "select o.id,a.PBI_ID,a.EMP_ID,a.PBI_NAME,c.DESG_DESC,d.DEPT_DESC,o.s_date as start_date, o.e_date as end_date,o.total_days from personnel_basic_info a,designation c, department d,hrm_leave_info o where a.DESG_ID=c.DESG_ID and a.DEPT_ID=d.DEPT_ID  and o.half_or_full='Half' and a.PBI_ID=o.PBI_ID  order by o.id desc";



        echo link_report1($res,$link);



        ?>





    </div>

</form>







<?php/*>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>




<div class="oe_view_manager oe_view_manager_current">



        <form action=""  method="post">







        <div class="oe_view_manager_body">







                <div  class="oe_view_manager_view_list"></div>







                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">



        <div class="oe_form_buttons"></div>



        <div class="oe_form_sidebar"></div>



        <div class="oe_form_pager"></div>



        <div class="oe_form_container"><div class="oe_form">



          <div class="">







<div class="oe_form_sheetbg">



        <div class="oe_form_sheet oe_form_sheet_width">







          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">



            <table width="80%" border="1" align="center">



              <tr>



                <td height="40" colspan="2" bgcolor="#00FF00"><div align="center" class="style1">Half Day Leave Information  Entry </div></td>



                </tr>



              <tr>



                <td width="20%"><div align="right">Employee Code : </div></td>



                <td><input name="PBI_ID"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1" style="width:400px;" required /></td>



              </tr>













              <tr>



                <td align="right" bgcolor="#EBEBEB"><div align="right"> Type : </div></td>



                <td bgcolor="#EBEBEB">



                  <select name="type" id="type">





				  <option selected="selected">Short Leave (SHL)</option>





				  </select>                </td>



              </tr>





			    <tr>

                <td align="right"><span class="oe_form_group_cell oe_form_group_cell_label">&nbsp;Leave Slot: </span></td>

                <td><span class="oe_form_group_cell">

                  <select name="leave_slot" id="leave_slot" required="required">

                    <option></option>

                    <option <?=($half_or_full=='Early Half')?'Selected':'';?> >Early Half</option>

                    <option <?=($half_or_full=='Last Half')?'Selected':'';?> >Last Half</option>

                  </select>

                </span></td>

              </tr>







              <tr>



                <td align="right"><div align="right">  Date :</div></td>



                <td><input type="hidden" name="total_days" id="total_days" style="width:100px;"  value=".5"/>







				<input type="text" name="s_date" id="s_date" style="width:100px;" /></td>



              </tr>



              <tr>



                <td bgcolor="#EBEBEB"><div align="right">Reason :</div></td>



                <td bgcolor="#EBEBEB"><label>



                  <input name="reason" type="text" id="reason" />



                </label></td>



              </tr>



              <tr>



                <td><div align="right">Paid Status : </div></td>



                <td><label>



                  <select name="paid_status" id="paid_status">

				  <option>Paid</option>

				  <option>Unpaid</option>

                  </select>



                  </label></td>



              </tr>



              <tr>



                <td colspan="2">



                    <div align="center">



                      <input name="search" class="btn1 btn1-bg-submit" type="submit" id="search" value="add" />



                    </div></td>



              </tr>



            </table>



            <br/>
                  <div style="text-align:center">



              <div class="oe_form_sheetbg">



        <div class="oe_form_sheet oe_form_sheet_width">







          <div class="oe_view_manager_view_list"><div class="oe_list oe_view">



<? if($_POST['PBI_ID']>0)



$res = "select o.id,a.PBI_ID,a.EMP_ID,a.PBI_NAME,c.DESG_DESC,d.DEPT_DESC,o.s_date as start_date, o.e_date as end_date,o.total_days from personnel_basic_info a,designation c, department d,hrm_leave_info o
where a.DESG_ID=c.DESG_ID and a.DEPT_ID=d.DEPT_ID  and o.half_or_full='Half' and a.PBI_ID=o.PBI_ID and  a.PBI_ID='".$_POST['PBI_ID']."' order by o.id desc";



else



$res = "select o.id,a.PBI_ID,a.EMP_ID,a.PBI_NAME,c.DESG_DESC,d.DEPT_DESC,o.s_date as start_date, o.e_date as end_date,o.total_days from personnel_basic_info a,designation c, department d,hrm_leave_info o where a.DESG_ID=c.DESG_ID and a.DEPT_ID=d.DEPT_ID  and o.half_or_full='Half' and a.PBI_ID=o.PBI_ID  order by o.id desc";



echo link_report1($res,$link);



 ?>



</div></div>



          </div>



    </div>







  </div></div></div>



          </div>



    </div>



    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">



      <div class="oe_follower_list"></div>



    </div></div></div></div></div>



    </div></div>







        </div>



 </form>   </div>


<*/?>



<?
$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>