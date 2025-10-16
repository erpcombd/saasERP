<?php






require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





$title='Product Advance Reports';











do_calander("#f_date");





do_calander("#t_date");





auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type="Distributor" and canceled="Yes"','dealer_code');





?>













<div class="d-flex justify-content-center">

    <form class="n-form1 pt-4" action="master_report.php" method="post" name="form1" target="_blank" id="form1">

        <div class="row m-0 p-0">

            <div class="col-sm-5">

                <div align="left">Select Report </div>

                <!--<div class="form-check">

                    <input name="report" type="radio" class="radio1" id="report1-btn" value="8888" checked="checked" tabindex="1"/>

                    <label class="form-check-label p-0" for="report1-btn">

                        Product Price Setup Information

                    </label>

                </div>-->

                <div class="form-check">

                   <!-- <input name="report" type="radio" class="radio1" id="report2-btn"  value="888833"  tabindex="2"/> -->

					<input name="report" type="radio" class="radio1" id="report2-btn"  value="888811"  tabindex="2" checked/>

                    <label class="form-check-label p-0" for="report2-btn">

                        Product Information Report

                    </label>

                </div>

				

				<div class="form-check">

                   <!-- <input name="report" type="radio" class="radio1" id="report2-btn"  value="888833"  tabindex="2"/> -->

					<input name="report" type="radio" class="radio1" id="report2-btn"  value="2019"  tabindex="2"/>

                    <label class="form-check-label p-0" for="report2-btn">

                        Barcode Print Report

                    </label>

                </div>



            </div>



            <div class="col-sm-7">

                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Form</label>

                    <div class="col-sm-8 p-0">

                        <input class="m-0" name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/>

                    </div>

                </div>



                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">To</label>

                    <div class="col-sm-8 p-0">

                        <input  class="m-0" name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/>

                    </div>

                </div>





                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Item Name</label>

                    <div class="col-sm-8 p-0">

                      <span class="oe_form_group_cell">

                        <select name="item_id" id="item_id">

                          <option></option>

<?=foreign_relation('item_info i, item_sub_group b,item_group g','i.item_id','i.item_name',$item_id,'b.sub_group_id=i.sub_group_id and b.group_id=g.group_id and g.group_name like "%FIXED ASSET%"');?>



                      </select>
				

                      </span>



                    </div>

                </div>



                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Group</label>

                    <div class="col-sm-8 p-0">



                        <span class="oe_form_group_cell">



                          <select name="group_id" id="group_id" tabindex="3" onchange="getData2('item_sub_group_ajax.php', 'item_sub_group', this.value,document.getElementById('group_id').value);">


<? foreign_relation('item_group','group_id','group_name',$_POST['item_group'],'group_name like "%FIXED ASSET%" order by group_name');?>



                          </select>



                        </span>





                    </div>

                </div>





                <div class="form-group row m-0 mb-1 pl-3 pr-3">

                    <label for="group_for" class="col-sm-4 m-0 p-0 d-flex align-items-center">Product Sub Group</label>

                    <div class="col-sm-8 p-0">

                        <span class="oe_form_group_cell">



                              <select name="item_sub_group" tabindex="4">



                      <? foreign_relation('item_sub_group s,item_group g','s.sub_group_id','s.sub_group_name',$PBI_ORG,'s.group_id=g.group_id and g.group_name like "%FIXED ASSET%" ');?>



                              </select>





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









































<?php /*?><form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

  <table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>

      <td><div class="box4">

          <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

            <tr>

              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>

                          <td><table width="100%" border="0" cellspacing="0" cellpadding="0">

                              <tr>

                                <td colspan="2" class="title1"><div align="left">Select Report </div></td>

                              </tr>

                              <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="1" tabindex="1"/></td>

                                <td><div align="left">Finish Good Product List</div></td>

                              </tr>-->

							  

							  

							<!--  <tr>

                                <td><input name="report" type="radio" class="radio" value="888" tabindex="2"/></td>

                                <td><div align="left">Product Information (Rate Changable)</div></td>

                              </tr>-->

							  

							  

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="8888" checked="checked" tabindex="1"/></td>

                                <td><div align="left">Product Price Setup Information</div></td>

								

                              </tr>

							  <tr>

							  

							  <td><input name="report" type="radio" class="radio" value="888833"  tabindex="2"/></td>

                                <td><div align="left">Product Information Report</div></td>

							  </tr>

							  

							  <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="118888"  tabindex="2"/></td>

                                <td><div align="left">Product Information (MINWAL)</div></td>

                              </tr>-->

							  

							  

							 <!-- <tr>

                                <td><input name="report" type="radio" class="radio" value="888811" tabindex="2"/></td>

                                <td><div align="left">Turky Sajjada & Swadie Item</div></td>

                              </tr>

							  

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="888822" tabindex="2"/></td>

                                <td><div align="left">Zadi Item Information</div></td>

                              </tr>

							  

							  <tr>

                                <td><input name="report" type="radio" class="radio" value="888833" tabindex="2"/></td>

                                <td><div align="left">Minwal Carpet Item List</div></td>

                              </tr>-->

							  

							  

							  <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="888898" tabindex="2"/></td>

                                <td><div align="left">Warehouse Report</div></td>

                              </tr>-->

							  

							  <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="8889" tabindex="2"/></td>

                                <td><div align="left">Product Rate Change Information</div></td>

                              </tr>-->

							  

							  

							  

							 <!-- <tr>

                                <td><input name="report" type="radio" class="radio" value="8890" tabindex="2"/></td>

                                <td><div align="left">Area and Transport Changes Information</div></td>

                              </tr>-->

							  

							  

							  <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="889" tabindex="2"/></td>

                                <td><div align="left">Product Mesh Size Information </div></td>

                              </tr>-->

							  

		              

							  

							  <!--<tr>





                                <td width="6%"><input name="report" type="radio" class="radio" value="2" /></td>





                                <td width="94%"><div align="left">Product List Details</div></td>





                              </tr>





                              <tr>





                                <td width="6%"><input name="report" type="radio" class="radio" value="3" /></td>





                                <td width="94%"><div align="left">Price List Details</div></td>





                              </tr>-->

                            </table></td>

                        </tr>

                      </table></td>

                  </tr>

                </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                  

                  <!--<tr>

                    <td>Product Nature :</td>

                    <td><span id="branch" class="oe_form_group_cell">

                      <select name="product_nature" id="product_nature">

                        <option></option>

                        <option value="Salable">Salable</option>

                        <option value="Purchasable">Purchasable</option>

                        <option value="Both">Both</option>

                      </select>

                      </span></td>

                  </tr>-->

				  

				  <tr>

                    <td>From :</td>

                    <td><span class="oe_form_group_cell">

                      <input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" style="width:250px"/>

                      </span></td>

                  </tr>

				  

				  <tr>

                    <td>To :</td>

                    <td><span class="oe_form_group_cell">

                      <input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" style="width:250px"/>

                      </span></td>

                  </tr>

				  

				  

				  

				   <tr>

                    <td>Item Name :</td>

                    <td><span class="oe_form_group_cell">

                      <select name="item_id" id="item_id"  style="width:250px;">

					  	<option></option>

						<?=foreign_relation('item_info','item_id','item_name','1');?>

					  </select>

                      </span>

                    </td>

                  </tr>

				  

				  

				  <tr>



                    <td>Product Group :</td>



                    <td>

                        <span class="oe_form_group_cell">



                      <select name="group_id" id="group_id"  style="width:250px" tabindex="3" onchange="getData2('item_sub_group_ajax.php', 'item_sub_group', this.value, 



document.getElementById('group_id').value);">



                        <option></option>



                        <? foreign_relation('item_group','group_id','group_name',$group_id,' 1');?>



                      </select>



                      </span>

                    </td>



                  </tr>

				  

				  

				  <tr>



                    <td>Product Sub Group :</td>



                    <td>

                        <span class="oe_form_group_cell">

					

					<span id="item_sub_group">



                      <select name="item_sub_group" id="item_sub_group" tabindex="4"  style="width:250px">



                        <option></option>



                        <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$item_sub_group, '1');?>



                      </select>



                      </span>

                        </span>

                    </td>



                  </tr>

				  

				  <!--<tr>

                    <td>Concern Name :</td>

                    <td><span class="oe_form_group_cell">

                      <select name="group_for" id="group_for" tabindex="5">

                        <option></option>

                        <? foreign_relation('user_group','id','group_name',$group_for);?>

                      </select>

                      </span></td>

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

              <td><input name="submit" type="submit" class="btn1 btn1-bg-submit" value="Report" tabindex="6" /></td>

            </tr>

          </table>

        </div></td>

    </tr>

  </table>

</form><?php */?>

<?





require_once SERVER_CORE."routing/layout.bottom.php";



?>

