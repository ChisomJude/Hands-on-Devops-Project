# VPC Peering for Cross-Region Communication

## Objective
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
sudo git clone https://github.com/chisomjude/samplewebapp /usr/share/nginx/html

# Set proper ownership and permissions
sudo chown -R nginx:nginx /usr/share/nginx/html
sudo chmod -R 755 /usr/share/nginx/html

# Restart Nginx and PHP-FPM to apply changes
sudo systemctl restart nginx php-fpm
```

### Security Group Configuration

#### In VPC-A (Web Server):
- Allow **HTTP (80)**
- Allow **SSH (22)**
- Allow **Outbound MySQL (3306)** to VPC-B

#### In VPC-B (Database):
- Allow **Inbound MySQL (3306)** from VPC-A’s CIDR (`10.0.0.0/16`).

---

## Configure a Bastion Host (Jump Server)

Since **VPC-B (Database VPC)** is in a **private subnet**, SSH access should be restricted. You will need to connect via a **secure jump server** to access the DB server.

### Step 1: Launch a Bastion Host in VPC-A

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

## Step 2: Set Up MySQL on EC2 in VPC-B

1. **SSH into the DB server from the Bastion Host:**
   ```bash
   ssh -i your-key.pem ec2-user@<PRIVATE-IP-OF-DB-SERVER>
   ```

2. **Install MySQL and Configure Database:**
   ```bash
   # Update system
   sudo yum update -y  # (For Amazon Linux/RHEL)
   
   # Install MySQL Server
   sudo yum install -y mysql-server  # (For Amazon Linux/RHEL)
   
   # Start MySQL
   sudo systemctl start mysqld
   sudo systemctl enable mysqld
   ```

3. **Create a Database and Users Table:**
   ```bash
   mysql -u root -p
   ```

   Inside MySQL:
   ```sql
   CREATE DATABASE webapp;
   USE webapp;

   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(50) NOT NULL UNIQUE,
       password VARCHAR(255) NOT NULL
   );

   INSERT INTO users (username, password) VALUES ('user1', 'user1');
   INSERT INTO users (username, password) VALUES ('chisom', 'chisom');
   ```

---

### 4. Test Connectivity  

1. **SSH into the Web Server** and verify database access:  
   ```bash
   mysql -h <PRIVATE-IP-OF-DB-SERVER> -u user1 -p
   ```

2. **Configure the PHP App to Use the Database**
   - Update `config.php` with the correct **DB credentials and IP**:
   ```php
   <?php
   $host = "<PRIVATE-IP-OF-DB-SERVER>";
   $username = "user1";
   $password = "user1";
   $dbname = "webapp";
   
   $conn = new mysqli($host, $username, $password, $dbname);
   
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   ?>
   ```

3. **Test Login via Web App**
   - Open the web browser and go to **`http://<Web-Server-Public-IP>`**
   - Try logging in with:
     - **Username:** `user1`  
     - **Password:** `user1`
   - If successful, it should display:
     ```
     Welcome user1, your login was successful.
     ```
   - If incorrect, it should show:
     ```
     Wrong login credentials.
     ```
   - If the DB connection fails, it should output:
     ```
     Connection failed.
     ```

---

## Final Validation Checklist

| Task | Success Criteria |
|------|-----------------|
| VPC Peering Established | Web server can query MySQL in another VPC |
| Web App Can Login | Users can authenticate using stored credentials |
| Security Configuration | Only required ports (80, 22, 3306) are open |
| Bastion Host Access | Secure SSH to DB via the jump server |

This setup ensures a secure and scalable architecture for cross-region communication between the web and database servers!

