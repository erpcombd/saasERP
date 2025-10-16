<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$now=time();

$title='Section Setup';

$tr_type="Show";

$unique='warehouse_id';

$unique_field='warehouse_name';

$table='warehouse';

$page="section.php";



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













  <div class="container-fluid p-0">

    <div class="row">

      <div class="col-md-8 pr-2 pl-0">

        



        <div class="container n-form1">

          <table id="grp" class="table1  table-striped table-bordered table-hover table-sm">

            <thead class="thead1">

            <tr class="bgc-info">

              <th >ID</th>

			  <th >Company</th>

              <th>Section Name</th>

			  <th>Under Warehouse</th>

              <th>Type</th>

			  <th >Action</th>

            </tr>

            </thead>



            <tbody class="tbody1">

            <?php

       $user_group_define=find_a_field('company_define ','GROUP_CONCAT(company_id order by company_id asc)','user_id="'.$_SESSION['user']['id'].'"');

	 $rrr = "select * from warehouse where group_for in (".$user_group_define.") and use_type = 'SC' order by warehouse_id desc";

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





      <div class="col-md-4 p-0">

        <form id="form1" name="form1" class="n-form" method="post" action="<?=$page?>?<?=$unique?>=<?=$$unique?>">

		

          <h4 align="center" class="n-form-titel1"> Production Line Manage</h4>

		  

		 <?php /*?> <div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Company:</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">



                       <select name="group_for" required id="group_for"  tabindex="7">

					

							  <? foreign_relation('user_group','id','group_name',$group_for,'1 and id="'.$_SESSION['user']['group'].'"');?>

					   </select>



                    </div>

                </div>
<?php */?>

          <div class="form-group row m-0 pl-3 pr-3 p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label"> Section Name :</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

              					<? if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique)?>

					<input name="<?=$unique?>" type="hidden" id="<?=$unique?>" value="<?=$$unique?>"/>

				  <input name="warehouse_name" type="text" id="warehouse_name" value="<?php echo $warehouse_name;?>" required  class="form-control"/>





            </div>

          </div>

	<input type="hidden" name="use_type"  id="use_type" value="SC" class="form-control" >


			

		<? $user_group_define=find_a_field('company_define ','GROUP_CONCAT(company_id ORDER BY company_id ASC)','user_id="'.$_SESSION['user']['id'].'" and status="Active"');?>	

	<div class="form-group row m-0 pl-3 pr-3 p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Under Warehouse</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

					<select name="master_warehouse_id" id="master_warehouse_id" required>

                     <option ></option>					
					 <? foreign_relation('warehouse','warehouse_id','warehouse_name',$master_warehouse_id,'1 and group_for in ('.$user_group_define.') and status="Active" and use_type="WH" ');?>

					</select>



            </div>

          </div>



          <div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Address :</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

              <textarea name="address" class="form-control"  id="address"><?=$address;?></textarea>



            </div>

          </div>



          <div class="form-group row m-0 pl-3 pr-3 p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Account Code :</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

			<input name="ledger_id" type="text" id="ledger_id" value="<?=$ledger_id?>" class="form-control"/>



            </div>

          </div>

        <div class="form-group row m-0 pl-3 pr-3 p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Company :</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

			 <select name="group_for" id="group_for" value="<?=$_POST['group_for'];?>" required>

                <option></option>
                <? user_company_access($group_for); ?>
              </select>

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