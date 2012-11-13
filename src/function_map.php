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

$function_mapping = array(
    'ls'=>array(
        'func'=>'list_servers',
        'usage'=>'[HOST] [HOST] ...',
        'desc'=>'List running containers on OpenVZ Host(s)',
        'auto'=>'$host $host $host $host $host'
    ),
    'lsa'=>array(
        'func'=>'list_all_servers',
        'usage'=>'[HOST] [HOST] ...',
        'desc'=>'List all containers on OpenVZ Host(s)',
        'auto'=>'$host $host $host $host $host'
    ),
    'lst'=>array(
        'func'=>'list_templates',
        'usage'=>'[HOST] [HOST] ...',
        'desc'=>'List templates on OpenVZ Host(s)',
        'auto'=>'$host $host $host $host $host'
    ),
    'lsot'=>array(
        'func'=>'list_online_templates',
        'usage'=>'[SECTION]',
        'desc'=>'List avaliable template for download. Sections include beta, old, and contrib',
        'auto'=>'?beta,old,contrib'
    ),
    'install'=>array(
        'func'=>'download_template',
        'usage'=>'HOST TEMPLATE [SECTION]',
        'desc'=>'Install TEMPLATE from [SECTION] on HOST. Sections include beta, old, and contrib',
        'auto'=>'$host $template ?beta,old,contrib'
    ),
    'mv'=>array(
        'func'=>'move_container',
        'usage'=>'CURENTHOST CTID DESTHOST',
        'desc'=>'Perform an offline migration of containter CTID on CURRENTHOST to DESTHOST',
        'auto'=>'$host $ctid $host'
    ),
    'mvo'=>array(
        'func'=>'move_container_online',
        'usage'=>'CURRENTHOST CTID DESTHOST',
        'desc'=>'Perform an online migration of container CTID on CURRENTHOST to DESTHOST',
        'auto'=>'$host $ctid $host'
    ),
    'set'=>array(
        'func'=>'set_option',
        'usage'=>'HOST CTID OPTION',
        'desc'=>'Change OPTION of CTID of HOST',
        'auto'=>'$host $ctid ?memory,autoboot,cpuunit,cpulimit,cpus,diskquota,diskspace,ipadd,ipdel'
    ),
    'see'=>array(
        'func'=>'see_options',
        'usaged'=>'HOST CTID',
        'desc'=>'See configuration of CTID of HOST',
        'auto'=>'$host $ctid'

    ),
    'start'=>array(
        'func'=>'start_container',
        'usage'=>'HOST CTID',
        'desc'=>'Start container CTID on HOST',
        'auto'=>'$host $ctid'
    ),
    'stop'=>array(
        'func'=>'stop_container',
        'usage'=>'HOST CTID',
        'desc'=>'Stop containter CTID on HOST',
        'auto'=>'$host $ctid'
    ),
    'restart'=>array(
        'func'=>'restart_container',
        'usage'=>'HOST CTID',
        'desc'=>'Restart containter CTID on HOST',
        'auto'=>'$host $ctid'
    ),
    'enter'=>array(
        'func'=>'enter_container',
        'usage'=>'HOST CTID',
        'desc'=>'Enter containter CTID on HOST',
        'auto'=>'$host $ctid'
    ),
    'create'=>array(
        'func'=>'create_container',
        'usage'=>'HOST',
        'desc'=>'Create a new container on HOST',
        'auto'=>'$host'
    ),
    'rm'=>array(
        'func'=>'destroy_container',
        'usage'=>'HOST CTID',
        'desc'=>'Destroy containter CTID on HOST',
        'auto'=>'$host $ctid'
    ),
    'reboot'=>array(
        'func'=>'reboot_host',
        'usage'=>'HOST [HOST] ...',
        'desc'=>'Reboot OpenVZ Host(s)',
        'auto'=>'$host $host $host $host $host'
    ),
    'shutdown'=>array(
        'func'=>'shutdown_host',
        'usage'=>'HOST [HOST] ...',
        'desc'=>'Shutdown OpenVZ Host(s)',
        'auto'=>'$host $host $host $host $host'
    ),
    'uptime'=>array(
        'func'=>'uptime',
        'usage'=>'[HOST] [HOST] ...',
        'desc'=>'Get uptime for OpenVZ Host(s)',
        'auto'=>'$host $host $host $host $host'
    ),
    'clear'=>array(
        'func'=>'clear_screen',
        'usage'=>'',
        'desc'=>'clears all output on screen'
    ),
    'raw'=>array(
        'func'=>'raw',
        'usage'=>'HOST COMMAND',
        'desc'=>'Runs COMMAND on HOST',
        'auto'=>'$host $ctid'
    ),
    'quit'=>array(
        'func'=>'quit_program',
        'usage'=>'',
        'desc'=>'Exit/Quit the program'
    ),
    'exit'=>array(
        'func'=>'quit_program',
        'usage'=>'',
        'desc'=>'Exit/Quit to the program'
    ),
    'help'=>array(
        'func'=>'help',
        'usage'=>'[COMMAND]',
        'desc'=>'Show this help page',
        'auto'=>'$func'
    )
);

?>
