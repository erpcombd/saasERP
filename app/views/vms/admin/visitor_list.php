<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$menu = 'Visitor';
$sub_menu = 'visitor_list';
$today = date('Y-m-d');
$company_id     = $_SESSION['company_id'];
?>
        
<!--Top header	-->	
<?php include("inc/header.php");?>
<?php include("inc/header_top.php");?>
        
<script>
function getXMLHTTP() { 
		var xmlhttp=false;	
		try{
			xmlhttp=new XMLHttpRequest();
		}
		catch(e)	{		
			try{			
				xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e){
				try{
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch(e1){
					xmlhttp=false;
				}
			}
		}
		return xmlhttp;
    }


function visitor_out(id){
var visitor_id=id;
var strURL="ajax_visitor_out.php?visitor_id="+visitor_id;

		var req = getXMLHTTP();

		if (req) {
			req.onreadystatechange = function() {
				if (req.readyState == 4) {
					// only if "OK"
					if (req.status == 200) {							
						document.getElementById('order_status_'+id).style.display='inline';
						document.getElementById('order_status_'+id).innerHTML=req.responseText;					
					} else {
						alert("There was a problem while using XMLHTTP:\n" + req.statusText);
					}
				}				
			}
			req.open("GET", strURL, true);
			req.send(null);
		}	
}


</script>		
		
		
<!--BODY Start	-->	
		<section class="content-main">
            <div class="content-header">
                        <h2 class="content-title">Visitor List</h2>
                        <div>
                            <a href="visitor_self_list.php"><button class="btn btn-md rounded font-sm hover-up">Visitor Request List 
                            <?php echo find1("select count(visitor_id) from visitor_table_self where sync_status=0 and company_id='".$company_id."'");?></button></a>
                            
                            <a href="visitor_entry.php"><button class="btn btn-md rounded font-sm hover-up">New Visitor</button></a>
                        </div>
                    </div>
            
              

<div class="card mb-4">

<div class="card-body">
<div class="table-responsive">
<table class="table table-striped">
    <thead>
        <tr>
      <th scope="col">LOG</th>
      <th scope="col">visitor_name</th>
	  <th scope="col">Image</th>
      <th scope="col">meet_person_name</th>

	  <th scope="col">reason_to_meet</th>
	  <th scope="col">visitor_intime</th>
	  <th scope="col">visitor_outtime</th>
	  <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
<?php 
$sql = "select v.* from visitor_table v where 1 and v.company_id='".$company_id."' and (visitor_status='In' OR visitor_enter_date='".$today."') order by visitor_status,visitor_id desc ";
$query=mysqli_query($conn, $sql);
while($data=mysqli_fetch_object($query)){
?>
    <tr>
      <td class="align-middle"><a href="visitor_card.php?log=<?php echo $data->visitor_id;?>"><?php echo $data->visitor_id;?></a></th>
	  <td class="align-middle"><?php echo $data->visitor_name;?><br><?php echo $data->visitor_mobile_no;?><br><?php echo $data->visitor_nid;?><br><?php echo $data->visitor_address;?>
	  <br>
<div class="alert alert-danger" role="alert">
<h4>Card No: <?php echo $data->visitor_card_no;?></h4>
</div>
	  
	  </td>
	  
	  
	  <td class="align-middle"><img src="visitor_image/<?php echo $data->visitor_in_image;?>"></td>
	  <td class="align-middle"><?php echo $data->visitor_meet_person_name;?><br><?php echo find1("select department_name from setup_department where department_id='".$data->visitor_department."'");?></td>
	  <td class="align-middle"><?php echo $data->visitor_reason_to_meet;?></td>
	  <td class="align-middle"><?php echo $data->visitor_enter_time;?></td>
<td class="align-middle">
<?php if($data->visitor_status=='In'){?>
<span id="order_status_<?=$data->visitor_id?>">
<input name="status" type="button" value="Out" class="btn btn-success" onClick="visitor_out(<?=$data->visitor_id?>)">
</span>
<?php }else { echo $data->visitor_out_time;} ?>	  
</td>
	  	  
        </tr>
        <?php } ?>
</tbody>
</table>	
</div></div></div>
				
				

				

<!-- /end Body page -->
			
			
			
</section> 		
<!-- Body end// -->
        
		
		
<?php include("inc/footer.php");?>