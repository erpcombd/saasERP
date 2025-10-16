<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);

$user_id = $data[0];
$input_data = $data[1];

		$sql2 = 'select r.*,u.fname from rfq_master r, user_activity_management u, rfq_evaluation_team t where t.rfq_no=r.rfq_no 
		and r.rfx_stage ="Template" and u.user_id=r.entry_by and (r.rfq_no like "%'.$input_data.'%" or event_name like "%'.$input_data.'%") and r.del !=1 group by t.rfq_no,r.rfq_no order by r.rfq_no desc';
		$qry2 = db_query($sql2);
		while($rfq_copy=mysqli_fetch_object($qry2)){
		?>
			<a href="event_template_copy.php?rfq_no=<?=url_encode($rfq_copy->rfq_no)?>"><li class="even-li fs-14">#<?=$rfq_copy->rfq_no?> - <?=$rfq_copy->event_name?></li></a>
			<? } ?>