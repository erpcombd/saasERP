<?php

session_start();
//

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.core/init.php);
require_once SERVER_CORE."routing/layout.top.php";

$title = 'Individial Attendance Report';

$page_id = 35;

//check_access($page_id);

auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','PBI_ID');

$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

do_calander('#start_date');

do_calander('#end_date');



?>

<style type="text/css">

<!--

.style2 {color: #FFFFFF; }

-->

</style>









<div class="oe_view_manager oe_view_manager_current">
<form action="?"  method="post">

<table width="100%" border="0">
<tbody>
<tr>

  <td colspan="6" style="background-color:#00CCCC; padding:5px; font-size:20px; font-weight:bold; text-align:center;">Individial Attendance Report</td>

  </tr>
 

  	<tr>
	  <td width="10%"><strong></strong></td>
	  
		<td width="11%"><strong>Employee Code  :</strong></td>
		
		<td  colspan="3">
			<input name="PBI_ID"  type="text" id="PBI_ID"  onblur="" tabindex="1" required value="<?=$_POST['PBI_ID']?>" />
		</td>
		  <td width="10%"><strong></strong></td>

    </tr>

	<tr>
  <td width="10%"><strong></strong></td>
    <td width="11%"><strong>Start Date  :</strong></td>

    <td width="30%"><input type="text" name="start_date" id="start_date"  required value="<?=$_POST['start_date']?>" autocomplete="off"/></td>

    <td width="10%"><strong>End Date   :</strong></td>

    <td width="30%"><input type="text" name="end_date" id="end_date"  required value="<?=$_POST['end_date']?>" autocomplete="off"/></td>
  <td width="10%"><strong></strong></td>
  	</tr>

	<tr>
	
	  <td colspan="6" align="center"><input name="create" type="submit" id="create" class="btn1 btn1-bg-submit" value="Show Report" /></td>
	
	</tr>



  </tbody>
  
  </table>
  
  </form>
        

        <div class="oe_view_manager_body">

            

            

                <div class="oe_view_manager_view_form">
				<div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">



        <div class="oe_form_container"><div class="oe_form">

          <div class="">

<div class="oe_form_sheetbg">

        <div class="oe_form_sheet oe_form_sheet_width">




		  
		  

<br /><? if($_POST['PBI_ID']>0){



$PBI_ID = $_POST['PBI_ID'];

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





$ab="SELECT a.PBI_NAME as name, b.DOMAIN_DESC as company_name, c.DEPT_DESC as department, d.DESG_DESC as designation,off_day FROM personnel_basic_info a, domai b, department c, designation d WHERE a.PBI_DOMAIN=b.DOMAIN_CODE and a.PBI_DEPARTMENT=c.DEPT_ID and a.PBI_DESIGNATION=d.DESG_ID and a.PBI_ID='".$_POST['PBI_ID']."'";

$data=db_query($ab);

$emp=mysqli_fetch_object($data);

?>

<div style="text-align:center">

<div class="print_box">	

						

									<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td style="text-align:left"><table width="1%" border="0" cellspacing="0" cellpadding="0" align="center">

									  <tr>

										<td>

<form action="../common/ShowForPrint.php" method="post" name="form_print" target="_blank" id="form_print" onsubmit='$("#datatodisplay1").val( $("<div>").append( $("#grp").eq(0).clone() ).html() )'>

  <input  type="image" src="../images/print.png" width="26" height="26" style="width:26px; height:26px;">

  <input type="hidden" id="datatodisplay1" name="datatodisplay1" />

  <input type="hidden" id="page_title" name="page_title" value="Individual Attendence Report" />

  <input type="hidden" id="report_detail" name="report_detail" value="

  Employee :<?php echo $emp->name." [".$_POST['PBI_ID']."]"." (".$emp->designation.")";?>

  <br>Department :<?=$emp->department?><br>Company Name :<?=$emp->company_name;?><br>DATE INTERVAL : <?=$_POST['start_date']?> AND <?=$_POST['end_date']?>" />

</form></td>

									    

									    <td>&nbsp;</td>

									  </tr>

							  </table></td>

  </tr>

</table>



									</div>

<table width="100%" class="oe_list_content">

  <thead>





<tr><td colspan="4">



<span id="id_view">

<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">

<tr>

<td height="50" bgcolor="#4F1971"><div align="center" class="style2">

  <p>ATTENDANCE REPORT</p>

  <p>DATE INTERVAL : <?=$_POST['start_date']?> AND <?=$_POST['end_date']?></p>

</div></td>

</tr>

<tr>

<td><div align="center"><img src="../../pic/staff/<?php echo $_POST['PBI_ID'];?>.jpg" width="190" height="191" /></div></td>

</tr>

<tr>

<td><div align="center" class="cell_fonts_grant_total style7"><strong><em>Employee Code  : <?php echo $_POST['PBI_ID'];?></em></strong></div></td>

</tr>

<tr>

<td><div align="center" class="cell_fonts_grant_total style6"><strong><em><?php echo $emp->name." (".$emp->designation.")";?> </em></strong></div></td>

</tr><tr>

<td><div align="center" class="cell_fonts_grant_total style6"><strong><em><?php echo $emp->department.", ".$emp->company_name;?> </em></strong></div></td>

</tr>

</table>

</span>          



</td></tr>

<tr class="oe_list_header_columns">

  <th colspan="4" style="text-align:center"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="grp">

   <thead> 
   <tr bgcolor="#4890D7">

      <th><div align="center" class="style2">Date</div></th>
      <th><div align="center" class="style2">Day</div></th>
      <th><div align="center" class="style2">Status</div></th>
      <th><div align="center" class="style2">Star Over Time</div></th>
      <th><span class="style2">End Over Time</span></th>
      <th><span class="style2">Working Hours</span></th>

      <th><div align="center" class="style2">Rate</div></th>

	  <th><div align="center" class="style2">Total Amount</div></th>
	  
	  <th><div align="center" class="style2">Action</div></th>
	   

      </tr>
	  
	 


	  
	  </thead>

	  <? 

  $sqls = 'select sl,xdate,ztime,xtime,bizid,overtime_hours,off_day,rate,amount
from overtime_input where bizid="'.$PBI_ID.'" and  xdate between "'.$start_date.'" and "'.$end_date.'" limit 1';

$querys = db_query($sqls);

$datas = mysqli_fetch_object($querys);





 $sql  = 'select sl,xdate,ztime,xtime,bizid,overtime_hours,off_day,rate,amount
from overtime_input where bizid="'.$PBI_ID.'" and  xdate between "'.$start_date.'" and "'.$end_date.'" group by xdate order by xdate asc';

$query = db_query($sql);

$off_dateno = $datas->off_day;

$off_days=${'day'.$datas->off_day};

while($data=mysqli_fetch_object($query)){

 $s = 'select sl,xdate,ztime,xtime,bizid,overtime_hours,off_day,rate,amount
from overtime_input where sl!="'.$data->sl.'" and bizid="'.$PBI_ID.'" and  xdate = "'.$data->xdate.'" order by xdate desc limit 1';

    $out = find_all_field_sql($s);

	$date = date('Ymd',strtotime($data->xdate));
	$info['sl'][$date] = $data->sl;
	$info['xdate'][$date] = $data->xdate;

	$info['ztime'][$date]=$data->ztime;

	$info['xtime'][$date]=strtotime($data->xtime);

	$info['start_time'][$date]=$data->start_time;

	$info['end_time'][$date]=$data->end_time;

	$info['off_day'][$date]=$data->off_day;

	$info['xtime'][$date]=$data->xtime;
	
	$info['overtime_hours'][$date]=$data->overtime_hours;
	$info['rate'][$date]=$data->rate;
	$info['amount'][$date]=$data->amount;

	$info['out_stamp'][$date]=$out->xtime;

	$in_time = date('H:i:s',$info['ztime'][$date]);

	//$out_time = date('H:i:s',$out->access_stamp);



	if(date('N',$info['xdate'][$date])==$datas->xdate)

	{$info['status'][$date] ='Off Day';$info['bgcolor'][$date] = '#FFF';}

	elseif($data->start_time == '')	{$info['status'][$date]='Regular'; $info['bgcolor'][$date] = '#EAFFEF'; ++$regular; }
    else {} 
	
	//$off_date = date('l',mktime(1,1,1,1,$info['off_day'][$date],2001));

    }
	
	
$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);
//echo $off_day;
foreach ( $period as $dt ){ ++$days;
//echo $thisdate;
$this_date = $dt->format( "Ymd" );
if($info['xdate'][$this_date]=='')
{
//echo date('N',$info['access_stamp'][$thisdate]);
if($dt->format( "N" )==$off_dateno)
{$info['status'][$this_date] ='Off Day';$info['bgcolor'][$this_date] = '#FFF';++$off_day;}
else {$info['status'][$this_date] ='Absent';$info['bgcolor'][$this_date] = '#FFECFF';$this_date;++$absent;}
}

//if($dt->format("l")==$off_date)

//{

//$info['status'][$this_date] ='Off Day';$info['bgcolor'][$this_date] = '#FFF';echo ++$off_day;

//}



?>

      <tr bgcolor="<?=$info['bgcolor'][$this_date]?>">

      <td><?=$datee = $dt->format( "Y-m-d" );?></td>

      <td><?=$dt->format("l");?></td>

      <td><? $abb = $info['status'][$this_date]; if($abb=="Absent"){
       $leave_out = find_a_field('hrm_leave_info','count(id)','1 and leave_date="'.$datee.'" and PBI_ID = "'.$PBI_ID.'"');
       $office_t_out = find_a_field('hrm_offical_tour','count(id)','1 and leave_date="'.$datee.'" and PBI_ID = "'.$PBI_ID.'"');
       if($leave_out>0){ echo "LEAVE"; }elseif($office_t_out>0){ echo "Official Tour";}else{echo $abb; }
       }else{ echo $abb; } ?>
	   
	   </td>

     <?php /*?> <td><? 

	  $ddd = strtotime($data->access_date.' '.$info['start_time'][$date]);

      $ddd1 = (int)$ddd;

	  echo 'IT-&nbsp;'.date('h:i A',($ddd1)).'

	  <Br>OT-'.date('h:i A',strtotime($data->access_date.' '.$info['end_time'][$date]));?></td><?php */?>

     <td><?=($info['ztime'][$this_date]>0)? date('d-M-Y H:i:s A',strtotime($info['ztime'][$this_date])) : ''; ?></td>
	 <td><?=($info['xtime'][$this_date]>0)? date('d-M-Y H:i:s A',strtotime($info['xtime'][$this_date])) : ''; ?></td>
	 <td><?=$info['overtime_hours'][$this_date];?></td> 
	 <td><?=($info['rate'][$this_date]>0)? number_format($info['rate'][$this_date]): '' ;?></td> 

      

	  <td><?=($info['amount'][$this_date]>0)? number_format($info['amount'][$this_date]) : '' ;?></td>
	  
	  <td><a href="edit_fetch.php?sl=<?=$info['sl'][$this_date];?>" class="btn1 btn1-bg-update" target="_blank"><i class="fa fa-edit">Edit</i></a></td>
	  

    </tr>

<? }?>

    <tr bgcolor="#FFFFFF">

      <td colspan="9"><br />

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <th bgcolor="#666666"><div align="center" class="style2">Total Days </div></th>

        <th bgcolor="#CC6666"><div align="center" class="style2">Off Day</span></th>

        <th bgcolor="#006600"><div align="center" class="style2">Regular</div></th>

        <th bgcolor="#FFCC00"><div align="center" class="style2">Late</div></th>

        <th bgcolor="#FF3300"><div align="center" class="style2">Absent</div></th>

        <th bgcolor="#336699"><div align="center" class="style2">Extra</div></th>

      </tr>



      <tr >

        <td bgcolor="#CCCCCC"><div align="center">

          <?=$days;?>

        </div></td>

        <td align="center" bgcolor="#CC99CC"><div align="center"><?=$off_days;?></div>

          <div align="center"></div></td>

        <td bgcolor="#33FF00"><div align="center">

          <?=$regular;?>

        </div></td>

        <td bgcolor="#FFFF99"><div align="center">

          <?=$late;?>

        </div></td>

        <td bgcolor="#FF9966"><div align="center">

          <?=$absent;?>

        </div></td>

        <td bgcolor="#33CCFF"><div align="center"><?=($days - ($regular+$late+$absent+$off_day));?></div></td>

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



<?

$main_content=ob_get_contents();
ob_end_clean();
require_once SERVER_CORE."routing/layout.bottom.php";

?>