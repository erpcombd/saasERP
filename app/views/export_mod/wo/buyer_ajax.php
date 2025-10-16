<?php


//



 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('##',$str);


   $customer=$data[0];
   
   $dealer=explode('->',$customer);
   
   $dealer_code=$dealer[0];
   
   $dealer_all = find_all_field('dealer_info_foreign','',"dealer_code=".$dealer_code);

?>

  
  
  
<div>

<label style="width:220px;">Customer Group </label>


		 
		<input name="dealer_group" type="hidden" id="dealer_group" required readonly="" style="width:250px;" value="<?=$dealer_all->dealer_group?>" tabindex="105" />
		
		<input name="dealer_group2" type="text" id="dealer_group2" required readonly="" style="width:250px;"
		 value="<?=find_a_field('dealer_group','dealer_group',"id=".$dealer_all->dealer_group);?>" tabindex="105" />


		
</div>
  
  



 
  <div>

<label style="width:220px;">Marketing Team: </label>


		 
		<input name="marketing_team" type="hidden" id="marketing_team" required readonly="" style="width:250px;" value="<?=$dealer_all->marketing_team?>" tabindex="105" />
		
		<input name="marketing_team2" type="text" id="marketing_team2"  readonly="" style="width:250px;"
		 value="<?=find_a_field('marketing_team','team_name',"team_code=".$dealer_all->marketing_team);?>" tabindex="105" />


		
</div>


<div>

<label style="width:220px;">Marketing Person: </label>


		 
		<input name="marketing_person" type="hidden" id="marketing_person" required readonly="" style="width:250px;" value="<?=$dealer_all->marketing_person?>" tabindex="105" />
		
		<input name="marketing_person2" type="text" id="marketing_person2"  readonly="" style="width:250px;"
		 value="<?=find_a_field('marketing_person','marketing_person_name',"person_code=".$dealer_all->marketing_person);?>" tabindex="105" />


		
</div>



<div>

<label style="width:220px;">Merchandiser: </label>


		 
		 
		 
		<input name="dealer_code" type="hidden" id="dealer_code" required readonly="" style="width:250px;" value="<?=$dealer_code?>" tabindex="105" />


  <input list="merchandizer_name" name="merchandizer" id="merchandizer"  style="width:250px;"    autocomplete="off" >
  <datalist id="merchandizer_name">

	  <? foreign_relation('merchandizer_info','CONCAT(merchandizer_code, "->", merchandizer_name)','merchandizer_name',$merchandizer,'dealer_group="'.$dealer_all->dealer_group.'" order by merchandizer_name');?>
	  
  </datalist>


		

</div>




