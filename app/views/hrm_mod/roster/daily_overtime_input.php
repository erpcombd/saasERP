<?php



session_start();



//




require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";

$title = 'Daily Overtime Entry';

do_calander('#m_date');



$head='<link href="../../../assets/css/report_selection.css" type="text/css" rel="stylesheet"/>';



auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');



$table='hrm_inout';



$unique='id';







if(isset($_POST['search']))



{		



$emp_id=$_POST['PBI_ID'];



$access_date=$a_date=$_POST['ztime'];



$c_date=explode('-',$a_date);



//$access_time=$a_date.' '.$_POST['m_hr'].':'.$_POST['m_min'].':'.'00';

$access_time=$_POST['ztime'];
$access_out_time=$_POST['xtime']; 



//$access_stamp=mktime($_POST['ztime'],$_POST['ztime'],0,$c_date[1],$c_date[2],$c_date[0]);

$access_stamp = $_POST['ztime'];

$sch = find_all_field_sql('select p.off_day,s.office_start_time,s.office_end_time from personnel_basic_info p, hrm_schedule_info s where p.PBI_ID="'.$emp_id.'" and p.office_time=s.id');
$date = date('Ymd',$access_stamp);
if(date('N',$access_stamp)==$sch->off_day) $info['status'][$date]=0;
else{

if($sch->office_start_time == '')	$info['status'][$date]=1;
else{$info['late'][$date] = (int)(($access_stamp - strtotime($access_date.' '.$sch->office_start_time))/60);
if($info['late'][$date]>0) 	$info['status'][$date]=2;
else $info['status'][$date]=1;
}}


$overtime_hours = round((strtotime($access_out_time) - strtotime($access_time))/3600, 1);


$overtime_rate = find_a_field('salary_info','overtime_hr_rate','PBI_ID="'.$_POST['PBI_ID'].'"');

$total_amount = $overtime_hours*$overtime_rate;













//$sql="INSERT INTO `overtime_input`(`employee_id` ,`card_no`,`access_date` ,`access_time` ,`access_stamp` ,`user` ,`status`,off_day,start_time,end_time )
//VALUES ('$emp_id', '$data[3]', '$access_date','$access_time', '$access_stamp', '$user1', '".$info['status'][$date]."','$sch->off_day', '$sch->office_start_time', '$sch->office_end_time')";
//$query=db_query($sql);


 $sql1="INSERT INTO `overtime_input` (`ztime` ,`bizid`,`xaction` ,`xenrollid` ,`xlocationid` ,`xmechineid`, xdate, xtime,overtime_hours,rate,amount) 
 VALUES ('$access_time', '$emp_id', '$terminal_id','$emp_id', '$terminal_id', '$terminal_id', '$access_date', '$access_out_time','$overtime_hours','$overtime_rate','$total_amount')";

$query1=db_query($sql1);
 
 
 
 
}?>











<style type="text/css">



<!--



.style1 {font-size: 24px}



.style2 {



	color: #FFFFFF;



	font-size: 24px;



	font-weight: bold;



}



-->



</style>











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



                <td height="40" colspan="4" bgcolor="#D82B7B" style="color:#FFFFFF"><div align="center" class="style1">Daily Overtime Input Page </div></td>



                </tr>



              <tr>



                <td ><div align="right">Employee Code: </div></td>



                <td colspan="3"><input name="PBI_ID" class="form-control"  type="text" id="PBI_ID" size="10" onblur="" tabindex="1"/></td>



              </tr>



              <?php /*?><tr>

                <td width="20%"><div align="right">Access Date-Time:</div></td>
                <td><input type="text" name="m_date" id="m_date" class="form-control" /></td>
                <td><select name="m_hr" id="m_hr">
               <? for($i=7;$i<20;$i++){  ?>
               <option><?=sprintf('%02d', $i);?></option>
               <? }?>
              </select>Hr
			  </td>
             <td><select name="m_min" id="m_min"><? for($i=0;$i<60;$i++){ ?>
              <option> <?=sprintf('%02d', $i);?></option> <? }?>

              </select> Min
			  
			  </td>
            </tr><?php */?>
			
			
			<tr>

                <td width="20%"><div align="right">Access In Date-Time:</div></td>
                <td><input type="datetime-local" id="ztime" name="ztime" required></td>
            
            </tr>
			
			
			
			
			<tr>

                <td width="20%"><div align="right">Access Out Date-Time:</div></td>
                <td><input type="datetime-local" id="xtime" name="xtime" required></td>
            
            </tr>
			
			
			
			
			



              <tr>



                <td colspan="4">



                    <div align="center">



                      <input name="search" type="submit" class="btn btn-primary" style="width:175px" id="search" value="Manual Overtime" />



                    </div>



                 </td>



              </tr>



            </table>



            <br /><div style="text-align:center">



              <div class="oe_form_sheetbg">



        <div class="oe_form_sheet oe_form_sheet_width">







          <div class="oe_view_manager_view_list"><div class="oe_list oe_view">



<? if($emp_id>0){







$ab="SELECT a.PBI_NAME as name, b.DOMAIN_DESC as company_name, c.DEPT_DESC as department, d.DESG_DESC as designation FROM personnel_basic_info a, domai b, department c, designation d WHERE a.PBI_DOMAIN=b.DOMAIN_CODE and a.PBI_DEPARTMENT=c.DEPT_ID and a.PBI_DESIGNATION=d.DESG_ID and a.PBI_ID=$emp_id";



$data=db_query($ab);



$emp=mysqli_fetch_object($data);



?>



<span id="id_view">



<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">



<tr>



<td height="50" bgcolor="#4F1971"><div align="center" class="style2">ACCESS IN AT: 



  <? //=date('d/m/Y H:i:s A',$access_stamp)?>
  <?=date('d-M-Y H:i:s',strtotime($access_stamp))?>



</div></td>



</tr>



<tr>



<td><div align="center"><img src="../../pic/staff/<?php echo $emp_id;?>.jpg" width="190" height="191" /></div></td>



</tr>



<tr>



<td><div align="center" class="cell_fonts_grant_total style7"><strong><em>Employee Code  : <?php echo $emp_id;?></em></strong></div></td>



</tr>



<tr>



<td><div align="center" class="cell_fonts_grant_total style6"><strong><em><?php echo $emp->name." (".$emp->designation.")";?> </em></strong></div></td>



</tr><tr>



<td><div align="center" class="cell_fonts_grant_total style6"><strong><em><?php echo $emp->department.", ".$emp->company_name;?> </em></strong></div></td>



</tr>



</table>



</span>          



<? }?>



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







<?



$main_content=ob_get_contents();



ob_end_clean();



require_once SERVER_CORE."routing/layout.bottom.php";



?>