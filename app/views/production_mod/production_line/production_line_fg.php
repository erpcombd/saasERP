<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$title='Production Line Finish Goods';



if(isset($_POST['line_id']))

$line_id=$_POST['line_id'];



if($_GET['del']>0)

{

		$line_id = find_a_field('production_line_fg','line_id','id='.$_GET['del']);

		$crud   = new crud('production_line_fg');

		$condition="id=".$_GET['del'];		

		$crud->delete_all($condition);

		$type=1;

		$msg='Successfully Deleted.';

}



if(isset($_POST['add'])&&($_POST['line_id']>0))

{

		$table		='production_line_fg';

		$crud      	=new crud($table);

$item_id = explode('#>', $_POST['fg_item_id']);

echo $_POST['fg_item_id']=$item_id[2];

		$crud->insert();

}


//auto_complete_from_db('item_info i, item_sub_group s, item_group g','i.item_name','concat(i.item_name,"#>",i.item_description,"#>",i.item_id)','1 and i.sub_group_id=s.sub_group_id and g.group_id in (1005000100000000)  and s.group_id=g.group_id and i.status="Active"' ,'fg_item_id');





?>








    <div class="form-container_large">

        <form action="" method="post" name="cloud" id="cloud">
            <div class="d-flex justify-content-center pb-3">
                <div class="n-form1 fo-short pt-0">
                    <div class="container">
                        <div class="form-group row  m-0 mt-1 pt-2 mb-1 pl-3 pr-3">
                            <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Production Line Name : </label>
                            <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                                <input  name="line_id" type="hidden" id="line_id" value="<?=$line_id?>"/>
                                <input  name="manual_wo_id" type="text" id="manual_wo_id" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>"/>

                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <table class="table1  table-striped table-bordered table-hover table-sm">
                <thead class="thead1">
                <tr class="bgc-success">
                    <th>Finish Goods</th>
                    <th>Hourly Produce</th>
                    <th>Unit Name</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody class="tbody1">

                <tr>

                    <td>
                        <span id="inst_no">
                        <input name="fg_item_id" type="text" list="fg_item_ids" id="fg_item_id"   autocomplete="off" required onblur="getData2('pl_ajax.php', 'pl',this.value,'');"/>
                            <datalist id="fg_item_ids">
                                <option></option>
                                 <? foreign_relation('item_info i, item_sub_group s, item_group g','concat(i.item_name,"#>",i.item_description,"#>",i.item_id)','concat(i.item_name,"#>",i.item_description,"#>",i.item_id)',$fg_item_ids,'1 and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id   and i.status="Active"');?>
                            </datalist>

                        <input  name="wo_id" type="hidden" id="wo_id" value="<?=$wo_id?>"/>
                        </span>
                    </td>

                    <td><input name="hourly_production" type="text" id="hourly_production"/></td>

                    <td><span id="pl"><input name="unit_name" type="text"  id="unit_name"/></span></td>

                    <td> <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="btn1 btn1-bg-update btn-md" /> </td>
                </tr>

                </tbody>
            </table>

            <br/>

            <table class="table1 table-striped table-bordered table-hover table-sm">

                <?
                $res='select a.id,c.finish_goods_code as code,c.item_name,a.hourly_production,a.unit_name,"X" from production_line_fg a,warehouse b,item_info c where b.warehouse_id=a.line_id and c.item_id=a.fg_item_id and b.warehouse_id='.$line_id;
                ?>

<!--                <thead class="thead1">-->
<!--                <tr class="bgc-info">-->
<!--                    <th>Sl</th>-->
<!--                    <th>Code</th>-->
<!--                    <th>Item Name</th>-->
<!--                    <th>Unit Name</th>-->
<!--                    <th>Action</th>-->
<!--                </tr>-->
<!--                </thead>-->

                <tbody class="tbody1">

                    <?
                    //$res='select * from tbl_receipt_details where rec_no='.$str.' limit 5';
                    echo link_report_del($res);
                    ?>

                </tbody>
            </table>

        </form>

    </div>








<?/*>
<br>
<br>
<br>

<div class="form-container_large">
<form action="" method="post" name="cloud" id="cloud">



<table width="49%" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr>

    <td><fieldset>

      <div>

        <label>Production Line Name : </label>

        <input  name="line_id" type="hidden" id="line_id" value="<?=$line_id?>"/>

        <input  name="manual_wo_id" type="text" id="manual_wo_id" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>"/>

        </div>

      <div></div>

      <div></div>

      

      <div></div>

      </fieldset></td>

    </tr>

  <tr>

    <td>&nbsp;</td>

    </tr>

</table>

<table  width="70%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

                      <tr>

                        <td align="center" bgcolor="#0099FF"><strong>Finish Goods </strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Hourly Produce</strong></td>

                        <td align="center" bgcolor="#0099FF"><strong>Unit Name</strong></td>

                        <td  rowspan="2" align="center" bgcolor="#FF0000">

						  <div class="button">

						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       

						  </div>				        </td>

      </tr>

                      <tr>

<td align="center" bgcolor="#CCCCCC"><span id="inst_no">



<input name="fg_item_id" type="text" list="fg_item_ids" class="input3" id="fg_item_id" style="width:400px;"  autocomplete="off" required onblur="getData2('pl_ajax.php', 'pl',this.value,'');"/><datalist id="fg_item_ids">
   <option></option>
   <? foreign_relation('item_info i, item_sub_group s, item_group g','concat(i.item_name,"#>",i.item_description,"#>",i.item_id)','concat(i.item_name,"#>",i.item_description,"#>",i.item_id)',$fg_item_ids,'1 and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and g.group_id in (500000000,300000000,400000000) and i.status="Active"');?>
</datalist>

<input  name="wo_id" type="hidden" id="wo_id" value="<?=$wo_id?>"/>

</span></td>

<td bgcolor="#CCCCCC"><input name="hourly_production" type="text" class="input3" id="hourly_production" style="width:110px;"/></td>

<td bgcolor="#CCCCCC"><span id="pl"><input name="unit_name" type="text" class="input3" id="unit_name" style="width:100px;"/></span></td>

</tr>

    </table><br /><br /><br />



<? 

 $res='select a.id,c.finish_goods_code as code,c.item_name,a.hourly_production,a.unit_name,"X" from production_line_fg a,warehouse b,item_info c where b.warehouse_id=a.line_id and c.item_id=a.fg_item_id and b.warehouse_id='.$line_id;

?>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">



    <tr>

      <td><div class="tabledesign2">

        <? 

//$res='select * from tbl_receipt_details where rec_no='.$str.' limit 5';

echo link_report_del($res);

		?>



      </div></td>

    </tr>

	    	

	



				

    <tr>

     <td>



 </td>

    </tr>

  </table>

</form>
</div>

    <*/?>



<?
$main_content=ob_get_contents();

ob_end_clean();

require_once SERVER_CORE."routing/layout.bottom.php";

?>