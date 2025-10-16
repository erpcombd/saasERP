<?php
session_start();
ob_start();
require_once "../../config/inc.all.php";
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

if(isset($_POST['save']))
{
		$schedule_id = $_POST['schedule_id'];
		$sql = "select PBI_ID from 
		personnel_basic_info
		where PBI_DOMAIN='".$_POST['area']."'";
		$query = mysql_query($sql);
		
		while($info=mysql_fetch_object($query))
		{
			if(isset($_POST['sch_'.$info->PBI_ID]))
			{
			mysql_query('update personnel_basic_info set office_time="'.$schedule_id.'",off_day="'.$_POST['off_day'].'" where PBI_ID='.$info->PBI_ID);}
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


var strURL="monthly_attendence_ajax.php?PBI_ID="+PBI_ID+"&td="+td+"&od="+od+"&hd="+hd+"&lt="+lt+"&ab="+ab+"&lv="+lv+"&pre="+pre+"&pay="+pay+"&ot="+ot+"&mon="+mon+"&year="+year+"&area="+area;

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
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
-->
</style>

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
  <th colspan="3"><span style="text-align: center; font-size:18px; color:#09F">Roster Day Set</span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="3"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>
  <tr >
    <td align="right">&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
  <tr >
    <td align="right"><strong>Company Name  :</strong></td>
    <td align="right"><div align="left"><span class="oe_form_group_cell">
      <select name="area" style="width:360px;" id="area" required="required">
        <? foreign_relation('domai','DOMAIN_CODE','DOMAIN_DESC',$_REQUEST['area']);?>
      </select>
    </span></div></td>
    <td rowspan="3" align="center" valign="bottom"><input name="create" type="submit" id="create" value="SHOW EMPLOYEE" /></td>
  </tr>
  <tr >
    <td align="right"><strong>Department :</strong></td>
    <td align="right"><div align="left">
      <select name="department" style="width:160px;" id="department">
        <? foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['department']);?>
      </select>
    </div></td>
  </tr>
  <tr >
    <td align="right"><strong>Designation :</strong></td>
    <td align="right">
      <div align="left">
        <select name="designation" style="width:160px;" id="designation">
          <? foreign_relation('designation','DESG_ID','DESG_DESC',$_POST['designation'], ' 1 order by DESG_DESC');?>
        </select>
        </div></td>
    </tr>
  </tbody></table>
<br />
<? if($_REQUEST['area']>0){?>
<div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#FF6633">
    <tr>
      <td width="45%"><div align="right" class="style1">New Schedule: </div></td>
      <td width="27%"><span class="oe_form_group_cell">
        <select name="schedule_id" style="width:325px;" id="schedule_id" required="required">
          <? foreign_relation('hrm_schedule_info','id','schedule_name',$_REQUEST['schedule_id']);?>
        </select>
      </span></td>
      <td width="28%">OFF Day </td>
      <td width="27%"><span class="oe_form_group_cell">
        <select name="off_day">
          <option></option>
          <option value="5" <?=($off_day==5)?'selected':'';?>>Friday</option>
          <option value="6" <?=($off_day==6)?'selected':'';?>>Saturday</option>
          <option value="7" <?=($off_day==7)?'selected':'';?>>Sunday</option>
          <option value="1" <?=($off_day==1)?'selected':'';?>>Monday</option>
          <option value="2" <?=($off_day==2)?'selected':'';?>>Tuesday</option>
          <option value="3" <?=($off_day==3)?'selected':'';?>>Wednesday</option>
          <option value="4" <?=($off_day==4)?'selected':'';?>>Thursday</option>
        </select>
      </span> </td>
      <td width="28%"><input name="save" type="submit" id="save" value="SET NEW SCHEDULE" /></td>
    </tr>
  </table></th>
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
        <th>Present Schedule</th>
        <th>OFF DAY </th>
        <th>Check</th>
        </tr>
		</thead>
        <tbody>
        <?
		if($_POST['designation']>0)
		$con .=' and a.PBI_DESIGNATION='.$_POST['designation'];
		if($_POST['department']>0)
		$con .=' and a.PBI_DEPARTMENT='.$_POST['department'];
		$sql = "select a.PBI_NAME,a.PBI_ID,c.DESG_DESC,d.DEPT_DESC,(select s.schedule_name from hrm_schedule_info s where s.id=a.office_time) as schedule_name, a.off_day from 
		personnel_basic_info a,designation c, department d
		where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_DOMAIN='".$_POST['area']."'".$con."  and a.PBI_JOB_STATUS='1' order by a.PBI_ID ";
		$query = mysql_query($sql);
		while($info=mysql_fetch_object($query))
		{
		?>
        <tr style="font-size:10px; padding:3px; "><td><?=$info->PBI_ID?>
          <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>
		  <td><?=$info->PBI_NAME?></td>
		  <td><?=$info->DESG_DESC?></td>
		  <td><?=$info->DEPT_DESC?></td>
		  <td><?=$info->schedule_name?></td>
		  <td><?=date('l',mktime(1,1,1,1,$info->off_day,2001));?>&nbsp;</td>
		  <td align="center"><input type="checkbox" name="sch_<?=$info->PBI_ID?>" id="sch_<?=$info->PBI_ID?>" value="checkbox" /></td>
          </tr>
        <?
		}
		?>
        </tbody>
        
        <tfoot>
        <tr><td></td><td></td><td></td>
          <td></td>
          <td colspan="2"></td>
          <td></td>
          </tr>
        </tfoot>
        </table>          
          </div></div>
          </div>
    </div>
<p>&nbsp;</p>
  </div>
<? }?>
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