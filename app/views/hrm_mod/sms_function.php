<?php

function gpsms($masking, $dest_addr, $sms_text) {	
	//$masking = "SAJEEB CROP";
$dest_addr = substr($dest_addr, 2, 12);
$sms_text = trim(preg_replace('/\s\s+/', '', $sms_text));
		
	$data = array(
		"username"		=> "SajeebADMIN",
		"password"		=> "Sajeeb##1234",
		"apicode"		=> "1",
		"msisdn"		=> $dest_addr,
		"countrycode"	=> "880",
		"cli"			=> $masking,
		"messagetype"	=> "1",
		"message"		=> $sms_text,
		"messageid"		=> "0"
	);
	
	$url = "https://gpcmp.grameenphone.com/ecmapigw/webresources/ecmapigw.v2";
	$ch = curl_init( $url );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($data) );
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json') );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	
	try {
		$output = curl_exec($ch); //print_r($output);	
	} catch(Exception $ex) {
		$output = "-100";}
	
	return $output;	
}

function sms_sajeeb($dest_addr,$sms_text){
$url = "http://api.rankstelecom.com/api/v3/sendsms/plain?user=sajeebcorp&password=Sajeeb3636&sender=8804445648540";

$sms_text="&SMSText=".$sms_text;
$gsm="&gsm=".$dest_addr;
$postdata=$url.$sms_text.$gsm;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
}

function sms_erp($dest_addr,$sms_text){
$url = "http://api.rankstelecom.com/api/v3/sendsms/plain?user=ERPCOM&password=Ui0gXQcJ&sender=8804445629099";

$sms_text="&SMSText=".$sms_text;
$gsm="&gsm=".$dest_addr;
$postdata=$url.$sms_text.$gsm;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
}


function sms_rice($dest_addr,$sms_text){
$url = "http://api.rankstelecom.com/api/v3/sendsms/plain?user=sajeebrice&password=Sajeeb3636&sender=8804445648550";

$sms_text="&SMSText=".$sms_text;
$gsm="&gsm=".$dest_addr;
$postdata=$url.$sms_text.$gsm;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
}	
?>