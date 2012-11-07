VzControl
=========

Installation / Building
-----------------------

*Requirements*
- PHP5
- SSH

1. Clone the repo `git clone https://github.com/mrkmg/vzcontrol.git`
2. Enter Dir `cd vzcontrol`
3. Build `./build`

Configuration
-------------

1. Make sure the root account on all OpenVZ hosts have their ssh keys shared among each other. For a smoother experience in vzcontrol, you should share your accounts ssh key with all the OpenVZ hosts as well.
2. Modify `out/config.php`. Follow instructions in that file

Usage
-----

After you have built and configured vzcontrol, you can launch it from the out directory.

    ./vzcontrol

Here is a list of all commands

    ls [server1] [server2] [etc]
        List running containers on servers

    lsa [server1] [server2] [etc]
        List all containers on servers

    lst [server1] [server2] [etc]
        List templates on server

    lsot [section]
        List avaliable template for download

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
