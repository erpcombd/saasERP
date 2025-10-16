<?


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";



$title='New Task Assign';

/*if(isset($_POST['my_comment']) && $_POST['my_comment']!=''){

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

}*/

if(isset($_POST['feedback'])){

$new_sql='select * from task_assign_master where status="Processing" order by task_no desc';
$new_q = db_query($new_sql);
while($new_data = mysqli_fetch_object($new_q)){
$task_id = $new_data->task_no;
$comment = $_POST['comment_'.$new_data->task_no];
$complete_percent = (int)$_POST['complete_percent_'.$new_data->task_no];
$total_previous_percent = find_a_field('task_feedback','sum(complete_percent)','task_id="'.$task_id.'"');
$total_percent = $total_previous_percent+$complete_percent;
if($total_percent>100){
$percent = 100;
$update = 'update task_assign_master set status="Completed" where task_no="'.$task_id.'"';
db_query($update);
}else{
$percent = $complete_percent;
}

 $insert = 'insert into task_feedback(task_id,task_date,feedback_date,complete_percent,comment,entry_by,entry_at) value("'.$task_id.'","'.$new_data->task_date.'","'.date('Y-m-d').'","'.$percent.'","'.$comment.'","'.$_SESSION['user']['id'].'","'.date('Y-m-d H:i:s').'")';
 db_query($insert);
 
 
 }

}

if(isset($_POST['status'])){
$new_sql='select * from task_assign_master where status="Processing" order by task_no desc';
$new_q = db_query($new_sql);

while($new_data = mysqli_fetch_object($new_q)){
$task_id = $new_data->task_no;
$status = $_POST['completed_'.$new_data->task_no];
if($status!=''){
 $update = 'update task_assign_master set status="Completed", edit_by="'.$_SESSION['user']['id'].'", edit_at="'.date('Y-m-d H:i:s').'" where task_no="'.$task_id.'"';
 db_query($update);
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




<form name="comment_submit" id="comment_submit" method="post" action="">
<table width="100%" border="1" cellspacing="2" cellpadding="2">

<tr border="1" >

<td bordercolor="#0000CC"><div class="tabledesign2">
<div id="accordion">
<? 

if($_POST['status']!=''&&$_POST['status']!='ALL')

$con .= 'and a.status="'.$_POST['status'].'"';



if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



 $new_sql='select t.*,p.PBI_NAME,proj.project_name from task_assign_master t, personnel_basic_info p, task_project proj where t.assign_person=p.PBI_ID and proj.project_id=t.project and t.status="Processing" and 1 order by priority asc';

//echo link_report($res,'mr_print_view.php');
$new_q = db_query($new_sql);
while($new_data = mysqli_fetch_object($new_q)){
$progress = find_a_field('task_feedback','sum(complete_percent)','task_id="'.$new_data->task_no.'"');
?>


  <h3><?="Task No: ".$new_data->task_no?></h3>
  <div>
  <fieldset>
  <legend>Task Information</legend>
  <table border="0" cellpadding="0" cellspacing="0" style="border:0px; width:60%; float:left; clear:right;">
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
  <td style="border:0px;"> <strong><input type="radio" checked="checked" />&nbsp;Progress :</strong> <progress id="file" value="<?=$progress?>" max="100" title="<?=$progress?> % Completed" style="width:100%; height:30px;"> <?=$progress?>% </progress></td>
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
    <td style="border:0px;"><a href="task_assing.php?task_no=<?=$new_data->task_no?>" class="btn btn-warning">Edit</a></td>
  </tr>
   <tr>
   <td style="border:0px;">
   <!--<input type="button" name="comment_<?=$new_data->task_no?>" id="comment" value="Comment" class="btn btn-warning" onclick="return_function(<?=$new_data->task_no?>)" />
   <input type="hidden" name="task_comment_<?=$new_data->task_no?>" id="task_comment_<?=$new_data->task_no?>">
   <input type="hidden" name="task_comment_<?=$new_data->task_no?>" id="task_comment_<?=$new_data->task_no?>">-->
    <fieldset>
<legend>Feedback </legend>
    <?php
	 $res='select c.task_id,c.feedback_date,c.comment,u.fname as user from task_feedback c,user_activity_management u where c.entry_by=u.user_id and c.task_id="'.$new_data->task_no.'"';
	echo link_report($res,'mr_print_view.php');
	
	?>

</fieldset>
   </td>
  </tr>
  </table>
  <input type="button" name="comment_<?=$new_data->task_no?>" id="comment" value="Feedback" class="btn btn-warning" onclick="return_function(<?=$new_data->task_no?>)" />
  <table width="100%" cellpadding="0" cellspacing="0" border="0" id="feedback_table<?=$new_data->task_no?>" style="display:none; float:right; width:40%;">
	  <tr>
	    <td style="border:0px;">Total Complete (%)</td>
		<td style="border:0px;"><input type="text" name="complete_percent_<?=$new_data->task_no?>" id="complete_percent_<?=$new_data->task_no?>" class="form-control"/></td>
	  </tr>
	  <tr>
	    <td style="border:0px;">Feedback</td>
		<td style="border:0px;"><textarea name="comment_<?=$new_data->task_no?>" id="comment_<?=$new_data->task_no?>" class="form-control"></textarea></td>
	  </tr>
	  <tr>
	  <td style="border:0px;" align="right"><div align="right"><input type="submit" name="feedback" id="feedback" value="Submit" class="btn btn-success" /></div></td>
	  <td style="border:0px;" align="right"><div align="right"><input type="button" name="close" id="close" value="Close" class="btn btn-danger" onclick="feedback_close(<?=$new_data->task_no?>)" /></div></td>
	  </tr>
	</table>
  </form>
  
  </fieldset>
    

    
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
<!--<script>
function return_function(id) {
  var notes = prompt("Write your comment here","");
  if (notes!=null) {
    var task_id = id;
    document.getElementById("task_comment_"+id).value =notes;
	document.getElementById("task_id_"+id).value =task_id;
	document.getElementById("comment_submit").submit();
  }
  return false;
}
</script>-->
<script>
function return_function(id) {
  
    var task_id = id;
    document.getElementById("feedback_table"+id).style.display ='';
	
}

function feedback_close(id){
document.getElementById("feedback_table"+id).style.display ='none';
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