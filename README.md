VzControl - v0.2.1
=========

A CLI enviroment to monitor/administrate multiple OpenVZ Host machines and the containers on them. It is written in
php5, and uses standard tools such as vzctl and vzmigrate to facilitate all actions.

Overview
--------

VzControl is run from a command line, and gives you an interface to perform actions very easily. All commands are
based on the standard *nix utility names, so the learning curve should be mininal. The actions include
the following and more.

- List containers on some/all OpenVZ Hosts
- Start/Stop/Restart containers
- List/Download templates to OpenVZ Hosts
- Migrate containers from one OpenVZ Host to another (offline and online)
- Create a new container
- Shutdown/Reboot an OpenVZ Host
- Run custom commands on an OpenVZ Host
- Tab autocomplete of commands and container completion

Installation
------------

**Requirements**

- PHP 5.3
- SSH 
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
4. Put all the servers in your cluster into the config file (See Configuration Below)
5. *Optional* Symlink the script to PATH
    - `sudo ln ./out/vzcontrol /usr/bin/vzcontrol` If cloned from repo
    - `sudo ln .vzcontrol /usr/bin/vzcontrol` If downloaded only the script
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
4. Build `./build`
5. *Optional* Symlink the script to PATH eg. `sudo ln ./out/vzcontrol /usr/bin/vzcontrol`

Usage
-----

After you have built and configured vzcontrol, you can launch it from the out directory.

    If you did symlink the script: `vzcontrol`
    If you did not symlink: `./out/vzcontrol`

Here is a list of all commands

    ls [HOST] [HOST] ...
        List running containers on OpenVZ Host(s)

    lsa [HOST] [HOST] ...
        List all containers on OpenVZ Host(s)

    lst [HOST] [HOST] ...
        List templates on OpenVZ Host(s)

    lsot [SECTION]
        List avaliable template for download. Sections include beta, old, and contrib

    install HOST TEMPLATE [SECTION]
        Install TEMPLATE from [SECTION] on HOST. Sections include beta, old, and contrib

    mv CTID CURRENTHOST DESTHOST
        Perform an offline migration of containter CTID on CURRENTHOST to DESTHOST

    mvo CTID CURRENTHOST DESTHOST
        Perform an online migration of container CTID on CURRENTHOST to DESTHOST

    start HOST CTID
        Start container CTID on HOST

    stop HOST CTID
        Stop containter CTID on HOST

    restart HOST CTID
        Restart containter CTID on HOST

    enter HOST CTID
        Enter containter CTID on HOST

    create HOST
        Create a new container on HOST

    rm HOST CTID
        Destroy containter CTID on HOST

    set HOST CTID OPTION
        Change OPTION of CTID of HOST
        OPTIONS include: memory, autoboot, cpuunit, cpulimit, cpus,d iskquota, diskspace, ipadd, ipdel

    see HOST CTID
        See configuration of CTID of HOST

    reboot HOST [HOST] ...
        Reboot OpenVZ Host(s)

    shutdown HOST [HOST] ...
        Shutdown OpenVZ Host(s)

    uptime [HOST] [HOST] ...
        Get uptime for OpenVZ Host(s)

    clear 
        clears all output on screen

    raw HOST COMMAND
        Runs COMMAND on HOST

    quit 
        Exit/Quit the program

    exit 
        Exit/Quit to the program

    help [COMMAND]
        Show this help page
