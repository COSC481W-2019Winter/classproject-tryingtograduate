#!/bin/bash
sudo mkdir /opt/CarrierPigeon
sudo cp -r MessageQueue /opt/CarrierPigeon/
sudo cp Util/cpigeon.service /lib/systemd/system/
sudo ln -s /lib/systemd/system/cpigeon.service /etc/systemd/system/cpigeon.service
sudo adduser cpigeon
sudo systemctl daemon-reload 
sudo systemctl enable cpigeon
sudo systemctl start cpigeon
sudo systemctl status cpigeon