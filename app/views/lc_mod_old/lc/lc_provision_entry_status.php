<?php
//
//

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='L/C Provision Statement';
$proj_id=$_SESSION['proj_id'];
$active='transstle';
do_calander('#fdate');
do_calander('#tdate');

//auto_complete_from_db('accounts_ledger','ledger_id','ledger_id','1','ledger_id');

create_combobox('ledger_id');

//create_combobox('cc_code');

if(isset($_REQUEST['show']))
{
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];


if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'];
//if(isset($_REQUEST['ledger_id'])&&$_REQUEST['ledger_id']!=''&&$_REQUEST['ledger_id']!='%')
//$report_detail.='<br>Ledger Name : '.find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST["ledger_id"].' ');
//if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')
//$report_detail.='<br>Cost Center: '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);

}
?>


<style>
.box_report{
	border:3px solid cadetblue;
	background:aliceblue;
}
.custom-combobox-input{
width:217px!important;
}
</style>






<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report" ><form id="form1" name="form1" method="post" action="">
									<table width="100%" border="0" cellspacing="2" cellpadding="2">
                                      <tr>
                                        <td width="24%"  align="right">
		                                        Period :   </td>
                                        <td width="18%"  align="left"><input name="fdate"  type="text" id="fdate" size="12" class="form-control" style="max-width:250px;" value="<?php echo $_REQUEST['fdate'];?>" /> </td>
										
                                        <td width="7%"  align="center">TO</td>
                                        <td width="51%" align="left"><input name="tdate" type="text" id="tdate" size="12" class="form-control" style="max-width:250px;" 
											value="<?=isset($_REQUEST['tdate'])?$_REQUEST['tdate']:date('Y-m-d');?>"/></td>
                                      </tr>
                                      <tr>
                                        <td  align="right">L/C Number:</td>
                                        <td colspan="3"  align="left">
										<select name="ledger_id" id="ledger_id"  class="form-control" style="float:left"  >

										<option></option>
										
										<?	//foreign_relation('lc_number_setup','ledger_id','lc_number',$_POST['ledger_id'],"1  order by ledger_id");?>
										
 <?	foreign_relation('lc_number_setup l,lc_bank_entry b','l.ledger_id','b.bank_lc_no',$_POST['ledger_id'],"l.id=b.lc_no  order by ledger_id");?>
										</select></td>
                                      </tr>
                                      <tr>
                                        <td align="right">Company:</td>
                                        <td width="18%" align="left"><!--<input type="text" class="form-control" style="max-width:250px;" name="ledger_id" id="ledger_id" value="<?php echo $_REQUEST['ledger_id'];?>" size="50" />-->
										
										<select name="group_for" id="group_for"  class="form-control" style="float:left"  >

										<option></option>
										
										<?	foreign_relation('user_group','id','group_name',$_POST['group_for'],"id not in (7,8)  order by id");?>
										</select>										</td>
                                        <td width="7%" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php /*?><? if($_REQUEST['ledger_id']>0) echo find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST['ledger_id']);?><?php */?>&nbsp;</td>
                                      </tr>
									  
									 
                                       
                                      <?php /*?><tr>
                                        <td align="right">Cost Center : </td>
                                        <td colspan="2" align="left"><select name="cc_code" id="cc_code" style="width:250px;" class="form-control" >
										<option value="<?php echo $_REQUEST['cc_code'];?>"></option>
											<? foreign_relation('cost_center cc, cost_category c','cc.id','cc.center_name',$_POST['cc_code'],"cc.category_id=c.id and c.group_for='".$_SESSION['user']['group']."' ORDER BY id ASC");?>
										</select></td>
                                      </tr><?php */?>
                                      <tr>
                                        <td colspan="4" align="center" style="padding:13px;"><input class="btn btn-primary" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td align="right"><? include('PrintFormat.php');?></td>
								  </tr>
								  <tr>
									<td><div id="reporting">
									<table id="grp"  class="tabledesign table-bordered table-condensed" width="100%" cellspacing="0" cellpadding="2" border="0">
							  <tr>
								<th  height="20" align="center">SL</th>
								<th  align="center">Acc Name</th>
								
							    <th  align="center">Status View </th>
							  </tr>
<?php
if(isset($_REQUEST['show']))
{


	//if($_POST['fdate']!=''&&$_POST['tdate']!='') $date_con .= ' and payment_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
	
	$f_date=$_POST['fdate'];
	$t_date=$_POST['tdate'];
	
	
		if($_POST['group_for']!='')
		$group_for_con .= ' and l.group_for = "'.$_POST['group_for'].'" ';
		
		if($_POST['ledger_id']!='')
		$ledger_id_con .= ' and l.ledger_id = "'.$_POST['ledger_id'].'" ';
	


 		
		
		
		
		
		
		
		
		
		
	

	 $sql1="select l.group_for, u.company_name, u.group_name from user_group u, lc_number_setup l where u.id=l.group_for ".$group_for_con.$ledger_id_con." group by l.group_for  order by l.group_for";

	$query1 = db_query($sql1);
	while($data1 = mysqli_fetch_object($query1))
	
{
  ?>
  
  
  <tr>
    <td colspan="2" align="left" bgcolor="aliceblue"><strong>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$data1->group_name;?>
    </strong></td>
    
    <td align="right" bgcolor="aliceblue">&nbsp;</td>
  </tr>
	<?
	
	

	
	 $sql2="select l.id, l.lc_number, l.ledger_id as lc_ledger, l.status from lc_number_setup l where l.group_for='".$data1->group_for."' ".$group_for_con.$ledger_id_con."  order by l.group_for, l.lc_number";

	$query2 = db_query($sql2);
	while($data2 = mysqli_fetch_object($query2))
	
{
	
	?>
	
	
	
	<tr <?=($xx%2==0)?' bgcolor="#EDEDF4"':'';$xx++;?>>
    <td align="center"><?=++$sl2;?></td>
    <td align="left"><a href="transaction_listledger.php?show=show&fdate=<?=$_REQUEST['fdate']?>&tdate=<?=$_REQUEST['tdate']?>&ledger_id=<?=$data2->lc_ledger?>" target="_blank" style=" color:#000000; text-decoration:none; font-size:14px; text-transform:uppercase;"><?=$data2->lc_number;?></a></td>
    
	<td><div align="center"><a href="lc_provision_print_view.php?lc_no=<?=$data2->id?>" target="_blank" style=" color:#000000; text-decoration:none; font-size:12px; padding: 2px 5px;
	 background:  #99CCFF; font-weight:700; margin: 3px 3px; border:1px solid #000000; hover: none; ">Click Me</a></div></td>
	</tr>
	
	
	<?  }?>
 
    
  <? } ?>
  
  
  
  
  <?php }?>
</table> 
									</div>
		<div id="pageNavPosition"></div>									
		</td>
		</tr>
		</table>
		</div></td>    
  </tr>
</table>

<?
//
//
require_once SERVER_CORE."routing/layout.bottom.php";
?>