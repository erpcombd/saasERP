<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$head='<link href="../css/report_selection.css" type="text/css" rel="stylesheet"/>';

if(isset($_POST['create']))
{
	$mon=$_POST['mon'];
	$dept=$_POST['dept'];
	$year=$_POST['year'];
	//$bonus=$_POST['bonus'];
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
	
	
	
function delete_value(id){

var dealer_code=id;
var qty					=(document.getElementById('qty_'+id).value)*1; 
var purpose				=document.getElementById('purpose_'+id).value; 
var replacement_code	=(document.getElementById('replacement_code_'+id).value)*1; 
var avg_sales			=(document.getElementById('avg_sales_'+id).value)*1; 
var remarks				=document.getElementById('remarks_'+id).value; 

var mon					=document.getElementById('mon').value;
var year				=document.getElementById('year').value;


var strURL="requisition_delete_ajax.php?dealer_code="+dealer_code+"&qty="+qty+"&purpose="+purpose+"&replacement_code="+replacement_code+"&avg_sales="+avg_sales+"&remarks="+remarks+"&mon="+mon+"&year="+year;

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




function update_value(id){

var dealer_code=id; // Rent
var qty					=(document.getElementById('qty_'+id).value)*1; 
var purpose				=document.getElementById('purpose_'+id).value; 
var replacement_code	=(document.getElementById('replacement_code_'+id).value)*1; 
var avg_sales			=(document.getElementById('avg_sales_'+id).value)*1; 
var remarks				=document.getElementById('remarks_'+id).value; 

var mon					=document.getElementById('mon').value;
var year				=document.getElementById('year').value;



if (status.checked == true){
var sta = 1;}
else
{var sta=0;}

<!--var strURL="requisition_ajax.php?dealer_code="+dealer_code+"&td="+td+"&fd="+fd+"&od="+od+"&hd="+hd+"&lt="+lt+"&ab="+ab+"&lv="+lv+"&lwp="+lwp+"&pre="+pre+"&pay="+pay+"&ot="+ot+"&mon="+mon+"&year="+year+"&remarks="+remarks+"&status="+sta;-->

var strURL="requisition_ajax.php?dealer_code="+dealer_code+"&qty="+qty+"&purpose="+purpose+"&replacement_code="+replacement_code+"&avg_sales="+avg_sales+"&remarks="+remarks+"&mon="+mon+"&year="+year+"&status="+sta;

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

function cal_all(id){


var dealer_code=id; 
var qty					=(document.getElementById('qty_'+id).value)*1; 
var purpose				=document.getElementById('purpose_'+id).value; 
var avg_sales			=(document.getElementById('avg_sales_'+id).value)*1; 
var remarks				=document.getElementById('remarks_'+id).value; 
var replacement_code	=document.getElementById('replacement_code_'+id).value; 

var mon					=document.getElementById('mon').value;
var year				=document.getElementById('year').value;


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
  <th colspan="6"><span style="text-align: center; font-size:18px; color:#09F">Sales Officer Requisition</span></th>
  </tr>
<tr class="oe_list_header_columns">
  <th colspan="6"><span style="text-align: center; font-size:16px; color:#C00">Select Options</span></th>
  </tr>
</thead><tfoot>
</tfoot><tbody>

  <tr  class="alt">
    <td align="right"><strong>Year:</strong></td>
    <td><select name="year" style="width:160px;" id="year" required="required">
		<option <?=($year=='2020')?'selected':''?>>2020</option>
		<option <?=($year=='2021')?'selected':''?>>2021</option>
    </select></td>
    <td align="right"><strong>Department:</strong></td>
    <td colspan="3"><span class="oe_form_group_cell">
      <select name="dept" style="width:160px;" id="dept">
        <option value="Sales">Sales</option>
      </select>
    </span></td>
  </tr>
  <tr >
    <td align="right" class="alt">Concern Company :</td>
    <td align="left" class="alt"><span class="oe_form_group_cell">
      <select name="PBI_ORG" style="width:160px;" id="PBI_ORG" required>
        <option value="2">Sajeeb Corporation</option>
      </select>
    </span></td>
    <td align="right"><strong>Group:</strong></td>
    <td colspan="3"><span class="oe_form_group_cell">
      <select required name="PBI_GROUP" id="PBI_GROUP">
        <? 
		$g_id=find_a_field('user_activity_management','product_group','username="'.$_SESSION['user']['username'].'"');
		foreign_relation('product_group','group_name','group_name',$_POST['PBI_GROUP'],' 1 and group_name="'.$g_id.'"');

$month_find = find_a_field('hrm_portal_setup','mon','1 and level=55');
$dateObj   = DateTime::createFromFormat('!m', $month_find);
$monthName = $dateObj->format('F');			
		
		?>
      </select>
    </span></td>
    </tr>
  <tr >
    <td align="right" class="alt"><strong>Month:</strong></td>
    <td align="left" class="alt"><span class="oe_form_group_cell">
      <select name="mon" style="width:160px;" id="mon" required="required">
<option value="<?=$month_find;?>"><?=$monthName;?></option>
      </select>
    </span></td>
    <td align="right"><strong>Region:</strong></td>
    <td><span class="oe_form_group_cell">
      <select required name="PBI_BRANCH" id="PBI_BRANCH"   onchange="getData2('ajax_zone.php', 'loc', this.value,  this.value)">
        <?
		$b_id=find_a_field('user_activity_management','region_id','username="'.$_SESSION['user']['username'].'"');
		foreign_relation('branch','BRANCH_ID','BRANCH_NAME',$_POST['PBI_BRANCH'],' 1 and BRANCH_ID="'.$b_id.'" order by BRANCH_NAME');?>
      </select>
    </span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td align="right"><strong>Zone:</strong></td>
    <td><span id="loc">
      <select required name="PBI_ZONE" id="PBI_ZONE">
        <? 
		foreign_relation('zon','ZONE_CODE','ZONE_NAME',$_POST['PBI_ZONE'],' 1 and REGION_ID="'.$_POST['PBI_BRANCH'].'" order by ZONE_NAME');?>
      </select>
    </span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
  </tbody></table>
<br /><div style="text-align:center">
<table width="100%" class="oe_list_content">
  <thead>
<tr class="oe_list_header_columns">
  <th colspan="4"><input name="create" type="submit" id="create" value="Open" /></th>
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
        <th>Dealer Code</th>
        <th>Dealer Name</th>
        <th>Area</th>
        <th>Qty</th>
        <th>Purpose</th>
        <th>Old Code</th>
        <th>Average Sales</th>
        <th>Remarks</th>
        <th>&nbsp;</th>
        </tr>
		</thead>
        <tbody>

<!--<input name="fd" type="hidden" id="fd" value="<?=$r_count;?>" />-->
<?		
$sql = "select * from dealer_info 
where product_group='".$_POST['PBI_GROUP']."' and region_id='".$_POST['PBI_BRANCH']."' and zone_id='".$_POST['PBI_ZONE']."'
and canceled='Yes' order by dealer_code";
		
$query = db_query($sql);
	while($info=mysqli_fetch_object($query)){

$att = find_all_field('hrm_requisition','','dealer_code="'.$info->dealer_code.'" and mon="'.$mon.'" and year="'.$year.'" ');		

if($att->status=='apply')
$status='Edit';
elseif($att->status=='approve')
$status='approved';
elseif($att->status=='send')
$status='send';
else
$status='Save';



?>
<tr style="font-size:10px; padding:3px; ">
		  <td><?=++$S?></td>
          <td><?=$info->dealer_code?><input type="hidden" name="dealer_code" id="dealer_code" value="<?=$info->dealer_code?>" /></td>
          
		  <td><?=$info->dealer_name_e?></td>
		  <td><?=find_a_field('area','AREA_NAME','AREA_CODE="'.$info->area_code.'"');?></td>


<td align="center">
<input name="qty_<?=$info->dealer_code?>" type="text" id="qty_<?=$info->dealer_code?>" 
style="font-size:10px; width:20px; min-width:20px;" 
value="<?=($data->qty=='')?$att->qty:$data->qty;?>" size="2" maxlength="2"/>
</td>

<td align="center">
<select name="purpose_<?=$info->dealer_code?>" id="purpose_<?=$info->dealer_code?>">
<option><?=($data->purpose=='')?$att->purpose:$data->purpose;?></option>
<option value="Resign">Resign</option>
<option value="New">New</option>
</select> 
</td>


<td align="center">
<input name="replacement_code_<?=$info->dealer_code?>" type="text" id="replacement_code_<?=$info->dealer_code?>" 
style="font-size:10px; width:100px; min-width:20px;" 
value="<?=($data->replacement_code=='')?$att->replacement_code:$data->replacement_code;?>" 
size="2" />
</td>



<td align="center">
<input name="avg_sales_<?=$info->dealer_code?>" type="text" id="avg_sales_<?=$info->dealer_code?>" 
style="font-size:10px; width:100px; min-width:28px;" 
value="<?=($data->avg_sales=='')?$att->avg_sales:$data->avg_sales;?>" size="4" />
</td>





<td align="center">
<input name="remarks_<?=$info->dealer_code?>" type="text" id="remarks_<?=$info->dealer_code?>" 
style="font-size:10px; width:100px; min-width:20px;" 
 value="<?=$att->remarks;?>" size="10"  /></td>
 
<td align="center"><span id="divi_<?=$info->dealer_code?>">
<? 
			
	

  if($status=='Edit')
  {
  if($_SESSION['user']['level']==5||$_SESSION['user']['level']==55)
  { ?>
<input type="button" name="Button" value="<?=$status?>"  onclick="cal_all(<?=$info->dealer_code?>), update_value(<?=$info->dealer_code?>)" 
style="font-size:10px;"/>
<input type="button" name="Button" value="Delete"  onclick="delete_value(<?=$info->dealer_code?>)" style="font-size:10px;"/>
<?
  } else echo 'Saved';
  
  } elseif($status=='Save') {
  ?>
  
  <input type="button" name="Button" value="<?=$status?>"  
  onclick="cal_all(<?=$info->dealer_code?>), update_value(<?=$info->dealer_code?>)" 
  style="font-size:10px; background-color:#00FF00"/>
  
<? }elseif($status=='send') {

echo 'HR Approve';

   }
  
  else{ echo 'Approved';} ?>
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