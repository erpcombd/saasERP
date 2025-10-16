<?php

session_start();

ob_start();
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";

// ::::: Start Edit Section ::::: 

$title='Voucher Delete';			// Page Name and Page Title

if(isset($_POST['v_delete'])){
$chalan_no = $_REQUEST['chalan_no'];

$type = $_REQUEST['type'];


if($chalan_no>0)

{

	define('TR_CONDITION', "' and tr_no=");

db_query("INSERT INTO secondary_journal_del 
          SELECT * FROM secondary_journal 
          WHERE tr_from ='".$type.TR_CONDITION.$chalan_no);


    db_query("DELETE FROM `secondary_journal` WHERE tr_from ='".$type."' and tr_no=".$chalan_no."");
	
	db_query("INSERT INTO journal_del select * from journal where tr_from ='".$type."' and tr_no=".$chalan_no."");
    db_query("DELETE FROM `journal` WHERE tr_from ='".$type."' and tr_no=".$chalan_no."");
	
	db_query("insert into del_modify_logs set tr_no='".$chalan_no."',tr_from='".$type."',action='Delete',entry_by='".$_SESSION['user']['id']."',entry_at='".date('Y-m-d H:i:s')."'");
	$msg = '<span style="color:green;">Voucher Deleted Successfully.</span>';

}

}



	?>

<style type="text/css">

<!--

.style1 {

	color: #FF0000;

	font-weight: bold;

}

.style2 {

	color: #006600;

	font-weight: bold;

}

-->

</style>
<? if(isset($msg)){ ?>

	<div class="alert alert-success p-2" role="alert">
  			<?=$msg?>
	</div>

<? } ?>


<div class="form-container_large">
   
    <form action="" method="post">
           
        <div class="container-fluid bg-form-titel">
            <div class="row">
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">TR No</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                            <input name="chalan_no" type="text" id="chalan_no" maxlength="16" value="<?=$chalan_no?>" required />
                        </div>
                    </div>

                </div>
                <div class="col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="form-group row m-0">
                        <label class="col-sm-4 col-md-4 col-lg-4 col-xl-4 m-0 p-0 d-flex justify-content-end align-items-center pr-1 bg-form-titel-text">Voucher Type</label>
                        <div class="col-sm-8 col-md-8 col-lg-8 col-xl-8 p-0">
                           <select name="type" id="type" required>
							<option></option>
								<option value="Receipt" >Receipt</option>
								<option value="Payment" >Payment</option>
								<option  value="Journal">Journal</option>
								<option value="contra" >Contra</option>
							</select>

                        </div>
                    </div>
                    
                    
                    
                    
                    
                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
							<input name="v_delete" type="submit" class="btn1 btn1-submit-input" id="v_delete" value="Delete" />
                  
                   
                </div>

            </div>
        </div>

    </form>
</div>






<?

require_once SERVER_CORE."routing/layout.bottom.php";

?>