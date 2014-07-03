<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

include 'file_transfer_lib.php';

use FileTransfer as FT;

$factory = new FT\Factory();

try
{
    $conn = $factory->getConnection('ssh', 'user', 'pass', 'hostname.com', 2222);
    $conn->cd('/var/www')
    ->download('dump.tar.gz')
    ->close();
}
catch(Exception $e)
{
    echo $e->getMessage();
}

try
{
    $conn = $factory->getConnection('ftp', 'user', 'pass', 'hostname.com');
    echo $conn->pwd() . "\n";
    $conn->upload('archive.zip');
    print_r($conn->exec('ls -al'));
}
catch (Exception $e)
{
    echo $e->getMessage();
} 