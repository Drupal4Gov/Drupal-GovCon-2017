TEST # Drupal GovCon
Welcome to the repo for the Drupal GovCon event website. This is an open source project and we proudly make all of our source code available (not only to those that want to contribute to the project, but for those that are interested in seeing a working Drupal 10 site!).

## Getting Started

* Ensure that your computer meets the minimum installation requirements (and then install the required applications). See the [DDEV System Requirements](https://ddev.readthedocs.io/en/stable/users/install/ddev-installation/) or [Lando System Requirements](https://docs.lando.dev/basics/installation.html).
* Fork the parent repository in GitHub
* Request access to the Drupal4Gov organization in GitHub
* Request access to the Acquia Cloud Environment for Drupal GovCon
* Setup an SSH key that can be used for GitHub and the Acquia Cloud (you CAN use the same key)
    * [Setup GitHub SSH Keys](https://help.github.com/articles/adding-a-new-ssh-key-to-your-github-account/)
    * [Setup Acquia Cloud SSH Keys](https://docs.acquia.com/acquia-cloud/ssh/generate)

After creating a fork of the repository in GitHub and installing all dependencies above) there are only 4 commands to get started:

### This project supports DDEV and Lando.
Make sure you to poweroff the one you are not using `ddev poweroff` or `lando poweroff`. To avoid conflicts only one should run at any given time.

* `git clone` (clone your fork)

#### Choose between DDEV or Lando
* `ddev start` (install dependencies for the project)
* `ddev composer install` (install dependencies for the project)
* `ddev composer site-install` (install Drupal)

or

* `lando start` (provision the vm)
* `lando composer install`
* `lando composer site-install` (install Drupal)

## Working with (DDEV or Lando) and Composer Scripts

Our team utilizes a standard [Git flow](https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow) for our development workflow. You can read more about our recommended workflow in the [BLT docs](https://docs.acquia.com/blt/developer/dev-workflow/#workflow-example-local-development).

In general, "all" commands (drush, composer, etc.) should be run "inside" the docker container (Lando or DDEV). You can do this by first running the `lando or ddev` command.

For example:

Cleanly Install Drupal:
`ddev composer site-install`
`lando composer site-install`

Log Into Drupal

`ddev drush uli`
`lando drush uli`

## Resources

* JIRA - https://drupal4gov.atlassian.net
* GitHub - https://github.com/Drupal4Gov/Drupal-GovCon-2017
