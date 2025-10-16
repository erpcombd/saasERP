<?php



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$op_date ='2025-05-30';

//$f_sql ='SELECT 
//    j.item_id, 
//    MAX(j.final_price) AS latest_final_price
//FROM 
//    journal_item j
//JOIN 
//    (SELECT item_id, MAX(id) AS max_id
//        FROM journal_item where  ji_date <="2024-01-24"  and group_for=2
//        GROUP BY item_id
//    ) AS latest_ids
//ON 
//    j.item_id = latest_ids.item_id
//AND 
//    j.id = latest_ids.max_id 
//GROUP BY 
//    j.item_id
//ORDER BY 
//    j.id DESC';


//$f_query = db_query($f_sql);
//while($f_data=mysql_fetch_object($f_query)){
//	$final_price[$f_data->item_id] =number_format($f_data->latest_final_price,2,'.','');
//}

/*
$sql="select * journal_item_opening where group_for=3 ";
$f_query = db_query($sql);
while($f_data=mysqli_fetch_object($f_query)){
	$final_price[$f_data->item_id] =$f_data->item_price;
}*/


function journal_item_control_rony2($item_id,$warehouse_id,$ji_date,$item_in,$item_ex,$tr_from,$tr_no,$rate='',$r_warehouse='',$sr_no='',$c_price='',$id='')
{


	$pre_stock=find_all_field('journal_item_back_up','final_stock','item_id = "'.$item_id .'"  order by id desc');
	
	$pre_stock_final_stock = find_a_field('journal_item_back_up','sum(item_in-item_ex)','item_id = "'.$item_id.'"');

if($pre_stock_final_stock<0){
	$pre_stock_final_stock =0;
}

//$pre_stock->final_price = number_format(find_a_field('journal_item','sum((item_in-item_ex)*item_price)/sum(item_in-item_ex)','item_id = "'.$item_id.'" and ji_date <= "'.$ji_date.'" order by id desc'),4,'.','');



/*if($pre_stock->final_price<0){
	$pre_stock->final_price =0;
}
	*/
		
	$final_stock=($pre_stock_final_stock+$item_in)-$item_ex;
	
	
	if($final_stock<0){
	
		$final_stock=0;
	
	}else{
	
		$final_stock=$final_stock;
	}
	
	

if($item_in>0){
	
	if($tr_from =='Purchase' || $tr_from =='Production Receive'  || $tr_from =='Conversion Receive' || $tr_from =='InterPurchase' || $tr_from == 'Sales Return' || $tr_from=='Reprocess Receive' || $tr_from=='Reverse Receive' || $tr_from=='LC Purchase'  ||  $tr_from=='Opening'   || $tr_from=='Rate Adjust' || $tr_from=='Other Receive' ||$tr_from=='Purchase Return' ){
	    
	    
	    $item_price=$rate;
		$final_price = ((($pre_stock->final_price*$pre_stock_final_stock)+($item_price*$item_in))/($pre_stock_final_stock+$item_in));
		$c_price=$pre_stock->final_price;
		
		}elseif($tr_from == 'Transfered'){
		    
		   $item_price = find_a_field('journal_item_back_up','item_price','item_id = "'.$item_id .'"  and tr_no='.$tr_no.'  and sr_no='.$sr_no.' and item_ex>0');
		   
		    //if($item_price>0){ $item_price=$item_price; }else{$item_price=$rate;}
		    
		    
		   $final_price = ((($pre_stock->final_price*$pre_stock_final_stock)+($item_price*$item_in))/($pre_stock_final_stock+$item_in));
    		$c_price=$pre_stock->final_price; 
		    
		}
		else{
		 $item_price=find_a_field('journal_item_back_up','final_price','item_id = "'.$item_id .'"  and final_price>0  order by id desc');
		 
		    if($item_price>0){ $item_price=$item_price; }else{$item_price=$rate;}
		    $final_price = $item_price;
		    $c_price=$pre_stock->final_price;
		}
	
}


else{
       if($tr_from=='Purchase Return'){
		$item_price =$rate;
	}else{	 $item_price=find_a_field('journal_item_back_up','final_price','item_id = "'.$item_id .'" and final_price > 0  order by id desc'); }
        
		if ($final_stock > 0) {
    $final_price = (
        (($pre_stock->final_price * $pre_stock_final_stock) 
        + ($item_price * ($item_in - $item_ex))) 
        / $final_stock
    );
} else {
    $final_price = 0; // or handle it as you need
}
		
		if($final_price>0){$final_price=$final_price;}else{$final_price = $pre_stock->final_price;}
		
		$c_price=$pre_stock->final_price;
}
	
	
     $sql="INSERT INTO `journal_item_back_up` 
	(`ji_date`, `item_id`, `warehouse_id`, `pre_stock`, `pre_price`, `item_in`, `item_ex`, `item_price`, `final_stock`, `final_price`,`tr_from`, `tr_no`, `entry_by`, `entry_at`,
	relevant_warehouse,sr_no,c_price,lot_no) 
	VALUES 
	('".$ji_date."', '".$item_id."', '".$warehouse_id."', '".$pre_stock_final_stock."', '".$pre_stock->final_price."', '".$item_in."', '".$item_ex."', '".$item_price."', 
	'".$final_stock."', '".$final_price."', '".$tr_from."', '".$tr_no."', '".$entry_by."'
	, '".$entry_at."', '".$r_warehouse."', '".$sr_no."',
	'".$c_price."','".$id."')";
	
	db_query($sql);
	
}


//function journal_item_control_rony2_spare($item_id,$warehouse_id,$ji_date,$item_in,$item_ex,$tr_from,$tr_no,$rate='',$r_warehouse='',$sr_no='',$c_price='',$id='',$group_for)
//{
//
//
//	$pre_stock=find_all_field('journal_item_back_up','final_stock','item_id = "'.$item_id .'" and group_for="'.$group_for.'" and ji_date < "'.$ji_date.'"   order by id desc');
//	
//	if($pre_stock->final_stock>0){
//        
//        $pre_stock_final_stock =$pre_stock->final_stock;
//        
//    }else{
//        $pre_stock_final_stock = find_a_field('journal_item','sum(item_in-item_ex)','ji_date < "'.$ji_date.'" and group_for="'.$group_for.'" and item_id = "'.$item_id .'"'); 
//    }
//		
//	$final_stock=($pre_stock_final_stock+$item_in)-$item_ex;
//	
//	
//	if($final_stock<0){
//	
//		$final_stock=0;
//	
//	}else{
//	
//		$final_stock=$final_stock;
//	}
//	
//	
//	if($item_in>0){
//	
//	if($tr_from =='Purchase'){
//		$item_price = $rate;
//		$final_price = ((($pre_stock->final_price*$pre_stock_final_stock)+($item_price*$item_in))/($pre_stock_final_stock+$item_in));
//		$c_price=$pre_stock->final_price;
//		}elseif($tr_from=='Opening' || $tr_from=='Opening Adjustment'){
//		    
//		   $item_price = $rate;
//		   $final_price = $rate;
//		}
//		else{
//		 $item_price=find_a_field('journal_item_back_up','final_price','item_id = "'.$item_id.'" and  group_for="'.$group_for.'" and final_price>0  order by id desc');
//		    if($item_price>0){ $item_price=$item_price; }else{$item_price=$rate;}
//		    $final_price =$item_price;
//		    $c_price=$pre_stock->final_price;
//		}
//	
//}
//else{
//        $item_price=find_a_field('journal_item_back_up','final_price','item_id = "'.$item_id .'" and  group_for="'.$group_for.'" and final_price > 0  order by id desc');
//        
//		$final_price =((($pre_stock->final_price*$pre_stock_final_stock)+($item_price*($item_in-$item_ex)))/($final_stock));
//		
//		if($final_price>0){$final_price=$final_price;}else{$final_price = $pre_stock->final_price;}
//		
//		$c_price=$pre_stock->final_price;
//}
//	
//	
//	
//	
//	
//     $sql="INSERT INTO `journal_item_back_up` 
//	(`ji_date`, `item_id`, `warehouse_id`, `pre_stock`, `pre_price`, `item_in`, `item_ex`, `item_price`, `final_stock`, `final_price`,`tr_from`, `tr_no`, `entry_by`, `entry_at`,
//	relevant_warehouse,sr_no,c_price,lot_no) 
//	VALUES 
//	('".$ji_date."', '".$item_id."', '".$warehouse_id."', '".$pre_stock_final_stock."', '".$pre_stock->final_price."', '".$item_in."', '".$item_ex."', '".$item_price."', 
//	'".$final_stock."', '".$final_price."', '".$tr_from."', '".$tr_no."', '".$entry_by."'
//	, '".$entry_at."', '".$r_warehouse."', '".$sr_no."',
//	'".$c_price."','".$id."')";
//	
//	
//	db_query($sql);
//}



//$item_sql="select i.item_id from item_info i,item_sub_group s,item_group g,journal_item j where i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_id=400000000 and i.item_id=j.item_id and ji_date>='2023-11-15' group by j.item_id";


//$item_sql = "select i.item_id from item_info i,item_sub_group s,item_group g  where i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and i.group_for=3 and g.group_id=200000000";
//and g.group_id!=400000000 and i.group_for=3 and i.flag=0
$item_sql  = "select item_id 
from item_info i,item_sub_group s,item_group g 
where i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and i.flag=0 ";

$item_query=db_query($item_sql);

while($item_data=mysqli_fetch_row($item_query)){

if($final_price[$item_data[0]]>0){
	$rate = $final_price[$item_data[0]];
}else{

$rate = find_a_field('journal_item','item_price','item_id='.$item_data[0].' and tr_from in ("Opening","Production Receive","Purchase","LC Purchase","Rate Adjust","InterPurchase")  order by id asc');


}
//$rate = find_a_field('journal_item','item_price','item_id='.$item_data[0].' and tr_from in ("Opening") order by id asc');


$final = "select sum(item_in-item_ex) as stock ,warehouse_id,item_id,group_for from
 journal_item where item_id=".$item_data[0]." and ji_date < '".$op_date."'  group by item_id";


$final_query=db_query($final);

if (mysqli_num_rows($final_query) > 0) {

while($final_data =mysqli_fetch_object($final_query)){

	
	/*    $ins_sql="INSERT INTO `journal_item_back_up` 
	(`ji_date`, `item_id`, `warehouse_id`, `pre_stock`, `pre_price`, `item_in`, `item_ex`, `item_price`, `final_stock`, `final_price`,`tr_from`, `tr_no`,`group_for`, `entry_by`, `entry_at`,
	relevant_warehouse,sr_no,c_price) 
	VALUES 
	('".$op_date."', '".$final_data->item_id."', '".$final_data->warehouse_id."', '0', '','".$final_data->stock."', '0', '".$rate."', '".$final_data->stock."', '".$rate."', 'Opening', '','".$final_data->group_for."', '', '".$final_data->entry_at."', '', '','')";
	db_query($ins_sql);*/

}
}else{
	
	/* $ins_sql="INSERT INTO `journal_item_back_up` 
	(`ji_date`, `item_id`, `warehouse_id`, `pre_stock`, `pre_price`, `item_in`, `item_ex`, `item_price`, `final_stock`, `final_price`,`tr_from`, `tr_no`,`group_for`, `entry_by`, `entry_at`,
	relevant_warehouse,sr_no,c_price) 
	VALUES 
	('".$op_date."', '".$item_data[0]."', '".$final_data->warehouse_id."', '".$final_data->stock."', '".$rate."','0', '0', '".$rate."', '".$final_data->stock."', '".$rate."', 'Opening', '','".$final_data->group_for."', '', '".$final_data->entry_at."', '', '','')";
	db_query($ins_sql);*/

}


$sql="select * from journal_item where item_id=".$item_data[0]." and ji_date >='".$op_date."'  order by id";
$query =db_query($sql);
while($data=mysqli_fetch_object($query)){
//journal_item_control_rony2($data->item_id,$data->warehouse_id,$data->ji_date,$data->item_in,$data->item_ex,$data->tr_from,$data->tr_no,$data->item_price,'',$data->sr_no,'',$data->id);

}

//$update = "update item_info set flag=1 where item_id=".$item_data[0]."";
//db_query($update);

 //$sql_update = "update journal_item j,journal_item_back_up jb set j.pre_stock=jb.pre_stock,j.pre_price=jb.pre_price,j.c_price=jb.c_price,j.item_price=jb.item_price,j.final_stock=jb.final_stock,j.final_price=jb.final_price where  jb.item_id=".$item_data[0]." and j.id=jb.lot_no";

//db_query($sql_update);
	
echo $item_data[0].'-ok.<br>';

}	

?>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>