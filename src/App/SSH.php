<?php

/**
 * 
 * Copyright (c) 2012-2013 Kevin Gravier <kevin@mrkmg.com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell 
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A 
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 */

class SSH {
    const RESULT_GOOD=0;
    const COMMAND_FAILED=1;
    const SSH_FAILED=255;

    public $socket_location = '/tmp/';

    private $connections = array();

    public function __construct($sl){
        register_shutdown_function(array($this,'closeConnections'));
        $this->socket_location = $sl;
    }

    public function closeConnections(){
        foreach($this->connections as $uri=>$sl){
            App::log('Closing persistant ssh connection for: '.$uri);
            exec('ssh -O stop -S '.$sl.' '.$uri.' > /dev/null 2>&1');
        }
    }

    private function getSocketLocation($uri){
        $pattern = '/[^a-z0-9.]/i';
        $replacement = '';
        return $this->socket_location.'vzcs_'.preg_replace($pattern, $replacement, $uri, -1 );
    }

    private function getConnection($uri){
        $sl = $this->getSocketLocation($uri);
        if(!file_exists($sl)){
            $this->makeConnection($uri);
            $this->connections[$uri] = $sl;
        }

        return '-S '.$sl.' '.$uri;
    }

    private function makeConnection($uri){
        App::log('Starting persistant ssh connection for: '.$uri);
        exec('ssh '.$uri.' -o "ControlPersist=yes" -fNMS '.$this->getSocketLocation($uri).' > /dev/null 2>&1');
        App::log('Persistant connection started for: '.$uri);
    }

    public function run($uri,$command){
        $command = 'ssh -q -t'
                 . ' -o ConnectTimeout=2 '
                 . $this->getConnection($uri)
                 . ' "'.str_replace('"','\\"',$command).'"';
        App::log('Running SSH Command: '.$command);
        App::reader()->restoreStty();
        passthru($command,$return);
        App::reader()->setStty();
        return $return;
    }

    public function ret($uri,$command){
        $command = 'ssh -q '
                 . ' -o ConnectTimeout=2 '
                 . $this->getConnection($uri)
                 . ' "'.str_replace('"','\\"',$command).'"';
        App::log('Running SSH Command: '.$command);
        $output = shell_exec($command);
        return $output;
    }
}
?>
