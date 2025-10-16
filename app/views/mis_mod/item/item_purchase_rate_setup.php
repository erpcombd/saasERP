<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Start Edit Section ::::: 

$title='Purchase Price Setup';			// Page Name and Page Title

$page="task_assign.php";			// PHP File Name

$root='mis';



$table='journal_item';					// Database Table Name Mainly related to this page

$unique='id';						// Primary Key of this Database table

$shown='ji_date';				// For a New or Edit Data a must have data field







//while($ddata = mysqli_fetch_object($qquery)){

//$sql = "INSERT INTO sales_corporate_price 

//(dealer_code, item_id, `discount`, `set_price`, `entry_by`, `entry_at`, `edit_by`, `edit_at`) VALUES

//('".$ddata->dealer_code."', 1096000100010342, 0.00, 313.8000, 10149, '2015-05-26 17:18:36', 10149, '2015-05-26 17:42:38')";


//}



// ::::: End Edit Section :::::

do_calander('#ji_date');



$chalan_no = $_REQUEST['chalan_no'];

$crud      =new crud($table);



// $$unique = $_GET[$unique];



$old_item = $_REQUEST['old_item'];



if(isset($_POST['change_ledger'])&&$_POST['old_item_id']>0)

{



	$item_id = $_POST['old_item_id'];

	$mrp_price = find_a_field('item_info','m_price','item_id='.$item_id);



	$sql = "select * from item_info where  item_id = '".$item_id."'";

	$query = db_query($sql);

	while($data = mysqli_fetch_object($query))

	{

		$set_price = $_POST['price_set'];
		
		$ji_date = $_POST['ji_date'];
		
	echo	$rate_set="INSERT INTO `journal_item` (`id`, `ji_date`, `item_id`, `warehouse_id`, `relevant_warehouse`, `pre_stock`, `pre_price`, `item_in`, `item_ex`, `item_price`, `final_stock`, `final_price`, `tr_from`, `tr_no`, `sr_no`, `entry_by`, `entry_at`) VALUES (NULL, '".$ji_date."', '".$item_id."', '', '0', '0.0000', '0.00000000', '0.0000', '0.0000', '".$set_price."', '0.0000', '".$set_price."', 'Purchase', '0', '0', '".$_SESSION['user_id']."', '2020-03-09 00:00:00')"; 


		db_query($rate_set);

	}


echo "Insert Successsully";

echo "<script> window.location.href='item_purchase_rate_setup.php'; </script>";
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

           	 <table border="0" class="text-center" style="padding: 5px; width:85%"><th></th>

  <tr>

    <td style="background-color:#33CCFF; height: 35px"><strong> Item Code:</strong></td>

    <td style="background-color:#33CCFF;">

	<strong>

		<label>

<input name="old_item" type="text" id="old_item" maxlength="16" value="<?=$old_item?>" required / class="form-control">
		</label>
    </strong>	</td>

<td class="text-center" style="background-color:#33CCFF; vertical-align: middle">

	<strong>

		<label>

			<div class="text-center">

			  <input name="search" type="submit" id="search" value="Find Item!" style="width:100px;" / class="form-control">
			      </div>

		</label>
	</strong></td>
  </tr>

  

  <? if($old_item>0){?>

  

    <tr>

    <td style="background-color:#FFFFFF;">&nbsp;</td>

    <td style="background-color:#FFFFFF;">&nbsp;</td>

    <td style="background-color:#FFFFFF;">&nbsp;</td>
  </tr>

    <tr>

      <td style="height: 35px; vertical-align: middle; background-color:#33CCCC;" class="text-center">Item Name: </td>

      <td style="height: 35px; vertical-align: middle; background-color:#33CCCC;" class="text-center">

	  <div style="vertical-align: left;">

		<input name="old_item_name" type="text" id="old_item_name" value="<?=find_a_field('item_info','item_name','item_id='.$old_item);?>" / class="form-control">
      </div>	  </td>

      <td rowspan="4" style="vertical-align:middle; background-color:#33CCCC">

		<div  style="vertical-align:middle">

		  <input name="change_ledger" type="submit" id="change_ledger" value="Price Setup" / class="form-control">
		  </div></td>
    </tr>

    <tr>

    <td style="height: 35px; vertical-align: middle; background-color:#33CCCC;" class="text-center"><label>Item Code:</label></td>

    <td style="height: 35px; vertical-align: middle; background-color:#33CCCC;" class="text-center">

		<div style="vertical-align: left;">

			<input name="old_item_id" type="text" id="old_item_id" value="<?=find_a_field('item_info','item_id','item_id='.$old_item);?>" / class="form-control">
		</div>	</td>
    </tr>
	
	<tr>
	  <td style="height: 35px; vertical-align: middle; background-color:#33CCCC;" class="text-center">Date</td>
	  <td style="height: 35px; vertical-align: middle; background-color:#33CCCC;" class="text-center"><div align="left">
        <input name="ji_date" type="text" id="ji_date" value=" " required / class="form-control">
      </div></td>
	  </tr>
	<tr>

    <td style="height: 35px; vertical-align: middle; background-color:#33CCCC;" class="text-center"><label>Set Price:</label></td>

    <td style="height: 35px; vertical-align: middle; background-color:#33CCCC;" class="text-center">

		<div style="vertical-align: left;">

			<input name="price_set" type="text" id="price_set" value="<?=find_a_field('item_info','cost_price','item_id='.$old_item);?>" required / class="form-control">
		</div>	</td>
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