# Drupal GovCon
Welcome to the repo for the Drupal GovCon event website.

## Getting Started

This project is based on BLT, an open-source project template and tool that enables building, testing, and deploying Drupal installations following Acquia Professional Services best practices.

* Ensure that your computer meets the minimum installation requirements (and then install the required applications). See the [BLT System Requirements](https://blt.readthedocs.io/en/latest/INSTALL/) and [Drupal VM System Requirements](https://blt.readthedocs.io/en/latest/local-development/#using-drupal-vm-for-blt-generated-projects).
* Fork the parent repository in GitHub
* Request access to the Drupal4Gov organization in GitHub 
* Request access to the Acquia Cloud Environment for Drupal GovCon
* Setup a SSH key that can be used for GitHub and the Acquia Cloud (you CAN use the same key)
    * [Setup GitHub SSH Keys](https://help.github.com/articles/adding-a-new-ssh-key-to-your-github-account/)
    * [Setup Acquia Cloud SSH Keys](https://docs.acquia.com/acquia-cloud/ssh/generate)
* Clone your fork
```
$ git clone git@github.com:<your repository>/Drupal-GovCon-2017.git
```
* Add the parent repository as an upstream
```
$ git remote add upstream git@github.com:Drupal4Gov/Drupal-GovCon-2017.git
```
* Install Composer Dependencies (warning: this can take some time based on internet speeds)
```
$ composer install
```
* Install BLT alias (if this is your first BLT project)
```
$ composer run-script blt-alias
```
* Setup Virtual Machine (warning: this can take some time based on internet speeds)
```
$ blt vm
```
* Log into your VM
```
$ vagrant ssh
```
* Finalize BLT Setup / Install Drupal for the first time
```
$ blt setup
``` 
* If you wish to sync your local with the cloud
```
$ blt sync
``` 
* Access the site and do necessary work at http://local.capitalcamp.com

Additional [BLT documentation](https://docs.acquia.com/blt/) may be useful. You may also access a list of BLT commands by running:
```
$ blt
``` 

Note the following properties of this project:
* Primary development branch: master
* Local environment: DrupalVM
* Local drush alias: @capitalcamp.local
* Local site URL: http://local.capitalcamp.com

## Working With BLT

This is the common workflow for this project.

* Locate a ticket that you are planning on working
* Ensure that your git is tracking the most current upstream.
```
$ git fetch upstream
```
* Create a new branch off of upstream/master that is based on the ticket you are working (e.g. DGC-XXX)
```
$ git checkout -b DGC-XXX upstream/master
```
* Reset local environment to ensure all is inline with new branch. WARNING: this is destructive
```
$ blt sync
```
* Do whatever work is required for ticket
* Create new commit(s) as needed. All commit messages should follow the pattern: DGC-XXX: commit messages go here. They must include the Ticket Number (with a dash AND a colon), a message, and a period.
* Run Tests / Validation Scripts
```
$ blt validate
$ blt tests
```
* Ensure no other changes have been made to the upstream/master branch. If they have, rebase your branch.
```
$ git fetch upstream
$ git rebase upstream/master
```
* Push your commit(s) to your origin
```
$  git push --set-upstream origin DGC-XXX
```
* Create a new Pull Request that mentions the original ticket in the body (#DGC-XXX)
* Ensure the build passes

## Resources

* JIRA - https://drupal4gov.atlassian.net
* GitHub - https://github.com/Drupal4Gov/Drupal-GovCon-2017

## Troubleshooting

### Cybersquatting site for capitalcamp.com loads in browser instead local Drupal install
It's likely your /etc/hosts file wasn't updated properly. Ensure you have the [Vagrant hostsupdater plugin](https://github.com/cogitatio/vagrant-hostsupdater) `vagrant plugin list` and then try to reprovision your VM from the box dir with `vagrant reload --provision`

### PHP version is not correct
blt/composer may complain that you have the wrong PHP version. If this happens there are a lot of options for installing a different version of PHP. Easiest is probably with [homebrew](http://brew.sh/). After installing PHP 5.6 with homebrew you may need to reorder your path to include /usr/local/bin before /usr/bin. To do this run the following commands:

`echo 'export PATH="/usr/local/bin:$PATH"' >> ~/.bash_profile`

`source ~/.bash_profile`
