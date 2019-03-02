#!/bin/bash
sudo systemctl stop cpigeon
sudo systemctl disable cpigeon
sudo rm -f /etc/systemd/system/cpigeon.service
sudo rm -f /lib/systemd/system/cpigeon.service
sudo systemctl daemon-reload
sudo rm -rf /opt/CarrierPigeon