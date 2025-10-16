<?php
session_start ();
include ("../config/access_admin.php");
include ("../config/db.php");
include '../config/function.php';
$menu = 'Visitor';
$sub_menu = 'visitor_entry';
$user_id        = $_SESSION['user_id'];
$company_id     = $_SESSION['company_id'];



$_SESSION['filename'] = 'p'.$company_id.''.$user_id.''.date('YmdHis') . '.jpeg';
?>
        
<!--Top header	-->	
<?php include("inc/header.php");?>
<?php include("inc/header_top.php");?>
<!--BODY Start	-->	

<?php
if(isset($_POST['submit'])){
	$categories			=get_safe_value($conn,$_POST['categories_id']);
	$sub_categories		=get_safe_value($conn,$_POST['sub_categories']);
	
	$sql = "insert ignore into visitor_table(categories_id,sub_categories,status) values('$categories','$sub_categories','1')";
	mysqli_query($conn,$sql);

	}
?>



		<section class="content-main">
            <div class="row">
                <div class="col-9">
                    <div class="content-header">
                        <h2 class="content-title"><a href="visitor_entry.php">Add New Visitor</a></h2>
<!--                        <div>
                            <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Save to draft</button>
                            <button class="btn btn-md rounded font-sm hover-up">Publich</button>
                        </div>-->
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
<!--                        <div class="card-header">
                            <h4>Basic</h4>
                        </div>-->
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                             
							  <div class="row">  
								<div class="mb-4 col-lg-8">
                                    <label for="product_name" class="form-label">Visitor Name</label>
                                    <input type="text" class="form-control" id="visitor_name" name="visitor_name" autocomplete="off">
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
										<label class="form-label">Visitor Indentification No</label>
										<input type="text" name="visitor_nid" id="visitor_nid" class="form-control">
										<div class="text-danger" id="nid_error"></div>
									</div>
									<div class="mb-4 col-lg-6">
										<label class="form-label">Visitor Mobile NO</label>
										<input placeholder="" type="text" name="visitor_mobile_no" id="visitor_mobile_no" class="form-control">
										<div class="text-danger" id="mobile_error"></div>
									</div>
                               </div> 
							   
							   	<div class="mb-4">
                                    <label for="product_name" class="form-label">Visitor Address</label>
                                    <input type="text" class="form-control" id="visitor_address" name="visitor_address">
                                <div class="text-danger" id="address_error"></div>
								</div>
								
								<div class="row">
                                    <div class="col-lg-4">
                                        <label class="form-label">Department</label>
                                        <select class="form-select" name="visitor_department" id="visitor_department" required>
                                          <option></option>
										   <?php optionlist("select department_id,department_name from setup_department where 1 and group_for='".$company_id."'");?> 
                                        </select>
										<div class="text-danger" id="department_error"></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label class="form-label">Meet Person</label>
                                            <input type="text" name="visitor_meet_person_name" id="visitor_meet_person_name" class="form-control">
											<div class="text-danger" id="meet_error"></div>
                                        </div>
                                    </div>
								</div>
                                <div class="mb-4">
                                    <label class="form-label">Visit Purpose</label>
                                    <input type="text" placeholder="" class="form-control" id="visitor_reason_to_meet" name="visitor_reason_to_meet">
                                </div>
<!--							<div class="row">
                                    <div class="col-lg-4">
                                        <label class="form-label">In Time</label>
										<input placeholder="" type="text" name="visitor_enter_time" id="visitor_enter_time" class="form-control">
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-4">
                                            <label class="form-label">Out Time</label>
                                            <input placeholder="" type="text" name="visitor_out_time" id="visitor_out_time" class="form-control">
                                        </div>
                                    </div>
								</div>-->
								
								
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
                            <div class="input-upload" id="my_camera">

                            </div>
							<input type=button value="Take Snapshot" id="snapshot" onClick="take_snapshot()">
							<div class="text-danger" id="image_error"></div>
							<div id="results" ></div>
							<div><?php echo $_SESSION['filename'];?></div>

<!--<input class="form-control" type="text" name="visitor_in_image" id="visitor_in_image" value="" />-->

                        </div>
                    </div> <!-- card end// -->
                
				
				</div>
            </div>
			</form>
        </section> 		
<!-- Body end// -->
        
		
		
		
		
<?php include("inc/footer.php");?>

<script type="text/javascript" src="assets/js/webcamjs/webcam.min.js"></script>
	<!-- Configure a few settings and attach camera -->
	<script language="JavaScript">
		Webcam.set({
			width: 320,
			height: 240,
			image_format: 'jpeg',
			jpeg_quality: 90
		});
		Webcam.attach( '#my_camera' );
	</script>
	<!-- A button for taking snaps -->
	
	<!-- Code to handle taking the snapshot and displaying it locally -->
	<script language="JavaScript">

		function take_snapshot() {
			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
				// display results in page
				document.getElementById('results').innerHTML = 
					'<img id="imageprev" src="'+data_uri+'"/>';		
			} );
		
		
			jQuery('#submit').show();
		
		
		}
	</script>
	
<script>

jQuery('#submit').hide();
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
		
		
/*		var myInput = document.getElementById("imageprev").src;
		if (myInput && myInput.value) {
		
		}else{
					jQuery('#image_error').html('Please take Visitor Image');
					is_error='yes';
				}*/		
		
	
	
	if(is_error==''){
	    
	    
	    // Image upload system
			var base64image =  document.getElementById("imageprev").src;
		 	Webcam.upload( base64image, 'visitor_submit.php', function(code, text) {
					 console.log('Image Save successfully');
					 
					 
			
			
		// Form data insert ajax
		jQuery.ajax({
			url:'visitor_submit.php',
			type:'post',

//data:'name='+name+'&email='+email+'&mobile='+mobile+'&password='+password,
data:'visitor_name='+visitor_name+'&visitor_nid='+visitor_nid+'&visitor_mobile_no='+visitor_mobile_no+'&image='+base64image+'&visitor_address='+visitor_address+'&visitor_meet_person_name='+visitor_meet_person_name+'&visitor_department='+visitor_department+'&visitor_reason_to_meet='+visitor_reason_to_meet+'&visitor_card_no='+visitor_card_no,

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
			
			
			
			
				});	
	    // end image upload system


//window.location = 'visitor_list.php';

jQuery('#submit').hide();
jQuery('#snapshot').hide();
jQuery('.success').show();
jQuery('.success').html('Visitor Information Insert Complete');	
   
    
} // end if error




}
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
 
 