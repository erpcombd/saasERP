<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Edit This Section ::::: 

$title='Fiscal Year Setup';			// Page Name and Page Title

do_datatable('table_head');

$page="opening_date.php";		// PHP File Name



$table='opening_date';		// Database Table Name Mainly related to this page

$unique='id';			// Primary Key of this Database table

$shown='start_date';				// For a New or Edit Data a must have data field



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

$proj_id = $_SESSION['proj_id'];
$_POST['entry_by']=$_SESSION['user']['id'];
$_POST['entry_at']=date('Y-m-d h:i:s');
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


		$crud->update($unique);

		$id = $_POST['dealer_code'];




		$type=1;

		$msg='Successfully Updated.';

}

//for Delete..................................



/*if(isset($_POST['delete']))

{		$condition=$unique."=".$$unique;		$crud->delete($condition);

		unset($$unique);

		$type=1;

		$msg='Successfully Deleted.';

}*/

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
            <?php /*?><div class="container p-0">
                <form id="form1" name="form1" class="n-form1" method="post" action="">


                   
					<div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Fiscal Year</label>
                        <div class="col-sm-9 p-0">
                             <select name="sitem" required id="sitem" tabindex="7">
                                  <option></option>
                     			 <? foreign_relation('fiscal_year','id','fiscal_year',$_POST['sitem'],'1')?>
                   			 </select>

                        </div>
                    </div>

                    <div class="n-form-btn-class">
                        <input class="btn1 btn1-bg-submit" name="search" type="submit" id="search" value="Show" />
                        <input class="btn1 btn1-bg-cancel" name="cancel" type="submit" id="cancel" value="Cancel" />
                    </div>

                </form>
            </div><?php */?>


            <div class="container n-form1">
               <table  id="table_head" class="table table-bordered table-bordered table-striped table-hover table-sm" cellspacing="0">
					<thead>
						<tr>
							 <th><span>ID</span></th>
							
							<th><span>Opening Date</span></th>
							
							<th><span>Status</span></th>
						</tr>
					</thead>
					
					<tbody>
					
					<?php
					
					
					
					
					
					if($_POST['sitem']>0)
					
					$con .=' and id="'.$_POST['sitem'].'"';
					
					
					
					
					
					 $td='select * from opening_date where 1 '.$con.'';
					
					$report=db_query($td);
					
					while($rp=mysqli_fetch_object($report)){$i++; if($i%2==0)$cls=' class="alt"'; else $cls='';?>
					
					<tr<?=$cls?> onclick="DoNav('<?php echo $rp->id;?>');">
					 <td><?=++$i?></td>
					
					
					<td><?=$rp->start_date;?></td>
					
					<td><?=$rp->status;?></td>
					
					</tr>
					
					<?php }?>
					</tbody>
					</table>
					
					<? //}?>

									<div id="pageNavPosition"></div>

            </div>

        </div>


        <div class="col-sm-5 p-0  pl-2">
            
            <form class="n-form setup-fixed" action="" method="post" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return check()">
                <h4 align="center" class="n-form-titel1"><?=$title?></h4>

                

               
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Start Date: </label>
                    <div class="col-sm-9 p-0">
                       
                       <input type="date" name="start_date" id="start_date" value="<?=$start_date?>" tabindex="1">

                    </div>
                </div>
				
				
				
				
				<div class="form-group row m-0 pl-3 pr-3">
                    <label for="group_name" class="col-sm-3 pl-0 pr-0 col-form-label">Status:  </label>
                    <div class="col-sm-9 p-0">

                       <select name="status" id="status" required>

                              <option <?=($status=='Active')?'selected':''?> value="Active">Active</option>

                              <option <?=($status=='Inactive')?'selected':''?> value="Inactive">Inactive</option>


                        </select>

                    </div>
                </div>
				
				
				
				<div class="form-group row m-0 pl-3 pr-3">
                        <label for="group_for" class="col-sm-3 pl-0 pr-0 col-form-label">Company :</label>
                        <div class="col-sm-9 p-0">
                             <select name="group_for" required id="group_for" tabindex="7">

                      <? foreign_relation('user_group','id','group_name',$group_for,'
					  id="'.$_SESSION['user']['group'].'"');?>
                    </select>

                        </div>
                    </div>

                <div class="n-form-btn-class">
                     <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="SAVE" class="btn1 btn1-bg-submit" />
                      <? }?>
                    
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="UPDATE" class="btn1 btn1-bg-update" />
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