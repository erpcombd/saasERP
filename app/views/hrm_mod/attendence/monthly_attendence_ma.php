<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

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
var pre=(document.getElementById('pre_'+id).value)*1; // Due
var pay=document.getElementById('pay_'+id).value;
var ot=document.getElementById('ot_'+id).value;

var mon=document.getElementById('mon').value;
var year=document.getElementById('year').value;


var strURL="monthly_attendence_delete_ajax.php?PBI_ID="+PBI_ID+"&td="+td+"&fd="+fd+"&od="+od+"&hd="+hd+"&lt="+lt+"&ab="+ab+"&pre="+pre+"&pay="+pay+"&ot="+ot+"&mon="+mon+"&year="+year;

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

var mon=document.getElementById('mon').value;
var year=document.getElementById('year').value;
var remarks= document.getElementById('remarks_'+id).value;
var status = document.getElementById('status_'+id);

if (status.checked == true){
var sta = 1;}
else
{var sta=0;}
var strURL="monthly_attendence_store_ajax.php?PBI_ID="+PBI_ID+"&td="+td+"&fd="+fd+"&od="+od+"&hd="+hd+"&lt="+lt+"&ab="+ab+"&lv="+lv+"&lwp="+lwp+"&pre="+pre+"&pay="+pay+"&ot="+ot+"&mon="+mon+"&year="+year+"&remarks="+remarks+"&status="+sta;

		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {

			

				if (req.readyState == 4) {

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
var lv=(document.getElementById('lv_'+id).value)*1;
var lwp=(document.getElementById('lwp_'+id).value)*1;
var td=(document.getElementById('td_'+id).value)*1; // Other
var od=(document.getElementById('od_'+id).value)*1; // Rent + Other
var hd=(document.getElementById('hd_'+id).value)*1; // Paid
var lt=(document.getElementById('lt_'+id).value)*1; 
var ab=(document.getElementById('ab_'+id).value)*1;


var pre=td - (od + hd + ab  + lv + lwp);
var pay=td - (ab + lwp) ;
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
<tr class="oe_list_header_columns" style="text-align:center">
  <th colspan="6"><span style="text-align: center; font-size:18px; color:#09F">Monthly Attendence Entry</span></th>
  </tr>
<tr class="oe_list_header_columns" style="text-align:center">
  <th colspan="6"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>

  <tr  class="alt">
    <td align="right"><strong>Year:</strong></td>
    <td><select name="year" style="width:160px;" id="year" required="required" class="form-control">
<option <?=($year=='2021')?'selected':''?>>2021</option>

    </select></td>
    <td align="right"><strong>Department:</strong></td>
    <td colspan="3"><span class="oe_form_group_cell">
      <select name="dept" style="width:160px;" id="dept"  class="form-control">
		<option value="Mkt. A">Market Audit</option>
      </select>
    </span></td>
  </tr>
  <tr >
    <td align="right" class="alt">Concern Company :</td>
    <td align="left" class="alt"><span class="oe_form_group_cell">
      <select name="PBI_ORG" style="width:160px;" id="PBI_ORG" required class="form-control">
      	 <? foreign_relation('user_group','id','group_name',$_POST['PBI_ORG']); ?>
      </select>
    </span></td>
    <td align="right"><strong>Job Location:</strong></td>
    <td colspan="3"><span class="oe_form_group_cell">
      
	  <select name="JOB_LOCATION" id="JOB_LOCATION" style="width:160px;" required="required" class="form-control">
        <? $b_id=find_a_field('user_activity_management','location_id','username="'.$_SESSION['user']['username'].'"');
		foreign_relation('office_location','ID','LOCATION_NAME',$_POST['JOB_LOCATION'],'1 and ID="'.$b_id.'"');

$month_find = find_a_field('hrm_portal_setup','mon','1 and level=57');
$dateObj   = DateTime::createFromFormat('!m', $month_find);
$monthName = $dateObj->format('F');
?>
      </select>
	    
	  
    </span></td>
    </tr>
  <tr >
    <td align="right" class="alt"><strong>Month:</strong></td>
    <td align="left" class="alt"><span class="oe_form_group_cell">
      <select name="mon" style="width:160px;" id="mon" required="required" class="form-control">

<option value="<?=$month_find;?>"><?=$monthName;?></option>

<!--    
<option value="1" <?=($mon=='1')?'selected':''?>>Jan</option>
        <option value="2" <?=($mon=='2')?'selected':''?>>Feb</option>
        <option value="3" <?=($mon=='3')?'selected':''?>>Mar</option>
        <option value="4" <?=($mon=='4')?'selected':''?>>Apr</option>
      	<option value="5" <?=($mon=='5')?'selected':''?>>May</option>
        <option value="6" <?=($mon=='6')?'selected':''?>>Jun</option>
        <option value="7" <?=($mon=='7')?'selected':''?>>Jul</option>
        <option value="8" <?=($mon=='8')?'selected':''?>>Aug</option>
        <option value="9" <?=($mon=='9')?'selected':''?>>Sep</option>
        <option value="10" <?=($mon=='10')?'selected':''?>>Oct</option>
        <option value="11" <?=($mon=='11')?'selected':''?>>Nov</option>
        <option value="12" <?=($mon=='12')?'selected':''?>>Dec</option>
		-->
      </select>
    </span></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
        <th>DOJ</th>
        <th>TD</th>
        <th>OD</th><th>HD</th>
        <th>AB</th><th>LWP</th>
        <th>LV</th>
        <th>Pre</th>
        <th>Pay</th>
        <th>Dealer Code</th>
        <th>Held-Up</th>
        <th>Remarks</th>
        <th>&nbsp;</th>
        </tr>
		</thead>
        <tbody>
        <? 
//$startTime = $days1=mktime(0,0,0,($mon-1),26,$year);
//$endTime = $days2=mktime(0,0,0,$mon,25,$year);
if($mon == 1)
{
$syear = $year - 1;
$smon = 12;
}
else
{
$syear = $year;
$smon =  $mon - 1;
}

$startTime = $days1=mktime(0,0,0,$smon,26,$year);
$endTime = $days2=mktime(0,0,0,$mon,25,$year);

$days_in_month = date('t',$startTime);

$startTime1 = $days1=mktime(0,0,0,($mon),26,$year);
$endTime1 = $days2=mktime(0,0,0,$mon,25,$year);

$startday = date('Y-m-d',$startTime);
$endday = date('Y-m-d',$endTime);
	



//$start_date = $year.'-'.($mon-1).'-26';
//$end_date = $year.'-'.$mon.'-25';

$start_date =$starting_date = date('Y-m-d',strtotime($year.'-'.($mon-1).'-26'));
$end_date =$ending_date = date('Y-m-d',strtotime($year.'-'.$mon.'-25'));

$da =  find_all_field('hrm_payroll_setup','',' `year` = "'.$year.'" and `mon` = "'.$mon.'" ');
$days_mon = $da->days_of_month;

?>
<input name="fd" type="hidden" id="fd" value="<?=$r_count;?>" />
<?		
		
		

		if($_POST['PBI_BRANCH']!='')	$con .= " and PBI_BRANCH = '".$_POST['PBI_BRANCH']."'";
		if($_POST['PBI_ZONE']!='')		$con .= " and PBI_ZONE = '".$_POST['PBI_ZONE']."'";
		if($_POST['PBI_GROUP']!='')		$con .= " and PBI_GROUP = '".$_POST['PBI_GROUP']."'";
		if($_POST['PBI_DOMAIN']!='')	$con .= " and PBI_DOMAIN = '".$_POST['PBI_DOMAIN']."'";
		if($_POST['JOB_LOCATION']!='')  $con .= " and JOB_LOCATION = '".$_POST['JOB_LOCATION']."'";
		//echo $jday=date('d').' <br>';
		$j_date=$start_date;

 $sql = "select p.* from personnel_basic_info p, salary_info s where p.PBI_ID=s.PBI_ID and p.PBI_JOB_STATUS='In Service' 
and p.PBI_DEPARTMENT like '".$_POST['dept']."' 
and p.PBI_ORG='".$_POST['PBI_ORG']."' ".$con."  
and p.PBI_ID not in (3476,4705)
order by (s.basic_salary+s.consolidated_salary) desc,p.PBI_ID";
		
		$query = db_query($sql);
		while($info=mysqli_fetch_object($query))
		{
$new_emp_days = 0;
$att = find_all_field('hrm_attendence_final','','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');

if($att->id>0)
$status='Edit';
else
$status='Save';

if($data->dealer_code=='') {$dealer_code = find_a_field('dealer_info','dealer_code',' 1 and area_code>0 and product_group!="" and area_code="'.$info->PBI_AREA.'" and product_group="'.$info->PBI_GROUP.'"');}

$leave_days_lwp = 0;
$leave_days_lv =  0;

		if(strtotime($info->PBI_DOJ)>strtotime($starting_date))
		$new_emp_days =ceil(($endTime - strtotime($info->PBI_DOJ))/(3600*24))+1;


if($start_date>$info->PBI_DUE_DOJ)
{
$leave_days_lwp = $att->lwp;
$leave_days_lv = $att->lv;
}
else
{
$leave_days_lwp = $att->lwp;
$leave_days_lv = 0;}

	?>

        <tr style="font-size:10px; padding:3px; "><td><?=++$S?></td>
          <td><?=$info->PBI_ID?>
            <input name="dept_<?=$info->PBI_ID?>" type="hidden" id="dept_<?=$info->PBI_ID?>"  value="<?=$info->PBI_DEPARTMENT;?>" />
            <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>
          <td><?=$info->PBI_NAME?></td><td><?=find_a_field('designation','DESG_SHORT_NAME','DESG_ID='.$info->DESG_ID)?></td><td><?=$info->PBI_DEPARTMENT?></td>

          <td align="center"><?=$info->PBI_DOJ?></td>
          <td align="center">
<input name="td_<?=$info->PBI_ID?>" type="text" id="td_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" 
value="<? if($att->td>0) echo $att->td; else {if($new_emp_days>0) echo $new_emp_days; else echo $days_mon;}?>" size="2" maxlength="2" readonly="readonly"/></td>

<td align="center"><input name="od_<?=$info->PBI_ID?>" type="text" id="od_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" size="2" maxlength="2" value="<?=$att->od;?>" onchange="cal_all(<?=$info->PBI_ID?>)" />

  <input name="lt_<?=$info->PBI_ID?>" type="hidden" id="lt_<?=$info->PBI_ID?>" style="font-size:10px; width:40px; min-width:40px;" value="<?=($data->lt=='')?$att->lt:$data->lt;?>" size="2" maxlength="2" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>

<td align="center"><input name="hd_<?=$info->PBI_ID?>" type="text" id="hd_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" size="2" maxlength="2" value="<? if($att->hd>0) echo $att->hd; else {if($new_emp_holy_day>0) echo $new_emp_holy_day; else echo $holy_day;}?>"   onchange="cal_all(<?=$info->PBI_ID?>)"/></td>


<td align="center"><input name="ab_<?=$info->PBI_ID?>" type="text" id="ab_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:20px;" value="<?=($data->ab=='')?$att->ab:$data->ab;?>" size="2" maxlength="2" onchange="cal_all(<?=$info->PBI_ID?>)"/>
  </td>

 <td align="center"><input name="lwp_<?=$info->PBI_ID?>" type="text" id="lwp_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:28px;" value="<?=($att->lwp=='')?$leave_days_lwp:$att->lwp;?>" size="4" maxlength="4"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td> 
  
<td align="center"><input <? if($end_date>$info->PBI_DOC2&&$info->PBI_DOC2!='0000-00-00') echo ''; else echo 'readonly';  ?> name="lv_<?=$info->PBI_ID?>" type="text" id="lv_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:28px;" value="<?=($att->lv=='')?$leave_days_lv:$att->lv;?>" size="4" maxlength="4"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>

<td align="center"><input name="pre_<?=$info->PBI_ID?>" type="text" id="pre_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:40px;" value="<?=($data->pre=='')?$att->pre:$data->pre;?>" size="2" maxlength="2" readonly="readonly"/></td>

<td align="center"><input name="pay_<?=$info->PBI_ID?>" type="text" id="pay_<?=$info->PBI_ID?>" style="font-size:10px; width:35px; min-width:40px;" value="<?=($data->pay=='')?$att->pay:$data->pay;?>" size="2" maxlength="2" readonly="readonly"/></td>

<td align="center"><input name="ot_<?=$info->PBI_ID?>" type="text" id="ot_<?=$info->PBI_ID?>" style="font-size:10px; width:45px; min-width:20px;" value="<?=$att->dealer_code;?>" size="6" maxlength="6" /></td>

<td align="center"><input type="checkbox" name="status_<?=$info->PBI_ID?>" id="status_<?=$info->PBI_ID?>" <? if($att->status>0) echo 'CHECKED="CHECKED"'; ?> value="1"/></td>

<td align="center"><input name="remarks_<?=$info->PBI_ID?>" type="text" id="remarks_<?=$info->PBI_ID?>" style="font-size:10px; width:100px; min-width:20px;" 
 value="<?=$att->remarks;?>" size="10" maxlength="50" /></td>
 
<td align="center"><span id="divi_<?=$info->PBI_ID?>">
            <? 
			
	

			  if($status=='Edit')
			  {
			  if($_SESSION['user']['level']==5||$_SESSION['user']['level']==57)
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
          </tr>
        </tfoot>
        </table>
		<? }?>          </div></div>
          </div>
    </div>
<p>&nbsp;</p>
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