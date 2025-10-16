<?php
require_once "../../../assets/template/layout.top.php";
$title='Gift Offer';

do_calander('#fdate');
do_calander('#tdate');

$table_master='sale_gift_offer';
$unique_master='id';
$page = $target_url = 'gift_offer.php';

?>

<div class="form-container_large">
    
<form action="" method="post" name="codz" id="codz">

        <div class="container-fluid bg-form-titel">
            <div class="row">

                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-center align-items-center pr-1 bg-form-titel-text">Offer Date:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input name="fdate" type="text" id="fdate" value="<? if($_POST['fdate']!=''){echo $_POST['fdate'];}else{echo date('Y-m-01');}?>"/> 
                        </div>
                    </div>

                </div>
				<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-center align-items-center pr-1 bg-form-titel-text">Date To:</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input name="tdate" type="text" id="tdate" value="<? if($_POST['tdate']!='') echo $_POST['tdate']; else echo date('Y-m-d');?>"/>
                        </div>
                    </div>

                </div>
                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4">
                    <div class="form-group row m-0">
                        <label class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-center align-items-center pr-1 bg-form-titel-text">Item :</label>
                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0">
							<?php 
							auto_complete_from_db('item_info','item_name','finish_goods_code','product_nature="Salable"','item_id');
							?>	  
							<input name="item_id" type="text" id="item_id" value="<? if($_POST['item_id']!='') echo $_POST['item_id'];?>"/>

                        </div>
                    </div>
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
				    <? if($$unique_master>0) {?>
					<!--<input name="new" type="submit" class="btn1" value="Update Demand Order" style="width:200px; font-weight:bold; font-size:12px;" tabindex="12" />-->
					<input name="flag" id="flag" type="hidden" value="1" />
					<? }else{?>
					<input name="new" type="submit" value="View Report" class="btn1 btn1-submit-input" />
					<input name="flag" id="flag" type="hidden" value="0" />
					<? }?>

					
                    
                </div>
				


            </div>
        </div>


						


            
        <div class="container-fluid pt-5 p-0 tabledesign2 ">

<? 
if($_POST['fdate']!='')
$con .= ' and a.start_date >= "'.$_POST['fdate'].'" and a.end_date <= "'.$_POST['tdate'].'" ';

if($_POST['group_for']!='')
$con .= ' and a.group_for="'.$_POST['group_for'].'"';

if($_POST['item_id']!='')
$con .= ' and b.finish_goods_code="'.$_POST['item_id'].'"';

if($_POST['gpn']!='')
$con .= ' and a.offer_name="'.$_POST['gpn'].'"';

if($_POST['new']){
$res='select a.id,a.id,a.offer_name as offer,a.start_date as Start,a.end_date as End,
b.item_name as main_item,a.item_qty, c.item_name as gift_item,a.gift_qty
from sale_gift_offer a,item_info b,item_info c 
where b.item_id=a.item_id and c.item_id=a.gift_id 
'.$con.'
order by id desc';
}
?>

					        <? echo link_report($res,$page); ?>


        </div>
    </form>
</div>


<?
require_once "../../../assets/template/layout.bottom.php";
?>