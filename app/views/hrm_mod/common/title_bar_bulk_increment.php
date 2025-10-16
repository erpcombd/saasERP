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
	/*background-color:#18226d;*/
	background-color:#83B0DE;
	color:#FFFFFF; 
	padding: 5px 20px !important;
}
.border-danger1{
/*border-color: #18226d !important;*/
border-color: #83B0DE !important;
}

.bg-light {
    background: white !important;
    padding: 5px 10px;
}
</style>


<? 


if(isset($_POST['reset'])){

    

	unset($_SESSION['employee_selected']); 
	unset($_SESSION['PBI_CODE']); 
    unset($_POST); 


}

?>
<div class="card" style="margin-top:0px; padding:0px">
  <div class="card-body border border-danger1 rounded search-bgc" style=" zoom: 85%; ">
    <div class="row">
      <div class="col-sm-1" align="right" style="padding:6px; padding-top: 8px;">
        <div class="row m-0 col-sm-12"> </div>
      </div>
      <div class="col-md-5"></div>
      <form action="" method="post">
        <div class="col-md-6" style="padding: 22px 0px 0px 0px;">
        <div class="row  p-0 m-0">
          <div class="col-md-4 p-0">
            <select name="PBI_JOB_STATUS" class="form-control" style=" height: 100% !important; ">
              <option value="">All</option>
              <option <?=($PBI_JOB_STATUS=='In Service')?'selected':'selected';?>>In Service</option>
              <option <?=($PBI_JOB_STATUS=='Not In Service')?'selected':'';?>>Not In Service</option>
            </select>
          </div>
		  
          <div class="col-md-4" style="padding-right:0px!important;">
            <button id="button-addon1" name="button"  type="submit" class="btn btn-warning" style=" height: 100%; width: 100%; "><i class="fa fa-search" style=" font-size: 15px; "></i> Search</button>
            <datalist id='eip_ids'>
              <option></option>
						  <?
			
			foreign_relation('personnel_basic_info','PBI_CODE','PBI_NAME',$employee_selected,'1');
			
			?>
						</datalist>
          </div>
		  
		  
          <div class="col-md-4" style="padding-right:0px!important;">
            <input type="submit" name="reset" id="reset" value="Reset" class="btn btn-danger" onclick="reset_data()" style=" height: 100%; width: 95%; "/>
          </div>
		  
		  
        </div>
      </form>
      <script>
  function reset_data(){
  
  document.getElementById("employee_selected").value="";
 
  
  }
  </script>
    </div>
    
    
    
    
    <div class="col-sm-2 pt-1">
      <label class="label" for="Emp_CODE"> ID NO: </label>
      <input type="text" list='code_list' name="PBI_CODE" id="PBI_CODE" value="<?=$_POST['PBI_CODE']?>" class="form-control" />
      <datalist id='code_list'>
        <option></option>
        <?
                    foreign_relation('personnel_basic_info','PBI_CODE','PBI_CODE', $PBI_CODE ,'1');
                    ?>
      </datalist>
    </div>
	
        <div class="col-sm-2 pt-1">
      <label class="label" for="PBI_ID"> Employee Code: </label>
      <input type="text" list='id_list' name="PBI_IDD" id="PBI_IDD" value="<? if($_POST['PBI_IDD']>0) echo $_POST['PBI_IDD'];?>" class="form-control" />
      <datalist id='id_list'>
        <option></option>
        <?
                    foreign_relation('personnel_basic_info','PBI_ID','concat(PBI_CODE," - ",PBI_NAME)', $PBI_IDD ,'1');
                    ?>
      </datalist>
    </div>
	
	
    <div class="col-sm-2 pt-1">
      <label class="label" for="Emp_CODE"> Employee Name :</label>
      <input type="text" list='name_list' name="PBI_NAME" id="PBI_NAME" value="<?=$_POST['PBI_NAME']?>" class="form-control" />
      <datalist id='name_list'>
        <option></option>
        <?
                    foreign_relation('personnel_basic_info','PBI_NAME','PBI_NAME', $PBI_NAME ,'1');
                    ?>
      </datalist>
    </div>
    <div class="col-md-2 form-group">
      <label class="label" for="PBI_SEX">Gender :</label>
      <select name="PBI_SEX" class="form-control">
        <option selected>
        <?=$_POST["PBI_SEX"]?>
        </option>
        <option></option>
        <option <?=($PBI_SEX =='Male')?'selected':'';?>>Male</option>
        <option <?=($PBI_SEX =='Female')?'selected':'';?>>Female</option>
      </select>
    </div>
    <div class="col-md-2 form-group">
      <label class="label" for="DESG_ID"> Designation : </label>
      <select name="DESG_ID" id="DESG_ID" class="form-control">
        <option></option>
        <option selected>
        <?=find_a_field('designation','DESG_DESC','DESG_ID="'.$_POST['DESG_ID'].'"');?>
        </option>
        <? foreign_relation('designation','DESG_ID','DESG_DESC',$_POST['DESG_ID'],'1 order by DESG_DESC');?>
      </select>
    </div>
    <div class="col-md-2 form-group">
      <label class="label" for="DESG_ID"> Grade : </label>
      <select name="grade" id="grade" class="form-control">
        <option></option>
        <option selected>
        <?=find_a_field('hrm_grade','grade_name','id="'.$_POST['grade'].'"');?>
        </option>
        <? foreign_relation('hrm_grade','id','grade_name',$_POST['grade'],'1 order by id');?>
      </select>
    </div>
    <div class="col-md-2 form-group">
      <label class="label req-input" for="PBI_ORG">Company: </label>
      <select  id="PBI_ORG" class="form-control" name="PBI_ORG">
        <option></option>
        <option selected>
        <?=find_a_field('user_group','group_name','id="'.$_POST['PBI_ORG'].'"');?>
        </option>
        <? foreign_relation('user_group','id','group_name',$_POST['PBI_ORG'],' 1');?>
      </select>
    </div>
    <div class="col-md-2 form-group">
      <label class="label" for="cost_center">Cost Center :</label>
      <select name="cost_center" id="cost_center" class="form-control" >
        <option selected>
        <?=find_a_field('hrm_cost_center','center_name','id="'.$_POST['cost_center'].'"');?>
        </option>
        <option>
        <? foreign_relation('hrm_cost_center','id','center_name',$_POST['cost_center'],' 1');?>
        </option>
      </select>
    </div>
    <div class="col-md-2 form-group">
      <label class="label" for="DEPT_ID">Department : </label>
      <select name="DEPT_ID" id="DEPT_ID" class="form-control">
        <option></option>
        <option selected>
        <?=find_a_field('department','DEPT_DESC','DEPT_ID="'.$_POST['DEPT_ID'].'"');?>
        </option>
        <? foreign_relation('department','DEPT_ID','DEPT_DESC',$_POST['DEPT_ID'],' 1 order by DEPT_DESC');?>
      </select>
    </div>
    <div class="col-md-2 form-group">
      <label class="label" for="section"> Section :</label>
      <select name="section" id="section" class="form-control" >
        <option></option>
        <option selected>
        <?=find_a_field('PBI_Section','sec_name','sec_id="'.$_POST['section'].'"');?>
        </option>
        <? foreign_relation('PBI_Section','sec_id','sec_name',$_POST['section'],' 1');?>
      </select>
    </div>
    <div class="col-md-2 form-group">
      <label class="label" for="section"> Work Station :</label>
      <select name="work_station" id="work_station" class="form-control" >
        <option></option>
        <option selected>
        <?=find_a_field('hrm_workstation','work_station_name','station_id="'.$_POST['work_station'].'"');?>
        </option>
        <?  foreign_relation('hrm_workstation','station_id','work_station_name',$_POST['work_station'],' 1');?>
      </select>
    </div>
    <div class="col-md-2 form-group">
      <label class="label" for="level"> Employment Type :</label>
      <select name="level" id="level" class="form-control" >
        <option></option>
        <option selected>
        <?=find_a_field('hrm_level','level_name','id="'.$_POST['level'].'"');?>
        </option>
        <? foreign_relation('hrm_level','id','level_name',$level,' 1');?>
      </select>
    </div>
    <div class="col-md-2 form-group">
      <label class="label" for="level"> Class :</label>
      <select name="class" id="class" class="form-control" >
        <option></option>
        <option selected>
        <?=find_a_field('hrm_class','class_name','id="'.$_POST['class'].'"');?>
        </option>
        <? foreign_relation('hrm_class','id','class_name',$_POST['class'],' 1');?>
      </select>
    </div>
    <div class="col-md-2 form-group">
      <label class="label" for="level"> Line :</label>
      <select name="line" id="line" class="form-control" >
        <option></option>
        <option selected>
        <?=find_a_field('hrm_line','line_name','id="'.$_POST['line'].'"');?>
        </option>
        <? foreign_relation('hrm_line','id','line_name',$_POST['line'],' 1');?>
      </select>
    </div>
    <div class="col-md-2 form-group">
      <label class="label" for="incharge_id"> First Reporting Supervisor :</label>
      <select name="incharge_id" id="incharge_id" class="form-control">
        <option></option>
        <option selected>
        <?=find_a_field('personnel_basic_info','PBI_NAME','PBI_ID="'.$_POST['incharge_id'].'"');?>
        </option>
        <? foreign_relation('personnel_basic_info','PBI_ID','PBI_NAME',$_POST['incharge_id'],' 1 order by PBI_NAME asc');?>
      </select>
    </div>
    
    
    <div class="col-md-2 form-group">
      <label class="label" for="PBI_RELIGION">Religion :</label>
      <select name="PBI_RELIGION" class="form-control">
        <option selected>
        <?=$_POST["PBI_RELIGION"];?>
        </option>
        <option <?=($PBI_RELIGION =='Islam')?'selected':'';?>>Islam</option>
        <option <?=($PBI_RELIGION =='Hinduism')?'selected':'';?>>Hinduism</option>
        <option <?=($PBI_RELIGION =='Buddhism')?'selected':'';?> >Buddhism</option>
        <option <?=($PBI_RELIGION =='Christianity')?'selected':'';?> >Christianity</option>
      </select>
    </div>
    
    <div class="col-md-2 form-group">
      <label class="label" for="JOB_LOCATION">Job Location :</label>
      <select name="JOB_LOC_ID" id="JOB_LOC_ID"  class="form-control"  >
        <option></option>
        <option selected>
        <?=find_a_field('project','PROJECT_DESC','PROJECT_ID="'.$_POST['JOB_LOC_ID'].'"');?>
        </option>
        <? foreign_relation('project','PROJECT_ID','PROJECT_DESC',$_POST['JOB_LOC_ID']);?>
      </select>
    </div>
    
	
     <div class="col-md-2 form-group">
      <label class="label" for="shedule"> Shift :</label>
      <select name="shedule" id="shedule"  class="form-control"  >
        <option></option>
        <option selected>
        <?=find_a_field('hrm_schedule_info','schedule_name','id="'.$_POST['shedule'].'"');?>
        </option>
        <? foreign_relation('hrm_schedule_info','id','schedule_name',$_POST['shedule']);?>
      </select>
    </div>
    
	
	
		<div class="col-md-2 form-group">
      <label class="label" for="fdate"> Joining  Date :</label>
        <input type="date" name="fdate" autocomplete="off" id="fdate"  value="<?php echo ($_POST['fdate'] > 0) ? $_POST['fdate'] : date("Y-m-01");?>"  class="form-control" required />
                                         
    </div>
    
    <?php /*?><div class="col-md-2 form-group">
      <label class="label" for=" "> Search To  Date </label>
      <input type="date" name="tdate" autocomplete="off" id="tdate" value="<?=date("Y-m-d");?>"  class="form-control" required/>
                                          
    </div><?php */?>
 
    
	
	
	
	
  </div>
</div>
