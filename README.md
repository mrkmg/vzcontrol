VZControl - v0.6.2
=========

A CLI environment to monitor/administrate multiple OpenVZ Host machines and the containers on them. It is written in
php5, and uses standard tools such as vzctl and vzmigrate to facilitate all actions.


Table of Contents
-----------------

- [Overview](#overview)
- [Quick Start](#quick-start-debian)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Building](#building)

Overview
--------

VzControl is run from a command line, and gives you an interface to perform actions very easily. All commands are
based on the standard *nix utility names, so the learning curve should be minimal. The actions include
the following and more.

- List containers on some/all OpenVZ Hosts
- Start/Stop/Restart containers
- List/Download templates to OpenVZ Hosts
- Migrate containers from one OpenVZ Host to another (offline and online)
- Create a new container
- Shutdown/Reboot an OpenVZ Host
- Run custom commands on an OpenVZ Host
- Tab auto-complete of commands and containers


Quick Start (Debian)
--------------------

Install php5 pear

    apt-get install php5-cli php-pear php5-dev build-essential libpcre3-dev
    pecl install --alldeps phar

Edit suhosin to allow phar and hoa to run

    nano /etc/php/conf.d/suhosin.ini

Change `;suhosin.executor.include.whitelist = `  
to `suhosin.executor.include.whitelist = "phar,hoa"`

Download vzcontrol (compiled)  
`wget https://raw.github.com/mrkmg/vzcontrol/master/out/vzcontrol`

Make vzcontrol executable  
`chmod +x vzcontrol`

Create the default config file

    mrkmg$ ./vcontrol -m

If you are running this on a machine that is not one of your OpenVZ Hosts, remove the default server

    VZControl> removehost local

Add in your hosts

    VZControl> addhost serv1 full.host.name
    VZControl> addhost serv2 1.2.3.4
    VZControl> addhost serv3 1.2.3.5 1222   #Uses port 1222 for SSH

Write the config

    VZControl> writeconfig

List running containers on all hosts

    VZControl> ls

List all containers on all hosts

    VZControl> lsa

List running containers on serv1

    VZControl> ls serv1

Download a new template to serv3

    VZControl> install serv3 debian-6.0_X86_64

View a detailed list of all commands

    VZControl> help all

Prerequisites
------------

**Debain 6.0**

Install php5 and pear

    apt-get install php5-cli php-pear php5-dev build-essential libpcre3-dev
    pecl install --alldeps phar

Edit suhosin to allow phar and hoa to run

    nano /etc/php/conf.d/suhosin.ini

Change `;suhosin.executor.include.whitelist = ` to `suhosin.executor.include.whitelist = "phar,hoa"`

**CentOS 6**

Install php5 and mbstring
    yum install php-cli php-mbstring

Edit the php.ini to allow phars to be built

    nano /etc/php.ini

    Set "phar.readonly = Off"


Installation
------------

**Requirements**

- For each OpenVZ Host you plan on controlling, ssh keys for the root account must be shared to all other hosts

**Optional**

- Share the ssh key from the computer you are running vzcontrol on with all OpenVZ Hosts

**Steps**

1. Either clone the repo or download only the packaged script
    - `git clone https://github.com/mrkmg/vzcontrol.git`
    - `wget https://raw.github.com/mrkmg/vzcontrol/master/out/vzcontrol`
2. Make vzcontrol executable
    - `chmod +x vzcontrol`
3. Either manually create a config file or have vzcontrol generate a sample file for you
    - `./vzcontrol make` This creates a config file at `~/.vzcontrol.conf`
4. Put all the servers in your cluster into the config file (See Configuration Below) or add them via the vzcontrol interface
5. *Optional* Symlink the script to PATH
    - `sudo ln -s /path/to/repo/out/vzcontrol /usr/bin/vzcontrol` If cloned from repo
    - `sudo ln -s /path/to/downloads/vzcontrol /usr/bin/vzcontrol` If downloaded only the script
6. Run vzcontrol
    - `./out/vzcontrol` If cloned from repo
    - `./vzcontrol` If downloaded
    - `vzcontrol` If symlinked

Configuration
-------------

vzcontrol uses a configuration file to determine which servers it is able to administer. The file is very easy to understand. The file must be in the following format

    ;Sample vzcontrol.conf

    ;This is the shortname of server, something you could easily remember. Usually the systems hostname shortened
    [shortname]
    ;Every server must have a host
    host = shortname.domain.tld
    ;Port is optional, this specifies what port SSH runs on. Defaults to 22
    port = 2222

    [server2]
    host = server2.host.tld

    [server3]
    host = 1.2.3.4

You can also dynamically create this file via the vzcontrol command interface. For example, if you are starting from scratch.

    mrkmg$ vzcontrol -m
    ######################################
    #             VZControl              #
    #           OpenVZ Manager           #
    #                                    #
    # Created By MrKMG <kevin@mrkmg.com> #
    # Type `help` to start               #
    #                             v0.6.2 #
    ######################################

    VZControl> removehost local
    VZControl> addhost name1 host.domain
    VZControl> addhost name2 1.2.4.5 2222
    VZControl> writeconfig

The about command remove the sample servers added, adds two new servers, and then writes the config file.

Building
--------

**Requirements**

- PHP 5.3
    - php.ini must have "phar.readonly = Off"
- SSH 
- For each OpenVZ Host you plan on controlling, ssh keys for the root account must be shared to all other hosts

**Optional**

- Share the ssh key from the computer you are running vzcontrol on with all OpenVZ Hosts

**Steps**

1. Clone the repo `git clone https://github.com/mrkmg/vzcontrol.git`
2. Enter Dir `cd vzcontrol`
3. Build: `./build` to just build or `./build install` to build and symlink to /usr/bin/vzcontrol


Usage
-----

After you have built and configured vzcontrol, you can launch it from the out directory.

If you did symlink the script: `vzcontrol`  
If you did not symlink: `./out/vzcontrol`

Command Link Switches:

-h   Show the help
-c   Define a custom config (Defaults to ~/.vzcontrol.conf)
-m   Make a default config file
-s   Temp Location for SSH Sockets (If set to same for multiple instances they we will share sockets)
-v   Turn on verbose mode (Warnings only)
-vv  Turn on verbose mode (Warnings and logs)

Here is a list of all the commands

ls [HOST] [HOST] ...
    List running containers on OpenVZ Host(s)

lsa [HOST] [HOST] ...
    List all containers on OpenVZ Host(s)

lst [HOST] [HOST] ...
    List templates on OpenVZ Host(s)

lsot [SECTION]
    List available template for download. Sections include beta, old, and contrib

install HOST TEMPLATE [SECTION]
    Install TEMPLATE from [SECTION] on HOST. Sections include beta, old, and contrib

mv CURENTHOST CTID DESTHOST
    Perform an offline migration of container CTID on CURRENTHOST to DESTHOST

mvo CURRENTHOST CTID DESTHOST
    Perform an online migration of container CTID on CURRENTHOST to DESTHOST

set HOST CTID OPTION
    Change OPTION of CTID of HOST
    Options are: memory, autoboot, cpuunit, cpulimit, cpus, diskquota, diskspace, ipadd, ipdel, nameserver

see HOST CTID
    See configuration of CTID of HOST

start HOST CTID
    Start container CTID on HOST

stop HOST CTID
    Stop container CTID on HOST

restart HOST CTID
    Restart container CTID on HOST

enter HOST CTID
    Enter container CTID on HOST

create HOST
    Create a new container on HOST

rm HOST CTID
    Destroy container CTID on HOST

reboot HOST [HOST] ...
    Reboot OpenVZ Host(s)

shutdown HOST [HOST] ...
    Shutdown OpenVZ Host(s)

uptime [HOST] [HOST] ...
    Get uptime for OpenVZ Host(s)

tops [HOST] [HOST] ...
    Get the top for OpenVZ Host(s)

clear 
    clears all output on screen

raw HOST COMMAND
    Runs COMMAND on HOST

quit 
    Exit/Quit the program

exit 
    Exit/Quit to the program

help [COMMAND|all]
    Show the help page

? [COMMAND|all]
    Show the help page

addhost NAME HOST [PORT] [USER]
    Add a host to the configuration (Defaults: Port 22, User root)

removehost NAME
    Remove a host to the configuration

edithost HOST OPTION VALUE
    Modify a host. Options are "host, port, user"

writeconfig 
    Writes the vzcontrol config file. Use after you add, edit, or remove hosts

showconfig 
    Displays the VZControl config contents.
