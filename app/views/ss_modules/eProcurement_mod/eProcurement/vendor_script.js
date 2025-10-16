function get_vendor(search_with,search_text){
	 getData2('get_vendor_ajax.php','vendor_detailss',search_with,search_text);
	 document.getElementById('search_box').value='';
	}
	
function save_vendor(company,vendor_name,vendor_category,contact_person_name,email,address,beneficiary_name,status,tin,cc_email,country){
	
	var second_part = vendor_name+'|'+vendor_category+'|'+contact_person_name+'|'+email+'|'+address+'|'+beneficiary_name+'|'+status+'|'+tin+'|'+cc_email+'|'+country;
	 /*document.getElementById('vendor_company').value = '';
	 document.getElementById('contact_person_name').value = '';
	 document.getElementById('email').value = '';
	 document.getElementById('country').value = '';*/
	 
	 ////////
		document.getElementById('vendor_name').value = '';
		document.getElementById('vendor_category').value = '';
		document.getElementById('contact_person_name').value = '';
		document.getElementById('email').value = '';
		document.getElementById('address').value = '';
		
		document.getElementById('beneficiary_name').value = '';
		document.getElementById('status').value = '';
		document.getElementById('tin').value = '';
		document.getElementById('cc_email').value = '';
		document.getElementById('country').value = '';
	 ///////
	 if (validateEmail(email)) {
		getData2SpecialCharecter('save_vendor_ajax.php','vendor_detailss',company,second_part);

	  } else {
       alert("Email is invalid");
	  }
	 
	}
	
/*function assign_vendor(rfq_no,vendor){
	var vendor_checked = document.getElementById('vendor_id_'+vendor).checked;
	if(vendor_checked==true){
	getData2('event_vendor_insert_ajax.php','selected_vendor_detailss',rfq_no,vendor);
	}
	}*/


function assign_vendor(rfq_no,vendor) {
  var vendor_checked = document.getElementById('vendor_id_'+vendor).checked;
  if(vendor_checked==true){
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'event_vendor_insert_ajax.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.send('data=' + rfq_no + '##' +vendor);
  xhr.onload = function() {
                if (xhr.status == 200) {
					var res = JSON.parse(xhr.responseText);
                   document.getElementById('selected_vendor_detailss').innerHTML = res['table'];
				   document.getElementById('preview_button').innerHTML = res['button'];
					
                }
            };
  }
}


function remove_vendor(vendor){
	getData2('remove_vendor_ajax.php','selected_vendor_detailss',vendor,vendor);
	}
	
	function clear_vendor_search(){
		var type = '';
	getData2('clear_vendor_search_ajax.php','vendor_detailss',type,type);
	}
	
function mail_send(){
	var vendor = '';
	
	getData2('mail_sender_ajax.php','mail_msg',vendor,vendor);
	}	

  function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email regex pattern
    return emailPattern.test(email);
  }

  function userCopy(value) {
    const emailInput = document.getElementById("email");
    const errorMessage = document.getElementById("emailError");

    if (validateEmail(value)) {
      emailInput.style.borderColor = "green"; // Indicate valid email
      errorMessage.textContent = ""; // Clear error message
    } else {
      emailInput.style.borderColor = "red"; // Indicate invalid email
      errorMessage.textContent = "Please enter a valid email address.";
    }
  }
