<?php
session_start();
//require_once "../../../assets/template/layout.top.php";
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
 $item = explode("#",$_POST['item_id']);

$item_id   = $item[1];
 $group_for = $_POST['group_for'];
$sql = 'select s.manual_code as sub_group_manual_code, g.manual_code as group_manual_code, i.finish_goods_code as item_manual_code from item_info i, item_sub_group s, item_group g where i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and i.item_id="'.$item_id.'"';
$qry = db_query($sql);
$info=mysqli_fetch_object($qry);

$item_sub_group = find_a_field('item_info i, item_sub_group s','s.manual_code','i.sub_group_id=s.sub_group_id and i.item_id="'.$item_id.'"');
$item_sub_id = find_a_field('item_info','sub_group_id','item_id="'.$item_id.'"');

$item_sql = 'select i.item_name,s.sub_group_id,s.sub_group_name,s.group_id,i.depreciation_cycle,i.depreciation_type,i.depreciation_rate,i.item_sub_ledger, i.ledger_id 

from item_sub_group s, item_info i 

where s.sub_group_id=i.sub_group_id and i.item_id="'.$item_id.'"';

$item_qry = db_query($item_sql);
$data=mysqli_fetch_object($item_qry);

$all['item_price'] = $data->price;
$all['po_date'] = $data->po_date;
$all['reg_date'] = $data->reg_date;
$all['quality'] = $data->quality;
$all['note'] = $data->note;
$all['warehouse_id'] = $data->warehouse_id;
$all['qty'] = 1;
$all['serial_no'] = $data->serial_no;
$all['sub_group_id'] = $data->sub_group_id;
$all['group_id'] = $data->group_id;
$all['dpc_cycle'] = $data->depreciation_cycle;
$all['dpc_type'] = $data->depreciation_type;
$all['dpc_rate'] = $data->depreciation_rate;
$all['price']=find_a_field('journal','sum(dr_amt-cr_amt)','sub_ledger="'.$data->item_sub_ledger.'" and ledger_id="'.$data->ledger_id.'"');
$all['depreciation_start_date'] = $data->depreciation_start_date;


$max_id = find_a_field('asset_register','count(id)','sub_group_id="'.$item_sub_id.'"')+1;


$all['asset_tag_id'] = filter_var(($group_for.$info->group_manual_code.$info->sub_group_manual_code.$info->item_manual_code), FILTER_SANITIZE_STRING);

echo json_encode($all);

?>


<?php /*?>
						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Item Name</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input list="items" name="item_ids" type="hidden" id="item_ids"   class="form-control" onchange="check_item(this.value)">

								<datalist id="items">

								<? foreign_relation('item_info i, item_sub_group s, item_group g','concat(i.item_name,"#",i.item_id)','concat(i.item_name,"#",i.item_id)',$item_id,'i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.ptype="asset" and item_group="'.$group_for.'"');?>

								</datalist>
								

                            </div>

                        </div><?php */?>

