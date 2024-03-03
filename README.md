# SQLI LAB

Thanks to this repo, you'll be able to create a vulnerable VM to perform a simple sql injection.

It is inspired of the room [Kitty V2 on TryHackMe](https://tryhackme.com/room/kitty). But it has been made easier for beginners.

The install script has been tested on Debian.

## Install

### Create the VM

First create a Debian VM. A simple one with no GUI is enough. Just enable ssh.

During installation, create a user. It will be used to set the vulnerable website and it will be automatically deleted at the end.

Once the VM is created, connect to it, and give sudo role to the user

```bash
ssh myuser@myvm
su -
adduser myuser sudo
```

Also, install git: `sudo apt install git`

### Make it vulnerable

```bash
git clone https://github.com/olivierprotips/SQLI-LAB
cd SQLI-LAB
chmod +x install.sh
sudo ./install.sh
```