<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require 'assets/aws/aws-autoloader.php';

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
        $awssecretmanagerdb = base64_encode($resultDB['SecretString']);
    } else {
        $awssecretmanagerdb = $resultDB['SecretBinary'];
    }

    if (isset($resultFTP['SecretString'])) {
        $awssecretmanagerftp = base64_encode($resultFTP['SecretString']);
    } else {
        $awssecretmanagerftp = $resultFTP['SecretBinary'];
    }

    echo "DB : $awssecretmanagerdb";
    echo "<br>";
    echo "FTP : $awssecretmanagerftp";
?>
