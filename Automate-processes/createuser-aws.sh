#!/bin/bash

# Variables
USERNAME="NewUser"
POLICY_ARN="arn:aws:iam::aws:policy/AmazonS3ReadOnlyAccess"

# Create IAM user
echo "Creating IAM user..."
aws iam create-user --user-name $USERNAME

# Attach policy to the user
echo "Attaching policy to the user..."
aws iam attach-user-policy --user-name $USERNAME --policy-arn $POLICY_ARN

# Create access keys for the user
echo "Creating access keys..."
aws iam create-access-key --user-name $USERNAME
