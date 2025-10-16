	<?php
	
	session_start();
	
	ob_start();
	
	
	
	require "../../../warehouse_mod/support/inc.all.php";
	
	// ::::: Start Edit Section ::::: 
	
	$title='Other Issue Edit';			// Page Name and Page Title
	
	
	
	
	
	
	
	$oi_no = $_REQUEST['oi_no'];
	
	
	
	
	
	if($oi_no>0)
	
	{
	
	//$found = find_a_field('journal','tr_no','1 and tr_no = "'.$pi_no.'" and tr_from = "Production Receive" ');
	
	
	$oi_no = find_a_field('warehouse_other_issue','oi_no','oi_no='.$oi_no);
	
	//$line_id = find_a_field('production_floor_issue_master','warehouse_to','pi_no='.$pi_no);

	
	echo "hi";
		
	echo '<script> window.location.href= "../../../warehouse_mod/pages/other_isse/'.$_POST['type'].'_issue.php?oi_no='.$oi_no.'" </script>';
		
	
	
	
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
	
			<title>Other Issue Edit</title><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FF0000">
	
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
	
		<td height="35" bgcolor="#33CCFF"><strong>OI No: </strong></td>
	
		<td bgcolor="#33CCFF"><input name="oi_no" type="text" id="oi_no" maxlength="16" value="<?=$_POST['oi_no']?>" required /></td>
		
		<td bgcolor="#33CCFF">
		
		
		
		<select name="type" id="type" required>
		<option></option>
		<option value="damage">Damage Issue</option>
		<option value="entertainment">Entertainment Issue</option>
		<option value="gift">Gift Issue</option>
		<option value="other">Other Issue</option>
		<option value="sample">Sample Issue</option>
		
		<option value="rd">R & D Issue</option>
		</select>
		
		</td>
	
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