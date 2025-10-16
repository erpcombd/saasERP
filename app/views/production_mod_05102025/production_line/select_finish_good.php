<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


do_datatable('grp');

$title='FG Ingrediants Formula';
if($_GET['line_id_get']){
$_POST['warehouse_id']=$_GET['line_id_get'];
}
$table='production_line_fg';

$unique='id';

$target_url = "../production_line/production_formula.php?line_id=".$_POST['warehouse_id']."&";

?>

<script language="javascript">

function custom(theUrl)

{

	window.open('<?=$target_url?>item_id='+theUrl);

}

</script>

<div class="form-container_large">








<form action="" method="post" name="codz" id="codz">





<table width="80%" border="0" align="center">





  <tr>





    <td>&nbsp;</td>





    <td colspan="4">&nbsp;</td>





    <td>&nbsp;</td>





  </tr>





  





  <tr>





    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>





    <td colspan="3" bgcolor="#FF9966"><strong>





<select name="warehouse_id" id="warehouse_id" class="form-control" style="background:#FFFFFF; width:300px">


<option value="<?=$_POST['warehouse_id']?>" ><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$_POST['warehouse_id'])?></option>


<? foreign_relation('warehouse','warehouse_id','warehouse_name',$warehouse_id,'1 and use_type="PL"');?>





</select>





    </strong></td>


<td  bgcolor="#FF9966"><strong>





      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" class="btn btn-primary"/>





    </strong></td>


    </tr>





</table>











</form>
</div>











<table width="100%" border="0" cellspacing="0" cellpadding="0">

<tr>

<td>



<div class="tabledesign2">

<? 

//if($_POST['warehouse_id']!=''){ $warehouse_con = ' and w.warehouse_id="'.$_POST['warehouse_id'].'" ';
//$res='select  i.item_id, i.item_id, i.finish_goods_code as fg_code,i.item_name, w.warehouse_name, (select unit_batch_size from production_ingredient_detail where item_id=i.item_id limit 1) as batch_size, (select count(1) from production_ingredient_detail where item_id=i.item_id) as Item

//from item_info i,production_line_fg f, warehouse w

//where i.item_id=f.fg_item_id '.$warehouse_con.' and w.warehouse_id=f.line_id order by w.warehouse_name';



//echo link_report($res,'other_issue_report.php');
//}


?>



<tr>
<td>
<div class="tabledesign2">
	<table id="grp" cellspacing="0" cellpadding="0" width="100%">
			<thead>
				<tr>
					<th>Item Id</th>
					<th>Item Code</th>
					<th>Item Name</th>
					<th>Warehouse Name</th>
					<th>Batch Size</th>
					<th>Item</th>
					<th>Receipe Category</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			if($_POST['warehouse_id']!=''){ $warehouse_con = ' and w.warehouse_id="'.$_POST['warehouse_id'].'" ';
			 $res='select  i.item_id, i.item_id, i.finish_goods_code as fg_code,i.item_name, w.warehouse_name, (select unit_batch_size from production_ingredient_detail where item_id=i.item_id limit 1) as batch_size, (select count(1) from production_ingredient_detail where item_id=i.item_id) as Item from item_info i,production_line_fg f, warehouse w where i.item_id=f.fg_item_id '.$warehouse_con.' and w.warehouse_id=f.line_id order by w.warehouse_name';
			}
			$query=db_query($res);
			while($row=mysqli_fetch_object($query)){
			?>
				<tr>
					<td><?=$row->item_id?></td>
					<td><?=$row->fg_code?></td>
					<td><?=$row->item_name?></td>
					<td><?=$row->warehouse_name?></td>
					<td><?=$row->batch_size?></td>
					<td><?=$row->Item?></td>
					<td>
					<table >
					<thead></thead>
					<tbody>
					<?php 
					$sqll='select * from production_ingredient_detail where item_id="'.$row->item_id.'" and line_id="'.$_POST['warehouse_id'].'" group by receipe_no';
					$query2=db_query($sqll);
					while($data2=mysqli_fetch_object($query2)){
					?>
						<tr>
							<td style="border:none;">
							<a href="../production_line/production_formula.php?line_id=<?php echo $_POST['warehouse_id'];?>&item_id=<?php echo $row->item_id;?>&receipe_no=<?=$data2->receipe_no?>" ><button type="submit" class="btn btn-primary" style="padding:6px;margin:0px 0px;">Recipe-<?=$data2->receipe_no?> (<?=$data2->receipe_name?>)</button></a>
							</td>
						</tr>
						<?php } ?>
						<tr>
						<td style="border:none;">
						<a href="../production_line/production_formula.php?line_id=<?php echo $_POST['warehouse_id'];?>&item_id=<?php echo $row->item_id;?>&receipe_no=0"  ><button type="submit" class="btn btn-success"  style="padding:6px;margin:0px 0px;" >+ Add New</button></a>
						</td>
						</tr>
						</tbody>
					</table>
					</td>
				</tr>
				<?php } ?>
			</tbody>
	</table>
	

	
	
</div>
</td>
</tr>












</td>

</tr>

</table>




</div>





<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>