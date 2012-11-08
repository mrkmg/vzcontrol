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

require('Hoa/Core/Core.php');
require('Hoa/Console/Readline/Readline.php');
require('Hoa/Console/Readline/Password.php');
require('functions.php');
require('function_map.php');
require('conf/config.php');


$reader = new Hoa\Console\Readline\Readline;
$reader->setAutocomplete(arraY_keys($function_mapping));
showBanner();
while(1){
    $line = $reader->readLine('VzControl>');
    $line = explode(' ',$line,2);
    $command = $line[0];
    $args = isset($line[1])?$line[1]:null;
    if(strlen($command) == 0){
        
    }
    elseif(!isset($function_mapping[$command])){
        putLine('Command not found');
    }
    else{
        if(!$function_mapping[$command]['func']($args))
            help($command);
    }
}

?>
