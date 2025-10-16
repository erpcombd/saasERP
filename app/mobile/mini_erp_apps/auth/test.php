<?php
function sendSMS($to, $message) {
    $api_url = 'https://cloudmvc.clouderp.com.bd/smsapi/smsapi.php';
    $cid = isset($_SESSION['proj_id']) ? $_SESSION['proj_id'] : '';

    // Prepare options manually for PHP 5.6
    $options = array(
        'msgType' => 'T',
        'contentType' => 1,
    );

    $defaults = array(
        'msgType' => 'T',
        'contentType' => 1,
        'cid' => '',
        'ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1'
    );

    $options = array_merge($defaults, $options);

    // Prepare data
    $data = array(
        'Username' => 'fahimerp',
        'Password' => '35ggh7',
        'To' => $to,
        'Message' => $message,
        'msgType' => $options['msgType'],
        'contentType' => $options['contentType'],
        'cid' => $cid,
        'ip' => $options['ip']
    );

    // Initialize cURL
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $api_url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json'
        ),
        // Optional: disable SSL peer verification for local/dev environments
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ));

    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $error = curl_error($curl);

    curl_close($curl);

    if ($error) {
        return array(
            'success' => false,
            'error' => 'cURL Error: ' . $error
        );
    }

    $result = json_decode($response, true);

    if ($http_code === 200) {
        return array(
            'success' => true,
            'data' => $result
        );
    } else {
        return array(
            'success' => false,
            'error' => 'HTTP Error: ' . $http_code,
            'response' => $result
        );
    }
}
sendSMS('8801865482911','8801894650378');
?>
<form  action=”https://api.mobireach.com.bd/SendTextMessage” 
method="post">   
<input type="text" name="Username" value="erpcom"/>  
<input type="text" name="Password" value="AllahOnly@1"/>   
<input type="text" name="From" value="8801865482911"/> 
<input type="text" name="To" value="8801894650378" />   
<input type="text" name="Message" value="testmessage"/>   
<input type="submit" value="Submit" />   
</form>   
C