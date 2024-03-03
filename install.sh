#!/bin/bash

CURRENT_USER=$(logname)

if [[ "$EUID" != 0 || "$CURRENT_USER" == "root" ]]
  then echo "Please run as sudo"
  exit
fi

# Variables
DB_ROOT_PASSWORD="spongebobsquarepants"
USERNAME="elena"
USERPASS="Sqli123!"
ROOT_USER_PASSWORD="2a75aac5a8504a8c913550464cd47de6680d98de9b0ab77c2facc8ba4c36600d"
USER_FLAG="Well done. Now manage to become root."
ROOT_FLAG="You rock!!!"

# Update and install tools
apt update
# apt upgrade -y
apt install apache2 mariadb-server php libapache2-mod-php php-mysql -y

# Set database
mysql -u root <<EOF
SET PASSWORD FOR root@localhost = '${DB_ROOT_PASSWORD}';
FLUSH PRIVILEGES;
EOF

mysql_secure_installation -u root --password="${DB_ROOT_PASSWORD}" --use-default

mysql -u root -p"${DB_ROOT_PASSWORD}" < dump.sql

# Set website
cp -r html /var/www/
chown -R www-data:www-data /var/www/html

# Manage linux users
useradd -m -s /bin/bash $USERNAME
echo "$USERNAME:$USERPASS" | chpasswd
echo "root:$ROOT_USER_PASSWORD" | chpasswd
cd /home/$USERNAME
ln -sf /dev/null .bash_history
echo "$USER_FLAG" > /home/$USERNAME/user.txt
chown -R $USERNAME:$USERNAME /home/$USERNAME

# root privesc
echo "$USERNAME ALL=(root) /usr/bin/find" > /etc/sudoers.d/$USERNAME

# Remove current user
cd /root
echo "$ROOT_FLAG" > root.txt
echo "My IP address: \4" >> /etc/issue
userdel -fr $CURRENT_USER
reboot

