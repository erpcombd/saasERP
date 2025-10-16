<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);

		?>
     <select class="section_name" name="evaluation_section" id="evaluation_section"><option></option><? foreign_relation('rfq_evaluation_section','id','section_name',$evaluation_section,'rfq_no="'.$_SESSION['rfq_no'].'"')?></select>
			