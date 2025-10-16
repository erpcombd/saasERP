<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Purchase Order Advence Reports';

do_calander("#f_date");
do_calander("#t_date");
auto_complete_from_db('item_info','item_name','item_id','1 and product_nature="Salable"','item_id');
?>

<form action="po_master.php" method="post" name="form1" target="_blank" id="form1">
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
                              
                              
                          </table>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <!--<tr>
                    <td>Prepared By:</td>
                    <td><select name="by" id="by" class="form-control">
            <option></option>
<? 
$sql="SELECT a.user_id,a.fname FROM `user_activity_management` a WHERE level=3 or level=5";
advance_foreign_relation($sql,$by);   
?>
</select></td>
                  </tr>-->
                  <tr>
                    <td>Product Sub Category: </td>
                    <td><select name="sub_group_id" id="sub_group_id" class="form-control" >
            <option></option>
        <? foreign_relation('item_sub_group','sub_group_id','sub_group_name',$data->sub_group_id);?>
      </select></td>
                  </tr>
                  <tr>
                    <td>Product Name: </td>
                    <td><input name="item_id" id="item_id" class="form-control" ></td>
                  </tr>
                  <tr>
                    <td>From: </td>
                    <td><input  name="f_date" type="text" id="f_date" value="<?=date('Y-m-01')?>" class="form-control" required autocomplete="off" /></td>
                  </tr>
                  <tr>
                    <td>To: </td>
                    <td><input  name="t_date" type="text" id="t_date" value="<?=date('Y-m-d')?>" class="form-control" required autocomplete="off"  /></td>
                  </tr>
          <tr>
                    <td>Vendor Name: </td>
                    <td><select name="vendor_id" id="vendor_id" class="form-control" >
                        <option></option>
                        <? 
            $sql = "select v.vendor_id,concat(v.vendor_name,'-',g.group_name) from vendor v,user_group g where v.group_for=g.id order by v.vendor_name";
            foreign_relation_sql($sql);?>
                    </select></td>
                  </tr>
          
          <tr>
            <td>Purchase Order Status:</td>
            <td><select name="status" id="status" class="form-control" >
              <option value="">All</option>
                        <option value="CHECKED">CHECKED</option>
                        <option value="UNCHECKED">UNCHECKED</option>
              <option value="DONE">DONE</option>
              </select></td>
            </tr>
          <tr>
                    <td>Purchase Order No: </td>
                    <td><input  name="wo_id" type="text" id="wo_id" value="" class="form-control" /></td>
                  </tr>
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
              <td><input name="submit" type="submit" class="btn btn-success" value="Report" /></td>
            </tr>
          </table>
      </div></td>
    </tr>
  </table>
</form>
<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>