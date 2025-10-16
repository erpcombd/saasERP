<?php

session_start();

ob_start();



require "../../../warehouse_mod/support/inc.all.php";

// ::::: Start Edit Section ::::: 

$title='Production Entry Delete';			// Page Name and Page Title







$pi_no = $_REQUEST['pi_no'];

//

//$sql = "SELECT tr_no  FROM `secondary_journal` 

//WHERE `tr_from` = 'Sales' AND `tr_no` IN (17041703043,17041703023,17041703024,17041703025,17041703026,17041703027,17041703028,17041703029,17041703030,17041703031,17041703032,17041703033,17041703034,17041703035,17041703036,17041703037,17041703038,17041703039,17041703040,17041703041,17041703042,17041703044,17041703045,17041703046,17041703047,17041703048,17041703049,17041703050,17041703051,17041703052,17041703053,17041703054,17041703055,17041703056,17041703057,17041803001,17041803002,17041803003,17041803004,17041803005,17041803006,17041803007,17041803008,17041803031,17041803032,17041803034,17041803035,17041803036,17041803037,17041803038,17041803039,17041803040,17041803042,17041803043,17041803044,17041803045,17041803046,17041803047,17041803048,17041803049,17041803050,17041803051,17041803052,17041803053,17041803054,17041803055,17041803057,17041803058,17041803060,17041803061,17041803062,17041803063,17041803064,17041803065,17041803066,17041803067,17041803068,17041803069,17041803070,17041803071,17041803072,17041803073,17041803074,17041803075,17041803076,17041803077,17041803078,17041803079,17041803080,17041903001,17041903002,17041903003)";

//$query = db_query($sql);

//while($data = mysqli_fetch_object($query))

//{

//auto_reinsert_sales_chalan_secoundary($data->tr_no);

//echo $data->tr_no.'-DONE<br>';

//}





if($pi_no>0)

{

$found = find_a_field('journal','tr_no','1 and tr_no = "'.$pi_no.'" and tr_from = "Production Receive" ');

//$chalan_type = find_a_field('sale_do_chalan','gate_pass_type','chalan_no='.$chalan_no);

$pi_no = find_a_field('production_floor_issue_master','pi_no','pi_no='.$pi_no);

if($found<1){

	

	$sql = "DELETE FROM `production_floor_issue_detail` WHERE pi_no=".$pi_no."";

	db_query($sql);

	$sql2 = "DELETE FROM `journal_item` WHERE tr_from ='Production Receive' and  sr_no=".$pi_no."";

	db_query($sql2);

	

	$sql3 = "DELETE FROM `production_floor_issue_master` WHERE pi_no=".$pi_no."";

	db_query($sql3);

	

	

	

	

	

	

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

if($found>0){

?>

		<title>Production Delete</title><table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FF0000">

      <tr>

        <td><div align="center" class="style2">Sorry Journal Exists! </div></td>

      </tr>

    </table>

<? 

}

elseif($pi_no>0)

{



?>

		<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FF66">

      <tr>

        <td><div align="center" class="style2">PI Deleted Successfull </div></td>

      </tr>

    </table>

<? }?>



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

    <td bgcolor="#33CCFF"><input name="pi_no" type="text" id="pi_no" maxlength="16" value="<?=$pi_no?>" required /></td>

    <td align="center" valign="middle" bgcolor="#33CCCC"><input name="search" type="submit" id="search" value="Delete PI" /></td>

  </tr>

  

  <? if($new_ledger>0&&$old_ledger>0){?>

  

    <tr>

    <td bgcolor="#FFFFFF">&nbsp;</td>

    <td bgcolor="#FFFFFF">&nbsp;</td>

    <td bgcolor="#FFFFFF">&nbsp;</td>

  </tr>

  

  <? }?>

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