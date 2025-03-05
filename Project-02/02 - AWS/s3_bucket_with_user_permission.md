# Creating an S3 Bucket with IAM User Permissions

This guide will walk you through creating an S3 bucket with two folders (`Dev` and `Finance`) and setting up two IAM users (`Chisom` and `John`) with specific access permissions using AWS CLI

## Prerequisites
- AWS account
- AWS CLI installed and configured

## Step 1: Create an S3 Bucket
Run the following command to create an S3 bucket:
```sh
aws s3 mb s3://your-bucket-name
```
Replace `your-bucket-name` with a globally unique name.

## Step 2: Create the Folders
```sh
aws s3 cp /dev/null s3://your-bucket-name/Dev/
aws s3 cp /dev/null s3://your-bucket-name/Finance/
```

## Step 3: Create IAM Users
```sh
aws iam create-user --user-name Chisom
aws iam create-user --user-name John
```

## Step 4: Create and Attach Policies

### 4.1 Create Policy for John
Create a file `john-policy.json` with the following content:
```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": "s3:*",
            "Resource": [
                "arn:aws:s3:::your-bucket-name",
                "arn:aws:s3:::your-bucket-name/*"
            ]
        },
        {
            "Effect": "Deny",
            "Action": "s3:*",
            "Resource": "arn:aws:s3:::your-bucket-name/Finance/*"
        }
    ]
}
```
Attach this policy:
```sh
aws iam put-user-policy --user-name John --policy-name JohnPolicy --policy-document file://john-policy.json
```

### 4.2 Create Policy for Chisom
Create a file `chisom-policy.json` with the following content:
```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Action": "s3:*",
            "Resource": [
                "arn:aws:s3:::your-bucket-name",
                "arn:aws:s3:::your-bucket-name/*"
            ]
        },
        {
            "Effect": "Deny",
            "Action": "s3:*",
            "Resource": "arn:aws:s3:::your-bucket-name/Dev/*"
        }
    ]
}
```
Attach this policy:
```sh
aws iam put-user-policy --user-name Chisom --policy-name ChisomPolicy --policy-document file://chisom-policy.json
```

## Step 5: Verify Permissions
Login as each user and attempt to access the restricted folders to verify that the permissions are applied correctly.

### Testing Access (Optional)
To list files in a folder:
```sh
aws s3 ls s3://your-bucket-name/Dev/ --profile John
aws s3 ls s3://your-bucket-name/Finance/ --profile Chisom
```
These should be denied based on the policies applied.

---
This completes the setup. Now `John` can access everything except `Finance`, and `Chisom` can access everything except `Dev`.
