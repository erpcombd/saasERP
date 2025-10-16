<?php

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

session_start();

ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";




$title='Unfinished CMR List';

$table = 'production_floor_return_master';


$unique = 'pr_no';


$status = "RECEIVED";


$target_url = '../production_return/production_receive.php';



 if(prevent_multi_submit()){
if(isset($_POST['confirm']))

{


$select = "update production_floor_return_master set received_by=".$_SESSION['user']['id'].",received_at='".date('Y-m-d H:i:s')."',status='COMPLETE' where pr_no=".$_POST['pr_no'];

db_query($select);
//$select = "update production_floor_return_master set status='RECEIVED' where pr_no=".$_POST['pr_no'];


//$sql = "select * from production_floor_return_detail where pr_no=".$_POST['pr_no'];


$csql='select * from general_sub_ledger  where 1 group by sub_ledger_id ';
$cquery=db_query($csql);
while($crow=mysqli_fetch_object($cquery)){

  $pl_main_ledger[$crow->sub_ledger_id]=$crow->ledger_id;

}

$sql ='SELECT r.id,rr.pr_no,r.item_id ,rr.warehouse_from,rr.warehouse_to,i.item_name,s.group_id,s.sub_group_name,s.item_ledger,i.sub_ledger_id,s.status,r.unit_price,r.total_unit,rr.pr_date FROM production_floor_return_detail r,production_floor_return_master rr,item_info i,item_sub_group s  WHERE r.pr_no="'.$_POST['pr_no'].'" and  rr.pr_no=r.pr_no and i.item_id=r.item_id and i.sub_group_id=s.sub_group_id';

$result = db_query($sql);


$jv=next_journal_sec_voucher_id('','Production Return',$_SESSION['user']['depot']);


While($data=mysqli_fetch_object($result)){


$wip_ledger = find_a_field('warehouse','ledger_id','warehouse_id="'.$data->warehouse_from.'"');

$found =find_a_field('journal_item','count(tr_no)','tr_from="Production Return" and tr_no='.$data->id);


if($found==0){

$final_price=find_a_field('journal_item','final_price',' 1 and final_price>0 and item_id="'.$data->item_id.'" order by id desc');
$final_amt = $final_price * $data->total_unit;
//$pr_date = strtotime($data->pr_date);



add_to_sec_journal('CloudMVC', $jv, $data->pr_date,$data->item_ledger,'Production Return',$final_amt,'0','Production Return',$data->pr_no,$data->sub_ledger_id,'',$cc_code,$_SESSION['user']['group'],$_SESSION['user']['id'],'');
add_to_sec_journal('CloudMVC', $jv, $data->pr_date,$pl_main_ledger[$wip_ledger],'Production Return','0',$final_amt,'Production Return',$data->pr_no,$wip_ledger,'',$cc_code,$_SESSION['user']['group'],$_SESSION['user']['id'],'');



journal_item_control($data->item_id,$data->warehouse_from,$data->pr_date,0,$data->total_unit,'Production Return',$data->id,$data->unit_price,'',$data->pr_no);
journal_item_control($data->item_id,$data->warehouse_to,$data->pr_date,$data->total_unit,0,'Production Return',$data->id,$data->unit_price,'',$data->pr_no);

}

}

sec_journal_journal($jv,$jv,'Production Return');




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