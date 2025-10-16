<?php

session_start();

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Requisition Status';


$page_name = 'PR Status';

$table = 'requisition_master';

$unique = 'req_no';

$status = 'UNCHECKED';

$target_url = '../pr/mr_print_view.php';



?><head>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<script language="javascript">

function custom(theUrl)

{

	window.open('<?=$target_url?>?<?=$unique?>='+theUrl);

}

</script>


<div class="form-container_large">

<form action="" method="post" name="codz" id="codz"> 
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" style="margin-top:-2.9%">

      <tr bgcolor="#FFD">
        <td width="193" align="center" valign="middle"  style="text-align: center">&nbsp;</td>
        <td width="193" align="center" valign="middle"  style="text-align: left">&nbsp;</td>
        <td valign="middle" >&nbsp;</td>
        <td width="143" align="center" valign="middle">&nbsp;</td>
        <td valign="middle">&nbsp;</td>
        <td width="690" rowspan="5" valign="middle"><strong>
          
          <input type="submit" name="submitit" id="submitit" value="VIEW DETAIL" style="width:120px; font-weight:bold; font-size:12px; height:30px; color:#090; margin-left:23px; margin-top:10px;"/>
          
        </strong></td>
      </tr>
      <tr bgcolor="#FFD">
        <td align="center" valign="middle"  style="color: #FFFFFF">&nbsp;</td>
    
    <td align="center" valign="middle"  style="color: #000"><strong>Date:</strong></td>
    
    <td width="144" valign="middle"  style="color: #FFFFFF"><strong>
      
      <input type="date" name="fdate" id="fdate" value="<?=(isset($_POST['fdate']) && $_POST['fdate']!="")?$_POST['fdate']:date('Y-m-01')?>" />
      
      </strong></td>
    <br />
    
    <td align="center" valign="middle"  style="color: #FFFFFF"><strong> -to- </strong><span style="text-align: center"></span></td>
    
    <td width="144" valign="middle" style="color: #FFFFFF"><strong>
      
      <input type="date" name="tdate" id="tdate" value="<?=(isset($_POST['tdate']) && $_POST['tdate']!="")?$_POST['tdate']:date('Y-m-d')?>" />
      
      </strong></td>
    <br />
    
    </tr>

  <tr bgcolor="#FFD">
    <td align="right" valign="middle"  style="color: #FFFFFF">&nbsp;</td>
    <td align="right" valign="middle"  style="color: #FFFFFF">&nbsp;</td>
    <td colspan="3" valign="middle"  style="color: #FFFFFF">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFD">
    <td align="right" valign="middle"  style="color: #FFFFFF">&nbsp;</td>
    <td align="right" valign="middle"  style="color: #000"><strong>
      <?=$title?>
      : </strong></td>
    <td colspan="3" valign="middle"  style="color: #FFFFFF"><strong>
      <select name="status" id="status">
        <option>
          <?=$_POST['status']?>
          </option>
        <option>UNCHECKED</option>
        <option>CHECKED</option>
        <option>ALL</option>
      </select>
    </strong></td>
  </tr>
  <tr bgcolor="#FFD">
    <td align="right" valign="middle" style="color: #FFFFFF">&nbsp;</td>

    <td align="right" valign="middle"  style="color: #FFFFFF">&nbsp;</td>

    <td colspan="3" valign="middle" style="color: #FFFFFF">&nbsp;</td>

    </tr>

</table>
</form>
<table width="100%" border="1" cellspacing="2" cellpadding="2">

<tr border="1" >

<td bordercolor="#0000CC"><div class="tabledesign2">
<div id="accordion">
<? 

if($_POST['status']!=''&&$_POST['status']!='ALL')

$con .= 'and a.status="'.$_POST['status'].'"';



if($_POST['fdate']!=''&&$_POST['tdate']!='')

$con .= 'and a.req_date between "'.$_POST['fdate'].'" and "'.$_POST['tdate'].'"';



 $new_sql='select * from task_assign_master where 1';

//echo link_report($res,'mr_print_view.php');
$new_q = db_query($new_sql);
while($new_data = mysqli_fetch_object($new_q)){
?>


  <h3><?="PR No: ".$new_data->task_no?></h3>
  <div>
  <fieldset>
  <legend>PR Information</legend>
  <table>
  <tr>
  <td><?=$new_data->note?></td>
  </tr>
  </table>
  
  </fieldset>
    <fieldset>
    <legend>Remarks</legend>
    <?=$new_data->note?>
    </fieldset>
<fieldset>
<legend>Comment </legend>
    <?php
	$res='select a.master_id,a.master_id as PR_no,p.PBI_NAME as Employee_name,a.status,(case when status="UNCHECKED" then entry_at when status="CHECKED" then edit_at when status="CANCELED" then edit_at when status = "RETURNED" then edit_at ELSE "" END) as Checked_at from approval_matrix a,personnel_basic_info p where a.pbi_id=p.PBI_ID and a.master_id="'.$new_data->req_no.'" and req_type="pr" order by a.id asc ';
	echo link_report($res,'mr_print_view.php');
	
	?>

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
</div>

<script>
  $( function() {
    $( "#accordion" ).accordion();
  } );
</script>
<?
require_once SERVER_CORE."routing/layout.bottom.php";

?>