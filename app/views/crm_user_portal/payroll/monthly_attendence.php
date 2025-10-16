<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';

if(isset($_POST['create']))
{
	$mon=$_POST['mon'];
	$area=$_POST['area'];
	$year=$_POST['year'];
	$bonus=$_POST['bonus'];
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
var deduction=document.getElementById('deduction_'+id).value;
var benefits=document.getElementById('benefits_'+id).value;

var mon=document.getElementById('mon').value;
var year=document.getElementById('year').value;
var bonus=document.getElementById('bonus').value;
var area=document.getElementById('area').value;


var strURL="monthly_attendence_ajax.php?PBI_ID="+PBI_ID+"&td="+td+"&od="+od+"&hd="+hd+"&lt="+lt+"&ab="+ab+"&lv="+lv+"&pre="+pre+"&pay="+pay+"&ot="+ot+"&deduction="+deduction+"&mon="+mon+"&year="+year+"&bonus="+bonus+"&area="+area+"&benefits="+benefits;

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
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Monthly Payroll Final </span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>

  <tr  class="alt">
    <td width="40%" align="right"><strong>Month :</strong></td><td width="10%" align="left"><span class="oe_form_group_cell">
      <select name="mon" style="width:160px;" id="mon" required>
	     <option value="0" <?=($mon=='0')?'selected':''?>></option>
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
      </select>
      </span></td>
    <td width="40%" align="right"><strong>Year :</strong></td>
    <td width="10%"><select name="year" style="width:160px;" id="year" required>
	  <option <?=($year=='0')?'selected':''?>></option>
      <option <?=($year=='2013')?'selected':''?>>2013</option>
      <option <?=($year=='2014')?'selected':''?>>2014</option>
      <option <?=($year=='2015')?'selected':''?>>2015</option>
      <option <?=($year=='2016')?'selected':''?>>2016</option>
    </select></td>
  </tr>
  <tr >
    <td align="right"><strong>Bonus Month (?) :</strong></td>
    <td align="left"><span class="oe_form_group_cell">
      <select name="bonus" style="width:160px;" id="bonus" required>
	  <option <?=($bonus=='0')?'selected':''?>></option>
      <option <?=($bonus=='No')?'selected':''?>>No</option>
      <option <?=($bonus=='Yes')?'selected':''?>>Yes</option>
        </select>
      </span></td>
    <td align="right"><strong>Company Name  :</strong></td>
    <td><span class="oe_form_group_cell">
<select name="area" style="width:160px;" id="area" required>
<? foreign_relation('domai','DOMAIN_CODE','DOMAIN_DESC',$area);?>
</select>
</span></td>
  </tr>
  </tbody></table><br /><div style="text-align:center">
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
        <th>Deduction</th>
        <th>Benefits</th>
        <th>&nbsp;</th>
        </tr>
		</thead>
        <tbody>
        <? 
$startTime = $days1=mktime(1,1,1,$mon,1,$year);
$days_mon=date('t',$days1);
$endTime = $days2=mktime(1,1,1,$mon,$days_mon,$year);

		
		
		



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
		$sql = "select a.*,c.DESG_DESC,d.DEPT_DESC from personnel_basic_info a,salary_info b,designation c, department d where a.PBI_DESIGNATION=c.DESG_ID and a.PBI_DEPARTMENT=d.DEPT_ID and a.PBI_ID=b.PBI_ID and a.PBI_DOMAIN='".$_POST['area']."' and a.PBI_JOB_STATUS='1' order by a.PBI_DEPARTMENT,a.PBI_ID,b.basic_salary desc";
		$query = db_query($sql);
		while($info=mysqli_fetch_object($query))
		{
		$data = find_all_field('salary_attendence','','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');
		if($data->td>0)
		{
			$status='Edit';
		}
		else
		{
			
			$att = find_all_field('hrm_attendence_final','','PBI_ID="'.$info->PBI_ID.'" and mon="'.$mon.'" and year="'.$year.'" ');
			$status='Save';
			$pay = $days_mon;
			$pre = $days_mon - ($holy_day + $r_count);

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
          <td align="center"><input name="lt_<?=$info->PBI_ID?>" type="text" id="lt_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" value="<?=($data->lt=='')?$att->lt:$data->lt;?>" size="2" maxlength="2" onchange="cal_all(<?=$info->PBI_ID?>)" /></td>
          <td align="center"><input name="ab_<?=$info->PBI_ID?>" type="text" id="ab_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" value="<?=($data->ab=='')?$att->ab:$data->ab;?>" size="2" maxlength="2"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>
          <td align="center"><input name="lv_<?=$info->PBI_ID?>" type="text" id="lv_<?=$info->PBI_ID?>" style="font-size:10px; width:20px; min-width:20px;" value="<?=($data->lv=='')?$att->lv:$data->lv;?>" size="2" maxlength="2"  onchange="cal_all(<?=$info->PBI_ID?>)"/></td>
<td align="center"><input name="pre_<?=$info->PBI_ID?>" type="text" id="pre_<?=$info->PBI_ID?>" style="font-size:10px; width:25px; min-width:20px;" onchange="cal_all(<?=$info->PBI_ID?>)" value="<?=($data->pre=='')?$att->pre:$data->pre;?>" size="2" maxlength="2" readonly="readonly" /></td>
<td align="center"><input name="pay_<?=$info->PBI_ID?>" type="text" id="pay_<?=$info->PBI_ID?>" style="font-size:10px; width:25px; min-width:20px;" value="<?=($data->pay=='')?$att->pay:$data->pay;?>" size="2" maxlength="2" readonly="readonly" /></td>
          <td align="center"><input name="ot_<?=$info->PBI_ID?>" type="text" id="ot_<?=$info->PBI_ID?>" style="font-size:10px; width:25px; min-width:20px;" value="<?=$data->ot?>" size="2" maxlength="2" /></td>
          <td align="center"><input name="deduction_<?=$info->PBI_ID?>" type="text" id="deduction_<?=$info->PBI_ID?>" style="font-size:10px; width:50px; min-width:20px;" value="<?=$data->deduction?>" size="5" maxlength="5" /></td>
          <td align="center"><input name="benefits_<?=$info->PBI_ID?>" type="text" id="benefits_<?=$info->PBI_ID?>" style="font-size:10px; width:50px; min-width:20px;" value="<?=$data->benefits?>" size="5" maxlength="5" /></td>
          <td align="center"><span id="divi_<?=$info->PBI_ID?>">
            <? 
			  if($status=='Edit')
			  {
			  if($_SESSION['user']['level']==5)
			  {?><input type="button" name="Button" value="<?=$status?>"  onclick="update_value(<?=$info->PBI_ID?>)" style="font-size:10px;"/><?
			  }
			  else echo 'Saved';
			  }
			  else
			  {
			  ?><input type="button" name="Button" value="<?=$status?>"  onclick="update_value(<?=$info->PBI_ID?>)" style="font-size:10px;"/><? }?>
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
          <td></td>
          <td></td>
          </tr>
        </tfoot>
        </table>          </div></div>
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
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>