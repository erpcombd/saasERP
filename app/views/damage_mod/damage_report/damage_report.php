<?php

session_start();

ob_start();


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Damage Advance Reports';



do_calander("#f_date");

do_calander("#t_date");

auto_complete_from_db('dealer_info','concat(dealer_code,"-",product_group,"-",dealer_name_e)','dealer_code','dealer_type in ("Distributor","Depot","Foreign")','dealer_code');

auto_complete_from_db('item_info','concat(finish_goods_code,"-",item_name)','item_id','1 and finish_goods_code>0','item_id');

?>



<form action="master_report.php" method="post" name="form1" target="_blank" id="form1">

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

                              <!--<tr>

							  <td><input name="report" type="radio" class="radio" value="3" checked="checked" /></td>

                                <td><div align="left">Depo Wise Damage Report.</div></td>

                                

                              </tr>-->

                              

                              <tr>

                                <td><input name="report" type="radio" class="radio" value="2121" /></td>

                                <td><div align="left">Item Wise Damage Report</div></td>

                              </tr>

                              <tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="1001" /></td>

                                <td width="94%"><div align="left">Date Wise Damage Report </div></td>

                              </tr>
							  <!--<tr>

                                <td><input name="report" type="radio" class="radio" value="9012104" /></td>

                                <td><div align="left">Item Wise Damage Report Monthly(Amount)</div></td>

                              </tr>-->
								<!--<tr>

                                <td><input name="report" type="radio" class="radio" value="901210400" /></td>

                                <td><div align="left">Item Wise Damage Report Monthly</div></td>

                              </tr>-->
							   <!--<tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="90121" /></td>

                                <td width="94%"><div align="left">Zone Wise Damage Report</div></td>

                              </tr>-->
							   <!--<tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="9012102" /></td>

                                <td width="94%"><div align="left">Region Wise Damage Report</div></td>

                              </tr>-->
							  <!--<tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="9012103" /></td>

                                <td width="94%"><div align="left">Area Wise Damage Report</div></td>

                              </tr>-->
							  
							  <!--<tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="9012105" /></td>

                                <td width="94%"><div align="left">Territory Wise Damage Report</div></td>

                              </tr>-->
							  
							  <!--<tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="9012106" /></td>

                                <td width="94%"><div align="left">Group Wise Damage Report (Pcs)</div></td>

                              </tr>-->
							  
							  <!--<tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="9012107" /></td>

                                <td width="94%"><div align="left">Group Wise Damage Report (Amount)</div></td>

                              </tr>-->
							  
							  <!--<tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="9012108" /></td>

                                <td width="94%"><div align="left">Party Wise Damage Report (Amount)</div></td>

                              </tr>-->
							  
							  <!--<tr>

                                <td width="6%"><input name="report" type="radio" class="radio" value="9012109" /></td>

                                <td width="94%"><div align="left">Party Wise Damage Report (Pcs)</div></td>

                              </tr>-->
							  
							  
                          </table></td>

                        </tr>

                    </table></td>

                  </tr>

              </table></td>

              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

                  <!--<tr>

                    <td>Product Sales Group :</td>

                    <td><span class="oe_form_group_cell">

                      <select name="product_group" id="product_group">

                      <option></option>

                        <? foreign_relation('item_group','group_name','group_name',$group_id);?>

                      </select>

                    </span></td>

                  </tr>-->

                  <!--<tr>

                    <td>Product Brand : </td>

                    <td><select name="item_brand" id="item_brand">

                                          <option></option>
											<? $sql="select brand_category from item_info group by brand_category";
												$query = db_query($sql);
												while($data=mysqli_fetch_object($query)){
													?>
													<option value="<?=$data->brand_category?>"><?=$data->brand_category?></option>
													<?
												}
											?>
                                        </select></td>

                  </tr>-->

                  <tr>

                    <td>Product Name : </td>

                     <td>
					<input name="item_name" list="con" id="item_name" value="<?=$item_name?>" class="form-control" >
	<datalist id=con>
		  <option></option>
		 <? foreign_relation('item_info','item_name','item_id');?>
		</datalist>
		</td>

                  </tr>

                  <tr>

                    <td>From : </td>

                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>"/></td>

                  </tr>

                  <tr>

                    <td>To : </td>

                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>"/></td>

                  </tr>

				  <!--<tr>

                    <td>Dealer Name :</td>

                    <td>

                    <input  name="dealer_code" type="text" id="dealer_code" style="width:250px;"/>                   
				 </td>

                  </tr>-->

                  <!--<tr>

                    <td>Dealer Type :</td>

                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">

                      <select name="dealer_type" id="dealer_type" style="width:150px;">

                        <option></option>

                        <option value="Distributor" >Distributor</option>

                        <option value="Depot" >Depot</option>

                        <option value="Foreign" >Foreign</option>
						 
						<option value="Depot,Distributor">Depot & Distributor</option>

                      </select>

                    </span></td>

                  </tr>-->
					<!--<tr>
				  	<td>Super Zone</td>
					<td>
						<input list="super_zones" name="super_zone" id="super_zone"/>
						<datalist id="super_zones">
							<option></option>
							<? foreign_relation('super_zone', 'super_zone_id', 'super_zone_name', $super_zone);?>
						</datalist>
						
					</td>
				  </tr>-->
				  
				  <!--<tr>
				  	<td>Region</td>
					<td>
						<input list="regions" name="region" id="region"/>
						<datalist id="regions">
							<option></option>
							<? foreign_relation('branch', 'BRANCH_ID', 'BRANCH_NAME', $region);?>
						</datalist>
						
					</td>
				  </tr>-->
				  <!--<tr>
				  	<td>Area</td>
					<td>
						<input list="areas" name="area" id="area"/>
						<datalist id="areas">
							<option></option>
							<? foreign_relation('zon', 'ZONE_CODE', 'ZONE_NAME', $area);?>
						</datalist>
						
					</td>
				  </tr>-->
				  <!--<tr>
				  	<td>Territory</td>
					<td>
						<input list="territorys" name="territory" id="territory"/>
						<datalist id="territorys">
							<option></option>
							<? foreign_relation('area', 'AREA_CODE', 'AREA_NAME', $territory);?>
						</datalist>
						
					</td>
				  </tr>-->
                  <!--<tr>

                    <td>Depot From :</td>

                    <td><span class="oe_form_group_cell" style="padding: 2px 0 2px 2px;">

                      <select name="depot_id" id="depot_id" style="width:150px;">

					  <option></option>

					  <? foreign_relation('warehouse','warehouse_id','warehouse_name',$receive_type,' use_type="SD"');?>

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

              <td><input name="submit" type="submit" class="btn" value="Report" /></td>

            </tr>

          </table>

      </div></td>

    </tr>

  </table>

</form>

<?

$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>