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
                'desc'=>"Change OPTION of CTID of HOST\n\tOptions are: memory, autoboot, cpuunit, cpulimit, cpus, diskquota, diskspace, ipadd, ipdel, nameserver",
                'auto'=>'$host $ctid ?memory,autoboot,cpuunit,cpulimit,cpus,diskquota,diskspace,ipadd,ipdel,nameserver'
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
            '?'=>array(
                'func'=>'help',
                'usage'=>'[COMMAND]',
                'desc'=>'Show this help page',
                'auto'=>'$func'
            ),
            'addhost'=>array(
                'func'=>'add_server',
                'usage'=>'NAME HOST [PORT] [USER]',
                'desc'=>'Add a host to the configuration (Defaults: Port 22, User root)'
            ),
            'removehost'=>array(
                'func'=>'remove_server',
                'usage'=>'NAME',
                'desc'=>'Remove a host to the configuration',
                'auto'=>'$host'
            ),
            'edithost'=>array(
                'func'=>'edit_server',
                'usage'=>'HOST OPTION VALUE',
                'desc'=>'Modify a host. Options are "host, port, user"',
                'auto'=>'$host ?host,port,user'
            ),
            'writeconfig'=>array(
                'func'=>'write_config',
                'usage'=>'',
                'desc'=>'Writes the vzcontrol config file. Use after you add, edit, or remove hosts'
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
            App::simpleHeader('Listing for '.$server_name);
            if(App::m('SSH')->run(App::m('Servers')->getUriFor($server_name),'vzlist'.($all?' -a':'')) == SSH::SSH_FAILED){
                App::line($server_name.' is not online');
            }
            echo App::eol();
        }
        return true;
    }

    private function list_all_servers($args){
        return $this->list_servers($args,true);
    }

    private function move_container($args,$live=false){
        $args = App::m('Utils')->exploder(' ',$args);
        if(count($args) !== 3){
            App::line('Incorrect usage.');
            return false;
        }
        $source = $args[0];
        $ctid = $args[1];
        $dest = $args[2];

        if(!$suri = App::m('Servers')->getUriFor($source)){
            App::line($source.' was not found');
            return false;
        }
        if(!$duri = App::m('Servers')->getUrlFor($dest)){
            App::line($dest.' was not found');
            return false;
        }

        $result = App::m('SSH')->run($suri,'vzmigrate'.($live?' --online ':' ').$duri.' '.$ctid);
        if($result==SSH::COMMAND_FAILED)
            App::line('Migration Failed');
        elseif($result==SSH::SSH_FAILED)
            App::line($source.' is offline');
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
            App::line($host.' is not known');
            return false;
        }

        $result = App::m('SSH')->run($uri,'vzctl stop '.$ctid);
        if($result==SSH::COMMAND_FAILED)
            App::line('Stop Failed');
        elseif($result==SSH::SSH_FAILED)
            App::line($source.' is offline');
        return !$result;
    }

    private function start_container($args){
        $args = App::m('Utils')->exploder(' ',$args);
        $host = $args[0];
        $ctid = $args[1];

        if(!$uri = App::m('Servers')->getUriFor($host)){
            App::line($host.' is not known');
            return false;
        }

        $result = App::m('SSH')->run($uri,'vzctl start '.$ctid);
        if($result==SSH::COMMAND_FAILED)
            App::line('Stop Failed');
        elseif($result==SSH::SSH_FAILED)
            App::line($source.' is offline');
        return !$result;
    }

    private function restart_container($args){
        $args = App::m('Utils')->exploder(' ',$args);
        $host = $args[0];
        $ctid = $args[1];

        if(!$uri = App::m('Servers')->getUriFor($host)){
            App::line($host.' is not known');
            return false;
        }

        $result = App::m('SSH')->run($uri,'vzctl restart '.$ctid);
        if($result==SSH::COMMAND_FAILED)
            App::line('Stop Failed');
        elseif($result==SSH::SSH_FAILED)
            App::line($source.' is offline');
        return !$result;
    }

    private function enter_container($args){
        $args = App::m('Utils')->exploder(' ',$args);
        $host = $args[0];
        $ctid = $args[1];

        if(!$uri = App::m('Servers')->getUriFor($host)){
            App::line($host.' is not known');
            return false;
        }

        $result = App::m('SSH')->run($uri,'vzctl enter '.$ctid);
        if($result==SSH::COMMAND_FAILED)
            App::line('Stop Failed');
        elseif($result==SSH::SSH_FAILED)
            App::line($source.' is offline');
        return !$result;
    }

    private function create_container($args){
        $reader = App::reader();
        $args = trim($args);
        if(!$uri = App::m('Servers')->getUriFor($args)){
            App::line($args.' is not known');
            return false;
        }
        global $___HOST;
        $___HOST = $args;

        $_oldAuto = $reader->getAutocomplete();
        $reader->removeAutocomplete();
        App::line('You will be prompted for a series of details.');
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
        }while($tries <= 3 and !((!empty($rootPassword) and $rootPassword == $confirmPassword) or !App::line('Passwords did not match')));
        if($tries > 3){
            App::line('Quiting, password did not match');
            return false;
        }
        App::line('Going to create a new container on '.$args);
        App::line('CTID: '.$ctid);
        App::line('OS Template: '.$ostemplate);
        App::line('IP Address: '.$ipaddr);
        App::line('Hostname: '.$hostname);
        App::line('Nameserver: '.$nameserver);
        $confirm = $reader->readLine('Are you sure you want to create this container? (y/N)> ');
        if(!in_array($confirm,array('y','Y','yes','Yes','YES'))){
            return true;
        }
        $reader->setAutocomplete($_oldAuto);
        App::line('Creating container');
        $return = App::m('SSH')->run($uri,'vzctl create '.$ctid.' --ostemplate '.$ostemplate);
        if($return == SSH::SSH_FAILED)
        {
            App::line($args. 'is offline');
        }
        elseif($return == SSH::COMMAND_FAILED){
            App::line('Failed to create container');
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
            App::line($host.' is not known');
            return false;
        }

        $confirm = App::r('Are you sure you want to destroy '.$ctid.'? (y/N) ');
        if(!in_array($confirm,array('y','Y','yes','Yes','YES'))){
            return true;
        }

        $result = App::m('SSH')->run($uri,'vzctl destroy '.$ctid);
        
        if($result==SSH::COMMAND_FAILED)
            App::line('Remove Failed');
        elseif($result==SSH::SSH_FAILED)
            App::line($source.' is offline');
        return !$result;
    }

    private function list_templates($args){
        if(!$servers_wanted = App::m('Servers')->parseListOfServers($args)) return false;

        foreach($servers_wanted as $server_name){
            App::simpleHeader('Listing Templates for '.$server_name);
            $r = App::m('SSH')->run(App::m('Servers')->getUriFor($server_name),'ls /vz/template/cache | sed s/.tar.gz//');
            if($r==SSH::SSH_FAILED) App::line($server_name.' is offline');
            echo App::eol();
        }

        return true;
    }

    private function uptime($args){
        if(!$servers_wanted = App::m('Servers')->parseListOfServers($args)) return false;

        foreach($servers_wanted as $server_name){
            App::simpleHeader('Uptime for '.$server_name);
            $r = App::m('SSH')->run(App::m('Servers')->getUriFor($server_name),'uptime');
            if($r==SSH::SSH_FAILED) App::line($server_name.' is offline');
            echo App::eol();
        }

        return true;
    }

    private function tops($args){
        if(!$servers_wanted = App::m('Servers')->parseListOfServers($args)) return false;

        foreach($servers_wanted as $server_name){
            App::simpleHeader('Uptime for '.$server_name);
            $r = App::m('SSH')->run(App::m('Servers')->getUriFor($server_name),'top -n 5');
            system('clear');
            if($r==SSH::SSH_FAILED) App::line($server_name.' is offline');
            echo App::eol();
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
        App::line('All templates online');
        foreach($file_list as $file){
            App::line($file);
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
            App::line($host.' is not known');
            return false;
        }

        App::line('Downloading requested template');
        $r = App::m('SSH')->run($uri,'wget http://'.$url.'/'.$folder.'/'.$template.'.tar.gz -O /vz/template/cache/'.$template.'.tar.gz --progress=bar:force');
        if($r==SSH::SSH_FAILED) App::line($host.' is offline');
        else if($r==SSH::COMMAND_FAILED) App::line('Failed to download template');
        return !$r;
    }

    private function shutdown_host($args){
        if(!$servers_wanted = App::m('Servers')->parseListOfServers($args)) return false;

        $confirm = $reader->readLine('Are you sure you want to shutdown '.implode(', ',$servers_wanted).'? (y/N)> ');
        if(!in_array($confirm,array('y','Y','yes','Yes','YES'))){
            return true;
        }

        foreach($servers_wanted as $server_name){
            App::line('Shutting down '.$server_name);
            $r = App::m('SSH')->run(App::m('Servers')->getUriFor($server_name),'shutdown -h now');
            if($r==SSH::SSH_FAILED) App::line($server_name.' is offline');
            echo App::eol();
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
            App::line('Rebooting '.$server_name);
            $r = App::m('SSH')->run(App::m('Servers')->getUriFor($server_name),'reboot');
            if($r==SSH::SSH_FAILED) App::line($server_name.' is offline');
            echo App::eol();
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
                $ip = App::r('IP to delete?> ');
                App::m('SSH')->run($uri,'vzctl set '.$ctid.' --ipdel '.$ip.' --save');
                return true;
                break;
            case 'nameserver':
                $dns = App::r('Nameserver?> ');
                App::m('SSH')->run($uri,'vzctl set '.$ctid.' --nameserver '.$dns.' --save');
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
                App::line($command.' '.$info['usage']);
                App::line("\t".$info['desc']);
                echo App::eol();
            }
            elseif($args == 'all'){
                foreach($this->map as $command=>$info){
                    App::line($command.' '.$info['usage']);
                    App::line("\t".$info['desc']);
                    echo App::eol();
                }
            }
            else{
                App::line('Command not found');
            }
        }
        else{
            foreach($this->map as $command=>$info){
                App::line($command.' '.$info['usage']);
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
            App::line('Host does not exist');
            return false;
        }

        App::m('SSH')->run($uri,$command);

        return true;
    }

    private function add_server($args){    
        $args = App::m('Utils')->exploder(' ',$args);
        $cargs = count($args);
        if($cargs == 2) return App::m('Servers')->addServer($args[0],$args[1]);
        elseif($cargs == 3) return App::m('Servers')->addServer($args[0],$args[1],$args[2]);
        elseif($cargs == 4) return App::m('Servers')->addServer($args[0],$args[1],$args[2],$args[3]);
        else return false;
    }

    private function edit_server($args){
        $args = App::m('Utils')->exploder(' ',$args);
        if(count($args) != 3) return false;
        $server = $args[0];
        $option = $args[1];
        $value = $args[2];
        return App::m('Servers')->editServer($server,$option,$value);
    }

    private function remove_server($args){ 
        return App::m('Servers')->removeServer($args);
    }

    private function write_config($args){
        file_put_contents(App::$config_location, App::m('Servers')->getIni());
        return true;
    }

    private function show_config($args){
        echo App::eol();
        App::line(App::m('Servers')->getIni());
        return true;
    }
}
?>
