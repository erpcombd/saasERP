<?php
//ini_set('display_errors', '0');
//ini_set('display_startup_errors', '0');
//error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$head='<link href="../../css/report_selection.css" type="text/css" rel="stylesheet"/>';



$title='Asset Register';

if($_GET['clear']>0){
unset($_SESSION['assetId']);
header('location:asset_register.php');
}


do_calander('#depreation_start_date');

do_calander('#po_date');

do_calander('#reg_date');

do_calander('#depreciation_start_date');

$table='asset_register';

$crud= new crud($table);

if(isset($_POST['submit'])){

$exist=find_a_field('asset_register','asset_id','asset_id="'.$_POST['asset_id'].'" and asset_id!=""');

if($_POST['asset_id']!=$exist){

if($_POST['dpc_cycle']!=''){
//$_POST['warehouse_id']=$_SESSION['user']['depot'];

$_POST['entry_by']=$_SESSION['user']['id'];

$itemId=explode("#",$_POST['item_ids']);

$jv_date = $_POST['reg_date'];
$tr_from = 'Registered';

$jv_no=next_journal_sec_voucher_id('',$tr_from,$_SESSION['user']['group']);



$_POST['item_id']=$itemId[1];

$ledger_all=find_all_field('item_info i','i.ledger_id','i.item_id='.$_POST['item_id'].'');

$_POST['asset_tag'] = $_POST['asset_id'];
$_POST['estd_production_unit'] = $_POST['estd_production_unit'];

if($_POST['estd_production_unit']>0){
$_POST['unit_cost'] = (float)(($_POST['price']-$_POST['salvage_value'])/$_POST['estd_production_unit']);
}else{
$_POST['unit_cost']=0;
}

$id=$_SESSION['assetId']=$crud->insert();
$narration = 'New Asset Registered';

$reg_amt=(float)$_POST['price'];

$amt=(float)((float)$_POST['price']-(float)$_POST['salvage_value']);

journal_asset_item_control($_POST['item_id'] ,$_POST['warehouse_id'],$jv_date,1,0,'InStock',$id,$_POST['price'],0,$id,$_POST['price'],0,0,$_POST['serial_no'],
$_POST['asset_tag'],'');





asset_journal($jv_no,$jv_date,$_POST['asset_tag'],$ledger_all->asset_ledger,$narration,$reg_amt,0,$tr_from,$id,$_POST['group_for'],$_POST['warehouse_id']);

//Secondary Journal

//
//add_to_sec_journal('MEP', $jv_no, $jv_date, $ledger_all->asset_ledger,$narration,$amt,'0', $tr_from, $id,$_POST['group_for'],'',$_POST['asset_tag']);
//
//add_to_sec_journal('MEP', $jv_no, $jv_date, $ledger_all->ledger_id,$narration,'0',$amt, $tr_from, $id,$_POST['group_for'],'',$_POST['asset_tag']);

 $insert_sec="INSERT INTO `secondary_journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$ledger_all->asset_ledger.",'".$narration."',".$reg_amt.",'0', '".$tr_from."', ".$id.",".$ledger_all->item_sub_ledger.",".$_POST['group_for'].",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$ledger_all->ledger_id.",'".$narration."','0',".$reg_amt.", '".$tr_from."', ".$id.",".$ledger_all->item_sub_ledger.",".$_POST['group_for'].",".$_SESSION['user']['id'].",'')";

db_query($insert_sec);


// $insert_sec1="INSERT INTO `secondary_journal` 
//( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`,  `group_for`, `entry_by`, `entry_at`) 
//
//VALUES 
//
//
//('MEP',".$jv_no.", '".$jv_date."', ".$ledger_all->item_ledger.",'".$narration."','0',".$amt.", '".$tr_from."', ".$id.",".$_POST['group_for'].",".$_SESSION['user']['id'].",'')";
//
//db_query($insert_sec1);
//Journal



$sa_config = find_a_field('voucher_config','secondary_approval','voucher_type="'.$tr_from.'"');



$time_now = date('Y-m-d H:i:s');



if($sa_config=="Yes"){



$sa_up='update secondary_journal set secondary_approval="Yes", om_checked_at="'.$time_now.'", om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';



db_query($sa_up);



$jv_config = find_a_field('voucher_config','direct_journal','voucher_type="'.$tr_from.'"');





if($jv_config=="Yes"){



//sec_journal_journal($jv_no,$jv_no,$tr_from);

$insert_jur="INSERT INTO `journal` 
( `proj_id`, `jv_no`, `jv_date`, `ledger_id`, `narration`, `dr_amt`, `cr_amt`, `tr_from`, `tr_no`, sub_ledger, `group_for`, `entry_by`, `entry_at`) 

VALUES 

('MEP',".$jv_no.", '".$jv_date."', ".$ledger_all->asset_ledger.",'".$narration."',".$reg_amt.",'0', '".$tr_from."', ".$id.",".$ledger_all->item_sub_ledger.",".$_POST['group_for'].",".$_SESSION['user']['id'].",''),
('MEP',".$jv_no.", '".$jv_date."', ".$ledger_all->ledger_id.",'".$narration."','0',".$reg_amt.", '".$tr_from."', ".$id.",".$ledger_all->item_sub_ledger.",".$_POST['group_for'].",".$_SESSION['user']['id'].",'')";

db_query($insert_jur);



$time_now = date('Y-m-d H:i:s');



$up2='update secondary_journal set checked="YES", checked_at="'.$time_now.'", checked_by="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';



db_query($up2);



$sa_up2='update journal set secondary_approval="Yes", checked="YES", checked_by="'.$_SESSION['user']['id'].'", checked_at="'.$time_now.'", om_checked_at="'.$time_now.'" ,om_checked="'.$_SESSION['user']['id'].'" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';

db_query($sa_up2);





}



} else {



$sa_up='update secondary_journal set secondary_approval="No" where jv_no="'.$jv_no.'" and tr_from="'.$tr_from.'"';



db_query($sa_up);



}



if($_POST['dpc_cycle']=='Monthly'){
 
  $life_duration = $_POST['life_duration'];
  $dpc_end_date = date('Y-m-d',strtotime($_POST['depreciation_start_date'].' + '.$life_duration.' month'));
  
  $startDate = strtotime($_POST['depreciation_start_date']);
  $endDate = strtotime($dpc_end_date);

  for ($i = $startDate; $i <= $endDate; $i = strtotime("+1 month", $i)) {
    $mon = date('m', $i);
	$year = date('Y', $i);
	$mdays = date('t', $i);
	$dpc_date = $year.'-'.$mon.'-'.$mdays;
	$minsert = 'insert into dpc_duration_info set mon="'.$mon.'",year="'.$year.'",dpc_date="'.$dpc_date.'",asset_id="'.$_POST['asset_tag'].'",item_id="'.$_POST['item_id'].'",group_id="'.$_POST['group_id'].'",sub_group_id="'.$_POST['sub_group_id'].'",entry_by="'.$_POST['entry_by'].'",entry_at="'.date('Y-m-d H:i:s').'",group_for="'.$_POST['group_for'].'",warehouse_id="'.$_POST['warehouse_id'].'",dpc_type="'.$_POST['dpc_type'].'",dpc_cycle="'.$_POST['dpc_cycle'].'",dpc_rate="'.$_POST['dpc_rate'].'"';
	db_query($minsert);
  }
 
}elseif($_POST['dpc_cycle']=='Yearly'){

  $life_duration = $_POST['life_duration'];
  $dpc_end_date = date('Y-m-d',strtotime($_POST['depreciation_start_date'].' + '.$life_duration.' year'));
  
  $startDate = strtotime($_POST['depreciation_start_date']);
  $endDate = strtotime($dpc_end_date);

  for ($i = $startDate; $i <= $endDate; $i = strtotime("+1 year", $i)) {
	$year = date('Y', $i);
	$dpc_date = $year.'-12-31';
	$yinsert = 'insert into dpc_duration_info set year="'.$year.'",dpc_date="'.$dpc_date.'",asset_id="'.$_POST['asset_tag'].'",item_id="'.$_POST['item_id'].'",group_id="'.$_POST['group_id'].'",sub_group_id="'.$_POST['sub_group_id'].'",entry_by="'.$_POST['entry_by'].'",entry_at="'.date('Y-m-d H:i:s').'",group_for="'.$_POST['group_for'].'",warehouse_id="'.$_POST['warehouse_id'].'",dpc_type="'.$_POST['dpc_type'].'",dpc_cycle="'.$_POST['dpc_cycle'].'",dpc_rate="'.$_POST['dpc_rate'].'"';
	db_query($yinsert);
  }
  
}else{

}


 echo '<div class="alert alert-success" role="alert">

    New Item Registered Successfully

  </div>';
}else{

    echo '<div class="alert alert-danger" role="alert">

    Please Setup Depreciation Cycle, Depreciation Type, Depreciation Rate Properly!!

  </div>';

}

}else{

    echo '<div class="alert alert-danger" role="alert">

    Serial Number Already Exist

  </div>';

}

}

/*if(isset($_POST['update'])){

    $_POST['id']=$_SESSION['assetId'];
    $itemId=explode("#",$_POST['item_ids']);
    $_POST['item_id']=$itemId[1];    
	$crud->update('id');
    echo '<div class="alert alert-success" role="alert">

    Asset Updated Successfully

  </div>';

}*/


//if($_GET['delId']!=''){
//
//$delId = url_decode($_GET['delId']);
//
//$condition="id=".$delId;		
//
//		$crud->delete($condition);
//
//		unset($$unique);
//
//		$type=1;
//
//		$msg='Successfully Deleted.';
//		$tr_type="Delete";
//}

if($_GET['assetId']>0){
$_SESSION['assetId'] = $_GET['assetId'];
}


if($_SESSION['assetId']>0){



        $condition="id=".$_SESSION['assetId'];

        $data=db_fetch_object($table,$condition);

        foreach($data as $key =>$value)

        { $$key=$value;}




}

?>









<form action="" method="post" autocomplete="off">

    <div class="form-container_large">
        
        <h4 class="text-center bg-titel bold pt-2 pb-2"> Asset Register Form </h4>

        <div class="container-fluid bg-form-titel">

            <div class="row">

                <!--left form-->

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                    <div class="container n-form2">

						

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <select name="group_for" id="group_for" class="form-control" onchange="check_item_group(this.value)" required>
                               <option></option>
                               <? foreign_relation('user_group','id','group_name',$_POST['group_for'],'1')?>
                               </select>
				<span id="gf"></span>
                            </div>

                        </div>
						
						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Registation Date</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input name="reg_date" type="text" id="reg_date" value="<?=($reg_date!='')?$reg_date:date('Y-m-d')?>"  class="form-control">
								<input type="hidden" id="sub_group_id" name="sub_group_id" />
								<input type="hidden" id="group_id" name="group_id" />
								<input type="hidden" id="dpc_cycle" name="dpc_cycle" />
								<input type="hidden" id="dpc_type" name="dpc_type" />
								<input type="hidden" id="dpc_rate" name="dpc_rate" />
								

                            </div>

                        </div>
				<span id="item_select">
						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Item Name</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                                <input list="items" name="item_ids" type="text" id="item_ids"   class="form-control" onchange="check_item(this.value)">

								<datalist id="items">

								<? foreign_relation('item_info i, item_group g','concat(i.item_name,"#",i.item_id)','concat(i.item_name,"#",i.item_id,">>",i.item_sub_ledger)',$item_id,'i.item_group=g.group_id and g.ptype="asset" group by i.item_id');?>

								</datalist>
								<span id="response"></span>

                            </div>

                        </div>
	</span>


                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Acquisition cost </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

							 <input name="price" type="text" id="price" value="<?=$price?>" class="form-control">

							  

                            </div>

                        </div>
						
						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">  Salvage Value  </label>
                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

							 <input name="salvage_value" type="text" id="salvage_value" value="<?=$salvage_value?>" class="form-control">

							  

                            </div>

                        </div>
						
                        <?php /*?><div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Total Quantity</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

							 <input name="qty" type="hidden" id="qty" value="<?=$qty?>" class="form-control">

							  <input name="serial_no" type="hidden" id="serial_no" value="<?=$serial_no?>" class="form-control">

                            </div>

                        </div><?php */?>
						
						
						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Serial No.</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

							<input name="qty" type="hidden" id="qty" value="<?=$qty?>" class="form-control">

							  <input name="serial_no" type="text" id="serial_no" value="<?=$serial_no?>" class="form-control">

							  

                            </div>

                        </div>
						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Already Production Qty 
</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                               <input name="production_qty" type="text" id="production_qty" value="<?=$production_qty?>"  class="form-control">  

                            </div>

                        </div>

                    </div>

                </div>



                <!--Right form-->

                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">

                    <div class="container n-form2">

                       



                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Asset Tag ID</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">
                                <input type="hidden" name="quality" id="quality" value="Good" />
                                <input type="text" name="asset_id" id="asset_id" value="<?=$asset_id?>" readonly="readonly" />

                            </div>

                        </div>

                        <div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Purchase Date</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                               <input name="po_date" type="text" id="po_date" value="<?=$po_date?>"  class="form-control">  

                            </div>

                        </div>
						
						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Depreciation Start Date</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                               <input name="depreciation_start_date" type="text" id="depreciation_start_date" value="<?=$depreciation_start_date?>"  class="form-control">  

                            </div>

                        </div>

						

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Area/Branch/Depot</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                              <select name="warehouse_id" id="warehouse_id" class="form-control" required>

							  <option></option>

							  <? foreign_relation('asset_section','id','section_name',$warehouse_id,'1');?>

							  </select>

                            </div>

                        </div>

						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                               <input name="note" type="text" id="note" value="<?=$note?>"  class="form-control">  

                            </div>

                        </div>
						
						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text"> Estimated Life </label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                               <input name="life_duration" type="text" id="life_duration" value="<?=$life_duration?>"  class="form-control">  

                            </div>

                        </div>
						
						<div class="form-group row m-0 pb-1">

                            <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Estd unit of Production 
</label>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2 ">

                               <input name="estd_production_unit" type="text" id="estd_production_unit" value="<?=$estd_production_unit?>"  class="form-control">  

                            </div>

                        </div>
						
						

                    </div>

                </div>





            </div>



        </div>

        <div class="container-fluid p-0 ">

            <div class="n-form-btn-class">

                <!--            button code hear-->

                <? if($_SESSION['assetId']>0){?>

                <!--<input name="update" type="submit" class="btn1 btn1-bg-submit" id="update" value="Update" />-->
				
				<input name="submit" type="submit" class="btn1 btn1-bg-submit" id="submit" value="New Register" />

                <span class="btn btn-danger" onclick=" window.location= 'asset_register.php?clear=2';">Reset</span>

                <? }else{?>

                    <input name="submit" type="submit" class="btn1 btn1-bg-submit" id="submit" value="New Register" />



                    <? }?>

                   

            </div>
			



        </div>
		
		
		

        </form>

		

	<?php /*?><div class="col-12 tabledesign2">

    <table class="table table-striped" id="grp">

  <thead>

    <tr>

      <th scope="col">S/L</th>

      <th scope="col">Item Name</th>
	  
	  <th scope="col">Asset Tag</th>
	  
	  <th scope="col">Serial No.</th>
	  
	  <th scope="col">Item Price</th>
	  
	  <th scope="col">Register Date</th>

      <th scope="col">Depreciation Start Date</th>

      <th scope="col">Depot/Branch</th>

      <th scope="col">Quality</th>
	  
	  <th scope="col">Status</th>

	<!--<th scope="col">Status</th>-->
    </tr>
  </thead>

  <tbody>

    <?php

     $sql='select r.*,i.item_name from asset_register r,item_info i where r.item_id=i.item_id group by r.serial_no';

     $query=db_query($sql);

     $i=1;

     while($data=mysqli_fetch_object($query)){
	 $warehouse = find_a_field('warehouse','warehouse_name','warehouse_id="'.$data->warehouse_id.'"');
     ?>

   <tr onclick="window.location='?assetId=<?=$data->id?>';" style="cursor:pointer">

      <th scope="row"><?=$i++?></th>

      <td><?=$data->item_name?></td>

	  <td><?=$data->asset_id?></td>
	  <td><?=$data->serial_no?></td>
	  <td><?=$data->price?></td>
	  <td><?=date("d-m-Y",strtotime($data->reg_date))?></td>

      <td><?=$data->depreciation_start_date?></td>

      <td><?=$warehouse?></td>

      <td><?=$data->quality?></td>

	  <td><?=$data->item_status?></td>
	  
	  <!--<td><a href="?delId=<?=url_encode($data->id)?>">X</a></td>-->
    </tr>

  <? }?>
  </tbody>
</table>

    </div><?php */?>	

		

    </div>


<script>

  function check_item(item_id) {
  var group_for = document.getElementById('group_for').value;
    
    $.ajax({
      url: 'get_item_info.php',
      type: 'POST',
      data: {
        item_id: item_id,
		group_for: group_for
      },
      success: function(response) {
      
        var res = JSON.parse(response);
        //document.getElementById("price").value = res['item_price'];
		//document.getElementById("po_date").value = res['po_date'];
		//document.getElementById("depreciation_start_date").value = res['depreciation_start_date'];
		document.getElementById("quality").value = 'Good';
		//document.getElementById("note").value = res['note'];
		//document.getElementById("warehouse_id").value = res['warehouse_id'];
		document.getElementById("qty").value = res['qty'];
		document.getElementById("sub_group_id").value = res['sub_group_id'];
		document.getElementById("group_id").value = res['group_id'];
		document.getElementById("dpc_cycle").value = res['dpc_cycle'];
		document.getElementById("dpc_type").value = res['dpc_type'];
		document.getElementById("dpc_rate").value = res['dpc_rate'];
		document.getElementById("price").value = res['price'];
		document.getElementById("asset_id").value = res['asset_tag_id'];
      },
      error: function(xhr, status, error) {
        
        console.error(error);
      }
    });
  }
  function check_item_group(group_for_id) {
  var group_for = document.getElementById('group_for').value;
  
  $.ajax({
    url: 'get_item_info_group.php',
    type: 'POST',
    data: {
      item_id: '353',
      group_for: group_for_id
    },
    success: function(response) {
      // Clear previous options in the datalist
      var datalist = document.getElementById("items");
      datalist.innerHTML = ''; // Clear existing options

      // Parse the response to extract the options
      var options = response.split("\n"); // Assuming each option is returned on a new line
      options.forEach(function(option) {
        var optionElement = document.createElement("option");
        optionElement.value = option;
        datalist.appendChild(optionElement); // Add the new option to the datalist
      });

      console.log(response); // Log the response for debugging
    },
    error: function(xhr, status, error) {
      console.error(error); // Log the error for debugging
    }
  });
}
  // function check_item(item_id) {
  // var group_for = document.getElementById('group_for').value;
    
  //   $.ajax({
  //     url: 'get_item_info.php',
  //     type: 'POST',
  //     data: {
  //       item_id: item_id,
	// 	group_for: group_for
  //     },
  //     success: function(response) {
      
  //       var res = JSON.parse(response);
  //       //document.getElementById("price").value = res['item_price'];
	// 	//document.getElementById("po_date").value = res['po_date'];
	// 	//document.getElementById("depreciation_start_date").value = res['depreciation_start_date'];
	// 	document.getElementById("quality").value = 'Good';
	// 	//document.getElementById("note").value = res['note'];
	// 	//document.getElementById("warehouse_id").value = res['warehouse_id'];
	// 	document.getElementById("qty").value = res['qty'];
	// 	document.getElementById("sub_group_id").value = res['sub_group_id'];
	// 	document.getElementById("group_id").value = res['group_id'];
	// 	document.getElementById("dpc_cycle").value = res['dpc_cycle'];
	// 	document.getElementById("dpc_type").value = res['dpc_type'];
	// 	document.getElementById("dpc_rate").value = res['dpc_rate'];
	// 	document.getElementById("price").value = res['price'];
	// 	document.getElementById("asset_id").value = res['asset_tag_id'];
  //     },
  //     error: function(xhr, status, error) {
        
  //       console.error(error);
  //     }
  //   });
  // }
</script>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>