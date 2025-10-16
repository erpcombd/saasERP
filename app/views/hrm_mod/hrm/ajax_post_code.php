<?php
session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
//require "../../config/inc.all.php";
@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'Off');
 $str = $_POST['data'];
 $data=explode('##',$str);
 $post_code = find_a_field('uploadpost', 'code', 'post like "'.$data[0].'"');

?>



<input name="post_code" type="text" id="post_code" class="form-control" value="<?=$post_code?>"/>
