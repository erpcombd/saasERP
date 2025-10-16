<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='Production Line Raw Setup';


if(isset($_POST['line_id']))
$line_id=$_POST['line_id'];

if($line_id<=0){
	$_POST['line_id']=$_GET['line_id'];
	$line_id=$_POST['line_id'];
}

if($_GET['id']>0 && ($_GET['delete']=='ok'))
{
	db_query("delete from production_line_raw where fg_item_id='".$_GET['id']."' and line_id='".$line_id."'");
	//db_query("delete from production_line_fg_raw where fg_custom_id='".$_GET['id']."' and line_id='".$_GET['line_id']."'");
}







if(isset($_POST['add'])&&($_POST['line_id']>0))
{

		$table		='production_line_raw';
		$crud      	=new crud($table);
		$fg_ite = explode('#>',$_REQUEST['fg_item_id']);
		$_REQUEST['fg_item_id'] = $_POST['fg_item_id'] = $fg_ite[2];
		$crud->insert();}







auto_complete_from_db('item_info i, item_sub_group s, item_group g','i.item_name','concat(i.item_name,"#>",i.item_description,"#>",i.item_id)','1 and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id and s.group_id not in (100000000)  and i.status="Active"' ,'fg_item_id');

?>



<div class="form-container_large">

    <form action="" method="post" name="cloud" id="cloud">
        <div class="d-flex justify-content-center pb-3">
            <div class="n-form1 fo-short pt-0">
                <div class="container">
                    <div class="form-group row  m-0 mt-1 pt-2 mb-1 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 col-md-3 col-lg-3 col-xl-3 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">CMU Name :  </label>
                        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9 p-0 pr-2">
                          <span class="oe_form_group_cell">
                                <input  name="line_id" type="hidden" id="line_id" value="<?=$line_id?>"/>
                                <input  name="manual_wo_id" type="text" id="manual_wo_id" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>"/>
                          </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <table class="table1  table-striped table-bordered table-hover table-sm">
            <thead class="thead1">
            <tr class="bgc-success">
                <th>Raw Materials</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody class="tbody1">
            <tr>
                <td>
                    <span id="inst_no">
                        <input name="fg_item_id" atuocomplete="off" type="text" list="fg_items" class="input3" id="fg_item_id" style="width:400px;"/>
                        <!--<datalist id="fg_items">
                           <option></option>
                           <? //foreign_relation('item_info i, item_sub_group s, item_group g','concat(i.item_name,"#>",i.item_description,"#>",i.item_id)','concat(i.item_name,"#>",i.item_description,"#>",i.item_id)',$fg_item_ids,'1 and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and i.status="Active"');?>
                        </datalist>-->
                        <input  name="wo_id" type="hidden" id="wo_id" value="<?=$wo_id?>"/>
                    </span>


                </td>

                <td><input name="add" type="submit" id="add" value="ADD" class="btn1 btn1-bg-update btn-md"/> </td>
            </tr>
            </tbody>
        </table>


        <br/>

        <table class="table1 table-striped table-bordered table-hover table-sm">
            <thead class="thead1">
                <tr class="bgc-info">
                    <th>Sl</th>
                    <th>Code</th>
                    <th>Item Name</th>
                    <th>Unit Name</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody class="tbody1">
            <?php

            $s = "Select distinct i.item_name,i.unit_name,p.fg_item_id,p.line_id from production_line_raw p, item_info i,item_sub_group s where i.item_id=p.fg_item_id and s.sub_group_id=i.sub_group_id  and p.line_id=$line_id";
            $results=db_query($s);

            while($rows=mysqli_fetch_array($results)){

                $i=$i+1;
                ?>

                <tr style="background-color:#FFF">

                    <td><?php echo $i ; ?></td>
                    <td><?php echo $rows[fg_item_id] ; ?></td>
                    <td><?php echo $rows[0] ; ?></td>

                    <td><?php echo $rows[1] ; ?></td>
                    <td><a href="../production_line/production_line_raw.php?delete=ok&id=<?=$rows[fg_item_id]?>&line_id=<?=$line_id?>">X</a></td>

                </tr>

            <?php } ?>

            </tbody>
        </table>

    </form>

</div>





<?/*>
<br>
<br>
<br>
<br>
<div class="form-container_large">
<form action="" method="post" name="cloud" id="cloud">

<table width="49%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><fieldset>

      <div>
        <label>CMU Name : </label>
        <input  name="line_id" type="hidden" id="line_id" value="<?=$line_id?>"/>
       <input  name="manual_wo_id" type="text" id="manual_wo_id" value="<?=find_a_field('warehouse','warehouse_name','warehouse_id='.$line_id)?>"/>
       </div>
      <div></div>
      <div></div>
      <div></div>
      </fieldset></td></tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
</table>
<table  width="90%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">



                      <tr>
                        <td align="center" bgcolor="#0099FF"><strong>Raw Materials </strong></td>
                        <td  rowspan="2" align="center" bgcolor="#FF0000">
						  <div class="button">
						  <input name="add" type="submit" id="add" value="ADD" tabindex="12" class="update"/>                       
						  </div>
                        </td>
                      </tr>


    <tr>

<td align="center" bgcolor="#CCCCCC">

<span id="inst_no">
    <input name="fg_item_id" atuocomplete="off" type="text" list="fg_items" class="input3" id="fg_item_id" style="width:400px;"/>
    <!--<datalist id="fg_items">
       <option></option>
       <? //foreign_relation('item_info i, item_sub_group s, item_group g','concat(i.item_name,"#>",i.item_description,"#>",i.item_id)','concat(i.item_name,"#>",i.item_description,"#>",i.item_id)',$fg_item_ids,'1 and i.sub_group_id=s.sub_group_id and s.group_id=g.group_id  and i.status="Active"');?>
    </datalist>-->
    <input  name="wo_id" type="hidden" id="wo_id" value="<?=$wo_id?>"/>
</span>

</td>
</tr>
</table>
<br/>
<br/>
<table width="90%" border="1" align="center"  style="border-collapse:collapse; border:1px solid #caf5a5;" cellpadding="2" cellspacing="2">

<tr style="background-color:#F60">
<th>Sl</th>
<th>Code</th>
<th>Item Name</th>
<th>Unit Name</th>
<th>Action</th>
</tr>

<?php 

 $s = "Select distinct i.item_name,i.unit_name,p.fg_item_id,p.line_id from production_line_raw p, item_info i,item_sub_group s where i.item_id=p.fg_item_id and s.sub_group_id=i.sub_group_id  and p.line_id=$line_id";
$results=db_query($s);

 while($rows=mysqli_fetch_array($results)){ 
 
 $i=$i+1;
 ?>

<tr style="background-color:#FFF">

<td><?php echo $i ; ?></td>
<td><?php echo $rows[fg_item_id] ; ?></td>
<td><?php echo $rows[0] ; ?></td>

<td><?php echo $rows[1] ; ?></td>
<td><a href="../production_line/production_line_raw.php?delete=ok&id=<?=$rows[fg_item_id]?>&line_id=<?=$line_id?>">X</a></td>

</tr>

<?php } ?>
</table>
</form>
</div>
<*/?>
















<script>
function deleletconfig(){
var del=confirm("Are you sure you want to delete this record?");
if (del==true){
   alert ("record deleted")
}
return del;
}
</script>









<?

require_once SERVER_CORE."routing/layout.bottom.php";
?>