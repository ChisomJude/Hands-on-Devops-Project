# HandsOn Project 02 - Linux 

## Introduction

This guide is designed for beginners who are new to Linux and want to get started with the basics. First, it is good to understand that Linux is an open-source operating system kernel first created by Linus Torvalds in 1991. It is the foundation of many different operating systems. There are different distributions of the Linux OS, but the popular ones are **UBUNTU and CENTOS**

Ubuntu is a popular Linux distribution that aims to provide a user-friendly experience while being powerful and versatile. It's based on Debian, another well-known Linux distribution. Ubuntu uses the Advanced Package Tool (APT) for package management. You can use commands like `apt update`, `apt install`, and `apt remove` to manage software packages. Ubuntu also has a large and active community makes it easy to find support and resources online. Ubuntu forums and documentation are great places to seek help. For our HandOns we will be using **Ubuntu 20.04 or 22.04**

## Terminal and Command Line

In Linux, you interact with the system using a command-line interface (CLI). The terminal is the application that allows you to type commands to perform various tasks.

### Basic Commands to keep Handy

- `pwd`: Print the current working directory.
- `ls`: List the contents of the current directory.
- `cd`: Change the current directory.
- `mkdir`: Create a new directory.
- `touch`: Create an empty file.
- `cp`: Copy files or directories.
- `mv`: Move or rename files or directories.
- `rm`: Remove files or directories
- `cat`: Read the content of a file
- `nano` or `vi`: Opens the content of a file in an editor mode. There are text editors and different commands used to manage them but this project will use `nano` because it is a beginner-friendly option. you can easily use the  Ctrl+O for write-out, Ctrl+S to save and  Ctrl+X for exit the editor mode

Please note that some of these commands may require you to add one or more flags eg `-a`  `-r` to achieve a desired activity. Google is your friend. 

Flags and options are used to modify the behavior of a command. They are specified after the command and are preceded by a hyphen (-). Options can be single-character (short options) or full words (long options), and they are used to customize how a command operates.


Example:
```bash
$ pwd
/home/user
$ ls 
Desktop  Documents  Downloads  Music
$ mkdir NewFolder
$ cd NewFolder
$ touch newfile.txt

```
It is good to mention that you can't learn Linux by just reading, let's dive on to HandsOn.
You will need to spin up an **Ubuntu Server** from a Cloud Provider (AWS or Azure) or a Virtual Box. I will be using AWS EC2 to spin up Ubuntu 20.04  For a Guide on what option to go for Click to See [Resources](#resources) 


## Handson Project for Linux
In this project, we will be working on a LEMP stack project. LEMP means - LEMP stands for Linux, Nginx (pronounced "engine-x"), MySQL (or MariaDB), and PHP. 

What will you need for this project:
- Ubuntu Server
- Install Nginx
- Install MySQL
- install Php
- Your Web Files

For a Guide on what option to go for Click to See [Resources](#resources) 
  





## Resources 
- Linux Commands: 
  - https://www.youtube.com/watch?v=gd7BXuUQ91w
- Setting Up VM in Azure
- Setting Up VM in AWS
- Setting up Ubuntu Box in Virtual Box
- Project: https://blog.chisomjude.net/how-to-set-up-a-lemp-stack-for-your-web-project
