<?php

 
session_start();


ob_start();



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Unfinished CMR List';

$table = 'production_floor_return_master';


$unique = 'pr_no';


$status = "RECEIVED";


$target_url = '../production_return/production_receive_qc.php';



 if(prevent_multi_submit()){
if(isset($_POST['confirm']))

{
//////ware con//////
$wsql='select * from warehouse where 1 group by warehouse_id';
$wquery=db_query($wsql);
while($wrow=mysqli_fetch_object($wquery)){
$ware_name[$wrow->warehouse_id]=$wrow->warehouse_name;
}


$grn_no=$_POST['grn_no'];
$vendor_id_get=explode("##",$_POST['vendor_id']);
$vendor_id=$vendor_id_get[1];
$vendor_name=$vendor_id_get[0];
$sql = "select d.*,m.warehouse_from,m.warehouse_to from  production_floor_return_detail d,production_floor_return_master m where m.pr_no=d.pr_no and m.pr_no=".$_POST['pr_no']."";

$query = db_query($sql);
while($data=mysqli_fetch_object($query)){
$narration='Floor Return From '.$ware_name[$data->warehouse_from]."(GRN- ".$grn_no.")(".$vendor_name.")";
journal_item_control($data->item_id ,$data->warehouse_from,$data->pr_date,0,$data->total_unit,'Production Return',$data->id,$data->unit_price,$_POST['ware_id'],$data->pr_no,'','','','','',$narration);
journal_item_control($data->item_id ,$_POST['ware_id'],$data->pr_date,$data->total_unit,0,'Production Return',$data->id,$data->unit_price,$data->warehouse_from,$data->pr_no,'','','','','',$narration);

}

$select = "update production_floor_return_master set checked_by=".$_SESSION['user']['id'].",checked_at='".date('Y-m-d H:i:s')."',status='RECEIVED',vendor_id='".$vendor_id."',grn_no='".$grn_no."' where pr_no=".$_POST['pr_no'];
db_query($select);

}
}


if(isset($_POST['return']))

{


$select = "update production_floor_return_master set status='MANUAL' where pr_no=".$_POST['pr_no'];
//$select = "update production_floor_return_master set status='RECEIVED' where pr_no=".$_POST['pr_no'];

db_query($select);




}
/*if($_POST[$unique]>0)


{


$_SESSION[$unique] = $_POST[$unique];


header('location:'.$target_url);


}*/





?>
<div class="form-container_large">


<form action="<?=$target_url?>" method="post" name="codz" id="codz">


<table width="80%" border="0" align="center">


  <tr>


    <td>&nbsp;</td>


    <td>&nbsp;</td>


    <td>&nbsp;</td>
  </tr>


  <tr>


    <td>&nbsp;</td>


    <td>&nbsp;</td>


    <td>&nbsp;</td>
  </tr>


  <tr>


    <td align="right" bgcolor="#FF9966"><strong><?=$title?>: </strong></td>


    <td bgcolor="#FF9966"><strong>


      <select name="old_pr_no" id="old_pr_no">
    <?
        $sql = 'select pr_no from production_floor_return_master where  status="CHECKED" ';
        $rs = db_query($sql);
        while($row=mysqli_fetch_object($rs)){
            echo '<option value="'.$row->pr_no.'">'.$row->pr_no.'</option>';
        }
        ?>
      </select>


    </strong></td>


    <td bgcolor="#FF9966"><strong>
      <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:170px; font-weight:bold; font-size:12px; height:30px; color:#090"/>
    </strong></td>
  </tr>
</table>





</form>


</div>





<?




require_once SERVER_CORE."routing/layout.bottom.php";


?>