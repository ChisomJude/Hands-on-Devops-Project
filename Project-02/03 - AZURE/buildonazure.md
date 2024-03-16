# Microsoft Azure 

AZURE is  cloud computing platform, by Microsoft, that offers a wide range of services to help individuals, businesses, and organizations build, deploy, and manage applications and services. Similar to AWS there are multiple services you can get from Azure such as Virtual Machines, Databases, CDN, Networking,  and lots more. 

This resource will focus on App Development and DevOps related. This project we will be considering how to  
host a web app on Azure. There are various ways to host a project in Azure, depending on your requirements
- Host on Static Web Apps
- Azure App Service
- Virtual Machine

## Azure Static Apps
Azure Static Apps is a fully managed service designed to simplify the deployment and hosting of static web applications. It offers a seamless workflow for building, deploying, and scaling modern web applications that consist of HTML, CSS, and JavaScript files without the need for server-side processing. Key features of Azure Static Apps include:

**Continuous Deployment:** Azure Static Apps integrates with popular version control systems like GitHub, GitLab, and Azure DevOps, enabling automated deployments triggered by code changes.

**Serverless APIs:** Seamlessly integrate serverless APIs using Azure Functions or APIs hosted elsewhere, enabling dynamic functionality within your static web applications.

**Global Content Delivery:** Leverage Azure CDN (Content Delivery Network) to ensure fast and reliable content delivery to users worldwide, enhancing the performance and user experience of your applications.

**Custom Domains:** Easily configure custom domains for your static apps, allowing you to establish a branded presence on the web.

Authentication and Authorization: Integrate authentication providers such as Azure Active Directory, GitHub, and others to secure access to your static apps and APIs.

## Azure App Service
Azure App Service is a fully managed platform for building, deploying, and scaling web applications and APIs. It supports a wide range of programming languages, frameworks, and tools, making it suitable for diverse development scenarios. Key features of Azure App Service include:

**Multiple Runtimes:** Azure App Service supports multiple programming languages and frameworks, including .NET, Node.js, Java, Python, and PHP, enabling developers to choose the technology stack that best fits their requirements.

**Automatic Scaling:** Scale your applications effortlessly based on demand with built-in auto-scaling capabilities that adjust resources dynamically to handle varying workloads.

**Deployment Slots:** Utilize deployment slots to deploy applications to separate environments (e.g., staging, production) and perform validation and testing before promoting changes to the production environment.

**Integration with Azure Services:** Seamlessly integrate with other Azure services such as Azure SQL Database, Azure Cosmos DB, Azure Functions, and Azure Monitor to enhance the functionality and capabilities of your applications.

**Built-in DevOps Integration:** Streamline your development workflow with built-in support for continuous integration and continuous deployment (CI/CD) using Azure DevOps, GitHub Actions, or other CI/CD tools.

## Other options for Host App and website in Azure

**Azure Virtual Machines:** Azure Virtual Machines (VMs) provide on-demand, scalable computing resources where you can deploy and manage web servers like Apache, Nginx, or IIS. With VMs, you have full control over the underlying infrastructure, allowing you to install and configure software as needed. This option provides flexibility but requires more management compared to managed services like Azure App Service.

**Azure Kubernetes Service (AKS):** AKS is a managed Kubernetes service that allows you to deploy, manage, and scale containerized applications. You can host web applications within containers orchestrated by Kubernetes, enabling easy scaling and management of your application infrastructure.

**Azure Container Instances (ACI):** ACI offers a serverless way to run containers without managing the underlying infrastructure. You can deploy containerized web applications directly to ACI, and Azure handles provisioning, scaling, and maintenance automatically.

**Azure Front Door:** Azure Front Door is a global content delivery network (CDN) and application delivery network (ADN) service that enables you to deliver web applications at high scale with high availability and low latency. While not directly hosting websites, **it provides global load balancing, SSL offloading, and advanced traffic management features for web applications hosted on other Azure services**.

**Azure Storage Static Website Hosting:** Azure Storage provides the capability to host static websites directly from a storage account. You can upload HTML, CSS, JavaScript, and other static files to a storage container and enable static website hosting. While limited in functionality compared to Azure Static Apps, it's a simple and cost-effective solution for basic static websites.

**Azure CDN:** Azure Content Delivery Network (CDN) caches website content at strategically placed locations to provide faster delivery to users. While not a hosting service per se, Azure CDN can be used in conjunction with other hosting services (e.g., Azure App Service, Azure Storage) to improve website performance and global availability.

## Projects

We will be working on two Projects:
### Project 01 - Azure Work Overview
The essence of this project is to familiarise with Azure, Create an Account, create resources like
- virtual machine ( Windows OS any image and size)
- create a static web app and pull from your website file github repo

- ### Project 02 - Deploy a simple python app to Azure App Service

 ## Resources
- Azure Services - https://www.youtube.com/watch?v=TJOwP5VhvAo 
- Azure Static Web Apps - https://www.youtube.com/watch?v=6uaiGqCwDgs
- Azure App Service - https://www.youtube.com/watch?v=ogO_ZZUssHE
