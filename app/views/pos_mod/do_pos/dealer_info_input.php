<?php

require_once "../../../assets/template/layout.top.php";


// ::::: Edit This Section ::::: 



$title='Add New Customer Information';			// Page Name and Page Title

$page="dealer_info.php";		// PHP File Name



$table='dealer_pos';		// Database Table Name Mainly related to this page

$unique='dealer_code';			// Primary Key of this Database table

$shown='dealer_name';				// For a New or Edit Data a must have data field



// ::::: End Edit Section :::::



//if(isset($_GET['proj_code'])) $proj_code=$_GET[$proj_code];

$crud      =new crud($table);



$$unique = $_GET[$unique];

if(isset($_POST[$shown]))

{

$$unique = $_POST[$unique];



if(isset($_POST['insert']))

{		

$proj_id			= $_SESSION['proj_id'];

$now				= time();

$entry_by = $_SESSION['user'];

$check_mobile = find_a_field('dealer_pos','contact_no','contact_no="'.$_POST['contact_no'].'"');
if($check_mobile==''){
$crud->insert();
$id = $_POST['dealer_code'];
		
		if($_FILES['pp']['tmp_name']!=''){ 
		$file_temp = $_FILES['pp']['tmp_name'];
		$folder = "../../pp_pic/pp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
$type=1;

$msg='New Entry Successfully Inserted.';

unset($_POST);

unset($$unique);
header('Location:../do_pos/dealer_info.php');
}else{
echo '<span style="color:red;">Duplicate Phone Number Found!</span>';
}
}





//for Modify..................................



if(isset($_POST['update']))

{
		$crud->update($unique);

$id = $_POST['dealer_code'];
		
		if($_FILES['pp']['tmp_name']!=''){ 
		$file_temp = $_FILES['pp']['tmp_name'];
		$folder = "../../pp_pic/pp/";
		move_uploaded_file($file_temp, $folder.$id.'.jpg');}
		
		$type=1;

		$msg='Successfully Updated.';
    
	header('Location:../do_pos/dealer_info.php');
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

while (list($key, $value)=each($data))

{ $$key=$value;}

}

if(!isset($$unique)) $$unique=db_last_insert_id($table,$unique);

?>

<script type="text/javascript"> function DoNav(lk){document.location.href = '<?=$page?>?<?=$unique?>='+lk;}



function popUp(URL) 

{

day = new Date();

id = day.getTime();

eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=1,menubar=0,resizable=1,width=800,height=800,left = 383,top = -16');");

}

</script>

<?php /*?><div class="form-container_large">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <!--<td valign="top"><div class="left">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div class="tabledesign" style="height:787px;">
                <? 	$res='select '.$unique.','.$unique.','.$shown.' as dealer_name, account_code  from '.$table;

											echo $crud->link_report($res,$link);?>
              </div>
               </td>
          </tr>
        </table>
      </div></td>--->
	  
	  
	
	  
    <td valign="top"><?php */?>
	
	
	<form action="" method="post"  enctype="multipart/form-data" >
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td colspan="2"><fieldset>
                     <!-- <legend>
                      <?=$title?>
                      </legend>--->
                      <div> </div>
                      <div class="buttonrow"></div>
					  
					  
			
  
  
  <div class="form-group row">
    <!-- Material input -->
    <label for="inputPassword3MD" class="col-sm-2 col-form-label">Customer Name</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
	  <input name="<?=$unique?>" id="<?=$unique?>" value="<?=$$unique?>" type="hidden" />
        <input name="dealer_name" class="form-control" type="text" id="dealer_name" value="<?=$dealer_name?>">
      </div>
    </div>
  </div>
		<div class="form-group row">
  <label for="inputPassword3MD" class="col-sm-2 col-form-label" onkeyup="contact_check(this.value);"required >Contact Number </label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
    <input name="contact_no" type="text" id="contact_no" class="form-control"  value="<?=$contact_no?>">
      </div>
    </div>
  </div>
  
  
  <div class="form-group row">
  <label for="inputPassword3MD" class="col-sm-2 col-form-label">Email:</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
    <input name="national_id" type="text" class="form-control" id="national_id" tabindex="6" value="<?=$national_id?>">
      </div>
    </div>
  </div>
		
	
  
  <div class="form-group row">
  <label for="inputPassword3MD" class="col-sm-2 col-form-label">Address</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
    <input name="address_e" type="text" id="dealer_name_e" class="form-control"  value="<?=$address_e?>">
      </div>
    </div>
	  
  </div>	
					   
  <div class="form-group row">
  <label for="inputPassword3MD" class="col-sm-2 col-form-label">Register Discount</label>
    <div class="col-sm-10">
      <div class="md-form mt-0">
    <input name="register_bonus" type="text" id="register_bonus" class="form-control"  value="<?=$register_bonus?>">
      </div>
    </div>
	  
  </div>	
  
  
  	  
      </div>
    </div>
  </div>


                      <div></div>
                    </fieldset></td>
                
                </tr>
              
              </table></td>
          </tr>
          <tr>
            <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td><div class="button">
                      <? if(!isset($_GET[$unique])){?>
                      <input name="insert" type="submit" id="insert" value="Save" class="btn btn-success" style="width:99%;" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <? if(isset($_GET[$unique])){?>
                      <input name="update" type="submit" id="update" value="Update" class="btn btn-primary" style="width:99%;" />
                      <? }?>
                    </div></td>
                  <td><div class="button">
                      <input name="reset" type="button" class="btn btn-warning" id="reset" value="Reset" onclick="parent.location='<?=$page?>'" style="width:99%;" />
                    </div></td>
                  <td>
                  <!--<div class="button">
                      <input class="btn" name="delete" type="submit" id="delete" value="Delete"/>
                    </div>-->
                    </td>
                </tr>
              </table></td>
          </tr>
        </table>
      </form>
	  
<!--	  
	  
	  </td>
  </tr>
</table>
</div>-->
<?

require_once "../../../assets/template/layout.bottom.php";

?>
