<?php

 
 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

$now=time();

$title='Warehouse Type Setup';



$unique='id';

$unique_field='id';

$table='warehouse_type';

$page="warehouse_type.php";



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



}











//for Modify..................................







if(isset($_POST['modify']))



{

$_POST['edit_at']=time();

$_POST['edit_by']=$_SESSION['user']['id'];

		$crud->update($unique);



		$type=1;



		$msg='Successfully Updated.';



}



//for Delete..................................







if(isset($_POST['delete']))



{		$condition=$unique."=".$$unique;		



		$crud->delete($condition);



		unset($$unique);



		$type=1;



		$msg='Successfully Deleted.';



}







}



if(isset($$unique))



{



$condition=$unique."=".$$unique;	



$data=db_fetch_object($table,$condition);



 
foreach($data as $key=>$value)


{ $$key=$value;}



}



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

			  <th >Warehouse Type</th>

			  
			  <th >Action</th>

            </tr>

            </thead>



            <tbody class="tbody1">

            <?php



	 $rrr = "select * from warehouse_type where 1";

	$report=db_query($rrr);



	while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>

            <tr<?=$cls?> >

              <td><?=$rp[0];?></td>
			  <td><?=$rp[1];?></td>

		

			  

			  

			  <td><button type="button" onclick="nav('<?php echo $rp[0];?>');" class="btn2 btn1-bg-submit"><i class="fa-solid fa-eye"></i></button></td>



            </tr>



            <?php }?>



            </tbody>

          </table>



        </div>



      </div>





      <div class="col-md-4 p-0">

        <form id="form1" name="form1" class="n-form" method="post" action="<?=$page?>?<?=$unique?>=<?=$$unique?>">

		

          <h4 align="center" class="n-form-titel1"> Warehouse Type Manage</h4>

		  

		  <div class="form-group row m-0 pl-3 pr-3  p-1">

            <label for="group_name" class="col-sm-4 col-md-4 col-lg-4 pl-0 pr-0 col-form-label">Warehouse Type:</label>

            <div class="col-sm-8 col-md-8 col-lg-8 p-0">

						 <input type="text" name="warehouse_type" class="form-control"  id="warehouse_type" value="<?=$warehouse_type;?>"/>
						 <input type="hidden" name="id" class="form-control"  id="id" value="<?=$id;?>"/>

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
		  

            </div>

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