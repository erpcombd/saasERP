<?php
require_once "../../../assets/template/layout.top.php";


$title='Bin Card Reports';

do_calander("#f_date");
do_calander("#t_date");
auto_complete_from_db('item_info','item_name','concat(item_name,"#>",item_id)','1','item');
?>


<div class="d-flex justify-content-center">
    <form class="n-form1 pt-4" action="product_transection_report_master.php" method="post" name="form1" target="_blank" id="form1">
        <div class="row m-0 p-0">
            <div class="col-sm-5">
                <div align="left">Select Report </div>
                <div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="3" checked="checked" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                        BIN CARD DETAIL (Date Wise)(3)
                    </label>
                </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="5" tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                        BIN CARD(Finish Goods)(5)
                    </label>
                </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="1"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                        BIN CARD (Posting Wise)(1)
                    </label>
                </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="4"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                        BIN CARD WITH SR NO(4)
                    </label>
                </div>
				<div class="form-check">
                    <input name="report" type="radio" class="radio1" id="report1-btn" value="2"  tabindex="1"/>
                    <label class="form-check-label p-0" for="report1-btn">
                        Product Transection Report Summary(2)
                    </label>
                </div>
               

            </div>

            <div class="col-sm-7">
                

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product name:</label>
                    <div class="col-sm-8 p-0">
                        <select name="item_id" id="item_id" class="form-control">
                        	<option></option>
                      
							<? foreign_relation('item_info','item_id','item_name',$item_id);?>
                   		 </select>
                    </div>
                </div>


                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From:</label>
                    <div class="col-sm-8 p-0">
                      <span class="oe_form_group_cell">
                        	<input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" required autocomplete="off" / class="form-control">
                      </span>

                    </div>
                </div>

                <div class="form-group row m-0 mb-1 pl-3 pr-3">
                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To:</label>
                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">
                            <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" required autocomplete="off" / class="form-control">

                        </span>


                    </div>
                </div>


                




            </div>

        </div>
        <div class="n-form-btn-class">
            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" />
        </div>
    </form>
</div>






<?php /*?><form action="product_transection_report_master.php" method="post" name="form1" target="_blank" id="form1">
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
                                <td><input name="report" type="radio" class="radio" checked="checked" value="3"/></td>
                                <td><div align="left">BIN CARD DETAIL (Date Wise)(3)</div></td>
                              </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="5"/></td>
							    <td><div align="left">BIN CARD(Finish Goods)(5)</div></td>
						      </tr>
							  <tr>
                                <td><input name="report" type="radio" class="radio" value="1"/></td>
                                <td><div align="left">BIN CARD (Posting Wise)(1)</div></td>
                              </tr>
                              <tr>
                                <td><input name="report" type="radio" class="radio" value="4"/></td>
                                <td><div align="left">BIN CARD WITH SR NO(4)</div></td>
                              </tr>
                              
                              
                              <tr>
                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>
                                <td width="94%"><div align="left">Product Transection Report Summary(2)</div></td>
                              </tr>
                          </table></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>Product Name: </td>
                    <td><input type="text" name="item" id="item" style="width:250px" required="required" />
                    </td>
                  </tr>
                  <tr>
                    <td>From: </td>
                    <td><input  name="f_date" type="text" id="f_date" required="required" value="<?=date('Y-m-01')?>"/></td>
                  </tr>
                  <tr>
                    <td>To: </td>
                    <td><input  name="t_date" type="text" id="t_date" required="required" value="<?=date('Y-m-d')?>"/></td>
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
              <td><input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
</form><?php */?>
<?
require_once "../../../assets/template/layout.bottom.php";
?>