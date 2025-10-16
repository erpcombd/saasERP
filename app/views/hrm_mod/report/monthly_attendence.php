<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
error_reporting(0);
if(isset($_POST['create']))
{
	$mon=$_POST['mon'];
	$dept=$_POST['dept'];
	$year=$_POST['year'];
	$bonus=$_POST['bonus'];
}else{
$mon=date('n');
$year=date('Y');
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
	function delete_value(id)

	{



var PBI_ID=id; // Rent
var fd=(document.getElementById('fd').value)*1; // Other
var td=(document.getElementById('td_'+id).value)*1; // Other
var od=(document.getElementById('od_'+id).value)*1; // Rent + Other
var hd=(document.getElementById('hd_'+id).value)*1; // Paid
var lt=document.getElementById('lt_'+id).value; 
var ab=document.getElementById('ab_'+id).value;
var lv=document.getElementById('lv_'+id).value;
var lwp=document.getElementById('lwp_'+id).value;
var pre=(document.getElementById('pre_'+id).value)*1; // Due
var pay=document.getElementById('pay_'+id).value;
var ot=document.getElementById('ot_'+id).value;
var deduction=document.getElementById('deduction_'+id).value;
var benefits=document.getElementById('benefits_'+id).value;

var mon=document.getElementById('mon').value;
var year=document.getElementById('year').value;
var bonus=document.getElementById('bonus').value;


var strURL="monthly_attendence_delete_ajax.php?PBI_ID="+PBI_ID+"&td="+td+"&fd="+fd+"&od="+od+"&hd="+hd+"&lt="+lt+"&ab="+ab+"&lv="+lv+"&lwp="+lwp+"&pre="+pre+"&pay="+pay+"&ot="+ot+"&deduction="+deduction+"&mon="+mon+"&year="+year+"&bonus="+bonus+"&benefits="+benefits;

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
	function update_value(id)

	{



var PBI_ID=id; // Rent
var fd=(document.getElementById('fd').value)*1; // Other
var td=(document.getElementById('td_'+id).value)*1; // Other
var od=(document.getElementById('od_'+id).value)*1; // Rent + Other
var hd=(document.getElementById('hd_'+id).value)*1; // Paid
var lt=document.getElementById('lt_'+id).value; 
var ab=document.getElementById('ab_'+id).value;
var lv=document.getElementById('lv_'+id).value;
var lwp=document.getElementById('lwp_'+id).value;
var pre=(document.getElementById('pre_'+id).value)*1; // Due
var pay=document.getElementById('pay_'+id).value;
var ot=document.getElementById('ot_'+id).value;
var deduction=document.getElementById('deduction_'+id).value;
var benefits=document.getElementById('benefits_'+id).value;
var other_benefits=document.getElementById('other_benefits_'+id).value;

var mon=document.getElementById('mon').value;
var year=document.getElementById('year').value;
var bonus=document.getElementById('bonus').value;


var strURL="monthly_attendence_ajax.php?PBI_ID="+PBI_ID+"&td="+td+"&fd="+fd+"&od="+od+"&hd="+hd+"&lt="+lt+"&ab="+ab+"&lv="+lv+"&lwp="+lwp+"&pre="+pre+"&pay="+pay+"&ot="+ot+"&deduction="+deduction+"&mon="+mon+"&year="+year+"&bonus="+bonus+"&benefits="+benefits+"&other_benefits="+other_benefits;

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
var lwp=(document.getElementById('lwp_'+id).value)*1;

var ltd=lt; 
var ltdd=ltd;
var pre=td - (od + hd + ab + lv + lwp);
var pay=td - ab - lwp;
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
  <th colspan="6"><span style="text-align: center; font-size:18px; color:#09F">Final Payroll Process </span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="6"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>

  <tr  class="alt">
    <td align="right"><strong>Year:</strong></td>
    <td><select name="year" style="width:160px;" id="year" required="required">
        <option <?=($year=='2017')?'selected':''?>>2017</option>
    </select></td>
    <td align="right"><strong>Department:</strong></td>
    <td colspan="3"><span class="oe_form_group_cell">
      <select name="dept" style="width:160px;" id="dept">
        <?=foreign_relation('department','DEPT_SHORT_NAME','DEPT_DESC',$_POST['dept'],' 1 order by DEPT_DESC asc');?>
      </select>
    </span></td>
  </tr>
  <tr >
    <td align="right" class="alt">Concern Company :</td>
    <td align="left" class="alt"><span class="oe_form_group_cell">
      <select name="PBI_ORG" style="width:160px;" id="PBI_ORG" required>
        <?=foreign_relation('user_group','id','group_name',$_POST['PBI_ORG']);?>
      </select>
    </span></td>
    <td align="right"><strong>Section:</strong></td>
    <td colspan="3"><span class="oe_form_group_cell"><strong>
      <select name="PBI_DOMAIN">
        <? foreign_relation('domai','DOMAIN_DESC','DOMAIN_DESC',$_POST['PBI_DOMAIN']);?>
      </select>
    </strong></span></td>
    </tr>
  <tr >
    <td align="right" class="alt"><strong>Month:</strong></td>
    <td align="left" class="alt"><span class="oe_form_group_cell">
      <select name="mon" style="width:160px;" id="mon" required="required">
<!--        <option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>
        <option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>
        <option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>
        <option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>
      <option value="5" <?=($mon=='5')?'selected':''?>>May</option> -->
        <option value="6" <?=($mon=='6')?'selected':''?>>Jun</option><!-- 
        <option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>
        <option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>
        <option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>
        <option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>
        <option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>
        <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>-->
      </select>
    </span></td>
    <td align="right"><strong>Region: </strong></td>
    <td><span class="oe_form_group_cell">
      <select name="PBI_BRANCH" id="PBI_BRANCH">
        <? 
		foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$_POST['PBI_BRANCH'],' 1 order by BRANCH_NAME');?>
      </select>
    </span></td>
    <td><div align="right"><strong>Zone: </strong></div></td>
    <td><span class="oe_form_group_cell">
      <select name="PBI_ZONE" id="PBI_ZONE">
        <? 
		foreign_relation('zon','ZONE_CODE','ZONE_NAME',$_POST['PBI_ZONE'],' 1 order by ZONE_NAME');?>
      </select>
    </span></td>
  </tr>
  <tr >
    <td align="right"><strong>Bonus Month (?):</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="bonus" style="width:160px;" id="bonus" required="required">
        <option <?=($bonus=='No')?'selected':''?>>No</option>
        <option <?=($bonus=='Yes')?'selected':''?>>Yes</option>
      </select>
    </span></td>
    <td align="right"><strong>Job Location: </strong></td>
    <td><span class="oe_form_group_cell">
      <select name="JOB_LOCATION" id="JOB_LOCATION">
        <? foreign_relation('office_location','ID','LOCATION_NAME',$_POST['JOB_LOCATION'],'1');?>
      </select>
    </span></td>
    <td><div align="right"><strong>Group</strong>:</div></td>
    <td><span class="oe_form_group_cell">
      <select name="PBI_GROUP" id="PBI_GROUP" style="">
        <? foreign_relation('product_group','group_name','group_name',$_POST['PBI_GROUP']);?>
      </select>
    </span></td>
  </tr>
  <tr >
    <td align="right">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><strong>PBI ID IN:</strong></td>
    <td><input name="pbi_id_in" type="text" id="pbi_id_in" value="<?=$_POST['pbi_id_in']?>" /></td>
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
          <? if(isset($_POST['create'])){?>
		<table width="100%" class="oe_list_content"><thead><tr class="oe_list_header_columns" style="font-size:10px;padding:3px;">
        <th>S/L</th>
        <th>Code</th>
        <th>Full Name</th>
        <th>Desg</th>
        <th>Dept</th>
        <th>Dealer Info</th>
        <th>TD</th>
        <th>OD</th>
        <th>HD</th>
        <th>LT</th>
        <th>AB</th>
        <th>LWP</th>
        <th>LV</th>
        <th>Pre</th>
        <th>Pay</th>
        <th>Dealer Code</th>
        <th>Mob Ded</th>
        <th>Arear</th>
        <th>Other</th>
        <th>&nbsp;</th>
        </tr>
		</thead>
        <tbody>
        <? 
//$startTime = $days1=mktime(0,0,0,($mon-1),26,$year);
//$endTime = $days2=mktime(0,0,0,$mon,25,$year);

if($_POST['dept']=='Sales'&&$_POST['JOB_LOCATION']!='1'){
$startTime = $days1=mktime(0,0,0,($mon-1),26,$year);
$endTime = $days2=mktime(0,0,0,$mon,25,$year);

$days_in_month = $days_mon = date('t',$startTime);

$startTime1 = $days1=mktime(0,0,0,($mon),26,$year);
$endTime1 = $days2=mktime(0,0,0,$mon,25,$year);

$start_date =$starting_date = $startday = date('Y-m-d',$startTime);
$end_date =$ending_date = $endday = date('Y-m-d',$endTime);
}
else{
$startTime = $days1=mktime(0,0,0,$mon,01,$year);
$endTime = $days2=mktime(0,0,0,$mon,date('t',$startTime),$year);

$days_in_month = $days_mon = date('t',$startTime);

$startTime1 = $days1=mktime(0,0,0,($mon),01,$year);
$endTime1 = $days2=mktime(0,0,0,$mon,$days_in_month,$year);

$start_date =$starting_date = $startday = date('Y-m-d',$startTime);
$end_date =$ending_date = $endday = date('Y-m-d',$endTime);
}



for ($i = $startTime1; $i <= $endTime1; $i = $i + 86400) {
$day   = date('l',$i);
${'day'.date('N',$i)}++;

//if(isset($$day))
//$$day .= ',"'.date('Y-m-d', $i).'"';
//else
//$$day .= '"'.date('Y-m-d', $i).'"';
}
$r_count=${'day5'};
?>
<input name="fd" type="hidden" id="fd" value="<?=$r_count;?>" />
<?		
		
		
		$holy_day=find_a_field('salary_holy_day','count(holy_day)','holy_day between "'.$year.'-'.$mon.'-'.'01'.'" and "'.$year.'-'.$mon.'-'.$days_mon.'"');
		if($_POST['PBI_BRANCH']!='')	$con .= " and PBI_BRANCH = '".$_POST['PBI_BRANCH']."'";
		if($_POST['PBI_ZONE']!='')		$con .= " and PBI_ZONE = '".$_POST['PBI_ZONE']."'";
		if($_POST['PBI_GROUP']!='')		$con .= " and PBI_GROUP = '".$_POST['PBI_GROUP']."'";
		if($_POST['PBI_DOMAIN']!='')	$con .= " and PBI_DOMAIN = '".$_POST['PBI_DOMAIN']."'";
		if($_POST['JOB_LOCATION']!='')  $con .= " and JOB_LOCATION = '".$_POST['JOB_LOCATION']."'";
		if($_POST['pbi_id_in']!='')     $con .= " and p.PBI_ID in (".$_POST['pbi_id_in'].")";
		if($_POST['dept']!='')     $con .= " and p.PBI_DEPARTMENT = '".$_POST['dept']."'";
		//echo $jday=date('d').' <br>';
		//$j_date=date('Y-m-d',mktime(0,0,0,$_POST['mon'],31,$_POST['year']));
		$sql = "select p.* from personnel_basic_info p, salary_info s where p.PBI_ID=s.PBI_ID and p.PBI_JOB_STATUS='In Service'  and p.PBI_ORG='".$_POST['PBI_ORG']."' ".$con."  order by (s.basic_salary+s.consolidated_salary) desc";
		
		$query = db_query($sql);
		while($info=mysqli_fetch_object($query))
		{
$leave_days_lv = 0;
$leave_days_lwp = 0;
		$new_emp_days = 0;
		$new_emp_off = 0;
		$new_emp_holy_day = 0;
		if(strtotime($info->PBI_DOJ)>strtotime($starting_date))
		{
		$new_emp_days =ceil(($endTime - strtotime($info->PBI_DOJ))/(3600*24))+1;
		$new_emp_holy_day=find_a_field('salary_holy_day','count(holy_day)','holy_day between "'.$info->PBI_DOJ.'" and "'.$year.'-'.$mon.'-'.$days_mon.'"');
		${'day5'} = 0 ; for ($i = strtotime($info->PBI_DOJ); $i <= $endTime1; $i = $i + 86400) {$day   = date('l',$i);${'day'.date('N',$i)}++;}
		$new_emp_off=${'day5'};
		}


			
if(strtotime($info->PBI_DOJ) > strtotime($startday)){$startday=date('Y-m-d',strtotime($info->PBI_DOJ));}
else $startday = date('Y-m-d',$startTime);
$leave_days = 0;

$lsql = 'select * from hrm_leave_info where PBI_ID="'.$info->PBI_ID.'" and 
((s_date<="'.$startday.'" and e_date>="'.$startday.'" and e_date!="0000-00-00") or 
(s_date>="'.$startday.'" and e_date<="'.$endday.'" and e_date!="0000-00-00" ) or 
(s_date between "'.$startday.'" and "'.$endday.'" and total_days="0.5") or 
(s_date<="'.$endday.'" and e_date>="'.$endday.'" and e_date!="0000-00-00"))';
$qquery = db_query($lsql);
while($le = mysqli_fetch_object($qquery))
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
 $leave_day = $diff->d +1 ;

$leave_days = $leave_days + $leave_day;
}
elseif(($le->s_date>=$startday)&&($le->e_date<=$endday))
{
$start_date = $le->s_date;
$end_date = $le->e_date;


$date1=date_create($start_date);
$date2=date_create($end_date);
$diff=date_diff($date1,$date2);

if($le->total_days=='0.5')
$leave_day = .5 ;
else $leave_day = $diff->d + 1 ;
$leave_days = $leave_days + $leave_day;
			}
			elseif(($le->s_date<=$startday)&&($le->e_date>=$endday))
			{
				$start_date = $startday;
				$end_date = $endday;
$date1=date_create($start_date);
$date2=date_create($end_date);
$diff=date_diff($date1,$date2);

$leave_day = $diff->d +1 ;
$leave_days = $leave_days + $leave_day;
			}
			elseif(($le->s_date<=$endday)&&($le->e_date>=$endday))
			{
$start_date = $le->s_date;
$end_date = $endday;
$date1=date_create($start_date);
$date2=date_create($end_date);
$diff=date_diff($date1,$date2);

$leave_day = $diff->d +1 ;
$leave_days = $leave_days + $leave_day;
			}
			else
			echo 'doom';
			}

$leave_days_lwp = 0;
$leave_days_lv =  0;
//echo '<br>'.$info->PBI_ID.' - ';
//echo $startday.' - ';
//echo $info->PBI_DUE_DOJ;
if($startday>$info->PBI_DUE_DOJ)
{
$leave_days_lwp = 0;
$leave_days_lv = $leave_days;}
else
{
$leave_days_lwp = $leave_days;
$leave_days_lv = 0;}


$mobile_bills = find_a_field('hrm_moblie_bill','mobile_bill','emp_id="'.$info->PBI_ID.'" and `month`="'.$mon.'" and `year`="'.$year.'" ');
if(@$att->od=='') @$att->od = $r_count;




		$data = find_all_field('salary_attendence','','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');
		if($data->td>0)
		{
			$status='Edit';
		}
		else
		{
			if($info->special_attendence==0)
			{
			$att = find_all_field('hrm_attendence_final','','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');
			}
			else
			{
			$att->lt = 0;
			$att->ab = 0;
			$att->lv = 0;
			$att->ot = 0;
			
			$att->pay = $days_mon;
			$att->pre = $days_mon - ($holy_day + $r_count);
			}
			$status='Save';
			$pay = $days_mon;
			$pre = $days_mon - ($holy_day + $r_count);
		}
			


?>
        <tr style="font-size:10px; padding:3px; "><td><?=++$S?></td>
          <td><?=$info->PBI_ID?>
            <input name="dept_<?=$info->PBI_ID?>" type="hidden" id="dept_<?=$info->PBI_ID?>"  value="<?=$info->PBI_DEPARTMENT;?>" />
            <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>
          <td><?=$info->PBI_NAME?></td><td><? ($data->pbi_designation!='')?$desg_id=$data->pbi_designation:$desg_id=$info->DESG_ID; echo find_a_field('designation','DESG_SHORT_NAME','DESG_ID='.$desg_id)?></td><td><?=$info->PBI_DEPARTMENT?></td>
          <td align="center"><?
          $res = "select concat(a.AREA_NAME,'-',d.dealer_name_e) dealer from area a, dealer_info d where a.AREA_CODE=d.area_code and d.dealer_code=".$data->dealer_code;
		  $resq = @db_query($res);
		  $res_data = @mysqli_fetch_object($resq); echo $res_data->dealer; ?></td>
          <td align="center"><input name="td_<?=$info->PBI_ID?>" type="text" id="td_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" 
value="<? if($data->td==0){if($att->td>0) echo $att->td; else {if($new_emp_days>0) echo $new_emp_days; else echo $days_mon;}} else echo $data->td;?>" size="2" maxlength="2" readonly="readonly" /></td>
<td align="center"><input name="od_<?=$info->PBI_ID?>" type="text" id="od_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" size="2" maxlength="2" value="<?=($data->od=='')?$att->od:$data->od;?>" /></td>
<td align="center"><input name="hd_<?=$info->PBI_ID?>" type="text" id="hd_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" size="2" maxlength="2" value="<?=($data->hd=='')?$att->hd:$data->hd;?>" /></td>
<td align="center"><input name="lt_<?=$info->PBI_ID?>" type="text" id="lt_<?=$info->PBI_ID?>" style="font-size:10px; width:40px; min-width:40px;" value="<?=($data->lt=='')?$att->lt:$data->lt;?>" size="2" maxlength="2" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>
<td align="center"><input name="ab_<?=$info->PBI_ID?>" type="text" id="ab_<?=$info->PBI_ID?>" style="font-size:10px; width:40px; min-width:40px;" value="<?=($data->ab=='')?$att->ab:$data->ab;?>" size="2" maxlength="2"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>
<td align="center"><input name="lwp_<?=$info->PBI_ID?>" type="text" id="lwp_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:28px;" value="<?=($data->lwp=='')?$att->lwp:$data->lwp;?>" size="4" maxlength="4"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>
<td align="center"><input name="lv_<?=$info->PBI_ID?>" type="text" id="lv_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:28px;" value="<?=($data->lv=='')?$att->lv:$data->lv;?>" size="4" maxlength="4"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>
<td align="center"><input name="pre_<?=$info->PBI_ID?>" type="text" id="pre_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:20px;" onchange="cal_all(<?=$info->PBI_ID?>)" value="<?=($data->pre=='')?$att->pre:$data->pre;?>" size="2" maxlength="2" readonly="readonly" /></td>
<td align="center"><input name="pay_<?=$info->PBI_ID?>" type="text" id="pay_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:20px;" value="<?=($data->pay=='')?$att->pay:$data->pay;?>" size="2" maxlength="2" readonly="readonly" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>
<td align="center"><input name="ot_<?=$info->PBI_ID?>" type="text" id="ot_<?=$info->PBI_ID?>" style="font-size:10px; width:45px; min-width:45px;" value="<?=$data->dealer_code?>" size="2" maxlength="10" /></td>
<td align="center"><input name="deduction_<?=$info->PBI_ID?>" type="text" id="deduction_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:20px;" 
 value="<?=$mobile_bills?>" size="8" maxlength="8" readonly="readonly" /></td>
          <td align="center"><input name="benefits_<?=$info->PBI_ID?>" type="text" id="benefits_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:20px;" value="<?=$data->benefits?>" size="8" maxlength="8" /></td>
          <td align="center"><input name="other_benefits_<?=$info->PBI_ID?>" type="text" id="other_benefits_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:20px;" value="<?=$data->other_benefits?>" size="8" maxlength="8" /></td>
          <td align="center"><span id="divi_<?=$info->PBI_ID?>">
            <? 
			
			  if($status=='Edit')
			  {
			  if($_SESSION['user']['level']==5||$_SESSION['user']['level']==2)
			  {?><input type="button" name="Button" value="<?=$status?>"  onclick="cal_all(<?=$info->PBI_ID?>), update_value(<?=$info->PBI_ID?>)" style="font-size:10px;"/>
			    <input type="button" name="Button" value="Delete"  onclick="delete_value(<?=$info->PBI_ID?>)" style="font-size:10px;"/><?
			  }
			  else echo 'Saved';
			  }
			  else
			  {
			  ?><input type="button" name="Button" value="<?=$status?>"  onclick="cal_all(<?=$info->PBI_ID?>), update_value(<?=$info->PBI_ID?>)" style="font-size:10px;"/><? }?>
          </span>&nbsp;</td>
          </tr>
        <?
		}
		?>
        <tr><td colspan="2"></tbody>
        
        <tfoot>
        <tr><td colspan="2"></td><td></td><td></td><td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
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
		<? }?>          </div></div>
          </div>
    </div>
<p>
  <input name="save" type="submit" id="save" value="SAVE" />
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
require_once SERVER_CORE."routing/layout.bottom.php";
?>