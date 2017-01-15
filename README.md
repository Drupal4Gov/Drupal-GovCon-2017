# Drupal GovCon
Welcome to the repo for the Drupal GovCon event website.

Tools we are using:
[Acquia BLT](http://blt.readthedocs.io/en/8.x/)

## Prereqs

- A Mac (these instructions are primarily for a Mac host running El Capitan or Sierra)
- [Virtualbox](https://www.virtualbox.org)
- [Vagrant](https://www.vagrantup.com/)
 - [Vagrant hostsupdater plugin](https://github.com/cogitatio/vagrant-hostsupdater)
- [Composer](https://getcomposer.org/)
- [Drush](http://www.drush.org/en/master/install/) > 8
- [Ansible](https://github.com/ansible/ansible) > 2.1

## Quickstart Instructions

- Before you start, do `ssh-add -l` to ensure your private key is registered. If not (especially after a system update), do `ssh-add -K ~/.ssh/id_rsa` to do this.
- Before you start, add your public ssh key to your Acquia account, otherwise you will be unable to sync.
- Install the prereqs above by following [BLT's Installing Requirements](https://github.com/acquia/blt/blob/8.x/INSTALL.md#installing-requirements) and then `vagrant plugin install vagrant-hostsupdater`
- **Fork this repo**
- Clone repo locally (clone **your fork**, do NOT clone the main repo)
- Configure a remote for the main repo (replace upstream with whatever naming makes sense to you) `git remote add upstream git@github.com:Drupal4Gov/Drupal-GovCon-2017.git`
- From the repo root, run `composer install`
- `composer blt-alias`
- `source ~/.bash_profile`
- `blt vm`
- Access local Drupal install at http://local.capitalcamp.com/

## Troubleshooting

### Cybersquatting site for capitalcamp.com loads in browser instead local Drupal install
It's likely your /etc/hosts file wasn't updated properly. Ensure you have the [Vagrant hostsupdater plugin](https://github.com/cogitatio/vagrant-hostsupdater) `vagrant plugin list` and then try to reprovision your VM from the box dir with `vagrant reload --provision`

### PHP version is not correct
blt/composer may complain that you have the wrong PHP version. If this happens there are a lot of options for installing a different version of PHP. Easiest is probably with [homebrew](http://brew.sh/). After installing PHP 5.6 with homebrew you may need to reorder your path to include /usr/local/bin before /usr/bin. To do this run the following commands:

`echo 'export PATH="/usr/local/bin:$PATH"' >> ~/.bash_profile`

`source ~/.bash_profile`

## Git Versioning Standards

- Before starting, update your remote by typing `git remote update` and to be safe, `git pull upstream master`
- Always checkout a new branch from `master` when you start on an issue.
- To Checkout a branch type in your command line `git checkout -b dgc-[issue-number]-[description] upstream/master`
- Commit frequently when working on larger issues. This helps to assist with potential troubleshooting. To help track which commits are to which issues, please prefix all your messages with 'DGC-[issue-number]'
- Your work is done for this ticket! Hooray! Before Submitting your work be sure to rebase you work against master.
- On your feature branch, type `git rebase upstream/master`
- If you rebase successfully, push your branch to upstream and submit a pull request :)

### Troubleshooting Git

- If you are unable to rebase, it may be due to merge conflicts. Type `git status` in the command line and see which file(s) are identified as 'both modified'
- Resolve the merge conflicts in the files that are both modified, being sure to not delete anyone's work.
- Once you have resolved the conflicts and saved your file(s), type `git add [file]` and type `git rebase --continue`
- Once you have gotten the message `Successfully rebased and updated refs/heads/[branch-name]`, it is safe to push.
- You can also abort your rebase at anytime by typing `git rebase --abort`
- If you have any trouble rebasing, you can rebase interactively which allows you to update your commits. Type `git rebase -i upstream/master`
- There you can reword, drop, squash commits, but please do this with caution as you can accidentally delete work.
- Read up on rebasing and rebasing interactively at: https://git-scm.com/docs/git-rebase and https://git-scm.com/docs/git-rebase#git-rebase---interactive
