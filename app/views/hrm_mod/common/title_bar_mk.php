

<style>

.profile_info img {
    max-width: 87px;
    max-height: 87px;
    border-radius: 50%;
    border: 2px solid #a5adc6;
    cursor: pointer;
};

.serach_field-area .search_inner input {
    color: #000;
    font-size: 17px;
    height: 60px;
    width: 100%;
    padding-left: 82px;
    border: 0;
    padding-right: 15px;
    border-bottom: 1px solid #f4f7fc;
    background: #f7faff;
    border-radius: 30px;
}
</style>








<? if(isset($_POST['button'])){

	$_SESSION['employee_selected'] = $_POST['employee_selected'];

}?>





<div class="card" style="margin-top:0px; padding:0px">
<div class="card-body border border-danger rounded" style="background-color:#494BA4; color:#FFFFFF;">
  
  
 



<div class="row">


           <? if($_SESSION['employee_selected']>0){ 

		   $sql =  @db_query("select PBI_NAME,PBI_PICTURE_ATT_PATH,DEPT_ID,DESG_ID,PBI_NID_ATT_PATH,PBI_PASSPORT_ATT_PATH 
		   from  personnel_basic_info where PBI_ID = ".$_SESSION['employee_selected']."");

		   $row = @mysqli_fetch_object($sql);

		  ?>


<div class="col-2">
<div class="profile_info">
<img src="../../../assets/support/upload_view.php?name=<?=$row->PBI_PICTURE_ATT_PATH?>&folder=hrm_emp_pic" alt="#">  
</div>
</div>

<div class="col-5">
  <ul class="list-unstyled">
  <li style="font-family:verdana; font-weight:bold;font-size:18px;">Name : <?=$row->PBI_NAME;?></li>
  <li style="font-family:'Courier New';font-weight:bold; font-style:italic;font-size:16px;padding-top:5px">Designation: <?=find_a_field('designation','DESG_DESC','DESG_ID='.$row->DESG_ID);?></li>
  <li style="font-family:'Courier New';font-weight:bold; font-style:italic;font-size:16px">Department: <?=find_a_field('department','DEPT_DESC','DEPT_ID='.$row->DEPT_ID);?></li>
 <ul>




  
</div>



  <? }else{?>

<div class="col-2">

<div class="container">
 <div class="profile_info">
<img src="../../common/images.png" alt="Employee Image">   
</div>         
   
</div>

</div>


<div class="col-md-5">
<div>
  <ul class="list-unstyled">
  <li style="font-family:verdana; font-weight:bold;font-size:18px;">Employee Name & ID</li>
  <li style="font-family:'Courier New';font-weight:bold; font-style:italic;font-size:16px;padding-top:5px">Employee Designation</li>
  <li style="font-family:'Courier New';font-weight:bold; font-style:italic;font-size:16px;">Employee Department</li>
 <ul>

</div>


</div>



<? }?>


<div class="col-5">



  
<form action="" method="post">


            <div class="form-group"><!--<label>Employee Identification Number</label>--></div>

            <div class="p-1 bg-danger rounded rounded-pill shadow-sm mb-4">
            <div class="input-group">
			
              <input type="search" list='eip_ids' name="employee_selected" id="employee_selected" value="<?=$_SESSION['employee_selected']?>"
			   placeholder="Search Employee Name & ID!" aria-describedby="button-addon1" class="form-control border-0 bg-light">
			   
			   
              <div class="input-group-append">
                <button id="button-addon1" name="button"  type="submit" class="btn btn-danger"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </div>
		  
	
		
<datalist id='eip_ids'>
  <option></option>
  <?
foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_CODE," - ",PBI_NAME)',$employee_selected,'1');
?>
</datalist>  
  
<!--<div class="input-group">
<input type="search" name="employee_selected" id="employee_selected" class="form-control rounded" placeholder="Search" aria-label="Search" 
aria-describedby="search-addon" value="<? //=$_SESSION['employee_selected']?>" />

<input type="submit" name="button" class="btn btn-outline-danger" id="button" value="Search"  /> 
</div>-->


</form>
  
</div>


</div>


          


  </div>
</div>