<?php

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
require 'aws_sdk/vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;

/*function file_upload_wasabi($fieldName) {
$bucketName = 'erpbucket-sohel';
$region = 'ap-southeast-1';
$endpoint = 'https://s3.ap-southeast-1.wasabisys.com';
$accessKey = 'K8D2RG8SY6PIU3XTUK4N';
$secretKey = 'p4E01RqlvzCAX9OmuG5TMWGNkkZu55EGCe0yv6tv';

    if (isset($_FILES[$fieldName])) {
        $file = $_FILES[$fieldName];

        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = basename($file['name']);
            $fileTmpPath = $file['tmp_name'];

            try {
                // Initialize S3 client
                $s3 = new S3Client([
                    'version' => 'latest',
                    'region' => $region,
                    'endpoint' => $endpoint,
                    'use_path_style_endpoint' => true,
                    'credentials' => [
                        'key' => $accessKey,
                        'secret' => $secretKey,
                    ],
                ]);

                // Upload file
                $result = $s3->putObject([
                    'Bucket' => $bucketName,
                    'Key' => $fileName,
                    'SourceFile' => $fileTmpPath,
                    'ACL' => 'public-read', // optional
                ]);

                $fileUrl = $result['ObjectURL'];
                $msg =  "File uploaded successfully!<br>";
                $msg =  "<a href='$fileUrl' target='_blank'>View Uploaded File</a>";
            } catch (AwsException $e) {
                $msg =  "Error uploading file: " . $e->getMessage();
            }
        } else {
            $msg = "Upload error code: " . $file['error'];
        }
    } else {
        $msg = "No file uploaded.";
    }
	
	return $msg;
}*/
function file_upload_aws($fieldName,$folder,$newFileName) {
    
    $bucketName = 'attach-backup-erp';
    $region = 'ap-south-1';
    $accessKey = 'AKIAXEOVU55IK6ZVBQKL';
    $secretKey = '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';

    if (isset($_FILES[$fieldName])) {
        $file = $_FILES[$fieldName];

        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = basename($file['name']);
			$ext = explode(".",$fileName);
			$fileName = $newFileName.'.'.$ext[1];
			$upload_path = 'saas/'.$_SESSION['proj_id'].'/'.$folder.'/'.$fileName;
            $fileTmpPath = $file['tmp_name'];

            try {
                // Initialize AWS S3 client
                $s3 = new S3Client([
                    'version' => 'latest',
                    'region' => $region,
                    'credentials' => [
                        'key' => $accessKey,
                        'secret' => $secretKey,
                    ],
                ]);

                // Upload the file
                $result = $s3->putObject([
                    'Bucket' => $bucketName,
                    'Key' => $upload_path,
                    'SourceFile' => $fileTmpPath,
                     // or 'private' if not public
                ]);

                $fileUrl = $result['ObjectURL'];
                $msg = "File uploaded successfully!<br>";
                $msg = "<a href='$fileUrl' target='_blank'>View Uploaded File</a>";
            } catch (AwsException $e) {
                $msg = "Error uploading file: " . $e->getMessage();
            }
        } else {
            $msg = "Upload error code: " . $file['error'];
        }
    } else {
        $msg = "No file uploaded.";
    }
	
	return $msg;
}

function file_upload_aws2($fieldName) {
    
    $bucketName = 'clouderp-final';
    $region = 'ap-south-1';
    $accessKey = 'AKIAXEOVU55IK6ZVBQKL';
    $secretKey = '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';

    if (isset($_FILES[$fieldName])) {
        $file = $_FILES[$fieldName];

        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = basename($file['name']);
			$upload_path = 'uploads/'.$fileName;
            $fileTmpPath = $file['tmp_name'];

            try {
                // Initialize AWS S3 client
                $s3 = new S3Client([
                    'version' => 'latest',
                    'region' => $region,
                    'credentials' => [
                        'key' => $accessKey,
                        'secret' => $secretKey,
                    ],
                ]);

                // Upload the file
                $result = $s3->putObject([
                    'Bucket' => $bucketName,
                    'Key' => $upload_path,
                    'SourceFile' => $fileTmpPath,
                     // or 'private' if not public
                ]);

                $fileUrl = $result['ObjectURL'];
                $msg = "File uploaded successfully!<br>";
                $msg = "<a href='$fileUrl' target='_blank'>View Uploaded File</a>";
            } catch (AwsException $e) {
                $msg = "Error uploading file: " . $e->getMessage();
            }
        } else {
            $msg = "Upload error code: " . $file['error'];
        }
    } else {
        $msg = "No file uploaded.";
    }
	
	return $msg;
}

function upload_view_redirect($proj, $folder, $file) {
    $url = 'upload_view.php?proj_id=' . urlencode($proj) .
           '&folder=' . urlencode($folder) .
           '&name=' . urlencode($file);
    header('Location: ' . $url);
    return $url;
}
?>
