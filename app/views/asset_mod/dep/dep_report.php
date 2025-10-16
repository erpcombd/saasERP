<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Depreciation Report';



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

                        Depreciation Reports

                    </label>

                </div>

            </div>



            <div class="col-sm-7">

                



                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product name:</label>

                    <div class="col-sm-8 p-0">

                        <select name="item_id" id="item_id" class="form-control">

                        	<option></option>

                      

<? foreign_relation('item_info i,item_sub_group s,item_group g','i.item_id','i.item_name',$pName,'i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_name like "%FIXED ASSET%"')?>

                   		 </select>

                    </div>

                </div>
				
				<div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Year:</label>

                    <div class="col-sm-8 p-0">

                        
            <select name="year" required>
                <option value="<?= $_POST['year'] ?>"><?= $_POST['year'] ?></option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
            </select>

                    </div>

                </div>



            </div>



        </div>

        <div class="n-form-btn-class">

            <input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" />

        </div>

    </form>

</div>















<!--<form action="master_report_sales.php" method="post" name="form1" target="_blank" id="form1">

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

                                <td width="6%"><input name="report" type="radio" class="radio" value="1100" checked="checked" /></td>

                                <td width="94%"><div align="left">Sales Return Report</div></td>

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

                                <td><div align="left">Purchase History Report</div></td>

                              </tr>

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="6" /></td>

                                <td><div align="left">Purchase Receive Report</div></td>

                              </tr>-->

                       <!--       <tr>

                                <td><input name="report" type="radio" class="radio" value="4" /></td>

                                <td><div align="left">View Purchase Order(Single)</div></td>

                              </tr>-->

                      <!--    </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                  <tr>

                    <td>&nbsp;</td>

                    <td>&nbsp;</td>

                  </tr>-->

                  <?php /*?><tr>

                    <td>Prepared By:</td>

                    <td><select name="by" id="by" class="form-control">

					  <option></option>

<? 

$sql="SELECT a.user_id,a.fname FROM `user_activity_management` a WHERE level=3 or level=5";

advance_foreign_relation($sql,$by);	  

?>

</select></td>

                  </tr><?php */?>

                <?php /*?>  <tr>

                    <td>Dealer Name: </td>

                    <td><select name="dealer_code" id="dealer_code" class="form-control">

					  <option></option>

				<? foreign_relation('dealer_info','dealer_code','dealer_name_e',$data->dealer_code);?>

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

                  </tr><?php */?>

				 <?php /*?> <tr>

                    <td>Vendor Name: </td>

                    <td><select name="vendor_id" id="vendor_id" class="form-control">

                        <option></option>

                        <? 

						$sql = "select v.vendor_id,concat(v.vendor_name,'-',g.group_name) from vendor v,user_group g where v.group_for=g.id order by v.vendor_name";

						foreign_relation_sql($sql);?>

                    </select></td>

                  </tr><?php */?>

					

				  <?php /*?><tr><td>Status: </td>

				          <td><select name="status" id="status" class="form-control">

					  <option></option>

<? 

$sql="SELECT a.or_no,a.status FROM `warehouse_other_receive` a WHERE status='checked' or status='unchecked' or status='manual' group by status";

advance_foreign_relation($sql,$status);	  

?>

</select></td><?php */?>

			      </tr>

				  <!--<tr>

                    <td>Purchase Order No: </td>

                    <td><input  name="wo_id" type="text" id="wo_id" value=""/></td>

                  </tr>-->

                  <!--<tr>

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

</form>-->

<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>