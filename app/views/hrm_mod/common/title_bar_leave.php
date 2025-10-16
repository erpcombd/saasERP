



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

.Emp_n{
	font-weight:bold;
	font-size:14px;
}

.Emp_n1{
	font-size:13px;
	font-style:italic;
}

.search-bgc{
	background-color:#18226d;
	color:#FFFFFF; 
	padding: 5px 20px !important;
}
.border-danger1{
border-color: #18226d !important;
}


.bg-light {
    background: white !important;
    padding: 0px;
    border-bottom: 1px Solid #cccccc;
}
</style>

















<? if(isset($_POST['button'])){

    

	$_SESSION['employee_selected'] = find_a_field('personnel_basic_info','PBI_ID','PBI_CODE="'.$_POST['employee_selected'].'"');

	$_SESSION['PBI_CODE'] = $_POST['employee_selected'];



}?>











<div class="card" style="margin-top:0px; padding:0px">

<div class="card-body border border-danger1 rounded search-bgc" >

  

  

 







<div class="row">





           <? if($_SESSION['employee_selected']>0){ 


           $module_name = find_a_field('user_module_manage','module_file','id='.$_SESSION["mod"]);
		   $sql =  @db_query("select PBI_NAME,PBI_PICTURE_ATT_PATH,DEPT_ID,DESG_ID,PBI_NID_ATT_PATH,PBI_PASSPORT_ATT_PATH 

		   from  personnel_basic_info where PBI_ID = ".$_SESSION['employee_selected']."");



		   $row = @mysqli_fetch_object($sql);



		  ?>





<div class="col-sm-1" align="right" style="padding:6px; padding-top: 8px;">

<div class="profile_info">

<img src="../../../assets/support/upload_view.php?name=<?=$row->PBI_PICTURE_ATT_PATH?>&folder=hrm_emp_pic&proj_id=<?=$_SESSION['proj_id']?>&mod=<?=$module_name?>" alt="#" style="width: 70px; height: 70px;">  

</div>

</div>



<div class="col-6">

  <ul class="list-unstyled m-0" style="padding-top: 8px;">

  <li class="Emp_n">Employee Name : <?=$row->PBI_NAME;?></li>

  <li class="Emp_n1">Designation: <?=find_a_field('designation','DESG_DESC','DESG_ID='.$row->DESG_ID);?></li>

  <li class="Emp_n1">Department: <?=find_a_field('department','DEPT_DESC','DEPT_ID='.$row->DEPT_ID);?></li>

 <ul>


</div>







  <? }else{?>



<div class="col-sm-1" align="right" style="padding:6px; padding-top: 8px;">



<div class="row m-0 col-sm-12">

 <div class="profile_info">

<img src="../../common/images.png" alt="Employee Image" style=" width: 70px; height: 70px; ">   

</div>         

</div>

</div>





<div class="col-md-5">


	
	  <ul class="list-unstyled m-0" style="padding-top: 8px;">
	
	  <li class="Emp_n">Employee Name & ID</li>
	
	  <li class="Emp_n1">Employee Designation</li>
	
	  <li class="Emp_n1">Employee Department</li>
	
	 <ul>
	 


</div>







<? }?>





<div class="col-md-5" style="padding-top: 22px; display: flex;">







  

<form action="" method="post">


             <div class="p-1 bg-danger rounded rounded-pill shadow-sm mb-4  ;" style="width: 90px;     margin-right: 10px;">
    <div class="input-group">
        <!-- Add a year selection dropdown -->
        <select name="selected_year" id="selected_year" class="form-control border-0 bg-light">
            <?php
            // Assuming you have a range of years, adjust the range accordingly
            $currentYear = date("Y");
            $startYear = $currentYear - 10; // You can adjust the range as needed
            for ($year = $currentYear; $year >= $startYear; $year--) {
                echo "<option value='$year'>$year</option>";
            }
            ?>
        </select>

       

        
    </div>
</div>



            <!--<div class="form-group"><label>Employee Identification Number</label></div>-->



            <div class="p-1 bg-danger rounded rounded-pill shadow-sm mb-4" style=" width: 100%; ">

            <div class="input-group">

			

              <input type="search" list='eip_ids' name="employee_selected" id="employee_selected" value="<?=$_SESSION['PBI_CODE']?>"

			   placeholder="Search Employee Name & ID!" aria-describedby="button-addon1" class="form-control border-0 bg-light" style=" height: 35px; ">

			   

			   

              <div class="input-group-append">

                <button id="button-addon1" name="button"  type="submit" class="btn btn-danger"><i class="fa fa-search"></i></button>

              </div>

            </div>

          </div>

		  

	

		

<datalist id='eip_ids'>

  <option></option>
  
  
   <?
  $user_id  =  $_SESSION['user']['id'];
  
if($user_id == 10073 || $user_id == 10074 || $user_id == 10108) {
 
 foreign_relation('personnel_basic_info','PBI_CODE','PBI_NAME',$employee_selected,'JOB_LOC_ID !=3');   
    
}else{
    
   foreign_relation('personnel_basic_info','PBI_CODE','PBI_NAME',$employee_selected,'1'); 
}





?>

  <?

//foreign_relation('personnel_basic_info','PBI_CODE','PBI_NAME',$employee_selected,'1');

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