<?php

require_once "../../../assets/template/layout.top.php";

$title='Sales Order Maturity Reports';



do_calander("#f_date");

do_calander("#t_date");

do_calander("#cut_date");

auto_complete_from_db('dealer_info','concat(dealer_code,"-",team_name,"-",dealer_name_e)','dealer_code','canceled="Yes" order by dealer_code','dealer_code');

auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and product_nature="Salable" ','item_id');?>



<form action="master_report_chalan.php" method="post" name="form1" target="_blank" id="form1">

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

                                <td><input name="report" type="radio" class="radio" value="353465346" checked="checked" /></td>

                                <td><div align="left">Sales Order Maturity Report</div></td>
                              </tr>


                              <tr>

                                <td>&nbsp;</td>

                                <td>&nbsp;</td>
                              </tr>

                              <tr>

                                <td>&nbsp;</td>

                                <td>&nbsp;</td>
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

                    <td>From : </td>

                    <td><input class="form-control"  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>

                  </tr>

                  <tr>

                    <td>To : </td>

                    <td><input class="form-control"  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>

                  </tr>

				 <!-- <tr>

                    <td>Customer Name :</td>

                    <td><input  name="dealer_code" type="text" id="dealer_code" class="form-control"/></td>

                  </tr>-->

					

				  <!--<tr>

				    <td>Customer Type :</td>

				    <td><span class="oe_form_group_cell" >

				      <select name="dealer_type" id="dealer_type" class="form-control" style="margin-left:4px">

					  <option></option>

                        <option value="Distributor" >Distributor</option>

						<!--<option value="Corporate" >Corporate</option>

						<option value="SuperShop" >SuperShop</option>-->

                     <!-- </select>

				    </span></td>

			      </tr>

				  <tr>

				    <td>SO Status :</td>

				    <td><select name="status" id="status" class="form-control" style="margin-left:4px">

					    <option value="">All</option>

                        <option value="CHECKED">PROCESSION</option>

                        <option value="UNCHECKED">UNCHECKED</option>

					    <option value="DONE">DONE</option>

			        </select></td>

			      </tr>-->

				 <!-- <tr>

                    <td>Chalan No: </td>

                    <td><input  name="chalan_no" type="text" id="chalan_no" value="" class="form-control" /></td>

                  </tr>-->

               

             
 

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

<?

require_once "../../../assets/template/layout.bottom.php";

?>