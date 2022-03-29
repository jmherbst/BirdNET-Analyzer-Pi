#!/usr/bin/env bash
# This installs BirdNET-Pi for you!

# Environment
USER=pi
HOME=/home/pi
my_dir=$HOME/BirdNET-Analyzer-Pi
pyconfig=$my_dir/config.py
caddy_url="https://dl.cloudsmith.io/public/caddy/stable/setup.deb.sh"

export USER=$USER
export HOME=$HOME
export my_dir=$my_dir
export pyconfig=$pyconfig

# Variables
dependencies=(git python3-dev python3-venv python3-pip ffmpeg caddy sqlite3 alsa-utils pulseaudio)

echo "Adding dependency repos to apt-sources"
curl -1sLf "$caddy_url" | sudo -E bash

echo "Updating system"
sudo apt update && sudo apt -y upgrade

echo "Installing dependencies"
sudo apt -y install ${dependencies[@]}

install_recording_service() {
  echo "Installing birdnet_recording.service"
  cat <<- EOF > /home/pi/BirdNET-Analyzer-Pi/templates/birdnet_recording.service
    [Unit]
    Description=BirdNET Recording
    [Service]
    Environment=XDG_RUNTIME_DIR=/run/user/1000
    Restart=always
    Type=simple
    RestartSec=3
    User=${USER}
    ExecStart=/home/pi/BirdNET-Analyzer-Pi/birdnet_recording.sh
    [Install]
    WantedBy=multi-user.target
  EOF
  sudo ln -sf /home/pi/BirdNET-Analyzer-Pi/templates/birdnet_recording.service /usr/lib/systemd/system
  sudo systemctl enable birdnet_recording.service
}