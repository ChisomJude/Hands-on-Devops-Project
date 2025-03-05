# Setting up a LEMP Stack (Linux, Nginx, MySQL, PHP) on Ubuntu EC2

This guide will walk you through setting up a LEMP stack on an Ubuntu EC2 instance, pulling your website from GitHub, and configuring Nginx to serve your application.

## Prerequisites
- AWS account
- SSH client (or AWS CloudShell)
- GitHub repository with your website files

---

## Step 1: Launch an EC2 Instance
1. Log in to the **AWS Management Console**.
2. Navigate to **EC2** > **Instances**.
3. Click **Launch Instance**.
4. Select **Ubuntu 22.04 LTS** as the AMI.
5. Choose an instance type (e.g., `t2.micro` for free tier).
6. Configure security group:
   - Allow SSH (port 22) from your IP.
   - Allow HTTP (port 80) from anywhere.
7. Click **Launch** and download the private key (.pem file).

## Step 2: Connect to Your EC2 Instance
Run the following command in your terminal:
```sh
ssh -i your-key.pem ubuntu@your-ec2-public-ip
```

---

## Step 3: Update and Install Required Packages
```sh
sudo apt update && sudo apt upgrade -y
```

## Step 4: Install Nginx
```sh
sudo apt install nginx -y
```
Start and enable Nginx:
```sh
sudo systemctl start nginx
sudo systemctl enable nginx
```
Test by visiting `http://your-ec2-public-ip` in a browser.

---

## Step 5: Install MySQL
```sh
sudo apt install mysql-server -y
```
Secure MySQL:
```sh
sudo mysql_secure_installation
```
Follow the prompts to set a root password and secure the installation.

Log in to MySQL:
```sh
sudo mysql -u root -p
```
Create a database and user:
```sql
CREATE DATABASE mydatabase;
CREATE USER 'myuser'@'localhost' IDENTIFIED BY 'mypassword';
GRANT ALL PRIVILEGES ON mydatabase.* TO 'myuser'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

---

## Step 6: Install PHP
```sh
sudo apt install php-fpm php-mysql -y
```
Check PHP version:
```sh
php -v
```

---

## Step 7: Install Git and Clone Your Website from GitHub
Prior to this ensure, ensure you already prepare your wesbite files and uploaded to your github repo. 

Install Git:
```sh
sudo apt install git -y
```
Clone your repository:
```sh
cd /var/www/
sudo git clone https://github.com/yourusername/yourrepo.git mywebsite
```
Give Nginx permission:
```sh
sudo chown -R www-data:www-data /var/www/mywebsite
```

---

## Step 8: Configure Nginx to Serve Your Website
1. Create a new Nginx configuration file:
```sh
sudo nano /etc/nginx/sites-available/mywebsite
```
2. Add the following configuration:
```nginx
server {
    listen 80;
    server_name your-ec2-public-ip;
    root /var/www/mywebsite;
    index index.php index.html;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```
3. Enable the configuration:
```sh
sudo ln -s /etc/nginx/sites-available/mywebsite /etc/nginx/sites-enabled/
```
4. Test and restart Nginx:
```sh
sudo nginx -t
sudo systemctl restart nginx
```

---

## Step 9: Access Your Website
Open your browser and visit:
```sh
http://your-ec2-public-ip
```
Your website should now be live!, Having issue, let troublesoot, create an issue on this repo
If this was help ⭐ this repo

---
