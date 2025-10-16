<?php


require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";





// ::::: Edit This Section ::::: 

$title='Motorcycle Installment';			// Page Name and Page Title

$page="motorcycle_install.php";		// PHP File Name

$input_page="motorcycle_install.php";

$root='payroll';



$table='motorcycle_install';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='advance_amt';				// For a New or Edit Data a must have data field

do_datatable('grp');



// ::::: End Edit Section :::::



$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

	

$$unique = $_POST[$unique];



if(isset($_POST['insert'])||isset($_POST['insertn']))

{		

$now				= time();



$_POST['PBI_ID']=$_SESSION['employee_selected'];

for($i=0;$i<$_POST['total_installment'];$i++)

{

$smon=$_POST['start_mon']+$i;

$syear=$_POST['start_year'];

$_POST['current_mon'] = date('m',mktime(1,1,1,$smon,1,$syear));

$_POST['current_year'] = date('Y',mktime(1,1,1,$smon,1,$syear));

$_POST['installment_no'] = $i+1;

$crud->insert();

}



$type=1;

$msg='New Entry Successfully Inserted.';



unset($_POST);

unset($$unique);

}





//for Modify..................................



if(isset($_POST['update']))

{



		$crud->update($unique);

		$type=1;

		$msg='Successfully Updated.';



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

while (list($key, $value)=@each($data))

{ $$key=$value;}

}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);



$$unique = $_GET[$unique];



?>

<script type="text/javascript"> function DoNav(lk){

	document.location.href = '<?=$page?>?<?=$unique?>='+lk;

	}

	

	

function install_amnt_auto_cal(){

var tot_amnt=document.getElementById('advance_amt').value;

var tot_istl=document.getElementById('total_installment').value;

var istl_amnt=tot_amnt/tot_istl;

document.getElementById('payable_amt').value = istl_amnt;

}	

</script>



<style>

label{

 font-weight:bold;

}



</style>





<div class="oe_view_manager oe_view_manager_current">

      <form action="" method="post" enctype="multipart/form-data">  

    <? include('../common/title_bar.php');?>

    </form>

    <form action="" method="post" enctype="multipart/form-data">

        <div class="oe_view_manager_body">

                <div class="oe_view_manager_view_form"><div style="opacity: 1;" class="oe_formview oe_view oe_form_editable">


        <div class="oe_form_container"><div class="oe_form">

          <div class="">

    <? include('../common/input_bar.php');?>

<div class="oe_form_sheetbg">

                        <div class="oe_form_sheet oe_form_sheet_width" style="min-height:100px;background: whitesmoke;">

     
		  
		 <div class="p-3">

			

               <div class="row ">

	         <div class="col-md-4 form-group">

            <label for="rcv_amt">Total Install Amount: </label>

            <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />

          </div>

		  

		  <div class="col-md-4 form-group">

            <label for="dealer_code">Start Month: </label>

           <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />

          </div>

		  

		  

		 <div class="col-md-4 form-group">

            <label for="wo_detail2">Monthly Payable Amt: </label>

			 <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />

          </div>

		  

		  

		   <div class="col-md-4 form-group">

            <label for="wo_detail">Total Install  : </label>

            <input name="rcv_amt" type="text" class="form-control" id="rcv_amt"  value="<?=$rcv_amt?>" tabindex="101" />

          </div>

		  

		  <div class="col-md-4 form-group">

		  <label for ="wo_detail">Start Year :</label>

		  <input name ="rcv_amt" type ="text" class="form-control" id="rcv_amt" value="<?=$rcv_amt?>"tabindex"101"/>

		  </div>


		  <div class="col-md-4 form-group">

		  <label for ="wo_detail">Install Type :</label>

              <input name ="rcv_amt" type="text" id="rcv_amt" value="<?=$rcv_amt?>"tabindex"101"/>

		  </div>



		  </div>

                        </div>

                      </div>

             <div class="oe_form_sheetbg">

        <div class="oe_form_sheet oe_form_sheet_width">



          <div  class="table table-bordered table-sm">
		  <div  class="oe_list oe_view pt-4">

          <? 	$res='select id, advance_type,payable_amt, installment_no,concat(current_mon,"-",current_year) as payable_month,total_installment ,	                             concat(start_mon,"-",start_year) as start_month,advance_amt as total_advance_amt  from motorcycle_install where PBI_ID="'.$_SESSION['employee_selected'].'" order by id desc';

				echo link_report1($res,$link);?>

          </div></div>

          </div>

    </div>

    <div class="oe_chatter"><div class="oe_followers oe_form_invisible">

      <div class="oe_follower_list"></div>

    </div></div></div></div></div>

    </div></div>

            

        </div>

        </form>

    </div>



<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>