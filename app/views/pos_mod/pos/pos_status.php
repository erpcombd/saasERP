<?php
require_once "../../../assets/template/layout.top.php";
$title='POS Status';

do_calander('#fdate');
do_calander('#tdate');

$table = 'sale_pos_master';
$unique = 'po_no';
$status = 'CHECKED';
$target_url = '../pos/pos_print_view.php';
$target_url2 = '../pos/pos_receipt_view.php';
$target_url3 = '../pos/pos_chalan_view.php';
$target_url4 = '../pos/pos_gatepass_view.php';

if($_REQUEST[$unique]>0)
{
$_SESSION[$unique] = $_REQUEST[$unique];
header('location:'.$target_url);
}

?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}
function custom2(theUrl)
{
	window.open('<?=$target_url2?>?v_no='+theUrl);
}

function custom3(theUrl)
{
	window.open('<?=$target_url3?>?v_no='+theUrl);
}

function custom4(theUrl)
{
	window.open('<?=$target_url4?>?v_no='+theUrl);
}
</script>

<? include("../../../assets/css/New_them_css_custome.css")?>

<div class="form-container_large">
 
    <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date From:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate" value="<?=($_POST['fdate']!='')?$_POST['fdate'] : date('Y-m-d')?>" />
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                           <input type="text" name="tdate" id="tdate" value="<?=($_POST['tdate']!='')?$_POST['tdate'] : date('Y-m-d')?>" />

                        </div>
                    </div>
                </div>
				

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    
                    <input type="submit" name="submitit" id="submitit" value="View Product" class="btn1 btn1-submit-input"/ >
                </div>

            </div>
        </div>






        <div class="container-fluid pt-5 p-0 ">
		
		
		

                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>POS ID</th>
						<th>POS Date</th>
						<th>Amount</th>
						<th>Customer Name</th>
						<th>Created By</th>
						<th>Entry At</th>
						<th>Status</th>
						<th>Action</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					
					<? 

$con = 'and m.pos_date between "'.date('Y-m-d').'" and "'.date('Y-m-d').'"';					
if(isset($_POST['submitit'])){


if($_POST['fdate']!=''&&$_POST['tdate']!=''){
$con = 'and m.pos_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

}
}


$res='select m.pos_id,m.pos_id,m.pos_date,d.dealer_name,u.fname as created_by,m.entry_at,m.status from sale_pos_master m left join dealer_pos d on d.dealer_code=m.dealer_id left join user_activity_management u on u.user_id=m.entry_by where m.warehouse_id="'.$_SESSION['user']['depot'].'"'.$con.' order by m.pos_id desc ';
//echo link_report($res,'po_print_view.php');

		$query = mysql_query($res);
		?>
					
					
					<?
					
					while($row = mysql_fetch_object($query)){
					
					?>

                        <tr>
                            <td><?=$row->pos_id?></td>
                            <td><?=$row->pos_date?></td>
							<td><?=find_a_field('sale_pos_details','sum(total_amt)','pos_id="'.$row->pos_id.'"');?></td>
                            <td><?=$row->dealer_name?></td>

                            <td><?= $row->created_by?></td>
                            <td><?= $row->entry_at?></td>
							<td><?= $row->status?></td>
                            
                            <td>
							<input type="button" name="submitit" id="submitit" value="INVOICE" class="btn1 btn1-submit-input" onclick="custom(<?= $row->pos_id?>)"/ >
							<input type="button" name="submitit" id="submitit" value="POS RECEIPT" class="btn1 btn1-submit-input" onclick="custom2(<?= $row->pos_id?>)"/ >
							<input type="button" name="submitit" id="submitit" value="CHALAN" class="btn1 btn1-submit-input" onclick="custom3(<?= $row->pos_id?>)"/ >
							<input type="button" name="submitit" id="submitit" value="GATE PASS" class="btn1 btn1-submit-input" onclick="custom4(<?= $row->pos_id?>)"/ >

							</td>

                        </tr>
						<?
						}
						?>
                    </tbody>
                </table>

						


        </div>
    </form>
</div>







<?php /*?><div class="form-container_large">
  <form action="" method="post" name="codz" id="codz">
    <table width="80%" border="0" align="center">
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FF9966"><strong>Date Interval :</strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="fdate" id="fdate" style="width:100px;" value="<?=date('Y-m-01')?>" />
        </strong></td>
        <td align="center" bgcolor="#FF9966"><strong> -to- </strong></td>
        <td width="1" bgcolor="#FF9966"><strong>
          <input type="text" name="tdate" id="tdate" style="width:100px;" value="<?=date('Y-m-d')?>" />
        </strong></td>
        <td bgcolor="#FF9966"><strong>
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input" />
        </strong></td>
      </tr>
    </table>
  </form>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><div class="tabledesign2">
<? 
if(isset($_POST['submitit'])){


if($_POST['fdate']!=''&&$_POST['tdate']!='')
$con .= 'and m.pos_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';

$res='select m.pos_id,m.pos_id,m.pos_date,d.dealer_name_e as Customer,u.fname as created_by,m.entry_at from sale_pos_master m left join dealer_info d on d.dealer_code=m.dealer_id left join user_activity_management u on u.user_id=m.entry_by where 1 '.$con.'';
echo link_report($res,'po_print_view.php');

}
?>
</div></td>
</tr>
</table>
</div><?php */?>

<?
require_once "../../../assets/template/layout.bottom.php";
?>