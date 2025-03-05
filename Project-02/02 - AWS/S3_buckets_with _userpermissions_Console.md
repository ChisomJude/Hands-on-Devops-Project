# Creating an S3 Bucket with IAM User Permissions (AWS Management Console)

This guide will walk you through creating an S3 bucket with two folders (`Dev` and `Finance`) and setting up two IAM users (`Chisom` and `John`) with specific access permissions using the AWS Management Console.

## Prerequisites
- AWS account
- Access to the AWS Management Console

## Step 1: Create an S3 Bucket
1. Sign in to the AWS Management Console.
2. Navigate to **S3**.
3. Click **Create Bucket**.
4. Enter a unique **Bucket name** (e.g., `your-bucket-name`).
5. Choose a **Region** and leave other settings as default.
6. Click **Create Bucket**.

## Step 2: Create Folders 
1. Open your newly created bucket.
2. Click **Create folder**.
3. Name the first folder **Dev** and click **Create**.
4. Repeat the process to create another folder named **Finance**.

## Step 3: Create IAM Users
1. Navigate to **IAM** in the AWS Management Console.
2. Click **Users** in the left panel.
3. Click **Add users**.
4. Enter the username `Chisom`, select **No access**, and click **Next**.
5. Repeat for `John`.

## Step 4: Create and Attach Policies

### 4.1 Create Policy for John
1. Navigate to **IAM > Policies**.
2. Click **Create Policy**.
3. Go to the **JSON** tab and enter the following:
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
4. Click **Next: Tags**, then **Next: Review**.
5. Name the policy `DevDeptPolicy` and click **Create Policy**.
6. Navigate to **IAM > Users > John**, click **Add permissions**, then **Attach policies**.
7. Search for `DevDeptPolicy`, check the box, and click **Add permissions**.

### 4.2 Create Policy for Chisom
1. Repeat the above steps but use the following JSON policy:
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
2. Name this policy `FinanceDeptPolicy`.
3. Attach it to **Chisom** following the same process as John.

## Step 5: Verify Permissions
1. Login as each user and attempt to access restricted folders.
2. John should be denied access to **Finance**, and Chisom should be denied access to **Dev**.

---

Now `John` can access everything except `Finance`, and `Chisom` can access everything except `Dev`.

> Please Like and star ⭐ this Project 
