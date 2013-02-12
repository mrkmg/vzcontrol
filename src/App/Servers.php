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

class Servers {
    private $servers = array();
    private $params = array(
        'host',
        'port',
        'user'
    );
    private $ctids = array();


    public function addServer($server,$host,$port=22,$user='root'){
        if(isset($this->servers[$server])) return false;
        $this->servers[$server] = array();
        $this->servers[$server]['host'] = $host;
        if($port!=22) $this->servers[$server]['port'] = $port;
        if($user!='root') $this->servers[$server]['user'] = $user;
        return true;
    }

    public function editServer($server,$option,$value){
        if(!isset($this->servers[$server])) return false;
        if(!in_array($option, $this->params)) return false;
        $this->servers[$server][$option] = $value;
        return true;
    }

    public function removeServer($server){
        unset($this->servers[$server]);
        return true;
    }

    public function setServers($servers){
        $this->servers = $servers;
        return true;
    }

    public function getIni(){
        $ini = '; This is a VZControl configuration file'.newLine();
        foreach($this->servers as $name=>$options){
            $ini .= '['.$name.']'.newLine();
            foreach($options as $k=>$v){
                $ini .= $k.' = '.$v.newLine();
            }
            $ini .= newLine();
        }
        return $ini;
    }

    public function getServers(){
        return array_keys($this->servers);
    }

    public function parseListOfServers($list){
        if(strlen($list)){
            $servers_wanted = exploder(' ',$list);
            foreach($servers_wanted as $server_name){
                if(!isset($this->servers[$server_name])){
                    putLine($server_name.' is not known');
                    putLine('');
                    return false;
                }
            }
        }
        else{
            $servers_wanted = $this->getServers();
        }
        return $servers_wanted;
    }

    public function getUriFor($host){
        if(!isset($this->servers[$host])) return false;
        if(!isset($this->servers[$host]['host'])) return false;
        return $this->getUserFor($host).'@'.$this->servers[$host]['host'];
    }

    public function getUserFor($host){
        if(!isset($this->servers[$host])) return false;
        if(!isset($this->servers[$host]['user'])) return 'root';
        return $this->servers[$host]['user'];
    }

    public function getCtidFor($host){
        if(!$uri = $this->getUriFor($host)) return false;
        $ctid_raw = App::m('SSH')->ret($uri,'vzlist -a -H -1');
        $ctids = explode("\n",$ctid_raw);
        array_walk($ctids,function(&$i){ return $i = trim($i); });
        array_pop($ctids);
        return $ctids;
    }

    public function getTemplateFor($host){
        $templates = App::m('SSH')->ret($this->getUriFor($host),'ls /vz/template/cache | sed s/.tar.gz//');
        $templates = explode("\n",$templates);

        return $templates;
    }

}
?>
