<?php
session_start();
ob_start();
require_once "../../config/inc.all.php";
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','search_PBI_ID');
function auto_calculation($PBI_ID,$mon,$year,$search_PBI_ID=''){
$unique = 'id';

$days1=mktime(1,1,1,$mon,1,$year);
$days_mon=$td=date('t',$days1);
		if($search_PBI_ID>0) $con .= ' and PBI_ID='.$search_PBI_ID;

$start_date = $year.'-'.$mon.'-01';
$end_date = $year.'-'.$mon.'-'.$days_mon;
$hd=find_a_field('salary_holy_day','count(holy_day)','holy_day between "'.$start_date.'" and "'.$end_date.'"');
$$unique = find_a_field('hrm_attendence_final','id','PBI_ID="'.$PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');

if($$unique) db_delete('hrm_attendence_final','PBI_ID="'.$PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');
$sql = 'select 
 access_date, access_time, access_stamp, start_time, off_day 
from hrm_inout where 
employee_id="'.$PBI_ID.'" and access_date between "'.$start_date.'" and "'.$end_date.'" '.$con.' group by access_date order by access_stamp desc';
$query = mysql_query($sql);
while($data=mysql_fetch_object($query)){
$date = date('Ymd',$data->access_stamp);
$info['access_date'][$date]=$data->access_date;
$info['access_time'][$date]=$data->access_time;
$info['access_stamp'][$date]=$data->access_stamp;
$info['start_time'][$date]=$data->start_time;
$info['off_day'][$date]=$data->off_day;

$in_time = date('H:i:s',$data->access_stamp);
if($data->start_time=='')
{$info['status'][$date]='Regular';$info['bgcolor'][$date] = '#EAFFEF';++$regular;}
else{
$info['late'][$date] = (int)(($data->access_stamp - strtotime($data->access_date.' '.$data->start_time))/60);
if($info['late'][$date]>0) {++$late;$info['status'][$date]='Late';$info['bgcolor'][$date] = '#FFFFCC';} else {++$regular;$info['status'][$date]='Regular';$info['bgcolor'][$date] = '#EAFFEF';}
}
$info['off_day'][$date]=$data->off_day;
}
$lt = $late;
$ab = $days_mon - ($late + $regular);


$pre = $days_mon - ($ab + $hd);
$pay = $days_mon - ($ab + ((int)($lt/3)));

$entry_by=$_SESSION['user']['id'];
$entry_at=date('Y-m-d h:i:s');


			$leave_days = 0;

			$lsql = 'select * from hrm_leave_info where PBI_ID="'.$info->PBI_ID.'" and 
			((s_date<="'.$startday.'" and e_date>="'.$startday.'") or 
			(s_date>="'.$startday.'" and e_date<="'.$endday.'") or 
			(s_date<="'.$endday.'" and e_date>="'.$endday.'"))';
			$qquery = mysql_query($lsql);
			while($le = mysql_fetch_object($qquery))
			{
						$leave_day = 0;
			if(($le->s_date<=$startday)&&($le->e_date>=$startday))
			{
				$start_date = $startday;
				if($le->e_date>=$endday) $end_date = $endday;
				else $end_date = $le->e_date;
				
				
$date1=date_create($start_date);
$date2=date_create($end_date);
$diff=date_diff($date1,$date2);

$leave_day = $diff->format("%a") +1 ;

$leave_days = $leave_days + $leave_day;
			}
			elseif(($le->s_date>=$startday)&&($le->e_date<=$endday))
			{
				$start_date = $le->s_date;
				$end_date = $le->e_date;
$date1=date_create($start_date);
$date2=date_create($end_date);
$diff=date_diff($date1,$date2);

$leave_day = $diff->format("%a") +1 ;
$leave_days = $leave_days + $leave_day;
			}
			elseif(($le->s_date<=$startday)&&($le->e_date>=$endday))
			{
				$start_date = $startday;
				$end_date = $endday;
$date1=date_create($start_date);
$date2=date_create($end_date);
$diff=date_diff($date1,$date2);

$leave_day = $diff->format("%a") +1 ;
$leave_days = $leave_days + $leave_day;
			}
			elseif(($le->s_date<=$endday)&&($le->e_date>=$endday))
			{
				$start_date = $le->s_date;
				$end_date = $endday;
$date1=date_create($start_date);
$date2=date_create($end_date);
$diff=date_diff($date1,$date2);

$leave_day = $diff->format("%a") +1 ;
$leave_days = $leave_days + $leave_day;
			}
			else
			echo 'doom';
			}

$liv = ($data->lv=='')?$leave_days:$data->lv;



mysql_query("insert into hrm_attendence_final 
(mon, `year`, PBI_ID, lv,td,ab,hd, pre, pay, entry_by, entry_at) values 
(".$mon.", ".$year.",".$PBI_ID.", ".$liv.",".$td.",".$ab.",".$hd.", ".$pre.",  ".$pay.",".$entry_by.", '".$entry_at."')");

}
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
if(isset($_POST['auto']))
{

$area=$_POST['area'];
$PBI_ID = $_REQUEST['PBI_ID'];
$mon = $_REQUEST['mon'];
$year = $_REQUEST['year'];

		$sql = "select PBI_ID from personnel_basic_info where PBI_DOMAIN='".$area."' and PBI_JOB_STATUS='1' order by PBI_ID ";
		$query = mysql_query($sql);
		while($info=mysql_fetch_object($query))
		{
		auto_calculation($info->PBI_ID,$mon,$year,$search_PBI_ID);
		}
}


?>

<script>

function getXMLHTTP() { //fuction to return the xml http object

		var xmlhttp=false;	

		try{

			xmlhttp=new XMLHttpRequest();

		}

		catch(e)	{		

			try{			

				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){

				try{

				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");

				}

				catch(e1){

					xmlhttp=false;

				}

			}

		}

		 	

		return xmlhttp;

    }

	function update_value(id)
	{
var PBI_ID=id; // Rent
var td=(document.getElementById('td_'+id).value)*1; // Other
var od=(document.getElementById('od_'+id).value)*1; // Rent + Other
var hd=(document.getElementById('hd_'+id).value)*1; // Paid
var lt=document.getElementById('lt_'+id).value; 
var ab=document.getElementById('ab_'+id).value;
var lv=document.getElementById('lv_'+id).value;
var pre=(document.getElementById('pre_'+id).value)*1; // Due
var pay=document.getElementById('pay_'+id).value;
var ot=document.getElementById('ot_'+id).value;

var mon=document.getElementById('mon').value;
var year=document.getElementById('year').value;
var area=document.getElementById('area').value;
var flag=document.getElementById('flag_'+id).value;

var strURL="monthly_attendence_ajax.php?PBI_ID="+PBI_ID+"&td="+td+"&od="+od+"&hd="+hd+"&lt="+lt+"&ab="+ab+"&lv="+lv+"&pre="+pre+"&pay="+pay+"&ot="+ot+"&mon="+mon+"&year="+year+"&area="+area+"&flag="+flag;

		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {

			

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+id).style.display='inline';

						document.getElementById('divi_'+id).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			

						

			req.open("GET", strURL, true);

			req.send(null);

		}	

}

	function cal_all(id)

	{
var PBI_ID=id; // Rent
var td=(document.getElementById('td_'+id).value)*1; // Other
var od=(document.getElementById('od_'+id).value)*1; // Rent + Other
var hd=(document.getElementById('hd_'+id).value)*1; // Paid
var lt=(document.getElementById('lt_'+id).value)*1; 
var ab=(document.getElementById('ab_'+id).value)*1;
var lv=(document.getElementById('lv_'+id).value)*1;

var ltd=lt/3; 
var ltdd=Math.floor(ltd);
var pre=td - (od + hd + ab + lv);
var pay=td - ab - ltdd;
document.getElementById('pay_'+id).value=pay;
document.getElementById('pre_'+id).value=pre;
	}
</script>
<form action=""  method="post">
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

          <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
<table width="100%" border="0" class="oe_list_content"><thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Monthly Attendence Entry</span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>

  <tr  class="alt">
    <td width="40%" align="right"><strong>Month :</strong></td><td width="10%" align="left"><span class="oe_form_group_cell">
      <select name="mon" style="width:160px;" id="mon" required>
	     <option value="0" <?=($_POST['mon']=='0')?'selected':''?>></option>
        <option value="1" <?=($_POST['mon']=='1')?'selected':''?>>Jan</option>
        <option value="2" <?=($_POST['mon']=='2')?'selected':''?>>Feb</option>
        <option value="3" <?=($_POST['mon']=='3')?'selected':''?>>Mar</option>
        <option value="4" <?=($_POST['mon']=='4')?'selected':''?>>Apr</option>
        <option value="5" <?=($_POST['mon']=='5')?'selected':''?>>May</option>
        <option value="6" <?=($_POST['mon']=='6')?'selected':''?>>Jun</option>
        <option value="7" <?=($_POST['mon']=='7')?'selected':''?>>Jul</option>
        <option value="8" <?=($_POST['mon']=='8')?'selected':''?>>Aug</option>
        <option value="9" <?=($_POST['mon']=='9')?'selected':''?>>Sep</option>
        <option value="10" <?=($_POST['mon']=='10')?'selected':''?>>Oct</option>
        <option value="11" <?=($_POST['mon']=='11')?'selected':''?>>Nov</option>
        <option value="12" <?=($_POST['mon']=='12')?'selected':''?>>Dec</option>
      </select>
      </span></td>
    <td width="40%" align="right"><strong>Year :</strong></td>
    <td width="10%"><select name="year" style="width:160px;" id="year" required>
	  <option <?=($_POST['year']=='0')?'selected':''?>></option>
      <option <?=($_POST['year']=='2015')?'selected':''?>>2015</option>
      <option <?=($_POST['year']=='2016')?'selected':''?>>2016</option>
      <option <?=($_POST['year']=='2017')?'selected':''?>>2017</option>
      <option <?=($_POST['year']=='2018')?'selected':''?>>2018</option>
    </select></td>
  </tr>
  <tr >
    <td align="right">Employee ID:(Optional) </td>
    <td align="left"><input name="search_PBI_ID"  type="text" id="search_PBI_ID" size="10" onblur="" tabindex="1" style="width:200px;" value="<?=$_POST['search_PBI_ID']?>" /></td>
    <td align="right"><strong>Company Name  :</strong></td>
    <td><span class="oe_form_group_cell">
<select name="area" style="width:160px;" id="area" required>
<? foreign_relation('domai','DOMAIN_CODE','DOMAIN_DESC',$_POST['area']);?>
</select>
</span></td>
  </tr>
  </tbody></table>
<br /><div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><input name="create" type="submit" id="create" value="Attendence Sheet" /></th>
  </tr>
  </thead>
  <tfoot>
  </tfoot>
  <tbody>
    </tbody>
</table>
<div class="oe_form_sheetbg">
        <div class="oe_form_sheet oe_form_sheet_width">

          <div class="oe_view_manager_view_list"><div class="oe_list oe_view">
          
		<table width="100%" class="oe_list_content"><thead><tr class="oe_list_header_columns" style="font-size:10px;padding:3px;">
        <th>Code</th>
        <th>Full Name</th>
        <th>Desg</th>
        <th>Dept</th>
        <th>TD</th>
        <th>OD</th>
        <th>HD</th>
        <th>LT</th>
        <th>AB</th>
        <th>LV</th>
        <th>Pre</th>
        <th>Pay</th>
        <th>OT</th>
        <th>&nbsp;</th>
        </tr>
		</thead>
        <tbody>
        <? 
$mon = $_REQUEST['mon'];
$year = $_REQUEST['year'];
$startTime = $days1=mktime(1,1,1,$mon,1,$year);
$days_mon=date('t',$days1);
$endTime = $days2=mktime(1,1,1,$mon,$days_mon,$year);

		
$startday = date('Y-m-d',$startTime);
$endday = date('Y-m-d',$endTime);	
		



for ($i = $startTime; $i <= $endTime; $i = $i + 86400) {
$day   = date('l',$i);
${'day'.date('N',$i)}++;
if(isset($$day))
$$day .= ',"'.date('Y-m-d', $i).'"';
else
$$day .= '"'.date('Y-m-d', $i).'"';
}
$r_count=${'day5'};

		$holy_day=find_a_field('salary_holy_day','count(holy_day)','holy_day between "'.$year.'-'.$mon.'-'.'01'.'" and "'.$year.'-'.$mon.'-'.$days_mon.'"');
		
		if($_POST['search_PBI_ID']>0) $con .= ' and a.PBI_ID='.$_POST['search_PBI_ID'];
		$sql = "select a.PBI_NAME,a.PBI_ID,c.DESG_DESC,d.DEPT_DESC from personnel_basic_info a,designation c, department d where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_DOMAIN='".$_POST['area']."'".$con." and a.PBI_JOB_STATUS='1' order by a.PBI_ID ";
		$query = mysql_query($sql);
		while($info=mysql_fetch_object($query))
		{
		$data = find_all_field('hrm_attendence_final','','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');

		if($data->td>0)
		{
			$status='RE-CAL';
		}
		else
		{
			//$leave = find_all_field('hrm_attendence_final','','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');
			$status='CAL';
			$pay = $days_mon;
			$pre = $days_mon - ($holy_day + $r_count);

			$leave_days = 0;

			$lsql = 'select * from hrm_leave_info where PBI_ID="'.$info->PBI_ID.'" and 
			((s_date<="'.$startday.'" and e_date>="'.$startday.'") or 
			(s_date>="'.$startday.'" and e_date<="'.$endday.'") or 
			(s_date<="'.$endday.'" and e_date>="'.$endday.'"))';
			$qquery = mysql_query($lsql);
			while($le = mysql_fetch_object($qquery))
			{
						$leave_day = 0;
			if(($le->s_date<=$startday)&&($le->e_date>=$startday))
			{
				$start_date = $startday;
				if($le->e_date>=$endday) $end_date = $endday;
				else $end_date = $le->e_date;
				
				
$date1=date_create($start_date);
$date2=date_create($end_date);
$diff=date_diff($date1,$date2);

$leave_day = $diff->format("%a") +1 ;

$leave_days = $leave_days + $leave_day;
			}
			elseif(($le->s_date>=$startday)&&($le->e_date<=$endday))
			{
				$start_date = $le->s_date;
				$end_date = $le->e_date;
$date1=date_create($start_date);
$date2=date_create($end_date);
$diff=date_diff($date1,$date2);

$leave_day = $diff->format("%a") +1 ;
$leave_days = $leave_days + $leave_day;
			}
			elseif(($le->s_date<=$startday)&&($le->e_date>=$endday))
			{
				$start_date = $startday;
				$end_date = $endday;
$date1=date_create($start_date);
$date2=date_create($end_date);
$diff=date_diff($date1,$date2);

$leave_day = $diff->format("%a") +1 ;
$leave_days = $leave_days + $leave_day;
			}
			elseif(($le->s_date<=$endday)&&($le->e_date>=$endday))
			{
				$start_date = $le->s_date;
				$end_date = $endday;
$date1=date_create($start_date);
$date2=date_create($end_date);
$diff=date_diff($date1,$date2);

$leave_day = $diff->format("%a") +1 ;
$leave_days = $leave_days + $leave_day;
			}
			else
			echo 'doom';
			}

		}
		?>
        <tr style="font-size:10px; padding:3px; "><td><?=$info->PBI_ID?>
          <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>
		  <td><?=$info->PBI_NAME?></td>
		  <td><?=$info->DESG_DESC?></td>
		  <td><?=$info->DEPT_DESC?></td>
		  <td align="center"><input name="td_<?=$info->PBI_ID?>" type="text" id="td_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" value="<?=$days_mon?>" size="2" maxlength="2" readonly="readonly" /></td>
          <td align="center"><input name="od_<?=$info->PBI_ID?>" type="text" id="od_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" size="2" maxlength="2" readonly="readonly" value="<?=$r_count?>" /></td>
          <td align="center"><input name="hd_<?=$info->PBI_ID?>" type="text" id="hd_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" size="2" maxlength="2" readonly="readonly" value="<?=$holy_day?>" /></td>
          <td align="center"><input name="lt_<?=$info->PBI_ID?>" type="text" id="lt_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" value="<?=$data->lt?>" size="2" maxlength="2" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>
          <td align="center"><input name="ab_<?=$info->PBI_ID?>" type="text" id="ab_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" value="<?=$data->ab?>" size="2" maxlength="2"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>
          <td align="center"><input name="lv_<?=$info->PBI_ID?>" type="text" id="lv_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" value="<?=($data->lv=='')?$leave_days:$data->lv;?>" size="2" maxlength="2"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>
<td align="center"><input name="pre_<?=$info->PBI_ID?>" type="text" id="pre_<?=$info->PBI_ID?>" style="font-size:10px; width:25px; min-width:20px;" onchange="cal_all(<?=$info->PBI_ID?>)" value="<?=(($data->pre<1)?$pre:$data->pre);?>" size="2" maxlength="2" readonly="readonly" /></td>
<td align="center"><input name="pay_<?=$info->PBI_ID?>" type="text" id="pay_<?=$info->PBI_ID?>" style="font-size:10px; width:25px; min-width:20px;" value="<?=(($data->pay<1)?$pay:$data->pay);?>" size="2" maxlength="2" readonly="readonly" /></td>
          <td align="center"><input name="ot_<?=$info->PBI_ID?>" type="text" id="ot_<?=$info->PBI_ID?>" style="font-size:10px; width:25px; min-width:20px;" value="<?=$data->ot?>" size="2" maxlength="2" /></td>
          <td align="center"><span id="divi_<?=$info->PBI_ID?>">
            <? 
			  if($status=='RE-CAL')
			  {
			  if($_SESSION['user']['level']==5)
			  {?>
			  <input type="hidden" name="flag_<?=$info->PBI_ID?>" id="flag_<?=$info->PBI_ID?>" value="1" />
			  <input type="button" name="Button" value="<?=$status?>"  onclick="update_value(<?=$info->PBI_ID?>)" style="font-size:10px;"/><?
			  }
			  else echo 'Sucessful!';
			  }
			  else
			  {
			  ?>
			  <input type="hidden" name="flag_<?=$info->PBI_ID?>" id="flag_<?=$info->PBI_ID?>" value="0" />
			  <input type="button" name="Button" value="<?=$status?>"  onclick="update_value(<?=$info->PBI_ID?>)" style="font-size:10px;"/>
			  <? }?>
          </span>&nbsp;</td>
          </tr>
        <?
		}
		?>
        </tbody>
        
        <tfoot>
        <tr><td></td><td></td><td></td><td></td><td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          </tr>
        </tfoot>
        </table>          
          </div></div>
          </div>
    </div>
<p>
  <input name="auto" type="submit" id="auto" value="CALCULATE ALL" />
</p>
  </div></div></div>
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