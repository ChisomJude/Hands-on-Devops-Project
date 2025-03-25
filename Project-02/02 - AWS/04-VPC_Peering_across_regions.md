# VPC Peering for Cross-Region Communication

#### Objective  
Connect two VPCs (in different regions) to allow a PHP web app in **VPC-A** to query a MySQL database in **VPC-B**.

---

## Step-by-Step Implementation  

### 1. Create Two VPCs  

#### VPC-A (Web Server VPC)  
- **Region:** `us-east-1`  
- **CIDR:** `10.0.0.0/16`  
- **Public Subnet:** `10.0.1.0/24` (`us-east-1a`)  
- **Internet Gateway:** Attached  

#### VPC-B (Database VPC)  
- **Region:** `us-west-2`  
- **CIDR:** `192.168.0.0/16`  
- **Private Subnet:** `192.168.1.0/24` (`us-west-2a`)  
- **NAT Gateway:** For outbound updates  

---

### 2. Set Up VPC Peering  
1. Go to **VPC Dashboard** → **Peering Connections** → **Create Peering Connection**.  
2. Set the requester and accepter:  
   - **Requester VPC:** `VPC-A (us-east-1)`  
   - **Accepter VPC:** `VPC-B (us-west-2)`  
3. Accept the peering request in the second account/region.  
4. **Update Route Tables** in both VPCs:  
   - **In VPC-A:** Add route to `192.168.0.0/16` via the peering connection.  
   - **In VPC-B:** Add route to `10.0.0.0/16` via the peering connection.  

---

### 3. Deploy Resources  

#### In VPC-A (Web Server):  
- **Launch an EC2 instance** in the public subnet.  
- **SSH into the instance and install PHP + Nginx:** use script below  

```bash

# Update system packages
sudo yum update -y

# Install required packages
sudo yum install -y nginx php php-fpm git mysql

# Enable and start services
sudo systemctl enable nginx php-fpm
sudo systemctl start nginx php-fpm

# Clone the PHP application to /usr/share/nginx/html
sudo git clone https://github.com/chisomjude/sampleweb /usr/share/nginx/html

# Set proper ownership and permissions
sudo chown -R nginx:nginx /usr/share/nginx/html
sudo chmod -R 755 /usr/share/nginx/html

# Restart Nginx and PHP-FPM to apply changes
sudo systemctl restart nginx php-fpm

```

### Security Group Configuration  

#### In VPC-A (Web Server), configure security group if not done before now:  
- Allow **HTTP (80)**  
- Allow **SSH (22)**  
- Allow **Outbound MySQL (3306)** to VPC-B  

#### In VPC-B (Database):  
- Allow **Inbound MySQL (3306)** from VPC-A’s CIDR (`10.0.0.0/16`).  


## **Configure a Jump Server or use ServerA about ?**

Since **VPC-B (Database VPC)** is in a **private subnet**, SSH access should be restricted. You will need to connect via  a **secure jump server** to access ServerB and install **MySQL**.

---

## **Step 1: Launch a Bastion Host in VPC-A**

1. **Go to AWS EC2 Dashboard** → Click **Launch Instance**
2. **Choose Amazon Linux 2 (or Ubuntu, RHEL, etc.)**
3. **Instance Type:** Select `t2.micro` (Free Tier)
4. **Network Settings:**
   - **VPC:** Select **VPC-A**
   - **Subnet:** Choose a **public subnet** in `us-east-1a`
   - **Auto-assign Public IP:** **Enabled**
5. **Configure Security Group:**
   - Allow **SSH (22)** **only from your IP** (e.g., `X.X.X.X/32`)
   - Deny all other inbound traffic
6. **Launch the instance** and **connect via SSH**:
   ```bash
   ssh -i your-key.pem ec2-user@PUBLIC-IP
   ```

---

## **Step 2: Configure Security Group for MySQL in VPC-B**

- **Security Group Rules for MySQL EC2 Instance:**
  - **Allow SSH (22)** **only from the jumpserver Private IP or WerServer IP**
  - **Allow Inbound MySQL (3306)** **from VPC-A’s CIDR (**``**)**

---

## **Step 3: SSH into ServerB from the Jumb**

Once inside ServerA or Jump:

```bash
ssh -i your-key.pem ec2-user@<PRIVATE-IP-OF-serverb>
```

---

## **Step 4: Install MySQL and Configure Database**

Once inside the **MySQL EC2 instance**, update the system and install MySQL:

```bash
# Update system
sudo yum update -y  # (For Amazon Linux/RHEL)
# sudo apt update -y  # (For Ubuntu)

# Install MySQL Server
sudo yum install -y mysql-server  # (For Amazon Linux/RHEL)
# sudo apt install -y mysql-server  # (For Ubuntu)

# Start MySQL
sudo systemctl start mysqld
sudo systemctl enable mysqld
```

---



### 4. Test Connectivity  

1. **Access the WebApp and to log in using ** and verify database access:  

```bash
mysql -h <RDS-ENDPOINT> -u admin -p
```



