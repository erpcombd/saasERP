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
var ob=(document.getElementById('ob_'+id).value)*1; // Other
var bs=(document.getElementById('bs_'+id).value)*1; // Rent + Other
var hr=(document.getElementById('hr_'+id).value)*1; // Paid
var co=(document.getElementById('co_'+id).value)*1; 
var cc=(document.getElementById('cc_'+id).value)*1;
var me=(document.getElementById('me_'+id).value)*1;
var pf=(document.getElementById('pf_'+id).value)*1; // Due
var po=(document.getElementById('po_'+id).value)*1;

var year=document.getElementById('year').value;
var flag=document.getElementById('flag_'+id).value;

var strURL="salary_increment_ajax.php?PBI_ID="+PBI_ID+"&ob="+ob+"&bs="+bs+"&hr="+hr+"&co="+co+"&cc="+cc+"&me="+me+"&pf="+pf+"&po="+po+"&year="+year+"&flag="+flag;

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
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Salary Increment  Entry</span></th>
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
        <th>Old-Basic </th>
        <th>Basic</th>
        <th>House.R</th>
        <th>Conv</th>
        <th>Conv(City)</th>
        <th>Medical</th>
        <th>PF</th>
        <th>PF(OR)</th>
        <th>Total</th>
        <th>&nbsp;</th>
        </tr>
		</thead>
        <tbody>
        <? 
$year = $_REQUEST['year'];
if($_POST['search_PBI_ID']>0) $con .= ' and a.PBI_ID='.$_POST['search_PBI_ID'];
		$sql = "select a.PBI_NAME,a.PBI_ID,c.DESG_DESC,d.DEPT_DESC from personnel_basic_info a,designation c, department d where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_DOMAIN='".$_POST['area']."'".$con." and a.PBI_JOB_STATUS='1' order by a.PBI_ID ";
		$query = mysql_query($sql);
		while($info=mysql_fetch_object($query))
		{
			$data = find_all_field('increment_detail','','PBI_ID="'.$info->PBI_ID.'" and year="'.$year.'" order by INCREMENT_D_ID desc');

		if($data->new_basic_salary>0)
		{
			$status='RE-CAL';
		$ob = (int)$data->old_basic_salary;
		$bs = (int)$data->new_basic_salary;
		$hr = (int)$data->new_house_rent;
		$me = (int)$data->new_medical_allowance;
		$co = (int)$data->new_ta;
		$cc = (int)$data->new_da;
		$pf = (int)$data->new_pf;
		$po = (int)$data->new_pf_organization;
		$to = $bs +$hr +$me +$co +$cc +$pf +$po ;
		}
		else
		{
			$status='CAL';
			$data = find_all_field('increment_detail','','PBI_ID="'.$info->PBI_ID.'" order by INCREMENT_D_ID desc');
					$ob = (int)$data->old_basic_salary;
		$ob = (int)$data->new_basic_salary;
		$bs = (int)($data->new_basic_salary*(1.1));
		$hr = (int)($data->new_basic_salary*(1.1)*(.6));
		$me = (int)$data->new_medical_allowance;
		$co = (int)$data->new_ta;
		$cc = (int)$data->new_da;
		$pf = (int)($data->new_basic_salary*(1.1)*(.1));
		$po = (int)((($data->new_basic_salary*(1.1))>3499)?(($data->new_basic_salary*(1.1)*(.1))):350);
		$to = 		$bs +$hr +$me +$co +$cc +$pf +$po ;

		}
		

		?>
        <tr style="font-size:10px; padding:3px; "><td><?=$info->PBI_ID?>
          <input type="hidden" name="PBI_ID" id="PBI_ID" value="<?=$info->PBI_ID?>" /></td>
		  <td><?=$info->PBI_NAME?></td>
		  <td><?=$info->DESG_DESC?></td>
		  <td><?=$info->DEPT_DESC?></td>
		  <td align="center"><input name="ob_<?=$info->PBI_ID?>" type="text" id="ob_<?=$info->PBI_ID?>" style="font-size:10px; width:50px;min-width:50px;" value="<?=$ob?>" readonly="readonly" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>
          <td align="center"><input name="bs_<?=$info->PBI_ID?>" type="text" id="bs_<?=$info->PBI_ID?>" style="font-size:10px;  width:50px;min-width:50px;" value="<?=$bs?>" onchange="autocal(<?=$info->PBI_ID?>);cal_all(<?=$info->PBI_ID?>);" /></td>
          <td align="center"><input name="hr_<?=$info->PBI_ID?>" type="text" id="hr_<?=$info->PBI_ID?>" style="font-size:10px;  width:50px;min-width:50px;" value="<?=$hr?>" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>
          <td align="center"><input name="co_<?=$info->PBI_ID?>" type="text" id="co_<?=$info->PBI_ID?>" style="font-size:10px;  width:50px;min-width:50px;" value="<?=$co?>" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>
          <td align="center"><input name="cc_<?=$info->PBI_ID?>" type="text" id="cc_<?=$info->PBI_ID?>" style="font-size:10px;  width:50px;min-width:50px;" value="<?=$cc?>"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>
          <td align="center"><input name="me_<?=$info->PBI_ID?>" type="text" id="me_<?=$info->PBI_ID?>" style="font-size:10px;  width:50px;min-width:50px;" value="<?=$me?>"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>
<td align="center"><input name="pf_<?=$info->PBI_ID?>" type="text" id="pf_<?=$info->PBI_ID?>" style="font-size:10px;  width:50px;min-width:50px;" onchange="cal_all(<?=$info->PBI_ID?>)" value="<?=$pf?>" /></td>
<td align="center"><input name="po_<?=$info->PBI_ID?>" type="text" id="po_<?=$info->PBI_ID?>" style="font-size:10px;  width:50px;min-width:50px;" value="<?=$po?>"/></td>
          <td align="center"><input name="to_<?=$info->PBI_ID?>" type="text" id="to_<?=$info->PBI_ID?>" style="font-size:10px;  width:50px;min-width:50px;" value="<?=$to?>" readonly="" /></td>
          <td align="center"><span id="divi_<?=$info->PBI_ID?>">
            <? 
			  if($status=='RE-CAL')
			  {?>
			  <input type="hidden" name="flag_<?=$info->PBI_ID?>" id="flag_<?=$info->PBI_ID?>" value="1" />
			  <input type="button" name="Button" value="<?=$status?>"  onclick="update_value(<?=$info->PBI_ID?>)" style="font-size:10px;"/><?
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