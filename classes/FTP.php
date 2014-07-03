<?php

namespace FileTransfer;

class FTP implements ConnectionInterface
{
    protected $connection;
    
    public function __construct($user, $pass, $hostname, $port = 21){ //check $port param
        $this->connection = ftp_connect($hostname, $port);
        if (!$this->connection) {
            throw new \Exception("Couldn't connect to $hostname:$port");
        }
        if (!ftp_login($this->connection, $user, $pass)) {
            throw new \Exception("Couldn't authorize with $user:$pass on $hostname:$port");
        }
    }
    
    //TODO is $path exists
    public function cd($path){
        if (!is_string($path)) {
            throw new \InvalidArgumentException('$path should be a string');
        }
        if (!ftp_chdir($this->connection, $path)){
            throw new \Exception("Couldn't change directory to $path");
        }
    }
    
    public function pwd(){
        $currentPath = ftp_pwd($this->connection);
        if (!$currentPath) {
            throw new \Exception("Cannot read current directory");
        }
        return $currentPath;
    }
    
    //TODO is file exists
    //TODO is enough space
    public function download($fileName){
        if (!is_string($fileName)) {
            throw new \InvalidArgumentException('$fileName should be a string');
        }
        if (!ftp_get($this->connection, $fileName, $fileName, FTP_BINARY)){
            throw new \Exception("Cannot download file $filename");
        }
    }
    
    //TODO is file exists
    //TODO is enough space
    public function upload($fileName){
        if (!is_string($fileName)) {
            throw new \InvalidArgumentException('$fileName should be a string');
        }
        if (!ftp_put($this->connection, $fileName, $fileName, FTP_BINARY)){
            throw new \Exception("Cannot upload file $filename");
        }
    }
    
    //TODO check is there ways to get output instead of status of command execution
    public function exec($command){
        if (!is_string($command)) {
            throw new \InvalidArgumentException('$command should be a string');
        }
        if (!ftp_exec($this->connection, $command)){
            throw new \Exception("Couldn't execute command $command");
        }
    }
    
    public function close(){
        $closeResult = ftp_close($this->connection);
        if (!$closeResult) {
            throw new \Exception("Cannot read current directory");
        }
        return $closeResult;
    }
}