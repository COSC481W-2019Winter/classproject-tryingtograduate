#!/bin/bash
SYSTEMD=`which systemctl| grep -c systemctl`
USEREXISTS=`grep -c cpigeon /etc/passwd`

sudo mkdir /opt/CarrierPigeon
sudo cp -r MessageQueue /opt/CarrierPigeon/
sudo cp $HOME/Email.php /opt/CarrierPigeon/MessageQueue/
if [[ USEREXISTS == 0 ]]
then
  sudo adduser cpigeon
fi
sudo cp Util/cpigeon.service /lib/systemd/system/
sudo ln -s /lib/systemd/system/cpigeon.service /etc/systemd/system/cpigeon.service
sudo systemctl daemon-reload 
sudo systemctl enable cpigeon
sudo systemctl start cpigeon
sudo systemctl status cpigeon
