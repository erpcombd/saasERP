<?php


 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$now=time();

$title='Production Line Setup';

$tr_type="Show";

$unique='warehouse_id';

$unique_field='warehouse_name';

$table='warehouse';

$page="production_line.php";

$user_group_define=find_a_field('company_define ','GROUP_CONCAT(company_id ORDER BY company_id ASC)','user_id="'.$_SESSION['user']['id'].'" and status="Active"');



function createSubLedger($code,$name,$tr_from,$tr_id,$ledger_id,$type){

$insert = 'insert into general_sub_ledger set sub_ledger_id="'.$code.'",sub_ledger_name="'.$name.'",tr_from="'.$tr_from.'",tr_id="'.$tr_id.'",ledger_id="'.$ledger_id.'",type="'.$type.'",entry_at="'.date('Y-m-d H:i:s').'",entry_by="'.$_SESSION['user']['id'].'",group_for="'.$_SESSION['user']['group'].'"';
db_query($insert);
return db_insert_id();

}

$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$unique_field]))

{

$$unique = $_POST[$unique];

//for Record..................................



if(isset($_POST['record']))



{		

$_POST['entry_at']=time();

$_POST['entry_by']=$_SESSION['user']['id'];

$custome_codes = find_a_field('general_sub_ledger','max(sub_ledger_id)','tr_from="PL" and type="PL"');
if($custome_codes>0){
	$custome_code = $custome_codes+1;
	}
	else{
	$custome_code = 22000001;
	}
$_POST['account_code'] = $_POST['ledger_id'];

//$_POST['sub_ledger_id'] = $custome_code;
$_POST['ledger_id'] = $custome_code;
$_POST['ledger_name'] = $_POST['warehouse_name'];

$tr_type="Add";
$ledger_gl_found = find_a_field('general_sub_ledger','sub_ledger_id','ledger_id="'.$_POST['account_code'].'" and sub_ledger_name='.$_POST['ledger_name']);

if ($ledger_gl_found==0) {
createSubLedger($custome_code,$_POST['warehouse_name'],'PL',$_POST[$unique],$_POST['account_code'] ,'PL');
}



$crud->insert();



$type=1;



$msg='New Entry Successfully Inserted.';



unset($_POST);



unset($$unique);

$tr_type="Add";

}











//for Modify..................................







if(isset($_POST['modify']))



{

$_POST['edit_at']=time();

$_POST['edit_by']=$_SESSION['user']['id'];

		$crud->update($unique);



		$type=1;



		$msg='Successfully Updated.';

		$tr_type="Add";

}



//for Delete..................................







if(isset($_POST['delete']))



{		$condition=$unique."=".$$unique;		



		$crud->delete($condition);



		unset($$unique);



		$type=1;



		$msg='Successfully Deleted.';

		$tr_type="Delete";



}







}



if(isset($$unique))



{



$condition=$unique."=".$$unique;	



$data=db_fetch_object($table,$condition);



foreach ($data as $key => $value)



{ $$key=$value;}



}

$tr_from="Warehouse";

?>



<script type="text/javascript">



function nav(lkf){document.location.href = '<?=$page?>?<?=$unique?>='+lkf;}



</script>













  <div class="container-fluid">

    <div class="row">

      <div class="col-md-8">

        



        <div class="container n-form1">

          <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">

            <thead class="thead1">

            <tr class="bgc-info">

              <th >ID</th>

			  <th >Company</th>

              <th>PL Name</th>

			  <th>Under Section</th>

              <th>Type</th>

			  <th >Action</th>

            </tr>

            </thead>



            <tbody class="tbody1">

            <?php



	 $rrr = "select * from warehouse where group_for in (".$user_group_define.") and use_type = 'PL' order by warehouse_id desc";

	$report=db_query($rrr);



	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

            <tr<?=$cls?> >

              <td><?=$rp[0];?></td>

			  <td><?=find_a_field('user_group','group_name','id='.$rp[17]);?></td>



              <td><?=$rp[1];?></td>

			  

			   <td><?=find_a_field('warehouse','warehouse_name','warehouse_id='.$rp[21]);?></td>



              <td><?=$rp[10];?></td>

			  

			  <td><button type="button" onclick="nav('<?php echo $rp[0];?>');" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button></td>



            </tr>



            <?php }?>



            </tbody>

          </table>



        </div>



      </div>





      <div class="col-md-4">

        <form id="form1" name="form1" class="n-form" method="post" action="<?=$page?>?<?=$unique?>=<?=$$unique?>">

		

          <h4 align="center" class="n-form-titel1"> Production Line Manage</h4>

		  <div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Company:</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

                       <select name="group_for" required id="group_for"  tabindex="7">

					<? user_company_access($group_for); ?>
					   </select>



                    </div>

                </div>



          <div class="form-group row m-0 pl-3 pr-3 p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label"> PL Name :</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

              					<? if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique)?>

					<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

				  <input name="warehouse_name" type="text" id="warehouse_name" value="<?php echo $warehouse_name;?>" required  class="form-control"/>





            </div>

          </div>
      <input name="use_type" type="hidden" id="use_type" value="PL" class="form-control">


			

	<div class="form-group row m-0 pl-3 pr-3 p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Under Section</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

					<select name="master_warehouse_id" id="master_warehouse_id" required>

                     <option ></option>					

		<? foreign_relation('warehouse','warehouse_id','warehouse_name',$master_warehouse_id,'1 and group_for in ('.$user_group_define.') and use_type="SC" ');?>

					</select>



            </div>

          </div>



          <div class="form-group row m-0 pl-3 pr-3 p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Address :</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

              <textarea name="address" class="form-control"  id="address"><?=$address;?></textarea>



            </div>

          </div>
		  
		  
		  
		  <?php 
							$proj_all=find_all_field('project_info','*','1');
							$gr_all=find_all_field('config_group_class','*','group_for='.$_SESSION['user']['group']);
						
							$dealer_ledg_group_id=$gr_all->wip_ledger;
							
							?>

            <div class="form-group row m-0 pl-3 pr-3 p-1">
						<div class="form-group row m-0">
							
							<label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">A/C Configuration:</label>
							 <div class="col-sm-8 col-md-8 col-lg-8 p-0">

											<? if ($ledger_id==0) {?>
											<select name="ledger_id" required="required" id="ledger_id" style="width:95%; font-size:12px;" tabindex="9">
											  <option></option>
<? foreign_relation('accounts_ledger','ledger_id','ledger_name',$ledger_id,'ledger_id="'.$dealer_ledg_group_id.'"');?>
                                            </select>

											<? }?>
											<? if ($ledger_id>0) {?>
											<input name="ledger_id" type="text" id="ledger_id" tabindex="9" value="<?=$ledger_id?>"  style="width:95%; font-size:12px;" />
<input name="sub_ledger_id" type="hidden" id="sub_ledger_id" tabindex="9" value="<?=$sub_ledger_id?>"  style="width:95%; font-size:12px;" />

											<? }?>
							</div>

						</div>

					</div>



          <div class="n-form-btn-class">

		  

<? if(!isset($_POST[$unique])&&!isset($_GET[$unique])) {?>

<input name="record" type="submit" id="record" value="Record" onclick="return checkUserName()" class="btn1 btn1-bg-submit" />



<? }?>



<? if(isset($_POST[$unique])||isset($_GET[$unique])) {?>

<input name="modify" type="submit" id="modify" value="Modify" class="btn1 btn1-bg-update" />



<? }?>

<input name="clear" type="button" class="btn1 btn1-bg-help" id="clear" onclick="parent.location='<?=$page?>'" value="Clear"/>



<? if($_SESSION['user']['level']==5){?>

<!--<input class="btn1 btn1-bg-cancel" name="delete" type="submit" id="delete" value="Delete"/>-->



<? }?>



          </div>





        </form>



      </div>



    </div>









  </div>











<script type="text/javascript">



	document.onkeypress=function(e){



	var e=window.event || e



	var keyunicode=e.charCode || e.keyCode



	if (keyunicode==13)



	{



		return false;



	}



}



</script>



<?



require_once SERVER_CORE."routing/layout.bottom.php";



?>