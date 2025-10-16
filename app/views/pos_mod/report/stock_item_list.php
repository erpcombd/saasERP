<?php
session_start();
require_once "../../../assets/support/inc.all.php";
$pr_no = $_GET['pr_no'];

$company_name=find_a_field('project_info','proj_name','1'); 
$item_id=$_GET['item_id'];

?>
<!DOCTYPE html> <html lang="en"> 
<head>
<title>Warehouse Present Stock</title> 
<meta charset="utf-8"> <meta name="viewport" content="width=device-width, initial-scale=1"> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> 
<script src="https://ajax.googleapis.com/ajaxlibs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> 
<script src="https://maxcdn. bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script> function pr(){ 
document.getElementById('pr').style.display='none'; 
document.getElementById('bar').style.display='none';
window.print();
}
</script></head>  
<body>
<div class="container"> 
<h4 class="text-center"><?php echo $company_name; ?></h4> <h6 class="text-center">Warehouse Present Stock</h6> <div class="row"> 
<button onClick="pr()" id="pr" style="margin-left: 15px;">Print</button>
</div> 

<div class="row" style="margin: 0 auto;"> 

<table class="table table-bordered table-sm"> <thead>
<tr> 
<th>SL</th>
<th>Box No</th>
<th>Item SL No</th>
<th>Item Barcode</th>
<th>Item Name</th> 
<th>Item Price</th>
<th>Item Quantity</th>
</tr> </thead>
<tbody> <?php
$sql='select i.item_id,i.item_name, box_no, LPAD(item_sl_no, 4,"0") as item_sl_no, sum(item_in-item_ex) qty, volt_code, concat(volt_code,"-",box_no,"-",LPAD(item_sl_no, 4,"0")) barcode
from journal_item j, item_info i where i.item_id=j.item_id and i.item_id="'.$item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" group by i.item_id, box_no, item_sl_no
having sum(item_in-item_ex)>0';


$query=mysql_query($sql); 
while($data=mysql_fetch_object($query)){ 
$fg_v_code=find_a_field('item_info', 'volt_code', 'item_id='.$data->item_id); 
$transit_item = find_a_field('journal_item','1','item_id="'.$item_id.'" and warehouse_id="'.$_SESSION['user']['depot'].'" and tr_from="TRANSIT" and item_in>0 and box_no="'.$data->box_no.'" and item_sl_no="'.$data->item_sl_no.'"');
$item_barcode=$fg_v_code."-".$data->box_no."-".$data->item_sl_no;
if($transit_item==0){
?>

<tr> 
<td><?=++$i?></td>
<td><?=$fg_v_code."-".$data->box_no ?></td> 
<td><?=$fg_v_code."-".$data->box_no."-".$data->item_sl_no;?></td>
<td><img alt="testing" style="width: 105px; margin-top: 2px;" src="../barcode/barcode.php?codetype=Code39&amp;size=40&amp; text=<?=$item_barcode?>&amp;print=true"></td> 
<td><?=find_a_field('item_info','item_name', 'item_id='.$data->item_id);?></td> 
<td><?=$item_price =find_a_field('item_info','d_price','item_id='.$item_id);?></td>
<td><?=$data->qty?></td> </tr> 

<?php 

$total_qty+=$data->qty;
 } }
 ?> 

<tr>
<td colspan="6"><strong>Total</strong></td>
<td style="font-weight:bold;"> <?=$total_qty?></td> </tr> </tbody> </table></div>
</div>
</body> </html>