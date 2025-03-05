# WELCOME TO CLOUD - AWS
Amazon Web Service popularly known as AWS is a major cloud service provider with a large market share and worth learning. From basic infrastructure components to advanced managed services, AWS continues to redefine the way organizations build, deploy, and scale their applications today.  In the course of these project, we have to soil our hands on AWS to familiarise ourselves with these services, especially the popularly used services


## Core AWS Services
There are lots of services on AWS for different purposes but this article will narrow down to the very key on and also a pointer to the ones we will be using for a hands-on project.

**EC2 (Elastic Compute Cloud):**
Amazon EC2, the cornerstone of AWS, provides resizable compute capacity in the cloud. It allows users to launch virtual servers, known as instances, within minutes, catering to a variety of workload requirements. With EC2, users have full control over their computing environment, including the choice of instance type, operating system, networking, and security configurations. EC2 instances are commonly used for web hosting, application development, batch processing, and more.

**S3 (Simple Storage Service):**
Amazon S3 offers highly scalable and durable object storage in the cloud. It serves as a secure repository for a wide range of data types, including documents, images, videos, and backups. S3 provides robust features such as versioning, encryption, and lifecycle management, making it suitable for storing critical data and enabling seamless integration with various AWS services and third-party applications. Common use cases for S3 include data archiving, content distribution, backup and recovery, and hosting static websites.

**IAM (Identity and Access Management)**
IAM is a vital component of AWS security, enabling users to manage access to AWS resources securely. With IAM, users can create and manage users, groups, and roles, defining fine-grained permissions to control who can access specific resources and perform certain actions within their AWS environment. IAM plays a crucial role in enforcing the principle of least privilege, enhancing security posture, and ensuring compliance with regulatory requirements.

**VPC (Virtual Private Cloud):**
Amazon VPC empowers users to provision a logically isolated section of the AWS Cloud, complete with its own virtual network, subnets, route tables, and security settings. VPC enables organizations to architect their network infrastructure according to their specific requirements, establishing private connectivity between AWS resources and on-premises environments via VPN or Direct Connect. VPC facilitates the deployment of secure and scalable applications, ensuring network isolation, traffic routing, and access control.

**RDS (Relational Database Service):**
Amazon RDS is a managed relational database service that simplifies the setup, operation, and scaling of relational databases in the cloud. RDS supports popular database engines such as MySQL, PostgreSQL, Oracle, SQL Server, and MariaDB, offering features such as automated backups, patch management, and high availability configurations. By offloading database administration tasks to AWS, RDS enables organizations to focus on application development, ensuring optimal performance, reliability, and scalability of their databases.

**Lambda (Serverless Compute):**
AWS Lambda revolutionizes the way developers build and deploy applications by offering serverless computing capabilities. With Lambda, developers can run code without provisioning or managing servers, paying only for the compute time consumed by their functions. Lambda supports multiple programming languages and integrates seamlessly with other AWS services, allowing for event-driven architectures and microservices-based applications. Whether it's processing data streams, executing business logic, or automating workflows, Lambda enables rapid innovation and cost-effective scalability



## Compare AWS Resources with AZURE Cloud 
The second part of our cloud learning will be to Azure, so this table is here to help us 


| Resources                       | AWS                                 | Azure                                   | Uses                                                                     |
|--------------------------------|-------------------------------------|-----------------------------------------|--------------------------------------------------------------------------|
| Compute                        | EC2 (Elastic Compute Cloud)        | Virtual Machines                        | Running virtual servers for various workloads                            |
| Storage                        | S3 (Simple Storage Service)        | Blob Storage                            | Storing and retrieving objects such as documents, images, and videos    |
| Identity and Access Management | IAM (Identity and Access Management)| Azure Active Directory (AAD)           | Managing user identities, access control, and permissions               |
| Networking                    | VPC (Virtual Private Cloud)        | Virtual Network (VNet)                 | Creating isolated virtual networks with subnets, gateways, and routing  |
| Database                      | RDS (Relational Database Service)  | Azure SQL Database                      | Managed relational database service supporting SQL databases            |
| Serverless Computing          | Lambda                              | Azure Functions                         | Running code in response to events without managing server infrastructure|
| Monitoring and Logging        | CloudWatch                          | Azure Monitor                           | Collecting and analyzing metrics, logs, and events for resources         |
| Content Delivery              | CloudFront                          | Azure Content Delivery Network (CDN)   | Delivering content to users with low latency and high data transfer speed|
| File Storage                  | EFS (Elastic File System)          | Azure Files                            | Providing scalable file storage for cloud-based applications            |
| Object Storage                | S3 (Simple Storage Service)        | Azure Blob Storage                     | Storing unstructured data such as files, images, and backups           |
| Web Hosting                   | Elastic Beanstalk                   | App Service                             | Deploying and managing web applications and services with ease           |



### Learn more about AWS:


##  Project 03- AWS
This will be a two-phase  project (03A and 03B)
- Creating resources and hosting your website on S3 
- Hosting your AWS ELastic Bean Stalk


### Creating resources and hosting your website on S3 - Project 03A
First, you will want to play around on your AWS CONSOLE, create free resources,  and get familiar with how things work here.
When you are good, we will now drive into to project proper, we will be using Amazon S3 for storage and Amazon CloudFront for content delivery and caching. 

**Step 1: Prepare Your Website**

Ensure that your website consists of static files such as HTML, CSS, JavaScript, images, and other assets.
Organize your website files into a local directory on your computer.

**Step 2: Create an S3 Bucket for Your Website**

- Sign in to the AWS Management Console.
- Navigate to the Amazon S3 service.
- Click on the "Create bucket" button.
- Enter a unique name for your bucket and choose the region where you want to create the bucket.
- Uncheck the "Block all public access" option.
- Click "Create bucket".

**Step 3: Upload Your Website Files to the S3 Bucket**

- Open the newly created S3 bucket.
- Click on the "Upload" button.
- Select all the files and folders from your local directory and upload them to the S3 bucket.
- Once the upload is complete, select all the files in the bucket, click on the "Actions" dropdown, and choose "Make public".

**Step 4: Enable Static Website Hosting on the S3 Bucket**

- In the S3 bucket properties, go to the "Static website hosting" section.
- Select the option to "Use this bucket to host a website".
- Enter the name of the index document (e.g., index.html).
- Optionally, you can also specify an error document.
- Click "Save changes".


**Step 5: Configure Amazon CloudFront**

- Navigate to the Amazon CloudFront service in the AWS Management Console.
- Click on the "Create Distribution" button.
- Select "Web" as the delivery method.
- In the "Origin Domain Name" field, select the S3 bucket that you created earlier from the dropdown.
- Leave the other settings as default or customize them according to your requirements.
- Click "Create Distribution".

**Step 6: Update DNS Records (Optional)**

- If you have a custom domain, you can point it to your CloudFront distribution by creating a CNAME record in your DNS provider's settings.
Obtain the CloudFront domain name from the CloudFront distribution settings.
- Create a CNAME record pointing to the CloudFront domain name in your DNS provider's dashboard.

**Step 7: Test Your Website**

- Once the CloudFront distribution is deployed (which may take a few minutes), you can access your website using the CloudFront domain name or your custom domain if you configured one.
- Open a web browser and enter the URL of your website. Verify that your website is accessible and functioning as expected.
 

### Hosting your AWS ELastic Bean Stalk  - Project 03B
AWS Elastic Beanstalk makes it easy to deploy, manage, and scale web applications and services developed with popular programming languages, frameworks, and platforms. Here's a step-by-step approach to hosting your website using AWS Elastic Beanstalk:

**Step 1: Prepare Your Website**

Ensure that your website is a web application or a collection of files (HTML, CSS, JavaScript, etc.) that you want to host.
Organize your website files into a directory on your local machine.

**Step 2: Create an Elastic Beanstalk Application**

- Sign in to the AWS Management Console.
- Navigate to the Elastic Beanstalk service.
- Click on "Create Application".
- Enter a name for your application.
- Optionally, describe your application.
- Click "Create".

**Step 3: Configure Your Environment**

- After creating the application, click on "Create Environment".
- Choose the web server environment type.
- Select the platform that matches your application (e.g., Node.js, Python, Ruby, PHP, Java, .NET, etc.).
- Choose the appropriate application code deployment method (upload your code or use a version control system like Git).
- Click "Create environment".

**Step 4: Upload Your Application Code**

- If you choose to upload your code during environment creation, you'll be prompted to upload your application code.
- Upload the ZIP file or individual files containing your website code.
- Optional, you can choose to use the S3 bucket if you already have this in the first project
- Wait for the application to deploy.

Step 5: Configure Environment Settings (Optional)

- Configure environment settings such as instance type, capacity, environment variables, database connection strings, etc., as needed.
- You can adjust these settings later from the Elastic Beanstalk console.

**Step 6: Access Your Website**

- Once the environment is created and the application is deployed, you'll see a URL for accessing your website.
- Click on the URL to open your website in a web browser and verify that it's working correctly.
- You can also assign a custom domain to your Elastic Beanstalk environment if needed.

**Step 7: Monitor and Manage Your Environment**

*Monitor your environment's health, performance, and resource utilization from the Elastic Beanstalk console.*
Scale your environment up or down as needed to handle changes in traffic or workload.
Update your application code or environment configuration as needed.


### Resources
- AWS resources: 
   - https://www.youtube.com/watch?v=7PaaFkiuiFY
   - https://www.youtube.com/watch?v=JIbIYCM48to
- AWS S3 and CloudFront:  https://www.youtube.com/watch?v=SS707jG4yZ8
- AWS Elastic Beanstalk : https://www.youtube.com/watch?v=2BoVhej0QVI

- Watch Project 1 Implementation Video - https://youtu.be/KRUm5v5bYf8
- Reference Article for Project 1 - https://blog.chisomjude.net/step-by-step-guide-on-hosting-your-first-website-on-aws-using-s3-bucket-and-cloudfront

