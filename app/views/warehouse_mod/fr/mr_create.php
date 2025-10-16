<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
$title='New FG Req Create';

do_calander('#req_date','-1200','0');
do_calander('#need_by','0','60');


$table_master='requisition_fg_master';
$table_details='requisition_fg_order';
$unique='req_no';



if($_GET['mhafuz']>0) unset($_SESSION[$unique]);
if($_GET['req_no']>0) $_SESSION['req_no']=$_GET['req_no'];




if(isset($_POST['new'])){

   
$crud   = new crud($table_master);

		
		if(!isset($_SESSION[$unique])) {
		    
		$_POST['req_no']  = find_a_field($table_master,'max('.$unique.')','1')+1;    

		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['edit_by']=$_SESSION['user']['id'];
		$_POST['edit_at']=date('Y-m-d H:i:s');

        $$unique=$_SESSION[$unique]=$crud->insert();
	    unset($$unique);
		$type=1;
		$msg='Requisition No Created. (Req No :-'.$_SESSION[$unique].')';
	//	redirect("mr_create.php?req_no=".$_SESSION['req_no']);
		
		header("Location: mr_create.php?req_no=".$_SESSION['req_no']."");


		}else {

		    
    		$_POST['edit_by']=$_SESSION['user']['id'];
    		$_POST['edit_at']=date('Y-m-d H:i:s');
    		$crud->update($unique);
    		$type=1;
    		$msg='Successfully Updated.';
    		//redirect("mr_create.php?req_no=".$_SESSION['req_no']);
    		header("Location: mr_create.php?req_no=".$_SESSION['req_no']."");
    		
		}

} // end






$$unique=$_SESSION[$unique];






if(isset($_POST['delete'])){
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

	//redirect("mr_create.php?new=2");	
	header("Location: mr_create.php?new=2");

}






if($_GET['del']>0){

		$crud   = new crud($table_details);

		$condition="id=".$_GET['del'];		

		$crud->delete_all($condition);

		$type=1;

		$msg='Successfully Deleted.';

}




if(isset($_POST['confirmm'])){

        unset($_POST);
        $_POST[$unique]=$$unique;

		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		$_POST['status']='UNCHECKED';

		$crud   = new crud($table_master);

    // check wid
    $master_wid=find_all_field('requisition_fg_master','','req_no="'.$$unique.'"');
    //("select warehouse_id,warehouse_to from requisition_fg_master where req_no='".$$unique."'");
    $details_wid=find_all_field('requisition_fg_order','','req_no="'.$$unique.'"');
    //("select warehouse_id,warehouse_to from requisition_fg_order where req_no='".$$unique."' order by id desc limit 1");
    
    if($master_wid->warehouse_id==$details_wid->warehouse_id && $master_wid->warehouse_to==$details_wid->warehouse_to){
        $crud->update($unique);
    
       		unset($$unique);
    
    		unset($_SESSION[$unique]);
    
    		$type=1;
    
    		$msg='Successfully Forwarded for Approval.'; 
        
    }else{
        die('Error');
    }




    
    
}









if(isset($_POST['add'])&&($_POST[$unique]>0)){

  
// check do status
$req_status=find_all_field('requisition_fg_master','','req_no="'.$$unique.'"');
//if($do_status->status!='MANUAL'){redirect('mr_create.php?new=2'); exit();}

// locker user
if($req_status->entry_by != $_SESSION['user']['id']){ 
    //redirect('mr_create.php?new=2'); exit();
    header("Location: mr_create.php?new=2");exit();
    
}
  
    

		$_POST['qty']=($_POST['qty_ctn']*$_POST['pack_size'])+$_POST['qty_pcs'];

		$crud   = new crud($table_details);


		$_POST['entry_by']=$_SESSION['user']['id'];
		$_POST['entry_at']=date('Y-m-d H:i:s');
		//$_POST['edit_by']=$_SESSION['user']['id'];
		//$_POST['edit_at']=date('Y-m-d H:i:s');


// check master user info. 15-sep-24
$uinfo =find_a_field('requisition_fg_master','entry_by','req_no="'.$$unique.'"');
if($_SESSION['user']['id']!=$uinfo){
    die('Error');
    exit();
}
		

		if($_POST['qty']>0){

		    $check_old_item=find("select item_id from requisition_fg_order where req_no='".$$unique."' and item_id='".$_POST['item_id']."' ");

            if($check_old_item==''){   

                if($_POST['item_id']>0){
		            $crud->insert();
                }
            }

		    

		}

}



if($$unique>0)

{

		$condition=$unique."=".$$unique;

		$data=db_fetch_object($table_master,$condition);

		//while (list($key, $value)=each($data))
		
		    foreach ($data as $key => $value)

		{ $$key=$value;}

		

}

if($$unique>0) $btn_name='Update Requsition Information'; else $btn_name='Initiate Requsition Information';

if($_SESSION[$unique]<1)

$$unique=db_last_insert_id($table_master,$unique);



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







<div class="form-container_large">

    <form action="" method="post" name="codz" id="codz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">



        <div class="container-fluid bg-form-titel">



            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="container n-form2">
                        <div class="form-group row m-0 pb-1">

                            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req No:</div>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                <? $field = 'req_no'; ?>

                                <input name="<?= $field ?>" type="text" id="<?= $field ?>" value="<?= $$field ?>" readonly />

                            </div>
                        </div>
                        <div class="form-group row m-0 pb-1">
                            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req Date:</div>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                <? $field = 'req_date';
                                if ($req_date == '') $req_date = date('Y-m-d'); ?>

                                <input name="<?= $field ?>" type="text" id="<?= $field ?>" value="<?= $$field ?>" required readonly="" />

                            </div>
                        </div>


                        <div class="form-group row m-0 pb-1">
                            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Need within:</div>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                <? $field = 'need_by'; ?>

                                <input name="<?= $field ?>" type="text" id="<?= $field ?>" value="<?= $$field ? $$field : date('Y-m-d'); ?>" autocomplete="off" readonly />

                            </div>

                        </div>






                        <!-- 
        <div class="col-md-2">Corporate DO No:</div>

        <div class="col-md-2">

        <? $field = 'do_no'; ?>

            <input id="do_no" name="do_no" class="form-control" value="<?= $do_no ?>">

        </div> -->


                        <!-- 
        <div class="col-md-2">InterSales Req No:</div>

        <div class="col-md-2">

        <? $field = 'is_reqno'; ?>

            <input id="is_reqno" name="is_reqno" class="form-control" value="<?= $is_reqno ?>">

        </div>         -->




                        <div class="form-group row m-0 pb-1">
                            <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Note:</div>

                            <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                <? $field = 'req_note'; ?>

                                <input id="req_note" name="req_note" class="form-control" value="<?= $req_note ?>">

                            </div>



                        </div><!--end row-->


                        <!-- <div class="row from-control mt-1">

    <div class="col-md-2">Replace Receive No:</div>
    <div class="col-md-2">
        <? $field = 'replace_no'; ?>
        <input id="replace_no" name="replace_no" class="form-control" value="<?= $replace_no ?>">
    </div>

</div> -->

                        <!--end row-->

                    </div>
</div>
                    
                    <!--end row-->



                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                        <div class="container n-form2">
                            <div class="form-group row m-0 pb-1">

                                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req From:</div>


                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                    <? $field = 'warehouse_id';
                                    $table = 'warehouse';
                                    $get_field = 'warehouse_id';
                                    $show_field = 'warehouse_name'; ?>

                                    <!--      <input name="warehouse_id" type="hidden" id="warehouse_id" value="<?= $_SESSION['user']['depot'] ?>" />-->

                                    <!--<input name="warehouse_id2" type="text" id="warehouse_id2" value="<?= find_a_field('warehouse', 'warehouse_name', 'warehouse_id=' . $_SESSION['user']['depot']) ?>" readonly="" />-->

                                    <select name="warehouse_id" type="text" id="warehouse_id" required>

                                        <? if ($$field != '') { ?>
                                            <option value="<?= $$field ?>"> <?= find_a_field('warehouse', 'warehouse_name', 'warehouse_id=' . $$field); ?></option>
                                        <? } else { ?>
                                            <option></option>
                                            <? foreign_relation('warehouse_define d,warehouse w', 'w.warehouse_id', 'w.warehouse_name', $warehouse_id, 'w.warehouse_id=d.warehouse_id and d.user_id="' . $_SESSION['user']['id'] . '" '); ?>
                                        <? } ?>

                                    </select>

                                </div>
                            </div>


                            <div class="form-group row m-0 pb-1">
                                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Req To:</div>

                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                    <? $field = 'warehouse_to';
                                    $table = 'warehouse';
                                    $get_field = 'warehouse_id';
                                    $show_field = 'warehouse_name'; ?>

                                    <select name="warehouse_to" id="warehouse_to" required <? if ($_SESSION[$unique] > 0) { ?> readonly <? } ?>>

                                        <? if ($$field != '') { ?>
                                            <option value="<?= $$field ?>"><?= find_a_field('warehouse', 'warehouse_name', 'warehouse_id=' . $$field); ?></option>
                                        <? } else { ?>

                                            <option></option>

                                            <?
                                            foreign_relation('warehouse', 'warehouse_id', 'warehouse_name', '', '1 and warehouse_id!="' . $_SESSION['user']['depot'] . '"');

                                            ?>
                                        <? } ?>

                                    </select>

                                </div>
                            </div>


                            <div class="form-group row m-0 pb-1">
                                <div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Company:</div>

                                <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0 pr-2">

                                    <? $field = 'group_for'; ?>

                                    <select id="group_for" name="group_for" class="form-control" required>

                                        <? if ($$field > 0) { ?>

                                            <option value="<?= $$field ?>"><?= find_a_field('user_group', 'group_name', 'id=' . $$field); ?></option>

                                        <? } else { ?>

                                            <option></option>

                                            <? foreign_relation('user_group', 'id', 'group_name', $group_for, '1 order by group_name'); ?>

                                        <? } ?>

                                    </select>

                                </div>

                            </div>




                        </div>

                    </div><!--end row-->


                    </div>








                    <div class="n-form-btn-class">

                       

                            <input name="new" type="submit" class="btn1 btn1-bg-submit" value="<?= $btn_name ?>" />

                        

                    </div><!--end row-->







                <!--end container-->


            </div>                                
    </form>

</div>






<? if($_SESSION[$unique]>0){

// check real user
$real_user = find_a_field('requisition_fg_master','entry_by','req_no='.$_SESSION[$unique]);
// if($real_user != $_SESSION['user']['id']){
//     unset($$unique); unset($_SESSION[$unique]); $type=1;
//     //redirect('mr_create.php');
//     header("Location: mr_create.php");
//     die('error');
// }
?>

<form action="?<?=$unique?>=<?=$$unique?>" method="post" name="cloud" id="cloud">
     <div class="container-fluid pt-5 p-0 ">

<table class="table1  table-striped table-bordered table-hover table-sm">
    <thead class="thead1">
    
<tr class="bgc-info">

<td align="center" bgcolor="#015b93"><strong>Item Code</strong></td>

<td align="center" bgcolor="#015b93"><strong>Item Name</strong></td>

<td align="center" bgcolor="#015b93"><strong>Pack Size</strong></td>

<td align="center" bgcolor="#015b93"><strong>Unit </strong></td>

<td align="center" bgcolor="#015b93"><strong>Stock of <?=find_a_field('warehouse','warehouse_name','warehouse_id='.$warehouse_id);?> </strong></td>

<td align="center" bgcolor="#015b93"><strong>Ctn</strong></td>

<td align="center" bgcolor="#015b93"><strong>Pcs</strong></td>

<td align="center" bgcolor="#015b93"><strong>Note</strong></td>
<td align="center" bgcolor="#015b93"><strong>Action</strong></td>





</tr>
</thead>


 <tbody class="tbody1">
<tr>

<td align="center" bgcolor="#CCCCCC">

<input  name="<?=$unique?>"i="i" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

<input  name="warehouse_id" type="hidden" id="warehouse_id" value="<?=$warehouse_id?>"/>

<input  name="sub_depot" type="hidden" id="sub_depot" value="<?=$sub_depot?>"/>

<input  name="warehouse_to" type="hidden" id="warehouse_to" value="<?=$warehouse_to?>"/>

<input  name="req_date" type="hidden" id="req_date" value="<?=$req_date?>"/>



<input list="items" name="item_id" type="text" class="input3"  value="" id="item_id" style="width:100px;" onChange="getData()" autocomplete="off" required autofocus/>

 <datalist id="items">

<?=foreign_relation('item_info','item_id','concat(finish_goods_code," # ",item_name)',$item_id,'1 and group_for="'.$group_for.'" order by item_name');?>    


 </datalist>

</td>


<td align="center" bgcolor="#CCCCCC"><input name="item_name" type="text" class="input3" id="item_name"  style="width:250px;" readonly="readonly"/></td>

<td align="center" bgcolor="#CCCCCC"><input name="pack_size" type="text" class="input3" id="pack_size"  style="width:80px;" readonly="readonly"/></td>



<td align="center" bgcolor="#CCCCCC"><input name="unit_name" type="text" class="input3" id="unit_name"  style="width:50px;" onfocus="focuson('qty_ctn')" readonly="readonly"/></td>

<td align="center" bgcolor="#CCCCCC"><input type="text" class="input3" id="stock"  style="width:80px;" readonly="readonly"/></td>



<td align="center" bgcolor="#CCCCCC"><input name="qty_ctn" type="text" class="input3" id="qty_ctn"  maxlength="100" style="width:100px;" value="0" required/></td>

<td align="center" bgcolor="#CCCCCC"><input name="qty_pcs" type="text" class="input3" id="qty_pcs"  maxlength="100" style="width:100px;" required/></td>

<td align="center" bgcolor="#CCCCCC"><input name="item_note" type="text" class="input3" id="item_note"  style="width:190px;" /></td>

      <td>

<div class="button">

<input name="add" type="submit" id="add" value="ADD" tabindex="12" class="btn1 btn1-bg-submit"/>                       

</div></td>

      </tr>
    </tbody>
    </table>

<br/><br/><br/><br/>







<? 

//echo link_report_add_del_auto($res,1,6,7,8);

?>









<script language="javascript">



function upAmt(id){

    

    psize   =document.getElementById('psize_'+id).value*1;

    pctn    =document.getElementById('pctn_'+id).value*1;

    ppcs    =document.getElementById('ppcs_'+id).value*1;

 

    num =(psize*pctn)+ppcs;

    document.getElementById('ptotal_'+id).value = num;

}



</script>



<script>



function getXMLHTTP() { //fuction to return the xml http object



		var xmlhttp=false;	



		try{



			xmlhttp=new XMLHttpRequest();



		}



		catch(e)	{		



			try{			



				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");

			}

			catch(e){



				try{



				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");



				}



				catch(e1){



					xmlhttp=false;



				}



			}



		}



		 	



		return xmlhttp;



    }





function update_value(id){



var item_id=id;

var req_no=<?=$$unique;?>



var psize=(document.getElementById('psize_'+id).value)*1; 

var pctn=(document.getElementById('pctn_'+id).value)*1; 

var ppcs=(document.getElementById('ppcs_'+id).value)*1; 

var ptotal=(document.getElementById('ptotal_'+id).value)*1; 





var strURL="ajax_req_update.php?item_id="+item_id+"&req_no="+req_no+"&psize="+psize+"&pctn="+pctn+"&ppcs="+ppcs+"&ptotal="+ptotal;



		var req = getXMLHTTP();



		if (req) {



			req.onreadystatechange = function() {

				if (req.readyState == 4) {

					// only if "OK"

					if (req.status == 200) {						

						document.getElementById('divi_'+id).style.display='inline';

						document.getElementById('divi_'+id).innerHTML=req.responseText;						

					} else {

						alert("There was a problem while using XMLHTTP:\n" + req.statusText);

					}

				}				

			}

			req.open("GET", strURL, true);

			req.send(null);

		}	

}

</script>



<div class="container-fluid pt-5 p-0 ">

<table class="table table-striped table-bordered table-hover table-sm" width="100%" border="0" cellspacing="0" cellpadding="0">
    
      <thead class="thead1">

<tr class="bgc-info">

<th>S/L</th>

<th>FG Code</th>

<th>Item Name</th>

<th>Pack Size</th>

<th>Unit Name</th>

<th>Ctn</th>

<th>Pcs</th>

<th>Total Pcs</th>

<th>Note</th>

<th>Action</th>

<th>X</th>

</tr>
</thead>

<tbody class="tbody1">
<?

$sl=1;

 $res='select a.id, b.finish_goods_code as fg_code, concat(b.item_name) as item_name,b.pack_size,a.unit_name, 

(a.qty DIV b.pack_size) as ctn,(a.qty MOD b.pack_size) as pcs,a.qty as Total_Pcs,a.item_note as note,"x" 



from requisition_fg_order a,item_info b 

where b.item_id=a.item_id and a.req_no='.$req_no;

$query=db_query($res);

while($info=mysqli_fetch_object($query)){

?>

<tr>

    <td><?=$sl++?></td>

    <td><?=$info->fg_code?></td>

    <td><?=$info->item_name?></td>

    

    

    <td><? //=$info->pack_size?>

    <input name="psize_<?=$info->id?>" id="psize_<?=$info->id?>" type="text" class="ctt_amt" value="<? echo $info->pack_size;?>" readonly/>

    </td>

    

    <td><?=$info->unit_name?></td>

    <td>

        <? //=$info->ctn; $gctn+=$info->ctn;?>

        <input name="pctn_<?=$info->id?>" id="pctn_<?=$info->id?>" type="number" min="0" class="ctt_amt" value="<? echo $info->ctn;?>" onChange="upAmt(<?=$info->id?>)" />

    </td>

    <td>

        <? //=$info->pcs; $gpcs+=$info->pcs;?>

        <input name="ppcs_<?=$info->id?>" id="ppcs_<?=$info->id?>" type="number" min="0" class="ctt_amt" value="<? echo $info->pcs;?>" onChange="upAmt(<?=$info->id?>)" />

    </td>

    <td>

        <? //=$info->Total_Pcs; $gtotal+=$info->Total_Pcs;?>

       <input name="ptotal_<?=$info->id?>" id="ptotal_<?=$info->id?>" type="text"  class="ctt_amt" value="<? echo $info->Total_Pcs;?>" readonly /> 

    </td>

    

    

    <td><?=$info->note?></td>



<td>

    <span id="divi_<?=$info->id?>">

    <input type="button" class="btn" name="Button2" value="Update" onclick="update_value(<?=$info->id?>)" />

    </span>

</td>    

    <td><a href="?del=<?=$info->id;?>"><i class="fa fa-trash" style="color:red"></i></a></td>

</tr>

<? } ?>

<tr style="font-weight:700;">

    <td colspan="5"><div  align="right">Total:</div> </td>

    <td><?=$gctn?></td>

    <td><?=$gpcs?></td>

    <td><?=$gtotal?></td>

    <td></td>

    <td></td>

</tr>


  </tbody>
</table>

</div>

</form>















<form action="" method="post" name="cz" id="cz" onSubmit="if(!confirm('Are You Sure Execute this?')){return false;}">
    
    <div class="n-form-btn-class">
				<input name="delete" type="submit" class="btn1 btn1-bg-cancel" value="DELETE"  />
				
				<input name="confirmm" type="submit" class="btn1 btn1-bg-submit" value="Submit For Approval"  />
            </div>


 
</form>

<? }?>

</div>

















<script>

function getData(){

    

var id = document.getElementById("item_id").value;



		jQuery.ajax({

			url:'ajax_requisition.php',

			type:'post',

			data:'id='+id,

			success:function(result){

				var json_data=jQuery.parseJSON(result);



				jQuery('#item_name').val(json_data.item_name);

				jQuery('#unit_name').val(json_data.unit);

                jQuery('#pack_size').val(json_data.pack_size);

                jQuery('#stock').val(json_data.stock);

			}



		})

	

}

</script> 



<script>$("#codz").validate();$("#cloud").validate();</script>

<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>