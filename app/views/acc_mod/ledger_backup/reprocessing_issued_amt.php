<?php

session_start();

ob_start();


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Reprocessing Issue Varification';
$now=time();
do_calander('#do_date_fr');
do_calander('#do_date_to');
$depot_id = $_POST['depot_id'];
$group_for = $_SESSION['user']['group'];
?>
<script>

function getXMLHTTP() {

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











	<!--Reprocessing issued amt-->
	<form id="form2" name="form2" method="post" action="">
		<div class="form-container_large">

			<div class="container-fluid bg-form-titel">
				<div class="row">
					<!--left form-->
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<div class="container n-form2">

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Return Date :</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<input name="do_date_fr" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?>"/>
								</div>
							</div>
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">-To- :</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" />
								</div>
							</div>
							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Checked :</label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<span class="oe_form_group_cell">
										<select name="checked" id="checked">
											<option></option>
											<option <?=($_POST['checked']=='NO')?'Selected':'';?>>NO</option>
											<option <?=($_POST['checked']=='YES')?'Selected':'';?>>YES</option>
										</select>
									</span>
								</div>
							</div>




						</div>
					</div>

					<!--Right form-->
					<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
						<div class="container n-form2">


							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Party Name : </label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<select name="ledger_id" id="ledger_id" style="width:150px;">
										<option><?=$_POST['ledger_id']?></option>

									</select>
								</div>
							</div>

							<div class="form-group row m-0 pb-1">
								<label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Depot : </label>
								<div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
									<span class="oe_form_group_cell">
									  <select name="depot_id" id="depot_id">
										  <? foreign_relation('cost_center','id','center_name',$depot_id,'group_for="'.$group_for.'" and cc_code>0 order by center_name');?>
									  </select>
									</span>
								</div>
							</div>

						</div>
					</div>

				</div>


				<div class="container-fluid p-0 ">

					<div class="n-form-btn-class">
						<input type="submit" name="submitit" id="submitit" value="View Return" class="btn1 btn1-submit-input" />
					</div>

				</div>




			</div>






			<div class="container-fluid pt-5 p-0 ">


				<table class="table1  table-striped table-bordered table-hover table-sm">
					<thead class="thead1">


					<tr class="bgc-info">

						<th>SL</th>
						<th>RI</th>
						<th>Accounts Head </th>
						<th>Date</th>
						<th>CC</th>
						<th>Entry By </th>
						<th>Amount</th>
						<th> </th>
						<th>Checked?</th>

					</tr>
					</thead>

					<tbody class="tbody1">
					<?
					if($_POST['do_date_fr']!=''){
						$i=0;
						$datefr = strtotime($_POST['do_date_fr']);
						$dateto = strtotime($_POST['do_date_to']);
						$day_from = mktime(0,0,0,date('m',$datefr),date('d',$datefr),date('y',$datefr));
						$day_end =  mktime(23,59,59,date('m',$dateto),date('d',$dateto),date('y',$dateto));

						if($_POST['checked']!='') $checked_con = ' and j.checked="'.$_POST['checked'].'" ';


						if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];
						if($_POST['dealer_type']!='') 	 $depot_con .= ' AND d.dealer_type="'.$_POST['dealer_type'].'"';
						if($depot_id>0) {


							$depot_con .= 'and j.cc_code='.$depot_id;
						}

						$sql="SELECT
				  j.tr_no,
				  sum(1) as co,
				  sum(j.dr_amt) as dr_amts,
				  j.jv_date,
				  j.jv_no,
				  l.ledger_name,
				  j.tr_id,
				  u.fname,
				  j.entry_at,
				  j.checked,
				  j.jv_no,
				  j.dr_amt,j.cc_code
				FROM
				  secondary_journal j,
				  accounts_ledger l,
				  user_activity_management u
				WHERE
				  j.user_id = u.user_id and
				  j.tr_from = 'Reprocess Issue' AND
				  j.jv_date  between '".$day_from."' AND '".$day_end."' AND
				  j.ledger_id = l.ledger_id ".$group_s." ".$depot_con.$checked_con."
				group by  j.tr_no";
						$query=db_query($sql);
						while($data=mysqli_fetch_object($query)){
							$received = $received + $data->dr_amts;

							?>
							<tr <?=($i%2==0)?'class="alt"':'';?>>
								<td ><?=++$i;?></td>
								<td ><? echo $data->tr_no;?></td>
								<td ><? echo $data->ledger_name;?></td>
								<td ><? echo date('Y-m-d',$data->jv_date);?></td>
								<td ><? echo $data->cc_code;?></td>
								<td ><div align="left"><? echo $data->fname;?></div></td>
								<td ><?=number_format($data->dr_amts,2);?></td>
								<td ><a target="_blank" href="reprocess_issue_sec_print_view.php?jv_no=<?=$data->jv_no ?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td>
								<td ><span id="divi_<?=$data->tr_no?>">
<?
if(($data->checked=='YES')){
	?>
	<input type="button" name="Button" value="YES"  onclick="window.open('reprocess_issue_sec_print_view.php?jv_no=<?=$data->jv_no;?>');"/>
	<?
}elseif(($data->checked=='NO')){
	?>
	<input type="button" name="Button" value="NO"  onclick="window.open('reprocess_issue_sec_print_view.php?jv_no=<?=$data->jv_no;?>');"/>
<? }?>
          </span></td>
							</tr>
						<? }}?>
					<tr>
						<td colspan="6"><div align="right"><strong>Total Amt : </strong></div> <div align="left"></div></td>
						<td align="right"><?=number_format($received,2);?></td>
						<td></td>
						<td></td>
					</tr>

					</tbody>
				</table>





			</div>



		</div>

	</form>
















<?/*>
	<br>
<br>
<br>
<br>
<br>
<br>
<br>

				<form id="form2" name="form2" method="post" action="">	

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td>      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td><table width="75%" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#FF9999">
              <tr>
                <td><div align="right"><strong>Return Date :</strong></div></td>
                <td><input name="do_date_fr" type="text" id="do_date_fr" value="<?=$_POST['do_date_fr']?>" style="width:150px;"/>
                  <label>                  </label></td>
                <td>-to-</td>
                <td><input name="do_date_to" type="text" id="do_date_to" value="<?=$_POST['do_date_to']?>" style="width:150px;"/></td>
                <td rowspan="4"><label>
                  <input type="submit" name="submitit" id="submitit" value="View Return" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
                </label></td>
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
                <td><div align="right"><strong> Party Name : </strong></div></td>
                <td colspan="3"><div align="left">
						<select name="ledger_id" id="ledger_id" style="width:150px;">
                      <option><?=$_POST['ledger_id']?></option>
                      
			          </select>
					</div></td>
                </tr>
              <tr>
                <td><div align="right"><strong> Depot : </strong></div></td>
                <td colspan="3"><div align="left">
						<span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">
                  <select name="depot_id" id="depot_id" style="width:250px;">
                    <? foreign_relation('cost_center','id','center_name',$depot_id,'group_for="'.$group_for.'" and cc_code>0 order by center_name');?>
                  </select>
                </span>
					</div></td>
                </tr>
              
            </table></td>
	    </tr>
		<tr><td>&nbsp;</td></tr>
        <tr>
          <td>
      <table width="98%" align="center" cellspacing="0" class="tabledesign">
      <tbody>
      <tr>
      <th>SL</th>
	  
      <th>RI</th>
      <th> Accounts Head </th>
      <th>Date</th>
      <th>CC</th>
      <th>Entry By </th>
      <th> Amount</th>
      <th>&nbsp;</th>
      <th>Checked?</th>
      </tr>
	  <?
	if($_POST['do_date_fr']!=''){
	  $i=0;
$datefr = strtotime($_POST['do_date_fr']);
$dateto = strtotime($_POST['do_date_to']);
$day_from = mktime(0,0,0,date('m',$datefr),date('d',$datefr),date('y',$datefr));
$day_end =  mktime(23,59,59,date('m',$dateto),date('d',$dateto),date('y',$dateto));

if($_POST['checked']!='') $checked_con = ' and j.checked="'.$_POST['checked'].'" ';


	if($_SESSION['user']['group']>1) $group_s='AND j.group_for='.$_SESSION['user']['group'];
	if($_POST['dealer_type']!='') 	 $depot_con .= ' AND d.dealer_type="'.$_POST['dealer_type'].'"';
	if($depot_id>0) {
	
	
	$depot_con .= 'and j.cc_code='.$depot_id;
	}
	
$sql="SELECT
				  j.tr_no,
				  sum(1) as co,
				  sum(j.dr_amt) as dr_amts,
				  j.jv_date,
				  j.jv_no,
				  l.ledger_name,
				  j.tr_id,
				  u.fname,
				  j.entry_at,
				  j.checked,
				  j.jv_no,
				  j.dr_amt,j.cc_code
				FROM
				  secondary_journal j,
				  accounts_ledger l,
				  user_activity_management u
				WHERE
				  j.user_id = u.user_id and 
				  j.tr_from = 'Reprocess Issue' AND 
				  j.jv_date  between '".$day_from."' AND '".$day_end."' AND 
				  j.ledger_id = l.ledger_id ".$group_s." ".$depot_con.$checked_con."
				group by  j.tr_no";
	  $query=db_query($sql);
	  while($data=mysqli_fetch_object($query)){
	  $received = $received + $data->dr_amts;
	  
	  ?>
      <tr <?=($i%2==0)?'class="alt"':'';?>>
      <td align="center"><div align="left"><?=++$i;?></div></td>
      <td align="center"><div align="left"><? echo $data->tr_no;?></div></td>
      <td align="center"><div align="left"><? echo $data->ledger_name;?></div></td>
      <td align="center"><div align="left"><? echo date('Y-m-d',$data->jv_date);?></div></td>
      <td align="center"><? echo $data->cc_code;?></td>
      <td align="center"><div align="left"><? echo $data->fname;?></div></td>
      <td align="right"><?=number_format($data->dr_amts,2);?></td>
      <td align="center"><a target="_blank" href="reprocess_issue_sec_print_view.php?jv_no=<?=$data->jv_no ?>"><img src="../images/print_hover.png" width="20" height="20" /></a></td>
      <td align="center"><span id="divi_<?=$data->tr_no?>">
<? 
if(($data->checked=='YES')){
?>
<input type="button" name="Button" value="YES"  onclick="window.open('reprocess_issue_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" style=" font-weight:bold;width:40px; height:20px;background-color:#66CC66;"/>
<?
}elseif(($data->checked=='NO')){
?>
<input type="button" name="Button" value="NO"  onclick="window.open('reprocess_issue_sec_print_view.php?jv_no=<?=$data->jv_no;?>');" style="font-weight:bold;width:40px; height:20px;background-color:#FF0000;"/>
<? }?>
          </span></td>
      </tr>
	  <? }}?>
	        <tr class="alt">
        <td colspan="6" align="center"><div align="right"><strong>Total Amt : </strong></div> <div align="left"></div></td>
        <td align="right"><?=number_format($received,2);?></td>
        <td align="center">&nbsp;</td>
	        </tr>
  </tbody></table>		  
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

	<*/?>



<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>