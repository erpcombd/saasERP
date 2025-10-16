<?php
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require 'aws_sdk/vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

$proj_id = htmlspecialchars($_GET["proj_id"]);
$folder = htmlspecialchars($_GET["folder"]);
$fileName = htmlspecialchars($_GET["name"]);

$file = '../../../media_attachment/'.$folder.'/'. $fileName;

if(file_exists($file)){

	$check  =explode('.',$_GET['name']);
	$ch = strtolower($check[1]);
	
	if($ch=='pdf'){
		header("Content-type:application/pdf");
	}elseif($ch=='jpg'){
	header('Content-Type: image/jpg');
	}elseif($ch=='png'){
	header('Content-Type: image/png');
	}elseif($ch=='PNG'){
	header('Content-Type: image/PNG');
	}elseif($ch=='jpeg'){
	header('Content-Type: image/jpeg');
	
	}elseif($ch=='JPEG'){
	header('Content-Type: image/JPEG');
	}elseif($ch=='xlsx'){
	   header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	   header('Content-Disposition: attachment; filename="' . basename($_GET['name']) . '"');
	}elseif($ch=='docx'){
	   header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
	   header('Content-Disposition: attachment; filename="' . basename($_GET['name']) . '"');
	}elseif($ch=='csv'){
	   header('Content-Type: text/csv');
	   header('Content-Disposition: attachment; filename="' . basename($_GET['name']) . '"');
	}
	 readfile($file);
}else{



// AWS S3 Config
$bucketName = 'attach-backup-erp';
    $region = 'ap-south-1';
    $accessKey = 'AKIAXEOVU55IK6ZVBQKL';
    $secretKey = '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';



$fileKey = "saas/saaserp/$folder/$fileName";
//$fileKey_old = "reverieerp/reverie_old/$proj_id/$folder/$fileName";
//$fileKey_local = "reverieerp/reverie_new/$proj_id/$folder/$fileName";

// Determine content type
$extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
$mimeTypes = [
    'pdf'  => 'application/pdf',
    'jpg'  => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png'  => 'image/png',
    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'csv'  => 'text/csv'
];

$contentType = isset($mimeTypes[$extension]) ? $mimeTypes[$extension] : 'application/octet-stream';
$inlineView = in_array($extension, ['pdf', 'jpg', 'jpeg', 'png']);

try {
    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => $region,
        'credentials' => [
            'key'    => $accessKey,
            'secret' => $secretKey,
        ],
    ]);

    // Get the object from S3
    $result = $s3->getObject([
        'Bucket' => $bucketName,
        'Key'    => $fileKey
    ]);

    // Set headers
    header("Content-Type: $contentType");
    header("Content-Length: " . $result['ContentLength']);

    if (!$inlineView) {
        header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
    }

    // Output file body
    echo $result['Body'];

} catch (AwsException $e) {
    http_response_code(404);
    echo "Error retrieving file: " . $e->getMessage();
}

}
?>
