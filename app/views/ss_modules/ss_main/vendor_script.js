function get_vendor(search_with,search_text){
	 getData2('get_vendor_ajax.php','vendor_detailss',search_with,search_text);
	}
	
function save_vendor(company,contact_person,email,country){
	
	var second_part = contact_person+'|'+email+'|'+country;
	 document.getElementById('vendor_company').value = '';
	 document.getElementById('contact_person_name').value = '';
	 document.getElementById('email').value = '';
	 document.getElementById('country').value = '';

	 getData2('save_vendor_ajax.php','vendor_detailss',company,second_part);
	 
	}
	
function assign_vendor(rfq_no,vendor){
	getData2('event_vendor_insert_ajax.php','vendor_checked',rfq_no,vendor);
	}

function remove_vendor(vendor){
	getData2('remove_vendor_ajax.php','vendor_detailss',vendor,vendor);
	}	
	
function mail_send(){
	var vendor = '';
	
	getData2('mail_sender_ajax.php','mail_msg',vendor,vendor);
	}	