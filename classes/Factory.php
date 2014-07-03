<?php

namespace FileTransfer;

class Factory
{   
    protected $typeList;
    
    public function __construct(){
        $this->typeList = array(
            'ssh' => __NAMESPACE__ . '\SSH',
            'ftp' => __NAMESPACE__ . '\FTP'
        );
    }
    
    public function getConnection($type, $user, $pass, $hostname, $port = false){
    	
    	if (!array_key_exists($type, $this->typeList)) {
            throw new \InvalidArgumentException("$type is not valid connection type");
        }
        $className = $this->typeList[$type];

        return new $className($user, $pass, $hostname, $port);
    }
}