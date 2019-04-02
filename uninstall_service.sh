#!/bin/bash
SYSTEMD=`which systemctl| grep -c systemctl`

if [[ SYSTEMD ]]
then
  sudo systemctl stop cpigeon
  sudo systemctl disable cpigeon
  sudo rm -f /etc/systemd/system/cpigeon.service
  sudo rm -f /lib/systemd/system/cpigeon.service
  sudo systemctl daemon-reload
else
  sudo /etc/init.d/carrierpigeon stop
  sudo chkconfig --del carrierpigeon
  sudo rm -f /etc/init.d/carrierpigeon
sudo rm -rf /opt/CarrierPigeon