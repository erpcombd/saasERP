<?


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='New Task Assign';

if(isset($_POST['my_comment']) && $_POST['my_comment']!=''){

 $new_sql='select * from task_assign_master where status="Processing" order by task_no desc';
$new_q = db_query($new_sql);
while($new_data = mysqli_fetch_object($new_q)){
$task_id = $new_data->task_no;
$comment = $_POST['task_comment_'.$new_data->task_no];
if($comment!=''){
 $insert = 'insert into task_comments(task_no,comment_date,task_comment,entry_by,entry_at) value("'.$task_id.'","'.date('Y-m-d').'","'.$comment.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d H:i:s').'")';
 db_query($insert);
 }
 
 }

}
?><head>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>





<table width="100%" border="1" cellspacing="2" cellpadding="2">

<tr border="1" >

<td bordercolor="#0000CC"><div class="tabledesign2">
<div id="accordion">
<? 

if($_POST['status']!=''&&$_POST['status']!='ALL')

$con .= 'and a.status="'.$_POST['status'].'"';



if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



$new_sql='select count(t.task_no) as pending_list ,p.PBI_NAME,t.assign_person,proj.project_name 
 from task_assign_master t, personnel_basic_info p, task_project proj 
 where t.assign_person=p.PBI_ID and proj.project_id=t.project and t.status="Processing" group by p.PBI_ID order by task_no desc';

$new_q = db_query($new_sql);
while($new_data = mysqli_fetch_object($new_q)){
?>


  <h3><?=$new_data->PBI_NAME.": <span class='badge badge-danger'>  ".$new_data->pending_list?> </span></h3>

  <div>
  <fieldset>
<legend>  </legend>
 
    <?php
	 $res='select t.task_no ,t.task_date, t.schedule_date as dead_line ,t.task_title,t.description, proj.project_name 
   from task_assign_master t, personnel_basic_info p, task_project proj 
   where t.assign_person='.$new_data->assign_person.' and t.assign_person=p.PBI_ID and proj.project_id=t.project and t.status="Processing"  order by task_no desc';
	echo link_report($res,'mr_print_view.php');
	
	?>

</fieldset>

  <!-- <fieldset>
  <legend>Task Information</legend>
  <table border="0" cellpadding="0" cellspacing="0" style="border:0px;">
  <tr>
  <td style="border:0px;"> <strong><input type="radio" checked="checked" />&nbsp;Task Title :</strong> <br /><?=$new_data->task_title?></td>
  </tr>
  <tr>
   <td style="border:0px;">&nbsp;</td>
  </tr>
  <tr>
  <td style="border:0px;"> <strong><input type="radio" checked="checked" />&nbsp;Task Description :</strong> <br /><?=$new_data->description?></td>
  </tr>
  <tr>
   <td style="border:0px;">&nbsp;</td>
  </tr>
  <tr>
  <td style="border:0px;"> <strong><input type="radio" checked="checked" />&nbsp;Assign Person :</strong> <?=$new_data->PBI_NAME?></td>
  </tr>
  <tr>
  <td style="border:0px;"> <strong><input type="radio" checked="checked" />&nbsp;Project :</strong> <?=$new_data->project_name?></td>
  </tr>
  <tr>
  <td style="border:0px;"> <strong><input type="radio" checked="checked" />&nbsp;Schedule Date :</strong> <?=$new_data->schedule_date?></td>
  </tr>
  <tr>
  <td style="border:0px;"> <strong><input type="radio" checked="checked" />&nbsp;Priority : <?=$new_data->priority?></strong> </td>
  </tr>
  <tr>
  <td style="border:0px;"> <strong><input type="radio" checked="checked" />&nbsp;Status :</strong> <?=$new_data->status?></td>
  </tr>
  <tr>
   <td style="border:0px;">&nbsp;</td>
  </tr>
  
  <tr>
   
   <td style="border:0px;">
   <form name="comment_submit" method="post" action="">
   <input type="submit" name="comment_<?=$new_data->task_no?>" id="comment" value="Comment" class="btn btn-warning" onclick="return_function(<?=$new_data->task_no?>)" />
   <input type="hidden" name="task_comment_<?=$new_data->task_no?>" id="task_comment_<?=$new_data->task_no?>">
   <input type="hidden" name="task_id_<?=$new_data->task_no?>" id="task_id_<?=$new_data->task_no?>" />
   <input type="hidden" name="my_comment" id="my_comment" value="my_comment" />
   &nbsp;
   </form>
   </td>
  </tr>
  </table>
  
  </fieldset> -->
    
<!-- <fieldset>
<legend>Comment </legend>
    <?php
	 $res='select c.task_no,c.comment_date,c.task_comment,u.fname as user from task_comments c,user_activity_management u where c.entry_by=u.user_id and c.task_no="'.$new_data->task_no.'"';
	echo link_report($res,'mr_print_view.php');
	
	?>

</fieldset> -->
    
  </div>




<?php 
}
?>
</div>
</div>
</td>

</tr>

</table>
    

</table>

</div>
<script>
function return_function(id) {
  var notes = prompt("Write your comment here","");
  var task_id = id;
  if (notes!=null) {
    document.getElementById("task_comment_"+id).value =notes;
	document.getElementById("task_id_"+id).value =task_id;
	document.getElementById("comment_submit").submit();
  }
  return false;
}
</script>
<script>
  $( function() {
    $( "#accordion" ).accordion();
  } );
</script>
<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>