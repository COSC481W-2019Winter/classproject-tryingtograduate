#!/bin/bash
CURDIR=`pwd`
cd /var/www/html
sudo rm -rf *
sudo cp -r /home/ec2-user/classproject-tryingtograduate/WebPage/* .
sudo cp /home/ec2-user/classproject-tryingtograduate/Util/aws.html ./index.html
cd /var/www/html/PHP
sudo rm -f Database.PHP
sudo mv AWS.php Database.php
cd $CURDIR