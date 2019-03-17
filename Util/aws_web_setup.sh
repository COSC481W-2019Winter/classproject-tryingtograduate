#!/bin/bash
CURDIR=`pwd`
cd /var/www/html
sudo rm -rf *
sudo cp -r /home/ec2-user/classproject-tryingtograduate/WebPage/* .
cd /var/www/html/PHP
sudo rm -f Database.PHP
sudo mv AWS.php Database.php
cd $CURDIR