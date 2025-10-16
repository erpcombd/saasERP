<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Production Planning';
do_calander('#fdate');
do_calander('#tdate');
$table_master='sale_do_master';
$unique_master='do_no';
$tr_type="Show";
 $master_id = find_a_field('user_activity_management','master_user','user_id='.$_SESSION['user']['id']);

//create_combobox('do_no');
//create_combobox('dealer_code');

$table_detail='sale_do_details';
$unique_detail='id';

$table_chalan='sale_do_chalan';
$unique_chalan='id';

$$unique_master=$_POST[$unique_master];

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique_master."=".$$unique_master;		
		$crud->delete($condition);
		$crud   = new crud($table_detail);
		$crud->delete_all($condition);
		$crud   = new crud($table_chalan);
		$crud->delete_all($condition);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Deleted.';
}
if(isset($_POST['confirm']))
{
		$do_no=$_POST['do_no'];

		$_POST[$unique_master]=$$unique_master;
		$_POST['send_to_depot_at']=date('Y-m-d H:i:s');
		$_POST['do_date']=date('Y-m-d');
		$_POST['status']="CHECKED";
		
		
		$crud   = new crud($table_master);
		$crud->update($unique_master);
		$crud   = new crud($table_detail);
		$crud->update($unique_master);
		$crud   = new crud($table_chalan);
		$crud->update($unique_master);
				unset($_POST);
		unset($$unique_master);
		unset($_SESSION[$unique_master]);
		$type=1;
		$msg='Successfully Instructed to Depot.';
}


$table='sale_do_master';
$show='dealer_code';
$id='do_no';
$text_field_id='do_no';

$target_url = 'sales_order_print_view.php';

$tr_from="Sales";
?>
<script language="javascript">
window.onload = function() {
  document.getElementById("dealer").focus();
}
</script>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?v_no='+theUrl);
}



function custom2(theUrl)
{
	window.open('do_with_kg.php?old_do_no='+theUrl);
}
</script>

<style>
/*
.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited, a.ui-button, a:link.ui-button, a:visited.ui-button, .ui-button {
    color: #454545;
    text-decoration: none;
    display: none;
}*/


div.form-container_large input {
    width: 90%;
    height: 38px;
    border-radius: 0px !important;
}



</style>


<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz">

        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> From Date:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="fdate" id="fdate"  value="<?=$_POST['fdate']?>" autocomplete="off"/>
                        </div>
                  </div>

                </div>
				<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">To Date: </label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input type="text" name="tdate" id="tdate" value="<?=$_POST['tdate']?>" autocomplete="off"/>
                        </div>
                  </div>

                </div>
			<?php /*?>	<div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 pt-1 pb-1">
                    <div class="form-group row m-0">
             <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Customer Name :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
							<input list="dealer" type="text" name="dealer_code" id="dealer_code" /> 
                            <datalist id="dealer">
		
							<option></option>
					
							<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'1 order by dealer_code');?>
						</datalist>
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5 m-0 pt-1 pb-1">
                    <div class="form-group row m-0">
            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Warehouse Name :</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
				 
				 <select name="warehouse_id" id="warehouse_id" >
				
			 <option></option>
                  <? foreign_relation('warehouse w, warehouse_define d','w.warehouse_id','w.warehouse_name',$_POST['warehouse_id'],'w.warehouse_id=d.warehouse_id and d.user_id="'.$_SESSION['user']['id'].'" and d.status="Active"');?>
				</select>
				 
				 

                        </div>
                    </div>
                </div><?php */?>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
                    <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn1 btn1-submit-input"/>
                </div>

            </div>
        </div>

		
		
		

    </form>

        <div class="container-fluid pt-2 p-0 ">
                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>SO No</th>
                        <th>SO Date</th>
						<th>Item Name</th>
						<th>SO Qty</th>
						<th>Challaned Qty</th>
						<th>Pending Qty</th>
                        <th>Customer Name</th>
                        <th>Warehouse Name</th>
                        <th>Entry By</th>
                        <th>Status</th>
						
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                   <? 
					$last_two_months = date('Y-m-d', strtotime('-2 months'));
					$con = ' and m.do_date between "'.$last_two_months.'" and  "'.date('Y-m-d').'" ';
					
					if(isset($_POST['submitit'])){
						if($_POST['fdate']!=''&&$_POST['tdate']!='')  { 
							$con = ' and m.do_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';
						}
						
						if($_POST['dealer_code']!='')
							$dealer_con=" and m.dealer_code='".$_POST['dealer_code']."'";
							
						if($_POST['warehouse_id']!='') 
							$con .= ' and m.depot_id in ('.$_POST['warehouse_id'].') ';
					}
					
					$chalan_qty="select do_no,item_id,sum(total_unit) as chalan_qty from sale_do_chalan where 1 group by do_no,item_id";
					$ch_query = db_query($chalan_qty);
					while($ch_data = mysqli_fetch_object($ch_query))
					{
					$ch_qty_get[$ch_data->do_no][$ch_data->item_id]=$ch_data->chalan_qty;
					}
					
					$res="select m.do_no,s.item_id,i.item_name,m.do_date,m.entry_at ,m.entry_time, m.status,concat(d.dealer_code,'- ',d.dealer_name_e) as dealer_name,m.depot_id, m.entry_by, w.warehouse_name as depot,s.total_unit
from sale_do_master m,sale_do_details s,dealer_info d,warehouse w, item_info i

where m.do_no=s.do_no and m.status in ('CHECKED') and m.dealer_code=d.dealer_code and w.warehouse_id=m.depot_id and i.item_id=s.item_id
".$group_for_con.$con.$dealer_con." group by s.do_no,s.item_id order by s.do_no";
					$query = db_query($res);
					while($data = mysqli_fetch_object($query))
					{
					$do_chalan_qty=$ch_qty_get[$data->do_no][$data->item_id];
					$remain_qty=$data->total_unit-$do_chalan_qty;
					if($remain_qty>0){
					?>
                        <tr> 
									
							<td><?= $data->do_no?></td>
							<td><?= $data->do_date?></td>
							<td style="text-align:left"><?= $data->item_name?></td>
							<td><?= $data->total_unit?></td>
							<td><?= $do_chalan_qty;?></td>
							<td><?= $remain_qty;?></td>
							<td style="text-align:left"><?= $data->dealer_name?></td>
							<td style="text-align:left"><?= $data->depot?></td>
							<td><?= find_a_field('user_activity_management','fname','user_id='.$data->entry_by);?></td>
							<td><?= $data->status?></td>
					
                        </tr>
                        <?
                    }
					}
				?>
                    </tbody>
                </table>





        </div>

</div>








<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>