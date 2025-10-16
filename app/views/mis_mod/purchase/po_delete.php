<?php



session_start();



ob_start();




require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";







// ::::: Start Edit Section ::::: 



$title='Purchase Order Delete';			// Page Name and Page Title



$page="task_assign.php";			// PHP File Name



$root='mis';







$table1='purchase_master';					// Database Table Name Mainly related to this page

$table2='purchase_master_local';	

$unique='id';						// Primary Key of this Database table



$shown='po_date';				// For a New or Edit Data a must have data field







// ::::: End Edit Section :::::



do_calander('#po_date');







$po_no = $_REQUEST['po_no'];



$crud      =new crud($table);







$$unique = $_GET[$unique];







	$po_no = $_REQUEST['po_no'];



	//$status = $_REQUEST['status'];







if(isset($_REQUEST['po_no'])!='')



{

	







	 $sql1 = "DELETE  FROM `purchase_master` WHERE po_no=".$po_no;
	 db_query($sql1);
	  $sql2 = "DELETE    FROM `purchase_invoice` WHERE  po_no=".$po_no;
	



	
	db_query($sql2);



}



?><title>PO DELETE</title>



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



   

    <td bgcolor="#33CCFF"><strong>

 <label>PO NO </label>

      



      <input name="po_no" type="text" id="po_no" maxlength="16" value="<?=$po_no?>" required / class="form-control"> 



       



    </strong></td>



      <td rowspan="" align="center" valign="middle" bgcolor="#33CCCC"><strong>



      <label>



      <input name="search" type="submit" id="search" value="Delete PO" / class="form-control">



        </label>



    </strong></td>



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