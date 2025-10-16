<?php
session_start();

ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Import Varification';
$now=time();
do_calander('#do_date_fr');
do_calander('#do_date_to');
$depot_id = $_POST['depot_id'];
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

var item_id=id; // Rent
var ra=(document.getElementById('ra_'+id).value)*1;
var flag=(document.getElementById('flag_'+id).value); 
if(ra>0){
var strURL="received_amt_ajax.php?item_id="+item_id+"&ra="+ra+"&flag="+flag;}
else
{
alert('Receive Amount Must be Greater Than Zero.');
document.getElementById('ra_'+id).value = '';
document.getElementById('ra_'+id).focus();
return false;
}

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

</script>
				<form id="form2" name="form2" method="post" action="">	

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td><table width="50%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FF9999">
              <tr>
<td><div align="right"><strong>Import Date :</strong></div></td>
<td><input name="do_date_fr" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?$_POST['do_date_fr']:date('Y-01-01');?>" style="width:150px;" readonly="readonly"/></td>
<td>-to-</td>
<td><input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?$_POST['do_date_to']:date('Y-m-d')?>" style="width:150px;" readonly="readonly"/></td>
<td rowspan="2"><input type="submit" name="submitit" id="submitit" value="View Chalan" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Checked : </strong></div></td>
                <td colspan="3"><div align="left"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <select name="checked" id="checked" style="width:250px;">
                      <option></option>
                      <option <?=($_POST['checked']=='NO')?'Selected':'';?>>NO</option>
                      <option <?=($_POST['checked']=='YES')?'Selected':'';?>>YES</option>
                    </select>
                </span></div></td>
                </tr>
				              <tr>
                <td><div align="right"><strong>Warehouse : </strong></div></td>
                <td colspan="3"><div align="left"><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                    <select name="depot_id" id="depot_id" style="width:250px;">
                      <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['depot_id'],'group_for=3 
					  and use_type in("SD","WH") order by warehouse_name');?>
                    </select>
                </span></div></td>
                </tr>
              

            </table></td>
	    </tr>
		<tr><td align="right"><? include('PrintFormat.php');?></td></tr>
        <tr>
          <td>
		  <? if($_POST['do_date_fr']!=''){
		  

$i=0;

$datefr = strtotime($_POST['do_date_fr']);
$dateto = strtotime($_POST['do_date_to']);
$day_from = mktime(0,0,0,date('m',$datefr),date('d',$datefr),date('y',$datefr));
$day_end =  mktime(23,59,59,date('m',$dateto),date('d',$dateto),date('y',$dateto));
if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];

		if($depot_id>0) $depot_con = ' and SUBSTR(j.tr_no,7,2)='.$depot_id;
		if($_POST['checked']!='') $checked_con = ' and j.checked="'.$_POST['checked'].'" ';

		if($_POST['depot_id']>0) $depot_con = ' and r.warehouse_id="'.$_POST['depot_id'].'" ';


$sql="SELECT j.tr_no,
				  sum(j.dr_amt) as dr_amt,
				  sum(j.cr_amt) as cr_amt,
				  j.jv_date,
				  j.jv_no,
				  l.ledger_name,
				  j.tr_id,
				  j.user_id,
				  j.entry_at,
				  j.checked,
				  j.jv_no,
				  u.fname,r.ch_no
				
				FROM secondary_journal j, accounts_ledger l, purchase_receive r, user_activity_management u
				WHERE
					r.pr_no=j.tr_no	and j.dr_amt>0 and 
				  j.user_id=u.user_id and
				  j.tr_from = 'Import' AND 
				  j.ledger_id = l.ledger_id AND 
				  j.jv_date between '".$day_from."' AND '".$day_end."'  ".$group_s." 
				  ".$depot_con.$checked_con.$dealer_type_con.$dealer_group_con." 
				

				group by  j.jv_no
				order by tr_no";
// 				and u.warehouse_id not in(5)				
	  $query=db_query($sql);
	  
		  ?>
      <table id="grp" width="98%" align="center" cellspacing="0" class="tabledesign">
      <tbody>
      <tr>
      <th>SL</th>
      <th>CH#</th>
      <th>Party Name</th>
      <th>LC Info </th>
      <th>Import By </th>
      <th>Total Amt</th>
      <th>&nbsp;</th>
      <th>Checked?</th>
      </tr>
	  <?
 
	  while($data=mysqli_fetch_object($query)){
	  $pr_amount = find_a_field('purchase_receive','sum(amount)','pr_no="'.$data->tr_no.'"');
	  $received = $received + ($pr_amount);
	  ?>

      <tr <?=($i%2==0)?'class="alt"':'';?>>
      <td align="center"><div align="left"><?=++$i;?></div></td>
      <td align="center"><div align="left"><? echo $data->tr_no;?></div></td>
      <td align="center"><div align="left"><? echo $data->ledger_name;?></div></td>
      <td align="center"><div align="left"><? echo $data->ch_no;?></div></td>
      <td align="center"><div align="left"><?=$data->fname;?><br><? echo $data->entry_at;?></div></td>
      <td align="right"><?=number_format(($pr_amount),2);?></td>
      <td align="center"><a target="_blank" href="import_sales_sec_print_view.php?jv_no=<?=$data->jv_no ?>">
<input name="radio_<?=$data->jv_no;?>" type="radio" value="" <?=($data->checked=='YES')?'checked="checked"':'';?>  style="width:20px;" />
      </a></td>
      <td align="center"><span id="divi_<?=$data->tr_no?>">
<? 
if(($data->checked=='YES')){
?>
<input type="button" name="Button" value="YES"  onclick="window.open('import_sales_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" style=" font-weight:bold;width:40px; height:20px;background-color:#66CC66;"/>
<?
}elseif(($data->checked=='NO')){
?>
<input type="button" name="Button" value="NO"  onclick="window.open('import_sales_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" style="font-weight:bold;width:40px; height:20px;background-color:#FF0000;"/>
<? }?>
          </span></td>
      </tr>
	  <? }?>
	        <tr class="alt">
        <td colspan="5" align="center"><div align="right"><strong>Total Amt : </strong></div>
          
            <div align="left"></div></td>
        <td align="right"><?=number_format($received,2);?></td>
        <td align="center">&nbsp;</td>
        <td align="center"><div align="left"></div></td>
      </tr>
  </tbody></table>
  <? }?>
  </td>
	    </tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>
		<div>
                    
		<table width="100%" border="0" cellspacing="0" cellpadding="0">		
		<tr>		
		<td>
		<div style="width:380px;"></div></td>
		</tr>
		</table>
	        </div>
		</td>
		</tr>
      </table></td></tr>
</table>
</form>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>