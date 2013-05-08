<?php

/**
 * 
 * Copyright (c) 2012 Kevin Gravier <kevin@mrkmg.com>
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

    private $uris = array();

    public function __construct(){
        register_shutdown_function(array($this,'closeConnections'));
    }

    public function closeConnections(){
        foreach($this->uris as $uri=>$soc){
            App::log('Closing ssh connection with id: '.$soc);
            exec('ssh -O stop -S /tmp/vzcontrol_ssh_'.$soc.' '.$uri.' > /dev/null 2>&1');
        }
    }

    private function getConnection($uri){
        if(!isset($this->uris[$uri])){
            $this->makeConnection($uri);
        }
        return '-S /tmp/vzcontrol_ssh_'.$this->uris[$uri].' '.$uri;
    }

    private function makeConnection($uri){
        $soc = rand(1000,9999);
        App::log('Starting ssh connection with id: '.$soc);
        exec('ssh '.$uri.' -o "ControlPersist=yes" -fNMS /tmp/vzcontrol_ssh_'.$soc.' > /dev/null 2>&1');
        App::log('Connection Started with id: '.$soc);
        $this->uris[$uri] = $soc;
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
                 . $uri
                 . ' "'.str_replace('"','\\"',$command).'"';
        App::log('Running SSH Command: '.$command);
        $output = shell_exec($command);
        return $output;
    }
}
?>
