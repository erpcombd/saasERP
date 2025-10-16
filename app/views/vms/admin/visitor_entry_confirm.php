<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$menu = 'Visitor';
$sub_menu = 'visitor_entry';
$user_id        = $_SESSION['user_id'];
$company_id     = $_SESSION['company_id'];


//$_SESSION['filename'] = 'p'.$company_id.''.$user_id.''.date('YmdHis') . '.jpeg';

$id = $_GET['req'];
if($_GET['req']==''){
    redirect("home.php");
}
$data = findall("select * from visitor_table_self where visitor_id='".$id."'");
?>
        
<!--Top header	-->	
<?php include("inc/header.php");?>
<?php include("inc/header_top.php");?>
<!--BODY Start	-->	


<section class="content-main">
            <div class="row">
                <div class="col-9">
                    <div class="content-header">
                        <h2 class="content-title"><a href="visitor_entry.php">Confirm Visitor</a></h2>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">

                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                             
							  <div class="row">  
								<div class="mb-4 col-lg-8">
                                    <label for="product_name" class="form-label">Visitor Name</label>
                                    <input type="text" class="form-control" id="visitor_name" name="visitor_name" autocomplete="off" value="<?php echo $data->visitor_name?>">
                                    <div id="visitorList"></div>
                                <div class="text-danger" id="name_error"></div>
								</div>




<div class="col-lg-4">
        <label class="form-label">Card NO</label>
        <select class="form-select" name="visitor_card_no" id="visitor_card_no" required></select>
		<div class="text-danger" id="card_error"></div>
    </div>
</div>

<?php 
$ssql = 'select visitor_card_no from visitor_table where company_id="'.$company_id.'" and visitor_status="In" ';
$qquery = mysqli_query($conn, $ssql);
    while($sec = mysqli_fetch_object($qquery)){
if($sections == '') $sections .= $sec->visitor_card_no;
else $sections .= ','.$sec->visitor_card_no;
}
$live_card_list = $sections;

$card_list = find1("select card_no from setup_card_no where company_id='".$company_id."'"); 

$arr1 = explode(",", $card_list);
$arr2 = explode(",", $live_card_list);
$arr3 =array_diff($arr1,$arr2);

$available_card_list = implode(",", $arr3);


?>
<script>
var x = "<?php echo $available_card_list?>";
var options = x.split(",");

var select = document.getElementById('visitor_card_no');
for(var i=0; i<options.length; i++)
{
  select.options[i] = new Option(options[i], options[i]); //new Option("Text", "Value")
}
</script>
							  
							  <div class="row">
									<div class="mb-4 col-lg-6">
										<label class="form-label">Visitor NID/Birth Certificate No</label>
										<input type="text" name="visitor_nid" id="visitor_nid" class="form-control" value="<?php echo $data->visitor_nid?>">
										<div class="text-danger" id="nid_error"></div>
									</div>
									<div class="mb-4 col-lg-6">
										<label class="form-label">Visitor Mobile NO</label>
										<input placeholder="" type="text" name="visitor_mobile_no" id="visitor_mobile_no" class="form-control" value="<?php echo $data->visitor_mobile_no?>">
										<div class="text-danger" id="mobile_error"></div>
									</div>
                               </div> 
							   
							   	<div class="mb-4">
                                    <label for="product_name" class="form-label">Visitor Address</label>
                                    <input type="text" class="form-control" id="visitor_address" name="visitor_address" value="<?php echo $data->visitor_address?>">
                                <div class="text-danger" id="address_error"></div>
								</div>
								
								<div class="row">
                                    <div class="col-lg-4">
                                        <label class="form-label">Department</label>
                                        <select class="form-select" name="visitor_department" id="visitor_department" required>
                                          <option value="<?php echo $data->visitor_department?>"><?php echo find1("select department_name from setup_department where department_id='".$data->visitor_department."'");?></option>
										   <?php optionlist("select department_id,department_name from setup_department where 1 and group_for='".$company_id."'");?> 
                                        </select>
										<div class="text-danger" id="department_error"></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label class="form-label">Meet Person</label>
                                            <input type="text" name="visitor_meet_person_name" id="visitor_meet_person_name" class="form-control" value="<?php echo $data->visitor_meet_person_name?>">
											<div class="text-danger" id="meet_error"></div>
                                        </div>
                                    </div>
								</div>
                                <div class="mb-4">
                                    <label class="form-label">Visit Purpose</label>
                                    <input type="text" placeholder="" class="form-control" id="visitor_reason_to_meet" name="visitor_reason_to_meet" value="<?php echo $data->visitor_reason_to_meet?>">
                                </div>
								
								
<div class="mb-4">
<button name="submit" id="submit" type="button" onclick="visitor_register()" class="btn btn-success">Submit</button>
</div>

<div class="alert alert-warning success" role="alert"></div>

                            
                        </div>
                    </div> <!-- card end// -->
                    
                </div>
                
				
				
				
				
				<div class="col-lg-3">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Visitor Image</h4>
                        </div>
                        <div class="card-body">
                            <div class="input-upload2" id="my_camera">
                                <img src="visitor_image/<?php echo $data->visitor_in_image;?>" alt="<?php echo $data->visitor_in_image;?>">
                            </div>
							<div class="text-danger" id="image_error"></div>
							<div id="results" ></div>
							<div><?php echo $data->visitor_in_image;?></div>

<input class="form-control" type="hidden" name="visitor_in_image" id="visitor_in_image" value="<?php echo $data->visitor_in_image;?>" />
<input class="form-control" type="hidden" name="visitor_id" id="visitor_id" value="<?php echo $data->visitor_id;?>" />

                        </div>
                    </div>
                
				
				</div>
            </div>
			</form>
        </section> 		
<!-- Body end// -->
        
		

<?php include("inc/footer.php");?>

	
<script>

// jQuery('#submit').hide();
jQuery('.success').hide();

function visitor_register(){



	jQuery('.field_error').html('');

	var visitor_name        =jQuery("#visitor_name").val();
	var visitor_nid         =jQuery("#visitor_nid").val();
	var visitor_mobile_no   =jQuery("#visitor_mobile_no").val();
	var visitor_address     =jQuery("#visitor_address").val();
	
	var visitor_meet_person_name    =jQuery("#visitor_meet_person_name").val();
	var visitor_department          =jQuery("#visitor_department").val();
	var visitor_reason_to_meet      =jQuery("#visitor_reason_to_meet").val();
	var visitor_card_no             =jQuery("#visitor_card_no").val();
	var visitor_in_image            =jQuery("#visitor_in_image").val();
	var visitor_id                  =jQuery("#visitor_id").val();


	var is_error='';

	if(visitor_name==""){
		jQuery('#name_error').html('Please enter name'); 
		is_error='yes';
		}
	
	if(visitor_card_no==""){
		jQuery('#card_error').html('Please Select Visiting Card Number');
		is_error='yes';
	}
	
		if(visitor_mobile_no==""){
		jQuery('#mobile_error').html('Please enter Mobile Number');
		is_error='yes';
	}
	
		if(visitor_nid==""){
		jQuery('#nid_error').html('Please enter Identification Number');
		is_error='yes';
	}
	
		if(visitor_meet_person_name==""){
		jQuery('#meet_error').html('Please enter visitor_meet_person_name');
		is_error='yes';
	}
	
		if(visitor_department==""){
		jQuery('#department_error').html('Please Select Department');
		is_error='yes';
	}
		

	
	
	if(is_error==''){
			
		// Form data insert ajax
		jQuery.ajax({
			url:'visitor_submit_confirm.php',
			type:'post',

//data:'name='+name+'&email='+email+'&mobile='+mobile+'&password='+password,
data:'visitor_name='+visitor_name+'&visitor_id='+visitor_id+'&visitor_nid='+visitor_nid+'&visitor_mobile_no='+visitor_mobile_no+'&visitor_in_image='+visitor_in_image+'&visitor_address='+visitor_address+'&visitor_meet_person_name='+visitor_meet_person_name+'&visitor_department='+visitor_department+'&visitor_reason_to_meet='+visitor_reason_to_meet+'&visitor_card_no='+visitor_card_no,

			success:function(result){
			    result=result.trim();

				if(result=='insert'){

					/*jQuery('.register_msg p').html('Thank you for your registration');*/

					//window.location = 'visitor_list.php';
					console.log('Visitor Information INSERT successfully');

				}

			}	

		});
		// end form data submit	
			

jQuery('#submit').hide();
jQuery('.success').show();
jQuery('.success').html('Visitor Information Insert Complete');	
   
    
} // end if error


} // end submit
</script>	


 <script>  
 $(document).ready(function(){  
      $('#visitor_name').keyup(function(){ 
          
          if( this.value.length < 3 ) return;
           var query = $(this).val();  
           if(query != '')  
           {  
                $.ajax({  
                     url:"ajax_name.php",  
                     method:"POST",  
                     data:{query:query},  
                     success:function(data)  
                     {  
                          $('#visitorList').fadeIn();  
                          $('#visitorList').html(data);  
                     }  
                });  
           }  
      });  
      $(document).on('click', 'li', function(){  
           $('#visitor_name').val($(this).text());  
           $('#visitorList').fadeOut(); 
           
      // now fill up others information
      $.getJSON("get_visitor_info.php?visitor_name=" + $("#visitor_name").val(),
        
        function(data){
          $.each(data, function(i,item){
            if (item.field == "visitor_mobile_no") { $("#visitor_mobile_no").val(item.value);}
                
             else if (item.field == "visitor_address") { $("#visitor_address").val(item.value);}
             else if (item.field == "visitor_nid") { $("#visitor_nid").val(item.value);}
             else if (item.field == "visitor_meet_person_name") { $("#visitor_meet_person_name").val(item.value);}
             
          });
        });
         // end auto form fillup  
         
      });  
 });  
 </script> 
 
 