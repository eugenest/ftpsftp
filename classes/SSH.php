<?php

namespace FileTransfer;

class SSH implements ConnectionInterface
{
    public function __construct($user, $pass, $hostname, $port){
        
    }
    public function cd(){}
    public function pwd();
    public function download(){}
    public function upload(){}
    public function exec(){}
    public function close(){}
}