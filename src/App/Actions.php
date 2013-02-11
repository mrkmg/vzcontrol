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

class Actions {
    private $map = array(
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
                'desc'=>'List available template for download. Sections include beta, old, and contrib',
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
                'desc'=>'Perform an offline migration of container CTID on CURRENTHOST to DESTHOST',
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
                'usage'=>'HOST CTID',
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
                'desc'=>'Stop container CTID on HOST',
                'auto'=>'$host $ctid'
            ),
            'restart'=>array(
                'func'=>'restart_container',
                'usage'=>'HOST CTID',
                'desc'=>'Restart container CTID on HOST',
                'auto'=>'$host $ctid'
            ),
            'enter'=>array(
                'func'=>'enter_container',
                'usage'=>'HOST CTID',
                'desc'=>'Enter container CTID on HOST',
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
                'desc'=>'Destroy container CTID on HOST',
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
            'tops'=>array(
                'func'=>'tops',
                'usage'=>'[HOST] [HOST] ...',
                'desc'=>'Get the top for OpenVZ Host(s)',
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
                'auto'=>'$host'
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
            ),
            'addserver'=>array(
                'func'=>'add_server',
                'usage'=>'NAME HOST [PORT]',
                'desc'=>'Add a server to the configuration'
            ),
            'removeserver'=>array(
                'func'=>'remove_server',
                'usage'=>'NAME',
                'desc'=>'Remove a server to the configuration',
                'auto'=>'$host'
            ),
            'writeconfig'=>array(
                'func'=>'write_config',
                'usage'=>'',
                'desc'=>'Writes the vzcontrol config file. Use after you add or remove servers'
            ),
            'showconfig'=>array(
                'func'=>'show_config',
                'usage'=>'',
                'desc'=>'Displays the VZControl config contents.'    
            )
        );

    public function getActions(){
        return array_keys($this->map);
    }

    public function getUsage($action){
        echo 'getting usage';
        if(!isset($this->map[$action]['usage'])) return false;
        return $this->map[$action]['usage'];
    }

    public function getDesc($action){
        if(!isset($this->map[$action]['desc'])) return false;
        return $this->map[$action]['desc'];
    }

    public function getAuto($action){
        if(!isset($this->map[$action]['auto'])) return false;
        return $this->map[$action]['auto'];
    }

    public function run($action,$args){
        if(!isset($this->map[$action])) return false;
        else return $this->{$this->map[$action]['func']}($args);
    }

    private function list_servers($args,$all=false){
        if(!$servers_wanted = App::m('Servers')->parseListOfServers($args)) return false;

        foreach($servers_wanted as $server_name){
            putHeader('Listing for '.$server_name);
            if(App::m('SSH')->run(App::m('Servers')->getUriFor($server_name),'vzlist'.($all?' -a':'')) == SSH::SSH_FAILED){
                putLine($server_name.' is not online');
            }
            putLine('');
        }
        return true;
    }

    private function list_all_servers($args){
        return $this->list_servers($args,true);
    }

    private function move_container($args,$live=false){
        $args = App::m('Utils')->exploder(' ',$args);
        if(count($args) !== 3){
            putLine('Incorrect usage.');
            return false;
        }
        $source = $args[0];
        $ctid = $args[1];
        $dest = $args[2];

        if(!$suri = App::m('Servers')->getUriFor($source)){
            putLine($source.' was not found');
            return false;
        }
        if(!$duri = App::m('Servers')->getUriFor($dest)){
            putLine($dest.' was not found');
            return false;
        }

        $result = App::m('SSH')->run($suri,'vzmigrate'.($live?' --online ':' ').$duri.' '.$ctid);
        if($result==SSH::COMMAND_FAILED)
            putLine('Migration Failed');
        elseif($result==SSH::SSH_FAILED)
            putLine($source.' is offline');
        return !$result;
    }

    private function move_container_online($args){
        return $this->move_container($args,true);
    }

    private function stop_container($args){
        $args = App::m('Utils')->exploder(' ',$args);
        $host = $args[0];
        $ctid = $args[1];

        if(!$uri = App::m('Servers')->getUriFor($host)){
            putLine($host.' is not known');
            return false;
        }

        $result = App::m('SSH')->run($uri,'vzctl stop '.$ctid);
        if($result==SSH::COMMAND_FAILED)
            putLine('Stop Failed');
        elseif($result==SSH::SSH_FAILED)
            putLine($source.' is offline');
        return !$result;
    }

    private function start_container($args){
        $args = App::m('Utils')->exploder(' ',$args);
        $host = $args[0];
        $ctid = $args[1];

        if(!$uri = App::m('Servers')->getUriFor($host)){
            putLine($host.' is not known');
            return false;
        }

        $result = App::m('SSH')->run($uri,'vzctl start '.$ctid);
        if($result==SSH::COMMAND_FAILED)
            putLine('Stop Failed');
        elseif($result==SSH::SSH_FAILED)
            putLine($source.' is offline');
        return !$result;
    }

    private function restart_container($args){
        $args = App::m('Utils')->exploder(' ',$args);
        $host = $args[0];
        $ctid = $args[1];

        if(!$uri = App::m('Servers')->getUriFor($host)){
            putLine($host.' is not known');
            return false;
        }

        $result = App::m('SSH')->run($uri,'vzctl restart '.$ctid);
        if($result==SSH::COMMAND_FAILED)
            putLine('Stop Failed');
        elseif($result==SSH::SSH_FAILED)
            putLine($source.' is offline');
        return !$result;
    }

    private function enter_container($args){
        $args = App::m('Utils')->exploder(' ',$args);
        $host = $args[0];
        $ctid = $args[1];

        if(!$uri = App::m('Servers')->getUriFor($host)){
            putLine($host.' is not known');
            return false;
        }

        $result = App::m('SSH')->run($uri,'vzctl enter '.$ctid);
        if($result==SSH::COMMAND_FAILED)
            putLine('Stop Failed');
        elseif($result==SSH::SSH_FAILED)
            putLine($source.' is offline');
        return !$result;
    }

    private function create_container($args){
        $reader = App::reader();
        $args = trim($args);
        if(!$uri = App::m('Servers')->getUriFor($args)){
            putLine($args.' is not known');
            return false;
        }
        global $___HOST;
        $___HOST = $args;

        $_oldAuto = $reader->getAutocomplete();
        $reader->removeAutocomplete();
        putLine('You will be prompted for a series of details.');
        $ctid = $reader->readLine('CTID? ');
        $reader->setAutocomplete(function($pre,$cur){
            global $___HOST;
            $templates = App::m('Servers')->getTemplateFor($___HOST);
            $curlen = strlen($cur);
            $matches = array();
            foreach($templates as $item)
                if(substr($item,0,$curlen) == $cur) $matches[] = $item;

            return $matches;
        });
        $ostemplate = $reader->readLine('OS Template? ');
        $reader->removeAutocomplete();
        $ipaddr = $reader->readLine('IP Address? ');
        $hostname = $reader->readLine('Hostname? ');
        $nameserver = $reader->readLine('Nameserver? ');
        $pReader = new Hoa\Console\Readline\Password;
        $tries = 0;
        do{
            $rootPassword    =  $pReader->readLine('Root Password? ');
            $confirmPassword =  $pReader->readLine('Confirm? ');
            $tries++;
        }while($tries <= 3 and !((!empty($rootPassword) and $rootPassword == $confirmPassword) or !putLine('Passwords did not match')));
        if($tries > 3){
            putLine('Quiting, password did not match');
            return false;
        }
        putLine('Going to create a new container on '.$args);
        putLine('CTID: '.$ctid);
        putLine('OS Template: '.$ostemplate);
        putLine('IP Address: '.$ipaddr);
        putLine('Hostname: '.$hostname);
        putLine('Nameserver: '.$nameserver);
        $confirm = $reader->readLine('Are you sure you want to create this container? (y/N)> ');
        if(!in_array($confirm,array('y','Y','yes','Yes','YES'))){
            return true;
        }
        $reader->setAutocomplete($_oldAuto);
        putLine('Creating container');
        $return = App::m('SSH')->run($uri,'vzctl create '.$ctid.' --ostemplate '.$ostemplate);
        if($return == SSH::SSH_FAILED)
        {
            putLine($args. 'is offline');
        }
        elseif($return == SSH::COMMAND_FAILED){
            putLine('Failed to create container');
        }
        if(!$return){
            App::m('SSH')->run($uri,'vzctl set '.$ctid.' --ipadd '.$ipaddr.' --save');
            App::m('SSH')->run($uri,'vzctl set '.$ctid.' --nameserver '.$nameserver.' --save');
            App::m('SSH')->run($uri,'vzctl set '.$ctid.' --hostname '.$hostname.' --save');
            App::m('SSH')->run($uri,'vzctl set '.$ctid.' --userpasswd root:'.$rootPassword.' --save');
        }
        return true;
    }

    private function destroy_container($args){
        $args = App::m('Utils')->exploder(' ',$args);
        $host = $args[0];
        $ctid = $args[1];

        if(!$uri = App::m('Servers')->getUriFor($host)){
            putLine($host.' is not known');
            return false;
        }

        $confirm = App::r('Are you sure you want to destroy '.$ctid.'? (y/N) ');
        if(!in_array($confirm,array('y','Y','yes','Yes','YES'))){
            return true;
        }

        $result = App::m('SSH')->run($uri,'vzctl destroy '.$ctid);
        
        if($result==SSH::COMMAND_FAILED)
            putLine('Remove Failed');
        elseif($result==SSH::SSH_FAILED)
            putLine($source.' is offline');
        return !$result;
    }

    private function list_templates($args){
        if(!$servers_wanted = App::m('Servers')->parseListOfServers($args)) return false;

        foreach($servers_wanted as $server_name){
            putHeader('Listing Templates for '.$server_name);
            $r = App::m('SSH')->run(App::m('Servers')->getUriFor($server_name),'ls /vz/template/cache | sed s/.tar.gz//');
            if($r==SSH::SSH_FAILED) putLine($server_name.' is offline');
            putLine('');
        }

        return true;
    }

    private function uptime($args){
        if(!$servers_wanted = App::m('Servers')->parseListOfServers($args)) return false;

        foreach($servers_wanted as $server_name){
            putHeader('Uptime for '.$server_name);
            $r = App::m('SSH')->run(App::m('Servers')->getUriFor($server_name),'uptime');
            if($r==SSH::SSH_FAILED) putLine($server_name.' is offline');
            putLine('');
        }

        return true;
    }

    private function tops($args){
        if(!$servers_wanted = App::m('Servers')->parseListOfServers($args)) return false;

        foreach($servers_wanted as $server_name){
            putHeader('Uptime for '.$server_name);
            $r = App::m('SSH')->run(App::m('Servers')->getUriFor($server_name),'top -n 5');
            system('clear');
            if($r==SSH::SSH_FAILED) putLine($server_name.' is offline');
            putLine('');
        }

        return true;
    }

    private function list_online_templates($args){
        $url = 'download.openvz.org';
        $folder = 'template/precreated/';
        if(strlen($args)) $folder .= $args.'/';
        $conn = ftp_connect($url);
        $log = ftp_login($conn, 'anonymous','anonymous');
        $file_list = ftp_nlist($conn, $folder);
        $file_list = array_filter($file_list,function($o){ return preg_match('/\.tar\.gz$/', $o); });
        array_walk($file_list,function(&$o,$key,$folder){ $o = substr($o,strlen($folder)); $o = substr($o,0,strlen($o)-7); },$folder);
        putLine('All templates online');
        foreach($file_list as $file){
            putLine($file);
        }

        return true;
    }

    private function download_template($args){
        $url = 'download.openvz.org';
        $folder = 'template/precreated/';
        $args = App::m('Utils')->exploder(' ',$args);
        $host = $args[0];
        $template = $args[1];
        if(isset($args[2])) $folder .= $args[2].'/';

        if(!$uri = App::m('Servers')->getUriFor($host)){
            putLine($host.' is not known');
            return false;
        }

        putLine('Downloading requested template');
        $r = App::m('SSH')->run($uri,'wget http://'.$url.'/'.$folder.'/'.$template.'.tar.gz -O /vz/template/cache/'.$template.'.tar.gz --progress=bar:force');
        if($r==SSH::SSH_FAILED) putLine($host.' is offline');
        else if($r==SSH::COMMAND_FAILED) putLine('Failed to download template');
        return !$r;
    }

    private function shutdown_host($args){
        if(!$servers_wanted = App::m('Servers')->parseListOfServers($args)) return false;

        $confirm = $reader->readLine('Are you sure you want to shutdown '.implode(', ',$servers_wanted).'? (y/N)> ');
        if(!in_array($confirm,array('y','Y','yes','Yes','YES'))){
            return true;
        }

        foreach($servers_wanted as $server_name){
            putLine('Shutting down '.$server_name);
            $r = App::m('SSH')->run(App::m('Servers')->getUriFor($server_name),'shutdown -h now');
            if($r==SSH::SSH_FAILED) putLine($server_name.' is offline');
            putLine('');
        }

        return true;
    }

    private function reboot_host($args){
        if(!$servers_wanted = App::m('Servers')->parseListOfServers($args)) return false;

        $confirm = App::r('Are you sure you want to reboot '.$args.'? (y/N)> ');
        if(!in_array($confirm,array('y','Y','yes','Yes','YES'))){
            return true;
        }

        foreach($servers_wanted as $server_name){
            putLine('Rebooting '.$server_name);
            $r = App::m('SSH')->run(App::m('Servers')->getUriFor($server_name),'reboot');
            if($r==SSH::SSH_FAILED) putLine($server_name.' is offline');
            putLine('');
        }
        
        return true;
    }

    private function set_option($args){
        $araw = App::m('Utils')->exploder(' ',$args);
        if(count($araw) != 3) return false;

        $host = $araw[0];
        $ctid = $araw[1];
        $command = $araw[2];

        if(!$uri = App::m('Servers')->getUriFor($host)) return false;

        switch($command){
            case 'memory':
                $ram = App::r('Amount of RAM?> ');
                $burst = App::r('Burstable RAM?> ');
                App::m('SSH')->run($uri,'vzctl set '.$ctid.' --vmguarpages '.$ram.' --save');
                App::m('SSH')->run($uri,'vzctl set '.$ctid.' --oomguarpages '.$ram.' --save');
                App::m('SSH')->run($uri,'vzctl set '.$ctid.' --privvmpages '.$ram.':'.$burst.' --save');
                return true;
                break;
            case 'autoboot':
                $c = App::r('Start on Boot? (y/N)> ');
                $b = in_array($c,array('y','Y','yes','Yes','YES'));
                App::m('SSH')->run($uri,'vzctl set '.$ctid.' --onboot '.($b?'yes':'no').' --save');
                return true;
                break;
            case 'cpuunit':
                $units = App::r('# of units?> ');
                App::m('SSH')->run($uri,'vzctl set '.$ctid.' --cpuunits '.$units.' --save');
                return true;
                break;
            case 'cpulimit':
                $perc = App::r('Max CPU Usage (%)?> ');
                App::m('SSH')->run($uri,'vzctl set '.$ctid.' --cpulimit '.$perc.' --save');
                return true;
                break;
            case 'diskquota':
                $c = App::r('Enable Disk Quotes? (y/N)> ');
                $b = in_array($c,array('y','Y','yes','Yes','YES'));
                App::m('SSH')->run($uri,'vzctl set '.$ctid.' --diskquota '.($b?'yes':'no').' --save');
                return true;
                break;
            case 'diskspace':
                $units = App::r('Diskspace?> ');
                App::m('SSH')->run($uri,'vzctl set '.$ctid.' --diskspace '.$units.' --save');
                return true;
            case 'ipadd':
                $ip = App::r('IP to add?> ');
                App::m('SSH')->run($uri,'vzctl set '.$ctid.' --ipadd '.$ip.' --save');
                return true;
            case 'ipdel':
                $ip = App::r('IP to add?> ');
                App::m('SSH')->run($uri,'vzctl set '.$ctid.' --ipdel '.$ip.' --save');
                return true;
                break;
        }

        return false;
    }

    private function see_options($args){
        $araw = App::m('Utils')->exploder(' ',$args);
        if(count($araw) != 2) return false;

        $host = $araw[0];
        $ctid = $araw[1];


        if(!$uri = App::m('Servers')->getUriFor($host)) return false;

        return !App::m('SSH')->run($uri,'cat /etc/vz/conf/'.$ctid.'.conf');
    }

    private function help($args){
        if(strlen($args)){
            if(isset($this->map[$args])){
                $command = $args;
                $info = $this->map[$args];
                putLine($command.' '.$info['usage']);
                putLine("\t".$info['desc']);
                putLine('');
            }
            elseif($args == 'all'){
                foreach($this->map as $command=>$info){
                    putLine($command.' '.$info['usage']);
                    putLine("\t".$info['desc']);
                    putLine('');
                }
            }
            else{
                putLine('Command not found');
            }
        }
        else{
            foreach($this->map as $command=>$info){
                putLine($command.' '.$info['usage']);
            }
        }
        return true;
    }

    private function clear_screen($args){
        system('clear');
        return true;
    }

    private function quit_program($args){
        exit(0);
    }

    private function raw($args){
        $args = App::m('Utils')->exploder(' ',$args,2);
        $host = $args[0];
        $command = $args[1];

        if(!$uri = App::m('Servers')->getUriFor($host)){
            putLine('Host does not exist');
            return false;
        }

        App::m('SSH')->run($uri,$command);

        return true;
    }

    private function add_server($args){    
        $args = App::m('Utils')->exploder(' ',$args);

        return App::m('Servers')->addServer($args[0],$args[1]);
    }

    private function remove_server($args){ 
        return App::m('Servers')->removeServer($args);
    }

    private function write_config($args){
        file_put_contents($_SERVER['HOME'].'/.vzcontrol.conf', App::m('Servers')->getIni());
        return true;
    }

    private function show_config($args){
        putLine('');
        putLine(App::m('Servers')->getIni());
        return true;
    }
}
?>
