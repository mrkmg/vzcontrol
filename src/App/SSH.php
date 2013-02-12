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

    public function run($uri,$command){
        App::reader()->restoreStty();
        $command = 'ssh -q -t'
                 . ' -o ConnectTimeout=2 '
                 . $uri
                 . ' "'.str_replace('"','\\"',$command).'"';
        passthru($command,$return);
        App::reader()->setStty();
        return $return;
    }

    public function ret($uri,$command){
        $command = 'ssh -q '
                 . ' -o ConnectTimeout=2 '
                 . $uri
                 . ' "'.str_replace('"','\\"',$command).'"';
        $output = shell_exec($command);
        return $output;
    }
}
?>
