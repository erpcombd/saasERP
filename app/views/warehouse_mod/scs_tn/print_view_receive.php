<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

if ($_SESSION['user']['depot']==51 || $_SESSION['user']['depot']==2){ $tdate = 200;}else{$tdate = 7;}


$unique_master='pi_no';
$req_no 		= $_REQUEST['req_no'];

$group = find_all_field('user_group','','id="'.$_SESSION['user']['group'].'"');


		  $barcode_content = $req_no;
		  $barcodeText = $barcode_content;
          $barcodeType='code128';
		  $barcodeDisplay='horizontal';
          $barcodeSize=40;
          $printText='';


if(prevent_multi_submit()){
if(isset($_POST['rec']))
{
		$pi_no=$req_no;
		$_POST['status']='RECEIVED';
		$_POST['received_by']=$_SESSION['user']['id'];
		$_POST['received_at']=date('Y-m-d H:i:s');
		$sql = 'update production_issue_master set status = "'.$_POST['status'].'", rec_sl_no = "'.$_POST['rec_sl_no'].'", receive_date = "'.$_POST['receive_date'].'", received_by = "'.$_POST['received_by'].'", received_at = "'.$_POST['received_at'].'" where pi_no="'.$req_no.'"';
		db_query($sql);
		

$table_detail='production_issue_detail';
$sql="select * from ".$table_detail." where  pi_no='$req_no'";
$data=db_query($sql);


$master = $pi = find_all_field('production_issue_master','','pi_no='.$req_no);
$warehouse_to = $master->warehouse_to;
$warehouse_from = $master->warehouse_from;






// ------------------------------------------------ Secondary Journal 
if($warehouse_from==5){ // HFL

$cr_head = '1078000200010000'; // cr // goods in transit
$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$pi->warehouse_to);
//$ledger = find_a_field('config_group_class','purchase_ledger','group_for=2');	
// dr.
$dr_head = find_a_field('warehouse','ledger_id','warehouse_id='.$_SESSION['user']['depot']);	
$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;

//auto_insert_sale_sc_in($pi->pi_date,$dr_head,$cr_head,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$pi_no),$pi_no,$cc_code,$narration);
auto_insert_store_transfer_receive($pi->receive_date,$dr_head,$cr_head,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);

}
elseif($warehouse_from==17) // Agro
{

				if($_SESSION['user']['group']==3 && $_SESSION['user']['depot']==5){
				$sales_ledger = '2043000101960000';
				$ledger_dr ='1079000400030001';
				
				}elseif($_SESSION['user']['group']==3 && $_SESSION['user']['depot']!=5){
				$sales_ledger = '1097000300050002'; // cr. head
				$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code 
				and w.warehouse_id='.$pi->warehouse_to);
				//$ledger = find_a_field('config_group_class','purchase_ledger','group_for=2');	
				$ledger_dr = find_a_field('warehouse','ledger_id','warehouse_id='.$_SESSION['user']['depot']);	
				}
$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;
auto_insert_sale_sc_in($pi->pi_date,$ledger_dr,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$pi_no),$pi_no,$cc_code,$narration);
		
		
}
elseif($warehouse_from==68) // Flour mill
{
				if($_SESSION['user']['group']==333){ // hfl 
				$sales_ledger = '2043000103410000';
				$ledger_dr = '1079000400030001';
				
				}elseif($_SESSION['user']['group']==4){ //agro
				$sales_ledger = '1126000300010000';
				$ledger_dr = '1127000100030001';
				$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code 
				and w.warehouse_id='.$pi->warehouse_to);
				}
				
				
				elseif($_SESSION['user']['group']==3){ // sajeeb
				$sales_ledger = '1097000300040002'; // cr head
				$ledger_dr = find_a_field('warehouse','ledger_id','warehouse_id='.$_SESSION['user']['depot']);	
				$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code 
				and w.warehouse_id='.$pi->warehouse_to);
				}
				//$ledger = find_a_field('config_group_class','purchase_ledger','group_for=2');	
				
				$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;
				auto_insert_sale_sc_in($pi->pi_date,$ledger_dr,$sales_ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$pi_no),$pi_no,$cc_code,$narration);
		
		
}
else // LAST ELSE (From sajeeb corporation to others) 
{
	
		if($_SESSION['user']['group']==10){ // user company Flour mill
		$sales_ledger = '3030000100050000';
		$ledger = '1119000100040003';	
		$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;
		auto_insert_store_transfer_receive($pi->receive_date,$sales_ledger,$ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);
			
		}elseif($_SESSION['user']['group']==4){ // Agro user receive form sc
		$sales_ledger = '1126000100020000';
		$ledger = find_a_field('warehouse','ledger_id','warehouse_id='.$_SESSION['user']['depot']);		
		$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;
		auto_insert_store_transfer_receive($pi->receive_date,$sales_ledger,$ledger,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);
			
		
		}elseif($_SESSION['user']['depot']==51){ // sajeeb to damage
		$cr_head = '1078000200010000'; // cr head Goods In Transit (Depot To Depot)(SC)
		$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$_SESSION['user']['depot']);
		$dr_head = '4026000200010000';	
		$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;
		auto_insert_store_transfer_receive($pi->receive_date,$dr_head,$cr_head,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);		
				
		
		}else{
		$cr_head = '1078000200010000'; // cr head Goods In Transit (Depot To Depot)(SC)
		$cc_code = find_a_field_sql('select c.id from cost_center c, warehouse w where c.cc_code=w.acc_code and w.warehouse_id='.$_SESSION['user']['depot']);
		$dr_head = find_a_field('warehouse','ledger_id','warehouse_id='.$_SESSION['user']['depot']);	
		$narration = 'PI No-'.$pi_no.'||RSL-'.$pi->rec_sl_no.'||RecDt:'.$pi->receive_date;
		auto_insert_store_transfer_receive($pi->receive_date,$dr_head,$cr_head,$pi_no,find_a_field('production_issue_detail','sum(total_amt)','pi_no='.$$unique_master),$pi_no,$cc_code,$narration);
		}
} // END LAST IF
		
while($all=mysqli_fetch_object($data)){
++$i;

	//	if($warehouse_to == 5)
	//	$_POST['unit_pricer']= find_a_field('item_info','p_price','item_id='.$all->item_id);
	//	else
		$_POST['unit_pricer']= find_a_field('item_info','f_price','item_id='.$all->item_id);


journal_item_control($all->item_id ,$warehouse_to,$_POST['receive_date'],$all->total_unit,'0','Transfered',$all->id,$_POST['unit_pricer'],$warehouse_from,$pi_no);
db_query('update journal_item set tr_from="Transfered" where tr_no="'.$all->id.'" and tr_from="Transit"');
}
	
}
}
do_calander('#receive_date');

$sql="select * from production_issue_master where  pi_no='$req_no'";
$data=db_query($sql);
$all=mysqli_fetch_object($data);



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>.: FG Challan Copy :.</title>
<link href="../../../assets/css/invoice.css" type="text/css" rel="stylesheet"/>
<?php include("../../../../public/assets/css/theme_responsib_new_table_report.php");?>
<script type="text/javascript">
function hide()
{
    document.getElementById("pr").style.display="none";
}
</script>
<style type="text/css">
<!--
.style1 {font-weight: bold}
.style11 {
	font-size: 16px;
	font-weight: bold;
}
.style14 {font-weight: bold}
.style12 {
	font-size: 16px;
	font-weight: normal;
}
.style4 {	font-size: 18px;
	color: #000000;
}
.style6 {font-size: 10px}
.style15 {
	color: #FF0000;
	font-weight: bold;
}
.style17 {color: #006600}
-->
</style>
</head>
<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div class="header">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
             
			 <tr>
					<td><div class="header">
						<table class="table1">
						<tr>
						<td class="logo">
							<img src="<?=SERVER_ROOT?>public/uploads/logo/<?=$_SESSION['proj_id']?>.png" class="logo-img"/>
						</td>
						
						<td class="titel" style="font-size:11px">
								<h2 class="text-titel"> <?=$group->group_name?> </h2>			
								<p class="text"><?=$group->address?></p>
								<p class="text">Cell: <?=$group->mobile?>. Email: <?=$group->email?> <br> <?=$group_data->vat_reg?></p>
								<p class="text">
									 <? $war=find_all_field('warehouse','','warehouse_id='.$all->warehouse_id);
									  echo $war->warehouse_name;?>
								</p>
						</td>
						
						
						<td class="Qrl_code">
									<?='<img class="barcode Qrl_code_barcode" alt="'.$barcodeText.'" src="barcode.php?text='.$barcodeText.'&codetype='.$barcodeType.'&orientation='.$barcodeDisplay.'&size='.$barcodeSize.'&print='.$printText.'"/>' ?>
							<p class="qrl-text"><?=$all->pi_no;?></p>
						</td>
						
						</tr>
						 
						</table>
					</div></td>
				  </tr>
				  
				  <tr><td colspan="4"><hr /></td></tr>
			 
			 
			 

              <tr>
                <td>
				<div class="header_title">
				Store To Store Chalan Copy				</div></td>
              </tr>
              <tr>
                <td height="19">&nbsp;</td>
              </tr>
            </table></td>
          </tr>

        </table></td>
	    </tr>
	  <tr>
	    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
            <td width="22%" valign="bottom">&nbsp;</td>
		    <td width="24%" valign="bottom"><span class="style11">
		      <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_from);?>
            </span></td>
		    <td width="9%" valign="bottom">TO</td>
		    <td width="45%"><span class="style11">
              <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_to);?>
            </span></td>
		    </tr>
		  <tr>
		    <td valign="bottom">&nbsp;</td>
		    <td valign="bottom">&nbsp;</td>
		    <td valign="bottom">&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
		  <tr>
		    <td colspan="4" valign="bottom">
			<? if($all->status=='SEND'){?>
			
			<? if($_SESSION['user']['level']!=='1'){ ?>
			
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFCC99">
              <tr>
                <td><div align="center" class="style15">IN TRANSIT </div></td>
              </tr>
			                <tr>
                <td><form id="form1" name="form1" method="post" action="">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25%" bgcolor="#FFFFCC"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Receive Date : </strong></td>
                      <td width="25%" bgcolor="#FFFFCC"><label>
                        <select name="receive_date" id="receive_date" required />
						<? for($i=0;$i<$tdate;$i++){?>
						<option><?=date('Y-m-d',time()-(24*60*60*$i));?></option>
						<? }?>
                        </select>
                      </label></td>
                      <td width="25%" bgcolor="#FFFFCC"><div align="right"><strong>Rec SL No : </strong></div></td>
                      <td width="25%" bgcolor="#FFFFCC"><label>
                        <input type="text" name="rec_sl_no" style="width:80px;" />
                      </label></td>
                      <td width="50%" bgcolor="#FFFFCC"><div align="center">
                        <input name="rec" type="submit" id="rec" value="Received" />
                      </div></td>
                    </tr>
                  </table>
                                </form>
                </td>
              </tr>
            </table><? } }?>
			
			
		    <? if($all->status=='RECEIVED'){?><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCFFCC">
                <tr>
                  <td><div align="center"><strong>
	<span class="tabledesign style17" style=" text-transform: uppercase;">(<?='Received Date: '.$all->receive_date.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Receive SL No: '.$all->rec_sl_no?>)&nbsp;</span></strong></div></td>
                </tr>
              </table><? }?>
			</td>
		    </tr>
		</table>		</td>
	  </tr>
    </table>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    
	<td>	</td>
    <td></td>
  </tr>
  <tr>
    <td><div class="line"></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div class="header2">
          <div class="header2_left" style="height:30px;">
        <p><strong>PI  No</strong>: <span class="style14">
          <?=$all->pi_no;?>
          </span><br /><strong>Send Date</strong>: <?=$all->pi_date;?><br />
          
        </p>
      </div>
      <div class="header2_right">
        <p>
          <strong class="">SL No</strong>: <strong class=""><?php echo $all->remarks;?></strong><br />
          Carried By: <?php echo $all->carried_by;?><br />
        </p>
      </div>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div id="pr">
<div align="left">
<form action="" method="get">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="1"><input name="button" type="button" onclick="hide();window.print();" value="Print" /></td>
  </tr>
</table>
</form>
</div>
</div>
<table width="100%" class="tabledesign" border="1" bordercolor="#000000" cellspacing="0" cellpadding="0">
       <tr>
        <td width="2%"><strong>SL.</strong></td>
        <td><strong>FG</strong></td>
        <td><strong>Description of the Goods </strong></td>
        <td><strong>OP Date</strong></td>
        <td><strong>Crt</strong></td>
        <td><strong>Pcs</strong></td>
        </tr>
	  <?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;
$sql2="select * from production_issue_detail where  pi_no='$req_no'";
$data2=db_query($sql2);
//echo $sql2;
while($info=mysqli_fetch_object($data2)){ 
$pi++;

$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);
if($item->item_id){
?>
      <tr>
        <td valign="top"><?=$pi?></td>
        <td align="left" valign="top"><?=$item->finish_goods_code?></td>
        <td align="left" valign="top"><span class="style12">
          <?=$item->item_name?>
        </span></td>
        <td align="left" valign="top"><?=$info->old_production_date?></td>
        <td valign="top"><div align="right">
          
          <?=(int)$crt[$i]=@($info->total_unit/$item->pack_size); $t_crt = $t_crt + ((int)$crt[$i]);?>
                </div></td>
        <td valign="top">
          <div align="right">
            
            <?=(int)$pcs[$i]=@($info->total_unit%$item->pack_size); $t_pcs = $t_pcs + ((int)$pcs[$i]);?>
              </div></td>
        </tr>
      
<? }}?>
<tr>
        <td colspan="4" valign="top"><div align="right"><strong>Total:</strong></div></td>
        <td valign="top"><div align="right"><span class="style1">
          <?=$t_crt?>
        </span></div></td>
        <td valign="top"><div align="right"><span class="style1">
          <?=$t_pcs?>
        </span></div></td>
</tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
	<div class="footer1"><strong><br />
    </strong>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  
	  
	  	<tr>
			<td width="33%"><?=find_a_field('user_activity_management','fname','user_id='.$all->entry_by)?></td>
			<td width="33%"><?=find_a_field('user_activity_management','fname','user_id='.$all->received_by)?></td>
			<td width="33%">&nbsp;</td>
		
		</tr>
	  	<tr>
			<td width="33%">--------------------</td>
			<td width="33%">--------------------</td>
			<td width="33%">--------------------</td>
		
		</tr>
	  	<tr>
			<td width="33%">Prepared By:</td>
			<td width="33%">Received By</td>
			<td width="33%">Store Incharge</td>
		
		</tr>
        
		
		
      </table>
	  <tr>
			<td colspan="4"><?php include("../../../assets/template/report_print_buttom_content.php");?></td>
		</tr>
         </div>
	</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</body>
</html>
