<?php

session_start();

ob_start();



require "../../../warehouse_mod/support/inc.all.php";

// ::::: Start Edit Section ::::: 

$title='Purchase Return Re-hit';			// Page Name and Page Title







$pr_no = $_REQUEST['pr_no'];







if($pr_no>0)

{	

	$found = find_a_field('journal','tr_no','1 and tr_no = "'.$pr_no.'" and tr_from = "Purchase Return" ');

	if($found ==0){
	$sql3 = "DELETE FROM `secondary_journal` WHERE tr_no=".$pr_no." and tr_from ='Purchase Return'";

	db_query($sql3);
	
	auto_insert_secoundary_journal_po_return($pr_no);
	
	
	
	echo '<div align="center" class="style2">Purchase Return  Re-hit Successfull </div>';
	
	}
	
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

if($found > 0){

?>

		<title>Purchase Return Re-hit</title><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FF0000">

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
  
  	

    <td height="35" bgcolor="#33CCFF"><strong>Purchase Return NO: </strong></td>

    <td bgcolor="#33CCFF"><input name="pr_no" type="text" id="pr_no" maxlength="16" value="<?=$pr_no?>" required /></td>

    <td align="center" valign="middle" bgcolor="#33CCCC"><input name="search" type="submit" id="search" value="Re-hit Purchase Return" /></td>

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

require_once SERVER_CORE."routing/layout.bottom.php";

?>