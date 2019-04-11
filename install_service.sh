#!/bin/bash
USEREXISTS=`grep -c cpigeon /etc/passwd`

sudo mkdir /opt/CarrierPigeon
sudo cp -r MessageQueue /opt/CarrierPigeon/
sudo cp $HOME/Email.php /opt/CarrierPigeon/MessageQueue/
if [[ USEREXISTS == 0 ]]
then
  sudo adduser cpigeon
fi
sudo mv /opt/CarrierPigeon/MessageQueue/AWS.php /opt/CarrierPigeon/MessageQueue/Database.php
sudo cp Util/carrierpigeon /etc/init.d/
sudo chkconfig --add carrierpigeon
sudo /etc/init.d/carrierpigeon start 
