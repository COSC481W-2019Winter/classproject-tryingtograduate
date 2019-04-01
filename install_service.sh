#!/bin/bash
SYSTEMD=`which systemctl| grep -c systemctl`
USEREXISTS=`grep -c cpigeon /etc/passwd`

sudo mkdir /opt/CarrierPigeon
sudo cp -r MessageQueue /opt/CarrierPigeon/
if [[ !USEREXISTS ]]
then
  sudo adduser cpigeon
fi

if [[ SYSTEMD ]]
then
  sudo cp Util/cpigeon.service /lib/systemd/system/
  sudo ln -s /lib/systemd/system/cpigeon.service /etc/systemd/system/cpigeon.service
  sudo systemctl daemon-reload 
  sudo systemctl enable cpigeon
  sudo systemctl start cpigeon
  sudo systemctl status cpigeon
else
  sudo cp Util/carrierpigeon /etc/init.d/
  sudo chkconfig --add carrierpigeon
  sudo /etc/init.d/carrierpigeon start 
fi