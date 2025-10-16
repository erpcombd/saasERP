<?php
require_once "../../../assets/template/layout.top.php";
$title='Sales Return List';

do_calander('#fdate');
do_calander('#tdate');

$table = 'purchase_master';
$unique = 'po_no';
$status = 'CHECKED';
$target_url = '../salesReturn/item_return_report.php';

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
</script>


<div class="form-container_large">
    
  <form action="" method="post" name="codz" id="codz">
            
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date From:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
  						  <input type="text" name="fdate" id="fdate"  value="<?=($_POST['fdate']!='')?$_POST['fdate']:date('Y-m-01');?>" />
                        </div>
                    </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Date To:</label>
                        <div class="col-sm-7 col-md-7 col-lg-7 col-xl-7 p-0">
                            <input type="text" name="tdate" id="tdate" svalue="<?=($_POST['tdate']!='')?$_POST['tdate']:date('Y-m-d');?>" />
                        </div>
                    </div>

                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
         			<input type="submit" name="submitit" id="submitit" value="View Detail" class="btn1 btn1-submit-input"/>                    
                </div>

            </div>
        </div>
    </form>
        <div class="container-fluid pt-5 p-0 tabledesign2">
<!--                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Sr No</th>
                        <th>Pos No</th>
                        <th>Sr Date</th>
						
                        <th>Customer</th>
                        <th>Note</th>
						<th>Total</th>                        
                    </tr>
                    </thead>

                    <tbody class="tbody1">
					
					</tbody>
                </table>-->

			<? 
			if(isset($_POST['submitit'])){
			
			
			if($_POST['fdate']!=''&&$_POST['tdate']!='')
			$con .= 'and a.or_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
			
			$res='select  a.or_no,a.or_no as sr_no,a.manual_or_no as pos_no,a.or_date as sr_date,a.vendor_name as customer,a.or_subject as note,sum(amount) as Total from warehouse_other_receive a,warehouse_other_receive_detail b where a.or_no=b.or_no and a.warehouse_id = "'.$_SESSION['user']['depot'].'" and a.receive_type = "PosReturn" '.$con.' group by a.or_no order by a.or_no desc';
			
			
			echo link_report($res,'po_print_view.php');
			
			}
			?>

        </div>

</div>


<?
require_once "../../../assets/template/layout.bottom.php";
?>