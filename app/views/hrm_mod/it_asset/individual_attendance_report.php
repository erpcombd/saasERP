<?php
session_start();
//
require "../../config/inc.all.php";


$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
do_calander('#start_date');
do_calander('#end_date');
$PBI_ID = $_POST['PBI_ID'];




?>
<style type="text/css">
<!--
.style2 {color: #FFFFFF; }
-->
</style>



<div class="right_col" role="main">
  <!-- Must not delete it ,this is main design header-->
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>ATTENDENCE PAGE</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
              <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#">Settings 1</a> </li>
                  <li><a href="#">Settings 2</a> </li>
                </ul>
              </li>
              <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="openerp openerp_webclient_container">
            <div class="x_content">




<div class="oe_view_manager oe_view_manager_current">
        
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

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view"><form action="?"  method="post">
<table width="100%" border="0" class="oe_list_content"><thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><div align="center"><span>Payroll Calculation Report </span></div></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><div align="center"><span>Select Options</span></div></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>

  <tr  >
    <td width="5%" align="right">&nbsp;</td>
    <td width="18%" align="right"><strong>Employee Code  :</strong></td>
    <td width="31%" align="right"><div align="left">
	
      <input name="PBI_ID" list='eip_ids' type="text" id="PBI_ID" size="30" onblur="" tabindex="1"  class="form-control"  required="required" value="<?=$_POST['PBI_ID']?>" />
	  
	   <datalist id='eip_ids'>
  <option></option>
   <?
		
		foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_ID," - ",PBI_NAME)',$emp_id,'1');
		
	?>
  </datalist>
	  
	  
	  
    </div></td>
    <td width="23%" align="right">&nbsp;</td>
  </tr>
	  
	  <tr >
	    <td align="right">&nbsp;</td>
        <td align="right"><strong> Date  :</strong></td>
        <td align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><input type="date" style="width: 190px;" name="start_date" id="start_date"  class="form-control" required="required" 
	value="<? if(isset($_POST['start_date'])){ echo $_POST['start_date']; }else{echo date('Y-m-01'); } ?>" /></td>
            <td>TO</td>
            <td><input type="date" name="end_date" id="end_date"  class="form-control" required="required" 
	value="<? if(isset($_POST['end_date'])){ echo $_POST['end_date']; }else{echo date('Y-m-25'); } ?>" /></td>
          </tr>
        </table></td>
        <td align="right">&nbsp;</td>
    </tr>
	

	
	
	
	
	
	


  </tbody></table>
  <div align="center">
  <br /><br />
    <input name="create" type="submit" id="create" value="Show Report" style="width:230px" class="btn btn-info" />
  </div>
          </form>
<br /><? if($_POST['PBI_ID']>0){

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$begin = new DateTime($start_date);
$end = new DateTime($end_date);
$end->modify('+1 day');

$startTime = $days1=mktime(1,1,1,date('m',strtotime($start_date)),26,date('y',strtotime($start_date)));

$endTime = $days2=mktime(1,1,1,date('m',strtotime($end_date)),25,date('y',strtotime($end_date)));

$days_mon=($endTime - $startTime)/(3600*24);

for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
$day   = date('l',$i);
${'day'.date('N',$i)}++;

//if(isset($$day))
//$$day .= ',"'.date('Y-m-d', $i).'"';
//else
//$$day .= '"'.date('Y-m-d', $i).'"';
}


 $ab="SELECT 
a.PBI_NAME as name,
c.group_name as company,
desi.DESG_DESC as designation, 
d.DEPT_DESC as department

FROM 
personnel_basic_info a, 
user_group c, 
department d, 
designation desi

WHERE 
a.PBI_ORG=c.id and 
a.PBI_DEPARTMENT=d.DEPT_SHORT_NAME and 
a.PBI_DESIGNATION=desi.DESG_SHORT_NAME and 
a.PBI_ID='".$_POST['PBI_ID']."'";
$abb = db_query($ab);
$pbi=mysqli_fetch_object($abb);
?>
<div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>


<?php /*?><tr><td colspan="4">

<span id="id_view"></span>          

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Name: </td>
    <td>&nbsp;<?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$_POST['PBI_ID']);?></td>
    <td>Company:</td>
    <td>&nbsp;<?=$pbi->company?>,<?=$pbi->LOCATION_NAME?></td>
  </tr>
  <tr>
    <td>Designation:</td>
    <td>&nbsp;<?=$pbi->designation?></td>
    <td>Department:</td>
    <td>&nbsp;<?=$pbi->department?></td>
  </tr>
</table></td></tr><?php */?>




<tr><td colspan="4">

<span id="id_view">
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
<td height="50" bgcolor="#303435"><div align="center" class="style2">
  <p>ATTENDANCE REPORT</p>
  <p>DATE INTERVAL : <?=$_POST['start_date']?> AND <?=$_POST['end_date']?></p>
</div></td>
</tr>
<tr>
<td><div align="center"><img src="../../pic/staff/<?php echo $_POST['PBI_ID'];?>.jpeg" width="190" height="191" /></div></td>
</tr>
<tr>
<td><div align="center" class="cell_fonts_grant_total style7"><strong><em>Employee Code  : <?php echo $_POST['PBI_ID'];?></em></strong></div></td>
</tr>
<tr>
<td><div align="center" class="cell_fonts_grant_total style6"><strong><em>Employee Name  : <?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID='.$_POST['PBI_ID']);?> </em></strong></div></td>
</tr><tr>
<td><div align="center" class="cell_fonts_grant_total style6"><strong><em>Department  : <?=$pbi->department?> </em></strong></div></td>
</tr>
<tr>
<td><div align="center" class="cell_fonts_grant_total style6"><strong><em>Company  : <?=$pbi->company?>,<?=$pbi->LOCATION_NAME?> </em></strong></div></td>
</tr>
</table>
</span>          

</td></tr>








<tr class="oe_list_header_columns">
  <th colspan="4" style="text-align:center"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="grp">
   <thead> <tr bgcolor="#CCCCCC">
      <th><div align="center" class="style2">Date</div></th>
      <th><div align="center" class="style2">Day</div></th>
      <th>Sch-IN</th>
      <th>Sch-Out</th>
      <th><div align="center" class="style2">IN</div></th>
      <th><span class="style2">OUT</span></th>
    <!--  <th><span class="style2">Grace</span></th>
      <th>Late(Min)</th>
      <th>Final Late (Min)</th>
	  <th>Total Time</th>-->
      <th>Status</th>
      </tr></thead>
	  <? 



$sql  = 'select * from hrm_att_summary where emp_id="'.$PBI_ID.'" and  att_date between "'.$start_date.'" and "'.$end_date.'" order by att_date asc';
$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$val[$data->att_date]['in_time'] = $data->in_time;
$val[$data->att_date]['out_time'] = $data->out_time;

$val[$data->att_date]['sch_in_time'] = $data->sch_in_time;
$val[$data->att_date]['sch_out_time'] = $data->sch_out_time;

$val[$data->att_date]['iom'] = $data->iom_sl_no	;
$val[$data->att_date]['leave'] = $data->leave_id;
$val[$data->att_date]['dayname'] = $data->dayname;

$val[$data->att_date]['od_id'] = $data->od_id;
$val[$data->att_date]['od_start_time'] = $data->od_start_time;
$val[$data->att_date]['iom_start_time'] = $data->iom_start_time;
//time
$sacrow = $data->sch_in_time;
$sac = strtotime($sacrow);
$sac_formated = date("H:i",$sac);
//od start time
$fromserver = $data->od_start_time;
$fs = strtotime($fromserver);
$fromserver_formated = date("H:i",$fs);
//iom start time
$sort_leave_start_timee = date("H:i",strtotime($data->iom_start_time));


$val[$data->att_date]['final_late_min'] = $data->final_late_min;
$val[$data->att_date]['late_min'] = $data->late_min;
$val[$data->att_date]['final_late_status'] = $data->final_late_status;
$val[$data->att_date]['grace_no'] = $data->grace_no;
$val[$data->att_date]['holyday'] = $data->holyday;

if($data->leave_id>0)
$val[$data->att_date]['final_status'] = 'LEAVE';

//elseif($data->late_min>0)
//$val[$data->att_date]['late_status'] = 'LATE';


elseif( $data->in_time=='' && $data->leave_id==0 && $data->od_id==0 && $data->iom_sl_no==0 )
$val[$data->att_date]['final_status'] = 'Absent';


elseif( $data->final_late_status>0 && $data->od_id>0 && $fromserver_formated < $sac_formated )
$val[$data->att_date]['final_status'] = 'OD';

elseif( $data->od_id>0 && $fromserver_formated < $sac_formated )
$val[$data->att_date]['final_status'] = 'OD';

elseif( $data->final_late_status>0 && $data->od_id>0 && $fromserver_formated > $sac_formated  )
$val[$data->att_date]['final_status'] = 'LATE';

elseif($data->final_late_status>0 && $data->iom_sl_no>0 && $sort_leave_start_timee < $sac_formated )
$val[$data->att_date]['final_status'] = 'IOM';

elseif( $data->final_late_status>0 && $data->iom_sl_no>0 && $sort_leave_start_timee > $sac_formated  )
$val[$data->att_date]['final_status'] = 'LATE';


elseif($data->holyday>0)
$val[$data->att_date]['final_status'] = 'HOLIDAY';

elseif($data->dayname=='Friday')
$val[$data->att_date]['final_status'] = 'HOLIDAY';

elseif($data->final_late_status>0||$data->final_late_min>0)
$val[$data->att_date]['final_status'] = 'LATE';

elseif($data->id>0)
$val[$data->att_date]['final_status'] = 'REGULAR';




$dteStart = new DateTime($data->in_time);
$dteEnd   = new DateTime($data->out_time);
$dteDiff  = $dteStart->diff($dteEnd);








}



$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
//echo $off_day;
foreach ( $period as $dt ){
++$days;



$this_date = $dt->format( "Ymd" );

$day_date = $dt->format( "Y-m-d" );


$holysql = "select 1 from salary_holy_day where holy_day = '".$day_date."'";
$holy_query = db_query($holysql);
$holy = mysqli_fetch_row($holy_query);

$val[$day_date]['grace_no'];



if($holy>0){
$bgcolor = '#DDC6B6';
$val[$day_date]['final_status']='HOLIDAY';}

elseif($dt->format("l")=='Friday')
{$bgcolor = '#CCCCCC';$off_days++;}

elseif($val[$day_date]['final_status']=='LEAVE')
{$bgcolor = '#C3E8EA'; $leave++;}


elseif($dt->format("l")=='Friday')
{$bgcolor = '#CCCCCC';$off_days++;}

elseif($val[$day_date]['final_status']=='IOM')
{$bgcolor = '#AA96DA'; $iom++;}

elseif($val[$day_date]['final_status']=='OD')
$bgcolor = '#C5FAD5';


elseif($val[$day_date]['final_status']=='Absent')
{$bgcolor = '#ED9284'; $absent_leave_ck++;}


elseif($val[$day_date]['final_status']=='LATE')
{$bgcolor = '#F7DD00';$late++;$late_min_total = $late_min_total + $val[$day_date]['final_late_min'];}


elseif($val[$day_date]['final_status']=='REGULAR')
{$bgcolor = '#C1EEB0';$regular++;}
else
{$bgcolor = '#ED9284'; $regular++; $absent++;}

?>     
    
     
    <tr bgcolor="<?=$bgcolor?>">
      <td><?=$dt->format( "d-M-Y" );?></td>
      <td><?=$dt->format("l");?></td>
      <td><?=$val[$day_date]['sch_in_time'];?></td>
      <td><?=$val[$day_date]['sch_out_time'];?></td>
	  
	  <?php  if ($val[$day_date]['in_time'] >0){  ?>
	  
      <td><?=date("h:i:sa",strtotime($val[$day_date]['in_time']));?></td>
      <td><?=date("h:i:sa",strtotime($val[$day_date]['out_time']));?></td>
	  
	  <?php }else{  ?>
	  
	  <td></td>
	  <td></td>
	  
	   <?php  } ?>
	  
	  
      <?php /*?><td><?=($val[$day_date]['grace_no']>0&&$val[$day_date]['iom']==0)?$val[$day_date]['grace_no']:'';?></td>
      <td><?=($val[$day_date]['iom']==0&&$val[$day_date]['late_min']>0)?$val[$day_date]['late_min']:'';?></td>
      <td><?=($val[$day_date]['iom']==0&&$val[$day_date]['final_late_min']>0)?$val[$day_date]['final_late_min']:'';?></td>
	  <td><?=$hourdiff = round((strtotime($val[$day_date]['sch_out_time']) - strtotime($val[$day_date]['sch_in_time']))/3600, 1); ?></td><?php */?>
      <td><?=$val[$day_date]['final_status'];?></td>
      

	 
	  
	  
   
	  
	  
      </tr>
<? }?>
    <tr bgcolor="#FFFFFF">
      <td colspan="11"><br />
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th bgcolor="#666666"><div align="center" class="style2">TOTAL DAYS</div></th>
        <th bgcolor="#4A4B43"><div align="center" class="style2">PUBLIC HOLIDAYS</div></th>
        <th bgcolor="#006600"><div align="center" class="style2">PRESENT</div></th>
        <th bgcolor="#FF3300"><div align="center" class="style2">ABSENT</div></th>
		<th bgcolor="#78B4BF">LEAVE</th>
		<th bgcolor="#78B4BF">LWP</th>
		<th bgcolor="#78B4BF"><div align="center" class="style2"> SHL </div></th>
		<th bgcolor="#FFCC00"><div align="center" class="style2">LATE IN DAYS</div></th>
        <th bgcolor="#78B4BF">DAY OFF</th>
        
      </tr>

      <tr >
        <td bgcolor="#CCCCCC"><div align="center">
          <?=$days;?>
        </div></td>
        <td align="center" bgcolor="#F6E942"><div align="center"><?=$off_days;?></div>
          <div align="center"></div></td>
        <td bgcolor="#33FF00"><div align="center"><?=$regular-$absent;?></div></td>
        <td bgcolor="#FF9966"><div align="center"><?=$absent+$absent_leave_ck;?></div></td>
		<td bgcolor="#7CF8F8"><div align="center"><?=$leave?></div>    <? //=$late_min_total ?></td>
		<td bgcolor="#FF9966"><div align="center"><? //=$absent-$leave;?></div></td>
		<td bgcolor="#33CCFF"><div align="center"><?=$iom?>     <? //if($late_min_p>$late_day_p) echo $late_min_p*.5; else echo $late_day_p*.5;?></div></td>
        <td bgcolor="#FFFF99"><div align="center"> <?=$late;?></div></td>
        <td bgcolor="#33CCFF">    <? //$late_day_p = (int)($late/3); $late_min_p = (int)($late_min_total/30); if($late_min_p>$late_day_p) echo $late_min_p; else echo $late_day_p;?></td>
        
      </tr>
    </table></td>
      </tr>
  </table>
  </th>
  </tr>
  </thead>
  <tfoot>
  </tfoot>
  <tbody>
  </tbody>
</table>
  </div><? }?></div></div>
          </div>
    </div>
    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">
      <div class="oe_follower_list"></div>
    </div></div></div></div></div>
    </div></div>
            
        </div>
    </div>
	
	
	</div>
</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<?
$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";
include_once("../../template/footer.php");


?>