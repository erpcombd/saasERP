<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Delivery Order Advence Reports';

do_calander("#f_date");
do_calander("#t_date");
auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1','item');
?>

<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="product_transection_report_master.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-6">
            </br>
                <div align="left"> Select Report </div>
               
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1" checked="checked" tabindex="1">
                    <label class="form-check-label p-0" for="report1-btn">
                    Product Transection Report Detail (Date Wise)
                    </label>
                </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="2" tabindex="1">
                    <label class="form-check-label p-0" for="report1-btn">
                    Product Transection Report Summary (Date Wise)
                    </label>
                </div>

                

            </div>

            <div class="col-sm-6">

				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Name: </label>
                    <div class="col-sm-8 p-0">
                    <input type="text" name="item" id="item" style="width:250px" />
                    </div>
                </div>

				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Production Line</label>
                    <div class="col-sm-8 p-0">
                    <select name="pl_no" id="pl_no">
                      <option></option>
                      <? 
                        $sql="SELECT a.user_id,a.fname FROM `user_activity_management` a WHERE level=3 or level=5";
                        advance_foreign_relation($sql,$by);	  
                      ?>
                    </select>
                    </div>
                </div>


				<div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Transection Type: </label>
                    <div class="col-sm-8 p-0">
                    <select name="by2" id="by2">
                      <option></option>
                      <? 
                        $sql="SELECT a.user_id,a.fname FROM `user_activity_management` a WHERE level=3 or level=5";
                        advance_foreign_relation($sql,$by);	  
                      ?>
                    </select>
                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date: </label>
                    <div class="col-sm-8 p-0">
                    <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-d')?>"  autocomplete="off"/>
                    </div>
                </div>
                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date: </label>
                    <div class="col-sm-8 p-0">
                    <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"  autocomplete="off"/>
                    </div>
                </div>


            </div>

        </div>
        <div class="n-form-btn-class">
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report">
            
        </div>
    </form>
</div>
<? /*> 
<form action="product_transection_report_master.php" method="post" name="form1" target="_blank" id="form1">
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
                                <td width="94%"><div align="left">Product Transection Report Detail (Date Wise)</div></td>
                              </tr>
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="2" checked="checked" /></td>
                                <td width="94%"><div align="left">Product Transection Report Summary (Date Wise)</div></td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>Product Name : </td>
                    <td><input type="text" name="item" id="item" style="width:250px" />
                    </td>
                  </tr>
                  <tr>
                    <td>Production Line :</td>
                    <td><select name="pl_no" id="pl_no">
                      <option></option>
                      <? 
$sql="SELECT a.user_id,a.fname FROM `user_activity_management` a WHERE level=3 or level=5";
advance_foreign_relation($sql,$by);	  
?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>Transection Type :</td>
                    <td><select name="by2" id="by2">
                      <option></option>
                      <? 
$sql="SELECT a.user_id,a.fname FROM `user_activity_management` a WHERE level=3 or level=5";
advance_foreign_relation($sql,$by);	  
?>
                    </select></td>
                  </tr>
                  <tr>
                    <td>From : </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-d')?>"/></td>
                  </tr>
                  <tr>
                    <td>To : </td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>
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
              <td><input name="submit" type="submit" class="btn" value="Report" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
</form>
<*/?>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>