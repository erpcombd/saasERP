



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





<div class="col-md-6">


	
	  <ul class="list-unstyled m-0" style="padding-top: 8px;">
	
	  <li class="Emp_n">Employee Name & ID</li>
	
	  <li class="Emp_n1">Employee Designation</li>
	
	  <li class="Emp_n1">Employee Department</li>
	
	 <ul>
	 


</div>







<? }?>





<div class="col-md-5" style="padding-top: 22px;">







  

<form action="" method="post">





            <!--<div class="form-group"><label>Employee Identification Number</label></div>-->



            <div class="p-1 bg-danger rounded rounded-pill shadow-sm mb-4">

            <div class="input-group">

			

              <input type="search" list='eip_ids' name="employee_selected" id="employee_selected" value="<?=$_SESSION['PBI_CODE']?>"

			   placeholder="Search Employee Name & ID!" aria-describedby="button-addon1" class="form-control border-0 bg-light">

			   

			   

              <div class="input-group-append">

                <button id="button-addon1" name="button"  type="submit" class="btn btn-danger"><i class="fa fa-search"></i></button>

              </div>

            </div>

          </div>

		  

	

		

<datalist id='eip_ids'>

  <option></option>

  <?

foreign_relation('personnel_basic_info','PBI_CODE','PBI_NAME',$employee_selected,'1');

?>

</datalist>  

  

<!--<div class="input-group">

<input type="search" name="employee_selected" id="employee_selected" class="form-control rounded" placeholder="Search" aria-label="Search" 

aria-describedby="search-addon" value="<? //=$_SESSION['employee_selected']?>" />



<input type="submit" name="button" class="btn btn-outline-danger" id="button" value="Search"  /> 

</div>-->





</form>

  

</div>












                    
                    
                    <div class="col-sm-2 pt-1"> 
                     <label class="label" for="Emp_CODE"> Employee Code :</label>
                    <input type="text" list='code_list' name="PBI_CODE" id="PBI_CODE" value="<?=$PBI_CODE?>" class="form-control" /> 
                    
                    <datalist id='code_list'>
                    <option></option>
                    <?
                    foreign_relation('personnel_basic_info','PBI_CODE','PBI_CODE', $PBI_CODE ,'1');
                    ?>
                    </datalist> 
                    </div>
                    
                    
                    <div class="col-sm-2 pt-1"> 
                     <label class="label" for="ID_NO"> ID NO :</label>
                    <input type="text" list='id_list' name="PBI_ID" id="PBI_ID" value="<?=$PBI_ID?>" class="form-control" /> 
                    
                    <datalist id='id_list'>
                    <option></option>
                    <?
                    foreign_relation('personnel_basic_info','PBI_ID','PBI_ID', $PBI_ID ,'1');
                    ?>
                    </datalist> 
                    </div>






                        <div class="col-md-2 form-group">
                            <label class="label" for="PBI_SEX">Gender :</label>
                             <select name="PBI_SEX" class="form-control">
                                 <option selected>
                              <?=$_POST["PBI_SEX"]?>
                              </option>
                              <option <?=($PBI_SEX =='Male')?'selected':'';?>>Male</option>
                              <option <?=($PBI_SEX =='Female')?'selected':'';?>>Female</option>
                            </select>
                            
                            
                          </div>


                        <div class="col-md-2 form-group">
                            <label class="label" for="PBI_RELIGION">Religion :</label>
                            <select name="PBI_RELIGION" class="form-control">
                              <option selected> <?=$_POST["PBI_RELIGION"];?>  </option>
                          
                              <option <?=($PBI_RELIGION =='Islam')?'selected':'';?>>Islam</option>
                              <option <?=($PBI_RELIGION =='Hinduism')?'selected':'';?>>Hinduism</option>
                              <option <?=($PBI_RELIGION =='Bahai')?'selected':'';?>>Bahai</option>
                              <option <?=($PBI_RELIGION =='Buddhism')?'selected':'';?> >Buddhism</option>
                              <option <?=($PBI_RELIGION =='Christianity')?'selected':'';?> >Christianity</option>
                              <option>Confucianism </option>
                              <option>Druze</option>
                              
                              <option>Jainism</option>
                              <option>Judaism</option>
                              <option>Shinto</option>
                              <option>Sikhism</option>
                              <option>Taoism</option>
                              <option>Zoroastrianism</option>
                              <option>Others</option>
                            </select>
                          </div>

                        <div class="col-md-2 form-group">
                            <label class="label req-input" for="PBI_ORG">Company: </label>
                            <select  id="PBI_ORG" class="form-control" name="PBI_ORG">
                                <option></option>
                              <? foreign_relation('user_group','id','group_name',$PBI_ORG,' 1');?>
                            </select>
                          </div>

                         
                             <div class="col-md-2 form-group">
                            <label class="label req-input" for="PBI_JOB_STATUS">Employee Status :</label>
                            <select name="PBI_JOB_STATUS" class="form-control">
                               <option value="">All</option> 
                              <option <?=($PBI_JOB_STATUS=='In Service')?'selected':'selected';?>>In Service</option>
                              <option <?=($PBI_JOB_STATUS=='Not In Service')?'selected':'';?>>Not In Service</option>
                            </select>
                          </div>
                          

                          <div class="col-md-2 form-group">
                            <label class="label" for="DEPT_ID">Department : </label>
                            
                            <select name="DEPT_ID" id="DEPT_ID" class="form-control">
                                <option></option>
                              <? foreign_relation('department','DEPT_ID','DEPT_DESC',$DEPT_ID,' 1 order by DEPT_DESC');?>
                            </select>
                          </div>
                          
                          
                         


                            <div class="col-md-2 form-group">
                            <label class="label" for="DESG_ID"> Designation : </label>
                            <select name="DESG_ID" id="DESG_ID" class="form-control">
                              <option></option>
                              <? foreign_relation('designation','DESG_ID','DESG_DESC',$DESG_ID,'1 order by DESG_DESC');?>
                            </select>
                          </div>
                          
                          
                          <div class="col-md-2 form-group">
                            <label class="label" for="section"> Section :</label>
                            <select name="section" id="section" class="form-control" >
                              <option selected="selected">
                              <? foreign_relation('PBI_Section','sec_id','sec_name',$section,' 1');?>
                            </select>
                          </div>
                          
                         <div class="col-md-2 form-group">
                            <label class="label" for="JOB_LOCATION">Job Location :</label>
                            <select name="JOB_LOC_ID" id="JOB_LOC_ID"  class="form-control"  >
                              <option></option>
                              <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$JOB_LOC_ID);?>
                            </select>
                          </div>
                          
                          <div class="col-md-2 form-group">
                            <label class="label" for="cost_center">Cost Center :</label>
                            <select name="cost_center" id="cost_center" class="form-control" >
                              <option selected="selected">
                              <? foreign_relation('hrm_cost_center','id','center_name',$cost_center,' 1');?>
                            </select>
                          </div>
                          
                         <div class="col-md-2 form-group">
                            <label class="label" for="level"> Level :</label>
                            <select name="level" id="level" class="form-control" >
                              <option selected="selected">
                              <? foreign_relation('hrm_level','id','level_name',$level,' 1');?>
                            </select>
                          </div>




          





  </div>

</div>