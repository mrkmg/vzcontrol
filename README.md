VzControl - v0.1.1
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


Installation / Building
-----------------------

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
3. Edit src/config/config.php and add all your OpenVZ Hosts
4. Build `./build`
5. *Optional* Symlink the script to PATH eg. `sudo ln ./out/vzcontrol /usr/bin/vzcontrol`

Usage
-----

After you have built and configured vzcontrol, you can launch it from the out directory.

    If you did symlink the script: `vzcontrol`
    If you did not symlink: `./out/vzcontrol`

Here is a list of all commands

    ls [server1] [server2] [etc]
        List running containers on servers

    lsa [server1] [server2] [etc]
        List all containers on servers

    lst [server1] [server2] [etc]
        List templates on server

    lsot [section]
        List avaliable template for download

    install HOST TEMPLATE [section]
        Install TEMPLATE from [section] on HOST

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

    reboot server1 [server2] [etc]
        Reboot OpenVZ Host(s)

    shutdown server1 [server2] [etc]
        Shutdown OpenVZ Host(s)

    uptime [server1] [server2] [etc]
        Get uptime for OpenVZ Host(s)

    clear 
        clears all output on screen

    raw HOST COMMAND
        Runs COMMAND on HOST

    quit 
        Exit/Quit the program

    exit 
        Exit/Quit to the program

    help [command]
        Show this help page
