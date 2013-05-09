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

require 'Hoa/Core/Core.php';
require 'Hoa/Console/Readline/Readline.php';
require 'Hoa/Console/Readline/Password.php';
require 'App/App.php';
require 'functions.php';

$doMake = false;
$config_file = false;
$verbose = false;

$gopt = getopt('s:c:vmh');

if(array_key_exists('h', $gopt)){
    echo <<<EOT
VZControl

VZControl allows you to easily control OpenVZ hosts and containers

Usage:

-h   Show this help
-c   Define a custom config (Defaults to ~/.vzcontrol.conf)
-m   Make a default config file
-s   TMP Location for SSH Sockets (If set to same for multiple instances they we will share sockets)
-v   Turn on verbose mode (Warnings only)
-vv  Turn on verbose mode (Warnings and logs)

EOT;
    exit(1);
}
if(array_key_exists('m', $gopt)) $doMake = true;
if(array_key_exists('v', $gopt)) $verbose = count($gopt['v']);
if(array_key_exists('c', $gopt)) $config_file = $gopt['c'];
if(array_key_exists('s', $gopt)) $socket = $gopt['s']; else $socket = '/tmp/';

if($config_file === false){
    if(!isset($_SERVER['HOME'])){
        putLine('No config file was given, and your home directory could not be found');
        exit(1);
    }
    $config_file = $_SERVER['HOME'].'/.vzcontrol.conf';
}

if($doMake){
    if(!writeInitialINIFile($config_file)){
        putLine('Failed to write a config file "'.$config_file.'"');
        exit(1);
    }
}

if(!file_exists($config_file)){
    putLine("No config file could be found, Please run with make param");
    exit(1);
}



$servers = parse_ini_file($config_file,true);

App::setup();
App::$isVerbose = $verbose;
App::$config_location = $config_file;
App::addModule('Servers');
App::m('Servers')->setServers($servers);
App::addModule('SSH',$socket);
App::addModule('Actions');
App::addModule('Utils');
App::addModule('Validate');

App::reader()->setAutocomplete('autocompleterParse');

App::showHeader();

while(1){
    $line = App::r('VZControl> ');
    $line = explode(' ',$line,2);
    $command = $line[0];
    $args = isset($line[1])?$line[1]:null;
    if(strlen($command) == 0){
        App::line('No command was given.');
    }
    if(!App::m('Actions')->run($command,$args))
        App::m('Actions')->run('help',$command);
}

?>
