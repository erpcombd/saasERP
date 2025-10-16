<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


// ::::: Edit This Section ::::: 


do_calander('#start_date');

do_calander('#end_date');

$title='Vendor Notice';			// Page Name and Page Title

do_datatable('table_head');

$page="notice.php";		// PHP File Name


$table='vendor_notice';		// Database Table Name Mainly related to this page



$unique='id';			// Primary Key of this Database table

$shown='notice';				// For a New or Edit Data a must have data field


// ::::: End Edit Section :::::







//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];



$crud      =new crud($table);







$$unique = $_GET[$unique];



if(isset($_POST[$shown]))



{



$$unique = $_POST[$unique];



//for Insert..................................



if(isset($_POST['insert']))



{		



$_POST['entry_by']=$_SESSION['user']['id'];

$_POST['entry_at']=date('Y-m-d H:i:s');







$crud->insert();



		



$type=1;



$msg='New Entry Successfully Inserted.';



unset($_POST);



unset($$unique);



}











//for Modify..................................







if(isset($_POST['update']))



{





		$_POST['edit_by'] = $_SESSION['user']['id'];

		 

		 $_POST['edit_at'] = $now=date('Y-m-d H:i:s');

		 

		 $_POST['ply'] = find_a_field('paper_grade_type','ply',"id=".$_POST['paper_grade_type']);





		$crud->update($unique);





}



//for Delete..................................







if(isset($_POST['delete']))



{		$condition=$unique."=".$$unique;		$crud->delete($condition);



		unset($$unique);



		$type=1;



		$msg='Successfully Deleted.';



}



}







if(isset($$unique))



{



$condition=$unique."=".$$unique;



$data=db_fetch_object($table,$condition);



foreach ($data as $key => $value)



{ $$key=$value;}



}



if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);



?>



<script type="text/javascript">



$(function() {



		$("#fdate").datepicker({



			changeMonth: true,



			changeYear: true,



			dateFormat: 'yy-mm-dd'



		});



});



function Do_Nav()



{



	var URL = 'pop_ledger_selecting_list.php';



	popUp(URL);



}









function DoNav(theUrl)



{



	document.location.href = '<?=$page?>?<?=$unique?>='+theUrl;



}



function popUp(URL) 



{



	day = new Date();



	id = day.getTime();



	eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");



}



</script>


<div class="container-fluid p-0">
    <div class="row">
        <div class="col-sm-7 p-0 pr-2">
            <div class="container p-0">
			<form id="form1" name="form1" class="n-form1 pt-0" method="post" action="">
			<h4 align="center" class="n-form-titel1">Search Vendor Notice</h4>

            <div class="form-group row m-0 pl-3 pr-3">

              <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Vendor List: </label>

              <div class="col-sm-9 p-0">

                	<select name="vendor_id" required id="vendor_id" style="width:250px; float:left;">

						<option></option>

						<? foreign_relation('vendor','vendor_id','vendor_name',$_POST['vendor_id'],'1');?>

					</select>



              </div>

            </div>



            <div class="n-form-btn-class">

              <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />

              <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Cancel" />

            </div>



          </form>

        </div>





        <div class="container n-form1">

         

          <table id="table_head" class="table1  table-striped table-bordered table-hover table-sm">

            <thead class="thead1">

            <tr class="bgc-info">

              <th>ID</th>

              <th>Vendor Name:</th>

              <th style="width: 9%;">Notice</th>

			  <th>Start Date</th>

              <th>End Date</th>

            </tr>

			

            </thead>



            <tbody class="tbody1">

					<?php

					if($_POST['vendor_id']!="")

					$con .= 'and a.vendor_id="'.$_POST['vendor_id'].'"';				

					if($_POST['warehouse_name']!="")					

					$con .='and a.warehouse_name like "%'.$_POST['warehouse_name'].'%" ';					

 $td='select a.'.$unique.',d.vendor_name,  a.'.$shown.',  a.start_date, a.end_date from '.$table.' a,vendor d	where a.vendor_id=d.vendor_id  '.$con.' order by a.id  ';					

					$report=db_query($td);	

								

					while($rp=mysqli_fetch_row($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>					

					<tr<?=$cls?> onclick="DoNav('<?php echo $rp[0];?>');">

					  	<td><?=$i;?></td>					

						<td><?=$rp[1];?></td>					

						<td><?=$rp[2];?></td>

						<td><?=$rp[3];?></td>

						<td><?=$rp[4];?></td>

					</tr>					

					<?php }?>

            </tbody>

          </table>

				<div id="pageNavPosition"></div>

        </div>



      </div>





      <div class="col-sm-5  p-0  pl-2">

		<form action="" method="post" class="n-form  setup-fixed" name="form1" id="form1" >

          <h4 align="center" class="n-form-titel1"> <?=$title?></h4>



									  

          <div class="form-group row m-0 pl-3 pr-3">

            <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Vendor:</label>

            <div class="col-sm-9 p-0">

              	<input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />

                <input name="id" type="hidden" id="id" tabindex="1" value="<?=$id?>" readonly>

				<? $dcode=$vendor_id."##".find_a_field('dealer_info','dealer_name_e','dealer_code="'.$vendor_id.'"')?>

                <input name="vendor_id" list="did" required type="text" id="vendor_id" tabindex="1" <?=($vendor_id!='') ?  'value="'.$dcode.'"': ''?> autocomplete="off">	

				<datalist id="did">

				<? foreign_relation('vendor','concat(vendor_id,"##",vendor_name)','concat(vendor_id,"##",vendor_name)',$vendor_id,'1')?>

				</datalist>

            </div>

          </div>

	

          <div class="form-group row m-0 pl-3 pr-3">

            <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Notice: </label>

            <div class="col-sm-9 p-0">

             	<textarea name="notice" required type="text" id="notice" tabindex="1" value="" rows="6" ><?=$notice?></textarea>

				

				



            </div>

          </div>



          <div class="form-group row m-0 pl-3 pr-3">

            <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Start Date:  </label>

            <div class="col-sm-9 p-0">



              <input name="start_date" required id="start_date"  tabindex="1" value="<?=$start_date?>" type="text" autocomplete="off">



            </div>

          </div>

		  

		  <div class="form-group row m-0 pl-3 pr-3">

            <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">End Date: </label>

            <div class="col-sm-9 p-0">

              <input name="end_date" required id="end_date"  tabindex="1" type="text" value="<?=$end_date?>"  autocomplete="off">



            </div>

          </div>

		  



          <div class="n-form-btn-class">

		  

                      <? if(!isset($_GET[$unique])){?>

                      	<input name="insert" type="submit" class="btn1 btn1-bg-submit" id="insert" value="SAVE" class="btn" />

                      <? }?>

					  

                      <? if(isset($_GET[$unique])){?>

                      	<input name="update" type="submit" class="btn1 btn1-bg-update" id="update" value="UPDATE" class="btn" />

                      <? }?>

                      	<input name="reset" type="button" class="btn1 btn1-bg-cancel" id="reset" value="RESET" onclick="parent.location='<?=$page?>'" />



          </div>

		  

        </form>

		

      </div>

    </div>

  </div>













<script type="text/javascript"><!--



    var pager = new Pager('grp', 10000);



    pager.init();



    pager.showPageNav('pager', 'pageNavPosition');



    pager.showPage(1);



//-->



	document.onkeypress=function(e){



	var e=window.event || e



	var keyunicode=e.charCode || e.keyCode



	if (keyunicode==13)



	{



		return false;



	}



}



</script>









<script>





function duplicate(){



var dealer_code_2 = ((document.getElementById('dealer_code_2').value)*1);



var customer_id = ((document.getElementById('customer_id').value)*1);







   if(dealer_code_2>0)

  {

  

alert('This customer code already exists.');

document.getElementById('customer_id').value='';





document.getElementById('customer_id').focus();



  } 







}



</script>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>