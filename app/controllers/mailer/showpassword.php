<?php
define('AES_KEY', 'ROBI');
define('AES_IV', '1234567890123456');
function auth_encode($data){
    $dataToEncrypt = $data;
    $key = AES_KEY;
    $iv = AES_IV;
    $encryptedData = openssl_encrypt($dataToEncrypt, 'aes-256-cbc', $key, 0, $iv);
    return urlencode(base64_encode($encryptedData));
}
// echo auth_encode('fahim1234');
echo '<br>';
echo url_decode('V09VTUNOUU95RmxqR053eENoZG1vQT09');

function url_decode($data){
    $encryptedData = base64_decode(urldecode($data));
    $key = AES_KEY;
    $iv = AES_IV;
    $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
    return $decryptedData;
}
?>