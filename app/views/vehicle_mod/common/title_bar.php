

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

	$_SESSION['vehical_selected'] = $_POST['vehical_selected'];

}?>





<div class="card" style="margin-top:0px; padding:0px">
<div class="card-body border border-danger rounded" style="background-color:#494BA4; color:#FFFFFF;">
  
  
 



<div class="row">


           <? if($_SESSION['vehical_selected']>0){ 

		   $sql =  @mysql_query("select vehicle_id,vehicle_name
		   from  vehicle_info where vehicle_id = ".$_SESSION['vehical_selected']."");

		   $row = @mysql_fetch_object($sql);

		  ?>


<?php /*?><div class="col-2">
<div class="profile_info">
<!--<img src="../../../assets/support/upload_view.php?name=<?=$row->PBI_PICTURE_ATT_PATH?>&folder=hrm_emp_pic" alt="#">  -->
</div>
</div><?php */?>

<div class="col-5">
  <ul class="list-unstyled">
  <li style="font-family:verdana; font-weight:bold;font-size:18px;">Vehical Name : <?=$row->vehicle_name;?></li>
  <li style="font-family:'Courier New';font-weight:bold; font-style:italic;font-size:16px;padding-top:5px">Vehical ID:  <?=$row->vehicle_id;?> </li>
 
 <ul>




  
</div>



  <? }else{?>




<div class="col-md-5">
<div>
  <ul class="list-unstyled">
   <li style="font-family:verdana; font-weight:bold;font-size:18px;">Vehical Name : </li>
  <li style="font-family:'Courier New';font-weight:bold; font-style:italic;font-size:16px;padding-top:5px">Vehical ID: </li>
 <ul>

</div>


</div>



<? }?>


<div class="col-5">



  
<form action="" method="post">


            <div class="form-group"><!--<label>Employee Identification Number</label>--></div>

            <div class="p-1 bg-danger rounded rounded-pill shadow-sm mb-4">
            <div class="input-group">
			
              <input type="search" list='eip_ids' name="vehical_selected" id="vehical_selected" value="<?=$_SESSION['vehical_selected']?>"
			   placeholder="Search Vehical Name & ID!" aria-describedby="button-addon1" class="form-control border-0 bg-light">
			   
			   
              <div class="input-group-append">
                <button id="button-addon1" name="button"  type="submit" class="btn btn-danger"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </div>
		  
	
		
<datalist id='eip_ids'>
  <option></option>
  <?
foreign_relation('vehicle_info','vehicle_id','concat(vehicle_id," - ",vehicle_name)',$vehical_selected,'1');
?>
</datalist>  
  
<!--<div class="input-group">
<input type="search" name="vehical_selected" id="vehical_selected" class="form-control rounded" placeholder="Search" aria-label="Search" 
aria-describedby="search-addon" value="<? //=$_SESSION['vehical_selected']?>" />

<input type="submit" name="button" class="btn btn-outline-danger" id="button" value="Search"  /> 
</div>-->


</form>
  
</div>


</div>


          


  </div>
</div>