<?php



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



require_once "../../../controllers/core/class.numbertoword.php";



$title='Cash Book';

do_calander('#fdate');
do_calander('#tdate');

create_combobox('ledger_id');
create_combobox('cc_code');
$active='cashbo';

$proj_id=$_SESSION['proj_id'];



jv_double_check();



if($_SESSION['user']['group']>1) {



$cash_and_bank_balance=find_a_field('ledger_group','group_id',"group_sub_class='1020' and group_for=".$_SESSION['user']['group']);}



else {



$cash_and_bank_balance=find_a_field('ledger_group','group_id','group_sub_class=1020');}











if(isset($_REQUEST['show']))



{



$tdate=$_REQUEST['tdate'];



//fdate-------------------



$fdate=$_REQUEST["fdate"];



$ledger_id=$_REQUEST["ledger_id"];







if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='') {



$report_detail.='<br>Report date : '.$_REQUEST['tdate']; }



if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='') {



$report_detail.='<br>CC Code : '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);}











$j=0;



for($i=0;$i<strlen($fdate);$i++)



{



if(is_numeric($fdate[$i])){



$time1[$j]=$time1[$j].$fdate[$i];}







else { $j++;}



}















//tdate-------------------











$j=0;



for($i=0;$i<strlen($tdate);$i++)



{



if(is_numeric($tdate[$i])){



$time[$j]=$time[$j].$tdate[$i];}



else{ $j++;}



}















}



?>



<?php  



	



	$led1=db_query("SELECT id, center_name FROM cost_center WHERE 1 ORDER BY center_name");



	  if(mysqli_num_rows($led1) > 0)



	  {	



		  $data1 = '[';



		  while($ledg1 = mysqli_fetch_row($led1)){



			  $data1 .= '{ name: "'.$ledg1[1].'", id: "'.$ledg1[0].'" },';



		  }



		  $data1 = substr($data1, 0, -1);



		  $data1 .= ']';



	  }



	  else



	  {



		$data1 = '[{ name: "empty", id: "" }]';



	  }



?>



<script type="text/javascript">







$(document).ready(function(){







    function formatItem(row) {



		//return row[0] + " " + row[1] + " ";



	}



	function formatResult(row) {



		return row[0].replace(/(<.+?>)/gi, '');



	}







    var data = <?php echo $data; ?>;



    $("#ledger_id").autocomplete(data, {



		matchContains: true,



		minChars: 0,



		scroll: true,



		scrollHeight: 300,



        formatItem: function(row, i, max, term) {



            return row.name + " [" + row.id + "]";



		},



		formatResult: function(row) {



			return row.id;



		}



	});



	



	var data = <?php echo $data1; ?>;



    $("#cc_code").autocomplete(data, {



		matchContains: true,



		minChars: 0,        



		scroll: true,



		scrollHeight: 300,



        formatItem: function(row, i, max, term) {



            return row.name + " : [" + row.id + "]";



		},



		formatResult: function(row) {            



			return row.id;



		}



	});	



  });



	



</script>






<style>
.box_report{
	border:3px solid cadetblue;
	background:aliceblue;
}

</style>













	<div class="form-container_large">

		<form  id="form1" name="form1" method="post" action="">
			<div class="d-flex  justify-content-center">

				<div class="n-form1 fo-short pt-2">
					<div class="container">
						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">From Date :</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
								<input name="fdate" type="text" id="fdate" size="12"  class="form-control" value="<?php echo $_REQUEST['fdate'];?>" autocomplete="off"/>
							</div>
						</div>

						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date :</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
								<input name="tdate" type="text" id="tdate" size="12"  class="form-control" value="<?php echo $_REQUEST['tdate'];?>" autocomplete="off"/>
							</div>
						</div>

						<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Cash Head :</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">


								<select name="ledger_id" id="ledger_id" class="form-control">
									

									<?
									$cash_group= find_a_field('config_group_class','cash_group','group_for="'.$_SESSION['user']['group'].'"');
									foreign_relation('accounts_ledger','ledger_id','ledger_name',$ledger_id,"ledger_group_id=".$cash_group." order by ledger_id");

									?>
								</select>

							</div>
						</div>

<div class="form-group row  m-0 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Sub Ledger</label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">


								<select name="sub_ledger_id" id="sub_ledger_id" class="form-control"  >

<? if($_REQUEST['sub_ledger_id']>0) {?>
									<option value="<?php echo $_REQUEST['sub_ledger_id'];?>"><?php echo find_a_field('general_sub_ledger','sub_ledger_name','sub_ledger_id='.$_REQUEST['sub_ledger_id']); ?></option>
									<?php } ?>
<option value="%">All</option>
									<?

									foreign_relation('general_sub_ledger','sub_ledger_id','sub_ledger_name',$sub_ledger_id,"1 and group_for='".$_SESSION['user']['group']."'  order by sub_ledger_id");

									?>

								</select>

							 

							</div>
						</div>
					</div>

					<div class="n-form-btn-class">
						<input class="btn1 btn1-bg-submit" name="show" type="submit" id="show" value="Show" />

					</div>

				</div>

			</div>

		</form>



		<div class="container-fluid">
			<p class="#"> <? include('PrintFormat.php');?> </p>



			<div id="reporting">
				<div id="grp">

					<table class="table1  table-striped table-bordered table-hover table-sm">

						<thead class="thead1">
						<tr class="bgc-info">

							<th>S/N</th>
							<th>Date</th>
							<th>Voucher No</th>
							<th>Type</th>
							<th>Head Of A/C</th>
								<th>Sub Ledger</th>
							<th>Narration</th>
							<th>Debit(TK)</th>
							<th>Credit(TK)</th>
						</tr>


						</thead>
						<tbody class="tbody1">


						<?php
						
						$gsql='select * from  general_sub_ledger where 1 group by sub_ledger_id';
						$gquery=db_query($gsql);
						while($grow=mysqli_fetch_object($gquery)){
							$sub_ledger_name[$grow->sub_ledger_id]=$grow->sub_ledger_name;
						}
						
						if(isset($_REQUEST['show']))
						{
							$cc_code = (int) $_REQUEST['cc_code'];

							$psql		= "select a.jv_no from journal a where  jv_date between '$fdate' and '$tdate' and  a.ledger_id='$ledger_id' order by a.jv_date,a.tr_no";

							$pquery		= db_query($psql);

							$pcount     = mysqli_num_rows($pquery);
							
							
							if($_POST['sub_ledger_id']>0){
								$sub_ledg_con='and a.sub_ledger="'.$_POST['sub_ledger_id'].'"';
							}

							if($pcount>0)



							{



								while($info=mysqli_fetch_object($pquery)){



									++$c;



									if($c==1){$jvs .= $info->jv_no;}



									else{$jvs .= ','.$info->jv_no;}



								}



							}



							//echo $jvs;



							//$join=" and tr_from in('Receipt','Payment','Opening','Journal_info','Cash Purchase','Contra')"; //changed by al amin



							if($cc_code > 0)



							{











								$op		= "select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$ledger_id' and jv_date<'$fdate' and 1 AND cc_code=$cc_code ";







								$open	= mysqli_fetch_row(db_query($op));



								$cur	= "select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$ledger_id' and jv_date between '$fdate' and '$tdate' and 1 AND cc_code=$cc_code ";







								$current = mysqli_fetch_row(db_query($cur));



								$close	= $open[0]+$current[0];







								$p		= "select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_no,a.narration,a.tr_from,a.cheq_no,a.cheq_date,a.sub_ledger from journal a,accounts_ledger b where a.ledger_id=b.ledger_id AND a.cc_code=$cc_code and jv_no in (".$jvs.") and a.ledger_id!='$ledger_id' ".$sub_ledg_con." order by a.jv_date,a.tr_no";



							}



							else



							{











								$op		= "select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$ledger_id' and jv_date<'$fdate' ";



								$open	= mysqli_fetch_row(db_query($op));



								$cur	= "select SUM(dr_amt)-SUM(cr_amt) from journal where ledger_id ='$ledger_id' and jv_date between '$fdate' and '$tdate' ";











								$current = mysqli_fetch_row(db_query($cur));



								$close	= $open[0]+$current[0];



								$p		= "select a.jv_date,b.ledger_name,a.dr_amt,a.cr_amt,a.tr_no,a.narration,a.tr_from,a.jv_no,a.cheq_no,a.cheq_date,a.sub_ledger from journal a,accounts_ledger b where a.ledger_id=b.ledger_id and jv_no in (".$jvs.") and a.ledger_id!='$ledger_id' ".$sub_ledg_con." order by a.jv_date DESC,a.tr_no ";







							}



							$i=0;



							$report = db_query($p);



							$old_jv = 1;



							while($rp=mysqli_fetch_row($report)){



								if($old_jv != $rp[4]){ $i++;} else{ echo '&nbsp;';}



								if($i%2==0){$cls=' class="alt"';} else{ $cls='';}







								$cr_total=$cr_total+$rp[3];



								$dr_total=$dr_total+$rp[2];







								if($old_tp != $rp[6]){ $i=1;$old_tp = $rp[6];}







								?>



								<tr<?=$cls?>>



									<td><? if($old_jv != $rp[4]){ echo $i;} ?></td>

<td><?  echo $rp[0];?></td>

									<td><?



										if($old_jv != $rp[4])



										{



											$link="general_voucher_print_view_from_journal.php?jv_no=".url_encode($rp[7]);



											echo "<a href='$link' target='_blank'>".$rp[4]."</a>";}?></td>



									<td><? if($old_jv != $rp[4]){ echo $rp[6];} ?></td>



									<td><?=$rp[1];?></td>

<td><?=$sub_ledger_name[$rp[10]];?></td>

									<td><?=$rp[5];?><?=(($rp[8]!='')?'-Cq#'.$rp[8]:'');?><?=(($rp[9]>943898400)?'-Cq-Date#'.date('d-m-Y',$rp[9]):'');?></td>

 

									<td style="text-align:right"><?=$rp[2];?></td>



									<td style="text-align:right"><?=$rp[3];?></td>



								</tr>

								<?php $old_jv = $rp[4];  }
							?>
							<tr>
								<th colspan="7" align="right">Total : </th>
								<th><?=number_format($dr_total,2);?></th>

								<th><?=number_format($cr_total,2);?></th>

							</tr>

							<?

						}?>

						</tbody>
					</table>
					<br>
					<br>




					<table class="tabledesign"   width="100%" cellspacing="0" cellpadding="2" border="0">



						<tr>
							<th width="70%">Opening Balance :</th>
							<th width="30%" align="right"><?php if($open[0]==0) { echo "0.00"; } else { echo number_format($open[0],2);} ?></th>
						</tr>



						<tr class="alt">
							<th>Received in this Period :</th>
							<th align="right"><?=number_format($cr_total,2);?></th>
						</tr>



						<tr class="alt">
							<th>Total after Received :</th>
							<th align="right"><?=number_format(($open[0]+$cr_total),2);?></th>
						</tr>



						<tr class="alt">
							<th>Payment in this Period :</th>
							<th align="right"><?=number_format($dr_total,2);?></th>
						</tr>


						<tr>
							<th>Closing Balance :</th>
							<th align="right"><?php echo number_format($close,2);?></th>
						</tr>
					</table>


					<br />



					Amount Inwords:



					<?=convertNumberMhafuz($close)?>



					<br />



					<br /><br /><br />



					<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:#FFFFFF">



						<tr style="border-bottom:#FFFFFF">







							<td align="center" valign="bottom" style="border-bottom:#FFFFFF;border-left:0px; border-right:0px;  ">

								........................................



								<!--<u>







                                <? if($_SESSION['user']['group']==3){



									echo find_a_field('user_activity_management','fname',"user_id=".$_SESSION['user']['id']);}



								else{ echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Hezol Alam &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';} ?>



                                </u>-->



							</td>



							<td align="center" valign="bottom" style="border-bottom:#FFFFFF; border-left:0px;border-right:0px;  ">........................</td>



							<td align="center" valign="bottom" style="border-bottom:#FFFFFF; border-left:0px;border-right:0px;  ">................................</td>



							<td align="center" valign="bottom" style="border-bottom:#FFFFFF; border-left:0px;border-right:0px;  ">............................</td>



							<td align="center" valign="bottom" style="border-bottom:#FFFFFF; border-left:0px;border-right:0px;  ">................................</td>



						</tr>



						<tr>







							<td style="border-bottom:#FFFFFF; border-left:0px;border-right:0px;  "><div align="center">Prepared by Accountant</div></td>



							<td style="border-bottom:#FFFFFF; border-left:0px;border-right:0px;  "><div align="center">Checked by </div></td>



							<td style="border-bottom:#FFFFFF; border-left:0px;border-right:0px;  "><div align="center">Head of Accounts</div></td>



							<td style="border-bottom:#FFFFFF; border-left:0px;border-right:0px;  "><div align="center">Director/ED</div></td>



							<td style="border-bottom:#FFFFFF; border-left:0px;border-right:0px;  "><div align="center">DMD/MD/Proprietor</div></td>



						</tr>



					</table>






				</div>
			</div>


		</div>





	</div>















<?


require_once SERVER_CORE."routing/layout.bottom.php";



?>