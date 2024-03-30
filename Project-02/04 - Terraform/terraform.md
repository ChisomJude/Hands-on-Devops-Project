# TERAFFORM

Resource :  https://blog.chisomjude.net/practical-guide-to-terraform-for-newbie?showSharer=true

## Project One

#### Using Terraform to Deploy S3 to AWS

Create this Files 
Main.tf and provider.tf and also a read.me to give instruction to your reader 
```
#main.tf
resource "aws_s3_bucket" "example" {
  bucket = "chisom-newest-bucket23" #enter a unique bucket name
  acl    = "private"

  tags = {
    Name        = "My bucket"
    Environment = "Dev"
  }
}

#provider.tf

# Configure the AWS Provider
provider "aws" {
  region = "us-east-2"
  access_key = "ENTER YOUR ACCESS KEY" #NAVIGATE TO AWS AND CREATE IAM USER AND ASSIGN ACCESS KEY
  secret_key = "ENTER YOUR SECRET KEY"
}

```

#### Before you RUN 
- Edit `provider.tf`
- Enter `your access key and secret`
- Edit `main.tf` and enter a unique bucket name

#### RUN TERRAFORM 

 ```
 terraform init
 terraform plan
 terraform apply

```

 ## Project Two

#### Create a VM on Azure


```

#provider.tf

provider "azurerm" {
  features {}

  subscription_id = "<your_subscription_id>"
  tenant_id       = "<your_tenant_id>"
  client_id       = "<your_client_id>"
  client_secret   = "<your_client_secret>"
}

#Main.tf

resource "azurerm_resource_group" "example" {
  name     = "myResourceGroup"
  location = "East US"
}

# Virtual Network
resource "azurerm_virtual_network" "example" {
  name                = "myVNet"
  address_space       = ["10.0.0.0/16"]
  location            = azurerm_resource_group.example.location
  resource_group_name = azurerm_resource_group.example.name
}

# Subnet
resource "azurerm_subnet" "example" {
  name                 = "mySubnet"
  resource_group_name  = azurerm_resource_group.example.name
  virtual_network_name = azurerm_virtual_network.example.name
  address_prefixes     = ["10.0.1.0/24"]
}

# Network Interface
resource "azurerm_network_interface" "example" {
  name                = "myNIC"
  location            = azurerm_resource_group.example.location
  resource_group_name = azurerm_resource_group.example.name

  ip_configuration {
    name                          = "myNICConfig"
    subnet_id                     = azurerm_subnet.example.id
    private_ip_address_allocation = "Dynamic"
  }
}

# Virtual Machine
resource "azurerm_virtual_machine" "example" {
  name                  = "myVM"
  location              = azurerm_resource_group.example.location
  resource_group_name   = azurerm_resource_group.example.name
  network_interface_ids = [azurerm_network_interface.example.id]
  vm_size               = "Standard_DS1_v2"

  storage_image_reference {
    publisher = "Canonical"
    offer     = "UbuntuServer"
    sku       = "16.04-LTS"
    version   = "latest"
  }

  os_profile {
    computer_name  = "hostname"
    admin_username = "adminuser"
    admin_password = "Password1234!"
  }

  os_profile_linux_config {
    disable_password_authentication = false
  }
}

```