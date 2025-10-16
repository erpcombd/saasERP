<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');

$str = $_POST['data'];
$data=explode('##',$str);
$rfq_no = $_SESSION['rfq_no'];
?>

<table class="w-100"   border="1">

			<?
		 $sql2 = 'select * from rfq_evaluation_section_child where rfq_no="'.$rfq_no.'" and section_id="'.$data[0].'"';
		 $qry2 = db_query($sql2);
		 while($doc2=mysqli_fetch_object($qry2)){
		?>
			<tr>
             <td><?=$doc2->child_name?></td>
             <td style="text-align:right;"><?=$doc2->child_percent?>%</td>
             <td style="text-align:center;"><button type="button" name="section" class="btn2 btn1-bg-cancel" onclick="remove_section_child(<?=$data[0]?>,<?=$doc2->id?>)">x</button></td>
           </tr>
			<? } ?>
            </table>