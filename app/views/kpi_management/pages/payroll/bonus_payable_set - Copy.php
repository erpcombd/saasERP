<?php
session_start();
ob_start();
require_once "../../config/inc.all.php";
auto_complete_from_db('personnel_basic_info','concat(PBI_NAME,"-",PBI_ID)','PBI_ID','','search_PBI_ID');


$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';
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

var flag=document.getElementById('flag_'+id).value;

var strURL="bonus_payable_set_ajax.php?PBI_ID="+PBI_ID+"&flag="+flag;

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
function autocal(id){
	var basic=(document.getElementById('bs_'+id).value)*1;
	if(basic>0){
	var house_rent=(basic*1)*(.6);
	var pf=(basic*1)*(.1);
	
	if(basic>3499)
	{
	var pf_organization=(basic*1)*(.1);
	}
	else
	{
	var pf_organization=350;
	}
	document.getElementById('hr_'+id).value = house_rent.toFixed(0);
	document.getElementById('pf_'+id).value = pf.toFixed(0);
	document.getElementById('po_'+id).value = pf_organization.toFixed(0);
	}
	}

	function cal_all(id)

	{
var PBI_ID=id; // Rent
var ob=(document.getElementById('ob_'+id).value)*1; // Other
var bs=(document.getElementById('bs_'+id).value)*1; // Rent + Other
var hr=(document.getElementById('hr_'+id).value)*1; // Paid
var co=(document.getElementById('co_'+id).value)*1; 
var cc=(document.getElementById('cc_'+id).value)*1;
var me=(document.getElementById('me_'+id).value)*1;
var pf=(document.getElementById('pf_'+id).value)*1; // Due
var po=(document.getElementById('po_'+id).value)*1;

var to=(bs + hr + co + cc+ me + pf + po);
document.getElementById('to_'+id).value=to;
	}
</script>
<style type="text/css">
.oe_list_content td {
    line-height: 18px;
    padding: 1px 3px;
}
.style1 {
	font-size: 18px;
	color: #09F;
}
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
  <th colspan="4"><span class="style1">Set Bonus Payable </span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>

  <tr  class="alt">
    <td width="40%" align="right"><strong>Year :</strong></td><td width="10%" align="left"><select name="year" style="width:160px;" id="year" required="required">
      <option <?=($_POST['year']=='0')?'selected':''?>></option>
      <option <?=($_POST['year']=='2015')?'selected':''?>>2015</option>
      <option <?=($_POST['year']=='2016')?'selected':''?>>2016</option>
      <option <?=($_POST['year']=='2017')?'selected':''?>>2017</option>
      <option <?=($_POST['year']=='2018')?'selected':''?>>2018</option>
    </select></td>
    <td width="40%" align="right"><strong>Company Name  :</strong></td>
    <td width="10%">      <select name="area" style="width:160px;" id="area" required="required">
          <? foreign_relation('domai','DOMAIN_CODE','DOMAIN_DESC',$_POST['area']);?>
            </select>    </td>
  </tr>
  <tr >
    <td align="right"><strong>Employee ID:(Optional) </strong></td>
    <td align="left"><input name="search_PBI_ID"  type="text" id="search_PBI_ID" size="10" onblur="" tabindex="1" style="width:200px;" value="<?=$_POST['search_PBI_ID']?>" /></td>
    <td align="right"><strong>Department Name : </strong></td>
    <td><span class="oe_form_group_cell">
      <select name="PBI_DEPARTMENT">
        <? foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['PBI_DEPARTMENT']);?>
      </select>
    </span></td>
  </tr>
  </tbody></table>
<br /><div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><input name="create" type="submit" id="create" value="Show" /></th>
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
          
		<table width="100%" cellpadding="0" cellspacing="0" class="oe_list_content">
		  <thead><tr class="oe_list_header_columns" style="font-size:10px;padding:3px;">
        <th>Code</th>
        <th>Full Name</th>
        <th>Desg</th>
        <th>Dept</th>
        <th>Joining Date </th>
        <th>Length of Job </th>
        <th>Job Type </th>
        <th>Bonus Payable </th>
        <th>Change To </th>
        </tr>
		</thead>
        <tbody>
        <? 
$year = $_REQUEST['year'];
if($_POST['search_PBI_ID']>0) $con .= ' and a.PBI_ID='.$_POST['search_PBI_ID'];
		$sql = "select a.PBI_NAME,a.PBI_ID,c.DESG_DESC,d.DEPT_DESC,a.PBI_DOJ,a.PBI_PRIMARY_JOB_STATUS from personnel_basic_info a,designation c, department d where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_DOMAIN='".$_POST['area']."'".$con." and a.PBI_JOB_STATUS='1' order by a.PBI_ID ";
		$query = mysql_query($sql);
		while($info=mysql_fetch_object($query))
		{
		$data = find_all_field('salary_info','','PBI_ID="'.$info->PBI_ID.'"');
		$status = $data->bonus_applicable;
		
		

		?>
        <tr style="font-size:10px; padding:3px; "><td><?=$info->PBI_ID?>
          <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>
		  <td><?=$info->PBI_NAME?></td>
		  <td><?=$info->DESG_DESC?></td>
		  <td><?=$info->DEPT_DESC?></td>
		  <td><?=$info->PBI_DOJ?></td>
          <td><? if($info->PBI_DOJ<date('Y-m-d',time()-31536000)) echo '<font color="#009900">'.Date2age($info->PBI_DOJ).'</font>'; else echo Date2age($info->PBI_DOJ);?></td>
          <td><? if($info->PBI_PRIMARY_JOB_STATUS=='Permanent') echo '<font color="#009900">'.$info->PBI_PRIMARY_JOB_STATUS.'</font>'; else echo $info->PBI_PRIMARY_JOB_STATUS;?></td>
          <td align="center">
		  <?
		  if($status=='YES'){
		  ?>
		  <table width="50" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#00CC33">
		    <tr><td align="center" style="text-align:center"><?=$status?></td>
		    </tr></table>
		  <?
		  }if($status=='NO'){
		  ?>
		  <table width="50" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FF0000">
		    <tr><td align="center" style="text-align:center"><?=$status?></td>
		  </tr></table>
		  <?
		  }if($status==''){
		  ?>
		  <table width="50" border="0" cellpadding="0" cellspacing="0" ><tr><td align="center" style="text-align:center">NOT-FOUND</td>
		  </tr></table>
		  <?
		  }
		  ?>
            </td>
          <td align="center"><span id="divi_<?=$info->PBI_ID?>">
            <? 
			  if($status=='YES')
			  {?>
			  <input type="hidden" name="flag_<?=$info->PBI_ID?>" id="flag_<?=$info->PBI_ID?>" value="1" />
			  <input type="button" name="Button" value="NO"  onclick="update_value(<?=$info->PBI_ID?>)" style="font-size:10px; background-color:#FF0000; font-weight:bold"/><?
			  }
			  if($status=='NO')
			  {
			  ?>
			  <input type="hidden" name="flag_<?=$info->PBI_ID?>" id="flag_<?=$info->PBI_ID?>" value="0" />
			  <input type="button" name="Button" value="YES"  onclick="update_value(<?=$info->PBI_ID?>)" style="font-size:10px;background-color:#009900; font-weight:bold"/>
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
          </tr>
        </tfoot>
        </table>          
          </div></div>
          </div>
    </div>
<p>&nbsp;</p>
  </div>
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