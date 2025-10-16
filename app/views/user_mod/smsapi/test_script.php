<script> 
const username = 'fahimerp'; // Replace with your username
const password = '35ggh7'; // Replace with your password
const from = '8801894949555'; // Replace with your sender number
// const to = '88<?=$customerData->mobile_no;?>'; // Replace with recipient number   PHP   variable fele dile text send  hoy
const to ='8801865482911';
const smsText = "<?php echo $plain_text;?>"; // Replace with your message
//alert(smsText);
// Construct the URL with parameters
const url = 'https://cloudmvc.clouderp.com.bd/app/views/user_mod/smsapi/smsapi.php?Username='+username+'&Password='+password+'&From='+from+'&To='+to+'&Message='+smsText;

// Send GET request using fetch API
fetch(url)
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    return response.text();
  })
  .then(data => {
    console.log(data); // Output the response
  })
  .catch(error => {
    console.error('There was a problem with the fetch operation:', error);
  });
</script>