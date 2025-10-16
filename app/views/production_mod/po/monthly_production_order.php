<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Select Finished Goods';

$table='production_line_fg';
$unique='id';
$target_url = '../production_line/production_formula.php';
?>
<script language="javascript">
function custom(theUrl)
{
	window.open('<?=$target_url?>?item_id='+theUrl);
}
</script>
<script>

function getXMLHTTP() { //fuction to return the xml http object

		var xmlhttp=false;	

		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}

			}

		}

		 	

		return xmlhttp;

    }

	function update_value(id)

	{

var item_id=id; // Rent
var year=(document.getElementById('year').value)*1;
var mon=(document.getElementById('mon').value)*1;
var qty=(document.getElementById('qty_'+id).value)*1;
var flag=(document.getElementById('flag_'+id).value)*1;
var strURL="monthly_production_order_ajax.php?item_id="+item_id+"&order_qty="+qty+"&mon="+mon+"&year="+year+"&flag="+flag;

		var req = getXMLHTTP();

		if (req) {

			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {						
						document.getElementById('divi_'+id).style.display='inline';
						document.getElementById('divi_'+id).innerHTML=req.responseText;						
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}
			req.open("GET", strURL, true);
			req.send(null);
		}	

}

</script>






<div class="form-container_large">
	<form action="" method="post">

			<div class="d-flex justify-content-center pb-3">
				<div class="n-form1 fo-short pt-0">
					<div class="container">
						<div class="form-group row  m-0 mt-1 pt-2 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Production Year  </label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
									<select name="year" id="year" required>
										<option>2015</option>
										<option>2016</option>
									</select>
							</div>
						</div>

						<div class="form-group row  m-0 mt-1 pt-2 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Production Month  </label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
								<select name="mon" id="mon" required>
									<option value="<?=$_REQUEST['mon']?>" selected="selected"><?=($_REQUEST['mon']!='')?date('F',mktime(12,30,30,$_REQUEST['mon'],1,2015)):'';?></option>
									<option value="1">January</option>
									<option value="2">February</option>
									<option value="3">March</option>
									<option value="4">April</option>
									<option value="5">May</option>
									<option value="6">June</option>
									<option value="7">July</option>
									<option value="8">August</option>
									<option value="9">September</option>
									<option value="10">October</option>
									<option value="11">November</option>
									<option value="12">December</option>
								</select>
							</div>
						</div>

						<div class="form-group row  m-0 mt-1 pt-2 mb-1 pl-3 pr-3">
							<label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Product Group  </label>
							<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
								<select name="product_group" id="product_group">
									<option value="<?=$_REQUEST['product_group']?>" selected="selected"><?=$_REQUEST['product_group']?></option>
									<option value="A">A</option>
									<option value="B">B</option>
									<option value="C">C</option>
								</select>
							</div>
						</div>

						<div class="n-form-btn-class">
							<input type="submit" name="Submit" value="Submit" class="btn1 btn1-bg-submit"/>
						</div>


					</div>
				</div>
			</div>



		<table class="table1  table-striped table-bordered table-hover table-sm">
			<thead class="thead1">
			<tr class="bgc-info">
				<th>SL</th>
				<th>Fg Code</th><th>Item Name</th><th>Production Line</th>
				<th>Group</th>
				<th>Brand</th>
				<th>Order(CTN)</th>
				<th></th>
			</tr>

			</thead>

			<tbody class="tbody1">
			<? $sl=0;
			//$con = ' and i.sales_item_type like "%'.$_REQUEST['product_group'].'%"';
			echo $res='select  i.item_id, i.item_id, i.finish_goods_code as fg_code,i.item_name, w.warehouse_name,i.item_brand,
(select unit_batch_size from
production_ingredient_detail where item_id=i.item_id limit 1) as batch_size, i.pack_size from item_info i, production_line_fg f, warehouse w
where i.item_id=f.fg_item_id and w.warehouse_id=f.line_id   order by i.finish_goods_code,i.item_id';
			$sql = db_query($res);
			while($data=mysqli_fetch_object($sql)){
				$order_qty = find_a_field('production_plan_order','order_qty','year="'.$_REQUEST['year'].'" and mon="'.$_REQUEST['mon'].'" and item_id = "'.$data->item_id.'"');
				$sl++;
				?>
				<tr>
					<td><?=$sl;?></td>
					<td><?=$data->fg_code?>
						<input name="pkt_sz_<?=$data->item_id?>" id="pkt_sz_<?=$data->item_id?>" type="hidden" size="10" maxlength="10" value="<?=$data->pack_size;?>"/></td>
					<td><?=$data->item_name?></td>
					<td><?=$data->warehouse_name?></td>
					<td><?=$data->product_group?></td>
					<td><?=$data->item_brand?></td>
					<td><div align="center">
							<input type="text" name="qty_<?=$data->item_id?>"  id="qty_<?=$data->item_id?>" value="<?=$order_qty;?>" />
						</div></td>
					<td><span id="divi_<?=$data->item_id?>">
<?
if(($order_qty>0))
{?>
	<input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="1" />
	<input type="button" name="Button" value="Edit"  onclick="update_value(<?=$data->item_id?>)" /><?
}
else
{
	?>
	<input name="flag_<?=$data->item_id?>" type="hidden" id="flag_<?=$data->item_id?>" value="0" />
	<input type="button" name="Button" value="Save"  onclick="update_value(<?=$data->item_id?>)" />
<? }?>
          </span></td>
				</tr>
			<? }?>

			</tbody>

		</table>


	</form>
</div>









<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>