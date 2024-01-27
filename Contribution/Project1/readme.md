### How to Add your Project One Submission

Fork this repo 
![image](https://github.com/ChisomJude/Hands-on-Devops-Project/assets/47423151/68bec712-8f5e-481f-b081-0de264ebbf0b)
- Pointer 1 - fork a repo
- Pointer 2 - Star a Repo
  
On your VScode Terminal, clone your forked repo and create a branch. 
Checkout to the branch using the following:

```git
git clone https://github.com/ChisomJude/Hands-on-Devops-Project.git
git checkout main  # Switch to the main branch
git pull origin main  # Pull the latest changes from the remote main branch
git checkout -b <new-branch-name> #your branchname should be in this format yourname_surname
```
1. Navigate to the project folder contribution/project1 `cd contribution/project1`
2. Create a folder with your **name_surname** eg Chisom_Jude, if such name already exists,add your middlename eg Mike_Ade_Ola
3. Move your project files to this folder, and download a sample project from [ColorLib](https://colorlib.com/wp/cat/personal/)
4. Modify to suit your taste
5. Push to GitHub using the following steps
6. ```git
   git add .
   git commit -m "Your commit message here"
   # Fetch changes from the remote (so you  write them or create a conflict)
   git fetch
   git merge origin/main
   git push -u origin <new-branch-name>
   ```
7. Navigate to github, confirm your forked branch was updated, and send in a pull request to the master of the main branch

For more explanation - watch [SCA Lagos Project with First Contribution](https://www.youtube.com/watch?v=7hpMeh68f10&t=73s)
