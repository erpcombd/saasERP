<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';
do_calander('#ijdb');
do_calander('#ijda');
do_calander('#ppjdb');
do_calander('#ppjda');
if($_POST['mon']!=''){
$mon=$_POST['mon'];}
else{
$mon=date('n');
}

if($_POST['year']!=''){
$year=$_POST['year'];}
else{
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
var strURL="monthly_attendence_rsm_ajax.php?PBI_ID="+PBI_ID+"&td="+td+"&fd="+fd+"&od="+od+"&hd="+hd+"&lt="+lt+"&ab="+ab+"&lv="+lv+"&lwp="+lwp+"&pre="+pre+"&pay="+pay+"&ot="+ot+"&mon="+mon+"&year="+year+"&remarks="+remarks+"&status="+sta;

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
var td=(document.getElementById('td_'+id).value)*1; // Other
var od=(document.getElementById('od_'+id).value)*1; // Rent + Other
var hd=(document.getElementById('hd_'+id).value)*1; // Paid
var lt=(document.getElementById('lt_'+id).value)*1; 
var ab=(document.getElementById('ab_'+id).value)*1;


var pre=td - (od + hd + ab  );
var pay=td - ab ;
document.getElementById('pay_'+id).value=pay;
document.getElementById('pre_'+id).value=pre;
	}


</script>

<form action="../report/master_report.php" target="_blank" method="post">
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
  <th colspan="4"><span style="text-align: center; font-size:18px; color:#09F">Advance Reporting FOR RSM </span></th>
  </tr>
<tr class="oe_list_header_columns" style="text-align:center">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>
  <tr>
    <td align="right" class="alt"><strong>Company :</strong></td>
    <td align="left" class="alt"><span class="oe_form_group_cell">
      <select name="PBI_ORG" style="width:160px;" id="PBI_ORG" class="form-control">
        <option value="2">Sajeeb Corporation</option>
      </select>
    </span></td>
    <td width="40%" align="right" class="alt"><strong>Department :</strong></td>
    <td width="10%"><span class="oe_form_group_cell">
      <select name="department" style="width:160px;" id="department" class="form-control">
        <option value="Sales">Sales</option>
      </select>
    </span></td>
  </tr>

  <tr  class="alt">
    <td align="right"><strong>Group  :</strong></td>
    <td><span class="oe_form_group_cell">
      <select name="PBI_GROUP" style="width:160px;" id="PBI_GROUP" required="required" class="form-control">
        <? $g_id=find_a_field('user_activity_management','product_group','username="'.$_SESSION['user']['username'].'"');
		foreign_relation('product_group','group_name','group_name',$_POST['PBI_GROUP'],' 1 and group_name="'.$g_id.'"');?>
      </select>
    </span></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td align="right"><strong>Region :</strong></td>
    <td><span class="oe_form_group_cell">
	
	  <select required name="branch" id="branch" style="width:160px;" onchange="getData2('ajax_zone_rsm.php', 'loc', this.value,  this.value)" class="form-control">
        <? 
		//$b_id=find_a_field('user_activity_management','region_id','username="'.$_SESSION['user']['username'].'"');
		foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$_POST['branch'],' 1 order by BRANCH_NAME');?>
      </select>
	  

    </span></td>
    <td align="right"><strong>PBI ID IN:</strong></td>
    <td><input name="pbi_id_in" type="text" id="pbi_id_in"  class="form-control"/></td>
  </tr>
  <tr >
    <td align="right">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td align="right">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td align="right" bgcolor="#FF99FF">(For Payroll) Month  :</td>
    <td align="left" bgcolor="#FF99FF"><span class="oe_form_group_cell">
      <select name="mon" style="width:160px;" id="mon" required="required" class="form-control">
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
    <td align="right" bgcolor="#FF99FF">(For Payroll) Year  :</td>
    <td bgcolor="#FF99FF"><select name="year" style="width:160px;" id="year" required="required" class="form-control">
      
      <option <?=($year=='2016')?'selected':''?>>2016</option>
	  <option <?=($year=='2017')?'selected':''?>>2017</option>
      <option <?=($year=='2018')?'selected':''?>>2018</option>
      <option <?=($year=='2019')?'selected':''?>>2019</option>
	  <option <?=($year=='2020')?'selected':''?>>2020</option>
	  <option <?=($year=='2021')?'selected':''?>>2021</option>
    </select></td>
  </tr>
  </tbody></table>
<br /><div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><span style="text-align: center; font-size:16px; color:#C00">Select Report</span></th>
  </tr>
  </thead>
  <tfoot>
  </tfoot>
  <tbody>
    <tr>
      <td width="4%" align="center"><input name="report" type="radio" class="radio" value="77" checked="checked" /></td>
      <td width="44%"><strong>Salary Information</strong></td>
      <td width="4%" align="center">&nbsp;</td>
      <td width="44%">&nbsp;</td>
      </tr>

  </tbody>
</table>
<input name="submit" type="submit" id="submit" value="SHOW" />
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