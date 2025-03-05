# Hosting a Static Website on S3 using AWS Management Console

This guide walks you through hosting a static website on Amazon S3 using the AWS Management Console. 

## Prerequisites
- An **AWS account**
- A simple **HTML file** to upload as the website content

## Step 1: Create an S3 Bucket
1. Sign in to the **AWS Management Console**.
2. Navigate to **S3**.
3. Click **Create bucket**.
4. Enter a unique **Bucket name** (e.g., `my-static-website`).
5. Choose a **Region**.
6. Under **Block Public Access settings**, uncheck "Block all public access" and confirm.
7. Click **Create bucket**.

## Step 2: Enable Static Website Hosting
1. Open your newly created bucket.
2. Click the **Properties** tab.
3. Scroll down to **Static website hosting** and click **Edit**.
4. Choose **Enable**.
5. Select **Host a static website**.
6. Set the **Index document** as `index.html`.
7. Click **Save changes**.

## Step 3: Upload Website Files
1. Create a simple `index.html` file with the following content:
```html
<!DOCTYPE html>
<html>
<head>
    <title>My S3 Website</title>
</head>
<body>
    <h1>Welcome to My Static Website on S3!</h1>
    <p>This is a sample page hosted on AWS S3.</p>
</body>
</html>
```
2. Open your S3 bucket.
3. Go to the **Objects** tab and click **Upload**.
4. Select your `index.html` file and click **Upload**.

## Step 4: Make the Website Public
1. Go to the **Permissions** tab of your bucket.
2. Click **Bucket Policy** and enter the following policy (replace `your-bucket-name` with your actual bucket name):
```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Effect": "Allow",
            "Principal": "*",
            "Action": "s3:GetObject",
            "Resource": "arn:aws:s3:::your-bucket-name/*"
        }
    ]
}
```
3. Click **Save changes**.

## Step 5: Access Your Static Website
1. Go back to the **Properties** tab.
2. Under **Static website hosting**, find the **Bucket website endpoint**.
3. Click the link to view your live static website.

