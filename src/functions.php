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


function putLine($line){
    echo $line.PHP_EOL;
    return true;
}

function autocompleterParse($pre,$cur){
    if(strlen($pre)){
        $pCurrent = explode(' ',$pre);
        $func = $pCurrent[0];
        if(!$auto_str = App::m('Actions')->getAuto($func)){
            return array();
        }
        $autos = exploder(' ',$auto_str);
        $pres = exploder(' ',$pre);
        if(!isset($autos[count($pres)-1])) return array();
        $type = $autos[count($pres)-1];
        switch(substr($type,0,1)){
            case '$':
                $var = substr($type,1);
                if($var == 'host') $to_check = App::m('Servers')->getServers();
                elseif($var == 'ctid') $to_check = App::m('Servers')->getCtidFor($pres[count($pres)-1]);
                elseif($var == 'template') $to_check = getOnlinetemplates(null);
                else $to_check = array();
                break;
            case '?':
                $to_check = explode(',',substr($type,1));
                break;
            default:
                $to_check = array();
                break;
        }
    }else{
        $to_check = App::m('Actions')->getActions();
    }

    if(!$to_check) return array();
    $curlen = strlen($cur);
    $matches = array();
    foreach($to_check as $item)
        if(substr($item,0,$curlen) == $cur) $matches[] = $item;

    return $matches;

}

function getCtidFor($server_name){
    global $servers;

    $ctid_raw = returnSSH($server_name,'vzlist -a -H -1');
    $ctids = explode("\n",$ctid_raw);
    array_walk($ctids,function(&$i){ return $i = trim($i); });
    array_pop($ctids);
    return $ctids;
}

function putHeader($header){
    putLine($header);
    putLine(str_repeat('-', strlen($header)));
    return true;
}

function runSSH($server_name,$command){
    global $servers;
    global $reader;
    if(!isset($servers[$server_name])) return false;
    $reader->restoreStty();
    $command = 'ssh -q -t'
             . (isset($servers[$server_name]['port'])?' -p '.$servers[$server_name]['port']:'')
             . ' -o ConnectTimeout=2 root@'
             . $servers[$server_name]['host']
             . ' "'.str_replace('"','\\"',$command).'"';
    passthru($command,$return);
    $reader->setStty();
    return !$return;
}

function returnSSH($server_name,$command){
    global $servers;
    if(!isset($servers[$server_name])) return false;
    $command = 'ssh -q '
             . (isset($servers[$server_name]['port'])?' -p '.$servers[$server_name]['port']:'')
             . ' -o ConnectTimeout=2 root@'
             . $servers[$server_name]['host']
             . ' "'.str_replace('"','\\"',$command).'"';
    $output = shell_exec($command);
    return $output;
}



function get_templates_for_host($host){
    global $servers;

    $templates = returnSSH($host,'ls /vz/template/cache | sed s/.tar.gz//');
    $templates = explode("\n",$templates);

    return $templates;
}



function get_wanted_servers($args){
    global $servers;
    if(strlen($args)){
        $servers_wanted = explode(' ',$args);
        $servers_wanted = array_filter($servers_wanted,function($v){return !empty($v); });
        foreach($servers_wanted as $server_name){
            if(!isset($servers[$server_name])){
                putLine($server_name.' is not known');
                putLine('');
                return false;
            }
        }
    }
    else{
        $servers_wanted = array_keys($servers);
    }
    return $servers_wanted;
}



function getOnlinetemplates($args){
    $url = 'download.openvz.org';
    $folder = 'template/precreated/';
    if(strlen($args)) $folder .= $args.'/';
    $conn = ftp_connect($url);
    $log = ftp_login($conn, 'anonymous','anonymous');
    $file_list = ftp_nlist($conn, $folder);
    $file_list = array_filter($file_list,function($o){ return preg_match('/\.tar\.gz$/', $o); });
    array_walk($file_list,function(&$o,$key,$folder){ $o = substr($o,strlen($folder)); $o = substr($o,0,strlen($o)-7); },$folder);
    
    return $file_list;
}



function exploder($d,$s){
    $ar = explode($d,$s);
    $ar = array_filter($ar,function($v){return !empty($v); });
    return $ar;
}





function showBanner(){
    putLine('######################################');
    putLine('#             VzControl              #');
    putLine('#           OpenVZ Manager           #');
    putLine('#                                    #');
    putLine('# Created By MrKMG <kevin@mrkmg.com> #');
    putLine('# Type `help` to start               #');
    putLine('#                             v0.5.2 #');
    putLine('######################################');
    putLine('');
}

function writeInitialINIFile($location){
    return file_put_contents($location,
'; This is a VZControl configuration file

[local]
host = 127.0.0.1
'
);
}

?>
