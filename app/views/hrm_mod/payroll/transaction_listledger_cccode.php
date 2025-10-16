<?php
session_start();
//
require "../support/inc.report.php";
$consumption_head = find_all_field('config_group_class','consumption_head',"group_for=".$_SESSION['user']['group']);
require_once ('../common/class.numbertoword.php');
$title='Transaction Statement (Ledger)';
$proj_id=$_SESSION['proj_id'];

if(isset($_REQUEST['show']))
{
$tdate=$_REQUEST['tdate'];
//fdate-------------------
$fdate=$_REQUEST["fdate"];
$ledger_id=$_REQUEST["ledger_id"];

if(isset($_REQUEST['tdate'])&&$_REQUEST['tdate']!='')
$report_detail.='<br>Period: '.$_REQUEST['fdate'].' to '.$_REQUEST['tdate'];
if(isset($_REQUEST['ledger_id'])&&$_REQUEST['ledger_id']!=''&&$_REQUEST['ledger_id']!='%')
$report_detail.='<br>Ledger Name : '.find_a_field('accounts_ledger','ledger_name','ledger_id='.$_REQUEST["ledger_id"].' and group_for='.$_SESSION['user']['group']);
if(isset($_REQUEST['cc_code'])&&$_REQUEST['cc_code']!='')
$report_detail.='<br>Cost Center: '.find_a_field('cost_center','center_name','id='.$_REQUEST["cc_code"]);

$j=0;
for($i=0;$i<strlen($fdate);$i++)
{
if(is_numeric($fdate[$i]))
$time1[$j]=$time1[$j].$fdate[$i];

else $j++;
}

$fdate=mktime(0,0,0,$time1[1],$time1[0],$time1[2]);

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
<?php $led=db_query("select ledger_id,ledger_name from accounts_ledger where group_for=".$_SESSION['user']['group']." order by ledger_name");
      $data = '[';
      $data .= '{ name: "All", id: "%" },';
	  while($ledg = mysqli_fetch_row($led)){
          $data .= '{ name: "'.$ledg[1].'", id: "'.$ledg[0].'" },';
	  }
      $data = substr($data, 0, -1);
      $data .= ']';
	//echo $data;
	

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
			//return row.name.replace(new RegExp("(" + term + ")", "gi"), "<strong>$1</strong>") + "<br><span style='font-size: 80%;'>ID: " + row.id + "</span>";
            return row.name + " [" + row.id + "]";
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="left_report">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
								    <td><div class="box_report"><form id="form1" name="form1" method="post" action="">
									<table width="10%" border="0" cellspacing="2" cellpadding="2">
                                      <tr>
                                        <td width="22%" align="right">
		    Period :                                       </td>
                                        <td width="78%" colspan="2" align="left"><input name="fdate" type="text" id="fdate" size="12" maxlength="12" value="<?php echo $_REQUEST['fdate'];?>" /> 
                                          ---  
                                            <input name="tdate" type="text" id="tdate" size="12" maxlength="12" value="<?php echo $_REQUEST['tdate'];?>"/></td>
                                      </tr>
                                      

                                      <tr>
                                        <td colspan="3" align="center"><input class="btn" name="show" type="submit" id="show" value="Show" /></td>
                                      </tr>
                                    </table>
								    </form></div></td>
						      </tr>
								  <tr>
									<td align="right"><? include('PrintFormat.php');?></td>
								  </tr>
								  <tr>
									<td><div id="reporting">
									<table id="grp"  class="tabledesign" width="100%" cellspacing="0" cellpadding="2" border="0">
							  <tr>
								<th height="20" align="center">S/N</th>
								<th align="center">Ledger ID</th>
								<th height="20" align="center">Ledger Name</th>


<?
$ccc = 0;
$sqled1 = "select cc.id, cc.center_name FROM cost_center cc, cost_category c WHERE cc.category_id=c.id and c.group_for='".$_SESSION['user']['group']."' ORDER BY center_name ASC";
$ccd=db_query($sqled1);
while($cc=mysqli_fetch_object($ccd))
{
$cccode[$ccc] = $cc->id;
echo '<th align="center">'.$cc->center_name.'</th>';
$ccc++;
}
								?>
								<th height="20" align="center">Ledger Total</th>
								</tr>
<?php
if(isset($_REQUEST['show']))
{

$sql="select sum(a.dr_amt-a.cr_amt) amt,cc_code, ledger_id from journal a where a.jv_date between '$fdate' AND '$tdate' and a.ledger_id like '".$consumption_head."%'  GROUP BY cc_code, ledger_id
ORDER BY a.jv_date, a.id";
$query = db_query($sql);
while($data=mysqli_fetch_object($query))
{
$cc[$data->ledger_id][$data->cc_code] = $data->amt;
$ledger_total[$data->ledger_id] = $ledger_total[$data->ledger_id] + $data->amt;
$cc_total[$data->cc_code] = $cc_total[$data->cc_code] + $data->amt;
$all_total = $all_total + $data->amt;
}
	


$p="select b.ledger_id,b.ledger_name from accounts_ledger b where  b.ledger_id like '4002%' ORDER BY ledger_name";
  $sql=db_query($p);
  while($data=mysqli_fetch_row($sql))
  {
  $pi++;
  ?>
  <tr>
    <td align="center"><?php echo $pi;?></td>
    <td align="center"><?=$data[0];?></td>
    <td align="center"><?=$data[1];?></td>
    <? for($ic=0;$ic<$ccc;$ic++){echo '<td align="center">'.$cc[$data[0]][$cccode[$ic]].'</td>'; }?>
    <td align="right"><?=number_format($ledger_total[$data[0]],2);?></td>
    </tr>
  <?php } 

  
  ?>
  <tr>
    <th colspan="3" align="center"><strong>Cost Center Total : </strong></th>
    <?
    for($ic=0;$ic<$ccc;$ic++){

    echo '<th align="right"><strong>'.number_format($cc_total[$cccode[$ic]],2).'</strong></th>';
 }?>
    <th align="right"><strong><?php echo number_format($all_total,2);?></strong></th>
    </tr>
  
  <?php }
  
  
  
  ?>
</table> 
									<br />
</div>									
		</td>
		</tr>
		</table>
		</div></td>    
  </tr>
</table>

<?
$main_content=ob_get_contents();
ob_end_clean();
include ("../template/main_layout.php");
?>