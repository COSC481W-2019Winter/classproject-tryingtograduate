#!/bin/bash
sudo /etc/init.d/carrierpigeon stop
sudo chkconfig --del carrierpigeon
sudo rm -f /etc/init.d/carrierpigeon
sudo rm -rf /opt/CarrierPigeon
