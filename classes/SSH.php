<?php

namespace FileTransfer;

class SSH implements ConnectionInterface
{
    protected $connection;
    
    public function __construct($user, $pass, $hostname, $port = 22){ //check $port param
        $this->connection = ssh2_connect($hostname, $port);
        if (!$this->connection) {
            throw new \Exception("Couldn't connect to $hostname:$port");
        }
        if (!ssh2_auth_password($this->connection, $user, $pass)) {
            throw new \Exception("Couldn't authorize with $user:$pass on $hostname:$port");
        }
    }
    
    //TODO is $path exists
    public function cd($path){
        if (!is_string($path)) {
            throw new \InvalidArgumentException('$path should be a string');
        }
        if (!ssh2_exec($this->connection, "cd $path")){
            throw new \Exception("Couldn't change directory to $path");
        }
    }
    
    public function pwd(){
        $stream = ssh2_exec($this->connection, '${PWD##*/}');
        if (!$stream) {
            throw new \Exception("Cannot read current directory or exec error");
        }
        
        stream_set_blocking( $stream, true ); 
        $response = '';
        while ($line=fgets($stream)) 
        { 
                $response .= $line; 
        }
        return $response;
    }
    
    //TODO is file exists
    //TODO is enough space
    public function download($fileName){
        if (!is_string($fileName)) {
            throw new \InvalidArgumentException('$fileName should be a string');
        }
        if (!ssh2_scp_recv($this->connection, $fileName, $fileName)){
            throw new \Exception("Cannot download file $filename");
        }
    }
    
    //TODO is file exists
    //TODO is enough space
    public function upload($fileName){
        if (!is_string($fileName)) {
            throw new \InvalidArgumentException('$fileName should be a string');
        }
        if (!ssh2_scp_send($this->connection, $fileName, $fileName)){
            throw new \Exception("Cannot upload file $filename");
        }
    }
    
    public function exec($command){
        if (!is_string($command)) {
            throw new \InvalidArgumentException('$command should be a string');
        }
        $stream = ssh2_exec($this->connection, $command);
        if (!$stream){
            throw new \Exception("Couldn't execute command $command");
        }
        
        stream_set_blocking($stream, true); 
        $response = '';
        while ($line=fgets($stream)) { 
            $response .= $line; 
        }
        return $response;
    }
    
    public function close(){
        $closeResult = ssh2_exec($this->connection, 'exit;');
        if (!$closeResult) {
            throw new \Exception("Cannot read current directory");
        }
        return $closeResult;
    }
}