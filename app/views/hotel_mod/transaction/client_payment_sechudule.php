<?php
require_once "../../../assets/template/layout.top.php";
$title='Client Payment Shedule';

//echo $proj_id;

?>

<style type="text/css">
<!--
.style1 {
	color: #000000;
	font-size: 12px;
}
-->
</style>
<div class="form-container_large">
<form action="" method="post" name="form2" id="form2">
<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
			<fieldset>
			<legend>Project Details</legend>
			<div>
			<label>Project : </label>
			<select name="proj_code" id="proj_code">
<? if(isset($_REQUEST['proj_code'])) $proj_code=$_REQUEST['proj_code'];
foreign_relation('tbl_project_info','proj_code','proj_name',$proj_code);?>
              </select>
			</div>
			<div>
			<label for="email">Category : </label>
			<span id="bld">
<select name="building" id="building" onchange="getData2('../../common/flat_option_mhafuz.php', 'fid', document.getElementById('proj_code').value,this.value);">
<? 
foreign_relation('tbl_building_info','bid','category','');
?>
</select></span>			</div>
			<div>
			<label for="fname">Allotment no. : </label>
			<? if(isset($_REQUEST['flat'])) $flat=$_REQUEST['flat'];?>
				<span id="fid">
				<select name="flat" id="flat">
				<? foreign_relation('tbl_flat_info','fid','flat_no',$flat);?>
				</select></span>			</div>
			<div class="buttonrow" style="margin-left:154px;"><input name="submit" type="submit" class="btn1" value="Search details " /></div>
			</fieldset>	</td>
    <td>
			<fieldset>
			<legend>Client Details</legend>
			<div>
			<label>Name : </label>
<?
if(isset($_POST['submit']))
{
$flat=$_POST['flat'];
$sql="select * from tbl_flat_info where fid=".$flat." limit 1";
$q=mysql_query($sql);
if(mysql_num_rows($q)>0)
$data=mysql_fetch_object($q);


$sql="select a.* from tbl_party_info a where a.party_code=".$data->party_code." limit 1";
$i=mysql_query($sql);
if(mysql_num_rows($i)>0){
$info=mysql_fetch_object($i);
$client_info=$info->party_name;
$address=$info->per_house.', '.$info->per_road .', '.$info->per_village .', '.$info->per_postoffice 	.', '.$info->per_district;
$mobile=$info->ah_mobile_tel;
}
}
?> 
			<input  name="" type="text" id="" value="<?=$client_info?>"/>
			</div>
			<div>
			<label for="email">Address : </label>
			<span id="bld">
			<textarea name="" id=""><?=$address?></textarea>
			</span>                                        </div>
			<div>
			<label for="fname">Mobile no. : </label>
			<span id="fid">
			<input  name="" type="text" id="" value="<?=$mobile?>"/>
			</span>                                        </div>
			</fieldset>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div><div class="box4">
<? if(isset($flat)&&$flat!='')
{$res='select a.rec_no,c.pay_desc,a.inst_no,a.inst_date,a.inst_amount,a.rcv_amount from tbl_flat_cost_installment a,tbl_flat_info b,tbl_payment_head c where a.pay_code=c.pay_code and a.proj_code=b.proj_code and a.build_code=b.build_code and a.flat_no=b.flat_no and b.fid='.$flat.' order by inst_date';

$res1='select sum(a.inst_amount),sum(a.rcv_amount) from tbl_flat_cost_installment a,tbl_flat_info c where a.flat_no=c.flat_no and a.build_code=c.build_code and a.proj_code=c.proj_code and c.fid='.$flat.' limit 1';
$data=mysql_fetch_row(mysql_query($res1));

		?>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">
        <? 
//$res='select * from tbl_receipt_details where rec_no='.$str.' limit 5';
echo link_report($res);
		?>

      </div></td>
    </tr>
	    <tr>
      <td><table width="55%" border="0" cellspacing="2" cellpadding="0" align="right">
        <tr>
          <td > Total : </td>
          <td ><input name="user_id" type="text" id="user_id" value="<?=$data[0]?>" /></td>
          <td ><input name="name" id="name" type="text" value="<?=$data[1]?>" /></td>
        </tr>
      </table></td>
    </tr>
	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table><? }else {?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>
      <td><div class="tabledesign2">

 		  <table width="100%" cellspacing="0" cellpadding="0" id="grp"><tbody><tr><th>Pay Desc</th><th>Inst No</th><th>Inst Date</th><th>Inst Amount</th><th>Rcv Amount</th></tr><tr><td>&nbsp;</td>
  		 		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  		 		<td>&nbsp;</td>
  		 		</tr><tr class="alt"><td>&nbsp;</td>
  		 		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  		 		<td>&nbsp;</td>
  		 		</tr><tr><td>&nbsp;</td>
  		 		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  		 		<td>&nbsp;</td>
  		 		</tr><tr class="alt"><td>&nbsp;</td>
  		 		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  		 		</tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  		 		</tr><tr class="alt"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
  		 		<td>&nbsp;</td>
  		 		</tr></tbody>
 		  </table>
  		 		</div></td>
    </tr>
	    <tr>
      <td><table width="55%" border="0" cellspacing="2" cellpadding="0" align="right">
        <tr>
          <td > Total : </td>
          <td ><input name="user_id" type="text" id="user_id" value="<?=$data[0]?>" /></td>
          <td ><input name="name" id="name" type="text" value="<?=$data[1]?>" /></td>
        </tr>
      </table></td>
    </tr>
	
	

				
    <tr>
     <td>

 </td>
    </tr>
  </table>

<? }?></div>
<?
require_once "../../../assets/template/layout.bottom.php";
?>