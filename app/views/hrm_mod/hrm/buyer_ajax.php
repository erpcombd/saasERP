<?php


session_start();



require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";


@ini_set('error_reporting', E_ALL);


@ini_set('display_errors', 'Off');


$str = $_POST['data'];


$data=explode('->',$str);


   $customer=$data[0];
   
   $dealer=explode('->',$customer);
   
   $dealer_code=$dealer[0];
   
   $dealer_all = find_all_field('personnel_basic_info','',"joining_designation=".$dealer_code);

?>

  
  
  
  



 
  <!--<div>

<label style="width:220px;">Marketing Team: </label>


		 
		<input name="marketing_team" type="hidden" id="marketing_team"    style="width:250px;" value="<?=$dealer_all->marketing_team?>" tabindex="105" />
		
		<input name="marketing_team2" type="text" id="marketing_team2"   style="width:250px;"
		 value="<?=find_a_field('marketing_team','team_name',"team_code=".$dealer_all->marketing_team);?>" tabindex="105" />
		
		<select name="marketing_team" type="text" id="marketing_team">
		 		<option value="<?php echo $dealer_all->team_code;?>"><?php echo find_a_field('marketing_team','team_name','team_code="'.$dealer_all->marketing_team.'"');?></option>
		 		<?=foreign_relation('marketing_team','team_code','team_name',$_POST['marketing_team'],'1');?>
		 </select>-->

		
<!--</div>-->


<div>

<label style="width:220px;"> </label>


		 
		
		 
		  <input type="text" name="joining_designation" id="joining_designation" value="<?=find_a_field('designation','DESG_DESC','DESG_ID='.$dealer_all->joining_designation);?>" />
		 


		
</div>










