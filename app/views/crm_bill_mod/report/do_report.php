<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Billing Advence Reports';

  create_combobox('customer_id');

do_calander("#f_date");

do_calander("#t_date");

?>







<div class="d-flex justify-content-center">

    <form class="n-form1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">

        <div class="row m-0 p-0">

            <div class="col-sm-5">

                <div align="left">Select Report </div>

                <div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report1-btn" value="404" checked="checked" tabindex="1"/>

                    <label class="form-check-label p-0" for="report1-btn">

                       Customer Report

                    </label>

                </div>
				
				<div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report1-btn" value="505"  tabindex="1"/>

                    <label class="form-check-label p-0" for="report1-btn">

                       Bill Information

                    </label>

                </div>
				
				
				<div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report1-btn" value="606"  tabindex="1"/>

                    <label class="form-check-label p-0" for="report1-btn">

                       Generated Bill Information

                    </label>

                </div>
				
				<div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report1-btn" value="777"  tabindex="1"/>

                    <label class="form-check-label p-0" for="report1-btn">

                       Monthly Collection Report

                    </label>

                </div>
				
				<!--<div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report1-btn" value="707"  tabindex="1"/>

                    <label class="form-check-label p-0" for="report1-btn">

                       Closing Report

                    </label>

                </div>-->
				
				<div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report1-btn" value="709"  tabindex="1"/>

                    <label class="form-check-label p-0" for="report1-btn">

                       Collection Report

                    </label>

                </div>

				

				

                



            </div>



            <div class="col-sm-7">

				

				<div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Customer Name</label>

                    <div class="col-sm-8 p-0">

                      <select name="customer_id" id="customer_id" class="form-control">

					 		 <option></option>

							<? foreign_relation('crm_service_customer','customer_id','customer_name',$data->customer_id);?>

					</select>

                    </div>

                </div>

                  



                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">From Date</label>

                    <div class="col-sm-8 p-0">

                     <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" required autocomplete="off" / class="form-control">

                    </div>

                </div>





                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To Date</label>

                    <div class="col-sm-8 p-0">

                     

                     <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" required autocomplete="off" / class="form-control">

                     



                    </div>

                </div>

               
			   <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Bill Type</label>

                    <div class="col-sm-8 p-0">

                      <select name="type" id="type" class="form-control">

					    <option value=""></option>

                        <? foreign_relation('crm_acc_bill_type','id','type',$type,'1');?>

			        </select>

                    </div>

                </div>

                
				<div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Bill Status</label>

                    <div class="col-sm-8 p-0">

                      <select name="status" id="status" class="form-control">

					    <option value=""></option>

                        <option value="PENDING">PENDING</option>

                        <option value="BILL SUBMITTED">BILL SUBMITTED</option>

					    <option value="BILL RECEIVED">BILL RECEIVED</option>
						<option value="CANCELED">CANCELED</option>

			        </select>

                    </div>

                </div>





            </div>



        </div>

        <div class="n-form-btn-class">

            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" />

        </div>

    </form>

</div>









<!--<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

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

                                <td width="6%"><input name="report" type="radio" class="radio" value="1" /></td>

                                <td width="94%"><div align="left">Purchase Order Summary</div></td>

                              </tr>

							  

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="1005" /></td>

                                <td><div align="left">Present Stock Summary</div></td>

                              </tr>-->

                              

                            <!-- <tr>

                                <td><input name="report" type="radio" class="radio" value="2" /></td>

                                <td><div align="left">Purchase Receive Report(PO Wise)</div></td>

                              </tr>

                               <tr>

                                <td><input name="report" type="radio" class="radio" value="3" /></td>

                                <td><div align="left">Purchase Receive Report(Date Wise)</div></td>

                              </tr>-->

                            <!--  <tr>

                                <td><input name="report" type="radio" class="radio" value="5" /></td>

                                <td><div align="left">Purchase Receive Report (PO Wise)</div></td>

                              </tr>-->

                              <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="6" /></td>

                                <td><div align="left">Purchase Receive Report</div></td>

                              </tr>-->

                       <!--       <tr>

                                <td><input name="report" type="radio" class="radio" value="4" /></td>

                                <td><div align="left">View Purchase Order(Single)</div></td>

                              </tr>-->

                   <!--       </table></td>

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

                    <td>Prepared By:</td>

                    <td><select name="by" id="by" class="form-control">

					  <option></option>-->

<?php /*?><? 

$sql="SELECT a.user_id,a.fname FROM `user_activity_management` a WHERE level=3 or level=5";

advance_foreign_relation($sql,$by);	  

?>

</select></td>

                  </tr>

                  <tr>

                    <td>Product Sub Category: </td>

                    <td><select name="sub_group_id" id="sub_group_id" class="form-control">

					  <option></option>

				<? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$data->sub_group_id);?>

			</select></td>

                  </tr>

                  <tr>

                    <td>Product Name: </td>

                    <td><select name="item_id" id="item_id" class="form-control">

                        <option></option>

                      

						<? foreign_relation('item_info','item_id','item_name',$item_id);?>

                    </select></td>

                  </tr>

                  <tr>

                    <td>From: </td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" required autocomplete="off" / class="form-control"></td>

                  </tr>

                  <tr>

                    <td>To: </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" required autocomplete="off" / class="form-control"></td>

                  </tr>

				  <tr>

                    <td>Vendor Name: </td>

                    <td><select name="vendor_id" id="vendor_id" class="form-control">

                        <option></option>

                        <? 

						$sql = "select v.vendor_id,concat(v.vendor_name,'-',g.group_name) from vendor v,user_group g where v.group_for=g.id order by v.vendor_name";

						foreign_relation_sql($sql);?>

                    </select></td>

                  </tr>

					

				  <tr>

				    <td>Purchase Order Status:</td>

				    <td><select name="status" id="status" class="form-control">

					    <option value="">All</option>

                        <option value="CHECKED">CHECKED</option>

                        <option value="UNCHECKED">UNCHECKED</option>

					    <option value="DONE">DONE</option>

			        </select></td>

			      </tr>

				  <!--<tr>

                    <td>Purchase Order No: </td>

                    <td><input  name="wo_id" type="text" id="wo_id" value=""/></td>

                  </tr>-->

                  <tr>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

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

require_once SERVER_CORE."routing/layout.bottom.php";

?>