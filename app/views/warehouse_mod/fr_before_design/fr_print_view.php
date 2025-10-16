<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$req_no 		= $_REQUEST['req_no'];
$all            =find_all_field('requisition_fg_master','','req_no='.$req_no);
//("select * from requisition_fg_master where  req_no='$req_no'");
$company_name   =find_a_field('user_group','group_name','id="'.$all->group_for.'"');


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Requsition Copy</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


</head>
<body>

<style>
@media print
{    
.no-print, .no-print *
{
    display: none !important;
}
}
</style>



<div class="container">

<center>
<div class="display-3 mb-5">
    
<h3><?=$company_name;?></h3>
<h4>Requisition</h4>
<h5><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_id);?> to <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$all->warehouse_to);?></h5>

</div>
</center>

<div class="row mt-5">
    <div class="col-6">
        Requisition  No : <?php echo $all->req_no;?><br>
        Date: <?php echo $all->req_date;?>
    </div>
    
    <div class="col-6 text-right">
        Need Before : <?php echo $all->need_by;?><br/>
       
    </div>    
    
</div>



<form action="" method="get">
<div class="row no-print">
    <div class="col-6">
        <input name="button" type="button" onclick="window.print();" value="Print" />
    </div>
    <?php /*?><div class="col-6">
        <? if($all->warehouse_id !=$_SESSION['user']['depot'] && ($all->status=='CHECKED' || $all->status=='PENDING') ){?>    
            <a class="btn btn-primary" href="../depot_transfer/depot_transfer_entry2.php?line_id=<?=$all->warehouse_id?>&req_no=<?=$req_no?>" role="button">Make Transfer</a>
        <? } ?> 
    </div> <?php */?>
</div>
</form>
<br/><br/>



<table class="table table-striped">
       <tr>
        <th width="2%"><strong>SL.</strong></th>
        <th><strong>FG-Code</strong></th>
        <th><strong>Description of the Goods </strong></th>
        <th><strong>Pack Size</strong></th>
        <th><strong>Req Ctn</strong></th>
        <th><strong>Req Pcs</strong></th>
        <th><strong>Total Pcs</strong></th>
        
        <th><strong>Delivered Pcs</strong></th>
        <th><strong>Pending Pcs</strong></th>
        </tr>
<tbody>         
<?php
$final_amt=(int)$data1[0];
$pi=0;
$total=0;

$sql2="select * from requisition_fg_order where  req_no='$req_no'";
$data2=db_query($sql2);
while($info=mysqli_fetch_object($data2)){ 
$pi++;
$amount=$info->qty*$info->rate;
$total=$total+($info->qty*$info->rate);
$sl=$pi;
$item=find_all_field('item_info','concat(item_name," : ",	item_description)','item_id='.$info->item_id);
$qty=($info->qty%$item->pack_size);
$ctn=(int)(@($info->qty/$item->pack_size));
$qoh=$info->qoh;
$last_p_date=$info->last_p_date;
$last_p_qty=$info->last_p_qty;
?>
 
    <tr>
        <td valign="top"><?=$sl?></td>
        <td align="left" valign="top"><?=$item->finish_goods_code?>&nbsp;</td>
        <td align="left" valign="top"><?=$item->item_name?><br><strong><?=$info->item_note?></strong></td>
        <td valign="top"><?=$item->pack_size;?></td>
        
        <td valign="top"><?=$ctn; $gctn+=$ctn;?></td>
        
        <td valign="top"><?=$qty; $gqty+=$qty;?></td>
        <td valign="top"><?=$info->qty; $gtpcs+=$info->qty;?></td>
        <td><?=$done_item=find_a_field('fg_issue_detail','sum(total_unit)','req_no="'.$req_no.'" and item_id="'.$info->item_id.'"'); $gditem+=$done_item;?></td>
        <td><?=$pending_qty=($info->qty-$done_item); $gpqty+=$pending_qty;?></td>
    </tr>
<? 
$done_item=$pending_qty='';
}?>
</tbody>     
    <tr style="font-weight:700;">
        <td colspan="3">Total</td>
        <td></td>
        <td><?=$gctn?></td>
        <td><?=$gqty?></td>
        <td><?=$gtpcs?></td>
        <td><?=$gditem?></td>
        <td><?=$gpqty?></td>
    </tr>
</table>

 
<div class="row">
	<div class="col">Note : <?php echo $all->req_note;?></div>
</div>  
 

<br><br><br>


<div class="row mt-5 font-weight-bold">
    <div class="col-4"><?=find_a_field('user_activity_management','fname','user_id="'.$all->entry_by.'"');?></div>
    <div class="col-4 text-center"></div> 
    <div class="col-4 text-right"><?=find_a_field('user_activity_management','fname','user_id="'.$all->checked_by.'"');?></div>     
</div>
<div class="row font-weight-bold">
    <div class="col-4">Prepared By</div>
    <div class="col-4 text-center">Checked By</div> 
    <div class="col-4 text-right">Approved By</div>     
</div>
  
 
  
  
</div>  
  
  
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
