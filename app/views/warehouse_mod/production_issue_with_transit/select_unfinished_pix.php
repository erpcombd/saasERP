<?php


session_start();


ob_start();



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


$title='Unfinished CMI List';





$table = 'production_issue_master';


$unique = 'pi_no';


$status = 'MANUAL';


$target_url = '../production_issue/production_issue.php';

/*if($_REQUEST['old_pi_no']>0)


{

header('location:'.$target_url);


}*/





?><div class="form-container_large">
<script>
	function get(id){
		document.getElementById('req').value=id;
	}
</script>

<form action="<?=$target_url?>?req=<?=$_POST['req']?>" method="post" >

<input type="hidden" id="req" name="req" value=""/>
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
	<? // echo $_SESSION['user']['depot']; ?>
      <select name="pi_no" id="pi_no" onChange="get(this.value)" onFocus="get(this.value)" autofocus >
        <? foreign_relation($table,$unique,$unique,'','warehouse_from='.$_SESSION['user']['depot'].' and status="'.$status.'"');?>
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


$main_content=ob_get_contents();


ob_end_clean();


require_once SERVER_CORE."routing/layout.bottom.php";


?>