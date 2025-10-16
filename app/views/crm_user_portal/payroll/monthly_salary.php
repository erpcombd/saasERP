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
<form action="master_salary.php"  method="post">
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
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Monthly Salary Final</span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>

  <tr  class="alt">
    <td width="40%" align="right"><strong>Month :</strong></td><td width="10%" align="left"><span class="oe_form_group_cell">
      <select name="mon" style="width:160px;" id="mon" required>
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
      <option <?=($bonus=='No')?'selected':''?>>No</option>
      <option <?=($bonus=='Yes')?'selected':''?>>Yes</option>
        </select>
      </span></td>
    <td align="right"><strong>Staff Type  :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="area" style="width:160px;" id="area" required>
        <option value="1" <?=($area==1)?'selected':''?>>Employee</option>
        <option value="2" <?=($area==2)?'selected':''?>>Worker</option>
        </select></span></td>
  </tr>
  </tbody></table><br /><div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><input name="create" type="submit" id="create" value="Salary Payable" /></th>
  </tr>
  </thead>
  <tfoot>
  </tfoot>
  <tbody>
    </tbody>
</table>
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