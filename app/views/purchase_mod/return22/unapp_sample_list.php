<?php

session_start();

ob_start();

require "../support/inc.report.php";

$title='Balance Sheet';

$proj_id=$_SESSION['proj_id'];



if(isset($_REQUEST['show']))

{

$tdate=$_REQUEST['tdate'];

//fdate-------------------



$ledger_id=$_REQUEST["ledger_id"];





if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')

$report_detail.='<br>Report date Till: '.$_REQUEST['tdate'];





$j=0;

for($i=0;$i<strlen($fdate);$i++)

{

if(is_numeric($fdate[$i]))

$time1[$j]=$time1[$j].$fdate[$i];



else $j++;

}



$fdate=mktime(0,0,-1,$time1[1],$time1[0],$time1[2]);



//tdate-------------------





$j=0;

for($i=0;$i<strlen($tdate);$i++)

{

if(is_numeric($tdate[$i]))

$time[$j]=$time[$j].$tdate[$i];

else $j++;

}

$tdate=mktime(23,59,59,$time[1],$time[0],$time[2]);





}

?>

<?php $led=db_query("select ledger_id,ledger_name from accounts_ledger where 1 order by ledger_name");

      $data = '[';

      $data .= '{ name: "All", id: "%" },';

	  while($ledg = mysqli_fetch_row($led)){

          $data .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';

	  }

      $data = substr($data, 0, -1);

      $data .= ']';

//echo $data;

	

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

<script type="text/javascript">

$(document).ready(function(){

	

	$(function() {

		$("#fdate").datepicker({

			changeMonth: true,

			changeYear: true,

			dateFormat: 'dd-mm-y'

		});

	});

		$(function() {

		$("#tdate").datepicker({

			changeMonth: true,

			changeYear: true,

			dateFormat: 'dd-mm-y'

		});

	});



});

</script>

<style>
<script src="https://kit.fontawesome.com/d1384ef8ea.js" crossorigin="anonymous"></script>
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td><div class="left_report">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								  <tr>

								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">

									<table width="100%" border="0" cellspacing="2" cellpadding="0">

                                      <tr>

                                        <td width="22%" align="right">

		    As On:                                       </td>

                                        <td align="left"><input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>" /> 

                                        </td>

                                      </tr>

                                     

                                     

                                      

                                      <tr>

                                        <td colspan="2" align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>

                                      </tr>

                                    </table>

								    </form></div></td>

						      </tr>

								  <tr>

									<td align="right"><? include('PrintFormat.php');?></td>

								  </tr>

								  <tr>

									<td><div id="reporting">

			<table id="grp" class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">

							 <tr>

							<th height="20" align="center">Class</th>
							<th height="20" colspan="2" align="center">Sub Class</th>

							<th width="47%" height="20" align="center">Head of Account </th>

							<th width="17%" align="center">Amount</th>

							<th width="18%" height="20" align="center">Balance</th>

							</tr>

							<tr>

							<th align="left">ASSET:</th>
							
							<th colspan="4"></th>
							<th align="left"></th>

							</tr>
							
								<tr>
								<th><!--<span style="color:black;font-weight:bold;font-size:24px;background-color:aliceblue;" onclick="expend1()">+</span>--></th>
							<th align="left">Non Current Assets/Fixed Assets</th>						
							<th colspan="3"></th>
							<?php 
							$bal1=find_a_field('journal j,accounts_ledger a,ledger_group g','sum(j.dr_amt-j.cr_amt)',' g.sub_class=1 and a.ledger_group_id=g.group_id and a.ledger_id=j.ledger_id and j.jv_date<="'.$tdate.'"');
							
							?>
							<th align="left"><?php echo $bal1;?></th>
							</tr>
						
							<?php 
							 $sql3="select * from ledger_group where sub_class=1 ";
							$query3=db_query($sql3);
							while($data3=mysqli_fetch_object($query3)){
						
							?>
						
						<tr >
								<th></th>
							<th align="left"></th>						
							<td colspan="2" style="font-weight:bold;"><?php echo $data3->group_name; ?></td>
							<th align="left"></th>
							<th align="left"></th>
							</tr>
							
								<?php 
							 $sql1="select a.* from accounts_ledger a,ledger_group g where g.sub_class=1 and a.ledger_group_id=g.group_id and g.group_id='".$data3->group_id."'";
							$query1=db_query($sql1);
							while($data1=mysqli_fetch_object($query1)){
							$ledger_bal1=find_a_field('journal','sum(dr_amt-cr_amt)','jv_date<="'.$tdate.'" and ledger_id="'.$data1->ledger_id.'"');
							?>
					
							<tr >
								<th></th>
							<th align="left"></th>						
							<td colspan="2"><?php echo $data1->ledger_name; ?></td>
							<th align="left"><a href="balance_sheet_details.php?ledger_id=<?=$data1->ledger_id?>&&to_date=<?=$tdate?>" target="_blank"><?php 
							 if($ledger_bal1 < 0){
							  echo "(".$ledger_bal1*(-1).")";
							}
							else{
							echo $ledger_bal1;
							}
							 ?></a></th>
							<th align="left"></th>
							</tr>
						
							<?php  } ?>
							
							
							
							<?php } ?>
						
						
							
							<tr>
							
								<th></th>
							<?php	$bal2=find_a_field('journal j,accounts_ledger a,ledger_group g','sum(j.dr_amt-j.cr_amt)',' g.sub_class=2 and a.ledger_group_id=g.group_id and a.ledger_id=j.ledger_id and j.jv_date<="'.$tdate.'"'); ?>
							<th align="left">Current Assets</th>						
							<th colspan="3"></th>
							
							<th align="left"><?php echo $bal2;?></th>
							</tr>
							
							
								<?php 
							 $sql4="select * from ledger_group where sub_class=2 ";
							$query4=db_query($sql4);
							while($data4=mysqli_fetch_object($query4)){
						
							?>
						
						<tr >
								<th></th>
							<th align="left"></th>						
							<td colspan="2" style="font-weight:bold;"><?php echo $data4->group_name; ?></td>
							<th align="left"></th>
							<th align="left"></th>
							</tr>
							
							
									<?php 
							 $sql2="select a.* from accounts_ledger a,ledger_group g where g.sub_class=2 and a.ledger_group_id=g.group_id and g.group_id='".$data4->group_id."'";
							$query2=db_query($sql2);
							while($data2=mysqli_fetch_object($query2)){
							$ledger_bal2=find_a_field('journal','sum(dr_amt-cr_amt)','jv_date<="'.$tdate.'" and ledger_id="'.$data2->ledger_id.'"');
							//echo $sqltest='select sum(dr_amt-cr_amt) from journal where jv_date<="'.$tdate.'" and ledger_id="'.$data2->ledger_id.'" ';
							?>
							<tr>
								<th></th>
							<th align="left"></th>						
							<td colspan="2"><?php echo $data2->ledger_name; ?></td>
							<th align="left"><a href="balance_sheet_details.php?ledger_id=<?=$data2->ledger_id?>&&to_date=<?=$tdate?>" target="_blank">
							<?php 
							 if($ledger_bal2 < 0){
							  echo "(".$ledger_bal2*(-1).")";
							}
							else{
							echo $ledger_bal2;
							}
							 ?></a>
							</th>
							<th align="left"></th>
							</tr>
							<?php  } } ?>
							
								<tr>
							<th align="left" style="color:red;font-weight:bold;">Total Asset:</th>
								<th colspan="4"></th>
							<th align="left" style="color:red;font-weight:bold;" ><?php echo $total_assets=$bal1+$bal2;?></th>
							</tr>
								<tr>
								
							<th align="left">Liability:</th>
								<th colspan="4"></th>
							<th align="left"></th>
							</tr>
							
								<tr>
								<th></th>
									<?php	$bal3=find_a_field('journal j,accounts_ledger a,ledger_group g','sum(j.cr_amt-j.dr_amt)',' g.sub_class=3 and a.ledger_group_id=g.group_id and a.ledger_id=j.ledger_id and j.jv_date<="'.$tdate.'"'); ?>
							<th align="left">Equiety & Libilities</th>						
							<th colspan="3"></th>
							<th align="left"><?php echo $bal3;?></th>
							</tr>
							<?php 
							 $sql5="select * from ledger_group where sub_class=3 ";
							$query5=db_query($sql5);
							while($data5=mysqli_fetch_object($query5)){
						
							?>
						
						<tr >
								<th></th>
							<th align="left"></th>						
							<td colspan="2" style="font-weight:bold;"><?php echo $data5->group_name; ?></td>
							<th align="left"></th>
							<th align="left"></th>
							</tr>
							
							
									<?php 
							  $sql3="select a.* from accounts_ledger a,ledger_group g where g.sub_class=3 and a.ledger_group_id=g.group_id and group_id='".$data5->group_id."'";
							$query3=db_query($sql3);
							while($data3=mysqli_fetch_object($query3)){
							$ledger_bal3=find_a_field('journal','sum(cr_amt-dr_amt)','jv_date<="'.$tdate.'" and ledger_id="'.$data3->ledger_id.'"');
							?>
							<tr>
								<th></th>
							<th align="left"></th>						
							<td colspan="2"><?php echo $data3->ledger_name; ?></td>
							<th align="left"><a href="balance_sheet_details.php?ledger_id=<?=$data3->ledger_id?>&&to_date=<?=$tdate?>" target="_blank"><?php 
							 if($ledger_bal3 < 0){
							  echo "(".$ledger_bal3*(-1).")";
							}
							else{
							echo $ledger_bal3;
							}
							 ?></a></th>
							<th align="left"></th>
							</tr>
							<?php  } } ?>
							
							<tr>
								<th></th>
									<?php	$bal4=find_a_field('journal j,accounts_ledger a,ledger_group g','sum(j.cr_amt-j.dr_amt)',' g.sub_class=4 and a.ledger_group_id=g.group_id and a.ledger_id=j.ledger_id and j.jv_date<="'.$tdate.'"'); ?>
							<th align="left">Current Libilities</th>						
							<th colspan="3"></th>
							<th align="left"><?php echo $bal4;?></th>
							</tr>
									<?php 
							 $sql6="select * from ledger_group where sub_class=4 ";
							$query6=db_query($sql6);
							while($data6=mysqli_fetch_object($query6)){
						
							?>
						
						<tr >
								<th></th>
							<th align="left"></th>						
							<td colspan="2" style="font-weight:bold;"><?php echo $data6->group_name; ?></td>
							<th align="left"></th>
							<th align="left"></th>
							</tr>
							
							
									<?php 
							 $sql4="select a.* from accounts_ledger a,ledger_group g where g.sub_class=4 and a.ledger_group_id=g.group_id and g.group_id='".$data6->group_id."'";
							$query4=db_query($sql4);
							while($data4=mysqli_fetch_object($query4)){
							$ledger_bal4=find_a_field('journal','sum(cr_amt-dr_amt)','jv_date<="'.$tdate.'" and ledger_id="'.$data4->ledger_id.'"');
							?>
							<tr>
								<th></th>
							<th align="left"></th>						
							<td colspan="2"><?php echo $data4->ledger_name; ?></td>
							<th align="left"><a href="balance_sheet_details.php?ledger_id=<?=$data4->ledger_id?>&&to_date=<?=$tdate?>" target="_blank"><?php 
							 if($ledger_bal4 < 0){
							  echo "(".$ledger_bal4*(-1).")";
							}
							else{
							echo $ledger_bal4;
							}
							 ?></a></th>
							<th align="left"></th>
							</tr>
							<?php  } }?>
							
							<tr>
								<th></th>
								<?php	$bal5=find_a_field('journal j,accounts_ledger a,ledger_group g','sum(j.cr_amt-j.dr_amt)',' g.sub_class=5 and a.ledger_group_id=g.group_id and a.ledger_id=j.ledger_id and j.jv_date<="'.$tdate.'"'); ?>
							<th align="left">Non Current Libilities</th>						
							<th colspan="3"></th>
							<th align="left"><?php echo $bal5;?></th>
							</tr>
							
									<?php 
							 $sql7="select * from ledger_group where sub_class=5 ";
							$query7=db_query($sql7);
							while($data7=mysqli_fetch_object($query7)){
						
							?>
						
						<tr >
								<th></th>
							<th align="left"></th>						
							<td colspan="2" style="font-weight:bold;"><?php echo $data7->group_name; ?></td>
							<th align="left"></th>
							<th align="left"></th>
							</tr>
							
								<?php 
							 $sql5="select a.* from accounts_ledger a,ledger_group g where g.sub_class=5 and a.ledger_group_id=g.group_id and g.group_id='".$data7->group_id."'";
							$query5=db_query($sql5);
							while($data5=mysqli_fetch_object($query5)){
							$ledger_bal5=find_a_field('journal','sum(cr_amt-dr_amt)','jv_date<="'.$tdate.'" and ledger_id="'.$data5->ledger_id.'"');
							?>
							<tr>
								<th></th>
							<th align="left"></th>						
							<td colspan="2"><?php echo $data5->ledger_name; ?></td>
							<th align="left"><a href="balance_sheet_details.php?ledger_id=<?=$data5->ledger_id?>&&to_date=<?=$tdate?>" target="_blank"><?php 
							 if($ledger_bal5 < 0){
							  echo "(".$ledger_bal5*(-1).")";
							}
							else{
							echo $ledger_bal5;
							}
							 ?></a></th>
							<th align="left"></th>
							</tr>
							<?php  }} ?>
								<tr>
								<tr>
							<th align="left" style="color:red;font-weight:bold;">Total Liability:</th>
								<th colspan="4"></th>
							<th align="left" style="color:red;font-weight:bold;" ><?php echo $total_libility=$bal3+$bal4+$bal5;?></th>
							</tr>


</table></div>

									<div id="pageNavPosition"></div>									</td>

								  </tr>

		</table>



							</div></td>

    

  </tr>

</table>

<script>
//document.getElementById('expand2').style.display="none";

 
function expend1(){
 document.getElementById("expand2 ").style.display = "none"; 
 //alert("hi");
}
</script>

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>