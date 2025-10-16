<?php


//


require "../../support/inc.all.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


$group_id=$data[0];




?>


 					<select multiple name="item_sub_group_in[]" id="item_sub_group_in[]" style="height:150px;"  size='5'>)
                      <?
					  $sql = 'select * from item_sub_group where  group_id="'.$group_id.'" and fg_sub_group="Yes" order by sub_group_sl ';
					  $query = db_query($sql);
					  while($info = mysqli_fetch_object($query)){
					  ?><option value="<?=$info->sub_group_id?>" <?=(@in_array($info->sub_group_id, $_POST['sub_group_id']))?'Selected':'';?>><?=$info->sub_group_name?></option>
					  <?
					  }
					  ?>
                    </select>

