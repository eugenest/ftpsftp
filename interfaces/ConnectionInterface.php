<?php

namespace FileTransfer;

interface ConnectionInterface
{
    public function cd($path);
    public function pwd();
    public function exec($command);
    public function download($fileName);
    public function upload($fileName);
    public function close();
}