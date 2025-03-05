# Access Key And secret for AWS CLI From (AWS Management Console)

This guide will walk you through creating Access to  your AWS account from third party app ( VSCOde)  using Access key and Secrets.

## Prerequisites
- AWS account
- AWS CLI installed and configured on your system 
- VS Code installed with AWS Toolkit extension (optional)

## Step 1: Install and Configure AWS CLI
### 1.1 Install AWS CLI
Download and install AWS CLI from [here](https://aws.amazon.com/cli/).

### 1.2 Create IAM User for CLI Access
1. Go to the **AWS Management Console**.
2. Navigate to **IAM > Users > Add User**.
3. Enter a username (e.g., `CLIUser`) and select **Programmatic Access**.
4. Click **Next: Permissions** and attach the necessary permissions, prefereably Admin Permissions.
5. Click **Create User** and save the **Access Key ID** and **Secret Access Key**.

### 1.3 Configure AWS CLI
Run the following command in your terminal:
```sh
aws configure
```
Enter:
- **Access Key ID**: (from step 1.2)
- **Secret Access Key**: (from step 1.2)
- **Region**: Choose your preferred AWS region (e.g., `us-east-1`)
- **Output format**: Leave as default or choose `json`
On subsequently you can connect by just running `aws configure`  enter same cred

## Step 2: Connect AWS CLI to VS Code(optional)
1. Install the **AWS Toolkit** extension in VS Code.
2. Open **AWS Explorer** (View > AWS Explorer).
3. Click **Add a new AWS connection**.
4. Select the AWS profile configured in step 1.3.
5. You should now see your AWS services inside VS Code.
