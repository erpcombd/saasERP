<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Sales Order Report';



if($_SESSION['ip']=='115.127.35.125'){ 

do_calander('#f_date'/*,'-360','0'*/);

do_calander('#t_date'/*,'-360','0'*/);

} else {



		if($_SESSION['user']['id']!=='10807'){

			do_calander('#f_date'/*,'-60','0'*/);

			do_calander('#t_date'/*,'-60','0'*/);

			} else {

			do_calander('#f_date'/*,'-60','0'*/);

			do_calander('#t_date'/*,'-60','0'*/);

			}

}

auto_complete_from_db('item_info','item_name','item_id','1 and product_nature="Salable"','item_id');

$dealer_code = find_a_field('user_activity_management','dealer_code','user_id="'.$_SESSION['user']['id'].'"');

?>











<div class="d-flex justify-content-center">

    <form class="n-form1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">

        <div class="row m-0 p-0">

            <div class="col-sm-5">

                <div align="left">Select Report </div>

                <div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1" checked="checked" tabindex="1">

                    <label class="form-check-label p-0" for="report1-btn">

                       Sales Order Report

                    </label>

                </div>
				<div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report1-btn" value="404" tabindex="1">

                    <label class="form-check-label p-0" for="report1-btn">

                       Challan Report

                    </label>

                </div>
				
				

            </div>



            <div class="col-sm-7">

				<div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Name</label>

                    <div class="col-sm-8 p-0">

                      <input type="text" name="item_id" id="item_id" />

                    </div>

                </div>

				<div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Dealer Name</label>

                    <div class="col-sm-8 p-0">

                      <select name="dealer_code" id="dealer_code">

                        <? foreign_relation('dealer_info','dealer_code','dealer_name_e',$_POST['dealer_code'],'dealer_code="'.$dealer_code.'"');?>

                      </select>

                    </div>

                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Brand</label>

                    <div class="col-sm-8 p-0">

                      <select name="item_brand" id="item_brand">

                      	<option></option>

                     	 <? foreign_relation('item_sub_group','sub_group_id','sub_group_name');?>

                   	 </select>

                    </div>

                </div>  



                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date</label>

                    <div class="col-sm-8 p-0">

                     <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/>

                    </div>

                </div>





                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date</label>

                    <div class="col-sm-8 p-0">

                      

                     <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/>

                     



                    </div>

                </div>



                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Inventory Name</label>

                    <div class="col-sm-8 p-0">



                             <? if($master_id==1){?>	

                      <select name="warehouse_id" id="warehouse_id">

					  

					  <option></option>



				 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'warehouse_id="'.$_SESSION['user']['depot'].'"');?>

 

                      </select>

					  

				<? }?>

					  

					  <? if($master_id==0){?>	

			

					  <select name="warehouse_id" id="warehouse_id" >

				



				 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$_POST['warehouse_id'],'warehouse_id="'.$_SESSION['user']['depot'].'"');?>

 

                      </select>

					

				 <? }?>



                    </div>

                </div>

				





            </div>



        </div>

        <div class="n-form-btn-class">

            <input name="submit" type="submit" class="btn1 btn1-submit-input" value="Report" />

        </div>

    </form>

</div>













<?php /*?><form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>

      <td><div class="box4">

          <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                                <td colspan="2" class="title1"><div align="left">Select Report </div></td>

                              </tr>

                              <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="1" checked="checked" /></td>

                                <td width="94%"><div align="left">Sales Order Report Details(5)</div></td>

                              </tr>

							  

                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                  <tr>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                  </tr>

                  <tr>

                    <td>Item Name:</td>

                    <td><input type="text" name="item_id" id="item_id" style="width:250px" /></td>

                  </tr>

				  <tr>

                    <td>Dealer Name:</td>

                    <td><select name="dealer_code" id="dealer_code">

                      <option></option>

                      <? foreign_relation('dealer_info','dealer_code','dealer_name_e');?>

                    </select></td>

                  </tr>

                  <tr>

                    <td>Item Brand: </td>

                    <td><select name="item_brand" id="item_brand">

                      <option></option>

                      <? foreign_relation('item_sub_group','sub_group_id','sub_group_name');?>

                    </select></td>

                  </tr>

                  <tr>

                    <td>From:</td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>

                  </tr>

                  <tr>

                    <td>To:</td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>

                  </tr>

                  <tr>

                    <td>Invantory Name: </td>

                    <td><select name="warehouse_id" id="warehouse_id">

					  <? foreign_relation('warehouse','warehouse_id','warehouse_name');?>

                    </select></td>

                  </tr>

              </table></td>

            </tr>

          </table>

      </div></td>

    </tr>

    <tr>

      <td>&nbsp;</td>

    </tr>

    <tr>

      <td><div class="box">

        <table width="1%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td><input name="submit" type="submit" class="btn1 btn1-submit-input" value="Report" /></td>

            </tr>

          </table>

      </div></td>

    </tr>

  </table>

</form><?php */?>

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>