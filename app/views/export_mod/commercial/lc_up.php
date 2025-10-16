<?php

//

//


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='LC Information Update';

create_combobox('lc_no');
create_combobox('dealer_code');

create_combobox('dealer_pi');

do_calander('#ldbc_date');
do_calander('#acceptance_date');
do_calander('#maturity_date');
do_calander('#realized_date');
do_calander('#purchase_date');




$condition = "lc_no='".$_POST['lc_no']."'";

$data = db_fetch_object('lc_master', $condition);

while (list($key, $value) = @each($data)) {
		$$key = $value;
	}





if(isset($_POST['confirm'])){

 $sql='update lc_master set 
ldbc_no="'.$_POST['ldbc_no'].'",
ldbc_date="'.$_POST['ldbc_date'].'",
valueccc="'.$_POST['valueccc'].'",
acceptance_date="'.$_POST['acceptance_date'].'",
purchase_parcent="'.$_POST['purchase_parcent'].'",
purchase_date="'.$_POST['purchase_date'].'",
maturity_date="'.$_POST['maturity_date'].'",
maturity_usd="'.$_POST['maturity_usd'].'",
realized_value="'.$_POST['realized_value'].'",
realized_date="'.$_POST['realized_date'].'",
ldbp_no="'.$_POST['ldbp_no'].'",
dsc_amt="'.$_POST['dsc_amt'].'"


 where lc_no="'.$_POST['lc_no'].'"';

	
db_query($sql);




	 	

}




else

{

	$type=0;

	$msg='Data Re-Submit Warning!';

}






?>



<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 280px;
    height: 38px;
    border-radius: 0px !important;
}



</style>



<div class="form-container_large">

<form action="" method="post" name="codz" id="codz">

<table width="80%" border="0" align="center">
      <tr>
        <td width="16%" align="right" bgcolor="#FF9966"><strong>LC No:</strong></td>
        <td width="40%" bgcolor="#FF9966">
		<select name="lc_no" id="lc_no" required style="width:280px;">
		
		<option></option>

        <? foreign_relation('lc_master','lc_no','export_lc_no',$_POST['lc_no'],'1');?>
    </select>	
	
		</td>
        <td width="18%" bgcolor="#FF9966"><?=$pi_data->pi_date;?></td>
        <td width="26%" rowspan="7" bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
        </strong></td>
      </tr>

	  
    </table>
	
	</form>

<br />

<?

if(isset($_POST['submitit'])){



?>



<form method="post">
<table width="100%" border="0">

<div class="box" style="width:100%;">

								<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>
<input name="lc_no" id="lc_no" type="hidden" value="<?=$lc_no?>"/>
								 <td width="12%">LDBC No:</td>
									<td width="20%"><input name="ldbc_no" type="text" id="ldbc_no" tabindex="1" value="<?=$ldbc_no?>"></td>
									
					<td width="12%">LDBC Date:</td>
				<td width="20%"><input name="ldbc_date" type="text" id="ldbc_date" style="width:220px;" value="<?=$ldbc_date?>"  tabindex="105" />	</td>
				
					<td width="12%">Value (USD):</td>
				<td width="20%"><input name="valueccc" type="text" id="valueccc" onkeyup="realiaz()" style="width:220px;" value="<?=$valueccc?>"  tabindex="105" />	</td>
				
									
								  </tr>

							<tr>

								 <td width="12%">Acceptance Date:</td>
									<td width="20%"><input name="acceptance_date" type="text" id="acceptance_date" tabindex="1" value="<?=$acceptance_date?>"></td>
									
					<td width="12%">Purchase USD 90% or 80%:</td>
				<td width="20%"><input name="purchase_parcent" type="text" id="purchase_parcent" onkeyup="realiaz()" style="width:220px;" value="<?=$purchase_parcent?>"  tabindex="105" />	</td>
				
					<td width="12%">Purchase Date:</td>
				<td width="20%"><input name="purchase_date" type="text" id="purchase_date" style="width:220px;" value="<?=$purchase_date?>"  tabindex="105" />	</td>
				
									
								  </tr>
								  
								  <tr>

								 <td width="12%">LDBP No:</td>
									<td width="20%"><input name="ldbp_no" type="text" id="ldbp_no" tabindex="1" value="<?=$ldbp_no?>"></td>
									
					<td width="12%">Maturity Date:</td>
				<td width="20%"><input name="maturity_date" type="text" id="maturity_date" style="width:220px;" value="<?=$maturity_date?>"  tabindex="105" />	</td>
				
					<td width="12%">Maturity Usd:</td>
				<td width="20%"><input name="maturity_usd" type="text" id="maturity_usd" style="width:220px;" value="<?=$maturity_usd?>"  tabindex="105" />	</td>
				
									
								  </tr>
								  
								  <tr>

								 <td width="12%">Realized Value:</td>
									<td width="20%"><input name="realized_value" type="text" id="realized_value" tabindex="1" readonly="readonly" value="<?=$realized_value?>"></td>
									
					<td width="12%">Realized Date:</td>
				<td width="20%"><input name="realized_date" type="text" id="realized_date" style="width:220px;" value="<?=$realized_date?>"  tabindex="105" />	</td>
				
					<td width="12%">discrepancy Amount:</td>
				<td width="20%"><input name="dsc_amt" type="text" id="dsc_amt" style="width:220px;" value="<?=$dsc_amt?>"  tabindex="105" />	</td>
						
								  </tr>
								  
								</table>

							  </div>




<tr>

<td align="center">&nbsp;

</td>

<td align="center">
<!--<input  name="do_no" type="hidden" id="do_no" value="<?=$_POST['do_no'];?>"/>-->
<input name="confirm" type="submit" class="btn1" value="Update" style="width:270px; font-weight:bold; float:right; font-size:12px; height:30px; color:#090" /></td>

</tr>



</table>

</form>

<? }?>








<p>&nbsp;</p>



</div>
<script>
function realiaz(){
var vala=$('#valueccc').val();

var purchase=$('#purchase_parcent').val();

$('#realized_value').val(vala-purchase);


}
</script>


<?

//

//

require_once SERVER_CORE."routing/layout.bottom.php";

?>