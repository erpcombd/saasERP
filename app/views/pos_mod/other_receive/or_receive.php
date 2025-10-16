<?php
session_start();
ob_start();
require_once "../../../assets/template/layout.top.php";
$title='New Other Receive';
$page_for = 'Other Receive';

/*if($_SESSION['user']['group']=='4'){
do_calander('#or_date','-360','0');
}
do_calander('#or_date','-5','0');
do_calander('#quotation_date');*/

$din = find_a_field('menu_warehouse','other_receive','id="'.$_SESSION['user']['group'].'"');
if($din>0){$din=$din;}else{$din=60;}
do_calander('#or_date');

$table_master='warehouse_other_receive';
$table_details='warehouse_other_receive_detail';
$unique='or_no';


if(isset($_POST['new']))
{
		$crud   = new crud($table_master);

		if(!isset($_SESSION[$unique])) {
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$$unique=$_SESSION[$unique]=$crud->insert();
		unset($$unique);
		$type=1;
		$msg=$title.'  No Created. (No :-'.$_SESSION[$unique].')';
		}
		else {
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$crud->update($unique);
		$type=1;
		$msg='Successfully Updated.';
		}
}

$$unique=$_SESSION[$unique];

if(isset($_POST['delete']))
{
		$crud   = new crud($table_master);
		$condition=$unique."=".$$unique;		
		$crud->delete($condition);
		$crud   = new crud($table_details);
		$condition=$unique."=".$$unique;		
		$crud->delete_all($condition);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Deleted.';
}

if($_GET['del']>0)
{
		$crud   = new crud($table_details);
		$condition="id=".$_GET['del'];		
		$crud->delete_all($condition);
		
		$sql = "delete from journal_item where tr_from = '".$page_for."' and tr_no = '".$_GET['del']."'";
		mysql_query($sql);
		$type=1;
		$msg='Successfully Deleted.';
		
}
if(isset($_POST['confirmm']))
{
		unset($_POST);
		$_POST[$unique]=$$unique;
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['status']='UNCHECKED';
		$crud   = new crud($table_master);
		$crud->update($unique);
		unset($$unique);
		unset($_SESSION[$unique]);
		$type=1;
		$msg='Successfully Forwarded.';
}

if(isset($_POST['add'])&&($_POST[$unique]>0))
{
		$crud   = new crud($table_details);
		$iii=explode('#>',$_POST['item_id']);
		$_POST['item_id']=$iii[1];
		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d h:s:i');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d h:s:i');
		$xid = $crud->insert();
		//journal_item_control($_POST['item_id'] ,$_SESSION['user']['depot'],$_POST['or_date'],$_POST['qty'],0,$page_for,$xid,$_POST['rate']);
}

if($$unique>0)
{
		$condition=$unique."=".$$unique;
		$data=db_fetch_object($table_master,$condition);
		while (list($key, $value)=each($data))
		{ $$key=$value;}
		
}
if($$unique>0) $btn_name='Update PO Information'; else $btn_name='Initiate PO Information';
if($_SESSION[$unique]<1)
$$unique=db_last_insert_id($table_master,$unique);

//auto_complete_from_db($table,$show,$id,$con,$text_field_id);
$depot_type = find_a_field('warehouse','use_type','warehouse_id="'.$_SESSION['user']['depot'].'"');


auto_complete_from_db('item_info','concat(item_name,"#>",item_id)','concat(item_name,"#>",item_id)','1','item_id');
?>
<script language="javascript">
function focuson(id) {
  if(document.getElementById('item_id').value=='')
  document.getElementById('item_id').focus();
  else
  document.getElementById(id).focus();
}
window.onload = function() {
if(document.getElementById("warehouse_id").value>0)
  document.getElementById("item_id").focus();
  else
  document.getElementById("req_date").focus();
}
</script>
<script language="javascript">
function count()
{
var num=((document.getElementById('qty').value)*1)*((document.getElementById('rate').value)*1);
document.getElementById('amount').value = num.toFixed(2);	
}
</script>





    <div class="form-container_large">
        <form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
            <div class="container-fluid bg-form-titel">
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="container n-form2">

                            <fieldset>

                                <? $field='or_no';?>
                                <div class="form-group row m-0 pb-1">
                                    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">OR  No:</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>"/>
                                    </div>
                                </div>

                                <? $field='or_date'; if($or_date=='') $or_date =date(''); ?>
                                <div class="form-group row m-0 pb-1">
                                    <label for="<?=$field?>"class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">OR Date :</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" readonly="readonly" required/>

                                                            <!--<select name="<?=$field?>" id="<?=$field?>" required />
                                            <? for($i=0;$i<20;$i++){?>
                                            <option><?=date('Y-m-d',time()-(24*60*60*$i));?></option>
                                            <? }?>
                                            </select>-->
                                    </div>
                                </div>

                                <? $field='requisition_from';?>
                                <div class="form-group row m-0 pb-1">
                                    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Requisition From :</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
                                    </div>
                                </div>


                                <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$_SESSION['user']['depot']?>"  required/>
                                <input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
                            </fieldset>

                        </div>



                    </div>


                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 ">
                        <div class="container n-form2">

                            <fieldset>

                                <? $field='or_subject';?>
                                <div class="form-group row m-0 pb-1">
                                    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Slip No :</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
                                    </div>
                                </div>


                                <? $field='vendor_name'; ?>
                                <div class="form-group row m-0 pb-1">
                                    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Receive From :</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required="required"/>
                                    </div>
                                </div>


                                <? $field='approved_by';?>
                                <div class="form-group row m-0 pb-1">
                                    <label for="<?=$field?>" class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Approved By :</label>
                                    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">
                                        <input  name="<?=$field?>" type="text" id="<?=$field?>" value="<?=$$field?>" required/>
                                    </div>
                                </div>





                            </fieldset>



                        </div>






                    </div>

                </div>

                <div class="n-form-btn-class">
                    <input name="new" type="submit" class="btn1 btn1-bg-submit" value="<?=$btn_name?>">
                </div>
            </div>

            <!--return Table design start-->
            <div class="container-fluid pt-5 p-0 ">

            </div>

        </form>



        <? if($_SESSION[$unique]>0){?>
        <form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
            <!--Table input one design-->
            <div class="container-fluid pt-5 p-0">
                <table class="table1  table-striped table-bordered table-hover table-sm">
                    <thead class="thead1">
                    <tr class="bgc-info">
                        <th>Item Name</th>

                        <th>Stock</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody class="tbody1">

                    <tr>
                        <td align="center">
                            <input  name="receive_type" type="hidden" id="receive_type" value="<?=$page_for?>"  required="required"/>
                            <input  name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>
                            <input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>
                            <input  name="or_date" type="hidden" id="or_date" value="<?=$or_date?>"/>
                            <input  name="vendor_name" type="hidden" id="vendor_name" value="<?=$vendor_name?>"/>
                            <input  name="item_id" type="text" id="item_id" value="<?=$item_id?>"  required onblur="getData2('or_receive_ajax.php', 'po',this.value,document.getElementById('warehouse_id').value);"/></td>
                        <td colspan="3" align="center">
<span id="po">
<input name="stk" type="text" class="input3" id="stk" style="width:50px;" readonly="readonly"/>
<input name="unit" type="text" class="input3" id="unit" style="width:50px;" readonly="readonly"/>
<input name="price" type="text" class="input3" id="price" style="width:50px;"  readonly="readonly"/>
</span></td>
                        <td align="center"><input name="qty" type="text" class="input3" id="qty"  maxlength="100" onchange="count()" required/></td>
                        <td align="center"><input name="amount" type="text" class="input3" id="amount"  readonly="readonly" required/></td>
                        <td><input name="add" type="submit" id="add" class="btn1 btn1-bg-submit" value="ADD"></td>
                    </tr>

                    </tbody>
                </table>



            </div>




            <!--Data multi Table design start-->
            <div class="container-fluid pt-5 p-0 ">

                <div class="tabledesign2 border-0">
                    <?
                    $res='select a.id,b.item_name,a.rate as unit_price,a.qty ,a.unit_name,a.amount,"x" from warehouse_other_receive_detail a,item_info b where b.item_id=a.item_id and a.or_no='.$or_no;
                    echo link_report_add_del_auto($res,'',1,5);
                    ?>
                </div>

            </div>
        </form>



        <!--button design start-->
        <form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
            <div class="container-fluid p-0 ">

                <div class="n-form-btn-class">

                    <input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="CONFIRM AND FORWARD OR"/>
                </div>

            </div>
        </form>

        <?}?>
    </div>





<script>$("#codz").validate();$("#cloud").validate();</script>
<?
require_once "../../../assets/template/layout.bottom.php";
?>