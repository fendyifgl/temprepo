<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    include_once 'assets/aws/aws-autoloader.php';

    use Aws\SecretsManager\SecretsManagerClient; 
    use Aws\Exception\AwsException;

    $client = new SecretsManagerClient([
        'version' => 'latest',
        'region' => 'ap-southeast-3'
    ]);

    $secretNameDB = 'arn:aws:secretsmanager:ap-southeast-3:402663288391:secret:prd/legacy/enota-NS12tP';
    $secretNameFTP = 'arn:aws:secretsmanager:ap-southeast-3:402663288391:secret:prd/legacy/ftpenota-MK8goO';

    try {
        $resultDB = $client->getSecretValue([
            'SecretId' => $secretNameDB,
        ]);
    } catch (AwsException $e) {
        $error = $e->getAwsErrorCode();
        if ($error == 'DecryptionFailureException') {
            // Secrets Manager can't decrypt the protected secret text using the provided AWS KMS key.
            // Handle the exception here, and/or rethrow as needed.
            throw $e;
        }
        else if ($error == 'InternalServiceErrorException') {
            // An error occurred on the server side.
            // Handle the exception here, and/or rethrow as needed.
            throw $e;
        }
        else if ($error == 'InvalidParameterException') {
            // You provided an invalid value for a parameter.
            // Handle the exception here, and/or rethrow as needed.
            throw $e;
        }
        else if ($error == 'InvalidRequestException') {
            // You provided a parameter value that is not valid for the current state of the resource.
            // Handle the exception here, and/or rethrow as needed.
            throw $e;
        }
        else if ($error == 'ResourceNotFoundException') {
            // We can't find the resource that you asked for.
            // Handle the exception here, and/or rethrow as needed.
            throw $e;
        }
        else {
            throw $e;
        }
    }

    try {
        $resultFTP = $client->getSecretValue([
            'SecretId' => $secretNameFTP,
        ]);
    } catch (AwsException $e) {
        $error = $e->getAwsErrorCode();
        if ($error == 'DecryptionFailureException') {
            // Secrets Manager can't decrypt the protected secret text using the provided AWS KMS key.
            // Handle the exception here, and/or rethrow as needed.
            throw $e;
        }
        else if ($error == 'InternalServiceErrorException') {
            // An error occurred on the server side.
            // Handle the exception here, and/or rethrow as needed.
            throw $e;
        }
        else if ($error == 'InvalidParameterException') {
            // You provided an invalid value for a parameter.
            // Handle the exception here, and/or rethrow as needed.
            throw $e;
        }
        else if ($error == 'InvalidRequestException') {
            // You provided a parameter value that is not valid for the current state of the resource.
            // Handle the exception here, and/or rethrow as needed.
            throw $e;
        }
        else if ($error == 'ResourceNotFoundException') {
            // We can't find the resource that you asked for.
            // Handle the exception here, and/or rethrow as needed.
            throw $e;
        }
        else {
            throw $e;
        }
    }

    if (isset($resultDB['SecretString'])) {
        $awssecretmanagerdb = json_decode($resultDB['SecretString'], true);
    } else {
        $awssecretmanagerdb = json_decode(base64_decode($resultDB['SecretBinary']), true);
    }

    if (isset($resultFTP['SecretString'])) {
        $awssecretmanagerftp = json_decode($resultFTP['SecretString'], true);
    } else {
        $awssecretmanagerftp = json_decode(base64_decode($resultFTP['SecretBinary']), true);
    }

    $config['db_username'] = $awssecretmanagerdb['username'];
    $config['db_password'] = $awssecretmanagerdb['password'];
    $config['ftp_username'] = $awssecretmanagerftp['username'];
    $config['ftp_password'] = $awssecretmanagerftp['password'];
?>
