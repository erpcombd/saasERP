<?php
set_time_limit(0);
ini_set('memory_limit', '2024M'); // increase if needed
ini_set('output_buffering', 'off');
ob_clean();
flush();
require 'aws_sdk/vendor/autoload.php';



use Aws\S3\S3Client;
use Aws\Exception\AwsException;

$bucketName = 'attach-backup-erp';
$region = 'ap-south-1';

// ✅ Use environment variables for security (not hardcoded)
// Put these in a secure .env file and load using getenv() or use IAM Role if on EC2
$accessKey = 'AKIAXEOVU55IK6ZVBQKL';
$secretKey = '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';

$prefix = 'reverieerp/reverie_new/';

try {
    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => $region,
        'credentials' => [
            'key'    => $accessKey,
            'secret' => $secretKey,
        ],
    ]);

    $result = $s3->listObjectsV2([
        'Bucket' => $bucketName,
        'Prefix' => $prefix
    ]);

    if (empty($result['Contents'])) {
        die('No files found.');
    }

    $zipFile = tempnam(sys_get_temp_dir(), 's3zip_') . '.zip';
    $zip = new ZipArchive();
    if ($zip->open($zipFile, ZipArchive::CREATE) !== TRUE) {
        die('Cannot create ZIP file.');
    }

    foreach ($result['Contents'] as $object) {
        $key = $object['Key'];
        if ($key === $prefix) continue;

        try {
            $file = $s3->getObject([
                'Bucket' => $bucketName,
                'Key'    => $key
            ]);

            if (!isset($file['Body'])) continue;

            $relativePath = str_replace($prefix, '', $key);
            $zip->addFromString($relativePath, $file['Body']);
        } catch (AwsException $e) {
            error_log("Error fetching file {$key}: " . $e->getMessage());
            continue;
        }
    }

    $zip->close();

    // Output the zip
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="reverie_new.zip"');
    header('Content-Length: ' . filesize($zipFile));

    readfile($zipFile);

    // Delete temp file after serving
    //unlink($zipFile);

} catch (AwsException $e) {
    http_response_code(500);
    echo 'Error: ' . $e->getMessage();
}
