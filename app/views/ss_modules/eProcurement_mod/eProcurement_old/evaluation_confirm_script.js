function evaluation_confirmation(){
var formData = $('#ep_form').serialize();
$.ajax({
url:"evaluation_confirmation_ajax.php",
method:"POST",
dataType:"JSON",
data: formData,
success: function(result, msg){
var res = result;

setTimeout(function() {
    $("#confirmation_msg").html(res['success']);
	if(res['success_code']==1){
		get_response_details();
	 window.close();
	}
}, 2000);

$("#confirmation_msg").html('Processing...');

}
}); 
}

