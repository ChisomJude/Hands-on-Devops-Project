#  Auto Scaling for Self-Healing

This is an extension of project_06. In this project, you will need to replace manual EC2 instances with an Auto Scaling Group that:
- Maintains 2 healthy web instances across AZs
- Scales to 3 instances during failures
- Self-heals automatically
- Integrates with ALB from Project 2

## Step-by-Step Implementation  

### 1. Create a Launch Template  
- Go to **EC2 > Launch Templates > Create launch template**
- **Name :** web-template
- **Key pair:**  Your existing key
- **AMI:** Amazon Linux 2
- **Instance Type:** t2.micro  
- **User Data:** (Same as Project 06)  
- **Security Group:** Allow HTTP (80), SSH (22) 

### Under Advanced Details
```bash
# User Data (paste exactly as seen below):

#!/bin/bash
sudo yum update -y
sudo amazon-linux-extras enable nginx1
sudo yum install -y nginx git
sudo git clone https://github.com/chisomjude/samplewebapp /usr/share/nginx/html
sudo chown -R nginx:nginx /usr/share/nginx/html
sudo systemctl enable --now nginx
```

### 2. Configure Auto Scaling Group  
- **Desired Capacity:** 2  
- **Min/Max:** 2 / 3  
- **Subnets:** Both public subnets (multi-AZ)  
- **Target Group:** Attach the ALB’s target group from Project6.  
- **Scaling Policy:** Scale to 3 if CPU > 70% for 5 minutes.
- **Name:** web-asg
- **Launch template:** web-template
- **VPC:** Your existing VPC
- **Subnets:** Select both public subnets

### 3. Test and Self-Healing  
#### Confirm your instances are running
#### Simulate Failure:  
Terminate one instance → ASG launches a replacement.  

#### Stress Test:  
SSH into an instance and simulate stress to confirm a 3rd instance spins up
```bash
sudo yum install stress -y
stress --cpu 2 --timeout 300
```

### Finals:

Once the project is complete, remember to clean up resources, keep screenshots of your project where necessary before cleanup. 
Scale down ASG to Zero capacity using the command below, after 10 minutes, proceed to delete 
ASG, Launch template, (Keep ALB/VPC if needed)

```bash
aws autoscaling update-auto-scaling-group \
  --auto-scaling-group-name web-asg \
  --min-size 0 \
  --desired-capacity 0
```

