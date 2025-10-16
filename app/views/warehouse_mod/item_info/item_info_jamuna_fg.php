<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Product Information Setup';

do_datatable('item_table');

$proj_id=$_SESSION['proj_id'];

function createSubLedger($code,$name,$tr_from,$tr_id,$ledger_id,$type){

$insert = 'insert into general_sub_ledger set sub_ledger_id="'.$code.'",sub_ledger_name="'.$name.'",tr_from="'.$tr_from.'",tr_id="'.$tr_id.'",ledger_id="'.$ledger_id.'",type="'.$type.'",entry_at="'.date('Y-m-d H:i:s').'",entry_by="'.$_SESSION['user']['id'].'",group_for="'.$_SESSION['user']['group'].'"';
db_query($insert);
return db_insert_id();

}

$now=time();

$unique='item_id';

$unique_field='item_name';

$table='item_info';

$page="item_info_jamuna_fg.php";

$crud      =new crud($table);

$$unique = $_GET[$unique];

$tr_type="Show";



if(isset($_POST[$unique_field]))

{

$$unique = $_POST[$unique];

//for Record..................................

$_POST['item_name'] = str_replace('"',"``",$_POST['item_name']);

//$_POST['item_name'] = str_replace("'","`",$_POST['item_name']);



$_POST['item_description'] = str_replace(Array("\r\n","\n","\r"), " ", $_POST['item_description']);



$_POST['item_description'] = str_replace('"',"``",$_POST['item_description']);

$_POST['item_description'] = str_replace("'","`",$_POST['item_description']);





$_POST['group_for'] = find_a_field('item_sub_group','group_for','sub_group_id='.$_POST['sub_group_id']);

if(isset($_POST['record']))

{

$_POST['entry_at']=date('Y-m-d H:i:s');

$_POST['entry_by']=$_SESSION['user']['id'];


$custome_codes = find_a_field('item_info','max(sub_ledger_id)','1');
if($custome_codes>0){
	$custome_code = $custome_codes+1;
	}
	else{
	$custome_code = 30000001;
	}
$_POST['sub_ledger_id'] = $custome_code;
$min=number_format($_POST['sub_group_id'] + 1, 0, '.', '');

$max=number_format($_POST['sub_group_id'] + 10000, 0, '.', '');

$_POST[$unique]=number_format(next_value('item_id','item_info','1',$min,$min,$max), 0, '.', '');

$_POST['account_code']=find_a_field('item_sub_group','item_ledger','sub_group_id="'.$_POST['sub_group_id'].'"');
$ledger_gl_found = find_a_field('general_sub_ledger','sub_ledger_id','sub_ledger_name='.$_POST['item_name']);



if ($ledger_gl_found==0) {
createSubLedger($custome_code,$_POST['item_name'],'item',$_POST[$unique],$_POST['account_code'] ,$_POST['sub_group_id']);

}

$crud->insert();



$type=1;

$msg='New Entry Successfully Inserted.';
$tr_type="Add";


unset($_POST);

unset($$unique);
header("Location: item_info_jamuna.php");
}



//for Modify..................................



if(isset($_POST['modify']))

{

		

$_POST['item_name'] = str_replace('"',"``",$_POST['item_name']);

$_POST['item_name'] = str_replace("'","`",$_POST['item_name']);



$_POST['item_description'] = str_replace(Array("\r\n","\n","\r"), " ", $_POST['item_description']);



$_POST['item_description'] = str_replace('"',"``",$_POST['item_description']);

$_POST['item_description'] = str_replace("'","`",$_POST['item_description']);



		$_POST['edit_at']=date('Y-m-d H:i:s');

		$_POST['edit_by']=$_SESSION['user']['id'];

		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';
		$tr_type="Add";

}



//for Delete..................................







if(isset($_POST['delete']))



{		

		$condition=$unique."=".$$unique;		

		$crud->delete($condition);

		unset($$unique);

		$type=1;

		$msg='Successfully Deleted.';
		$tr_type="Delete";

}







}



if(isset($$unique))

{

	$condition=$unique."=".$$unique;	

	$data=db_fetch_object($table,$condition);

	foreach ($data as $key => $value){ $$key=$value;}

}





//for Modify..................................



if($_REQUEST['src_sub_group_id']>0){$_SESSION['src_sub_group_id'] = $_REQUEST['src_sub_group_id'];$_SESSION['src_item_id'] = $_REQUEST['src_item_id'];}else{$_SESSION['src_sub_group_id']="";}

if($_REQUEST['src_item_id']!=''){$_SESSION['src_sub_group_id'] = $_REQUEST['src_sub_group_id'];$_SESSION['src_item_id'] = $_REQUEST['src_item_id'];}

if($_REQUEST['item_group']!=''){$_SESSION['item_group'] = $_REQUEST['item_group'];$_SESSION['item_group'] = $_REQUEST['item_group'];}

if($_REQUEST['fg_code']!=''){$_SESSION['fg_code'] = $_REQUEST['fg_code'];$_SESSION['fg_code'] = $_REQUEST['fg_code'];}else{$_SESSION['fg_code']="";}



if(isset($_REQUEST['cancel'])){unset($_SESSION['item_group']);unset($_SESSION['src_sub_group_id']);unset($_SESSION['src_item_id']);unset($_SESSION['fg_code']);}



if($_SESSION['item_group']>0){

$item_group = $_SESSION['item_group'];

$con .='and b.group_id="'.$item_group.'" ';}


if($_SESSION['src_sub_group_id']>0){

$src_sub_group_id = $_SESSION['src_sub_group_id'];

$con .='and a.sub_group_id="'.$src_sub_group_id.'" ';}



if($_SESSION['src_item_id']!=''){

$src_item_id = $_SESSION['src_item_id'];

$con .='and a.item_name like "%'.$src_item_id.'%" ';}



if($_SESSION['fg_code']>0){

$fg_code = $_SESSION['fg_code'];

$con .='and a.finish_goods_code="'.$fg_code.'" ';}
$tr_from="Warehouse";
?>

<script type="text/javascript">

$(function() {

		$("#fdate").datepicker({

			changeMonth: true,

			changeYear: true,

			dateFormat: 'yy-mm-dd'

		});

});

function Do_Nav()

{

	var URL = 'pop_ledger_selecting_list.php';

	popUp(URL);

}



function DoNav(theUrl)

{

	document.location.href = '<?=$page?>?<?=$unique?>='+theUrl;

}

function popUp(URL) 

{

	day = new Date();

	id = day.getTime();

	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>


	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-sm-7 p-0 pr-2">
				<div class="container p-0">
				<form id="form1" name="form1" class="n-form1 pt-0" method="post" action="">
				<h4 align="center" class="n-form-titel1">Search Product Information</h4>


						<div class="form-group row m-0 pl-3 pr-3 p-1">
							<label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Product Group</label>
							<div class="col-sm-9 p-0">
								<select name="item_group" id="item_group" onchange="getData2('item_sub_group_ajax.php', 'item_sub_group', this.value,document.getElementById('item_group').value);">

									<option ></option>
									<? foreign_relation('item_group','group_id','group_name',$_POST['item_group'],'1 and group_for="'.$_SESSION['user']['group'].'" order by group_name');?>
								</select>
							</div>
						</div>


						<div class="form-group row m-0 pl-3 pr-3 p-1">
							<label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Sub Group</label>
							<div class="col-sm-9 p-0">

								<select name="src_sub_group_id" id="src_sub_group_id">

									<option></option>

									<?php

									$a2="select sub_group_id, sub_group_name from item_sub_group where 1 and group_for='".$_SESSION['user']['group']."'";

									//echo $a2;

									$a1=db_query($a2);



									while($a=mysqli_fetch_row($a1))

									{

										if($a[0]==$src_sub_group_id)

											echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

										else

											echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

									}

									?></select>
							</div>
						</div>


						<div class="form-group row m-0 pl-3 pr-3 p-1">
							<label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Product Name</label>
							<div class="col-sm-9 p-0">
								<input name="src_item_id" class="m-0" type="text" id="src_item_id" value="<?php echo $_SESSION['src_item_id']; ?>" />
							</div>
						</div>


						<div class="form-group row m-0 pl-3 pr-3 p-1">
							<label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Product Code</label>
							<div class="col-sm-9 p-0">
								<input name="fg_code" class="m-0" type="text" id="fg_code"  value="<?php echo $_SESSION['fg_code']; ?>" />
							</div>
						</div>


						<div class="n-form-btn-class">
							<input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
							<input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Clear" />
						</div>

					</form>

				</div>


				<div class="container n-form1">


						<?

						if($_SESSION['item_group']>0||$_SESSION['src_sub_group_id']>0||$_SESSION['src_item_id']!=''||$_SESSION['fg_code']>0){

							?>

							<table id="table_head" class="table table-striped table-bordered table-hover table-sm" cellspacing="0">
								<thead class="thead1">
								<tr class="bgc-info">
									<th><span class="style2">Product Code </span></th>
									<th><span class="style2">Product Name</span></th>
									<th><span class="style2">Category </span></th>
									<th><span class="style2">Status</span></th>
								</tr>
								</thead>

								<tbody>
								<?php

								 $td="select a.item_id,a.item_name,b.sub_group_name,a.item_description,a.finish_goods_code, a.status FROM item_info a, item_sub_group b where b.sub_group_id=a.sub_group_id ".$con." order by item_id";

								$report=db_query($td);

								while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

									<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">

										<td><?=$rp[4];?></td>

										<td><?=$rp[1];?></td>

										<td><?=$rp[2];?></td>
										<td><?=$rp[5];?></td>
									</tr>

								<?php }?>
								</tbody>
							</table>

						<? }?>


				</div>

			</div>


			<div class="col-sm-5 p-0  pl-2">

				<form id="form1" name="form1" class="n-form setup-fixed" method="post" action="" enctype="multipart/form-data" onsubmit="return check()">
					<h4 align="center" class="n-form-titel1"> <?=$title?> </h4>


<!--					<div class="form-group row m-0 pl-3 pr-3">-->
<!--						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label"> Item Code</label>-->
<!--						<div class="col-sm-9 p-0">-->
<!--							<input name="item_name2" type="text" id="item_name2" value="--><?//=$$unique?><!--" class="required" readonly="readonly" />-->
<!--						</div>-->
<!--					</div>-->



					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input"> Product Code</label>
						<div class="col-sm-9 p-0">
							<input type="text" name="finish_goods_code" class="m-0" id="finish_goods_code" value="<?=$finish_goods_code?>" required />
						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
    <label class="col-sm-4 pl-0 pr-0 col-form-label">Item Group :</label>
    <div class="col-sm-8 p-0">
        <select name="group_id_cus" id="group_id_cus" required>
		<?php 
		if($_GET['item_id']>0){
		?>
		<option value="<?=$group_id_cus?>"><?php echo find_a_field('item_group_cus','group_name','group_id="'.$group_id_cus.'"');?></option>
		<?php } ?>
            <option value="">-- Select Group --</option>
            <?php
            $sql="SELECT * FROM item_group_cus WHERE 1 ORDER BY group_id";
            $query=db_query($sql);
            while($datas=mysqli_fetch_object($query)) {
                ?>
                <option value="<?=$datas->group_id?>"><?=$datas->group_name?></option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="form-group row m-0 pl-3 pr-3 p-1">
    <label class="col-sm-4 pl-0 pr-0 col-form-label">Item Sub Group :</label>
    <div class="col-sm-8 p-0">
        <select name="group_id" id="group_id" required>
			<?php 
		if($_GET['item_id']>0){
		?>
		<option value="<?=$group_id?>"><?php echo find_a_field('item_group','group_name','group_id="'.$group_id.'"');?></option>
		<?php } ?>
            <option value="">-- Select Sub Group --</option>
        </select>
    </div>
</div>

<div class="form-group row m-0 pl-3 pr-3 p-1">
    <label class="col-sm-4 pl-0 pr-0 col-form-label">Item Sub Sub Group :</label>
    <div class="col-sm-8 p-0">
        <select name="sub_group_id" id="sub_group_id" required>
					<?php 
		if($_GET['item_id']>0){
		?>
		<option value="<?=$sub_group_id?>"><?php echo find_a_field('item_sub_group','sub_group_name','sub_group_id="'.$sub_group_id.'"');?></option>
		<?php } ?>
            <option value="">-- Select Sub Sub Group --</option>
        </select>
    </div>
</div>

					
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Product Name </label>
						<div class="col-sm-9 p-0">
							<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />

							<input name="item_name" class="m-0" type="text" id="item_name" value="<?php echo $item_name;?>"  required />
							<input name="product_nature" type="hidden" id="product_nature" value="Salable"  class="required m-0" />

						</div>
					</div>

					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Description  </label>
						<div class="col-sm-9 p-0">

							<input name="item_description" class="m-0" type="text" id="item_description" value="<?php echo $item_description;?>" />

						</div>
					</div>



<!--					<div class="form-group row m-0 pl-3 pr-3 p-1">-->
<!--						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Product Group  </label>-->
<!--						<div class="col-sm-9 p-0">-->
<!---->
<!--							<select name="group_id" id="group_id" style="width: float:left"  onchange="getData2('product_group_ajax.php', 'product_sub_group', this.value,document.getElementById('group_id').value);" required>-->
<!---->
<!--								<option ></option>-->
<!--								--><?// foreign_relation('item_group','group_id','group_name',$group_id,'1');?>
<!--							</select>-->
<!---->
<!--						</div>-->
<!--					</div>-->


					



					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Product Nature </label>
						<div class="col-sm-9 p-0">

							<select name="product_nature" id="product_nature" required="required">

						<option value="<?=$product_nature?>"><?=$product_nature?></option>
								<option value="Salable">Saleable</option>

								<option value="Purchasable">Purchasable</option>

								<option value="Both">Both</option>

							</select>

						</div>
					</div>
					
					
					
				<div class="form-group row m-0 pl-3 pr-3 p-1">
				<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Paper Type</label>
				<div class="col-sm-9 p-0">

			<select name="paper_type" id="paper_type" required>
			
			<option value="<?=$paper_type?>">
                              <?=$paper_type?>
		
            <option>Woodfree Offset</option>
			<option>Kraft</option>
			<option>Duplex</option>
			<option>Art Paper</option>
			<option>Etc</option>
			
           
           </select>

		</div>
	</div>
						
          <div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">GSM(Grams Per Square meter)</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="gsm" id="gsm" value="<?=$gsm?>" />

						</div>
					</div>
           

           <div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Sheet Size </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="sheet_size" id="sheet_size" value="<?=$sheet_size?>" />

						</div>
					</div>

       <div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Roll Size</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="roll_size" id="roll_size" value="<?=$roll_size?>" />

						</div>
					</div>
					
					
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
				<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Color</label>
				<div class="col-sm-9 p-0">

			<select name="color" id="color" required>
			
			<option value="<?=$color?>">
                              <?=$color?>
		
            <option>White </option>
			<option>Brown</option>
			<option>Custom</option>
	
           </select>

		</div>
	</div>
	
	
	<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Brand Name</label>
						<div class="col-sm-9 p-0">

							<select name="item_brand" id="item_brand" required>
							
							<option value="<?=$item_brand?>">
                              <?=$item_brand?>
		
                     <option>A </option>
			         <option>B</option>
			         <option>C</option>
	
           </select>

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Manufacture Name</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="manufacturer_name" id="manufacturer_name" value="<?=$manufacturer_name?>" />

						</div>
					</div>
	
	     <div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Country Of Origin</label>
						<div class="col-sm-9 p-0">

							<select name="country_origin" id="country_origin" required>
							
		                    <option value="<?=$country_origin?>">
                              <?=$country_origin?>
							  
                     <option>Bangladesh</option>
			         <option>India</option>
			         
           </select>


						</div>
					</div>
	
	    <div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Material Composition</label>
						<div class="col-sm-9 p-0">

						<select name="material_composition" id="material_composition" required>
						<option value="<?=$material_composition?>">
                         <?=$material_composition?>
		
                     <option>100% Virgin Pule</option>
			         <option>Recycled Pulp</option>
			         
          </select>
				</div>
			</div>
			
			<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Moisture Content(%)</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="moisture_content" id="moisture_content" value="<?=$moisture_content?>" />

						</div>
					</div>

                   <div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Brightness(%)</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="brightness" id="brightness" value="<?=$brightness?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Opacity(%)</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="opacity" id="opacity" value="<?=$opacity?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Smoothness (Bendtsen)</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="smoothness" id="smoothness" value="<?=$smoothness?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Packaging Type</label>
						<div class="col-sm-9 p-0">

							<select name="packaging_type" id="packaging_type" required>
							
							<option value="<?=$packaging_type?>">
                         <?=$packaging_type?>
		
                     <option>Ream Wrapped</option>
			         <option> Boxed</option>
					 <option>Palletized</option>
			         
          </select>
				</div>
			</div>
				    
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Sheets Per Ream</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="sheet_per_ream" id="sheet_per_ream" value="<?=$sheet_per_ream?>" />

						</div>
					</div>
					
					
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Units Per Carton</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="units_per_carton" id="units_per_carton" value="<?=$units_per_carton?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Unite Per Pallet</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="units_per_pallet" id="units_per_pallet" value="<?=$units_per_pallet?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Expiry Date</label>
						<div class="col-sm-9 p-0">

							<select name="expiry_date_applicable" id="expiry_date_applicable" required>
		               <option value="<?=$expiry_date_applicable?>">
                         <?=$expiry_date_applicable?>
					   
                     <option>Yes</option>
			         <option> No</option>
					 
			         
          </select>
				</div>
			</div>
			
			<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">HS Code</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="hs_code" id="hs_code" value="<?=$hs_code?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Certifications</label>
						<div class="col-sm-9 p-0">
							<select name="certifications" id="certifications" required>
							
							<option value="<?=$certifications?>">
                         <?=$certifications?>
                      <option>ISO 9001</option>
			          <option> FSC Certified</option>
			         
          </select>
			</div>
			</div>
					
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Usage Application</label>
						<div class="col-sm-9 p-0">

							<select name="usage_application" id="usage_application" required>
		               <option value="<?=$usage_application?>">
                         <?=$usage_application?>
                     <option>Office Printing</option>
			         <option> Packaging</option>
					 <option>Notebooks</option>
					 
			         
          </select>
				</div>
			</div>
			
			
			<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Special Features</label>
						<div class="col-sm-9 p-0">

							<select name="special_features" id="special_features" required>
		               <option value="<?=$special_features?>">
                         <?=$special_features?>
						 
                     <option>Jam-Free</option>
			         <option> Eco-Friendly</option>
					 <option>High Brightness</option>
					 
			         
          </select>
				</div>
			</div>
			
			
			<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Minimum Order Quentity</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="moq" id="moq" value="<?=$moq?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Lead Item</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="lead_time" id="lead_time" value="<?=$lead_time?>" />

						</div>
					</div>
					
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Custom Branding Available</label>
						<div class="col-sm-9 p-0">

							<select name="custom_branding_available" id="custom_branding_available" required>
		              <option value="<?=$custom_branding_available?>">
                         <?=$custom_branding_available?>
						 
                     <option>Yes</option>
			         <option>No</option> 
			         
          </select>
				</div>
			</div>
			
			
			<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Barcode UPC</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="barcode_upc" id="barcode_upc" value="<?=$barcode_upc?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Storage Guidelines</label>
						<div class="col-sm-9 p-0">

							<select name="storage_guidelines" id="storage_guidelines" required>
							 <option value="<?=$storage_guidelines?>">
                         <?=$storage_guidelines?>
		
                     <option>A</option>
			         <option>B</option> 
			         
          </select>
				</div>
			</div>
			
			<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Net weight Per Unit</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="net_weight_per_unit" id="net_weight_per_unit" value="<?=$net_weight_per_unit?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Gross weight Per Unit</label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="gross_weight_per_unit" id="gross_weight_per_unit" value="<?=$gross_weight_per_unit?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Warranty</label>
						<div class="col-sm-9 p-0">

							<select name="warranty" id="warranty" required>
		               <option value="<?=$warranty?>">
                         <?=$warranty?>
                     <option>Yes </option>
			         <option>No</option> 
			         
          </select>
				</div>
			</div>
			
			
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Unit Name  </label>
						<div class="col-sm-9 p-0">

								<?php

								$a2="select unit_name, unit_name from unit_management where 1 order by id";

								//echo $a2;

								$a1=db_query($a2);

								echo "<select name=\"unit_name\" id=\"unit_name\"\">";

								echo "<option value=\"\" selected></option>";

								while($a=mysqli_fetch_row($a1))

								{

									if($a[0]==$unit_name)

										echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

									echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

								}

								echo "</select>";

								?>
						</div>
					</div>

					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">CTN/MB   </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="ctn_size" id="ctn_size" value="<?=$ctn_size?>" Placeholder="Default : 1" required />

						</div>
					</div>


					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Pack Size/Box/Poly  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="pack_size" id="pack_size" value="<?=$pack_size?>" Placeholder="Default : 1" required />

						</div>
					</div>




					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Buy Unit  </label>
						<div class="col-sm-9 p-0">

							<?php



							$a2="select unit_name, unit_name from unit_management";

							//echo $a2;

							$a1=db_query($a2);

							echo "<select name=\"purchase_unit\" id=\"purchase_unit\"\">";

							echo "<option value=\"\" selected></option>";

							while($a=mysqli_fetch_row($a1))

							{

								if($a[0]==$purchase_unit)

									echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

								else

									echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

							}

							echo "</select>";

							?>

						</div>
					</div>




					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Buy Unit Size  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="purchase_size" id="purchase_size" value="<?=$purchase_size?>" />

						</div>
					</div>




					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Cost Price  Per Unit </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="cost_price" id="cost_price" value="<?=$cost_price?>" />

						</div>
					</div>
                     
					 <div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label"> Price  Per Unit </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="" id="" value="" />

						</div>
					</div>


					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Sale Price  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="d_price" id="d_price" value="<?=$d_price?>" />

						</div>
					</div>

					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">MRP Price  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="m_price" id="m_price" value="<?=$m_price?>" />

						</div>
					</div>
					

<fieldset class="scheduler-border" style=" margin: 0px 15px 10px !important; ">
   					 <legend class="scheduler-border">SFA</legend>

					<div class="form-group row m-0 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">TP </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="t_price" id="t_price" value="<?=$t_price?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">DP Dis %  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="d_price_per" id="d_price_per" value="<?=$d_price_per?>" />

						</div>
					</div>
					
					
					<div class="form-group row m-0 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">DP  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="d_price" id="d_price" value="<?=$d_price?>" />

						</div>
					</div>
					
					
					<div class="form-group row m-0 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">NSP%  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="nsp_per" id="nsp_per" value="<?=$nsp_per?>" />

						</div>
					</div>
					
					
					<div class="form-group row m-0 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">NSP Price  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="nsp_price" id="nsp_price" value="<?=$nsp_price?>" />

						</div>
					</div>
					
					
					<div class="form-group row m-0 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Direct Dis%  </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="direct_per" id="direct_per" value="<?=$direct_per?>" />

						</div>
					</div>
					
					
					<div class="form-group row m-0 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Int. Sales Price </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="is_price" id="is_price" value="<?=$is_price?>" />

						</div>
					</div>
					</fieldset>
					

					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Min Alert Qty </label>
						<div class="col-sm-9 p-0">

							<input type="text" class="m-0" name="min_stock" id="min_stock" value="<?=$min_stock?>" />

						</div>
					</div>
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label ">Item Type </label>
						<div class="col-sm-9 p-0">

							<select name="item_type" id="item_type" >

								<option value="<?=$item_type?>"><?=$item_type?></option>

								<option value="Serialized">Serialized</option>

								<option value="Non-Serialized">Non-Serialized</option>


							</select>

						</div>
					</div>
					
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Parameter Applicable:</label>
						<div class="col-sm-9 p-0">

							<select name="product_type" id="product_type" required="required">

								<option value="<?=$product_type?>"><?=$product_type?></option>

								<option value="Yes">Yes</option>

								<option value="No">No</option>


							</select>

						</div>
					</div>
					
					
					
					<div class="form-group row m-0 pl-3 pr-3 p-1">
						<label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label req-input">Status </label>
						<div class="col-sm-9 p-0">

							<select name="status" id="status" required="required">

								<option value="<?=$status?>"><?=$status?></option>

								<option value="Active">Active</option>

								<option value="Inactive">Inactive</option>


							</select>

						</div>
					</div>


































					<div class="n-form-btn-class">
						<? if($$unique<1){?>

							<input name="record" type="submit" id="record" value="Save" onclick="return checkUserName()" class="btn1 btn1-bg-submit" />

						<? }?>


						<? if($$unique>0){?>

							<input name="modify" type="submit" id="modify" value="Update" class="btn1 btn1-bg-update" />

						<? }?>

						<input name="clear" type="button" class="btn1 btn1-bg-cancel" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/>


					</div>


				</form>

			</div>

		</div>




	</div>













<?php /*?><table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top">
		<div class="left">

							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								 								  <tr>

								    <td>
										<div class="box">
											<form id="form1" name="form1" method="post" action="">

												<table width="100%" border="0" cellspacing="2" cellpadding="0">
									
									
									<tr>

                                        <td width="40%" align="right">

		    Product Group:                                       </td>

                                        <td width="60%" align="right">

										<select name="item_group" id="item_group" style="width:250px; float:left"  onchange="getData2('item_sub_group_ajax.php', 'item_sub_group', this.value,document.getElementById('item_group').value);">

                                          <option ></option>
										  <? foreign_relation('item_group','group_id','group_name',$_POST['item_group'],'1 order by group_name');?>
                                        </select>
										
										</td>

                                      </tr>
									
									
									

                                      <tr>

                                        <td width="40%" align="right">

		    Sub Group:                                       </td>

                                        <td width="60%" align="right">
										
										<span id="item_sub_group">


										<select name="src_sub_group_id" id="src_sub_group_id" style="width:250px; float:left">

										<option></option>

<?php

$a2="select sub_group_id, sub_group_name from item_sub_group where 1";

//echo $a2;

$a1=db_query($a2);



while($a=mysqli_fetch_row($a1))

{

if($a[0]==$src_sub_group_id)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

else

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

?></select></span></td>

                                      </tr>

                                      <tr>

                                        <td align="right">Product Name:                                      </td>

                                        <td align="right"><input name="src_item_id" style="width:250px; float:left" type="text" id="src_item_id" value="<?php echo $_SESSION['src_item_id']; ?>" size="20" /></td>

                                      </tr>

                                      <tr>

                                        <td align="right"> Product Code:                                         </td>

                                        <td align="right"><input name="fg_code" type="text" id="fg_code" style="width:250px;  float:left" value="<?php echo $_SESSION['fg_code']; ?>" size="20" /></td>

                                      </tr>

                                      <tr>

                                        <td colspan="2"><div align="center">
                                          <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
                                          <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Cancel" />
                                        </div></td>

                                      </tr>

                                    </table>

								    </form>
										</div>
									</td>

						      </tr>

								  <tr>

									<td>&nbsp;</td>

								  </tr>
								<tr>
									<td>

<?

if($_SESSION['item_group']>0||$_SESSION['src_sub_group_id']>0||$_SESSION['src_item_id']!=''||$_SESSION['fg_code']>0){

?>

<table id="item_table" class="table table-bordered" cellspacing="0">
<thead>
<tr>

<th bgcolor="#45777B"><span class="style2">Product Code </span></th>

<th bgcolor="#45777B"><span class="style2">Product Name</span></th>

<th bgcolor="#45777B"><span class="style2">Category </span></th>
<th bgcolor="#45777B"><span class="style2">Status</span></th>
</tr>
</thead>

<tbody>
<?php

 $td="select a.item_id,a.item_name,b.sub_group_name,a.item_description,a.finish_goods_code, a.status FROM item_info a, item_sub_group b where b.sub_group_id=a.sub_group_id ".$con." order by item_id";

$report=db_query($td);

while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">

<td><?=$rp[4];?></td>

<td><?=$rp[1];?></td>

<td><?=$rp[2];?></td>
<td><?=$rp[5];?></td>
</tr>

<?php }?>
</tbody>
</table>

<? }?>

									<div id="pageNavPosition"></div>									</td>
								  </tr>

		</table>



	</div>
	</td>

    <td valign="top">
		<div class="right">
			<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">

							  <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  
							  <tr>
								
								
								

                                  <td width="100%" colspan="2"><div class="box style2" style="width:400px;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

									  


                                      <tr>

                                        <th style="font-size:16px; padding:5px; color:#FFFFFF" bgcolor="#45777B"> <div align="center">
                                          <?=$title?>
                                        </div></th>
                                      </tr></table>

                                  </div></td>
                                </tr>

                                <tr>

                                  <td width="100%" colspan="2"><div class="box" style="width:400px;">

                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
									
									
									

                                      <!--<tr>

                                        <td>Item Code: </td>

                                        <td><input name="item_name2" type="text" id="item_name2" value="<?=$$unique?>" size="30" maxlength="100" class="required" readonly="readonly" /></td>

                                      </tr>-->

									  

									  <tr>

                                     <td><span class="style1" style="padding-top:5px;">*</span>Product Code:</td>

                                        <td><input type="text" name="finish_goods_code" id="finish_goods_code" value="<?=$finish_goods_code?>" required /></td>

                                      </tr>

									  

                                      <tr>

                                        <td>Product Name:</td>

                                        <td>

                                        <input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"  />

										<input name="item_name" type="text" id="item_name" value="<?php echo $item_name;?>" size="30" maxlength="100" required />
										<input name="product_nature" type="hidden" id="product_nature" value="Salable" size="30" maxlength="100" class="required" /></td>

									  </tr>
									  
									  
									  
									  
									  
									  



                                      <tr>

                                        <td> Description:</td>

                                        <td>
										<input name="item_description" type="text" id="item_description" value="<?php echo $item_description;?>" size="30" maxlength="100"  />
										</td>

									  </tr>
									  
									  
									  <!--<tr>

                                        <td> Product Group :</td>

                                        <td><select name="group_id" id="group_id" style="width: float:left"  onchange="getData2('product_group_ajax.php', 'product_sub_group', this.value, 

document.getElementById('group_id').value);" required>

                                          <option ></option>
										  <? foreign_relation('item_group','group_id','group_name',$group_id,'1');?>
                                        </select></td>

									  </tr>-->
									  
									  
									  
									 

                                      

                                      <tr>

                                        <td> Category:</td>

                                        <td>
										
										<span id="product_sub_group">
										<?php



$a2="select sub_group_id, sub_group_name from item_sub_group where 1";

//echo $a2;

$a1=db_query($a2);

echo "<select name=\"sub_group_id\" id=\"sub_group_id\"\" required>";
	echo "<option></option>";
while($a=mysqli_fetch_row($a1))

{



if($a[0]==$sub_group_id)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

else

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

echo "</select>";

?>




										</span>
</td>

                                      </tr>

									  

									  

									  

									  

									  

									  

									  

                                      <!--<tr>

                                        <td>Consumable Type :</td>

                                        <td>

                                        <select name="consumable_type" id="consumable_type">

                                        <option value="<?=$consumable_type?>"><?=$consumable_type?></option>

                                        <option value="Consumable">Consumable</option>

                                        <option value="Non-Consumable">Non-Consumable</option>

                                        <option value="Service">Service</option>

                                        </select></td>

                                      </tr>-->

                                      <!--<tr>

                                        <td>Material Nature :</td>

                                        <td><select name="product_nature" id="product_nature">

                                          <option value="<?=$product_nature?>"><?=$product_nature?></option>

                                          <option value="Salable">Salable</option>

                                          <option value="Purchasable">Purchasable</option>

                                          <option value="Both">Both</option>

                                        </select></td>

                                      </tr>-->

                                      

                                      

                                      

                                      
				

                                      <tr>

                                        <td>Unit Name:</td>

                                        <td><?php



$a2="select unit_name, unit_name from unit_management where 1 order by id";

//echo $a2;

$a1=db_query($a2);

echo "<select name=\"unit_name\" id=\"unit_name\"\">";

echo "<option value=\"\" selected></option>";

while($a=mysqli_fetch_row($a1))

{

if($a[0]==$unit_name)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

echo "</select>";

?></td>

                                      </tr>

									  

									  

									  <tr>

                                        <td>Pack Size:</td>

                                        <td><input type="text" name="pack_size" id="pack_size" value="<?=$pack_size?>" /></td>

                                      </tr>

									  

									  

                                                                     
									  
									  
									  <tr>

                                        <td>Buy Unit:</td>

                                        <td><?php



$a2="select unit_name, unit_name from unit_management";

//echo $a2;

$a1=db_query($a2);

echo "<select name=\"purchase_unit\" id=\"purchase_unit\"\">";

echo "<option value=\"\" selected></option>";

while($a=mysqli_fetch_row($a1))

{

if($a[0]==$purchase_unit)

echo "<option value=\"".$a[0]."\" selected>".$a[1]."</option>";

else

echo "<option value=\"".$a[0]."\">".$a[1]."</option>";

}

echo "</select>";

?></td>

                                      </tr>

                                      <tr>

                                        <td>Buy Unit Size:</td>

                                        <td><input type="text" name="purchase_size" id="purchase_size" value="<?=$purchase_size?>" /></td>

                                      </tr>
									  
									  

                                      <tr>

                                        <td>Cost Price:</td>

                                        <td><input type="text" name="cost_price" id="cost_price" value="<?=$cost_price?>" /></td>

                                      </tr>

                                      <tr>

                                        <td>Sale Price:</td>

                                        <td><input type="text" name="d_price" id="d_price" value="<?=$d_price?>" /></td>

                                      </tr>
									  
									  
									  <tr>

                                        <td>Min Alert Qty:</td>

                                        <td><input type="text" name="min_stock" id="min_stock" value="<?=$min_stock?>" /></td>

                                      </tr>

                                     
									  
									  
									  <tr>

                                        <td>Status:</td>

                                        <td><select name="status" id="status">

                                          <option value="<?=$status?>"><?=$status?></option>

                                          <option value="Active">Active</option>

                                          <option value="Inactive">Inactive</option>


                                        </select></td>

                                      </tr>

                                    

                                      <tr>

                                        <td>&nbsp;</td>

                                        <td>&nbsp;</td>

                                      </tr>

                                      <tr>

                                        <td>&nbsp;</td>

                                        <td>&nbsp;</td>

                                      </tr></table>

                                  </div></td>

                                </tr>

                                

                                <tr>

                                  <td colspan="2">&nbsp;</td>

                                </tr>

                                <tr>

                                  <td colspan="2">

								  <div class="box1">

								    <table width="100%" border="0" cellspacing="0" cellpadding="0">

								      <tr>

								        <td><? if($$unique<1){?>

								          <input name="record" type="submit" id="record" value="Save" onclick="return checkUserName()" class="btn1 btn1-bg-submit" />

								          <? }?></td>

								        <td><? if($$unique>0){?>

								          <input name="modify" type="submit" id="modify" value="Modify" class="btn1 btn1-bg-update" />

								          <? }?></td>

								        <td><input name="clear" type="button" class="btn1 btn1-bg-cancel" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/></td>

								        <td>&nbsp;</td>

							          </tr>

							        </table>

								  </div>								  </td>

                                </tr>

                              </table>

    </form>

		</div>
	</td>

  </tr>

</table><?php */?>
 
<script>
$(document).ready(function(){

    // Load Sub Group when Group is selected
    $('#group_id_cus').change(function(){
        var group_id_cus = $(this).val();
        $.ajax({
            url: 'get_subgroup.php',
            type: 'POST',
            data: {group_id_cus: group_id_cus},
            success: function(data){
                $('#group_id').html(data);
                $('#sub_group_id').html('<option value="">-- Select Sub Sub Group --</option>'); // reset sub-sub
            }
        });
    });

    // Load Sub Sub Group when Sub Group is selected
    $('#group_id').change(function(){
        var group_id = $(this).val();
        $.ajax({
            url: 'get_subsubgroup.php',
            type: 'POST',
            data: {group_id: group_id},
            success: function(data){
                $('#sub_group_id').html(data);
            }
        });
    });

});
</script>


<script type="text/javascript"><!--

    var pager = new Pager('grp', 10000);

    pager.init();

    pager.showPageNav('pager', 'pageNavPosition');

    pager.showPage(1);

//-->

	document.onkeypress=function(e){

	var e=window.event || e

	var keyunicode=e.charCode || e.keyCode

	if (keyunicode==13)

	{

		return false;

	}

}

</script>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>