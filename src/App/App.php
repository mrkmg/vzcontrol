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

class App {
    public static $config_location = null;
    public static $_modules = array();
    public static $_reader;
    public static $isVerbose = 0;

    static function setup(){
        self::$_reader = new Hoa\Console\Readline\Readline; 
        self::$_reader->setAutocomplete('autocompleterParse');
    }
    
    static function addModule($name,$args=null){
        if(!class_exists($name)) require_once 'App/'.$name.'.php';
        self::log('Loading new module: '.$name);
        self::$_modules[$name] = new $name($args);
    }

    static function m($name){
        return self::$_modules[$name];
    }

    static function r($prefix){
        return self::$_reader->readLine($prefix);
    }

    static function reader(){
        return self::$_reader;
    }

    static function eol(){
        return PHP_EOL;
    }

    static function line($message){
        echo $message.self::eol();
    }

    static function log($message){
        if(self::$isVerbose >= 2) fwrite(STDERR, '[log] '.$message.self::eol());
    }

    static function warn($message){
        if(self::$isVerbose >= 1) fwrite(STDERR, '[warn] '.$message.self::eol());
    }

    static function simpleHeader($header){ 
        self::line($header);
        self::line(str_repeat('-', strlen($header)));
        return true;
    }

    static function showHeader(){
        $dims = self::m('Utils')->getScreenDimensions();
        self::line(str_repeat('#', $dims[0]));
        self::line('#'.str_repeat(' ', max(ceil(($dims[0]-11)/2),0)).'VzControl'.str_repeat(' ', max(floor(($dims[0]-11)/2),0)).'#');
        self::line('#'.str_repeat(' ', max(ceil(($dims[0]-16)/2),0)).'OpenVZ Manager'.str_repeat(' ', max(floor(($dims[0]-16)/2),0)).'#');
        self::line('#'.str_repeat(' ', $dims[0]-2).'#');
        self::line('#'.str_repeat(' ', max(ceil(($dims[0]-36)/2),0)).'Created By MrKMG <kevin@mrkmg.com>'.str_repeat(' ', max(floor(($dims[0]-36)/2),0)).'#');
        self::line('# Type `help` to start'.str_repeat(' ', $dims[0]-23).'#');
        self::line('#'.str_repeat(' ', $dims[0]-9).'v'.VZC_VERSION.' #');
        self::line(str_repeat('#', $dims[0]));
    }
}
?>
