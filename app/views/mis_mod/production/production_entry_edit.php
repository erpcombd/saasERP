	<?php
	
	session_start();
	
	ob_start();
	
	
	
	require "../../../warehouse_mod/support/inc.all.php";
	
	// ::::: Start Edit Section ::::: 
	
	$title='Production Entry Delete';			// Page Name and Page Title
	
	
	
	
	
	
	
	$pi_no = $_REQUEST['pi_no'];
	
	
	
	
	
	if($pi_no>0)
	
	{
	
	$found = find_a_field('journal','tr_no','1 and tr_no = "'.$pi_no.'" and tr_from = "Production Receive" ');
	
	
	$pi_no = find_a_field('production_floor_issue_master','pi_no','pi_no='.$pi_no);
	
	$line_id = find_a_field('production_floor_issue_master','warehouse_to','pi_no='.$pi_no);

	
		
	echo '<script> window.location.href= "create_new_batch.php?line_id='.$line_id.'&pi_no='.$pi_no.'" </script>';
		
	
	
	
	}
	
	
	
		?>
	
	<style type="text/css">
	
	<!--
	
	.style1 {
	
		color: #FF0000;
	
		font-weight: bold;
	
	}
	
	.style2 {
	
		color: #006600;
	
		font-weight: bold;
	
	}
	
	-->
	
	</style>
	
	<? 
	
	if($found>0){
	
	?>
	
			<title>Production Delete</title><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FF0000">
	
		  <tr>
	
			<td><div align="center" class="style2">Sorry Journal Exists! </div></td>
	
		  </tr>
	
		</table>
	
	<? 
	
	}
?>
	
	
	
	<form action="" method="post">
	
	<div class="oe_view_manager oe_view_manager_current">
	
			
	
		<? include('../../common/title_bar.php');?>
	
			<div class="oe_view_manager_body">
	
				
	
					<div  class="oe_view_manager_view_list"></div>
	
				
	
					<div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">
	
			<div class="oe_form_buttons"></div>
	
			<div class="oe_form_sidebar"></div>
	
			<div class="oe_form_pager"></div>
	
			<div class="oe_form_container"><div class="oe_form">
	
			  <div class="">
	
	<div class="oe_form_sheetbg" style="min-height:10px;">
	
			<div class="oe_form_sheet oe_form_sheet_width">
	
	
	
			  <div  class="oe_view_manager_view_list"><div  class="oe_list oe_view">
	
				 <table width="85%" border="0" align="center" cellpadding="5" cellspacing="0">
	
	  <tr>
	
		<td height="35" bgcolor="#33CCFF"><strong>PI No: </strong></td>
	
		<td bgcolor="#33CCFF"><input name="pi_no" type="text" id="pi_no" maxlength="16" value="<?=$_POST['pi_no']?>" required /></td>
	
		<td align="center" valign="middle" bgcolor="#33CCCC"><input name="search" type="submit" id="search" value="Search PI" /></td>
	
	  </tr>
	
	  
	
	
	
	  
	
		<tr>
	
		<td bgcolor="#FFFFFF">&nbsp;</td>
	
		<td bgcolor="#FFFFFF">&nbsp;</td>
	
		<td bgcolor="#FFFFFF">&nbsp;</td>
	
	  </tr>
	
	  
	
	
	</table>
	
	
	
			
	
			  
	
			  </div></div>
	
			  </div>
	
		</div>
	
		<div class="oe_chatter"><div class="oe_followers oe_form_invisible">
	
		  <div class="oe_follower_list"></div>
	
		</div></div></div></div></div>
	
		</div></div>
	
				
	
			</div>
	
	  </div>
	
	</form>
	
	

 	<?
	
	$main_content=ob_get_contents();
	
	ob_end_clean();
	
	require_once SERVER_CORE."routing/layout.bottom.php";
	
	?>