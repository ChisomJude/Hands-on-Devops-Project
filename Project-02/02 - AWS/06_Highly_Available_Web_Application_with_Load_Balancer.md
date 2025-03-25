# Project 2: Highly Available Web Application with Load Balancer

## Objective
Deploy a fault-tolerant PHP web application using an Application Load Balancer (ALB) to distribute traffic across two EC2 instances in different Availability Zones (AZs).

## Architecture Components
- **VPC** with public subnets in 2 AZs
- **Internet Gateway** (IGW) for public access
- **EC2 instances** running Nginx/PHP
- **Application Load Balancer** (ALB)
- **Security Groups** for traffic control

## Prerequisites
- AWS account with IAM permissions
- Basic understanding of EC2 and VPC
- Sample PHP app in GitHub (`github.com/chisomjude/sampleweb`)

---

## Step-by-Step Implementation

### 1. Set Up VPC Networking
1. **Create a VPC**:
   - Go to **VPC Dashboard > Your VPCs > Create VPC**
   - Name: `HA-Web-App-VPC`
   - IPv4 CIDR: `10.0.0.0/16`
   - Region: `us-east-1` (or your preferred region)

2. **Create Public Subnets**:
   - Subnet 1:
     - Name: `Public-Subnet-A`
     - AZ: `us-east-1a`
     - CIDR: `10.0.1.0/24`
   - Subnet 2:
     - Name: `Public-Subnet-B`
     - AZ: `us-east-1b`
     - CIDR: `10.0.2.0/24`

3. **Create Internet Gateway**:
   - Go to **Internet Gateways > Create**
   - Name: `HA-Web-IGW`
   - Attach to your VPC

4. **Configure Route Tables**:
   - Edit the main route table:
     - Add route: `0.0.0.0/0` → Target: `IGW`

---

### 2. Launch EC2 Web Servers
1. **Launch EC2 Instance 1**:
   - AMI: Amazon Linux 2
   - Instance type: `t2.micro`
   - Subnet: `Public-Subnet-A`
   - **User Data** (paste in Advanced Details):
     ```bash
     #!/bin/bash
     sudo yum update -y
     sudo amazon-linux-extras enable php8.2 nginx1
     sudo yum install -y php-cli php-fpm php-mysqlnd nginx git
     
     # Clone sample app
     sudo git clone https://github.com/chisomjude/sampleweb /usr/share/nginx/html
     sudo chown -R nginx:nginx /usr/share/nginx/html
     
     # Start services
     sudo systemctl start nginx php-fpm
     sudo systemctl enable nginx php-fpm
     ```

2. **Launch EC2 Instance 2**:
   - Repeat same configuration in `Public-Subnet-B`

3. **Configure Security Groups**:
   - Name: `Web-Server-SG`
   - Rules:
     - HTTP (80) - Source: 0.0.0.0/0
     - SSH (22) - Source: Your IP

---

### 3. Configure Application Load Balancer
1. **Create ALB**:
   - Go to **EC2 > Load Balancers > Create**
   - Type: Application Load Balancer
   - Name: `HA-Web-ALB`
   - Scheme: Internet-facing
   - VPC: Select your VPC
   - Subnets: Select both public subnets

2. **Create Target Group**:
   - Name: `Web-Servers-TG`
   - Protocol: HTTP (80)
   - Target type: Instance
   - Health check path: `/index.php`

3. **Register Targets**:
   - Select both EC2 instances
   - Test health status (should show "healthy")

---

### 4. Test High Availability
1. **Access Application**:
   - Copy ALB DNS name (e.g., `HA-Web-ALB-123456.us-east-1.elb.amazonaws.com`)
   - Open in browser - should show your PHP app

2. **Simulate Failure**:
   - Stop one EC2 instance
   - Refresh browser - traffic should automatically route to the other instance

3. **Verify Health Checks**:
   - Check Target Group - unhealthy instance should be marked accordingly

---

## Troubleshooting
- **Instance not healthy**:
  - Check security groups allow HTTP/80 from ALB
  - Verify user data script ran successfully (`/var/log/cloud-init-output.log`)
- **ALB not routing**:
  - Verify both subnets are selected in ALB config
  - Check route tables have IGW association

## Cleanup
- Delete ALB and Target Group
- Terminate EC2 instances
- Delete VPC (will auto-delete subnets/IGW)
