Generate Cloud-Init ISO Image for your Cloud/VMWare/ESXI Guest OS

A hosted version is available at https://cloud-init-iso.saurabhdatta.com/

For security purposes, no data is kept on the server. The ISO file is deleted immediately after you download it.

Background: Cloud images of popular Linux distributions like Ubuntu ship with a Cloud-Init utility that allows you to configure certain parameters using an attachable ISO image while creating your VM or Cloud instance. This little utility helps you generate the same ISO file with your settings.

Dependencies: genisoimage (https://linux.die.net/man/1/genisoimage), PHP 7, Apache web server.

Run composer update to install package dependencies.
