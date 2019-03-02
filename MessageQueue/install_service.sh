#!/bin/bash
sudo mkdir /opt/CarrierPigeon
sudo ln -s MessageQueue /opt/CarrierPigeon/MessageQueue
sudo ln -s /opt/CarrierPigeon/MessageQueue/cpigeon.service /etc/systemd/system/cpigeon.service
sudo adduser cpigeon
sudo systemctl daemon-reload 
sudo systemctl enable cpigeon
sudo systemctl start cpigeon