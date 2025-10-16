<? 
//ini_set('display_errors',1); ini_set('display_startup_errors',1); error_reporting(E_ALL);
require_once "../../../controllers/routing/default_values.php";
require_once(SERVER_CORE.'core/init.php');
require_once SERVER_CORE."routing/layout.top.php";
require_once '../assets/support/Calendar.php';
require_once '../assets/support/custom.php';
require_once '../assets/support/mix_function.php';
require_once '../assets/support/reg__ajax.php';
//var_dump($_SESSION);
$met_id=$_GET['met_id'];
$group_data = find_all_field('user_group','group_name','id='.$_SESSION['user']['group']);
//echo $group_data->group_name;

//$meeting_sql = 'SELECT * FROM crm_lead_activity WHERE activity_id = "'.$met_id.'"';
$meeting_sql = find_all_field('crm_lead_activity','project_id','activity_id='.$met_id);
$new = find_a_field('crm_lead_activity','project_id','activity_id='.$met_id);

$project_data = find_all_field('crm_project_org','id','id='.$new);


// ::::: Edit This Section ::::: 
$title = "Metting Details Info";
?>

<script>
  function hide() {
    document.getElementById('pr').style.display = 'none'; // Example: Hides the 'pr' div itself before printing
  }
</script>

<style>
	.table .tr .td, .table {
		border-collapse: collapse;
		border: none;
	}
  
  table {
    border-collapse: collapse;
  }
</style>
		<div id="pr">
          <div align="center">
			  <p>
				<input name="button" type="button" onClick="hide();window.print();" value="Print" style=" height: 40px; width: 90px; font-size: 15px; font-weight: bold; background-color: lightblue; border-radius: 5px; cursor: pointer;" />
			  </p>    
		  </div>
       </div>
	  
<table class="table" cellpadding="1" width="100%" border="1">
  <tr class="tr">
    <td class="td" colspan="2"><div align="center" style="font-size:18px;"><strong>Meeting Minutes</strong></div></td>
  </tr>
    <tr class="tr">
    <td class="td" colspan="2">
	<p style="font-size:14px;margin: 0px;padding: 0px;"><strong>Meeting Date & Time</strong>: <?=$meeting_sql->date;?> (<?=$meeting_sql->time;?> ) </p>
	<p style="font-size:14px;margin: 0px;padding: 0px;"><strong>Meeting Subject</strong>: <?=$meeting_sql->subject;?> </p>
	<p style="font-size:14px;margin: 0px;padding: 0px;;"><strong>Meeting Location</strong>: <?=$meeting_sql->location;?> </p>
		<p style="font-size:14px;margin: 0px;padding: 0px;"><strong>Meeting Type:</strong>: <?=$meeting_sql->meeting_type;?></p>
	</td>
  </tr>
  <tr class="tr">
    <td class="td" colspan="2"><br /></td>
  </tr>
  <tr class="tr">
    <td class="td" width="50%">
      <table width="100%" border="1">
        <tr>
          <td><strong>Attendees:</strong> <?=$group_data->group_name;?> </td>
        </tr>
        <tr>
          <td>
		    <?php
  $ids = explode(',', $meeting_sql->assign_person);
  foreach ($ids as $id) { ?>
    <span class="badge bg-blue-dark color-white font-10 mt-2">
      <?= find_a_field('personnel_basic_info', 'PBI_NAME', 'PBI_ID = "' . $id . '"') ?>
	  (<?= find_a_field('personnel_basic_info', 'PBI_DESIGNATION', 'PBI_ID = "' . $id . '"') ?>)
    </span><br> <!-- Adding a line break after each badge -->
  <?php } ?>
		  
		  </td>
        </tr>
      </table>
    </td>
    <td class="td"  width="50%">
      <table width="100%" border="1">
        <tr>
          <td><strong>Attendees: <?=$project_data->name;?></strong></td>
        </tr>
        <tr>
          <td>		  
<?php
$text_meeting_person = $meeting_sql->meeting_person;

// Replace semicolons, commas, plus signs, ampersands, and slashes with a space and a line break
$text_with_meeting_person = str_replace(',', ',<br>', $text_meeting_person);
$text_with_meeting_person = str_replace(';', ';<br>', $text_with_meeting_person);
$text_with_meeting_person = str_replace('+', '+<br>', $text_with_meeting_person);
$text_with_meeting_person = str_replace('&', '&<br>', $text_with_meeting_person);
$text_with_meeting_person = str_replace('/', '/<br>', $text_with_meeting_person);

// Insert line breaks before any number (using regex)
$text_with_meeting_person = preg_replace('/(\d+)/', '<br>$1', $text_with_meeting_person);

// Output the result
echo $text_with_meeting_person;
?>
		  </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr class="tr">
    <td colspan="2" class="td"><br /></td>
  </tr>
  <tr class="tr">
    <td class="td" colspan="2">
	<strong>Notes:</strong>
	<?php
	$text_meeting_note = $meeting_sql->note;
	// Insert line breaks before any number (using regex)
	$text_with_meeting_note = preg_replace('/(\d+)/', '<br>$1', $text_meeting_note);
	
	// Output the result
	echo $text_with_meeting_note;
	?>
	</td>
  </tr>
  <tr class="tr">
    <td colspan="2" class="td"><br /></td>
  </tr>
  <tr class="tr">
    <td class="td" colspan="2">
	<strong>Decision:</strong>
	<?php
	$text_meeting_details = $meeting_sql->details;
	// Insert line breaks before any number (using regex)
	$text_with_meeting_details = preg_replace('/(\d+)/', '<br>$1', $text_meeting_details);
	
	// Output the result
	echo $text_with_meeting_details;
	?>
	</td>
  </tr>
  <tr class="tr">
    <td colspan="2" class="td"><br /></td>
  </tr>
  <tr class="tr">
    <td class="td" colspan="2">

	<strong>Next Action Plan:</strong>
	<?php
	$text_meeting_plan = $meeting_sql->plan;
	// Insert line breaks before any number (using regex)
	$text_with_meeting_plan = preg_replace('/(\d+)/', '<br>$1', $text_meeting_plan);
	
	// Output the result
	echo $text_with_meeting_plan;
	?>
	</td>
  </tr>
</table>

